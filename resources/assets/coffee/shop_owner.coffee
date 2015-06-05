source = document.getElementById 'edit-coffeeshop-about'
helper = document.getElementById 'edit-coffeeshop-about-helper'
container = source?.parentNode
savedValue = source?.textContent
target = source?.dataset.target

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
  document.getElementById('submit-edit-about').classList.add 'disabled'
  document.getElementById('cancel-edit-about').classList.add 'disabled'

  $.ajax
    url: target
    data: {about: source.value}
    method: 'put'
    success: (data) ->
      savedValue = data

      revertToText e

  koolbeans.cancelEvent e

helper?.onclick = source?.onclick = changeAboutSection

activators = document.getElementsByClassName('activates')
for activator in activators
  activator.onchange = () ->
    url = this.dataset.target

    $.ajax
      url: url
      method: 'get'
      success: () ->

renames = document.getElementsByClassName('change-display-name')
for rename in renames
  rename.onclick = (e) ->
    triggerRenameProduct this, e

prices = document.getElementsByClassName('change-price')
for price in prices
  price.onclick = (e) ->
    triggerChangePrice this, e

addLinks = document.getElementsByClassName('add-product')
for link in addLinks
  link.onclick = (e) ->
    e.preventDefault()
    document.getElementById(this.dataset.target).classList.remove 'hide'

triggerRenameProduct = (link, e) ->
  e.preventDefault()
  createInput link, e, 'text', renameProduct

triggerChangePrice = (link, e) ->
  e.preventDefault()
  createInput link, e, 'number', changePrice

createInput = (link, e, type, cb) ->
  e.preventDefault()
  input = document.createElement 'input'
  input.type = type
  input.dataset.target = link.dataset.target
  input.value = link.textContent.trim()
  input.classList.add 'form-control'
  input.onkeydown = (e) ->
    this.blur() if e.keyCode == 13

  input.onblur = (e) ->
    cb this, e

  if type == 'number'
    input.step = '0.01'
    input.min = '0.01'
    input.value = link.textContent.trim().substr(2).trim()

  link.parentNode.replaceChild input, link
  input.focus()

renameProduct = (input, e) ->
  e.preventDefault()
  input.disabled = true

  $.ajax
    url: input.dataset.target
    method: 'post'
    data: {name: input.value}
    success: (data) ->
      createLink input, 'change-display-name', data, triggerRenameProduct

changePrice = (input, e) ->
  e.preventDefault()
  input.disabled = true

  $.ajax
    url: input.dataset.target
    method: 'post'
    data: {price: parseFloat(input.value) * 100}
    success: (data) ->
      createLink input, 'change-price', '£ ' + data, triggerChangePrice
    error: () ->
      input.disabled = false
      input.parentNode.classList.add 'has-error'

createLink = (input, cls, data, cb) ->
  link = document.createElement 'a'
  link.href = '#'
  link.classList.add = cls
  link.dataset.target = input.dataset.target
  link.textContent = data
  link.onclick = (e) ->
    cb this, e

  input.parentNode.replaceChild link, input
  input.parentNode.classList.remove 'has-error'
