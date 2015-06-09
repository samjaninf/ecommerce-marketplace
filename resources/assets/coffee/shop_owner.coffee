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

if document.getElementById('creating-offers')?
  productNb = 1

  addOrderDetail = (e) ->
    e.preventDefault()

    select = createProductSelect()
    radios = createRadios()
    sizes = document.createElement 'div'
    sizes.classList.add 'sizes'
    sizes.id = 'sizes-' + productNb

    details = document.getElementById('offer-details')
    details.appendChild document.createElement 'hr'
    details.appendChild select
    details.appendChild radios
    details.appendChild sizes
    productNb += 1

  createProductSelect = () ->
    div = document.createElement 'div'
    div.classList.add 'form-group'

    label = document.createElement 'label'
    label.for = 'referenced_product-' + productNb
    label.classList.add 'col-sm-2'
    label.classList.add 'control-label'
    label.innerHTML = 'Referenced product:'

    selectContainer = document.createElement 'div'
    selectContainer.classList.add 'col-sm-10'
    selectContainer.classList.add 'col-md-6'

    select = document.createElement 'select'
    select.id = label.for
    select.name = 'referenced_product[' + productNb + ']'
    select.classList.add 'form-control'
    select.onchange = selectReferencedProductChanged

    for p in products
      opt = document.createElement 'option'
      opt.value = p.id
      opt.innerHTML = if p.pivot.name != '' then p.pivot.name else p.name
      select.appendChild opt

    p = document.createElement 'p'
    p.classList.add 'help-block'
    p.innerHTML = 'If you do not set a referenced product here, the base product will be reduced.'

    selectContainer.appendChild select
    selectContainer.appendChild p
    div.appendChild label
    div.appendChild selectContainer

    return div

  createRadios = () ->
    div = document.createElement 'div'
    div.classList.add 'form-group'

    div.appendChild createRadio('free', 'The referenced product will be free.')
    div.appendChild createRadio('flat',
      'The referenced product will be reduced by a fixed amount. You can specify the amount below, for each size (if it is a drink).')
    div.appendChild createRadio('percent',
      'The referenced product will be reduced by a percentage. You can specify the amount below, for each size (if it is a drink).')

    return div

  createRadio = (value, text) ->
    div = document.createElement 'div'
    div.classList.add 'radio'
    div.classList.add 'col-sm-10'
    div.classList.add 'col-md-6'
    div.classList.add 'col-sm-offset-2'
    div.classList.add 'col-md-offset-2'

    label = document.createElement 'label'

    input = document.createElement 'input'
    input.type = 'radio'
    input.name = 'type[' + productNb + ']'
    input.value = value
    input.onchange = offerTypeChanged
    input.checked = true if value == 'free'

    label.appendChild input
    label.appendChild document.createTextNode text

    div.appendChild label

    return div

  offerTypeChanged = () ->
    sizesContainer = document.getElementById('sizes-' + this.name.substr(-2, 1))
    sizesContainer.innerHTML = ''

    if this.value isnt 'free'
      select = document.getElementById('referenced_product-' + this.name.substr(-2, 1))
      sizes = createSizesFor(select.options[select.selectedIndex].value)
      sizesContainer.appendChild size for size in sizes

  baseProductChanged = () ->
    select = document.getElementById('referenced_product-0')
    if select.options[select.selectedIndex].value is ''
      sizesContainer = document.getElementById('sizes-0')
      sizesContainer.innerHTML = ''

      selector = 'input[type=radio][name=type\\[0\\]]:checked'
      checkedRatio = document.querySelector(selector)
      if checkedRatio? and checkedRatio.value isnt 'free'
        sizes = createSizesFor(this.options[this.selectedIndex].value)
        sizesContainer.appendChild size for size in sizes

  selectReferencedProductChanged = () ->
    sizesContainer = document.getElementById('sizes-' + this.id.substr(-1))
    sizesContainer.innerHTML = ''

    selector = 'input[type=radio][name=type\\[' + this.id.substr(-1) + '\\]]:checked'
    checkedRatio = document.querySelector(selector)
    if checkedRatio? and checkedRatio.value isnt 'free'
      sizes = createSizesFor(this.options[this.selectedIndex].value)
      sizesContainer.appendChild size for size in sizes

  createSizesFor = (productId) ->
    if productId == ''
      productId = document.querySelector('select#product').options[document.querySelector('select#product').selectedIndex].value
    for product in products
      if product.id == parseInt(productId)
        sizes = []
        for size in ['xs', 'sm', 'md', 'lg']
          sizes.push createSizeInput product, size if product.pivot[size + '_activated'] and product.pivot[size] > 0
        return sizes

  createSizeInput = (product, size) ->
    text = if product.type == 'food' then 'Reduction:' else coffeeShop['display_' + size]

    div = document.createElement 'div'
    div.classList.add 'form-group'

    label = document.createElement 'label'
    label.for = "size-#{size}-#{productNb}"
    label.classList.add 'col-sm-2'
    label.classList.add 'control-label'
    label.textContent = text

    inputContainer = document.createElement 'div'
    inputContainer.classList.add 'col-sm-10'
    inputContainer.classList.add 'col-md-6'

    input = document.createElement 'input'
    input.id = label.for
    input.name = "size-#{size}[#{productNb}"
    input.type = 'number'
    input.placeholder = '10'
    input.classList.add 'form-control'

    inputContainer.appendChild input
    div.appendChild label
    div.appendChild inputContainer

    return div

  addLink = document.getElementById 'add-offer-detail'
  addLink.onclick = addOrderDetail
  document.getElementById('referenced_product-0').onchange = selectReferencedProductChanged
  document.getElementById('product').onchange = baseProductChanged
  firstRowTypes = document.querySelectorAll('input[type=radio][name=type\\[0\\]]')
  for t in firstRowTypes
    t.onchange = offerTypeChanged

