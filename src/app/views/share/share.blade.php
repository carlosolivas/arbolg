@extends('layouts.template')

@section('title')
    {{ Lang::get('social.timeline') }}
@stop

@section('head')

@stop

@section('breadcrumb')
@stop

@section('content')
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
                                {{ Form::hidden('hid_'.$customControl->getName(), $customControl->getHtml()) }}
                            @endforeach
                            <br/>
                            <p>Share with Friends:<br/>
                            @foreach($myFriends as $friend)
                                {{ Form::radio('shareWithFamilies',$friend->getGroup()->id, '1', false)}} {{ $friend->name }}
                            @endforeach
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
@stop