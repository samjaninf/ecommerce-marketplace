class Modal
  constructor: (@htmlID) ->
    document.getElementById('modal-close').onclick = @hide

  open: (link) ->
    if not @opened?
      @href = link.href
      @method = if link.dataset.method then link.dataset.method else 'get'
      @text = link.dataset.confirm

      document.getElementById('modal-text').innerHTML = @text
      document.getElementById('modal-method').value = @method
      document.getElementById('modal-form').action = @href
      document.getElementById('modal-form').method = if @method == 'get' then 'get' else 'post'
      document.getElementById(koolbeans.modal.htmlID).classList.remove 'hide'
      document.getElementById(koolbeans.modal.htmlID).classList.add 'show'

  hide: ->
    console.log 'click'
    document.getElementById(koolbeans.modal.htmlID).classList.add 'hide'
    document.getElementById(koolbeans.modal.htmlID).classList.remove 'show'

window.koolbeans.modal = new Modal('modal')
