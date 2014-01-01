@extends('freak::master.layout1')

@section('content')
@if($order = $payment->order)
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

            @include('panel::payments.payment_info')

            @include('panel::orders.info')
        </div>
    </div>
</div>
@endif
@stop
