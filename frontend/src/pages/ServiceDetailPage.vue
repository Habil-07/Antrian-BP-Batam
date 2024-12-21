<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div v-if="isLoading" class="flex justify-center">
        <LoadingSpinner />
      </div>
      <div v-else>
        <div class="text-center my-6">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ serviceName }}</h1>
          <p class="text-gray-600">Detail antrian untuk layanan {{ serviceName }}</p>
        </div>

        <DataTable :value="appointments" stripedRows>
          <Column field="queue_number" header="No. Antrian"></Column>
          <Column field="sub_service" header="Layanan"></Column>
          <Column field="customer_name" header="Nama"></Column>
          <Column field="appointment_date" header="Tanggal">
            <template #body="{ data }">
              {{ formatDate(data.appointment_date) }}
            </template>
          </Column>
          <Column field="appointment_time" header="Jam">
            <template #body="{ data }">
              {{ formatTime(data.appointment_time) }}
            </template>
          </Column>
          <Column field="status" header="Status">
            <template #body="{ data }">
              <Tag :severity="getStatusSeverity(data.status)" :value="getStatusText(data.status)" />
            </template>
          </Column>
        </DataTable>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { appointmentService } from '@/services/appointment'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Tag from 'primevue/tag'
import LoadingSpinner from '@/components/LoadingSpinner.vue'

const route = useRoute()
const serviceName = route.params.serviceName
const isLoading = ref(true)
const appointments = ref<Appointment[]>([])

interface Appointment {
  id: number
  main_service: string
  sub_service: string
  queue_number: string
  appointment_time: string
  status: string
}

interface AppointmentData {
  [key: string]: Appointment[] // Menggunakan tipe Appointment yang sudah didefinisikan
}

interface ApiResponse {
  status: string
  data: AppointmentData
  message?: string
}

const fetchAppointments = async () => {
  try {
    const response: ApiResponse = await appointmentService.getAppointments() // Ganti dengan API yang sesuai
    const serviceName = route.params.serviceName as string // Pastikan serviceName adalah string
    appointments.value = response.data[serviceName] || [] // Pastikan serviceName adalah kunci yang valid
  } catch (error) {
    console.error('Error fetching appointments:', error)
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  fetchAppointments()
})

const formatDate = (date: string) => {
  const options: Intl.DateTimeFormatOptions = {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  }
  return new Date(date).toLocaleDateString('id-ID', options)
}

const formatTime = (time: string) => {
  return time.substring(0, 5) // Ambil hanya jam:menit
}

const getStatusSeverity = (status: string) => {
  const severities = {
    waiting: 'warning',
    called: 'info',
    completed: 'success',
    cancelled: 'danger',
  }
  return severities[status as keyof typeof severities]
}

const getStatusText = (status: string) => {
  const texts = {
    waiting: 'Menunggu',
    called: 'Dipanggil',
    completed: 'Selesai',
    cancelled: 'Dibatalkan',
  }
  return texts[status as keyof typeof texts]
}
</script>
