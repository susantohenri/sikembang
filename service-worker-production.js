var cacheName = 'sikembang-v1'
var filesToCache = [
    'https://sikembang.com/',
    'https://sikembang.com/manifest-development.json',
    'https://sikembang.com/icon.png',

    'https://sikembang.com/index.php/Pengukuran',
    'https://sikembang.com/index.php/Pengukuran/create',
    'https://sikembang.com/index.php/posyandubumil',
    'https://sikembang.com/index.php/posyandubumil/create',
    'https://sikembang.com/assets/css/dataTables.bootstrap4.css',
    'https://sikembang.com/assets/js/jquery.dataTables.min.js',
    'https://sikembang.com/assets/js/dataTables.bootstrap4.js',
    'https://sikembang.com/assets/js/table.js',
    'https://sikembang.com/assets/css/select2.min.css',
    'https://sikembang.com/assets/css/bootstrap-datepicker.css',
    'https://sikembang.com/assets/js/moment.min.js',
    'https://sikembang.com/assets/js/bootstrap-datepicker.js',
    'https://sikembang.com/assets/js/daterangepicker.min.js',
    'https://sikembang.com/assets/js/select2.full.min.js',
    'https://sikembang.com/assets/js/form_pengukuran.js',

    'https://sikembang.com/assets/css/all.min.css',
    'https://sikembang.com/assets/css/adminlte.min.css',
    'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
    'https://sikembang.com/assets/js/jquery.min.js',
    'https://sikembang.com/assets/js/bootstrap.bundle.min.js',
    'https://sikembang.com/assets/js/offline.js',
    'https://sikembang.com/logo-sikembang.jpeg',
    'https://sikembang.com/assets/webfonts/fa-solid-900.woff2',
    'https://fonts.gstatic.com/s/sourcesanspro/v21/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7lujVj9w.woff2',
    'https://fonts.gstatic.com/s/sourcesanspro/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3ig4vwlxdu3cOWxw.woff2',
    'https://sikembang.com/favicon.ico'
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
    event.respondWith(
        caches.open(cacheName).then(cache => cache.match(event.request.url.replace('https://sikembang.com/', '/')))
    )
})