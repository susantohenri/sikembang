var dataCacheName = 'pwa-calculator-v1'
var cacheName = 'pwa-calculator-v1'
var dataUrl = 'https://henri.xsanisty.com/calculator/'
var PATH = dataUrl
var filesToCache = [
   PATH + '/',
   PATH + '/index.html',
   PATH + '/js/jquery-3.2.1.min.js',
   PATH + '/js/main.js',
   PATH + '/css/main.css'
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