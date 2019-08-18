window.onload = function () {

  formInit($(`[data-controller="${current_controller}"]`))
  $('.main-form').submit(function () {
    $('[data-number]').each (function () {
      $(this).val(getNumber($(this)))
    })
    return true
  })

  $('.form-child').each (function () {
    var fchild = $(this)
    var child_controller = fchild.attr('data-controller')
    var child_controller_url = site_url + child_controller
    var uuids = JSON.parse(fchild.attr('data-uuids').split("'").join('"'))
    for (var u in uuids) $.ajax({url: child_controller_url + '/subformread/' + uuids[u], success: function (form) {
      fchild.prepend(form)
      if (uuids.length === fchild.find('[data-orders]').length) {
        var elements = fchild.find('[data-orders]')
        var elems = []
        for( var i = 0; i < elements.length; ++i ) {
          var el = elements[i]
          elems.push(el)
        }
        var sorted = elems.sort(function (a, b) {
          var aValue = parseInt(a.getAttribute('data-orders'), 10)
          var bValue = parseInt(b.getAttribute('data-orders'), 10)
          return aValue - bValue
        })
        var html = ''
        elements.remove()
        for( var i = 0; i < sorted.length; ++i ) html += sorted[i].outerHTML
        var fetched = fchild.prepend(html)
        formInit(fetched)
      }
    }})
    fchild.find('.btn-add').click(function () {
      var beforeButton = $(this).parents('.form-group');
      $.get(child_controller_url + '/subformcreate/', function (form) {
        var created = $(form).insertBefore(beforeButton)
        formInit(created)
      })
    })
  })

  $('.select2-selection__rendered .select2-selection__choice').each(function(){
      atr = this.getAttribute('title');
      if (atr === ''){ $(this).remove(); }
      else if (atr === null){ $(this).remove(); }
  });

  if (window.location.href.indexOf('ChangePassword') > -1) $('form a[href*="ChangePassword/delete"]').hide()
}

function formInit (scope) {
  scope.find('.btn-delete[data-uuid]').click(function () {
    $(this).parent().parent().remove()
  })
  scope.find('select').not('.select2-hidden-accessible').each(function () {
    if ($(this).is ('[data-autocomplete]')) {
      var model = $(this).attr('data-model')
      var field = $(this).attr('data-field')
      $(this).select2({
        ajax: {
          url: current_controller_url + '/select2/' + model + '/' + field,
          type: 'POST', dataType: 'json'
        }
      })
    } else if ($(this).is ('[data-suggestion]')) {
      $(this).select2({
        tags: true,
        createTag: function (params) {
          return {
            id: params.term,
            text: params.term,
            newOption: true
          }
        },
         templateResult: function (data) {
          var $result = $('<span></span>')
          $result.text(data.text)
          if (data.newOption) $result.append('<em> (add new)</em>')
          return $result
        }
      })
    } else $(this).select2()
  })
  scope.find('[data-date="datepicker"]').attr('autocomplete', 'off').datepicker({format: 'yyyy-mm-dd', autoclose: true})
  // scope.find('[data-date="timepicker"]').timepicker({defaultTime: false, showMeridian: false})
  scope.find('[data-date="datetimepicker"]').attr('autocomplete', 'off').daterangepicker({
    singleDatePicker: true,
    timePicker: true,
    timePicker24Hour: true,
    locale: {format: 'YYYY-MM-DD HH:mm'},
    // startDate: moment().format('YYYY-MM-DD HH:mm')
  })
  scope.find('[data-number="true"]').keyup(function () {
    $(this).val(currency(getNumber($(this))))
  })
}

function getNumber (element) {
  var val = element.val() || element.html()
  val = val.split(',').join('')
  return isNaN(val) || val.length < 1 ? 0 : parseInt (val)
}

function currency (number) {
  var reverse = number.toString().split('').reverse().join(''),
  currency  = reverse.match(/\d{1,3}/g)
  return currency.join(',').split('').reverse().join('')
}