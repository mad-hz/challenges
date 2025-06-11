<template>
    <div class="bg-gray-50 min-h-screen flex flex-col">
        <Navbar />
        <router-view class="flex-grow" />
        <Footer />
    </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
</script>
