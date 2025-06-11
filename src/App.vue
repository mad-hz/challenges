<template>
    <div class="bg-gray-50 min-h-screen flex flex-col">
        <Navbar />
        <router-view class="flex-grow" />
    </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue'
</script>
