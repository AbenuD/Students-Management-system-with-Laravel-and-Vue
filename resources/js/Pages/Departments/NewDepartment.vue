<script setup>
import { ref, watch } from "vue";
import axios from "axios";
import { useRouter } from 'vue-router';
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Sidebar from '../../Components/Sidebar.vue'
const router = useRouter();
const department = ref({
  departmentName: "",
  noYears: "",
});


const add = async () => {
  try {
    // Make an Axios POST request to register the department
    const response = await axios.post('/api/new-department',  department.value );

    // Assuming the API response contains the department ID
    const departmentId = response.data.departmentId;
    const noYears = response.data.noYears;

    // Navigate to the course registration component with the obtained department ID
    router.push({
      name: 'AddCourse',
      params: {departmentId: departmentId, noYears:noYears}
    });
  } catch (error) {
    console.error('Error registering department:', error);
    // Handle error as needed
  }
};




  
</script>
<template>
    <div class="flex flex-col">
      <div><Sidebar /></div>
      <!-- <div class="bg-[url('../Images/background.jpg')]"> -->
        <div class="min-h-screen flex items-center justify-center mx-5">
        <div class="max-w-3/4 w-3/4 p-6 bg-white rounded-lg shadow-lg">
          <h1 class="text-2xl font-semibold text-center text-gray-500 mt-8 mb-6">
            Add New Department
          </h1>
          <div class="flex flex-cols space-x-20 mx-auto items-center justify-center">
            <div class="mb-4">
              <label
                for="department_name"
                class="block mb-2 text-sm text-gray-600"
              >
                Department Name
              </label>
              <input
                type="text"
                id="department_name"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                v-model="department.departmentName"
                required
              />
            </div>

            <div class="mb-4">
              <label
                for="department_noYears"
                class="block mb-2 text-sm font-medium text-gray-600"
                >Number of Years</label
              >
              
              <input
                type="number"
                id="noCourses"
                name="noCourses"
                min="4"
                max="7"
                class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                v-model="department.noYears"
                required
              />
            </div>
            <div class="mb-4">
              <h1 class="block mb-2 text-sm font-medium text-white">Click Add to submit</h1>
              <button
                @click="add()"
                class="w-full  bg-gradient-to-r from-cyan-400 to-cyan-600 text-white text-2xl py-2 rounded-lg  block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:cyan-600 mb-2">
                Add 
              </button>
            </div>
          </div>
          <div class="text-center"></div>
          <p class="text-xs text-gray-600 text-center mt-8">&copy; 2024 Igsoon</p>
        </div>
      </div>
    <!-- </div> -->
  </div>
</template>