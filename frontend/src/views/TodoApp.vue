<script setup>
import { onMounted, ref } from 'vue';
import TodoInput from '../components/TodoApp/TodoInput.vue';
import TodoListView from '../components/TodoApp/TodoListView.vue';

const items = ref([]);

const loadItems = () => {
  items.value = JSON.parse(localStorage.getItem("items")) || [];
}

onMounted(loadItems);

</script>

<template>
  <div class="todoApp">
    <TodoInput @created="loadItems"></TodoInput>
    <TodoListView :items="items"></TodoListView>
  </div>
</template>