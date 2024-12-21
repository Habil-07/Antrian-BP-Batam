import { services, getQueuePrefix } from './service'

interface Appointment {
  id: string
  queue_number: string
  main_service: string
  sub_service: string
  appointment_date: string
  appointment_time: string
  name: string
  phone: string
  email: string
  status: 'waiting' | 'called' | 'completed' | 'cancelled'
}

const generateRandomDate = (start: Date, end: Date) => {
  return new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()))
}

const generateRandomTime = () => {
  const times = [
    '08:00',
    '08:30',
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
  return times[Math.floor(Math.random() * times.length)]
}

const generateRandomStatus = () => {
  const statuses: ('waiting' | 'called' | 'completed' | 'cancelled')[] = [
    'waiting',
    'called',
    'completed',
    'cancelled',
  ]
  return statuses[Math.floor(Math.random() * statuses.length)]
}

const generateRandomName = () => {
  const firstNames = ['Budi', 'Siti', 'Ahmad', 'Dewi', 'Rudi', 'Nina', 'Andi', 'Maya']
  const lastNames = ['Santoso', 'Wijaya', 'Kusuma', 'Pratama', 'Sari', 'Putri', 'Hidayat']
  return `${firstNames[Math.floor(Math.random() * firstNames.length)]} ${lastNames[Math.floor(Math.random() * lastNames.length)]}`
}

const generateRandomPhone = () => {
  return `08${Math.floor(Math.random() * 90000000 + 10000000)}`
}

const generateRandomEmail = (name: string) => {
  const domains = ['gmail.com', 'yahoo.com', 'hotmail.com']
  const cleanName = name.toLowerCase().replace(/\s+/g, '.')
  return `${cleanName}@${domains[Math.floor(Math.random() * domains.length)]}`
}

export const generateAppointments = (count: number = 50): Appointment[] => {
  const appointments: Appointment[] = []
  const startDate = new Date()
  const endDate = new Date()
  endDate.setDate(endDate.getDate() + 30)

  for (let i = 0; i < count; i++) {
    const randomService = services[Math.floor(Math.random() * services.length)]
    const randomSubService =
      randomService.subServices[Math.floor(Math.random() * randomService.subServices.length)]
    const name = generateRandomName()

    const appointment: Appointment = {
      id: `APT${Math.random().toString(36).substr(2, 9)}`,
      queue_number: `${getQueuePrefix(randomService.service)}${String(i + 1).padStart(3, '0')}`,
      main_service: randomService.service,
      sub_service: randomSubService,
      appointment_date: generateRandomDate(startDate, endDate).toISOString().split('T')[0],
      appointment_time: generateRandomTime(),
      name: name,
      phone: generateRandomPhone(),
      email: generateRandomEmail(name),
      status: generateRandomStatus(),
    }

    appointments.push(appointment)
  }

  // Urutkan berdasarkan tanggal dan waktu
  return appointments.sort((a, b) => {
    const dateA = new Date(`${a.appointment_date} ${a.appointment_time}`)
    const dateB = new Date(`${b.appointment_date} ${b.appointment_time}`)
    return dateA.getTime() - dateB.getTime()
  })
}

// Contoh penggunaan:
const sampleAppointments = generateAppointments(50)
console.log(sampleAppointments)
