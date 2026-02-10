<script setup>

  const props = defineProps({
    statusFlg: {
      type: String,
      default: 'success'
    },
    message: {
      type: String,
      required: true,
    }
  });

  defineEmits(['close']);
</script>

<template>
  <div class="modal">
    <div class="modal-content" :class="props.statusFlg">
      <p class="mgn-btm20">{{ props.message }}</p>
      <input type="button" value="閉じる" @click="$emit('close')">
    </div>
  </div>
</template>

<style>
.mgn-btm20 {
  margin-bottom: 20px;
}
.modal-content {
  color: black;
}
.modal-content.success {
  border: 2px solid #4caf50;
}

.modal-content.error {
  border: 2px solid #f44336;
}
</style>