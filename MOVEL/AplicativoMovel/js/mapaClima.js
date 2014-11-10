function initializeWeather() {
	var mapOptions = {
		zoom : 10,
		/*panControl: false,
		 zoomControl: false,
		 mapTypeControl: false,
		 scaleControl: false,
		 streetViewControl: false,
		 overviewMapControl: false,*/
		center : new google.maps.LatLng(-26.82, -49.28),
		mapTypeId : google.maps.MapTypeId.SATELLITE
	};

	var map = new google.maps.Map(document.getElementById('mapaClima'), mapOptions);

	var weatherLayer = new google.maps.weather.WeatherLayer({
		temperatureUnits : google.maps.weather.TemperatureUnit.CELSIUS
	});
	weatherLayer.setMap(map);

	var cloudLayer = new google.maps.weather.CloudLayer();
	cloudLayer.setMap(map);

	// --- Campo de busca ---

	// Create the search box and link it to the UI element.
	var input = /** @type {HTMLInputElement} */(
		document.getElementById('pac-input2'));
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	var searchBox = new google.maps.places.SearchBox(
	/** @type {HTMLInputElement} */(input));

	// [START region_getplaces]
	// Listen for the event fired when the user selects an item from the
	// pick list. Retrieve the matching places for that item.
	google.maps.event.addListener(searchBox, 'places_changed', function() {
		var places = searchBox.getPlaces();

		if (places.length == 0) {
			return;
		}
		for (var i = 0, marker; marker = markers[i]; i++) {
			marker.setMap(null);
		}

		// For each place, get the icon, place name, and location.
		markers = [];
		var bounds = new google.maps.LatLngBounds();
		for (var i = 0, place; place = places[i]; i++) {
			var image = {
				url : place.icon,
				size : new google.maps.Size(71, 71),
				origin : new google.maps.Point(0, 0),
				anchor : new google.maps.Point(17, 34),
				scaledSize : new google.maps.Size(25, 25)
			};

			// Create a marker for each place.
			var marker = new google.maps.Marker({
				map : map,
				icon : image,
				title : place.name,
				position : place.geometry.location
			});

			markers.push(marker);

			bounds.extend(place.geometry.location);
		}

		//Seta o mapa no local

		// This is needed to set the zoom after fitbounds,
		google.maps.event.addListener(map, 'zoom_changed', function() {
			zoomChangeBoundsListener = google.maps.event.addListener(map, 'bounds_changed', function(event) {
				if (this.getZoom() > 15 && this.initialZoom == true) {
					// Change max/min zoom here
					this.setZoom(14);
					this.initialZoom = false;
				}
				google.maps.event.removeListener(zoomChangeBoundsListener);
			});
		});
		map.initialZoom = true;

		map.fitBounds(bounds);
	});
	// [END region_getplaces]

	// Bias the SearchBox results towards places that are within the bounds of the
	// current map's viewport.
	google.maps.event.addListener(map, 'bounds_changed', function() {
		var bounds = map.getBounds();
		searchBox.setBounds(bounds);
	});
	
}
google.maps.event.addDomListener(window, 'load', initializeWeather);