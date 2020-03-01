<?php
if($this->session->userdata('sessionAfKey')) {
  $af_key = '?af_id='.$this->session->userdata('sessionAfKey');
}
if(!empty($_REQUEST['af_id'])) {
  $af_key = '?af_id='.$_REQUEST['af_id'];
}
?>
<div class="coupondisplay-category">
  <a class="item" href="<?=base_url()."library/vouchers".$af_key?>">Tất cả</a>
  <a class="item" href="<?=base_url()."library/vouchers/type/0".$af_key?>">Mới nhất</a>
  <a class="item" href="<?=base_url()."library/vouchers/type/1".$af_key?>">Bán chạy</a>
  <a class="item filter" href="#coupondisplayFilter" data-toggle="modal"><img src="/templates/home/styles/images/svg/filter.svg" class="mr05">Bộ lọc</a>
</div>
<div class="coupondisplay-content">
  <div class="coupondisplay-content-banner">
    <div class="js-coupondisplay-banner">
      <div class="items">
        <img src="/templates/home/styles/images/product/sanazibai/banner01.jpg" alt="">
      </div>
      <div class="items">
        <img src="/templates/home/styles/images/product/sanazibai/banner02.jpg" alt="">
      </div>
      <div class="items">
        <img src="/templates/home/styles/images/product/sanazibai/banner03.jpg" alt="">
      </div>
    </div>
  </div>

  <div class="coupondisplay-content-item">
    <div class="tit">
      <h3 class="sub-tt one-line">Tìm kiếm</h3>
    </div>
    <div class="detail">
      <div class="row">
        <?php foreach ($aAll as $key => $item) {
          $this->load->view('shop/media/elements/voucher-item', ["item"=>$item], FALSE);
        }?>
      </div>
    </div>
  </div>

  <?=$pagination_html?>
</div>

<?php $this->load->view('shop/media/popups/popup-filter-voucher', $data, FALSE);?>
<?php $this->load->view('home/product/popup/popup-payment-voucher');?>

<script type="text/javascript">
 $(document).ready(function() {
   function setBoundries(slick, state) {
     if (state === 'default') {
       slick.find('ul.slick-dots li').eq(2).addClass('n-small-1');
     }
   }

   // Slick Selector.
   var slickSlider = $('.js-coupondisplay-banner');
   var maxDots = 3;
   var transformXIntervalNext = -18;
   var transformXIntervalPrev = 18;

   slickSlider.on('init', function (event, slick) {

     console.log(number);
     $(this).find('ul.slick-dots').wrap("<div class='slick-dots-container'></div>");
     $(this).find('ul.slick-dots li').each(function (index) {
       $(this).addClass('dot-index-' + index);
     });
     $(this).find('ul.slick-dots').css('transform', 'translateX(0)');
     setBoundries($(this),'default');
     var number = $(this).find('ul.slick-dots li').length;
     if (number <= 2) {
        $(this).find('.slick-dots-container').addClass("lessthanfour");
     }
   });

   var transformCount = 0;
   slickSlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
     var totalCount = $(this).find('.slick-dots li').length;
     if (totalCount > maxDots) {
       if (nextSlide > currentSlide) {
         if ($(this).find('ul.slick-dots li.dot-index-' + nextSlide).hasClass('n-small-1')) {
           if (!$(this).find('ul.slick-dots li:last-child').hasClass('n-small-1')) {
             transformCount = transformCount + transformXIntervalNext;
             $(this).find('ul.slick-dots li.dot-index-' + nextSlide).removeClass('n-small-1');
             var nextSlidePlusOne = nextSlide + 1;
             $(this).find('ul.slick-dots li.dot-index-' + nextSlidePlusOne).addClass('n-small-1');
             $(this).find('ul.slick-dots').css('transform', 'translateX(' + transformCount + 'px)');
             var pPointer = nextSlide - 1;
             var pPointerMinusOne = pPointer - 1;
             $(this).find('ul.slick-dots li').eq(pPointerMinusOne).removeClass('p-small-1');
             $(this).find('ul.slick-dots li').eq(pPointer).addClass('p-small-1');
           }
         }
       }
       else {
         if ($(this).find('ul.slick-dots li.dot-index-' + nextSlide).hasClass('p-small-1')) {
           if (!$(this).find('ul.slick-dots li:first-child').hasClass('p-small-1')) {
             transformCount = transformCount + transformXIntervalPrev;
             $(this).find('ul.slick-dots li.dot-index-' + nextSlide).removeClass('p-small-1');
             var nextSlidePlusOne = nextSlide - 1;
             $(this).find('ul.slick-dots li.dot-index-' + nextSlidePlusOne).addClass('p-small-1');
             $(this).find('ul.slick-dots').css('transform', 'translateX(' + transformCount + 'px)');
             var nPointer = currentSlide + 1;
             var nPointerMinusOne = nPointer - 1;
             $(this).find('ul.slick-dots li').eq(nPointer).removeClass('n-small-1');
             $(this).find('ul.slick-dots li').eq(nPointerMinusOne).addClass('n-small-1');
           }
         }
       }
     }
   });

   $('.js-coupondisplay-banner').slick({
     slidesToShow: 1,
     slidesToScroll: 1,
     dots: true,
     focusOnSelect: true,
     infinite: false,
     arrows: false
   });
 });
</script>