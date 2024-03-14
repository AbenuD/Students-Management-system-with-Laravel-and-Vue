<script setup>
import axios from 'axios';
import {ref,onMounted} from 'vue'
function getDepartments(){
    axios.get("/departments")
         .then((response)=>{
            console.log(response.data)
         })
         .catch((error)=>{
            console.error();
         })
}
</script>
<template>
    
</template>