<div class="row-fluid">
	<div class="span12 widget">
		<div class="widget-header">
			<span class="title"><i class="icos-address-book"></i> Contacts</span>
			<div class="toolbar">
				<a href="#" class="btn"><i class="icon-plus"></i></a>
			</div>
		</div>
		<div class="widget-content no-padding">
            <ul id="contacts">
            	@foreach( $groups as $character => $users )
                <li data-group="{{ $character }}">
                    <a class="title">{{ ucfirst($character) }}</a>
                    <ul>
                    	@foreach($users as $user)
                        <li>
                            <a href="#">

                                <span class="thumbnail">
                                    {{ $user->getImage('profile')->html() }}
                                </span> {{ $user->name }}

                                @if($user->isDeveloper())
                                <span class="label label-important">developer</span>
                                @elseif($user->isAccess($user::HIGH_ACCESS))
                                <span class="label label-important">High access</span>
                                @elseif($user->isAccess($user::MEDIUM_ACCESS))
                                <span class="label label-warning">Medium access</span>
                                @elseif($user->isAccess($user::LOW_ACCESS))
                                <span class="label label-success">Low access</span>
                                @endif
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
		</div>
	</div>

</div>