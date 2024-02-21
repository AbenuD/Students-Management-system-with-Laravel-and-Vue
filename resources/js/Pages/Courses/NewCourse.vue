<script setup>
import { ref, watch } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import { useRouter } from 'vue-router';
import "vue3-toastify/dist/index.css";

const router = useRouter();
const noCourses = ref(1);
const years = ref([]);
const creditHours = [1, 2, 3, 4, 5, 6, 7];

// const departmentId = router.params.departmentId.value;
const departmentId = 1;
const noYears = 5;

const selectedYear = ref(years[0]);
const selectedSemester = ref(0);


  years.value = Array.from(
    { length: noYears },
    (_, index) => index + 1
  );



const courses = ref(
  Array.from({ length: noCourses.value }, () => ({
    name: "",
    creditHour: 0,
    year: 1,
  }))
);
const updateCoursesFields = () => {
  courses.value = Array.from({ length: noCourses.value }, () => ({
    name: "",
    creditHour: 0,
  }));
};
const submit = () => {
  const requestData = {
    year: selectedYear.value,
    semester: selectedSemester.value,
    noCourses: noCourses.value,
    courses: courses.value.map((course) => ({
      name: course.name,
      creditHour: course.creditHour,
    })),
  };

  // Send the data to the backend
  axios
    .post("/api/add-course", requestData)
    .then((response) => {
      console.log(response.data);
    })
    .catch((error) => {
      console.error(error);
    });
};

  
</script>
<template>
  <section class="bg-[url('../Images/background.jpg')]">
    <div class="min-h-screen flex items-center justify-center mx-5">
      <div class="max-w-3/4 w-3/4 p-6 bg-white rounded-lg shadow-lg">
      

        <h1 class="text-2xl font-semibold text-center text-gray-500 mt-8 mb-6">
          Add Courses
        </h1>
        <div class="grid grid-cols-3 gap-4">
          <div class="mb-4">
            <label
              for="course_year"
              class="block mb-2 text-sm font-medium text-gray-900"
            >
              Year</label
            >
            <select
              v-model="selectedYear"
              id="course_year"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            >
              <option disabled selected>Year</option>
              <option v-for="year in years" :key="year" :value="year">
                {{ year }}
              </option>
            </select>
          </div>
          <div class="mb-4">
            <h1 class="block mb-2 text-sm text-gray-600">Semister</h1>
            <div
              class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 px-4 w-full"
            >
              <label>
                <input
                  type="radio"
                  :value="0"
                  class="peer hidden"
                  v-model="selectedSemester"
                  name="semister"
                />

                <div
                  class="hover:bg-gray-50 flex items-center justify-between px-4 py-2 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500"
                >
                  <h2 class="font-medium text-gray-700">1st</h2>
                  <svg
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5 text-blue-600 invisible group-[.peer:checked+&]:visible"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
              </label>
              <label>
                <input
                  type="radio"
                  :value="1"
                  class="peer hidden"
                  name="semister"
                  v-model="selectedSemester"
                />
                <div
                  class="hover:bg-gray-50 flex items-center justify-between px-4 py-2 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500"
                >
                  <h2 class="font-medium text-gray-700">2nd</h2>
                  <svg
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5 text-blue-600 invisible group-[.peer:checked+&]:visible"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
              </label>
            </div>
          </div>
          <div class="mb-4">
            <label for="noCourses" class="block mb-2 text-sm text-gray-600">
              Number of Courses
            </label>
            <input
              type="number"
              id="noCourses"
              name="noCourses"
              min="1"
              class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
              v-model="noCourses"
              @input="updateCoursesFields"
              required
            />
          </div>
        </div>
        <div class="mx-auto">
          <div class="mb-4" v-for="(course, index) in courses" :key="index">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label
                  :for="'courseName' + index"
                  class="block mb-2 text-sm text-gray-600"
                >
                  Name
                </label>
                <input
                  type="text"
                  :id="'courseName' + index"
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                  v-model="course.name"
                  required
                />
              </div>
              <div>
                <label
                  :for="'courseCHr' + index"
                  class="block mb-2 text-sm text-gray-600"
                >
                  Credit Hour
                </label>
                <select
                  v-model="course.creditHour"
                  :id="'courseCHr' + index"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5"
                >
                  <option selected>Credit Hour</option>
                  <option v-for="cHr in creditHours" :key="cHr" :value="cHr">
                    {{ cHr }}
                  </option>
                </select>
              </div>
            </div>
          </div>
       
          <button
            @click="submit()"
            class="w-1/4 bg-gradient-to-r from-cyan-400 to-cyan-600 text-white text-2xl py-2 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:cyan-600 mb-2"
          >
            Register
          </button>
        </div>
        <div class="text-center"></div>
        <p class="text-xs text-gray-600 text-center mt-8">&copy; 2024 Igsoon</p>
      </div>
    </div>
  </section>
</template>