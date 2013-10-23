<header id="header" class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <div class="brand-wrap pull-left">
                <div class="brand-img">
                    <a class="brand" href="#">
                    </a>
                </div>
            </div>

            <div id="header-right" class="clearfix">
                <div id="nav-toggle" data-toggle="collapse" data-target="#navigation" class="collapsed">
                    <i class="icon-caret-down"></i>
                </div>
<!--                <div id="header-search">-->
<!--                    <span id="search-toggle" data-toggle="dropdown">-->
<!--                        <i class="icon-search"></i>-->
<!--                    </span>-->
<!--                    <form class="navbar-search">-->
<!--                        <input type="text" class="search-query" placeholder="Search">-->
<!--                    </form>-->
<!--                </div>-->
                <div id="dropdown-lists">
                    <div class="item-wrap">
                        <a class="item" href="#" data-toggle="dropdown">
                            <span class="item-icon"><i class="icon-exclamation-sign"></i></span>
                            <span class="item-label">Notifications</span>
                            @if($notifications->count() > 0)
                            <span class="item-count">{{ $notifications->count() }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item-wrap">
                                <ul>
                                    @foreach( $notifications as $notification )
                                    <li>
                                        <a href="{{ freakUrl('notifications#notification'.$notification->id) }}">
                                            @if($user = $notification->getUser())
                                            <span class="thumbnail">
                                                {{ $user->getImage('profile')->html() }}
                                            </span>
                                            <span class="details">
                                                <strong>{{ $user->name }}</strong>
                                                {{ $notification->body }}
                                                <span class="time">{{ $notification->getTimeAgo() }}</span>
                                            </span>
                                            @else
                                            <span class="details">
                                                {{ $notification->body }}
                                                <span class="time">{{ $notification->getTimeAgo() }}</span>
                                            </span>
                                            @endif
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{ freakUrl('notifications') }}">View all notifications</a></li>
                        </ul>
                    </div>
                    <div class="item-wrap">
                        <a class="item" href="#" data-toggle="dropdown">
                            <span class="item-icon"><i class="icon-envelope"></i></span>
                            <span class="item-label">Messages</span>
                            @if($newMessages > 0)
                            <span class="item-count">{{ $newMessages }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item-wrap">
                                <ul>
                                    @foreach($messages as $message)
                                    @if($message)
                                    @if($fromUser = $message->getFromUser())
                                    <li>
                                        <a href="{{ freakUrl('mail/show/'.$message->id) }}">
                                            <span class="thumbnail">
                                                {{ $fromUser->getImage('profile')->html() }}
                                            </span>
                                            <span class="details">
                                                <strong>{{ $fromUser->name }}</strong><br>
                                                {{ $message->getSubject() }}
                                            </span>
                                        </a>
                                    </li>
                                    @endif
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{ freakUrl('mail/inbox') }}">View all messages</a></li>
                        </ul>
                    </div>
                </div>

                <div id="header-functions" class="pull-right">
                    <div id="user-info">
                        <span class="info">
                            Welcome
                            <span class="name">{{ $authUser->name }}</span>
                        </span>
                        <div class="avatar">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                {{ $authUser->getImage('profile')->html() }}
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ freakUrl('user/profile') }}"><i class="icol-user"></i> My Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ freakUrl('logout') }}"><i class="icol-key"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="logout-ribbon">
                        <a href="{{ freakUrl('logout') }}"><i class="icon-off"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>