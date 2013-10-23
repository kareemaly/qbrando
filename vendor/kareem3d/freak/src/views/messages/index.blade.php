@extends('freak::master.layout1')

@section('content')
<div class="mail">

    <div id="compose-mail" class="modal mail-modal fade hide" data-backdrop="false">
        <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal">&times;</button>
            Compose Mail
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <form action="{{ freakUrl('mail/create') }}" class="form-vertical span12" method="POST">
                    <div class="control-group">
                        <label class="control-label">To</label>
                        <div class="controls">
                            <select id="input17" name="Message[to_id]" class="select2-select-00 span12">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Subject</label>
                        <div class="controls">
                            <input type="text" class="span12" name="Message[subject]">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <textarea class="span12" name="Message[body]" style="height:200px"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="navbar">
        <div class="navbar-inner">
            <button type="button" class="btn btn-primary btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="btn-toolbar pull-left">
                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#compose-mail">Compose</a>
            </div>
            <div class="nav-collapse pull-right">
                <ul class="nav">
                    <li class="active"><a data-toggle="tab" data-target="#inbox" href="#"><i class="icol-inbox"></i> Inbox</a></li>
                    <li><a data-toggle="tab" data-target="#sent" href="#"><i class="icol-page-white-get"></i> Sent</a></li>
                    <li><a data-toggle="tab" data-target="#trash" href="#"><i class="icol-bin-closed"></i> Trash</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mail-pages tab-content">
        <div id="inbox" class="tab-pane active">
            <table class="table table-striped table-checkable">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inbox as $message)
                    <tr>
                        <td>
                            @if($from = $message->getFromUser())
                            {{ $from->name }}
                            @endif
                        </td>
                        <td><a href="{{ freakUrl('mail/show/'.$message->id) }}">{{ $message->subject }}</a></td>
                        <td>
                            <span class="btn-group">
                                <a href="{{ freakUrl('mail/trash/'.$message->id) }}" class="btn"><i class="icol-bin-closed"></i></a>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="sent" class="tab-pane">
            <table class="table table-striped table-checkable">
                <thead>
                    <tr>
                        <th>To</th>
                        <th>Subject</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sent as $message)
                    <tr>
                        <td>
                        @if($to = $message->getToUser())
                        {{ $to->name }}
                        @endif
                        </td>
                        <td><a href="{{ freakUrl('mail/show/'.$message->id) }}">{{ $message->subject }}</a></td>
                        <td>
                            <span class="btn-group">
                                <a href="{{ freakUrl('mail/trash/'.$message->id) }}" class="btn"><i class="icol-bin-closed"></i></a>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="trash" class="tab-pane">
            <table class="table table-striped table-checkable">
                <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Subject</th>
                    <th>Tools</th>
                </tr>
                </thead>
                <tbody>
                @foreach($trash as $message)
                <tr>
                    <td>
                        @if($from = $message->getFromUser())
                        {{ $from->name }}
                        @endif
                    </td>
                    <td>
                        @if($to = $message->getToUser())
                        {{ $to->name }}
                        @endif
                    </td>
                    <td><a href="{{ freakUrl('mail/show/'.$message->id) }}">{{ $message->subject }}</a></td>
                    <td>
                        <span class="btn-group">
                            <a href="{{ freakUrl('mail/delete/'.$message->id) }}" class="btn"><i class="icol-delete"></i></a>
                        </span>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@stop

