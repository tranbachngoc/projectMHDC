<style>
  .modal-body .close {
    font-size: 30px;
    color: #000;
    position: absolute;
    top: -5px;
    right: 5px;
  }
  #fee_cate { color: red }
  .border_red { border-color: red !important ; }
  .background_red { background-color: red }
  .upload-pic .slider-img-small .slick-slide { height: 100px }
  
  #popup-image-list .slider-img-big { display: inline-block; }
  #popup-image-list .slider-img-small img{ width: 100px; height: 100px }
  #popup-image-list .item-image-list { position: relative; }
  #popup-image-list .item-image-list .action-icon{ position: absolute; top:0px; right: 5px }
  #popup-image-list .item-image-list .action-icon i{ cursor: pointer; }
  #popup-image-list .item-image-list .action-icon .fa-trash{ color: red }

 
  #popup-image-list .item-image-list .fa-check-circle{ color: green; display: none; }
  #popup-image-list .item-image-list.crop-done .fa-check-circle{ display: inline-block; }


  #popup-image-list .item_default_img .action-icon { display: none; }
  #popup-image-list .item_default_img .action-icon { display: none; }
  #popup-image-list .item-image-list { opacity: 0.7 }
  #popup-image-list .item-image-list.active_crop, #popup-image-list .item-image-list.crop-done { opacity: 1 }

  #mutiple_img_input { display: none; }
  .darkroom-button-group {
    padding: 5px;
    display: inline-block;
  }
  .container_show .dynamic { max-width: 100px; max-height: 100px; }
  .product-video { cursor: pointer; }
  #modal-pro-qc .upload_btn { border: 1px solid gray }
  #pro_attach .sanphamchitiet-content-detail { width: 100% }
  #pro_attach .san-pham-mua-kem .item { margin: 10px 10px 15px 10px;  }
  #pro_attach .sanphamchitiet-content-detail .san-pham-mua-kem .item .image { width: 150px; height: 150px; }
  #pro_attach .sanphamchitiet-content-detail .san-pham-mua-kem .item .text {width: 150px;}
  #pro_attach .sanphamchitiet-content-detail .san-pham-mua-kem .item .image:after {background: unset;}
  #pro_attach .sanphamchitiet-content-detail .san-pham-mua-kem .item .image .icon-chon {
      position: absolute;
      left: 50%;
      top: 45%;
      margin-left: -15px;
      width: 30px;
      cursor: pointer;
  }
  #pro_attach .sanphamchitiet-content-detail .san-pham-mua-kem .item .btn-chon {
      position: absolute;
      top: 25px;
      left: 50%;
      padding: 5px 0;
      background: rgba(0, 0, 0, 0.7);
      color: #fff;
      border-radius: 5px;
      width: 45px;
      text-align: center;
      margin-left: -24px;
      opacity: 0;
  }
  #specification .error_input_spec, #modal-pro-qc .error_input_spec { border: 1px solid red }
  .root_category { display: block; margin-bottom: 10px }
  .c-hide { display: none; }
  .bootstrap-datetimepicker-widget table td.disabled, .bootstrap-datetimepicker-widget table td.disabled:hover { text-decoration: line-through !important; }
  .error_input {
    text-align: left;
    font-size: 12px;
    color: red;
    display: none;
  }
  .pro_category { margin-bottom: 10px }
  .control-label {
    text-align: right;
    line-height: 30px;
    text-transform: capitalize;
  }
  #modal-add-product .san-pham-mua-kem {
    padding: 10px;
    position: relative;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flex;
    display: -o-flex;
    display: flex;
    justify-content: flex-start;
  }

  #modal-add-product .san-pham-mua-kem .item {
    border-radius: 5px;
    width: 100px;
    margin-right: 20px;
  }

  #modal-add-product .san-pham-mua-kem .item:last-child .image:after {
    content: none;
  }

  #modal-add-product .san-pham-mua-kem .item .image {
    width: 100px;
    height: 100px;
    margin-bottom: 10px;
    position: relative;
  }

  #modal-add-product .san-pham-mua-kem .item .image img {
    border-radius: 5px;
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
  }


  #modal-add-product .san-pham-mua-kem .item .text {
    width: 100px;
  }

  #modal-add-product .san-pham-mua-kem .item .text .tit {
    font-size: 14px;
    color: #000000;
    font-weight: normal;
    margin-bottom: 0;
  }

  #modal-add-product .san-pham-mua-kem .item .text .price {
    color: #D23F31;
  }

  #modal-add-product .san-pham-mua-kem .item .text .price .dong {
    color: #272727;
    font-size: 10px;
  }
  @media (max-width: 767px) {
    .control-label {
      text-align: left;
    }
    .wp10 { padding-bottom: 10px; }
  }
  .rowqcach .container_show{
      margin-top: 5px;
  }
</style>

<!-- product basic popup -->
<div class="modal add_product" id="modal-pro-basic">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->
      
      <!-- Modal body -->
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="tab-content">
          <!-- thông tin cơ bản -->
          <div class="p20" id="home" role="tabpanel" aria-labelledby="home-tab">

          
            <div class="form-group row">
              <div class="col-sm-4 col-xs-12 control-label">
                  <font color="#FF0000"><b>*</b></font> Tên <?php echo $result->text; ?> :
              </div>
              <div class="col-sm-8 col-xs-12 control-label">
                  <input class="pro_name" maxlength="100" name="pro_name" type="text" placeholder="Nhập Tên <?php echo $result->text; ?> (tối đa 100 ký tự)">
                  <p class="error_input error_pro_name">Vui lòng nhập tên <?php echo $result->text; ?>.</p>
              </div>
            </div>
            
            <div class="form-group row">
              <div class="col-sm-4 col-xs-12 control-label">
                  <font color="#FF0000"><b>*</b></font> Mã <?php echo $result->text; ?> :
              </div>
              <div class="col-sm-8 col-xs-12">
                  <input class="pro_sku" maxlength="35" name="pro_sku" type="text" placeholder="Nhập Mã <?php echo $result->text; ?> (tối đa 35 ký tự)">
                  <p class="error_input error_pro_sku">Vui lòng nhập mã <?php echo $result->text; ?>.</p>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-4 col-xs-12 control-label">
                  <font color="#FF0000"></font> Thương hiệu :
              </div>
              <div class="col-sm-8 col-xs-12">
                  <input class="pro_brand" name="pro_brand" maxlength="255" type="text" placeholder="Nhập Thương hiệu (tối đa 255 ký tự)">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-4 col-xs-12 control-label">
                  <font color="#FF0000"><b>*</b></font> Giá bán :
              </div>
              <div class="col-sm-8 col-xs-12 row">
                <div class="col-sm-3 col-xs-12 wp10">
                    <input class="pro_cost" name="pro_cost" type="text" onkeypress="return isNumberKey(event);" placeholder="Giá bán">
                </div>
                <div class="col-sm-3 col-xs-12 wp10">
                    <input class="pro_unit" name="pro_unit" maxlength="50" type="text" placeholder="Nhập đơn vị bán">
                </div>
                <div class="col-sm-3 col-xs-12 wp10">
                    <select name="pro_currency" class="pro_currency select-style">
                      <option value="VND">VND</option>
                    </select>
                </div>
                <div class="col-sm-12 col-xs-12">
                  <p class="error_input error_pro_cost">Vui lòng nhập giá <?php echo $result->text; ?>.</p>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-4 col-xs-12 control-label">
                  <font color="#FF0000">*</font> Số lượng :
              </div>
              <div class="col-sm-8 col-xs-12">
                  <input class="pro_instock" name="pro_instock" type="text" onkeypress="return isNumberKey(event);" placeholder="Số lượng">
                  <p class="error_input error_pro_instock">Vui lòng nhập số lượng <?php echo $result->text; ?>.</p>
              </div>
            </div>


            <div class="form-group row">
              <div class="col-sm-4 col-xs-12 control-label">
                  <font color="#FF0000">*</font> Số lượng bán tối thiểu :
              </div>
              <div class="col-sm-8 col-xs-12">
                  <input class="pro_minsale" name="pro_minsale" type="text" onkeypress="return isNumberKey(event);" placeholder="Số lượng bán tối thiểu" value="1">
                  <p class="error_input error_pro_minsale">Vui lòng nhập số lượng <?php echo $result->text; ?>.</p>
              </div>
            </div>

            <?php if ($pro_type == 0) { ?>
            <div class="form-group row">
              <div class="col-sm-4 col-xs-12 control-label">
                  <font color="#FF0000">*</font> Trọng lượng :
              </div>
              <div class="col-sm-8 col-xs-12">
                  <input class="pro_weight w80pc" name="pro_weight" onkeypress="return isNumberKey(event);" type="text" placeholder="Trọng lượng"> gram
                  <p class="error_input error_pro_weight">Vui lòng nhập trọng lượng <?php echo $result->text; ?>.</p>
              </div>
            </div>
            <?php } ?>

            <div class="form-group row">
              <div class="col-sm-4 col-xs-12 control-label">
                  <font color="#FF0000"></font> <?php echo $result->text; ?> nổi bật :
              </div>
              <div class="col-sm-3 col-xs-12 wp10">
                  <label class="checkbox-style mt10">
                    <input class="pro_hot" type="checkbox" name="pro_hot" value="1">
                    <span></span>
                  </label>
              </div>
            </div>


            <div class="form-group row">
              <div class="col-sm-4 col-xs-12 control-label">
                  <font color="#FF0000"></font> <?php echo $result->text; ?> có khuyến mãi :
              </div>
              <div class="col-sm-8 col-xs-12 wp10">
                  <div class="col-sm-3 col-xs-12 wp10 row">
                    <label class="checkbox-style mt10">
                      <input class="pro_saleoff" type="checkbox" name="pro_saleoff" value="1">
                      <span></span>
                  </label>
                  </div>
                  <div class="child_saleoff col-sm-12 col-xs-12 wp10 m00 p00 mt10 row" style="display:none;">
                    <div class="col-sm-4 col-xs-12 wp10 mb15">
                      <input class="pro_saleoff_value" onkeypress="return isNumberKey(event);" name="pro_saleoff_value" type="text" placeholder="" value="0">
                    </div>
                    <div class="col-sm-4 col-xs-12 wp10 mb15">
                        <select name="pro_saleoff_type" class="pro_saleoff_type select-style w50pc">
                          <option value="1">%</option>
                          <option value="2">VND</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-xs-12 wp10">
                      <input class=" begin_date_sale" name="begin_date_sale" type="text" placeholder="Ngày bắt đầu">
                    </div>
                    <div class="col-sm-6 col-xs-12 wp10">
                      <input class=" end_date_sale"  name="end_date_sale" type="text" placeholder="Ngày kết thúc">
                    </div>
                    <div class="col-sm-12 col-xs-12 wp10">
                      <p class="error_input error_two_day">Vui lòng nhập ngày khuyến mãi.</p>
                      <p class="error_input error_pro_saleoff"></p>
                    </div>
                  </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-4 col-xs-12 control-label">
                  <font color="#FF0000"></font> Chiết khấu cho thành viên:
                  <input type="hidden" id="limit_type" name="limit_type" value="1">
              </div>
              <div class="col-sm-8 col-xs-12 wp10">
                <ul class="nav nav-tabs" id="saleTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="quantity-tab" data-id="1" data-toggle="tab" href="#quantity" role="tab" aria-controls="quantity" aria-selected="true">Số lượng</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="price-tab" data-id="2" data-toggle="tab" href="#price" role="tab" aria-controls="price" aria-selected="false">Số tiền</a>
                  </li>
                </ul>

                <div class="tab-content " id="saleTabContent">
                    <div class="tab-pane fade show active" id="quantity" role="tabpanel" aria-labelledby="quantity-tab">
                      <table class="table table-hover promotion_list_table">
                          <thead>
                            <tr>
                                <th>Từ</th>
                                <th>Tới</th>
                                <th>Giảm giá</th>
                                <th>Loại</th>
                                <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                      </table>
                      <button type="button" class="btn btn-default promotion_list_new">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                      </button>            
                    </div>

                    
                    <div class="tab-pane fade" id="price" role="tabpanel" aria-labelledby="price-tab">
                      <table class="table table-hover promotion_price_table">
                          <thead>
                            <tr>
                                <th>Từ</th>
                                <th>Tới</th>
                                <th>Giảm giá</th>
                                <th>Loại</th>
                                <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                      </table>
                      <button type="button" class="btn btn-default promotion_price_new">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                      </button>
                    </div>
                    <i class="mt05 mb15">(Nhập số lượng từ 5 đến 10 giảm 200.000 thì nhập là Từ: 5, Tới: 10, Giảm giá:200.000, tương tự cho nhập Số tiền)</i>
                    <br/> 
                    <i class="mt05 mb15">(Nhập số lượng từ 10 trở về sau thì nhập là Từ: 10, Tới: 0, tương tự cho nhập Số tiền)</i>
                    
                    <div class="col-sm-12 col-xs-12 wp10">
                        <p class="error_input error_pro_giamsi"></p>
                   </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end thông tin cơ bản -->
        </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="save-basic btn btn-success">Lưu</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
      </div>
      
    </div>
  </div>
</div>
<!-- end product basic popup -->

<!-- product image list -->

<div class="modal upload-pic" id="popup-image-list">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <div class="button-up-img">
            <button type="button" class="btn btn-primary up_mutiple_img">Đăng hình</button>
            <button type="button" class="btn btn-success save_mutiple_img">Lưu hình</button>
            <input type="file" name="" accept="image/*" id="mutiple_img_input"  multiple>
          </div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="slider slider-img-big">
              <img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">
          </div>
          <div class="slider slider-img-small">
              <div class="item_default_img item-image-list">
                <img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">
                <div class="action-icon">
                  <span class="check_crop fail-crop">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                  </span>
                  <span>
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </span>
                </div>
              </div>

              <div class="item_default_img item-image-list">
                <img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">
                <div class="action-icon">
                  <span class="check_crop fail-crop">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                  </span>
                  <span>
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </span>
                </div>
              </div>

              <div class="item_default_img item-image-list">
                <img id="target_crop_image" src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">
                <div class="action-icon">
                  <span class="check_crop fail-crop">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                  </span>
                  <span>
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </span>
                </div>
              </div>

              <div class="item_default_img item-image-list">
                <img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">
                <div class="action-icon">
                  <span class="check_crop fail-crop">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                  </span>
                  <span>
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </span>
                </div>
              </div>
          </div>
        </div>
        <!-- Modal footer -->
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div> -->
    </div>
  </div>
</div>

<!-- end product image list -->

<!-- product aff -->
<div class="modal cooperator coupon" id="modal-pro-ctv">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Cho phép cộng tác viên bán hộ</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="coupon-content">
          <div class="coupon-content-item">
            <ul class="ctv-list js-type-persale">
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="apply" value="0" checked><span>Không bán qua cộng tác viên</span>
                </label>
              </li>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="apply" value="2"><span>Chỉ cho hệ thống cộng tác viên của tôi bán</span>
                </label>
              </li>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="apply" value="3"><span>Chỉ cho hệ thống cộng tác viên của azibai bán</span>
                </label>
              </li>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="apply" value="1"><span>Cho phép tất cả</span>
                </label>
              </li>
            </ul>
          </div>
          <div class="coupon-content-item js-affsale hidden">
            <div class="ctv-content">
              <div class="ctv-content-item">
                <h3 class="tt">Ưu đãi qua hệ thống bán hộ</h3>
                <p class="error_input error_aff_dc_swap" style="display: none;"></p>
                <div class="text">
                  <div class="accordion js-accordion special-price js-aff-dc-swap">
                    <div class="accordion-item special-price-item js-rate">
                      <div class="accordion-toggle special-price-title">
                        Ưu đãi theo phần trăm
                      </div>
                      <div class="accordion-panel special-price-text">
                        <label class="has-unit"><input type="text" class="form-control js-aff-dc-value" onkeypress="return isNumberKey(event);" placeholder="Nhập số"><span class="unit">%</span></label>
                      </div>
                    </div>
                    <div class="accordion-item special-price-item js-amt">
                      <div class="accordion-toggle special-price-title">
                        Ưu đãi theo giá tiền
                      </div>
                      <div class="accordion-panel special-price-text">
                        <label class="has-unit"><input type="text" class="form-control js-aff-dc-value" onkeypress="return isNumberKey(event);" placeholder="Nhập số tiền ưu đãi"><span class="unit">VND</span></label>
                        <!-- <p class="small-text"></p> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="ctv-content-item">
                <h3 class="tt">Hoa hồng cho hệ thống bán hộ</h3>
                <p class="error_input error_aff_swap" style="display: none;"></p>
                <div class="text">
                  <div class="accordion js-accordion02 special-price js-aff-swap">
                    <div class="accordion-item02 special-price-item js-rate">
                      <div class="accordion-toggle02 special-price-title">
                        Hưởng phần trăm trên mỗi đơn hàng
                      </div>
                      <div class="accordion-panel02 special-price-text">
                        <div class="flex-center">
                          <p class="txt">Hoa hồng cho nhà phân phối</p>
                          <label class="has-unit"><input type="text" class="form-control affiliate_value_1" onkeypress="return isNumberKey(event);" placeholder="Nhập số"><span class="unit">%</span></label>
                        </div>
                        <div class="flex-center">
                          <p class="txt">Hoa hồng cho tổng đại lý</p>
                          <label class="has-unit"><input type="text" class="form-control affiliate_value_2" onkeypress="return isNumberKey(event);" placeholder="Nhập số"><span class="unit">%</span></label>
                        </div>
                        <div class="flex-center">
                          <p class="txt">Hoa hồng cho đại lý</p>
                          <label class="has-unit"><input type="text" class="form-control affiliate_value_3" onkeypress="return isNumberKey(event);" placeholder="Nhập số"><span class="unit">%</span></label>
                        </div>                      
                      </div>
                    </div>
                    <div class="accordion-item02 special-price-item js-amt">
                      <div class="accordion-toggle02 special-price-title">
                        Hưởng số tiền trên mỗi đơn hàng
                      </div>
                      <div class="accordion-panel02 special-price-text">
                        <div class="flex-center">
                          <p class="txt">Hoa hồng cho nhà phân phối</p>
                          <label class="has-unit"><input type="text" class="form-control affiliate_value_1" onkeypress="return isNumberKey(event);"  placeholder="Nhập số"><span class="unit">VND</span></label>
                        </div>
                        <div class="flex-center">
                          <p class="txt">Hoa hồng cho tổng đại lý</p>
                          <label class="has-unit"><input type="text" class="form-control affiliate_value_2" onkeypress="return isNumberKey(event);" placeholder="Nhập số"><span class="unit">VND</span></label>
                        </div>
                        <div class="flex-center">
                          <p class="txt">Hoa hồng cho đại lý</p>
                          <label class="has-unit"><input type="text" class="form-control affiliate_value_3" onkeypress="return isNumberKey(event);" placeholder="Nhập số"><span class="unit">VND</span></label>
                        </div>                      
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>   
      <div class="modal-footer">
        <button type="button" class="save-basic btn btn-success">Lưu</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
      </div>
      <!-- End modal-footer -->       
    </div>
  </div>
</div>
<!-- end product aff -->

