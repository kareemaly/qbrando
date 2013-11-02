@extends('freak::elements.filterable')

@section('table')
<thead>
<tr>
    <th>Id</th>
    <th>Title</th>
    <th>URL</th>
    <th>Tools</th>
</tr>
</thead>
<tbody>
@foreach($seo as $oneSeo)
<tr>
    <td>{{ $oneSeo->id }}</td>
    <td>{{ $oneSeo->title }}</td>
    <th>
        <a href="{{ $oneSeo->url }}">
            {{ $oneSeo->url }}
        </a>
    </th>

    @include('freak::elements.tools', array('id' => $oneSeo->id))
</tr>
@endforeach
</tbody>
<tfoot>
<tr>
    <th>Id</th>
    <th>Title</th>
    <th>URL</th>
    <th>Tools</th>
</tr>
</tfoot>
@stop
