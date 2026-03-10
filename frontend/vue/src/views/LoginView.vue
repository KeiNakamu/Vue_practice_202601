<template>
  <div>
    <h1>Login</h1>

    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Password" />
      <button type="submit">Login</button>
    </form>

    <p v-if="error">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/store/auth'

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()
const authStore = useAuthStore()

const login = async () => {
  try {
    const res = await fetch('http://localhost/api/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        email: email.value,
        password: password.value
      })
    })

    const data = await res.json()

    console.log("login response:", data)

    if (!res.ok) {
      error.value = data.message || 'Login failed'
      return
    }

    // localStorage.setItem('token', data.data.token)
    authStore.login({
      token: data.data.token,
      user: data.data.user
    })

    console.log(authStore.token)
    console.log(authStore.isLoggedIn)

    router.push('/todo')
  } catch (e) {
    console.error('LOGIN ERROR: ', e)
    error.value = 'Server error'
  }
}
</script>