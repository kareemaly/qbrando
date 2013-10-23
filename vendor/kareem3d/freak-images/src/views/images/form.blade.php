<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">Images</span>
        </div>
        <div class="widget-content form-container">
            <form class="vertical-form" method="POST" action="{{ freakUrl('packages/store/Images') }}">
                <fieldset id="cloner53" class="sheepit-form">
                    <legend>
                        All images
                        <span id="cloner53_controls" class="pull-right">
                            <span class="btn btn-mini" id="cloner53_add"><i class="icon-plus"></i></span>
                        </span>
                    </legend>

                    <div class="clearfix"></div>

                    @include('freak-images::images.detail')

                    <div id="cloner53_template" class="control-group">
                        <label for="cloner53_#index#_input" class="control-label">Image <span id="cloner53_label"></span></label>
                        <div class="controls">
                            <input id="cloner53_#index#_input" name="images[#index#]" type="file"/>
                        </div>
                        <span class="close" id="cloner53_remove_current">&times;</span>
                    </div>
                    <div id="cloner53_noforms_template" class="control-group">
                        <p class="help-block">Add a new input by clicking the (+) button above</p>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script type="text/javascript">

    (function( $, window, document, undefined ) {

        $(document).ready(function() {
            if( $.fn.sheepIt ) {
                $('#cloner53').sheepIt({
                    separator: '',
                    iniFormsCount: 0,
                    minFormsCount: 0,
                    maxFormsCount: 5
                });
            }
        });
    }) (jQuery, window, document);

</script>
@stop