(function() {
  var bindMapToAutoComplete, centerMapOn, changeFormFields, hideMarkerAndWindow, initialize, initializeAutoComplete, initializeMaps, moveMarkerTo, openInfoWindow, placeChanged, useGeoLocation;

  initialize = function() {
    var container, locationField;
    container = document.getElementById('maps-container');
    locationField = document.getElementById('field-maps-location');
    if (container != null) {
      initializeMaps(container);
    }
    if (locationField != null) {
      return initializeAutoComplete(locationField, koolbeans.map);
    }
  };

  initializeMaps = function(container) {
    var options, position;
    options = {
      zoom: 15,
      styles: [
        {
          featureType: "poi",
          elementType: "labels",
          stylers: [
            {
              visibility: "off"
            }
          ]
        }
      ]
    };
    if (container.dataset.position != null) {
      position = container.dataset.position.split(',');
      options.position = new google.maps.LatLng(position[0], position[1]);
    }
    koolbeans.map = new google.maps.Map(container, options);
    koolbeans.marker = new google.maps.Marker({
      map: koolbeans.map,
      anchorPoint: new google.maps.Point(0, -29)
    });
    koolbeans.infoWindow = new google.maps.InfoWindow;
    if (navigator.geolocation) {
      return useGeoLocation(koolbeans.map);
    }
  };

  useGeoLocation = function(map) {
    return navigator.geolocation.getCurrentPosition(function(position) {
      var location;
      location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
      map.setCenter(location);
      return moveMarkerTo(location);
    });
  };

  initializeAutoComplete = function(locationField, map) {
    var autoComplete;
    autoComplete = new google.maps.places.Autocomplete(locationField);
    if (map != null) {
      return bindMapToAutoComplete(autoComplete, map);
    }
  };

  bindMapToAutoComplete = function(autoComplete, map) {
    autoComplete.bindTo('bounds', map);
    return google.maps.event.addListener(autoComplete, 'place_changed', placeChanged(autoComplete));
  };

  placeChanged = function(autoComplete) {
    return function() {
      var place;
      hideMarkerAndWindow();
      place = autoComplete.getPlace();
      if (!place.geometry) {
        return;
      }
      centerMapOn(place);
      moveMarkerTo(place.geometry.location);
      openInfoWindow(place, koolbeans.marker);
      return changeFormFields(place);
    };
  };

  hideMarkerAndWindow = function() {
    koolbeans.infoWindow.close();
    return koolbeans.marker.setVisible(false);
  };

  centerMapOn = function(place) {
    if (place.geometry.viewport) {
      return koolbeans.map.fitBounds(place.geometry.viewport);
    } else {
      koolbeans.map.setCenter(place.geometry.location);
      return koolbeans.map.setZoom(17);
    }
  };

  moveMarkerTo = function(position) {
    koolbeans.marker.setPosition(position);
    return koolbeans.marker.setVisible(true);
  };

  openInfoWindow = function(place, marker) {
    var address;
    address = [place.address_components[0] && place.address_components[0].short_name || '', place.address_components[1] && place.address_components[1].short_name || '', place.address_components[2] && place.address_components[2].short_name || ''].join(' ');
    koolbeans.infoWindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    return koolbeans.infoWindow.open(koolbeans.map, marker);
  };

  changeFormFields = function(place) {
    var component, i, len, ref;
    ref = place.address_components;
    for (i = 0, len = ref.length; i < len; i++) {
      component = ref[i];
      if (component.types.indexOf('postal_code') !== -1) {
        document.getElementById('postal_code').setAttribute('value', component.short_name);
      }
    }
    document.getElementById('latitude-field').setAttribute('value', place.geometry.location.lat());
    document.getElementById('longitude-field').setAttribute('value', place.geometry.location.lng());
    return document.getElementById('place-id-field').setAttribute('value', place.place_id);
  };

  google.maps.event.addDomListener(window, 'load', initialize);

}).call(this);

//# sourceMappingURL=gmaps.js.map