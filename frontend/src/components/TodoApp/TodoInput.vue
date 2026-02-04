<script setup>
  import { ref } from "vue";
  import { statuses } from "@/const/status"

  const input = ref('');
  const inputDate = ref('');

  const onSubmitForm = () => {
    console.log(input.value);
    console.log(inputDate.value);

    const items = JSON.parse(localStorage.getItem("items")) || [];

    const newItem = {
      id: items.length,
      content: input.value,
      limit: inputDate.value,
      state: statuses.NOT_START,
      onEdit: false,
    };

    items.push(newItem);

    localStorage.setItem("items", JSON.stringify(items));

  }
</script>

<template>
  <div>
    <form @submit.prevent="onSubmitForm">
      <label>やること<input type="text" v-model="input" /></label>
      <br/>
      <label>期限<input type="date" v-model="inputDate" /></label>
      <br/>
      <input type="submit" value="登録" />
    </form>
  </div>
</template>