<?php 
$shop = [
  'sho_link'  => $item['shop_link'],
  'domain'    => $item['domain'],
];
$shop_url = shop_url($shop);
$url_redirect = '';
if($item['type'] == FILTER_CONTENT_COMPANY) {
  $url_redirect = $shop_url;
}
if($item['type'] == FILTER_CONTENT_PERSONAL) {
  $url_redirect = azibai_url().'/profile/'.$item['user_id'];
}
?>
<div class="item post">
  <div class="post-head">
    <div class="post-head-name">
      <div class="avata">
        <a href="<?=$url_redirect?>">
          <img src="<?=$item['user_image']?>" onerror="error_image(this)" alt="">
        </a>
      </div>
      <div class="title two-lines">
        <a class="one-line" href="<?=$url_redirect?>">
          <?=$item['user_fullname']?>
        </a>
        <div class="datetime">
          <span class="date">
            <?=date('d/m/Y',$item['timestamp'])?>
          </span>
          <span class="icon-eye">
            <img src="/templates/home/styles/images/svg/eye_gray.svg" class="mr05 ml10" alt="">
            <?=$item['article_view']?>
          </span>
        </div>
      </div>
    </div>
    <div class="post-head-more">
      <span class="mr10">
        <!-- <img src="/templates/home/styles/images/svg/comment_3dot.svg" alt=""> -->
      </span>
      <span class="icon-3dot" data-toggle="modal" data-target="#myModal">
        <!-- <img src="/templates/home/styles/images/svg/3dot_doc.svg" height="24" alt="more"> -->
      </span>
    </div>
  </div>
  <div class="post-body">
    <div class="image">
      <img src="<?=$item['article_image']?>" onerror="error_image(this)" alt="">
    </div>
    <div class="text">
      <h4 class="two-lines">
        <a href="<?=azibai_url('/tintuc/detail/').$item['article_id'].'/'.RemoveSign($item['article_title'])?>">
          <?=trim($item['article_title']) . ' ' . strip_tags($item['article_detail']);?>
        </a>
      </h4>
      <!-- <p class="text-right text-red mt20 finance">Được tài trợ</p> -->
    </div>
  </div>
</div>