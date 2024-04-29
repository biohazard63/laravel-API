<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Pagination from './Pagination.vue';

const users = ref([]);
const products = ref([]);
const categories = ref([]);

const fetchData = async (url) => {
    const response = await fetch(url);
    const data = await response.json();
    return data;
};

onMounted(async () => {
    users.value = await fetchData('/api/v1/users');
    products.value = await fetchData('/api/v1/products');
    categories.value = await fetchData('/api/v1/categories');
});

const userPage = ref(1);
const productPage = ref(1);
const categoryPage = ref(1);

const tables = ref([
    { title: 'Users', data: users, actions: ['edit', 'delete'], currentPage: userPage },
    { title: 'Products', data: products, actions: ['edit', 'delete'], currentPage: productPage },
    { title: 'Categories', data: categories, actions: ['edit', 'delete'], currentPage: categoryPage },
]);
</script>

<template>
  <div>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
      <ApplicationLogo class="block h-12 w-auto" />
      <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Welcome to your Jetstream application!
      </h1>
    </div>

    <div class="bg-gray-200 bg-opacity-25 flex flex-col gap-6 lg:gap-8 p-6 lg:p-8">
      <div v-for="table in tables" :key="table.title">
        <h2 class="text-xl font-semibold text-gray-900">
          {{ table.title }}
        </h2>

        <table class="table-auto w-full mt-4">
          <thead>
            <tr>
              <th v-for="(value, key) in table.data[0]" :key="key" class="px-4 py-2">
                {{ key }}
              </th>
              <th v-if="table.actions.length > 0" class="px-4 py-2">
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in table.data" :key="index">
              <td v-for="(value, key) in item" :key="key" class="border px-4 py-2">
                {{ value }}
              </td>
              <td v-if="table.actions.includes('edit')" class="border px-4 py-2">
                <button>Edit</button>
              </td>
              <td v-if="table.actions.includes('delete')" class="border px-4 py-2">
                <button>Delete</button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Ajoutez le composant de pagination ici -->
<!--        <Pagination :total-page="10" :current-page="table.currentPage" @update:currentPage="table.currentPage = $event" />-->
      </div>
    </div>
  </div>
</template>
