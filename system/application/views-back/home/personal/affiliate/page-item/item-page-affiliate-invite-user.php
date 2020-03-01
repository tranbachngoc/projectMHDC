<li class="js-filter-item" data-search="<?=$oFriend['use_fullname']?>">
  <div class="listfriends-name">
    <div class="avata">
      <img src="<?=$oFriend['avatar']?>" onerror="error_image_avatar(this)" alt="">
    </div>
    <div class="tit one-line">
      <?=$oFriend['use_fullname']?>
    </div>
  </div>
  <a class="btn-invite invitefriend" data-id="<?=$oFriend['use_id']?>">Mời</a>
</li>