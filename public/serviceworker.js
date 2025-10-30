const CACHE_NAME = 'pewaca-pwa-v2';
const OFFLINE_URL = '/offline';

// Critical assets to cache on install
const ASSETS_TO_CACHE = [
    OFFLINE_URL,
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-512x512.png',
    '/assets/bootstrap/dist/css/bootstrap-5.min.css',
    '/assets/bootstrap/dist/js/bootstrap-5.min.js',
];

// Install event - cache critical assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('[Service Worker] Caching critical assets');
                return cache.addAll(ASSETS_TO_CACHE).catch(err => {
                    console.error('[Service Worker] Failed to cache some assets:', err);
                });
            })
            .then(() => self.skipWaiting())
    );
});

// Activate event - cleanup old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys()
            .then(cacheNames => {
                return Promise.all(
                    cacheNames
                        .filter(cacheName => cacheName.startsWith('pewaca-pwa-') && cacheName !== CACHE_NAME)
                        .map(cacheName => {
                            console.log('[Service Worker] Deleting old cache:', cacheName);
                            return caches.delete(cacheName);
                        })
                );
            })
            .then(() => self.clients.claim())
    );
});

// Fetch event - Network First with Cache Fallback
self.addEventListener('fetch', event => {
    // Skip non-GET requests
    if (event.request.method !== 'GET') {
        return;
    }

    const url = new URL(event.request.url);
    
    // Handle same-origin requests only
    if (url.origin !== location.origin) {
        return;
    }

    event.respondWith(
        // Try network first
        fetch(event.request)
            .then(response => {
                // Only cache successful responses for static assets
                if (response && response.status === 200) {
                    // Cache static assets (images, CSS, JS) but skip API and dynamic content
                    const shouldCache = url.pathname.match(/\.(png|jpg|jpeg|gif|webp|svg|css|js|woff|woff2|ttf|eot)$/i) ||
                                       url.pathname.startsWith('/assets/') ||
                                       url.pathname.startsWith('/images/');
                    
                    if (shouldCache) {
                        const responseClone = response.clone();
                        caches.open(CACHE_NAME)
                            .then(cache => {
                                cache.put(event.request, responseClone);
                            })
                            .catch(err => console.error('[Service Worker] Cache put error:', err));
                    }
                }
                return response;
            })
            .catch(() => {
                // Network failed, try cache
                return caches.match(event.request)
                    .then(cachedResponse => {
                        if (cachedResponse) {
                            console.log('[Service Worker] Serving from cache:', url.pathname);
                            return cachedResponse;
                        }
                        
                        // For navigation requests, serve offline page
                        if (event.request.mode === 'navigate') {
                            return caches.match(OFFLINE_URL);
                        }
                        
                        // For other requests, throw error
                        return new Response('Network error', {
                            status: 408,
                            headers: { 'Content-Type': 'text/plain' }
                        });
                    });
            })
    );
});
