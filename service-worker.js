var dataCacheName = 'pwa-sikembang-v1'
var cacheName = 'pwa-sikembang-v1'
var dataUrl = 'https://sikembang.com'
var PATH = dataUrl
var filesToCache = [
   PATH + '/'
]
self.addEventListener('install', function(e) {
   console.log('[ServiceWorker] Install')
   e.waitUntil(caches.open(cacheName).then(function(cache) {
      console.log('[ServiceWorker] Caching app shell')
      return cache.addAll(filesToCache)
   }))
})
self.addEventListener('activate', function(e) {
   console.log('[ServiceWorker] Activate')
   e.waitUntil(caches.keys().then(function(keyList) {
      return Promise.all(keyList.map(function(key) {
         if (key !== cacheName) {
            console.log('[ServiceWorker] Removing old cache', key)
            return caches.delete(key)
         }
      }))
   }))
})
self.addEventListener('fetch', function(e) {
   console.log('[ServiceWorker] Fetch', e.request.url)
   if (e.request.url.indexOf(dataUrl) === 0) {
      e.respondWith(fetch(e.request).then(function(response) {
         return caches.open(dataCacheName).then(function(cache) {
            cache.put(e.request.url, response.clone())
            console.log('[ServiceWorker] Fetched&Cached Data')
            return response;
         })
      }))
   } else {
      e.respondWith(caches.match(e.request).then(function(response) {
         return response || fetch(e.request)
      }))
   }
})