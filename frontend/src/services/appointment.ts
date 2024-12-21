import api from './api'

interface AppointmentForm {
  main_service: string
  sub_service: string
  appointment_date: string
  appointment_time: string
  customer_name: string
  customer_nik: string
  customer_phone: string
  whatsapp?: string
  queue_prefix: string
}

interface AppointmentResponse {
  status: string
  data: {
    [key: string]: Array<{
      id: number
      main_service: string
      sub_service: string
      queue_number: string
      appointment_time: string
      status: string
    }>
  }
}

export const appointmentService = {
  async create(data: AppointmentForm) {
    try {
      const response = await api.post('/api/appointments', data)
      return response.data
    } catch (error: any) {
      if (error.response) {
        throw new Error(error.response.data.message || 'Terjadi kesalahan')
      }
      throw error
    }
  },

  async getAppointments(): Promise<AppointmentResponse> {
    try {
      const response = await api.get('/api/appointments')
      return response.data
    } catch (error: any) {
      if (error.response) {
        throw new Error(error.response.data.message || 'Terjadi kesalahan')
      }
      throw error
    }
  },

  async updateStatus(id: number, status: string) {
    try {
      const response = await api.put(`/api/appointments/${id}/status`, { status })
      return response.data
    } catch (error: any) {
      if (error.response) {
        throw new Error(error.response.data.message || 'Terjadi kesalahan')
      }
      throw error
    }
  },

  async getTodayQueue(): Promise<AppointmentResponse> {
    try {
      const response = await api.get('/api/appointments/today')
      return response.data
    } catch (error: any) {
      if (error.response) {
        throw new Error(error.response.data.message || 'Terjadi kesalahan')
      }
      throw error
    }
  },

  async getAllQueue(): Promise<AppointmentResponse> {
    try {
      const response = await api.get('/api/appointments/all')
      return response.data
    } catch (error: any) {
      if (error.response) {
        throw new Error(error.response.data.message || 'Terjadi kesalahan')
      }
      throw error
    }
  },
}
