class Koolbeans

  constructor: ->
    @rewriteConfirmedLinks()
    @initTooltips()

  cancelEvent: (e) ->
    e.preventDefault()
    e.stopPropagation()
    false

  rewriteConfirmedLinks: ->
    links = document.querySelectorAll('a[data-confirm]')
    @rewriteConfirmLink link for link in links

  rewriteConfirmLink: (link) ->
    _ = @
    link.onclick = (e) ->
      _.modal.open link
      _.cancelEvent e

  initTooltips: ->
    $('[data-toggle="tooltip"]').tooltip()

window.koolbeans = new Koolbeans()
