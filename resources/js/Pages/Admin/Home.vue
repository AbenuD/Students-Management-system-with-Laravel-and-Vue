<template>
    <div class="leading-normal tracking-normal" id="main-body">
      <div class="flex flex-wrap">
  
        <Sidebar />
  
        <div class="w-full bg-gray-100 pl-0 lg:pl-64 min-h-screen"  id="main-content">
  
          <Navbar />
  
          <div class="p-6 bg-gray-100 mb-20">
            <Dashboard/>
          </div>
  
          <Footer />
  
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { mapState } from 'vuex'
  
  import Dashboard from '../../Components/Dashboard.vue'
  import Sidebar from '../../Components/Sidebar.vue'
  import Navbar from '../../Components/Navbar.vue'
  import Footer from '../../Components/Footer.vue'
  
  
  // mapState(['sideBarOpen'])
    
  </script>
  