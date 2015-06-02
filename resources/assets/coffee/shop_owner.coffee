source = document.getElementById 'edit-coffeeshop-about'
helper = document.getElementById 'edit-coffeeshop-about-helper'
container = source.parentNode
savedValue = source.textContent
target = source.dataset.target

changeAboutSection = (e) ->
  replacement = document.createElement 'textarea'
  replacement.classList.add 'form-control'
  replacement.value = source.textContent.trim()
  replacement.id = 'edit-coffeeshop-about-field'

  submit = document.createElement 'a'
  submit.onclick = editAboutSection
  submit.classList.add 'btn'
  submit.classList.add 'btn-success'
  submit.textContent = 'Submit'
  submit.id = 'submit-edit-about'

  cancel = document.createElement 'a'
  cancel.onclick = revertToText
  cancel.classList.add 'btn'
  cancel.classList.add 'btn-default'
  cancel.textContent = 'Cancel'
  cancel.id = 'cancel-edit-about'

  container.replaceChild replacement, source
  helper.onclick = revertToText

  source = replacement

  container.appendChild submit
  container.appendChild cancel

  koolbeans.cancelEvent e

revertToText = (e) ->
  text = document.createElement 'p'
  text.onclick = changeAboutSection
  text.id = 'edit-coffeeshop-about'
  text.textContent = savedValue

  container.replaceChild text, source
  helper.onclick = changeAboutSection

  source = text

  container.removeChild document.getElementById 'submit-edit-about'
  container.removeChild document.getElementById 'cancel-edit-about'

  koolbeans.cancelEvent e

editAboutSection = (e) ->
  $.ajax
    url: target
    data: { about: source.value }
    method: 'put'
    success: (data) ->
      savedValue = data

      revertToText e

  koolbeans.cancelEvent e

helper.onclick = source.onclick = changeAboutSection
