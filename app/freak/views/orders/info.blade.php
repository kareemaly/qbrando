

@if($user = $order->userInfo)
<table class="table table-striped table-detail-view">
    <thead>
    <tr>
        <th colspan="2"><li class="icol-clipboard-text"></li> Order information</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>Products</th>
        <td>
            @foreach($order->products as $product)
            <strong>{{ $product->pivot->qty }}</strong>&nbsp&nbsp&nbsp * &nbsp&nbsp&nbsp
            <a href="{{ freakUrl('element/product/show/' . $product->id) }}">{{ $product->title }}</a><br/>
            @endforeach
        </td>
    </tr>
    <tr>
        <th><span class="icol-medal-bronze-1"></span> Price after offer</th>
        <td>
            <strong>{{ $order->getOfferPrice() }} Q.R</strong>
            <strong style="text-decoration: line-through">{{ $order->getTotal() }} Q.R</strong>
        </td>
    </tr>
    </tbody>
</table>
<table class="table table-striped table-detail-view">
    <thead>
    <tr>
        <th colspan="2"><li class="icol-doc-text-image"></li> User information</th>
    </tr>
    </thead>
    <tr>
        <th>User name</th>
        <td>{{ $user->name }}</td>
    </tr>
    <tr>
        <th>User number</th>
        <td>{{ $user->contact_number }}</td>
    </tr>
    @if($user->delivery_location)
    <tr>
        <th>User delivery location</th>
        <td>{{ $user->delivery_location }}</td>
    </tr>
    @endif
    @if($user->contact_email)
    <tr>
        <th>User email</th>
        <td>{{ $user->contact_email }}</td>
    </tr>
    @endif
    <tr>
        <th>Created at</th>
        <td>{{ date('d F, H:i', strtotime($order->created_at)) }}</td>
    </tr>
    </tbody>
</table>
@endif
@if($deliveryLocation = $order->deliveryLocation)
<table class="table table-striped table-detail-view">
    <thead>
    <tr>
        <th colspan="2"><li class="icol-world"></li> Delivery location</th>
    </tr>
    </thead>
    <tr>
        <th>Country</th>
        <td>{{ $deliveryLocation->municipality->country }}</td>
    </tr>
    <tr>
        <th>City</th>
        <td>{{ $deliveryLocation->municipality }}</td>
    </tr>
    <tr>
        <th>Address</th>
        <td>{{ $deliveryLocation->address1 }}</td>
    </tr>
    </tbody>
</table>

<!--<div id="map-canvas" style="height:400px; width:100%;"></div>-->
<!---->
<!--<script type="text/javascript"-->
<!--        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIOc9JCY2NKcBhMEesyaC8Vm5ZbPtWoPs&sensor=false">-->
<!--</script>-->
<!--<script type="text/javascript">-->
<!---->
<!--    var map;-->
<!--    var marker;-->
<!--    var infowindow = new google.maps.InfoWindow();-->
<!---->
<!--    function initialize() {-->
<!---->
<!--        var latlng = new google.maps.LatLng({{ $deliveryLocation->latitude }}, {{ $deliveryLocation->longitude }});-->
<!---->
<!--        map = new google.maps.Map(document.getElementById("map-canvas"), {-->
<!---->
<!--            center: latlng,-->
<!--            zoom: 15-->
<!--        });-->
<!---->
<!--        marker = new google.maps.Marker({-->
<!--            map:map,-->
<!--            position: latlng-->
<!--        });-->
<!---->
<!--        var geocoder = new google.maps.Geocoder();-->
<!--        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status)-->
<!--        {-->
<!--            if (status == google.maps.GeocoderStatus.OK)-->
<!--            {-->
<!--                if (results[0])-->
<!--                {-->
<!--                    infowindow.setContent(results[0].formatted_address);-->
<!--                    infowindow.open(map, marker);-->
<!--                }-->
<!--            }-->
<!--        });-->
<!--    }-->
<!---->
<!--    google.maps.event.addDomListener(window, 'load', initialize);-->
<!--</script>-->
@endif