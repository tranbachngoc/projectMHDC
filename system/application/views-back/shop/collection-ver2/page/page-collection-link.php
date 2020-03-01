<div class="bosuutap-header">
  <div class="collection-btn-add createCollection">
    <img src="/templates/home/styles/images/svg/add_circle_white.svg" class="mr10" alt="">Thêm BST liên kết
  </div>
  <div class="collection-input-search">
    <input type="text" class="form-control" placeholder="Tìm bộ sưu tập">
    <img src="/templates/home/styles/images/svg/search.svg" alt="">
  </div>
  <div class="collection-action">
    <div class="filter" data-toggle="modal" data-target="#modalFilter">
      <!-- <img src="/templates/home/styles/images/svg/filter.svg" alt=""> -->
    </div>
    <div class="xem-dang-danh-sach">
      <img src="/templates/home/styles/images/svg/xemluoi_off.svg" alt="">
    </div>
  </div>
</div>
<div class="bosuutap-content">
  <div class="bosuutap-tabbosuutap-xemluoi append-box">
    <?php foreach ($items as $key => $item) {
      $this->load->view('shop/collection-ver2/element/item-collection-link', ['item' => $item, 'link_categories_p' => $link_categories_p, 'shop_url' => $shop_url], FALSE);
    }?>
  </div>
</div>
</div>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="/templates/home/darkroomjs/css/darkroom.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/darkroomjs/js/fabric.js"></script>
<script src="/templates/home/darkroomjs/js/darkroom.js"></script>

<?php $this->load->view('shop/collection-ver2/popup/popup-collection-link', ['link_categories_p' => $link_categories_p, 'shop_url' => $shop_url]);?>
<?php $this->load->view('shop/collection-ver2/popup/popup-collection-link-filter-category', ['link_categories_p' => $link_categories_p, 'shop_url' => $shop_url]);?>
<?php $this->load->view('shop/collection-ver2/popup/popup-collection-link-menu-item');?>

<?php if($is_next == true) { ?>
<script>
  var is_busy = false;
  var last_id = "<?=end($items)['id']?>";
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
        data: {last_id: last_id},
        success: function (result) {
          $loadding.addClass('hidden');
          if(result.html == '') {
            stopped = true;
          }
          if(result.html != ''){
            var $content = $(result.html);
            $('.append-box').append($content);
            last_id = result.last_id;
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