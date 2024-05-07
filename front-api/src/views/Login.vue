<template>
  <div class="register flex flex-col justify-center items-center h-screen w-full">
    <h2 class="mb-4 text-2xl">Login</h2>
    <form @submit.prevent="login" class="w-full max-w-xs">
      <input v-model="email" type="text" placeholder="Email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-3"> <!-- Changez ceci -->
      <input v-model="password" type="password" placeholder="Password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-3">
      <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Login</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/v1/login', {
          email: this.email,
          password: this.password,
        });

        if (response.status === 200) {
          localStorage.setItem('accessToken', response.data.token);
          localStorage.setItem('userId', response.data.user.id); // Modifiez cette ligne
          console.log('User ID stored in local storage:', response.data.user.id); // Et cette ligne
          this.$root.$emit('login'); // Ajoutez cette ligne

          this.$router.push('/dashboard');
        }
      } catch (error) {
        console.error('An error occurred:', error);
      }
    },
  },
};
</script>


