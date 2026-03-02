<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/store/auth' // Pinia

const router = useRouter();
const authStore = useAuthStore();

const logout = () => {
  authStore.logout()
  router.push('/login');
}
</script>

<template>
  <header class="header">
    <nav>
      <router-link to="/" active-class="active">Tutorial</router-link>
      |
      <router-link to="/todo" active-class="active">Todo</router-link>
      |
      <router-link v-if="!authStore.isLoggedIn" to="/login" active-class="active">Login</router-link>

      <a v-else type="button" @click="logout" >Logout</a>
    </nav>
  </header>
</template>

<style scoped>
.header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 60px;

  background-color: #333;
  color: white;

  display: flex;
  align-items: center;
  padding: 0 16px;
  z-index: 1000;
}

nav {
  display: flex;
  gap: 16px;
  align-items: center;
}

.active {
  font-weight: bold;
  color: red;
}

.logout-btn {
  background: none;
  border: none;
  color: white;
  cursor: pointer;
}
</style>