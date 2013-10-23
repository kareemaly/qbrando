<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->

<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

{{ Asset::styles() }}

<title>MoonCake :: Responsive Admin Template - Error Page</title>

</head>

<body>

    <div id="error-wrap">

        <div id="error-digits">
            <span class="animated">BEING</span>
            <span class="animated delay300">UPDATED</span>
        </div>

        <h1>Hey! The website is currently being updated :)</h1>
        <p>Please be patient. In any moment now you will have an updated control panel.</p>

    </div>

    {{ Asset::scripts() }}

    <script>
        function support() {
            var vendorPrefixes = "O Ms Webkit Moz".split( ' ' ),    
                i = vendorPrefixes.length, support = true, 
                divStyle = document.createElement('div').style;

            while( i-- ) {
                for(var a = 0, support = true; a < arguments.length; a++) {
                    support = (vendorPrefixes[ i ] + arguments[ a ] in divStyle);
                }

                if( support ) return true;
            }

            return false;
        }

        $(document).ready(function() {
            support( 'Animation' ) && $('#error-digits > span').each( function(i, span) {
                $(span).addClass('bounceInDown');
            });
        });

    </script>

</body>

</html>
