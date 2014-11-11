<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>soft4home | @yield('title')</title>
	
    <!-- Styles -->
    {{ HTML::style('assets/css/bootstrap.min.css'); }}
    <style>
		@font-face {
		  font-family: 'FontAwesome';
		  src: url('{{ asset("assets/font-awesome/fonts/fontawesome-webfont.eot?v=4.0.3"); }}');
		  src: url('{{ asset("assets/font-awesome/fonts/fontawesome-webfont.eot?#iefix&v=4.0.3"); }}') format('embedded-opentype'), url('{{ asset("assets/font-awesome/fonts/fontawesome-webfont.woff?v=4.0.3"); }}') format('woff'), url('{{ asset("assets/font-awesome/fonts/fontawesome-webfont.ttf?v=4.0.3"); }}') format('truetype'), url('{{ asset("assets/font-awesome/fonts/fontawesome-webfont.svg?v=4.0.3#fontawesomeregular"); }}') format('svg');
		  font-weight: normal;
		  font-style: normal;
		}
    </style>
    {{ HTML::style('assets/font-awesome/css/font-awesome.css'); }}
    
    <!-- iCheck -->
    {{ HTML::style('assets/css/plugins/iCheck/custom.css'); }}
    
    <!-- Input Mask-->
    {{ HTML::style('assets/css/plugins/jasny/jasny-bootstrap.min.css'); }}
        
    <!-- Steps -->
	{{ HTML::style('assets/css/plugins/steps/jquery.steps.css'); }}
    
    <!-- Full Calendar -->
    {{ HTML::style('assets/css/plugins/fullcalendar/fullcalendar.css'); }}
	{{ HTML::style('assets/css/plugins/fullcalendar/fullcalendar.print.css'); }}
    
    <!-- Date picker -->
    {{ HTML::style('assets/css/plugins/datapicker/datepicker3.css'); }}
    
    <!-- Styles -->
    {{ HTML::style('assets/css/animate.css'); }}
    
    <!-- DROPZONE -->
    {{ HTML::style('assets/css/plugins/dropzone/basic.css'); }}
    {{ HTML::style('assets/css/plugins/dropzone/dropzone.css'); }}
    
    <!-- preimage -->
    {{ HTML::style('assets/css/plugins/preimage/preimage.css'); }}
    
    <!-- Styles -->
    {{ HTML::style('assets/css/style.css'); }}

    <!-- jQuery UI -->
    {{ HTML::style('assets/css/jquery-ui.min.css'); }}
    
    <!-- Mainly scripts -->
    {{ HTML::script('assets/js/jquery-1.10.2.js'); }}
    {{ HTML::script('assets/js/jquery-ui.min.js'); }}
    {{ HTML::script('assets/js/bootstrap.min.js'); }}
    {{ HTML::script('assets/js/plugins/metisMenu/jquery.metisMenu.js'); }}
    
    <!-- Custom and plugin javascript -->
    {{ HTML::script('assets/js/inspinia.js'); }}
    {{ HTML::script('assets/js/plugins/pace/pace.min.js'); }}
    {{ HTML::script('assets/js/jquery-ui.custom.min.js'); }}
    
    <!-- DROPZONE -->
    {{ HTML::script('assets/js/plugins/dropzone/dropzone.js'); }}
    
    <!-- Input Mask-->
    {{ HTML::script('assets/js/plugins/jasny/jasny-bootstrap.min.js'); }}
    
    <!-- Date picker -->
    {{ HTML::script('assets/js/plugins/datapicker/bootstrap-datepicker.js'); }}
    
    <!-- iCheck -->
	{{ HTML::script('assets/js/plugins/iCheck/icheck.min.js'); }}

    <!-- Full Calendar -->
    {{ HTML::script('assets/js/plugins/fullcalendar/fullcalendar.min.js'); }}
        
    <!-- Steps -->
    {{ HTML::script('assets/js/plugins/staps/jquery.steps.min.js'); }}

    <!-- Jquery Validate -->
    {{ HTML::script('assets/js/plugins/validate/jquery.validate.min.js'); }}
    
    <!-- Jquery preimage -->
    {{ HTML::script('assets/js/plugins/preimage/preimage.js'); }}

    <!-- Cytoscape -->
    {{ HTML::script('assets/js/cytoscape.js'); }}

    
