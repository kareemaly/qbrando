@extends('freak::elements.empty_add')

@section('form')

<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">{{ $leafTitle }}</span>
        </div>
        <div class="widget-content form-container">
            <form class="form-horizontal form-editor" method="POST">
                <div class="control-group">
                    <label class="control-label">Title</label>
                    <div class="controls">
                        <input type="text" name="Category[title]" value="{{ $category->title }}" required/>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@stop