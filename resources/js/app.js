import { createApp,h } from "vue";
import App from './App.vue';
import axios from "axios";
import router from './router.js';
// import {toast} from 'vue3-toastify';
// import Toaster from "@meforma/vue-toaster";
import {toast} from 'vue3-toastify';
const app = createApp({render: ()=>h(App)})
app.use(router,toast,axios)
app.mount('#app')   ;


