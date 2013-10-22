<div class="slider">
    <div id="carousel-example-generic" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @foreach($offers as $offer)
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            @endforeach
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            @foreach($offers as $offer)
            <div class="item active">
                <img src="{{ $offer->getImage('main')->getLargest()->url }}" alt="">
            </div>
            @endforeach
        </div>
    </div>
</div>