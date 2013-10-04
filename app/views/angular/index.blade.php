<!doctype html>
<html ng-app="qbrando">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

<!doctype html>
<html lang="en" ng-app="myApp">
<head>
    <meta charset="utf-8">
    <title>My AngularJS App</title>
    <link rel="stylesheet" href="css/app.css"/>
</head>
<body>
<ul class="menu">
    <li><a href="#/view1">view1</a></li>
    <li><a href="#/view2">view2</a></li>
</ul>

<div ng-view></div>

<div>Angular seed app: v<span app-version></span></div>


@if(App::environment() == 'production')
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>
<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js"></script>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
@else
<script src="{{ URL::asset('angular/app/lib/angular/angular.js') }}"></script>
<script src="{{ URL::asset('angular/app/lib/ui-bootstrap-tpls-0.6.0.js') }}"></script>
<script src="{{ URL::asset('angular/app/lib/angular/bootstrap-combined.min.css') }}"></script>
@endif

<script src="{{ URL::asset('angular/app/js/app.js') }}"></script>
<script src="{{ URL::asset('angular/app/js/services.js') }}"></script>
<script src="{{ URL::asset('angular/app/js/controllers.js') }}"></script>
<script src="{{ URL::asset('angular/app/js/filters.js') }}"></script>
<script src="{{ URL::asset('angular/app/js/directives.js') }}"></script>
</body>
</html>