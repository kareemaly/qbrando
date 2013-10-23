@extends('freak::master.layout1')

@section('content')
<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">Order information</span>
            <div class="toolbar">
                <div class="btn-group">
                    <a href="{{ freakUrl($element->getUri('delete/'.$id)) }}" class="btn"><i class="icos-cross"></i> Delete</a>
                </div>
            </div>
        </div>
        <div class="widget-content table-container">

            @if(($product = $order->products->first()) && ($user = $order->userInfo))
            <table class="table table-striped table-detail-view">
                <thead>
                <tr>
                    <th colspan="2"><li class="icol-doc-text-image"></li> Order information</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>Product</th>
                    <td>
                        <a href="{{ freakUrl('element/product/show/' . $product->id) }}">{{ $product->en('title') }}</a>
                    </td>
                </tr>
                <tr>
                    <th>User name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>User email</th>
                    <td>
                        {{ $user->contact_email }}
                    </td>
                </tr>
                <tr>
                    <th>User mobile</th>
                    <td>{{ $user->mobile }}</td>
                </tr>
                <tr>
                    <th>Message</th>
                    <td>{{ $order->message }}</td>
                </tr>
                <tr>
                    <th>Created at</th>
                    <td>{{ date('d F, H:i', strtotime($order->created_at)) }}</td>
                </tr>
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@stop
