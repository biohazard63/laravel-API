<template>
  <div>
    <div class="container">
    <h1>Gestion des utilisateurs</h1>
    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>
<!--            <router-link :to="{ name: 'profile', params: { id: user.id }}">Modifier</router-link>-->
            <button @click="deleteUser(user.id)">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      users: [],
    };
  },
  async created() {
    await this.loadUsers();
  },
  methods: {
    async loadUsers() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/v1/users');
        this.users = response.data;
      } catch (error) {
        console.error('An error occurred:', error);
      }
    },
    async deleteUser(userId) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/v1/users/${userId}`);
        await this.loadUsers(); // Recharge les utilisateurs après la suppression
      } catch (error) {
        console.error('An error occurred:', error);
      }
    },
  },
};
</script>

<style scoped >
div {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 80%;
}
.container {
  margin: 0 20px;
  display: flex;
  flex-direction: column;
  width: 30rem;

}
table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  transition: 0.3s;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

th, td {
  padding: 15px;
  text-align: left;
  transition: 0.3s;
}

th {
  background-color: #007BFF;
  color: white;
}

td {
  background-color: #f3f3f3;
  color: #333;
}

tr:hover td {
  background-color: #edf2fa;
}

/* Pour les écrans de taille moyenne (tablette) */
@media (min-width: 600px) {
  table {
    width: 75%;
  }
}

/* Pour les grands écrans (ordinateur de bureau) */
@media (min-width: 900px) {
  table {
    width: 50%;
  }
}
</style >