<?php
$this->load->view('home/common/header_new');
$group_id = (int) $this->session->userdata('sessionGroup');
$user_id = (int) $this->session->userdata('sessionUser');
?>
<!-- <link href="/templates/home/css/azinews.css" type="text/css" rel="stylesheet" /> -->
<!-- <link href="/templates/engine1/style.css" type="text/css" rel="stylesheet" /> -->
<script src="/templates/home/js/home_news.js"></script>
<!-- <link href="/templates/home/owlcarousel/owl.carousel.min.css" rel="stylesheet" type="text/css" /> -->
<script src="/templates/home/owlcarousel/owl.carousel.js"></script>
<script src="/templates/home/darkroomjs/js/fabric.js"></script>
<link href="/templates/home/darkroomjs/css/darkroom.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/darkroomjs/js/darkroom.js"></script>
<script src="/templates/home/js/jquery.countdown.min.js"></script>
<script type="text/javascript" src="/templates/engine1/wowslider.js"></script>
<script type="text/javascript" src="/templates/engine1/script.js"></script>
<link href="/templates/home/css/addnews.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/js/addnews.js"></script>

    <main>      
      <section class="main-content">
        <div class="container clearfix">
          <div class="sidebar md">
            <?php $this->load->view('home/common/left_tintuc'); ?>
            <?php $this->load->view('home/common/ads_right'); ?>
          </div>
          <div class="content">
            <?php if($this->session->userdata('sessionUser')) { ?>
            
            <div class="blockdangtin">
            <?php $this->load->view('home/tintuc/dangtin', array()); ?>
                        
              <!-- <div class="blockdangtin-buttontaobaiviet">
                <p class="taobaiviet is-active">Tạo bài viết</p>
                <p>Tạo album</p>
              </div>
              <div class="blockdangtin-nhaptin">
                <textarea class="bandangnghigi" name="" id="" placeholder="Bạn đang nghĩ gì?"></textarea>
              </div>
              <div class="blockdangtin-dangtinby">
                <button><img src="/templates/home/images/svg/video.svg" alt="Video">Video</button>
                <button><img src="/templates/home/images/svg/camera.svg" alt="Anh">Ảnh</button>
                <button><img src="/templates/home/images/svg/chuyenmuc.svg" alt="Video">Chuyên mục</button>
                <button class="more"><img src="/templates/home/images/svg/3dot.svg" alt=""></button>
              </div> -->
            </div>
            <?php } ?>          
            <ul class="listtabtitle">
              <li class="is-active">Tin tức</li>
              <li>Doanh nghiệp</li>
              <li>Bạn bè</li>
            </ul>
            <div class="categories">
              <p class="suggest">Gợi ý theo dõi</p>
              <ul class="categories-items">
                <li class="add item">
                  <a href="#"><div class="icon"><img src="/templates/home/images/svg/add.svg" alt="add"></div></a>
                </li>
              <?php   
              $i = 0;
              $list_icons = array(
                '/templates/home/images/svg/goiy_dienthoaivienthong.svg',
                '/templates/home/images/svg/goiy_maytinhlinhkien.svg',
                '/templates/home/images/svg/goiy_dientudienmay.svg',
                '/templates/home/images/svg/goiy_thoitrangphukien.svg',
                '/templates/home/images/svg/goiy_mayanhmayquay.svg',
                '/templates/home/images/svg/goiy_suckhoelamdep.svg',
                '/templates/home/images/svg/goiy_mebe.svg',
                '/templates/home/images/svg/goiy_otoxemay.svg',
                '/templates/home/images/svg/goiy_dodungsinhhoat.svg',
                '/templates/home/images/svg/goiy_noithatngoaithat.svg',
                '/templates/home/images/svg/goiy_thethao.svg',
                '/templates/home/images/svg/goiy_thucphamdouong.svg',
                '/templates/home/images/svg/goiy_sachvanphong.svg',
                '/templates/home/images/svg/goiy_congnghiepxaydung.svg',
                '/templates/home/images/svg/goiy_nonglamngunghiep.svg',
                '/templates/home/images/svg/goiy_dichvuit.svg',
                '/templates/home/images/svg/goiy_anuong.svg',
                '/templates/home/images/svg/goiy_suckhoelamdep.svg',
                '/templates/home/images/svg/goiy_gamedochoi.svg',
                '/templates/home/images/svg/goiy_giaoducdaotao.svg',
                '/templates/home/images/svg/goiy_chothue.svg',
                '/templates/home/images/svg/goiy_dichvutochuctiec.svg',
                '/templates/home/images/svg/goiy_dichvutuvan.svg',
                '/templates/home/images/svg/goiy_dichvuphaply.svg',
                '/templates/home/images/svg/goiy_dichvuvesinh.svg',
                '/templates/home/images/svg/goiy_dulichkhachsan.svg',
                '/templates/home/images/svg/goiy_inanthietke.svg',
                '/templates/home/images/svg/goiy_dichvuthoitrang.svg',
                '/templates/home/images/svg/goiy_tuyendung.svg',
                '/templates/home/images/svg/goiy_xuatnhapkhau.svg',
                '/templates/home/images/svg/goiy_dichvuyte.svg',
                '/templates/home/images/svg/goiy_dichvusangtacnghethuat.svg',
                '/templates/home/images/svg/goiy_dichvutruyenthongtruyenhinh.svg',
                '/templates/home/images/svg/goiy_quangcaosukien.svg',
                '/templates/home/images/svg/goiy_dichvuvantaivanchuyen.svg',
                '/templates/home/images/svg/goiy_taichinhtiente.svg',
                '/templates/home/images/svg/goiy_batdongsan.svg',
                '/templates/home/images/svg/goiy_dichvukhac.svg',
                
                '/templates/home/images/svg/goiy_bachhoaonline.svg',
                '/templates/home/images/svg/goiy_thietbigiadung.svg',
              );
			    foreach ($productCategoryRoot as $k => $category) :
            if ($category->cate_type == 2) {
                ?>
                <li class="item">
              <a href="<?php echo '/tintuc/category/' . $category->cat_id . "/" . RemoveSign($category->cat_name); ?>">
                        <div class="icon"><img src="<?php echo $list_icons[$i] ;?>" alt="<?php echo $category->cat_name; ?>"></div>    
                        <span><?php echo $category->cat_name; ?></span>
              </a>
                </li>
                <?php $i++;
            }
			    endforeach;
			    ?>
              </ul>
            </div>
            <!-- test -->
            <!-- <div id="content" class="newfeeds" data-type="<?php //echo $this->uri->segment(2); ?>">                                       -->
            <div class="content-posts" id="content" data-type="<?php echo $this->uri->segment(2); ?>">
            <?php if(count($listcategory) > 0) { ?>
            <?php foreach ($listcategory as $key => $item) { 
            $item->key = $key;
               $this->load->view('home/tintuc/item', array('item' => $item));
            } ?>
            <?php } else { ?>
                <strong>Thông báo:</strong> Danh mục tin này chưa có tin tức nào
            <?php } ?>
            </div>


            <!-- test -->
          </div>
        </div>
      </section>
      
    </main>
    
  </div>
  <script src="/templates/home/styles/js/common.js"></script>
  <script src="/templates/home/styles/js/slick.js"></script>
  <script src="/templates/home/styles/js/slick-slider.js"></script>
  <!-- <script src="/templates/home/js/jquery.countdown.min.js"></script>  -->
  <script src="/templates/home/js/countdown.js"></script>
  <script src="/templates/home/js/jquery-scrolltofixed.js"></script>
  <script src="/templates/home/fixed_sidebar.js"></script>
  <script src="/templates/home/popup_dangtin.js"></script>

  <script src="/templates/home/js/jAlert-master/jAlert-v3.min.js"></script>
  <script src="/templates/home/js/general_ver2.js"></script>
  <script>
    function copylink(link) { clipboard.copy(link); }
    jQuery(function () {        
        // scroll load more data
        var is_busy = false;
        var page = 1;
        var stopped = false;
        $(window).scroll(function() 
        {
            console.log('11111111111111111111111111');
            $element = $('#content');
            $loadding = $('#loadding');
            if($(window).scrollTop() + $(window).height() >= $element.height() - 200) 
            {
                if (is_busy == true){
                    return false;
                }
                if (stopped == true){
                    return false;
                }
                is_busy = true;
                page++;

                $.ajax(
                {
                    type        : 'post',
                    dataType    : 'text',
                    url         : '/home/tintuc/getmoreindex',
                    data        : {page : page, type: $element.attr('data-type')},

                    success     : function (result)
                    {  
                        if(result == '')
                        {
                            stopped = true;
                            $loadding.addClass('hidden');
                        }
                        $element.append(result);  
                        $('.rowpro .owl-carousel').owlCarousel({ loop: false, margin: 5, nav: true, dots: false, responsive: { 0:{ items:1 }, 600:{ items:2 } } });
                        $('[data-countdown]').each(function() { var $this = $(this), finalDate = $(this).data('countdown'); $this.countdown(finalDate, function(event) { $this.html(event.strftime('%D ngày %H:%M:%S')); }); });
                        var itempost = $('.embed-responsive');
                        var tolerancePixel = -100;            
                        function checkMedia() {
                            var scrollTop = $(window).scrollTop() - 170;
                            var scrollBottom = $(window).scrollTop() + $(window).height() + 100;
                            itempost.each(function (index, el) {
                                var yTopMedia = $(this).offset().top;
                                var yBottomMedia = $(this).height() + yTopMedia;
                                if (scrollTop < yBottomMedia && scrollBottom > yTopMedia) {
                                    $(this).find("video").trigger("play");
                                } else {
                                    $(this).find("video").trigger("pause");
                                }
                            });

                        }
                        
                        $(document).on('scroll', checkMedia);
                        $('.lazy').lazy();
                        
                    }
                })
                .always(function()
                { 
                    is_busy = false;
                });
                return false;
            }
        });

        $('.fixtoscroll').scrollToFixed({ marginTop: function () { var marginTop = $(window).height() - $(this).outerHeight(true) - 0; if (marginTop >= 0) return 75; return marginTop; }, limit: function () { var limit = 0; limit = $('#footer').offset().top - $(this).outerHeight(true) - 0; return limit; } });
        $('.rowpro .owl-carousel').owlCarousel({ loop: false, margin: 5, nav: true, dots: false, responsive: { 0:{ items:1 }, 600:{ items:2 } } });
        $('[data-countdown]').each(function() { var $this = $(this), finalDate = $(this).data('countdown'); $this.countdown(finalDate, function(event) { $this.html(event.strftime('%D ngày %H:%M:%S')); }); });
        var itempost = $('.embed-responsive');
        var tolerancePixel = -100;            
        function checkMedia() {
            var scrollTop = $(window).scrollTop() - 170;
            var scrollBottom = $(window).scrollTop() + $(window).height() + 100;
            itempost.each(function (index, el) {
                var yTopMedia = $(this).offset().top;
                var yBottomMedia = $(this).height() + yTopMedia;
                if (scrollTop < yBottomMedia && scrollBottom > yTopMedia) {
                    $(this).find("video").trigger("play");
                } else {
                    $(this).find("video").trigger("pause");
                }
            });
        }
        $(document).on('scroll', checkMedia);
        $('.lazy').lazy();	
    });
  </script>
<?php //$this->load->view('home/common/footer', array('oloadding'=>true)); ?>
