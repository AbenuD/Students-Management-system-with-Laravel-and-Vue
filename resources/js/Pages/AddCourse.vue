<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import * as XLSX from "xlsx";
import { toast } from "vue3-toastify";
import Sidebar from "../Components/Sidebar.vue";
import RadioStyle from "../Components/RadioStyle.vue";
import CourseTableHead from "../Components/CourseTableHead.vue";

const form = ref({
    department_id:0,
    year:0,
    semister:0,
});
const departments = ref([]);
function getDepartment(){
    axios.get('api/department/index')
        .then(res => departments.value = res.data)
}
// const courseExcel = ref(null);
const headers = ref([]);
const uploadedFileContent = ref(null);

// function handleFileChange(event) {
//     courseExcel.value = event.target.files[0];
// }
const courseExcel = ref(new FormData());
function handleFileChange(event) {
    const file = event.target.files[0];
    courseExcel.value = new FormData();
    courseExcel.value.append("file", file);
}

const previewFile = () => {
    if (!courseExcel.value.get("file")) {
        return;
    }

    const file = courseExcel.value.get("file");
    const reader = new FileReader();

    reader.onload = (e) => {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: "array" });

        const sheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[sheetName];

        const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

        headers.value = jsonData.shift();

        uploadedFileContent.value = jsonData.map((row) =>
            headers.value.reduce((acc, header, index) => {
                acc[header] = row[index];
                return acc;
            }, {})
        );
    };

    reader.readAsArrayBuffer(file);
};

function submitEntries() {
    if (!uploadedFileContent.value || !courseExcel.value) {
        toast.error("No file selected or invalid file type");
        return;
    }

    // const formData = new FormData();
    // formData.append("file", courseExcel.value);

    for (const key in form.value) {
        courseExcel.value.append(key, form.value[key]);
    }

    axios.post("api/upload-courses", courseExcel.value)
        .then((response) => {
            uploadedFileContent.value = null
             form.value = {}
            toast.success(response.data.message);
        })
        .catch((error) => {
            console.error("Failed",error);
            toast.error(error.response.data.message);
        });
}

const deleteEntry = (index) => {
    uploadedFileContent.value.splice(index, 1);
};

onMounted(() => {
    getDepartment();
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
                                    v-model="form.department_id"
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
                                    v-model="form.year"
                                >
                                    <option value="">Choose the Year</option>
                                    <option value="1">1st Year</option>
                                    <option value="2">2nd Year</option>
                                    <option value="3">3rd Year</option>
                                    <option value="4">4th Year</option>
                                    <option value="5">5th Year</option>
                                </select>
                            </label>
                        </div>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 mt-5 w-full"
                        >
                            <label>
                                <input
                                    type="radio"
                                    :value="1"
                                    class="peer hidden"
                                    name="semister"
                                    v-model="form.semister"
                                />

                                <RadioStyle name="1st Semister" />
                            </label>

                            <label>
                                <input
                                    type="radio"
                                    :value="2"
                                    class="peer hidden"
                                    name="semister"
                                    v-model="form.semister"
                                    
                                />

                                <RadioStyle name="2nd Semister" />
                            </label>
                        </div>
                    </div>

                    <form
                        id="allcourses"
                        class="flex gap-6 items-center"
                        @submit.prevent="previewFile"
                    >
                        <div class="mb-4">
                            <label
                                for="uploadCourses"
                                class="block mb-2 text-sm text-gray-600"
                            >
                                Choose file
                            </label>
                            <input
                                type="file"
                                accept=".xlsx, .xls"
                                id="uploadCourses"
                                name="file"
                                class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                @change="handleFileChange"
                            />
                        </div>
                        <button
                            type="submit"
                            class="bg-sky-600 w-1/5 h-10 text-white text-xl px-2 py-2 rounded-lg block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:bg-cyan-800"
                        >
                            Preview
                        </button>
                    </form>
                </div>
            </div>

            <div v-if="uploadedFileContent" class="table w-full p-2">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <!-- <CourseTableHead> Course Code</CourseTableHead> -->
                            <CourseTableHead
                                v-for="header in headers"
                                :key="header"
                            >
                                {{ header }}</CourseTableHead
                            >
                            <CourseTableHead> Action</CourseTableHead>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="bg-gray-100 text-center border-b text-sm text-gray-600"
                            v-for="(entry, index) in uploadedFileContent"
                            :key="index"
                        >
                            <td
                                class="p-2 border-r"
                                v-for="header in headers"
                                :key="header"
                            >
                                {{ entry[header] }}
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
                <button
                    @click="submitEntries"
                    class="w-1/4 bg-gradient-to-r from-cyan-400 to-cyan-600 text-white text-2xl py-2 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:bg-cyan-600 mb-2"
                >
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>
