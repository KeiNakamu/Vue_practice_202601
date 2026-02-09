<script setup>
  import { ref } from "vue";
  import { statuses } from "@/const/status"

  const input = ref('');
  const inputDate = ref('');

  const isErrMsg = ref(false);

  const emit = defineEmits(['created']);

  const onSubmitForm = () => {
    // console.log(input.value);
    // console.log(inputDate.value);

    if(input.value == "" || inputDate.value == "") {
      isErrMsg.value = true;
      return;
    }

    emit("created", {
      content: input.value,
      limit_date: inputDate.value,
      state: statuses.NOT_START.value,
    });
    input.value = '';
    inputDate.value = '';
    isErrMsg.value = false;
  }
</script>

<template>
  <div>
    <p v-if="isErrMsg" style="color:red">タスク・期限を両方入力してください</p>
    <form @submit.prevent="onSubmitForm">
      <label>やること<input type="text" v-model="input" style="margin: 20px;"/></label>
      <label>期限<input type="date" v-model="inputDate" style="margin: 20px;" /></label>
      <input type="submit" value="登録" style="margin: 20px;" />
    </form>
  </div>
</template>