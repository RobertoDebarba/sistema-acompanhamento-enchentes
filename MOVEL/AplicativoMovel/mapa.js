var overlay;
USGSOverlay.prototype = new google.maps.OverlayView();

function initialize() {

	var markers = [];
	var mapOptions = {
		zoom : 14,
		center : new google.maps.LatLng(-26.825, -49.268)
	};

	var map = new google.maps.Map(document.getElementById('mapa'), mapOptions);

	// --- Imagem de inundação ---

	//Define posição da imagem
	var swBound = new google.maps.LatLng(-26.8744997, -49.30611066);
	var neBound = new google.maps.LatLng(-26.7894996999999, -49.23311066000017);
	var bounds = new google.maps.LatLngBounds(swBound, neBound);

	// Define imagem
	var srcImage = './img/status-inundacao.png';

	//Seta a imagem no mapa
	overlay = new USGSOverlay(bounds, srcImage, map);

	// --- Marcador da regua ---

	//Seta posição e propriedades
	var latLngRegua = new google.maps.LatLng(-26.82682817, -49.27629948);
	var iconeRegua = './img/marcadorRegua.png';
	var marcadorRegua = new google.maps.Marker({
		position : latLngRegua,
		map : map,
		icon : iconeRegua,
		title : "Ponto de medição"
	});

	//Seta conteudo do quadro de info
	var conteudoMarcadorRegua = '<!DOCTYPE html>' + '<html>' + '<head>' + '<title></title>' + '<style>' + '#wrap {' + 'margin:0 auto;' + '}' + '#left_col {' + 'float:left;' + '}' + '#right_col {' + 'float:right;' + '}' + '#foto {' + 'width: 68px;' + 'margin-right: 7px;' + '}' + '</style>' + '</head>' + '<body>' + '<div id="content">' + '<h1 id="firstHeading" class="firstHeading">Ponto de Medição</h1>' + '<div id="bodyContent">' + '<div id="wrap">' + '<div id="left_col">' + '<img id="foto" src=./img/foto-regua.jpg>' + '</div>' + '</div>' + '<div id="rigth_col":' + '<p>' + 'Rio: Rio Benedito.<br>' + 'Bairro: Centro.<br>' + 'Cidade: Timbó.<br>' + 'Latitude: ' + latLngRegua.lat() + '<br>' + 'Longitude: ' + latLngRegua.lng() + '<br>' + '</div>' + '</div>' + '</body>' + '</html>';

	//Seta no mapa
	var infowindow = new google.maps.InfoWindow({
		content : conteudoMarcadorRegua
	});

	google.maps.event.addListener(marcadorRegua, 'click', function() {
		infowindow.open(map, marcadorRegua);
	});

	marcadorRegua.setMap(map);

	// --- Campo de busca ---

	// Create the search box and link it to the UI element.
	var input = /** @type {HTMLInputElement} */(
		document.getElementById('pac-input'));
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

	// [END region_initialization]

	// [START region_constructor]
	/** @constructor */
	function USGSOverlay(bounds, image, map) {

		// Initialize all properties.
		this.bounds_ = bounds;
		this.image_ = image;
		this.map_ = map;

		// Define a property to hold the image's div. We'll
		// actually create this div upon receipt of the onAdd()
		// method so we'll leave it null for now.
		this.div_ = null;

		// Explicitly call setMap on this overlay.
		this.setMap(map);
	}

	// [END region_constructor]

	// [START region_attachment]
	/**
	 * onAdd is called when the map's panes are ready and the overlay has been
	 * added to the map.
	 */
	USGSOverlay.prototype.onAdd = function() {

		var div = document.createElement('div');
		div.style.borderStyle = 'none';
		div.style.borderWidth = '0px';
		div.style.position = 'absolute';

		// Create the img element and attach it to the div.
		var img = document.createElement('img');
		img.src = this.image_;
		img.style.width = '100%';
		img.style.height = '100%';
		img.style.position = 'absolute';
		div.appendChild(img);

		this.div_ = div;

		// Add the element to the "overlayLayer" pane.
		var panes = this.getPanes();
		panes.overlayLayer.appendChild(div);
	};
	// [END region_attachment]

	// [START region_drawing]
	USGSOverlay.prototype.draw = function() {

		// We use the south-west and north-east
		// coordinates of the overlay to peg it to the correct position and size.
		// To do this, we need to retrieve the projection from the overlay.
		var overlayProjection = this.getProjection();

		// Retrieve the south-west and north-east coordinates of this overlay
		// in LatLngs and convert them to pixel coordinates.
		// We'll use these coordinates to resize the div.
		var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
		var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());

		// Resize the image's div to fit the indicated dimensions.
		var div = this.div_;
		div.style.left = sw.x + 'px';
		div.style.top = ne.y + 'px';
		div.style.width = (ne.x - sw.x) + 'px';
		div.style.height = (sw.y - ne.y) + 'px';
	};
	// [END region_drawing]

	// [START region_removal]
	// The onRemove() method will be called automatically from the API if
	// we ever set the overlay's map property to 'null'.
	USGSOverlay.prototype.onRemove = function() {
		this.div_.parentNode.removeChild(this.div_);
		this.div_ = null;
	};
	// [END region_removal]
}

<<<<<<< HEAD:MOVEL/AplicativoMovel/js/mapaClima.js
$(function() {
	$('.loadMap').ready(function(e) {
		var map = this.id + '-map';

		if ($('#mapaClima #' + map).length === 0) {
			$('<div class="map_style" id="' + map + '">').appendTo('#mapaClima');
			initializeWeather();
		}
	});
}); 
=======
// [END region_constructor]

// [START region_attachment]
/**
 * onAdd is called when the map's panes are ready and the overlay has been
 * added to the map.
 */
USGSOverlay.prototype.onAdd = function() {

	var div = document.createElement('div');
	div.style.borderStyle = 'none';
	div.style.borderWidth = '0px';
	div.style.position = 'absolute';

	// Create the img element and attach it to the div.
	var img = document.createElement('img');
	img.src = this.image_;
	img.style.width = '100%';
	img.style.height = '100%';
	img.style.position = 'absolute';
	div.appendChild(img);

	this.div_ = div;

	// Add the element to the "overlayLayer" pane.
	var panes = this.getPanes();
	panes.overlayLayer.appendChild(div);
};
// [END region_attachment]

// [START region_drawing]
USGSOverlay.prototype.draw = function() {

	// We use the south-west and north-east
	// coordinates of the overlay to peg it to the correct position and size.
	// To do this, we need to retrieve the projection from the overlay.
	var overlayProjection = this.getProjection();

	// Retrieve the south-west and north-east coordinates of this overlay
	// in LatLngs and convert them to pixel coordinates.
	// We'll use these coordinates to resize the div.
	var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
	var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());

	// Resize the image's div to fit the indicated dimensions.
	var div = this.div_;
	div.style.left = sw.x + 'px';
	div.style.top = ne.y + 'px';
	div.style.width = (ne.x - sw.x) + 'px';
	div.style.height = (sw.y - ne.y) + 'px';
};
// [END region_drawing]

// [START region_removal]
// The onRemove() method will be called automatically from the API if
// we ever set the overlay's map property to 'null'.
USGSOverlay.prototype.onRemove = function() {
	this.div_.parentNode.removeChild(this.div_);
	this.div_ = null;
};
// [END region_removal]

//Adiciona mapa

google.maps.event.addDomListener(window, 'load', initialize);
>>>>>>> 69b548cee7598b771a766ca0d11f5f843fe0da6b:MOVEL/AplicativoMovel/mapa.js
