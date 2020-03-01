<?php $this->load->view('home/common/header_new'); ?>
<?php
if ($_SERVER['HTTP_REFERER'] != base_url() . "login") {
    $_SESSION['previous_page'] = $_SERVER['HTTP_REFERER'];
}
?>
<script src="<?php echo base_url() ?>templates/home/js/general_registry.js"></script>
<script src="<?php echo base_url() ?>templates/home/styles/js/common.js"></script>

<script type="text/javascript">
  function checkSocialLogin(data) { 
      // let url_reg = siteUrl+"register/socialfacebook";
      // if (data.social == 'google') {
      //   url_reg = siteUrl+"register/socialgoogle";
      // }
      var url_reg =   siteUrl+"home/register/register_by_social";       
      if (data.accessToken) {
        // console.log(data); 
        $.ajax({
          type: "POST",
          url: url_reg,         
          data: data,
          dataType: "json",
          success: (resp) => {            
            console.log(resp);
            if (resp.error == false) {
              console.log('login success');
              if (resp.redirect != '') {
                $(location).attr('href', resp.redirect);
              } else {
                alert(resp.message);
              }
            } else {
              console.log('login failed');
              alert(resp.message);
            }
          },
          error: (err) => {console.log('Lỗi: '+err)}
        });
      }
    }

    var requestPermissions = '<?php echo FACEBOOK_PERMISSION; ?>';
    var requestFaceBook = '<?php echo FACEBOOK_FIELD; ?>';
    
    function facebookInit() {
      if (window.FB)
        return false;
      var js, id = 'facebook-jssdk', ref = document.getElementsByTagName('script')[0];
      if (document.getElementById(id)) {
        return;
      }
      js = document.createElement('script');
      js.id = id;
      js.async = true;
      js.src = "//connect.facebook.net/en_US/all.js";
      ref.parentNode.insertBefore(js, ref);        
    }

    window.fbAsyncInit = function () {
      // init the FB JS SDK
      FB.init({
        appId: '<?php echo FACEBOOK_ID; ?>', // App ID from the App Dashboard [Optional]
        status: true, // check the login status upon init?
        cookie: true, // set sessions cookies to allow your server to access the session?
        xfbml: true, // parse XFBML tags on this page?
        version: 'v2.0'
      });
    };

    window.loginByFacebookAccount = function (element) {
        var clickEl = $(element);
        if (clickEl.length > 0 && clickEl.hasClass('clicked') === true) {
            return false;
        }
        clickEl.addClass('clicked');
        FB.login(function (response) {
          if (response.status === 'connected') {              
            FB.api('/' + response.authResponse.userID, {fields: requestFaceBook}, function (res) {
              var parrams = {};
              // console.log(res);
              parrams.id = res.id;
              parrams.email = res.email;              
              parrams.social = 'facebook';
              parrams.name = res.name;
              parrams.accessToken = response.authResponse.accessToken;
              parrams.avatar = 'https://graph.facebook.com/'+res.id+'/picture?type=square';

              // FB.api('/'+res.id+'/picture','GET',{'redirect':false,'height':250,'width':250}, function (response) {
              //   if (response && !response.error) {                  
              //     parrams.avatar = response.data.url;
              //   }
              // });

              checkSocialLogin(parrams);
            });            
          } else {
            if (clickEl.length > 0) {
                clickEl.removeClass('clicked');
            }                
          }
        }, {scope: requestPermissions});
    };

    // var defaultCallBackUrl = '/customer/account/logingoogle';
    var defaultCallBackUrl = '/register/socialgoogle';
    var googleCallBackUrl = defaultCallBackUrl;

    // Handle case Google login hit twice: http://stackoverflow.com/questions/23020733/google-login-hitting-twice?rq=1
    var glIsGoogleAlreadyHandled = false;

    // Google OAuth Init
    (function () {
        var po = document.createElement('script');
        po.type = 'text/javascript';
        po.async = true;
        po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(po, s);
    })();

    function onLoadCallback() {
        // Replace the API key with yours
        gapi.client.setApiKey('<?php echo GOOGLE_KEY; ?>');
        gapi.client.load('plus', 'v1', function () {
        });
    }
    // Google Oauth Init - END

    function handleAuthResult(authResult) {
      if (authResult['status']['signed_in'] && authResult['status']['method'] == 'PROMPT') {
          var clickEl = $('button.google');
          if (clickEl.length > 0) {
              clickEl.removeClass('clicked');
          }
          if (authResult && !authResult.error) {

            gapi.client.load('oauth2', 'v2', function () {
              gapi.client.oauth2.userinfo.get()
              .execute(function (res) {
               
                var googleToken = gapi.auth.getToken();
                // Shows user email
                var parrams = {};
                parrams.id = res.id;
                parrams.email = res.email;
                parrams.name = res.name;
                parrams.social = 'google';
                parrams.code = googleToken.code;
                parrams.accessToken = googleToken.code;
                parrams.avatar = res.picture;
                checkSocialLogin(parrams);
              });
            });

          } else if (authResult['error']) {
              console.log('There was an error: ' + authResult['error']);
          } else {
              console.log('There was an unexpected error: ' + authResult);
          }
      }
        
    }

    

    function handleGoogleAuthClick(element) {
        var clickEl = $(element);
        if (clickEl.length > 0 && clickEl.hasClass('clicked') === true) {
            return false;
        }
        clickEl.addClass('clicked');
        var options = {
            'callback': handleAuthResult,
            'approvalprompt': 'auto',
            'clientid': '<?php echo GG_APP_ID; ?>',
            'scope': '<?php echo GOOGLE_SCOPE; ?>',
            'cookiepolicy': 'single_host_origin'
        };
        gapi.auth.signIn(options);
        console.log('dfgfg');
        return false;
    }
   
    jQuery(document).ready(function () {
      facebookInit();      
    });
