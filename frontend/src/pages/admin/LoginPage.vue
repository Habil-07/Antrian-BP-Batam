<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Login Admin</h2>
      </div>
      <Card class="shadow-2">
        <template #content>
          <form @submit.prevent="handleSubmit" class="space-y-6">
            <div v-if="loginError" class="p-4 bg-red-50 rounded-lg mb-4">
              <p class="text-red-600 text-sm">{{ loginError }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
              <InputText
                v-model="username"
                class="w-full"
                :class="{ 'p-invalid': submitted && !username }"
                @input="loginError = ''"
              />
              <small class="p-error" v-if="submitted && !username">Username harus diisi</small>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
              <Password
                v-model="password"
                class="w-full"
                :class="{ 'p-invalid': submitted && !password }"
                toggleMask
                @input="loginError = ''"
              />
              <small class="p-error" v-if="submitted && !password">Password harus diisi</small>
            </div>
            <div>
              <Button type="submit" label="Login" class="w-full" :loading="isLoading" />
            </div>
          </form>
        </template>
      </Card>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'
import Card from 'primevue/card'
import InputText from 'primevue/inputtext'
import Password from 'primevue/password'
import Button from 'primevue/button'

const router = useRouter()
const toast = useToast()
const username = ref('')
const password = ref('')
const isLoading = ref(false)
const submitted = ref(false)
const loginError = ref('')

const handleSubmit = async () => {
  submitted.value = true
  loginError.value = ''

  // Validasi form
  if (!username.value || !password.value) {
    return
  }

  try {
    isLoading.value = true
    // Autentikasi sederhana
    if (username.value === 'admin' && password.value === 'admin123') {
      localStorage.setItem('isAdmin', 'true')
      router.push('/admin/queue')
    } else {
      loginError.value = 'Username atau password salah'
    }
  } catch (error: any) {
    loginError.value = error.message
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
.p-password {
  width: 100%;
}
.p-password-input {
  width: 100%;
}
</style>
