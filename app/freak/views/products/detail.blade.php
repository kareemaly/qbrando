@extends('freak::elements.detail')

@section('tables')
<table class="table table-striped table-detail-view">
    <thead>
    <tr>
        <th colspan="2"><li class="icol-doc-text-image"></li> Product information</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>Title</th>
        <td>{{ $product->title }}</td>
    </tr>
    <tr>
        <th>Model</th>
        <td>{{ $product->model }}</td>
    </tr>
    <tr>
        <th>Brand</th>
        <td>
            @if($category = $product->category)
            <a href="{{ freakUrl('element/category/show/' . $category->id) }}">
                {{ $category->title }}
            </a>
            @endif
        </td>
    </tr>
    <tr>
        <th>Gender</th>
        <td>{{ $product->gender }}</td>
    </tr>
    <tr>
        <th>Color</th>
        <td>{{ $product->color }}</td>
    </tr>
    <tr>
        <th>Price</th>
        <td>{{ $product->price }}</td>
    </tr>
    <tr>
        <th>Offer Price</th>
        <td>{{ $product->offer_price }}</td>
    </tr>
    </tbody>
</table>

@stop