<!-- product qc popup -->
<div class="modal add_product" id="modal-pro-qc">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->
      
      <!-- Modal body -->
      <div class="modal-body p20">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="tab-pane" role="tabpanel" aria-labelledby="profile-tab">
            <table class="table table-hover">
              <thead>
                  <tr style="font-size: 14px;">
                      <th><span style="color: #ff0000">* </span>Hình ảnh</th>
                      <th>Màu sắc <input type="checkbox" id="qcColor" onchange="qcColor();" value="1" checked="checked"></th>
                      <th>Kích thước <input type="checkbox" id="qcSize" onchange="qcSize();" value="1"></th>      
                      <th>Chất liệu <input type="checkbox" id="qcMaterial" onchange="qcMaterial();" value="1"></th>
                      <th>Trọng lượng</th>
                      <th><span style="color: #ff0000">* </span>Giá</th>
                      <th><span style="color: #ff0000">* </span>Số lượng</th>
                      <th>Xóa</th>
                  </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
            <button type="button" class="btn btn-default add-row-qc">
              <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
            </button>
        </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="save-basic btn btn-success">Lưu</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<!-- end product qc popup -->


<!-- product info popup -->

<!-- product info popup -->
<div class="modal" id="modal-pro-info">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->
      
      <!-- Modal body -->
      <div class="modal-body">
        <div class="tab-content">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- thông tin cơ bản -->
          <div class="p20" id="infoProduct" role="tabpanel" aria-labelledby="infoProduct-tab">
                <div class="form-group row">
                  <div class="col-sm-3 col-xs-12 control-label">
                      <font color="#FF0000"><b>*</b></font> Danh mục :
                  </div>
                  <div class="col-sm-9 col-xs-12">
                      <input type="hidden" value="0" data-title="" class="pro_category" name="pro_category">
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
                      <p class="error_input error_pro_category">Vui lòng chọn danh mục.</p>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-3 col-xs-12 control-label">
                      <font color="#FF0000"><b>*</b></font> Thuế VAT :
                  </div>
                  <div class="col-sm-9 col-xs-12">
                      <select name="pro_vat" class="pro_vat select-style w50pc">
                        <option selected="selected" value="" title="- Chọn -">- Chọn -</option>
                        <option value="1" title="Đã có VAT">Đã có VAT</option>
                        <option value="2" title="Chưa có VAT">Chưa có VAT</option>
                      </select>
                      <p class="error_input error_pro_vat">Vui lòng chọn thuế VAT.</p>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-3 col-xs-12 control-label">
                      <font color="#FF0000"></font> Tình trạng :
                  </div>
                  <div class="col-sm-9 col-xs-12">
                      <select name="pro_quality" class="pro_quality select-style w50pc">
                        <option selected="selected" value="" title="- Chọn -">- Chọn -</option>
                        <option value="0" title="Mới">Mới</option>
                        <option value="1" title="Cũ">Cũ</option>
                      </select>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-3 col-xs-12 control-label">
                      <font color="#FF0000"></font> Xuất xứ :
                  </div>
                  <div class="col-sm-9 col-xs-12">
                      <select name="pro_made_from" class="pro_made_from select-style w50pc">
                        <option selected="selected" value="" title="- Chọn -">- Chọn -</option>
                        <option value="1" title="Chính hãng">Chính hãng</option>
                        <option value="2" title="Xách tay">Xách tay</option>
                        <option value="3" title="Hàng công ty">Hàng công ty</option>
                      </select>
                  </div>
                </div>


                <div class="form-group row">
                  <div class="col-sm-3 col-xs-12 control-label">
                      <font color="#FF0000"></font> Nhà sản xuất :
                  </div>
                  <div class="col-sm-9 col-xs-12">
                      <input class="pro_mannufacurer" name="pro_mannufacurer" type="text" placeholder="Nhà sản xuất" maxlength="255">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-3 col-xs-12 control-label">
                      <font color="#FF0000"></font> Sản xuất tại :
                  </div>
                  <div class="col-sm-9 col-xs-12">
                      <input class="pro_made_in" name="pro_made_in" type="text" placeholder="Sản xuất tại" maxlength="255">
                  </div>
                </div>


                <div class="form-group row">
                  <div class="col-sm-3 col-xs-12 control-label">
                      <font color="#FF0000"></font> Thời hạn bảo hành :
                  </div>
                  <div class="col-sm-9 col-xs-12">
                      <input class="pro_warranty_period w50pc" onkeypress="return isNumberKey(event);" name="pro_warranty_period" type="text" placeholder="Bảo hành" maxlength="6"> Tháng
                  </div>
                </div>
                <!-- <div class="form-group row">
                  <div class="col-sm-3 col-xs-12 control-label">
                      <font color="#FF0000"></font> Bảo hộ người mua :
                  </div>
                  <div class="col-sm-9 col-xs-12">
                      <select name="pro_protection" class="pro_protection select-style w50pc">
                        <option selected="selected" value="" title="- Chọn -">- Chọn -</option>
                        <option value="0" title="Không">Không</option>
                        <option value="1" title="Có">Có</option>
                      </select>
                  </div>
                </div> -->

                <div class="form-group row">
                  <div class="col-sm-3 col-xs-12 control-label">
                      <font color="#FF0000"></font> Video :
                  </div>
                  <div class="col-sm-9 col-xs-12">
                      <input class="pro_video" name="pro_video" type="text" placeholder="Đường link Youtube hoặc Vimeo" maxlength="250">
                      <p class="error_input error_pro_video">Sai đường dẫn.</p>
                  </div>
                </div>

                <!-- <div class="form-group row">
                  <div class="col-sm-3 col-xs-12 control-label">
                      <font color="#FF0000">*</font> Đồng ý phí mua bán :
                  </div>
                  <div class="col-sm-9 col-xs-12">
                     Khi đăng <?php echo $result->text; ?> này tức là bạn chấp nhận với phí mua bán của danh mục <?php echo $result->text; ?> đã chọn ở trên là <span id="fee_cate">0</span>(%).
                  </div>
                </div> -->
          </div>
          <!-- end thông tin cơ bản -->
        </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="save-basic btn btn-success">Lưu</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
      </div>
      
    </div>
  </div>
</div>
<!-- end product info popup -->

<!-- product specification popup -->
<div class="modal" id="modal-pro-specification">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->
      
      <!-- Modal body -->
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="tab-content">
          <!-- đặc điểm kỹ thuật -->
          <div class="p20" id="specification" role="tabpanel" aria-labelledby=specification-tab">
              <table class="table table-hover">
              <thead>
                  <tr style="font-size: 14px;">
                      <th>Nhãn</th>
                      <th>Thông tin</th>
                      <th>Xóa</th>
                  </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
            <button type="button" class="btn btn-default specification-new">
              <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
            </button>
          </div>
          <!-- end đặc điểm kỹ thuật -->
        </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="save-basic btn btn-success">Lưu</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<!-- end product specification popup -->


<!-- product detail -->
<div class="modal" id="modal-pro-detail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->
      
      <!-- Modal body -->
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="tab-content">
          <!-- mô tả chi tiết -->
          <div class="" id="detailProduct" role="tabpanel" aria-labelledby="detailProduct-tab">

              <div class="form-group">
                  <div class="col-sm-12 col-xs-12">
                      <font color="#FF0000"><b>*</b></font> Mô tả ngắn :
                  </div>
                  <div class="col-sm-12 col-xs-12">
                    <input class="pro_descr" name="pro_descr" maxlength="100" type="text" placeholder="Nhập mô tả ngắn (tối đa 100 ký tự)">
                    <p class="error_input error_pro_descr">Vui lòng nhập mô tả ngắn.</p>
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-12 col-xs-12">
                      <font color="#FF0000"><b>*</b></font> Từ khóa tìm kiếm :
                  </div>
                  <div class="col-sm-12 col-xs-12">
                    <input class="pro_keyword" name="pro_keyword" maxlength="255" type="text" placeholder="Từ khóa tìm kiếm cách nhau bởi dấu , (tối đa 255 ký tự)">
                    <p class="error_input error_pro_keyword">Vui lòng nhập từ khóa.</p>
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-12 col-xs-12">
                      <font color="#FF0000"><b>*</b></font> Chi tiết <?php echo $result->text; ?>:
                  </div>
                  <?php $this->load->view('home/common/tinymce'); ?>
                  <div class="col-sm-12 col-xs-12">
                    <textarea name="pro_detail" id="" cols="30" rows="10" class="editor w100pc"></textarea>
                    <p class="error_input error_pro_detail">Vui lòng nhập chi tiết <?php echo $result->text; ?>.</p>
                  </div>
              </div>
          </div>
          <!-- end mô tả chi tiết -->
        </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="save-basic btn btn-success">Lưu</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<!-- end product detail -->


<!-- product attach popup -->
<div class="modal" id="modal-pro-attach">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->
      
      <!-- Modal body -->
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="tab-content">
          <!-- <?php echo $result->text; ?> dính kèm -->
          <div class="p20" id="pro_attach" role="tabpanel" aria-labelledby="attach-tab">
              <div class="form-group row">
                <div class="col-sm-8 col-xs-12">
                    <select name="" class="select-style w50pc">
                      <option value="" title="- Chọn -">- Chọn -</option>
                      <?php 
                        if (!empty($products)) {
                          foreach ($products as $k_pro => $v_pro) {
                            echo '<option value="'.$v_pro->pro_id.'" title="'.$v_pro->pro_name.'">'.$v_pro->pro_name.'</option>';
                          }
                        }

                      ?>
                    </select>
                    <button type="button" class="add_pro_attach btn btn-success">Thêm</button>
                </div>
              </div>
              <div class="sanphamchitiet-content-detail">
                <div class="san-pham-mua-kem row">
                  
                </div>
              </div> 
          </div>
          <!-- end <?php echo $result->text; ?> dính kèm -->
        </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="save-basic btn btn-success">Lưu</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<!-- end product attech popup -->


<!-- product attach popup -->
<div class="upload-pic modal" id="modal-pro-image-qc" data-backdrop="static">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body">
            <div class="crop_image_qc">
             <img id="target_crop_qc" src="<?php echo DOMAIN_CLOUDSERVER ?>media/images/content/04122018/1x1_e1faeabe6faf07cbaf50d0dd8daf6295.jpg" alt="">
            </div>
          </div>
          
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
</div>
<!-- end product attach popup -->

<!-- coupon conditions popup -->
<?php if (!empty($pro_type) && $pro_type == 2){ ?>
<div class="modal conditionsUse" id="modal-pro-condition">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Điều kiện sử dụng</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="conditionsUse-content">
          <form>
            <div class="form-group">
              <label class="mb10">&#9679; &#12288;Thời gian hiệu lực của voucher ( ngày )</label>
              <input type="text" class="form-control js-time-condition" onkeypress="return isNumberKey(event);">
            </div>
            <div class="form-group">
              <label class="mb10">&#9679; &#12288;Thời lượng của gói dịch vụ </label>
              <div class="time">
                <input type="text" class="form-control js-duration-condition" onkeypress="return isNumberKey(event);">
                <div class="selectDate">
                  <select class="js-type-duration-condition">
                    <option value="0">-- Chọn --</option>
                    <option value="1">năm</option>
                    <option value="2">tháng</option>
                    <option value="3">ngày</option>
                    <option value="4">giờ</option>
                  </select>
                </div>
              </div>
              
            </div>
            <div class="form-group">
              <label class="mb10">&#9679; &#12288;Áp dụng cho</label>
              <textarea name="" class="form-control js-apply-condition"></textarea>
            </div>
            <div class="form-group">
              <label class="mb10">&#9679; &#12288;Không áp dụng đối với</label>
              <textarea name="" class="form-control js-not-apply-condition"></textarea>
            </div>                
            <div class="form-group">
              <div class="address-tt">
                <label>&#9679; &#12288;Địa chỉ sử dụng dịch vụ</label>
                <div class="btnAdd js-btn-add-condition"><img src="/templates/home/styles/images/svg/add_circle_black02.svg" width="22" class="mr05">Thêm</div>
              </div>
              <div class="address-content">
                <div class="address-content-item">
                  <input type="text" class="form-control js-address-condition">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>   
      <div class="modal-footer">
        <button type="button" class="save-basic btn btn-success">Lưu</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
      </div>
      <!-- End modal-footer -->       
    </div>
  </div>
</div>
<?php } ?>
<!-- end coupon conditions popup -->







<script id="js-promotion-list-new" type="text/template">
  <tr data-key="{{KEY}}">
    <td>
      <input onkeypress="return isNumberKey(event);" name="promotion_list[{{KEY}}][limit_from]" type="text" class="min-list min-list{{KEY}}" data-name="limit_from" data-key="{{KEY}}">
    </td>

    <td>
      <input onkeypress="return isNumberKey(event);" name="promotion_list[{{KEY}}][limit_to]" type="text" class="max-list max-list{{KEY}}" data-name="limit_to" data-key="{{KEY}}">
    </td>
    <td>
      <input onkeypress="return isNumberKey(event);" name="promotion_list[{{KEY}}][amount]" type="text" class="giam-si giam-si{{KEY}}" data-name="amount" data-key="{{KEY}}"></td>
    <td>
      <select name="promotion_list[{{KEY}}][type]" class="select-style js-style{{KEY}}" data-name="type" data-key="{{KEY}}">
        <option value="1">Số tiền</option>
        <option value="2">%</option>
      </select>
    </td>
    <td>
      <span class="btn btn-danger" onclick="$(this).closest('tr').remove();" title="Xóa">
        <i class="fa fa-remove "></i>
      </span>
    </td>
  </tr>
</script>

<script id="js-promotion-price-new" type="text/template">
  <tr data-key="{{KEY}}">
    <td>
      <input onkeypress="return isNumberKey(event);" name="promotion_price[{{KEY}}][limit_from]" type="text" class="min-price min-price{{KEY}}" data-name="limit_from" data-key="{{KEY}}">
    </td>

    <td>
      <input onkeypress="return isNumberKey(event);" name="promotion_price[{{KEY}}][limit_to]" type="text" class="max-price max-price{{KEY}}" data-name="limit_to" data-key="{{KEY}}">
    </td>
    <td>
      <input onkeypress="return isNumberKey(event);" name="promotion_price[{{KEY}}][amount]" type="text" class="giam-si-price giam-si-price{{KEY}}" data-name="amount" data-key="{{KEY}}"></td>
    <td>
      <select name="promotion_price[{{KEY}}][type]" class="select-style js-style-price{{KEY}}" data-name="type" data-key="{{KEY}}">
        <option value="1">Số tiền</option>
        <option value="2">%</option>
      </select>
    </td>
    <td>
      <span class="btn btn-danger" onclick="$(this).closest('tr').remove();" title="Xóa">
        <i class="fa fa-remove "></i>
      </span>
    </td>
  </tr>
</script>

<!-- product list image template -->
<script type="text/template" id="js-template-list-image">
  <div class="slider slider-img-big">
              <img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">
          </div>
          <div class="slider slider-img-small">
              <div class="item_default_img item-image-list">
                <img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">
                <div class="action-icon">
                  <span class="check_crop fail-crop">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                  </span>
                  <span>
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </span>
                </div>
              </div>

              <div class="item_default_img item-image-list">
                <img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">
                <div class="action-icon">
                  <span class="check_crop fail-crop">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                  </span>
                  <span>
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </span>
                </div>
              </div>

              <div class="item_default_img item-image-list">
                <img id="target_crop_image" src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">
                <div class="action-icon">
                  <span class="check_crop fail-crop">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                  </span>
                  <span>
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </span>
                </div>
              </div>

              <div class="item_default_img item-image-list">
                <img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">
                <div class="action-icon">
                  <span class="check_crop fail-crop">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                  </span>
                  <span>
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </span>
                </div>
              </div>
          </div>
</script>
<!-- end product list image template -->

<!-- template default specti -->
<script type="text/template" id="js-template-default-spec">
  <tr>
    <th class="style-no-value">Đặc điểm kĩ thuật</th>
    <td class="style-no-value">áo co giãn abc</td>
  </tr>
  <tr>
    <th class="style-no-value">Mã <?php echo $result->text; ?> SKU</th>
    <td class="style-no-value">MS_msp12</td>
  </tr>
  <tr>
    <th class="style-no-value">Kích thước</th>
    <td class="style-no-value">S, M, L, XL, XXL</td>
  </tr>
  <tr>
    <th class="style-no-value">Trọng lượng</th>
    <td class="style-no-value">500 gram</td>
  </tr>
  <tr>
    <th class="style-no-value">Model</th>
    <td class="style-no-value">2018</td>
  </tr>
  <tr>
    <th class="style-no-value">Phụ kiện đi kèm</th>
    <td class="style-no-value">cài áo</td>
  </tr>
</script>
<!-- end template default specti -->

<!-- template default specti -->
<script type="text/template" id="js-template-default-detail">
  <ul class="mo-ta-chi-tiet">
    <li class="style-no-value">
      <span class="dot">&#9679;</span>Lợi ích
    </li>

    <li class="style-no-value">
      <span class="dot">&#9679;</span>Bảo hành - bảo quản
    </li>

    <li class="style-no-value">
      <span class="dot">&#9679;</span>Khác biệt
    </li>

    <li class="style-no-value">
      <span class="dot">&#9679;</span>Chứng nhận
    </li>

    <li class="style-no-value">
      <span class="dot">&#9679;</span>Kết quả <?php echo $result->text; ?>
    </li>

    <li class="style-no-value">
      <span class="dot">&#9679;</span>Hướng dẫn sử dụng
    </li>
  </ul>
</script>
<!-- end template default specti -->

<!-- template product specitification -->
<script type="text/template" id="js-template-specitifi">
  <tr>
    <td>
      <input name="" type="text" class="spec_label">
    </td>
    <td>
      <input name="" type="text" class="spec_val">
    </td>
    <td>
      <span class="btn btn-danger" title="Xóa" onclick="$(this).closest('tr').remove();">
        <i class="fa fa-remove "></i>
      </span>
    </td>
  </tr>
</script>
<!-- template product specitification -->

<!-- template basic -->
<script id="js-template-basic" type="text/template">
  <div class="error_all_data">Bạn vui lòng nhập đầy đủ thông tin (*)</div>
  <div class="button-chinh-sua modal-pro-basic">
    <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
  </div>
  <p class="flash-sale">{{PRO_SALEOFF}}</p>
  <h3 class="tit">{{PRO_NAME}} {{PRO_MADE_FROM}}</h3>
  <p class="small-text">
    <span>Thương hiệu: {{PRO_BRAND}}</span>
    <span>Mã <?php echo $result->text; ?>: {{PRO_SKU}}</span>
  </p>
  <ul class="list-number">
    <li class="">
      <img src="/templates/home/styles/images/svg/gioxach.svg" width="11" alt="">0
    </li>
    <li class="">
      <img src="/templates/home/styles/images/svg/eyes.svg" width="15" alt="">0
    </li>
    <li class="">
      <img src="/templates/home/styles/images/svg/help_black.svg" width="15" alt="">
      <span class="baocao">Báo cáo</span>
    </li>
  </ul>
  <div class="price">
    {{PRO_COST}}
    <p>{{PRO_UNIT}}</p>
  </div>
  <div class="">
    <div class="gia-uu-dai {{PRO_PROMOTION}}">
      <img src="/templates/home/styles/images/svg/dola_den.svg" class="mr10" alt="">
        Giá ưu đãi khi mua số lượng
    </div>
  </div> 
