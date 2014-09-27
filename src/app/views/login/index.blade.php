<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    {{ HTML::style('assets/css/bootstrap.min.css'); }}
    {{ HTML::style('assets/font-awesome/css/font-awesome.css'); }}

    {{ HTML::style('assets/css/animate.css'); }}
    {{ HTML::style('assets/css/style.css'); }}

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">IN+</h1>

            </div>
            <h3>Welcome to IN+</h3>
            <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p>Login in. To see it in action.</p>
            {{Form::open( array (
                            'action'=>'UserController@do_login', 
                            "id"   => "login_form", 
                            "class"=> "m-t", 
                            "role" => "form" )
                        ) 
            }}
                <div class="form-group">
                    {{ Form::email('email', $value = Input::old('email'), $attributes = array(
                        "class"=>"form-control", 
                        "placeholder"=>Lang::get('confide::confide.username_e_mail') ))
                    }}
                    
                </div>
                <div class="form-group">
                    {{ Form::password('password', $attributes = array(
                        "class"=>"form-control",
                        "placeholder"=>Lang::get('confide::confide.password') )) 
                    }}
                </div>
                <td style="text-align:center;"><input type="hidden" name="_token" value="<?php echo Session::getToken(); ?>">
                <input type="hidden" name="remember" value="0"> 
                <button type="submit" class="btn btn-primary block full-width m-b">{{ Lang::get('confide::confide.login.submit') }}</button>

                <a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.html">{{ Lang::get('confide::confide.signup.desc') }}</a>

            {{ Form::close() }}
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>