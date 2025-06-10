<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenges</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <nav class="bg-white shadow-sm">
        <section class="max-w-6xl mx-auto flex flex-wrap items-center justify-between p-2 sm:p-4">
            <a href="/" class="text-lg sm:text-xl font-semibold text-gray-800">Challenges</a>
            <button id="menuBtn"
                class="lg:hidden p-1.5 rounded text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16m-16 6h16" />
                </svg>
            </button>
            <ul id="menu"
                class="hidden lg:flex flex-col lg:flex-row lg:space-x-4 w-full lg:w-auto mt-1 sm:mt-2 lg:mt-0">
                <li><a href="/"
                        class="block py-1 text-gray-600 hover:text-gray-900 hover:bg-gray-50 lg:hover:bg-transparent">Home</a>
                </li>
                <li><a href="https://hz.nl" target="_blank"
                        class="block py-1 text-gray-600 hover:text-gray-900 hover:bg-gray-50 lg:hover:bg-transparent">HZ</a>
                </li>
                <li><a href="#"
                        class="block py-1 text-gray-600 hover:text-gray-900 hover:bg-gray-50 lg:hover:bg-transparent">Contact</a>
                </li>
            </ul>
        </section>
    </nav>

    <section class="max-w-6xl mx-auto p-2 sm:p-3">
        <article id="errorContainer" class="hidden"></article>
        <ul class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-2 sm:gap-3" id="newsList">
        </ul>
    </section>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const menu = document.getElementById('menu');
        menuBtn.addEventListener('click', () => menu.classList.toggle('hidden'));
        document.addEventListener('click', (e) => {
            if (!menu.contains(e.target) && !menuBtn.contains(e.target)) menu.classList.add('hidden');
        });
        menu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => menu.classList.add('hidden'));
        });

        async function fetchNews() {
            const API_KEY = 'acb7404e1ba14c258ab41ac7aabf50ff';
            const url = `https://newsapi.org/v2/everything?q=tesla&from=2025-04-27&sortBy=publishedAt&apiKey=${API_KEY}`;
            const newsList = document.getElementById('newsList');
            const errorContainer = document.getElementById('errorContainer');

            try {
                const response = await fetch(url, {
                    headers: {
                        'Referer': window.location.origin,
                        'Accept': 'application/json'
                    }
                });

                if (response.status === 426) {
                    throw new Error('Please use HTTPS protocol for this request');
                }

                if (!response.ok) {
                    throw new Error(`News fetch failed: ${response.status}`);
                }

                const data = await response.json();

                if (data.status !== 'ok' || !data.articles.length) {
                    throw new Error('No news articles available');
                }

                const articles = await Promise.all(data.articles.map(async article => {
                    const li = document.createElement('li');

                    const link = document.createElement('a');
                    link.href = article.url;
                    link.target = '_blank';
                    link.rel = 'noopener noreferrer';
                    link.className = 'block h-full no-underline hover:no-underline';

                    const articleEl = document.createElement('article');
                    articleEl.className = 'bg-white rounded-md shadow-sm hover:shadow-md transition-shadow h-full flex flex-col';

                    const figure = document.createElement('figure');
                    figure.className = 'aspect-video overflow-hidden rounded-t-md flex-shrink-0';

                    const img = document.createElement('img');
                    img.className = 'w-full h-full object-cover';
                    img.src = article.urlToImage || 'https://picsum.photos/400/400';
                    img.alt = article.title || 'News image';
                    img.onerror = () => img.src = 'https://picsum.photos/400/400';

                    const header = document.createElement('header');
                    header.className = 'p-1.5 flex flex-col flex-grow';

                    const title = document.createElement('h3');
                    title.className = 'text-sm sm:font-medium text-gray-800 mb-1';
                    title.textContent = article.title || 'No title available';

                    const description = document.createElement('p');
                    description.className = 'text-xs text-gray-600 mb-2 flex-grow';
                    description.textContent = article.description || 'No description available';

                    const footer = document.createElement('footer');
                    footer.className = 'flex justify-between items-center text-xs text-gray-500';

                    const author = document.createElement('p');
                    author.textContent = article.author ? `by: ${article.author}` : 'Source: BBC News';

                    const time = document.createElement('time');
                    time.dateTime = article.publishedAt;
                    time.textContent = new Date(article.publishedAt).toLocaleDateString();

                    figure.appendChild(img);
                    footer.appendChild(author);
                    footer.appendChild(time);
                    header.appendChild(title);
                    header.appendChild(description);
                    header.appendChild(footer);
                    articleEl.appendChild(figure);
                    articleEl.appendChild(header);
                    link.appendChild(articleEl);
                    li.appendChild(link);

                    return li;
                }));

                newsList.innerHTML = '';
                articles.forEach(li => newsList.appendChild(li));

            } catch (error) {
                errorContainer.classList.remove('hidden');
                errorContainer.innerHTML = `
                <article class="bg-red-100 border border-red-400 text-red-700 p-4 rounded" role="alert">
                    <h2 class="font-bold">Error!</h2>
                    <p>${error.message}</p>
                </article>
            `;
            }
        }

        fetchNews();
    </script>
</body>

</html>