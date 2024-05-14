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
      </div>
      <div class="flex justify-between items-center">
        <p class="text-2xl font-bold">Total : {{ total }}€</p>
        <button @click="checkout" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">Commander</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
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
  cart.value.push(product);
  console.log(product);
  console.log(`Produit ajouté au panier : ${product.name}`);
};

const total = computed(() => {
  return cart.value.reduce((acc, product) => acc + Number(product.price), 0).toFixed(2);
});
const checkout = async () => {
  console.log('Commande en cours...');

  // Récupérer le nom de l'utilisateur à partir du local storage
  const customerName = localStorage.getItem('username');

  // Créer un objet commande avec les détails nécessaires
  const order = {
    customer_name: customerName,
    products: cart.value.map(product => ({ id: product.id, quantity: 1 })), // replace 1 with the actual quantity
    total_amount: total.value,
  };

  try {
    // Envoyer la commande à l'API via une requête POST
    const response = await axios.post('http://localhost:8000/api/v1/orders', order);

    // Vérifier la réponse de l'API
    if (response.status === 201) {
      console.log('Commande enregistrée avec succès');
      // Vider le panier après une commande réussie
      cart.value = [];
    } else {
      console.log('Erreur lors de l\'enregistrement de la commande');
    }
  } catch (error) {
    console.error('Une erreur est survenue lors de l\'envoi de la commande à l\'API:', error);
  }
};
</script>
