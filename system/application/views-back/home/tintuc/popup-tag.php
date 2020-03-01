<?php 
  $getListCate = sonlv::listCategory();
?>
<div class="popup-element">
  <div class="model-content" id="popup-tag">
    <div class="wrapp-model">
      <div class="content-model">
         <div class="contents popup-tag">
            <div class="btn-back js-back">
                <a href="#">
                  <img src="<?=base_url()?>templates/home/images/svg/close_black.svg">
                </a>
            </div>
            <div class="popup-tag-search">
                <div class="search">
                  <input type="text" class="tag-search" placeholder="Tìm kiếm sản phẩm">
                  <img src="<?=base_url()?>templates/home/images/svg/search.svg" alt="" class="button-tag-seach">
                </div>
            </div>
            <div class="popup-tag-content">
                <div class="popup-tag-content-left">
                  <div class="fromwhere">
                      <ul>
                        <li>
                          <label class="checkbox-style">
                            <input type="radio" name="fromwhere" class="choose-search-for" value="1" checked="checked">
                            <span>Của tôi</span>
                          </label>
                        </li>

                        <li>
                          <label class="checkbox-style">
                            <input type="radio" name="fromwhere" class="choose-search-for" value="2">
                            <span>Từ azibai</span>
                          </label>
                        </li>
                      </ul>
                  </div>
                  
                  <div class="list-danhmucsanpham for_azibai" data-type="0">
                      <div class="danhmucsanpham">
                          <h3 class="tit">Danh mục sản phẩm</h3>
                          <div class="danhmucsanpham-parent hidden">
                              <ul class="overflow">
                                <li data-id="-1"><p>Xem tất cả sản phẩm</p></li>
                                <?php 
                                  if (!empty($getListCate['product_azibai']))
                                  {
                                    foreach ($getListCate['product_azibai'] as $k_pro_cate => $v_pro_cate)
                                    {
                                      if (!empty($v_pro_cate->have_child)) {
                                        echo '<li class="danhmucsanpham-child" data-id="'.$v_pro_cate->cat_id.'">';
                                        echo '<p class="danhmucsanpham-child-title">'.trim($v_pro_cate->cat_name).'</p>';
                                        echo '<ul class="danhmucsanpham-child-content hidden"></ul></li>';
                                      } else {
                                        echo '<li data-id="'.$v_pro_cate->cat_id.'"><p>'.trim($v_pro_cate->cat_name).'</p></li>';
                                      }
                                    }
                                  }
                                ?>
                              </ul>
                          </div>
                      </div>
                  </div>
                  
                  <div class="list-danhmucsanpham for_azibai" data-type="2">
                      <div class="danhmucsanpham">
                          <h3 class="tit">Danh mục Coupon</h3>
                          <div class="danhmucsanpham-parent hidden">
                              <ul class="overflow">
                                <li data-id="-1"><p>Xem tất cả coupon</p></li>
                                <?php 
                                  if (!empty($getListCate['coupon_azibai']))
                                  {
                                    foreach ($getListCate['coupon_azibai'] as $k_pro_cate => $v_pro_cate)
                                    {
                                      if (!empty($v_pro_cate->have_child)) {
                                        echo '<li class="danhmucsanpham-child" data-id="'.$v_pro_cate->cat_id.'">';
                                        echo '<p class="danhmucsanpham-child-title">'.trim($v_pro_cate->cat_name).'</p>';
                                        echo '<ul class="danhmucsanpham-child-content hidden"></ul></li>';
                                      } else {
                                        echo '<li data-id="'.$v_pro_cate->cat_id.'"><p>'.trim($v_pro_cate->cat_name).'</p></li>';
                                      }
                                    }
                                  }
                                ?>
                              </ul>
                          </div>
                      </div>
                  </div>

                  
                  <div class="list-danhmucsanpham for_me" data-type="0">
                      <div class="danhmucsanpham">
                          <h3 class="tit">Danh mục sản phẩm</h3>
                          <div class="danhmucsanpham-parent hidden">
                              <ul class="overflow">
                                  <li data-id="-1" class="menu-active">
                                    <p>Xem tất cả sản phẩm</p>
                                  </li>
                                  <?php 
                                    if (!empty($getListCate['category_user']))
                                    {
                                      foreach ($getListCate['category_user'] as $k_pro_cate => $v_pro_cate)
                                      {
                                        if ($v_pro_cate->cate_type == 0)
                                        {
                                            if (!empty($v_pro_cate->have_child)) {
                                              echo '<li class="danhmucsanpham-child" data-id="'.$v_pro_cate->cat_id.'">';
                                              echo '<p class="danhmucsanpham-child-title">'.trim($v_pro_cate->cat_name).'</p>';
                                              echo '<ul class="danhmucsanpham-child-content hidden"></ul></li>';
                                            } else {
                                              echo '<li data-id="'.$v_pro_cate->cat_id.'"><p>'.trim($v_pro_cate->cat_name).'</p></li>';
                                            }
                                        }
                                      }
                                    }
                                  ?>                                  
                              </ul>
                          </div>
                      </div>
                  </div>
                  
                  <div class="list-danhmucsanpham for_me" data-type="2">
                      <div class="danhmucsanpham">
                          <h3 class="tit">Danh mục Coupon</h3>
                          <div class="danhmucsanpham-parent hidden">
                              <ul class="overflow">
                                  <li data-id="-1"><p>Xem tất cả coupon</p></li>
                                  <?php 
                                    if (!empty($getListCate['category_user']))
                                    {
                                      foreach ($getListCate['category_user'] as $k_pro_cate => $v_pro_cate)
                                      {
                                        if ($v_pro_cate->cate_type == 2)
                                        {
                                            if (!empty($v_pro_cate->have_child)) {
                                              echo '<li class="danhmucsanpham-child" data-id="'.$v_pro_cate->cat_id.'">';
                                              echo '<p class="danhmucsanpham-child-title">'.trim($v_pro_cate->cat_name).'</p>';
                                              echo '<ul class="danhmucsanpham-child-content hidden"></ul></li>';
                                            } else {
                                              echo '<li data-id="'.$v_pro_cate->cat_id.'"><p>'.trim($v_pro_cate->cat_name).'</p></li>';
                                            }
                                        }
                                      }
                                    }
                                  ?> 
                              </ul>
                          </div>
                      </div>
                  </div>

                </div>
                <div class="popup-tag-content-right">
                    <ul class="title-tabs">
                      <li class="list-product-choose is-active">Danh sách sản phẩm</li>
                      <li class="ajax-pro-choose">Sản phẩm đã chọn</li>
                      <li class="js-link-choose">Danh sách link</li>
                    </ul>
                    <div class="content-sanpham">
                      <div class="content-sanpham-items">
                        <div id="loader" class="hidden"><span></span></div>
                        <div class="scroll-div-product">
                          <ul class="ajax_product_tags" data-pape="1" data-ajax="true">
                              <?php 
                                if(!empty($getListCate['user_product'])) { 
                                  foreach ($getListCate['user_product'] as $k_user_pro => $v_user_pro){
                                    $this->load->view('home/product/ajax_html/item', array('v_user_pro' => $v_user_pro));
                                  } 
                                } 
                              ?>
                          </ul>
                        </div>
                      </div>
                      <div class="content-sanpham-items hidden">
                        <div class="div-pro-choose">
                          <ul class="list-pro-choose"></ul>
                        </div>
                      </div>
                      <div class="content-link content-sanpham-items hidden">
                          <form onsubmit="return false;">
                            <div class="chenlink">
                                <div class="nhaplink">
                                  <input type="url" id="link_tag_pt" placeholder="Chèn link">
                                </div>
                                <button class="btn-them" id="add_link_tag_pt">Thêm </button>
                            </div>
                          </form>
                          <div class="linkdachen">
                            <div class="div-link-choose">
                              <ul class="list-link-choose">
                                <?php for ($i=0; $i < 1; $i++) { ?>
                                <li>
                                    <div class="image">
                                      <img src="<?=base_url()?>frontend/asset/images/product/shop/img01.jpg" alt="">
                                      <span class="icon-chon">
                                        <img src="<?=base_url()?>templates/home/images/svg/xoa.svg" alt="">
                                      </span>
                                    </div>
                                    <div class="decs">
                                      <span>5 điện thoại bán chạy nhất năm 2018, bạn cần biết.</span>
                                      <br>
                                      <a href="https://www.w3schools.com/tags/att_a_target.asp" target="_blank">tintuconline.com.vn</a>
                                    </div>
                                </li>
                                <?php } ?>
                              </ul>
                            </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="popup-tag-lists-buttons">
              <button class="img-tag-remove btn-bg-white">Xóa tag</button>
              <button class="img-tag-save btn-bg-gray">Hoàn tất</button>
            </div>
         </div>
      </div>
    </div>
  </div>
  <div class="drawer-overlay drawer-toggle"></div>
</div>

<script id="js-link-demo-tag" type="text/template">
  <li>
      <div class="image remove-link-tag" data-index={{INDEX}}>
        <img src="{{IMAGE_LINK_TAG}}" alt="">
        <span class="icon-chon">
          <img src="<?=base_url()?>templates/home/images/svg/xoa.svg" alt="">
        </span>
      </div>
      <div class="decs">
        <span>{{TITLE_LINK_TAG}}</span>
        <br>
        <a href="{{LINK_TAG}}" target="_blank">{{DOMAIN_TAG}}</a>
      </div>
  </li>
</script>

