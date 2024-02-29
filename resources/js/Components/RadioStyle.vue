<script setup>
defineProps({name: String})
</script>
<template>
    <div class="hover:bg-gray-50 flex items-center justify-between px-4 mt-5 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500">
        <h2 class="font-medium text-gray-700">{{name}}</h2>
        <svg
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-9 h-9 text-blue-600 invisible group-[.peer:checked+&]:visible">
            <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
        </svg>
    </div>
</template>