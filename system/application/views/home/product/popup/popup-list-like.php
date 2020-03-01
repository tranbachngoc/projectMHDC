<style type="text/css">
.pendFriend {
    border: 1px solid #8a8e8b;
    color: #8a8e8b;
}
.confirmFriend {
    border: 1px solid #0904fb;
    color: #0904fb;
}
.pendFriend, .confirmFriend {
    border-radius: 5px;
    width: 104px;
    padding: 5px;
}
.nofriend, .hasfriend, .pendFriend, .confirmFriend{
  display: none;
}
.show{
  display: block;
}
</style>
<div class="modal mess-bg" id="luotthich">
  <div class="modal-dialog modal-dialog-center modal-lg modal-mess  ">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><span class="total_like_content"></span> Lượt thích</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <ul class="show-more-detail show-detail-user js-show-like-user">          
        </ul>
        <a class="like_url hidden" href="#"></a>
        <div class="text-center mt20">
          <button class="bnt-xemthem js-show-more-loadding" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Xem thêm" data-page="" data-id="">Xem thêm</button>
        </div>
      </div>
      
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script id="js-list-user-like" type="text/template">
    <li>
      <a target="_blank" href="<?php echo azibai_url() . '/profile/' ?>{{USER_ID}}" class="flex-between-center">
        <div class="nickname">
          <div class="img"><img src="<?php echo DOMAIN_CLOUDSERVER ?>/media/images/avatar/{{AVATAR}}" alt=""></div>
          <div class="name">{{NAME}}</div>
        </div>
      </a>
      <div class="buttons btn-follow btn-follow-{{USER_ID}} {{BTN_FOLLOW}}" data-id="{{USER_ID}}">
        <div class="md">
          <img class="nofriend-{{USER_ID}} nofriend {{NO_FOLLOW}}" src="/templates/home/styles/images/svg/bnt_theodoi.svg" alt="">
          <img class="hasfriend-{{USER_ID}} hasfriend {{HAS_FOLLOW}}" src="/templates/home/styles/images/svg/friend_pink.svg" alt="">
          <div class="pendFriend-{{USER_ID}} pendFriend {{PEND_FOLLOW}}">Đã gửi yêu cầu</div>
          <div class="confirmFriend-{{USER_ID}} confirmFriend {{IS_FOLLOW}}">Xác nhận</div>
        </div>
        <div class="sm">
          <img class="nofriend-{{USER_ID}} nofriend {{NO_FOLLOW}}" src="/templates/home/styles/images/svg/bnt_theodoi_sm.svg" alt="">
          <img class="hasfriend-{{USER_ID}} hasfriend {{HAS_FOLLOW}}" src="/templates/home/styles/images/svg/friend_pink_sm.svg" alt="">
          <div class="pendFriend-{{USER_ID}} pendFriend {{PEND_FOLLOW}}">Đã gửi yêu cầu</div>
          <div class="confirmFriend-{{USER_ID}} confirmFriend {{IS_FOLLOW}}">Xác nhận</div>
        </div>
      </div>
    </li>
</script>

<script type="text/javascript">

