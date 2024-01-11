import { createRouter, createWebHashHistory } from "vue-router";

import Welcome from './Pages/Welcome.vue';


const router = createRouter({
    history: createWebHashHistory('/'),
    routes: [
                   
        { path: '/', name: 'welcome', component: Welcome, meta: { layout: 'empty' }, },
       
    ]
});
export default router;
