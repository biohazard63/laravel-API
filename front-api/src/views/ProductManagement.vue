<template>
  <div>
    <div class="container">
    <h1>Gestion des produits</h1>
           <button @click="showForm = !showForm">Créer un nouveau produit</button>

      <!-- Le formulaire apparaît lorsque showForm est vrai -->
<form v-if="showForm" @submit.prevent = "createProduct" >
      <label for = "name">Nom:</label>
      <input id="name" v-model="newProductName" required>

      <label for="description">Description:</label>
      <input id="description" v-model="newProductDescription" required>

      <label for="price">Prix:</label>
      <input id="price" type="number" v-model.number="newProductPrice" required>

      <label for="stock">Stock:</label>
      <input id="stock" type="number" v-model.number="newProductStock" required>

      <label for="image">Image:</label>
      <input id="image" type="file" @change="onFileChange">

      <label for="category">Catégorie:</label>
      <select id="category" v-model="selectedCategory">
        <option v-for="category in categories" :key="category.id" :value="category.id">
          {{ category.name }}
        </option>
      </select>

  <button type="submit">{{ editingProduct ? 'Modifier' : 'Créer' }}</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Description</th>
          <th>Prix</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.name }}</td>
          <td>{{ product.description }}</td>
          <td>{{ product.price }}</td>
         <td><img :src="product.image"></td>
          <td>
<button @click="navigateToProductEdit(product.id)">Modifier</button>
            <button @click ="deleteProduct(product.id)">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router'; // Importez useRouter

export default {
  setup() {
    const router = useRouter();

    const navigateToProductEdit = (productId) => {
      router.push({ name: 'product-edit', params: { id: productId } });
    }

    return {
      navigateToProductEdit,
    };
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
      showForm: false,
      editingProduct: null, // Ajoutez cette ligne
    };
  },
  async created() {
    await this.loadProducts();
    await this.loadCategories();
  },
  methods: {
    async loadProducts() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/v1/products');
        this.products = response.data;
      } catch (error) {
        console.error('An error occurred:', error);
      }
    },
    async deleteProduct(productId) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/v1/products/${productId}`);
        await this.loadProducts(); // Recharge les produits après la suppression
      } catch (error) {
        console.error('An error occurred:', error);
      }
    },
    // Le reste de vos méthodes
    async loadCategories() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/v1/categories');
        this.categories = response.data;
      } catch (error) {
        console.error('An error occurred:', error);
      }
    },
    onFileChange(e) {
      this.newProductImage = e.target.files[0];
    },

    async createProduct() {
      try {
        const formData = new FormData();
        formData.append('name', this.newProductName);
        formData.append('description', this.newProductDescription);
        formData.append('price', this.newProductPrice);
        formData.append('stock', this.newProductStock);
        formData.append('image', this.newProductImage);
        const response = await axios.post('http://127.0.0.1:8000/api/v1/products', formData);
        this.products.push(response.data);
        // Réinitialisez les propriétés du nouveau produit
        this.newProductName = '';
        this.newProductDescription = '';
        this.newProductPrice = 0;
        this.newProductStock = 0;
        this.newProductImage = null;
        this.showForm = false; // Ajoutez cette ligne
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
  margin-top: 186rem;
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