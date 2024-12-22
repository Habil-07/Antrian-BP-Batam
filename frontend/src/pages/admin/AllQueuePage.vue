<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <Toast />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center my-6">
        <div class="text-center">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Panel Admin - Semua Antrian</h1>
          <p class="text-gray-600">Kelola semua antrian berdasarkan tanggal</p>
        </div>
        <div class="flex gap-2">
          <Button
            label="Antrian Hari Ini"
            icon="pi pi-calendar"
            severity="info"
            @click="router.push('/admin/queue')"
          />
          <Button label="Logout" icon="pi pi-sign-out" severity="danger" @click="handleLogout" />
        </div>
      </div>
      <div v-if="isLoading" class="flex justify-center">
        <LoadingSpinner />
      </div>
      <div v-else>
        <div class="grid gap-4">
          <Card v-for="(queues, service) in appointments?.data" :key="service" class="shadow-2">
            <template #title>
              <div class="flex items-center justify-between">
                <RouterLink :to="{ name: 'AdminServiceDetail', params: { serviceName: service } }">
                  <h2 class="text-xl font-semibold m-0">{{ service }}</h2>
                </RouterLink>
              </div>
            </template>
            <template #content>
              <DataTable :value="queues" stripedRows>
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
                    <Tag
                      :severity="getStatusSeverity(data.status)"
                      :value="getStatusText(data.status)"
                    />
                  </template>
                </Column>
                <Column header="Aksi">
                  <template #body="{ data }">
                    <div class="flex gap-2">
                      <Button
                        icon="pi pi-check"
                        severity="success"
                        :disabled="data.status === 'completed' || data.status === 'cancelled'"
                        @click="completeQueue(data)"
                        tooltip="Selesai"
                      />
                      <Button
                        icon="pi pi-times"
                        severity="danger"
                        :disabled="data.status === 'completed' || data.status === 'cancelled'"
                        @click="cancelQueue(data)"
                        tooltip="Batalkan"
                      />
                    </div>
                  </template>
                </Column>
              </DataTable>
            </template>
          </Card>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useToast } from 'primevue/usetoast'
import { useRouter } from 'vue-router'
import Card from 'primevue/card'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'
import Tag from 'primevue/tag'
import { appointmentService } from '@/services/appointment'
import LoadingSpinner from '@/components/LoadingSpinner.vue'

const toast = useToast()
const router = useRouter()
const appointments = ref()
const isLoading = ref(true)
let refreshInterval: number | null = null

// Reuse fungsi yang sama dari QueuePage
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

const completeQueue = async (queue: any) => {
  try {
    await appointmentService.updateStatus(queue.id, 'completed')
    toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Antrian selesai', life: 3000 })
    fetchAppointments()
  } catch (error: any) {
    toast.add({ severity: 'error', summary: 'Error', detail: error.message, life: 3000 })
  }
}

const cancelQueue = async (queue: any) => {
  try {
    await appointmentService.updateStatus(queue.id, 'cancelled')
    toast.add({
      severity: 'success',
      summary: 'Berhasil',
      detail: 'Antrian dibatalkan',
      life: 3000,
    })
    fetchAppointments()
  } catch (error: any) {
    toast.add({ severity: 'error', summary: 'Error', detail: error.message, life: 3000 })
  }
}

const fetchAppointments = async () => {
  try {
    isLoading.value = true
    const response = await appointmentService.getAllQueue()
    appointments.value = response
  } catch (error: any) {
    toast.add({ severity: 'error', summary: 'Error', detail: error.message, life: 3000 })
  } finally {
    isLoading.value = false
  }
}

const handleLogout = () => {
  localStorage.removeItem('isAdmin')
  router.push('/admin/login')
}

const formatDate = (date: string) => {
  const options: Intl.DateTimeFormatOptions = {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  }
  return new Date(date).toLocaleDateString('id-ID', options)
}

const formatTime = (time: string) => {
  return time.substring(0, 5)
}

onMounted(() => {
  fetchAppointments()
  refreshInterval = setInterval(fetchAppointments, 60000)
})

onUnmounted(() => {
  if (refreshInterval) {
    clearInterval(refreshInterval)
  }
})
</script>
