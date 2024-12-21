<template>
  <div>
    <h2>Queue Summary</h2>
    <p>Total Appointments: {{ totalAppointments }}</p>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const totalAppointments = ref(42)
</script>
