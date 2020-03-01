$( document ).ready(function() {

  $('body').on('click', '.js-show-like', function(){
    var id_content = $(this).attr('data-id');
    $('.js-show-like-user').html('');
    $('#luotthich .like_url').attr('href','like/info/');
    ajax_list_like("like/info/", id_content, 1, true, false);
  });

  $('body').on('click', '.js-show-like-image', function(){
      var id_content = $(this).attr('data-id');
      $('.js-show-like-user').html('');
      $('#luotthich .like_url').attr('href','like/info-image/');
      ajax_list_like("like/info-image/", id_content, 1, true, false);
  });

  $('body').on('click', '.js-show-like-video', function(){
    var id_content = $(this).attr('data-id');
    $('.js-show-like-user').html('');
    $('#luotthich .like_url').attr('href','like/info-video/');
    ajax_list_like("like/info-video/", id_content, 1, true, false);
  });

  $('body').on('click', '.js-show-like-gallery', function(){
    var id_pro = $(this).attr('data-id');
    $('.js-show-like-user').html('');
    $('#luotthich .like_url').attr('href','like/info-gallery/');
    ajax_list_like("like/info-gallery/", id_pro, 1, true, false);
  });

  $('body').on('click', '.js-show-like-link', function(){
    var id_link = $(this).attr('data-id');
    var type_link = $(this).attr('data-type_url');
    $('.js-show-like-user').html('');
    $('#luotthich .like_url').attr('href','like/info-link/');
    ajax_list_like("like/info-link/", id_link, 1, true, false, type_link);
  });

  $('body').on('click', '.js-show-like-product', function(){
    var id_pro = $(this).attr('data-id');
    $('.js-show-like-user').html('');
    $('#luotthich .like_url').attr('href','like/infopro/');
    ajax_list_like("like/infopro/", id_pro, 1, true, false);
  });

  $('body').on('click', '.js-show-like-service', function(){
    var id_service = $(this).attr('data-id');
    $('.js-show-like-user').html('');
    $('#luotthich .like_url').attr('href','like/info-service/');
    ajax_list_like("like/info-service/", id_service, 1, true, false);
  });

  //Follow list like
  /*$('body').on('click', '.js-follow-user', function(){
    $('.load-wrapp').show();
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'follow/user',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        $('.load-wrapp').hide();
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.addFriend == false){
            $('#luotthich').modal('hide');
            mess = 'Bạn đã nhận được yêu cầu kết bạn từ người này, bạn load lại trang để xác nhận';
            $('#modal_mess').modal('show');
            $('#modal_mess .modal-body p').html(mess);
          }
          else{
            $('.btn-follow-'+id_user).attr('class','btn-follow btn-follow-'+id_user);
            $('.btn-follow-'+id_user).html('<div class="pendFriend-'+id_user+' pendFriend show"><img src="/templates/home/styles/images/svg/daguiloimoi.svg"><span class="text">Đã gửi yêu cầu</span></div>');
          }
        }
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });*/

  $('body').on('click', '.js-confirmfollow-user', function(){
    $('.load-wrapp').show();
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'confirmfollow/user',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        $('.load-wrapp').hide();
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.confirmFriend == false){
            $('#luotthich').modal('hide');
            mess = 'Xác nhận thất bại';
            $('#modal_mess').modal('show');
            $('#modal_mess .modal-body p').html(mess);
          }
          else{
            if(result.follow == false){
              $('#luotthich').modal('hide');
              mess = 'follow thất bại';
              $('#modal_mess').modal('show');
              $('#modal_mess .modal-body p').html(mess);
            }else{
              $('.btn-friend-'+id_user).html('<img class="hasfriend-'+id_user+' hasfriend show" src="/templates/home/styles/images/svg/banbe.svg" alt="Bạn bè"><span class="text"> Bạn bè</span>');
              $('.btn-friend-'+id_user).attr('class','btn unfriend btn-friend-'+id_user);
            }
          }
        }
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });

  /*$('body').on('click', '.js-cancelfollow-user', function(){
    var id_user = $(this).attr('data-id');
    mess = 'Bạn có muốn hủy kết bạn';
    $('#modal_mess').modal('show');
    $('#modal_mess .modal-body p').html(mess);
    $('#modal_mess .buttons-direct .btn-ok').text('Xác nhận');
    $('#modal_mess .buttons-direct .btn-ok').removeClass(' hidden');
    $('.btn-ok').on('click',function(){
      $('#modal_mess').modal('hide');
      $('#modal_mess .modal-body p').html('');
      $.ajax({
        type:'POST',
        url:siteUrl +'cancelfollow/user',
        dataType: 'json',
        data:{id_user: id_user},
        success:function(result){
          var mess = '';
          var type = result.error == true ? 'alert-danger' : 'alert-success';
          if(result.error == true && result.user == false){
            $('#luotthich').modal('hide');
            mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
            $('#modal_mess').modal('show');
            $('#modal_mess .modal-body p').html(mess);
          }
          else
          {
            if(result.cancelFriend == false){
              $('#luotthich').modal('hide');
              mess = 'Hủy kết bạn thất bại';
              $('#modal_mess').modal('show');
              $('#modal_mess .modal-body p').html(mess);
            }
            else{
              $('.btn-follow-'+id_user).attr('class','btn btn-follow btn-follow-'+id_user+' js-follow-user');
              $('.btn-follow-'+id_user).html('<img class="nofriend-'+id_user+' nofriend show" src="/templates/home/styles/images/svg/ketban.svg" alt="Kết bạn"><span class="text"> Kết bạn</span>');
            }
          }
        },
        error: function(){
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html('Kết nối thất bại');
        }
      });
    });
  });
  $('body').on('click', '.js-deletefollow-user', function(){
    $('.load-wrapp').show();
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'deletefollow/user',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        $('.load-wrapp').hide();
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.deleteFollow == false){
            $('#luotthich').modal('hide');
            mess = 'Xóa yêu cầu kết bạn thất bại';
            $('#modal_mess').modal('show');
            $('#modal_mess .modal-body p').html(mess);
          }
          else{
            // mess = 'Xóa thành công';
            $('.isFollow').addClass(' hidden');
            $('.noFollow').removeClass(' hidden');
            $('.theodoi').text('Theo dõi');
          }
        }
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });*/


  //Follow profile
  $('body').on('click', '.js-follow-user-profile', function(){//add friend
    $('.load-wrapp').show();
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'follow/user',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        $('.load-wrapp').hide();
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.addFriend == false){
            $('#luotthich').modal('hide');
            mess = 'Bạn đã nhận được yêu cầu kết bạn từ người này, bạn load lại trang để xác nhận';
          }
          else{
            mess = 'Bạn đã gửi lời mời kết bạn thành công';
            //page profile
            $('.xoaloimoi').addClass(' ketban-mess');
            $('.isFollow').removeClass(' hidden');
            $('.noFollow').addClass(' hidden');
            //chung
            $('.btn-friend-'+id_user).removeClass(' js-follow-user-profile');
            $('.btn-friend-'+id_user).find('span').text('Đã gửi yêu cầu');
            $('.btn-friend-'+id_user).find('img').attr('src', '/templates/home/styles/images/svg/daguiloimoi.svg');
          }
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
          $('#modal_mess .btn-cancle').text('Đóng');
        }
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.confirm-friend', function(){
    $('.load-wrapp').show();
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'confirmfollow/user',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        $('.load-wrapp').hide();
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.confirmFriend == false){
            $('#luotthich').modal('hide');
            mess = 'Xác nhận thất bại';
            $('#modal_mess').modal('show');
            $('#modal_mess .modal-body p').html(mess);
          }
          else{
            if(result.follow == false){
              $('#luotthich').modal('hide');
              mess = 'follow thất bại';
              $('#modal_mess').modal('show');
              $('#modal_mess .modal-body p').html(mess);
            }else{
              $('.banbe').removeClass(' hidden');
              $('.choxacnhan').addClass(' hidden');
              $('.isFollow').removeClass(' hidden');
              $('.noFollow').addClass(' hidden');
            }
          }
        }
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.unfriend', function(){
    var id_user = $(this).attr('data-id');
    var user_name = $(this).attr('data-name');
    var _this = $(this);
    var mess = 'Bạn có chắc muốn hủy bạn bè với <b>'+user_name+'</b>';
    $('#modal_mess').modal('show');
    $('#modal_mess .modal-body p').html(mess);
    $('#modal_mess .modal-footer .btn-ok').removeClass('hidden').text('Xác nhận hủy bạn bè').addClass('btn-ok-unfriend').attr('data-id', id_user);
  });

  $('body').on('click', '.btn-ok.btn-ok-unfriend', function(){
    unfriend($(this).attr('data-id'));
  });

  function unfriend(id_user){
    $('#modal_mess').modal('hide');
    $('#modal_mess .modal-body p').html('');
    $('.load-wrapp').show();
    $.ajax({
      type:'POST',
      url:siteUrl +'cancelfollow/user',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.cancelFriend == false){
            $('#luotthich').modal('hide');
            mess = 'Hủy bạn thất bại';
          }
          else{
            //page profile
            $('.banbe').addClass(' hidden');
            $('.choxacnhan').removeClass(' hidden');
            $('.xacnhanFollow').remove();
            $('.isFollow').addClass(' hidden');
            $('.noFollow').removeClass(' hidden');
            $('.theodoi').text('Theo dõi');
            // $('.btn-follow-'+id_user).attr('class','btn btn-follow btn-follow-'+id_user+' js-follow-user');
            // $('.btn-follow-'+id_user).html('<img class="nofriend-'+id_user+' nofriend show" src="/templates/home/styles/images/svg/ketban.svg" alt="Kết bạn"><span class="text"> Kết bạn</span>');
            mess = 'Hủy bạn thành công';

            // $('.btn-friend-'+id_user).attr('class','btn btn-friend btn-friend-'+id_user+' js-follow-user');
            // $('.btn-friend-'+id_user).html('<img class="nofriend-'+id_user+' nofriend show" src="/templates/home/styles/images/svg/ketban.svg" alt="Kết bạn"><span class="text"> Kết bạn</span>');
            //chung
            $('.btn-friend-'+id_user).addClass(' js-follow-user-profile').removeClass('unfriend');
            $('.btn-friend-'+id_user+' span').text('Kết bạn');
            $('.btn-friend-'+id_user).find('img').attr('src', '/templates/home/styles/images/svg/ketban.svg');
            $('#modal_mess .modal-footer .btn-ok').removeClass('btn-ok-unfriend').addClass('hidden');
          }
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        $('.load-wrapp').hide();
      },
      error: function(){
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
        $('.load-wrapp').hide();
      }
    });
  }

  $('body').on('click', '.js-removefollow-user', function(){
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var user_name = $(this).attr('data-name');
    var _this = $(this);
    var mess = 'Bạn có chắc muốn xóa lời mời kết bạn với <b>'+user_name+'</b>';
    $('#modal_mess').modal('show');
    $('#modal_mess .modal-body p').html(mess);
    $('#modal_mess .modal-footer .btn-ok').removeClass('hidden').text('Xác nhận').addClass('btn-ok-xoayeucau').attr('data-id', id_user);
  });

  $('body').on('click', '.btn-ok.btn-ok-xoayeucau', function(){
    xoayeucau($(this).data('id'));
  });

  function xoayeucau(id_user){
    $('#modal_mess').modal('hide');
    $('.load-wrapp').show();
    $.ajax({
      type:'POST',
      url:siteUrl +'removefollow/user',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.deleteFollow == false){
            $('#luotthich').modal('hide');
            mess = 'Xóa lời mời kết bạn thất bại';
          }
          else{
            $('.banbe').addClass(' hidden');
            // $('.ketban-btn span').addClass(' js-follow-user-profile');
            $('.ketban-btn span.btn-friend-'+id_user).addClass(' js-follow-user-profile');
            $('.ketban-btn span.btn-friend-'+id_user).text('Kết bạn');
            $('.xoaloimoi').removeClass(' ketban-mess');
            $('.xoaloimoi').addClass(' hidden');
            // $('.btn-follow-'+id_user).addClass(' js-follow-user-profile');
            $('.btn-friend-'+id_user).addClass(' js-follow-user-profile');
            $('.isFollow').addClass(' hidden');
            $('.noFollow').removeClass(' hidden');
            // $('.btn-follow-'+id_user).text('Kết bạn');
            $('.btn-friend-'+id_user).html('<span class="text">Kết bạn</span>');

            mess = 'Xóa lời mời kết bạn thành công';
            $('#modal_mess .modal-footer .btn-ok').removeClass('btn-ok-xoaloimoi').addClass('hidden');
          }
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
          $('.load-wrapp').hide();
        }
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  }

  $('body').on('click', '.block-friend', function(){
    var id_user = $(this).attr('data-id');
    var user_name = $(this).attr('data-name');
    var _this = $(this);
    var mess = 'Bạn có chắc muốn chặn <b>'+user_name+'</b>, sau khi chặn thì <b>'+user_name+'</b> sẽ: <br/> - Không thể xem nội dung tại trang cá nhân của bạn. <br/> - Không thể trò chuyện với bạn. <br/> - Không thể thêm bạn làm bạn bè. </br> <span class="text-red">***Lưu ý:</span> Nếu bạn và <b>'+user_name+'</b> đã là bạn của nhau thì sau khi chặn, hai bạn sẽ bị hủy trạng thái bạn bè.';
    $('#modal_mess').modal('show');
    $('#modal_mess .modal-body p').html(mess);
    $('#modal_mess .modal-footer .btn-ok').removeClass('hidden').text('Xác nhận chặn').addClass('btn-ok-block').attr('data-id', id_user);
  });

  $('body').on('click', '.btn-ok.btn-ok-block', function(){
    block_user($(this).data('id'));
  });

  function block_user(id_user){
    $('#modal_mess').modal('hide');
    $('.load-wrapp').show();
    $.ajax({
      type:'POST',
      url:siteUrl +'follow/blockfriend-profile',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        $('.load-wrapp').hide();
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.isBlock == false){
            mess = 'Chặn bạn thất bại';
          }
          else{
            mess = 'Chặn bạn thành công';
            // $('.isFollow').addClass(' hidden');
            // $('.noFollow').removeClass(' hidden');
            $('.block-friend-'+id_user).text('Bỏ chặn');
            $('.block-friend-'+id_user).attr('class','cancel-block cancel-block-'+id_user);
            $('#modal_mess .modal-footer .btn-cancle').addClass('hidden');
            $('#modal_mess .modal-footer .btn-ok').addClass('hidden');
          }
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);

          setTimeout(function(){
            location.reload();
          }, 1000);
        }
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  }

  $('body').on('click', '.cancel-block', function(){
    var id_user = $(this).attr('data-id');
    var user_name = $(this).attr('data-name');
    var _this = $(this);
    var mess = 'Bạn có chắc muốn bỏ chặn <b>'+user_name+'</b>, sau bỏ chặn <b>'+user_name+'</b> sẽ: <br/> - Xem được nội dung tại trang cá nhân của bạn. <br/> - Liên lạc được với bạn. <br/> - Kết bạn, theo dõi.';
    $('#modal_mess').modal('show');
    $('#modal_mess .modal-body p').html(mess);
    $('#modal_mess .modal-footer .btn-ok').removeClass('hidden').text('Xác nhận bỏ chặn').addClass('btn-ok-cancelblock').attr('data-id', id_user);
  });

  $('body').on('click', '.btn-ok.btn-ok-cancelblock', function(){
    cancelblock_user($(this).attr('data-id'));
  });

  function cancelblock_user(id_user){
    $('#modal_mess').modal('hide');
    $('.load-wrapp').show();
    $.ajax({
      type:'POST',
      url:siteUrl +'follow/cancelblock-profile',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.cancelBlock == false){
            mess = 'Bỏ chặn thất bại';
          }
          else{
            mess = 'Bỏ chặn thành công';
            $('.cancel-block-'+id_user).text('Chặn');
            $('.cancel-block-'+id_user).attr('class','block-friend block-friend-'+id_user);
            $('#modal_mess .modal-footer .btn-cancle').addClass('hidden');
            $('#modal_mess .modal-footer .btn-ok').addClass('hidden');
          }

          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);

          setTimeout(function(){
            location.reload();
          }, 1000);
        }
        $('.load-wrapp').hide();
        
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  }

  $('body').on('click', '.is-follow', function(){
    $('.load-wrapp').show();
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'follow/follow-profile',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.isFollow == false){
            $('#luotthich').modal('hide');
            mess = 'Theo dõi thất bại';
          }
          else{
            mess = 'Theo dõi thành công';
            $('.isFollow').removeClass(' hidden');
            $('.noFollow').addClass(' hidden');
            // $('.theodoi').text('Đang theo dõi');
          }
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        $('.load-wrapp').hide();
        
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.priority-follow', function(){
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'follow/priority-profile',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.isFollow == false){
            $('#luotthich').modal('hide');
            mess = 'Theo dõi thất bại';
          }
          else{
            mess = 'Ưu tiên theo dõi thành công';
            // $('.isFollow').removeClass(' hidden');
            // $('.noFollow').addClass(' hidden');
            // $('.theodoi').text('Đang theo dõi');
            $('.priority-follow-'+id_user).text('Bỏ theo dõi ưu tiên');
            $('.priority-follow-'+id_user).attr('class','cancel-priority-follow cancel-priority-follow-'+id_user);
          }
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
      },
      error: function(){
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.cancel-priority-follow', function(){
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'follow/cancelpriority-profile',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.isFollow == false){
            $('#luotthich').modal('hide');
            mess = 'Theo dõi thất bại';
          }
          else{
            mess = 'Hủy ưu tiên theo dõi thành công';
            // $('.isFollow').removeClass(' hidden');
            // $('.noFollow').addClass(' hidden');
            // $('.theodoi').text('Đang theo dõi');
            $('.cancel-priority-follow-'+id_user).text('Ưu tiên theo dõi');
            $('.page-priofollow .item-'+id_user).remove();
            $('.cancel-priority-follow-'+id_user).attr('class','priority-follow priority-follow-'+id_user);
          }
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
      },
      error: function(){
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.cancel-follow', function(){
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'follow/cancel-follow-profile',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.cancelFollow == false){
            $('#luotthich').modal('hide');
            mess = 'Bỏ theo dõi thất bại';
          }
          else{
            mess = 'Bỏ theo dõi thành công';
            $('.isFollow').addClass(' hidden');
            $('.noFollow').removeClass(' hidden');
            // $('.theodoi').text('Theo dõi');
          }
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
      },
      error: function(){
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.js-deletefollow-user', function(){
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var user_name = $(this).attr('data-name');
    var _this = $(this);
    var mess = 'Bạn có muốn gỡ lời mời kết bạn của <b>'+user_name+'</b>';
    $('#modal_mess').modal('show');
    $('#modal_mess .modal-body p').html(mess);
    $('#modal_mess .modal-footer .btn-ok').removeClass('hidden').text('Xác nhận').addClass('btn-ok-xoaloimoi').attr('data-id', id_user);
  });

  $('body').on('click', '.btn-ok.btn-ok-xoaloimoi', function(){
    xoaloimoi($(this).attr('data-id'));
  });

  function xoaloimoi(id_user){
    $('.load-wrapp').show();
    $('#modal_mess').modal('hide');
    $.ajax({
      type:'POST',
      url:siteUrl +'deletefollow/user',
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.deleteFollow == false){
            $('#luotthich').modal('hide');
            mess = 'Xóa lời mời kết bạn thất bại';
            $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
          }
          else{
            // mess = 'Xóa thành công';
            $('.xacnhanFollow').remove();
            $('.isFollow').addClass(' hidden');
            $('.noFollow').removeClass(' hidden');
            $('.btn-friend-'+id_user).addClass(' js-follow-user-profile');
            $('.btn-friend-'+id_user+' span').text('Kết bạn');
          }
        }
        $('.load-wrapp').hide();
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  }

  //Follow shop
  $('body').on('click', '.is-follow-shop', function(){
    $('.load-wrapp').show();
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'follow/follow-shop',
      dataType: 'json',
      data:{sho_id: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.isFollow == false){
            $('#luotthich').modal('hide');
            mess = 'Theo dõi thất bại';
          }
          else{
            mess = 'Theo dõi thành công';
            $('.isFollow-'+id_user).removeClass(' hidden');
            $('.noFollow-'+id_user).addClass(' hidden');
            $('.theodoi').text('Đang theo dõi');

            var html = '<div class="btn">';
            html += '<img src="/templates/home/styles/images/svg/botheodoi.svg" alt="Đang theo dõi" title="Đang theo dõi" style="width: 18px;height: 18px;">';
            html += '<span class="text md"> Đang theo dõi</span>';
            html += '</div>';
            $('.is-follow-shop-'+id_user).html(html);
            $('.is-follow-shop-'+id_user).attr('class','btn-follow-'+id_user+' cancel-follow-shop-'+id_user+' cancel-follow-shop');
          }
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        $('.load-wrapp').hide();
        
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.cancel-follow-shop', function(){
    $('#modal_mess .modal-body p').html('');
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'follow/cancel-follow-shop',
      dataType: 'json',
      data:{sho_id: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
        else
        {
          if(result.cancelFollow == false){
            $('#luotthich').modal('hide');
            mess = 'Bỏ theo dõi thất bại';
          }
          else{
            mess = 'Bỏ theo dõi thành công';
            $('.isFollow-'+id_user).addClass(' hidden');
            $('.noFollow-'+id_user).removeClass(' hidden');
            $('.theodoi').text('Theo dõi');

            var html = '<div class="btn">';
            html += '<img src="/templates/home/styles/images/svg/theodoi.svg" alt="Theo dõi" title="Theo dõi" style="width: 18px;height: 18px;">';
            html += '<span class="text md"> Theo dõi</span>';
            html += '</div>';
            $('.cancel-follow-shop-'+id_user).html(html);
            $('.cancel-follow-shop-'+id_user).attr('class','btn-follow-'+id_user+' is-follow-shop-'+id_user+' is-follow-shop');
          }
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html(mess);
        }
      },
      error: function(){
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });

  function ajax_list_like(link, id_content, pape, modal, button, type_url) {
    var data = {};
    if(type_url != undefined){
      data = {id: id_content, tbl: type_url};
    }else{
      data = {id: id_content};
    }
    $('.load-wrapp').show();
    jQuery.ajax({
          type: "POST",
          url: siteUrl + link,
          dataType: 'json',
          data: data,
          success: function (res) {
            $('.total_like_content').text(res.total);
            var arr_addFriend = {};
            var arr_isFriend = {};
            if(res.addFriend.length > 0){
              $.each(res.addFriend, function( key_, value ) {
                arr_addFriend[value['user_id']] = {accept:value['accept']};
              });
            }
            if(res.isFriend.length > 0){
              $.each(res.isFriend, function( key_link, value ) {
                arr_isFriend[value['add_friend_by']] = {accept:value['accept']};
              });
            }
            var tmp_users = '';
            if(res.data.length > 0){
              $.each(res.data, function( key_link, value_link ) {
                var template = $('#js-list-user-like').html();
                if (value_link.avatar == '') {
                  value_link.avatar = 'default-avatar.png';
                }
                template = template.replace(/{{USER_ID}}/g, value_link.user_id);
                template = template.replace(/{{AVATAR}}/g, value_link.avatar);
                template = template.replace(/{{NAME}}/g, value_link.use_fullname);
                profile_url = siteUrl + 'profile/' + value_link.user_id;
                if(value_link.website != ''){
                  profile_url = 'http://' + value_link.website;
                }
                template = template.replace(/{{PROFILE_URL}}/g, profile_url);
                console.log(value_link);
                //session gui loi moi

                if(arr_addFriend[value_link.user_id] != undefined || arr_isFriend[value_link.user_id] != undefined){
                  if(arr_addFriend[value_link.user_id] != undefined){ //session gui loi moi
                    var is_accept = arr_addFriend[value_link.user_id].accept;
                  }
                  else{//session duoc gui loi moi
                    var accept = arr_isFriend[value_link.user_id].accept;
                  }
                  if(is_accept != undefined || accept != undefined){
                    if(is_accept == 0 || accept == 0){
                      if(is_accept == 0){
                        //cho xac nhan
                        template = template.replace(/{{BTN_FOLLOW}}/g, ' ');
                        template = template.replace(/{{HAS_FOLLOW}}/g, '');
                        template = template.replace(/{{PEND_FOLLOW}}/g, 'show');
                        template = template.replace(/{{NO_FOLLOW}}/g, '');
                        template = template.replace(/{{IS_FOLLOW}}/g, '');
                      }else{
                        //Dong y yeu cau ket ban
                        template = template.replace(/{{BTN_FOLLOW}}/g, 'js-confirmfollow-user');
                        template = template.replace(/{{HAS_FOLLOW}}/g, '');
                        template = template.replace(/{{PEND_FOLLOW}}/g, '');
                        template = template.replace(/{{NO_FOLLOW}}/g, '');
                        template = template.replace(/{{IS_FOLLOW}}/g, 'show');
                      }
                    }else{
                      //ban be
                      template = template.replace(/{{BTN_FOLLOW}}/g, 'unfriend');
                      template = template.replace(/{{HAS_FOLLOW}}/g, 'show');
                      template = template.replace(/{{PEND_FOLLOW}}/g, '');
                      template = template.replace(/{{NO_FOLLOW}}/g, '');
                      template = template.replace(/{{IS_FOLLOW}}/g, '');
                    }
                  }
                }else{
                  if(res.user != value_link.user_id){
                      //ket ban
                      template = template.replace(/{{BTN_FOLLOW}}/g, 'js-follow-user-profile');
                      template = template.replace(/{{HAS_FOLLOW}}/g, '');
                      template = template.replace(/{{PEND_FOLLOW}}/g, '');
                      template = template.replace(/{{NO_FOLLOW}}/g, 'show');
                      template = template.replace(/{{IS_FOLLOW}}/g, '');
                    }
                }
                tmp_users += template;
              });
            }else{
              tmp_users = '<p>Không có dữ liệu</p>';
            }
            $('.js-show-like-user').html(tmp_users);
            $('.load-wrapp').hide();
            $('#luotthich .js-show-more-loadding').attr('data-page', res.page);
            $('#luotthich .js-show-more-loadding').attr('data-id', id_content);
            if (res.show_more == false) {
              $('.js-show-more-loadding').hide();
            } else {
              $('.js-show-more-loadding').show();
            }
            if (modal == true) {
              $('#luotthich').modal('show');
            }
          }
    }).always(function(jqXHR, textStatus) {
        $(button).button('reset');
    });
  }

  $('#luotthich').on('hidden.bs.modal', function () {
    if($('#modal-show-detail-img').hasClass('show') == true){
      $('body').addClass(' modal-open');
    }
    if($('#myModal2').hasClass('show') == true){
      $('body').addClass(' modal-open');
    }
  });
  
  $('#modal_mess').on('show.bs.modal', function () {
    $('#actfriend').modal('hide');
  });

  $('#modal_mess').on('hidden.bs.modal', function () {
    if($('#luotthich').hasClass('show') == true){
      $('body').addClass(' modal-open');
    }
    $('#modal_mess .modal-footer .btn-ok').attr('class', 'btn-share btn-ok hidden').removeAttr('data-id');
  });

  $('.js-show-more-loadding').on('click', function() {
    var $this = $(this);
    var page = parseInt($(this).attr('data-page')) + 1;
    var id_content = parseInt($(this).attr('data-id'));
    var url = $('#luotthich a.like_url').attr('href');
    $this.button('loading');
    ajax_list_like(url, id_content, page, false, $this);
  });


  //pop status user - sesion page friends
  $('body').on('click', '.actfriend', function(){
    $('.load-wrapp').show();
    var id_user = $(this).attr('data-id');
    var user_name = $(this).attr('data-name');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'profile/ajax_status_friend',
      dataType: 'json',
      data:{id_user: id_user, user_name: user_name},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          
        }
        else
        {
          $('#actfriend').modal('show');
          $('#actfriend .show-more-detail').html(result.status);
        }
        $('.load-wrapp').hide();
      },
      error: function(){
        $('.load-wrapp').hide();
        $('#modal_mess').modal('show');
        $('#modal_mess .modal-body p').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.js-list-offriend', function(){
    $('.modal-title').text('Bạn chung');
    $('.js-show-like-user').html('');
    var use_id = parseInt($(this).attr('data-id'));
    ajax_list_like('ajax_poplist_user', use_id, 1, true, false);
  });
});