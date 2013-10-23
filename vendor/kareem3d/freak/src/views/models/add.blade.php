@extends('freak::master.layout1')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <span class="title">{{ $currentTitle }}</span>
                <div class="toolbar">
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#tab-01" data-toggle="tab">{{ $element->name }}</a></li>
                        <?php $i = 2; ?>
                        @foreach($element->getPackages() as $package)

                        @if($package->hasAddView())
                        <li class="active"><a href="#tab-0{{ $i }}" data-toggle="tab">{{ $package->title }}</a></li>
                        <?php $i ++; ?>
                        @endif

                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-01">

                    @yield('tab')

                </div>
                <?php $i = 2; ?>
                @foreach($element->getPackages() as $package)

                @if($package->hasAddView())
                <div class="tab-pane" id="tab-0{{ $i }}">
                    $package->getAddView( $packagesModel )
                </div>
                <?php $i ++; ?>
                @endif

                @endforeach

            </div>
        </div>
    </div>
</div>

@yield('after')

@stop
