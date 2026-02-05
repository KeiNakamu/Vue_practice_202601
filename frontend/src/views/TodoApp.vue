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

  const onDeleteItem = (id) => {
    items.value.splice(id, 1);
  }

  // ソート機能
  const isLimitAsc = ref(true);
  const isIdAsc = ref(true);

  const sortByLimit = () => {
    console.log('期限を基準にソート');
    items.value.sort((a, b) => {
      const diff = new Date(a.limit) - new Date(b.limit);
      return isLimitAsc.value ? diff : -diff;
    });

    isLimitAsc.value = !isLimitAsc.value;

    localStorage.setItem("items", JSON.stringify(items.value));
  }

  const sortById = () => {
    console.log('IDを基準にソート');
    items.value.sort((a, b) => {
      const diff = a.id - b.id;
      return isIdAsc.value ? diff : -diff;
    });

    isIdAsc.value = !isIdAsc.value;
    localStorage.setItem("items", JSON.stringify(items.value));
  }
</script>

<template>
  <div class="todoApp">
    <TodoInput @created="loadItems"></TodoInput>
    <TodoListView
      :items="items"
      @toggle-edit="toggleEdit"
      @update="onUpdate"
      @delete="onDeleteItem"
      @sort-by-limit="sortByLimit"
      :isLimitAsc="isLimitAsc"
      @sort-by-id="sortById"
      :isIdAsc="isIdAsc"
      >
    </TodoListView>
  </div>
</template>