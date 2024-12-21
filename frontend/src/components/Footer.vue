<template>
  <footer class="bg-gray-100 shadow-lg mt-8 border-t border-gray-200">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col items-center md:flex-row md:justify-between">
        <!-- Logo dan Copyright -->
        <div class="flex items-center mb-4 md:mb-0">
          <img src="@/assets/cropped-BP-Batam-Logo-Blue.png" alt="BP Batam Logo" class="h-8 mr-3" />
          <span class="text-gray-600 text-sm">
            © {{ new Date().getFullYear() }} BP Batam. All rights reserved.
          </span>
        </div>

        <!-- Links -->
        <div class="flex space-x-6">
          <a
            href="https://www.bpbatam.go.id"
            target="_blank"
            class="text-gray-600 hover:text-blue-600 text-sm flex items-center gap-1"
          >
            <i class="pi pi-globe"></i>
            Website
          </a>
          <a
            href="https://www.instagram.com/bp_batam"
            target="_blank"
            class="text-gray-600 hover:text-blue-600 text-sm flex items-center gap-1"
          >
            <i class="pi pi-instagram"></i>
            Instagram
          </a>
          <a
            href="https://www.facebook.com/bpbatam"
            target="_blank"
            class="text-gray-600 hover:text-blue-600 text-sm flex items-center gap-1"
          >
            <i class="pi pi-facebook"></i>
            Facebook
          </a>
          <a
            href="https://github.com/helwyza-f/Antrian-BP-Batam.git"
            target="_blank"
            class="text-gray-600 hover:text-blue-600 text-sm flex items-center gap-1"
          >
            <i class="pi pi-github"></i>
            Github Author
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>
