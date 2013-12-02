<div class="header">
    <a href="{{ URL::route('home') }}">
        <div class="logo">
            <img src="{{ URL::asset('app/img/logo.png') }}" class="img-responsive"/>
        </div>
    </a>

    <div class="search">
        <form action="{{ URL::route('search') }}">
            <input type="text" name="keyword" class="search-input" value="{{ Input::get('keyword') }}" />
            <input type="submit" class="search-submit" value=""/>
        </form>
    </div>

    <div class="cart" onclick="window.location.href='/shopping-cart.html'">
        <div class="cart-img"></div>
        <div class="cart-info">
            <a href="{{ URL::route('shopping-cart') }}">
                <span>Shopping Cart: </span>
            </a><strong ng-bind="cart.total()" ng-show="cart.isReady()"></strong> <strong>items</strong>
        </div>
    </div>
</div>