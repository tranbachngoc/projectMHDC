<style type="text/css">
.listfriends-tabs .left .bosuutap-header-tabs-content li{
  padding: 8px 0 0 0;
}
li.list-invite {
  position: relative;
}
span.numcount {
  right: -10px;
  top: 35%;
}
.bosuutap-header-tabs-content li {
  margin-right: 30px;
}
.search .autocompletebox-content-body .item .img img{
  position: unset;
  width: 100%;
}
</style>
<div class="listfriends">
    <div class="listfriends-title">
      <img src="/templates/home/styles/images/svg/friend.svg" class="mr10" alt="">
      Bạn bè
    </div>
    <div class="listfriends-tabs">
      <div class="left">
        <div class="bosuutap-header-tabs">
          <ul class="bosuutap-header-tabs-content">
            <?php
            if($this->session->userdata('sessionUser') && ($this->session->userdata('sessionUser') == $current_profile['use_id']))
            {
              $act_int = '';
              if($type == 'invitation'){
                $act_int = 'active';
              }
              $url_invitation = $current_profile['profile_url'] . 'friends/invitation';
              $list_invitation = '<li class="list-invite '.$act_int.'"><a href="'.$url_invitation.'">Lời mời kết bạn';
              if($count_invitation > 0){
                $list_invitation .= '<span class="numcount">'.$count_invitation.'</span>';
              }
              $list_invitation .= '</a></li>';
              $act_inst = '';
              if($type == 'insistence'){
                $act_inst = 'active';
              }
              $url_insistence = $current_profile['profile_url'] . 'friends/insistence';
              $list_insistence = '<li class="'.$act_inst.'"><a href="'.$url_insistence.'">Đã gửi yêu cầu</a></li>';
            }else{
            }
            ?>
            <li class="<?php echo ($type == '') ? 'active' : ''; ?>">
                <a href="<?php echo $current_profile['profile_url'] . 'friends'; ?>">Tất cả bạn bè</a>
            </li>
            <?php
            if(isset($list_invitation) && isset($list_insistence)){
              echo $list_invitation;
              echo $list_insistence;
            }
            ?>
            <?php
            if($this->session->userdata('sessionUser'))
            {
              if($this->session->userdata('sessionUser') != $current_profile['use_id']){
            ?>
            <li class="<?php echo ($type == 'offriend') ? 'active' : ''; ?>">
              <a href="<?php echo $current_profile['profile_url'] . 'friends/offriend'; ?>">Bạn chung</a>
            </li>
              <?php
              }
            }
            ?>
            <li class="<?php echo ($type == 'follow') ? 'active' : ''; ?>"><a href="<?php echo $current_profile['profile_url'] . 'friends/follow'; ?>">Người theo dõi</a></li>
            <?php
            if($this->session->userdata('sessionUser') == $current_profile['use_id']){
            ?>
            <li class="<?php echo ($type == 'isfollow') ? 'active' : ''; ?>"><a href="<?php echo $current_profile['profile_url'] . 'friends/isfollow'; ?>">Đang theo dõi</a></li>
            <li class="<?php echo ($type == 'priofollow') ? 'active' : ''; ?>"><a href="<?php echo $current_profile['profile_url'] . 'friends/priofollow'; ?>">Ưu tiên theo dõi</a></li>
            <li class="<?php echo ($type == 'listblock') ? 'active' : ''; ?>"><a href="<?php echo $current_profile['profile_url'] . 'friends/listblock'; ?>">Danh sách chặn</a></li>
          <?php } ?>
          </ul>
        </div>
      </div>
      <div class="right">
        <div class="search">
          <form class="form-search" method="get" action="<?php echo $info_public['profile_url'].'list-search-user' ?>">
            <input type="text" name="keyword" placeholder="Tìm kiếm bạn bè" value="<?php if($this->input->post('keyword')) echo $this->input->post('keyword'); ?>" required>
            <img src="/templates/home/styles/images/svg/search.svg" alt="">
          </form>
          <div class="autocompletebox-content">
            <div class="autocompletebox-content-item">
              <div class="autocompletebox-content-body js-dataArticle">
                <h3 class="tit">Tìm bạn bè</h3>
                <div class="box-user"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="listfriends-content <?php echo ($type == 'priofollow') ? 'page-priofollow' : ''; ?>">
      <?php $this->load->view('home/personal/elements/friends') ?>
    </div>
</div>
<div class="modal mess-bg" id="actfriend">
  <div class="modal-dialog modal-dialog-center modal-lg modal-mess  ">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <ul class="show-more-detail">
          
        </ul>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('form.form-search input').on('keyup', function(){
    $('.search .autocompletebox-content').addClass('autocompletebox-content-show');
    var keyword = $(this).val();
    $(this).autocomplete({
      source: function( request, response )
      {
        $.ajax({
          url: siteUrl+'search-user',
          data:{keyword: keyword},
          type: 'post',
          dataType: 'json',
          success: function(results)
          {
            var temp_search = '';
            var result = results.data;
            $(result).each(function(at, item){
              temp_search += '<div class="items">';
                temp_search += '<a class="item" href="'+siteUrl+'profile/'+item.user_id+'" target="_blank">';
                  temp_search += '<div class="img">';
                  temp_search += '<img src="'+item.user_image+'">';
                  temp_search += '</div>';
                  temp_search += '<div class="text">';
                    temp_search += '<h4 class="one-line">'+item.user_fullname+'</h4>';
                    temp_search += '<p class="one-line">'+item.user_address+'</p>';
                  temp_search += '</div>';
                temp_search += '</a>';
              temp_search += '</div>';
            });
            $('.box-user').html(temp_search);
          }
        });
      }
    });
  });

  $(document).ready(function()
  {
    var $win = $(window);
    var $box = $(".listfriends-tabs .right");
    $win.on("click.Bst", function(event){
      console.log(event);
      if ($box.has(event.target).length == 0 && !$box.is(event.target)){
        $('.search .autocompletebox-content').removeClass('autocompletebox-content-show');
      }
    });
  });
</script>