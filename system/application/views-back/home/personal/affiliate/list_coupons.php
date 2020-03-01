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
                          $this->load->view('e-azibai/common/common-html-item', ['item'=>$item,'has_af_key'=>$has_af_key]);
                        }
                    }?>
                </div>
            </div>

        </div>

    </div>
</div>
<div class="modal_affiliate_coupon modal fade bd-commision-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content js_content_commision">
            <div class="modal-header flex-center"><h3 class="title-commistion">Azibai</h3></div>
            <div class="modal-body"></div>
            <div class="modal-footer buttons-group"></div>
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
    var template_select = 'bạn sẽ nhận được {{price}} tiền hoa hồng khi bán sản phẩm này. Bạn muốn chọn bán mã giảm giá này ?';
    var price = $(this).attr('data-commission');
    var select = $(this).attr('data-select');
    
    var product_id = $(this).attr('data-product');
    var url = "'"+$(this).attr('data-domain')+"'";
    var msg = 'Bạn muốn hủy bán mã giảm giá này ?';
    var footer = '<button class="btn btn-default mr10 js_apply-commission" data-product="'+product_id+'" data-select="'+select+'">Xóa</button>'; 
    footer +='<button type="button" class="btn-bg-gray cursor-pointer btn-copy">Sao chép liên kết</button>';
    if (select != 'true') {
      msg = template_select.replace('{{price}}', price);
      var footer ='<button class="btn btn-default mr10 js_apply-commission" data-product="'+product_id+'" data-select="'+select+'">';
      footer +='<i class="fa fa-check fa-fw"></i> Chọn bán</button>';
    }
    $('.js_apply-commission').attr('data-product', product_id);
    $('.js_apply-commission').attr('data-select', select);

    $('.bd-commision-modal-sm .modal-body').html(msg);
    $('.bd-commision-modal-sm .modal-footer').html(footer);
    $('.bd-commision-modal-sm').modal('show');
  });

  $('body').on('click', '.js_apply-commission', function (e) {
    e.preventDefault();
    $('.bd-commision-modal-sm').modal('hide');
    $('.load-wrapp').show();
    var product_id = $(this).attr('data-product');
    var select = $(this).attr('data-select');

    var url = siteUrl+'home/affiliate/ajax_select_pro_sales';
    if (select === 'true') {
      url = siteUrl+'home/affiliate/ajax_cancel_select_pro_sales'
    }
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