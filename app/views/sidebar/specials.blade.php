@if($special)
<div class="box specials">
    <div class="title"><span class="glyphicon glyphicon-align-justify"></span>Special</div>

    @include('partials.product', array('product' => $special))
</div>
@endif