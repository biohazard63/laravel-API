<template>
  <div class="register flex flex-col items-center justify-center h-screen w-full">
    <h1 class="mb-5 text-2xl font-bold">Créer un compte</h1>
    <form @submit.prevent="register" class="w-full max-w-sm">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nom:</label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          type="text"
          id="name"
          v-model="name"
          required
        />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email:</label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          type="email"
          id="email"
          v-model="email"
          required
        />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password"
          >Mot de passe:</label
        >
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          type="password"
          id="password"
          v-model="password"
          required
        />
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="passwordConfirm"
          >Confirmer le mot de passe:</label
        >
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          type="password"
          id="passwordConfirm"
          v-model="password_confirmation"
          required
        />
      </div>
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        type="submit"
      >
        S'inscrire
      </button>
      <router-link to="/login" class="ml-4 text-blue-500 hover:text-blue-800"
        >Se connecter</router-link
      >
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    }
  },
  methods: {
    async register() {
      console.log('Password:', this.password)
      console.log('Password Confirmation:', this.password_confirmation)

      if (this.password !== this.password_confirmation) {
        alert('The password confirmation does not match.')
        return
      }

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/v1/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        })


        console.log(response.data)
      } catch (error) {
        console.error('An error occurred:', error)
      }
    }
  }
}
</script>
