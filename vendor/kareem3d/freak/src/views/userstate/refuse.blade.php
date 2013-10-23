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
            Admin state <span>One more step to refuse {{ $admin->getName() }}</span>
        </h1>
    </div>
    
    <div id="main-content">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <span class="title">Refusing {{ $admin->getName() }}</span>
                    </div>
                    <div class="widget-content form-container">
                        <form class="form-horizontal" method="POST">
                            <div class="control-group">
                                <label class="control-label" style="color:#900">Are you sure?</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" name="Refuse[answer]" value="yes" data-provide="ibutton" data-label-on="Yes" data-label-off="No">
                                        &nbsp &nbsp By refusing {{ $admin->getName() }}, he will be deleted.
                                    </label>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Submit answer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop