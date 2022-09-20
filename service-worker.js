cacheName = 'sikembang-v1'
filesToCache = [
   'https://192.168.43.39/sikembang/index.php/Frontpage',
   'https://192.168.43.39/sikembang/assets/css/all.min.css',
   'https://192.168.43.39/sikembang/assets/css/adminlte.min.css',
   'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
   'https://192.168.43.39/sikembang/assets/js/jquery.min.js',
   'https://192.168.43.39/sikembang/assets/js/bootstrap.bundle.min.js',
   'https://192.168.43.39/sikembang/logo-sikembang.jpeg',
   // 'https://fonts.gstatic.com/s/sourcesanspro/v21/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7lujVj9w.woff2',
   'https://192.168.43.39/sikembang/assets/webfonts/fa-solid-900.woff2',
   // 'https://fonts.gstatic.com/s/sourcesanspro/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3ig4vwlxdu3cOWxw.woff2',
   'https://192.168.43.39/favicon.ico',
   'https://192.168.43.39/sikembang/manifest.json',
   'https://192.168.43.39/sikembang/icon.png'
]

self.addEventListener('install', function (event) {
   var cacheAll = caches
      .open(cacheName)
      .then(function (cache) {
         return cache.addAll(filesToCache)
      })
   event.waitUntil(cacheAll)
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
      fetch(event.request).then(response => response).catch (e => {console.log(event.request.url, isOnline)}):
      caches.open(cacheName).then(cache => cache.match(event.request))
   )
})