@extends('freak::elements.detail')

@section('tables')
<table class="table table-striped table-detail-view">
    <tbody>
    <tr>
        <th>URL</th>
        <td>
            <a href="{{ $seo->url }}">
            {{ $seo->url }}
            </a>
        </td>
    </tr>
    <tr>
        <th>Title</th>
        <td>
            {{ $seo->title }}
        </td>
    </tr>
    <tr>
        <th>Keywords</th>
        <td>
            {{ $seo->keywords }}
        </td>
    </tr>
    <tr>
        <th>Description</th>
        <td>
            {{ $seo->description }}
        </td>
    </tr>
    </tbody>
</table>
@stop
