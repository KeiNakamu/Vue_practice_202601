<script setup>

  const props = defineProps({
    statusFlg: {
      type: String,
      default: 'success'
    },
    message: {
      type: String,
      required: true,
    },
    isConfirm: {
      type: Boolean,
      default: false,
    },
  });

  defineEmits(['close', 'delete','cancel']);
</script>

<template>
  <div class="modal">
    <div class="modal-content" :class="props.statusFlg">
      <p class="mgn-btm20">{{ message }}</p>

      <template v-if="isConfirm">
        <input type="button" value="はい" class="mgn-lft50" @click="$emit('delete')"/>
        <input type="button" value="キャンセル" class="mgn-lft40" @click="$emit('cancel')" />
      </template>
      <template v-else>
        <input type="button" value="閉じる" class="mgn-lft95" @click="$emit('close')" />
      </template>
    </div>
  </div>
</template>

<style>
/* モーダル関連 */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
}

.mgn-lft40 {
  margin-left: 40px;
}
.mgn-lft50 {
  margin-left: 50px;
}
.mgn-lft95 {
  margin-left: 95px;
}
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