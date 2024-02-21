<template>
    <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
        <div class="flex items-center justify-center">
            <slot></slot>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
            </svg>
        </div>
    </th>
</template>