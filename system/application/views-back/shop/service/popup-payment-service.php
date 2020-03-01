<!-- modal -->
<!-- Modal -->
<div class="modal" id="pop-add-pay-branch">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-mess ">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Đăng ký gói <?=$service['name']?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>          
        <!-- Modal body -->
        <form id="form_pay_branch" method="post">
            <div class="modal-body">
                <input type="hidden" name="package" class="package" value="<?=$service['id']?>">
                <input type="hidden" name="iUserId" class="iUserId" value="<?=$iUserId?>">
                <input type="hidden" name="periods" class="periods" value="-1">
                <input type="hidden" name="type_affiliate" class="type_affiliate" value="<?=$service['type_affiliate']?>">
                <input type="hidden" name="discount_type" class="discount_type" value="<?=$service['discount_type']?>">

                <div class="creatBranch-content settingBranch-content">
                    <div class="shop_rule_bank">
                        <?php if ($service['info_id'] == 16) { ?>
                        <div class="form-group">
                            <label>Số chi nhánh cần mở:</label>
                            <input type="number" name="numbran" class="form-control" min="1" max="99" placeholder="" required="required" value="1">
                            <span class="text-red js-msg-error"></span>
                        </div>
                        <?php } else { ?>
                        <input type="hidden" name="numbran" class="form-control" value="1">
                        <?php } ?>
                        <div class="form-group">
                            <label>Phương thức thanh toán:</label>
                            <div class="form-group">
                                <label class="checkbox-style mt10">
                                    <input class="type_pay" type="radio" name="type_pay" value="1" checked>
                                    <span>Ví MoMo</span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-style mt10">
                                    <input class="type_pay" type="radio" name="type_pay" value="2">
                                    <span>Thanh toán online bằng thẻ ngân hàng nội địa</span>
                                </label>

                                <div class="select-banks" style="display: none;">
                                    <p><i>
                                    <span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>: Bạn cần đăng ký Internet-Banking hoặc dịch vụ thanh toán trực tuyến tại ngân hàng trước khi thực hiện.</i></p>
                                    <br>
                                    <ul class="select-banks-check">
                                      <li>
                                        <label for="exampleCheck1">
                                          <img src="/templates/home/styles/images/banks/bidv.png" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam" alt="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"><br>
                                          <input type="radio" value="BIDV"  name="bankcode" id="exampleCheck1">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck2">
                                          <img src="/templates/home/styles/images/banks/vietcombank.png" title="Ngân hàng TMCP Ngoại Thương Việt Nam" alt="Ngân hàng TMCP Ngoại Thương Việt Nam"><br>
                                          <input type="radio" value="VCB"  name="bankcode" id="exampleCheck2">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck3">
                                          <img src="/templates/home/styles/images/banks/donga.png" title="Ngân hàng Đông Á" alt="Ngân hàng Đông Á"><br>
                                          <input type="radio" value="DAB"  name="bankcode" id="exampleCheck3">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck4">
                                          <img src="/templates/home/styles/images/banks/techcombank.png" title="Ngân hàng Kỹ Thương" alt="Ngân hàng Kỹ Thương"><br>
                                          <input type="radio" value="TCB"  name="bankcode" id="exampleCheck4">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck5">
                                          <img src="/templates/home/styles/images/banks/mb.png" title="Ngân hàng Quân Đội" alt="Ngân hàng Quân Đội"><br>
                                          <input type="radio" value="MB"  name="bankcode" id="exampleCheck5">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck6">
                                          <img src="/templates/home/styles/images/banks/vib.png" title="Ngân hàng Quốc tế" alt="Ngân hàng Quốc tế"><br>
                                          <input type="radio" value="VIB"  name="bankcode" id="exampleCheck6">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck7">
                                          <img src="/templates/home/styles/images/banks/viettin.png" title="Ngân hàng Công Thương Việt Nam" alt="Ngân hàng Công Thương Việt Nam"><br>
                                          <input type="radio" value="ICB"  name="bankcode" id="exampleCheck7">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck8">
                                          <img src="/templates/home/styles/images/banks/exim.png" title="Ngân hàng Xuất Nhập Khẩu" alt="Ngân hàng Xuất Nhập Khẩu"><br>
                                          <input type="radio" value="EXB"  name="bankcode" id="exampleCheck8">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck9">
                                          <img src="/templates/home/styles/images/banks/acb.png" title="Ngân hàng Á Châu" alt="Ngân hàng Á Châu"><br>
                                          <input type="radio" value="ACB" name="bankcode" id="exampleCheck9">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck10">
                                          <img src="/templates/home/styles/images/banks/hd.png" title="Ngân hàng Phát triển Nhà TPHCM" alt="Ngân hàng Phát triển Nhà TPHCM"><br>
                                          <input type="radio" value="HDB"  name="bankcode" id="exampleCheck10">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck11">
                                          <img src="/templates/home/styles/images/banks/maritime.png" title="Ngân hàng Hàng Hải" alt="Ngân hàng Hàng Hải"><br>
                                          <input type="radio" value="MSB"  name="bankcode" id="exampleCheck11">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck12">
                                          <img src="/templates/home/styles/images/banks/ncb.png" title="Ngân hàng Nam Việt" alt="Ngân hàng Nam Việt"><br>
                                          <input type="radio" value="NVB"  name="bankcode" id="exampleCheck12">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck13">
                                          <img src="/templates/home/styles/images/banks/vieta.png" title="Ngân hàng Việt Á" alt="Ngân hàng Việt Á"><br>
                                          <input type="radio" value="VAB"  name="bankcode" id="exampleCheck13">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck15">
                                          <img src="/templates/home/styles/images/banks/vp.png" title="Ngân Hàng Việt Nam Thịnh Vượng" alt="Ngân Hàng Việt Nam Thịnh Vượng"><br>
                                          <input type="radio" value="VPB"  name="bankcode" id="exampleCheck15">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck16">
                                          <img src="/templates/home/styles/images/banks/sacom.png" title="Ngân hàng Sài Gòn Thương tín" alt="Ngân hàng Sài Gòn Thương tín"><br>
                                          <input type="radio" value="SCB"  name="bankcode" id="exampleCheck16">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck17">
                                          <img src="/templates/home/styles/images/banks/pg.png" title="Ngân hàng Xăng dầu Petrolimex" alt="Ngân hàng Xăng dầu Petrolimex"><br>
                                          <input type="radio" value="PGB"  name="bankcode" id="exampleCheck17">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck18">
                                          <img src="/templates/home/styles/images/banks/gp.png" title="Ngân hàng TMCP Dầu khí Toàn Cầu" alt="Ngân hàng TMCP Dầu khí Toàn Cầu"><br>
                                          <input type="radio" value="GPB"  name="bankcode" id="exampleCheck18">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck19">
                                          <img src="/templates/home/styles/images/banks/agri.png" title="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn" alt="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn"><br>
                                          <input type="radio" value="AGB"  name="bankcode" id="exampleCheck19">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck20">
                                          <img src="/templates/home/styles/images/banks/saigon.png" title="Ngân hàng Sài Gòn Công Thương" alt="Ngân hàng Sài Gòn Công Thương"><br>
                                          <input type="radio" value="SGB"  name="bankcode" id="exampleCheck20">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck21">
                                          <img src="/templates/home/styles/images/banks/baca.png" title="Ngân hàng Bắc Á" alt="Ngân hàng Bắc Á"><br>
                                          <input type="radio" value="BAB"  name="bankcode" id="exampleCheck21">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck22">
                                          <img src="/templates/home/styles/images/banks/tp.png" title="Tiền phong bank" alt="Tiền phong bank"><br>
                                          <input type="radio" value="TPB"  name="bankcode" id="exampleCheck22">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck23">
                                          <img src="/templates/home/styles/images/banks/nama.png" title="Ngân hàng Nam Á" alt="Ngân hàng Nam Á"><br>
                                          <input type="radio" value="NAB"  name="bankcode" id="exampleCheck23">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck24">
                                          <img src="/templates/home/styles/images/banks/shb.png" title="Ngân hàng TMCP Sài Gòn - Hà Nội (SHB)" alt="Ngân hàng TMCP Sài Gòn - Hà Nội (SHB)"><br>
                                          <input type="radio" value="SHB"  name="bankcode" id="exampleCheck24">
                                        </label>
                                      </li>
                                      <li>
                                        <label for="exampleCheck25">
                                          <img src="/templates/home/styles/images/banks/ocen.png" title="Ngân hàng TMCP Đại Dương (OceanBank)" alt="Ngân hàng TMCP Đại Dương (OceanBank)"><br>
                                          <input type="radio" value="OJB"  name="bankcode" id="exampleCheck25">
                                        </label>
                                      </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-style mt10">
                                    <input class="type_pay" type="radio" name="type_pay" value="3">
                                    <span>Thanh toán bằng thẻ Visa hoặc MasterCard</span>
                                </label>

                                <div class="select-visa" style="display: none;">
                                    <p><i>
                                    <span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>: Visa hoặc MasterCard.</i></p>
                                    <br>
                                    <ul class="select-banks-check">
                                      <li>
                                        <label class="checkbox-style mt10">
                                            <input class="type_pay" type="radio" name="bankcode" value="VISA" checked>
                                            <span>VISA</span>
                                        </label>
                                      </li>
                                      <li>
                                        <label class="checkbox-style mt10">
                                            <input class="type_pay" type="radio" name="bankcode" value="MASTER">
                                            <span>Master</span>
                                        </label>
                                      </li>
                                    </ul>
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <label class="checkbox-style">
                                    <input class="type_pay" type="radio" name="type_pay" value="0">
                                    <span>Ví Azibai</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                                if (!empty($service['discount_price'])) 
                                {
                                    $price_buy = $service['discount_price'];
                                } 
                                else
                                {
                                    $price_buy = $service['month_price'];
                                }
                            ?> 
                            <label>Tổng tiền: 
                                <span class="total-pay-branch" data-branch="<?php echo $price_buy; ?>">
                                    <?php echo number_format($price_buy, 0, ',', '.') . ' đ'; ?>
                                </span>
                            </label>
                        </div>

                    </div>
                </div>                          
            </div>   
            <div class="modal-footer">
                <div class="shareModal-footer">
                  <div class="permision"></div>
                  <div class="buttons-direct">
                    <button class="btn-cancle">Đóng</button>
                    <button class="btn-share add-pay-branch" type="button">Đăng ký</button>
                  </div>
                </div>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- end Modal -->
