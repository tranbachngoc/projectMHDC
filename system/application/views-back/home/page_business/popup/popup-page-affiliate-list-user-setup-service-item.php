<div class="modal affiliate-modal" id="js-setup-service">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

    </div>
  </div>
</div>

<script>
  var id = user_id = '';
  $('body').on('click', '.js-setup-service', function () {
    id      = $(this).attr('data-id');
    user_id = $(this).attr('data-user');

    if(isEmpty(id) || isEmpty(user_id)) {
      alert('Lỗi không tìm thấy dữ liệu');
      return false;
    }

    var datas = {
      id      : id,
      user_id : user_id
    };

    $.ajax({
      type: "post",
      url: siteUrl+"profile/affiliate/getservice",
      data: datas,
      dataType: "json",
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        $('.load-wrapp').hide();
        if(response.type == 'success') {
          var result = response.data;
          var tpl = '';
          if(result.affiliate_data.parent_value > 0) {
            var level_name = '';
            switch (result.affiliate_data.iLevel) {
              case 2:
              case '2':
                level_name = 'Tổng đại lý';
                break;
              case 3:
              case '3':
                level_name = 'Đại lý';
                break;
              default:
                level_name = 'Thành viên mới';
                break;
            }
            tpl = $('#tmp-discount-true').html();
            $('#js-setup-service .modal-content').html(tpl.replace('{{DATA_NAME_USER_1}}', result.affiliate_data.sUserName)
                                                          .replace('{{DATA_NAME_USER_2}}', result.affiliate_data.sUserName)
                                                          .replace('{{DATA_NAME_SERVICE}}', result.name)
                                                          .replace('{{DATA_VALUE_INPUT}}', result.affiliate_data.user_value)
                                                          .replace('{{DATA_NAME_INPUT}}', 'price_aff_' + result.affiliate_data.iLevel)
                                                          .replace('{{DATA_PRICE_RAW}}', formatMoney(result.month_price))
                                                          .replace('{{DATA_PRICE_SALE}}', formatMoney(result.discount_price))
                                                          .replace('{{DATA_PERCENT_BONUS}}', result.affiliate_data.parent_value)
                                                          .replace('{{DATA_NAME_LEVEL_USER}}', level_name) );
            $('#js-setup-service').modal('show');
          } else {
            tpl = $('#tmp-discount-false').html();
            $('#js-setup-service .modal-content').html(tpl.replace('{{DATA_NAME_USER_1}}', result.affiliate_data.sUserName)
                                                          .replace('{{DATA_NAME_USER_2}}', result.affiliate_data.sUserName)
                                                          .replace('{{DATA_NAME_SERVICE}}', result.name)
                                                          .replace('{{DATA_VALUE_INPUT}}', result.affiliate_data.user_value)
                                                          .replace('{{DATA_NAME_INPUT}}', 'price_aff_' + result.affiliate_data.iLevel)
                                                          .replace('{{DATA_PRICE_RAW}}', formatMoney(result.month_price))
                                                          .replace('{{DATA_PERCENT_BONUS}}', result.affiliate_data.parent_value)
                                                          .replace('{{DATA_NAME_LEVEL_USER}}', level_name) );
            $('#js-setup-service').modal('show');
          }
        } else {
          alert(response.message);
        }
      }
    });
  })

  $('body').on('click', '.js-edit-price-affiliate', function () {

    if(isEmpty(id) || isEmpty(user_id)) {
      alert('Lỗi không tìm thấy dữ liệu');
      return false;
    }

    var input = [];
    $('#js-setup-service').find('input').each(function() {
      input.push({name:$(this).attr('name'), value: $(this).val()});
    });

    var datas = {
      id      : id,
      user_id : user_id,
      input   : input
    }

    $.ajax({
      type: "POST",
      url: siteUrl+"profile/affiliate/editservice",
      dataType: 'json',
      data: datas,
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        if(response.type == 'success') {
          alert(response.message);
          window.location.reload();
        }else {
          $('.load-wrapp').hide();
          alert(response.message);
        }
      }
    });
  })
