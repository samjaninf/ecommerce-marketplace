sourceAbout = document.getElementById 'edit-coffeeshop-about'
helperAbout = document.getElementById 'edit-coffeeshop-about-helper'
containerAbout = sourceAbout?.parentNode
savedValueAbout = sourceAbout?.textContent
targetAbout = sourceAbout?.dataset.target

sourceTimes = document.getElementById 'edit-coffeeshop-times'
helperTimes = document.getElementById 'edit-coffeeshop-times-helper'
containerTimes = sourceTimes?.parentNode
savedValueTimes = sourceTimes?.textContent
targetTimes = sourceTimes?.dataset.target

showAboutSection = (e) ->
  replacement = createTextArea 'about', sourceAbout, 'Add some information here...'
  submit = createSubmit 'about', editAboutSection
  cancel = createCancel 'about', revertAboutSection

  showElementsForEdition containerAbout, helperAbout, replacement, sourceAbout, submit, cancel, revertAboutSection
  sourceAbout = replacement

  koolbeans.cancelEvent e

revertAboutSection = (e) ->
  replacement = createParagraph 'about', savedValueAbout, showAboutSection

  revertElementsFromEdition containerAbout, helperAbout, replacement, sourceAbout, 'about', showAboutSection
  sourceAbout = replacement

  koolbeans.cancelEvent e

showTimesSection = (e) ->
  replacement = createTextArea 'times', sourceTimes, 'Mon-Fri: 09am-03pm'
  submit = createSubmit 'times', editTimesSection
  cancel = createCancel 'times', revertTimesSection

  showElementsForEdition containerTimes, helperTimes, replacement, sourceTimes, submit, cancel, revertTimesSection
  sourceTimes = replacement

  koolbeans.cancelEvent e

revertTimesSection = (e) ->
  replacement = createParagraph 'times', savedValueTimes, showTimesSection

  revertElementsFromEdition containerTimes, helperTimes, replacement, sourceTimes, 'times', showTimesSection
  sourceTimes = replacement

  koolbeans.cancelEvent e

editAboutSection = (e) ->
  document.getElementById('submit-edit-about').classList.add 'disabled'
  document.getElementById('cancel-edit-about').classList.add 'disabled'

  $.ajax
    url: targetAbout
    data: {about: sourceAbout.value}
    method: 'put'
    success: (data) ->
      savedValueAbout = data

      revertAboutSection e

  koolbeans.cancelEvent e

editTimesSection = (e) ->
  document.getElementById('submit-edit-times').classList.add 'disabled'
  document.getElementById('cancel-edit-times').classList.add 'disabled'

  $.ajax
    url: targetTimes
    data: {opening_times: sourceTimes.value}
    method: 'put'
    success: (data) ->
      savedValueTimes = data

      revertTimesSection e

  koolbeans.cancelEvent e

createParagraph = (id, content, cb) ->
  text = document.createElement 'p'
  text.onclick = cb
  text.id = 'edit-coffeeshop-' + id
  text.textContent = content
  text

createTextArea = (id, source, placeholder) ->
  replacement = document.createElement 'textarea'
  replacement.placeholder = placeholder
  replacement.classList.add 'form-control'
  replacement.value = source.textContent.trim()
  replacement.id = "edit-coffeeshop-#{id}-field"
  replacement

createSubmit = (id, cb) ->
  submit = document.createElement 'a'
  submit.onclick = cb
  submit.classList.add 'btn'
  submit.classList.add 'btn-success'
  submit.textContent = 'Submit'
  submit.id = 'submit-edit-' + id
  submit

createCancel = (id, cb) ->
  cancel = document.createElement 'a'
  cancel.onclick = cb
  cancel.classList.add 'btn'
  cancel.classList.add 'btn-default'
  cancel.textContent = 'Cancel'
  cancel.id = 'cancel-edit-' + id
  cancel

