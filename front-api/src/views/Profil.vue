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

        <form @submit.prevent="updateProfile" class="bg-blue-100 p-4 rounded">
          <h2 class="text-xl font-bold mb-2">Mise à jour du profil</h2>
          <div class="mb-3">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nom:</label>
            <input v-model="user.name" id="name" type="text" placeholder="Name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div class="mb-3">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email:</label>
            <input v-model="user.email" id="email" type="email" placeholder="Email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div class="mb-3">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Mot de passe:</label>
            <input v-model="password" id="password" type="password" placeholder="Password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Mettre à jour le profil</button>
          </div>
        </form>
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
      orders: [],
      password: ''
    }
  },
  async created() {
    const userName = localStorage.getItem('userName')
    const userId = localStorage.getItem('userId')

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
        const response = await axios.get(`http://127.0.0.1:8000/api/v1/users/${encodeURIComponent(userName)}/orders`)
        this.orders = response.data
      } catch (error) {
        console.error('An error occurred in loadUserOrders:', error)
      }
    },
    async updateProfile() {
      const userId = localStorage.getItem('userId')
      try {
        await axios.put(`http://127.0.0.1:8000/api/v1/users/${userId}`, {
          name: this.user.name,
          email: this.user.email,
          password: this.password
        })
        this.password = ''
      } catch (error) {
        console.error('An error occurred in updateProfile:', error)
      }
    }
  }
}
</script>