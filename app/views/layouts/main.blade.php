<!DOCTYPE HTML>
<html lang="en" ng-app="qbrando">
<head>
    <meta charset="utf-8">
    <title>Qbrando | Online shop for luxury in Qatar</title>
    <link rel="stylesheet" href="{{ URL::asset('app/css/app.css') }}"/>

    <script src="{{ URL::asset('app/lib/respond.min.js') }}"></script>

</head>
<body ng-controller="MainController">

<div class="large-container">
    <div class="container">

        {{ $template->render('header') }}

        <div class="clearfix"></div>

        {{ $template->render('lower_header') }}

        <div class="clearfix"></div>

        <div class="content">


            @if($template->getLocation('sidebar') == 'left')
                {{ $template->render('sidebar') }}
            @endif

            {{ $template->render('body') }}

            @if($template->getLocation('sidebar') == 'right')
                {{ $template->render('sidebar') }}
            @endif

            <div class="clearfix"></div>

            {{ $template->render('footer') }}
        </div>


    </div>
</div>


@include('partials.modal')


@if(App::environment() == 'production')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

<script src="http://code.angularjs.org/1.2.0rc1/angular.min.js"></script>
<script src="http://code.angularjs.org/1.2.0rc1/angular-resource.min.js"></script>
<script src="http://code.angularjs.org/1.2.0rc1/angular-cookies.min.js"></script>

<script src="{{ URL::asset('app/lib/zoom/zoomsl-3.0.min.js') }}"></script>
@else
<script src="{{ URL::asset('app/lib/jquery.min.js') }}"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="{{ URL::asset('app/lib/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="{{ URL::asset('app/lib/angular/angular.js') }}"></script>
<script src="{{ URL::asset('app/lib/angular/angular-resource.min.js') }}"></script>
<script src="{{ URL::asset('app/lib/angular/angular-cookies.min.js') }}"></script>

<script src="{{ URL::asset('app/lib/zoom/zoomsl-3.0.min.js') }}"></script>
@endif

<script src="{{ URL::asset('app/js/app.js') }}"></script>
<script src="{{ URL::asset('app/js/services.js') }}"></script>
<script src="{{ URL::asset('app/js/controllers.js') }}"></script>
<script src="{{ URL::asset('app/js/filters.js') }}"></script>
<script src="{{ URL::asset('app/js/directives.js') }}"></script>

</body>
</html>
