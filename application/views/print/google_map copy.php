<!DOCTYPE html>
<html>

<head>
  <title>Calculate Route Distance</title>
  <style>
    #map {
      height: 400px;
      width: 100%;
    }
  </style>
</head>

<body>
  <div id="map"></div>
  <p>Total Route Distance: <span id="totalDistance">Calculating...</span> km</p>

  <script>
    function initMap() {
      // List of waypoints (latitude and longitude)
      var waypoints = [

        <?php
        $query = "SELECT coordinate_latitude,coordinate_longitude FROM schools 
          WHERE coordinate_longitude IS NOT NULL and coordinate_latitude IS NOT NULL
          ";
        $coordinates = $this->db->query($query)->result();
        //var_dump($coordinates);
        foreach ($coordinates as $coordinate) {
        ?> {
            lat: <?php echo $coordinate->coordinate_latitude; ?>,
            lng: <?php echo $coordinate->coordinate_longitude; ?>
          },
        <?php } ?>
        // Add more waypoints as needed
      ];

      // Initialize the Google Map
      var map = new google.maps.Map(document.getElementById('map'), {
        center: waypoints[0],
        zoom: 10
      });

      // Create a DirectionsService object
      var directionsService = new google.maps.DirectionsService();

      // Create a DirectionsRenderer object to display the route on the map
      var directionsDisplay = new google.maps.DirectionsRenderer();
      directionsDisplay.setMap(map);

      // Create a request object for the DirectionsService
      var request = {
        origin: waypoints[0],
        destination: waypoints[waypoints.length - 1],
        waypoints: waypoints.slice(1, waypoints.length - 1).map(function(waypoint) {
          return {
            location: waypoint
          };
        }),
        travelMode: 'DRIVING' // You can change this to other modes like 'WALKING', 'BICYCLING', or 'TRANSIT'
      };

      // Calculate the route and display it on the map
      directionsService.route(request, function(response, status) {
        if (status == 'OK') {
          directionsDisplay.setDirections(response);
          var totalDistance = 0;
          var legs = response.routes[0].legs;
          for (var i = 0; i < legs.length; i++) {
            totalDistance += legs[i].distance.value;
          }
          var totalDistanceInKm = totalDistance / 1000;
          document.getElementById('totalDistance').textContent = totalDistanceInKm.toFixed(2) + ' km';
        } else {
          alert('Directions request failed due to ' + status);
        }
      });
    }
  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTbYZF_kDxKNopcvej6oh-eVs1z9Xq2J0&callback=initMap"></script>
</body>

</html>