<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-4xl font-bold text-white sm:text-5xl md:text-6xl mb-4">
            Selamat Datang di
            <span class="block text-blue-200">Sistem Antrian BP Batam</span>
          </h1>
          <p class="mt-3 text-xl text-blue-100">
            Layanan antrian online untuk memudahkan pelayanan Anda di BP Batam
          </p>
        </div>
      </div>
    </div>

    <!-- Feature Section -->
    <div class="py-12 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Card Buat Janji -->
          <Card class="shadow-2">
            <template #header>
              <div class="flex items-center justify-center">
                <i class="pi pi-calendar text-4xl text-blue-600"></i>
              </div>
            </template>
            <template #title>
              <h3 class="text-xl font-medium text-center text-gray-900">Buat Janji Temu</h3>
            </template>
            <template #content>
              <p class="text-center mb-4 text-gray-600">
                Buat janji temu dengan mudah dan cepat tanpa perlu mengantri
              </p>
              <div class="flex justify-center">
                <Button
                  label="Buat Janji"
                  icon="pi pi-calendar-plus"
                  @click="$router.push('/appointment')"
                  severity="primary"
                  raised
                />
              </div>
            </template>
          </Card>

          <!-- Card Lihat Antrian -->
          <Card class="shadow-2">
            <template #header>
              <div class="flex items-center justify-center">
                <i class="pi pi-list text-4xl text-blue-600"></i>
              </div>
            </template>
            <template #title>
              <h3 class="text-xl font-medium text-center text-gray-900">Lihat Antrian</h3>
            </template>
            <template #content>
              <p class="text-center mb-4 text-gray-600">
                Pantau status antrian secara real-time untuk semua layanan
              </p>
              <div class="flex justify-center">
                <Button
                  label="Lihat Antrian"
                  icon="pi pi-eye"
                  @click="$router.push('/queue')"
                  severity="primary"
                  raised
                />
              </div>
            </template>
          </Card>

          <!-- Card Admin -->
          <Card class="shadow-2">
            <template #header>
              <div class="flex items-center justify-center">
                <i class="pi pi-cog text-4xl text-blue-600"></i>
              </div>
            </template>
            <template #title>
              <h3 class="text-xl font-medium text-center text-gray-900">Area Admin</h3>
            </template>
            <template #content>
              <p class="text-center mb-4 text-gray-600">
                Kelola antrian dan janji temu di area admin
              </p>
              <div class="flex justify-center">
                <Button
                  label="Login Admin"
                  icon="pi pi-sign-in"
                  @click="$router.push('/admin/login')"
                  severity="primary"
                  raised
                />
              </div>
            </template>
          </Card>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
const router = useRouter()
</script>
