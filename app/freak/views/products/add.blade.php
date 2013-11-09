@extends('freak::elements.empty_add')

@section('form')

<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">{{ $leafTitle }}</span>
        </div>
        <div class="widget-content form-container">
            <form class="form-horizontal form-editor" method="POST">

                <div class="control-group">
                    <label class="control-label">Model</label>
                    <div class="controls">
                        <input type="text" name="Product[model]" value="{{ $product->model }}" required/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="input05">Brand</label>
                    <div class="controls">
                        <select name="Product[category_id]" required>
                            @foreach($categories as $category)
                            @if($product->category_id == $category->id)
                            <option selected="selected" value="{{ $category->id }}">{{ $category->title }}</option>
                            @else
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Gender</label>
                    <div class="controls">
                        <select name="Product[gender]" required>
                            @foreach($product->getGenders() as $gender)
                            @if($gender == $product->gender)
                            <option value="{{ $gender }}" selected="selected">{{ $gender }}</option>
                            @else
                            <option value="{{ $gender }}">{{ $gender }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="input05">Color</label>
                    <div class="controls">
                        <select name="Product[color_id]" required>
                            @foreach($colors as $color)
                            @if($product->color_id == $color->id)
                            <option selected="selected" value="{{ $color->id }}">{{ $color->title }}</option>
                            @else
                            <option value="{{ $color->id }}">{{ $color->title }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="input05">Title <br />
                        <small>You can leave empty</small></label>
                    <div class="controls">
                        <input type="text" name="Product[title]" id="input05" class="span12" value="{{ $product->title }}" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="input05">Price</label>
                    <div class="controls">
                        <input type="number" name="Product[price]" id="input05" class="span2" value="{{ $product->price }}" min="0" required>
                    </div>
                    <label class="control-label" for="input05">Offer price</label>
                    <div class="controls">
                        <input type="number" name="Product[offer_price]" id="input05" class="span2" value="{{ $product->offer_price }}" min="0">
                    </div>
                </div>



            </form>



            @if($product->exists)
            <form class="form-horizontal form-editor" method="POST" action="{{ freakUrl('element/product/facebook/' . $product->id) }}">
                <div class="control-group">
                    <label class="control-label">
                        Facebook title <br />
                        <small>You can leave empty</small>
                    </label>
                    <div class="controls">
                        <input type="text" name="facebook_title" class="span12"/>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Post to facebook</button>
                </div>
            </form>
            @endif

        </div>
    </div>
</div>

@stop