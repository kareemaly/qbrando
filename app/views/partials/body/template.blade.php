<div class="body">

    @foreach($part->getChildren() as $child)

    {{ $child->render() }}

    <div class="clearfix"></div>

    @endforeach

</div>