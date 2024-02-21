<template>
    <div class="w-full h-screen sm:w-full h-50 text-white py-20 bg-[url('../Images/background.jpg')] bg-opacity-35">
        <div class="container mx-auto flex flex-col md:flex-row items-center my-12 md:my-24 font-serif">
            <div class="flex flex-col w-full justify-center items-center p-8 space-y-10">
                <h1 class="text-9xl text-yellow-500 font-serif">Igsoon</h1>
                <router-link to="/login"
                    class="bg-transparent hover:bg-yellow-300 text-xl text-white hover:text-black rounded shadow py-2 px-4 border border-yellow-300">
                    Continue</router-link>
            </div>
        </div>
    </div>
</template>
