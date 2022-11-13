jQuery(function () {
    if (!navigator.onLine) {
        jQuery('.main-header .btn-group').hide()
        switch (window.location.href.replace(site_url, '')) {
            case 'Pengukuran':
                ; break
            case 'posyandubumil':
                jQuery(`[href="https://localhost/sikembang/index.php/posyandubumil/download"]`).hide()
                    ; break
            case 'Pengukuran/create':
                jQuery('.btn-save').click(function (e) {
                    e.preventDefault()
                    var record = {}
                    jQuery('form').find('input, select').each(function () {
                        jQuery(this).removeAttr('disabled')
                        var name = jQuery(this).attr('name')
                        var value = jQuery(this).val()
                        record[name] = value
                    })
                    var stored = localStorage.getItem('pengukuran')
                    if (null === stored) stored = [record]
                    else stored.push(record)
                    localStorage.setItem('pengukuran', stored)
                })
                    ; break
            default:
                jQuery(`a[href^="${site_url}"]`)
                    .not(`a[href$="Pengukuran"]`)
                    .not(`a[href$="posyandubumil"]`)
                    .parent()
                    .hide()
                    ; break
        }
    } else {
        /*
            CHECK EXISTS LOCALSTORAGE
            IF EXISTS:
                UPLOAD
                CLEAR
        */
        jQuery(`a[href="${site_url}Login/Logout"]`).click(function (e) {
            navigator.serviceWorker.getRegistrations().then(function (registrations) {
                for (let registration of registrations) registration.unregister()
            })
            caches.keys().then(function (names) {
                for (let name of names) caches.delete(name)
            });
        })
    }
})