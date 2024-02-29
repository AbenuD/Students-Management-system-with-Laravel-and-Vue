<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import Navbar from "../../Components/Navbar.vue"
const router = useRouter();
const option = ref(false);
const user = ref({});
function getUser() {
    axios.get("/api/user").then((response) => {
        user.value = response.data;
        console.log(user.value);
    });
}
function logout() {
    axios.post("/api/logout").then(() => {
        router.push("/login");
    });
}
onMounted(() => {
    getUser();
});
</script>
<template>
    <!-- Header -->
    <!-- component -->
    <Navbar />
    <!-- component -->
    <div class="h-screen flex flex-col bg-gray-100 shadow-xl overflow-y-scroll">
        <div class="bg-sky-300 shadow-lg pb-3 rounded-b-3xl">
            <div class="grid px-7 py-2 items-center justify-around grid-cols-3 gap-4 divide-x divide-solid">
                <div class="col-span-1 flex flex-col items-center">
                    <span class="text-2xl font-bold">Collage</span>
                    <span class="text-lg font-medium 0">{informatics collage}</span>
                </div>
                <div class="col-span-1 px-3 flex flex-col items-center">
                    <span class="text-2xl font-bold">Department</span>
                    <span class="text-lg font-medium">{information system}</span>
                </div>
                <div class="col-span-1 px-3 flex flex-col items-center">
                    <span class="text-2xl font-bold">Batch</span>
                    <span class="text-lg font-medium">{4th Year}</span>
                </div>
            </div>
        </div>

        <div
            class="grid grid-rows-3 rounded-2xl divide-y divide-dashed hover:divide-solid justify-evenly bg-gray-50 m-3 mt-10 grid-cols-3">
   
            <div class="col-span-1 p-3 hover:bg-gray-100 hover:text-blue-600 ">
                <div class="flex flex-col items-center">
                    <a href="">
                        <button class="tr-300">
                          <svg class="h-14 w-14 "
                              viewBox="0 0 512 512"
                              stroke="currentColor"
                              fill="currentColor"
                              stroke-width="2">

                           
                              <path d="M81.876,169.851v-68.266l67.776,43.851v55.916c0,0,0.351-0.157,0.942-0.416
                                c1.042,29.01,13.236,55.26,32.406,74.413c20.057,20.075,47.858,32.517,78.474,32.508c30.616,0.01,58.427-12.432,78.474-32.508
                                c19.179-19.153,31.373-45.403,32.407-74.413c0.599,0.259,0.95,0.416,0.95,0.416v-55.916l86.412-55.906L261.473,0L63.24,89.531
                                v80.32c-6.277,1.486-10.956,7.089-10.956,13.817v4.07H92.84v-4.07C92.84,176.94,88.151,171.337,81.876,169.851z M170.889,194.385
                                c22.282-5.345,58.454-8.464,90.584,14.02c32.13-22.484,68.312-19.365,90.593-14.02c0.018,0.831,0.055,1.66,0.055,2.491
                                c0,25.07-10.125,47.664-26.546,64.104c-16.438,16.42-39.033,26.546-64.102,26.554c-25.059-0.008-47.655-10.134-64.093-26.554
                                c-16.42-16.439-26.546-39.034-26.555-64.104C170.825,196.045,170.871,195.216,170.889,194.385z"/>
                              <path d="M52.284,219.592c0,7.864,6.368,14.232,14.233,14.232h12.091c7.854,0,14.232-6.369,14.232-14.232v-23.38H52.284
                                V219.592z"/>
                              <path d="M326.989,314.024c0,0-3.185,2.547-8.926,5.861l-56.589,95.761l-56.589-95.761
                                c-5.741-3.314-8.925-5.861-8.925-5.861c-51.209,22.586-72.29,76.812-72.29,119.732c0,42.929,0,78.244,0,78.244h275.619
                                c0,0,0-35.315,0-78.244C399.288,390.836,378.197,336.61,326.989,314.024z"/>
                           
                          </svg>
                            <span class="text-lg font-medium">Student</span>
                        </button>
                      </a>
                </div>
            </div>            
            <div class="col-span-1 p-3 hover:bg-gray-100 hover:text-blue-600 ">
                <div class="flex flex-col items-center">
                    <a href="">
                        <button class="tr-300">
                            <svg
                                class="h-14 w-14 "
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                              <path
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                              />
                            </svg>
                            <span class="text-lg font-medium">Grade</span>
                        </button>
                      </a>
                </div>
            </div>
            <div class="col-span-1 p-3 hover:bg-gray-100 hover:text-blue-600">
                <div class="flex flex-col items-center">
                    <a href="">
                        <button class="tr-300">
                            <svg
                                class="h-14 w-14"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"
                                />
                            </svg>
                            <span class="text-lg font-medium">News</span>
                        </button></a
                    >
                </div>
            </div>
            <div class="col-span-1 p-3 hover:bg-gray-100 hover:text-blue-600">
                <div class="flex flex-col items-center">
                    <a href="">
                        <button class="tr-300">
                            <svg
                                class="h-14 w-14 "
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                            <span class="text-lg font-medium">Materials</span>
                        </button></a
                    >
                </div>
            </div>
            <div class="col-span-1 p-3 hover:bg-gray-100 hover:text-blue-600">
                <div class="flex flex-col items-center">
                    <a href="">
                        <button class="tr-300">
                            <svg
                                class="h-14 w-14 "
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>
                            <span class="text-lg font-medium">Email</span>
                        </button></a
                    >
                </div>
            </div>


            <div class="col-span-1 p-3 hover:bg-gray-100 hover:text-blue-600">
                <div class="flex flex-col items-center">
                    <a href="">
                        <button class="tr-300 ">
                          <svg class="w-14 h-14" 
                          viewBox="0 0 24 24"
                          fill="currentColor">
                            <path  d="M7.857 10H2.142C.962 10 0 9.04 0 7.857V2.143C0 .96.96 0 2.142 0h5.715C9.04 0 10 .96 10 2.143v5.714C10 9.04 9.04 10 7.857 10zM2.142 2C2.066 2 2 2.067 2 2.143v5.714c0 .076.066.143.142.143h5.715C7.933 8 8 7.933 8 7.857V2.143C8 2.067 7.933 2 7.857 2H2.142zM7.857 24H2.142C.962 24 0 23.04 0 21.857v-5.715C0 14.962.96 14 2.142 14h5.715C9.04 14 10 14.96 10 16.143v5.715C10 23.038 9.04 24 7.857 24zm-5.715-8c-.076 0-.142.066-.142.143v5.715c0 .076.066.142.142.142h5.715c.076 0 .143-.066.143-.143v-5.715c0-.076-.067-.142-.143-.142H2.142zM21.857 24h-5.715C14.96 24 14 23.04 14 21.857v-5.715C14 14.96 14.96 14 16.142 14h5.715C23.04 14 24 14.96 24 16.14v5.715C24 23.04 23.037 24 21.856 24zm-5.715-8c-.076 0-.143.066-.143.143v5.715c0 .076.065.143.142.143h5.715c.076 0 .143-.065.143-.142v-5.715c0-.076-.066-.143-.143-.143h-5.715zM17.818 12.364c-.55 0-1.098-.208-1.516-.626l-4.04-4.04c-.837-.836-.837-2.196 0-3.03L16.3.625c.808-.808 2.225-.807 3.03 0l4.04 4.04c.837.835.837 2.195 0 3.03l-4.04 4.04c-.418.42-.967.628-1.514.628zm0-10.364c-.028 0-.067.007-.102.04l-4.04 4.04c-.055.055-.055.15 0 .203l4.04 4.04c.055.055.147.056.202 0l4.04-4.04c.055-.054.055-.148 0-.202l-4.04-4.04c-.034-.033-.073-.04-.1-.04z"/>
                          </svg>
                            <span class="text-lg font-medium mt-10">Registeration</span>
                        </button>
                        </a>
                </div>
            </div>



            <div class="col-span-1 p-3 hover:bg-gray-100 hover:text-blue-600">
                <div class="flex flex-col items-center">
                    <a href="">
                        <button class="tr-300">
                          <svg  class="h-14 w-14"
                          viewBox="0 0 24 24" 
                          fill="currentColor">
                            <path d="M12,14a1,1,0,1,0-1-1A1,1,0,0,0,12,14Zm5,0a1,1,0,1,0-1-1A1,1,0,0,0,17,14Zm-5,4a1,1,0,1,0-1-1A1,1,0,0,0,12,18Zm5,0a1,1,0,1,0-1-1A1,1,0,0,0,17,18ZM7,14a1,1,0,1,0-1-1A1,1,0,0,0,7,14ZM19,4H18V3a1,1,0,0,0-2,0V4H8V3A1,1,0,0,0,6,3V4H5A3,3,0,0,0,2,7V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V7A3,3,0,0,0,19,4Zm1,15a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V10H20ZM20,8H4V7A1,1,0,0,1,5,6H19a1,1,0,0,1,1,1ZM7,18a1,1,0,1,0-1-1A1,1,0,0,0,7,18Z"/></svg>
                            <span class="text-lg font-medium">Schedule</span>
                        </button></a
                    >
                </div>
            </div>

            <div class="col-span-1 p-3 hover:bg-gray-100 hover:text-blue-600">
                <div class="flex flex-col items-center">
                    <a href="">
                        <button class="tr-300">
                          <svg class="h-14 w-14"
                            viewBox="0 0 28 28" 
                            fill="currentColor">
                            <path d="M3.9997,3 L5.9897,3 C7.04351818,3 7.9078157,3.81639669 7.98421089,4.85080841 L7.9897,5 L7.9897,23 C7.9897,24.0538182 7.17330331,24.9181157 6.13889159,24.9945109 L5.9897,25 L3.9997,25 C2.94588182,25 2.0815843,24.1836033 2.00518911,23.1491916 L1.9997,23 L1.9997,5 C1.9997,3.94618182 2.81609669,3.0818843 3.85050841,3.00548911 L3.9997,3 L5.9897,3 L3.9997,3 Z M10.9947,3 L12.9897,3 C14.0435182,3 14.9078157,3.81639669 14.9842109,4.85080841 L14.9897,5 L14.9897,23 C14.9897,24.0538182 14.1733033,24.9181157 13.1388916,24.9945109 L12.9897,25 L10.9947,25 C9.93992727,25 9.07649752,24.1836033 9.00018319,23.1491916 L8.9947,23 L8.9947,5 C8.9947,3.94618182 9.81018554,3.0818843 10.8453842,3.00548911 L10.9947,3 L12.9897,3 L10.9947,3 Z M20.1303,5.0264 C20.9735941,5.0264 21.7460232,5.56408858 22.0232306,6.38601897 L22.0693,6.5434 L25.9293,22.0264 C26.1851182,23.0487182 25.6026719,24.0847037 24.6168316,24.4098625 L24.4733,24.4514 L22.5103,24.9404 C22.3483,24.9804 22.1853,25.0004 22.0253,25.0004 C21.1810647,25.0004 20.4094661,24.4618256 20.1323596,23.6406247 L20.0863,23.4834 L16.2253,8.0004 C15.9704364,6.97617273 16.552926,5.94101157 17.5387684,5.61680139 L17.6823,5.5754 L19.6453,5.0864 C19.8073,5.0464 19.9703,5.0264 20.1303,5.0264 Z M5.9897,4.5 L3.9997,4.5 C3.75525556,4.5 3.55031728,4.67777778 3.50779328,4.91042524 L3.4997,5 L3.4997,23 C3.4997,23.2444444 3.67747778,23.4493827 3.91012524,23.4919067 L3.9997,23.5 L5.9897,23.5 C6.23503333,23.5 6.43928025,23.3222222 6.48163964,23.0895748 L6.4897,23 L6.4897,5 C6.4897,4.75555556 6.31271235,4.55061728 6.07953813,4.50809328 L5.9897,4.5 Z M12.9897,4.5 L10.9947,4.5 C10.7493667,4.5 10.5451198,4.67777778 10.5027604,4.91042524 L10.4947,5 L10.4947,23 C10.4947,23.2444444 10.6716877,23.4493827 10.9048619,23.4919067 L10.9947,23.5 L12.9897,23.5 C13.2350333,23.5 13.4392802,23.3222222 13.4816396,23.0895748 L13.4897,23 L13.4897,5 C13.4897,4.75555556 13.3127123,4.55061728 13.0795381,4.50809328 L12.9897,4.5 Z M20.1303,6.5264 L20.0688,6.53015 L20.0688,6.53015 L20.0073,6.5414 L18.0453,7.0304 C17.8070778,7.08995556 17.6518185,7.31148642 17.6673137,7.54750288 L17.6813,7.6364 L21.5413,23.1204 C21.6063,23.3804 21.8383,23.5004 22.0253,23.5004 L22.086675,23.496525 L22.086675,23.496525 L22.1473,23.4844 L24.1103,22.9954 C24.3485222,22.9358444 24.5037815,22.7151037 24.4882863,22.4785605 L24.4743,22.3894 L20.6133,6.9054 C20.5483,6.6444 20.3173,6.5264 20.1303,6.5264 Z"></path>
                          </svg>
                            <span class="text-lg font-medium">Library</span>
                        </button></a
                    >
                </div>
            </div>












            <div class="col-span-1 bg-red-50 p-3 hover:bg-red-100 hover:text-red-600">
                <div class="flex flex-col items-center">
                    <a href="">
                        <button class="tr-300">
                            <svg
                                class="h-14 w-14 "
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                />
                            </svg>
                            <span class="text-lg font-medium">Logout</span>
                        </button></a
                    >
                </div>
            </div>
        </div>

    </div>
</template>
