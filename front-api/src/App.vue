<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import { RouterLink, RouterView } from 'vue-router'

const isLoggedIn = ref(false);

onMounted(() => {
  isLoggedIn.value = !!localStorage.getItem('accessToken');
});

watch(isLoggedIn, () => {
  // Force le re-rendering du composant lorsque isLoggedIn change
  isLoggedIn.value = !!localStorage.getItem('accessToken');
});

const logout = () => {
  localStorage.removeItem('accessToken');
  isLoggedIn.value = false;

  location.href = '/login';
}
</script>

<template>
  <header class="flex items-center justify-between p-5 bg-blue-500">
    <img alt="Vue logo" class="w-12 h-12" src="@/assets/logo.svg" />

    <nav class="flex space-x-4">
      <RouterLink class="text-white" to="/">Accueil</RouterLink>
      <RouterLink class="text-white" to="/register">Register</RouterLink>
      <RouterLink class="text-white" to="/dashboard">Dashboard</RouterLink>
      <RouterLink class="text-white" to="/user-management">User Management</RouterLink>
      <RouterLink class="text-white" to="/product-management">Product Management</RouterLink>
      <RouterLink class="text-white" to="/category-management">Category Management</RouterLink>
      <RouterLink class="text-white" to="/profil">Profil</RouterLink>
      <RouterLink class="text-white" to="/login">Login</RouterLink>
      <button class="px-4 py-2 text-white bg-red-500 rounded" @click="logout">Logout</button>
    </nav>
  </header>

  <RouterView />
</template>

<!--<style scoped>-->

<!--button {-->
<!--  background-color: #007BFF;-->
<!--  color: white;-->
<!--  padding: 10px 20px;-->
<!--  border: none;-->
<!--  border-radius: 5px;-->
<!--  cursor: pointer;-->
<!--  font-size: 16px;-->
<!--}-->
<!--.logo {-->
<!--  display: block;-->
<!--  margin: 0 auto 2rem;-->
<!--}-->

<!--nav {-->
<!--  width: 100%;-->
<!--  font-size: 12px;-->
<!--  text-align: center;-->
<!--  margin-top: 2rem;-->
<!--}-->

<!--nav a.router-link-exact-active {-->
<!--  color: var(&#45;&#45;color-text);-->
<!--}-->

<!--nav a.router-link-exact-active:hover {-->
<!--  background-color: transparent;-->
<!--}-->

<!--nav a {-->
<!--  display: inline-block;-->
<!--  padding: 0 1rem;-->
<!--  border-left: 1px solid var(&#45;&#45;color-border);-->
<!--}-->

<!--nav a:first-of-type {-->
<!--  border: 0;-->
<!--}-->

<!--@media (min-width: 1024px) {-->
<!--  header {-->
<!--    display: flex;-->
<!--    place-items: center;-->
<!--    padding-right: calc(var(&#45;&#45;section-gap) / 2);-->
<!--  }-->

<!--  .logo {-->
<!--    margin: 0 2rem 0 0;-->
<!--  }-->

<!--  header .wrapper {-->
<!--    display: flex;-->
<!--    place-items: flex-start;-->
<!--    flex-wrap: wrap;-->
<!--  }-->

<!--  nav {-->
<!--    text-align: left;-->
<!--    margin-left: -1rem;-->
<!--    font-size: 1rem;-->

<!--    padding: 1rem 0;-->
<!--    margin-top: 1rem;-->
<!--  }-->
<!--}-->
<!--</style>-->
