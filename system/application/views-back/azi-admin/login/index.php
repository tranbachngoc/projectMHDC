<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Admin Azibai</title>
    <!-- 
    <meta name="description" content="<?=SEO_DESCRIPTION?>">
    <meta name="Keywords" content="<?=SEO_KEYWORDS?>">
    <meta name="robots" content="INDEX,FOLLOW"> 
	-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=1" id="viewport">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="HandheldFriendly" content="True">
    <meta http-equiv="X-UA-Compatible", content="IE=edge">
    <!--[if IE]><meta http-equiv="cleartype" content="on"><![endif]-->
    
    <!-- CSS -->
    <link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap.css">
    <link href="/templates/home/styles/css/reset.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/base.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/supperDefault.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/admin.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/templates/home/css/font-awesome.min.css">
    <!-- JS -->
    
    <script src="/templates/home/js/jquery.min.js"></script>
    <script src="/templates/home/boostrap/js/popper.min.js"></script>
    <script type="text/javascript" src="/templates/home/boostrap/js/bootstrap.js"></script> 
  </head>
<body>
  <div class="wrapper">
     <header class="administrator-header">
      <div class="administrator-header-content">
        <div class="container">
          <div class="admin-header">
            <div class="left">
            </div>
            <div class="center">
              <h1 class="logo">administrator</h1>
            </div>
            <div class="right">
              <a href="login.html" class="md">Đăng nhập</a>
            </div>
          </div>
        </div>
      </header>
    </header>
    <main class="administrator">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="administrator-login">
              <div class="tit">
                <span class="icon"><img src="/templates/home/styles/images/svg/user05.svg" alt=""></span><br>
                <h2>Đăng nhập</h2>
              </div>
              <div class="login-form">
                <form method="post">
                  <div class="form-group">
                    <input required minlength="3" type="text" name="usernameLogin" class="form-control" placeholder="Tên đăng nhập">
                    <small class="form-text text-danger"></small>
                  </div>
                  <div class="form-group">
                    <input required minlength="6" id="passwordLogin" name="passwordLogin" type="password" class="form-control" placeholder="Mật khẩu">
                    <div class="show-pass">
                    	<img src="/templates/home/styles/images/svg/eye_off.svg" alt="">
                    </div>
                  </div>
                  
                  <?php if ($this->session->flashdata('sessionErrorLoginAdmin')){ ?>
                  <span class="alert alert-warning">Sai tài khoản hoặc mật khẩu.</span>
              	  <?php } ?>

                  <!-- <a href="">Bạn quên mật khẩu?</a> -->
                  <button type="submit" class="btn btn-login">Đăng nhập</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </main>
  </div>
 
  <script src="asset/styles/js/common.js"></script>
  <script type="text/javascript">
    $('.show-pass').click(function () 
    { 	
	    var x = document.getElementById("passwordLogin");
		if (x.type === "password") 
		{
		    x.type = "text";
		    $(this).find('img').attr('src', '/templates/home/styles/images/svg/eye_on.svg');
		} 
		else 
		{
		    x.type = "password";
		    $(this).find('img').attr('src', '/templates/home/styles/images/svg/eye_off.svg');
		}
    });
  </script>
</body>
</html>