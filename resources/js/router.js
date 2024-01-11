import { createRouter, createWebHashHistory } from "vue-router";
import Welcome from './Pages/Welcome.vue';
import Register from './Pages/Register.vue';


const router = createRouter({
    history: createWebHashHistory('/'),
    routes: [
                   
        { path: '/', name: 'welcome', component: Welcome},
        { path: '/register', name: 'register', component: Register },
       
    ]
});
export default router;
