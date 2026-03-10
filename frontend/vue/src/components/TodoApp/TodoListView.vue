<script setup>
  import { ref } from "vue"
  import { statuses } from "@/const/status"
  import { message } from "@/const/message"

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

  const emit = defineEmits(['toggle-edit', 'update', 'delete', 'sort-by-limit_date', 'sort-by-id', 'form-check']);

  let editContent = ref();
  let editLimit = ref();
  let editState = ref();
  let editingId = ref(null);

  const today = new Date();

  // タスクを編集要求
  const onEdit = (item) => {

    if(editingId.value && editingId.value !== item.id){
      emit("form-check", {
        form_check: 'error',
        message: message.FRT_INF_01_002,
      });
      return;
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

  // タスクを更新要求
  const onUpdate = (id) => {

    if(editContent.value == '' || editLimit.value == '') {
      emit("form-check", {
        form_check: 'error',
        message: message.FRT_INF_01_001,
      });
      return;
    }
    emit('update', {
      id,
      content: editContent.value,
      limit_date: editLimit.value,
      state: editState.value,
    });

    editingId.value = null;
  }

  // タスクを削除要求
  const onDeleteItem = (item) => {
    emit('delete', {
      id: item.id,
      content: item.content
    });
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
          <td><input @click="onDeleteItem(item)" type="button" value="削除"/></td>
        </tr>
      </table>
    </div>

  </div>
</template>

<style>
.red {
  color: red;
}
</style>