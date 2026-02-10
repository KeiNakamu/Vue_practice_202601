import { ref } from "vue";

export function useModal() {
  const modal = ref({
    visible: false,         // モーダルの表示(true)・非表示(false)
    statusFlg: 'success',   // success or error
    message: '',            // メッセージ
  });

  const showModal = (statusFlg, message) => {
    modal.value = {
      visible: true,
      statusFlg,
      message,
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
