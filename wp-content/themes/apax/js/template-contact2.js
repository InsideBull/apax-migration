function initMap() {

	var contact = {lat: parseFloat(48.874031), lng: parseFloat(2.308607)};

	var map = new google.maps.Map(document.getElementById('google-map-contact2'), {

		draggable: $(window).width() < 700 ? false : true,

		zoom: 17,

		center: contact,

		scrollwheel: false,

		mapTypeControl: true,

		mapTypeControlOptions: {

		  style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,

		  position: google.maps.ControlPosition.TOP_RIGHT,

		  /*mapTypeIds: [

			google.maps.MapTypeId.ROADMAP,

			google.maps.MapTypeId.SATELLITE

		  ]*/

		},

		styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"saturation":"-100"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]}]

	});

	

	var marker = new google.maps.Marker({

		position: contact,

		map: map,

		clickable: false,

		icon: oJsonContact.marker,

		title: oJsonContact.title

	});

	

	// Append card when map renders

	google.maps.event.addListener(map, 'idle', function(e) {

		// Prevents card from being added more than once (i.e. when page is resized and google maps re-renders)

		if ( $( ".place-card" ).length === 0 ) {

			$(".gm-style").append('<div style="position: absolute; left: 0px; top: 0px;"> <div style="margin: 10px; padding: 1px; -webkit-box-shadow: rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px; box-shadow: rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px; border-radius: 2px; background-color: white;"> <div> <div class="place-card place-card-large"> <div class="place-desc-large"> <div class="place-name"> ' + oJsonContact.title + ' </div><div class="address"> 1 rue Paul Cézanne, 75008 Paris, France </div></div><div class="navigate"> <div class="navigate"> <a class="navigate-link" href="https://maps.google.com/maps?ll=48.874031,2.308607&amp;z=16&amp;t=m&amp;gl=PT&amp;mapclient=embed&amp;daddr='+oJsonContact.title+' Paris, France" target="_blank"> <div class="icon navigate-icon"></div><div class="navigate-text">'+oJsonContact.txt_direction+'</div></a> </div></div><div class="google-maps-link" style="padding-top:10px;"> <a href="https://maps.google.com/maps?ll=48.87403,2.308607&z=16&t=m&hl=fr-FR&gl=PT&mapclient=embed&cid=1849712330132220009" target="_blank">'+oJsonContact.txt_enlarge+'</a> </div></div></div></div></div>');

		}

	});

	

}



$(document).ready(function(){



	// if (typeof infoContactGmap != "undefined")

		initMap();

});