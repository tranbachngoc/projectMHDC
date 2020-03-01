<!-- LOAD breadcrumb -->
<div class="shop-breadcrumb">
  <a href="<?=azibai_url()?>">Trang chủ azibai</a>
  <?php if($category['categoryRoot']->cate_type == 0) {?>
    <a href="<?=azibai_url('/shop/products'.($af_id != '' ? "?af_id=$af_id" : ""))?>" class="ml10">
      <img src="/templates/home/styles/images/svg/next.svg" width="10" class="mt05" alt="">&nbsp; sản phẩm</a>
  <?php } else if($category['categoryRoot']->cate_type == 2) {?>
    <a href="<?=azibai_url('/shop/coupons'.($af_id != '' ? "?af_id=$af_id" : ""))?>" class="ml10">
      <img src="/templates/home/styles/images/svg/next.svg" width="10" class="mt05" alt="">&nbsp; coupon</a>
  <?php }?>
  <?php foreach ($category['categoryBcrum'] as $key => $value) { ?>
    <?php if($key != 0) { 
      if($value['cat_id'] != '') {?>
      <a href="<?=azibai_url('/'.$value['cat_id'].'/'.RemoveSign($value['cat_name']).($af_id != '' ? "?af_id=$af_id" : ""))?>" class="ml10">
        <img src="/templates/home/styles/images/svg/next.svg" width="10" class="mt05" alt="">&nbsp; <?=$value['cat_name']?></a>
    <?php } } else { ?>
    <p class="ml10">
      <img src="/templates/home/styles/images/svg/next.svg" width="10" class="mt05" alt="">&nbsp; <?=$value['cat_name']?></p>
    <?php } ?>
  <?php } ?>
</div>
<!-- END LOAD breadcrumb -->

