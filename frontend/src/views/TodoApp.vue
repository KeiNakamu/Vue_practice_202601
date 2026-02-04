<script setup>
  import { onMounted, ref } from 'vue';
  import TodoInput from '../components/TodoApp/TodoInput.vue';
  import TodoListView from '../components/TodoApp/TodoListView.vue';

  const items = ref([]);

  // 再描画
  const loadItems = () => {
    items.value = JSON.parse(localStorage.getItem("items")) || [];
  }

  onMounted(loadItems);

  const toggleEdit = (id) => {
    items.value = items.value.map(item => item.id === id ? { ...item, onEdit: !item.onEdit } : item);
  };

  const onUpdate = (payload) => {
    const index = items.value.findIndex(i => i.id === payload.id);

    items.value[index] = {
      ...items.value[index],
      content: payload.content,
      limit: payload.limit,
      state: payload.state,
      onEdit: false,
    };

    localStorage.setItem("items", JSON.stringify(items.value));
  }

</script>

<template>
  <div class="todoApp">
    <TodoInput @created="loadItems"></TodoInput>
    <TodoListView :items="items" @toggle-edit="toggleEdit" @update="onUpdate"></TodoListView>
  </div>
</template>