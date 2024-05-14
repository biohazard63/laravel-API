import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/home', // Ajoutez cette nouvelle route
      name: 'homepage',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/Login.vue')
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../views/Dashboard.vue')
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/Register.vue')
    },
    {
      path: '/user-management',
      name: 'user-management',
      component: () => import('../views/UserManagement.vue')
    },
    {
      path: '/product-management',
      name: 'product-management',
      component: () => import('../views/ProductManagement.vue')
    },
    {
      path: '/product-edit/:id',
      name: 'product-edit',
      component: () => import('../views/ProductEdit.vue')
    },
    {
      path: '/category-management',
      name: 'category-management',
      component: () => import('../views/CategorieManagement.vue')
    },
    {
      path: '/category-edit/:id',
      name: 'category-edit',
      component: () => import('../views/CategoryEdit.vue')
    },
    {
      path: '/profil/',
      name: 'profile',
      component: () => import('@/views/Profil.vue')
    },
    {
      path: '/product-list',
      name: 'product-list',
      component: () => import('@/views/ProductList.vue')
    },
    {
      path: '/order-management',
        name: 'order-management',
        component: () => import('@/views/OrderManagement.vue')
    }
  ]
})

export default router
