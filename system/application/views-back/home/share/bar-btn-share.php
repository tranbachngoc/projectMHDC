<?php
if(isset($data_share)){
if ($data_share['layout_share'] == 'content') { ?>
<!-- // Start nút share trang chủ -->
    <li class="share-click shr-content cursor-pointer" 
        data-toggle="modal"
        data-name="<?=$data_share['data_name']?>"
        data-value="<?=$data_share['data_value']?>"
        data-type="<?=$data_share['data_type']?>"
        data-item_id="<?=$data_share['data_item_id']?>"
        data-url_page="<?php echo $data_share['data_detail']; ?>"
        data-permission="<?=$data_share['data_permission']?>"
        data-type_imgvideo="<?=$data_share['data_type_imgvideo']?>"
        data-tag="<?=$data_share['data_tag']?>">
        <span><img class="icon-img" src="<?=$data_share['src_image']?>" alt="share"></span>
        <span class="md">Chia sẻ</span>
    </li>
<!-- // End nút share trang chủ-->
<?php }
} ?>

<?php
if(isset($data_shr) && $data_shr == 1)
{
  $version = '';
  if(isset($data_backwhite))
  {
    $version = 'version02';
  }else{
    if(isset($data_backblack))
    {
      $version = 'version01';
    }
  }
?>
<style type="text/css">
    .bg-gray-blue{
        width: 100%;
    }
    .bg-gray-blue ul li{
        width: auto !important;
    }
</style>
<div class="bg-gray-blue">
  <?php
  $style_bar = $style_iconlike = $style_iconcomment = $style_iconshare = 'display: none;';
  $text_like = 'Thích';
  if(!isset($data_class_countact)){
    $data_class_countact = '';
  }
  if((isset($data_numlike) && $data_numlike > 0) || (isset($data_numcomment) && $data_numcomment > 0) || (isset($data_numshare) && $data_numshare > 0))
  {
    $style_bar = '';
    if(isset($data_textlike)){
      $text_like = $data_textlike;
    }
    if(isset($data_numlike) && $data_numlike > 0)
    {
        $style_iconlike = '';
    }
    if(isset($data_numcomment) && $data_numcomment > 0)
    {
        $style_iconcomment = '';
    }
    if(isset($data_numshare) && $data_numshare > 0)
    {
        $style_iconshare = '';
    }
  }

  $permission = '';
  $type_share = '';

  if(isset($data_typeshare) && $data_typeshare != ''){
    $type_share = $data_typeshare;
    if($this->session->userdata('sessionUser'))
    {
      if(isset($data_user) && $data_user == $this->session->userdata('sessionUser'))
      {
        $permission = 1;
      }
    }
  }

  $type_link = '';
  if(isset($data_typelink) && $data_typelink != ''){
    $type_link = $data_typelink;
  }
  ?>
    <div class="show-number-action js-item-id js-item-id-<?= $data_id;?> <?php echo $version; ?> <?php echo $data_class_countact; ?>" style="<?php echo $style_bar; ?>" data-id="<?= $data_id;?>">
      <ul style="display: flex;">
        <li class="list-like-js-<?=$data_id;?><?=$data_classshow;?> cursor-pointer" data-id="<?= $data_id;?>"<?php echo $type_link; ?> style="<?php echo $style_iconlike; ?>">
          <img src="/templates/home/styles/images/svg/liked.svg" class="mr05" alt="">
          <span class="count-like js-count-like-<?=$data_id;?>"><?= $data_numlike;?></span>
        </li>
        <li class="cursor-pointer" style="<?php echo $style_iconcomment; ?>"><?= $data_numcomment;?> bình luận</li>
        <li class="js-list-share js-list-share-<?= $data_id;?> <?=$data_classshare;?> cursor-pointer" style="<?php echo $style_iconshare; ?>"><span class="total-share-img"><?= $data_numshare;?></span> lượt chia sẻ</li>
      </ul>
    </div>
    <div class="action">
      <div class="action-left show-number-action">
        <ul class="action-left-listaction version01">
            <?php
            if(isset($data_backwhite))
            {
            ?>
              <li class="like <?php echo $data_jsclass;?> cursor-pointer" data-id="<?=$data_id;?>"<?php echo $type_link; ?>>
                <?= $data_imglike;?>
                <span class="md color-gray14"><?php echo $text_like; ?></span>
              </li>
              <li class="comment">
                <img class="icon-img" src="/templates/home/styles/images/svg/comment.svg" alt="comment">
                <span class="md color-gray14">Bình luận</span>
              </li>
              <?php
              if(isset($data_lishare) && $data_lishare == 1)
              {
              ?>
                <li class="share-click" data-toggle="modal" data-value="<?php echo $data_url;?>" data-name="<?= $data_title;?>" data-type="<?php echo $type_share; ?>" data-item_id="<?=$data_id;?>" data-url_page="<?php echo $data_url; ?>" data-permission="<?php echo $permission; ?>" data-type_imgvideo="<?php echo $data_type; ?>" data-tag="<?php echo $data_tag; ?>">
                  <img class="icon-img" src="/templates/home/styles/images/svg/share.svg" alt="share">
                  <span class="md color-gray14">Chia sẻ</span>
                </li>
              <?php
              }

              if(isset($data_bookmark) && $data_bookmark == 1)
              {
              ?>
                <li class="pin-node-collection" data-key="<?= $data_id; ?>">
                  <?= $data_imgBookmark;?>
                  <span class="md color-gray14">Lưu</span>
                </li>
              <?php
              }
              ?>
              
            <?php
            }
            else
            {
                if(isset($data_backblack))
                {
                ?>
                  <li class="like <?php echo $data_jsclass;?> cursor-pointer" data-id="<?=$data_id;?>"<?php echo $type_link; ?>>
                    <?= $data_imglike;?>
                    <span class="md color-white"><?php echo $text_like; ?></span>
                  </li>
                  <li class="comment">
                    <img class="icon-img" src="/templates/home/styles/images/svg/comment_white.svg" alt="comment">
                    <span class="md color-white">Bình luận</span>
                  </li>
                <?php
                if(isset($data_lishare) && $data_lishare == 1)
                {
                ?>
                  <li class="share-click" data-toggle="modal" data-value="<?php echo $data_url;?>" data-name="<?= $data_title;?>" data-type="<?php echo $type_share; ?>" data-item_id="<?=$data_id;?>" data-url_page="<?php echo $data_url; ?>" data-permission="<?php echo $permission; ?>" data-type_imgvideo="<?php echo $data_type; ?>" data-tag="<?php echo $data_tag; ?>">
                    <img class="icon-img" src="/templates/home/styles/images/svg/share_01_white.svg" alt="share">
                    <span class="md color-white">Chia sẻ</span>
                  </li>
              <?php } ?>
                <li>
                  <img class="icon-img" src="/templates/home/styles/images/svg/bookmark_white.svg" alt="share">
                  <span class="md color-white">Lưu</span>
                </li>
            <?php
                }
            } ?>
        </ul>
      </div>
    </div>
  </div>
<div class="show-number-action">
    <ul class="sanpham-lienket"></ul>
</div>
<?php
}
?>