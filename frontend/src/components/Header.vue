<script setup>
</script>

<template>
  <header class="header">
    <nav>
      <router-link to="/" active-class="active">Tutorial</router-link>
      |
      <router-link to="/todo" active-class="active">Todo</router-link>
      |
      <router-link to="/login" active-class="active">Login</router-link>
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
}

.active {
  font-size: bold;
  color: red;
}
</style>