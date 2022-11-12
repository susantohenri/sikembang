jQuery(function () {
    if (!navigator.onLine) {
        jQuery('.main-header .btn-group').hide()
        jQuery(`a[href^="${site_url}"]`)
            .not(`a[href$="Pengukuran"]`)
            .not(`a[href$="posyandubumil"]`)
            .parent()
            .hide()
    }
})