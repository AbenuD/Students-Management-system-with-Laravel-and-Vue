import { createRouter, createWebHashHistory } from "vue-router";
import Welcome from './Pages/Students/Welcome.vue';
import StudentHome from './Pages/Students/StudentHome.vue';
import Register from './Pages/Admin/Register.vue';
import ImportStudents from './Pages/Admin/ImportStudents.vue';
import AdminHome from './Pages/Admin/AdminHome.vue';
import AssignDepHead from './Pages/Admin/AssignDepHead.vue';
import TeacherHome from './Pages/Teachers/TeacherHome.vue';
import MarkList from './Pages/Teachers/MarkList.vue';
import NewRequests from './Pages/Teachers/Advisor/NewRequests.vue';
import AssignTeacher from './Pages/Teachers/DepHead/AssignTeacher.vue';
import StudentsList from './Pages/Admin/StudentsList.vue';
import ControlDepartmentCourses from './Pages/Admin/ControlDepartmentCourses.vue';
import Login from './Pages/Students/Login.vue';
import NewDepartment from './Pages/Departments/NewDepartment.vue';
import NewCourse from './Pages/Courses/NewCourse.vue';
import AddCourse from './Pages/Courses/AddCourses.vue';
import Select from './Pages/AddCourse.vue';
import Unauthorized from './Pages/Unauthorized.vue';
import GradeSheet from './Pages/Students/GradeSheet.vue';
import StudentRequest from './Pages/Students/StudentRequest.vue';
import { useAuthStore } from "./Src/Store/auth.js";

const router = createRouter({
    history: createWebHashHistory('/'),
    routes: [
        // { path: '/', component: Welcome},
        // { path: '/home', component: StudentHome, name: 'StudentHome', beforeEnter:(to,from,next)=>{axios.get('/api/athenticated').then(()=>{next()}).catch(()=>{return next({name: 'Login'})})}},
        // { path: '/register', component: Register, beforeEnter:(to,from,next)=>{axios.get('/api/athenticated').then(()=>{next()}).catch(()=>{return next({name: 'Login'})})} },
        // { path: '/admin', component: AdminHome, name: 'AdminHome' },
        // { path: '/teacher', component: TeacherHome, name: 'TeacherHome' },
        // { path: '/students/list', component: StudentsList, name: 'students/list' },
        // { path: '/login', component: Login, name: 'Login' },
        // { path: '/new-department', component: NewDepartment, name: 'NewDepartment' },
        // { path: '/new-course', component: NewCourse, name: 'NewCourse' },
        // { path: '/add-course', component: AddCourse, name: 'AddCourse' },
        // { path: '/select', component: Select, name: 'Select' },
        // { path: '/grade', component: GradeSheet, name: 'Grade' },
        
        { path: '/', component: Welcome },
        { path: '/home', component: StudentHome, name: 'StudentHome', meta: { requiresAuth: true, requiresRole: 'student' } },
        { path: '/register', component: Register, meta: { requiresAuth: true, requiresRole: 'admin' } },
        { path: '/login', component: Login, name: 'Login' },
        { path: '/import/students', component: ImportStudents, meta: { requiresAuth: true, requiresRole: 'admin' } },
        { path: '/admin', component: AdminHome, name: 'AdminHome', meta: { requiresAuth: true, requiresRole: 'admin' } },
        { path: '/students/list', component: StudentsList, name: 'students/list', meta: { requiresAuth: true, requiresRole: 'admin' } },
        { path: '/new-department', component: NewDepartment, name: 'NewDepartment', meta: { requiresAuth: true, requiresRole: 'admin' } },
        { path: '/new-course', component: NewCourse, name: 'NewCourse', meta: { requiresAuth: true, requiresRole: 'admin' } },
        { path: '/add-course', component: AddCourse, name: 'AddCourse', meta: { requiresAuth: true, requiresRole: 'admin' } },
        { path: '/control/department/courses', component: ControlDepartmentCourses, name: 'ControlDepartmentCourses', meta: { requiresAuth: true, requiresRole: 'admin' } },
        { path: '/select', component: Select, name: 'Select', meta: { requiresAuth: true, requiresRole: 'admin' } },
        { path: '/assign/dep_head', component: AssignDepHead, name: 'AssignDepHead', meta: { requiresAuth: true, requiresRole: 'admin' } },
        { path: '/teacher', component: TeacherHome, name: 'TeacherHome', meta: { requiresAuth: true, requiresRole: ['teacher','advisor','dep_head'] } },
        { path: '/mark/list/:courseId', component: MarkList, name: 'MarkList', meta: { requiresAuth: true, requiresRole: ['teacher','advisor','dep_head'] } },
        { path: '/stu/request', component: NewRequests, name: 'NewRequests', meta: { requiresAuth: true, requiresRole: 'dep_head' } },
        { path: '/assign/teacher', component: AssignTeacher, name: 'AssignTeacher', meta: { requiresAuth: true, requiresRole: 'dep_head' } },
        { path: '/grade', component: GradeSheet, name: 'GradeSheet', meta: { requiresAuth: true, requiresRole: 'student' }},
        { path: '/student/request', component: StudentRequest, name: 'StudentRequest', meta: { requiresAuth: true, requiresRole: 'student' }},
        { path: '/Unauthorized', component: Unauthorized, name: 'Unauthorized' },
    ]
});
router.beforeEach((to, from, next) => {
    const requiresAuth = to.meta.requiresAuth;
    const requiresRole = to.meta.requiresRole;

    const userStore = useAuthStore(); // Initialize the user store
    const userRole = userStore.role; // Get the user's role from the store

    // Check if the route requires authentication
    if (requiresAuth) {
        // If not logged in, redirect to the login page
        if (!userRole) {
            next({ name: 'Login' });
            return;
        }
    }

    // Check if the route requires a specific role
    if (requiresRole && !requiresRole.includes(userRole)) {
        // Redirect to unauthorized page or show a message
        next({ name: 'Unauthorized' });
        return;
    }

    // Allow navigation to proceed
    next();
});
export default router;
