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
            	<a href="#">{{ $app->name }} settings</a>
            </li>
        </ul>
        
        <h1 id="main-heading">
        	{{ $app->name }} Settings
        </h1>
    </div>
    
    <div id="main-content">
        @foreach($errors as $error)
        <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            {{ $error }}
        </div>
        @endforeach
        @if($success)
            <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success</strong><br>
                {{ $success }}
            </div>
        @endif
                                
        <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <span class="icon-exclamation-sign"></span>
            <strong>Be careful!</strong><br>
            The below information is very sensitive.<Br />
            Don't change unless you are positive of the changes you make.
        </div>
            
        <div class="row-fluid">
        	<div class="span12 widget">
                <div class="widget-header">
                    <span class="title"><i class="icon-resize-horizontal"></i>{{ $app->name }} settings form</span>
                </div>
                <div class="widget-content form-container">
                    <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <legend>Host FTP information</legend>
                            <div class="control-group">
                                <label class="control-label" for="input01">Host website*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Host][name]" value="{{ $host->getName() }}" class="span12" id="input01">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input01">Host username*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Host][username]" value="{{ $host->getUsername() }}" class="span12" id="input01">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input04">Host password*</label>
                                <div class="controls">
                                    <input type="password" name="Settings[Host][password]" value="{{ $host->getPassword() }}" class="span12" id="input01">
                                </div>
                            </div>
                            <legend>Database information</legend>
                            <div class="control-group">
                                <label class="control-label" for="input04">Database name*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Database][name]" value="{{ $database->getName() }}" class="span12" id="input01">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input04">Database username*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Database][username]" value="{{ $database->getUsername() }}" class="span12" id="input01">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input04">Database password*</label>
                                <div class="controls">
                                    <input type="password" name="Settings[Database][password]" value="{{ $database->getPassword() }}" class="span12" id="input01">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input04">Database Host name*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Database][hostName]" value="{{ $database->getHostName() }}" class="span12" id="input01">
                                </div>
                            </div>
                            <legend>Website information</legend>
                            <div class="control-group">
                                <label class="control-label" for="input04">Albums directory*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Host][albumsDirectory]" value="{{ $host->albumsDirectory }}" class="span12" id="input01">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input04">Server direcotry*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Host][serverDirectory]" value="{{ $host->serverDirectory }}" class="span12" id="input01">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input04">App server path*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Host][appPath]" value="{{ $host->getAppPath() }}" class="span12" id="input01">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input04">Base server path*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Host][basePath]" value="{{ $host->getBasePath() }}" class="span12" id="input01">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input04">App registers path*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Host][registerPath]" value="{{ $host->getRegisterPath() }}" class="span12" id="input01">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input04">Base URL*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Host][baseURL]" value="{{ $host->getBaseURL() }}" class="span12" id="input01">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input04">Directory separator*</label>
                                <div class="controls">
                                    <input type="text" name="Settings[Host][directorySeparator]" value="{{ $host->directorySeparator }}" class="span12" id="input01">
                                </div>
                            </div>
                            @if(Auth::developer() && $developer = Auth::user())
                            <div class="control-group">
                                <label class="control-label" for="input04">Choose application*</label>
                                <div class="controls">

                                    <select name="Settings[application]">
                                        @foreach($allApps as $app)
                                            @if($app->id == $developer->app->id)
                                            <option value="{{ $app->id }}" selected="selected">{{ $app->name }}</option>
                                            @else
                                            <option value="{{ $app->id }}">{{ $app->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                        </fieldset>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="reset" class="btn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
        <div class="row-fluid">
            <div class="span12 widget">
            </div>
        </div>
    </div>

</section>
@stop