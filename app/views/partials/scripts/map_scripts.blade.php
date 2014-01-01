<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIOc9JCY2NKcBhMEesyaC8Vm5ZbPtWoPs&sensor=false">
</script>
<script type="text/javascript">
    function mapMunicipality(municipality)
    {
        var mapper = {
            'Al Doha': 'Doha Qatar',
            'Al Rayyan': 'Rayyan Qatar',
            'Al Khor': 'Al Khor Qatar',
            'Al Wakrah': 'Wakrah Qatar',
            'Al Shamal': 'Ash Shamal Qatar',
            'Umm Salal': 'Umm Salal Qatar',
            'Al Daayen': 'Al Daayen Qatar'
        }

        return mapper[municipality];
    }

    var map;
    var marker;
    var infowindow = new google.maps.InfoWindow();

    function initialize() {
        map = new google.maps.Map(document.getElementById("map-canvas"));

        marker = new google.maps.Marker({
            map:map,
            draggable:true
        });

        var updateMapFromMunicipality = function()
        {
            setMapAddress(mapMunicipality($('#municipality-select option:selected').html()));
        }

        updateMapFromMunicipality();

        $("#municipality-select").change(function()
        {
            updateMapFromMunicipality();
        });

        marker.addListener('position_changed', markerPositionChange);
    }

    /**
     * Update hidden latitude and longitude inputs.
     * Update hidden description of the map current location
     */
    function markerPositionChange()
    {
        $("#delivery-location-latitude").val(marker.getPosition().lat());
        $("#delivery-location-longitude").val(marker.getPosition().lng());

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status)
        {
            if (status == google.maps.GeocoderStatus.OK)
            {
                if (results[0])
                {
                    $("#delivery-location-google-address").val(results[0].formatted_address);

                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                }
            }
        });
    }

    function setMapAddress(address) {
        var geocoder = new google.maps.Geocoder();
        if (geocoder) {
            geocoder.geocode({ 'address': address }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    console.log(address, results);
                    map.fitBounds(results[0].geometry.viewport);
                    marker.setPosition(results[0].geometry.location);
                }
            });
        }
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>