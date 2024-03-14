<script setup>
import { ref } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import RadioStyle from "../../Components/RadioStyle.vue";
const form = ref({
    name: "",
    f_name: "",
    address: "",
    gender: "",
    phone: "",
    age: "",
    email: "",
    cafe: "",
});
const errors = ref({});
const processing = ref(false);
function submit() {
    if (processing.value) return;
    processing.value = true;
    axios
        .post("/api/register/student", form.value)
        .then((response) => {
            errors.value = {};
            console.log(response.data.message);
            toast.success(response.data.message, {
                autoClose: 1000,
            });
            form.value = {};
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
            // toast.error(errors.value, {
            //   autoClose: 1000,
            // });
            // console.log(errors.value)
            if (
                error.response &&
                error.response.status === 401 &&
                error.response.data.message
            ) {
                // Display unauthorized message in toast
                toast.error(error.response.data.message, {
                    autoClose: 3000,
                });
                console.error(error);
            } else if (
                error.response &&
                error.response.data &&
                error.response.data.errors
            ) {
                // Update errors ref to display beside each input field
                errors.value = error.response.data.errors;
                toast.error("Please fix the errors in the form.", {
                    autoClose: 3000,
                });
            } else {
                // Display generic error message in toast
                toast.error(
                    "An error occurred while processing your request.",
                    {
                        autoClose: 3000,
                    }
                );
            }
        })
        .finally(() => (processing.value = false));
}
</script>
<template>
    <section class="bg-[url('../Images/background.jpg')]">
        <div class="min-h-screen flex items-center justify-center mx-5">
            <div class="max-w-3/4 w-full p-6 bg-white rounded-lg shadow-lg">
                <h1
                    class="text-2xl font-semibold text-center text-gray-500 mt-8 mb-6"
                >
                    Register
                </h1>
                <div class="mx-10">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label
                                for="name"
                                class="block mb-2 text-sm text-gray-600"
                            >
                                Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                v-model="form.name"
                                required
                            />
                            <span class="text-red-600" v-if="errors.name">{{
                                errors.name[0]
                            }}</span>
                        </div>
                        <div class="mb-4">
                            <label
                                for="f_name"
                                class="block mb-2 text-sm text-gray-600"
                            >
                                Father Name
                            </label>

                            <input
                                type="text"
                                id="f_name"
                                name="f_name"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                v-model="form.f_name"
                                required
                            />
                            <span class="text-red-600" v-if="errors.f_name">{{
                                errors.f_name[0]
                            }}</span>
                        </div>
                        <div class="mb-4">
                            <label
                                for="address"
                                class="block mb-2 text-sm text-gray-600"
                            >
                                Address
                            </label>

                            <input
                                type="text"
                                id="address"
                                name="address"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                v-model="form.address"
                                required
                            />
                            <span class="text-red-600" v-if="errors.address">{{
                                errors.address[0]
                            }}</span>
                        </div>
                        <div class="mb-4">
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 p-4 w-full"
                            >
                                <label>
                                    <input
                                        type="radio"
                                        :value="1"
                                        class="peer hidden"
                                        v-model="form.gender"
                                        name="gender"
                                    />

                                    <div
                                        class="hover:bg-gray-50 flex items-center justify-between px-4 py-2 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500"
                                    >
                                        <h2 class="font-medium text-gray-700">
                                            Male
                                        </h2>
                                        <svg
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-9 h-9 text-blue-600 invisible group-[.peer:checked+&]:visible"
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
                                        :value="2"
                                        class="peer hidden"
                                        name="gender"
                                        v-model="form.gender"
                                    />
                                    <div
                                        class="hover:bg-gray-50 flex items-center justify-between px-4 py-2 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500"
                                    >
                                        <h2 class="font-medium text-gray-700">
                                            Female
                                        </h2>
                                        <svg
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-9 h-9 text-blue-600 invisible group-[.peer:checked+&]:visible"
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
                            <span class="text-red-600" v-if="errors.gender">{{
                                errors.gender[0]
                            }}</span>
                        </div>
                        <div class="mb-4">
                            <label
                                for="phone"
                                class="block mb-2 text-sm text-gray-600"
                            >
                                Phone
                            </label>

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                v-model="form.phone"
                                required
                            />
                            <span class="text-red-600" v-if="errors.phone">{{
                                errors.phone[0]
                            }}</span>
                        </div>
                        <div class="mb-4">
                            <label
                                for="age"
                                class="block mb-2 text-sm text-gray-600"
                            >
                                Age
                            </label>

                            <input
                                type="text"
                                id="age"
                                name="age"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                v-model="form.age"
                                required
                            />
                            <span class="text-red-600" v-if="errors.age">{{
                                errors.age[0]
                            }}</span>
                        </div>
                        <div class="mb-4">
                            <label
                                for="email"
                                class="block mb-2 text-sm text-gray-600"
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                v-model="form.email"
                                required
                            />
                            <span class="text-red-600" v-if="errors.email">{{
                                errors.email[0]
                            }}</span>
                        </div>
                        <div class="mb-4">
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 p-4 w-full"
                            >
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
                                        :value="2"
                                        class="peer hidden"
                                        name="cafe"
                                        v-model="form.cafe"
                                    />

                                    <RadioStyle name="Non-Cafe" />
                                </label>
                            </div>
                            <span class="text-red-600" v-if="errors.cafe">{{
                                errors.cafe[0]
                            }}</span>
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
                <p class="text-xs text-gray-600 text-center mt-8">
                    &copy; 2024 Igsoon
                </p>
            </div>
        </div>
    </section>
</template>
