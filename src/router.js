import { createRouter, createWebHistory } from 'vue-router'
import HomeView from './views/HomeView.vue'
import ArticleView from './views/ArticleView.vue'

const routes = [
    { path: '/', name: 'home', component: HomeView },
    { path: '/article/:index', name: 'article', component: ArticleView, props: true }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router