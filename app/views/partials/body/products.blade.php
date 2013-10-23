<div class="{{ isset($part->brightTitle) ? 'main-bright-title' : 'main-title' }}">
    <span class="glyphicon glyphicon-tasks"></span>
    {{ $part->productsTitle }}
</div>

<div class="products">

    @foreach($part->products as $product)
        @include('partials.product', $product)
    @endforeach

    <div class="clearfix"></div>
</div>

<div class="text-center">
    {{ $part->products->links() }}
</div>