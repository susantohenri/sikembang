var cacheName = 'sikembang-v1'
var filesToCache = [
    'https://dev.sikembang.com/',
    'https://dev.sikembang.com/assets/css/all.min.css',
    'https://dev.sikembang.com/assets/css/adminlte.min.css',
    'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
    'https://dev.sikembang.com/assets/js/jquery.min.js',
    'https://dev.sikembang.com/assets/js/bootstrap.bundle.min.js',
    'https://dev.sikembang.com/assets/js/offline.js',
    'https://dev.sikembang.com/logo-sikembang.jpeg',
    'https://dev.sikembang.com/assets/webfonts/fa-solid-900.woff2',
    'https://fonts.gstatic.com/s/sourcesanspro/v21/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7lujVj9w.woff2',
    'https://fonts.gstatic.com/s/sourcesanspro/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3ig4vwlxdu3cOWxw.woff2',
    'https://dev.sikembang.com/favicon.ico'
]

self.addEventListener('install', function (event) {
    event.waitUntil(caches
        .open(cacheName)
        .then(function (cache) {
            return cache.addAll(filesToCache)
        }))
})

self.addEventListener('activate', function (event) {
})

self.addEventListener('fetch', function (event) {
    if (filesToCache.indexOf(event.request.url) < 0) return;
    var isOnline = false
    var isPage = -1 === event.request.url.split('/').pop().indexOf('.')
    var isNavigate = 'navigate' === event.request.mode
    var navigatorOnline = navigator.onLine
    isOnline = isPage ? !isNavigate : navigatorOnline

    event.respondWith(
        isOnline ?
            fetch(event.request).then(response => response) :
            caches.open(cacheName).then(cache => cache.match(event.request))
    )
})