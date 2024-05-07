<template>
  <div class="flex justify-center items-center h-screen">
    <div class="w-3/4 text-center">
      <h1 class="text-2xl font-bold mb-5">Bienvenue</h1>
      <p class="mb-5">Veuillez vous connecter ou créer un compte pour continuer.</p>
      <div>
        <router-link to="/login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">Se connecter</router-link>
        <router-link to="/register" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Créer un compte</router-link>
      </div>
    </div>
  </div>
</template>