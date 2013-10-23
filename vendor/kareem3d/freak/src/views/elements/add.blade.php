@extends('freak::master.layout1')

@section('content')
<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">{{ $leafTitle }}</span>
        </div>
        <div class="widget-content form-container">

            @yield('form')


        </div>
    </div>
</div>

@foreach($element->getPackages() as $package)
    {{ $package->formView() }}
@endforeach

<div class="row-fluid">
    <div class="span12 ">
        <div class="widget-content" style="text-align: center;">
            <button type="button" class="forms-submit btn-large btn btn-danger">Submit Data</button>
        </div>
    </div>
</div>


<div id="dialog-modal" title="Submitting data, Please wait ......">
</div>

<style type="text/css">
    p.step{border-bottom:1px solid #EEE; padding:5px;}
</style>
@stop

@section('scripts')
<script type="text/javascript">

    $(document).ready(function()
    {
        var html = new HtmlSubmitter($("#dialog-modal"));

        var submitter = new Submitter($('.form-container').find('form'), html, "{{ freakUrl($element->getUri('edit')) }}");

        $(".forms-submit").click(function( e )
        {
            e.preventDefault();

            submitter.run();

        });
    });

</script>
@stop