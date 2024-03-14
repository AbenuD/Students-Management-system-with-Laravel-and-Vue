<script setup>
import axios from "axios";
import { onMounted, ref, computed  } from "vue";
import { useRouter } from "vue-router";
import Navbar from "../../Components/Navbar.vue";
import StudentSidebar from "../../Components/StudentSidebar.vue";
import { useAuthStore } from "../../Src/Store/auth.js";

const router = useRouter();
const user = ref({});

const numberOfItems = ref(0)
const year = ref(0)
const semister = ref(0)
const courses = ref([]);
const itemCount = computed(() => {
  const items = [];
  for (let i = 0; i < numberOfItems.value; i++) {
    items.push(i);
  }
  return items;
});
// function getUser() {
//     axios.get(`/api/student/show/${stu.id}`).then((response) => {
//         user.value = response.data;

//         numberOfItems.value = user.value.noYears;

//         console.log(user.value);
//     });
// }
function logout() {
    axios.post("/api/logout").then(() => {
        router.push("/login");
    });
}
function getYear(index){
    year.value = index+1;
}

const getCourses = async (index) => {
    semister.value = index;
          try {
            const response = await axios.get(`/api/courses/${year.value}/${semister.value}`);
            courses.value = response.data;
            console.log(courses);
          } catch (error) {
            console.error('Error fetching courses:', error);
          }
        };

onMounted(() => {
    user.value = useAuthStore().getUser;
    numberOfItems.value = user.value.noYears;
});
</script>
<template>
    <div class="leading-normal tracking-normal">
      <div class="flex flex-wrap">
  
        <!-- <StudentSidebar /> -->
        <div class="w-1/2 md:w-1/3 lg:w-64 fixed md:top-0 md:left-0 h-screen lg:block bg-gray-100 border-r z-30" id="main-nav">
        <div class="h-full overflow-auto">
          <div class="w-full h-20 border-b flex px-4 items-center mb-4">
            <RouterLink class="font-semibold text-3xl text-blue-400 pl-4">Igsoon</RouterLink>
          </div>

          <div v-for="(item, index) in itemCount" :key="index">
            <div class="mb-4 px-4" >
            <button @click="getYear(index)" class="text-xl py-2 flex justify-center align-text-center font-semibold mb-1 bg-gray-200 rounded-xl w-full">{{index + 1 }} Year</button >
            <div v-if="index+1==year">
                <div class="w-full flex justify-center items-center text-blue-400 h-10 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                    <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
                        <path d="M17.592,8.936l-6.531-6.534c-0.593-0.631-0.751-0.245-0.751,0.056l0.002,2.999L5.427,9.075H2.491c-0.839,0-0.162,0.901-0.311,0.752l3.683,3.678l-3.081,3.108c-0.17,0.171-0.17,0.449,0,0.62c0.169,0.17,0.448,0.17,0.618,0l3.098-3.093l3.675,3.685c-0.099-0.099,0.773,0.474,0.773-0.296v-2.965l3.601-4.872l2.734-0.005C17.73,9.688,18.326,9.669,17.592,8.936 M3.534,9.904h1.906l4.659,4.66v1.906L3.534,9.904z M10.522,13.717L6.287,9.48l4.325-3.124l3.088,3.124L10.522,13.717z M14.335,8.845l-3.177-3.177V3.762l5.083,5.083H14.335z"></path>
                    </svg>
                <button @click="getCourses(1)" class="text-gray-700">1st Semister</button>
                </div>
                <div class="w-full flex justify-center items-center text-blue-400 h-10 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
                    <path d="M17.592,8.936l-6.531-6.534c-0.593-0.631-0.751-0.245-0.751,0.056l0.002,2.999L5.427,9.075H2.491c-0.839,0-0.162,0.901-0.311,0.752l3.683,3.678l-3.081,3.108c-0.17,0.171-0.17,0.449,0,0.62c0.169,0.17,0.448,0.17,0.618,0l3.098-3.093l3.675,3.685c-0.099-0.099,0.773,0.474,0.773-0.296v-2.965l3.601-4.872l2.734-0.005C17.73,9.688,18.326,9.669,17.592,8.936 M3.534,9.904h1.906l4.659,4.66v1.906L3.534,9.904z M10.522,13.717L6.287,9.48l4.325-3.124l3.088,3.124L10.522,13.717z M14.335,8.845l-3.177-3.177V3.762l5.083,5.083H14.335z"></path>
                </svg>
                <button @click="getCourses(2)" class="text-gray-700">2nd Semister</button>
                </div>
            </div>
        </div>
          </div>
        </div>
      </div>
  
        <div class="w-full pl-0 lg:pl-64 min-h-screen" >
  
          <Navbar :name=user.department />
  
          <div class="p-2 mb-2">
            <div class="container  px-4 mx-auto sm:px-8">
                    <div class="px-2 py-4 mx-2 sm:-mx-8 sm:px-8">
                        <div class="inline-block min-w-full rounded-lg shadow">
                            <table class="w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Course Name
                                        </th>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Course Code
                                        </th>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Credit Hour
                                        </th>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Mid-Exam
                                        </th>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Assignment
                                        </th>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Project
                                        </th>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Final
                                        </th>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Total
                                        </th>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Grade
                                        </th>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Instructor
                                        </th>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr  v-for="course in courses" :key="course.id">
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
                                                {{course.mid}}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{course.assignment}}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{course.project}}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{course.final}}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ course.total }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ course.grade }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{course.instructor}}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900">
                                                <span aria-hidden="true" class="absolute inset-0 bg-green-200 rounded-full opacity-50">
                                                </span>
                                                <span class="relative">
                                                    active
                                                </span>
                                            </span>
                                        </td>
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
  </template>