
<?php $this->load->view('home/product/header_product'); ?>
<?php
$pro_image = base_url().'media/images/product/'.$products->pro_dir.'/'.$products->pro_image;
$pro_name = $products->pro_name;
$pro_sku = $products->pro_sku;
$pro_brand = $products->pro_brand;
$pro_cost = $products->pro_cost;
$pro_instock = $products->pro_instock;
$pro_minsale = $products->pro_minsale;
$pro_province = $products->pro_province;
$pro_district = $products->pro_district;
$pro_weight = $products->pro_weight;
$pro_category = $products->pro_category;
$pro_detail = $products->pro_detail;

$limit_to = $promotion->limit_to;
$limit_type = $promotion->limit_type;
?>

<main class="sanphamchitiet add_product">      
    <section class="main-content">
      <div class="container">
          <form action="" class="form">
            <div class="sanphamchitiet-content">
              <div class="col-md-5">
                <div class="sanphamchitiet-content-gallery">
              <input type="file" name="imgPro" id="imgPro" style="height: auto;" name="pro_image">
              <div class="avatar">
                <img src="<?php echo $pro_image; ?>" id="avatarPro"/>
              </div>
              </div>
            </div>
            <div class="col-md-7">
                <div class="sanphamchitiet-content-detail">
            <div style="text-align: right;">
              <button type="button" class="up-product btn btn-success">Lưu</button>
            </div>
                  <!-- thông tin chung -->
                  <div class="thong-tin-chung">
                    <div class="error_all_data">Bạn vui lòng nhập đầy đủ thông tin (*)</div>
                      <!-- <div class="button-chinh-sua modal-pro-basic">
                        <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
                      </div> -->
                      <div class="box-no-value">
                        <div class="tab-content">
          <!-- thông tin cơ bản -->
                      <div class="p20" id="home" role="tabpanel" aria-labelledby="home-tab">

                      
                        <div class="form-group row">
                          <div class="col-sm-4 col-xs-12 control-label">
                              <font color="#FF0000"><b>*</b></font> Tên <?php echo $text; ?> :
                          </div>
                          <div class="col-sm-8 col-xs-12 control-label">
                              <input class="pro_name" maxlength="100" name="pro_name" type="text" placeholder="Nhập Tên <?php echo $text; ?> (tối đa 100 ký tự)" value="<?php echo $pro_name; ?>" required="required">
                              <!-- <p class="error_input error_pro_name">Vui lòng nhập tên <?php echo $text; ?>.</p> -->
                          </div>
                        </div>
                        
                        <div class="form-group row">
                          <div class="col-sm-4 col-xs-12 control-label">
                              <font color="#FF0000"><b>*</b></font> Mã <?php echo $text; ?> :
                          </div>
                          <div class="col-sm-8 col-xs-12">
                              <input class="pro_sku" maxlength="35" name="pro_sku" type="text" placeholder="Nhập Mã <?php echo $text; ?> (tối đa 35 ký tự)" value="<?php echo $pro_sku; ?>" required>
                              <!-- <p class="error_input error_pro_sku">Vui lòng nhập mã <?php echo $text; ?>.</p> -->
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-sm-4 col-xs-12 control-label">
                              <font color="#FF0000"></font> Thương hiệu :
                          </div>
                          <div class="col-sm-8 col-xs-12">
                              <input class="pro_brand" name="pro_brand" maxlength="255" type="text" placeholder="Nhập Thương hiệu (tối đa 255 ký tự)" value="<?php echo $pro_brand; ?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-sm-4 col-xs-12 control-label">
                              <font color="#FF0000"><b>*</b></font> Giá bán :
                          </div>
                          <div class="col-sm-8 col-xs-12 row">
                            <div class="col-sm-3 col-xs-12 wp10">
                                <input class="pro_cost" name="pro_cost" type="text" onkeypress="return isNumberKey(event);" placeholder="Giá bán" value="<?php echo $pro_cost; ?>" required>
                            </div>
                            <div class="col-sm-3 col-xs-12 wp10">
                                <input class="pro_unit" name="pro_unit" value="<?php echo $pro_unit; ?>" maxlength="50" type="text" placeholder="Nhập đơn vị bán">
                            </div>
                            <div class="col-sm-3 col-xs-12 wp10">
                                <select name="pro_currency" class="pro_currency select-style">
                                  <option value="VND">VND</option>
                                </select>
                            </div>
                            <!-- <div class="col-sm-12 col-xs-12">
                              <p class="error_input error_pro_cost">Vui lòng nhập giá <?php echo $text; ?>.</p>
                            </div> -->
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-sm-4 col-xs-12 control-label">
                              Bán sỉ :
                          </div>
                          <div class="col-sm-8 col-xs-12 row">
                            <?php
                            $unit_ = '';
                            $hidden = 'hidden';
                            if( $limit_type > 0)
                            {
                              $hidden = '';
                              // if( $limit_type == 1)
                              // {
                              //   $value_pro = $promotion->dc_rate;
                              // }
                              // else
                              // {
                              //   $value_pro = $promotion->dc_amt;
                              // }
                              $amount = $promotion->amount;
                            }
                            ?>
                            <div class="col-sm-12">
                              <input class="" id="isPromotion" type="checkbox" onkeypress="return isNumberKey(event);"value="1" <?php echo ($limit_type > 0) ? 'checked' : ''; ?>>
                            </div>
                            <div class="box-promotion col-sm-12 wp10 <?php echo $hidden; ?>">
                              <div class="col-sm-6 col-xs-12 wp10">
                                  <label>
                                    <input class="pro_cost" name="limit_type" type="radio" onkeypress="return isNumberKey(event);" placeholder="Giá bán" value="1" <?php echo ($limit_type == 1) ? 'checked' : ''; ?>>
                                    Theo số lượng
                                  </label>
                              </div>
                              <div class="col-sm-6 col-xs-12 wp10">
                                  <label>
                                    <input class="pro_cost" name="limit_type" type="radio" onkeypress="return isNumberKey(event);" placeholder="Giá bán" value="2" <?php echo ($limit_type == 2) ? 'checked' : ''; ?>>
                                    Theo giá tiền
                                  </label>
                              </div>

                              <div class="col-sm-12 wp10" style="padding-right: 0; margin-top: 10px;">
                                <label class="col-sm-3">Mua</label>
                                <input class="pro_cost col-sm-6 col-xs-12" name="limit_to" type="text" onkeypress="return isNumberKey(event);" placeholder="số lượng hoặc số tiền giảm sỉ" value="<?php echo $limit_to; ?>">
                                <span class="text_typePro"></span>
                              </div>
                              <div class="col-sm-12 col-xs-12 wp10">
                                  <p style="<?php echo 'margin-top: 10px;'; ?>">
                                    <span class="col-sm-3">Giá sỉ </span>
                                    <input class="amount col-sm-6 col-xs-12" name="amount" value="<?php echo $amount; ?>" maxlength="50" type="text" placeholder="Giá bán sỉ">
                                    <span class="">/ sản phẩm</span>
                                  </p>
                                  <!-- <p style="margin-top: 10px;"> -->
                                    <!-- <div class="" style="display: flex;"> -->
                                      <!-- <div class="col-sm-6 wp10" style="padding-left: 0;">
                                        <input class="pro_unit col-xs-6" onkeypress="return isNumberKey(event);" name="promotion_list[1][limit_from]" value="<?php echo $pro_unit; ?>" maxlength="50" type="text" placeholder="Từ">
                                      </div>
                                      <div class="col-sm-6 wp10" style="padding-right: 0;">
                                        <input class="pro_unit col-xs-6" name="pro_unit" value="<?php echo $pro_unit; ?>" maxlength="50" type="text" placeholder="Đến">
                                      </div> -->
                                    <!-- </div> -->
                                  <!-- </p> -->
                              </div>
                              <!-- <div class="col-sm-12 col-xs-12">
                                <p class="error_input error_pro_cost">Vui lòng nhập giá <?php echo $text; ?>.</p>
                              </div> -->
                              </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-sm-4 col-xs-12 control-label">
                              <font color="#FF0000">*</font> Số lượng :
                          </div>
                          <div class="col-sm-8 col-xs-12">
                              <input class="pro_instock" name="pro_instock" type="text" onkeypress="return isNumberKey(event);" placeholder="Số lượng" value="<?php echo $pro_instock; ?>">
                              <!-- <p class="error_input error_pro_instock">Vui lòng nhập số lượng <?php echo $text; ?>.</p> -->
                          </div>
                        </div>


                        <div class="form-group row">
                          <div class="col-sm-4 col-xs-12 control-label">
                              <font color="#FF0000">*</font> Số lượng bán tối thiểu :
                          </div>
                          <div class="col-sm-8 col-xs-12">
                              <input class="pro_minsale" name="pro_minsale" type="text" onkeypress="return isNumberKey(event);" placeholder="Số lượng bán tối thiểu" value="<?php echo $pro_minsale; ?>">
                              <!-- <p class="error_input error_pro_minsale">Vui lòng nhập số lượng <?php echo $text; ?>.</p> -->
                          </div>
                        </div>
                        <?php
                        if($pro_type == 0){
                        ?>
                        <div class="form-group row">
                          <div class="col-sm-4 col-xs-12 control-label">
                              <font color="#FF0000">*</font> Trọng lượng :
                          </div>
                          <div class="col-sm-8 col-xs-12">
                              <input class="pro_weight w80pc" name="pro_weight" onkeypress="return isNumberKey(event);" type="text" placeholder="Trọng lượng" value="<?php echo $pro_weight; ?>"> gram
                              <!-- <p class="error_input error_pro_weight">Vui lòng nhập trọng lượng <?php echo $text; ?>.</p> -->
                          </div>
                        </div>
                        <?php
                        }
                        ?>

                        <div class="form-group row">
                            <div class="col-sm-4 col-xs-12 control-label">
                                <font color="#FF0000"><b>*</b></font> Danh mục :
                            </div>
                            <div class="col-sm-8 col-xs-12" id="listCategory">
                                <input type="hidden" value="<?php echo $pro_category; ?>" data-title="" class="pro_category" name="pro_category">
                                <div class="swap_category">
                                  <select class="root_category select-style w50pc">
                                    <option value="0" data-title="">--Chọn danh mục cho sản phẩm--</option>
                                    <?php 
                                    if (!empty($category_root)) { 
                                      foreach ($category_root as $item) {
                                    ?>
                                    <option data-title="<?php echo $item->cat_name; ?>" value="<?php echo $item->cat_id; ?>">
                                      <?php 
                                        echo $item->cat_name;
                                        if ($item->child_count > 0)
                                        {
                                          echo ' >';
                                        }
                                      ?>
                                    </option>
                                    <?php } }?>
                                  </select>
                                </div>
                                <!-- <p class="error_input error_pro_category">Vui lòng chọn danh mục.</p> -->
                            </div>
                          </div>
                    
                            <div class="form-group row">
                            <div class="col-sm-4 col-xs-12 control-label">
                                <font color="#FF0000"></font> Tỉnh/thành :
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <div class="swap_category">
                                      <select name="sho_province" id="provice" class="root_category select-category select-style w50pc">
                                          <option value="">Chọn Tỉnh/Thành</option>
                                          <?php foreach ($province as $vals):?>
                                              <option value="<?php echo $vals->pre_id; ?>" <?php echo ($vals->pre_id == $shop->sho_province)?"selected='selected'":""; ?> ><?php echo $vals->pre_name; ?></option>
                                          <?php endforeach;?>
                                      </select>
                                  </div>
                              </div>
                            </div>
                            
                            <div class="form-group row">
                            <div class="col-sm-4 col-xs-12 control-label">
                                <font color="#FF0000"></font> Quận/huyện :
                            </div>
                              <div class="col-sm-8 col-xs-12">
                                <div class="swap_category">
                                      <select name="sho_district" id="district" class="root_category select-category select-style w50pc">
                                          <option value="">Chọn Quận/Huyện</option>
                                          <?php 
                                          if(!empty($district))
                                          {
                                          foreach ($district as $vals): ?>
                                              <option value="<?php echo $vals->DistrictCode; ?>" <?php echo ($vals->DistrictCode == $shop->sho_district)?"selected='selected'":""; ?> ><?php echo $vals->DistrictName; ?></option>
                                          <?php endforeach;
                                      }?>
                                      </select>
                                  </div>
                              </div>
                            </div>
                      </div>
                      <!-- end thông tin cơ bản -->
                    </div>
                      </div>
                  </div>
                  <!-- end thông tin chung -->
                        
                  </div>
              </div>
          </div>

            <div class="thong-tin-cua-hang" style="position: relative; margin: auto; margin-top: 20px; width: 95%;">

                <div class="title" style="text-transform: uppercase;">
                  <h3>Mô tả chi tiết</h3>
                </div>

                <div class="info" style="padding: 20px;">
          
        <!-- mô tả chi tiết -->
                <div class="item">
                    <!-- <div class="button-chinh-sua modal-pro-detail">
                      <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
                    </div> -->
                    <h4></h4>
                    <div class="add-product-detail">
                      <div class="form-group">
                            <!-- <div class="col-sm-12 col-xs-12">
                                <font color="#FF0000"><b>*</b></font> Chi tiết <?php echo $text; ?>:
                            </div> -->
                            <?php $this->load->view('home/common/tinymce'); ?>
                            <div class="col-sm-12 col-xs-12">
                              <textarea name="pro_detail" id="pro_detail" cols="30" rows="10" class="editor w100pc">
                                <?php echo $pro_detail; ?>
                              </textarea>
                              <!-- <p class="error_input error_pro_detail">Vui lòng nhập chi tiết <?php echo $text; ?>.</p> -->
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- end mô tả chi tiết -->
            </div>
        </div>
        </form>
      </div>
  </section>
      
</main>

<?php $this->load->view('home/product/js_product'); ?>