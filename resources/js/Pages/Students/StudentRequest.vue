<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import RadioStyle from "../../Components/RadioStyle.vue";
import Navbar from "../../Components/Navbar.vue"
const form = ref({
    semister: 0,
    year: 0,
    department_id: 0,
    cafe: 1,
});
const user = ref({});
const department = ref({});
const stuRequest = ref({});
const student = ref({});
const departments = ref([]);
const errors = ref({});
const processing = ref(false);
const sent = ref(false);
const noRequest = ref(true);
function submit() {
    if (processing.value) return;
    processing.value = true;
    axios
        .post("/api/student/request", form.value)
        .then((response) => {
            errors.value = {};
            stuRequest.value = response.data.stuRequest;
            if(stuRequest.value!==null){

                toast.info(response.data.message, {
                    autoClose: 1000,
                });
                form.value = {};
                sent.value = true
            }
            else {

                console.log(response.data.message);
                toast.success(response.data.message, {
                    autoClose: 1000,
                });
                sent.value = true
                console.log(response.data.stuRequest);
            }
             getStudentRequest();
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
            toast.error(errors.value, {
              autoClose: 1000,
            });
            console.log(errors.value)
           
        })
        .finally(() => (processing.value = false));
}
function getUser() {
    axios.get("/api/user").then((response) => {
        user.value = response.data;
        console.log(user.value);
        console.log(user.value.id);
        getStudentRequest();
    });
}
function getDepartment(){
    axios.get('api/department/index')
    .then(res => departments.value = res.data)
}
function getStudentRequest() {
    console.log("User ID:", user.value.id);
    axios.get(`/api/student/request/${user.value.id}`)
    .then((response) => {
        if(response.data.stuRequest==null){

            student.value = stuRequest.value;
            noRequest.value = response.data.noRequest;
        }
        student.value = response.data.stuRequest
        noRequest.value = response.data.noRequest;
        console.log(student.value);
        console.log(noRequest);
        })
        .catch((error) => {
            console.error(error);
            // console.log(user.value.id)
            toast.error('Error fetching student request');
        });
}
onMounted(() => {
    getUser();
    getDepartment();
    
});
</script>
<template>
    <Navbar :name=user.name  />
    <div class="h-screen flex flex-col bg-gray-100 shadow-xl overflow-y-scroll">
        <div class="bg-sky-300 shadow-lg rounded-b-3xl">
            <div class="grid px-7 py-2 items-center justify-around grid-cols-3 gap-4 divide-x divide-solid">
                <div class="col-span-1 flex flex-col items-center">
                    <span class="text-2xl font-bold">Collage</span>
                    <span class="text-lg font-medium 0">Fresh Man</span>
                </div>
                <div class="col-span-1 px-3 flex flex-col items-center">
                    <span class="text-2xl font-bold">Department</span>
                    <span class="text-lg font-medium">Fresh Man</span>
                </div>
                <div class="col-span-1 px-3 flex flex-col items-center">
                    <span class="text-2xl font-bold">Batch</span>
                    <span class="text-lg font-medium">2016</span>
                </div>
            </div>
        </div>
        <div class="min-h-screen flex justify-center mx-5">
            <div class="max-w-3/4 w-full p-2 bg-white rounded-lg shadow-lg">
                <div class="mx-10">
                    <div class="flex flex-row ">
                        <div class="flex space-x-6">
                            <div class="mt-5">
                                <label class="text-gray-700" for="department">
                                    Department
                                    <select
                                        id="department"
                                        class="block px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm w-52 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                        name="department"
                                        v-model="form.department_id">
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
                                        v-model="form.year">
                                        <option value=0>Choose the Year</option>
                                        <option value=1>1st Year</option>
                                        <option value=2>2nd Year</option>
                                        <option value=3>3rd Year</option>
                                        <option value=4>4th Year</option>
                                        <option value=5>5th Year</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-2 ml-4 mt-5 w-full">
                            <label>
                                <input
                                    type="radio"
                                    :value="0"
                                    class="peer hidden"
                                    name="semister"
                                    v-model="form.semister"
                                />
                                <RadioStyle name="1st Semister" />
                            </label>
                            <label>
                                <input
                                    type="radio"
                                    :value="1"
                                    class="peer hidden"
                                    name="semister"
                                    v-model="form.semister"
                                    
                                />

                                <RadioStyle name="2nd Semister" />
                            </label>
                            <label>
                                <input
                                    type="radio"
                                    :value="1"
                                    class="peer hidden"
                                    name="cafe"
                                    v-model="form.cafe"
                                    
                                />

                                <RadioStyle name="Cafe" />
                            </label>
                            <label>
                                <input
                                    type="radio"
                                    :value="0"
                                    class="peer hidden"
                                    name="cafe"
                                    v-model="form.cafe"
                                    
                                />

                                <RadioStyle name="Non Cafe" />
                            </label>
                        </div>

                        
                    </div>
                    <button
                        @click="submit()"
                        :disabled="sent"
                        class="w-1/5 bg-gradient-to-r from-cyan-400 to-cyan-600 text-white text-2xl py-2 rounded-lg mx-auto mt-6 block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:cyan-600 mb-2">
                        Register
                    </button>
                </div>
        <div v-if="noRequest !== true" class="p-2 mb-2">
            <div class="container  px-4 mx-auto sm:px-8">
                    <div class="px-2 py-4 mx-2 sm:-mx-8 sm:px-8">
                        <div class="inline-block min-w-full rounded-lg shadow">
                            <table class="w-full leading-normal">
                                <thead>
                                    <tr>
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
                                            Cafe
                                        </th>
                                   
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="student !== null">
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{student.department}}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{student.year}}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ student.semister }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{student.cafe}}
                                            </p>
                                        </td>
                                        
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900">
                                                <span aria-hidden="true" class="absolute inset-0 bg-green-200 rounded-full opacity-50">
                                                </span>
                                                <span class="relative">
                                                    {{student.status}}
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
