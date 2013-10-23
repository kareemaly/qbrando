@extends('freak::master.layout1')

@section('content')

<div class="row-fluid">
    <div class="span6 widget">
        <div class="widget-header">
            <span class="title">
                <i class="icon-ok"></i> Admins list
            </span>
        </div>
        <div class="widget-content task-list">
            <ul>
                @foreach($users as $user)
                <li class="done">
                    <label class="checkbox"><input type="checkbox" class="uniform" disabled></label>
                    <span class="text">
                        <span class="text-nowrap">
                            <a href="{{ freakUrl('user/profile/'. $user->id) }}">
                                <i class="icon-users"></i> {{ $user->name }}
                            </a>
                            @if($user->isOnline())
                                <span class="badge badge-success">Online</span>
                            @else
                                <span class="badge badge-grey">Offline</span>
                            @endif
                        </span>
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="row-fluid">
     <div class="widget span12">
        <div class="widget-header">
            <span class="title">
                <i class="icon-comments"></i> General Discussion
            </span>
        </div>
        <div class="widget-content chat-box">
            <ul class="thumbnails">
                @foreach( $discussions as $discussion )
                    @if($user = $discussion->getUser())
                        @if($authUser->same($user))
                        <li class="me">
                        @else
                        <li class="others">
                        @endif

                            <div class="thumbnail">
                                {{ $user->getImage('profile')->html() }}
                            </div>
                            <div class="message">
                                <span class="name">{{ $user->name }}</span>
                                {{ $discussion->body }}
                                <span class="time">{{ $discussion->getTimeAgo() }}</span>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="message-form">
                <form action="{{ freakUrl('discussion/') }}" method="POST">
                    <div class="row-fluid">
                        <div class="span10">
                            <input type="text" class="span12" name="Discussion[body]" placeholder="Type a message...">
                        </div>
                        <div class="span2">
                            <button type="submit" class="btn btn-block btn-primary">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop