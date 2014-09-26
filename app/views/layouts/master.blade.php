<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Bootstrap -->
    {{HTML::style('assets/bootstraptheme/css/bootstrap.min.css')}}

    <!-- Customized -->
    {{HTML::style('assets/customizedcss/site.css')}}

  @yield('head')
  </head>
  <body>

  	<div class='container'>
		@yield('content')  
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {{HTML::script('assets/js/jquery-1.11.1.min.js')}}
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {{HTML::script('assets/bootstraptheme/js/bootstrap.min.js')}}
  </body>
</html>