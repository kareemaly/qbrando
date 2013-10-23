@extends('freak::master.layout1')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <span class="title">Admin access and permissions for {{ $user->name }}</span>
            </div>
            <div class="widget-content form-container">

                <form class="form-horizontal" method="POST">
                    <div class="control-group">
                        <label class="control-label" style="color:#900">Access level:</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" value="{{ $user::HIGH_ACCESS }}" name="Permission[access]" {{ $user->isAccess( $user::HIGH_ACCESS ) ? 'checked':''; }} class="uniform">
                                <span class="label label-important">High access</span>
                                <p class="text-error">
                                    <br />
                                    A high access user can (and also have the privileges of medium and low accesses):
                                    <ul class="muted">
                                        <li>Accept and Refuse admins</li>
                                        <li>Delete[Block] admins</li>
                                        <li>Change admins permissions</li>
                                        <li>Access hosting information and change them</li>
                                    </ul>
                                </p><br />

                            </label>
                            <label class="radio">
                                <input type="radio" value="{{ $user::MEDIUM_ACCESS }}" name="Permission[access]" {{ $user->isAccess( $user::MEDIUM_ACCESS ) ? 'checked':''; }} class="uniform">
                                <span class="label label-warning">Medium access</span>
                                <p class="text-warning">
                                    <br />
                                    A medium access user can (and also have the privileges of low access):
                                    <ul class="muted">
                                        <li>Change control panel settings</li>
                                    </ul>
                                </p><br />

                            </label>
                            <label class="radio">
                                <input type="radio" value="{{ $user::LOW_ACCESS }}" name="Permission[access]" {{ $user->isAccess( $user::LOW_ACCESS ) ? 'checked':''; }} class="uniform">
                                <span class="label label-success">Low access</span>
                                <p class="text-success">
                                    <br />
                                    A low access user can't have access to any of the above.
                                </p>
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Permissions</label>
                        <div class="controls">
                            @foreach($elements as $element)
                            <label class="checkbox">
                                <input type="checkbox" name="Permission[Elements][]" value="{{ $element->getName() }}" data-provide="ibutton" data-label-on="Yes" data-label-off="No" {{ $user->hasControlOver( $element ) ? 'checked' : '' }}>
                                &nbsp &nbsp Manage {{ $element->getName() }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop