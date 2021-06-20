require('./bootstrap')

import { createApp } from 'vue'
import router from './router'
import store from './store'
import App from './App'

const app = createApp(App)
    .use(router)
    .use(store)
    .mount('#app')