window.onload = function () {

  for (var th in thead) {
    if (['total_spj', 'hargasat', 'pagu', 'paid'].indexOf(thead[th].mData) > -1)
      thead[th].render = $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' )
    if ('prosentase' === thead[th].mData) thead[th].render = $.fn.dataTable.render.number( ',', '.', 0, '', ' %' )
    if (['detail_vol', 'spj_vol'].indexOf(thead[th].mData) > -1)
      thead[th].render = $.fn.dataTable.render.number( ',', '.', 0, '' )
    $('.table-model tfoot tr').append('<th></th>')
  }

  var footer = []
  $('.table-model').DataTable( {
    processing: true,
    serverSide: true,
    ajax: {url: current_controller + '/dt', type: 'POST', dataSrc:function (data) {
      footer = data.footer
      return data.data
    }},
    columns: thead,
    createdRow: function( row, data, dataIndex){
      if (data.prosentase && parseInt(data.prosentase.replace('%', '').split(',').join('')) > 100) $(row).css('background-color', '#ffcccc')
    },
    fnRowCallback: function(nRow, aData, iDisplayIndex ) {
      $(nRow).css('cursor', 'pointer').click( function () {
        if (!allow_read) return false
        if (['Breakdown', 'Program', 'Kegiatan', 'Output', 'SubOutput', 'Komponen', 'SubKomponen', 'Akun'].indexOf(current_controller.replace(site_url, '')) > -1) window.location.href = current_controller + '/readList/' + aData.uuid
        else window.location.href = current_controller + '/read/' + aData.uuid
      })
    },
    drawCallback: function( settings ) {
      var api = this.api()
      for (var f in footer) $(api.column(f).footer()).html(footer[f])
    }
  })
}