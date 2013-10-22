<div class="box">
    <div class="title"><span class="glyphicon glyphicon-align-justify"></span>Colors</div>

    <div class="box-body">
        <select name="" id="" class="form-control">
            <option value="">Select color</option>
            @foreach($colors as $color)
            <option value="{{ $color->id }}">{{ $color }}</option>
            @endforeach
        </select>
    </div>
</div>