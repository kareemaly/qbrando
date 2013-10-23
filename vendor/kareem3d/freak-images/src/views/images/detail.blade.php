
@if($images = $model->getImages( $imagesType ))
    @if(! $images->isEmpty())
    <div class="gallery-imgs" style="margin:20px;">
        @foreach($images as $image)

        <img src="{{ $image->getNearest(100, 100, true)->url }}" style="width:100px;" />
        <a href="{{ freakUrl('resource/image/delete/' . $image->id) }}" class="delete-icon">Delete</a>

        @endforeach
    </div>
    @endif
@endif
<style type="text/css">
    .delete-icon{
        position:relative; right:65px; padding:5px; background:#333; color:#FFF;
        visibility: hidden;
        border-radius:5px; background:#900000;
        font-size:10px;
    }
    .delete-icon:hover{
        color:#FFF;
        cursor: pointer;
    }
    .gallery-imgs:hover .delete-icon{
        visibility: visible;;
    }
</style>