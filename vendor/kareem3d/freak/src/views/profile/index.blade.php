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
            	<a href="#">{{ $admin->getName() }}</a>
                <span class="divider">&raquo;</span>
            </li>
            <li>
            	<a href="#">Profile Page</a>
            </li>
        </ul>
    </div>
    
    <div id="main-content">

        @if(empty($errors))

        <div class="profile">
            <div class="clearfix">
                <div class="profile-head clearfix">
                    <div class="profile-info pull-left">
                        <h1 class="profile-username">{{ $admin->getName() }}</h1>
                        <ul class="profile-attributes">
                            <li><i class="icon-briefcase"></i> 
                                @foreach($admin->roles as $role)
                                    {{ $role->name }} , 
                                @endforeach
                            </li>
                        </ul>
                    </div>
                    <div class="btn-toolbar pull-right">
                        @if($admin->id != Auth::user()->id)
<!--                         <a href="{{ URL::to('messages/send/'.$admin->id) }}" class="btn btn-primary"><i class="icon-envelope"></i> Send Message</a> -->
                        @endif
                    </div>
                </div>
                <div class="profile-sidebar">
                    <div class="thumbnail">
                        <img src="{{ $admin->getProfileImage()->getSource() }}" alt="">
                    </div>
                    <ul class="nav nav-tabs nav-stacked">
                        <li class="active"><a href="#"><i class="icos-user"></i> Profile</a></li>
                        @if($admin->id == Auth::user()->id)
                        <li><a href="{{ URL::to('profile/edit') }}"><i class="icos-cog"></i> Settings</a></li>
                        @endif
                    </ul>
                </div>
                <div class="profile-content">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <h4 class="sub"><span>About Me</span></h4>
                            <p>{{ $admin->about }}</p>

                            @if(count($admin->roles) != 0)
                            <h4 class="sub"><span>Job Experience</span></h4>
                            <ul>
                                @foreach($admin->roles as $role)
                                <li>{{ $role->name }}</li>
                                @endforeach
                            </ul>
                            @endif

                            <h4 class="sub"><span>Contact Me</span></h4>
                            <address>
                                <abbr title="Phone">P:</abbr> {{ $admin->mobile_no }}<br>
                                <abbr title="Email">E:</abbr> <a href="mailto:{{ $admin->email }}">{{ $admin->email }}</a>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else

            <div class="alert fade in">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Profile not complete</strong><br>
                {{ $admin->getName() }} hasn't completed his profile settings yet.
            </div>

        @endif
    </div>
</section>
@stop