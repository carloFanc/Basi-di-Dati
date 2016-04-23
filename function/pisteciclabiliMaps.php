<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Google Maps</title>
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type="text/javascript">
  window.initMap = function() {
  	var bounds = new google.maps.LatLngBounds();
    var myLatlng = new google.maps.LatLng(41.8929, 12.4843);
    var myOptions = {
      zoom: 5,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
   
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
            $.ajax({
            url: 'function/get_piste_ciclabili.php',
            success:function(data){
            	   //oop through each location.
                 $.each(data, function(){
                 	var marker;
                 	var contenuto = 'Punto di Inizio'+'</p></b><br>'+'Chilometri: ' + this.Chilometri +'<br>'+'Pendenza Media: '+this.Pendenza_Media+'<br>';
                 	var infowindow = new google.maps.InfoWindow({
   					 content: contenuto
     					});
                    //Plot the location as a marker
                    
                    var pos = new google.maps.LatLng(this.Latitudine,this.Longitudine); 
                    bounds.extend(pos);
                    var titolo = 'Punto di Inizio';
                    marker = new google.maps.Marker({
                        position: pos,
                        map: map,
                        title: titolo
                    });
                     marker.addListener('click', function() {
                     infowindow.open(map, marker);
                    });
 
                 });
            map.fitBounds(bounds);
            }
        });
      
  }
</script>
</head>


<body>

  <div id="map_canvas" style="width:900px; height:500px"></div>
     <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8bBvuhva38_N5T8ZZb2JetjgBITIKrwI&callback=initMap&v=3"
  type="text/javascript"></script>
</body>
</html>
