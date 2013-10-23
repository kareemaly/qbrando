<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <span class="title">Admin access and permissions for {{ $admin->isMe() ? 'you' : $admin->getName() }}</span>
            </div>
            <div class="widget-content form-container">

                @foreach($errors as $error)
                <div class="alert alert-danger fade in">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    {{ $error }}
                </div>
                @endforeach
                
                <form class="form-horizontal" method="POST">
                    <div class="control-group">
                        <label class="control-label" style="color:#900">Access level:</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" value="high" name="Permission[access]" class="uniform">
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
                                <input type="radio" value="medium" name="Permission[access]" class="uniform">
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
                                <input type="radio" value="low" name="Permission[access]" class="uniform">
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
                            @foreach($models as $model)
                            <label class="checkbox">
                                <input type="checkbox" name="Permission[Models][]" value="{{ $model->id }}" data-provide="ibutton" data-label-on="Yes" data-label-off="No">
                                &nbsp &nbsp Manage {{ $model->getName() }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes and Accept admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>