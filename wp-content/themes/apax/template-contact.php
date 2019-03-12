<?php /* Template name: Contact */ ?>

<?php get_header(); ?>



<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

<div class="container">

	<div class="row">

		<div class="col-md-12">

			<div class="post">

				<h1 class="post-title"><?php the_title(); ?></h1>

				<?php $sous_titre = get_field("sous-titre_page");

				if ($sous_titre && $sous_titre != "") {

					echo '<div class="baseline">'.$sous_titre.'</div>';

				} ?>

			</div>

		</div>

	</div>



	<?php $list_membre = get_field("list_membres");

	if ($list_membre) {

		echo '<div class="row">

			<div class="col-md-10 col-md-offset-1" id="list-contact-membre">

				<div class="row no-gutters">';



		foreach ($list_membre as $lemembre) {

			if ($lemembre["type_membre"] == "equipe") {

				$membre = $lemembre["membre_existant"];

				if ($membre->post_status == "publish") {

					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($membre->ID), 'contact-membre' );

					$nom = $membre->post_title;

					$poste_membre_equipe = get_field("poste_membre_equipe",$membre->ID);

					$mail = get_field("email_membre_equipe",$membre->ID);

				}

			} else {

				$thumb = array($lemembre["photo"]["sizes"]["contact-membre"]);

				$nom = $lemembre["nom"];

				$mail = $lemembre["email"];

				$poste_membre_equipe = $lemembre["fonction"];

			}



			if (isset($nom)) {

				echo '<div class="col-md-4 col-sm-6">';

				echo ($mail != "" ? '<a href="mailto:'.$mail.'"' : '<div').' class="bloc-ele" style="'.($thumb ? 'background-image: url('.$thumb[0].');' : '').'">

				'.($thumb ? '<img src="'.$thumb[0].'" alt="" />' : '').'

				<span class="title">'.$nom.'</span>';

				if ($nom != "" || $poste_membre_equipe != "") {

					echo '<span class="name"><span>';

					echo $nom != "" ? $nom.'<br/>' : '';

					echo $poste_membre_equipe != "" ? $poste_membre_equipe.'<br/>' : '';

					// echo $mail != "" ? $mail : '';

					echo '</span></span>';

				}

				echo $mail != '' ? '</a>' : '</div>';

				echo '</div>';

			}



		}



		echo '</div>

			</div>

		</div>';

	}



	?>



	<?php $titre_sous_carte = get_field("titre_sous_carte");

	$texte_sous_carte = get_field("texte_sous_carte");

	if ($titre_sous_carte != "" || $texte_sous_carte != "") {

		echo '<div class="row">

				<div class="col-md-10 col-md-offset-1" id="texte-sous-carte-contact">

					'.($titre_sous_carte ? '<h2 class="underline">'.$titre_sous_carte.'</h2>' : '').'

					'.$texte_sous_carte.'

				</div>

			</div>';

	} ?>


<script>

