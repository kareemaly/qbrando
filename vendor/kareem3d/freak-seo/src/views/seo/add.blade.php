@extends('freak::elements.add')

@section('form')
<form class="form-horizontal form-editor" method="POST">
    <div class="control-group">
        <label class="control-label">URL</label>
        <div class="controls">
            <input type="text" name="SEO[url]" value="{{ $seo->url }}" class="span12" required/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">SEO title</label>
        <div class="controls">
            <input type="text" name="SEO[title]" value="{{ $seo->title }}" class="span12"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">SEO keywords</label>
        <div class="controls">
            <input type="text" name="SEO[keywords]" value="{{ $seo->keywords }}"  class="span12"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">SEO description</label>
        <div class="controls">
            <input type="text" name="SEO[description]" value="{{ $seo->description }}"  class="span12"/>
        </div>
    </div>
</form>
@stop