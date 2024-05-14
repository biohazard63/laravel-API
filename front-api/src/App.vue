<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'
import { RouterLink, RouterView } from 'vue-router'

const isLoggedIn = ref(false)

onMounted(() => {
  isLoggedIn.value = !!localStorage.getItem('accessToken')
})

watch(isLoggedIn, () => {
  // Force le re-rendering du composant lorsque isLoggedIn change
  isLoggedIn.value = !!localStorage.getItem('accessToken')
})

const logout = () => {
  localStorage.removeItem('accessToken')
  isLoggedIn.value = false

  location.href = '/login'
}
</script>

<template>
  <header class="flex items-center justify-between p-5 bg-blue-500">
    <img alt="Vue logo" class="w-12 h-12" src="@/assets/logo.svg" />

    <nav class="flex space-x-4">
      <RouterLink class="text-white" to="/">Accueil</RouterLink>
      <RouterLink class="text-white" to="/product-list">Liste des produits</RouterLink>
      <RouterLink class="text-white" to="/order-management">Gestion des commandes</RouterLink>
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
