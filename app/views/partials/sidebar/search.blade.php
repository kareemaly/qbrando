<div class="main-title">Search</div>

<div class="box">
    <div class="form-group">

        <form action="{{ URL::route('search-products') }}" method="GET">

            <br />
            <input type="text" name="model" value="{{ Input::get('model') }}" class="form-control" placeholder="Model" /><br />

            <select name="color" id="" class="form-control">
                <option value="">All colors</option>
                @foreach($colors as $color)
                    @if(Input::get('color') == $color->title)
                    <option value="{{ $color->title }}" selected="selected">{{ $color->title }}</option>
                    @else
                    <option value="{{ $color->title }}">{{ $color->title }}</option>
                    @endif
                @endforeach
            </select>
            <br />

            <select name="brand" id="" class="form-control">
                <option value="">All brands</option>
                @foreach($categories as $category)
                    @if(Input::get('brand') == $category->title)
                    <option value="{{ $category->title }}" selected="selected">{{ $category->title }}</option>
                    @else
                    <option value="{{ $category->title }}">{{ $category->title }}</option>
                    @endif
                @endforeach
            </select>

            <br />
            <input type="submit" class="btn btn-default" value="Search"/>
        </form>
    </div>
</div>