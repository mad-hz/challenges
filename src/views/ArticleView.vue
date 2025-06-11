<template>
    <main class="max-w-6xl mx-auto p-2 sm:p-3 w-full">
        <article v-if="article">
            <router-link to="/" class="flex items-center text-blue-600 hover:text-blue-800 mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to News
            </router-link>

            <header class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3">{{ article.title }}</h1>
                <figure class="aspect-video overflow-hidden rounded-lg mb-4 relative bg-gray-200">
                    <img class="w-full h-full object-cover transition-opacity duration-300"
                        :class="{ 'opacity-0': !article.imageLoaded }" :src="article.safeImageUrl" :alt="article.title"
                        @load="article.imageLoaded = true" />
                    <svg v-if="!article.imageLoaded" class="absolute inset-0 w-full h-full text-gray-300 animate-pulse"
                        viewBox="0 0 24 24">
                        <rect width="100%" height="100%" fill="currentColor" />
                    </svg>
                </figure>
                <footer class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-600 mb-4">
                    <p>{{ article.author ? `By ${article.author}` : 'Source: Unknown' }}</p>
                    <time :datetime="article.publishedAt">{{ store.formatDateDetail(article.publishedAt) }}</time>
                </footer>
            </header>

            <section class="text-gray-700 mb-8">
                <p class="text-lg font-medium mb-4">{{ article.description }}</p>
                <p v-if="article.content" class="mb-4">{{ article.content.replace(/\[\+\d+ chars\]$/, '') }}</p>
            </section>

            <footer class="border-t border-gray-200 pt-4">
                <a :href="article.url" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    Read full article
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </footer>
        </article>

        <section v-else-if="store.isLoading" class="text-center py-8">
            <svg class="animate-spin h-12 w-12 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <p class="mt-2 text-gray-600">Loading article...</p>
        </section>

        <section v-else class="text-center py-8">
            <p class="text-red-500">Article not found</p>
            <router-link to="/" class="mt-4 text-blue-600 hover:text-blue-800">Back to home</router-link>
        </section>
    </main>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { store } from '@/store'

const route = useRoute()
const article = ref(null)

// Watch for route changes
watch(() => route.params.index, (newIndex) => {
    loadArticle(newIndex)
})

// Load article on component mount
onMounted(() => {
    loadArticle(route.params.index)
})

const loadArticle = (index) => {
    const articleIndex = parseInt(index)

    if (store.articles.length === 0) {
        store.fetchNews().then(() => {
            if (articleIndex >= 0 && articleIndex < store.articles.length) {
                article.value = store.articles[articleIndex]
            }
        })
    } else if (articleIndex >= 0 && articleIndex < store.articles.length) {
        article.value = store.articles[articleIndex]
    }
}
</script>