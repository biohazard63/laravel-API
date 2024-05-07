<script setup lang="ts">
import { onMounted } from 'vue';

onMounted(() => {
  const accessToken = localStorage.getItem('accessToken');
  console.log('Access Token:', accessToken);
});
</script>

<template>
  <main>
    <TheWelcome />
  </main>
</template>