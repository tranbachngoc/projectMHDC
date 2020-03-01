<?php 
// dd($shop_current->shop_url);die;
?>
<div class="row">
  <div class="col-xl-9 col-md-7 col-sm-12">
    <div class="trangphu-left">
      <div class="slider-verticalSwiping">
        <div id="jssor_1" class="jssor-style">
          <!-- Loading Screen -->
          <div data-u="loading" class="jssorl-009-spin jssor-style-loading">
            <img class="jssor-style-loading-img" src="/templates/home/styles/plugins/jssor_slider/img/spin.svg" />
          </div>
          <div data-u="slides" class="jssor-style-slides">
            <?php if (!empty($list_bran)) {
              $path_banner_default = '/templates/home/styles/images/cover/cover_me.jpg';
              foreach ($list_bran as $key => $item) { ?>
            <div>
              <img data-u="image"
                src="<?=!empty($item->sho_banner) ? $this->config->item('banner_shop_config')['cloud_server_show_path'] . '/' .$item->sho_dir_banner.'/'.$item->sho_banner : $path_banner_default  ?>"
                onerror="error_image_banner(this)"/>
              <div data-u="thumb">
                <span class="ti two-lines"><?=$item->sho_name?></span>
                <br />
                <span class="d"><?=$item->sho_descr?></span>
              </div>
              <div class="show-text">
                <a href="<?=$shop_current->shop_url .'page-business/' . $item->use_id; ?>" class="see-page">Xem trang&nbsp;
                  <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                </a>
                <div class="title two-lines"><?=$item->sho_name?></div>
                <div class="address one-line">
                  <img src="/templates/home/styles/images/svg/map_white.svg" class="mr10" alt=""><?=$item->sho_address ? $item->sho_address : 'Chưa cập nhật.'?>
                </div>
              </div>
            </div>
            <?php } }?>
          </div>
          <!-- Thumbnail Navigator -->
          <div data-u="thumbnavigator" class="jssort121 jssor-style-thumbnavigator" style="" data-autocenter="2" data-scale-left="0.75">
            <div data-u="slides">
              <div data-u="prototype" class="p" style="width:268px;height:68px;">
                <div data-u="thumbnailtemplate" class="t"></div>
              </div>
            </div>
          </div>
          <!-- Bullet Navigator -->
          <!-- <div data-u="navigator" class="jssorb111" style="position:absolute;bottom:12px;right:12px;" data-scale="0.5">
                        <div data-u="prototype" class="i" style="width:24px;height:24px;font-size:12px;line-height:24px;">
                            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:-1;">
                                <circle class="b" cx="8000" cy="8000" r="3000"></circle>
                            </svg>
                            <div data-u="numbertemplate" class="n"></div>
                        </div>
                    </div> -->
        </div>
      </div>
      <div class="list-brands-address row">
        <?php 
        if (!empty($list_bran)) {
          foreach ($list_bran as $key => $branch) {
            $this->load->view('shop/branch/element/home_item-branch', ['item'=>$branch]);
          }
        }
        ?>
      </div>
    </div>
  </div>
  <?php
  // dd($siteGlobal);
  $info_public_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
  if($siteGlobal->sho_dir_logo && $siteGlobal->sho_logo){
    $info_public_avatar_path = $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' .$siteGlobal->sho_dir_logo.'/'.$siteGlobal->sho_logo;
  }
  ?>
  <div class="col-xl-3 col-md-5 col-sm-12">
    <div class="sidebar w100pc">
      <div class="gianhangcuaban">
        <div class="gianhangcuaban-soluong">
          <p>Gian hàng của bạn</p>
          <!-- <p>2</p> -->
        </div>
        <div class="gianhangcuaban-shopcuatoi">
          <div class="avata">
            <img src="<?=$info_public_avatar_path?>" alt="">
          </div>
          <div class="info">
            <h3>Shop của tôi</h3>
            <p class="tinnhan">
              <span>Tin nhắn</span>
              <span class="number">12</span>
            </p>
            <p class="thongbao">
              <span>Thông báo</span>
              <span class="number">6</span>
            </p>
            <p class="thongbao">
              <span>Đang online</span>
              <span class="number">6</span>
            </p>
          </div>
        </div>
        <div class="gianhangcuaban-luottheodoi">
          <p>Lượt theo dõi</p>
          <p class="is-active">Lượt Xem</p>
          <p>Bài Viết</p>
        </div>
        <div class="gianhangcuaban-luotthich hidden">
          <p>
            <span>21.890</span>
            <br>158 lượt thích tuần này</p>
        </div>
        <div class="gianhangcuaban-luotthich gianhangcuaban-luotxem">
          <p class="text-left">1 tháng 1 - 7 tháng 1</p>
          <div class="xem-tuongtac">
            <div class="luotxem">
              <span>100</span>
              <br>Lượt xem trang
            </div>
            <div class="tuongtac">
              <span>200</span>
              <br>Lượt tương tác
            </div>
          </div>
        </div>
        <div class="gianhangcuaban-luotthich gianhangcuaban-luotxem hidden">
          <p class="text-left">1 tháng 1 - 7 tháng 1</p>
          <div class="xem-tuongtac">
            <div class="luotxem">
              <span>100</span>
              <br>Bình luận
            </div>
            <div class="tuongtac">
              <span>200</span>
              <br>Lượt chia sẻ
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="nguoi-theo-doi">
        <div class="tit" data-toggle="modal" data-target="#luotthich">
          Người theo dõi
          <span class="number">667</span>
        </div>
        <ul class="info">
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/mi.svg" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/nikon.jpg" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/oppo.png" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/mi.svg" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/nikon.jpg" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/oppo.png" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
        </ul>
      </div> -->
      <!-- <div class="nguoi-theo-doi">
        <div class="tit" data-toggle="modal" data-target="#luotthich">
          Đang theo dõi
          <span class="number">667</span>
        </div>
        <ul class="info">
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/mi.svg" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/nikon.jpg" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/oppo.png" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/mi.svg" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/nikon.jpg" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
          <li>
            <div class="avata-shop">
              <a href="">
                <img src="/templates/home/styles/images/product/avata/oppo.png" alt="">
              </a>
            </div>
            <div class="name-shop">tên shopabc</div>
          </li>
        </ul>
      </div> -->
      <div class="link-to-other">
        <p class="mb10">
          <a href="">
            <img src="/templates/home/styles/images/svg/instagram.svg" alt="">
          </a>
          <a href="">
            <img src="/templates/home/styles/images/svg/facebook.svg" alt="">
          </a>
          <a href="">
            <img src="/templates/home/styles/images/svg/google.svg" alt="">
          </a>
          <a href="">
            <img src="/templates/home/styles/images/svg/twister.svg" alt="">
          </a>
        </p>
        <p>
          <a href="">Trang công ty </a>
          <a href="">Hướng dẫn</a>
          <a href="">Chính sách</a>
          <a href="">Lợi ích</a>
          <a href="">Điều khoản</a>
          <a href="">Liên hệ</a>
          <a href="">Azibai © 2018</a>
        </p>
      </div>
    </div>
  </div>
</div>

<script src="/templates/home/styles/plugins/jssor_slider/js/jssor.slider-27.5.0.min.js"></script>
<script src="/templates/home/styles/plugins/jssor_slider/js/jssor_slider.js"></script>
<script type="text/javascript">jssor_1_slider_init();</script>