
function initMap() {
    console.log("init map");
    var map = new google.maps.Map(
        document.getElementById('map'), {zoom: 13, center: {lat: 53.890763, lng: 27.565134}});

    var marker;

    google.maps.event.addListener(map, 'click', function(event) {

        placeMarker(event.latLng);

    });

    function placeMarker(location) {

        if (marker == null)
        {
            marker = new google.maps.Marker({
                position: location,
                map: map
            });
            document.getElementById('event-location').setAttribute('value', location);
        }
        else
        {
            marker.setPosition(location);
            document.getElementById('event-location').setAttribute('value', location);
        }
    }


    var infoWindow = new google.maps.InfoWindow;

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }


    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }
}