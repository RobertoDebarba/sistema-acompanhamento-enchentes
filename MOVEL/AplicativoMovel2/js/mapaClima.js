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
}