@yield('head')
</head>

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">

                        <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{ asset('assets/img/profile_small.jpg') }}">
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Confide::User()->username }}</strong>
                             </span> <span class="text-muted text-xs block"> <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="profile.html">Profile</a></li>
                                <li><a href="contacts.html">Contacts</a></li>
                                <li><a href="mailbox.html">Mailbox</a></li>
                                <li class="divider"></li>
                                <li><a href="user/logout">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>

                    </li>
                    <li>
                        <a href="/tree"><i class="fa fa-th-large"></i> <span class="nav-label">{{{Lang::get('titles.tree')}}}</span> </a>   
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Graphs</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="graph_flot.html">Flot Charts</a></li>
                            <li><a href="graph_morris.html">Morris.js Charts</a></li>
                            <li><a href="graph_rickshaw.html">Rickshaw Charts</a></li>
                            <li><a href="graph_peity.html">Peity Charts</a></li>
                            <li><a href="graph_sparkline.html">Sparkline Charts</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">Mailbox </span><span class="label label-warning pull-right">16/24</span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="mailbox.html">Inbox</a></li>
                            <li><a href="mail_detail.html">Email view</a></li>
                            <li><a href="mail_compose.html">Compose email</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Forms</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="form_basic.html">Basic form</a></li>
                            <li><a href="form_advanced.html">Advanced Plugins</a></li>
                            <li><a href="form_wizard.html">Wizard</a></li>
                            <li><a href="form_file_upload.html">File Upload</a></li>
                            <li><a href="form_editors.html">Text Editor</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">App Views</span>  <span class="pull-right label label-primary">SPECIAL</span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="file_manager.html">File manager</a></li>
                            <li><a href="calendar.html">Calendar</a></li>
                            <li><a href="timeline.html">Timeline</a></li>
                            <li><a href="pin_board.html">Pin board</a></li>
                            <li><a href="invoice.html">Invoice</a></li>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="register.html">Register</a></li>
                        </ul>
                    </li>
                    <li class="active">
                        <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Other Pages</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="search_results.html">Search results</a></li>
                            <li><a href="lockscreen.html">Lockscreen</a></li>
                            <li><a href="404.html">404 Page</a></li>
                            <li><a href="500.html">500 Page</a></li>
                            <li class="active"><a href="empty_page.html">Empty page</a></li>
                        </ul>
                    </li>

                    <li >
                        <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">UI Elements</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="typography.html">Typography</a></li>
                            <li><a href="icons.html">Icons</a></li>
                            <li><a href="draggable_panels.html">Draggable Panels</a></li>
                            <li><a href="buttons.html">Buttons</a></li>
                            <li><a href="tabs_panels.html">Tabs & Panels</a></li>
                            <li><a href="notifications.html">Notifications & Tooltips</a></li>
                            <li><a href="badges_labels.html">Badges, Labels, Progress</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">Layout</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="grid_options.html">Grid options</a></li>
                            <li><a href="boxed_layout.html">Boxed layout</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Tables</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="table_basic.html">Static Tables</a></li>
                            <li><a href="table_data_tables.html">Data Tables</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">Gallery</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="basic_gallery.html">Basic Gallery</a></li>
                            <li><a href="carousel.html">Bootstrap Carusela</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Menu Levels </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Third Level <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>

                                </ul>
                            </li>
                            <li><a href="#">Second Level Item</a></li>
                            <li>
                                <a href="#">Second Level Item</a></li>
                            <li>
                                <a href="#">Second Level Item</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="css_animation.html"><i class="fa fa-magic"></i> <span class="nav-label">CSS Animations </span><span class="label label-info pull-right">62</span></a>
                    </li>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" method="post" action="#">
                            <div class="input-group" style="margin-top:13px;"><input type="text" class="form-control" placeholder="{{ Lang::get('menu.search') }}" name="top-search" id="top-search"> <span class="input-group-btn"> <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button> </span></div>
                        </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="assets/img/a7.jpg">
                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="assets/img/a4.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="assets/img/profile.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>


                <li>
                    <a href="login.html">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
@yield('content')

            <!--Fin Contenido-->
        </div>
        <!-- Inicio Page Wrapper -->
    </div>
    <!-- Fin Wrapper -->
</body>

</html>
