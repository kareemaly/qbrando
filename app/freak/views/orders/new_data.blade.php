@extends('freak::elements.filterable')

@section('table')
<thead>
<tr>
    <th>Id</th>
    <th>User name</th>
    <th>User mobile</th>
    <th>Products</th>
    <th>Price after offer</th>
    <th>Tools</th>
</tr>
</thead>
<tbody>
@foreach($orders as $order)

@if($userInfo = $order->userInfo)
<tr>
    <td>{{ $order->id }}</td>
    <td>{{ $order->userInfo->name }}</td>
    <td>{{ $order->userInfo->contact_number }}</td>
    <td>
        @foreach($order->products as $product)
        <b>{{ $product->pivot->qty }}</b>&nbsp &nbsp * &nbsp &nbsp<a href="{{ freakUrl('element/product/show/' . $product->id) }}">{{ $product->title }}</a> <br/>
        @endforeach
    </td>

    <td>{{ $order->getOfferPrice() }} QAR</td>

    <td class="action-col" width="10%">
    <span class="btn-group">
        <a href="{{ freakUrl($element->getUri('show/'.$order->id)) }}" class="btn btn-small"><i class="icon-search"></i></a>
        <a href="{{ freakUrl($element->getUri('delete/'.$order->id)) }}" class="btn btn-small"><i class="icon-trash"></i></a>
    </span>
    </td>
</tr>
@endif

@endforeach
</tbody>
<tfoot>
<tr>
    <th>Id</th>
    <th>User name</th>
    <th>User mobile</th>
    <th>Products</th>
    <th>Price after offer</th>
    <th>Tools</th>
</tr>
</tfoot>
@stop
