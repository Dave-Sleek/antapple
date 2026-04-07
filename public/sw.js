const CACHE_NAME = "jobs-cache-v1";

const urlsToCache = [
    "/",
    "/offline",
    // "/css/app.css",
    // "/js/app.js"
     "/manifest.json",
    "/icons/icon-192.png",
    "/icons/icon-512.png"
];

// Install
self.addEventListener("install", event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

// Fetch
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
            .catch(() => caches.match("/offline"))
    );
});


// self.addEventListener("fetch", event => {
//     event.respondWith(
//         caches.open(CACHE_NAME).then(cache =>
//             fetch(event.request)
//                 .then(response => {
//                     cache.put(event.request, response.clone());
//                     return response;
//                 })
//                 .catch(() => cache.match(event.request))
//         )
//     );
// });
