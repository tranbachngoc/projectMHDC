<?php $this->load->view('home/common/header'); ?>
    <div class="container">
    <div class="form-group">
<?php $this->load->view('home/common/left'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<SCRIPT TYPE="text/javascript">
<!--
function submitenter(myfield,e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   CheckInput_EditAccount();
   return false;
   }
else
   return true;
}
//-->
</SCRIPT>
<!--BEGIN: RIGHT-->
<div class="col-lg-9 col-md-9 col-sm-8 col-sm-8 col-xs-12 account_edit">
    <div class="tile_modules tile_modules_blue"><?php echo $this->lang->line('title_edit_account'); ?></div>
    <form name="frmEditAccount" id="frmEditAcc" method="post" enctype="multipart/form-data" class="form-horizontal vientong">
        <?php if ((int)$this->session->userdata('sessionGroup') <= 2){
            $req =  '';
            $requr = '';
        }else{
            $req =  '<b>*</b>';
            $requr =  'required="required"';
        }
        ?>
        <?php if($successEditAccount == false){
           $group_id =  $this->session->userdata('sessionGroup');
            if($group_id == '2'){
                $url2 = 'affiliate';

            }elseif($group_id == '3'){
                $url2 = 'afstore';
            }else{
                $url2 = 'all';
            }
            ?>
                <div class="form-group viennen">
                    <div class="col-lg-3 col-md-3 col-sm-4"><?php echo $this->lang->line('username_edit_account'); ?>:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <strong><?php if(isset($username_account)){echo $username_account;} ?></strong>
                    </div>
                </div>
                <div class="form-group viennen">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> <?php echo $this->lang->line('avatar_edit_account'); ?>:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <div style=" display:<?php if($avatar!=''){ echo "none" ; } else { echo "block"; } ?>" id="vavatar_input">
                            <input type="hidden" name="avatar_hidden" value="<?php echo $avatar; ?>" />
                           <span class="btn btn-primary btn-file">
                             <i class="fa fa-upload" aria-hidden="true"></i> Chọn File
                               <input name="avatar" id="avatar" class="inputimage_formpost" type="file">
                         </span>
                            <input type="button" class="btn btn-default" onclick="resetBform-groupesIimgQ('avatar');"  value="Hủy" />
                            <p>
                              <span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> (Dung lượng tối đa  512 KB)</span>
                            </p>
                        </div>
                        <div style=" display:<?php if($avatar==''){ echo "none" ; } else { echo "block"; } ?>" id="img_vavatar_input">
                            <div style="float:left;">
                                <img style="margin-top:7px;" width="120" src="<?php if($avatar!=''){echo base_url(); ?>media/images/avatar/thumbnail_<?php echo $avatar; }else{ ?><?php echo base_url()."media/images/avatar/default.png"; } ?>" border="0" />
                            </div>
                            <div style="float:left; ">
                                <img style="margin-top:7px;" src="<?php echo base_url(); ?>templates/home/images/xoaimg.png" border="0" title="Xóa hình này " onclick="return delete_img_ajax('<?php echo base_url(); ?>home/account/','<?php echo $this->session->userdata('sessionUser'); ?>','use_id','avatar','tbtt_user');" />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group viennen">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> <?php echo $this->lang->line('email_edit_account'); ?>:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <input type="text" name="email_account" id="email_account" value="<?php  echo $email_account?$email_account:$email_post; ?>" maxlength="50" class="input_formpost form-control" <?php if($email_account !=''){ echo 'readonly';}?>  onfocus="ChangeStyle('email_account',1)" onblur="ChangeStyle('email_account',2)" />
                        <?php echo form_error('email_account'); ?>
                    </div>
                </div>
<!--                <div class="form-group viennen">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> <?php echo $this->lang->line('reemail_edit_account'); ?>:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <input type="text" name="reemail_account" id="reemail_account" value="<?php if(isset($reemail_account)){echo $reemail_account;} ?>" maxlength="50" class="input_formpost form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('reemail_account',1)" onblur="ChangeStyle('reemail_account',2)" />
                        <?php echo form_error('reemail_account'); ?>
                    </div>
                </div>-->
                <div class="form-group viennen">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> <?php echo $this->lang->line('fullname_edit_account'); ?>:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <input type="text" name="fullname_account" id="fullname_account" value="<?php echo $fullname_account?$fullname_account:$fullname_post;?>" maxlength="80" class="input_formpost form-control" <?php if($fullname_account !=''){ echo 'readonly';}?>  onfocus="ChangeStyle('fullname_account',1)" onblur="ChangeStyle('fullname_account',2)" />
                        <?php echo form_error('fullname_account'); ?>
                    </div>
                </div>
                <div class="form-group viennen">
                    <div class="col-lg-3 col-md-3 col-sm-3"><font color="#FF0000"><?php echo $req;?></font> <?php echo $this->lang->line('birthday_edit_account'); ?>:</div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <select name="day_account" id="day_account" class="selectdate_formpost">
                            <?php for($day = 1; $day <= 31; $day++){ ?>
                                <?php if(isset($day_account) && (int)$day_account == $day){ ?>
                                    <option value="<?php echo $day; ?>" selected="selected"><?php echo $day; ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <b>-</b>
                        <select name="month_account" id="month_account" class="selectdate_formpost">
                            <?php for($month = 1; $month <= 12; $month++){ ?>
                                <?php if(isset($month_account) && (int)$month_account == $month){ ?>
                                    <option value="<?php echo $month; ?>" selected="selected"><?php echo $month; ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <b>-</b>
                        <select name="year_account" id="year_account" class="selectdate_formpost">
                            <?php for($year = (int)date('Y')-70; $year <= (int)date('Y')-10; $year++){ ?>
                                <?php if(isset($year_account) && (int)$year_account == $year){ ?>
                                    <option value="<?php echo $year; ?>" selected="selected"><?php echo $year; ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-6 form-inline">
                        <label for="sex_account"><font color="#FF0000"><?php echo $req;?></font> <?php echo $this->lang->line('sex_edit_account'); ?>:</label>
                        <select name="sex_account" id="sex_account" class="selectsex_formpost">
                            <option value="1" <?php if(isset($sex_account) && (int)$sex_account == 1){echo 'selected="selected"';} ?>><?php echo $this->lang->line('male_edit_account'); ?></option>
                            <option value="0" <?php if(isset($sex_account) && (int)$sex_account == 0){echo 'selected="selected"';} ?>><?php echo $this->lang->line('female_edit_account'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group viennen">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> Số CMND:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <input <?php echo $requr; ?> name="idcard_account" id="idcard_regis"  <?php if($idcard_account ==''){?> onblur="checkUserIdcard(this.value, '<?php echo base_url(); ?>', 'affiliate')" <?php }?>   type="text" class="form-control" <?php if($idcard_account > 0){ echo 'readonly';}?>  value="<?php  echo $idcard_account?$idcard_account:$idcard_post; ?>" />
                    </div>
                </div>
                <!--<div class="form-group">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> <?php echo $this->lang->line('address_edit_account'); ?>:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <input <?php if($address_account != 0){ echo 'readonly';}?> type="text" name="address_account" id="address_account" value="<?php echo $address_account?$address_account:$address_post;?>" maxlength="80" class="input_formpost form-control" onblur="ChangeStyle('address_account',2)" />
                        <?php echo form_error('address_account'); ?>
                    </div>
                </div>-->
                <div class="form-group viennen">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> <?php echo $this->lang->line('province_edit_account'); ?>:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <select <?php echo $requr; ?> name="province_account" id="province_account" class="selectprovince_formpost form-control">
                            <option value="">Chọn Tỉnh/Thành</option>
                            <?php foreach($province as $provinceArray){ ?>
                                <?php if(isset($province_account) && $province_account == $provinceArray->pre_id){ ?>
                                    <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <?php echo form_error('province_account'); ?>
                    </div>
                </div>

                <div class="form-group viennen">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> <?php echo $this->lang->line('district_edit_account'); ?>:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <select <?php echo $requr; ?> name="district_account" id="district_account" class="selectprovince_formpost form-control">
                            <option value="">Chọn Quận/Huyện</option>
                            <?php
                            foreach ($district as $vals):
                                if($vals->DistrictCode == $district_account){
                                    $district_selected = "selected='selected'";
                                } else {
                                    $district_selected = '';
                                }
                                echo '<option value="'.$vals->DistrictCode.'" '.$district_selected.'>'.$vals->DistrictName.'</option>';
                            endforeach;
                            ?>
                        </select>
                        <?php echo form_error('district_account'); ?>
                    </div>
                </div>

				<div class="form-group viennen">
					<div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> Điện thoại di động:</div>
					<div class="col-lg-9 col-md-9 col-sm-8">
						<input  <?php echo  $requr; ?> type="text" <?php if($mobile_account != ''){ echo 'readonly'; }?> name="mobile_account" id="mobile_account" value="<?php echo $mobile_account?$mobile_account:$mobile_post; ?>" maxlength="20" class="inputphone_formpost form-control" onblur="checkUserMobile(this.value, '<?php echo base_url();?>','affiliate')" />
						<img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                        <span class="div_helppost"><?php echo $this->lang->line('phone_help'); ?></span>
						<?php echo form_error('phone_account'); ?>
					</div>
				</div>
			<!--
                <div class="form-group">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> Tên ngân hàng:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <input  <?php echo  $requr; ?> value="<?php echo $bank_name?$bank_namet:$bank_name_post; ?>" name="namebank_regis" id="namebank_regis"  class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> Thuộc chi nhánh :</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <input  <?php echo  $requr; ?> value="<?php  echo $bank_add?$bank_add:$bank_add_post;  ?>" name="addbank_regis" id="addbank_regis"  class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> Họ và tên chủ tài khoản:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <input  <?php echo  $requr; ?> value="<?php echo $account_name?$account_name:$account_name_post;  ?>" name="accountname_regis" id="accountname_regis"  class="form-control " type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> Số tài khoản:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <input  <?php echo  $requr; ?> value="<?php echo $num_account?$num_account:$num_account_post;  ?>" name="accountnum_regis" id="accountnum_regis" class="form-control " type="text">
                    </div>
                </div>
                <div class="form-group viennen">
                    <div class="col-lg-3 col-md-3 col-sm-4">Mã số thuế cá nhân:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <input type="text" name="tax_code_account" id="taxcode_regis" <?php if($tax_code != ''){ echo 'readonly'; }?> value="<?php echo $tax_code?$tax_code:$tax_code_post;?>" maxlength="50" class="form-control" onfocus="ChangeStyle('fax',1)" <?php if($tax_code == ''){?> onblur="checkUserTaxcode(this.value, '<?php echo base_url(); ?>','affiliate')" <?php }?>  />
                        <p>  <input id="check_notaxcode" name="check_notaxcode" type="checkbox"> Tôi chưa có Mã số thuế</p>
                        <p class="text-warning">
                            <i>(Nếu chưa có MST cá nhân, bạn vẫn có thể tham gia kinh doanh trên Azibai. Tuy nhiên, theo quy định của pháp luật, bạn sẽ bị khấu trừ 20% thuế thu nhập thay vì 10% như khi đã có MST)</i></p>
                    </div>
                </div>
				-->
                <?php if(isset($imageCaptchaEditAccount)){ ?>
                    <div class="form-group viennen">
                        <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req;?></font> <?php echo $this->lang->line('captcha_main'); ?>:</div>
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <img src="<?php echo $imageCaptchaEditAccount; ?>" width="151" height="30" /><br />
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-8">
                            <input onkeypress="return submitenter(this,event)" type="text" name="captcha_account" id="captcha_account" value="" maxlength="10" class="inputcaptcha_form  form-control" onfocus="ChangeStyle('captcha_account',1);" onblur="ChangeStyle('captcha_account',2);" />
                            <?php echo form_error('captcha_account'); ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group viennen">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-9">
                        <?php if ((int)$this->session->userdata('sessionGroup') > 2){?>
                        <input class="btn btn-primary" type="button" onclick="CheckInput_EditAccount();" name="submit_editaccount" value="<?php echo $this->lang->line('button_update_edit_account'); ?>" />
						<?php }else{ ?>
                            <button class="btn btn-primary" type="submit"  name="submit_editaccount" ><?php echo $this->lang->line('button_update_edit_account'); ?></button>
						<?php } ?>
                        <input class="btn btn-danger" type="button" name="reset_editaccount" value="<?php echo $this->lang->line('button_cancle_edit_account'); ?>" onclick="ActionLink('<?php echo base_url(); ?>account')" />
                    </div>
                 </div>
                <input type="hidden" name="isPostAccount" value="1" />

        <?php }else{ ?>
            <div class="form-group ">

                <p class="text-center">
                    <?php echo $this->lang->line('success_change_password'); ?>
                </p>
                <?php if($this->session->userdata('sessionGroup') == 3 && count($shopid)== 0) {?>
                <script>
                    jQuery(document).ready(function(jQuery) {
                        jQuery.jAlert({
                            'title': 'Thông báo',
                            'content': 'Bạn vui lòng cập nhật thông tin Gian hàng để kích hoạt shop của bạn!',
                            'theme': 'default',
                            'btns': {
                                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                    e.preventDefault();
                                    window.location.href = '<?php echo base_url(); ?>account/shop';
                                    return false;
                                }
                            }
                        });
                    });
                </script>
                <?php }else{?>
                    <p class="text-center"><a href="<?php echo base_url(); ?>account">Click vào đây để tiếp tục</a></p>
                <?php }?>
            </div>
        <?php } ?>
            </form>
		</div>

</div>
    </div>
<!--END RIGHT-->
<script type="text/javascript">
$( "#province_account" ).change(function() {
    if($("#province_account").val()){
        $.ajax({
            url     : siteUrl  +'home/showcart/getDistrict',
            type    : "POST",
            data    : {user_province_put:$("#province_account").val()},
            cache   : true,
            success:function(response)
            {
                if(response){
                    var json = JSON.parse(response);
                    emptySelectBoxById('district_account',json);
                    delete json;
                } else {
                    document.getElementById("district_account").innerHTML = "<option value=''>Không tìm thấy quận/huyện</option>";
                }
            },
            error: function()
            {
                alert("Lỗi! Vui lòng thử lại");
            }
        });
    }
});

function emptySelectBoxById(eid, value) {
    if(value){
        var text = "";
        $.each(value, function(k, v) {
                //display the key and value pair
                if(k != ""){
                    text += "<option value='" + k + "'>" + v + "</option>";
                }
        });
        document.getElementById(eid).innerHTML = text;
        delete text;
    }
}
</script>
<?php $this->load->view('home/common/footer'); ?>