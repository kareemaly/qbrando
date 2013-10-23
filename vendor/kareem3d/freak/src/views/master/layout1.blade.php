<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Kareem Mohamed">
    @yield('top_scripts')

    {{ Asset::styles() }}

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <title>Advanced Control panel Version 1.1 -- UPDATED --</title>

</head>

<body data-show-sidebar-toggle-button="true" data-fixed-sidebar="false">

<div id="wrapper">

    @include('freak::master.header')

    <div id="content-wrap">
        <div id="content">
            <div id="content-outer">
                <div id="content-inner">

                    @include('freak::master.sidebar')

                    <div id="sidebar-separator"></div>

                    <section id="main" class="clearfix">
                        <div id="main-header" class="page-header">
                            <ul class="breadcrumb">
                                <li>
                                    <i class="icon-home"></i>{{ $controlPanel->name }}
                                    <span class="divider">&raquo;</span>
                                </li>

                                @if($activeTree = $menu->getActiveTree())
                                @for ($i = 0; $i < count($activeTree); $i++)
                                <li>
                                    <a href="{{ freakUrl($activeTree[$i]->getUri()) }}">{{ $activeTree[$i]->getTitle() }}</a>

                                    {{-- If not last item --}}
                                    @if(($i + 1) != count($activeTree))
                                    <span class="divider">&raquo;</span>
                                    @endif
                                </li>
                                @endfor
                                @endif
                            </ul>

                            {{-- Last item in the active tree --}}
                            @if(isset($i) && $childItem = $activeTree[$i - 1])
                            <h1 id="main-heading">
                                {{ $childItem->getTitle() }}
                            </h1>
                            @endif
                        </div>

                        <div id="main-content">

                            @if(! $errors->isEmpty())
                            <div class="alert alert-danger fade in">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                {{ implode($errors->all(':message'), '<br/>') }}
                            </div>
                            @endif

                            @if(! $success->isEmpty())
                            <div class="alert alert-success fade in">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                <strong>Success</strong><br>
                                {{ implode($success->all(':message'), '<br/>') }}
                            </div>
                            @endif

                            @if(isset($viewContent))

                                {{ $viewContent }}

                            @else

                                @yield('content')

                            @endif
                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>

    <footer id="footer">
        <div class="footer-left">{{ $controlPanel->name }} Control panel</div>
        <div class="footer-right"><p>Copyright 2012. All Rights Reserved.</p></div>
    </footer>

</div>

{{ Asset::scripts() }}

@yield('scripts')

<script type="text/javascript">
    $(document).ready(function()
    {
        setInterval('updateOnline()', 10000);
    });

    function updateOnline(){
        $.ajax({
            cache:false,
            url: '{{ freakUrl("update/online") }}',
            type: "GET"
        });
    }
</script>

</body>

</html>