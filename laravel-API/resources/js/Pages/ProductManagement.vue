<template>
    <AppLayout title="Product Management">
        <div>
            <h1>Gestion des produits</h1>
            <div v-for="product in products" :key="product.id">
                <p>{{ product.name }}</p>
                <button @click="deleteProduct(product.id)">Delete</button>
            </div>
            <input v-model="newProduct" placeholder="New product name">
            <button @click="addProduct">Add Product</button>
        </div>
    </AppLayout>
</template>

<script>
import axios from 'axios';
import AppLayout from "@/Layouts/AppLayout.vue";

const apiClient = axios.create({
  baseURL: 'http://127.0.0.1:8000',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json'
  }
});

export default {
    components: {AppLayout},
    data() {
        return {
            products: [],
            newProduct: ''
        }
    },
    async created() {
        const response = await apiClient.get('/api/v1/products');
        this.products = response.data;
    },
    methods: {
        async addProduct() {
            const response = await apiClient.post('/api/v1/products', { name: this.newProduct });
            this.products.push(response.data);
            this.newProduct = '';
        },
        async deleteProduct(id) {
            await apiClient.delete(`/api/v1/products/${id}`);
            this.products = this.products.filter(product => product.id !== id);
        }
    }
}
</script>

<style scoped>
/* Add your styles here */
</style>
