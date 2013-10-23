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
            	<a href="{{ URL::to('profile') }}">Application creation</a>
                <span class="divider">&raquo;</span>
            </li>
            <li>
            	<a href="#">New application creation</a>
            </li>
        </ul>
        
        <h1 id="main-heading">
        	Application creation process
        </h1>
    </div>
    
    <div id="main-content">
        @foreach($errors as $error)
        <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            {{ $error }}
        </div>
        @endforeach
            
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-wand"></i>Application creation</span>
                </div>
                <div class="widget-content form-container">
                    <form id="wizard-demo-2" class="form-horizontal" data-forward-only="false" method="POST">
                        <fieldset class="wizard-step">
                            <legend class="wizard-label"><i class="icon-book"></i> Application info.</legend>
                            <div class="control-group">
                                <label class="control-label">Name <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Application[name]" class="required span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Password <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="password" name="Application[password]" class="required span12" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="wizard-step">
                            <legend class="wizard-label"><i class="icon-user"></i> Ftp info.</legend>
                            <div class="control-group">
                                <label class="control-label">Ftp Host <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Host[name]" class="required span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Ftp Username </label>
                                <div class="controls">
                                    <input type="text" name="Host[username]" class="span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Ftp Password </label>
                                <div class="controls">
                                    <input type="text" name="Host[password]" class="span12">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="wizard-step">
                            <legend class="wizard-label"><i class="icon-pencil"></i> Website info.</legend>
                            <div class="control-group">
                                <label class="control-label">Albums directory <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Host[albumsDirectory]" class="required span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Server directory <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Host[serverDirectory]" class="required span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Server base path <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Host[basePath]" class="span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Server app path <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Host[appPath]" class="span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Server register path <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Host[registerPath]" class="span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Base URL <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Host[baseURL]" class="required span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Directory Separator <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Host[directorySeparator]" class="required span12">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="wizard-step">
                            <legend class="wizard-label"><i class="icon-ok"></i> Database info.</legend>
                            <div class="control-group">
                                <label class="control-label">Host name <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Database[hostName]" class="required span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Username <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Database[username]" class="required span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Password </label>
                                <div class="controls">
                                    <input type="text" name="Database[password]" class="span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Name <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="Database[name]" class="required span12">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <label class="checkbox"><input type="checkbox" name="sure" class="required"> I am sure of the given data <span class="required">*</span></label>
                                    <label for="wizard[tos]" class="error" generated="true" style="display:none"></label>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop


@section('scripts')

<script type="text/javascript">

;(function( $, window, document, undefined ) {
    $(document).ready(function() {
        // When all page resources has finished loading
        if( $.fn.wizard ) {
            
            if( $.fn.validate ) {
                $wzd_form = $( '#wizard-demo-2' ).validate({ onsubmit: false });
                
                $( '#wizard-demo-2' ).wizard({
                    onStepLeave: function(wizard, step) {
                        return $wzd_form.form();
                    }, 
                    onBeforeSubmit: function() {
                        return $wzd_form.form();
                    }
                });
            }
        }
    });
}) (jQuery, window, document);

</script>

@stop