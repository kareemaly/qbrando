@extends('freak::elements.detail')

@section('tables')
<table class="table table-striped table-detail-view">
    <tbody>
    <tr>
        <th>English Title</th>
        <td>{{ $category->en('title') }}</td>
    </tr>
    <tr>
        <th>Products list in {{ $category->title }}</th>
        <td>
            <ul>
                @foreach($category->products as $product)
                <li><a href="{{ freakUrl('element/product/show/' . $product->id) }}">{{ $product->title }}</a></li>
                @endforeach
            </ul>
        </td>
    </tr>
    </tbody>
</table>
@stop