</script>

<script type="text/html" id="tmp-discount-true">
  <!-- Modal Header -->
  <div class="modal-header">
    <h4 class="modal-title">Cấu hình hoa hồng cho {{DATA_NAME_USER_1}}</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <!-- Modal body -->
  <div class="modal-body">
    <div class="affiliate-arranged-setting">
      <div class="product">
        <div class="img">
          <img src="/templates/home/styles/images/svg/bg_dichvu.png" alt="">
        </div>
        <div class="text">
          <h4 class="tit">{{DATA_NAME_SERVICE}}</h4>
          <p class="price-before">Giá gốc: &nbsp;
            <span>{{DATA_PRICE_RAW}}
              <span class="f12">VNĐ</span>
            </span>
          </p>
          <p class="price-after">Giá giảm: &nbsp;
            <span class="text-bold">{{DATA_PRICE_SALE}}
              <span class="f12">VNĐ</span>
            </span>
          </p>
        </div>
      </div>
      <div>
        <p>Phần trăm hoa hồng được hưởng:
          <span class="text-red">{{DATA_PERCENT_BONUS}}%</span>
        </p>
        <div class="input-percent">
          <p>Hoa hồng của
            <span class="text-red">{{DATA_NAME_USER_2}}</span>({{DATA_NAME_LEVEL_USER}})</p>
          <p class="input-number">
            <input type="text" value="{{DATA_VALUE_INPUT}}" name="{{DATA_NAME_INPUT}}" class="form-control" placeholder="nhập số">%</p>
        </div>
        <p class="text-italic">Lưu ý: phần trăm hoa hồng cấu hình phải nhỏ hơn phần trăm hoa hồng được hưởng</p>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <div class="shareModal-footer">
      <div class="permision"></div>
      <div class="buttons-direct">
        <button class="btn-cancle" data-dismiss="modal">Hủy</button>
        <button class="btn-share js-edit-price-affiliate">Lưu</button>
      </div>
    </div>
  </div>
</script>

<script type="text/html" id="tmp-discount-false">
  <!-- Modal Header -->
  <div class="modal-header">
    <h4 class="modal-title">Cấu hình hoa hồng cho {{DATA_NAME_USER_1}}</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <!-- Modal body -->
  <div class="modal-body">
    <div class="affiliate-arranged-setting">
      <div class="product">
        <div class="img">
          <img src="/templates/home/styles/images/svg/bg_dichvu.png" alt="">
        </div>
        <div class="text">
          <h4 class="tit">{{DATA_NAME_SERVICE}}</h4>
          <p class="price-after">Giá gốc: &nbsp;
            <span>{{DATA_PRICE_RAW}}
              <span class="f12">VNĐ</span>
            </span>
          </p>
        </div>
      </div>
      <div>
        <p>Phần trăm hoa hồng được hưởng:
          <span class="text-red">{{DATA_PERCENT_BONUS}}%</span>
        </p>
        <div class="input-percent">
          <p>Hoa hồng của
            <span class="text-red">{{DATA_NAME_USER_2}}</span>({{DATA_NAME_LEVEL_USER}})</p>
          <p class="input-number">
            <input type="text" value="{{DATA_VALUE_INPUT}}" name="{{DATA_NAME_INPUT}}" class="form-control" placeholder="nhập số">%</p>
        </div>
        <p class="text-italic">Lưu ý: phần trăm hoa hồng cấu hình phải nhỏ hơn phần trăm hoa hồng được hưởng</p>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <div class="shareModal-footer">
      <div class="permision"></div>
      <div class="buttons-direct">
        <button class="btn-cancle" data-dismiss="modal">Hủy</button>
        <button class="btn-share js-edit-price-affiliate">Lưu</button>
      </div>
    </div>
  </div>
</script>