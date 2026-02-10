<script setup>
  import { onMounted, ref } from 'vue';
  import TodoInput from '../components/TodoApp/TodoInput.vue';
  import TodoListView from '../components/TodoApp/TodoListView.vue';
  import ShowModal from '../components/Modal/ShowModal.vue';
  import { useModal } from '@/composables/useModal';

  import { getTodos, createTodo, updateTodo, deleteTodo } from '@/services/todoService.js';

  const { modal, showModal, hideModal } = useModal();

  const items = ref([]);

  // データ取得
  const loadItems = async () => {
    try {
      const res = await getTodos();
      items.value = res.todos;
      console.log('res.data: ', res.todos);
    } catch (err) {
      console.log('loadItems err: ', err);
      showModal('error', 'データの取得に失敗しました');
    }
  };

  // 新規作成
  const handleCreate = async (todo) => {
    try{
      await createTodo(todo);
      await loadItems();
      showModal('success', '登録しました');
    }catch (err){
      console.log('handleCreate err: ', err);
      showModal('error', '登録に失敗しました');
    }
  }

  // 更新
  const handleUpdate = async (data) => {
    // console.log(data);

    try {
      await updateTodo(data.id, {
        content: data.content,
        limit_date: data.limit_date,
        state: data.state,
      });
      await loadItems();
      showModal('success', '更新しました');
    } catch (err) {
      console.log('handleUpdate err: ', err);
      showModal('error', '更新に失敗しました');
    }
  }

  // 削除
  const handleDelete = async (id) => {
    try {
      await deleteTodo(id);
      await loadItems();
      showModal('success', '削除しました');

    } catch (err) {
      console.log('handleDelete err: ', err);
      showModal('error', '削除に失敗しました');
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
    <ShowModal 
      v-if="modal.visible"
      :statusFlg="modal.statusFlg"
      :message="modal.message"
      @close="hideModal"
    />
  </div>
</template>