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

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()

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

    localStorage.setItem('token', data.data.token)

    router.push('/todo')
  } catch (e) {
    error.value = 'Server error'
  }
}
</script>