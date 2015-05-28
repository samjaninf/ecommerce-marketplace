class Koolbeans
  cancelEvent: (e) ->
    e.preventDefault()
    e.stopPropagation()
    false

window.koolbeans = new Koolbeans()
