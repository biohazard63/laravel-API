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
      <div v-if="orders.length" class="mb-5 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <h2 class="text-2xl font-bold mb-5 text-center">Dernières commandes</h2>
    <div v-for="order in orders" :key="order.id">
        <p><strong>Commande ID:</strong> {{ order.id }}</p>
      <p><strong>Name:</strong> {{orders.name}}</p>
        <p><strong>Date:</strong> {{ order.created_at }}</p>
        <p><strong>Total:</strong> {{ order.total_amount }}</p>
    </div>
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
      user: null,
      orders: []
    }
  },
  async created() {
    const userName = localStorage.getItem('userName')
    const userId = localStorage.getItem('userId')
    console.log('Username from localStorage:', userName)

    if (userName) {
      await this.loadUserProfile(userId)
      await this.loadUserOrders(userName)
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
    },
    async loadUserOrders(userName) {
      try {
        console.log('loadUserOrders called with userName:', userName)
        const response = await axios.get(`http://127.0.0.1:8000/api/v1/users/${encodeURIComponent(userName)}/orders`)
        console.log('Response from loadUserOrders:', response)
        this.orders = response.data
      } catch (error) {
        console.error('An error occurred in loadUserOrders:', error)
      }
    }
  }
}
</script>