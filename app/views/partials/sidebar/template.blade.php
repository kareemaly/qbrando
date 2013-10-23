<div class="sidebar">

    @foreach($part->getChildren() as $child)

    {{ $child->render() }}

    <div class="clearfix"></div>

    @endforeach

</div>