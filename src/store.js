import { reactive } from 'vue'

export const store = reactive({
    articles: [],
    isLoading: false,
    error: null,

    async fetchNews() {
        this.isLoading = true;
        this.error = null;

        try {
            const API_KEY = 'acb7404e1ba14c258ab41ac7aabf50ff';
            const targetUrl = `https://newsapi.org/v2/everything?q=bmw&sortBy=publishedAt&apiKey=${API_KEY}`;
            const proxyUrl = 'https://api.allorigins.win/raw?url=' + encodeURIComponent(targetUrl);

            const response = await fetch(proxyUrl);

            if (!response.ok) {
                throw new Error(`News fetch failed: ${response.status}`);
            }

            const data = await response.json();

            if (data.status !== 'ok' || !data.articles.length) {
                throw new Error('No news articles available');
            }

            this.articles = data.articles.map(article => ({
                ...article,
                safeImageUrl: this.getSafeImageUrl(article.urlToImage),
                imageLoaded: false
            }));
        } catch (err) {
            this.error = err.message;
        } finally {
            this.isLoading = false;
        }
    },

    getSafeImageUrl(originalUrl) {
        if (!originalUrl) return 'https://picsum.photos/800/450';

        try {
            const url = new URL(originalUrl);
            const hostname = url.hostname;

            if (hostname.includes('s.yimg.com') ||
                hostname.includes('media.zenfs.com') ||
                hostname.includes('nypost.com')) {
                return 'https://picsum.photos/800/450';
            }

            return originalUrl;
        } catch {
            return 'https://picsum.photos/800/450';
        }
    },

    formatDate(dateString) {
        return new Date(dateString).toLocaleDateString();
    },

    formatDateDetail(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
});