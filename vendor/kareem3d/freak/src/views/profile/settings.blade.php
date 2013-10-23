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
            	<a href="{{ URL::to('profile') }}">Profile</a>
                <span class="divider">&raquo;</span>
            </li>
            <li>
            	<a href="#">Edit profile</a>
            </li>
        </ul>
        
        <h1 id="main-heading">
        	Edit profile
        </h1>
    </div>
    
    <div id="main-content">
        
        <div class="row-fluid">
        	<div class="span12 widget">
                <div class="widget-header">
                    <span class="title"><i class="icon-resize-horizontal"></i> Edit profile form</span>
                </div>
                <div class="widget-content form-container">

                    @foreach($errors as $error)
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        {{ $error }}
                    </div>
                    @endforeach
                    
                    <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                        <div class="control-group">
                            <label class="control-label" for="input01">Full name*</label>
                            <div class="controls">
                                <input type="text" name="Profile[fullname]" value="{{ $admin->getName() }}" class="span12" id="input01">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="input01">Mobile number*</label>
                            <div class="controls">
                                <input type="text" name="Profile[mobile_no]" value="{{ $admin->mobile_no }}" class="span12" id="input01">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Roles</label>
                            <div class="controls">
                                @foreach($roles as $role)
                                <label class="checkbox">
                                    
                                    <input type="checkbox" name="Profile[roles][]" value="{{ $role->id }}" class="uniform"
                                    
                                    @if($admin->hasRole($role))
                                    checked
                                    @endif
                                    
                                    >
                                    
                                    {{ $role->name }}
                                </label>
                                @endforeach
                                <p class="help-block">Choose the roles you perform in this control panel.</p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="input04">Upload image</label>
                            <div class="controls">
                                <input class="input-file" id="input04" name="image" type="file">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="input05">About me*</label>
                            <div class="controls">
                                <textarea class="span12" name="Profile[about]" id="input05" rows="3">{{ $admin->about }}</textarea>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="reset" class="btn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop