<style type="text/css">
.pendFriend {
    /*border: 1px solid #8a8e8b;*/
    color: #8a8e8b;
}
.confirmFriend {
    border: 1px solid #0904fb;
    color: #0904fb;
    text-align: center;
}
.pendFriend, .confirmFriend {
    border-radius: 5px;
    /*width: 104px;*/
    padding: 5px;
}
.nofriend, .hasfriend, .pendFriend, .confirmFriend{
  display: none !important;
}
.show{
  display: block !important;
}
.nofriend.show, .hasfriend.show{
  display: -webkit-flex !important;
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
        <div class="listfriends-content show-more-detail show-detail-user">
          <div class="block js-show-like-user">
          </div>
        </div>
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
    <div class="detail">
      <div class="item" style="width: 100%">
        <div class="avatar">
          <a target="_blank" href="{{PROFILE_URL}}" class="flex-between-center">
            <div class="nickname">
              <div class="img"><img src="<?php echo DOMAIN_CLOUDSERVER ?>/media/images/avatar/{{USER_ID}}/{{AVATAR}}" alt=""></div>
            </div>
          </a>
        </div>
        <div class="info">
          <div class="left">
            <div class="name">
              <a target="_blank" href="{{PROFILE_URL}}" class="flex-between-center">{{NAME}}</a>
            </div>
          </div>
          <div class="right">
            <div class="buttons btn-friend btn-friend-{{USER_ID}} {{BTN_FOLLOW}}" data-id="{{USER_ID}}" data-name="{{NAME}}">
              <div class="md">
                <div class="cursor-pointer btn nofriend {{NO_FOLLOW}}" title="Gửi lời mời kết bạn">
                  <img class="nofriend-{{USER_ID}}" src="/templates/home/styles/images/svg/ketban.svg" alt="" title="Gửi lời mời kết bạn"><span class="text"> Kết bạn</span>
                </div>
                <div class="cursor-pointer btn hasfriend {{HAS_FOLLOW}}" title="Hủy bạn">
                  <img class="hasfriend-{{USER_ID}}" src="/templates/home/styles/images/svg/banbe.svg" alt="" title="Hủy bạn"><span class="text"> Bạn bè</span>
                </div>
                <div class="pendFriend-{{USER_ID}} pendFriend {{PEND_FOLLOW}}" title="Đã gửi yêu cầu">
                  <img class="" src="/templates/home/styles/images/svg/daguiloimoi.svg" alt="" title="Đã gửi yêu cầu">
                  <span class="text">Đã gửi yêu cầu</span>
                </div>
                <div class="cursor-pointer confirmFriend-{{USER_ID}} confirmFriend {{IS_FOLLOW}}" title="Đồng ý kết bạn">Xác nhận</div>
              </div>
              <div class="sm">
                <img class="cursor-pointer nofriend-{{USER_ID}} nofriend {{NO_FOLLOW}}" src="/templates/home/styles/images/svg/ketban.svg" alt="" title="Gửi lời mời kết bạn">
                <img class="cursor-pointer hasfriend-{{USER_ID}} hasfriend {{HAS_FOLLOW}}" src="/templates/home/styles/images/svg/banbe.svg" alt="" title="Hủy bạn">
                <div class="pendFriend-{{USER_ID}} pendFriend {{PEND_FOLLOW}}" title="Đã gửi yêu cầu">
                  <img class="" src="/templates/home/styles/images/svg/daguiloimoi.svg" alt="" title="Đã gửi yêu cầu">
                </div>
                <div class="cursor-pointer confirmFriend-{{USER_ID}} confirmFriend {{IS_FOLLOW}}" title="Đồng ý kết bạn">Xác nhận</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
});
</script>
<script src="/templates/home/styles/js/friend-follow.js"></script>