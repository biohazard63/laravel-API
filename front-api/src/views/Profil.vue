<template>
  <div>
    <h1>Profil de l'utilisateur</h1>

    <div v-if="user">
      <p><strong>Nom:</strong> {{ user.name }}</p>
      <p><strong>Email:</strong> {{ user.email }}</p>
      <!-- Ajoutez ici d'autres informations de profil que vous souhaitez afficher -->
    </div>
    <div v-else>
      <p>Chargement...</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      user: null,
    };
  },
  async created() {
    const userId = localStorage.getItem('userId');
    console.log('User ID from local storage:', userId); // Ajout du console.log ici
    if (userId) {
      await this.loadUserProfile(userId);
    }
  },
  methods: {
    async loadUserProfile(userId) {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/v1/users/${userId}`);
        this.user = response.data;
      } catch (error) {
        console.error('An error occurred:', error);
      }
    },
  },
};
</script><style scoped>
div {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 80%;
}
</style>