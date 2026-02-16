import { ref } from "vue";

export function useModal() {
  const modal = ref({
    visible: false,         // モーダルの表示(true)・非表示(false)
    statusFlg: 'success',   // success or error
    message: '',            // メッセージ
    isConfirm: false,            // メッセージ
  });

  const showModal = (statusFlg, message, isConfirm = false) => {
    modal.value = {
      visible: true,
      statusFlg,
      message,
      isConfirm,
    };
  };

  const hideModal = () => {
    modal.value.visible = false;
  };

  return {
    modal,
    showModal,
    hideModal,
  };
}
