<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New design</title>
    <link rel="stylesheet" href="{{ URL::asset('app/css/app.css') }}"/>
</head>
<body>

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

</body>
</html>
