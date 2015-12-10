if document.getElementById('order')
  removeProduct = (e) ->
    e.preventDefault()

    return if (document.querySelectorAll('.order-products > label').length == 1)

    toRemove = this.parentNode.parentNode
    toRemove.parentNode.removeChild(toRemove)

  links = document.querySelectorAll('a.remove-product')
  for link in links
    link.onclick = removeProduct

  productSelected = () ->
    opt = select.options[this.selectedIndex]

    removeSecondPartProduct this

    if opt.dataset.type == 'drink'
      sizes = createSizesInputs this, opt
    else
      price = createPriceInfo this, opt

    for o in select.options
      return select.removeChild o if o.value == ''


  removeSecondPartProduct = (select) ->
    secondPart = select.parentNode.nextElementSibling
    secondPart.removeChild secondPart.children[0]

  createSizesInputs = (sel, opt) ->
    container = document.createElement 'span'
    container.classList.add 'sizes'

    select = document.createElement 'select'
    select.name = sel.name.replace 's[', 'Sizes['
    select.classList.add 'form-control'
    container.appendChild select

    product = findProduct opt


    sel.parentNode.nextElementSibling.appendChild container

  findProduct = (opt) ->
    for product in products
      return product if product.id == parseInt(opt.value)

  createPriceInfo = (sel, opt) ->
    product = findProduct opt

    newP = document.createElement 'p'
    newP.innerHTML = 'Price: £ ' + product.pivot.sm / 100
    newP.classList.add 'info-price'

    sel.parentNode.nextElementSibling.appendChild newP

  addProduct = document.getElementById('add-product')
  addProduct.onclick = (e) ->
    e.preventDefault()

    selects = document.querySelectorAll('.choose-product-select:last-of-type')
    idx = selects[selects.length - 1].id.replace('product-', '')
    idx = parseInt(idx) + 1

    newProduct = document.createElement 'label'
    newProduct.classList.add 'row'
    newProduct.classList.add 'full-width'

    productSpan = document.createElement 'span'
    productSpan.classList.add 'col-xs-12'
    productSpan.classList.add 'col-sm-6'

    priceSpan = document.createElement 'span'
    priceSpan.classList.add 'col-xs-12'
    priceSpan.classList.add 'col-sm-5'

    removeSpan = document.createElement 'span'
    removeSpan.classList.add 'col-xs-12'
    removeSpan.classList.add 'col-sm-1'

    removeLink = document.createElement 'a'
    removeLink.href = '#'
    removeLink.classList.add 'btn'
    removeLink.classList.add 'btn-danger'
    removeLink.classList.add 'remove-product'
    removeLink.classList.add 'form-control'
    removeLink.id = "remove-product-#{idx}"
    removeLink.innerHTML = '×'
    removeLink.onclick = removeProduct

    removeSpan.appendChild removeLink

    select = document.createElement 'select'
    select.classList.add 'form-control'
    select.classList.add 'choose-product-select'
    select.name = "products[#{idx}]"
    select.id = 'product-' + idx

    for prod in products
      pOpt = document.createElement 'option'
      pOpt.value = prod.id
      pOpt.dataset.type = prod.type
      pOpt.innerHTML = if prod.pivot.name == "" then prod.name else prod.pivot.name

      select.appendChild pOpt

    select.onchange = productSelected

    productSpan.appendChild select
    priceSpan.appendChild document.createElement 'span'

    newProduct.appendChild productSpan
    newProduct.appendChild priceSpan
    newProduct.appendChild removeSpan

    this.parentElement.insertBefore newProduct, this
    (productSelected.bind(select))()

  selects = document.querySelectorAll('select[name*=products]')
  for select in selects
    select.onchange = productSelected
