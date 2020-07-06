
function initMap() {
    console.log("init map");



    if($('#event-location').val() && ($('#event-location').val() !== '0')) {

        var loc = $('#event-location').val().replace('(', '')
        loc = loc.replace(')', '')

        loc = loc.split(',')

        var lat_p = loc[0];
        var lng_p = loc[1];

        var LatLng = {lat: parseFloat(lat_p), lng: parseFloat(lng_p)};

        console.log(LatLng)


        var map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: LatLng});

        console.log(map)

        var marker = new google.maps.Marker({
            position: LatLng,
            map: map
        });
    }
    else {
        var map = new google.maps.Map(document.getElementById('map'), {zoom: 13, center: {lat: 53.890763, lng: 27.565134}});
        var marker;

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
    }


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





    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }
}