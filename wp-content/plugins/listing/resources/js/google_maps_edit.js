var alsp_map = null;
var alsp_allow_map_zoom = true; // allow/disallow map zoom in listener, this option needs because alsp_map.setZoom() also calls this listener
var alsp_geocoder = null;
var alsp_infoWindow = null;
var alsp_markersArray = [];
var alsp_glocation_backend = (function(index, point, location, address_line_1, address_line_2, zip_or_postal_index, map_icon_file) {
	this.index = index;
	this.point = point;
	this.location = location;
	this.address_line_1 = address_line_1;
	this.address_line_2 = address_line_2;
	this.zip_or_postal_index = zip_or_postal_index;
	this.map_icon_file = map_icon_file;
	this.alsp_placeMarker = function() {
		return alsp_placeMarker_backend(this);
	};
	this.compileAddress = function() {
		var address = this.address_line_1;
		if (this.address_line_2)
			address += ", "+this.address_line_2;
		if (this.location) {
			if (address)
				address += " ";
			address += this.location;
		}
		if (alsp_google_maps_objects.default_geocoding_location) {
			if (address)
				address += " ";
			address += alsp_google_maps_objects.default_geocoding_location;
		}
		if (this.zip_or_postal_index) {
			if (address)
				address += " ";
			address += this.zip_or_postal_index;
		}
		return address;
	};
	this.compileHtmlAddress = function() {
		var address = this.address_line_1;
		if (this.address_line_2)
			address += ", "+this.address_line_2;
		if (this.location) {
			if (this.address_line_1 || this.address_line_2)
				address += "<br />";
			address += this.location;
		}
		if (this.zip_or_postal_index)
			address += " "+this.zip_or_postal_index;
		return address;
	};
	this.setPoint = function(point) {
		this.point = point;
	};
});

