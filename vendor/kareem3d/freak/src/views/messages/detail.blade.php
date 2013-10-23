@extends('freak::master.layout1')

@section('content')
<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">Showing message</span>
        </div>
        <div class="widget-content table-container">
            <table class="table table-striped table-detail-view">
                <tbody>
                <tr>
                    <th>Subject</th>
                    <td>{{ $message->subject }}</td>
                </tr>
                @if($from = $message->getFromUser())
                <tr>
                    <th>From</th>
                    <td>{{ $from->name }}</td>
                </tr>
                @endif
                @if($to = $message->getToUser())
                <tr>
                    <th>To</th>
                    <td>{{ $to->name }}</td>
                </tr>
                @endif
                <tr>
                    <th>Body</th>
                    <td>{{ $message->body }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop