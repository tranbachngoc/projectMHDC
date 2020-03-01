<div class="item">
  <div class="group">
    <div class="group-left">
      <div class="avata">
        <a href="<?=azibai_url().'/profile/'.$item['user_id']?>">
          <img src="<?=$item['user_image']?>" onerror="error_image(this)" alt="">
        </a>
      </div>
      <div class="name">
        <h4 class="two-lines"><a href="<?=azibai_url().'/profile/'.$item['user_id']?>"><?=$item['user_fullname']?></a></h4>
        <p class="text-small">
          <a href="<?=azibai_url().'/profile/'.$item['user_id']?>"><?=azibai_url().'/profile/'.$item['user_id']?></a>
          <br><?=$item['name_province'] ? $item['name_province'].', ' : ''?> <?=$item['count_follow'].' người theo dõi'?></p>
      </div>
    </div>
    <div class="group-right">
      <?php if($this->session->userdata('sessionUser')) { ?>
      <span class="favorite">
        <!-- <img src="<?=$item['isFriend'] == 0 ? '/templates/home/styles/images/svg/2user.svg' 
        : ($item['isFriend'] == 1 ? '/templates/home/styles/images/svg/huyketban.svg' 
        : (in_array($item['isFriend'], [2,3]) ? '/templates/home/styles/images/svg/dagoiloimoiketban.svg' : ''))?>" alt=""> -->
      </span>
      <?php } ?>
      <span class="icon-3dot">
        <!-- <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt=""> -->
      </span>
    </div>
  </div>
  <!-- <div class="financed">Được tài trợ</div> -->
</div>