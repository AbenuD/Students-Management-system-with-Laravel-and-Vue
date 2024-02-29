<script setup>
import { ref } from 'vue';
  const option = ref(false);
</script>
<template>
     <header class="bg-white w-full">
        <div
            class="mx-auto max-w-7xl px-2 sm:px-4 lg:divide-y lg:divide-teal-700 lg:px-8"
        >
            <div class="relative flex h-16 justify-between">
                <div class="relative z-10 flex px-2 lg:px-0">
                    <div class="flex flex-shrink-0 items-center">
                        <h1>{user.name}</h1>
                    </div>
                </div>
                <div
                    class="relative z-0 flex flex-1 items-center justify-center px-2 sm:absolute sm:inset-0"
                >
                    <div class="w-full sm:max-w-xs">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                            >
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <input
                                id="search"
                                name="search"
                                class="block w-full rounded-md border-0 py-1.5 pl-10 pr-3 text-blue-300 placeholder:text-blue-400 focus:bg-white focus:text-gray-900 focus:ring-0 focus:placeholder: sm:text-sm sm:leading-6"
                                placeholder="Search"
                                type="search"
                            />
                        </div>
                    </div>
                </div>
                <div class="relative z-10 flex items-center lg:hidden"></div>
                <div
                    class="lg:relative lg:z-10 lg:ml-4 lg:flex lg:items-center"
                >
                    <!-- <div>
                        <h1 class="text-h1 mx-4">{ user.name }</h1>
                    </div> -->
                    <button
                        type="button"
                        class="relative flex-shrink-0 rounded-full bg-blue-800 p-1 text-gray-100 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                    >
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">View notifications</span>
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
                            />
                        </svg>
                    </button>

                    <!-- Profile dropdown -->
                    <div class="relative ml-4 flex-shrink-0">
                        <div>
                            <button
                                @click="option = !option"
                                class="relative flex rounded-full bg-gray-800 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                id="user-menu-button"
                                aria-expanded="false"
                                aria-haspopup="true"
                            >
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <img
                                    class="h-8 w-8 rounded-full"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt=""
                                />
                            </button>
                        </div>

                        <!--
            Dropdown menu, show/hide based on menu state.

            Entering: "transition ease-out duration-100"
              From: "transform opacity-0 scale-95"
              To: "transform opacity-100 scale-100"
            Leaving: "transition ease-in duration-75"
              From: "transform opacity-100 scale-100"
              To: "transform opacity-0 scale-95"
          -->
                        <div
                            v-show="option"
                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu"
                            aria-orientation="vertical"
                            aria-labelledby="user-menu-button"
                            tabindex="-1"
                        >
                            <!-- Active: "bg-gray-100", Not Active: "" -->
                            <a
                                href="#"
                                class="block px-4 py-2 text-sm text-yellow-600"
                                role="menuitem"
                                tabindex="-1"
                                id="user-menu-item-0"
                                >Your Profile</a
                            >
                            <a
                                href="#"
                                class="block px-4 py-2 text-sm text-yellow-600"
                                role="menuitem"
                                tabindex="-1"
                                id="user-menu-item-1"
                                >Settings</a
                            >
                            <a
                                href="#"
                                class="block px-4 py-2 text-sm text-yellow-600"
                                role="menuitem"
                                tabindex="-1"
                                id="user-menu-item-2"
                                >Sign out</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

