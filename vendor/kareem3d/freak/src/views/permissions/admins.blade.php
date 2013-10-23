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
            	<a href="#">Permissions</a>
                <span class="divider">&raquo;</span>
            </li>
            <li>
            	<a href="#">Admins List</a>
            </li>
        </ul>
        
        <h1 id="main-heading">
        	Admins List <span>Choose admin to change his/her permissions</span>
        </h1>
    </div>
    
    <div id="main-content">
        
        @include('contacts.groups')

    </div>
</section>
@stop