window.onload = function () {

  for (var th in thead) {
    $('.table-model tfoot tr').append('<th></th>')
  }

  var footer = []
  $('.table-model').DataTable( {
    processing: true,
    serverSide: true,
    ajax: {url: current_controller_url + '/dt', type: 'POST', dataSrc:function (data) {
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
        else window.location.href = current_controller_url + '/read/' + aData.uuid
      })
    },
    drawCallback: function( settings ) {
      var api = this.api()
      for (var f in footer) $(api.column(f).footer()).html(footer[f])
    }
  })
}