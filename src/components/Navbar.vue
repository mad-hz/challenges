<template>
    <nav class="bg-white shadow-sm">
        <section class="max-w-6xl mx-auto flex flex-wrap items-center justify-between p-2 sm:p-4">
            <router-link to="/" class="text-lg sm:text-xl font-semibold text-gray-800">BBC News - M.
                Aldalati</router-link>
            <button @click="menuOpen = !menuOpen"
                class="lg:hidden p-1.5 rounded text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16m-16 6h16" />
                </svg>
            </button>
            <ul :class="{ 'hidden': !menuOpen, 'lg:flex': true }"
                class="flex-col lg:flex-row lg:space-x-4 w-full lg:w-auto">
                <li><router-link to="/"
                        class="block py-1 text-gray-600 hover:text-gray-900 hover:bg-gray-50 lg:hover:bg-transparent">Home</router-link>
                </li>
                <li><a href="https://hz.nl" target="_blank"
                        class="block py-1 text-gray-600 hover:text-gray-900 hover:bg-gray-50 lg:hover:bg-transparent">HZ</a>
                </li>
            </ul>
        </section>
    </nav>
</template>

<script setup>
import { ref } from 'vue'

const menuOpen = ref(false)
</script>