function initialize() {
    var latlng = new google.maps.LatLng(48.874027,2.308622);
    var latlng2 = new google.maps.LatLng(45.465320,9.194210);
    var myOptions = {
        zoom: 20,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
  
    var myOptions2 =  {
        zoom: 20,
        center: latlng2,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    
    var map2 = new google.maps.Map(document.getElementById("map_canvas_2"), myOptions2);
  
    var image = 'https://apax.website/wp-content/uploads/2019/01/logo_map100.png';
        var beachMarker = new google.maps.Marker({
          position: {lat: 48.874027, lng: 2.308622},
          map: map,
          icon: image
        });
  
      var image = 'https://apax.website/wp-content/uploads/2019/01/logo_map100.png';
        var beachMarker = new google.maps.Marker({
          position: {lat: 45.465320, lng: 9.194210},
          map: map2,
          icon: image
        });
  
    var myMarker = new google.maps.Marker(
    {
        position: latlng,
        map: map,
        title:"Pune"
   });

    var myMarker2 = new google.maps.Marker(
    {
        position: latlng2,
        map: map2,
        title:"Noida"
    });
  

        var styledMapType = new google.maps.StyledMapType(
            [
              {elementType: 'geometry', stylers: [{color: '#EEEEEE'}]},
              {elementType: 'labels.text.fill', stylers: [{color: '#523735'}]},
              {elementType: 'labels.text.stroke', stylers: [{color: '#f5f1e6'}]},
              {
                featureType: 'administrative',
                elementType: 'geometry.stroke',
                stylers: [{color: '#c9b2a6'}]
              },
              {
                featureType: 'administrative.land_parcel',
                elementType: 'geometry.stroke',
                stylers: [{color: '#dcd2be'}]
              },
              {
                featureType: 'administrative.land_parcel',
                elementType: 'labels.text.fill',
                stylers: [{color: '#ae9e90'}]
              },
              {
                featureType: 'landscape.natural',
                elementType: 'geometry',
                stylers: [{color: '#EEEEEE'}]
              },
              {
                featureType: 'poi',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
              },
              {
                featureType: 'poi',
                elementType: 'labels.text.fill',
                stylers: [{color: '#93817c'}]
              },
              {
                featureType: 'poi.park',
                elementType: 'geometry.fill',
                stylers: [{color: '#BCD5B8'}]
              },
              {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{color: '#447530'}]
              },
              {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{color: '#ffffff'}]
              },
              {
                featureType: 'road.arterial',
                elementType: 'geometry',
                stylers: [{color: '#fdfcf8'}]
              },
              {
                featureType: 'road.highway',
                elementType: 'geometry',
                stylers: [{color: '#f8c967'}]
              },
              {
                featureType: 'road.highway',
                elementType: 'geometry.stroke',
                stylers: [{color: '#e9bc62'}]
              },
              {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry',
                stylers: [{color: '#e98d58'}]
              },
              {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry.stroke',
                stylers: [{color: '#db8555'}]
              },
              {
                featureType: 'road.local',
                elementType: 'labels.text.fill',
                stylers: [{color: '#806b63'}]
              },
              {
                featureType: 'transit.line',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
              },
              {
                featureType: 'transit.line',
                elementType: 'labels.text.fill',
                stylers: [{color: '#8f7d77'}]
              },
              {
                featureType: 'transit.line',
                elementType: 'labels.text.stroke',
                stylers: [{color: '#ebe3cd'}]
              },
              {
                featureType: 'transit.station',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
              },
              {
                featureType: 'water',
                elementType: 'geometry.fill',
                stylers: [{color: '#b9d3c2'}]
              },
              {
                featureType: 'water',
                elementType: 'labels.text.fill',
                stylers: [{color: '#92998d'}]
              }
            ],
            {name: 'Styled Map'});

        map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');
  
        map2.mapTypes.set('styled_map', styledMapType);
        map2.setMapTypeId('styled_map');
  
  
  
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>


	<?php 

  $siege_social_1 = get_field("siege_social_contact_1");
  $siege_social_2 = get_field("siege_social_contact_2");

		echo '<div class="row" onload="initialize()">

			<div class="col-md-12" id="siege-contact">

				<h2 class="underline">'.__("Our Offices","apax").'</h2>

        <div class="row d-md-flex">';

          if ($siege_social_1 != "") {

            echo '<div class="col-md-6 col-xs-12" style="display: flex; flex-direction: column;">
                      <div>
                        '.$siege_social_1.'
                      </div>
                      <div style="padding: 30px 0; margin-top: auto">
                        <div id="map_canvas" style="position: relative; width:100%; min-height:400px; overflow: hidden;"></div>
                      </div>
                  </div>';
          }

          if ($siege_social_2 != "") {

            echo '<div class="col-md-6 col-xs-12" style="display: flex; flex-direction: column;">
                      <div>
                        '.$siege_social_2.'
                      </div>
                      <div style="padding: 30px 0; margin-top: auto">
                        <div id="map_canvas_2" style="position: relative; width:100%; min-height:400px; overflow: hidden;"></div>
                      </div>
                  </div>';
          }

        echo '</div>

			</div>

		</div>'; ?>

</div>


<?php endwhile; ?>

<?php endif; ?>



<?php get_footer(); ?>

