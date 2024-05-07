<template>
  <div>
    <h1>Gestion des catégories</h1>
    <button @click="showForm = !showForm">Créer une nouvelle catégorie</button>

    <form v-if="showForm" @submit.prevent="createCategory">
      <label for="name">Nom de la catégorie:</label>
      <input id="name" v-model="newCategoryName" required>
      <button type="submit">Créer</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="category in categories" :key="category.id">
          <td>{{ category.name }}</td>
          <td>
<button @click="editCategory(category.id)">Modifier</button>
            <button @click="deleteCategory(category.id)">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>
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

<style scoped >
div {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 80%;
  margin-top: 80rem;
}
.container {
  display: flex;
  flex-direction: column;
  width: 50%;
  margin-top: 50rem;
  margin-left: 5rem;
}

table img {
  height: 75px;
  width: auto;
}
table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  transition: 0.3s;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

th, td {
  padding: 15px;
  text-align: left;
  transition: 0.3s;
}

th {
  background-color: #007BFF;
  color: white;
}

td {
  background-color: #f3f3f3;
  color: #333;
}

tr:hover td {
  background-color: #edf2fa;
}
button {
  background-color: #007BFF;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

button:hover {
  background-color: #0056b3;
}

form {
  background-color: #f8f9fa;
  padding: 20px;
  border-radius: 5px;
  margin-top: 40rem;
}

form label {
  display: block;
  margin-bottom: 5px;
  color: #333333;
}

form input, form select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ced4da;
  border-radius: 4px;
  margin-bottom: 20px;
  color: #333333;
}

form button[type="submit"] {
  background-color: #28a745;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

form button[type="submit"]:hover {
  background-color: #218838;
}
/* Pour les écrans de taille moyenne (tablette) */
@media (min-width: 600px) {
  table {
    width: 75%;
  }
}

/* Pour les grands écrans (ordinateur de bureau) */
@media (min-width: 900px) {
  table {
    width: 50%;
  }
}
</style >