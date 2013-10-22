<div class="box select-brand">
    <div class="title"><span class="glyphicon glyphicon-align-justify"></span>Search</div>

    <div class="box-body">
        <select name="" id="" class="form-control">
            <option value="Product">Select brand</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
        </select>

        <div class="separator"></div>

        <select name="" id="" class="form-control">
            <option value="">Select color</option>
            @foreach($colors as $color)
            <option value="{{ $color->id }}">{{ $color->title }}</option>
            @endforeach
        </select>
    </div>
</div>