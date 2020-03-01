<?php
if($info_public['website'] != '') {
  $url_javascript = $info_public['profile_url'];
} else {
  $actual_link = get_current_full_url();
  $url_javascript = get_current_base_url($actual_link) . '/';
}
?>
<div class="collection-detail-header">
  <div class="bosuutap-header">
    <div class="button-back">
      <a href="<?=$info_public['profile_url'] . 'collection/link'?>">
        <img class="mr10" src="/templates/home/styles/images/svg/prev_bold.svg" alt=""> Quay lại</a>
    </div>
  </div>
  <div class="collection-detail-title">
    <div class="name">
      <div class="left">
        <h3 class="tit one-line"><?=$collection['name']?></h3>
        <span class="number one-line"><?=$collection['total']?> mục </span>
      </div>
      <div class="right">
        <ul>
          <?php if($this->session->userData('sessionUser') == $collection['user_id']) { ?>
          <li class="pu-add-custom-link">
            <a href="javascript:void(0)">
              <img src="/templates/home/styles/images/svg/add_circle_black02.svg" alt="">
            </a>
          </li>
          <li class="editCollection"
            data-id="<?=$collection['id']?>"
            data-name="<?=$collection['name']?>"
            data-description="<?=$collection['description']?>"
            data-avatar-path="<?=$collection['avatar_path']?>"
            data-avatar-full="<?=$collection['avatar_path_full']?>"
            data-cate_id="<?=$collection['cate_id']?>"
            data-is_personal="<?=$collection['sho_id'] > 0 ? 0 : 1?>"
            data-isPublic="<?=$collection['isPublic']?>">
            <a href="javascript:void(0)">
              <img src="/templates/home/styles/images/svg/pen_black.svg" alt="">
            </a>
          </li>
          <?php } ?>
          <?php if($collection['isPublic'] == 0) { ?>
          <li>
            <a href="javascript:void(0)">
              <img src="/templates/home/styles/images/svg/okhoa_gray.svg" alt="">
            </a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="decript">
      <?=$collection['description']?>
    </div>
  </div>
  <div class="group-show-like-share">
    <div class="show-number-action version02">
      <ul>
        <li data-toggle="modal" data-target="#luotthich">
          <img src="/templates/home/styles/images/svg/liked.svg" class="mr05" alt=""><?=$like?></li>
        <li><?=$share?> bình luận</span>
        </li>
        <li><?=$comment?> chia sẻ</span>
        </li>
      </ul>
    </div>
    <div class="action">
      <div class="action-left">
        <ul class="action-left-listaction">
          <li class="like">
            <img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like">
            <span class="md">Thích</span>
          </li>
          <li class="comment">
            <img class="icon-img" src="/templates/home/styles/images/svg/comment.svg" alt="comment">
            <span class="md">Bình luận</span>
          </li>
          <!-- <li class="share-click"> -->
          <li class="">
            <span>
              <img class="icon-img" src="/templates/home/styles/images/svg/share.svg" alt="share">
              <span class="md">Chia sẻ</</span>
          </li>
          <li>
            <img src="/templates/home/styles/images/svg/bookmark.svg" alt="">
            <span class="md">Lưu</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="bosuutap-header mt20">
    <div class="collection-input-search ml00 w100pc">
      <input type="text" class="form-control" placeholder="Tìm kiếm mục đã lưu...">
      <img src="/templates/home/styles/images/svg/search.svg" alt="">
    </div>
  </div>
  <div class="sm mb20">
    <div class="list-icons-grid">
      <span class="js-see-haftwidth mr10">
        <img src="/templates/home/styles/images/svg/xemluoi_white_on.svg" alt="">
      </span>
      <span class="js-see-fullwidth">
        <img src="/templates/home/styles/images/svg/danhsach_off.svg" alt="">
      </span>
    </div>
  </div>
</div>
<div class="grid haftwidth append-box">
  <?php foreach ($items as $key => $item) {
    $this->load->view('home/personal/collection-ver2/element/item-collection-link-detail', ['item'=>$item, 'profile_url' => $info_public['profile_url']], FALSE);
  } ?>
</div>

<?php $this->load->view('home/personal/collection-ver2/popup/popup-collection-link', ['link_categories_p' => $link_categories_p, 'profile_url' => $info_public['profile_url'], 'url_javascript' => $url_javascript]);?>
<?php $this->load->view('home/personal/collection-ver2/popup/popup-collection-link-add-new-link',
  [
  'popup_list_collection'=>$popup_list_collection,
  'cate_id'=>$collection['cate_id'],
  'c_id'=>$collection['id'],
  'is_personal'=>1,
  'link_categories_p'=>$link_categories_p,
  'link_categories_ch'=>$link_categories_ch,
  'profile_url' => $info_public['profile_url'],
  'url_javascript' => $url_javascript
  ])?>
<?php $this->load->view('home/personal/collection-ver2/popup/popup-collection-detail-link-menu-item', ['url_javascript' => $url_javascript]);?>
<?php $this->load->view('home/personal/collection-ver2/popup/popup-collection-link-edit-new-link',
  [
  'popup_list_collection'=>$popup_list_collection,
  'cate_id'=>$collection['cate_id'],
  'c_id'=>$collection['id'],
  'is_personal'=>1,
  'is_public'=>$collection['isPublic'],
  'link_categories_p'=>$link_categories_p,
  'link_categories_ch'=>$link_categories_ch,
  'profile_url' => $info_public['profile_url'],
  'user_id' => $collection['user_id'],
  'url_javascript' => $url_javascript
  ]);?>
<?php if($user_id != (int)$this->session->userData('sessionUser')) {
  $this->load->view('home/personal/collection-ver2/popup/popup-collection-link-clone',
  [
  'popup_list_collection'=>$popup_list_collection,
  'cate_id'=>$collection['cate_id'],
  'c_id'=>$collection['id'],
  'is_personal'=>1,
  'is_public'=>$collection['isPublic'],
  'link_categories_p'=>$link_categories_p,
  'link_categories_ch'=>$link_categories_ch,
  'profile_url' => $info_public['profile_url'],
  'user_id' => $collection['user_id'],
  'url_javascript' => $url_javascript
  ]);
}?>

<script>
  var masonryOptions = {
    itemSelector: '.item',
    horizontalOrder: true
  }
  var $grid = $('.grid').masonry( masonryOptions );
  $grid.imagesLoaded().progress( function() {
    $grid.masonry('layout');
  });

  $('.js-see-haftwidth').on( 'click', function() { 
    $grid.masonry('destroy');
    $('.liet-ke-hinh-anh').find('.grid').removeClass('fullwidth');  
    $(this).find('img').attr("src","/templates/home/styles/images/svg/xemluoi_white_on.svg");
    $('.js-see-fullwidth').find('img').attr("src","/templates/home/styles/images/svg/danhsach_off.svg");        
    $('.js-see-youtubelayer').find('img').attr("src","/templates/home/styles/images/svg/xemlietke_off.svg");
    $('.collection-version02').find('.main-content').addClass('bg-purple-black');
    $grid.masonry( masonryOptions );
  });
  $('.js-see-fullwidth').click(function() {
    $grid.masonry('destroy');          
    $('body').find('.grid').addClass('fullwidth');
    $('.liet-ke-hinh-anh').find('.grid').removeClass('youtubelayer');
    $(this).find('img').attr("src","/templates/home/styles/images/svg/danhsach_on.svg");
    $('.js-see-haftwidth').find('img').attr("src","/templates/home/styles/images/svg/xemluoi_off.svg");        
    $('.js-see-youtubelayer').find('img').attr("src","/templates/home/styles/images/svg/xemlietke_off.svg");  
    // $('.js-slider-tag-column').unslick();
    $('.collection-version02').find('.main-content').removeClass('bg-purple-black');
  });

</script>

<?php if($is_next == true) { ?>
<script>
  var is_busy = false;
  var last_created_at = "<?=end($items)['created_at']?>";
  var stopped = false;
  $(window).scroll(function(event) {
    $element = $('.wrapper');
    $loadding = $('#loadding-more');
    if($(window).scrollTop() + $(window).height() >= $element.height() - 200) {
      if (is_busy == true){
        event.stopPropagation();
        return false;
      }
      if (stopped == true){
        event.stopPropagation();
        return false;
      }
      $loadding.removeClass('hidden');
      is_busy = true;

      $.ajax({
        type: 'post',
        dataType: 'json',
        url: window.location.href,
        data: {last_created_at: last_created_at},
        success: function (result) {
          $loadding.addClass('hidden');
          if(result.html == '') {
            stopped = true;
          }
          if(result.html != ''){
            var $content = $(result.html);
            $grid.append( $content ).masonry('appended', $content);
            $grid.imagesLoaded().progress( function() {
              $grid.masonry('layout');
            });
            last_created_at = result.last_created_at;
          }
        }
      }).always(function() {
        is_busy = false;
      });
      return false;
    }
  });
</script>
<?php } ?>