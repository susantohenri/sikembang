jQuery(function () {
    if (!navigator.onLine) {
        jQuery('.main-header .btn-group').hide()
        switch (window.location.href.replace(site_url, '')) {
            case 'Pengukuran':
                localStorage.removeItem('pengukuran_id')
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
                        <tr data-id='${pengukuran.id}' style='cursor: pointer'>
                            <td>${pengukuran.createdAt}</td>
                            <td>${nama_anak}</td>
                        </tr>
                    `
                }).join('')
                $('.table-model').append(`<tbody>${storedPengukuran}</tbody>`)
                $('.table-model tbody tr').click(function () {
                    var id = $(this).data('id')
                    window.location = `${site_url}Pengukuran/show`
                    localStorage.setItem('pengukuran_id', id)
                })
                    ; break
            case 'Pengukuran/create':
                var storedAnak = JSON.parse(localStorage.getItem('anak')).map(anak => {
                    return `<option value="${anak.uuid}">${anak.nama}</option>`
                })
                jQuery(`[name="anak"]`).html(storedAnak)
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
                    record.id = new Date().getTime().toString()
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
            case 'Pengukuran/show':
                $('.card-header .btn-save').after(`
                    <button class="btn btn-danger btn-delete"><i class="fa fa-trash"></i> &nbsp; Delete</button>
                `)
                var storedPengukuran = localStorage.getItem('pengukuran')
                if (null === storedPengukuran) return true;
                storedPengukuran = JSON.parse(storedPengukuran)
                var id = localStorage.getItem('pengukuran_id')
                var currentPengukuran = storedPengukuran.filter(pengukuran => {
                    return pengukuran.id == id
                })[0]
                jQuery('form').find('input, select').each(function () {
                    var name = jQuery(this).attr('name')
                    var value = currentPengukuran[name]
                    jQuery(this).val(value)
                })
                var options = JSON.parse(localStorage.getItem('anak')).map(anak => {
                    return `<option value="${anak.uuid}">${anak.nama}</option>`
                })
                jQuery(`[name="anak"]`).html(options)
                if (jQuery(`[name="anak"]`).data('select2')) {
                    jQuery(`[name="anak"]`).select2('destroy')
                }
                jQuery(`[name="anak"]`).select2()
                jQuery(`[name="anak"]`).val(currentPengukuran.anak).trigger('change')
                jQuery('.btn-save').click(function (e) {
                    e.preventDefault()
                    var record = {}
                    jQuery('form').find('input, select').each(function () {
                        var name = jQuery(this).attr('name')
                        var value = jQuery(this).val()
                        record[name] = value
                    })
                    record.id = id
                    storedPengukuran = storedPengukuran.map(pengukuran => {
                        if (pengukuran.id == id) {
                            return record
                        }
                        return pengukuran
                    })
                    localStorage.setItem('pengukuran', JSON.stringify(storedPengukuran))
                    window.location = `${site_url}Pengukuran`
                })
                jQuery('.btn-delete').click(function (e) {
                    e.preventDefault()
                    storedPengukuran = storedPengukuran.filter(pengukuran => {
                        return pengukuran.id != id
                    })
                    localStorage.setItem('pengukuran', JSON.stringify(storedPengukuran))
                    window.location = `${site_url}Pengukuran`
                })
                ; break
            case 'posyandubumil':
                jQuery(`[href="${site_url}posyandubumil/download"]`).hide()
                localStorage.removeItem('pemeriksaan_bumil_id')
                var storedPemeriksaanBumil = localStorage.getItem('pemeriksaan_bumil')
                if (null === storedPemeriksaanBumil) return true;
                storedPemeriksaanBumil = JSON.parse(storedPemeriksaanBumil)
                var ibuhamil = JSON.parse(localStorage.getItem('ibuhamil'))
                var pemeriksaanList = storedPemeriksaanBumil.map(pemeriksaan => {
                    var ibu = ibuhamil.filter(ibu => {
                        return ibu.uuid === pemeriksaan.ibuhamil
                    })
                    var nama_ibu = ibu[0] ? ibu[0].nama_ibuhamil : ''
                    return `
                        <tr data-id='${pemeriksaan.id}' style='cursor: pointer'>
                            <td>${pemeriksaan.tanggal_pemeriksaan}</td>
                            <td>${nama_ibu}</td>
                            <td></td>
                        </tr>
                    `
                }).join('')
                $('.table-model').append(`<tbody>${pemeriksaanList}</tbody>`)
                $('.table-model tbody tr').click(function () {
                    var id = $(this).data('id')
                    window.location = `${site_url}posyandubumil/show`
                    localStorage.setItem('pemeriksaan_bumil_id', id)
                })
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
                    record.id = new Date().getTime().toString()
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
            case 'posyandubumil/show':
                $('.card-header .btn-save').after(`
                    <button class="btn btn-danger btn-delete"><i class="fa fa-trash"></i> &nbsp; Delete</button>
                `)
                var storedPemeriksaanBumil = localStorage.getItem('pemeriksaan_bumil')
                if (null === storedPemeriksaanBumil) return true;
                storedPemeriksaanBumil = JSON.parse(storedPemeriksaanBumil)
                var id = localStorage.getItem('pemeriksaan_bumil_id')
                var currentPemeriksaanBumil = storedPemeriksaanBumil.filter(pemeriksaan => {
                    return pemeriksaan.id == id
                })[0]
                jQuery('form').find('input, select, textarea').each(function () {
                    var name = jQuery(this).attr('name')
                    var value = currentPemeriksaanBumil[name]
                    jQuery(this).val(value)
                })
                var options = JSON.parse(localStorage.getItem('ibuhamil')).map(ibuhamil => {
                    return `<option value="${ibuhamil.uuid}">${ibuhamil.nama_ibuhamil}</option>`
                })
                jQuery(`[name="ibuhamil"]`).html(options)
                if (jQuery(`[name="ibuhamil"]`).data('select2')) {
                    jQuery(`[name="ibuhamil"]`).select2('destroy')
                }
                jQuery(`[name="ibuhamil"]`).select2()
                jQuery(`[name="ibuhamil"]`).val(currentPemeriksaanBumil.ibuhamil).trigger('change')
                jQuery('.btn-save').click(function (e) {
                    e.preventDefault()
                    var record = {}
                    jQuery('form').find('input, select, textarea').each(function () {
                        var name = jQuery(this).attr('name')
                        var value = jQuery(this).val()
                        record[name] = value
                    })
                    record.id = id
                    storedPemeriksaanBumil = storedPemeriksaanBumil.map(pemeriksaan => {
                        if (pemeriksaan.id == id) {
                            return record
                        }
                        return pemeriksaan
                    })
                    localStorage.setItem('pemeriksaan_bumil', JSON.stringify(storedPemeriksaanBumil))
                    window.location = `${site_url}posyandubumil`
                })
                jQuery('.btn-delete').click(function (e) {
                    e.preventDefault()
                    storedPemeriksaanBumil = storedPemeriksaanBumil.filter(pemeriksaan => {
                        return pemeriksaan.id != id
                    })
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

        var storedPengukuran = localStorage.getItem('pengukuran')
        if (null !== storedPengukuran) {
            storedPengukuran = JSON.parse(storedPengukuran)
            storedPengukuran = storedPengukuran.map(pengukuran => {
                delete pengukuran.id
                return pengukuran
            })
            jQuery.post(`${site_url}Pengukuran/bulkCreate`, { records: storedPengukuran }, function () {
                localStorage.removeItem('pengukuran')
            })
        }

        var storedPemeriksaanBumil = localStorage.getItem('pemeriksaan_bumil')
        if (null !== storedPemeriksaanBumil) {
            storedPemeriksaanBumil = JSON.parse(storedPemeriksaanBumil)
            storedPemeriksaanBumil = storedPemeriksaanBumil.map(pemeriksaan => {
                delete pemeriksaan.id
                return pemeriksaan
            })
            jQuery.post(`${site_url}posyandubumil/bulkCreate`, { records: storedPemeriksaanBumil }, function () {
                localStorage.removeItem('pemeriksaan_bumil')
            })
        }

        jQuery(`a[href="${site_url}Login/Logout"]`).click(function (e) {
            navigator.serviceWorker.getRegistrations().then(function (registrations) {
                for (let registration of registrations) registration.unregister()
            })
            caches.keys().then(function (names) {
                for (let name of names) caches.delete(name)
            });
            localStorage.clear()
        })

        if (null === localStorage.getItem('anak')) jQuery.get(`${site_url}Anak/all`, function (anak) {
            localStorage.setItem('anak', anak)
        })

        if (null === localStorage.getItem('ibuhamil')) jQuery.get(`${site_url}Ibuhamil/all`, function (res) {
            localStorage.setItem('ibuhamil', res)
        })

        var route = window.location.href.replace(site_url, '')
            , controller = route.split('/')[0]
            , method = route.split('/')[1]

        if (['posyandubumil', 'Pengukuran'].indexOf(controller) > -1) switch (method) {
            case 'create':
                jQuery('.btn-save').click(function (e) {
                    e.preventDefault()
                    var record = {}
                    jQuery('form').find('input, select, textarea').each(function () {
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
                    jQuery('form').find('input, select, textarea').each(function () {
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
        }
    }
})