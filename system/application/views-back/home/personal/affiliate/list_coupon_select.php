<div class="row">
    <div class="col-md-4">
        <?php echo $this->load->view('home/personal/affiliate/layout/menu-left') ?>
    </div>
    <div class="col-md-8">
        <div class="tranggioithieu-right trangcuahang-ver2">
            <div class="alert"></div>
            <div class="shop-product">
                <h3 class="tit">DỊCH VỤ CỦA AZIBAI</h3>
                <div class="list-affiliate-service shop-product-items">
                    <?php if(!empty($services)){
                        foreach ($services as $key => $item) {
                          $this->load->view('home/personal/affiliate/element/common-html-item', ['item'=>$item,'has_af_key'=>$has_af_key]);
                        }
                    }?>
                </div>
            </div>

        </div>

    </div>
</div>
<?php $this->load->view('e-azibai/common/common-popup-af-commission');?>
<!-- Modal -->
<div class="modal fade" id="myModal_ctv" role="dialog">
  <div class="modal-dialog modal-lg modal-mess ">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Hoa hồng cho cộng tác viên</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <p class="ptramhoahong">Tỉ lệ hoa hồng thông thường: <span class="tilehoahong"></span></p>
        <p><b>Hoa hồng ước tính: <span class="dong">đ</span><span class="uoctinh"></span></b></p>
        <p>Bằng việc chia sẻ, bạn đồng ý chấp nhận các <a href="">Quy tắc</a> của chúng tôi</p>
        <br>
        <p>Tiền hoa hồng ước tính: </p>
        <div class="tien-share">
          <b><span class="dong">đ</span> <span class="uoctinh"></span></b>
          <div class="btn-ctv">
            <button class="btn btn-default mr10">
              <i class="fa fa-check fa-fw"></i> Đã chọn bán
            </button>
            <?php if($af_id != ''){ $af_id = '?af_id='.$_REQUEST['af_id']; } ?>
            <label class="btn-share">
              <a href="javascript:void(0)" id="copy_link" onclick="">Copy link</a>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>

  $('.sm-btn-show').click(function () {
    var parent = $(this).closest('.item');
    parent.toggleClass('show-action');
    if (parent.hasClass('show-action')) {
      $(this).find('img').attr('src', '/templates/home/styles/images/svg/shop_icon_close.svg');
    } else {
      $(this).find('img').attr('src', '/templates/home/styles/images/svg/shop_icon_add.svg');
    }
  });

  $('body').on('click', '.js_get-pop-commission', function (e) {
    e.preventDefault();
    var template_select = 'bạn sẽ nhận được {{price}} tiền hoa hồng khi bán sản phẩm này. Bạn muốn chọn bán sản phẩm này ?';
    var price = $(this).attr('data-commission');
    var select = $(this).attr('data-select');
    var product_id = $(this).attr('data-product');
    var msg = 'Bạn muốn hủy bán sản phẩm này ?';
    if (select === 'true') {
      msg = template_select.replace('{{price}}', price);
    }
    ('.bd-commision-modal-sm .modal-body #copy_link').attr('onclick',$(this).attr('data-url'));
    data-url

    $('.js_apply-commission').attr('data-product', product_id);
    $('.js_apply-commission').attr('data-select', select);

    $('.bd-commision-modal-sm .modal-body').html(msg);
    $('.bd-commision-modal-sm').modal('show');
  });

  $('body').on('click', '.js_apply-commission', function (e) {
    e.preventDefault();
    $('.bd-commision-modal-sm').modal('hide');
    $('.load-wrapp').show();
    var product_id = $(this).attr('data-product');
    var select = $(this).attr('data-select');

    var url = siteUrl+'home/affiliate/ajax_select_pro_sales';
    if (select === 'false') {
      url = siteUrl+'home/affiliate/ajax_cancel_select_pro_sales'
    }
    alert(url);
    $.ajax({
      type: "POST",
      url: url,
      dataType: 'json',
      data: {
        proid: product_id,
        id_pro: product_id,
      },
      success: function (data) {
        if (data == 1) {
          if(select === 'false'){
            //sau khi xóa chon sp ctv
            $('.item-'+product_id).find('.img-ctv1').attr('src','/templates/home/styles/images/svg/CTV.svg');
            $('.item-'+product_id).find('.js_get-pop-commission').attr('data-select','true');
          }else{
            //sau khi add chon sp ctv
            $('.item-'+product_id).find('.img-ctv1').attr('src','/templates/home/styles/images/svg/CTV_add.svg');
            $('.item-'+product_id).find('.js_get-pop-commission').attr('data-select','false');
          }
          $('.load-wrapp').hide();

        } else {
          $('.load-wrapp').hide();
        }
      }
    });
  });
</script>