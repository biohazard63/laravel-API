<template>
  <form @submit.prevent="updateProduct" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <div class="mb-4">
      <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom du produit</label>
      <input
        id="name"
        v-model="product.name"
        type="text"
        required
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
      />
    </div>

    <div class="mb-4">
      <label for="description" class="block text-gray-700 text-sm font-bold mb-2"
        >Description du produit</label
      >
      <input
        id="description"
        v-model="product.description"
        type="text"
        required
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
      />
    </div>

    <div class="mb-4">
      <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Prix du produit</label>
      <input
        id="price"
        v-model="product.price"
        type="number"
        required
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
      />
    </div>

    <div class="mb-4">
      <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock du produit</label>
      <input
        id="stock"
        v-model="product.stock"
        type="number"
        required
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
      />
    </div>

    <div class="mb-4">
      <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image du produit</label>
      <input
        id="image"
        type="file"
        @change="onFileChange"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
      />
    </div>

    <div class="mb-4">
      <label for="category" class="block text-gray-700 text-sm font-bold mb-2"
        >Catégorie du produit</label
      >
      <input
        id="category"
        v-model="product.category_id"
        type="number"
        required
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
      />
    </div>

    <div class="flex items-center justify-between">
      <button
        type="submit"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
      >
        Mettre à jour le produit
      </button>
    </div>
  </form>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      product: {
        name: '',
        description: '',
        price: 0,
        stock: 0,
        image: '',
        category_id: 0
      },
      selectedImage: null
    }
  },
  async created() {
    const productId = this.$route.params.id
    const response = await axios.get(`http://127.0.0.1:8000/api/v1/products/${productId}`)
    this.product = response.data
  },
  methods: {
    onFileChange(e) {
      this.selectedImage = e.target.files[0]
      console.log(this.selectedImage)
    },
   async updateProduct() {
  const productId = this.$route.params.id
  try {
    let imageUrl = this.product.image
    if (this.selectedImage) {
      const imageFormData = new FormData()
      imageFormData.append('image', this.selectedImage, this.selectedImage.name)

      const imageResponse = await axios.post(`http://127.0.0.1:8000/api/v1/upload`, imageFormData)
      imageUrl = imageResponse.data.url
    }

    const productData = {
      name: this.product.name,
      description: this.product.description,
      price: this.product.price,
      stock: this.product.stock,
      category_id: this.product.category_id,
      image: imageUrl
    }

    await axios.put(`http://127.0.0.1:8000/api/v1/products/${productId}`, productData)
    this.$router.push({ name: 'product-management' })
  } catch (error) {
    console.error('An error occurred:', error)
  }
}
  }
}
</script>
