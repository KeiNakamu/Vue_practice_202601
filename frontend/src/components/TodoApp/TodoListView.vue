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

  const emit = defineEmits(['toggle-edit', 'update', 'delete', 'sort-by-limit_date', 'sort-by-id']);

  let editContent = ref();
  let editLimit = ref();
  let editState = ref();
  let editingId = ref(null);

  let isErrMsg = ref(false);
  let errMsg = ref('');

  let deleteItemId = ref('');
  let deleteItemContent = ref('');
  let isShowModal = ref(false);

  const today = new Date();

  // タスクを編集要求
  const onEdit = (item) => {
    console.log(item.state, typeof item.state);

    if(editingId.value && editingId.value !== item.id){
      errMsg.value = "他に編集中のタスクがあります";
      isErrMsg.value = true;
      return;
    } else {
      isErrMsg.value = false;
    }

    if(editingId.value === item.id) {
      editingId.value = null; // キャンセル
    }else{
      editingId.value = item.id;
      editContent.value = item.content;
      editLimit.value = item.limit_date;
      editState.value = item.state;
    }
  }

  console.log(statuses);

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
      content: editContent.value,
      limit_date: editLimit.value,
      state: editState.value,
    });

    editingId.value = null;
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
    emit('sort-by-limit_date');
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
          <th class="th-limit_date">期限<input type="button" @click="sortByLimit()" :value=" props.isLimitAsc ? '▲' : '▼' "/></th>
          <th class="th-state">状態</th>
          <th class="th-edit">編集</th>
          <th class="th-delete">削除</th>
        </tr>
        <tr v-for="(item, index) in props.items" :key="item.id" :class="{ red: new Date(item.limit_date) < today }">
          <td>{{ index + 1 }}</td>
          <td>
            <span v-if="editingId !== item.id">{{ item.content }}</span>
            <input v-else v-model="editContent" type="text"/>
          </td>
          <td>
            <span v-if="editingId !== item.id">{{ item.limit_date }}</span>
            <input v-else v-model="editLimit" type="date">
          </td>
          <td>
            <span v-if="editingId !== item.id">{{ item.state }}</span>
            <select v-else v-model="editState">
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
            <input @click="onEdit(item)" type="button" :value="editingId === item.id ? 'キャンセル' : '編集' "/>
            <input v-if="editingId === item.id" @click="onUpdate(item.id)" type="button" value="更新"/>
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