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
                jQuery(`[name="anak"]`).html(storedAnak).select2('destroy').select2()
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
                    record.id = new Date().getTime()
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
            jQuery('body').append(`<div data-backdrop="static" class="modal fade" id="offline_sync_pengukuran" tabindex="-1" role="dialog" aria-labelledby="offine_sync_label" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-body">Proses sinkronisasi data pengukuran anak sedang berlangsung,<br>mohon menunggu sejenak</div></div></div></div>`)
            jQuery('#offline_sync_pengukuran').modal('show')
            storedPengukuran = JSON.parse(storedPengukuran)
            jQuery.post(`${site_url}Pengukuran/bulkCreate`, { records: storedPengukuran }, function () {
                alert('asw')
                jQuery('#offline_sync_pengukuran').modal('hide')
                localStorage.removeItem('pengukuran')
                // jQuery('#offline_sync_pengukuran').remove()
            })
        }

        var storedPemeriksaanBumil = localStorage.getItem('pemeriksaan_bumil')
        if (null !== storedPemeriksaanBumil) {
            jQuery('body').append(`<div data-backdrop="static" class="modal fade" id="offline_sync_posyandubumil" tabindex="-1" role="dialog" aria-labelledby="offine_sync_label" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-body">Proses sinkronisasi data posyandu ibu hamil sedang berlangsung,<br>mohon menunggu sejenak</div></div></div></div>`)
            jQuery('#offline_sync_posyandubumil').modal('show')
            storedPemeriksaanBumil = JSON.parse(storedPemeriksaanBumil)
            storedPemeriksaanBumil = storedPemeriksaanBumil.map(pemeriksaan => {
                delete pemeriksaan.id
                return pemeriksaan
            })
            jQuery.post(`${site_url}posyandubumil/bulkCreate`, { records: storedPemeriksaanBumil }, function () {
                alert('clg')
                jQuery('#offline_sync_posyandubumil').modal('hide')
                localStorage.removeItem('pemeriksaan_bumil')
                // jQuery('#offline_sync_posyandubumil').remove()
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

        jQuery.get(`${site_url}Ibuhamil/all`, function (res) {
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