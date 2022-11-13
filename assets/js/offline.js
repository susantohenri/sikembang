jQuery(function () {
    if (!navigator.onLine) {
        jQuery('.main-header .btn-group').hide()
        switch (window.location.href.replace(site_url, '')) {
            case 'Pengukuran':
                ; break
            case 'Pengukuran/create':
                var options = JSON.parse(localStorage.getItem('anak')).map(anak => {
                    return `<option value="${anak.uuid}">${anak.nama}</option>`
                })
                jQuery(`[name="anak"]`).html(options).select2('destroy').select2()
                jQuery('.btn-save').click(function (e) {
                    e.preventDefault()
                    var record = {}
                    jQuery('form').find('input, select').each(function () {
                        jQuery(this).removeAttr('disabled')
                        var name = jQuery(this).attr('name')
                        var value = jQuery(this).val()
                        record[name] = value
                    })
                    var storedPengukuran = localStorage.getItem('pengukuran')
                    if (null === storedPengukuran) storedPengukuran = [record]
                    else {
                        storedPengukuran = JSON.parse(storedPengukuran)
                        storedPengukuran.push(record)
                    }
                    localStorage.setItem('pengukuran', JSON.stringify(storedPengukuran))
                    window.location = `${site_url}Pengukuran`
                })
                    ; break
            case 'posyandubumil':
                jQuery(`[href="${site_url}posyandubumil/download"]`).hide()
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
            BLOCK ACTIVITY
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

        if (null === localStorage.getItem('anak')) jQuery.get(`${site_url}Anak/all`, function (anak) {
            localStorage.setItem('anak', anak)
        })
    }
})