<div class="modal affiliate-modal" id="js-setup-service-all">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

    </div>
  </div>
</div>

<script>
  var id = '';
  $('body').on('click', '.js-setup-service-all', function () {
    // $('#js-setup-service-all').modal('show');
    id = $(this).attr('data-id');

    if(isEmpty(id)) {
      alert('Lỗi không tìm thấy dữ liệu');
      return false;
    }

    var datas = {
      id : id
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
        // console.log(response);
        $('.load-wrapp').hide();
        if(response.type == 'success') {
          var result = response.data;
          var tpl = tpl_item = '';

          if(result.affiliate_data.aListPrice != '') {
            for (var index = 0; index < result.affiliate_data.aListPrice.length; index++) {
              var item = result.affiliate_data.aListPrice[index];
              var level_name = '';
              var max = 0, min = 0;
              switch (item.iLevel) {
                case 2:
                case '2':
                  level_name = 'Tổng đại lý';
                  max = result.affiliate_data.parent_value;
                  min = 25;
                  break;
                case 3:
                case '3':
                  level_name = 'Đại lý';
                  max = result.affiliate_data.parent_value;
                  min = 20;
                  break;
                default:
                  level_name = 'Thành viên mới';
                  break;
              }
              var tmp = $('#item-input').html();
              tmp = tmp.replace('{{DATA_VALUE_INPUT}}', item.iValue)
                    .replace('{{DATA_NAME_INPUT}}', (result.prefix_name_input + item.iLevel))
                    .replace('{{DATA_NAME_AFF}}', level_name)
                    .replace('{{DATA_MAX}}', max)
                    .replace('{{DATA_MIN}}', min);
              tpl_item += tmp;
            }
          }
          if(result.discount_rate > 0) {
            console.log(result);
            
            tpl = $('#tmp-discount-true').html();
            $('#js-setup-service-all .modal-content').html(tpl.replace('{{DATA_NAME_SERVICE}}', result.name)
                                                          .replace('{{DATA_PRICE_RAW}}', formatMoney(result.month_price))
                                                          .replace('{{DATA_PRICE_SALE}}', formatMoney(result.discount_price))
                                                          .replace('{{DATA_PERCENT_BONUS}}', result.affiliate_data.parent_value)
                                                          .replace('{{DATA_ITEM_INPUT}}', tpl_item)
                                                        );
            $('#js-setup-service-all').modal('show');
          } else {
            tpl = $('#tmp-discount-false').html();
            $('#js-setup-service-all .modal-content').html(tpl.replace('{{DATA_NAME_SERVICE}}', result.name)
                                                          .replace('{{DATA_PRICE_RAW}}', formatMoney(result.month_price))
                                                          .replace('{{DATA_ITEM_INPUT}}', tpl_item)
                                                        );
            $('#js-setup-service-all').modal('show');
          }
          $('#js-setup-service-all').modal('show')
        } else {
          alert(response.message);
        }
      }
    });
  })

  $('body').on('click', '.js-edit-price-affiliate-all', function () {
    if(isEmpty(id)) {
      alert('Lỗi không tìm thấy dữ liệu');
      return false;
    }

    var input = [];
    $('#js-setup-service-all').find('input').each(function() {
      input.push({name:$(this).attr('name'), value: $(this).val()});
    });
    var datas = {
      id      : id,
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

  $('body').on('change', '.js-number', function () {
    var _max = parseInt($(this).attr('data-max'));
    var _min = parseInt($(this).attr('data-min'));
    var value = parseInt($(this).val());
    if(!isNaN(value)) {
      if(value >= _min && value <= _max) {
        $(this).val(value);
      } else {
        $(this).val(_min);
      }
    } else {
      $(this).val(_min);
    }
  })
</script>

<script type="text/html" id="tmp-discount-true">
  <!-- Modal Header -->
  <div class="modal-header">
    <h4 class="modal-title">Cấu hình hoa hồng</h4>
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
        {{DATA_ITEM_INPUT}}
        <p class="text-italic">Lưu ý: phần trăm hoa hồng cấu hình phải nhỏ hơn phần trăm hoa hồng được hưởng</p>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <div class="shareModal-footer">
      <div class="permision"></div>
      <div class="buttons-direct">
        <button class="btn-cancle" data-dismiss="modal">Hủy</button>
        <button class="btn-share js-edit-price-affiliate-all">Lưu</button>
      </div>
    </div>
  </div>
</script>

<script type="text/html" id="tmp-discount-false">
  <!-- Modal Header -->
  <div class="modal-header">
    <h4 class="modal-title">Cấu hình hoa hồng</h4>
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
        {{DATA_ITEM_INPUT}}
        <p class="text-italic">Lưu ý: phần trăm hoa hồng cấu hình phải nhỏ hơn phần trăm hoa hồng được hưởng</p>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <div class="shareModal-footer">
      <div class="permision"></div>
      <div class="buttons-direct">
        <button class="btn-cancle" data-dismiss="modal">Hủy</button>
        <button class="btn-share js-edit-price-affiliate-all">Lưu</button>
      </div>
    </div>
  </div>
</script>

<script type="text/html" id="item-input">
  <div class="input-percent">
    <p>Hoa hồng cho
      <span class="text-red">{{DATA_NAME_AFF}}</span></p>
    <p class="input-number js-number">
      <input type="text" value="{{DATA_VALUE_INPUT}}" name="{{DATA_NAME_INPUT}}" class="form-control js-number" placeholder="nhập số" data-max="{{DATA_MAX}}" data-min="{{DATA_MIN}}">%</p>
  </div>
</script>