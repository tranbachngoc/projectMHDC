<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
	    <script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
            <SCRIPT TYPE="text/javascript">
                // <!--
                function submitenter(myfield, e) {
                    var keycode;
                    if (window.event) keycode = window.event.keyCode;
                    else if (e) keycode = e.which;
                    else return true;

                    if (keycode == 13) {
                        CheckInput_EditAccount();
                        return false;
                    }
                    else
                        return true;
                }
                //-->
                $('body').on('change', '[type="file"]', showPreviewImage_click);

                function showPreviewImage_click(e) {
                    var $input = $(this);
                    var inputFiles = this.files;
                    if (inputFiles == undefined || inputFiles.length == 0)
                        return;
                    var inputFile = inputFiles[0];

                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $input.next().attr("src", event.target.result);
                    };
                    reader.onerror = function (event) {
                        alert("I AM ERROR: " + event.target.error.code);
                    };
                    reader.readAsDataURL(inputFile);
                }
            </SCRIPT>
            <?php //// Chuyen cau truc link sang dang subdomain /////
            $protocol = "http://";//(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $domainName = $_SERVER['HTTP_HOST'];
            if($domain_user !=''){
                $linkdomain = $shop_user;
            }
            else{
                if($shop_user !=''){
                    $linkdomain = $shop_user;
                }
                else{
                    $linkdomain = $username_account;
                }
            }
            $shop_domain = $protocol . $domain_parent . '/' . $linkdomain.'/shop'; //shop co domain rieng
            $link_aff = $protocol . $linkdomain . '.' . $domainName;
            $link_shop = $protocol . $shop_link_parent . '.' . $domainName . '/' . $linkdomain.'/shop';
            // link group khac 3
            $link_group_khac_3 = $link_aff;
            ?>


	    
            <!--BEGIN: RIGHT-->
            <div class="col-md-9 col-sm-8 col-xs-12">
		<h4 class="page-header" style="margin-top:10px"><?php echo $this->lang->line('title_edit_account'); ?></h4>
		
                <?php if ($this->session->flashdata('flash_message_error')) { ?>
                    <div class="alert alert-danger"
                         role="alert"> <?php echo $this->session->flashdata('flash_message_error'); ?> </div>
                <?php } ?>
                

                <form name="frmEditAccount" id="frmEditAcc" method="post" enctype="multipart/form-data"
                      class="form-horizontal vientong">
                    <?php if ((int)$this->session->userdata('sessionGroup') <= 2) {
                        $req = '';
                    } else {
                        $req = '<b>*</b>';
                    }
                    ?>
                    <?php
                    if ($successEditAccount == false) {
                        $group_id = $this->session->userdata('sessionGroup');
                        if ($group_id == '2') {
                            $url2 = 'affiliate';
                        } elseif ($group_id == '3') {
                            $url2 = 'afstore';
                        } else {
                            $url2 = 'all';
                        }
                        ?>
                        <?php if($user_group == StaffStoreUser){ ?>
                        <div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4"><strong>Mở chi nhánh</strong> :</div>
                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-4">
                                <img src="<?php echo base_url() ?>/templates/home/images/public.png" border="0" title="Nhân viên mở chi nhánh" alt="Nhân viên mở chi nhánh">

                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="col-sm-3 control-label">
				<?php echo $this->lang->line('username_edit_account'); ?> :
                            </div>
                            <div class="col-sm-9" style="padding-top:7px;">
                                <strong class="text-primary"><?php if (isset($username_account)) { echo $username_account; } ?></strong>
                            </div>
                        </div>
                        <?php
                        $p_id = array(Developer1User, Developer2User, Partner1User, Partner2User, CoreMemberUser, CoreAdminUser);
                        //   Link gian hàng khi tài khoàn đăng nhập là aff hay tk gian hàng có cha cũng là gian hàng
                        if (!in_array($parent_group,$p_id) && ($user_group == AffiliateStoreUser && $parent_group == AffiliateStoreUser)|| $user_group == AffiliateUser || $user_group == BranchUser) { ?>
                            <div class="form-group">
                                <div class="col-sm-3 control-label"> Link gian hàng :</div>
                                <div class="col-sm-9">
                                    <?php
                                    //TH Gian hàng có domain
                                    if ($domain_parent != '') {
                                        // aff có domain
                                        if ($domain_user != '') { ?>
                                            <a target="_blank" style="color:#f00;" href="<?php echo $protocol.$domain_user.'/shop'; ?>"><?php echo $protocol.$domain_user.'/shop' ?></a> <br/>
                                           
                                            <?php
                                        } //   aff khong có domain
                                        else {
                                            ?>
                                            <a target="_blank"
                                               href="<?php echo $link_aff.'/shop'; ?>" style="color:#f00;"><?php echo $link_aff.'/shop'; ?></a> <br/>
                                            

                                            <?php
                                        }
                                    }
                                    //GH không có domain
                                    else {
                                        // aff có domain
                                        if ($domain_user != '') { ?>
                                            <a target="_blank" style="color:#f00;" href="<?php echo $protocol.$domain_user.'/shop'; ?>"><?php echo $protocol.$domain_user.'/shop' ?></a> <br/>
                                            <?php echo $link2; ?>
                                            <?php
                                        } //   aff khong có domain
                                        else {  ?>
                                            <a target="_blank" style="color:#f00;" href="<?php echo $link_aff.'/shop'; ?>"><?php echo $link_aff.'/shop'; ?></a> <br/>
                                            <?php echo $link2; ?>

                                        <?php }
                                    }
                                    ?>

                                </div>
                            </div>
                        <?php }
                        else {
                            //   Link gian hàng khi tài khoàn đăng nhập không là aff hay tk gian hàng có cha không là gian hàng
                            if ($user_group == AffiliateStoreUser) {
                                ?>
                                <div class="form-group">
                                    <div class="col-sm-3 control-label"> Link gian hàng :</div>
                                    <div class="col-md-6 col-sm-9" style="padding-top:7px;">
                                        <?php
                                        //TH Gian hàng có domain
                                        if ($domain_user != '' && $domain_user != ' ') { ?>
                                            <a target="_blank" href="<?php echo $protocol.$domain_user; ?>"><?php echo $protocol.$domain_user ?></a>
                                        <?php } //TH Gian hàng k có domain
                                        else { ?>
                                            <a target="_blank" href="<?php echo $link_aff.'/shop'; ?>"><?php echo $link_aff.'/shop'; ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php }
                            }
                        ?>
                    
                        <div class="form-group">
                             <div class="col-sm-3 control-label">
                                <font color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('avatar_edit_account'); ?>
                                :
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-8">                               
                                <?php if ($avatar) { ?>
                                    <div id="img_vavatar_input">                                    
                                        <input type="hidden" name="avatar_hidden" value="<?php echo $avatar; ?>"/>
                                        <div style="float:left;">
                                            <img style="margin-top:7px;" width="120" 
                                                 src="<?php if ($avatar != '') {
                                                    echo DOMAIN_CLOUDSERVER.'media/images/avatar/'.$avatar;
                                                } else { 
                                                    echo base_url() . "media/images/avatar/default.png";
                                                } ?>" />
                                        </div>
                                        <div style="float:left;">
                                            <img style="margin-top:7px;"
                                                 src="<?php echo base_url(); ?>templates/home/images/xoaimg.png" border="0"
                                                 title="Xóa hình này "
                                                onclick="delete_image('<?php echo base_url(); ?>home/account/','<?php echo $this->session->userdata('sessionUser'); ?>','use_id','avatar','tbtt_user','media/images/avatar/','<?php echo $avatar ?>');"/>
                                        </div>
                                    </div> 
                                <?php } else { ?>
                                    <div id="vavatar_input">                  
                                        <input name="avatar" id="avatar" class="inputimage_formpost" type="file">                 
                                        <img style="height:116px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview"/>
                                    </div>                                                                   
                                <?php }  ?>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 control-label">
				<font color="#FF0000"><?php echo $req; ?></font> 
				<?php echo $this->lang->line('email_edit_account'); ?> :
                            </div>
                            <div class="col-md-6 col-sm-9">
                                <input type="text" name="email_account" id="email_account"
                                       value="<?php echo ($this->input->post('email_account')) ? $this->input->post('email_account') : $email_account; ?>"
                                       maxlength="50"
                                       class="input_formpost form-control" <?php if ($email_account != '') {
                                    echo 'readonly';
                                } ?> />
                                <?php echo form_error('email_account'); ?>
                            </div>
                        </div>
                        <!--                <div class="form-group">
                    <div class="col-lg-3 col-md-3 col-sm-4"><font color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('reemail_edit_account'); ?>:</div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <input type="text" name="reemail_account" id="reemail_account" value="<?php if (isset($reemail_account)) {
                            echo $reemail_account;
                        } ?>" maxlength="50" class="input_formpost form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('reemail_account',1)" onblur="ChangeStyle('reemail_account',2)" />
                        <?php echo form_error('reemail_account'); ?>
                    </div>
                </div>-->
                        <div class="form-group">
                            <div class="col-sm-3 control-label">
				<font color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('fullname_edit_account'); ?> :
                            </div>
                            <div class="col-md-6 col-sm-9">
                                <input type="text" name="fullname_account" id="fullname_account"
                                       value="<?php if (isset($fullname_account)) {
                                           echo $fullname_account;
                                       } ?>" maxlength="80" class="input_formpost form-control"/>
                                <?php echo form_error('fullname_account'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 control-label"> 
				<font color="#FF0000"><?php echo $req; ?></font>
				<?php echo $this->lang->line('birthday_edit_account'); ?> :
                            </div>
                            <div class="col-sm-4">
                                <select name="day_account" id="day_account" class="selectdate_formpost ">
                                    <?php for ($day = 1; $day <= 31; $day++) { ?>
                                        <?php if (isset($day_account) && (int)$day_account == $day) { ?>
                                            <option value="<?php echo $day; ?>"
                                                    selected="selected"><?php echo $day; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                               -
                                <select name="month_account" id="month_account" class="selectdate_formpost ">
                                    <?php for ($month = 1; $month <= 12; $month++) { ?>
                                        <?php if (isset($month_account) && (int)$month_account == $month) { ?>
                                            <option value="<?php echo $month; ?>"
                                                    selected="selected"><?php echo $month; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                -
                                <select name="year_account" id="year_account" class="selectdate_formpost ">
                                    <?php for ($year = (int)date('Y') - 70; $year <= (int)date('Y') - 10; $year++) { ?>
                                        <?php if (isset($year_account) && (int)$year_account == $year) { ?>
                                            <option value="<?php echo $year; ?>"
                                                    selected="selected"><?php echo $year; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
			</div>
			<div class="form-group">
			    <div class="col-sm-3 control-label">
				<font color="#FF0000"><?php echo $req; ?></font>
				<?php echo $this->lang->line('sex_edit_account'); ?> :
			    </div>                           
			    <div class="col-sm-3">
				<select name="sex_account" id="sex_account" class="form-control selectsex_formpost">
				    <option value="1" <?php if (isset($sex_account) && (int)$sex_account == 1) {
					echo 'selected="selected"';
				    } ?>><?php echo $this->lang->line('male_edit_account'); ?></option>
				    <option value="0" <?php if (isset($sex_account) && (int)$sex_account == 0) {
					echo 'selected="selected"';
				    } ?>><?php echo $this->lang->line('female_edit_account'); ?></option>
				</select>
			    </div>
			</div>
                        

                        <div class="form-group">
			    <div class="col-sm-3 control-label">
				<font color="#FF0000"><?php echo $req; ?></font> Số CMND :
			    </div>                           
                            <div class="col-md-6 col-sm-9">
                                <input name="idcard_account"
                                       id="idcard_regis" <?php if ($idcard_account == '') { ?> onblur="checkUserIdcard(this.value, '<?php echo base_url(); ?>', '<?php echo $url2; ?>')" <?php } ?>
                                       type="text" class="form-control" <?php if ($idcard_account > 0) {
                                    echo 'readonly';
                                } ?> value="<?php if (isset($idcard_account) && $idcard_account != '') {
                                    echo $idcard_account;
                                } ?>"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-3 control-label">
				<font color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('province_edit_account'); ?>
                                :
                            </div>
                            <div class="col-md-6 col-sm-9">
                                <?php /*if($province_account != ''){?>
                            <script type="text/javascript">
                                $("select :selected").each(function(){
                                    $(this).parent().data("default", this);
                                });

                                $("select").change(function(e) {
                                    $($(this).data("default")).prop("selected", true);
                                });
                            </script>
                            <?php } */
                                ?>
                                <select name="province_account" id="province_account"
                                        class="selectprovince_formpost form-control">
                                    <option value="">Chọn Tỉnh/Thành</option>
                                    <?php foreach ($province as $provinceArray) { ?>
                                        <?php if (isset($province_account) && $province_account == $provinceArray->pre_id) { ?>
                                            <option value="<?php echo $provinceArray->pre_id; ?>"
                                                    selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                        <?php } else { ?>
                                            <option
                                                value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php echo form_error('province_account'); ?>
                            </div>
			</div>
			<div class="form-group">
                            <div class="col-sm-3 control-label">
				<font color="#FF0000"><?php echo $req; ?></font> 
				<?php echo $this->lang->line('district_edit_account'); ?> :
                            </div>
			    
                            <div class="col-md-6 col-sm-9">
                                <?php /* if($district_account != ''){?>
                            <script type="text/javascript">
                                $("select :selected").each(function(){
                                    $(this).parent().data("default", this);
                                });

                                $("select").change(function(e) {
                                    $($(this).data("default")).prop("selected", true);
                                });
                            </script>
                            <?php } */
                                ?>
                                <select name="district_account" id="district_account"
                                        class="selectprovince_formpost form-control">
                                    <option value="">Chọn Quận/Huyện</option>
                                    <?php
                                    foreach ($district as $vals):
                                        if ($vals->DistrictCode == $district_account) {
                                            $district_selected = "selected='selected'";
                                        } else {
                                            $district_selected = '';
                                        }
                                        echo '<option value="'. $vals->DistrictCode .'" '. $district_selected . '>' . $vals->DistrictName . '</option>';
                                    endforeach;
                                    ?>
                                </select>
                                <?php echo form_error('district_account'); ?>
                            </div>
                        </div>
			<div class="form-group">
                            <div class="col-sm-3 control-label">				
				<font color="#FF0000"><?php echo $req; ?></font>
				<?php echo $this->lang->line('address_edit_account'); ?> :
			    </div>                             
                            <div class="col-md-6 col-sm-9">
                                <input type="text" name="address_account" id="address_account"
                                       value="<?php if (isset($address_account)) {
                                           echo $address_account;
                                       } ?>" maxlength="80" class="input_formpost form-control"
                                       placeholder="Nhập số nhà, tên đường, phường/xã"/>
                                <?php echo form_error('address_account'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 control-label">
				<font color="#FF0000"><?php echo $req; ?></font>
                                Điện thoại di động :
                            </div>
                            <div class="col-md-6 col-sm-9">
                                <input type="text" <?php if ($mobile_account != '') {
                                    echo 'readonly';
                                } ?> name="mobile_account" id="mobile_account"
                                       value="<?php if (isset($mobile_account)) {
                                           echo $mobile_account;
                                       } ?>" maxlength="20" class="inputphone_formpost form-control"
                                       />
                                
                                
                                <?php echo form_error('phone_account'); ?>
                            </div>
                            <div class="col-sm-3">
				<img src="<?php echo base_url(); ?>templates/home/images/help_post.gif"
                                     onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',225,'#F0F8FF');"
                                     onmouseout="hideddrivetip();" class="img_helppost"/>
				<span class="div_helppost"><?php echo $this->lang->line('phone_help'); ?></span>
			    </div>
				
			 </div>
			<div class="form-group">
                            <div class="col-sm-3 control-label"> <?php echo $this->lang->line('phone_edit_account'); ?>
                                :
                            </div>
                            <div class="col-md-6 col-sm-9">
                                <input type="text" name="phone_account" id="phone_account"
                                       value="<?php if (isset($phone_account)) {
                                           echo $phone_account;
                                       } ?>" maxlength="20" class="inputphone_formpost form-control"
                                       
				       />

                                
                                
                                <?php echo form_error('mobile_account'); ?>
                            </div>
			    <div class="col-sm-3">
				<img src="<?php echo base_url(); ?>templates/home/images/help_post.gif"
                                     onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',225,'#F0F8FF');"
                                     onmouseout="hideddrivetip();" class="img_helppost"/>
				<span class="div_helppost"><?php echo $this->lang->line('phone_help'); ?></span>
			    </div>
                        </div>
                        <?php
                        //if ($group_id != Developer2User && $group_id != Developer1User && $group_id != Partner2User && $group_id != Partner1User && $group_id != CoreMemberUser && $group_id != CoreAdminUser){
                            ?>
                            <div class="form-group">
                                <div class="col-sm-3 control-label">Message facebook :</div>
                                <div class="col-md-6 col-sm-9">
                                    <input type="text" value="<?php echo $use_message; ?>" name="message_regis" id="messages_regis" 
                                           placeholder="https://www.facebook.com/messages/t/726068167537746"
                                           maxlength="255" class="form-control "/>
                                    <?php echo form_error('message_regis'); ?>
                                </div>
                            </div>
                        <?php //} ?>
                        <div class="form-group">
                            <div class="col-sm-3 control-label">Mã số thuế :</div>
                            <div class="col-md-6 col-sm-9" style="padding-top:7px">
				
                                <div><input type="checkbox" name="taxtype_regis"
                                              class="tax_type" <?php if (isset($tax_type) && $tax_type == 0) {
                                        echo 'checked="checked"';
                                    } ?>
                                              value="0"/>&nbsp;Mã số thuế cá nhân</div>
				
                                <div><input type="checkbox" name="taxtype_regis" class="tax_type"
                                        <?php if (isset($tax_type) && $tax_type == 1) {
                                            echo 'checked="checked"';
                                        } ?> value="1"/>&nbsp;Mã số thuế doanh nghiệp</div>

                                <input type="text" name="tax_code_account"
                                       id="taxcode_regis" <?php if ($tax_code != '') {
                                    echo 'readonly';
                                } ?> value="<?php if (isset($tax_code)) {
                                    echo $tax_code;
                                } ?>" maxlength="50" class="form-control" onfocus="ChangeStyle('fax',1)"
                                       <?php if ($tax_code == ''){ ?>onblur="checkUserTaxcode(this.value, '<?php echo base_url(); ?>','<?php echo $url2 ?>')" <?php } ?> />
                            </div>
                        </div>
			
                        
                        
                        <!--            <div class="form-group">-->
                        <!--                <div class="col-lg-3 col-md-3 col-sm-4">--><?php //echo $this->lang->line('fax_edit_account');
                        ?><!--:</div>-->
                        <!--                <div class="col-lg-9 col-md-9 col-sm-8">-->
                        <!--                    <input type="text" name="fax" id="fax" value="--><?php //if(isset($fax)){echo $fax;}
                        ?><!--" maxlength="50" class="input_formpost form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('fax',1)" onblur="ChangeStyle('fax',2)" />-->
                        <!--                    --><?php //echo form_error('fax');
                        ?>
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--                <div class="form-group">-->
                        <!--                    <div class="col-lg-3 col-md-3 col-sm-4">--><?php //echo $this->lang->line('company_edit_account');
                        ?><!--:</div>-->
                        <!--                    <div class="col-lg-9 col-md-9 col-sm-8">-->
                        <!--                        <input type="text" name="company_name" id="company_name" value="--><?php //if(isset($company_name)){echo $company_name;}
                        ?><!--" maxlength="50" class="input_formpost form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('company_name',1)" onblur="ChangeStyle('company_name',2)" />-->
                        <!--                        --><?php //echo form_error('company_name');
                        ?>
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--                <div class="form-group">-->
                        <!--                    <div class="col-lg-3 col-md-3 col-sm-4">--><?php //echo $this->lang->line('company_position_edit_account');
                        ?><!--:</div>-->
                        <!--                    <div class="col-lg-9 col-md-9 col-sm-8">-->
                        <!--                        <input type="text" name="company_position" id="company_position" value="--><?php //if(isset($company_position)){echo $company_position;}
                        ?><!--" maxlength="50" class="input_formpost form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('company_position',1)" onblur="ChangeStyle('company_position',2)" />-->
                        <!--                        --><?php //echo form_error('company_position');
                        ?>
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--                <div class="form-group">-->
                        <!--                    <div class="col-lg-3 col-md-3 col-sm-4">--><?php //echo $this->lang->line('company_adress_edit_account');
                        ?><!--:</div>-->
                        <!--                    <div class="col-lg-9 col-md-9 col-sm-8">-->
                        <!--                        <input type="text" name="company_address" id="company_address" value="--><?php //if(isset($company_address)){echo $company_address;}
                        ?><!--" maxlength="50" class="input_formpost form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('company_address',1)" onblur="ChangeStyle('company_address',2)" />-->
                        <!--                        --><?php //echo form_error('company_address');
                        ?>
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--                <div class="form-group">-->
                        <!--                    <div class="col-lg-3 col-md-3 col-sm-4">--><?php //echo $this->lang->line('website_edit_account');
                        ?><!--:</div>-->
                        <!--                    <div class="col-lg-9 col-md-9 col-sm-8">-->
                        <!--                        <input type="text" name="website" id="website" value="--><?php //if(isset($website)){echo $website;}
                        ?><!--" maxlength="50" class="input_formpost form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('website',1)" onblur="ChangeStyle('website',2)" />-->
                        <!--                        --><?php //echo form_error('website');
                        ?>
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--                <div class="form-group">-->
                        <!--                    <div class="col-lg-3 col-md-3 col-sm-4">--><?php //echo $this->lang->line('field_edit_account');
                        ?><!--:</div>-->
                        <!--                    <div class="col-lg-9 col-md-9 col-sm-8">-->
                        <!--                        <textarea name="business_field" id="business_field" cols="29" form-groups="5" class=" form-control" >--><?php //if(isset($business_field)){echo $business_field;}
                        ?><!--</textarea>-->
                        <!---->
                        <!--                        --><?php //echo form_error('business_field');
                        ?>
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--                <div class="form-group">-->
                        <!--                    <div class="col-lg-3 col-md-3 col-sm-4">--><?php //echo $this->lang->line('yahoo_edit_account');
                        ?><!--:</div>-->
                        <!--                    <div class="col-lg-9 col-md-9 col-sm-8">-->
                        <!--                        <input type="text" name="yahoo_account" id="yahoo_account" value="--><?php //if(isset($yahoo_account)){echo $yahoo_account;}
                        ?><!--" maxlength="50" class="input_formpost form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_account',1)" onblur="ChangeStyle('yahoo_account',2)" />-->
                        <!--                        --><?php //echo form_error('yahoo_account');
                        ?>
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--                <div class="form-group">-->
                        <!--                    <div class="col-lg-3 col-md-3 col-sm-4">--><?php //echo $this->lang->line('skype_edit_account');
                        ?><!--:</div>-->
                        <!--                    <div class="col-lg-9 col-md-9 col-sm-8">-->
                        <!--                        <input type="text" name="skype_account" id="skype_account" value="--><?php //if(isset($skype_account)){echo $skype_account;}
                        ?><!--" maxlength="50" class="input_formpost form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_account',1)" onblur="ChangeStyle('skype_account',2)" />-->
                        <!--                        --><?php //echo form_error('skype_account');
                        ?>
                        <!--                    </div>-->
                        <!--                </div>-->
                        <?php if (isset($imageCaptchaEditAccount)) { ?>
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-4"><font
                                        color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('captcha_main'); ?>
                                    :
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4">
                                    <img src="<?php echo $imageCaptchaEditAccount; ?>" width="151"
                                         height="30"/><br/>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-8">
                                    <input onkeypress="return submitenter(this,event)" type="text"
                                           name="captcha_account" id="captcha_account" value="" maxlength="10"
                                           class="inputcaptcha_form  form-control"
                                           />
                                    <?php echo form_error('captcha_account'); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-4"></div>
                            <div class="col-lg-9 col-md-9 col-sm-8">
                                <?php if ((int)$this->session->userdata('sessionGroup') == 2) { ?>
                                    <button class="btn btn-azibai" type="submit" name="submit_editaccount">Cập nhật
                                    </button>
                                <?php } else { ?>
                                    <input class="btn btn-azibai" type="button" onclick="CheckInput_EditAccount();"
                                           name="submit_editaccount"
                                           value="<?php echo $this->lang->line('button_update_edit_account'); ?>"/>
                                <?php } ?>
                                <input class="btn btn-default" type="button" name="reset_editaccount"
                                       value="<?php echo $this->lang->line('button_cancle_edit_account'); ?>"
                                       onclick="ActionLink('<?php echo base_url().$back_link; ?>')"/>
                            </div>
                        </div>
                        <input type="hidden" name="isPostAccount" value="1"/>

                    <?php } else { ?>
                        <div class="form-group ">

                            <p class="text-center">
                                <?php echo $this->lang->line('success_change_password'); ?>
                            </p>
                            <?php if (($this->session->userdata('sessionGroup') == 2 && count($shopid) == 0) || ($this->session->userdata('sessionGroup') == 3 && count($shopid) == 0)) { ?>
                                <script>
                                    jQuery(document).ready(function (jQuery) {
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
                            <?php }else{ ?>
                                <p class="text-center"><a href="<?php echo base_url(); ?>account/edit">Click vào đây để
                                        tiếp tục</a></p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </form>
            </div>

        </div>
    </div>
    <!--END RIGHT-->
    <script type="text/javascript">
        $("#province_account").change(function () {
            if ($("#province_account").val()) {
                $.ajax({
                    url: siteUrl + 'home/showcart/getDistrict',
                    type: "POST",
                    data: {user_province_put: $("#province_account").val()},
                    cache: true,
                    success: function (response) {
                        if (response) {
                            var json = JSON.parse(response);
                            emptySelectBoxById('district_account', json);
                            delete json;
                        } else {
                            document.getElementById("district_account").innerHTML = "<option value=''>Không tìm thấy quận/huyện</option>";
                        }
                    },
                    error: function () {
                        alert("Lỗi! Vui lòng thử lại");
                    }
                });
            }
        });

        function emptySelectBoxById(eid, value) {
            if (value) {
                var text = "";
                $.each(value, function (k, v) {
                    //display the key and value pair
                    if (k != "") {
                        text += "<option value='" + k + "'>" + v + "</option>";
                    }
                });
                document.getElementById(eid).innerHTML = text;
                delete text;
            }
        }
    </script>
<?php $this->load->view('home/common/footer'); ?>