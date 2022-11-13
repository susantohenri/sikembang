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
                jQuery(`[name="anak"]`).html(options)
                if (jQuery(`[name="anak"]`).data('select2')) {
                    jQuery(`[name="anak"]`).select2('destroy')
                }
                jQuery(`[name="anak"]`).select2()
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
            case 'posyandubumil/create':
                var options = JSON.parse(localStorage.getItem('ibuhamil')).map(ibuhamil => {
                    return `<option value="${ibuhamil.uuid}">${ibuhamil.nama_ibuhamil}</option>`
                })
                jQuery(`[name="ibuhamil"]`).html(options)
                if (jQuery(`[name="ibuhamil"]`).data('select2')) {
                    jQuery(`[name="ibuhamil"]`).select2('destroy')
                }
                jQuery(`[name="ibuhamil"]`).select2()
                jQuery('.btn-save').click(function (e) {
                    e.preventDefault()
                    var record = {}
                    jQuery('form').find('input, select, textarea').each(function () {
                        var name = jQuery(this).attr('name')
                        var value = jQuery(this).val()
                        record[name] = value
                    })
                    var storedPemeriksaanBumil = localStorage.getItem('pemeriksaan_bumil')
                    if (null === storedPemeriksaanBumil) storedPemeriksaanBumil = [record]
                    else {
                        storedPemeriksaanBumil = JSON.parse(storedPemeriksaanBumil)
                        storedPemeriksaanBumil.push(record)
                    }
                    localStorage.setItem('pemeriksaan_bumil', JSON.stringify(storedPemeriksaanBumil))
                    window.location = `${site_url}posyandubumil`
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
            BLOCK ACTIVITY
            CHECK EXISTS LOCALSTORAGE
            IF EXISTS:
                UPLOAD
                CLEAR
        */
        // store pemeriksaan_bumil
        var storedPemeriksaanBumil = localStorage.getItem('pemeriksaan_bumil')
        if (null !== storedPemeriksaanBumil) {
            storedPemeriksaanBumil = JSON.parse(storedPemeriksaanBumil)
            console.log(storedPemeriksaanBumil)
            storedPemeriksaanBumil.forEach(record => {
                jQuery.post(`${site_url}Posyandubumil/save`, record)
            })
            localStorage.removeItem('pemeriksaan_bumil')
        }
        
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

        if (null === localStorage.getItem('ibuhamil')) jQuery.get(`${site_url}Ibuhamil/all`, function (ibuhamil) {
            localStorage.setItem('ibuhamil', ibuhamil)
        })
    }
})