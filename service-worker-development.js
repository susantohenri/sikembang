var cacheName = 'sikembang-v1'
var filesToCache = [
    'https://localhost/sikembang/',
    'https://localhost/sikembang/manifest-development.json',
    'https://localhost/sikembang/icon.png',

    'https://localhost/sikembang/index.php/Pengukuran',
    'https://localhost/sikembang/index.php/Pengukuran/create',
    'https://localhost/sikembang/index.php/posyandubumil',
    'https://localhost/sikembang/index.php/posyandubumil/create',
    'https://localhost/sikembang/assets/css/dataTables.bootstrap4.css',
    'https://localhost/sikembang/assets/js/jquery.dataTables.min.js',
    'https://localhost/sikembang/assets/js/dataTables.bootstrap4.js',
    'https://localhost/sikembang/assets/js/table.js',
    'https://localhost/sikembang/assets/css/select2.min.css',
    'https://localhost/sikembang/assets/css/bootstrap-datepicker.css',
    'https://localhost/sikembang/assets/js/moment.min.js',
    'https://localhost/sikembang/assets/js/bootstrap-datepicker.js',
    'https://localhost/sikembang/assets/js/daterangepicker.min.js',
    'https://localhost/sikembang/assets/js/select2.full.min.js',
    'https://localhost/sikembang/assets/js/form_pengukuran.js',

    'https://localhost/sikembang/assets/css/all.min.css',
    'https://localhost/sikembang/assets/css/adminlte.min.css',
    'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
    'https://localhost/sikembang/assets/js/jquery.min.js',
    'https://localhost/sikembang/assets/js/bootstrap.bundle.min.js',
    'https://localhost/sikembang/assets/js/offline.js',
    'https://localhost/sikembang/logo-sikembang.jpeg',
    'https://localhost/sikembang/assets/webfonts/fa-solid-900.woff2',
    'https://fonts.gstatic.com/s/sourcesanspro/v21/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7lujVj9w.woff2',
    'https://fonts.gstatic.com/s/sourcesanspro/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3ig4vwlxdu3cOWxw.woff2',
    'https://localhost/sikembang/favicon.ico'
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
        caches.open(cacheName).then(cache => cache.match(event.request.url.replace('https://localhost/sikembang/', '/sikembang/')))
    )
})