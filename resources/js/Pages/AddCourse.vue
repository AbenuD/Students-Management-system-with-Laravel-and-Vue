<script setup>
import { ref } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import Sidebar from "../Components/Sidebar.vue";
import RadioStyle from "../Components/RadioStyle.vue";

const semister = ref(false);
const courseExcel = ref(new FormData());
function handleFileChange(event) {
    const file = event.target.files[0];
    courseExcel.value = new FormData();
    courseExcel.value.append("file", file);
}

function previewFile() {
    if (!courseExcel.value) {
        console.error("No file selected.");
        return;
    }
    axios
        .post("api/upload-courses", courseExcel.value)
        .then((response) => {
            console.log(response.data.message);
            toast.success(response.data.message, {
                autoClose: 1000,
            });
        })
        .catch((error) => {
            console.error(error);
        });
}
</script>
<template>
    <div class="flex flex-row items-center justify-center">
        <div class="w-1/5">
            <Sidebar />
        </div>
      
        <!-- <div class="bg-[url('../Images/background.jpg')]"> -->
        <div class="w-3/4">
         
         <div class="flex space-x-6">
            <div class="mt-5">
                <label class="text-gray-700" for="department">
                    Department
                    <select id="department" class="block px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm w-52 focus:outline-none focus:ring-primary-500 focus:border-primary-500" name="department">
                        <option value="">
                            Choose the Department
                        </option>
                        <option value=1>
                            IS
                        </option>
                        <option value=2>
                           IT
                        </option>
                        <option value=3>
                            CS
                        </option>
                        <option value=4>
                            SW
                        </option>
                    </select>
                </label>
            </div>
            <div class="mt-5">
                <label class="text-gray-700" for="year">
                    Year
                    <select id="year" class="block px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm w-52 focus:outline-none focus:ring-primary-500 focus:border-primary-500" name="year">
                        <option value="">
                            Choose the Year
                        </option>
                        <option value=1>
                            1st Year
                        </option>
                        <option value=2>
                            2nd Year
                        </option>
                        <option value=3>
                            3rd Year
                        </option>
                        <option value=4>
                            4th Year
                        </option>
                        <option value=5>
                            5th Year
                        </option>
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
                  /> 

                <RadioStyle name="1st Semister" />
                </label>

                <label>
                  <input
                    type="radio"
                    :value=2
                    class="peer hidden"
                    name="semister"
                  />

                  <RadioStyle name="2nd Semister" />
                </label>
              </div>
         </div>



            <div class="min-h-screen flex items-center justify-center ">
                <div class="max-w-3/4 w-3/4 p-6 bg-white rounded-lg shadow-lg">
                    <h1
                        class="text-2xl font-semibold text-center text-gray-500 mt-8 mb-6"
                    >
                        Add Courses
                    </h1>
                    <form
                        id="allcourses"
                        class="flex gap-4"
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
                                id="uploadCourses"
                                name="file"
                                ref="fileInput"
                                class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                @change="handleFileChange"
                            />
                        </div>
                        <button
                            type="submit"
                            class="bg-gradient-to-r from-cyan-400 to-cyan-600 text-white text-2xl px-2 py-2 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:cyan-600 mb-2"
                        >
                            Import
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
