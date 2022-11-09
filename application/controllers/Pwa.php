<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pwa extends CI_Controller
{

    function serviceWorker()
    {
        $base_url = base_url();
        echo "
            var cacheName = 'sikembang-v1'
            var filesToCache = [
                '{$base_url}',
                '{$base_url}assets/css/all.min.css',
                '{$base_url}assets/css/adminlte.min.css',
                'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
                '{$base_url}assets/js/jquery.min.js',
                '{$base_url}assets/js/bootstrap.bundle.min.js',
                '{$base_url}assets/js/offline.js',
                '{$base_url}logo-sikembang.jpeg',
                '{$base_url}assets/webfonts/fa-solid-900.woff2',
                'https://fonts.gstatic.com/s/sourcesanspro/v21/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7lujVj9w.woff2',
                'https://fonts.gstatic.com/s/sourcesanspro/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3ig4vwlxdu3cOWxw.woff2',
                '{$base_url}favicon.ico'
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
        ";
    }

    function manifest()
    {
        echo '{"name":"SiKembang","short_name":"SiKembang","theme_color":"#ffab00","background_color":"#ffffff","display":"standalone","scope":"' . base_url() . '","start_url":"' . base_url() . '","icons":[{"src":"icon.png","sizes":"144x144","type":"image/png"},{"src":"icon192.png","sizes":"192x192","type":"image/png"}],"splash_pages":null}';
    }
}
