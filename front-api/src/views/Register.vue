<template>
  <div class="register">
    <h1>Créer un compte</h1>
    <form @submit.prevent="register">
      <div>
        <label for="name">Nom:</label>
        <input type="text" id="name" v-model="name" required>
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" required>
      </div>
      <div>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" v-model="password" required>
      </div>
      <div>
        <label for="passwordConfirm">Confirmer le mot de passe:</label>
        <input type="password" id="passwordConfirm" v-model=" password_confirmation" required>
      </div>
      <button type="submit">S'inscrire</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    };
  },
  methods: {
    async register() {
      console.log('Password:', this.password);
      console.log('Password Confirmation:', this.password_confirmation);

      if (this.password !== this.password_confirmation) {
        alert('The password confirmation does not match.');
        return;
      }

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/v1/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation, // Add this line
        });

        // Handle the API response here
        console.log(response.data);
      } catch (error) {
        console.error('An error occurred:', error);
      }
},
  },
};
</script>

<style scoped>
.register {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 100%;
}
</style>