</script>
<!-- end template basic -->

<!-- template pc -->
<script id="js-template-qc" type="text/template">
  <tr class="rowqcach">
    <td style="min-width: 100px;">
      <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
        <i class="fa fa-upload"></i> Hình
        <input type="hidden" name="dp_images" class="dp_image">
        <input type="file" name="dp_full_img" class="dp_image_file" style="display:none">
      </span>
      <div class="container_show"></div>
    </td>
    <td>
      <input  type="text" class="dp_color" {{COLOR_D}} maxlength="100">
    </td>
    <td>
      <input  type="text" class="dp_size" {{SIZE_D}} maxlength="100">
    </td>
    <td>
      <input  type="text" class="dp_material" {{MATERIAL_D}} maxlength="100">
    </td>
    <td>
      <input  type="text" class="dp_weight" onkeypress="return isNumberKey(event);">
    </td>
    <td>
      <input  type="text" class="dp_cost" maxlength="11" onkeypress="return isNumberKey(event);">
    </td>
    <td>
      <input  type="text" class="dp_instock" onkeypress="return isNumberKey(event);">
    </td>
    <td>
      <span class="btn btn-danger" onclick="$(this).closest('tr').remove();" title="Xóa">
        <i class="fa fa-remove "></i>
      </span>
    </td>
  </tr>
</script>

<script id="js-template-qc-show" type="text/template">
  <tr class="rowqcach">
    <td style="min-width: 100px;">
      <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
        <i class="fa fa-upload"></i> Hình
        <input type="hidden" name="dp_images" class="dp_image" value="{{IMAGE_VAL}}">
        <input type="file" name="dp_full_img" class="dp_image_file" style="display:none">
      </span>
      <div class="container_show">{{IMAGE_SHOW}}</div>
    </td>
    <td>
      <input  type="text" class="dp_color" value="{{COLOR_VAL}}" maxlength="100">
    </td>
    <td>
      <input  type="text" class="dp_size" value="{{SIZE_VAL}}" maxlength="100">
    </td>
    <td>
      <input  type="text" class="dp_material" value="{{MATERIAL_VAL}}" maxlength="100">
    </td>
    <td>
      <input  type="text" class="dp_weight" onkeypress="return isNumberKey(event);" value="{{WEIGHT_VAL}}">
    </td>
    <td>
      <input  type="text" class="dp_cost" maxlength="11" onkeypress="return isNumberKey(event);" value="{{COST_VAL}}">
    </td>
    <td>
      <input  type="text" class="dp_instock" onkeypress="return isNumberKey(event);" value="{{INSTOCK_VAL}}">
    </td>
    <td>
      <span class="btn btn-danger" onclick="$(this).closest('tr').remove();" title="Xóa">
        <i class="fa fa-remove "></i>
      </span>
    </td>
  </tr>
</script>
<!-- end template qc -->

<!-- template pc default -->
<script id="js-template-qc-default" type="text/template">
  <dl class="style-no-value">
    <dt><span class="dot">&#9679;</span>Màu sắc</dt>
    <dl></dl>
  </dl>
  <dl class="style-no-value">
    <dt><span class="dot">&#9679;</span>Chất liệu</dt>
    <dl></dl>
  </dl>
  <dl class="style-no-value">
    <dt><span class="dot">&#9679;</span>Kích thước</dt>
    <dl></dl>
  </dl>
</script>
<!-- end template pc default -->



<?php 

  $result->product->begin_date_sale = date("Y-m-d H:i", $result->product->begin_date_sale);
  $result->product->end_date_sale = date("Y-m-d H:i", $result->product->end_date_sale);
  $result->product->pro_detail = str_replace(array("&gt;", "&lt;", "&quot;", "&amp;"), array(">", "<", '\\"', "&"), $result->product->pro_detail);
  $data_product = json_encode($result);
?>

