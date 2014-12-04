<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Paris Guide de survie</title>    
    <script src='https://maps.googleapis.com/maps/api/js'></script>
	
    <style>
      #map-canvas {
        width: 100%;
        min-height: 500px;
		height: 100%;
      }
    </style>

    <!-- Bootstrap -->
    <link href='css/bootstrap.css' rel='stylesheet'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
      <script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
    <![endif]-->
	<link href='css/psg.css' rel='stylesheet' type='text/css'> 
	
	
	    <script>
      function initialize() {
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
          center: new google.maps.LatLng(48.8566140, 2.3522219),
          zoom: 12,
          mapTypeId: google.maps.MapTypeId.AIzaSyAlHPysfawORVcufyHe90ZPnTdKzp3Ofzc
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
      }
      google.maps.event.addDomListener(window, 'load', initialize); 
	  AIzaSyC0ZOQf_p_LJp0kiD4R5NEL7e86btDARhg 
    </script>
  </head>
  <body>
<div class='row'>
		<div class='col-xs-6 col-lg-4 menu_psg'>
		<p class='txt1'><span class='titre'>Paris<br>Guide de<br>survie</p> Paris Guide de survie est une carte interactive qui répertorie tous les accidents de circulation qui se sont produits en 2012 et en 2013 à Paris intra-muros.</p>
		<div class='item_menu'>Mode transport: </div>
			<ul class='pictos'>
				<li  id='pieton'><img width='30' height='auto' alt='' src='images/pieton.png'></li>
				<li id='velo'><img width='30' height='auto' alt='velo' src='images/velo.png'></li>
				<li id='scooter'><img width='30' height='auto' alt='scooter' src='images/scooter.png'></li>
				<li id='moto'><img width='30' height='auto' alt='moto' src='images/moto.png'></li>
				<li id='voiture'><img width='30' height='auto' alt='voiture' src='images/voiture.png'></li>
				<li id='camion'><img width='30' height='auto' alt='' src='images/camion.png'></li>
			</ul>
		<div class='deplacement'>
		
		</div>
		</div>
	Nombre de resultats: <span id="resultNumbers"></span>
        <div class='col-xs-12 col-sm-6 col-lg-8' id='carte_psg'>
		 <div id='map-canvas'></div>        
		</div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='js/bootstrap.min.js'></script>
    <script>

jQuery( document ).ready(function( $ ) {

	$('#resultNumbers').html("0");
    var Choices = {
        pieton: false,
        velo: false,
        scooter: false,
        moto: false,
        voiture: false,
        camion: false
    };


    var vehicules = [];

    function SelectionVehicule() {

        vehicules = [];
        if(Choices.pieton) {
            vehicules.push('pieton');
        }
        if(Choices.velo) {
            vehicules.push('velo');
        }
        if(Choices.scooter) {
            vehicules.push('scooter');
        }
        if(Choices.moto) {
            vehicules.push('moto');
        }
        if(Choices.voiture) {
            vehicules.push('vl');
        }
        if(Choices.camion) {
            vehicules.push('camion');
            vehicules.push('bus');
        }

        allVehicules = [];

        $.each(vehicules, function(key, value) {

          currentvehiculesObj = {
                      "or" : [
                            {
                                "term" : { "vehicule1" : value }
                            },
                            {
                                "term" : { "vehicule2" : value}
                            },
                            {
                                "term" : { "vehicule3" : value }
                            }
                    ]
                };

                allVehicules.push(currentvehiculesObj);


    });
        var query = {
    "query": {
    "filtered" : {
        "query" : {
            "match_all" : { }
        },
        "filter" : {
            "and": allVehicules
        }
    }
    }
};
                var json = JSON.stringify(query);

                var request = $.ajax({
                  url: "/es/paris_survival_guide/_search?size=14000",
                  type: "POST",
                  data: json,
                  dataType: "json"
                });
                request.done(function( msg ) {
			$('#resultNumbers').html(msg.hits.hits.length);
			alert(ResultsLenghts);
			$.each(msg.hits.hits, function(key, value) {
				console.log(value._source);
			});
                });

      }

    $( '#pieton' ).click(function() {
      if(Choices.pieton) {
        $( '#pieton' ).removeClass('btn-success');
        Choices.pieton = false;
      } else {
        Choices.pieton = true;
        $( '#pieton' ).addClass('btn-success');
      }
      SelectionVehicule();
    });
    $( '#velo' ).click(function() {
      
      if(Choices.velo) {
        $( '#velo' ).removeClass('btn-success');
        Choices.velo = false;
      } else {
        Choices.velo = true;
        $( '#velo' ).addClass('btn-success');
      }
            SelectionVehicule();
    });
    $( '#scooter' ).click(function() {
      
      if(Choices.scooter) {
        $( '#scooter' ).removeClass('btn-success');
        Choices.scooter = false;
      } else {
        Choices.scooter = true;
        $( '#scooter' ).addClass('btn-success');
      }
            SelectionVehicule();
    });
    $( '#moto' ).click(function() {
      
      if(Choices.moto) {
        $( '#moto' ).removeClass('btn-success');
        Choices.moto = false;
      } else {
        Choices.moto = true;
        $( '#moto' ).addClass('btn-success');
      }
            SelectionVehicule();
    });
    $( '#voiture' ).click(function() {
      
      if(Choices.voiture) {
        $( '#voiture' ).removeClass('btn-success');
        Choices.voiture = false;
      } else {
        Choices.voiture = true;
        $( '#voiture' ).addClass('btn-success');
      }
            SelectionVehicule();
    });
        $( '#camion' ).click(function() {
      
      if(Choices.camion) {
        $( '#camion' ).removeClass('btn-success');
        Choices.camion = false;
      } else {
        Choices.camion = true;
        $( '#camion' ).addClass('btn-success');
      }
            SelectionVehicule();
    });




});
</script>
  </body>
</htmle>
