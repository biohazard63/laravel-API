<template>
  <div class="container mx-auto px-4 flex">
    <div class="w-1/2 pr-4">
      <h1 class="text-4xl font-bold mb-4">Liste des produits</h1>
      <div>
        <label for="category">Filtrer par catégorie:</label>
        <select id="category" v-model="selectedCategory" @change="filterProducts">
          <option value="">Toutes les catégories</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>
      <div v-for="product in filteredProducts" :key="product.id"
           class="mb-8 bg-gray-100 shadow rounded overflow-hidden">
        <p class="text-xl m-4 font-semibold p-4">
          {{ product.name }} - {{ product.price }}€
          <img :src="product.image" alt="Product image" />
        </p>
        <button @click="addToCart(product)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ajouter au panier</button>
      </div>
    </div>

     <div class="fixed right-0 top-13 w-1/2 pl-4  h-screen overflow-auto">
    <h2 class="text-4xl font-bold mb-4 mt-8">Panier</h2>
    <div v-for="product in cart" :key="product.id" class="mb-4 bg-white shadow rounded overflow-hidden">
      <p class="text-xl font-semibold p-4">
        {{ product.name }} - {{ product.price }}€
      </p>
      <input type="number" v-model="product.quantity" min="1" class="border-2 border-gray-300 p-2 rounded-md">
      <button @click="updateQuantity(product)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Mettre à jour</button>
    </div>
    <div class="flex justify-between items-center">
      <p class="text-2xl font-bold">Total : {{ total }}€</p>
      <button @click="checkout" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">Commander</button>
    </div>
  </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed, defineExpose, watch } from 'vue';
import axios from 'axios';

const products = ref([]);
const filteredProducts = ref([]);
const categories = ref([]);
const selectedCategory = ref('');
const cart = ref([]);

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/v1/products');
    products.value = response.data;
    filteredProducts.value = [...products.value];

    const categoryResponse = await axios.get('http://localhost:8000/api/v1/categories');
    categories.value = categoryResponse.data;
  } catch (error) {
    console.error(error);
  }
});

watch(selectedCategory, () => {
  filterProducts();
});

const filterProducts = () => {
  if (selectedCategory.value) {
    filteredProducts.value = products.value.filter(product => product.categories.some(category => category.id === selectedCategory.value));
  } else {
    filteredProducts.value = [...products.value];
  }
};

const addToCart = (product) => {
  product.quantity = 1;
  cart.value.push(product);
};

const updateQuantity = (product) => {
  const index = cart.value.findIndex(p => p.id === product.id);
  if (index !== -1) {
    cart.value[index].quantity = product.quantity;
  }
};

const total = computed(() => {
  return cart.value.reduce((acc, product) => acc + Number(product.price) * product.quantity, 0).toFixed(2);
});

const checkout = async () => {
  const order = {
    customer_name: localStorage.getItem('userName'),
    products: cart.value.map(product => ({ id: product.id, quantity: product.quantity })),
    total_amount: total.value,
  };

  try {
    const response = await axios.post('http://localhost:8000/api/v1/orders', order);

    if (response.status === 201) {
      cart.value = [];
    } else {
      console.error('Error while recording the order');
    }
  } catch (error) {
    console.error('An error occurred while sending the order to the API:', error);
  }
};

defineExpose({
  addToCart,
  updateQuantity,
  checkout,
  filterProducts
});
</script>