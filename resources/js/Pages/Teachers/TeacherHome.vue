  <script setup>
  import { ref,onMounted } from 'vue';
  import axios from 'axios';
  import { toast } from "vue3-toastify";
  import Dashboard from '../../Components/Dashboard.vue'
  import TeacherSidebar from '../../Components/TeacherSidebar.vue'
  import Navbar from '../../Components/Navbar.vue'
  import { useAuthStore } from '../../Src/Store/auth';
  import { useRouter } from "vue-router";
import MarkList from './MarkList.vue';

const router = useRouter();
const authStore = useAuthStore();
const courses = ref([]);
  const teacher = ref({});
teacher.value = useAuthStore().getUser;
  const fetchCourses = async () => {
    try {
        const teacherId = teacher.value.id; // Replace with the actual teacher ID
        const response = await axios.get('/api/teacher/courses');
        courses.value = response.data.courses;
        console.log(courses.value);
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
};
function markList(courseId){
    console.log(courseId);
    router.push({ name: 'MarkList', params: { courseId } });
}

onMounted(() => {
    fetchCourses();
});
  </script>
<template>
    <div class="leading-normal tracking-normal" id="main-body">
      <div class="flex flex-wrap">
  
        <TeacherSidebar />
  
        <div class="w-full bg-gray-100 pl-0 lg:pl-64 min-h-screen"  id="main-content">
  
          <Navbar name="Instructor"/>
  
          <div class="p-6 bg-gray-100 mb-20">
            <div class="container  px-4 mx-auto sm:px-8">
    <div class="py-8">
        <div class="px-4 py-4 -mx-4 overflow-x-auto sm:-mx-8 sm:px-8">
            <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                Section
                            </th>
                            <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                Course Name
                            </th>
                            <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                Course Code
                            </th>
                            <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                Credit Hours
                            </th>
                            <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                No of Students
                            </th>
                            <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(course, index) in courses" :key="course.id" :class="{'bg-gray-100': index % 2 === 0, 'bg-green-300': index % 2 !== 0}" class="bg-white hover:bg-red-300">
                            <!-- <button  class="w-full"> -->

                                <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                           {{ course.department }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                <p class="text-gray-900 whitespace-no-wrap">
                                     {{course.courseName}}
                                </p>
                            </td>
                            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                <p class="text-gray-900 whitespace-no-wrap">
                                     {{course.courseCode}}
                                </p>
                            </td>
                            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                <p class="text-gray-900 whitespace-no-wrap">
                                     {{course.creditHour}}
                                </p>
                            </td>
                            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{course.noStudents    }}
                                </p>
                            </td>
                            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                <button @click="markList(course.id)" class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900">
                                    <span aria-hidden="true" class="absolute inset-0 bg-green-200 rounded-full opacity-50">
                                    </span>
                                    <span class="relative">
                                        View
                                    </span>
                                </button>
                            </td>
                        <!-- </button> -->
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

          </div>
  
  
        </div>
      </div>
    </div>
  </template>
  
  