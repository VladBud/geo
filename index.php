<!DOCTYPE html>
<html>
<head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>

</head>
<body>
<div id="map"></div>
<script>
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 8
        });
        var infoWindow = new google.maps.InfoWindow({map: map});

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };


                function dbPlace(list) {
                    for(var i=0;i<list.length;i++){
                        var infowindow = new google.maps.InfoWindow({
                            content: contentString
                        });

                        var pos = {
                            lat: list[i]['lat'],
                            lng: list[i]['lng']
                        };
                        var marker = new google.maps.Marker({
                            position: pos,
                            map: map
                        });
                    }
                }

                var image = 'images/geo.png';
                var marker = new google.maps.Marker({
                    position: pos,
                    map: map,
                    icon: image,
                    title: 'Hello World!'
                });

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
                infoWindow.setPosition(pos);
                infoWindow.setContent('Location found.');

                map.setCenter(pos);


            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    }






</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA485O7no2BJlHLP31XBUQ4kCxY8DMYuiE&callback=initMap">
</script>

<?php
    $servername = "localhost";
    $username = "mysql";
    $password = "mysql";

$link = mysqli_connect($servername, $username, $password, "avtoservices");
$result = mysqli_query($link, "SELECT * FROM sto");


$list = [];
$i = 0;
while($row = mysqli_fetch_array($result)){
    $list[$i]['sto_name'] = $row['sto_name'];
    $list[$i]['adress'] = $row['adress'];
    $list[$i]['position_lat'] = $row['position_lat'];
    $list[$i]['position_lng'] = $row['position_lng'];
    $i++;
}
$list = json_encode($list);
echo "<script>dbPlace($list)</script>";
?>



</body>
</html>