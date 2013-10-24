<div class="header">
    <a href="{{ URL::route('home') }}"><div class="logo"></div></a>

    <div class="search">
        <form action="">
            <input type="text" class="search-input" />
            <input type="submit" class="search-submit" value=""/>
        </form>
    </div>

    <div class="cart">
        <a href="{{ URL::route('shopping-cart') }}"><div class="cart-img"></div></a>
        <div class="cart-info">
            <a href="{{ URL::route('shopping-cart') }}">
                <span>Shopping Cart: </span>
            </a><strong>{{ Cart::totalItems() }} items</strong>
        </div>
    </div>
</div>