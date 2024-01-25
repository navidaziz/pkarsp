<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Google Maps with Multiple Markers</title>
  <style>
    #map {
      height: 500px;
    }
  </style>
</head>

<body>

  <div id="map"></div>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTbYZF_kDxKNopcvej6oh-eVs1z9Xq2J0&&callback=initMap" async defer></script>
  <script>
    function initMap() {
      const map = new google.maps.Map(document.getElementById('map'), {
        center: {
          lat: 35.522657,
          lng: 72.7752106
        },
        zoom: 8
      });

      // Provided points
      const points = [<?php
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
      ];

      // Add markers for provided points
      points.forEach(point => {
        addMarker(map, point.lat, point.lng);
      });
    }

    function addMarker(map, lat, lng) {
      const marker = new google.maps.Marker({
        position: {
          lat,
          lng
        },
        map: map
      });
    }
  </script>
</body>

</html>