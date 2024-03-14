<script setup>
import {ref,onMounted} from 'vue'
import axios from 'axios';
import { toast } from "vue3-toastify";
import TeacherSidebar from '../../../Components/TeacherSidebar.vue'
import Navbar from '../../../Components/Navbar.vue'
const studentRequest = ref({});
function getStuRequest() {
    axios.get('api/stu/request')
        .then((response) => {
            studentRequest.value = response.data;
             console.log(response.data);
        })
        .catch((error) => {
            console.error(error);
             console.log(studentRequest.value)
            toast.error('Error fetching student request');
        });
}
function changeStatus(stu){
     // Here you can implement the logic to update the status of the clicked student request
  console.log('Clicked student request:', stu);
  // Example: Update the status using Axios PUT request
  axios.put(`/api/stu/request/${stu.id}`, { status: 'approved' })
    .then((response) => {
      console.log('Status updated successfully:', response.data);
      // Optionally, update the local data after successful status change
      stu.status = response.data.status;
    })
    .catch((error) => {
      console.error('Error updating status:', error);
      toast.error('Error updating status');
    });
}
onMounted(() => {
    getStuRequest();
});
</script>
<template>
  <div class="leading-normal tracking-normal" >
    <div class="flex flex-wrap">
      <TeacherSidebar />
      <div class="w-full bg-gray-100 pl-0 lg:pl-64 min-h-screen" >
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
                                        Student
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                        Department
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                        Year
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                        Semister
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                        cafe
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                        status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="stu in studentRequest" :key="stu.id">
                                    <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{ stu.stuName }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{stu.department}}
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{stu.year}}
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{stu.semister}}
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{stu.cafe}}
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                        <button @click="changeStatus(stu)" class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900">
                                            <span aria-hidden="true" 
                                            class="absolute inset-0 rounded-full opacity-50" 
                                            :class="{
                                                'bg-yellow-200': stu.status === 'pending',
                                                'bg-green-200': stu.status === 'approved',
                                                'bg-red-200': stu.status === 'rejected'
                                            }">
                                            </span>
                                            <span class="relative">
                                                {{stu.status}}
                                            </span>
                                        </button>
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
  </div>
</template>

