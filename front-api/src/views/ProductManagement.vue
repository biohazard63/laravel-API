<template>
  <div class="flex justify-center items-center">
    <div class="w-3/4">
      <h1 class="text-2xl font-bold mb-5 text-center">Gestion des produits</h1>
      <button
        @click="showForm = !showForm"
        class="mb-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
      >
        Créer un nouveau produit
      </button>
      <div v-if="showForm" class="mb-5 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form
          v-if="showForm"
          @submit.prevent="createProduct"
          class="mb-5 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
        >
          <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom:</label>
            <input
              id="name"
              v-model="newProductName"
              required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>

          <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2"
              >Description:</label
            >
            <input
              id="description"
              v-model="newProductDescription"
              required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>

          <div class="mb-4">
            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Prix:</label>
            <input
              id="price"
              type="number"
              v-model.number="newProductPrice"
              required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>

          <div class="mb-4">
            <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock:</label>
            <input
              id="stock"
              type="number"
              v-model.number="newProductStock"
              required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>

          <div class="mb-4">
            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
            <input
              id="image"
              type="file"
              @change="onFileChange"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>

          <div class="mb-4">
            <label for="category" class="block text-gray-700 text-sm font-bold mb-2"
              >Catégorie:</label
            >
            <select
              id="category"
              v-model="selectedCategory"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            >
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>

          <div class="flex items-center justify-between">
            <button
              type="submit"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            >
              {{ editingProduct ? 'Modifier' : 'Créer' }}
            </button>
          </div>
        </form>
      </div>
      <div>
        <label for="categoryFilter">Filtrer par catégorie:</label>
        <select id="categoryFilter" v-model="selectedCategory" @change="filterProducts">
          <option value="">Toutes les catégories</option>
          <option v-for="category in filteredCategories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>
      <table class="w-full text-left border-collapse">
        <thead>
          <tr>
            <th class="py-4 px-6 bg-blue-500 text-white uppercase">Nom</th>
            <th class="py-4 px-6 bg-blue-500 text-white uppercase">Description</th>
            <th class="py-4 px-6 bg-blue-500 text-white uppercase">Prix</th>
            <th class="py-4 px-6 bg-blue-500 text-white uppercase">Image</th>
            <th class="py-4 px-6 bg-blue-500 text-white uppercase">categorie</th>
            <th class="py-4 px-6 bg-blue-500 text-white uppercase">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in filteredProducts" :key="product.id" class="text-gray-700">
            <td class="py-4 px-6 border-b">{{ product.name }}</td>
            <td class="py-4 px-6 border-b">{{ product.description }}</td>
            <td class="py-4 px-6 border-b">{{ product.price }}</td>
            <td class="py-4 px-6 border-b">
              <img :src="product.image" />
            </td>
            <td class="py-4 px-6 border-b">
              <ul>
                <li v-for="category in product.categories" :key="category.id">{{ category.name }}</li>
              </ul>
            </td>
            <td class="py-4 px-6 border-b">
              <div class="flex">
                <button
                  @click="navigateToProductEdit(product.id)"
                  class="mr-4 text-white bg-green-500 hover:bg-green-600 px-4 py-2 rounded"
                >
                  Modifier
                </button>
                <button
                  @click="deleteProduct(product.id)"
                  class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded"
                >
                  Supprimer
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { useRouter } from 'vue-router'

export default {
  setup() {
    const router = useRouter()

    const navigateToProductEdit = (productId) => {
      router.push({ name: 'product-edit', params: { id: productId } })
    }

    return {
      navigateToProductEdit
    }
  },
  data() {
    return {
      products: [],
      newProductName: '',
      newProductDescription: '',
      newProductPrice: 0,
      newProductStock: 0,
      newProductImage: null,
      selectedCategory: null,
      categories: [],
      filteredCategories: [],
      showForm: false,
      editingProduct: null
    }
  },
  async created() {
    await this.loadProducts()
    await this.loadCategories()
  },
  methods: {
    async loadProducts() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/v1/products')
        this.products = response.data
      } catch (error) {
        console.error('An error occurred:', error)
      }
    },
    async deleteProduct(productId) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/v1/products/${productId}`)
        await this.loadProducts()
      } catch (error) {
        console.error('An error occurred:', error)
      }
    },
    async loadCategories() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/v1/categories')
        this.categories = response.data
        this.filteredCategories = [...this.categories]
      } catch (error) {
        console.error('An error occurred:', error)
      }
    },
    onFileChange(e) {
      this.newProductImage = e.target.files[0]
    },

    async createProduct() {
      try {
        const formData = new FormData()
        formData.append('name', this.newProductName)
        formData.append('description', this.newProductDescription)
        formData.append('price', this.newProductPrice)
        formData.append('stock', this.newProductStock)
        formData.append('image', this.newProductImage)
        const response = await axios.post('http://127.0.0.1:8000/api/v1/products', formData)
        this.products.push(response.data)
        this.newProductName = ''
        this.newProductDescription = ''
        this.newProductPrice = 0
        this.newProductStock = 0
        this.newProductImage = null
        this.showForm = false
      } catch (error) {
        console.error('An error occurred:', error)
      }
    },

    filterProducts() {
      console.log('filterProducts called with selectedCategory:', this.selectedCategory);
      if (this.selectedCategory) {
        this.filteredProducts = this.products.filter(product =>
          product.categories.some(category => category.id === this.selectedCategory)
        );
      } else {
        this.filteredProducts = [...this.products];
      }
      console.log('filteredProducts:', this.filteredProducts);
    },
  },
  watch: {
    selectedCategory() {
      this.filterProducts();
    }
  }
}
</script>
