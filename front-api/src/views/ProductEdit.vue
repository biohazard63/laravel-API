<template>
  <form @submit.prevent="updateProduct">
    <label for="name">Nom du produit</label>
    <input id="name" v-model="product.name" type="text" required>

    <label for="description">Description du produit</label>
    <input id="description" v-model="product.description" type="text" required>

    <label for="price">Prix du produit</label>
    <input id="price" v-model="product.price" type="number" required>

    <label for="stock">Stock du produit</label>
    <input id="stock" v-model="product.stock" type="number" required>

  <label for="image">Image du produit</label>
  <input id="image" v-model="product.image" type="text" required>

  <label for="category">Catégorie du produit</label>
  <input id="category" v-model="product.category_id" type="number" required>

    <button type="submit">Mettre à jour le produit</button>
  </form>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      product: {
        name: '',
        description: '',
        price: 0,
        stock: 0,
        image: '', // Ajoutez un champ pour l'image du produit
        category_id: 0 // Ajoutez un champ pour la catégorie du produit
      }
    };
  },
  async created() {
    const productId = this.$route.params.id;
    const response = await axios.get(`http://127.0.0.1:8000/api/v1/products/${productId}`);
    this.product = response.data;
  },
  methods: {
    async updateProduct() {
      const productId = this.$route.params.id;
      try {
        await axios.put(`http://127.0.0.1:8000/api/v1/products/${productId}`, this.product);
        this.$router.push({ name: 'product-management' });
      } catch (error) {
        console.error('An error occurred:', error);
      }
    }
  }
};
</script>
<style scoped>
form {
  display: flex;
  flex-direction: column;
  width: 50%;
  margin-top: 22rem;
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 5px;
}

form label {
  margin-bottom: 5px;
  color: #333333;
}

form input {
  padding: 10px;
  border: 1px solid #ced4da;
  border-radius: 4px;
  margin-bottom: 20px;
  color: #333333;
}

form button {
  background-color: #007BFF;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

form button:hover {
  background-color: #0056b3;
}
</style>