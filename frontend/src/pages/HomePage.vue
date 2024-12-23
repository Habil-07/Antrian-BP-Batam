<template>
  <div class="min-h-screen bg-gray-50">
    <div class="container mx-auto py-8">
      <!-- Hero Section -->
      <div
        class="bg-cover bg-right rounded-lg shadow-lg overflow-hidden"
        :style="{ backgroundImage: `url(${bgImage})` }"
      >
        <div class="bg-gradient-to-r from-blue-600/80 to-blue-800/80 py-20 md:py-32">
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
      </div>

      <!-- Feature Section -->
      <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card Buat Janji -->
            <Card class="transform hover:scale-105 transition-transform duration-300 shadow-lg">
              <template #header>
                <div
                  class="flex items-center justify-center p-4 bg-gradient-to-r from-blue-500 to-blue-600"
                >
                  <i class="pi pi-calendar text-4xl text-white"></i>
                </div>
              </template>
              <template #title>
                <h3 class="text-xl font-medium text-center text-gray-900">Buat Janji Temu</h3>
              </template>
              <template #content>
                <p class="text-center mb-6 text-gray-600">
                  Buat janji temu dengan mudah dan cepat tanpa perlu mengantri
                </p>
                <div class="flex justify-center">
                  <Button
                    label="Buat Janji"
                    icon="pi pi-calendar-plus"
                    @click="$router.push('/appointment')"
                    severity="primary"
                    raised
                    class="w-full"
                  />
                </div>
              </template>
            </Card>

            <!-- Card Lihat Antrian -->
            <Card class="transform hover:scale-105 transition-transform duration-300 shadow-lg">
              <template #header>
                <div
                  class="flex items-center justify-center p-4 bg-gradient-to-r from-blue-500 to-blue-600"
                >
                  <i class="pi pi-list text-4xl text-white"></i>
                </div>
              </template>
              <template #title>
                <h3 class="text-xl font-medium text-center text-gray-900">Lihat Antrian</h3>
              </template>
              <template #content>
                <p class="text-center mb-6 text-gray-600">
                  Pantau status antrian secara real-time untuk semua layanan
                </p>
                <div class="flex justify-center">
                  <Button
                    label="Lihat Antrian"
                    icon="pi pi-eye"
                    @click="$router.push('/queue')"
                    severity="primary"
                    raised
                    class="w-full"
                  />
                </div>
              </template>
            </Card>

            <!-- Card Admin -->
            <Card class="transform hover:scale-105 transition-transform duration-300 shadow-lg">
              <template #header>
                <div
                  class="flex items-center justify-center p-4 bg-gradient-to-r from-blue-500 to-blue-600"
                >
                  <i class="pi pi-cog text-4xl text-white"></i>
                </div>
              </template>
              <template #title>
                <h3 class="text-xl font-medium text-center text-gray-900">Area Admin</h3>
              </template>
              <template #content>
                <p class="text-center mb-6 text-gray-600">
                  Kelola antrian pengunjung dan janji temu di admin area
                </p>
                <div class="flex justify-center">
                  <Button
                    label="Login Admin"
                    icon="pi pi-sign-in"
                    @click="$router.push('/admin/login')"
                    severity="primary"
                    raised
                    class="w-full"
                  />
                </div>
              </template>
            </Card>
          </div>
        </div>
      </div>

      <!-- Contact & Map Section -->
      <div class="bg-white py-16 rounded-lg shadow-lg mt-12">
        <div class="container mx-auto px-4">
          <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Kunjungi Kami</h2>
            <p class="text-lg text-gray-600">Temukan lokasi dan informasi kontak kami</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <!-- Contact Info -->
            <div
              class="space-y-6 p-8 bg-gray-50 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300"
            >
              <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Kontak</h3>

              <div class="flex items-start space-x-4">
                <div class="bg-blue-100 p-3 rounded-full">
                  <i class="pi pi-map-marker text-blue-600 text-xl"></i>
                </div>
                <div>
                  <h4 class="font-medium text-gray-900">Alamat</h4>
                  <p class="text-gray-600">
                    Jl. Jenderal Ibnu Sutowo No. 1 Batam Centre,<br />
                    Batam, Kepulauan Riau, Indonesia
                  </p>
                </div>
              </div>

              <div class="flex items-start space-x-4">
                <div class="bg-blue-100 p-3 rounded-full">
                  <i class="pi pi-phone text-blue-600 text-xl"></i>
                </div>
                <div>
                  <h4 class="font-medium text-gray-900">Telepon</h4>
                  <p class="text-gray-600">+62778-462 047 / 462 048</p>
                </div>
              </div>

              <div class="flex items-start space-x-4">
                <div class="bg-blue-100 p-3 rounded-full">
                  <i class="pi pi-clock text-blue-600 text-xl"></i>
                </div>
                <div>
                  <h4 class="font-medium text-gray-900">Jam Operasional</h4>
                  <p class="text-gray-600">Senin - Jumat: 08:00 - 16:00 WIB</p>
                  <p class="text-gray-600">Sabtu - Minggu: Tutup</p>
                </div>
              </div>

              <div class="flex items-start space-x-4">
                <div class="bg-blue-100 p-3 rounded-full">
                  <i class="pi pi-envelope text-blue-600 text-xl"></i>
                </div>
                <div>
                  <h4 class="font-medium text-gray-900">Email</h4>
                  <p class="text-gray-600">humas@bpbatam.go.id</p>
                </div>
              </div>
            </div>

            <!-- Map -->
            <div
              class="h-[400px] rounded-xl overflow-hidden shadow-lg transform hover:scale-[1.02] transition-transform duration-300"
            >
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.0579151036127!2d104.0589167!3d1.1305556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d98921856ddf41%3A0x6e2e6b7c3142716d!2sBP%20Batam!5e0!3m2!1sen!2sid!4v1680000000000!5m2!1sen!2sid"
                width="100%"
                height="100%"
                style="border: 0"
                allowfullscreen="true"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import bgImage from '@/assets/bg-batam.jpg'

</script>
