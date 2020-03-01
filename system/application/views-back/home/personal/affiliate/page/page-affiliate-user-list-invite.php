<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<div class="affiliate-category">
  <ul>
    <li class="<?=@$_REQUEST['affiliate'] == 'all' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/user?affiliate=all')?>">Tất cả (<span class="text-bold"><?=$data_aff['total']['all']?></span>)</a></li>
    <?php if(!in_array($user_aff_level, [2,3])) { ?>
      <li class="<?=@$_REQUEST['affiliate'] == '2' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/user?affiliate=2')?>">Tổng đại lý (<span class="text-bold"><?=$data_aff['total']['lv2']?></span>)</a></li>
    <?php } ?>
    <?php if(!in_array($user_aff_level, [3])) { ?>
      <li class="<?=@$_REQUEST['affiliate'] == '3' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/user?affiliate=3')?>">Đại lý (<span class="text-bold"><?=$data_aff['total']['lv3']?></span>)</a></li>
    <?php } ?>
    <li class="<?=@$_REQUEST['affiliate'] == '0' && @$_REQUEST['user_type'] == '2' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/user?affiliate=0&user_type=2')?>">Thành viên mới (<span class="text-bold"><?=$data_aff['total']['user_new']?></span>)</a></li>
    <li class="<?=@$_REQUEST['affiliate'] == '0' && @$_REQUEST['user_type'] == '1' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/user?affiliate=0&user_type=1')?>">Thành viên đã mua (<span class="text-bold"><?=$data_aff['total']['user_buy']?></span>)</a></li>
    <li class="<?=@$_REQUEST['affiliate'] == '0' && @$_REQUEST['user_type'] == '1' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/invite')?>">Lời mời cộng tác (<span class="text-bold"><?=count($aListInvite)?></span>)</a></li>
  </ul>
</div>
<div class="affiliate-content">
  <div class="affiliate-content-member">
    <div class="list-invite">
      <?php foreach ($aListInvite as $key => $user) { ?>
        <div class="invite-item">
          <div class="invite-item-inner">
            <div class="image">
              <img src="<?=$user['sAvatar']?>">
            </div>
            <div class="content">
              <h4><?=$user['sParentName']?></h4>
              <p><?=$user['sParentName']?> mời bạn vào hệ thống của họ</p>
              <div class="action">
                <button class="accept" data-id="<?=$user['id']?>">Chấp nhận</button>
                <button class="reject" data-id="<?=$user['id']?>">Từ chối</button>
              </div>
            </div>
            <div class="clear-invite"></div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<div class="modal" id="show_error">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">THÔNG BÁO LỖI</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="show-more-detail">
          
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  .list-invite {
  width: 100%;
  overflow: auto;
}
.invite-item {
  width: 33.33%;
  float: left;
  padding: 0px 10px;
}
.invite-item .invite-item-inner {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);
  border-radius: 5px;
  margin-top: 5px;
  margin-bottom: 5px;
}
.invite-item .image {
  width: 110px;
  height: 110px;
  float: left;
}
.invite-item .image img {
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
}
.main-content .invite-item .content {
  float: left;
  width: calc(100% - 110px);
  margin: 0px;
  padding: 10px;
}
.invite-item .content .action {
  margin-top: 5px;
}
.invite-item .content .accept {
  border: none;
  margin-right: 10px;
  background: #FF1678;
  color: #ffffff;
  border-radius: 5px;
  width: 80px;
  cursor: pointer;
}
.invite-item .content .reject {
  border: none;
  background: #F2F2F2;
  color: #000000;
  border-radius: 5px;
  width: 80px;
  cursor: pointer;
}
.clear-invite {
  clear: both;
}
</style>
<script type="text/javascript">
  jQuery(document).on('click','.accept', function() {
      var id = $(this).attr('data-id');
      $.ajax({
        url: siteUrl+"affiliate/inviterequest",
        data: {id: id, accept : 1},
        type: 'POST',
        dataType : 'json',
        success:function(res){
            if(res.type == 'error') {
              $('#show_error .show-more-detail').html('<p>'+res.message+'</p>');
              $('#show_error').modal('show');
            }else {
              location.reload();
            }
            
        }
    });
  });

  jQuery(document).on('click','.reject', function() {
      var id = $(this).attr('data-id');
      $.ajax({
        url: siteUrl+"affiliate/inviterequest",
        data: {id: id, accept : 0},
        type: 'POST',
        dataType : 'json',
        success:function(res){
            if(res.type == 'error') {
              $('#show_error .show-more-detail').html('<p>'+res.message+'</p>');
              $('#show_error').modal('show');
            }else {
              location.reload();
            }
            
        }
    });
  });
</script>