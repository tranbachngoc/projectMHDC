<!DOCTYPE html>
<html lang="en" ng-app="limoApp">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Limo backend Mở Rộng</title>

    <!-- Bower Components CSS -->
    <link href="{{asset('bower_components/angular-growl-v2/build/angular-growl.min.css')}}" rel="stylesheet">
    <link href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('bower_components/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('bower_components/simple-line-icons/css/simple-line-icons.css')}}" rel="stylesheet">
    <link href="{{asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('bower_components/angular-ui-select/dist/select.min.css')}}" rel="stylesheet">
    <!-- App CSS -->
    <link href="{{asset('css/backend.css')}}" rel="stylesheet">
    <link href="{{asset('css/components.css')}}" rel="stylesheet">
    <link href="{{asset('css/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/darkblue.css')}}" rel="stylesheet">
    <link href="{{asset('css/autocomplete.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/profile.css')}}" rel="stylesheet">
    <link href="{{asset('css/ticket.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">

    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
    <div class="page-wrapper">
      <!-- Navigation -->
      <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
          <!-- BEGIN LOGO -->
          <div class="page-logo">

            <a href="javascript:;"><h4 style="color:white" class="logo-default">LIMO APP </h4></a>
            <div class="menu-toggler sidebar-toggler">
              <span></span>
            </div>
          </div>
          <!-- END LOGO -->
          <!-- BEGIN RESPONSIVE MENU TOGGLER -->
          <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
          </a>
          <!-- END RESPONSIVE MENU TOGGLER -->
          <!-- BEGIN TOP NAVIGATION MENU -->
          <div class="top-menu">
            <ul class="nav navbar-nav pull-right">

              <li class="dropdown dropdown-user">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                  <img alt="" class="img-circle" src="../assets/layouts/layout/img/avatar3_small.jpg">
                  <span class="username username-hide-on-mobile">Admin </span>
                  <i class="fa fa-angle-down"></i>
                </a>

              </li>
              <!-- END USER LOGIN DROPDOWN -->
              <!-- BEGIN QUICK SIDEBAR TOGGLER -->
              <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
              <li class="dropdown dropdown-quick-sidebar-toggler">
                <a href="{{ url('backend/logout')}}" class="dropdown-toggle">
                  <i class="icon-logout"></i>
                </a>
              </li>
              <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
          </div>
          <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
      </div>
      <div class="clearfix"> </div>

      <!-- Page Content -->
      <div class="page-container">

        <div class="page-sidebar-wrapper">
          <!-- BEGIN SIDEBAR -->
          <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
          <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
          <div class="page-sidebar navbar-collapse collapse">
              <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" >
              <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
              <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
              <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                  <span></span>
                </div>
              </li>
              <!-- END SIDEBAR TOGGLER BUTTON -->
              <li class="nav-item start {{$controller == 'dashboard'?'active':'' }} ">
                <a href="{{url('backend/dashboard')}}"><i class="fa fa-dashboard"></i><span class="title">Dashboard</span></a>
              </li>
              <li class="nav-item start {{$controller =='achievement'?'active':''}}">
                <a href="{{url('backend/achievements/demo/view')}}"><i class="fa fa-heart"></i><span class="title">Thành Tích Demo</span></a>
              </li>
              <li class="nav-item start">
                <a href="{{url('backend/settings')}}"><i class="fa fa-cogs"></i><span class="title">Cài đặt</span></a>
              </li>
            </ul>
            <!-- END SIDEBAR MENU -->
            <!-- END SIDEBAR MENU -->
          </div>
          <!-- END SIDEBAR -->
        </div>
        <div class="page-content-wrapper">
          <div class="page-content">
            @if (isset($successMsg)))
            <div class="alert alert-success alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <p>{{$successMsg}}</p>
            </div>
            @elseif (\Session::has('successMsg'))
            <div class="alert alert-success alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <p>{!! \Session::get('successMsg') !!}</p>
            </div>
            @endif

            @if (isset($errorMsg))
            <div class="alert alert-danger alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <p>{{$errorMsg}}</p>
            </div>
            @elseif (\Session::has('errorMsg'))
            <div class="alert alert-danger alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <p>{!! \Session::get('errorMsg') !!}</p>
            </div>
            @endif
            <h3>@yield('title')</h3>
            @yield('main')
          </div>
        </div>

      </div>
      <!-- /.container -->
      <div class="page-footer">



        <!-- Footer -->

        <div class="page-footer-inner">
          Copyright &copy; LimoCAB 2016
        </div>

      </div>
    </div>
    <div growl></div>
    <script>
        window.TOKEN = "{{ $jwtToken }}";
        window.SOCKET_URL = "{{ env('SOCKET_URL') }}";
        window.BACKEND_URL = "{{ env('APP_URL') }}/backend";
        window.BACKEND_PUPLIC_URL ="{{ env('APP_URL') }}";
    </script>
    <!-- /.container -->
    {{-- <script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing&language=vi&key={{env('GOOGLE_MAP_KEY')}}"></script> --}}
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
    
    <!-- Bower Components JS -->
    <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('bower_components/angular/angular.min.js')}}"></script>
    <script src="{{asset('bower_components/angular-sanitize/angular-sanitize.min.js')}}"></script>
    <script src="{{asset('bower_components/angular-growl-v2/build/angular-growl.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js')}}"></script>
    <script src="{{asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('bower_components/angular-socket-io/socket.min.js')}}"></script>
    <script src="{{asset('bower_components/js-cookie/src/js.cookie.js')}}"></script>
    <script src="{{asset('bower_components/select2/select2.js')}}" type="text/javascript"></script>
    <script src="{{asset('bower_components/angular-ui-select/dist/select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('bower_components/highcharts/highcharts.js')}}" type="text/javascript"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('js/socket.io.min.js')}}"></script>
    
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{asset('js/app_script.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/layout.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/demo.min.js')}}" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->

    <script src="{{asset('backend-app/app.js')}}"></script>
    <script src="{{asset('backend-app/components/socket.js')}}"></script>
    <script src="{{asset('backend-app/controllers/achievement-demo-manager.controller.js')}}"></script>
    <script src="{{asset('backend-app/directives/layout.js')}}"></script>
    <script src="{{asset('backend-app/directives/gplace-autocomplete.js')}}"></script>
    <script src="{{asset('backend-app/directives/gplace-picker.js')}}"></script>
    <script src="{{asset('backend-app/directives/driver-single-map.js')}}"></script>
    <script src="{{asset('backend-app/directives/create-trip-form.js')}}"></script>
    <script src="{{asset('backend-app/directives/gmap-directory.js')}}"></script>
    <script src="{{asset('backend-app/directives/gdrawing-tools.js')}}"></script>
    <script src="{{asset('backend-app/directives/message-item.js')}}"></script>
    <script src="{{asset('backend-app/directives/driver-maps.js')}}"></script>
    <script src="{{asset('backend-app/directives/user-status-changed.js')}}"></script>
    <script src="{{asset('backend-app/services/achievement.service.js')}}"></script>
    <script src="{{asset('backend-app/modals/confirm-box.js')}}"></script>
    <script src="{{asset('backend-app/modals/change-trip-box.js')}}"></script>

    @yield('view.scripts')
  </body>
</html>