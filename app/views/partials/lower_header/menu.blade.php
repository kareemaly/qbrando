<div class="menu">
    <ul>
        @foreach($categories->take(9) as $category)
        <li>
            <a href="{{ URL::category($category) }}">{{ $category->title }}</a>
        </li>
        @endforeach
    </ul>
</div>