<div class="footer">
@foreach($part->getChildren() as $child)

{{ $child->render() }}

@endforeach
</div>
