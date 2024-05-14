<template>
  <div class="flex justify-center items-center ">
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
    <table class="w-full table-auto">
          <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
              <th class="py-3 px-6 text-left">Commande ID</th>
              <th class="py-3 px-6 text-left">Name</th>
              <th class="py-3 px-6 text-left">Date</th>
              <th class="py-3 px-6 text-left">Total</th>
              <th class="py-3 px-6 text-left">Détails</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 text-sm font-light">
            <tr v-for="order in orders" :key="order.id" class="border-b border-gray-200 hover:bg-gray-100">
              <td class="py-3 px-6 text-left">{{ order.id }}</td>
              <td class="py-3 px-6 text-left">{{ order.customer_name }}</td>
              <td class="py-3 px-6 text-left">{{ order.created_at }}</td>
              <td class="py-3 px-6 text-left">{{ order.total_amount }}</td>
              <td class="py-3 px-6 text-left">
                <router-link :to="{ name: 'OrderDetails', params: { id: order.id } }">
                  {{ order.id }}
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
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