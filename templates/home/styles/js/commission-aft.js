$(document).ready(function() {

  $('body').on('click', '.js_get-pop-commission', function (e) {
    e.preventDefault();
    var template_select = '';
    var price = $(this).attr('data-commission');
    var select = $(this).attr('data-select');
    var product_id = $(this).attr('data-product');
    var copy_link = $(this).attr('data-url');
    var quycach = $(this).attr('data-quycach');
    var html = '';
    // var msg = 'Bạn muốn hủy bán sản phẩm này ?';
    var msg;

    if( quycach == 1 && price != -1)
    {
      msg = 'Sản phẩm này có nhiều giá theo màu sắc, kích thước, chất liệu. Hoa hồng cho sản phẩm này sẽ được tính trên giá mà khách hàng chọn mua thành công.';
    }
    else if(price != -1)
    {
      template_select = '<p>Bạn sẽ nhận được <span style="color: #FF1678">{{price}}đ</span> tiền hoa hồng khi bán sản phẩm này.<p>';
      template_select += '<p>Để bán bạn chỉ cần sao chép liên kết rồi chia sẻ và khách hàng mua hàng thành công từ liên kết của bạn thì bạn sẽ có hoa hồng.</p>';
      template_select += '<p>Hãy sao chép và chia sẻ ngay !</p>';
      msg = template_select.replace('{{price}}', parseInt(price).toLocaleString());
    }else{
      html = $('.btn-selectsale-'+product_id).html();
      msg = $(' .textAff-'+product_id).html();
    }
    // if (select === 'true') {
      // console.log('select',select);
      
    // }
      html += '<button type="button" class="btn-bg-gray cursor-pointer btn-copy">Sao chép liên kết</button>';

    $('.js_apply-commission').attr('data-product', product_id);
    $('.js_apply-commission').attr('data-select', select);
    $('.bd-commision-modal-sm').modal('show');
    
    // onclick="copy_text('+"'"+copy_link+"'"+')"
    $('.bd-commision-modal-sm .modal-body').html(msg);
    $('.modal-footer.buttons-group').html(html);
    copy_text(copy_link);
  });

    $('body').on('click', '.js_apply-commission', function (e) {
        e.preventDefault();
        $('.bd-commision-modal-sm').modal('hide');
        $._loading('show');
        var product_id = $(this).attr('data-product');
        var icon_path = '/templates/home/styles/images/svg/';
        if(!product_id)
            return;
        var selected = $('.js_product-item-'+product_id+' .js_get-pop-commission').attr('data-select');
        var url = '/home/affiliate/ajax_select_pro_sales';
        if(selected !== 'false'){
            url = '/home/affiliate/ajax_cancel_select_pro_sales'
        }
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                proid: product_id,
                id_pro: product_id
            },
            success: function (data) {
                if (data == 1) {
                    $('.js_product-item-'+product_id+' .js_get-pop-commission').attr({
                        'data-select': (selected === 'true' ? 'false' : 'true')
                    });

                    $('.js_product-item-'+product_id+' .js_get-pop-commission img').attr('src',icon_path + (selected === 'true' ? 'CTV.svg' : 'CTV_add.svg'));
                } else {
                    alert('Có lỗi xảy ra!');
                }
            }
        }).always(function() {
            $._loading();
        });
    });

});