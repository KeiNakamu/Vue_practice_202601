<script setup>
  import { ref } from "vue"
  import { statuses } from "@/const/status"

  const props = defineProps({
    items: {
      type: Array,
      required: true
    }
  });

  const emit = defineEmits(['toggle-edit', 'update']);

  let editContent = ref();
  let editLimit = ref();
  let editState = ref();

  let isErrMsg = ref(false);

  const onEdit = (item) => {
    emit('toggle-edit', item.id);

    editContent.value = item.content;
    editLimit.value = item.limit;
    editState.value = item.state;
  }

  const onUpdate = (id) => {

    if(editContent.value == '' || editLimit.value == '') {
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
</script>

<template>
  <div>
    <p v-if="isErrMsg">タスク・期限を両方入力してください。</p>
    <table>
      <tr>
        <th class="th-id">ID</th>
        <th class="th-value">やること</th>
        <th class="th-limit">期限</th>
        <th class="th-state">状態</th>
        <th class="th-edit">編集</th>
        <th class="th-delete">削除</th>
      </tr>
      <tr v-for="item in props.items" :key="item.id">
        <td>{{ item.id }}</td>
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
        <td><input type="button" value="削除"/></td>
      </tr>
    </table>
  </div>
</template>