<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useAuthStore } from "../../Src/Store/auth.js";
import { toast } from "vue3-toastify";

const router = useRouter();
const authStore = useAuthStore();

const form = ref({
  email: "",
  password: "",
});

const errorText = ref({
  email: "",
  password: "",
  invalid: "",
});

const submit = async () => {
  try {
    await authStore.login(form.value.email, form.value.password);
    
    const role = authStore.role;
    if (!role) {
      throw new Error("Invalid role");
    }

    switch (role) {
      case "student":
        router.push({ name: "StudentHome" });
        break;
      case "dep_head":
        router.push({ name: "TeacherHome" });
        break;
      case "teacher":
        router.push({ name: "TeacherHome" });
        break;
      case "admin":
        router.push({ name: "AdminHome" });
        break;
    }
  } catch (error) {
    console.error(error);
    errorText.value = authStore.error;
    toast.error("Login Failed", { autoClose: 2000 });
  }
};
</script>



<template>
    <section class="bg-[url('../Images/background.jpg')]">
        <div class="min-h-screen flex items-center justify-center mx-5">
            <div class="w-1/2 p-6 bg-white rounded-lg shadow-lg">
                <h1
                    class="text-2xl font-semibold text-center text-gray-500 mt-8 mb-6"
                >
                    Sign up
                </h1>
                <div class="mx-10">
                    <div class="mb-4">
                        <label
                            for="email"
                            class="block mb-2 text-sm text-gray-600"
                        >
                            Email
                        </label>

                        <input
                            type="text"
                            id="email"
                            name="email"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                            v-model="form.email"
                            required
                        />
                        <span class="text-red-600" v-if="errorText && errorText.email">{{
                            errorText.email[0]
                        }}</span>
                    </div>
                    <div class="mb-4">
                        <label
                            for="f_name"
                            class="block mb-2 text-sm text-gray-600"
                        >
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                            v-model="form.password"
                            required
                        />
                        <span
                            class="text-red-600"
                            v-if="errorText && errorText.password"
                            >{{ errorText.password[0] }}</span
                        >
                    </div>

                    <span class="text-red-600" v-if="errorText && errorText.invalid">{{
                        errorText.invalid[0]
                    }}</span>
                    <button
                        @click="submit()"
                        class="w-1/4 bg-gradient-to-r from-cyan-400 to-cyan-600 text-white text-2xl py-2 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600 hover:cyan-600 mb-2"
                    >
                        Login
                    </button>

                    <div class="text-center"></div>
                    <p class="text-xs text-gray-600 text-center mt-8">
                        &copy; 2024 Igsoon
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
