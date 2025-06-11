<template>
    <article class="bg-white rounded-md shadow-md hover:shadow-lg transition-all h-full">
        <router-link :to="{ name: 'article', params: { index } }" class="block h-full no-underline hover:no-underline">
            <figure class="aspect-video overflow-hidden rounded-t-md relative bg-gray-200">
                <img class="w-full h-full object-cover transition-opacity duration-300"
                    :class="{ 'opacity-0': !article.imageLoaded }" :src="article.safeImageUrl"
                    :alt="article.title || 'News image'" @load="article.imageLoaded = true" />
                <svg v-if="!article.imageLoaded" class="absolute inset-0 w-full h-full text-gray-300 animate-pulse"
                    viewBox="0 0 24 24">
                    <rect width="100%" height="100%" fill="currentColor" />
                </svg>
            </figure>
            <header class="p-1.5 flex flex-col flex-grow">
                <h3 class="text-sm sm:font-medium text-gray-800 mb-1">{{ article.title || 'No title available' }}</h3>
                <p class="text-xs text-gray-600 mb-2 flex-grow">{{ article.description || 'No description available' }}
                </p>
                <footer class="flex justify-between items-center text-xs text-gray-500">
                    <p>{{ article.author ? `by: ${article.author}` : 'Source: BBC News' }}</p>
                    <time :datetime="article.publishedAt">{{ store.formatDate(article.publishedAt) }}</time>
                </footer>
            </header>
        </router-link>
    </article>
</template>

<script setup>
import { defineProps } from 'vue'
import { store } from '@/store'

const props = defineProps({
    article: {
        type: Object,
        required: true
    },
    index: {
        type: Number,
        required: true
    }
})
</script>