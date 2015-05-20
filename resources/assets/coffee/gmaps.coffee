initialize = ->
  container = document.getElementById 'maps-container'
  locationField = document.getElementById 'field-maps-location'

  initializeMaps container if container?
  initializeAutoComplete locationField, koolbeans.map if locationField?

initializeMaps = (container) ->
  options =
    zoom: 15
    styles: [
      featureType: "poi"
      elementType: "labels"
      stylers: [visibility: "off"]
    ]

  if container.dataset.position?
    position = container.dataset.position.split ','
    options.position = new google.maps.LatLng position[0], position[1]

  koolbeans.map = new google.maps.Map container, options
  koolbeans.marker = new google.maps.Marker
    map: koolbeans.map
    anchorPoint: new google.maps.Point 0, -29
  koolbeans.infoWindow = new google.maps.InfoWindow

  useGeoLocation koolbeans.map if navigator.geolocation

useGeoLocation = (map) ->
  navigator.geolocation.getCurrentPosition (position) ->
    map.setCenter new google.maps.LatLng(position.coords.latitude, position.coords.longitude)

initializeAutoComplete = (locationField, map) ->
  autoComplete = new google.maps.places.Autocomplete locationField

  bindMapToAutoComplete autoComplete, map if map?

bindMapToAutoComplete = (autoComplete, map) ->
  autoComplete.bindTo 'bounds', map

  google.maps.event.addListener autoComplete, 'place_changed', placeChanged(autoComplete)

placeChanged = (autoComplete) -> () ->
  hideMarkerAndWindow()

  place = autoComplete.getPlace()
  return if !place.geometry

  centerMapOn place
  moveMarkerTo place
  openInfoWindow place, koolbeans.marker
  changeFormFields place

hideMarkerAndWindow = () ->
  koolbeans.infoWindow.close();
  koolbeans.marker.setVisible(false);

centerMapOn = (place) ->
  if place.geometry.viewport
    koolbeans.map.fitBounds place.geometry.viewport
  else
    koolbeans.map.setCenter place.geometry.location
    koolbeans.map.setZoom 17

moveMarkerTo = (place) ->
  koolbeans.marker.setPosition place.geometry.location
  koolbeans.marker.setVisible true
  koolbeans.marker.setIcon
    url: place.icon,
    size: new google.maps.Size(71, 71),
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(17, 34),
    scaledSize: new google.maps.Size(35, 35)

openInfoWindow = (place, marker) ->
  address = [
    (place.address_components[0] && place.address_components[0].short_name || ''),
    (place.address_components[1] && place.address_components[1].short_name || ''),
    (place.address_components[2] && place.address_components[2].short_name || '')
  ].join(' ')

  koolbeans.infoWindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
  koolbeans.infoWindow.open(koolbeans.map, marker);

changeFormFields = (place) ->
  for component in place.address_components
    if component.types.indexOf('postal_code') != -1
      document.getElementById('postal_code').setAttribute 'value', component.short_name
  document.getElementById('latitude-field').setAttribute 'value', place.geometry.location.lat()
  document.getElementById('longitude-field').setAttribute 'value', place.geometry.location.lng()
  document.getElementById('place-id-field').setAttribute 'value', place.place_id

google.maps.event.addDomListener window, 'load', initialize
