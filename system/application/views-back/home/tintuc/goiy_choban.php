<?php if( in_array($suggest['key'], ["friends","many_friends","mutual_friends"]) && !empty($suggest['data']) ) { ?>
  <div class="sugget-addfriend <?="page-{$page}"?>">
    <div class="sugget-addfriend-title">
      <p>Gợi ý kết bạn</p>
      <p>
        <a href="<?="#popupSuggetAddfriend_{$suggest['key']}"?>" data-toggle="modal" onclick="loadSuggestData('<?=$suggest['key']?>'); this.onclick=null;">Xem tất cả</a>
      </p>
    </div>
    <div class="sugget-addfriend-content">
      <div class="slider lazy sugget-addfriend-content-items js-suggest-<?=$suggest['key']?> js-slider-suggest" id="lazy_01">
      <?php foreach ($suggest['data'] as $key => $item) {
        $site = profile_url($item);
        ?>
        <div class="item js-item">
          <span class="close-goiy"
          data-id="<?=$item['use_id']?>"
          onclick="remove_suggest_friend(this, true, event)">
            <img src="/templates/home/styles/images/svg/close03.svg" alt="">
          </span>
          <a href="javascript:void(0)">
            <div class="avata"><a href="<?=$site?>" target="_blank">
              <img src="<?=$item['full_avatar']?>" alt="">
            </a></div>
            <div class="name-shop one-line">
              <a href="<?=$site?>" target="_blank"><?=$item['use_fullname']?></a>
              <br>
              <?=$item['mutual-friends'] > 0 ? "<span>{$item['mutual-friends']} bạn chung</span>" : ""?>
            </div>
          </a>
          <button class="btn-add <?="js_{$suggest['key']}_{$item['use_id']}"?>"
          data-id="<?=$item['use_id']?>"
          data-name_js="<?=".js_{$suggest['key']}_{$item['use_id']}"?>"
          data-is_send="0"
          data-img_cancel="/templates/home/styles/images/svg/huyketban.svg"
          data-img_accept="/templates/home/styles/images/svg/ketban_white.svg"
          onclick="send_request_friend(this, event)">
            <img src="/templates/home/styles/images/svg/ketban_white.svg" class="icon js-img" alt=""><span class="js-text">Kết bạn</span>
          </button>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
  <script>
    $('.js-suggest-<?=$suggest['key']?>').slick({
      slidesToShow: 3,
      slidesToScroll: 3,
      infinite: false,
      arrows: true,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2.2,
            slidesToScroll: 2,
            arrows: false,
          }
        }
      ]
    });
  </script>
  <div class="modal <?="popupSuggetAddfriend_{$suggest['key']}"?>" id="<?="popupSuggetAddfriend_{$suggest['key']}"?>">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Gợi ý kết bạn</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="popup-sugget-addfriend">
            <!-- <div class="item">
              <a href="javascript:void(0)" class="avata">
                <img src="/templates/home/styles/images/hinhanh/01.jpg" alt="">
              </a>
              <div class="name">
                <div class="tt">
                  <h3 class="one-line">Tên demo ... </h3>
                  <div class="small-tt">34 bạn chung</div>
                </div>
                <div class="group-btn">
                  <a class="btn-addfriend"><img src="/templates/home/styles/images/svg/ketban_white.svg" class="mr10">Kết bạn</a>
                  <a class="btn-delete">Xóa</a>
                </div>
              </div>
            </div> -->
          </div>
        </div>

      </div>
    </div>
  </div>
<?php } ?>

<?php if( in_array($suggest['key'], ["shop_follow","shop_follow_better"]) && !empty($suggest['data']) ) { 
  $_id_null = '';
  ?>
  <div class="sugget-follow <?="page-{$page}"?>">
    <div class="sugget-follow-title">
      <p>Gợi ý theo dõi</p>
      <p>
        <a href="<?="#popupSuggetFollow_{$_id_null}"?>" data-toggle="modal" onclick="loadSuggestData('<?=$suggest['key']?>'); this.onclick=null;">Xem tất cả</a>
      </p>
    </div>
    <div class="sugget-follow-content js-suggest-<?=$suggest['key']?> js-slider-suggest">
    <?php foreach ($suggest['data'] as $key => $item) {
      $sho_introduction = strip_tags(html_entity_decode($item['sho_introduction']));
      $site = shop_url($item);
      ?>
      <div class="item js-item">
        <span class="close-goiy"
        data-id="<?=$item['sho_id']?>"
        onclick="remove_suggest_shop(this, true, event)">
          <img src="/templates/home/styles/images/svg/close03.svg">
        </span>
        <a class="banner" href="<?=$site?>" target="_blank">
          <img class="avata" src="<?=$item['sho_logo_full']?>">
          <img class="cover" src="<?=$item['sho_banner_full']?>">
        </a>
        <div class="text">
          <div class="tit">
            <h3 class="one-line"><a href="<?=$site?>" target="_blank"><?=$item['sho_name']?></a></h3>
            <button class="btn-follow <?="js_{$_id_null}_{$item['sho_id']}"?>"
            data-id="<?=$item['sho_id']?>"
            data-name_js="<?=".js_{$_id_null}_{$item['sho_id']}"?>"
            data-is_send="0"
            data-img_cancel="/templates/home/styles/images/svg/dangtheodoi.svg"
            data-img_accept="/templates/home/styles/images/svg/theodoi_white.svg"
            onclick="send_request_shop(this, event)">
              <img src="/templates/home/styles/images/svg/theodoi_white.svg" class="mr10 js-img"><span class="js-text">Theo dõi</span></button>
          </div>
          <?=!empty($sho_introduction) ? "<div class='txt two-lines'>{$sho_introduction}</div>" : ""?>
        </div>
      </div>
    <?php } ?>
    </div>
  </div>
  <script>
    $('.js-suggest-<?=$suggest['key']?>').slick({
      slidesToShow: 1.5,
      slidesToScroll: 1,
      infinite: false,
      arrows: true,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1.1,
            slidesToScroll: 1,
            arrows: false,
          }
        }
      ]
    });
  </script>
  <div class="modal <?="popupSuggetFollow_{$_id_null}"?>" id="<?="popupSuggetFollow_{$_id_null}"?>">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Gợi ý theo dõi</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="sugget-follow-content popupSuggetFollow-content">
            <!-- <div class="item">
              <span class="close-goiy"><img src="asset/images/svg/close03.svg"></span>
              <a class="banner">
                <img class="avata" src="asset/images/hinhanh/01.jpg">
                <img class="cover" src="asset/images/hinhanh/02.jpg">
              </a>
              <div class="text">
                <div class="tit">
                  <h3 class="two-lines">Du lịch</h3>
                  <a href="" class="btn-follow"><img src="asset/images/svg/theodoi_white.svg" class="mr10">Theo dõi</a>
                </div>
                <div class="txt two-lines">Text demo thong tin giới thiệu doanh nghiệp Text demo thong tin giới thiệu doanh nghiệp nghiệp... </div>
              </div>
            </div> -->
          </div>
        </div>

      </div>
    </div>
  </div>
<?php } ?>