jQuery(function () {
    if (!navigator.onLine) {
        jQuery('.main-header .btn-group').hide()
        switch (window.location.href.replace(site_url, '')) {
            case 'Pengukuran':

                ;break
            case 'posyandubumil':
                jQuery(`[href="https://localhost/sikembang/index.php/posyandubumil/download"]`).hide()
                ;break
            default :
                jQuery(`a[href^="${site_url}"]`)
                    .not(`a[href$="Pengukuran"]`)
                    .not(`a[href$="posyandubumil"]`)
                    .parent()
                    .hide()
                ;break
        }
    }
})