<script setup>
import { onBeforeMount, onBeforeUpdate, onMounted, onUpdated, ref } from 'vue'
  defineProps({
    text: String,
  });

  const dataText = "これはデータです！";

  const name = ref("");

  const data = [
    { id: 0, name: "りんご"},
    { id: 1, name: "いちご"},
    { id: 2, name: "バナナ"}
  ];

  console.log('beforeCreate フック: コンポーネントが初期化される直前');
  console.log('Created フック: コンポーネントが初期化された直後');

  onBeforeMount(() => {
    console.log('onBeforeMount フック: DOMにマウントされる直前');
  });

  onMounted(() => {
    console.log('onMounted フック: DOMにマウントされた直後');
  });

  onBeforeUpdate(() => {
    console.log('onBeforeUpdate フック: コンポーネントが再描画される直前');
  });

  onUpdated(() => {
    console.log('onUpdated フック: コンポーネントが再描画された直後');
  });

  const fruitsList = ref(data);

  function deleteItem(id) {
    fruitsList.value = fruitsList.value.filter(
      fruit => fruit.id !== id
    );
  }

  const number = 5;

  const count = ref(0);
  const incrementCountUp = () => {
    count.value++;
  }

  const incrementCountDown = () => {
    count.value--;
  }

  const incrementCountReset = () => {
    count.value = 0;
  }

  // emit
  // 子コンポーネントから親コンポーネントへデータを渡す
  // export default {
  //   methods: {
  //     sendMessage() {
  //       this.$emit("message", "子コンポーネントから送られたデータ");
  //     },
  //   },
  // };

  const emit = defineEmits(['message']);

  function sendMessage() {
    var data = '子コンポーネントから送られたデータです'
    emit('message', data);
  }
  // emit

  // loacalStorage
  // ブラウザにデータをJSONデータとして保存
  localStorage.setItem("message", "ローカルストレージに保存");
  // loacalStorage
</script>

<template>
  <div>
    <p>{{ text }}</p>
    <p>{{ dataText }}</p>
    <p v-text="dataText"></p>

    <label for="name">名前：</label>
    <input type="text" id="name" v-model="name" >
    <p>入力された名前：{{ name }}</p>

    <ul>
      <template v-for="fruit in fruitsList">
        <li v-if="fruit.name !== 'バナナ'" :key="fruit.id">
          {{ fruit.name }}
          <input type="button" value="削除" @click="deleteItem(fruit.id)" />
        </li>
      </template>
    </ul>

    <p v-if="number < 10">数字は10より小さいです。</p>
    <p v-else>数字は10より大きいです</p>

    <p v-show="number < 10">数字は10より小さいです。</p>

    <p>カウント：　{{ count }}</p>
    <button @click="incrementCountUp">カウントアップ</button>
    <button @click="incrementCountDown">カウントダウン</button>
    <br/>
    <button @click="incrementCountReset">リセット</button>

    <!-- emit -->
    <!-- 子コンポーネントから親コンポーネントへデータを渡す -->
    <button @click="sendMessage">メッセージを送る</button>
    <!-- emit -->
  </div>
</template>