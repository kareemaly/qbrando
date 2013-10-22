<div class="box" ng-controller="ProductsController">
    <div class="title"><span class="glyphicon glyphicon-search"></span>{{ $productsTitle }}</div>

    @foreach($products as $product)

    @include('partials.product', $product)

    @endforeach


    <div class="clearfix"></div>

    <div class="separator"></div>

    {{ $products->links() }}

</div>