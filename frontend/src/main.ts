import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import PrimeVue from 'primevue/config'

// Import PrimeVue themes from @primevue/themes
import lara from '@primevue/themes/lara'

// Import core PrimeVue styles and icons
import 'primeicons/primeicons.css'
import './assets/tailwind.css'

// Import PrimeVue components
import Card from 'primevue/card'
import Button from 'primevue/button'
import Dropdown from 'primevue/dropdown'
import Calendar from 'primevue/calendar'
import InputText from 'primevue/inputtext'
import InputMask from 'primevue/inputmask'
import Divider from 'primevue/divider'
import Toast from 'primevue/toast'
import ToastService from 'primevue/toastservice'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Tag from 'primevue/tag'
import Menubar from 'primevue/menubar'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(PrimeVue, { ripple: true, theme: { preset: lara, options: { darkModeSelector: false } } })
app.use(ToastService)

// Register components
app.component('Card', Card)
app.component('Button', Button)
app.component('Dropdown', Dropdown)
app.component('Calendar', Calendar)
app.component('InputText', InputText)
app.component('InputMask', InputMask)
app.component('Divider', Divider)
app.component('Toast', Toast)
app.component('DataTable', DataTable)
app.component('Column', Column)
app.component('Tag', Tag)
app.component('Menubar', Menubar)

app.mount('#app')
