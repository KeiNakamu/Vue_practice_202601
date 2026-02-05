<script setup>
  import { ref } from "vue"
  import { statuses } from "@/const/status"

  const props = defineProps({
    // タスクリストを取得
    items: {
      type: Array,
      required: true
    },
    // ソート昇順・降順フラグ
    isLimitAsc: {
      type: Boolean,
      required: true
    },
    isIdAsc: {
      type: Boolean,
      required: true
    },
  });

  const emit = defineEmits(['toggle-edit', 'update', 'delete', 'sort-by-limit', 'sort-by-id']);

  let editContent = ref();
  let editLimit = ref();
  let editState = ref();

  let isErrMsg = ref(false);
  let isOnEditOther = ref(false);
  let errMsg = ref('');

  let deleteItemId = ref('');
  let deleteItemContent = ref('');
  let isShowModal = ref(false);

  const today = new Date();

  // タスクを編集要求
  const onEdit = (item) => {

    isOnEditOther.value = props.items.some(
      (i) => i.onEdit && i.id !== item.id
    );

    if(isOnEditOther.value) {
      errMsg.value = "他に編集中のタスクがあります";
      isErrMsg.value = true;
      return;
    }else{
      isErrMsg.value = false;
    }
    emit('toggle-edit', item.id);

    editContent.value = item.content;
    editLimit.value = item.limit;
    editState.value = item.state;
  }

  // タスクを更新要求
  const onUpdate = (id) => {

    if(editContent.value == '' || editLimit.value == '') {
      errMsg.value = "タスク・期限を両方入力してください";
      isErrMsg.value = true;
      return;
    }else{
      isErrMsg.value = false;
    }
    emit('update', {
      id,
      content: editContent,
      limit: editLimit,
      state: editState,
    });
  }

  // 削除ボタン押下後、モーダル表示
  const showDeleteModal = (id) => {
    isShowModal.value = true;

    deleteItemId.value = id;
    const target = props.items.find(item => item.id === id);
    deleteItemContent.value = target?.content ?? '';
  }

  // idのタスクを削除要求
  const onDeleteItem = () => {
    emit('delete', deleteItemId.value);
    isShowModal.value = false;
  }

  // モーダルを閉じる
  const onHideModal = () => {
    isShowModal.value = false;
  }

  // 期限を基準にソート
  const sortByLimit = () => {
    emit('sort-by-limit');
  }

  // IDを基準にソート
  const sortById = () => {
    emit('sort-by-id');
  }
</script>

<template>
  <div>
    <div>
      <p v-if="isErrMsg">{{ errMsg }}</p>
      <table>
        <tr>
          <th class="th-index"><input type="button" @click="sortById()" :value=" props.isIdAsc ? '▲' : '▼'"/></th>
          <th class="th-value">やること</th>
          <th class="th-limit">期限<input type="button" @click="sortByLimit()" :value=" props.isLimitAsc ? '▲' : '▼' "/></th>
          <th class="th-state">状態</th>
          <th class="th-edit">編集</th>
          <th class="th-delete">削除</th>
        </tr>
        <tr v-for="(item, index) in props.items" :key="item.id" :class="{ red: new Date(item.limit) < today }">
          <td>{{ index + 1 }}</td>
          <td>
            <span v-if="!item.onEdit">{{ item.content }}</span>
            <input v-else v-model="editContent" type="text"/>
          </td>
          <td>
            <span v-if="!item.onEdit">{{ item.limit }}</span>
            <input v-else v-model="editLimit" type="date">
          </td>
          <td>
            <span v-if="!item.onEdit">{{ item.state.value }}</span>
            <select v-else v-model="item.state.value">
              <option
                v-for="state in statuses"
                :key="state.id"
                :value="state.value" 
              >
                {{ state.value }}
              </option>
            </select>
          </td>
          <td>
            <input @click="onEdit(item)" type="button" :value="item.onEdit ? 'キャンセル' : '編集' "/>
            <input v-if="item.onEdit" @click="onUpdate(item.id)" type="button" value="更新"/>
          </td>
          <td><input @click="showDeleteModal(item.id)" type="button" value="削除"/></td>
        </tr>
      </table>
    </div>

    <div v-if="isShowModal" class="modal">
      <div class="modal-content">
        <p style="color: black; margin-bottom: 20px;">{{ deleteItemContent }}を削除してもよろしいですか？</p>
        <input type="button" @click="onDeleteItem()" value="はい"/>
        <input type="button" @click="onHideModal()" value="キャンセル"/>
      </div>
    </div>
  </div>
</template>

<style>
/* モーダル関連 */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
}

.red {
  color: red;
}
</style>