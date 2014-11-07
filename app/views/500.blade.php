<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | 404 Error</title>

    {{ HTML::style('assets/css/bootstrap.min.css'); }}
    {{ HTML::style('assets/font-awesome/css/font-awesome.css'); }}

    {{ HTML::style('assets/css/animate.css'); }}
     {{ HTML::style('assets/css/style.css'); }}

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1>500</h1>
        <h3 class="font-bold">Internal Server Error</h3>
        <div class="error-desc">
        {{{ $error }}}.<br/>
        You can go back to main page: <br/><a href="/tree" class="btn btn-primary m-t">Árbol</a>
        </div>
    </div>

    <!-- Mainly scripts -->
    {{ HTML::script('assets/js/jquery-1.10.2.js'); }}
    {{ HTML::script('assets/js/bootstrap.min.js'); }}

</body>

</html>
