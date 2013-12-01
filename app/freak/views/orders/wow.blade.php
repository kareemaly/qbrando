<!doctype html>
<html>
<head>
    <title>Order management system</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app/lib/gridster/gridster.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app/lib/gridster/demo.css') }}">


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <!--Load Script and Stylesheet -->
    <script type="text/javascript" src="{{ URL::asset('app/lib/datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <link type="text/css" href="{{ URL::asset('app/lib/datetimepicker/jquery.simple-dtpicker.css') }}" rel="stylesheet" />
</head>

<body>

<div class="search-btn">Search</div>

<form method="GET">
    <div class="pickers-box">
        <div class="picker-box">
            <h3>From date</h3>
            <input type="text" name="from_date" value="Input::get('from_date') ?: date('Y/m/d H:i')">
            <script type="text/javascript">
                $(function(){
                    $('*[name=from_date]').appendDtpicker({"inline": true});
                });
            </script>
        </div>

        <div class="picker-box">
            <h3>To date</h3>
            <input type="text" name="to_date" value="{{ Input::get('to_date') ?: date('Y/m/d H:i') }}">
            <script type="text/javascript">
                $(function(){
                    $('*[name=to_date]').appendDtpicker({"inline": true});
                });
            </script>
        </div>

        <div class="clear"></div>

        <div class="picker-btns">
            <button type="submit">Show orders</button>

            <button type="button" onclick="window.location.href='{{ Request::url() }}'">All orders</button>
            <button type="button" class="close-pickers-box">Close</button>
        </div>
    </div>
</form>

<style type="text/css">
    .search-btn{background:#ffe862; padding:10px 20px; margin:5px; position: fixed; left:0px; top:50%; cursor: pointer; z-index: 1000}
    .pickers-box{ z-index: 10000; text-align: center; position: fixed; left:0px; top:30%; background:#666; border:1px solid #FFF; border-left:0px; padding:10px 50px;}
    .pickers-box h3{color:#FFF;}
    .picker-box{float:left ;display: inline-block; margin-left:50px;}
    .show-orders{color: #FFF; padding:5px; margin-bottom:20px; display: block;}
    .show-orders b{color:#ffe862; font-weight: normal;}
</style>

<script type="text/javascript">
    $(function(){
        setTimeout(function()
        {
            $(".pickers-box").hide();
        },100);

        $(".search-btn").click(function()
        {
            $(this).hide();
            $(".pickers-box").show();
        });

        $(".close-pickers-box").click(function()
        {
            $(".pickers-box").hide();
            $(".search-btn").show();
        })
    });
</script>


<div class="clear"></div>

@if(Input::get('from_date') && Input::get('to_date'))
<span class="show-orders">
Showing orders from : <b>{{ date('F j, Y, g:i a', strtotime(Input::get('from_date'))) }}</b>
    to : <b>{{ date('F j, Y, g:i a', strtotime(Input::get('to_date'))) }}</b>
</span>
@endif

<div class="clear"></div>

<ul class="static">
    <li style="background:#EC9706;">
        <span>Waiting</span>
    </li>
    <li style="background:#33A61C;">
        <span>Delivered</span>
    </li>
    <li style="background:#FE0000;">
        <span>Not delivered</span>
    </li>
</ul>

<div class="clear"></div>

<div class="gridster">
    <ul>
        <?php $rows = array(0, 0, 0); ?>

        @foreach($orders as $order)

        <?php $rows[(int) $order->status]++; ?>

        <li order-id="{{ $order->id }}" data-row="{{ $rows[(int) $order->status] }}" data-col="{{ $order->status + 1 }}" data-sizex="1" data-sizey="1">
            <header>
                Order id {{ $order->id }}
            </header>

            <div class="li-body" onclick="window.open('{{ freakUrl($element->getUri('show/'.$order->id)) }}','_blank');">
                <div class="row">
                    <span class="key">Products:</span>

                    <span class="value">
                    @foreach($order->products as $product)
                    {{ $product->title }} ||||
                    @endforeach
                    </span>
                </div>

                @if($userInfo = $order->userInfo)
                <div class="row">
                    <span class="key">User name:</span>
                    <span class="value">{{ $userInfo->name }}</span>
                </div>

                <div class="row">
                    <span class="key">User mobile:</span>
                    <span class="value">{{ $userInfo->contact_number }}</span>
                </div>
                @endif
            </div>

        </li>

        @endforeach
    </ul>
</div>
<script src="{{ URL::asset('app/lib/gridster/gridster.min.js') }}" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    var gridster;

    $(function(){

        gridster = $(".gridster ul").gridster({
            widget_base_dimensions: [400, 150],
            widget_margins: [5, 5],
            draggable: {
                handle: 'header'
            },
            serialize_params: function($w, wgd) {
                return { status: wgd.col - 1, id: $w.attr('order-id') }
            }
        }).data('gridster');


        setInterval(function()
        {
            var objects = gridster.serialize();

            $.ajax({
                url: '{{ Request::url() }}',
                data : JSON.stringify(objects),
                method: 'POST',
                contentType: 'application/json'
            });
        }, 2000);

    });
</script>

<style type="text/css">

    body{background: #222;}

    .clear{clear:both}

    .static{margin:0px; padding: 0px; list-style: none; width:100%;}
    .static li{float:left; width:400px; height:50px; margin: 5px;}
    .static span{color:#FFF; display: block; padding:15px 150px;}

    .gridster li header {
        background: #BBB;
        color:#000;
        display: block;
        font-size: 15px;
        line-height: 20px;
        padding: 10px;
        margin-bottom: 20px;
        cursor: move;
    }

    .row{text-align: left; padding:5px 10px;}
    .row .key{font-size:14px; color:#333;}
    .row .value{font-size:14px; color:#000;}

    .gridster ul {
        background:#222;
    }

    .li-body:hover{background:#EEE;}

</style>
</body>
</html>
