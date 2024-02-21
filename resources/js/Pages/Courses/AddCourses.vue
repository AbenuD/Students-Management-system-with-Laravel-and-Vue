<script setup>
import { ref, watch } from "vue";
import axios from "axios";
import * as XLSX from 'xlsx';
import { toast } from "vue3-toastify";
import { useRouter } from 'vue-router';
import "vue3-toastify/dist/index.css";
import CourseTableHead from "../../Components/CourseTableHead.vue"
const router = useRouter();
const noCourses = ref(1);
const years = ref([]);
const creditHour = [1, 2, 3, 4, 5, 6, 7];

// const departmentId = router.params.departmentId.value;
const departmentId = 1;
const noYears = 5;

const selectedYear = ref(years[0]);
const selectedSemester = ref(0);


  years.value = Array.from(
    { length: noYears },
    (_, index) => index + 1
  );
  const manualInput = ref({
    courseName: '',
    creditHour: null,
    // Add more properties for other manual input fields
  });

  const headers = ref([]);
  const combinedEntries = ref([]);


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


const fileInput = ref(null);
const message = ref(null);
const uploadedFileContent = ref(null);


  const handleFileChange = (event) => {
    fileInput.value = event.target.files[0];
  };


  const previewFile = () => {
    if (!fileInput.value) {
      return;
    }

    const reader = new FileReader();

    reader.onload = (e) => {
      const data = new Uint8Array(e.target.result);
      const workbook = XLSX.read(data, { type: 'array' });

      // Assuming that the first sheet is the one you want to read
      const sheetName = workbook.SheetNames[0];
      const worksheet = workbook.Sheets[sheetName];

      // Convert the worksheet to JSON
      const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

      // Extract headers
      headers.value = jsonData.shift();

      // Assign the data to the uploadedFileContent
      uploadedFileContent.value = jsonData.map(row =>
        headers.value.reduce((acc, header, index) => {
          acc[header] = row[index];
          return acc;
        }, {})
      );
    };

    reader.readAsArrayBuffer(fileInput.value);
  };



const deleteEntry = (index) => {
  uploadedFileContent.value.splice(index, 1);
};



const submitEntries = async () => {
  try {
    // Combine uploadedFileContent and manual entries for submission
    const allEntries = [...uploadedFileContent.value];
    // Perform Axios request to submit all entries
    await axios.post('/api/upload-courses', { entries: allEntries });
    // Reset entries and show success message
    uploadedFileContent.value = null;
    message.value = 'Entries submitted successfully';
  } catch (error) {
    console.error('Error submitting entries:', error);
    message.value = 'Error submitting entries';
  }
};





</script>
<template>
  <!-- <section class="bg-[url('../Images/background.jpg')]"> -->
  <section >
    <div class="min-h-screen flex items-center justify-center mx-5">
      <div class="max-w-3/4 w-3/4 p-6 bg-white rounded-lg shadow-lg">
      

        <h1 class="text-2xl font-semibold text-center text-gray-500 mt-8 mb-6">
          Add Courses
        </h1>
        <div class="flex gap-4">

 
          <div class="mb-4">
            <label for="uploadCourses" class="block mb-2 text-sm text-gray-600">
              Choose file
            </label>
            <input
              type="file"
              id="uploadCourses"
              name="uploadCourses"
              ref="fileInput"
              class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
              @change="handleFileChange"/>
          </div>
            <button
              @click="previewFile"
              class="bg-gradient-to-r from-cyan-400 to-cyan-600 text-white text-2xl px-2 py-2 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:cyan-600 mb-2">
              Import
            </button>
        </div>

       <!-- Display uploaded file content -->
    <div v-if="uploadedFileContent" class="table w-full p-2">
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-50 border-b">
             
              <!-- <CourseTableHead> Course Code</CourseTableHead> -->
              <CourseTableHead v-for="header in headers" :key="header"> {{ header }}</CourseTableHead>
              <CourseTableHead> Action</CourseTableHead>
            </tr>
        </thead>
        <tbody>
            <tr 
              class="bg-gray-100 text-center border-b text-sm text-gray-600"
              v-for="(entry, index) in uploadedFileContent" :key="index">
                <td class="p-2 border-r" v-for="header in headers" :key="header">{{ entry[header] }}</td>
                <td>
                    <button class="bg-blue-500 p-2 text-white hover:shadow-lg text-xs font-thin">Edit</button>
                    <button @click="deleteEntry(index)" class="bg-red-500 p-2 text-white hover:shadow-lg text-xs font-thin">Remove</button>
                </td>
            </tr>

        </tbody>
    </table>
    <button
      @click="submitEntries"
      class="w-1/4 bg-gradient-to-r from-cyan-400 to-cyan-600 text-white text-2xl py-2 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:cyan-600 mb-2">
      Submit
    </button>
  </div>



  
        <div class="text-center"></div>
        <p class="text-xs text-gray-600 text-center mt-8">&copy; 2024 Igsoon</p>
      </div>
    </div>
  </section>
</template>