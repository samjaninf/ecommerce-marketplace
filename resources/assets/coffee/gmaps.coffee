initialize = ->
  navigator.geolocation.getCurrentPosition( (a) =>
    document.getElementById('my-current-location').value = a.coords.latitude + ',' + a.coords.longitude
    document.getElementById('filter-location').value = a.coords.latitude + ',' + a.coords.longitude
  )

  containers = document.querySelectorAll '#maps-container,.maps-container'
  locationField = document.getElementById 'field-maps-location'

  for cont in containers
    initializeMaps cont
  initializeAutoComplete locationField, koolbeans.map if locationField?

initializeMaps = (container) ->
  return if container.offsetParent == null
  options =
    zoom: 15
    styles: [
      featureType: "poi"
      elementType: "labels"
      stylers: [visibility: "off"]
    ]

  draggable = container.classList.contains('draggable-marker')
  koolbeans.map = new google.maps.Map container, options

  cs = document.querySelectorAll 'div[data-latitude]'
  for cof in cs
    addMarker cof.dataset.latitude, cof.dataset.longitude, cof.dataset.title, cof.dataset.id

  if container.dataset.position?
    position = container.dataset.position.split ','
    location = new google.maps.LatLng position[0], position[1]
    centerMapOnLocation location
  else if navigator.geolocation
    useGeoLocation koolbeans.map

addMarker = (lat, lng, title, id) ->
  console.log(lat, lng, title)
  infoWindow = new google.maps.InfoWindow
    content: '<h3><a href="/coffee-shop/' + id + '">' + title + '</a></h3>'
  marker = new google.maps.Marker
    map: koolbeans.map
    position: new google.maps.LatLng lat, lng
    ttle: title
  marker.addListener('click', (e) ->
      infoWindow.open(koolbeans.map, marker)
  )

useGeoLocation = () ->
  navigator.geolocation.getCurrentPosition (position) ->
    location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
    centerMapOnLocation location

initializeAutoComplete = (locationField, map) ->
  autoComplete = new google.maps.places.Autocomplete locationField, { types: ['address'] }

  bindMapToAutoComplete autoComplete, map if map?

bindMapToAutoComplete = (autoComplete, map) ->
  autoComplete.bindTo 'bounds', map

  google.maps.event.addListener autoComplete, 'place_changed', placeChanged(autoComplete)

placeChanged = (autoComplete) -> () ->
  hideMarkerAndWindow()

  place = autoComplete.getPlace()
  return if !place.geometry

  centerMapOn place
  openInfoWindow place
  changeFormFields place

hideMarkerAndWindow = () ->
  koolbeans.infoWindow.close();

centerMapOn = (place) ->
  if place.geometry.viewport
    koolbeans.map.fitBounds place.geometry.viewport
  else
    centerMapOnLocation place.geometry.location

centerMapOnLocation = () ->
  cs = document.querySelectorAll 'div[data-latitude]'
  location = new google.maps.LatLng cs[0].dataset.latitude, cs[0].dataset.longitude
  koolbeans.map.setCenter location
  koolbeans.map.setZoom 17
  moveMarkerTo location


openInfoWindow = (place, marker) ->
  address = [
    (place.address_components[0] && place.address_components[0].short_name || ''),
    (place.address_components[1] && place.address_components[1].short_name || ''),
    (place.address_components[2] && place.address_components[2].short_name || '')
  ].join(' ')

  console.log(place)

  koolbeans.infoWindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
  koolbeans.infoWindow.open(koolbeans.map, marker);

changeFormFields = (place) ->
  for component in place.address_components
    if component.types.indexOf("administrative_area_level_2") != -1 or component.types.indexOf("administrative_area_level_1") != -1
      document.getElementById('county').setAttribute 'value', component.long_name
    if component.types.indexOf('postal_code') != -1
      document.getElementById('postal_code').setAttribute 'value', component.short_name
  document.getElementById('latitude-field').setAttribute 'value', place.geometry.location.lat()
  document.getElementById('longitude-field').setAttribute 'value', place.geometry.location.lng()
  document.getElementById('place-id-field').setAttribute 'value', place.place_id

google.maps.event.addDomListener window, 'load', initialize if google?