<template>
  <div v-if="order" class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Détails de la commande {{ order.id }}</h2>
    <p class="mb-2"><span class="font-bold">Nom du client :</span> {{ order.customer_name }}</p>
    <p class="mb-4"><span class="font-bold">Total :</span> {{ order.total_amount }}</p>
    <h3 class="text-xl font-bold mb-2">Produits :</h3>
    <ul class="list-disc list-inside">
      <li v-for="product in order.products" :key="product.id" class="mb-1">
        {{ product.name }} - Quantité : {{ product.pivot.quantity }}
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      order: null,
    };
  },
  async mounted() {
    const orderId = this.$route.params.id;
    console.log('orderId:', orderId);

    try {
      const response = await axios.get(`http://127.0.0.1:8000/api/v1/orders/${orderId}`);
      this.order = response.data;
    } catch (error) {
      console.error('An error occurred:', error);
    }
  },
};
</script>