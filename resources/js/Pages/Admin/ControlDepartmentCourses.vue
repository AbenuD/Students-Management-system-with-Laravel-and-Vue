        <script setup>
        import { ref, onMounted } from 'vue';
        import axios from 'axios';
        import { toast } from "vue3-toastify";
import Sidebar from "../../Components/Sidebar.vue";
import RadioStyle from "../../Components/RadioStyle.vue";
import CourseTableHead from "../../Components/CourseTableHead.vue";
        const departments = ref([]);
        const years = ref([]);
        const courses = ref([]);
        const selectedDepartment = ref('');
        const selectedYear = ref('');
        const selectedSemister = ref(0);
        
        const fetchDepartments = async () => {
          try {
            const response = await axios.get('/api/department/index'); // Adjust the API endpoint accordingly
            departments.value = response.data;
          } catch (error) {
            console.error('Error fetching departments:', error);
          }
        };
        
        const fetchCourses = async () => {
          try {
            const response = await axios.get(`/api/courses/${selectedDepartment.value}/${selectedYear.value}/${selectedSemister.value}`);
            courses.value = response.data;
          } catch (error) {
            console.error('Error fetching courses:', error);
          }
        };
        
        onMounted(() => {
          fetchDepartments();
        });
        
        // Generate a range of years, e.g., from 2020 to 2030
        const currentYear = new Date().getFullYear();
        const startYear = 1;
        const endYear = 5;
        years.value = Array.from({ length: endYear - startYear + 1 }, (_, i) => startYear + i);
        </script>
        
<template>
    





    <div class="flex flex-row items-center justify-center">
        <div class="w-1/5">
            <Sidebar />
        </div>

        <!-- <div class="bg-[url('../Images/background.jpg')]"> -->
        <div class="w-3/4">
            <div class="flex justify-center">
                <div class="w-full p-6 space-y-3 bg-white rounded-lg shadow-lg">
                    <div class="flex space-x-6">
                        <div class="mt-5">
                            <label class="text-gray-700" for="department">
                                Department
                                <select
                                    id="department"
                                    class="block px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm w-52 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    name="department"
                                    v-model="selectedDepartment"
                                >
                                    <option value="">
                                        Choose the Department
                                    </option>
                                    <option v-for="department in departments" :key="department.id" :value="department.id">{{department.departmentName}}</option>
                                </select>
                            </label>
                        </div>
                        <div class="mt-5">
                            <label class="text-gray-700" for="year">
                                Year
                                <select
                                    id="year"
                                    class="block px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm w-52 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    name="year"
                                    v-model="selectedYear"
                                >
                                    <option value="">Choose the Year</option>
                                    <option v-for="year in years" :value="year" :key="year">{{ year }}</option>
                                </select>
                            </label>
                        </div>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 mt-5 w-full">
                            <label>
                                <input
                                    type="radio"
                                    :value=1
                                    class="peer hidden"
                                    name="semister"
                                    v-model="selectedSemister"
                                />

                                <RadioStyle name="1st Semister" />
                            </label>

                            <label>
                                <input
                                    type="radio"
                                    :value=2
                                    class="peer hidden"
                                    name="semister"
                                    v-model="selectedSemister"
                                    
                                />

                                <RadioStyle name="2nd Semister" />
                            </label>
                            <div class="mt-5"><button class="bg-gradient-to-r from-cyan-400 to-cyan-600 text-white text-2xl py-2 px-2 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:bg-cyan-600 mb-2" @click="fetchCourses">Get Courses</button></div>
                        </div>
                    </div>

                </div>
            </div>

            <div v-if="courses.length" class="table w-full p-2">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <!-- <CourseTableHead> Course Code</CourseTableHead> -->
                            <CourseTableHead>Course Name</CourseTableHead>
                            <CourseTableHead>Course Code</CourseTableHead>
                            <CourseTableHead>Credit Hour</CourseTableHead>
                            <CourseTableHead> Action</CourseTableHead>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-gray-100 text-center border-b text-sm text-gray-600"
                        v-for="course in courses" :key="course.id">
                            <td class="p-2 border-r">
                                {{ course.courseName }}
                            </td>
                            <td class="p-2 border-r">
                                {{ course.courseCode }}
                            </td>
                            <td class="p-2 border-r">
                                {{ course.creditHour }}
                            </td>
                            <td>
                                <button
                                    class="bg-blue-500 p-2 text-white hover:shadow-lg text-xs font-thin"
                                >
                                    Edit
                                </button>
                                <button
                                    @click="deleteEntry(index)"
                                    class="bg-red-500 p-2 text-white hover:shadow-lg text-xs font-thin"
                                >
                                    Remove
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </template>
  