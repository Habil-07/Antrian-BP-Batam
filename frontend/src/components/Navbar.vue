<template>
  <nav
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    :class="{
      'bg-white/80 backdrop-blur-md shadow-lg': isScrolled,
      'bg-white shadow-lg': !isScrolled,
    }"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-20">
        <!-- Logo dan Brand -->
        <div class="flex items-center">
          <router-link to="/" class="flex items-center">
            <img class="w-32 sm:w-48" src="@/assets/cropped-BP-Batam-Logo-Blue.png" alt="Logo" />
          </router-link>
        </div>

        <!-- Tombol hamburger untuk mobile -->
        <div class="flex items-center md:hidden">
          <button @click="isOpen = !isOpen" class="text-gray-700 hover:text-blue-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path
                v-if="!isOpen"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
              <path
                v-if="isOpen"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>

        <!-- Menu Navigasi Desktop -->
        <div class="hidden md:flex items-center space-x-4 py-4">
          <router-link
            v-for="(item, index) in menuItems"
            :key="index"
            :to="item.path"
            class="text-gray-700 hover:text-blue-600 px-5 py-3 rounded-md text-md font-medium"
            :class="{ 'text-blue-600': $route.path === item.path }"
          >
            {{ item.name }}
          </router-link>
        </div>
      </div>

      <!-- Menu Mobile -->
      <div v-show="isOpen" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
          <router-link
            v-for="(item, index) in menuItems"
            :key="index"
            :to="item.path"
            class="block text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-base font-medium"
            :class="{ 'text-blue-600': $route.path === item.path }"
            @click="isOpen = false"
          >
            {{ item.name }}
          </router-link>
        </div>
      </div>
    </div>
  </nav>

  <!-- Spacer untuk kompensasi navbar fixed -->
  <div class="h-16"></div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import Button from 'primevue/button'

const router = useRouter()
const route = useRoute()
const isOpen = ref(false)
const isScrolled = ref(false)

const menuItems = [
  { name: 'Beranda', path: '/' },
  { name: 'Buat Janji', path: '/appointment' },
  { name: 'Antrian', path: '/queue' },
  { name: 'Admin', path: '/admin/queue' },
]

const handleScroll = () => {
  isScrolled.value = window.scrollY > 0
}

const handleLogout = () => {
  localStorage.removeItem('isAdmin') // Hapus status login
  router.push('/admin/login') // Arahkan ke halaman login
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
/* Tambahkan gaya sesuai kebutuhan */
</style>
