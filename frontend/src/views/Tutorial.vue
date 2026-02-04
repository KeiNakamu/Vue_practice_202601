<script setup>
import { ref, onMounted } from 'vue'
import TestComponent from '../components/TestComponent.vue'

const message = ref('')

onMounted(async () => {
  const res = await fetch('http://localhost/api/hello')
  const data = await res.json()
  message.value = data.message
})

const data = [
  { name: '親コンポーネントから渡されたデータ', id: 0 }
];

const receivedMessage = ref('');
const handleMessage = (mes) => {
  receivedMessage.value = mes;
}

</script>

<template>
    <h1>{{ message }}</h1>
    <TestComponent :text="data[0].name" @message="handleMessage"/>
    <p>{{ receivedMessage }}</p>
</template>
