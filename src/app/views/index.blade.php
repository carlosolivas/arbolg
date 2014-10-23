@extends('layouts.template')

@section('title')
    {{ Lang::get('modulo.variable') }}
@stop

@section('head')
  <script>
    $(document).ready(function(){
        
    });
  </script>
@stop

@section('breadcrumb')
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-12">
                    <h2>{{ Lang::get('modulo.variable') }}</h2>
                    <ul class="breadcrumb">
                        <li>
                            
                        </li>
                        <li class="active">
                            <strong>{{ Lang::get('modulo.variable') }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
@stop

@section('content')

@stop