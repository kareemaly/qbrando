<div class="lower-header">

    @foreach($part->getChildren() as $child)

    {{ $child->render() }}

    <div class="clearfix"></div>

    @endforeach

</div>