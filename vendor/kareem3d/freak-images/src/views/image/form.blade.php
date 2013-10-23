<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">Main Image</span>
        </div>
        <div class="widget-content form-container">
            <form class="vertical-form" method="POST" action="{{ freakUrl('packages/store/Image') }}">
                <fieldset>
                    @include('freak-images::image.detail')

                    <div class="control-group">
                        <label class="control-label" for="input03">Choose</label>
                        <div class="controls">
                            <input type="file" id="input03" name="image-file">
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
</div>