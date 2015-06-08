if document.getElementById('order')

  productSelected = () ->
    opt = select.options[this.selectedIndex]

    removeSecondPartProduct this

    if opt.dataset.type == 'drink'
      sizes = createSizesSelect this, opt
    else
      price = createPriceInfo this, opt

    for o in select.options
      select.removeChild o if o.value == ''


  removeSecondPartProduct = (select) ->
    secondPart = select.parentNode.nextElementSibling
    secondPart.removeChild secondPart.children[0]

  createSizesSelect = (sel, opt) ->
    newSelect = document.createElement 'select'
    newSelect.id = sel.id.replace 'product-', 'productSize-'
    newSelect.name = 'productSizes[]'
    newSelect.classList.add 'form-control'

    product = findProduct opt

    for size in ['xs', 'sm', 'md', 'lg']
      if product.pivot[size + '_activated'] == 1 and product.pivot[size] != 0
        option = document.createElement 'option'
        option.value = size
        option.innerHTML = coffeeShop['display_' + size] + ' (£ ' + (product.pivot[size] / 100) + ')'

        newSelect.appendChild(option)

    sel.parentNode.nextElementSibling.appendChild newSelect

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

    newProduct = document.createElement 'label'
    newProduct.classList.add 'row'
    newProduct.classList.add 'full-width'

    productSpan = document.createElement 'span'
    productSpan.classList.add 'col-xs-12'
    productSpan.classList.add 'col-sm-6'

    priceSpan = document.createElement 'span'
    priceSpan.classList.add 'col-xs-12'
    priceSpan.classList.add 'col-sm-6'

    select = document.createElement 'select'
    select.classList.add 'form-control'
    select.name = 'products[]'
    select.id = 'product-'

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

    this.parentElement.insertBefore newProduct, this
    (productSelected.bind(select))()

  selects = document.querySelectorAll('select[name*=products]')
  for select in selects
    select.onchange = productSelected
