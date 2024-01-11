import { createApp } from "vue";
import App from './App.vue';
import router from './router.js';
import Toaster from 'vue3-toastify';

const app = createApp(App)
app.use(router,Toaster);
app.mount('#app')   ;


