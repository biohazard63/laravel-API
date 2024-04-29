<template>
  <div class="flex items-center justify-center">
    <button @click="prevPage" :disabled="currentPage <= 1">Prev</button>
    <div>Page: {{ currentPage }}</div>
    <button @click="nextPage" :disabled="currentPage >= totalPage">Next</button>
  </div>
</template>

<script>
export default {
    props: {
        totalPage: {
            type: Number,
            required: true
        },
        currentPage: {
            type: Number,
            required: true
        }
    },
    methods: {
        nextPage() {
            if (this.currentPage < this.totalPage) {
                this.$emit('update:currentPage', this.currentPage + 1);
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.$emit('update:currentPage', this.currentPage - 1);
            }
        }
    }
}
</script>
