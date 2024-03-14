<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import * as XLSX from "xlsx";
import { toast } from "vue3-toastify";
import TeacherSidebar from "../../../Components/TeacherSidebar.vue";
import RadioStyle from "../../../Components/RadioStyle.vue"
import CourseTableHead from "../../../Components/CourseTableHead.vue";
import { useAuthStore } from "../../../Src/Store/auth.js";

const user = ref({});
const departmentId = ref(0);
const course_id = ref(0);
const teacher_id = ref(0);
const year = ref(0)
const years = ref([]);
const semister = ref(0)
const courses = ref([]);
const teachers = ref([]);
const courseTeachers = ref([]);

function getTeacher(){
    console.log(departmentId.value)
    axios.get(`api/dep/teacher/${departmentId.value}`)
         .then((response) => {
            teachers.value = response.data
        })
}
function getCourses(){
    console.log(departmentId.value)
    axios.get(`api/courses/${departmentId.value}/${year.value}/${semister.value}`)
         .then((response) => {
            courses.value = response.data
        })
}

function assign(){
    axios.post('/api/assign/teacher',{ 
        course_id: course_id.value,
        teacher_id: teacher_id.value,})
    .then((response) => {
        toast.success(response.data.message, {
                autoClose: 1000,
            });
      console.log('Status updated successfully:', response.data);
      getCourseTeacher();
      // Optionally, update the local data after successful status change
    //   getTeachers();
    })
    .catch((error) => {
      console.error('Error Assigning Teacher:', error);
      toast.error(response.data.error);
    });
}
function getCourseTeacher(){
    axios.get('api/course/teachers')
        .then((res) => {
            courseTeachers.value = res.data;

        //     CourseTeachers.value.forEach(department => {
        // if (department.departmentName && department.dep_head) {
        //     console.log(department.departmentName,department.dep_head.name);
        // } else {
        //     console.log("Department head not found for department:", department.departmentName);
        // }
    });
        
}
const startYear = 1;
        const endYear = 5;
        years.value = Array.from({ length: endYear - startYear + 1 }, (_, i) => startYear + i);
onMounted(() => {
    user.value = useAuthStore().getUser;
    departmentId.value = user.value.department_id;
    getTeacher();
    getCourseTeacher();
})
</script>


<template>
    <div class="flex flex-row items-center justify-center">
        <div class="w-1/5">
            <TeacherSidebar />
        </div>

        <!-- <div class="bg-[url('../Images/background.jpg')]"> -->
        <div class="w-3/4">
            <div class="flex justify-center">
                <div class="w-full p-6 space-y-3 bg-white rounded-lg shadow-lg">
                    <div class="flex space-x-6">
                        <div class="mt-5">
                            <label class="text-gray-700" for="year">
                                Bach
                                <select
                                    id="year"
                                    class="block px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm w-52 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    name="year"
                                    v-model="year"
                                >
                                    <option value="">Choose the Bach</option>
                                    <option v-for="year in years" :value="year" :key="year">{{ year }}</option>
                                </select>
                            </label>
                        </div>
                            <div class="mt-5">
                                Semister
                                <div
                                class="flex gap-2 w-full">
                                <label>
                                    <input
                                        type="radio"
                                        :value=1
                                        class="peer hidden"
                                        name="semister"
                                        v-model="semister"
                                        @change="getCourses()"
                                    />

                                    <RadioStyle name="1st" />
                                </label>

                                <label>
                                    <input
                                        type="radio"
                                        :value=2
                                        class="peer hidden"
                                        name="semister"
                                        v-model="semister"
                                        @change="getCourses()"
                                        
                                    />

                                    <RadioStyle name="2nd" />
                                </label>
                            </div>
                        </div>
                        <div class="mt-5">
                            <label class="text-gray-700" for="course">
                                Course
                                <select
                                    id="course"
                                    class="block px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm w-52 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    name="course"
                                    v-model="course_id"
                                >
                                    <option value=0>
                                        Choose the Course
                                    </option>
                                    <option  v-for="course in courses" :key="course.id" :value="course.id">{{course.courseName}}</option>
                                </select>
                            </label>
                        </div>
                        <div class="mt-5">
                            <label class="text-gray-700" for="teacher">
                                teacher
                                <select
                                    id="teacher"
                                    class="block px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm w-52 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    name="teacher"
                                    v-model="teacher_id"
                                >
                                    <option value=0>
                                        Choose the teacher
                                    </option>
                                    <option  v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">{{teacher.name}}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <button @click="assign()" class="w-1/4 bg-cyan-400 text-white text-2xl py-2 px-3 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:bg-cyan-600 mt-5">
                        Assign
                    </button>
                </div>
            </div>

            <div v-if="courseTeachers" class="table w-full p-2">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <CourseTableHead > Course Name</CourseTableHead>
                            <CourseTableHead> Course Code</CourseTableHead>
                            <CourseTableHead> Credit Hours</CourseTableHead>
                            <CourseTableHead> Instructor</CourseTableHead>
                            <CourseTableHead> Email</CourseTableHead>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-gray-100 text-center border-b text-sm text-gray-600" v-for="courseTeacher in courseTeachers" :key="courseTeacher.id">
                            <td class="p-2 border-r">
                                {{ courseTeacher.courseName }}
                            </td>
                            <td class="p-2 border-r">
                                {{ courseTeacher.courseCode }}
                            </td>
                            <td class="p-2 border-r">
                                {{ courseTeacher.creditHour }}
                            </td>
                            <td class="p-2 border-r">
                                {{ courseTeacher.teacher_name }}
                            </td>
                            <td class="p-2 border-r">
                                {{ courseTeacher.teacher_email }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
