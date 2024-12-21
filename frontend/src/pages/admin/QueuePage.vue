<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <Toast />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center mb-6">
        <div class="text-center">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Panel Admin - Antrian Hari Ini</h1>
          <p class="text-gray-600">Kelola antrian dan panggil pengunjung</p>
        </div>
        <div class="flex gap-2">
          <Button
            label="Semua Antrian"
            icon="pi pi-calendar-times"
            severity="info"
            @click="router.push('/admin/all-queue')"
          />
          <Button label="Logout" icon="pi pi-sign-out" severity="danger" @click="handleLogout" />
        </div>
      </div>

      <div class="grid gap-4">
        <Card v-for="(queues, service) in appointments?.data" :key="service" class="shadow-2">
          <template #title>
            <div class="flex items-center justify-between">
              <h2 class="text-xl font-semibold m-0">{{ service }}</h2>
            </div>
          </template>
          <template #content>
            <DataTable :value="queues" stripedRows>
              <Column field="queue_number" header="No. Antrian"></Column>
              <Column field="sub_service" header="Layanan"></Column>
              <Column field="customer_name" header="Nama"></Column>
              <Column field="appointment_time" header="Jam"></Column>
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
                      icon="pi pi-volume-up"
                      severity="info"
                      :disabled="data.status !== 'waiting' && data.status !== 'called'"
                      @click="callQueue(data)"
                      tooltip="Panggil"
                    />
                    <Button
                      icon="pi pi-check"
                      severity="success"
                      :disabled="data.status !== 'called'"
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
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useToast } from 'primevue/usetoast'
import Card from 'primevue/card'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'
import Tag from 'primevue/tag'
import { appointmentService } from '@/services/appointment'
import { speechService } from '@/services/speech'
import { useRouter } from 'vue-router'

const toast = useToast()
const appointments = ref<any>(null)
const isLoading = ref(false)
let refreshInterval: number | null = null
const router = useRouter()

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

const callQueue = async (queue: any) => {
  try {
    await appointmentService.updateStatus(queue.id, 'called')
    toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Antrian dipanggil', life: 3000 })
    await speechService.announceQueue(queue)
    fetchAppointments()
  } catch (error: any) {
    toast.add({ severity: 'error', summary: 'Error', detail: error.message, life: 3000 })
  }
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
    const response = await appointmentService.getAppointments()
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

onMounted(() => {
  fetchAppointments()
  refreshInterval = setInterval(fetchAppointments, 30000)
})

onUnmounted(() => {
  if (refreshInterval) {
    clearInterval(refreshInterval)
  }
})
</script>
