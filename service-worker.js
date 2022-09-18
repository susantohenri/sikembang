var dataCacheName = 'pwa-sikembang-v1'
var cacheName = 'pwa-sikembang-v1'
var dataUrl = 'https://192.168.43.39/sikembang/'
var PATH = dataUrl
var filesToCache = [
   'https://192.168.43.39/sikembang/index.php',
   'https://192.168.43.39/sikembang/assets/css/all.min.css',
   'https://192.168.43.39/sikembang/assets/css/adminlte.min.css',
   'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
   'https://192.168.43.39/sikembang/assets/js/jquery.min.js',
   'https://192.168.43.39/sikembang/assets/js/bootstrap.bundle.min.js',
   'https://192.168.43.39/sikembang/logo-sikembang.jpeg',
   'https://192.168.43.39/sikembang/assets/webfonts/fa-solid-900.woff2',
   'https://fonts.gstatic.com/s/sourcesanspro/v21/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7lujVj9w.woff2',
   'https://fonts.gstatic.com/s/sourcesanspro/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3ig4vwlxdu3cOWxw.woff2',
   'https://192.168.43.39/favicon.ico'
]
self.addEventListener('install', function (e) {
   console.log('install')
   e.waitUntil(
      caches
         .open(cacheName)
         .then(function (cache) {
            return cache.addAll(filesToCache)
         })
   )
})
self.addEventListener('activate', function (e) {
   console.log('activate')
   e.waitUntil(caches.keys().then(function (keyList) {
      return Promise.all(keyList.map(function (key) {
         if (key !== cacheName) return caches.delete(key)
      }))
   }))
})
self.addEventListener('fetch', function (event) {
   // if ([
   //    'https://192.168.43.39/sikembang/index.php',
   //    'https://192.168.43.39/sikembang/assets/css/all.min.css',
   //    'https://192.168.43.39/sikembang/assets/css/adminlte.min.css',
   //    'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
   //    'https://192.168.43.39/sikembang/assets/js/jquery.min.js',
   //    'https://192.168.43.39/sikembang/assets/js/bootstrap.bundle.min.js',
   //    'https://192.168.43.39/sikembang/logo-sikembang.jpeg',
   //    'https://192.168.43.39/sikembang/assets/webfonts/fa-solid-900.woff2',
   //    'https://fonts.gstatic.com/s/sourcesanspro/v21/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7lujVj9w.woff2',
   //    'https://fonts.gstatic.com/s/sourcesanspro/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3ig4vwlxdu3cOWxw.woff2',
   //    'https://192.168.43.39/favicon.ico'
   // ].indexOf(event.request.url) > -1) {
      event.respondWith(
         fetch(event.request)
            .then(response => response)
            .catch(e => {
               return caches
                  .open(cacheName)
                  .then(cache => cache.match(event.request))
                  .catch(e => {
                     console.error('cok!', e)
                  })
            })
      )
   // }
})