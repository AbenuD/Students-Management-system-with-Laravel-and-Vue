import { createRouter, createWebHashHistory } from "vue-router";
import Welcome from './Pages/Students/Welcome.vue';
import Home from './Pages/Students/Home.vue';
import Register from './Pages/Admin/Register.vue';
import Dashboard from './Pages/Admin/Home.vue';
import Login from './Pages/Students/Login.vue';
import NewDepartment from './Pages/Departments/NewDepartment.vue';
import NewCourse from './Pages/Courses/NewCourse.vue';
import AddCourse from './Pages/Courses/AddCourses.vue';
import Select from './Pages/AddCourse.vue';
import axios from "axios";


const router = createRouter({
    history: createWebHashHistory('/'),
    routes: [
                   
        { path: '/', component: Welcome},
        { path: '/home', component: Home, name: 'home', beforeEnter:(to,from,next)=>{axios.get('/api/athenticated').then(()=>{next()}).catch(()=>{return next({name: 'Login'})})}},
        { path: '/register', component: Register, beforeEnter:(to,from,next)=>{axios.get('/api/athenticated').then(()=>{next()}).catch(()=>{return next({name: 'Login'})})} },
        { path: '/admin', component: Dashboard, name: 'admin' },
        { path: '/login', component: Login, name: 'Login' },
        { path: '/new-department', component: NewDepartment, name: 'NewDepartment' },
        { path: '/new-course', component: NewCourse, name: 'NewCourse' },
        { path: '/add-course', component: AddCourse, name: 'AddCourse' },
        { path: '/select', component: Select, name: 'Select' },
       
    ]
});
export default router;
