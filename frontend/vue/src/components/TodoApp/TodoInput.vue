<script setup>
  import { ref } from "vue";
  import { statuses } from "@/const/status"
  import { message } from "@/const/message"

  const input = ref('');
  const inputDate = ref('');

  const isErrMsg = ref(false);

  const emit = defineEmits(['created', 'form-check']);

  const onSubmitForm = () => {

    if(input.value == "" || inputDate.value == "") {
      emit("form-check", {
        form_check: 'error',
        message: message.FRT_INF_01_001,
      });
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
    <form @submit.prevent="onSubmitForm">
      <label>やること<input type="text" v-model="input" style="margin: 20px;"/></label>
      <label>期限<input type="date" v-model="inputDate" style="margin: 20px;" /></label>
      <input type="submit" value="登録" style="margin: 20px;" />
    </form>
  </div>
</template>