const staticAssets = [
    '/',
    '/manifest.json',
    '/index.php',
    '/addvs/*',
    '/css/*',
    '/fonts/*',
    '/images-album/*',
    '/img/*',
    '/js/*',
    '/lightbox/*',
    '/logo/*',
    '/slider-images/*',
    '/spbanner/*',
    '/storage/*',
];

self.addEventListener('install', async event => {
    const cache = await caches.open('DrMalpani');
    cache.addAll(staticAssets);
});

self.addEventListener('fetch', event => {
    const {request} = event;
    const url = new URL(request.url);
    if(url.origin === location.origin) {
        event.respondWith(cacheData(request));
    } else {
        event.respondWith(networkFirst(request));
    }
});

async function cacheData(request) {
    const cachedResponse = await caches.match(request);
    return cachedResponse || fetch(request);
}

async function networkFirst(request) {
    const cache = await caches.open('DrMalpani');

    try {
        const response = await fetch(request);
        cache.put(request, response.clone());
        return response;
    } catch (error){
        return await cache.match(request);

    }
}

// const cacheName = `DrMalpani`;
// self.addEventListener('install', e => {
//   const timeStamp = Date.now();
//   e.waitUntil(
//     caches.open(cacheName).then(cache => {
//       return cache.addAll(staticAssets).then(() => self.skipWaiting());
//     })
//   );
// });

// self.addEventListener('activate', event => {
//   event.waitUntil(self.clients.claim());
// });

// self.addEventListener('fetch', event => {
//   event.respondWith(
//     caches.open(cacheName)
//       .then(cache => cache.match(event.request, {ignoreSearch: true}))
//       .then(response => {
//       return response || fetch(event.request);
//     })
//   );
// });