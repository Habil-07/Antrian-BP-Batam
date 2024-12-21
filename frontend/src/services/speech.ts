export const speechService = {
  playNotification() {
    return new Promise((resolve) => {
      const audio = new Audio('/src/assets/sounds/notification.mp3')
      audio.volume = 0.5 // Kurangi volume efek suara
      audio.onended = resolve
      audio.play()
    })
  },

  speak(text: string) {
    return new Promise((resolve) => {
      if (!window.speechSynthesis) {
        console.error('Browser tidak mendukung text-to-speech')
        resolve(null)
        return
      }

      window.speechSynthesis.cancel()

      const utterance = new SpeechSynthesisUtterance(text)
      utterance.lang = 'id-ID'
      utterance.rate = 0.9
      utterance.pitch = 1
      utterance.volume = 1 // Volume maksimum

      utterance.onend = () => resolve(null)
      utterance.onerror = (err) => {
        console.error('Speech error:', err)
        resolve(null)
      }

      window.speechSynthesis.speak(utterance)
    })
  },

  async announceQueue(queue: any) {
    try {
      await this.playNotification()
      const announcement = `
        Nomor antrian ${queue.queue_number}, 
        atas nama ${queue.customer_name},
        silakan menuju ${queue.main_service}.
      `.trim()
      await this.speak(announcement)
    } catch (error) {
      console.error('Announcement error:', error)
    }
  },
}
