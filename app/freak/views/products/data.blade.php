@extends('freak::master.layout1')

@section('content')
<form action="{{ freakUrl('element/product/available-many') }}" method="POST">
    <div class="row-fluid">
        <div class="span12 widget">
            <div class="widget-header">
                <span class="title">Product</span>
            </div>
            <div class="widget-content table-container">
                <table id="demo-dtable-02" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Model</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Tools</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->title }}</td>
                        <td>
                            @if($category = $product->category)
                            <a href="{{ freakUrl('element/category/show/' . $category->id) }}">
                                {{ $category->title }}
                            </a>
                            @endif
                        </td>
                        <td>{{ $product->actualPrice->format() }}</td>
                        <td>

                            <input type="hidden" name="Product[available_ids][]" value="{{ $product->id }}"/>
                            <input type="checkbox" name="Product[available][]" value="{{ $product->id }}" data-provide="ibutton" data-label-on="Yes" data-label-off="No"
                            {{ $product->isAvailable() ? 'checked="checked"' : '' }}
                            >

                        </td>

                        @include('freak::elements.tools', array('id' => $product->id))
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Model</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Tools</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <input type="submit" class="btn btn-success" value="Update product availability state"/>
</form>
@stop
