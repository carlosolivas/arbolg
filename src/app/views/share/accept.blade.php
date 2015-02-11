@extends('layouts.template')

@section('title')
    {{ Lang::get('social.acceptshare') }}
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
                            <div class="col-lg-4">
                                <div class="panel-body">
                                    {{ Form::open(array('action'=>array('ShareController@AcceptShareRequest_Post'))) }}
                                        <div class="feed-element">
                                            <a href="profile.html" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{ $shareDetail->Share->Person->Photo->fileURL }}" />
                                            </a>
                                            <strong>{{ $shareDetail->Share->Person->name }}</strong> {{ Lang::get('share.sharingnotice') }} <br>
                                            <small class="text-muted">{{ $shareDetail->Share->created_at }}</small>
                                            <div class="well">{{ $shareDetail->Share->message }}</div>
                                        </div>
                                        {{ Form::hidden('shareDetailId', $shareDetail->id) }}

                                        <br/>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" id="accept"><i class="fa fa-check"></i>&nbsp;{{Lang::get('share.accept')}}</button>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop