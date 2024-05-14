<template>
  <div class="container mx-auto px-4 flex">
    <div class="w-1/2 pr-4">
      <h1 class="text-4xl font-bold mb-4">Liste des produits</h1>
      <div v-for="product in products" :key="product.id" class="mb-4 bg-white shadow rounded overflow-hidden">
        <p class="text-xl font-semibold p-4">{{ product.name }} - {{ product.price }}€</p>
        <button @click="addToCart(product)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ajouter au panier</button>
      </div>
    </div>

    <div class="w-1/2 pl-4">
      <h2 class="text-4xl font-bold mb-4 mt-8">Panier</h2>
      <div v-for="product in cart" :key="product.id" class="mb-4 bg-white shadow rounded overflow-hidden">
        <p class="text-xl font-semibold p-4">{{ product.name }} - {{ product.price }}€</p>
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
import { ref, onMounted, computed, defineExpose } from 'vue';
import axios from 'axios';

const products = ref([]);
const cart = ref([]);

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/v1/products');
    products.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

const addToCart = (product) => {
  // When adding to cart, we also add a quantity property to the product
  product.quantity = 1;
  cart.value.push(product);
};

const updateQuantity = (product) => {
  // Update the quantity of the product in the cart
  const index = cart.value.findIndex(p => p.id === product.id);
  if (index !== -1) {
    cart.value[index].quantity = product.quantity;
  }
};

const total = computed(() => {
  return cart.value.reduce((acc, product) => acc + Number(product.price) * product.quantity, 0).toFixed(2);
});

const checkout = async () => {
  // Create an order object with necessary details
  const order = {
    customer_name: localStorage.getItem('username'), // Get the username from local storage
    products: cart.value.map(product => ({ id: product.id, quantity: product.quantity })),
    total_amount: total.value,
  };

  try {
    // Send the order to the API via a POST request
    const response = await axios.post('http://localhost:8000/api/v1/orders', order);

    // Check the API response
    if (response.status === 201) {
      // Empty the cart after a successful order
      cart.value = [];
    } else {
      console.error('Error while recording the order');
    }
  } catch (error) {
    console.error('An error occurred while sending the order to the API:', error);
  }
};

// Expose the methods to the template
defineExpose({
  addToCart,
  updateQuantity,
  checkout,
});
</script>