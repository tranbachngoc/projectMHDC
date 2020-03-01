<?php
if(!empty($listuser['user'])){
  foreach ($listuser['alpha'] as $key_alpha => $alpha)
  {
?>
  <div class="block">
    <div class="alpha"><?php echo $alpha->Alpha; ?></div>
    <div class="detail">
      <?php
      foreach ($listuser['user'] as $key_user => $user)
      {
        if(strtoupper($alpha->Alpha) == strtoupper($user->Alpha))
        {
          $img_friend = '';
          if($user->use_id != $this->session->userdata('sessionUser'))
          {
            if($user->isblock == 0)
            {
              $key = array_search($user->use_id,$list_friends_user_id);
              if($key !== false){
                  $friends_accept = $friends_accept_user;
              }
              else{
                  $key = array_search($user->use_id,$list_friends_addby);
                  $friends_accept = $friends_accept_addby;
              }
              if($key !== false && $friends_accept[$key] == 1){
                $img_friend = '<div class="btn btn-friend unfriend btn-friend-'.$user->use_id.' " data-id="'.$user->use_id.'" data-name="'.$user->use_fullname.'"><img class="hasfriend-'.$user->use_id.' hasfriend show" src="/templates/home/styles/images/svg/banbe.svg" alt="" title="Hủy bạn"><span> Bạn bè</span></div>';
              }else{
                if($key !== false){
                  if(array_search($user->use_id,$list_friends_user_id) !== false){
                    $img_friend = '<div class="btn btn-friend"><img class="" src="/templates/home/styles/images/svg/daguiloimoi.svg" alt="" title="Đã gửi yêu cầu kết bạn"><span>Đã gửi yêu cầu</span></div>';
                  }
                  else{
                    $img_friend = '<div class="btn btn-follow-'.$user->use_id.' js-confirmfollow-user" data-id="'.$user->use_id.'"  title="Xác nhận bạn bè"><span>Xác nhận</span></div>';
                  }
                }
                else{
                  $img_friend = '<div class="btn btn-friend-'.$user->use_id.' js-follow-user-profile" data-id="'.$user->use_id.'"><img class="nofriend-'.$user->use_id.' nofriend show" src="/templates/home/styles/images/svg/ketban.svg" alt="" title="Kết bạn"><span>Kết bạn</span></div>';
                }
              }
            }
            else{
              $img_friend = '<div class="btn cancel-block cancel-block-'.$user->use_id.'" data-id="'.$user->use_id.'" data-name="'.$user->use_fullname.'"><img class="" src="/templates/home/styles/images/svg/bochan.svg" alt="" title="Bỏ chặn"><span>Bỏ chặn</span></div>';
            }
          }
      ?>
        <div class="item item-<?php echo $user->use_id; ?>">
          <div class="avata">
            <img src="<?php echo DOMAIN_CLOUDSERVER.'media/images/avatar/'.$user->use_id.'/'.$user->avatar; ?>" alt="">
          </div>
          <div class="info">
            <div class="left">
              <a href="<?php echo base_url().'profile/'.$user->use_id; ?>"><?php echo $user->use_fullname; ?></a>
              <?php
              if($this->session->userdata('sessionUser')){
                if($user->use_id != $this->session->userdata('sessionUser')){
              ?>
              <span class="number <?php echo count($user->list_offriend) > 0 ? 'js-list-offriend cursor-pointer' : ''; ?>" data="<?php echo json_encode($user->list_offriend); ?>" data-id="<?php echo $user->use_id; ?>"><?php echo count($user->list_offriend);?> bạn chung</span>
              <?php
              }
              else{
              ?>
                <p class="small">(Tôi)</p>
              <?php
                }
              }
              ?>
            </div>
            <?php
            if($this->session->userdata('sessionUser') && $user->use_id != $this->session->userdata('sessionUser')){
            ?>
            <div class="right">
              <?php echo $img_friend;?>
              <?php
              if($user->isblock == 0)
              {
              ?>
              <p class="cursor-pointer"><img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="" data-toggle="modal" class="actfriend" data-id="<?php echo $user->use_id;?>" data-name="<?php echo $user->use_fullname;?>"></p>
              <?php
              }
              ?>
            </div>
          <?php } ?>
          </div>
        </div>
    <?php
      }
    }
    ?>
    </div>
  </div>
<?php
  }
}else{
  echo 'Chưa có dữ liệu';
}
?>