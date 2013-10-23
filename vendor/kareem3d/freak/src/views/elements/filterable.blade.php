@extends('freak::master.layout1')

@section('content')
<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">{{ $element->getName() }}</span>
        </div>
        <div class="widget-content table-container">
            <table id="demo-dtable-02" class="table table-striped">

                @yield('table')

            </table>
        </div>
    </div>
</div>

@yield('after')

@stop