<template>
  <div class="container mx-auto px-4">
    <h2 class="mb-4 text-2xl font-bold text-center">Dashboard</h2>
    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
      <table
        class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative"
      >
        <thead>
          <tr class="text-left">
            <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100 text-gray-600">
              Nom
            </th>
            <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100 text-gray-600">
              Email
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="hover:bg-gray-100">
            <td class="py-2 px-3 border-b border-gray-200">{{ user.name }}</td>
            <td class="py-2 px-3 border-b border-gray-200">{{ user.email }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <h2 class="mt-8 mb-4 text-2xl font-bold text-center">Produits</h2>
    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
      <table
        class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative"
      >
        <thead>
          <tr class="text-left">
            <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100 text-gray-600">
              Nom du produit
            </th>
            <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100 text-gray-600">
              Prix
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id" class="hover:bg-gray-100">
            <td class="py-2 px-3 border-b border-gray-200">{{ product.name }}</td>
            <td class="py-2 px-3 border-b border-gray-200">{{ product.price }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <h2 class="mt-8 mb-4 text-2xl font-bold text-center">Catégories</h2>
    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
      <table
        class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative"
      >
        <thead>
          <tr class="text-left">
            <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100 text-gray-600">
              Nom de la catégorie
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories" :key="category.id" class="hover:bg-gray-100">
            <td class="py-2 px-3 border-b border-gray-200">{{ category.name }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Dashboard',
  data() {
    return {
      users: [],
      products: [],
      categories: []
    }
  },
  async mounted() {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/v1/users', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('accessToken')}`
        }
      })
      this.users = response.data

      const productResponse = await axios.get('http://127.0.0.1:8000/api/v1/products', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('accessToken')}`
        }
      })
      const allProducts = productResponse.data
      this.products = allProducts.slice(Math.max(allProducts.length - 5, 0))

      // Ajoutez ceci
      const categoryResponse = await axios.get('http://127.0.0.1:8000/api/v1/categories', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('accessToken')}`
        }
      })
      const allCategories = categoryResponse.data
      this.categories = allCategories.slice(Math.max(allCategories.length - 5, 0))
    } catch (error) {
      console.error('An error occurred:', error)
    }
  }
}
</script>
