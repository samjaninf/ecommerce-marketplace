document.getElementById('add-review')?.onclick = (e) ->
  @classList.add 'hide'

  form = document.getElementById('add-review-form')
  form.classList.remove 'hide'

  ratings = document.getElementsByClassName('select-rating')[0]
  for star in ratings.children
    star.onmouseover = () ->
      for s,i in ratings.children
        s.classList.remove 'rating-no'
        s.classList.add 'rating-yes'
        return if s == @

    star.onmouseout = () ->
      for s,i in ratings.children
        s.classList.remove 'rating-yes'
        s.classList.add 'rating-no'
        return if s == @

    star.onclick = () ->
      rating = 0
      for s, index in ratings.children
        document.getElementById('rating-input').value = (index + 1) if s == @
        s.onclick = (e) -> koolbeans.cancelEvent(e)
        s.onmouseout = (e) -> koolbeans.cancelEvent(e)
        s.onmouseover = (e) -> koolbeans.cancelEvent(e)

  koolbeans.cancelEvent e

document.getElementById('post-review')?.onsubmit = (e) ->
  if document.getElementById('rating-input').value == ''
    document.getElementById('empty-rating').classList.remove 'hide'
    koolbeans.cancelEvent e

document.getElementById('show-more-reviews')?.onclick = (e) ->
  @classList.add('hide')
  for review in @parentNode.children
    review.classList.remove 'hide' if review.classList.contains('hide') and review.nodeName == 'DIV'

  koolbeans.cancelEvent e

document.getElementById('search-form')?.onsubmit = (e) ->
  that = @
  filters = document.getElementsByClassName('search-filter')
  if filters?
    [].forEach.call filters, (item) ->
      if (item.checked)
        input = document.createElement 'input'
        input.type = 'hidden'
        input.name = item.name
        input.value = item.value

        that.appendChild input
