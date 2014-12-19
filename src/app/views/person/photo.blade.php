@extends('layouts.template')
<title>{{ Lang::get('titles.changePhoto') }}</title>
@section('content')

<div class="col-md-8 col-md-offset-2">

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">
        {{ Lang::get('titles.changePhoto') }} {{ $person->name . " " . $person->lastname . " " . 
        $person->mothersname}}
      </h3>
    </div>

    <div class="panel-body">
      {{ Form::open(array('url' => '/setPhoto', 'method' => 'post', 'files' => true)) }}
        
        <div class="fancybox">
          <img id="photoPreview" class="img-circle" src= {{ $person->Photo->fileURL }}/>
        </div>
        <br>
        <input id="photo" type="file" name="photo" onchange="PreviewPhoto();" />        

        <br>  

        {{Form::submit(Lang::get('titles.save'), array('class' => 'btn btn-primary'))}}
        <a href="/tree" class="btn btn-default">{{ Lang::get('titles.cancel') }}</a>

      {{ Form::close() }}
    </div>
  </div>
</div>

@stop
<script type="text/javascript">
function PreviewPhoto() {
    var fr = new FileReader();
    fr.readAsDataURL(document.getElementById("photo").files[0]);

    fr.onload = function (oFREvent) {
        document.getElementById("photoPreview").src = oFREvent.target.result;
    };
};
</script>