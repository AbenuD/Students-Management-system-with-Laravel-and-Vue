<script setup>
  import { ref,onMounted } from 'vue';
  import axios from 'axios';
  import { toast } from "vue3-toastify";
  import Dashboard from '../../Components/Dashboard.vue'
  import TeacherSidebar from '../../Components/TeacherSidebar.vue'
  import Navbar from '../../Components/Navbar.vue'
  import { useRouter } from "vue-router";
  import { useAuthStore } from '../../Src/Store/auth';
  const studentMark = ref({
    'mid':0,
    'assignment':0,
    'project':0,
    'final':0,
  });
  const router = useRouter();
  console.log(router.currentRoute.value.params);
  const courseId = router.currentRoute.value.params.courseId;
  const markList = ref([]);
  const students = ref({});
  const fetchMarkList = async (courseId) => {
  try {
    const response = await axios.get(`/api/teacher/course/${courseId}/marklist`);
    students.value = response.data.markLists
    console.log(students.value);
  } catch (error) {
    console.error('Error fetching mark list:', error);
  }
};
function updateMarkList(student){
    const data = {
        student_id: student.student_id,
        course_id: student.course_id,
        mid: student.mid,
        assignment: student.assignment,
        project: student.project,
        final: student.final, 
    };
    axios
        .post("/api/update/marklist", data )
        .then((response) => {
            console.log(response.data.message);
            toast.success(response.data.message);
            fetchMarkList(courseId);
            // studentMark.value = {};
        })
        .catch((error) => {
            console.error(error);
            toast.error(response.data.error);
        })
}
onMounted(() => {
    console.log(courseId);
    fetchMarkList(courseId);
});
</script>
<template>
    <div class="leading-normal tracking-normal">
      <div class="flex flex-wrap">
        <TeacherSidebar />
        <div class="w-full bg-gray-100 pl-0 lg:pl-64 min-h-screen">
          <Navbar name="Instructor"/>
          <div class="p-2 mb-2">
            <div class="container  px-4 mx-auto sm:px-8">
                    <div class="px-2 py-4 mx-2 sm:-mx-8 sm:px-8">
                        <div class="inline-block min-w-full rounded-lg shadow">
                            <table class="w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Student Name
                                        </th>
                                        <th scope="col" class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                            Student Id
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
                                            status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="student in students" :key="student.id" >
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                               {{student.name}}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                               {{student.id}}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                <input type="number appearance-none py-2 px-3 leading-tight focus:outline-none focus:border-gray-100" class="w-full"  v-model="student.mid" >
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                <input type="number appearance-none py-2 px-3 leading-tight focus:outline-none focus:border-gray-100" class="w-full" v-model="student.assignment" >
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                <input type="number appearance-none py-2 px-3 leading-tight focus:outline-none focus:border-gray-100" class="w-full" v-model="student.project" >
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                <input type="number appearance-none py-2 px-3 leading-tight focus:outline-none focus:border-gray-100" class="w-full" v-model="student.final" >
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                <input type="number appearance-none py-2 px-3 leading-tight focus:outline-none focus:border-gray-100" class="w-full" v-model="student.total" >
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ student.grade }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                            <button @click="updateMarkList(student)" class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900">
                                                <span aria-hidden="true" class="absolute inset-0 bg-green-200 rounded-full opacity-50">
                                                </span>
                                                <span class="relative">
                                                    Submit
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
</template>