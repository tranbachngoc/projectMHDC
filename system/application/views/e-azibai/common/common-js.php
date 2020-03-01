<script>
  function addCart(pro_id) {
    $('.load-wrapp').show();
    $.ajax({
      type: "POST",
      dataType: "json",
      url: siteUrl + 'showcart/add',
      data: $('#bt_' + pro_id + ' :input').serialize(),
      success: function (result) {
        $('.load-wrapp').hide();
        if (result.error == false) {
          $('.cartNum').text(result.num);
        }
        var type = result.error == true ? 'alert-danger' : 'alert-success';
        $('#dialog_mess').modal('show');
        $('#mess_detail').html('<p class="' + type + '">' + result.message + '</p>');
      },
      error: function () { }
    });
  }

  function SelectProSales(siteUrl, id) {
    $.ajax({
        type: "POST",
        url: siteUrl + "home/affiliate/ajax_select_pro_sales",
        dataType: 'json',
        data: {proid: id},
        success: function (data) {
            //console.log(data);
            if (data == '1') {
                location.reload();
            } else {
                alert('Có lỗi xảy ra!');
            }
        }
    });
  }

  $('.sm-btn-show').click(function () {
    var parent = $(this).closest('.item');
    parent.toggleClass('show-action');
    console.log(parent);
    if (parent.hasClass('show-action')) {
      $(this).find('img').attr('src', '/templates/home/styles/images/svg/shop_icon_close.svg');
    } else {
      $(this).find('img').attr('src', '/templates/home/styles/images/svg/shop_icon_add.svg');
    }
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

<script>
  $(".js-search-product").on("keyup", function (e) {
    $(".js-search-product").val($(this).val());
    if (e.which == 13) {
      var keyword = encodeURIComponent(e.currentTarget.value.trim());
      if(keyword !== '') {
        var url = encodeURI("<?=azibai_url("/find-product")?>"+"?keyword="+keyword+"<?=$_REQUEST['af_id'] ? "&af_id={$_REQUEST['af_id']}" : ""?>");
        window.location.replace(url);
      }
    }
  })
</script>