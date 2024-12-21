<template>
  <div>
    <h2>Admin Panel</h2>
    <p v-if="!isAuthenticated">Please log in to access admin features.</p>
    <form v-else @submit.prevent="updateQueue">
      <label>
        Current Queue:
        <input v-model="currentQueue" />
      </label>
      <label>
        Next Queue:
        <input v-model="nextQueue" />
      </label>
      <button type="submit">Update Queue</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const isAuthenticated = ref(false)
const currentQueue = ref('')
const nextQueue = ref('')

const updateQueue = () => {
  console.log('Queue Updated:', { currentQueue: currentQueue.value, nextQueue: nextQueue.value })
}
</script>
