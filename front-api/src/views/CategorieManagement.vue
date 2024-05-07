<template>
  <div class="flex justify-center items-center ">
    <div class="w-3/4">
      <h1 class="text-2xl font-bold mb-5 text-center">Gestion des catégories</h1>
      <button @click="showForm = !showForm" class="mb-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Créer une nouvelle catégorie</button>
      <form v-if="showForm" @submit.prevent="createCategory" class="mb-5 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom de la catégorie:</label>
          <input id="name" v-model="newCategoryName" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="flex items-center justify-between">
          <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Créer</button>
        </div>
      </form>
      <table class="w-full text-left border-collapse">
        <thead>
          <tr>
            <th class="py-4 px-6 bg-blue-500 text-white uppercase">Nom</th>
            <th class="py-4 px-6 bg-blue-500 text-white uppercase">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories" :key="category.id" class="text-gray-700">
            <td class="py-4 px-6 border-b">{{ category.name }}</td>
            <td class="py-4 px-6 border-b">
              <button @click="editCategory(category.id)" class="text-white bg-green-500 hover:bg-green-600 px-4 py-2 rounded">Modifier</button>
              <button @click="deleteCategory(category.id)" class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded">Supprimer</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import axios from 'axios';

export default {
  data() {
    return {
      categories: [],
      newCategoryName: '',
      showForm: false,
    };
  },
  async created() {
    await this.loadCategories();
  },
  methods: {
    editCategory(categoryId) {
      this.$router.push({ name: 'category-edit', params: { id: categoryId } });
    },
    async loadCategories() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/v1/categories');
        this.categories = response.data;
      } catch (error) {
        console.error('An error occurred:', error);
      }
    },
    async deleteCategory(categoryId) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/v1/categories/${categoryId}`);
        await this.loadCategories();
      } catch (error) {
        console.error('An error occurred:', error);
      }
    },
    async createCategory() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/v1/categories', { name: this.newCategoryName });
        this.categories.push(response.data);
        this.newCategoryName = '';
        this.showForm = false;
      } catch (error) {
        console.error('An error occurred:', error);
      }
    },
  },
};
</script>

