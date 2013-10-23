@extends('master')

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Control panel
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">Admin state</a>
            </li>
        </ul>
        
        <h1 id="main-heading">
            Admin state <span>One more step to accept {{ $admin->getName() }}</span>
        </h1>
    </div>
    
    <div id="main-content">

        @include('userstate.permissions')

    </div>
</section>
@stop