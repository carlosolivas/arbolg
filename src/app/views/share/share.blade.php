
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel-heading">
                            <div class="panel-options">

                            </div>
                        </div>

                        <div class="panel-body">
                        {{ Form::open(array('action'=>array('ShareController@SaveRequestShare'))) }}
                            ShareType: {{ Form::text('sharetype_id', $shareTypeId) }}<br />
                            Module: {{ Form::text('className', $className) }} <br />
                            Element: {{ Form::text('element_id', $elementId) }} <br />
                            Person: {{ Form::text('person_id', $personId) }} <br />
                            Message: {{ Form::text('message', $message) }} <br />
                            URL: {{ Form::text('url', $message) }} <br />
                            @foreach($customControls as $customControl)
                                {{ $customControl->getHtml() }}
                            @endforeach
                            <br/>
                            <p>Share with Friends: <br/>
                            @if (!empty($myFriends))
                                @foreach($myFriends as $friend)
                                    @if ($friend != null && $friend->FriendType == 'Person')
                                        {{ Form::radio('shareWithFriends', $friend->Id, '1', false)}} {{ $friend->Name }}
                                    @endif
                            @endforeach
                            @endif
                            
                            </p>

                            <p>Share with Families:<br/>
                            @if (!empty($myFriends))
                                @foreach($myFriends as $friend)
                                    @if ($friend != null && $friend->FriendType == 'Family')
                                        {{ Form::radio('shareWithFamilies',$friend->Id, '1', false)}} {{ $friend->Name }}
                                    @endif
                                @endforeach
                            @endif
                            </p>
                            {{ Form::submit(Lang::get('share.share')) }}
                        {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
