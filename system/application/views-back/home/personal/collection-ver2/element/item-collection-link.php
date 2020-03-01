<div class="item">
  <div class="image">
    <a href="<?=$profile_url . 'collection/link/'. $item['id']?>">
      <ul class="many-image <?=$item['count_link'] <= 1 ? 'one-image' : '' ?>">
        <li class="img-danhsach">
          <img src="<?=$item['avatar_path_full']?>" alt="" onerror="error_image(this)">
        </li>

        <?php if($item['count_link'] == 0) { ?>
        <li>
          <img src="<?=$item['avatar_path_full']?>" alt="" onerror="error_image(this)">
        </li>
        <?php } ?>

        <?php if($item['count_link'] == 1) { ?>
        <li>
          <img src="<?=$item['links'][0]['full_image_path'] ? $item['links'][0]['full_image_path'] : $item['links'][0]['image']?>" alt="" onerror="error_image(this)">
        </li>
        <?php } ?>

        <?php if($item['count_link'] > 1) { ?>
          <?php foreach ($item['links'] as $key => $link) { ?>
            <li>
              <img src="<?=$link['full_image_path'] ? $link['full_image_path'] : $link['image']?>" alt="" onerror="error_image(this)">
            </li>
          <?php } ?>
          <?php for ($i=0; $i < 4 - count($item['links']) ; $i++) { ?>
            <li>
              <img src="" alt="" onerror="error_image(this)">
            </li>
          <?php } ?>
        <?php } ?>
      </ul>
    </a>
    <?php if($this->session->userData('sessionUser') == $item['user_id']) { ?>
    <div class="edit-icon js-menu-open-user"
      data-user_id="<?=$item['user_id']?>"
      data-id="<?=$item['id']?>"
      data-name="<?=$item['name']?>"
      data-description="<?=$item['description']?>"
      data-avatar-path="<?=$item['avatar_path']?>"
      data-avatar-full="<?=$item['avatar_path_full']?>"
      data-cate_id="<?=$item['cate_id']?>"
      data-is_personal="<?=$item['sho_id'] > 0 ? 0 : 1?>"
      data-isPublic="<?=$item['isPublic']?>">
      <img src="/templates/home/styles/images/svg/pen.svg" alt="">
    </div>
    <?php }?>
    <?php if($item['isPublic'] == 0) {?>
    <div class="lock-icon">
      <img src="/templates/home/styles/images/svg/lock_white.svg" alt="">
    </div>
    <?php }?>
  </div>
  <div class="descript">
    <a href="javascript:void(0)" class="infor">
      <img src="<?=$item['shop']['sho_logo_full']?>" onerror="error_image(this)" alt="" class="avata">
      <div class="name">
        <h3 class="two-lines"><?=$item['name'] . ' ' . $item['description']?></h3>
        <span class="one-line"><?=$item['count_link']?> mục <?=$item['cate_id'] > 0 ? '- '.$link_categories[$item['cate_id']]['name'] : ''?></span>
      </div>
    </a>
    <?php if($this->session->userData('sessionUser') != $item['user_id']) {?>
    <div class="button-chinh-sua js-menu-open-user"
      data-user_id="<?=$item['user_id']?>"
      data-id="<?=$item['id']?>">
      <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="">
    </div>
    <?php } ?>
  </div>
</div>