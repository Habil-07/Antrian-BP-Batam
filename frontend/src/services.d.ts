declare module '../services.js' {
  const services: {
    category: string
    items: {
      name: string
      services: string[]
    }[]
  }[]
  export default services
}