<script type="text/javascript">
  var $accordion = $(".js-accordion02");
  var $allPanels = $(".accordion-panel02").hide();
  var $allItems = $(".accordion-item02");

  // Event listeners
  $accordion.on("click", ".accordion-toggle02", function() {
      // Toggle the current accordion panel and close others
      $allPanels.slideUp();
      $allItems.removeClass("is-open");
      if ($(this).next().is(":visible")) 
      {
        $(".accordion-panel02").slideUp();
      } 
      else 
      {
        $(this).next().slideDown().closest(".accordion-item02").addClass("is-open");
      }
    return false;
  });

  function escapeSpecialChars(jsonString) {
      return jsonString.replace(/\n/g, "\\n")
          .replace(/\r/g, "\\r")
          .replace(/\t/g, "\\t")
          .replace(/\f/g, "\\f");

  }  
  function crop_image_qc(input) {
    if (input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {

          var image = new Image();
          image.src = e.target.result;
          image.onload = function() {
            if ((this.width <= 600) && (this.height <= 600)) {
                alert('Kích thước ảnh bắt buộc lớn hơn 600 x 600');
            } else {

              $('#modal-pro-qc').find('.active_upload').removeClass('active_upload');
              $(input).addClass('active_upload');
              var img = $('<img id="target_crop_qc">');
              img.attr('src', e.target.result);
              $('#modal-pro-image-qc .crop_image_qc').html(''); 
              $('#modal-pro-image-qc .crop_image_qc').html(img);

              $('#modal-pro-image-qc').modal('show');
              var getWidth = $('#modal-pro-image-qc .modal-body').width();
              var dkrm = new Darkroom('#target_crop_qc', {
                // Size options
                // minWidth: 600,
                // minHeight: 600,
                maxWidth: getWidth,
                maxHeight: 800,
                //ratio: 4/3,
                // backgroundColor: '#000',

                // Plugins options
                plugins: {
                  save: {
                      callback: function() {
                      }
                  },
                  //rotate: false,
                  save: false,
                  crop: {
                    //quickCropKey: 67, //key "c"
                    minHeight: 450,
                    minWidth: 450,
                    ratio: 1
                  }
                },

                // Post initialize script
                initialize: function() {
                  var cropPlugin = this.plugins['crop'];
                  cropPlugin.selectZone(50, 50, 450, 450);
                  // Add custom listener
                  var images_crop = this;

                  $('body').find('.darkroom-toolbar').append('<div class="darkroom-button-group luu_image_qc" style="display:none"><button type="button" class="darkroom-button darkroom-button-default">Lưu</button></div>');

                  this.addEventListener('core:transformation', function() {
                      // images_crop.selfDestroy(); // Cleanup
                      newImage = images_crop.sourceImage.toDataURL(); 
                      //newImage = dkrm.canvas.toDataURL();
                      $('body').find('.darkroom-toolbar .luu_image_qc').attr('data-src', newImage);
                      $('body').find('.darkroom-toolbar .luu_image_qc').show();
                  });
                  
                }
              });

            }
          };
        }
        reader.readAsDataURL(input.files[0]);
    } 
  }

  function parseVideo (url) {
    url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

    if (RegExp.$3.indexOf('youtu') > -1) {
        var type = 'youtube';
    } else if (RegExp.$3.indexOf('vimeo') > -1) {
        var type = 'vimeo';
    }

    return {
        type: type,
        id: RegExp.$6
    };
  }

  function createVideo (url, width, height) {
      // Returns an iframe of the video with the specified URL.
      var videoObj = parseVideo(url);
      var $iframe = $('<iframe>', { width: width, height: height });
      $iframe.attr('frameborder', 0);
      if (videoObj.type == 'youtube') {
          $iframe.attr('src', '//www.youtube.com/embed/' + videoObj.id);
      } else if (videoObj.type == 'vimeo') {
          $iframe.attr('src', '//player.vimeo.com/video/' + videoObj.id);
      }
      return $iframe;
  }

  function getVideoThumbnail (url, cb) {
      // Obtains the video's thumbnail and passed it back to a callback function.
      var videoObj = parseVideo(url);
      if (videoObj.type == 'youtube') {
          cb('//img.youtube.com/vi/' + videoObj.id + '/maxresdefault.jpg');
      } else if (videoObj.type == 'vimeo') {
          // Requires jQuery
          $.get('http://vimeo.com/api/v2/video/' + videoObj.id + '.json', function(data) {
              cb(data[0].thumbnail_large);
          });
      }
  }

  function readURL(input, type_file) {
   for(var i =0; i< input.files.length; i++){
       if (input.files[i]) {
          var reader = new FileReader();
          reader.onload = function (e) {
             var img = $('<img class="dynamic">');
             img.attr('src', e.target.result);
             if (type_file == 'pc') {
                var div_append = $(input).parents('tr').find('.container_show');
                var input_add = $(input).parents('tr').find('.dp_image');
                $(input_add).val(e.target.result);
                $(div_append).html(img);  
             }
             
          }
          reader.readAsDataURL(input.files[i]);
         }
      }
  }


  function isNumberKey(evt){
    var charCode=(evt.which)?evt.which:evt.keyCode;
    return!(charCode!=46&&charCode>31&&(charCode<48||charCode>57));
  }

  function qcColor() {
    if (!$('#qcColor').is(':checked')) {
      if (!$('#qcSize').is(':checked') && !$('#qcMaterial').is(':checked')) {
        $('#qcColor').prop('checked', true);
        alert('Bạn phải có 1 qui cách cho <?php echo $result->text; ?> của bạn!')
      }else {
        $('#modal-pro-qc').find('input.dp_color').val('').prop( "disabled", true );
      }
    } else {
      $('#modal-pro-qc').find('input.dp_color').prop( "disabled", false );
    }
  }

  function qcSize() {
    if (!$('#qcSize').is(':checked')) {
      if (!$('#qcColor').is(':checked') && !$('#qcMaterial').is(':checked')) {
        $('#qcSize').prop('checked', true);
        alert('Bạn phải có 1 qui cách cho <?php echo $result->text; ?> của bạn!')
      }else {
        $('#modal-pro-qc').find('input.dp_size').val('').prop( "disabled", true );
      }
    } else {
      $('#modal-pro-qc').find('input.dp_size').prop( "disabled", false );
    }
  }

  function qcMaterial() {
    if (!$('#qcMaterial').is(':checked')) {
      if (!$('#qcColor').is(':checked') && !$('#qcSize').is(':checked')) {
        $('#qcMaterial').prop('checked', true);
        alert('Bạn phải có 1 qui cách cho <?php echo $result->text; ?> của bạn!')
      }else {
        $('#modal-pro-qc').find('input.dp_material').val('').prop( "disabled", true );
      }
    } else {
      $('#modal-pro-qc').find('input.dp_material').prop( "disabled", false );
    }
  }

  function get_time_difference(start,end)
  {               
      start = new Date(start);
      end = new Date(end);
      var diff = end.getTime() - start.getTime();                 
      var time_difference = new Object();
      time_difference.days = Math.floor(diff/1000/60/60/24);
      diff -= time_difference.days*1000*60*60*24;
      time_difference.hours = Math.floor(diff/1000/60/60);        
      diff -= time_difference.hours*1000*60*60;
      if(time_difference.hours < 10) time_difference.hours = "0" + time_difference.hours;
      time_difference.minutes = Math.floor(diff/1000/60);     
      diff -= time_difference.minutes*1000*60;    
      if(time_difference.minutes < 10) time_difference.minutes = "0" + time_difference.minutes;
      return time_difference;              
  }

  window.money_saleoff = window.giam_qc = 0;
  window.uudai = window.giamgia = window.saleoff_percent = window.saleoff_money = 0;
  var clickat = 0;

  function show_basic(element) {
    var template_basic = $('#js-template-basic').html();

    template_basic = template_basic.replace(/{{PRO_NAME}}/g, data_product.product.pro_name);
    template_basic = template_basic.replace(/{{PRO_BRAND}}/g, data_product.product.pro_brand);
    template_basic = template_basic.replace(/{{PRO_SKU}}/g, data_product.product.pro_sku);
    template_basic = template_basic.replace(/{{PRO_UNIT}}/g, data_product.product.pro_unit);
    
    var pro_made_from = '';
    if (data_product.product.pro_made_from == 1) {
      var pro_made_from = ' - Hàng chính hãng';
    }
    else if (data_product.product.pro_made_from == 2) {
      var pro_made_from = ' - Hàng xách tay';
    }
    else if (data_product.product.pro_made_from == 3) {
      var pro_made_from = ' - Hàng công ty';
    }
    template_basic = template_basic.replace(/{{PRO_MADE_FROM}}/g, pro_made_from);

    if ( data_product.pro_promotion.promotion_list.length == 0 && data_product.pro_promotion.promotion_price.length == 0) {
      template_basic = template_basic.replace(/{{PRO_PROMOTION}}/g, 'c-hide');
    }

    //  giá sp
    var price = parseFloat(data_product.product.pro_cost);
    var price_off = parseFloat(data_product.product.pro_cost);
    

    var saleoff_day = '';
    if (data_product.product.pro_saleoff == 1) {
        // 1 = % , 2 = vnd
        if (data_product.product.pro_saleoff_type == 1) {
          price_off = price - (price * parseFloat(data_product.product.pro_saleoff_value)/ 100);
          saleoff_percent = parseFloat(data_product.product.pro_saleoff_value/ 100).toFixed(2);
        } 
        else if (data_product.product.pro_saleoff_type == 2) {
          price_off = price -  parseFloat(data_product.product.pro_saleoff_value);
          saleoff_money = parseFloat(data_product.product.pro_saleoff_value);
        }

        var diff = get_time_difference(data_product.product.begin_date_sale, data_product.product.end_date_sale);
        saleoff_day = '<img src="/templates/home/styles/images/svg/flashsale_pink.svg" alt=""><span class="time-flash-sale" id="flash-sale_0">';
        if (diff.days > 0) {
          saleoff_day += diff.days + ' ngày ';
        }
        saleoff_day += ' ' + diff.hours +': '+ diff.minutes +': 00</span>';
        // saleoff_day += '<span>('+ data_product.product.begin_date_sale +')</span>';
    }else{
      uudai = 0;
    }
    money_saleoff = price_off;
    
    if (data_product.product.is_product_affiliate == 1) {
        // 1 = % , 2 = vnd
        if (data_product.product.pro_dc_affiliate_type == 1) {
          price_off = price_off - (price_off * parseFloat(data_product.product.pro_dc_affiliate_value)/ 100);
          uudai = giamgia = price_off * parseFloat(data_product.product.pro_dc_affiliate_value)/ 100;
          giamduoc = parseFloat(data_product.product.pro_dc_affiliate_value)/ 100;
        } 
        else if (data_product.product.pro_dc_affiliate_type == 2) {
          price_off = price_off - parseFloat(data_product.product.pro_dc_affiliate_value);
          uudai = giamgia = parseFloat(data_product.product.pro_dc_affiliate_value);
        }
    }
    template_basic = template_basic.replace(/{{PRO_SALEOFF}}/g, saleoff_day);
    var price_show = '';
    if (price_off != price)
    {
      price_show += '<div class="no-sale"><strong class="dong">đ</strong><span>'+parseInt(price).toLocaleString()+'</span></div>';
    }
    price_show += '<div class="sale"><strong class="dong">đ</strong>'+ parseInt(price_off).toLocaleString()+'</div>';
    template_basic = template_basic.replace(/{{PRO_COST}}/g, price_show);
    $('.thong-tin-chung').html(template_basic);
    $('#modal-pro-basic').modal('hide');

  }

  function show_info(element) {
    // danh mục
    var template_info = '<tr><th class="">Danh mục</th><td class="">'+data_product.product.pro_category_name+'</td></tr>';

    // vat
    var content_vat = 'Chưa có VAT';
    if (data_product.product.pro_vat == 1)
    {
      var content_vat = 'Đã có VAT';
    } 
    template_info += '<tr><th class="">VAT</th><td class="">'+content_vat+'</td></tr>';

    // tình trạng
    if (data_product.product.pro_quality == 0 && data_product.product.pro_quality != '')
    {
      template_info += '<tr><th class="">Tình trạng</th><td class="">Mới</td></tr>';
    } 
    else if (data_product.product.pro_quality == 1)
    {
      template_info += '<tr><th class="">Tình trạng</th><td class="">Cũ</td></tr>';
    }

    // xuất xứ
    if (data_product.product.pro_made_from == 1)
    {
      template_info += '<tr><th class="">Xuất xứ</th><td class="">Chính hãng</td></tr>';
    } 
    else if (data_product.product.pro_made_from == 2)
    {
      template_info += '<tr><th class="">Xuất xứ</th><td class="">Xách tay</td></tr>';
    }
    else if (data_product.product.pro_made_from == 3)
    {
      template_info += '<tr><th class="">Xuất xứ</th><td class="">Hàng công ty</td></tr>';
    }

    // nhà sản xuất
    if ( $.trim(data_product.product.pro_mannufacurer) != '')
    {
      template_info += '<tr><th class="">Nhà sản xuất</th><td class="">'+data_product.product.pro_mannufacurer+'</td></tr>';
    } 

    // sản xuất tại
    if ( $.trim(data_product.product.pro_made_in) != '')
    {
      template_info += '<tr><th class="">Sản xuất tại</th><td class="">'+data_product.product.pro_made_in+'</td></tr>';
    }

    // thời hạn bảo hành
    if ( data_product.product.pro_warranty_period > 0 )
    {
      template_info += '<tr><th class="">Thời hạn bảo hành</th><td class="">'+data_product.product.pro_warranty_period+' tháng</td></tr>';
    }

    // bảo hộ người mua
    var content_protection = 'Không';
    if ( data_product.product.pro_protection == 1 )
    {
        content_protection = 'Có'
    }
    template_info += '<tr><th class="">Bảo hộ người mua</th><td class="">'+content_protection+'<img src="/templates/home/styles/images/svg/icon_question.svg" alt=""></td></tr>';
    $('.template-info').html(template_info);
    $('#modal-pro-info').modal('hide');
  }


  function show_specification(element) {
    var str = '';
    if (data_product.product.pro_specification.length > 0) {
        $.each(data_product.product.pro_specification, function( key_link, value_link ) {
            str += '<tr><th class="">'+value_link[0]+'</th><td class="">'+value_link[1]+'</td></tr>';
        });
    }else{
      str = $('#js-template-default-spec').html();
    }
    $('.template-specification').html(str);
    $('#modal-pro-specification').modal('hide');
  }

  window.min_dp_cost = -1;
  function show_qc(element) {
    var s_color = [];
    var s_material = [];
    var s_size   = [];
    var template_qc = '';

    if (data_product.pro_qc.length > 0) {
      var min_dpcost = 0;
      $.each(data_product.pro_qc, function( k_qc, v_qc ) {

          // color
          if (data_product.pro_qc_checkbox.qc_color && $.trim(v_qc['dp_color']) != '' && $.inArray(v_qc['dp_color'], s_color) === -1)
          {
            s_color.push(v_qc['dp_color']);
          }

          // material
          if (data_product.pro_qc_checkbox.qc_size && $.trim(v_qc['dp_size']) != '' && $.inArray(v_qc['dp_size'], s_size) === -1)
          {
            if (s_color.length > 0)
            {
              if (v_qc['dp_color'] == s_color[0]) {
                s_size.push(v_qc['dp_size']);
              }
            }
            else
            {
              s_size.push(v_qc['dp_size']);
            }
          }

          // size
          if (data_product.pro_qc_checkbox.qc_material && $.trim(v_qc['dp_material']) != '' && $.inArray(v_qc['dp_material'], s_material) === -1)
          {
            if (s_color.length > 0 && s_size.length > 0 && v_qc['dp_color'] == s_color[0] && v_qc['dp_size'] == s_size[0])
            {
              s_material.push(v_qc['dp_material']);
            }
            else if (s_color.length > 0 && s_size.length == 0 && v_qc['dp_color'] == s_color[0])
            {
              s_material.push(v_qc['dp_material']);
            }
            else if (s_color.length == 0 && s_size.length > 0 && v_qc['dp_size'] == s_size[0]) 
            {
                s_material.push(v_qc['dp_material']);
            }
            else if (s_color.length == 0 && s_size.length == 0 ) {
              s_material.push(v_qc['dp_material']);
            }
          }

          if(data_product.pro_qc.length == 1){
            min_dpcost = parseInt(v_qc['dp_cost']);
          }
          else{
            for(var i = 0; i < data_product.pro_qc.length; i++){
              if(data_product.pro_qc[i]['dp_cost'] < v_qc['dp_cost'])
              {
                min_dpcost = parseInt(data_product.pro_qc[i]['dp_cost']);
              }
            }
          }   
      });

      if (s_color.length > 0) {
        template_qc += '<dl class=""><dt><span class="dot">&#9679;</span> Màu sắc</dt><dl>';
        template_qc += '<ul class="buttons">';
        $.each(s_color, function( k_s_color, v_s_color ) {
            if (k_s_color == 0) {
              template_qc += '<li class="is-active">'+v_s_color+'</li>';
            }else{
              template_qc += '<li class="">'+v_s_color+'</li>';
            }
        });
        template_qc += '</ul></dl></dl>';
      }

      if (s_size.length > 0) {
        template_qc += '<dl class=""><dt><span class="dot">&#9679;</span> Kích thước</dt><dl>';
        template_qc += '<ul class="buttons">';
        $.each(s_size, function( k_s_size, v_s_size ) {
            if (k_s_size == 0) {
              template_qc += '<li class="is-active">'+v_s_size+'</li>';
            }else{
              template_qc += '<li class="">'+v_s_size+'</li>';
            }
        });
        template_qc += '</ul></dl></dl>';
      }

      if (s_material.length > 0) {
        template_qc += '<dl class=""><dt><span class="dot">&#9679;</span> Chất liệu</dt><dl>';
        template_qc += '<ul class="buttons">';
        $.each(s_material, function( k_s_material, v_s_material ) {
            if (k_s_material == 0) {
              template_qc += '<li class="is-active">'+v_s_material+'</li>';
            }else{
              template_qc += '<li class="">'+v_s_material+'</li>';
            }
        });
        template_qc += '</ul></dl></dl>';
      }

      min_dp_cost = min_dpcost;
      var qc_toithieu = 0;
      if(min_dp_cost > 0){
        giam_qc = money_saleoff = min_dp_cost;
        if($('#modal-pro-basic input.pro_saleoff').is(':checked') == true || data_product.product.pro_saleoff == 1)
        {
          var pro_saleoff_type = 0;
          if($('#modal-pro-basic input.pro_saleoff').is(':checked') == true){
            pro_saleoff_type = $('.pro_saleoff_type').val();
          }else{
            pro_saleoff_type = data_product.product.pro_saleoff_type;
          }
          
          if(pro_saleoff_type == 1){
            giam_qc = money_saleoff = min_dp_cost * (1 - saleoff_percent).toFixed(2);
            qc_toithieu = parseFloat(min_dp_cost * (1 - saleoff_percent).toFixed(2)).toLocaleString();
          }else{
            giam_qc = money_saleoff = min_dp_cost - saleoff_money;
            qc_toithieu = parseInt(min_dp_cost - saleoff_money).toLocaleString();
          }
        }
      }

      if($('#modal-pro-ctv input[name="apply"]:checked').val() > 0){
        var gtlon;
        if(saleoff_percent > 0){
          gtlon = parseInt(uudai / (1 - saleoff_percent).toFixed(2)).toLocaleString();
        }else{
          gtlon = (uudai + saleoff_money).toLocaleString();
        }

        if(giam_qc > 0 && giam_qc < uudai){
          alert('Tất cả giá bán phải lớn hơn '+gtlon+'đ hoặc ưu đãi cộng tác viên phải nhỏ hơn '+qc_toithieu+'đ');
          return false;
        }
      }
    } else {
      template_qc = $('#js-template-qc-default').html();
    }
    $('.pro-qc-content').html(template_qc);
    $('#modal-pro-qc').modal('hide');
  }


  function show_attach(element) {
    
      $('.san-pham-mua-kem .default-style').addClass('style-no-value');
      $('.san-pham-mua-kem-slider').removeClass('slick-initialized slick-slider');
      $('.san-pham-mua-kem-slider').html('');
      if (data_product.product.pro_attach.length > 0) {
        $.ajax({
          url: siteUrl +"product/getProChoose",
          method: "POST",
          data: {product: data_product.product.pro_attach, type : 'view_product'},
          dataType: "json",
          success: function(result) {
            if (result.list_product != "") {
              $('.san-pham-mua-kem .style-no-value').removeClass('style-no-value');
              $('.san-pham-mua-kem-slider').html(result.list_product);
              if($('.san-pham-mua-kem-slider').hasClass('slick-initialized')){
                $('.san-pham-mua-kem-slider').slick('unslick');
              }
              $('body').find('.san-pham-mua-kem-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: false,
                arrows: true,
                infinite: false,
                responsive: [
                {
                  breakpoint: 1025,
                  settings: {
                    slidesToShow: 3
                  }
                },
                /*{
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 2
                  }
                },*/
                {
                  breakpoint: 550,
                  settings: {
                    slidesToShow: 2
                  }
                },
                ]
              });
            }
          }
        });
      }
      $('#modal-pro-attach').modal('hide');
  }

  function show_img_main(element) {
      data_product.product.pro_image = [];
      var get_image = $('#popup-image-list .slider-img-small img');
      var str = '';
      $.each(get_image, function( key_link, value_link ) {
          if(key_link == 0) {
            $('.show-photo-main > img').attr('src', $(this).attr('src'));
            str += '<li><a class="is-active" href="#"><img src="'+$(this).attr('src')+'" alt=""></a></li>';
          } else {
            str += '<li class=""><a class="" href="#"><img src="'+$(this).attr('src')+'" alt=""></a></li>';
          }

          data_product.product.pro_image.push($(this).attr('src')); 
      });

      $('.show-photo-nav .gallery_01').removeClass('slick-initialized slick-slider');
      $('.show-photo-nav .gallery_01').html('');

      if ($('.show-photo-nav .gallery_01').hasClass('slick-initialized')){
        $('.show-photo-nav .gallery_01').slick('unslick');
      }
      $('.show-photo-nav .gallery_01').html(str);
      $('.show-photo-nav .gallery_01').slick({
         autoplay: false,
        arrows: false,
        dots: false,
        slidesToShow: 4,
        speed: 1000,
        infinite: false,
        vertical:true,
        verticalSwiping:true,
        responsive: [
        {
          breakpoint: 768,
          settings: {
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            vertical: false,
            verticalSwiping:false,
            dots: true,
            infinite: true,
          }
        },
        ]
      });
      
  }

  function show_pro_detail(element) {
    $('.add-product-detail').html(data_product.product.pro_detail);
  }

  function show_promo(element) {
    if (data_product.pro_promotion.limit_type == 1) {
        $.each(data_product.pro_promotion.promotion_list, function( key, value ) {
            var element_last = $('#modal-pro-basic .promotion_list_table tbody').find('tr').last();
            key_add = 1;
            if (element_last.length > 0) {
               key_add = parseInt($(element_last).attr('data-key')) + 1;
            }
            var template_row = $('#js-promotion-list-new').html();
            template_row = template_row.replace(/{{KEY}}/g, key_add);
            $('#modal-pro-basic .promotion_list_table tbody').append(template_row);
            $('#modal-pro-basic .promotion_list_table tbody').find('input[name="promotion_list['+key_add+'][limit_from]"]').val(value.limit_from);
            $('#modal-pro-basic .promotion_list_table tbody').find('input[name="promotion_list['+key_add+'][limit_to]"]').val(value.limit_to);
            $('#modal-pro-basic .promotion_list_table tbody').find('input[name="promotion_list['+key_add+'][amount]"]').val(value.amount);
            $('#modal-pro-basic .promotion_list_table tbody').find('select[name="promotion_list['+key_add+'][type]"]').val(value.type);
            $('#quantity-tab').click();
        });

        
    } else {
      $.each(data_product.pro_promotion.promotion_price, function( key, value ) {
        var element_last = $('#modal-pro-basic .promotion_price_table tbody').find('tr').last();
        key_add = 1;
        if (element_last.length > 0) {
           key_add = parseInt($(element_last).attr('data-key')) + 1;
        }
        var template_row = $('#js-promotion-price-new').html();
        template_row = template_row.replace(/{{KEY}}/g, key_add);
        $('#modal-pro-basic .promotion_price_table tbody').append(template_row);
        $('#modal-pro-basic .promotion_price_table tbody').find('input[name="promotion_price['+ key_add+'][limit_from]"]').val(value.limit_from);

        $('#modal-pro-basic .promotion_price_table tbody').find('input[name="promotion_price['+key_add+'][limit_to]"]').val(value.limit_to);

        $('#modal-pro-basic .promotion_price_table tbody').find('input[name="promotion_price['+key_add+'][amount]"]').val(value.amount);
        $('#modal-pro-basic .promotion_price_table tbody').find('select[name="promotion_price['+key_add+'][type]"]').val(value.type);
        $('#price-tab').click();
      });
    }
  }

  function show_category(element) {
    if (data_product.list_get_category.length > 0) {
      $('#infoProduct .swap_category .root_category').remove();
      $.each(data_product.list_get_category, function(key, val) {
            var str = '<select class="root_category select-style w50pc">';
                str += '<option value="0" data-title="">--Chọn danh mục cho <?php echo $result->text; ?>--</option>';
            $.each(val, function(k, v) {
                if (v.active == false)
                {
                  str += '<option data-title="'+ v.cat_name +'" value="' + v.cat_id + '" data-value="'+ v.b2c_fee +'">' + v.cat_name;
                  if (v.child_count > 0)
                  {
                      str += " >"
                  }
                }
                else
                {
                  str += '<option data-title="'+ v.cat_name +'" value="' + v.cat_id + '" data-value="'+ v.b2c_fee +'" selected="selected" >' + v.cat_name;
                  if (v.child_count > 0)
                  {
                      str += " >"
                  }
                }
                str += '</option>';
            });
            str += '</select>';
            $('#infoProduct .swap_category').append(str);

            // if (key == 1) {
            //   $('#fee_cate').text($('.root_category').last().find('option:selected').attr('data-value'));
            // }
      });
    }
  }

  function show_slider_img(element) {
    $('#popup-image-list .slider-img-small').removeClass('slick-initialized slick-slider');
    $('#popup-image-list .slider-img-small').html('');

    if ($('#popup-image-list .slider-img-small').hasClass('slick-initialized')){
      $('#popup-image-list .slider-img-small').slick('unslick');
    }
    $('#popup-image-list .slider-img-small').slick({
          slidesToShow: 8,
          slidesToScroll: 1,
          dots: false,
          arrows: true,
          infinite: false,
          variableWidth: true,
          responsive: [
          {
            breakpoint: 1025,
            settings: {
              slidesToShow: 3
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2
            }
          },
          ]
    });
    if (data_product.product.pro_image.length > 0) {

        $('#popup-image-list .slider-img-big').html('<img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">');

        $.each(data_product.product.pro_image, function( key_link, value_link ) {
            var str = '';
            str += '<div class="item-image-list crop-done">';
            str +=   '<div class="item_image_img">';
            str +=    '<img class="non_scrop" src="'+value_link+'" alt="">';
            str +=   '</div>';
            str +=   '<div class="action-icon">';
            str +=      '<span class="check_crop fail-crop">';
            str +=        '<i class="fa fa-check-circle" aria-hidden="true"></i>';
            str +=      '</span>';
            str +=      '<span>';
            str +=        '<i class="trash-image fa fa-trash" aria-hidden="true"></i>';
            str +=      '</span>';
            str +=    '</div>';
            str += '</div>';
            var currentSlide = $('.slider-img-small').slick('slickCurrentSlide');
            $('#popup-image-list .slider-img-small').slick('slickAdd',str);
            $('#popup-image-list .slider-img-small').slick('slickGoTo', currentSlide + 1);
        });
    }else{
        var template_default = $('#js-template-list-image').html();
        $('#popup-image-list .modal-body').html(template_default);
        $('#popup-image-list .slider-img-small').slick({
            slidesToShow: 8,
            slidesToScroll: 1,
            dots: false,
            arrows: true,
            infinite: false,
            variableWidth: true,
            responsive: [
            {
              breakpoint: 1025,
              settings: {
                slidesToShow: 3
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2
              }
            },
            ]
        });
    }
  }

  
  function show_pro_aff(element) 
  {
    if (data_product.product.is_product_affiliate == 1) 
    {
      $('.js-affsale').removeClass('hidden');
      $('#modal-pro-ctv input[type=radio][value='+ data_product.product.apply +']').prop('checked',true);
      if (data_product.product.pro_dc_affiliate_type == 1) 
      {
        $('#modal-pro-ctv .js-aff-dc-swap .js-rate').addClass('is-open');
        $('#modal-pro-ctv .js-aff-dc-swap .js-rate .special-price-text').show();
        $('#modal-pro-ctv .js-aff-dc-swap .js-rate .js-aff-dc-value').val(data_product.product.pro_dc_affiliate_value);
      } 
      else 
      {
        $('#modal-pro-ctv .js-aff-dc-swap .js-amt').addClass('is-open');
        $('#modal-pro-ctv .js-aff-dc-swap .js-amt .special-price-text').show();
        $('#modal-pro-ctv .js-aff-dc-swap .js-amt .js-aff-dc-value').val(data_product.product.pro_dc_affiliate_value);
      }


      if (data_product.product.pro_affiliate_type == 1) 
      {
        $('#modal-pro-ctv .js-aff-swap .js-rate').addClass('is-open');
        $('#modal-pro-ctv .js-aff-swap .js-rate .special-price-text').show();
        $('#modal-pro-ctv .js-aff-swap .js-rate .special-price-text');
        $('#modal-pro-ctv .js-aff-swap .js-rate .affiliate_value_1').val(data_product.product.affiliate_value_1);
        $('#modal-pro-ctv .js-aff-swap .js-rate .affiliate_value_2').val(data_product.product.affiliate_value_2);
        $('#modal-pro-ctv .js-aff-swap .js-rate .affiliate_value_3').val(data_product.product.affiliate_value_3);
      } 
      else 
      {
        $('#modal-pro-ctv .js-aff-swap .js-amt').addClass('is-open');
        $('#modal-pro-ctv .js-aff-swap .js-amt .special-price-text').show();
        $('#modal-pro-ctv .js-aff-swap .js-amt .affiliate_value_1').val(data_product.product.affiliate_value_1);
        $('#modal-pro-ctv .js-aff-swap .js-amt .affiliate_value_2').val(data_product.product.affiliate_value_2);
        $('#modal-pro-ctv .js-aff-swap .js-amt .affiliate_value_3').val(data_product.product.affiliate_value_3);
      }
      
    }
  }

  function show_pro_condition(element) 
  {
      if (data_product.pro_type == 2) 
      {
        $('#modal-pro-condition .js-time-condition').val(data_product.product.condition_use.time);
        $('#modal-pro-condition .js-duration-condition').val(data_product.product.condition_use.duration);
        $('#modal-pro-condition .js-type-duration-condition').val(data_product.product.condition_use.type_duration);
        $('#modal-pro-condition .js-apply-condition').val(data_product.product.condition_use.apply);
        $('#modal-pro-condition .js-not-apply-condition').val(data_product.product.condition_use.not_apply);
        
        if (data_product.product.condition_use.length > 0) 
        {
          if (data_product.product.condition_use.address.length > 0) 
          {
            $('#modal-pro-condition .address-content').empty();
            $(data_product.product.condition_use.address).each(function( index, value ) {
                if (index == 0) 
                {
                  var str = '<div class="address-content-item">';
                        str += '<input type="text" class="form-control js-address-condition" value="'+value+'">';
                      str += '</div>';
                  $('#modal-pro-condition .address-content').append(str);
                }
                else 
                {
                  var str = '<div class="address-content-item">';
                        str += '<input type="text" class="form-control js-address-condition" value="'+value+'">';
                        str += '<img src="/templates/home/styles/images/svg/close.svg" width="15" class="delete js-btn-delete-condition">';      
                      str += '</div>';
                  $('#modal-pro-condition .address-content').append(str);
                }
            });
          }
        }
      }
  }

  var data_product = {
    'product': {
      'pro_video'       : '',   // video (link youtube or vimeo)
      'pro_image'       : [],   // * list image

      'pro_name'        : '',     // * tên <?php echo $result->text; ?>
      'pro_sku'         : '',     // * mã <?php echo $result->text; ?>
      'pro_brand'       : '',     //   thương hiệu  -  (non database)
      'pro_cost'        : '',     // * giá bán
      'pro_currency'    : 'VND',  // * loại tiền tệ
      'pro_unit'        : '',   // đơn vị bán 
      'pro_instock'     : 0,    // * số lượng trong kho
      'pro_minsale'     : 1,    // * số lượng bán tối thiểu
      'pro_hot'       : 0,    // * <?php echo $result->text; ?> hot
      'pro_weight'      : 0,    // * trọng lượng <?php echo $result->text; ?>

      'pro_descr'       : '',  // wait
      'pro_keyword'     : '',  // wait
      'pro_hondle'        : 0, // wait

      'pro_saleoff'     : 0,    //  <?php echo $result->text; ?> có giảm giá
      'pro_saleoff_value'   : 0,    //  giá trị giảm giá
      'pro_saleoff_type'    : 1,    //  loại giảm giá (1 - %, 2 - VND)
      'begin_date_sale'   : '',   //  ngày bắt đầu giảm giá
      'end_date_sale'     : '',   //  ngày kết thúc giảm giá

      'apply'             : 0,
      'is_product_affiliate'  : 0,    //  <?php echo $text; ?> có Affiliate hay không
      "pro_affiliate_type": 1,      //  loại hoa hồng cho người giới thiệu (2 -VND or 1 - %)
      "affiliate_value_1": 0,  //  giá trị hoa hồng cho người giới thiệu  (1 - nhà phân phối )
      "affiliate_value_2": 0,  //  giá trị hoa hồng cho người giới thiệu (2 - tổng đại lý)
      "affiliate_value_3": 0,  //  giá trị hoa hồng cho người giới thiệu (3 - đại lý )
      "condition_use": {
        'time'      : '',    //  
        'duration'    : '',   // 
        'type_duration'    : '',   //  
        'apply' : '',
        'not_apply': '',
        'address': []
      },
      'pro_dc_affiliate_value': 0,    //  giá trị người mua được giảm
      'pro_dc_affiliate_type' : 1,    //  loại giá trị người mua được giảm (2 -VND or 1 - %)


      'pro_category'      : 0,    // * danh mục <?php echo $result->text; ?>
      'pro_category_name'      : '',    // tên danh mục <?php echo $result->text; ?>
      'pro_mannufacurer'    : '',   // nhà sản xuất
      'pro_made_from'     : '',   // xuất xứ (1 - chính hãng, 2 - xách tay, 3 - hàng công ty)
      'pro_made_in'     : '',   // sản xuất tại
      'pro_vat'       : '',   // * VAT (1 - có , 2 không)
      'pro_quality'     : 0,   // tình trạng (0 - mới, 1 - cũ)
      'pro_warranty_period' : '',    // thời hạn bảo hành
      'pro_protection'    : 0,    // bảo hộ người mua (0 - không, 1 - có) - (non database)
      'pro_detail'      : '',   // * mô tả chi tiết
      'pro_specification'   : [],   // đặc điểm kỹ thuật (non database, key - value)
      'pro_attach'      : [],   // <?php echo $result->text; ?> thường mua kèm
      'pro_attach_temp'      : [],   // <?php echo $result->text; ?> thường mua kèm tem
    },
    'list_name_category'    : '',   // get list category choose show preview
    'list_get_category'   : [],
    'pro_promotion'       : {
      'limit_type'      : 1,    //  loại giá sỉ (1 - số lượng, 2 - số tiền) 
      'promotion_price'    : [],   //  list giá sỉ cho thành viên (giá tiền)
      'promotion_list'    : [],   //  list giá sỉ cho thành viên (số lượng )
    },    
    'pro_qc'          : [],   // list trường quy cách nếu có
    'pro_qc_checkbox'          : [],   // list checkbox qc
    'tab_validate'    : {
      'pro_basic' : false,
      'pro_info'  : false,
      'pro_detail': false
    },
    'pro_gallegy': []
  }

  function init() {
    data_product = <?php echo $data_product; ?>;
    // data_product = JSON.parse(escapeSpecialChars('<?php echo $data_product; ?>'));
    data_product.product.pro_cost = parseInt(data_product.product.pro_cost);
    $('.begin_date_sale').datetimepicker({
      defaultDate: data_product.product.begin_date_sale,
      // minDate: new Date()
    });

    $('.end_date_sale').datetimepicker({
      defaultDate: data_product.product.end_date_sale,
      // minDate: new Date()
    });

    show_promo();
    show_category();
    show_basic();
    show_info();
    show_specification();
    show_qc();
    show_attach();
    show_slider_img();
    show_img_main();
    show_pro_detail();
    show_pro_aff();
    show_pro_condition();
    // $('.save_mutiple_img').click();
    
  }

  $( document ).ready(function() {

      init();

      function check_saleoff(){
        if($('#modal-pro-basic input.pro_saleoff').is(':checked') == true)
        {
          var pro_saleoff_type = $('.pro_saleoff_type').val();
          var pro_saleoff_value = parseInt($('.pro_saleoff_value').val());
          var pro_cost = parseInt($('.pro_cost').val());

          if(min_dp_cost > 0){
            pro_cost = min_dp_cost;
          }
          if(pro_saleoff_type == 1){
            if(pro_saleoff_value >= 100)
            {
              alert('Khuyến mãi phải nhỏ hơn 100%');
              // $('#modal-pro-basic input[name="is_product_affiliate"]').removeAttr('checked'); 
              window.var_error = true;
              $('.pro_saleoff_value').focus();
            }
          }else{
            if(pro_saleoff_value >= pro_cost)
            {
              alert('Khuyến mãi phải nhỏ hơn giá bán');
              // $('#modal-pro-basic input[name="is_product_affiliate"]').removeAttr('checked');
              window.var_error = true;
              $('.pro_saleoff_value').focus();
            }
          }
        }
      }

      function check_valueprice(){
        var pro_saleoff_type = $('.pro_saleoff_type').val();
        var pro_saleoff_value = parseFloat($('.pro_saleoff_value').val());
        var pro_cost = parseInt($('.pro_cost').val());
        if(min_dp_cost > 0){
          pro_cost = min_dp_cost;
        }

        if($('#modal-pro-basic input.pro_saleoff').is(':checked') == true && (pro_saleoff_type == 1 && (pro_saleoff_value >= 100 || (pro_cost * (1 - pro_saleoff_value/100) < uudai)) || (pro_saleoff_type == 2 && (pro_saleoff_value >= pro_cost || (pro_cost - pro_saleoff_value) < uudai))))
        {
          if(pro_saleoff_type == 1)
          {
            if(pro_saleoff_value >= 100){
              alert('Giá khuyến mãi không được lớn hơn 100%');
            }
            else if($('#modal-pro-ctv input[name="apply"]:checked').val() > 0 && (pro_cost * (1 - pro_saleoff_value/100) < uudai)){
              alert('Giá khuyến mãi phải lớn hơn ưu đãi hệ thống bán hộ');
            }
          }
      
          $('#modal-pro-basic input[name="is_product_affiliate"]').removeAttr('checked');
          $('#modal-pro-basic .child_affiliate').hide();
          $('#modal-pro-basic .child_affiliate').addClass('js-is-check');

          $('#modal-pro-basic .promotion_list_table tbody').addClass('hidden');
          $('#modal-pro-basic .promotion_price_table tbody').addClass('hidden');
        }else
        {
          if($('#modal-pro-ctv input[name="apply"]:checked').val() > 0 && uudai > pro_cost)
          {
            alert('Giá bán phải lớn hơn giá ưu đãi hệ thống');
          }

          if($('#modal-pro-basic .child_affiliate').hasClass('js-is-check') == true)
          {
            $('#modal-pro-basic input[name="is_product_affiliate"]').prop('checked', true);
            $('#modal-pro-basic .child_affiliate.js-is-check').show();
          }
          $('#modal-pro-basic .promotion_list_table tbody').removeClass('hidden');
          $('#modal-pro-basic .promotion_price_table tbody').removeClass('hidden');
        }
      }

      // changes saleoff
      $('#modal-pro-basic input[name="pro_saleoff"]').on('change', function() {
        check_valueprice();
        if ($(this).is(':checked')) {
          $('.child_saleoff').show();
        } else {
          $('.child_saleoff').hide();
        }
      });

      // changes affiliate
      $('#modal-pro-basic input[name="is_product_affiliate"]').on('change', function() {
          window.var_error = false;

          if ($(this).is(':checked')) {
            check_saleoff();
            if(var_error == false)
            {
              $('.child_affiliate').show();
              $('.child_affiliate').addClass('js-is-check');
            }
          } else {
            $('.child_affiliate').hide();
            $('.child_affiliate').removeClass('js-is-check');
          }
      });

      $('body').on('click', '#quantity-tab, #price-tab', function(){
        check_valueprice();
      });

      $('#modal-pro-basic .pro_saleoff_type').on('change', function() {
        check_valueprice();
      });

      $('#modal-pro-basic input[name="pro_saleoff_value"]').on('keypress', function() {
        $(this).autocomplete({
          source: function( request, response )
          {
            check_valueprice();
          }
        });
      });

      // add new row promotion_list_new
      $('.promotion_list_new').click(function(){
          window.var_error = false;
          check_saleoff();
          if($(this).hasClass('unlimit') == true){
            alert('Bạn không thể thêm chiết khấu mới khi giá trị Tới là 0');
            var_error = true;
            return false;
          }

          if($('#modal-pro-basic .promotion_list_table tbody').hasClass('hidden') == true)
          {
            alert('Bạn không thể thêm chiết khấu khi giá bán nhỏ hơn ưu đãi cho hệ thống bán hộ');
            var_error = true;
            return false;
          }

          if(var_error == false)
          {
            var element_last = $('#modal-pro-basic .promotion_list_table tbody').find('tr').last();
            key_add = 1;
            if (element_last.length > 0) {
               key_add = parseInt($(element_last).attr('data-key')) + 1;
            }
            var template_row = $('#js-promotion-list-new').html();
            template_row = template_row.replace(/{{KEY}}/g, key_add);
            $('#modal-pro-basic .promotion_list_table tbody').append(template_row);
          }
      });

      // add new row promotion_list_new
      $('.promotion_price_new').click(function(){
          window.var_error = false;
          check_saleoff();
          if($(this).hasClass('unlimit-price') == true){
            alert('Bạn không thể thêm chiết khấu khi giá trị Tới là 0');
            var_error = true;
            return false;
          }

          if($('#modal-pro-basic .promotion_price_new tbody').hasClass('hidden') == true)
          {
            alert('Bạn không thể thêm chiết khấu khi giá bán nhỏ hơn ưu đãi cho hệ thống bán hộ');
            var_error = true;
            return false;
          }

          if(var_error == false)
          {
            var element_last = $('#modal-pro-basic .promotion_price_table tbody').find('tr').last();
            key_add = 1;
            if (element_last.length > 0) {
               key_add = parseInt($(element_last).attr('data-key')) + 1;
            }
            var template_row = $('#js-promotion-price-new').html();
            template_row = template_row.replace(/{{KEY}}/g, key_add);
            $('#modal-pro-basic .promotion_price_table tbody').append(template_row);
          }
      });

      window.var_min = 0;

      function check_min(type, key, this_min, e, mess){
        var key_pre = key - 1;
        var val_min = parseInt($('.max-'+type+key_pre).val());
        var val_max = parseInt($('.max-'+type+key).val());
        var mss_min = '';
        var_min = key;

        if(this_min == 0){
          mss_min += 'Gía trị bạn nhập phải lớn hơn 0';
        }else{
          if(val_min > 0 && key > 1 && this_min <= val_min){
            mss_min += 'Giá trị bạn nhập phải lớn hơn ' + val_min;
          }
          if(val_max > 0 && (key < $(this).length && key > 1 && this_min >= val_max))
          {
            mss_min += ' và nhỏ hơn ' + val_max;
          }
        }            

        if(mss_min != '' && mess == true){
          alert(mss_min);
          $('.min-'+type+key).focus();
          e.preventDefault();
          return false;
        }
      }

      window.var_max = 0;

      function check_max(type, key, this_max, e, mess){
        var key_next = key + 1;
        var val_min = parseInt($('.min-'+type+key).val());
        var min_next = parseInt($('.min-'+type+key_next).val());
        var mss_max = '';
        var_max = key;

        if(val_min > 0 && this_max <= val_min && this_max != 0){
          mss_max += 'Giá trị bạn nhập phải lớn hơn ' + val_min;
        }

        if(min_next > 0 && (key < $(this).length && key > 1 && this_max >= min_next))
        {
          mss_max += ' và nhỏ hơn ' + min_next;
        }

        if($('#quantity').hasClass('show') == true)
        {
          if(this_max === 0){
            $('.promotion_list_new').addClass('unlimit');
          }else{
            $('.promotion_list_new').removeClass('unlimit');
          }
        }

        if($('#price').hasClass('show') == true)
        {
          if(this_max === 0){
            $('.promotion_price_new').addClass('unlimit-price');
          }else{
            $('.promotion_price_new').removeClass('unlimit-price');
          }
        }

        if(mss_max != '' && mess == true){
          alert(mss_max);
          $('.max-'+type+key).focus();
          e.preventDefault();
          return false;
        }
      }

      function out_min_max()
      {
        var $win = $('#modal-pro-basic');

        $win.on("click.Bst", function(event){
          var key_min = parseInt(var_min);
          var key_max = parseInt(var_max);
          if (event.target.dataset.name != 'limit_from' && event.target.dataset.name != 'limit_to' && event.target.nodeName != 'BUTTON')
          {
            var type = 'list';
            if($('#quantity').hasClass('show') == true)
            {
              type = 'list';
            }

            if($('#price').hasClass('show') == true)
            {
              type = 'price';
            }

            var this_min = parseInt($('.min-'+type+key_min).val());
            var this_max = parseInt($('.max-'+type+key_max).val());
            var mess = true;
            if(event.target.id == 'price-tab' || event.target.id == 'quantity-tab'){
              mess = false;
            }
            check_min(type, key_min, this_min, event, mess);
            check_max(type, key_max, this_max, event, mess);
          }
        });
      }

      out_min_max();

      //check so luong si
      $('body').on('keyup', '.promotion_list_table tbody tr .min-list', function(e){
        var key = parseInt($(this).data('key'));
        var this_min = parseInt($(this).val());
        check_min('list', key, this_min, e, false);
      });

      $('body').on('keyup', '.promotion_list_table tbody tr .max-list', function(e){
        var key = parseInt($(this).data('key'));
        var this_max = parseInt($(this).val());
        check_max('list', key, this_max, e, false);
      });

      //check so tien nhap giam si
      $('body').on('keyup', '.promotion_price_table tbody tr .min-price', function(e){
        var key = parseInt($(this).data('key'));
        var this_min = parseInt($(this).val());
        check_min('price', key, this_min, e, false);
      });

      $('body').on('keyup', '.promotion_price_table tbody tr .max-price', function(e){
        var key = parseInt($(this).data('key'));
        var this_max = parseInt($(this).val());
        check_max('price', key, this_max, e, false);
      });
      
      //  popup basic product
      $('body').on('click', '.modal-pro-basic', function() {
        $('#modal-pro-basic input.pro_name').val(data_product.product.pro_name);
        $('#modal-pro-basic input.pro_sku').val(data_product.product.pro_sku);
        $('#modal-pro-basic input.pro_brand').val(data_product.product.pro_brand);
        $('#modal-pro-basic input.pro_unit').val(data_product.product.pro_unit);
        $('#modal-pro-basic select.pro_currency').val(data_product.product.pro_currency);
        $('#modal-pro-basic input.pro_instock').val(data_product.product.pro_instock);
        $('#modal-pro-basic input.pro_minsale').val(data_product.product.pro_minsale);
        $('#modal-pro-basic input.pro_weight').val(data_product.product.pro_weight);
        $('#modal-pro-basic input.pro_cost').val(data_product.product.pro_cost);
        if (data_product.product.pro_hot == 1) {
          $('#modal-pro-basic input.pro_hot').prop('checked', true);
        } else {
          $('#modal-pro-basic input.pro_hot').prop('checked', false);
        }
        

        // saleoff
        $('#modal-pro-basic input.pro_saleoff_value').val(data_product.product.pro_saleoff_value);
        $('#modal-pro-basic select.pro_saleoff_type').val(data_product.product.pro_saleoff_type);
        $('#modal-pro-basic input.begin_date_sale').val(data_product.product.begin_date_sale);
        $('#modal-pro-basic input.end_date_sale').val(data_product.product.end_date_sale);

        if (data_product.product.pro_saleoff == 1) {
          $('#modal-pro-basic input.pro_saleoff').prop('checked', true);
          $('.child_saleoff').show();
        } else {
          if($('#modal-pro-basic input.pro_saleoff').prop('checked') == false){
            $('.child_saleoff').hide();
          }
          // $('#modal-pro-basic input.pro_saleoff').prop('checked', false);
        }

        // affiliate
        $('#modal-pro-basic input.pro_affiliate_value').val(data_product.product.pro_affiliate_value);
        $('#modal-pro-basic select.pro_affiliate_type').val(data_product.product.pro_affiliate_type);
        $('#modal-pro-basic input.pro_dc_affiliate_value').val(data_product.product.pro_dc_affiliate_value);
        $('#modal-pro-basic select.pro_dc_affiliate_type').val(data_product.product.pro_dc_affiliate_type);
        if (data_product.product.is_product_affiliate == 1) {
          $('#modal-pro-basic input.is_product_affiliate').prop('checked', true);
          $('.child_affiliate').show();
        } else {
          $('#modal-pro-basic input.is_product_affiliate').prop('checked', false);
          $('.child_affiliate').hide();
        }
        $('.error_input').hide();
        $('#modal-pro-basic').modal('show');
      });
      

      $('#modal-pro-basic .save-basic').click(function(e){
          $('.error_input').hide();
          var error_basic = false;

          var pro_name = $('#modal-pro-basic input.pro_name').val();
          var pro_sku  = $('#modal-pro-basic input.pro_sku').val();
          var pro_brand  = $('#modal-pro-basic input.pro_brand').val();
          var pro_cost   = $('#modal-pro-basic input.pro_cost').val();
          var pro_unit  = $('#modal-pro-basic input.pro_unit').val();
          var pro_currency  = $('#modal-pro-basic select.pro_currency').val();
          var pro_instock  = $('#modal-pro-basic input.pro_instock').val();
          var pro_minsale  = $('#modal-pro-basic input.pro_minsale').val();
          var pro_weight  = $('#modal-pro-basic input.pro_weight').val();
          var pro_hot = 0;
          if ($('#modal-pro-basic input.pro_hot').is(':checked')) {
            pro_hot = 1;
          }

          // saleoff
          var pro_saleoff_value = parseFloat($('#modal-pro-basic input.pro_saleoff_value').val());
          var pro_saleoff_type  = $('#modal-pro-basic select.pro_saleoff_type').val();
          var begin_date_sale = $('#modal-pro-basic input.begin_date_sale').val();
          var end_date_sale = $('#modal-pro-basic input.end_date_sale').val();
          var pro_saleoff = 0;
          var giacuoi = parseInt(pro_cost);
          if(min_dp_cost > 0){
            giacuoi = parseInt(min_dp_cost);
          }
          clickat = 1;

          if ($('#modal-pro-basic input.pro_saleoff').is(':checked')) {
            if($('#modal-pro-basic input.pro_saleoff_value').val() == ''){
              $('#modal-pro-basic .error_pro_saleoff').text('Bạn chưa nhập khuyến mãi');
              $('#modal-pro-basic .error_pro_saleoff').show();
              $('.pro_saleoff_value').focus();
              error_basic = true;
              e.preventDefault();
              return false;
            }

            if (isNaN(Date.parse(begin_date_sale)) || isNaN(Date.parse(end_date_sale)) || begin_date_sale == '' || end_date_sale == '') {
              $('#modal-pro-basic .error_two_day').text('Vui lòng nhập ngày khuyến mãi.');
              $('#modal-pro-basic .error_two_day').show();
              error_basic = true;
              e.preventDefault();
              return false;
            } else{
              if(Date.parse(end_date_sale) <= Date.parse(begin_date_sale)){
                  $('#modal-pro-basic .error_two_day').text('Ngày kết thúc khuyến mãi cần lớn hơn ngày bắt đầu.');
                  $('#modal-pro-basic .error_two_day').show();
                  $('.pro_saleoff_value').focus();
                  error_basic = true;
                  e.preventDefault();
                  return false;
              }
            }
            pro_saleoff = 1;

            if (pro_saleoff_type == 1)
            {
                if (pro_saleoff_value > 100)
                {
                  $('#modal-pro-basic .error_pro_saleoff').text('Phần trăm giảm giá không được lớn hơn 100%.');
                  $('#modal-pro-basic .error_pro_saleoff').show();
                  error_basic = true;
                  $('.pro_saleoff_value').focus();
                  e.preventDefault();
                  return false;
                }
            }
            else{
                if(parseInt(pro_saleoff_value + uudai) > giacuoi){
                    $('#modal-pro-basic .error_pro_saleoff').text('Số tiền giảm giá không được lớn hơn giá gốc của sản phẩm');
                    $('#modal-pro-basic .error_pro_saleoff').show();
                    error_basic = true;
                    $('.pro_saleoff_value').focus();
                    e.preventDefault();
                    return false;
                }
            }
          }

          if($.trim(pro_name) == '')
          {
            $('#modal-pro-basic .error_pro_name').show();
            error_basic = true;
            $('#modal-pro-basic input.pro_name').focus();
            e.preventDefault();
            return false;
          }

          if($.trim(pro_sku) == '')
          {
            $('#modal-pro-basic .error_pro_sku').show();
            error_basic = true;
            $('#modal-pro-basic input.pro_sku').focus();
            e.preventDefault();
            return false;
          }
          
          if($.trim(pro_cost) == '')
          {
            $('#modal-pro-basic .error_pro_cost').text('Vui lòng giá <?php echo $result->text; ?>.');
            $('#modal-pro-basic .error_pro_cost').show();
            $('#modal-pro-basic input.pro_cost').focus();
            error_basic = true;
            return false;
          } else if (pro_cost == 0) {
            $('#modal-pro-basic .error_pro_cost').text('Giá <?php echo $result->text; ?> lớn hơn 0.');
            $('#modal-pro-basic .error_pro_cost').show();
            $('#modal-pro-basic input.pro_cost').focus();
            error_basic = true;
            e.preventDefault();
            return false;
          }
          
          if($.trim(pro_instock) == '')
          {
            $('#modal-pro-basic .error_pro_instock').text('Vui lòng nhập số lượng.');
            $('#modal-pro-basic .error_pro_instock').show();
            $('#modal-pro-basic input.pro_instock').focus();
            error_basic = true;
            e.preventDefault();
            return false;
          } else if (pro_instock == 0) {
            $('#modal-pro-basic .error_pro_instock').text('Số lượng lớn hơn 0.');
            $('#modal-pro-basic .error_pro_instock').show();
            $('#modal-pro-basic input.pro_instock').focus();
            error_basic = true;
            e.preventDefault();
            return false;
          }
          if($.trim(pro_minsale) == '')
          {
            $('#modal-pro-basic .error_pro_minsale').text('Vui lòng nhập số lượng bán tối thiểu.');
            $('#modal-pro-basic .error_pro_minsale').show();
            $('#modal-pro-basic input.pro_minsale').focus();
            error_basic = true;
            e.preventDefault();
            return false;
          } else if (pro_minsale == 0) {
            $('#modal-pro-basic .error_pro_minsale').text('Số lượng bán tối thiểu lớn hơn 0.');
            $('#modal-pro-basic .error_pro_minsale').show();
            $('#modal-pro-basic input.pro_minsale').focus();
            error_basic = true;
            e.preventDefault();
            return false;
          }
          
          if( $('#modal-pro-basic input.pro_weight').length > 0 && $.trim(pro_weight) == '')
          {
            $('#modal-pro-basic .error_pro_weight').text('Vui lòng nhập trọng lượng <?php echo $result->text; ?>.');
            $('#modal-pro-basic .error_pro_weight').show();
            $('#modal-pro-basic input.pro_weight').focus();
            error_basic = true;
            e.preventDefault();
            return false;
          } 
          else if (pro_weight == 0) 
          {
            $('#modal-pro-basic .error_pro_weight').text('Trọng lượng <?php echo $result->text; ?> lớn hơn 0.');
            $('#modal-pro-basic .error_pro_weight').show();
            $('#modal-pro-basic input.pro_weight').focus();
            error_basic = true;
            e.preventDefault();
            return false;
          }

          if($('#modal-pro-basic input.pro_saleoff').is(':checked') == true && ((pro_saleoff_type == 1 && (pro_saleoff_value >= 100 || (giacuoi * (1 - (pro_saleoff_value/100))) < uudai)) || (pro_saleoff_type == 2 && (pro_saleoff_value >= giacuoi || (giacuoi - pro_saleoff_value) < uudai))))
          {

            if(pro_saleoff_type == 1)
            {
              if(pro_saleoff_value >= 100){
                alert('Giá khuyến mãi không được lớn hơn 100%');
                return false;
              }
              else if(giacuoi * (1 - (pro_saleoff_value/100)) < uudai){
                alert('Giá khuyến mãi phải lớn hơn ưu đãi hệ thống bán hộ');
                return false;
              }
            }
            $('#modal-pro-basic input[name="is_product_affiliate"]').removeAttr('checked');
            $('#modal-pro-basic .child_affiliate').hide();
            $('#modal-pro-basic .child_affiliate').addClass('js-is-check');

            $('#modal-pro-basic .promotion_list_table tbody').addClass('hidden');
            $('#modal-pro-basic .promotion_price_table tbody').addClass('hidden');
          }else
          {
            if(uudai > giacuoi)
            {
              alert('Giá bán phải lớn hơn giá ưu đãi hệ thống');
              return false;
            }

            if($('#modal-pro-basic .child_affiliate').hasClass('js-is-check') == true)
            {
              $('#modal-pro-basic input[name="is_product_affiliate"]').prop('checked', true);
              $('#modal-pro-basic .child_affiliate.js-is-check').show();
            }
            $('#modal-pro-basic .promotion_list_table tbody').removeClass('hidden');
            $('#modal-pro-basic .promotion_price_table tbody').removeClass('hidden');
          }
          
          if($('#modal-pro-basic .promotion_list_table tbody').hasClass('hidden') == false && $('.promotion_list_table tbody tr').length > 0)
          {
            
            if($('#quantity').hasClass('show') == true)
            {
              empty_promotion = false;
              var length = $('.promotion_list_table tbody tr').length;

              $('.promotion_list_table tbody tr').each(function(e)
              {
                var i = $(this).index();
                var key_i = $(this).data('key');
                var min_cur = parseInt($('.min-list'+key_i).val());
                var max_cur = parseInt($('.max-list'+key_i).val());
                var mess_mm = '';

                if(i == 0){
                  if(min_cur == 0){
                    mess_mm = 'Giá trị bạn nhập phải lớn hơn 0';
                    $('.min-list'+key_i).focus();
                  }
                  else{
                    if(max_cur == 0 && length == 1){
                      // mess_mm = 'Khi bạn nhập giá trị Tới = 0, Bạn không thể thêm chiết khấu mới';
                      // $('.max-list'+i).focus();
                      // $('.promotion_list_new').addClass('unlimit');
                    }
                    else{
                      if(min_cur >= max_cur){
                        mess_mm = 'Giá trị bạn nhập phải lớn hơn ' + min_cur;
                        $('.max-list'+key_i).focus();
                      }
                    }
                  }
                  
                  if(mess_mm != ''){
                    alert(mess_mm);
                    error_basic = true;
                    e.preventDefault();
                    return false;
                  }
                }
                else{
                  for(var j = i-1; j >= 0; j--){
                    var key_j = $('.promotion_list_table tbody tr').eq(j).data('key');
                    var min_pre = parseInt($('.min-list'+key_j).val());
                    var max_pre = parseInt($('.max-list'+key_j).val());

                    if(min_cur <= max_pre){
                      mess_mm = 'Giá trị bạn nhập phải lớn hơn '+max_pre;
                      $('.min-list'+key_i).focus();
                    }else{
                      if(min_cur >= max_cur && (i <= length - 1) && max_cur > 0){
                        mess_mm = 'Giá trị bạn nhập phải lớn hơn '+min_cur;
                        $('.max-list'+key_i).focus();
                      }
                    }

                    if(mess_mm != '')
                    {
                      alert(mess_mm);
                      error_basic = true;
                      e.preventDefault();
                      return false;
                    }
                  }
                }
              });

              $('.promotion_list_table tbody tr input[type="text"]').each(function(e)
              {
                if($(this).val() == ''){
                  empty_promotion = true;
                  alert('Bạn phải nhập đầy đủ thông tin ở mục Chiết khấu cho thành viên');
                  error_basic = true;
                  return false;
                }
                else
                {
                  var at = parseInt($(this).data('key'));
                  var max_num = parseInt($('.max-list'+at).val());
                  var style = $('.js-style'+at).val();

                  if(style == 2){
                    var percent_si = $('.giam-si'+at).val();
                    if(percent_si > 100)
                    {
                      alert('Phần trăm giảm sỉ không được lớn hơn 100%');
                      $('.giam-si'+at).focus();
                      error_basic = true;
                      return false;
                    }
                  }
                  else{

                    if($('#modal-pro-basic input.pro_saleoff').is(':checked') == true)
                    {
                      if(min_dp_cost > 0){
                        price_check = min_dp_cost;
                      }else{
                        price_check = pro_cost;
                      }

                      if(pro_saleoff_type == 1)
                      {
                        money_saleoff = price_check * parseFloat(1 - (pro_saleoff_value/100)).toFixed(2);
                      }else{
                        money_saleoff = price_check - pro_saleoff_value;
                      }
                    }

                    if(max_num > 0 && style == 1 && money_saleoff > 0){
                      var price_si = parseInt(money_saleoff * max_num);
                      var giamsi = parseInt($('.giam-si'+at).val());
                      if(giamsi > price_si)
                      {
                        alert('Giá giảm sỉ phải nhỏ hơn '+parseInt(money_saleoff * max_num).toLocaleString()+'đ');
                        $('.giam-si'+at).focus();
                        error_basic = true;
                        return false;
                      }
                    }
                  }
                }
              });
            }
          }

          if($('#modal-pro-basic .promotion_price_table tbody').hasClass('hidden') == false && $('.promotion_price_table tbody tr').length > 0)
          {
            
            if($('#price').hasClass('show') == true)
            {
              var length = $('.promotion_price_table tbody tr').length;
              
              $('.promotion_price_table tbody tr').each(function(ev)
              {
                var i = $(this).index();
                var key_i = $(this).data('key');
                var min_cur = parseInt($('.min-price'+key_i).val());
                var max_cur = parseInt($('.max-price'+key_i).val());
                var mess_mm = '';
                if(i == 0){
                  if(min_cur == 0){
                    mess_mm = 'Giá trị bạn nhập phải lớn hơn 0';
                    $('.min-price'+key_i).focus();
                  }
                  else{
                    if(max_cur == 0 && length == 1){
                      // mess_mm = 'Khi bạn nhập giá trị Tới = 0, Bạn không thể thêm chiết khấu mới';
                      // $('.max-price'+i).focus();
                      // $('.promotion_price_new').addClass('unlimit');
                    }
                    else{
                      if(min_cur >= max_cur){
                        mess_mm = 'Giá trị bạn nhập phải lớn hơn ' + min_cur;
                        $('.max-price'+key_i).focus();
                      }
                    }
                  }
                  
                  if(mess_mm != ''){
                    alert(mess_mm);
                    error_basic = true;
                    return false;
                  }
                }
                else{
                  for(var j = i-1; j >= 0; j--){
                    var key_j = $('.promotion_price_table tbody tr').eq(j).data('key');
                    var min_pre = parseInt($('.min-price'+key_j).val());
                    var max_pre = parseInt($('.max-price'+key_j).val());

                    if(min_cur <= max_pre){
                      mess_mm = 'Giá trị bạn nhập phải lớn hơn '+max_pre;
                      $('.min-price'+key_i).focus();
                    }else{
                      if(min_cur >= max_cur && (i <= length - 1) && max_cur > 0){
                        mess_mm = 'Giá trị bạn nhập phải lớn hơn '+min_cur;
                        $('.max-price'+key_i).focus();
                      }
                    }

                    if(mess_mm != '')
                    {
                      alert(mess_mm);
                      error_basic = true;
                      return false;
                    }
                  }
                }
              });

              $('.promotion_price_table tbody tr input[type="text"]').each(function(ev)
              {
                if($(this).val() == ''){
                  empty_promotion_price = true;
                  alert('Bạn phải nhập đầy đủ thông tin ở mục Chiết khấu cho thành viên');
                  error_basic = true;
                  return false;
                }
                else
                {
                  var at = parseInt($(this).data('key'));
                  var max_num = parseInt($('.max-price'+at).val());
                  var style = $('.js-style-price'+at).val();

                  
                  if(style == 2){
                    var percent_si_price = $('.giam-si-price'+at).val();
                    if(percent_si_price > 100)
                    {
                      alert('Phần trăm giảm sỉ không được lớn hơn 100%');
                      $('.giam-si-price'+at).focus();
                      error_basic = true;
                      return false;
                    }
                  }
                  else{
                    if(max_num > 0 && style == 1){
                      var giamsi_price = parseInt($('.giam-si-price'+at).val());

                      if(giamsi_price > max_num)
                      {
                        alert('Giá giảm sỉ phải nhỏ hơn '+parseInt(max_num).toLocaleString()+'đ');
                        $('.giam-si-price'+at).focus();
                        error_basic = true;
                        return false;
                      }
                    }
                  }
                }
              });
            }
          }

          if (error_basic == false) {
            data_product.product.pro_name   = pro_name;
            data_product.product.pro_sku    = pro_sku;
            data_product.product.pro_brand  = pro_brand;
            data_product.product.pro_unit   = pro_unit;
            data_product.product.pro_currency = pro_currency;
            data_product.product.pro_instock  = pro_instock;
            data_product.product.pro_minsale  = pro_minsale;
            data_product.product.pro_weight   = pro_weight;
            data_product.product.pro_cost   = pro_cost;
            
            if (pro_hot == 1) {
              data_product.product.pro_hot = 1;
            } else {
              data_product.product.pro_hot = 0;
            }

            // saleoff
            data_product.product.pro_saleoff_value = pro_saleoff_value;
            data_product.product.pro_saleoff_type  = pro_saleoff_type;
            data_product.product.begin_date_sale   = begin_date_sale;
            data_product.product.end_date_sale     = end_date_sale;

            if (pro_saleoff == 1) {
              data_product.product.pro_saleoff = 1;
            } else {
              data_product.product.pro_saleoff = 0;
            }


            // affiliate
            // data_product.product.pro_affiliate_value = pro_affiliate_value;
            // data_product.product.pro_affiliate_type  = pro_affiliate_type;
            // data_product.product.pro_dc_affiliate_value = pro_dc_affiliate_value; 
            // data_product.product.pro_dc_affiliate_type = pro_dc_affiliate_type;

            // if (is_product_affiliate == 1) {
            //   data_product.product.is_product_affiliate = 1;
            // } else {
            //   data_product.product.is_product_affiliate = 0;
            // }
            if($('#modal-pro-basic input.pro_saleoff').is(':checked') == true)
            {
              if (pro_saleoff_type == 1)
              {
                var percent = parseFloat(1 - pro_saleoff_value / 100).toFixed(2);
                money_saleoff = pro_cost * percent;
                if(min_dp_cost > 0){
                  giam_qc = min_dp_cost * percent;
                }
              }
              else{
                money_saleoff = pro_cost - pro_saleoff_value;
                if(min_dp_cost > 0){
                  giam_qc = min_dp_cost - pro_saleoff_value;
                }
              }
            }

            // promotion type
            var saleTab = $('#saleTab').find('.nav-item .active').attr('data-id');
            data_product.pro_promotion.limit_type = parseInt(saleTab);

            // promotion list
            data_product.pro_promotion.promotion_list = [];
            var promotion_list = $(".promotion_list_table tbody").find('tr');
            if($('#modal-pro-basic .promotion_list_table tbody').hasClass('hidden') == false && promotion_list.length > 0) {
              $.each(promotion_list, function( key_link, value_link ) {
                  var list_input = $(this).find('[name^="promotion_list"]');
                  if (list_input.length > 0) {
                    var promotion_data = {};
                    $.each(list_input, function( key_link, value_link ) {
                        promotion_data[$(this).attr('data-name')] = $(this).val();
                    });
                    data_product.pro_promotion.promotion_list.push(promotion_data);
                  }          
              });
            }

            // promotion price
            data_product.pro_promotion.promotion_price = [];
            var promotion_price = $(".promotion_price_table tbody").find('tr');
            if($('#modal-pro-basic .promotion_price_table tbody').hasClass('hidden') == false && promotion_price.length > 0) {
              $.each(promotion_price, function( key_link, value_link ) {
                  var list_input = $(this).find('[name^="promotion_price"]');
                  if (list_input.length > 0) {
                    var promotion_data = {};
                    $.each(list_input, function( key_link, value_link ) {
                        promotion_data[$(this).attr('data-name')] = $(this).val();
                    });
                    data_product.pro_promotion.promotion_price.push(promotion_data);
                  }          
              });
            }
            // data_product.tab_validate.pro_basic = true;
            show_basic();
          }
      });

      // popup product info 
      $('body').on('click', '.modal-pro-info', function() {
        $('.error_input').hide();

        $('#modal-pro-info input.pro_category').val(data_product.product.pro_category);
        $('#modal-pro-info input.pro_category').attr('data-title',data_product.product.pro_category_name);
        $('#modal-pro-info select.pro_vat').val(data_product.product.pro_vat);
        $('#modal-pro-info select.pro_quality').val(data_product.product.pro_quality);
        $('#modal-pro-info select.pro_made_from').val(data_product.product.pro_made_from);
        $('#modal-pro-info input.pro_mannufacurer').val(data_product.product.pro_mannufacurer);
        $('#modal-pro-info input.pro_made_in').val(data_product.product.pro_made_in);
        $('#modal-pro-info input.pro_warranty_period').val(data_product.product.pro_warranty_period);
        // $('#modal-pro-info select.pro_protection').val(data_product.product.pro_protection);
        $('#modal-pro-info input.pro_video').val(data_product.product.pro_video);

        if ($.trim(data_product.list_name_category) != '') {
          $('.swap_category').html(data_product.list_name_category);
        }

        $('#modal-pro-info').modal('show');
      });


      $('body').on('change', '.root_category', function(){
          var _this = $(this);

          // if ($(this ).index() == 0) {
          //   $('#fee_cate').text(0);
          // } else if ( $(this ).index() == 1) {
          //   $('#fee_cate').text($(this).find('option:selected').attr('data-value'));
          // }

          $(this).find('option[selected="selected"]').removeAttr('selected');
          $(_this).nextAll('select').remove();
          var category_id = $(this).val();
          var category_title = $(this).find('option:selected').attr('data-title');
          $(this).find('option:selected').attr('selected', 'selected');
          $(".pro_category").val(0); 
          $(".pro_category").attr('data-title', '');

          if (category_id != 0) {
            $.ajax({
              type: "POST",
              url: siteUrl + "product/ajax",
              data: "parent_id=" + category_id,
              dataType: "json",
              success: function (r) {
                  if (r[1] > 0) {
                      str = '<select class="root_category select-style w50pc">';
                      str += '<option data-title="" value="0">--Chọn danh mục cho <?php echo $result->text; ?>--</option>';
                      for (i = 0; i < r[1]; i++) {
                          str += '<option data-title="'+ r[0][i].cat_name +'" value="' + r[0][i].cat_id + '" data-value="'+ r[0][i].b2c_fee +'">' + r[0][i].cat_name;
                          if (r[0][i].child_count > 0) {
                              str += " >"
                          }
                          str += "</option>"
                      }
                      str += "</select>";
                      $( str ).insertAfter( $(_this) );
                  } else {
                      $(".pro_category").val(category_id);
                      $(".pro_category").attr('data-title', $.trim(category_title));
                  }
              },
              error: function () {
                  alert("No Data!")
              }
            })
          }
      });

      $('body').on('click', '#modal-pro-info .save-basic', function() {
        $('.error_input').hide();
        var pro_category = $('#modal-pro-info .pro_category').val();
        var pro_category_name = $('#modal-pro-info .pro_category').attr('data-title');
        var pro_vat = $('#modal-pro-info .pro_vat').val();
        var pro_quality = $('#modal-pro-info .pro_quality').val();
        var pro_made_from = $('#modal-pro-info .pro_made_from').val();
        var pro_mannufacurer = $('#modal-pro-info .pro_mannufacurer').val();
        var pro_made_in = $('#modal-pro-info .pro_made_in').val();
        var pro_warranty_period = $('#modal-pro-info .pro_warranty_period').val();
        // var pro_protection = $('#modal-pro-info .pro_protection').val(); 
        var pro_video =  $('#modal-pro-info input.pro_video').val();
        var error_basic = false;
        if (pro_category == 0 || pro_category == '') {
          $('#modal-pro-info .error_pro_category').show();
          error_basic = true;
        }

        if (pro_vat == 0 || pro_vat == '') {
          $('#modal-pro-info .error_pro_vat').show();
          error_basic = true;
        }

        if ($.trim(pro_video) != '') {
          pro_video.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

          var type_video = '';
          if (RegExp.$3.indexOf('youtu') > -1) {
              type_video = 'youtube';
          } else if (RegExp.$3.indexOf('vimeo') > -1) {
              type_video = 'vimeo';
          }
          
          if (type_video != 'youtube' && type_video != 'vimeo')
          { 
            $('#modal-pro-info .error_pro_video').show();
            error_basic = true;
          } 
        }

        if (error_basic != true) {
          data_product.product.pro_category = pro_category;
          data_product.product.pro_vat = pro_vat;
          data_product.product.pro_quality = pro_quality;
          data_product.product.pro_made_from = pro_made_from;
          data_product.product.pro_mannufacurer = pro_mannufacurer;
          data_product.product.pro_made_in = pro_made_in;
          data_product.product.pro_warranty_period = pro_warranty_period;
          // data_product.product.pro_protection = pro_protection;
          data_product.product.pro_category_name = pro_category_name;
          data_product.list_name_category = $('.swap_category').html();
          data_product.product.pro_video = pro_video;
          // data_product.tab_validate.pro_info = true;
          show_info();
        }
      });

      // popup product specification
      $('body').on('click','.modal-pro-specification', function(){
        $('.error_input').hide();
        var str = '';
        if (data_product.product.pro_specification.length > 0) {
          $.each(data_product.product.pro_specification, function( key_link, value_link ) {
              str += '<tr><td><input value="'+value_link[0]+'" name="" type="text" class="spec_label"></td><td><input value="'+value_link[1]+'" name="" type="text" class="spec_val"></td><td><span class="btn btn-danger" title="Xóa" onclick="$(this).closest(\'tr\').remove();"><i class="fa fa-remove "></i></span></td></tr>';
          });
        }
        $('#specification table tbody').html(str);

        $('#modal-pro-specification').modal('show');
      });

      $('body').on('click', '.specification-new', function(){
        var template_row = $('#js-template-specitifi').html();
        $('#modal-pro-specification table tbody').append(template_row);
      });

      $('body').on('click', '#modal-pro-specification .save-basic', function() {
        $('.error_input').hide();
        var error_basic = false;
        $('#modal-pro-specification .error_input_spec').removeClass('error_input_spec');
        var list_tr = $('#modal-pro-specification table tbody').find('tr');
        var list_data = [];
        if (list_tr.length > 0) {
          $.each(list_tr, function( key_link, value_link ) {
                  var spec_label = $(this).find('.spec_label');
                  var spec_val = $(this).find('.spec_val');
                  if ($.trim($(spec_label).val()) == '') {
                    $(spec_label).addClass('error_input_spec');
                    error_basic = true;
                  }
                  if ($.trim($(spec_val).val()) == '') {
                    $(spec_val).addClass('error_input_spec');
                    error_basic = true;
                  }

                  if ($.trim($(spec_label).val()) != '' && $.trim($(spec_val).val()) != '') {
                    list_data.push([$(spec_label).val(), $(spec_val).val()]);
                  }
              });
        }
        data_product.product.pro_specification = list_data;
        if (error_basic != true) {
          show_specification();
          $('#modal-pro-specification').modal('hide');
        }
      });


      //  popup product detail
      $('body').on('click', '.modal-pro-detail', function(){
        $('#modal-pro-detail .pro_descr').val(data_product.product.pro_descr);
        $('#modal-pro-detail .pro_keyword').val(data_product.product.pro_keyword);
        tinyMCE.get('pro_detail').setContent(data_product.product.pro_detail);
        
        $('#modal-pro-detail').modal('show');
      });

      //
      $('#modal-pro-detail .save-basic').click(function(){
        $('#modal-pro-detail .error_pro_detail').hide();
        $('#modal-pro-detail .error_pro_keyword').hide();
        $('#modal-pro-detail .error_pro_descr').hide();
        var pro_detail = tinyMCE.get('pro_detail').getContent();
        var pro_descr = $('#modal-pro-detail .pro_descr').val();
        var pro_keyword = $('#modal-pro-detail .pro_keyword').val();
        var descr = pro_detail.replace(/<\/?[^>]+(>|$)/g, "");
        
        var error_check = false;
 
        if ($.trim(pro_detail) == '' || descr.length < 100)
        {
          $('#modal-pro-detail .error_pro_detail').text('Bạn phải nhập mô tả sản phẩm từ 100 ký tự trở lên');
          $('#modal-pro-detail .error_pro_detail').show();
            error_check = true;
        }

        if ($.trim(pro_keyword) == '')
        {
          $('#modal-pro-detail .error_pro_keyword').show();
            error_check = true;
        }

        if ($.trim(pro_descr) == '')
        {
          $('#modal-pro-detail .error_pro_descr').show();
            error_check = true;
        }

        if (error_check == false) {
          
          data_product.product.pro_detail = pro_detail;
          data_product.product.pro_descr = pro_descr;
          data_product.product.pro_keyword = pro_keyword;
          // data_product.tab_validate.pro_detail = true;
          show_pro_detail();
          $('#modal-pro-detail').modal('hide');
        }
      });


      // popup product attach
      $('body').on('click', '.modal-pro-attach', function(){
        if (data_product.product.pro_attach.length > 0) {
          $.ajax({
            url: siteUrl +"product/getProChoose",
            method: "POST",
            data: {product: data_product.product.pro_attach, type : 'product'},
            dataType: "json",
            success: function(result) {
              if (result.list_product != "") {
                $('#pro_attach .san-pham-mua-kem').html(result.list_product);
              }
            }
          });
        }
        $('#modal-pro-attach').modal('show');
      }); 
       
      // add product attach
      $('.add_pro_attach').click(function(){
          var data_post = [];
          var product_id = $('#pro_attach select').val();
          var list_item_pro = $('#pro_attach .san-pham-mua-kem').find('.item');
          if (list_item_pro.length > 0) {
            $.each(list_item_pro, function( key_link, value_link ) {
              if (product_id == $(this).attr('data-id')) {
                product_id = 0;
              }
            });
          }
          if ( product_id > 0 ) {
              data_post.push(product_id);
              $.ajax({
                url: siteUrl +"product/getProChoose",
                method: "POST",
                data: {product: data_post, type : 'product'},
                dataType: "json",
                success: function(result) {
                  if (result.list_product != "") {
                    $('#pro_attach .san-pham-mua-kem').prepend(result.list_product);
                  }
                }
              });
          }
      });

      $('body').on('click','.remove-prodct-choose', function(){
          var product_id = $(this).attr('data-id');
          $(this).parents('.item').remove();
      });

      $('body').on('click', '#modal-pro-attach .save-basic', function(){
          var list_item_pro = $('#pro_attach .san-pham-mua-kem').find('.item');
          data_product.product.pro_attach = [];
          if (list_item_pro.length > 0) {
            $.each(list_item_pro, function( key_link, value_link ) {
              data_product.product.pro_attach.push($(this).attr('data-id'));
            });
          }
          show_attach();
      });

      //  qc
      $('body').on('click', '.modal-pro-qc', function(){
          if (data_product.pro_qc.length > 0) {
            $('#modal-pro-qc table tbody').html('');
            $.each(data_product.pro_qc, function( k_qc, v_qc ) { 
                var template_row_qc = $('#js-template-qc-show').html();
                template_row_qc = template_row_qc.replace(/{{IMAGE_VAL}}/g, v_qc['dp_image']);
                template_row_qc = template_row_qc.replace(/{{COLOR_VAL}}/g, v_qc['dp_color']);
                template_row_qc = template_row_qc.replace(/{{SIZE_VAL}}/g, v_qc['dp_size']);
                template_row_qc = template_row_qc.replace(/{{WEIGHT_VAL}}/g, v_qc['dp_weight']);
                template_row_qc = template_row_qc.replace(/{{MATERIAL_VAL}}/g, v_qc['dp_material']);
                template_row_qc = template_row_qc.replace(/{{COST_VAL}}/g, v_qc['dp_cost']);
                template_row_qc = template_row_qc.replace(/{{INSTOCK_VAL}}/g, v_qc['dp_instock']);

                // show image
                template_row_qc = template_row_qc.replace(/{{IMAGE_SHOW}}/g, '<img class="dynamic" src="'+v_qc['dp_image']+'">');

                $('#modal-pro-qc table tbody').append(template_row_qc);
            });

            if (data_product.pro_qc_checkbox.qc_color) {
              $('#qcColor').prop('checked', true);
            } else {
              $('#qcColor').prop('checked', false);
            }
            if (data_product.pro_qc_checkbox.qc_size) {
              $('#qcSize').prop('checked', true);
            } else {
              $('#qcSize').prop('checked', false);
            }

            if (data_product.pro_qc_checkbox.qc_material) {
              $('#qcMaterial').prop('checked', true);
            } else {
              $('#qcMaterial').prop('checked', false);
            }
            qcColor();
            qcSize();
            qcMaterial();
          }

          $('#modal-pro-qc').modal('show');
      });

      $('#modal-pro-qc .add-row-qc').click(function(){
        var template_row_qc = $('#js-template-qc').html();
        if (!$('#qcColor').is(':checked')) {
          template_row_qc = template_row_qc.replace(/{{COLOR_D}}/g, 'disabled="disabled"');
        }else {
          template_row_qc = template_row_qc.replace(/{{COLOR_D}}/g, '');
        }

        if (!$('#qcSize').is(':checked')) {
          template_row_qc = template_row_qc.replace(/{{SIZE_D}}/g, 'disabled="disabled"');
        }else {
          template_row_qc = template_row_qc.replace(/{{SIZE_D}}/g, '');
        }

        if (!$('#qcMaterial').is(':checked')) {
          template_row_qc = template_row_qc.replace(/{{MATERIAL_D}}/g, 'disabled="disabled"');
        }else {
          template_row_qc = template_row_qc.replace(/{{MATERIAL_D}}/g, '');
        }

        $('#modal-pro-qc table tbody').append(template_row_qc);
      });


      $('body').on('click', '#modal-pro-qc .upload_btn', function(){
        $(this).find('.dp_image_file')[0].click();
      });

      $('body').on('change', '#modal-pro-qc .dp_image_file', function(){
          crop_image_qc($(this)[0]);
          $(this).val('');
      });

      $('body').on('click', '.luu_image_qc', function(){
          var image_base = $(this).attr('data-src');
          var input_active = $('#modal-pro-qc').find('.active_upload');
          var div_append = $(input_active).parents('tr').find('.container_show');
          var input_add = $(input_active).parents('tr').find('.dp_image');
          var img = $('<img class="dynamic">');
          img.attr('src', image_base);
          $(input_add).val(image_base);
          $(div_append).html(img);
          $('#modal-pro-image-qc').modal('hide');
      });

      $('body').on('click','#modal-pro-qc .save-basic', function(){
          $('#modal-pro-qc .error_input_spec').removeClass('error_input_spec');
          var list_qc = $('#modal-pro-qc table tbody').find('tr');
          var qc_color = $('#qcColor').is(':checked');
          var qc_size = $('#qcSize').is(':checked');
          var qc_material = $('#qcMaterial').is(':checked');
          var pro_qc_checkbox = [];
          pro_qc_checkbox['qc_color'] = qc_color;
          pro_qc_checkbox['qc_size'] = qc_size;
          pro_qc_checkbox['qc_material'] = qc_material;

          var temp_data = [];
          var min_ = -1;
          clickat = 2;
          
          if(list_qc.length > 0) {
            $.each(list_qc, function( key_link, value_link ) {
                temp_data[key_link] = {};
                var row_image     = $(this).find('input.dp_image');
                var row_color     = $(this).find('input.dp_color');
                var row_size      =  $(this).find('input.dp_size');
                var row_material  =  $(this).find('input.dp_material');
                var row_weight    =  $(this).find('input.dp_weight');
                var row_cost      =  $(this).find('input.dp_cost');
                var row_instock   =  $(this).find('input.dp_instock');

                //  image crop
                temp_data[key_link]['dp_image'] = '';
                if ($.trim(row_image.val()) == '') {
                  $(row_image).parents('.upload_btn').addClass('error_input_spec');
                } else {
                  temp_data[key_link]['dp_image'] = $.trim(row_image.val());
                }

                // color
                temp_data[key_link]['dp_color'] = '';
                if ($.trim(row_color.val()) == '' && qc_color) {
                  $(row_color).addClass('error_input_spec');
                } else {
                  temp_data[key_link]['dp_color'] = $.trim(row_color.val());
                }

                // size
                temp_data[key_link]['dp_size'] = '';
                if ($.trim(row_size.val()) == '' && qc_size) {
                  $(row_size).addClass('error_input_spec');
                } else {
                  temp_data[key_link]['dp_size'] = $.trim(row_size.val());
                }

                // size
                temp_data[key_link]['dp_material'] = '';
                if ($.trim(row_material.val()) == '' && qc_material) {
                  $(row_material).addClass('error_input_spec');
                } else {
                  temp_data[key_link]['dp_material'] = $.trim(row_material.val());
                }

                // weight
                temp_data[key_link]['dp_weight'] = $.trim(row_weight.val());

                // cost
                temp_data[key_link]['dp_cost'] = '';
                if ($.trim(row_cost.val()) == '') {
                  $(row_cost).addClass('error_input_spec');
                } else {
                  temp_data[key_link]['dp_cost'] = $.trim(row_cost.val());
                  if(list_qc.length == 1){
                    min_ = parseInt(row_cost.val());
                  }
                  else{
                    for(var i = 0; i < list_qc.length; i++){
                      if(list_qc.eq(i).find('input.dp_cost').val() < $.trim(row_cost.val()))
                      {
                        min_ = parseInt(list_qc.eq(i).find('input.dp_cost').val());
                      }
                    }
                  }
                }

                // instock 
                temp_data[key_link]['dp_instock'] = '';
                if ($.trim(row_instock.val()) == '') {
                  $(row_instock).addClass('error_input_spec');
                } else {
                  temp_data[key_link]['dp_instock'] = $.trim(row_instock.val());
                }
            });
          }else{
            min_ = 0;
          }

          var list_error = $('#modal-pro-qc .error_input_spec');

          if (list_error.length == 0) {
            data_product.pro_qc = temp_data;
            data_product.pro_qc_checkbox = pro_qc_checkbox;
            min_dp_cost = min_;
            show_qc();
          }
      });

      $('.product-video').click(function(){
          if (data_product.product.pro_video) {}
      });




      $('.popup-image-list').click(function(){
          $('#popup-image-list').modal('show');
      });

      $('#popup-image-list').on('shown.bs.modal', function() {
          /*$('#popup-image-list .slider-img-small').removeClass('slick-initialized slick-slider');
          $('#popup-image-list .slider-img-small').html('');

          if ($('#popup-image-list .slider-img-small').hasClass('slick-initialized')){
            $('#popup-image-list .slider-img-small').slick('unslick');
          }
          $('#popup-image-list .slider-img-small').slick({
                slidesToShow: 8,
                slidesToScroll: 1,
                dots: false,
                arrows: true,
                infinite: false,
                variableWidth: true,
                responsive: [
                {
                  breakpoint: 1025,
                  settings: {
                    slidesToShow: 3
                  }
                },
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 2
                  }
                },
                ]
          });
          if (data_product.product.pro_image.length > 0) {

              $('#popup-image-list .slider-img-big').html('<img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">');

              $.each(data_product.product.pro_image, function( key_link, value_link ) {
                  var str = '';
                  str += '<div class="item-image-list crop-done">';
                  str +=   '<div class="item_image_img">';
                  str +=    '<img class="non_scrop" src="'+value_link+'" alt="">';
                  str +=   '</div>';
                  str +=   '<div class="action-icon">';
                  str +=      '<span class="check_crop fail-crop">';
                  str +=        '<i class="fa fa-check-circle" aria-hidden="true"></i>';
                  str +=      '</span>';
                  str +=      '<span>';
                  str +=        '<i class="trash-image fa fa-trash" aria-hidden="true"></i>';
                  str +=      '</span>';
                  str +=    '</div>';
                  str += '</div>';
                  var currentSlide = $('.slider-img-small').slick('slickCurrentSlide');
                  $('#popup-image-list .slider-img-small').slick('slickAdd',str);
                  $('#popup-image-list .slider-img-small').slick('slickGoTo', currentSlide + 1);
              });
          }else{
              var template_default = $('#js-template-list-image').html();
              $('#popup-image-list .modal-body').html(template_default);
              $('#popup-image-list .slider-img-small').slick({
                  slidesToShow: 8,
                  slidesToScroll: 1,
                  dots: false,
                  arrows: true,
                  infinite: false,
                  variableWidth: true,
                  responsive: [
                  {
                    breakpoint: 1025,
                    settings: {
                      slidesToShow: 3
                    }
                  },
                  {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 2
                    }
                  },
                  ]
              });
          }*/
      });

      $('body').on('click', '#popup-image-list .up_mutiple_img', function(){
          $('#mutiple_img_input').trigger('click');
      });

      $('body').on('click', '#popup-image-list .trash-image', function(){
          var parent = $(this).parents('.item-image-list');
          var list_image = $('#popup-image-list .item-image-list');
          var index_done = $('#popup-image-list .item-image-list.crop-done').length;
          var this_index = $(this).parents('.item-image-list').index();
          var active_crop = $('.item-image-list.active_crop').index();

          if(index_done == list_image.length || (index_done == list_image.length-1 && $(parent).hasClass('crop-done') === false)){
             $('#popup-image-list .slider-img-big').html('<img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">');
            $('#popup-image-list .slider-img-small').slick('slickRemove', parseInt($(parent).attr('data-slick-index'))).slick('refresh');
          }
          else
          {
            if(index_done < list_image.length){
              if(index_done < list_image.length - 1 && this_index <= active_crop && this_index < list_image.length - 1){
                if(this_index < active_crop){
                  active_crop = active_crop - 1;
                }
              }else{
                active_crop = list_image.length - 2;
              }
              
              $('#popup-image-list .slider-img-small').slick('slickRemove', parseInt($(parent).attr('data-slick-index'))).slick('refresh');

              if($('#popup-image-list .item-image-list').eq(active_crop).hasClass('crop-done') === true){
                $('#popup-image-list .item-image-list').each(function(){
                  if($(this).hasClass('crop-done') === false){
                    active_crop = $(this).index();
                    return false;
                  }
                });
              }else{
                if(index_done == list_image.length - 1){
                  $('#popup-image-list .slider-img-big').html('<img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">');
                }
              }
              $('#popup-image-list .item-image-list').eq(active_crop).find('.item_image_img').trigger('click');
              $('.slider-img-small').slick('slickGoTo', active_crop);
            }
          }

          if (list_image.length == 1) {
              var template_default = $('#js-template-list-image').html();
              $('#popup-image-list .modal-body').html(template_default);
              $('#popup-image-list .slider-img-small').slick({
                  slidesToShow: 8,
                  slidesToScroll: 1,
                  dots: false,
                  arrows: true,
                  infinite: false,
                  variableWidth: true,
                  responsive: [
                  {
                    breakpoint: 1025,
                    settings: {
                      slidesToShow: 3
                    }
                  },
                  {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 2
                    }
                  },
                  ]
              });
          }

      });
      
      $('body').on('click', '#popup-image-list .item-image-list .item_image_img', function(){
          if (!$(this).parent('.item-image-list').hasClass('crop-done')) {
            $('#popup-image-list .active_crop').removeClass('active_crop');
            $(this).parent('.item-image-list').addClass('active_crop');

            var src  = $(this).find('img').attr('src');
            var img = $('<img id="target_crop_image">');
            img.attr('src', src);
            $('#popup-image-list .slider-img-big').html(''); 
            $('#popup-image-list .slider-img-big').html(img);
            var getWidth = $('#popup-image-list .modal-body').width();
            var dkrm = new Darkroom('#target_crop_image', {
                // Size options
                //minWidth: 600,
                maxWidth: getWidth,
                maxHeight: 800,
                // Plugins options
                plugins: {
                  save: {
                      callback: function() {
                      }
                  },
                  //rotate: false,
                  save: false,
                  crop: {
                    //quickCropKey: 67, //key "c"
                    minHeight: 450,
                    minWidth: 450,
                    ratio: 1
                  }
                },

                // Post initialize script
                initialize: function() {
                  var cropPlugin = this.plugins['crop'];
                  cropPlugin.selectZone(50, 50, 450, 450);
                  // Add custom listener
                  var images_crop = this;

                  $('#popup-image-list').find('.darkroom-toolbar').append('<div class="darkroom-button-group luu_image_crop" style="display:none"><button type="button" class="darkroom-button darkroom-button-default">Lưu</button></div>');

                  this.addEventListener('core:transformation', function() {
                      // images_crop.selfDestroy();
                      newImage = images_crop.sourceImage.toDataURL(); 
                      // newImage = dkrm.canvas.toDataURL();
                      $('#popup-image-list').find('.darkroom-toolbar .luu_image_crop').attr('data-src', newImage);
                      $('#popup-image-list').find('.darkroom-toolbar .luu_image_crop').show();
                  });
                  
                }
            });

          }
      });
 
      $('body').on('click', '.slider-img-small .crop-done .item_image_img', function(){
        alert('Ảnh này bạn đã cắt hoàn tất, bạn không thể chỉnh sửa');
      });


      $('body').on('click', '#popup-image-list .luu_image_crop', function(){
            var image_active = $('#popup-image-list .active_crop');
            var image_base = $(this).attr('data-src');
            $(image_active).find('img').attr('src', image_base);
            $(image_active).find('img').removeClass('non_scrop');
            $(image_active).addClass('crop-done');

            var list_image = $('#popup-image-list .item-image-list');
            var index_done = $('#popup-image-list .item-image-list.crop-done').length;
            var active_crop = image_active.index();

            if(index_done <= list_image.length - 1){
              $('#popup-image-list .item-image-list').each(function(){
                if($(this).hasClass('crop-done') === false){
                  active_crop = $(this).index();
                  return false;
                }
              });

              $('#popup-image-list .item-image-list').eq(active_crop).find('.item_image_img').trigger('click');
              $('.slider-img-small').slick('slickGoTo', active_crop);
              
            }else{
              $('#popup-image-list .slider-img-big').html('<img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">');
            }
      });
      
      $('body').on('change', '#popup-image-list #mutiple_img_input', function(){
            var file_input = $(this)[0].files;
            var count_file_input = file_input.length;
            var count_file_run = 0;
            var list_image_error = [];
            var file_img_list = [];

            $('.load-wrapp').show();
            for (var i =0; i< file_input.length; i++) {
              if (file_input[i]) {
                  var reader = new FileReader();
                  reader.fileName = file_input[i].name;
                  reader.key = i;
                  reader.onload = function (e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function() {
                      count_file_run += 1;
                      if ((this.width <= 600) && (this.height <= 600)) 
                      {
                        list_image_error.push(e.target.fileName);
                      }
                      else
                      {
                        file_img_list.push(e.target.result);
                      }

                      if (count_file_run == count_file_input)
                      {
                        //  check list hình error
                        if (list_image_error.length > 0)
                        {
                            alert('Kích thước ảnh bắt buộc lớn hơn 600 x 600');
                            $('.load-wrapp').hide();
                        }

                        // tạo list hình sider
                        if (file_img_list.length > 0) {

                            var list_default = $('#popup-image-list .item_default_img');
                            if (list_default.length > 0) {
                              $.each(list_default, function( key_link, value_link ) {
                                  $('#popup-image-list .slider-img-small').slick('slickRemove', parseInt($(this).attr('data-slick-index')) - key_link );
                              });
                            }
                            $.each(file_img_list, function( key_link, value_link ) {
                                var str = '';
                                str += '<div class="item-image-list">';
                                str +=   '<div class="item_image_img">';
                                str +=      '<img class="non_scrop" src="'+value_link+'" alt="">';
                                str +=   '</div>';
                                str +=   '<div class="action-icon">';
                                str +=      '<span class="check_crop fail-crop">';
                                str +=        '<i class="fa fa-check-circle" aria-hidden="true"></i>';
                                str +=      '</span>';
                                str +=      '<span>';
                                str +=        '<i class="trash-image fa fa-trash" aria-hidden="true"></i>';
                                str +=      '</span>';
                                str +=    '</div>';
                                str += '</div>';
                                var currentSlide = $('.slider-img-small').slick('slickCurrentSlide');
                                $('#popup-image-list .slider-img-small').slick('slickAdd',str);
                                $('#popup-image-list .slider-img-small').slick('slickGoTo', currentSlide + 1);
                            });
                            var check_active = $('#popup-image-list .active_crop');
                            if (check_active.length < 1) {
                                // $('#popup-image-list .item-image-list').first().trigger('click');
                            }
                            $('.load-wrapp').hide();
                            $('#popup-image-list .item-image-list').each(function(){
                              if($(this).hasClass('crop-done') === false){
                                active_crop = $(this).index();
                                return false;
                              }
                            });
                            $('.slider-img-small').slick('slickGoTo', active_crop);
                            $('#popup-image-list .item-image-list').eq(active_crop).find('.item_image_img').trigger('click');
                        }
                      }
                    }
                  }
                  reader.readAsDataURL(file_input[i]);
              }
            }

            $( "#popup-image-list #mutiple_img_input" ).val("");
      });


      $('body').on('click', '#popup-image-list .save_mutiple_img', function(){
            var list_image = $('#popup-image-list .item-image-list');
            var list_image_crop = $('#popup-image-list .crop-done');
            if (list_image_crop.length == 0) {
              alert('Vui lòng cắt một tấm ảnh về đúng kích thước!');
            }
            else if (list_image_crop.length != list_image.length) {
              alert('Vui lòng cắt tất cả ảnh về đúng kích thước!');
            } else {
                show_img_main();
                $('#popup-image-list').modal('hide');
            }

      });


      $('.update-product').click(function(){
          var error_add_product = false;
          $('.error_all_data').hide();
          // validate tab image
          if ( data_product.product.pro_image.length == 0)
          {
            $('.show-photo-main').addClass('border_red');
            error_add_product = true;
          } else {
            $('.show-photo-main').removeClass('border_red');
          }

          // validate tab pro_basic
          // if ( data_product.tab_validate.pro_basic == false)
          // {
          //   $('.modal-pro-basic').addClass('background_red');
          //   error_add_product = true;
          // } else {
          //   $('.modal-pro-basic').removeClass('background_red');
          // }

          // validate tab pro_info
          // if ( data_product.tab_validate.pro_info == false)
          // {
          //   $('.modal-pro-info').addClass('background_red');
          //   error_add_product = true;
          // } else {
          //   $('.modal-pro-info').removeClass('background_red');
          // }

          // validate tab pro_detail
          // if ( data_product.tab_validate.pro_detail == false)
          // {
          //   $('.modal-pro-detail').addClass('background_red');
          //   error_add_product = true;
          // } else {
          //   $('.modal-pro-detail').removeClass('background_red');
          // }

          $('.load-wrapp').show();
          if (error_add_product === false) {
              $.ajax({
                url: siteUrl +"product/ajaxEdit/" + data_product.product.pro_id,
                method: "POST",
                data: {product: data_product},
                dataType: "json",
                success: function(result) {
                  if (result.error == false) {
                    alert('Lưu <?php echo $result->text; ?> thành công');
                    location.reload();
                  }else{
                    alert('Lưu <?php echo $result->text; ?> thất bại');
                  }
                  $('.load-wrapp').hide();
                },
                error: function(){
                  alert('Kết nối thất bại');
                  $('.load-wrapp').hide();
                }
              });
          } else {
            $('.load-wrapp').hide();
            $('.error_all_data').show();
          }


      });

      $('body').on('click', '#gallery_01 img', function(){
          $('#gallery_01').find('a.is-active').removeClass('is-active');
          var parent = $(this).closest('a').addClass('is-active');
          var url_img = $(this).attr('src');
          $('.show-photo-main > img').attr('src', url_img);
      });

      $(document).on({
        'show.bs.modal': function() {
          var zIndex = 1040 + (10 * $('.modal:visible').length);
          $(this).css('z-index', zIndex);
          setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
          }, 0);
        },
        'hidden.bs.modal': function() {
          if ($('.modal:visible').length > 0) {
            setTimeout(function() {
              $(document.body).addClass('modal-open');
            }, 0);
          }
        }
      }, '.modal');

      $('body').on('click', '.modal-pro-ctv', function(){
          $('#modal-pro-ctv').modal('show');
      });

      $('#modal-pro-ctv input[name="apply"]').on('change', function() {
        // check_valueprice();
        if ($(this).val() > 0) {
          $('.js-affsale').removeClass('hidden');
        } else {
          $('.js-affsale').addClass('hidden');
        }
      });

      $('#modal-pro-ctv .save-basic').click(function(e){
          $('.error_input').hide();
          var apply_aff = $('#modal-pro-ctv input[name="apply"]:checked').val();
          var aff_rate = $('#modal-pro-ctv .js-aff-swap').find('.special-price-item.js-rate.is-open');
          var aff_amt = $('#modal-pro-ctv .js-aff-swap').find('.special-price-item.js-amt.is-open');
          var aff_dc_rate = $('#modal-pro-ctv .js-aff-dc-swap').find('.special-price-item.js-rate.is-open');
          var aff_dc_amt = $('#modal-pro-ctv .js-aff-dc-swap').find('.special-price-item.js-amt.is-open');

          var pro_dc_affiliate_value = 0;
          var pro_dc_affiliate_type = 0;
          var pro_affiliate_type = 0;
          var affiliate_value_1 = 0;
          var affiliate_value_2 = 0;
          var affiliate_value_3 = 0;

          if (apply_aff > 0) 
          {
              // aff user
              /*if ($(aff_dc_rate).length == 0 && $(aff_dc_amt).length == 0) 
              {
                $('.error_aff_dc_swap').text('Vui lòng nhập giá ưu đãi.');
                $('.error_aff_dc_swap').show();
                return false;
              }*/

              var money_dc_aff = 0;
              if ($(aff_dc_rate).length == 1) 
              {
                pro_dc_affiliate_type = 1;
                pro_dc_affiliate_value = $(aff_dc_rate).find('.js-aff-dc-value').val();

                if (pro_dc_affiliate_value == '') 
                {
                  $('.error_aff_dc_swap').text('Vui lòng nhập giá ưu đãi.');
                  $('.error_aff_dc_swap').show();
                }
                else if (pro_dc_affiliate_value > 100) 
                { 
                  $('.error_aff_dc_swap').text('Tổng tiền hoa hồng, giảm qua ctv phải nhỏ hơn 100%.');
                  $('.error_aff_dc_swap').show();
                  return false;
                }
              }
              else 
              {
                pro_dc_affiliate_type = 2;
                pro_dc_affiliate_value = parseInt($(aff_dc_amt).find('.js-aff-dc-value').val());

                if(giam_qc > 0 && min_dp_cost > 0){
                  money_saleoff = giam_qc;
                }
                
                if(clickat == 0){
                  if(saleoff_percent > 0){
                    money_saleoff = giam_qc * (1 - saleoff_percent).toFixed(2);
                  }else{
                    money_saleoff = giam_qc - saleoff_money;
                  }
                }

                if (pro_dc_affiliate_value == '')
                {
                  $('.error_aff_dc_swap').text('Vui lòng nhập giá ưu đãi.');
                  $('.error_aff_dc_swap').show();
                  return false;
                }else{
                  if(pro_dc_affiliate_value > money_saleoff){
                    alert('Ưu đãi qua hệ thống bán hộ không được lớn hơn '+parseInt(money_saleoff).toLocaleString()+'đ');
                    return false;
                  }
                }
              }

              //  aff CTV
              if ($(aff_rate).length == 0 && $(aff_amt).length == 0) 
              { 
                $('.error_aff_swap').text('Vui lòng nhập hoa hồng cho hệ thống.');
                $('.error_aff_swap').show();
                return false;
              }

              if ($(aff_rate).length == 1)
              {
                pro_affiliate_type = 1;
                affiliate_value_1 = parseInt($(aff_rate).find('.affiliate_value_1').val());
                affiliate_value_2 = parseInt($(aff_rate).find('.affiliate_value_2').val());
                affiliate_value_3 = parseInt($(aff_rate).find('.affiliate_value_3').val());
                if (affiliate_value_1 == '' || affiliate_value_2 == '' || affiliate_value_3 == '') 
                {
                  $('.error_aff_swap').text('Vui lòng nhập hoa hồng cho hệ thống.');
                  $('.error_aff_swap').show();
                  return false;
                }
                else if (affiliate_value_1 > 100 || affiliate_value_2 > 100 || affiliate_value_3 > 100) 
                {
                  $('.error_aff_swap').text('Phần trăm giảm qua cộng tác viên phải nhỏ hơn 100%');
                  $('.error_aff_swap').show();
                  return false;
                }
              }
              else  
              {
                pro_affiliate_type = 2;
                affiliate_value_1 = parseInt($(aff_amt).find('.affiliate_value_1').val());
                affiliate_value_2 = parseInt($(aff_amt).find('.affiliate_value_2').val());
                affiliate_value_3 = parseInt($(aff_amt).find('.affiliate_value_3').val());
                if (affiliate_value_1 == '' || affiliate_value_2 == '' || affiliate_value_3 == '') 
                {
                  $('.error_aff_swap').text('Vui lòng nhập hoa hồng cho hệ thống.');
                  $('.error_aff_swap').show();
                  return false;
                }
              }

              if (affiliate_value_1 == 0 || affiliate_value_2 == 0 || affiliate_value_3 == 0) 
              {
                $('.error_aff_swap').text('Phần trăm giảm qua cộng tác viên phải lớn hơn 0');
                $('.error_aff_swap').show();
                return false;
              }

              if(affiliate_value_1 < affiliate_value_2){
                $('.error_aff_swap').text('Hoa hồng Tổng đại lý phải nhỏ hơn hoa hồng Nhà phân phối');
                $('.error_aff_swap').show();
                return false;
              }

              if(affiliate_value_2 < affiliate_value_3){
                $('.error_aff_swap').text('Hoa hồng Đại lý phải nhỏ hơn hoa hồng Tổng đại lý');
                $('.error_aff_swap').show();
                return false;
              }

          }
          // if ($(aff_dc_rate).length == 1) 
          // {
          //   pro_dc_affiliate_type = 1;
          //   pro_dc_affiliate_value = $(aff_dc_rate).find('.js-aff-dc-value').val();
          // }
          // else
          // {
          //   uudai = pro_dc_affiliate_value = parseInt($(aff_dc_amt).find('.js-aff-dc-value').val());
          // }

          if (apply_aff > 0) 
          {
            data_product.product.is_product_affiliate = 1;
          } 
          else 
          {
            data_product.product.is_product_affiliate = 0;
          }
          data_product.product.apply = apply_aff;
          data_product.product.pro_dc_affiliate_value = pro_dc_affiliate_value;
          data_product.product.pro_dc_affiliate_type = pro_dc_affiliate_type;
          data_product.product.pro_affiliate_type = pro_affiliate_type;
          data_product.product.affiliate_value_1 = affiliate_value_1;
          data_product.product.affiliate_value_2 = affiliate_value_2;
          data_product.product.affiliate_value_3 = affiliate_value_3;
          $('#modal-pro-ctv').modal('hide');
          show_basic();          
      });

      $('body').on('click', '.modal-pro-condition', function(){
        $('#modal-pro-condition').modal('show');
      });

      $('#modal-pro-condition').on('click', '.js-btn-add-condition', function() {
          var str = '<div class="address-content-item">';
                str += '<input type="text" class="form-control js-address-condition">';
                str += '<img src="/templates/home/styles/images/svg/close.svg" width="15" class="delete js-btn-delete-condition">';      
              str += '</div>';
          $('#modal-pro-condition .address-content').append(str);
      });

      $('#modal-pro-condition').on('click', '.js-btn-delete-condition', function() {
          $(this).closest('.address-content-item').remove();
      });

      $('#modal-pro-condition').on('click', '.save-basic', function() {
          var time_condition = $('#modal-pro-condition .js-time-condition').val();
          var duration_condition = $('#modal-pro-condition .js-duration-condition').val();
          var type_duration_condition = $('#modal-pro-condition .js-type-duration-condition').val();
          var apply_condition = $('#modal-pro-condition .js-apply-condition').val();
          var not_apply_condition = $('#modal-pro-condition .js-not-apply-condition').val();
          var list_address = $('#modal-pro-condition .js-address-condition');

          data_product.product.condition_use.time = time_condition;
          data_product.product.condition_use.duration = duration_condition;
          data_product.product.condition_use.type_duration = type_duration_condition;
          data_product.product.condition_use.apply = apply_condition;
          data_product.product.condition_use.not_apply = not_apply_condition;
          data_product.product.condition_use.address = [];

          if (list_address.length > 0) 
          {
            $(list_address).each(function( index ) {
                var address_item = $(this).val();
                if ($.trim(address_item) != '') 
                {
                  data_product.product.condition_use.address.push(address_item);
                }
            });
          }
          $('#modal-pro-condition').modal('hide');
      });
  });
</script>