showElementsForEdition = (container, helper, replacement, source, submit, cancel, callback) ->
  container.replaceChild replacement, source
  helper.onclick = callback

  container.appendChild submit
  container.appendChild cancel

revertElementsFromEdition = (container, helper, replacement, source, id, callback) ->
  container.replaceChild replacement, source
  helper.onclick = callback

  container.removeChild document.getElementById 'submit-edit-' + id
  container.removeChild document.getElementById 'cancel-edit-' + id

helperAbout?.onclick = sourceAbout?.onclick = showAboutSection
helperTimes?.onclick = sourceAbout?.onclick = showTimesSection

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

descs = document.getElementsByClassName('change-description')
for desc in descs
  desc.onclick = (e) ->
    triggerChangeDescription this, e

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

triggerChangeDescription = (link, e) ->
  e.preventDefault()
  createInput link, e, 'text', changeDescription

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

changeDescription = (input, e) ->
  e.preventDefault()
  input.disable = true

  $.ajax
    url: input.dataset.target
    method: 'post'
    data: { description: input.value }
    success: (data) ->
      createLink input, 'change-description', data, triggerChangeDescription

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
  link.parentNode.classList.remove 'has-error'

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
      sizes = createSizesFor(select.options[select.selectedIndex].value, this.name.substr(-2, 1))
      sizesContainer.appendChild size for size in sizes

  baseProductChanged = () ->
    select = document.getElementById('referenced_product-0')
    if select.options[select.selectedIndex].value is ''
      sizesContainer = document.getElementById('sizes-0')
      sizesContainer.innerHTML = ''

      selector = 'input[type=radio][name=type\\[0\\]]:checked'
      checkedRatio = document.querySelector(selector)
      if checkedRatio? and checkedRatio.value isnt 'free'
        sizes = createSizesFor(this.options[this.selectedIndex].value, 0)
        sizesContainer.appendChild size for size in sizes

  selectReferencedProductChanged = () ->
    sizesContainer = document.getElementById('sizes-' + this.id.substr(-1))
    sizesContainer.innerHTML = ''

    selector = 'input[type=radio][name=type\\[' + this.id.substr(-1) + '\\]]:checked'
    checkedRatio = document.querySelector(selector)
    if checkedRatio? and checkedRatio.value isnt 'free'
      sizes = createSizesFor(this.options[this.selectedIndex].value, this.id.substr(-1))
      sizesContainer.appendChild size for size in sizes

  createSizesFor = (productId, nbProd) ->
    if productId == ''
      productId = document.querySelector('select#product').options[document.querySelector('select#product').selectedIndex].value
    for product in products
      if product.id == parseInt(productId)
        sizes = []
        for size in ['xs', 'sm', 'md', 'lg']
          sizes.push createSizeInput product, size, nbProd if product.pivot[size + '_activated'] and product.pivot[size] > 0
        return sizes

  createSizeInput = (product, size, nbProd) ->
    text = if product.type == 'food' then 'Reduction:' else coffeeShop['display_' + size]

    div = document.createElement 'div'
    div.classList.add 'form-group'

    label = document.createElement 'label'
    label.for = "size-#{size}-#{nbProd}"
    label.classList.add 'col-sm-2'
    label.classList.add 'control-label'
    label.textContent = text

    inputContainer = document.createElement 'div'
    inputContainer.classList.add 'col-sm-10'
    inputContainer.classList.add 'col-md-6'
    inputContainer.classList.add 'input-group'

    span = document.createElement 'span'
    value = document.querySelector("input[name='type[#{nbProd}]']:checked").value
    span.classList.add 'input-group-addon'
    span.innerHTML = if value == 'flat' then '£' else '%'

    input = document.createElement 'input'
    input.id = label.for
    input.name = "size-#{size}[#{nbProd}]"
    input.type = 'number'
    input.step = '0.01'
    input.min = '0'
    input.placeholder = '10'
    input.classList.add 'form-control'

    inputContainer.appendChild span
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

