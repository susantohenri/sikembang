jQuery(function () {
    if (!navigator.onLine) {
        jQuery('.main-header .btn-group').hide()
        switch (window.location.href.replace(site_url, '')) {
            case 'Pengukuran':
                var storedPengukuran = localStorage.getItem('pengukuran')
                if (null === storedPengukuran) return true;
                storedPengukuran = JSON.parse(storedPengukuran)
                var storedAnak = JSON.parse(localStorage.getItem('anak'))
                storedPengukuran = storedPengukuran.map(pengukuran => {
                    var anak = storedAnak.filter(anak => {
                        return anak.uuid === pengukuran.anak
                    })
                    var nama_anak = anak[0] ? anak[0].nama : ''
                    return `
                        <tr>
                            <td>${pengukuran.createdAt}</td>
                            <td>${nama_anak}</td>
                        </tr>
                    `
                })
                $('.table-model tbody').html(storedPengukuran.join(''))
                    ; break
            case 'Pengukuran/create':
                var storedAnak = JSON.parse(localStorage.getItem('anak')).map(anak => {
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
        var route = window.location.href.replace(site_url, '')
            , controller = route.split('/')[0]
            , method = route.split('/')[1]
        switch (method) {
            case 'create':
                jQuery('.btn-save').click(function (e) {
                    e.preventDefault()
                    var record = {}
                    jQuery('form').find('input, select').each(function () {
                        jQuery(this).removeAttr('disabled')
                        var name = jQuery(this).attr('name')
                        var value = jQuery(this).val()
                        record[name] = value
                    })
                    jQuery.post(`${site_url}${controller}/bulkCreate`, { records: [record] }, function () {
                        window.location = `${site_url}${controller}`
                    })
                })
                    ; break
            case 'read':
                jQuery('.btn-save').click(function (e) {
                    e.preventDefault()
                    var record = {}
                    jQuery('form').find('input, select').each(function () {
                        jQuery(this).removeAttr('disabled')
                        var name = jQuery(this).attr('name')
                        var value = jQuery(this).val()
                        record[name] = value
                    })
                    jQuery.post(`${site_url}${controller}/bulkUpdate`, { records: [record] }, function () {
                        window.location = `${site_url}${controller}`
                    })
                })
                    ; break
            case 'delete':
                jQuery('.btn-danger').click(function (e) {
                    e.preventDefault()
                    var record = {}
                    jQuery('form').find('input, select').each(function () {
                        jQuery(this).removeAttr('disabled')
                        var name = jQuery(this).attr('name')
                        var value = jQuery(this).val()
                        record[name] = value
                    })
                    jQuery.post(`${site_url}${controller}/bulkDelete`, { records: [record] }, function () {
                        window.location = `${site_url}${controller}`
                    })
                })
                    ; break
            default:
                var storedPengukuran = localStorage.getItem('pengukuran')
                if (null !== storedPengukuran) {
                    storedPengukuran = JSON.parse(storedPengukuran)
                    jQuery.post(`${site_url}Pengukuran/bulkCreate`, { records: storedPengukuran }, function () {
                        localStorage.removeItem('pengukuran')
                    })
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
                    ; break
        }
    }
})