$(document).ready(function() {

  (function($) {
    $.fn.button = function(action) {
      if (action === 'loading' && this.data('loading-text')) {
        this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
      }
      if (action === 'reset' && this.data('original-text')) {
        this.html(this.data('original-text')).prop('disabled', false);
      }
    };
  }(jQuery));

  //Follow list like
  $('body').on('click', '.js-follow-user', function(){
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'follow/user/'+ parseInt(id_user),
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#dialog_mess').modal('show');
          $('#mess_detail').html(mess);
        }
        else
        {
          if(result.addFriend == false){
            $('#luotthich').modal('hide');
            mess = 'Bạn đã nhận được yêu cầu kết bạn từ người này, bạn load lại trang để xác nhận';
            $('#dialog_mess').modal('show');
            $('#mess_detail').html(mess);
          }
          else{
            $('.btn-follow-'+id_user).attr('class','btn-follow btn-follow-'+id_user);
            $('.btn-follow-'+id_user).html('<div class="pendFriend-'+id_user+' pendFriend show">Đã gửi yêu cầu</div>');
          }
        }
      },
      error: function(){
        $('#dialog_mess').modal('show');
        $('#mess_detail').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.js-confirmfollow-user', function(){
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'confirmfollow/user/'+ parseInt(id_user),
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#dialog_mess').modal('show');
          $('#mess_detail').html(mess);
        }
        else
        {
          if(result.confirmFriend == false){
            $('#luotthich').modal('hide');
            mess = 'Xác nhận thất bại';
            $('#dialog_mess').modal('show');
            $('#mess_detail').html(mess);
          }
          else{
            if(result.follow == false){
              $('#luotthich').modal('hide');
              mess = 'follow thất bại';
              $('#dialog_mess').modal('show');
              $('#mess_detail').html(mess);
            }else{
              $('.btn-follow-'+id_user).attr('class','btn-follow btn-follow-'+id_user+' js-cancelfollow-user');
              $('.btn-follow-'+id_user).html('<div class="md"><img class="hasfriend-'+id_user+' hasfriend show" src="/templates/home/styles/images/svg/friend_pink.svg" alt="Bạn bè"></div></div><div class="sm"><img class="hasfriend-'+id_user+' hasfriend show" src="/templates/home/styles/images/svg/friend_pink_sm.svg" alt="Bạn bè"></div></div>');
            }
          }
        }
      },
      error: function(){
        $('#dialog_mess').modal('show');
        $('#mess_detail').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.js-cancelfollow-user', function(){
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'cancelfollow/user/'+ parseInt(id_user),
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#dialog_mess').modal('show');
          $('#mess_detail').html(mess);
        }
        else
        {
          if(result.cancelFriend == false){
            $('#luotthich').modal('hide');
            mess = 'Hủy kết bạn thất bại';
            $('#dialog_mess').modal('show');
            $('#mess_detail').html(mess);
          }
          else{
            $('.btn-follow-'+id_user).attr('class','btn-follow btn-follow-'+id_user+' js-follow-user');
            $('.btn-follow-'+id_user).html('<div class="md"><img class="nofriend-'+id_user+' nofriend show" src="/templates/home/styles/images/svg/bnt_theodoi.svg" alt="Kết bạn"></div></div><div class="sm"><img class="nofriend-'+id_user+' nofriend show" src="/templates/home/styles/images/svg/bnt_theodoi_sm.svg" alt="Kết bạn"></div></div>');
          }
        }
      },
      error: function(){
        $('#dialog_mess').modal('show');
        $('#mess_detail').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.js-deletefollow-user', function(){
    var id_user = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'deletefollow/user/'+ parseInt(id_user),
      dataType: 'json',
      data:{id_user: id_user},
      success:function(result){
        var mess = '';
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        if(result.error == true && result.user == false){
          $('#luotthich').modal('hide');
          mess = 'Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này';
          $('#dialog_mess').modal('show');
          $('#mess_detail').html(mess);
        }
        else
        {
          if(result.deleteFollow == false){
            $('#luotthich').modal('hide');
            mess = 'Xóa lời mời kết bạn thất bại';
            $('#dialog_mess').modal('show');
            $('#mess_detail').html(mess);
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
        $('#dialog_mess').modal('show');
        $('#mess_detail').html('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.js-show-like-product', function(){console.log('gh');
    var id_pro = $(this).attr('data-id');
    $('.js-show-like-user').html('');
    $('#luotthich .like_url').attr('href','like/infopro/');
    ajax_list_like("like/infopro/", id_pro, 1, true, false);
  });

  //Follow shop
  $('body').on('click', '.is-follow-shop', function(){
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
            $('.is-follow-shop-'+id_user).html('<div class="btn"><span class="md"><img src="/templates/home/images/svg/dangtheodoi.svg" alt="Đang theo dõi" title="Đang theo dõi" style="width: 18px;height: 18px;"> Đang theo dõi</span><span class="sm"><img src="/templates/home/images/svg/dangtheodoi.svg" alt="Đang theo dõi" title="Đang theo dõi" style="width: 18px;height: 18px;"></span></div>');
            $('.is-follow-shop-'+id_user).attr('class','btn-follow-'+id_user+' cancel-follow-shop-'+id_user+' cancel-follow-shop');
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
            // $('.isFollow').addClass(' hidden');
            // $('.noFollow').removeClass(' hidden');
            // $('.theodoi').text('Theo dõi');
            $('.isFollow-'+id_user).removeClass(' hidden');
            $('.noFollow-'+id_user).addClass(' hidden');
            $('.theodoi').text('Theo dõi');
            $('.cancel-follow-shop-'+id_user).html('<div class="btn"><span class="md"><img src="/templates/home/styles/images/svg/theodoi.svg" alt="Theo dõi" title="Theo dõi" style="width: 18px;height: 18px;"> Theo dõi</span><span class="sm"><img src="/templates/home/styles/images/svg/theodoi.svg" alt="Theo dõi" title="Theo dõi" style="width: 18px;height: 18px;"></span></div>');
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

  function ajax_list_like(link, id_content, pape, modal, button) {
    jQuery.ajax({
          type: "POST",
          url: siteUrl + link + id_content + '/' + pape,
          dataType: 'json',
          data: {},
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
            if(res.data.length > 0){
              $.each(res.data, function( key_link, value_link ) {
                var template = $('#js-list-user-like').html();
                if (value_link.avatar == '') {
                  value_link.avatar = 'default-avatar.png';
                }
                template = template.replace(/{{USER_ID}}/g, value_link.user_id);
                template = template.replace(/{{AVATAR}}/g, value_link.avatar);
                template = template.replace(/{{NAME}}/g, value_link.use_username);
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
                      template = template.replace(/{{BTN_FOLLOW}}/g, 'js-cancelfollow-user');
                      template = template.replace(/{{HAS_FOLLOW}}/g, 'show');
                      template = template.replace(/{{PEND_FOLLOW}}/g, '');
                      template = template.replace(/{{NO_FOLLOW}}/g, '');
                      template = template.replace(/{{IS_FOLLOW}}/g, '');
                    }
                  }
                }else{
                  if(res.user != value_link.user_id){
                      //ket ban
                      template = template.replace(/{{BTN_FOLLOW}}/g, 'js-follow-user');
                      template = template.replace(/{{HAS_FOLLOW}}/g, '');
                      template = template.replace(/{{PEND_FOLLOW}}/g, '');
                      template = template.replace(/{{NO_FOLLOW}}/g, 'show');
                      template = template.replace(/{{IS_FOLLOW}}/g, '');
                    }
                }
                $('.js-show-like-user').append(template);
              });
            }
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
  })

  $('.js-show-more-loadding').on('click', function() {
    var $this = $(this);
    var page = parseInt($(this).attr('data-page')) + 1;
    var id_content = parseInt($(this).attr('data-id'));
    var url = $('#luotthich a.like_url').attr('href');
    $this.button('loading');
    ajax_list_like(url, id_content, page, false, $this);
  });
});

</script>