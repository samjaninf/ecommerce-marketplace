document.getElementById('showApplications').onclick = (e) ->
  @parentNode.classList.add 'hide'
  document.getElementById('applications').classList.remove 'hide'

  koolbeans.cancelEvent e
