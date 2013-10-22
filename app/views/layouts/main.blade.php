<!doctype html>
<html ng-app="qbrando">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <title>Branded sunglasses for you | QBrando</title>

    <link href="{{ URL::asset('app/css/app.css') }}" rel="stylesheet">

</head>
<body>

<div class="container">

    @include('partials.header')

    <div class="clearfix"></div>

    <div class="content">

        @yield('content')

    </div>

    <div class="clearfix"></div>

</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script src="//code.angularjs.org/1.2.0rc1/angular.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.0rc1/angular-route.min.js"></script>
<script src="//code.angularjs.org/1.2.0rc1/angular-resource.min.js"></script>

<script src="{{ URL::asset('app/lib/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="{{ URL::asset('app/js/app.js') }}"></script>
<script src="{{ URL::asset('app/js/services.js') }}"></script>
<script src="{{ URL::asset('app/js/controllers.js') }}"></script>
<script src="{{ URL::asset('app/js/filters.js') }}"></script>
<script src="{{ URL::asset('app/js/directives.js') }}"></script>
</body>
</html>