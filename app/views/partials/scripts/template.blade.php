@foreach($part->getChildren() as $child)

{{ $child->render() }}

@endforeach
