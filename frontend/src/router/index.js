import { createRouter, createWebHistory } from 'vue-router'
import TodoApp from '@/views/TodoApp.vue'
import Tutorial from '@/views/Tutorial.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Tutorial',
      component: Tutorial,
    },
    {
      path: '/todo',
      name: 'Todo',
      component: TodoApp,
    },
  ],
})

export default router
