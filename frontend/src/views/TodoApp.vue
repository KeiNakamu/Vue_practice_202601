<script setup>
  import { onMounted, ref } from 'vue';
  import TodoInput from '../components/TodoApp/TodoInput.vue';
  import TodoListView from '../components/TodoApp/TodoListView.vue';
  import ShowModal from '../components/Modal/ShowModal.vue';
  // import { useModal } from '@/composables/useModal';
  // import { useConfirm } from '@/composables/useConfirm';
  import { useDialog } from '@/composables/useDialog';

  import { getTodos, createTodo, updateTodo, deleteTodo } from '@/services/todoService.js';

  // const { modal, showModal, hideModal } = useModal();

  const items = ref([]);

  // const {
  //   visible: confirmVisible,
  //   message: confirmMessage,
  //   confirm,
  //   onConfirm,
  //   onCancel
  // } = useConfirm();

  const {
    dialog,
    alert,
    confirm,
    close,
    confirmOk,
    confirmCancel
  } = useDialog();

  // データ取得
  const loadItems = async () => {
    try {
      const res = await getTodos();
      items.value = res.todos;
      console.log('res.data: ', res.todos);
    } catch (err) {
      console.log('loadItems err: ', err.response.data);
      alert('error', err.response?.data?.message ?? 'エラーが発生しました');
    }
  };

  // 新規作成
  const handleCreate = async (todo) => {
    try{
      const res = await createTodo(todo);
      await loadItems();
      console.log('handleCreate res: ', res);
      alert('success', res.data.message);
    }catch (err){
      console.log('handleCreate err: ', err);
      alert('error', err.response?.data?.message ?? 'エラーが発生しました');
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
      alert('success', '更新しました');
    } catch (err) {
      console.log('handleUpdate err: ', err);
      alert('error', err.response?.data?.message ?? 'エラーが発生しました');
    }
  }

  // 削除
  const handleDelete = async (data) => {
    const ok = await confirm(`${data.content}を削除してもよろしいですか？`);

    if(!ok) return;

    try {
      await deleteTodo(data.id);
      await loadItems();
      alert('success', '削除しました');

    } catch (err) {
      console.log('handleDelete err: ', err);
      alert('error', err.response?.data?.message ?? 'エラーが発生しました');
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

  // 入力チェック
  const formCheck = (data) => {
    alert(data.form_check, data.message);
  }
</script>

<template>
  <div class="todoApp">
    <TodoInput
      @created="handleCreate"
      @form-check="formCheck"
    >
    </TodoInput>
    <TodoListView
      :items="items"
      @toggle-edit="loadItems"
      @update="handleUpdate"
      @delete="handleDelete"
      @sort-by-limit_date="sortByLimit"
      :isLimitAsc="isLimitAsc"
      @sort-by-id="sortById"
      :isIdAsc="isIdAsc"
      @form-check="formCheck"
    >
    </TodoListView>
    <!-- <ShowModal 
      v-if="modal.visible"
      :statusFlg="modal.statusFlg"
      :message="modal.message"
      :isConfirm="modal.isConfirm"
      @close="hideModal"
    />
    <ShowModal 
      v-if="confirmVisible"
      statusFlg="error"
      :message="confirmMessage"
      :isConfirm="true"
      @close="onCancel"
      @delete="onConfirm"
    /> -->
    <ShowModal
      v-if="dialog.visible"
      :statusFlg="dialog.status"
      :message="dialog.message"
      :isConfirm="dialog.type === 'confirm'"
      @close="close"
      @delete="confirmOk"
      @cancel="confirmCancel"
    />
  </div>
</template>