<!-- LOAD submenu + Filter-->
<div class="row">
  <div class="col-md-3">
    <!-- LOAD submenu -->
    <div class="catalogue">
      <div class="catalogue-tit md">
        <img src="/templates/home/styles/images/svg/danhmucsp.svg" alt="">Danh mục sản phẩm</div>
      <div class="catalogue-detail">
        <p class="is-active">
          <a href="javascript:void(0)"><?=$category['categoryRoot']->cat_name?></a>
        </p>
        <?php if(!empty($category['categorySub'])){
          foreach ($category['categorySub'] as $key => $item) { ?>
        <p class="">
          <a href="<?=azibai_url().'/'.$item->cat_id.'/'.RemoveSign($item->cat_name).($af_id != '' ? "?af_id=$af_id" : "")?>"><?=$item->cat_name?></a>
        </p>
        <?php }
        }?>
      </div>
    </div>
    <!-- END LOAD submenu -->

    <!-- Load filter -->
    <div class="show-filter-sort-sm">
      <ul class="show-filter-sort-menu sm">
        <li class="is-active">
          <img src="/templates/home/styles/images/svg/boloctimkiem_white.svg" class="mr05" alt="">Bộ lọc
          <img src="/templates/home/styles/images/svg/down_1.svg" width="10" class="ml05" alt="">
        </li>
        <li class="js-filter-sort">
          <select class="style-select-box sort-item" name="select-sort" id="">
            <option value="date-new" <?=$filter['sort'] == 'date-new' ? 'selected' : ''?>>Mới nhất</option>
            <option value="date-old" <?=$filter['sort'] == 'date-old' ? 'selected' : ''?>>Cũ nhất</option>
            <option value="price-asc" <?=$filter['sort'] == 'price-asc' ? 'selected' : ''?>>Giá sản phẩm tăng dần</option>
            <option value="price-desc" <?=$filter['sort'] == 'price-desc' ? 'selected' : ''?>>Giá sản phẩm giảm dần</option>
            <option value="name-az" <?=$filter['sort'] == 'name-az' ? 'selected' : ''?>>Tên sản phẩm A --&gt; Z</option>
            <option value="name-za" <?=$filter['sort'] == 'name-za' ? 'selected' : ''?>>Tên sản phẩm Z --&gt; A</option>
          </select>
        </li>
        <li>100 sản phẩm </li>
      </ul>
      <div id="show-filter-sort js-filter-data">
        <div class="filter-search">
          <div class="filter-search-tit md">
            <img src="/templates/home/styles/images/svg/boloctimkiem.svg" alt="">Bộ lọc tìm kiếm</div>
          <div class="filter-search-detail">
            <div class="item">
              <h4>Tình trạng sản phẩm</h4>
              <ul class="item-check">
                <li>
                  <label class="checkbox-style">
                    <input type="radio" name="filter_quality" value="0" <?=$filter['quality'] == 0 ? 'checked="checked"' : ''?>>
                    <span>Mới </span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style">
                    <input type="radio" name="filter_quality" value="1" <?=$filter['quality'] == 1 ? 'checked="checked"' : ''?>>
                    <span>Đã qua sử dụng</span>
                  </label>
                </li>
              </ul>
            </div>
            <div class="item">
              <h4>Khuyến mãi</h4>
              <ul class="item-check">
                <li>
                  <label class="checkbox-style">
                    <input type="radio" name="filter_percentage" value="0" <?=$filter['percentage'] == 0 ? 'checked="checked"' : ''?>>
                    <span>Tất cả</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style">
                    <input type="radio" name="filter_percentage" value="1" <?=$filter['percentage'] == 1 ? 'checked="checked"' : ''?>>
                    <span>Giảm giá</span>
                  </label>
                </li>
              </ul>
            </div>
            <div class="item">
              <h4>Giá</h4>
              <div class="nhapgia">
                <p class="mr10">Từ</p>
                <p>
                  <input class="width" type="text" name="filter_from" placeholder="VNĐ" value="<?=$filter['price_f'] > 0 ? $filter['price_f'] : '' ?>">
                </p>
                <p class="ml10 mr10">Đến</p>
                <p>
                  <input class="width" type="text" name="filter_to" placeholder="VNĐ" value="<?=$filter['price_t'] > 0 ? $filter['price_t'] : '' ?>">
                </p>
              </div>
              <div class="btn-tim js-filter-submit">
                <a href="javascript:void(0)">TÌM</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END Load filter -->
  </div>


  <div class="col-md-9">
    <!-- LOAD Sort -->
    <div class="sortby md">
      <div class="left">
        <p>Sắp xếp theo</p>
        <div class="sortby-category js-filter-sort">
          <select class="style-select-box sort-item" name="select-sort" id="">
            <option value="date-new" <?=$filter['sort'] == 'date-new' ? 'selected' : ''?>>Mới nhất</option>
            <option value="date-old" <?=$filter['sort'] == 'date-old' ? 'selected' : ''?>>Cũ nhất</option>
            <option value="price-asc" <?=$filter['sort'] == 'price-asc' ? 'selected' : ''?>>Giá sản phẩm tăng dần</option>
            <option value="price-desc" <?=$filter['sort'] == 'price-desc' ? 'selected' : ''?>>Giá sản phẩm giảm dần</option>
            <option value="name-az" <?=$filter['sort'] == 'name-az' ? 'selected' : ''?>>Tên sản phẩm A --&gt; Z</option>
            <option value="name-za" <?=$filter['sort'] == 'name-za' ? 'selected' : ''?>>Tên sản phẩm Z --&gt; A</option>
          </select>
        </div>
        <!-- <div class="sortby-category">Bán chạy</div> -->
      </div>
      <div class="right">Hiển thị
        <span>&nbsp;<?=$total?> sản phẩm</span>
      </div>
    </div>
    <div class="text-right mb10 sm">
      <div class="xem-dang-luoi">
        <img id="js-xem-dang-luoi" src="/templates/home/styles/images/svg/xemluoi_on.svg" alt="">
      </div>
    </div>
    <!-- END LOAD Sort -->

    <div class="show-product">
      <div class="shop-product-items catalogue-product-items">
        <?php foreach ($items as $key => $value) {
          $this->load->view('e-azibai/common/common-html-item',['item'=>$value,'has_af_key'=>$has_af_key]);
        }?>
      </div>
    </div>
  </div>
</div>