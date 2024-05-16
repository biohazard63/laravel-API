<template>
  <div class="flex justify-center items-center h-screen">
    <div class="w-3/4">
      <h1 class="text-2xl font-bold mb-5 text-center">Gestion des utilisateurs</h1>
      <table class="w-full text-left border-collapse">
        <thead>
          <tr>
            <th class="py-4 px-6 bg-blue-500 text-white uppercase">Nom</th>
            <th class="py-4 px-6 bg-blue-500 text-white uppercase">Email</th>
            <th class="py-4 px-6 bg-blue-500 text-white uppercase">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="text-gray-700">
            <td class="py-4 px-6 border-b">{{ user.name }}</td>
            <td class="py-4 px-6 border-b">{{ user.email }}</td>
            <td class="py-4 px-6 border-b">
              <button
                @click="deleteUser(user.id)"
                class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded"
              >
                Supprimer
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      users: []
    }
  },
  created() {
    this.loadUsers()
  },
  methods: {
    loadUsers() {
      axios.get('http://127.0.0.1:8000/api/v1/users')
        .then(response => this.users = response.data)
        .catch(error => console.error('An error occurred:', error))
    },
    deleteUser(userId) {
      axios.delete(`http://127.0.0.1:8000/api/v1/users/${userId}`)
        .then(() => this.loadUsers())
        .catch(error => console.error('An error occurred:', error))
    }
  }
}
</script>
