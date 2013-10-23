@extends('freak::master.layout1')

@section('content')
<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">{{ $element->getName() }}</span>
            <div class="toolbar">
                <div class="btn-group">
                    <a href="{{ freakUrl($element->getUri('edit/'.$id)) }}" class="btn"><i class="icos-pencil"></i>Edit</a>
                    <a href="{{ freakUrl($element->getUri('delete/'.$id)) }}" class="btn"><i class="icos-cross"></i> Delete</a>
                </div>
            </div>
        </div>
        <div class="widget-content table-container">

            @yield('tables')

            @foreach($element->getPackages() as $package)

            {{ $package->detailView() }}

            @endforeach
        </div>
    </div>
</div>
@stop