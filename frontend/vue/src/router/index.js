import { createRouter, createWebHistory } from 'vue-router'
import TodoApp from '@/views/TodoApp.vue'
import LoginView from '../views/LoginView.vue'
import Tutorial from '@/views/Tutorial.vue'
import SignupView from '@/views/SignupView.vue'

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
      meta: { requiresAuth: true },
    },
    {
      path: '/login',
      name: 'Login',
      component: LoginView,
    },
    {
      path: '/signup',
      name: 'Signup',
      component: SignupView,
    },
  ],
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  if (to.meta.requiresAuth && !token) {
    next('/login')
  } else if (token && (to.path === '/login' || to.path === '/signup')) {
    next('/todo')
  } else {
    next()
  }
})

export default router
