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
    $("#dtBox").DateTimePicker()

  fadeOutMessages: ->
    jQuery('#messages-top')?.delay(8000).fadeOut()

  lightbox.option(
    'resizeDuration': 500
    'fitImagesInViewport': true
    'wrapAround': true
    'maxHeight': $(window).height() - 50
  )

window.koolbeans = new Koolbeans()