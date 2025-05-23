import './bootstrap';

import { createApp , ref } from 'vue';

import App from './components/App.vue'
import router from './router'
import store from './store'

createApp(App).use(router).use(store).use(ref).mount('#app')
