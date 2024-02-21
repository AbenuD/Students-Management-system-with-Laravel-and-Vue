<script setup>
import { ref } from "vue";

    const show1 = ref(false);
    const show2= ref(false);
    const show3 = ref(false);
    const show4 = ref(false);
    const show5 = ref(false);
    const semister = ref(false)
</script>
<template>
<div class="flex space-x-5">

    <section class="flex flex-col items-center justify-center space-y-10 bg-sky-300 px-4 py-3 w-1/4">
        <div @click="show1=!show1" class="w-full border-b bottom-4 text-lg flex items-center font-bold mb-3 py-10">1st Year</div>
            <div v-show="show1">
                <div class="w-full border-b bottom-4 text-lg flex items-center mb-3">1st Semister</div>
                <div class="w-full border-b bottom-4 text-lg flex items-center mb-3">2nd Semister</div>
            </div>
        <div @click="show2=!show2" class="w-full border-b bottom-4 text-lg flex items-center font-bold mb-3 py-10">2nd Year</div>
            <div v-show="show2">
                <div class="w-full border-b bottom-4 text-lg flex items-center mb-3">1st Semister</div>
                <div class="w-full border-b bottom-4 text-lg flex items-center mb-3">2nd Semister</div>
            </div>
        <div @click="show3=!show3" class="w-full border-b bottom-4 text-lg flex items-center font-bold mb-3 py-10">3rd Year</div>
            <div v-show="show3">
                <div class="w-full border-b bottom-4 text-lg flex items-center mb-3">1st Semister</div>
                <div class="w-full border-b bottom-4 text-lg flex items-center mb-3">2nd Semister</div>
            </div>
        <div @click="show4=!show4" class="w-full border-b bottom-4 text-lg flex items-center font-bold mb-3 py-10">4th Year</div>
            <div v-show="show4">
                <div class="w-full border-b bottom-4 text-lg flex items-center mb-3">1st Semister</div>
                <div class="w-full border-b bottom-4 text-lg flex items-center mb-3">2nd Semister</div>
            </div>
        <div @click="show5=!show5" class="w-full border-b bottom-4 text-lg flex items-center font-bold mb-3 py-10">5th Year</div>
            <div v-show="show5">
                <div class="w-full border-b bottom-4 text-lg flex items-center mb-3">1st Semister</div>
                <div class="w-full border-b bottom-4 text-lg flex items-center mb-3">2nd Semister</div>
            </div>
    </section>
  <!-- <section class="bg-[url('../Images/background.jpg')]"> -->
    <section class="w-3/4">
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
</div>
</template>