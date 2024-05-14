<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Statistiques</h1>
    <div>
      <h2 class="text-xl font-semibold mb-2">Commandes</h2>
      <div v-if="orders.length" class="mb-5 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <table class="w-full table-auto">
          <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
              <th class="py-3 px-6 text-left">Commande ID</th>
              <th class="py-3 px-6 text-left">Name</th>
              <th class="py-3 px-6 text-left">Date</th>
              <th class="py-3 px-6 text-left">Total</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 text-sm font-light">
            <tr v-for="order in orders" :key="order.id" class="border-b border-gray-200 hover:bg-gray-100">
              <td class="py-3 px-6 text-left">{{ order.id }}</td>
              <td class="py-3 px-6 text-left">{{ order.customer_name }}</td>
              <td class="py-3 px-6 text-left">{{ order.created_at }}</td>
              <td class="py-3 px-6 text-left">{{ order.total_amount }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script >
import axios from 'axios'

export default {
  data() {
    return {
      orders: []
    }
  },
  async created() {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/v1/orders')
      this.orders = response.data
    } catch (error) {
      console.error('An error occurred:', error)
    }
  }
}
</script >