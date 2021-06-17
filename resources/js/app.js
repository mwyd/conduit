require('./bootstrap');

window.Vue = require('vue')

import App from './components/App'

const app = Vue.createApp(App)
app.mount('#app')