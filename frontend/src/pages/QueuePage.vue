<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Antrian BP Batam</h1>
        <p class="text-gray-600">Status antrian saat ini untuk setiap layanan</p>
      </div>

      <!-- Data Mode Toggle -->
      <div class="flex justify-center gap-2 mb-4">
        <Button
          @click="dataMode = 'today'"
          :outlined="dataMode !== 'today'"
          severity="secondary"
          icon="pi pi-calendar"
          label="Hari Ini"
        />
        <Button
          @click="dataMode = 'all'"
          :outlined="dataMode !== 'all'"
          severity="secondary"
          icon="pi pi-calendar-times"
          label="Semua"
        />
      </div>

      <!-- View Mode Toggle -->
      <div class="flex justify-center gap-2 mb-6">
        <Button
          @click="viewMode = 'scroll'"
          :outlined="viewMode !== 'scroll'"
          severity="primary"
          icon="pi pi-list"
          label="Mode Scroll"
        />
        <Button
          @click="viewMode = 'carousel'"
          :outlined="viewMode !== 'carousel'"
          severity="primary"
          icon="pi pi-images"
          label="Mode Carousel"
        />
      </div>

      <!-- Scroll Mode -->
      <div v-if="viewMode === 'scroll'" class="grid gap-4">
        <Card v-for="(queues, service) in groupedQueues" :key="service" class="shadow-2">
          <template #title>
            <div class="flex align-items-center justify-content-between py-2">
              <h2 class="text-xl font-semibold m-0">{{ service }}</h2>
            </div>
          </template>
          <template #content>
            <DataTable :value="queues" stripedRows>
              <Column field="queue_number" header="No. Antrian"></Column>
              <Column field="sub_service" header="Layanan"></Column>
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
                  <Tag
                    :severity="getStatusSeverity(data.status)"
                    :value="getStatusText(data.status)"
                  />
                </template>
              </Column>
            </DataTable>
          </template>
        </Card>
      </div>

      <!-- Carousel Mode -->
      <div v-else>
        <Card class="shadow-2">
          <template #title>
            <div class="flex items-center justify-between py-2">
              <Button icon="pi pi-chevron-left" @click="prevService" text />
              <div class="flex align-items-center">
                <h2 class="text-xl font-semibold my-auto">
                  {{ currentService }}
                </h2>
              </div>
              <Button icon="pi pi-chevron-right" @click="nextService" text />
            </div>
          </template>
          <template #content>
            <DataTable :value="currentQueues" stripedRows>
              <Column field="queue_number" header="No. Antrian"></Column>
              <Column field="sub_service" header="Layanan"></Column>
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
                  <Tag
                    :severity="getStatusSeverity(data.status)"
                    :value="getStatusText(data.status)"
                  />
                </template>
              </Column>
            </DataTable>
          </template>
        </Card>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch, onUnmounted } from 'vue'
import { appointmentService } from '@/services/appointment'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Tag from 'primevue/tag'

const appointments = ref([])
const isLoading = ref(true)
const error = ref('')
const viewMode = ref('scroll')
const currentServiceIndex = ref(0)
const dataMode = ref('today')

// Group appointments by main service
const groupedQueues = computed(() => {
  if (!appointments.value?.data) return {}
  return appointments.value.data
})

// Status styling
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

// Fetch appointments
const fetchAppointments = async () => {
  try {
    isLoading.value = true
    // await appointmentService.getAllQueue()
    const response =
      dataMode.value === 'today'
        ? await appointmentService.getTodayQueue()
        : await appointmentService.getAllQueue()

    if (response.status === 'success') {
      appointments.value = response
    } else {
      throw new Error(response.message || 'Gagal mengambil data antrian')
    }
  } catch (err: any) {
    error.value = err.message
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  fetchAppointments()
  // Refresh data every 30 seconds
  setInterval(fetchAppointments, 30000)
})

// Watch perubahan dataMode untuk refresh data
watch(dataMode, () => {
  fetchAppointments()
})

// Carousel logic
const servicesList = computed(() => Object.keys(groupedQueues.value))

const currentService = computed(() => {
  if (servicesList.value.length === 0) return ''
  return servicesList.value[currentServiceIndex.value]
})

const currentQueues = computed(() => {
  if (!currentService.value) return []
  return groupedQueues.value[currentService.value] || []
})

const nextService = () => {
  if (currentServiceIndex.value < servicesList.value.length - 1) {
    currentServiceIndex.value++
  } else {
    currentServiceIndex.value = 0
  }
}

const prevService = () => {
  if (currentServiceIndex.value > 0) {
    currentServiceIndex.value--
  } else {
    currentServiceIndex.value = servicesList.value.length - 1
  }
}

// Auto rotate carousel every 10 seconds when in carousel mode
let carouselInterval: number | null = null

watch(viewMode, (newMode) => {
  if (newMode === 'carousel') {
    carouselInterval = setInterval(nextService, 10000)
  } else {
    if (carouselInterval) {
      clearInterval(carouselInterval)
    }
  }
})

onUnmounted(() => {
  if (carouselInterval) {
    clearInterval(carouselInterval)
  }
})

// Tambahkan fungsi format tanggal dan waktu
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
</script>