</script>

<main>
      <section class="main-content">
        <div class="container">
          <div class="signin">
            <div class="signin-info">
              <h2 class="wellcome">Chào mừng đến với <strong>azibai</strong></h2>
              <ul class="list-info">
                <li>
                  <div class="icon"><img src="/templates/home/images/svg/icon_a.svg" alt=""></div>
                  <div class="text">Mạng xã hội kinh doanh<br>Khởi tạo blog cá nhân và trang web tiếp thị bán hàng miễn phí</div>
                </li>
                <li>
                  <div class="icon"><img src="/templates/home/images/svg/icon_dola.svg" alt=""></div>
                  <div class="text">Tiếp thị liên kết - kiểm thêm thu nhập bằng việc chia sẻ thông tin "sản phẩm - dịch vụ"</div>
                </li>
                <li>
                  <div class="icon"><img src="/templates/home/images/svg/icon_headphone.svg" alt=""></div>
                  <div class="text">Nhắn tin - goi điện thoại trực tuyến</div>
                </li>
              </ul>
            </div>
			<?php if (isset($successLogin) && $successLogin == false) { ?>
			<?php if (isset($validLogin) && $validLogin == true) {?>
			<?php } else { ?>
				<?php
				if (isset($errorLogin) && $errorLogin == true) {
				echo $this->lang->line('error_message_defaults');
				} ?>
			<?php }?>
            <div class="signin-form">
              <ul class="tabs-list">
                <li class="is-active">
                  <div class="icon"><span><img src="/templates/home/images/svg/user_signin.svg" alt=""></span></div>
                  <p>Đăng nhập</p>
                </li>
                <li class="">
                  <div class="icon"><span><a href="<?php echo azibai_url(); ?>/register/verifycode"><img src="/templates/home/images/svg/user_signin.svg" alt=""></a></span></div>
                  <p>Đăng ký</p>
                </li>
              </ul>
              <div class="form-login">
                <div class="show-form show-form-signin" style="">
                  <span class="error-mess">
                    <?php if ($this->session->flashdata('_sessionSuccessForgot')){ ?> 
                        <div class="message warning">
                          <div class="alert alert-warning">
                            <?php echo $this->session->flashdata('_sessionSuccessForgot'); ?>
                          </div>
                        </div>
                    <?php } ?>
                  </span>

                  <form name="frmLoginPage" method="post" id="frmLoginPage" role="form">
                    <div class="form-group">
                      <input type="text" class="input-form" placeholder="Số điện thoại, mail, ..." onKeyPress="return submitenter(this, event)" name="UsernameLogin" id="UsernameLogin" maxlength="35" onkeyup="BlockChar(this, 'AllSpecialChar')" onblur="lowerCase(this.value, 'UsernameLogin');" required>
                      <span class="error-mess"><?php if ($this->session->flashdata('_sessionErrorLogin')){ ?>
							          <div class="message success">
                          <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('_sessionErrorLogin'); ?>
                          </div>
                        </div><?php } ?>
                      </span>
                    </div>

                    <div class="form-group">
                      <input type="password" class="input-form" placeholder="<?php echo $this->lang->line('password_defaults'); ?>" onKeyPress="return submitenter(this, event)" name="PasswordLogin" id="PasswordLogin" maxlength="35" required>
                      <span class="error-mess"><?php if ($this->session->flashdata('_sessionPassErrorLogin')){ ?>
                        <div class="message success">
                          <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('_sessionPassErrorLogin'); ?>
                          </div>
                        </div><?php } ?>
                      </span>
                      <a href="<?php echo azibai_url(); ?>/forgot">Bạn quên mật khẩu?</a>
                    </div>

                    <div class="form-button">
                      <button class="button button-gray">Đăng nhập</button>
                    </div>

                    <a href="<?php echo azibai_url(); ?>/register/verifycode"><p>Chưa có tài khoản? Tạo tài khoản</p></a>
                  </form> 
                  
                  <!-- <div class="login-other">
                    <h3><span>hoặc</span></h3>
                    <div class="two-type">

                      <button onclick="loginByFacebookAccount(this); return false;" class="btn btn-primary btn-block facebook">
                        <img src="/templates/home/images/svg/ico_facebook.svg" alt="">Đăng nhập bằng Facebook
                      </button>

                      <button onclick="handleGoogleAuthClick(this); return false;"  class="btn btn-danger btn-block google">
                        <img src="/templates/home/images/svg/ico_google.svg" alt="">Đăng nhập bằng Google
                      </button>
                    </div>
                 </div>   -->

                </div>
              </div>
            </div>
			<?php } ?>
          </div>
        </div>
      </section>      
</main>

<?php $this->load->view('home/common/footer_new'); ?>