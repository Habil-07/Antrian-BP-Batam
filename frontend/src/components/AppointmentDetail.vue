<template>
  <Dialog
    :visible="modelValue"
    @update:visible="$emit('update:modelValue', $event)"
    modal
    :header="'Detail Janji Temu - ' + data?.queue_number"
    :style="{ width: '50vw' }"
    :breakpoints="{ '960px': '75vw', '641px': '90vw' }"
  >
    <div class="appointment-detail p-4">
      <div class="text-center mb-4">
        <h3 class="text-xl font-bold mb-2">BP Batam</h3>
        <p class="text-sm text-gray-600">Sistem Antrian Online</p>
      </div>

      <Divider />

      <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
          <p class="text-lg font-semibold text-center text-blue-600">
            Nomor Antrian: {{ data?.queue_number }}
          </p>
        </div>

        <div>
          <p class="font-semibold">Layanan:</p>
          <p>{{ data?.main_service }}</p>
        </div>

        <div>
          <p class="font-semibold">Sub Layanan:</p>
          <p>{{ data?.sub_service }}</p>
        </div>

        <div>
          <p class="font-semibold">Tanggal:</p>
          <p>{{ formatDate(data?.appointment_date) }}</p>
        </div>

        <div>
          <p class="font-semibold">Jam:</p>
          <p>{{ data?.appointment_time }}</p>
        </div>

        <div class="col-span-2">
          <Divider />
        </div>

        <div>
          <p class="font-semibold">Nama:</p>
          <p>{{ data?.customer_name }}</p>
        </div>

        <div>
          <p class="font-semibold">NIK:</p>
          <p>{{ data?.customer_nik }}</p>
        </div>
      </div>

      <div class="flex justify-center items-center gap-2 mt-6">
        <Button
          label="Simpan PDF"
          icon="pi pi-file-pdf"
          @click="generatePDF"
          severity="secondary"
        />
      </div>
      <div class="mt-4 flex justify-center">
        <p class="text-sm text-gray-600 italic">
          Silakan tunjukkan pesan ini saat kedatangan Anda.
        </p>
      </div>
    </div>
  </Dialog>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import Dialog from 'primevue/dialog'
import Button from 'primevue/button'
import Divider from 'primevue/divider'
import html2pdf from 'html2pdf.js'

const props = defineProps<{
  modelValue: boolean
  data: any
}>()

const emit = defineEmits<{
  'update:modelValue': [value: boolean]
}>()

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('id-ID', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

const generatePDF = () => {
  const element = document.querySelector('.appointment-detail')
  const opt = {
    margin: 1,
    filename: `janji-temu-${props.data?.queue_number}.pdf`,
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
  }
  html2pdf().set(opt).from(element).save()
}
</script>
