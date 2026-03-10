import { reactive } from 'vue';

export function useDialog() {

  const dialog = reactive({
    visible: false,
    type: 'alert', // 'alert' | 'confirm'
    status: 'success', // success | error
    message: '',
    resolve: null,
  });

  const alert = (status, message) => {
    dialog.visible = true;
    dialog.type = 'alert';
    dialog.status = status;
    dialog.message = message;
  };

  const confirm = (message) => {
    dialog.visible = true;
    dialog.type = 'confirm';
    dialog.status = 'error';
    dialog.message = message;

    return new Promise((resolve) => {
      dialog.resolve = resolve;
    });
  };

  const close = () => {
    dialog.visible = false;
  };

  const confirmOk = () => {
    dialog.visible = false;
    dialog.resolve?.(true);
  };

  const confirmCancel = () => {
    dialog.visible = false;
    dialog.resolve?.(false);
  };

  return {
    dialog,
    alert,
    confirm,
    close,
    confirmOk,
    confirmCancel,
  };
}