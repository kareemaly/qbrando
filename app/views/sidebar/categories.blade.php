<div class="box">
    <div class="title"><span class="glyphicon glyphicon-align-justify"></span>Brands</div>

    <ul class="nav">
        @foreach($categories as $category)
        <li>
            <a href="{{ URL::to('/search.html?category=' . $category->name) }}">{{ $category->name }}</a>
        </li>
        @endforeach
    </ul>
</div>