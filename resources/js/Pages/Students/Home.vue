<script setup>
import axios from "axios";
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router'
const router = useRouter()
const user = ref({});
function getUser(){
    axios.get('/api/user').then((res) => {
            user.value = res.data;
            console.log(user.value);
            });
}
function logout(){
    axios.post('/api/logout').then(() => { router.push('/login') })
}
onMounted(getUser());


</script>
<template>
    <div> Welcome  <br>
        Name: {{ user.name }}  <br>
        Email: {{ user.email }} 
     </div> 
<button @click="logout()">logout</button>
</template>