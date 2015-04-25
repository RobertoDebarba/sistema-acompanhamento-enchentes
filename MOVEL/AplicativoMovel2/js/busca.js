var autocomplete;
var geolocationBusca;

function initializeBusca() {
  autocomplete = new google.maps.places.Autocomplete((document.getElementById('pesquisar')), { types: ['geocode'] });
}

function geolocateBusca() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      geolocationBusca = new google.maps.LatLng(
          position.coords.latitude, position.coords.longitude);
      autocomplete.setBounds(new google.maps.LatLngBounds(geolocationBusca,
          geolocationBusca));
    });
  }
}


