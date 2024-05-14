<template>
  <div class="flex justify-center items-center h-screen">
    <div class="w-3/4">
      <h1 class="text-2xl font-bold mb-5 text-center">Modifier la catégorie</h1>
      <form
        @submit.prevent="updateCategory"
        class="mb-5 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
      >
        <div class="mb-4">
          <label for="name" class="block text-gray-700 text-sm font-bold mb-2"
            >Nom de la catégorie:</label
          >
          <input
            id="name"
            v-model="category.name"
            required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          />
        </div>
        <div class="flex items-center justify-between">
          <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          >
            Mettre à jour
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      category: {
        name: ''
      }
    }
  },
  async created() {
    await this.loadCategory()
  },
  methods: {
    async loadCategory() {
      try {
        const response = await axios.get(
          `http://127.0.0.1:8000/api/v1/categories/${this.$route.params.id}`
        )
        this.category = response.data
      } catch (error) {
        console.error('An error occurred:', error)
      }
    },
    async updateCategory() {
      try {
        await axios.put(
          `http://127.0.0.1:8000/api/v1/categories/${this.$route.params.id}`,
          this.category
        )
        this.$router.push({ name: 'category-management' })
      } catch (error) {
        console.error('An error occurred:', error)
      }
    }
  }
}
</script>
