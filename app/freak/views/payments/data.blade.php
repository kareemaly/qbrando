@extends('freak::elements.filterable')

@section('table')
<thead>
<tr>
    <th>Id</th>
    <th>User name</th>
    <th>User mobile</th>
    <th>Products</th>
    <th>Price after offer</th>
    <th>Status</th>
    <th>Tools</th>
</tr>
</thead>
<tbody>
@foreach($payments as $payment)

@if(($order = $payment->order) && ($userInfo = $payment->order->userInfo))
<tr>
    <td>{{ $payment->id }}</td>
    <td>{{ $userInfo->name }}</td>
    <td>{{ $userInfo->contact_number }}</td>
    <td>
        @foreach($order->products as $product)
        <b>{{ $product->pivot->qty }}</b>&nbsp &nbsp * &nbsp &nbsp<a href="{{ freakUrl('element/product/show/' . $product->id) }}">{{ $product->title }}</a> <br/>
        @endforeach
    </td>

    <td>{{ $order->getOfferPrice() }} QAR</td>

    @if($payment->hasReceived())
    <td><span class="label label-success">RECEIVED</span></td>
    @elseif($payment->isAwaiting())
    <td><span class="label label-warning">AWAITING</span></td>
    @else
    <td><span class="label label-important">CANCELED</span></td>
    @endif

    <td class="action-col" width="10%">
    <span class="btn-group">
        <a href="{{ freakUrl($element->getUri('show/'.$payment->id)) }}" class="btn btn-small"><i class="icon-search"></i></a>
        <a href="{{ freakUrl($element->getUri('delete/'.$payment->id)) }}" class="btn btn-small"><i class="icon-trash"></i></a>
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
    <th>Status</th>
    <th>Tools</th>
</tr>
</tfoot>
@stop
