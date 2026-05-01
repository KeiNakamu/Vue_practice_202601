<template>
  <div>
    <h1>Sign Up</h1>

    <form @submit.prevent="signup">
      <input v-model="name" type="text" placeholder="Name" />
      <input v-model="email" type="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Password" />
      <input v-model="password_confirmation" type="password" placeholder="Confirm Password" />
      <button type="submit">Register</button>
    </form>

    <p v-if="error">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/store/auth'
import { API_BASE_URL } from '@/config/api'

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const error = ref('')
const router = useRouter()
const authStore = useAuthStore()

const signup = async () => {
  try {
    const res = await fetch(`${API_BASE_URL}/register`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify({
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value,
      }),
    })

    const data = await res.json()

    if (!res.ok) {
      const fromErrors = data.errors
        ? Object.values(data.errors).flat()[0]
        : null
      error.value = fromErrors || data.message || '登録失敗'
      return
    }

    // 登録後そのままログイン状態にする
    authStore.login({
      token: data.data.token,
      user: data.data.user
    })

    router.push('/todo')
  } catch (e) {
    error.value = 'Server error'
  }
}
</script>