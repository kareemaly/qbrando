@extends('master')

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Controlpanel
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">Message Page</a>
            </li>
        </ul>
        
        <h1 id="main-heading">
            Error Message <span>You are redirected to this page because an error occurred</span>
        </h1>
    </div>
    
    <div id="main-content">

        @foreach($errors as $error)
        <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            {{ $error }}
        </div>
        @endforeach

    </div>

</section>
@stop