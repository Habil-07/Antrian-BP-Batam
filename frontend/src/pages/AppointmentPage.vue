<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <Toast />
    <AppointmentDetail v-model="showDetailModal" :data="appointmentDetail" />

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <Card class="shadow-2">
        <template #title>
          <div class="flex items-center justify-between mb-6">
            <div>
              <h2 class="text-3xl font-bold text-gray-900">Buat Janji Temu</h2>
              <p class="mt-1 text-sm text-gray-600">
                Silahkan isi form di bawah ini untuk membuat janji temu
              </p>
            </div>
          </div>
        </template>

        <template #content>
          <form @submit.prevent="handleSubmit" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Layanan -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
                <Dropdown
                  v-model="selectedService"
                  :options="services"
                  optionLabel="service"
                  placeholder="Pilih layanan"
                  class="w-full"
                  @change="handleServiceChange"
                />
              </div>

              <!-- Sub Layanan -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sub Layanan</label>
                <Dropdown
                  v-model="formData.subService"
                  :options="selectedService?.subServices"
                  placeholder="Pilih sub layanan"
                  class="w-full"
                  :disabled="!selectedService"
                  @change="handleSubServiceChange"
                />
              </div>

              <!-- Tanggal -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <Calendar
                  v-model="formData.date"
                  :minDate="new Date()"
                  :showIcon="true"
                  dateFormat="dd/mm/yy"
                  placeholder="Pilih tanggal"
                  class="w-full"
                  :manualInput="false"
                  :showButtonBar="true"
                  :firstDayOfWeek="1"
                  :locale="id"
                />
              </div>

              <!-- Waktu -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
                <Dropdown
                  v-model="formData.time"
                  :options="availableTimes"
                  placeholder="Pilih waktu"
                  class="w-full"
                />
              </div>
            </div>

            <Divider align="center">
              <Tag value="Data Diri" severity="info" />
            </Divider>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Nama -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <InputText
                  v-model="formData.name"
                  placeholder="Masukkan nama lengkap"
                  class="w-full"
                />
              </div>

              <!-- NIK -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                <InputMask
                  v-model="formData.nik"
                  mask="9999999999999999"
                  placeholder="Masukkan NIK"
                  class="w-full"
                />
              </div>

              <!-- No Telepon -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                <InputText
                  v-model="formData.phone"
                  placeholder="Masukkan no. telepon"
                  class="w-full"
                />
              </div>

              <!-- WhatsApp -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >WhatsApp (Opsional)</label
                >
                <InputText
                  v-model="formData.whatsapp"
                  placeholder="Masukkan no. WhatsApp"
                  class="w-full"
                />
              </div>
            </div>

            <div class="flex justify-end mt-6">
              <Button
                type="submit"
                :label="isLoading ? 'Memproses...' : 'Buat Janji Temu'"
                :loading="isLoading"
                icon="pi pi-check"
                severity="primary"
                raised
              />
            </div>
          </form>
        </template>
      </Card>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import Card from 'primevue/card'
import Button from 'primevue/button'
import Dropdown from 'primevue/dropdown'
import Calendar from 'primevue/calendar'
import InputText from 'primevue/inputtext'
import InputMask from 'primevue/inputmask'
import Divider from 'primevue/divider'
import Toast from 'primevue/toast'
import { useToast } from 'primevue/usetoast'
import { services, getQueuePrefix } from '@/services/service'
import { appointmentService } from '@/services/appointment'
import AppointmentDetail from '@/components/AppointmentDetail.vue'

const selectedService = ref<any>(null)
const formData = ref({
  mainService: '',
  subService: '',
  date: null,
  time: '',
  name: '',
  nik: '',
  phone: '',
  whatsapp: '',
  notes: '',
  queuePrefix: '',
})

const availableTimes = [
  '09:00',
  '09:30',
  '10:00',
  '10:30',
  '11:00',
  '11:30',
  '13:00',
  '13:30',
  '14:00',
  '14:30',
  '15:00',
  '15:30',
]

// Konfigurasi Calendar
const calendarSettings = {
  firstDayOfWeek: 1,
  dayNames: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
  dayNamesShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
  dayNamesMin: ['Mi', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
  monthNames: [
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember',
  ],
  monthNamesShort: [
    'Jan',
    'Feb',
    'Mar',
    'Apr',
    'Mei',
    'Jun',
    'Jul',
    'Agu',
    'Sep',
    'Okt',
    'Nov',
    'Des',
  ],
  today: 'Hari ini',
  clear: 'Bersihkan',
  dateFormat: 'dd/mm/yy',
  weekHeader: 'Mg',
}

const handleServiceChange = () => {
  formData.value.subService = ''
  if (selectedService.value) {
    formData.value.mainService = selectedService.value.service
  }
}

const handleSubServiceChange = () => {
  if (formData.value.subService) {
    formData.value.queuePrefix = getQueuePrefix(formData.value.subService)
  }
}

const isLoading = ref(false)
const toast = useToast()

const appointmentDetail = ref<any>(null)
const showDetailModal = ref(false)

const handleSubmit = async () => {
  try {
    isLoading.value = true

    // Validasi form tetap sama...

    const response = await appointmentService.create({
      main_service: formData.value.mainService,
      sub_service: formData.value.subService,
      appointment_date: formData.value.date,
      appointment_time: formData.value.time,
      customer_name: formData.value.name,
      customer_nik: formData.value.nik,
      customer_phone: formData.value.phone,
      whatsapp: formData.value.whatsapp,
      queue_prefix: formData.value.queuePrefix,
    })

    // Tampilkan modal detail appointment
    appointmentDetail.value = response.data
    showDetailModal.value = true

    // Reset form
    formData.value = {
      mainService: '',
      subService: '',
      date: null,
      time: '',
      name: '',
      nik: '',
      phone: '',
      whatsapp: '',
      notes: '',
      queuePrefix: '',
    }
    selectedService.value = null
  } catch (error: any) {
    toast.add({
      severity: 'error',
      summary: 'Error',
      detail: error.message,
      life: 3000,
    })
  } finally {
    isLoading.value = false
  }
}
</script>
