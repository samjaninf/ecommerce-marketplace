document.getElementById('showApplications')?.onclick = (e) ->
  @parentNode.classList.add 'hide'
  document.getElementById('applications').classList.remove 'hide'

  koolbeans.cancelEvent e

document.querySelector('#create-product #type')?.onchange = (e) ->
  typeChanged e, this.options[this.selectedIndex].value

document.getElementById('add-type')?.onkeydown = (e) ->
  addType e, this, this.value if e.keyCode == 13 or e.keyCode == 9

document.getElementById('add-type-trigger')?.onclick = (e) ->
  addType e, document.getElementById('add-type'), document.getElementById('add-type').value

typeChanged = (e, val) ->
  types = document.querySelectorAll('.checkbox.type-' + val)
  for type in types
    type.classList.remove 'hide' if type.classList.contains 'hide'
    type.children[0].children[0].checked = false
  types = document.querySelectorAll('.checkbox.type-' + if val == 'drink' then 'food' else 'drink')
  for type in types
    type.classList.add 'hide' if not type.classList.contains 'hide'
    type.children[0].children[0].checked = false

addType = (e, input, val) ->
  input.disabled = true
  select = document.querySelector('#create-product #type')
  type = select.options[select.selectedIndex].value

  jQuery.ajax
    url: '/admin/product-types'
    data: { value: val, type: type }
    method: 'post'
    success: () ->
      checkbox = document.createElement 'input'
      checkbox.type = 'checkbox'
      checkbox.name = "product_type[#{val}]"
      checkbox.id = "product_type-#{val}"
      checkbox.checked = true

      label = document.createElement 'label'
      label.for = checkbox.id
      label.appendChild checkbox
      label.appendChild document.createTextNode val

      div = document.createElement 'div'
      div.classList.add cls for cls in ["type-#{type}", 'checkbox']
      div.appendChild label

      document.getElementById('product-types-list').appendChild div
      input.value = ''
      input.parentNode.parentNode.parentNode.classList.remove 'has-error'
    error: () ->
      input.parentNode.parentNode.parentNode.classList.add 'has-error'
    complete: () ->
      input.disabled = false
      input.focus()

  koolbeans.cancelEvent e

select = document.querySelector('#create-product #type')
typeChanged window.event, select.options[select.selectedIndex].value if select?
