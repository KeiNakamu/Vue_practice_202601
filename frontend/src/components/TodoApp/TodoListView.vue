<script setup>

  const props = defineProps({
    items: {
      type: Array,
      required: true
    }
  });
</script>

<template>
  <div>
    <table>
      <tr>
        <th class="th-id">ID</th>
        <th class="th-value">やること</th>
        <th class="th-limit">期限</th>
        <th class="th-state">状態</th>
        <th class="th-edit">編集</th>
        <th class="th-delete">削除</th>
      </tr>
      <tr v-for="item in props.items" :key="item.id">
        <td>{{ item.id }}</td>
        <td>{{ item.content }}</td>
        <td>{{ item.limit }}</td>
        <td>{{ item.state.value }}</td>
        <td><input type="button" value="編集"/></td>
        <td><input type="button" value="削除"/></td>
      </tr>
    </table>
  </div>
</template>