<!-- end modal -->

<div class="modal" id="js-show-alert">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">THÔNG BÁO</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

      </div>

      <!-- Modal footer -->
      <!-- <div class="modal-footer buttons-group">
        <div class="bst-group-button">
          <div class="left">

          </div>
          <div class="right">
            <button type="button" class="btn btn-bg-white" data-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div> -->

    </div>
  </div>
</div>


<script type="text/javascript">

    $('input[type="number"]').bind('keyup input', function(){
        var number = parseInt($(this).val());
        var price_one = parseInt($('.total-pay-branch').attr('data-branch'));
        if (isNaN(number)) 
        {
            $('.total-pay-branch').text(parseInt(price_one).toLocaleString());
        }
        else
        {
            $('.total-pay-branch').text(parseInt(price_one * number).toLocaleString());
        }
    });


    $('#add_service').click(function(){
        $('#pop-add-pay-branch').modal('show');
    });


    $(':radio[name="type_pay"]').change(function() {
      var type_pay = $(this).filter(':checked').val();
      if (type_pay == 2) 
      {
            $('.select-banks').show();
            $('.select-visa').hide();
      }
      else if (type_pay == 3) 
      {
            $('.select-visa').show();
            $('.select-banks').hide();
      }
      else
      {
           $('.select-visa').hide();
           $('.select-banks').hide();
      }
    });


    $('input[type="number"]').bind('blur', function(){
        var number = parseInt($(this).val());
        var price_one = parseInt($('.total-pay-branch').attr('data-branch'));
        if (isNaN(number)) 
        {
            $('.total-pay-branch').text(parseInt(price_one).toLocaleString());
            $(this).val(1);
        }
        else
        {
            $('.total-pay-branch').text(parseInt(price_one * number).toLocaleString());
        }
    });


    $('.add-pay-branch').click(function() {
        $('.load-wrapp').show();
        var type_pay = parseInt($("#form_pay_branch input.type_pay[type='radio']:checked").val());
        jQuery.ajax({
            type: "POST",
            url: siteUrl + "ajax/add-package",
            dataType: 'json',
            data: $('#form_pay_branch').serialize(),
            success: function (resb) {
                var error_modal = $('#js-show-alert');
                var error = $('#js-show-alert .modal-body');
                if (type_pay == 1) 
                {
                    if (resb.link_pay != '') 
                    {
                        link_pay = JSON.parse(resb.link_pay);
                        if (link_pay.errorCode === 0) 
                        {
                            window.open(link_pay.payUrl, '_blank');
                            $('#pop-add-pay-branch').modal('hide'); 
                        }
                        else 
                        {
                            error.html('<div class="error">Thanh toán gói thất bại</div>');
                            $(error_modal).modal('show');
                        }
                    } 
                    else 
                    {
                        error.html('<div class="error">Thanh toán gói thất bại</div>');
                        $(error_modal).modal('show');
                    } 
                }
                else if (type_pay == 2 || type_pay == 3) 
                {
                    if (resb.link_pay != '') 
                    { 
                        if (resb.link_pay.error_code === '00') 
                        {
                            window.open(resb.link_pay.checkout_url, '_blank');
                            $('#pop-add-pay-branch').modal('hide'); 
                        }
                        else 
                        {
                            error.html('<div class="error">Thanh toán gói thất bại</div>');
                            $(error_modal).modal('show');
                        }
                    } 
                    else 
                    {
                        error.html('<div class="error">Thanh toán gói thất bại</div>');
                        $(error_modal).modal('show');
                    }
                } 
                else
                {
                    if(resb.error == true) {
                        error.html('<div class="error">'+resb.message+'</div>');
                        $(error_modal).modal('show');
                    }else {
                        error.html('<div class="success">'+resb.message+'</div>');
                        $(error_modal).modal('show');
                    }
                }

                $('#pop-add-pay-branch').modal('hide');

            }
        }).always(function() {
            $('.load-wrapp').hide();
        });
    });
</script>