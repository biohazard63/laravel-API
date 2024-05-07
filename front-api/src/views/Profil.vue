<template>
  <div class="flex justify-center items-center h-screen">
    <div class="w-3/4">
      <h1 class="text-2xl font-bold mb-5 text-center">Profil de l'utilisateur</h1>
      <div v-if="user" class="mb-5 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <p class="mb-2">
          <strong class="text-gray-700 text-sm font-bold">Nom:</strong> {{ user.name }}
        </p>
        <p class="mb-2">
          <strong class="text-gray-700 text-sm font-bold">Email:</strong> {{ user.email }}
        </p>
      </div>
      <div v-else>
        <p class="text-gray-700 text-sm font-bold">Chargement...</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      user: null
    }
  },
  async created() {
    const userId = localStorage.getItem('userId')

    if (userId) {
      await this.loadUserProfile(userId)
    }
  },
  methods: {
    async loadUserProfile(userId) {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/v1/users/${userId}`)
        this.user = response.data
      } catch (error) {
        console.error('An error occurred:', error)
      }
    }
  }
}
</script>
