<template >
  <div class = "" >
    <div class = "container" >
    <h2 class = "mb-4 text-2xl font-bold text-center" >Dashboard</h2 >
    <table class = "w-full text-left border-collapse" >
      <thead >
        <tr >
          <th class = "py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light" >Nom</th >
          <th class = "py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light" >Email</th >
        </tr >
      </thead >
      <tbody >
        <tr v-for = "user in users" :key = "user.id" class = "hover:bg-grey-lighter" >
          <td class = "py-4 px-6 border-b border-grey-light" >{{ user.name }}</td >
          <td class = "py-4 px-6 border-b border-grey-light" >{{ user.email }}</td >
        </tr >
      </tbody >
    </table >
      </div >
    <div class = "container" >
      <h2 class = "mb-4 text-2xl font-bold text-center" >Produits</h2 >
        <table class = "w-full text-left border-collapse" >
          <thead >
            <tr >
              <th class = "py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light" >Nom du produit</th >
              <th class = "py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light" >Prix</th >
            </tr >
          </thead >
          <tbody >
            <tr v-for = "product in products" :key = "product.id" class = "hover:bg-grey-lighter" >
              <td class = "py-4 px-6 border-b border-grey-light" >{{ product.name }}</td >
              <td class = "py-4 px-6 border-b border-grey-light" >{{ product.price }}</td >
            </tr >
          </tbody >
        </table >
    </div >
   <div class="container">
    <h2 class="mb-4 text-2xl font-bold text-center">Catégories</h2>
    <table class="w-full text-left border-collapse">
      <thead>
        <tr>
          <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Nom de la catégorie</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="category in categories" :key="category.id" class="hover:bg-grey-lighter">
          <td class="py-4 px-6 border-b border-grey-light">{{ category.name }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  </div >
</template>

<script>
import axios from 'axios';

export default {
  name: 'Dashboard',
  data() {
    return {
      users: [],
      products: [],
      categories: [], // Ajoutez ceci
    };
  },
  async mounted() {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/v1/users', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('accessToken')}`
        }
      });
      this.users = response.data;

      const productResponse = await axios.get('http://127.0.0.1:8000/api/v1/products', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('accessToken')}`
        }
      });
      const allProducts = productResponse.data;
      this.products = allProducts.slice(Math.max(allProducts.length - 5, 0));

      // Ajoutez ceci
      const categoryResponse = await axios.get('http://127.0.0.1:8000/api/v1/categories', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('accessToken')}`
        }
      });
      const allCategories = categoryResponse.data;
      this.categories = allCategories.slice(Math.max(allCategories.length - 5, 0)); // Prenez les 5 dernières catégories
    } catch (error) {
      console.error('An error occurred:', error);
    }
  },
};
</script>
<!--<style scoped >-->
<!--div {-->
<!--  display: flex;-->
<!--  justify-content: center;-->
<!--  align-items: center;-->
<!--  height: 100vh;-->
<!--  width: 80%;-->
<!--}-->
<!--.container {-->
<!--  margin: 0 20px;-->
<!--  display: flex;-->
<!--  flex-direction: column;-->
<!--  width: 30rem;-->

<!--}-->
<!--table {-->
<!--  width: 100%;-->
<!--  border-collapse: separate;-->
<!--  border-spacing: 0;-->
<!--  transition: 0.3s;-->
<!--  border-radius: 10px;-->
<!--  overflow: hidden;-->
<!--  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);-->
<!--}-->

<!--th, td {-->
<!--  padding: 15px;-->
<!--  text-align: left;-->
<!--  transition: 0.3s;-->
<!--}-->

<!--th {-->
<!--  background-color: #007BFF;-->
<!--  color: white;-->
<!--}-->

<!--td {-->
<!--  background-color: #f3f3f3;-->
<!--  color: #333;-->
<!--}-->

<!--tr:hover td {-->
<!--  background-color: #edf2fa;-->
<!--}-->

<!--/* Pour les écrans de taille moyenne (tablette) */-->
<!--@media (min-width: 600px) {-->
<!--  table {-->
<!--    width: 75%;-->
<!--  }-->
<!--}-->

<!--/* Pour les grands écrans (ordinateur de bureau) */-->
<!--@media (min-width: 900px) {-->
<!--  table {-->
<!--    width: 50%;-->
<!--  }-->
<!--}-->
<!--</style >-->