<!DOCTYPE html>
<html lang="en" ng-app="limoApp">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Limo backend</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/backend.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Limo CAB</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li>
              <a href="#">About</a>
            </li>
            <li>
              <a href="#">Services</a>
            </li>
            <li>
              <a href="#">Contact</a>
            </li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
      </div>
      <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <p class="lead">@yield('title')</p>
          <ul class="list-group">
            <li class="list-group-item">
              <a href="#">Phone verify codes</a>
            </li>
            <li class="list-group-item">
              <a href="#">Dịch vụ</a>
              <ul>
                <li>
                  <a href="{{ url('backend/services') }}">Danh sách</a>
                </li>
                <li>
                  <a href="{{ url('backend/services/create') }}">Tạo mới</a>
                </li>
                <li>
                  <a href="{{ url('backend/services/config') }}">Cấu hình</a>
                </li>
              </ul>
            </li>
            <li class="list-group-item">
              <a href="#">Drivers</a>
              <ul>
                <li>
                  <a href="{{ url('backend/drivers') }}">Danh sách</a>
                </li>
                <li>
                  <a href="{{ url('backend/drivers/create') }}">Tạo mới</a>
                </li>
              </ul>
            </li>
            <li class="list-group-item">
              <a href="#">Customers</a>
              <ul>
                <li>
                  <a href="{{ url('backend/customers') }}">Danh sách</a>
                </li>
              </ul>
            </li>
            <li class="list-group-item">
              <a href="#">Mã khuyến mãi</a>
              <ul>
                <li>
                  <a href="{{ url('backend/promocodes') }}">Danh sách</a>
                </li>
                <li>
                  <a href="#">Tạo mới</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>

        <div class="col-md-9">
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

          @yield('main')
        </div>
      </div>

    </div>
    <!-- /.container -->

    <div class="container">

      <hr>

      <!-- Footer -->
      <footer>
        <div class="row">
          <div class="col-lg-12">
            <p>Copyright &copy; LimoCAB 2016</p>
          </div>
        </div>
      </footer>

    </div>
    <script>
        window.TOKEN = "{{ $jwtToken }}";
        window.SOCKET_URL = "{{ env('SOCKET_URL') }}";
    </script>
    <!-- /.container -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/angular.min.js')}}"></script>
    <script src="{{asset('js/socket.io.min.js')}}"></script>
    <script src="{{asset('js/socket.min.js')}}"></script>

    <script src="{{asset('backend-app/app.js')}}"></script>
    <script src="{{asset('backend-app/components/socket.js')}}"></script>

    <script src="{{asset('backend-app/directives/driver-single-map.js')}}"></script>
  </body>
</html>