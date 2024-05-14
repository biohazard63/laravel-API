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
let isMenuOpen = ref(false)

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}
const logout = () => {
  localStorage.removeItem('accessToken')
  isLoggedIn.value = false

  location.href = '/login'
}
</script>

<template>
    <header class="flex items-center justify-between p-5 bg-blue-500">
      <RouterLink to="/">
        <img alt="Vue logo" class="w-12 h-12" src="@/assets/logo.svg" />
      </RouterLink>    <button @click="toggleMenu" class=" text-white">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>
   <nav
       class="fixed transform top-0 left-0   bg-gray-500 transition-transform duration-200 ease-in-out flex flex-col items-start p-5 z-50"
     :class="{'translate-x-full': !isMenuOpen, 'translate-x-0': isMenuOpen}"
     @click.self="toggleMenu"
>
   <div class="mt-16 space-y-4">
       <button @click="toggleMenu" class="absolute top-5 right-5 text-white">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      <RouterLink class="text-white mr-8 hover:text-blue-500" to="/">Accueil</RouterLink>
      <RouterLink class="text-white mr-8 hover:text-blue-500" to="/product-list">Liste des produits</RouterLink>
      <RouterLink class="text-white mr-8 hover:text-blue-500" to="/order-management">Gestion des commandes</RouterLink>
      <RouterLink class="text-white mr-8 hover:text-blue-500" to="/register">Register</RouterLink>
      <RouterLink class="text-white mr-8 hover:text-blue-500" to="/dashboard">Dashboard</RouterLink>
      <RouterLink class="text-white mr-8 hover:text-blue-500" to="/user-management">User Management</RouterLink>
      <RouterLink class="text-white mr-8 hover:text-blue-500" to="/product-management">Product Management</RouterLink>
      <RouterLink class="text-white mr-8 hover:text-blue-500" to="/category-management">Category Management</RouterLink>
      <RouterLink class="text-white mr-8 hover:text-blue-500" to="/profil">Profil</RouterLink>
      <RouterLink class="text-white mr-8 hover:text-blue-500" to="/login">Login</RouterLink>
      <button class="px-4 py-2 text-white bg-red-500 rounded" @click="logout">Logout</button>
  </div>
</nav>
  </header>

  <RouterView />
</template>
