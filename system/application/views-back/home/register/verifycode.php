<?php $this->load->view('home/common/header_new'); ?>
<?php $qr = '';
  if (isset($_REQUEST['reg_pa']) && $_REQUEST['reg_pa'] != '') { $qr = '?reg_pa='.$_REQUEST['reg_pa']; }
  if (isset($_REQUEST['type_affiliate']) && $_REQUEST['type_affiliate'] != '') { 
    $qr = $qr.'&type_affiliate='.$_REQUEST['type_affiliate'];
  }
  if (isset($_REQUEST['parent_id']) && $_REQUEST['parent_id'] != '') { 
    $qr = $qr.'&parent_id='.$_REQUEST['parent_id'];
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
      var url_reg =   siteUrl+"home/register/register_by_social<?php echo $qr ?>";       
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
            <div class="signin-form">
              <ul class="tabs-list">
                <li class="">
                  <div class="icon"><span><a href="<?php echo base_url(); ?>login"><img src="/templates/home/images/svg/user_signin.svg" alt=""></a></span></div>
                  <p>Đăng nhập</p>
                </li>
                <li class="is-active">
                  <div class="icon"><span><img src="/templates/home/images/svg/user_signin.svg" alt=""></span></div>
                  <p>Đăng ký</p>
                </li>
              </ul>
      <?php if ($successRegister == false) { ?>                   
              <div class="form-login">
                <div class="show-form show-form-signup" style="display: block;">
                  
                  <!-- <div class="login-other <?php echo ($qr != '') ? 'hidden' : ''; ?>" > -->
                  <!-- <div class="login-other" >
                    <div class="two-type">

                      <button onclick="loginByFacebookAccount(this); return false;" class="btn btn-primary btn-block facebook">
                        <img src="/templates/home/images/svg/ico_facebook.svg" alt="">Đăng ký bằng Facebook
                      </button>

                      <button onclick="handleGoogleAuthClick(this); return false;"  class="btn btn-danger btn-block google">
                        <img src="/templates/home/images/svg/ico_google.svg" alt="">Đăng ký bằng Google
                      </button>
                                                         
                    </div>
                    <h3><span>hoặc</span></h3>
                  </div> -->

                  <form action="<?php echo base_url().'register/verifycode'.$qr; ?>" name="frmVeryfy" id="frmVeryfy" method="post">
                    <div class="form-group"> 
                        <input type="tel" name="phone_num" value="<?php echo $this->session->flashdata('_sessionPhoneOld'); ?>" id="phone_num" class="input-form input-tel" placeholder="Số điện thoại" onblur="checkMobile(this.value, '<?php echo base_url(); ?>', 'phone_num')" autocomplete="off" required>
                        <span class="error-mess"><?php echo $this->session->flashdata('_sessionErrorLogin'); ?></span>
                     </div>
                     <div class="form-button">
                      <button type="submit" class="button button-white">Nhận mã kích hoạt</button>
                     </div>
                     <p>Bằng việc nhận mã kích hoạt, bạn đã đồng ý với các <a href="<?php echo base_url() .'content/29'; ?>" target="_blank"><span class="bold">điều khoản và điều kiện, chính sách, quyền riêng tư của azibai</span></a></p>
                  </form>

                </div>
              </div> 
        <?php } else { ?> 
        <div class="row wrap_regis">
          <p>Chúc mừng bạn đã đăng ký thành công</p>
        </div>
        <?php } ?>         
            </div>
          </div>
        </div>
      </section>
    </main>

<?php $this->load->view('home/common/footer_new'); ?>