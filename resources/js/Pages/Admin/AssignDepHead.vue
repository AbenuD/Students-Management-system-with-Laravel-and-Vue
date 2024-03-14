<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import * as XLSX from "xlsx";
import { toast } from "vue3-toastify";
import Sidebar from "../../Components/Sidebar.vue";
import CourseTableHead from "../../Components/CourseTableHead.vue";

const departmentId = ref(0);
const user_id = ref(0);
const departments = ref([]);
const departmentsWithHeads = ref([]);
const depTeachers = ref([]);
function getDepartment(){
    axios.get('api/department/index')
        .then((res) => {
            departments.value = res.data
            // console.log(departments.value);
        })
}

function depTeacher(){
    console.log(departmentId.value)
    axios.get(`api/dep/teacher/${departmentId.value}`)
         .then((response) => {
            depTeachers.value = response.data
        })
}

function assign(){
    axios.put('/api/assign/dep_head',{ 
        department_id: departmentId.value,
        teacher_id: user_id.value})
    .then((response) => {
        toast.success(response.data.message, {
                autoClose: 1000,
            });
      console.log('Status updated successfully:', response.data);
      getDepartmentHeads();
      // Optionally, update the local data after successful status change
    //   getTeachers();
    })
    .catch((error) => {
      console.error('Error Assigning Head:', error);
      toast.error('Error Assigning Head');
    });
}
function getDepartmentHeads(){
    axios.get('api/teacher/index')
        .then((res) => {
            departmentsWithHeads.value = res.data;
            departmentsWithHeads.value.forEach(department => {
        if (department.departmentName && department.dep_head) {
            console.log(department.departmentName,department.dep_head.name);
        } else {
            console.log("Department head not found for department:", department.departmentName);
        }
    });
        
            // console.log(departmentsWithHeads.value.dep_head.name);
        })
}
onMounted(() => {
    getDepartment();
    getDepartmentHeads();
})
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
                                    v-model="departmentId"
                                    @change="depTeacher()"
                                >
                                    <option value=0>
                                        Choose the Department
                                    </option>
                                    <option  v-for="department in departments" :key="department.id" :value="department.id">{{department.departmentName}}</option>
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
                                    v-model="user_id"
                                >
                                    <option value=0>
                                        Choose the teacher
                                    </option>
                                    <option  v-for="depteach in depTeachers" :key="depteach.id" :value="depteach.id">{{depteach.name}}</option>
                                </select>
                            </label>
                        </div>
                            <button @click="assign()" class="w-1/4 bg-cyan-400 text-white text-2xl py-2 px-3 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:bg-cyan-600 mt-5">
                                Assign
                            </button>
                    </div>
                </div>
            </div>

            <div v-if="departmentsWithHeads" class="table w-full p-2">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <!-- <CourseTableHead> Course Code</CourseTableHead> -->
                            <CourseTableHead > Department</CourseTableHead>
                            <CourseTableHead> Name</CourseTableHead>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-gray-100 text-center border-b text-sm text-gray-600" v-for="department in departmentsWithHeads" :key="department.id"
>
                            <td class="p-2 border-r">
                                {{ department.departmentName }}
                            </td>
                            <td class="p-2 border-r">
                                {{ department.dep_head.name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
       
            </div>
        </div>
    </div>
</template>
