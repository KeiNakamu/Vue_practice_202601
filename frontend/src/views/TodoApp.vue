<script setup>
  import { onMounted, ref } from 'vue';
  import TodoInput from '../components/TodoApp/TodoInput.vue';
  import TodoListView from '../components/TodoApp/TodoListView.vue';

  import { getTodos, createTodo, updateTodo, deleteTodo } from '@/services/todoService.js';

  const items = ref([]);

  // データ取得
  const loadItems = async () => {
    const res = await getTodos();
    items.value = res.todos;
    console.log('res.data: ', res.todos);
  };

  // 新規作成
  const handleCreate = async (todo) => {
    await createTodo(todo);
    await loadItems();
  }

  // 更新
  const handleUpdate = async (data) => {
    console.log(data);

    await updateTodo(data.id, {
      content: data.content,
      limit_date: data.limit_date,
      state: data.state,
    });
    await loadItems();
  }

  // 削除
  const handleDelete = async (id) => {
    try {
      await deleteTodo(id);
      await loadItems();
      alert('削除しました');

    } catch (err) {
      console.log(err);
      alert('削除に失敗しました');
    }
  }

  onMounted(loadItems);

  // ソート機能
  const isLimitAsc = ref(true);
  const isIdAsc = ref(true);

  const sortByLimit = () => {
    console.log('期限を基準にソート');
    items.value.sort((a, b) => {
      const diff = new Date(a.limit_date) - new Date(b.limit_date);
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
    <TodoInput @created="handleCreate"></TodoInput>
    <TodoListView
      :items="items"
      @toggle-edit="loadItems"
      @update="handleUpdate"
      @delete="handleDelete"
      @sort-by-limit_date="sortByLimit"
      :isLimitAsc="isLimitAsc"
      @sort-by-id="sortById"
      :isIdAsc="isIdAsc"
      >
    </TodoListView>
  </div>
</template>