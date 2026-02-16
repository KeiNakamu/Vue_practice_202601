import { ref } from 'vue';

export function useConfirm() {

  const visible = ref(false);
  const message = ref('');
  let resolveFn = null;

  const confirm = (msg) => {
    message.value = msg;
    visible.value = true;

    return new Promise((resolve) => {
      resolveFn = resolve;
    });
  };

  const onConfirm = () => {
    visible.value = false;
    resolveFn(true);
  };

  const onCancel = () => {
    visible.value = false;
    resolveFn(false);
  };

  return {
    visible,
    message,
    confirm,
    onConfirm,
    onCancel,
  };
}