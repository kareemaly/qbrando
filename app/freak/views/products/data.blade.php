@extends('freak::elements.filterable')

@section('table')
<thead>
<tr>
    <th>Id</th>
    <th>Model</th>
    <th>Brand</th>
    <th>Price</th>
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
    <td>{{ $product->getActualPrice() }}</td>

    @include('freak::elements.tools', array('id' => $product->id))
</tr>
@endforeach
</tbody>
<tfoot>
<tr>
    <th>Id</th>
    <th>English Title</th>
    <th>Arabic Title</th>
    <th>Category</th>
    <th>Tools</th>
</tr>
</tfoot>
@stop
