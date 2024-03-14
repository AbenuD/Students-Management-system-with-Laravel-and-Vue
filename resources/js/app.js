import { createApp, h } from "vue";
import { createPinia } from "pinia";
import App from './App.vue';
import axios from "axios";
import router from './router.js';
import { useAuthStore  } from './Src/Store/auth.js';
// import VueExcelEditor from 'vue3-excel-editor'

// const app = createApp(App)
// app.use(VueExcelEditor)
const pinia = createPinia();
const app = createApp({ render: () => h(App) });
app.use(pinia);
app.use(router);
app.use(axios);
const authStore = useAuthStore (); // create your auth store instance
app.provide('authStore', authStore); // provide the store

app.mount('#app');