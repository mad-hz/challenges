<template>
    <main class="max-w-6xl mx-auto p-2 sm:p-3 w-full">
        <article v-if="store.error" class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-4" role="alert">
            <h2 class="font-bold">Error!</h2>
            <p>{{ store.error }}</p>
        </article>

        <section v-if="store.isLoading" class="text-center py-8">
            <svg class="animate-spin h-12 w-12 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <p class="mt-2 text-gray-600">Loading news articles...</p>
        </section>

        <ul v-else class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-2 sm:gap-3">
            <li v-for="(article, index) in store.articles" :key="index">
                <ArticleCard :article="article" :index="index" />
            </li>
        </ul>
    </main>
</template>

<script setup>
import { onMounted } from 'vue'
import ArticleCard from '@/components/ArticleCard.vue'
import { store } from '@/store'

onMounted(() => {
    if (store.articles.length === 0) {
        store.fetchNews()
    }
})
</script>