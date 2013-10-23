<div class="offers">

    @foreach($offers as $offer)
    <div class="offer">

        @if($image = $offer->getImage('main'))
        <img class="img-responsive" src="{{ $image->getLargest()->url }}" alt=""/>
        @endif

    </div>
    @endforeach

</div>