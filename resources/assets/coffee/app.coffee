class Koolbeans

  constructor: ->
    @rewriteConfirmedLinks()
    @initTooltips()
    @fadeOutMessages()

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

  fadeOutMessages: ->
    jQuery('#messages-top')?.delay(8000).fadeOut()

window.koolbeans = new Koolbeans()

filters = document.querySelectorAll('.search-filter')
for filter in filters
  filter.onclick = (e) ->
    e.stopPropagation()
    this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.classList.add 'open'