(function($) {
	"use strict";

	var alsp_load_maps_backend = function() {
		if (document.getElementById("alsp-maps-canvas")) {
			var mapOptions = {
					zoom: 1,
					scrollwheel: true,
					gestureHandling: 'greedy',
					disableDoubleClickZoom: true,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					fullscreenControl: false
			};
			if (alsp_google_maps_objects.map_style_name != 'default' && alsp_google_maps_objects.map_styles)
				mapOptions.styles = eval(alsp_google_maps_objects.map_styles[alsp_google_maps_objects.map_style_name]);
			alsp_map = new google.maps.Map(document.getElementById("alsp-maps-canvas"), mapOptions);

			alsp_geocoder = new google.maps.Geocoder();

			var alsp_coords_array_1 = new Array();
			var alsp_coords_array_2 = new Array();

			if (alsp_isAnyLocation_backend())
				alsp_generateMap_backend();
			else
				alsp_map.setCenter(new google.maps.LatLng(34, 0));

			google.maps.event.addListener(alsp_map, 'zoom_changed', function() {
				if (alsp_allow_map_zoom)
					jQuery(".alsp-map-zoom").val(alsp_map.getZoom());
			});
		}
	}

	window.alsp_load_maps_api_backend = function() {
		$(document).trigger('alsp_google_maps_api_loaded');

		google.maps.event.addDomListener(window, 'load', alsp_load_maps_backend());
		
		alsp_load_maps_api(); // Load frontend maps
		
		alsp_setupAutocomplete();
	}
	
	window.alsp_setupAutocomplete = function() {
		$(".alsp-field-autocomplete").each( function() {
			if (google.maps && google.maps.places) {
				if (alsp_google_maps_objects.address_autocomplete_code != '0')
					var options = { componentRestrictions: {country: alsp_google_maps_objects.address_autocomplete_code}};
				else
					var options = { };
				var searchBox = new google.maps.places.Autocomplete(this, options);
				
				google.maps.event.addListener(searchBox, 'place_changed', function () {
					alsp_generateMap_backend();
				});
			}
		});
	}

	function alsp_setMapCenter_backend(alsp_coords_array_1, alsp_coords_array_2) {
		var count = 0;
		var bounds = new google.maps.LatLngBounds();
		for (count == 0; count<alsp_coords_array_1.length; count++)  {
			bounds.extend(new google.maps.LatLng(alsp_coords_array_1[count], alsp_coords_array_2[count]));
		}
		if (count == 1) {
			if (jQuery(".alsp-map-zoom").val() == '' || jQuery(".alsp-map-zoom").val() == 0)
				var zoom_level = 1;
			else
				var zoom_level = parseInt(jQuery(".alsp-map-zoom").val());
		} else {
			alsp_map.fitBounds(bounds);
			var zoom_level = alsp_map.getZoom();
		}
		alsp_map.setCenter(bounds.getCenter());
	
		// allow/disallow map zoom in listener, this option needs because alsp_map.setZoom() also calls this listener
		alsp_allow_map_zoom = false;
		alsp_map.setZoom(zoom_level);
		alsp_allow_map_zoom = true;
	}
	
	var alsp_coords_array_1 = new Array();
	var alsp_coords_array_2 = new Array();
	var alsp_attempts = 0;
	window.alsp_generateMap_backend = function() {
		//alsp_ajax_loader_show("Locations targeting...");
		alsp_coords_array_1 = new Array();
		alsp_coords_array_2 = new Array();
		alsp_attempts = 0;
		alsp_clearOverlays_backend();
		alsp_geocodeAddress_backend(0);
		alsp_setupAutocomplete();
	}

	function alsp_geocodeAddress_backend(i) {
		if ($(".alsp-location-in-metabox:eq("+i+")").length) {
			var locations_drop_boxes = [];
			$(".alsp-location-in-metabox:eq("+i+")").find("select").each(function(j, val) {
				if ($(this).val())
					locations_drop_boxes.push($(this).children(":selected").text());
			});
	
			var location_string = locations_drop_boxes.reverse().join(', ');
	
			if ($(".alsp-manual-coords:eq("+i+")").is(":checked") && jQuery(".alsp-map-coords-1:eq("+i+")").val()!='' && $(".alsp-map-coords-2:eq("+i+")").val()!='' && ($(".alsp-map-coords-1:eq("+i+")").val()!=0 || $(".alsp-map-coords-2:eq("+i+")").val()!=0)) {
				var map_coords_1 = $(".alsp-map-coords-1:eq("+i+")").val();
				var map_coords_2 = $(".alsp-map-coords-2:eq("+i+")").val();
				if ($.isNumeric(map_coords_1) && $.isNumeric(map_coords_2)) {
					var point = new google.maps.LatLng(map_coords_1, map_coords_2);
					alsp_coords_array_1.push(map_coords_1);
					alsp_coords_array_2.push(map_coords_2);
	
					var location_obj = new alsp_glocation_backend(i, point, 
						location_string,
						$(".alsp-address-line-1:eq("+i+")").val(),
						$(".alsp-address-line-2:eq("+i+")").val(),
						$(".alsp-zip-or-postal-index:eq("+i+")").val(),
						$(".alsp-map-icon-file:eq("+i+")").val()
					);
					location_obj.alsp_placeMarker();
				}
				alsp_geocodeAddress_backend(i+1);
				if ((i+1) == jQuery(".alsp-location-in-metabox").length) {
					alsp_setMapCenter_backend(alsp_coords_array_1, alsp_coords_array_2);
					alsp_ajax_loader_hide();
				}
			} else if (location_string || $(".alsp-address-line-1:eq("+i+")").val() || $(".alsp-address-line-2:eq("+i+")").val() || $(".alsp-zip-or-postal-index:eq("+i+")").val()) {
				var location_obj = new alsp_glocation_backend(i, null, 
					location_string,
					$(".alsp-address-line-1:eq("+i+")").val(),
					$(".alsp-address-line-2:eq("+i+")").val(),
					$(".alsp-zip-or-postal-index:eq("+i+")").val(),
					$(".alsp-map-icon-file:eq("+i+")").val()
				);
	
				// Geocode by address
				alsp_geocoder.geocode( { 'address': location_obj.compileAddress()}, function(results, status) {
					if (status != google.maps.GeocoderStatus.OK) {
						if (status == 'OVER_QUERY_LIMIT​' && alsp_attempts < 5) {
							alsp_attempts++;
							setTimeout('alsp_geocodeAddress_backend('+i+')', 2000);
						} else {
							alert("Sorry, we were unable to geocode that address (address #"+(i)+") for the following reason: " + status);
							alsp_ajax_loader_hide();
						}
					} else {
						var point = results[0].geometry.location;
						$(".alsp-map-coords-1:eq("+i+")").val(point.lat());
						$(".alsp-map-coords-2:eq("+i+")").val(point.lng());
						var map_coords_1 = point.lat();
						var map_coords_2 = point.lng();
						alsp_coords_array_1.push(map_coords_1);
						alsp_coords_array_2.push(map_coords_2);
						location_obj.setPoint(point);
						location_obj.alsp_placeMarker();
						alsp_geocodeAddress_backend(i+1);
					}
					if ((i+1) == $(".alsp-location-in-metabox").length) {
						alsp_setMapCenter_backend(alsp_coords_array_1, alsp_coords_array_2);
						alsp_ajax_loader_hide();
					}
				});
			} else
				alsp_ajax_loader_hide();
		} else
			alsp_attempts = 0;
	}

	window.alsp_placeMarker_backend = function(alsp_glocation) {
		if (alsp_google_maps_objects.map_markers_type != 'icons') {
			if (alsp_google_maps_objects.global_map_icons_path != '') {
				if (alsp_glocation.map_icon_file)
					var icon_file = alsp_google_maps_objects.global_map_icons_path+'icons/'+alsp_glocation.map_icon_file;
				else
					var icon_file = alsp_google_maps_objects.global_map_icons_path+"blank.png";
		
				var customIcon = {
						url: icon_file,
						size: new google.maps.Size(parseInt(alsp_google_maps_objects.marker_image_width), parseInt(alsp_google_maps_objects.marker_image_height)),
						origin: new google.maps.Point(0, 0),
						anchor: new google.maps.Point(parseInt(alsp_google_maps_objects.marker_image_anchor_x), parseInt(alsp_google_maps_objects.marker_image_anchor_y))
				};
				
				var manual_coords_val = alsp_js_objects.manual_coods;
				
				if(manual_coords_val == 1){
					var manual_coords = true;
				}else{
					var manual_coords = false;
				}
				var marker = new google.maps.Marker({
						position: alsp_glocation.point,
						map: alsp_map,
						icon: customIcon,
						draggable: manual_coords
				});
			} else 
				var marker = new google.maps.Marker({
						position: alsp_glocation.point,
						map: alsp_map,
						draggable: manual_coords
				});
			
			alsp_markersArray.push(marker);
			google.maps.event.addListener(marker, 'click', function() {
				alsp_show_infoWindow_backend(alsp_glocation, marker);
			});
		
			google.maps.event.addListener(marker, 'dragend', function(event) {
				var point = marker.getPosition();
				if (point !== undefined) {
					var selected_location_num = alsp_glocation.index;
					$(".alsp-manual-coords:eq("+alsp_glocation.index+")").attr("checked", true);
					$(".alsp-manual-coords:eq("+alsp_glocation.index+")").parents(".alsp-manual-coords-wrapper").find(".alsp-manual-coords-block").show(200);
					
					$(".alsp-map-coords-1:eq("+alsp_glocation.index+")").val(point.lat());
					$(".alsp-map-coords-2:eq("+alsp_glocation.index+")").val(point.lng());
				}
			});
		} else {
			alsp_load_richtext();
			
			var icon = false;
			var color = false;
			if (!alsp_glocation.map_icon_file || !alsp_in_array(alsp_glocation.map_icon_file, alsp_google_maps_objects.map_markers_array)) {
				if (!icon && alsp_google_maps_objects.default_marker_icon)
					icon = alsp_google_maps_objects.default_marker_icon;
			} else
				icon = alsp_glocation.map_icon_file;
			if (!color)
				if (alsp_google_maps_objects.default_marker_color)
					color = alsp_google_maps_objects.default_marker_color;
				else
					color = '#2393ba';
			
			if (icon) {
				var map_marker_icon = '<span class="alsp-map-marker-icon fa '+icon+'" style="color: '+color+';"></span>';
				var map_marker_class = 'alsp-map-marker';
			} else {
				var map_marker_icon = '';
				var map_marker_class = 'alsp-map-marker-empty';
			}

			var marker = new RichMarker({
				position: alsp_glocation.point,
				map: alsp_map,
				flat: true,
				draggable: true,
				height: 40,
				content: '<div class="'+map_marker_class+'" style="background: '+color+' none repeat scroll 0 0;">'+map_marker_icon+'</div>'
			});
			
			alsp_markersArray.push(marker);
			google.maps.event.addListener(marker, 'position_changed', function(event) {
				var point = marker.getPosition();
				if (point !== undefined) {
					var selected_location_num = alsp_glocation.index;
					$(".alsp-manual-coords:eq("+alsp_glocation.index+")").attr("checked", true);
					$(".alsp-manual-coords:eq("+alsp_glocation.index+")").parents(".alsp-manual-coords-wrapper").find(".alsp-manual-coords-block").show(200);
					
					$(".alsp-map-coords-1:eq("+alsp_glocation.index+")").val(point.lat());
					$(".alsp-map-coords-2:eq("+alsp_glocation.index+")").val(point.lng());
				}
			});
		}
	}
	
	// This function builds info Window and shows it hiding another
	function alsp_show_infoWindow_backend(alsp_glocation, marker) {
		address = alsp_glocation.compileHtmlAddress();
		var index = alsp_glocation.index;
	
		// we use global alsp_infoWindow, not to close/open it - just to set new content (in order to prevent blinking)
		if (!alsp_infoWindow)
			alsp_infoWindow = new google.maps.InfoWindow();
	
		alsp_infoWindow.setContent(address);
		alsp_infoWindow.open(alsp_map, marker);
	}
	
	function alsp_clearOverlays_backend() {
		if (alsp_markersArray) {
			for(var i = 0; i<alsp_markersArray.length; i++){
				alsp_markersArray[i].setMap(null);
			}
		}
	}
	
	function alsp_isAnyLocation_backend() {
		var is_location = false;
		$(".alsp-location-in-metabox").each(function(i, val) {
			var locations_drop_boxes = [];
			$(this).find("select").each(function(j, val) {
				if ($(this).val()) {
					is_location = true;
					return false;
				}
			});
	
			if ($(".alsp-manual-coords:eq("+i+")").is(":checked") && $(".alsp-map-coords-1:eq("+i+")").val()!='' && $(".alsp-map-coords-2:eq("+i+")").val()!='' && ($(".alsp-map-coords-1:eq("+i+")").val()!=0 || $(".alsp-map-coords-2:eq("+i+")").val()!=0)) {
				is_location = true;
				return false;
			}
		});
		if (is_location)
			return true;
	
		if ($(".alsp-address-line-1[value!='']").length != 0)
			return true;
	
		if ($(".alsp-address-line-2[value!='']").length != 0)
			return true;
	
		if ($(".alsp-zip-or-postal-index[value!='']").length != 0)
			return true;
	}
})(jQuery);