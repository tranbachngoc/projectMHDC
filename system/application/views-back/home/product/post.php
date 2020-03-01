<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php
                $arra_cat = $this->session->userdata('catidArr');
                //$arra_cat = json_decode($arra_cat);
            ?>
            <link rel="stylesheet" href="/templates/home/css/jupload-crop-images/style.css" type="text/css" />
            <link rel="stylesheet" href="/templates/home/css/jupload-crop-images/jquery.Jcrop.min.css" type="text/css"/>         
            <script language="javascript" src="<?php echo base_url(); ?>templates/home/js/him.js"></script>
            <script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>            
            <script language="javascript" src="<?php echo base_url(); ?>templates/home/js/jupload-crop-images/jquery.Jcrop.min.js"></script>
            <script language="javascript" src="<?php echo base_url(); ?>templates/home/js/jupload-crop-images/script.js"></script>
            <script language="javascript">
                jQuery(document).ready(function () {
                    $('#cat_search').css('display', 'none');
                    jQuery('#shop_title').attr('class', 'left_menu_title');
                    jQuery('#shop_link').attr('class', 'left_menu_hidden');

                    $('#btn_serach').click(function () {
                        $('.cat_level').css('display','none');
                        $('#search_list').css('display', 'block');
                        $('.chosen-select').select2({
                            language: "vi",
                            maximumSelectionLength: 1,
                            width: '100%'
                        });
                        $(this).css('display', 'none');
                        $('#btn_serach_cancel').css('display', 'block');
                    });
                    
                    $('#btn_serach_cancel').click(function () {
                        $('.cat_level').css('display','block');
                        $('.chosen-select').select2('destroy');
                        $('#search_list').css('display', 'none');
                        $(this).css('display', 'none');
                        $('#btn_serach').css('display', 'block');
                    });

                    $('#cat_search').change(function () {
                        $('#hd_category_id').val(this.value);
                    });
                })                
            
                function checkShowSaleOffValue() {
                    if (jQuery('#saleoff_pro').is(':checked')) {
                        jQuery('#wapper-saleoff').css('display', 'block');
                    } else {
                        jQuery('#pro_saleoff_value').val('');
                        jQuery('#wapper-saleoff').css('display', 'none');
                    }
                }

                function checkShowAffiliateValue() {
                    if (jQuery('#affiliate_pro').is(':checked')) {
                        jQuery('#wapper-affiliate').css('display', 'block');
                    } else {
                        jQuery('#pro_affiliate_value').val('');
                        jQuery('#wapper-affiliate').css('display', 'none');
                    }
                }

                jQuery(document).ready(function () {
                    jQuery('#cat_pro_0').trigger('click');
                    jQuery('.show_img').click(function () {
                        var var_name = jQuery("input[@name='show_img']:checked").val();
                        jQuery('#pro_show_img').val(var_name);
                    });
                });                
            </script>  
            <SCRIPT TYPE="text/javascript">
                <!--
                function submitenter(myfield, e) {
                    var keycode;
                    if (window.event) keycode = window.event.keyCode;
                    else if (e) keycode = e.which;
                    else return true;
                    if (keycode == 13) {
                        CheckInput_PostPro();
                        return false;
                    }
                    else
                        return true;
                }
                //-->
            </SCRIPT>

            <?php			
            if ($_SERVER['HTTP_REFERER'] != base_url() ."account/product/product/post") {
                $_SESSION['trangtruoc'] = $_SERVER['HTTP_REFERER'];
            }
            ?>
            
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: LEFT-->
            <div class="col-md-9 col-sm-8 col-xs-12">
    		<h4 class="page-header text-uppercase" style="margin-top:0">
                <?php
                    $url  = $this->uri->segment(3);
                    if ($url =='service'){
                        echo 'Thêm mới dịch vụ';
                        $pro = 'dịch vụ';
                    }elseif($url == 'coupon'){
                        $pro = 'phiếu mua hàng điện tử';
                        echo 'Thêm mới phiếu mua hàng điện tử';
                    }else{
                        $pro = 'sản phẩm';
                        echo 'Thêm mới sản phẩm';
                    }
                ?>
            </h4>
                <form name="frmPostPro" method="post" enctype="multipart/form-data" class="form-horizontal">
		    <?php if ($shopid > 0) { ?>
			    <?php if (isset($disAllowPost) && $disAllowPost == true) { ?>
				<div class="form-group">
				    <div class="col-sm-12 col-xs-12">
    					<meta http-equiv=refresh content="5; url=<?php echo $_SESSION['trangtruoc']; ?>">
    					<?php echo $this->lang->line('dis_allow_post'); ?>
				    </div>
				</div>
			    <?php } else { ?>
                        
			    <?php if ($successPostProduct == false) { ?>
                        
			    <div class="form-group">
        			<div class="col-sm-3 col-xs-12 control-label">
        			    <font color="#FF0000"><b>*</b></font> <?php echo 'Danh mục '. $pro; ?>
        			</div>
			        <div class="col-sm-9 col-xs-12">			    
				    <div id="category_pro_0" style="margin-bottom: 15px">
				            <?php if (isset($arra_cat[0]) && $arra_cat[0] > 0) { ?>
                                    <select id="cat_pro_0" onchange="check_postCategoryProduct('<?php echo $pro ?>',this.value,0,'<?php echo base_url(); ?>');" name="cat_pro_0" class="form-control form_control_cat_select cat_level">
                                        <?php if (isset($catlevel_0)) {
                                                ?> <option value="0">--Chọn danh mục cho <?php echo $pro ?>--</option> <?php
                                            foreach ($catlevel_0 as $item) {
                                                ?>
                                                <option value="<?php echo $item->cat_id; ?>" data-value="<?php echo $item->b2c_fee; ?>" <?php echo (isset($arra_cat[0]) && $arra_cat[0] == $item->cat_id) ? 'selected="selected"' : ''; ?>><?php echo $item->cat_name; ?><?php if ($item->child_count > 0) {
                                                        echo ' >';
                                                    } ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                    <?php } else { ?>
                                        <select id="cat_pro_0" onchange="check_postCategoryProduct('<?php echo $pro ?>',this.value,0,'<?php echo base_url(); ?>');" name="cat_pro_0" class="form-control form_control_cat_select cat_level">
                                            <?php if (isset($catlevel0)) {
                                                ?> <option value="0">--Chọn danh mục cho <?php echo $pro ?>--</option> <?php
                                                foreach ($catlevel0 as $item) {
                                                    ?>
                                                    <option value="<?php echo $item->cat_id; ?>" data-value="<?php echo $item->b2c_fee; ?>" <?php echo (isset($arra_cat[0]) && $arra_cat[0] == $item->cat_id) ? 'selected="selected"' : ''; ?>><?php echo $item->cat_name; ?><?php if ($item->child_count > 0) {
                                                            echo ' >';
                                                        } ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    <?php } ?>
                                </div>

                                <div id="category_pro_1"  style="margin-bottom: 15px">
                                    <?php if (isset($catlevel_1) && count($catlevel_1) > 0) { ?>
                                        <select id="cat_pro_1" name="cat_pro_1" class="form-control form_control_cat_select cat_level" onchange="check_postCategoryProduct('<?php echo $pro ?>',this.value,1,'<?php echo base_url(); ?>');">
                                            <?php foreach ($catlevel_1 as $item) { ?>
                                                <option <?php echo ($item->cat_id == $arra_cat[1]) ? 'selected="selected"': ''; ?> value="<?php echo $item->cat_id; ?>" data-value="<?php echo $item->b2c_fee; ?>"><?php echo $item->cat_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>

                                <div id="category_pro_2"  style="margin-bottom: 15px">
                                    <?php if (isset($catlevel_2) && count($catlevel_2) > 0) { ?>
                                        <select id="cat_pro_2" name="cat_pro_2" class="form-control form_control_cat_select cat_level" onchange="check_postCategoryProduct('<?php echo $pro ?>',this.value,2,'<?php echo base_url(); ?>');">
                                            <?php foreach ($catlevel_2 as $item) { ?>
                                                <option <?php echo ($item->cat_id == $arra_cat[2]) ? 'selected="selected"': ''; ?> value="<?php echo $item->cat_id; ?>" data-value="<?php echo $item->b2c_fee; ?>"><?php echo $item->cat_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>

                                <div id="category_pro_3" style="margin-bottom: 15px">
                                    <?php if (isset($catlevel_3) && count($catlevel_3) > 0) { ?>
                                        <select id="cat_pro_3" name="cat_pro_3" class="form-control form_control_cat_select cat_level" onchange="check_postCategoryProduct('<?php echo $pro ?>',this.value,3,'<?php echo base_url(); ?>');">
                                            <?php foreach ($catlevel_3 as $item) { ?>
                                                <option <?php echo ($item->cat_id == $arra_cat[3]) ? 'selected="selected"': ''; ?> value="<?php echo $item->cat_id; ?>" data-value="<?php echo $item->b2c_fee; ?>"><?php echo $item->cat_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>

                                <div id="category_pro_4" style="margin-bottom: 15px">
                                    <?php if (isset($catlevel_4) && count($catlevel_4) > 0) { ?>
                                        <select id="cat_pro_4" name="cat_pro_4" class="form-control form_control_cat_select cat_level" onchange="check_postCategoryProduct('<?php echo $pro ?>',this.value,4,'<?php echo base_url(); ?>');">
                                            <?php foreach ($catlevel_4 as $item) { ?>
                                                <option <?php echo ($item->cat_id == $arra_cat[4]) ? 'selected="selected"': ''; ?> value="<?php echo $item->cat_id; ?>" data-value="<?php echo $item->b2c_fee; ?>"><?php echo $item->cat_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>

                                <?php if (isset($arra_cat[4]) && $arra_cat[4] > 0) { ?>
                                    <input type="hidden" id="hd_category_id" name="hd_category_id"
                                           value="<?php echo $arra_cat[4]; ?>"/>
                                <?php } elseif ($arra_cat[3] > 0 && $arra_cat[4] == 0) { ?>
                                    <input type="hidden" id="hd_category_id" name="hd_category_id"
                                           value="<?php echo $arra_cat[3]; ?>"/>
                                <?php } elseif ($arra_cat[2] > 0 && $arra_cat[3] == 0) { ?>
                                    <input type="hidden" id="hd_category_id" name="hd_category_id"
                                           value="<?php echo $arra_cat[2]; ?>"/>
                                <?php } elseif ($arra_cat[1] > 0 && $arra_cat[2] == 0) { ?>
                                    <input type="hidden" id="hd_category_id" name="hd_category_id"
                                           value="<?php echo $arra_cat[1]; ?>"/>
                                <?php } elseif ($arra_cat[0] > 0 && $arra_cat[1] == 0) { ?>
                                    <input type="hidden" id="hd_category_id" name="hd_category_id"
                                           value="<?php echo $arra_cat[0]; ?>"/>
                                <?php } else { ?>
                                    <input type="hidden" id="hd_category_id" name="hd_category_id" value=""/>
                                <?php } ?>

                                <?php echo form_error('category_pro'); ?>
				<p>
                                    <button id="btn_serach" type="button" class="btn btn-azibai"><i class="fa fa-search"></i> Tìm nhanh</button>
                                    <button id="btn_serach_cancel" style="display: none" type="button" class="btn btn-default"><i class="fa fa-search"></i> Hủy tìm nhanh</button>
                                </p>
                               <div id="search_list" style="display: none;">
                                   <?php
                                   $url  = $this->uri->segment(2);
                               if((filesize('system/application/views/home/common/catlist.php') > 0) || (filesize('system/application/views/home/common/catlistcoupon.php') > 0) || (filesize('system/application/views/home/common/catlistservice.php') > 0)) {
                                    if ($url !='' && $url == 'service'){
                                        $this->load->view('home/common/catlistservice');
                                    }elseif ($url !='' && $url == 'coupon'){
                                        $this->load->view('home/common/catlistcoupon');
                                    }else{
                                        $this->load->view('home/common/catlist');
                                    }
                               }else {
                                    $this->load->view('home/common/catlist1');
                                }?>
                               </div>
			</div>			
		    </div>
		    
		    <div class="form-group">
    			<div class="col-sm-3 col-xs-12 control-label">
    			    <font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('name_post'); ?> :
    			</div>
    			<div class="col-sm-9 col-xs-12">
    			    <input type="text" value="<?php
				if (isset($name_pro)) {
				    echo $name_pro;
				}
				?>" name="name_pro" id="name_pro" maxlength="80" class="form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('name_pro',1)" onblur="ChangeStyle('name_pro',2)"/>
				       <?php echo form_error('name_pro'); ?>
			</div>
		    </div>
		    
		   <div class="form-group">
			<div class="col-sm-3 col-xs-12 control-label">
			     <font color="#FF0000"><b>*</b></font> Mã sản phẩm:
			 </div>
			 <div class="col-sm-9 col-xs-12">
			     <input type="text" value="<?php if (isset($pro_sku)) { echo $pro_sku;
			     } ?>" name="pro_sku" id="pro_sku" maxlength="35" class="form-control" placeholder="Nhập tối đa 35 ký tự" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('pro_sku',1)" onblur="ChangeStyle('pro_sku',2)"/>
			     <?php echo form_error('pro_sku'); ?>
		        </div>
		    </div>

                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
                                <span style="color: #FF0000">*&nbsp;</span><?php echo $this->lang->line('descr_product_edit'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                   <input type="text" placeholder="Mô tả khái quát <?php echo $pro; ?> của bạn" value="<?php if (isset($descr_pro)) { echo $descr_pro; } ?>" name="descr_pro" id="descr_pro" maxlength="120" class="form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('descr_pro',1)" onblur="ChangeStyle('descr_pro',2)" onkeypress="return submitenter(this,event)"/>
                                <?php echo form_error('descr_pro'); ?>
                            </div>
                        </div>                      

                        
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
				<font color="#FF0000">*</font> <?php echo $this->lang->line('image_1_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <div class="content">
                                    <span class="btn btn-azibai btn-file upload_btn inputimage_formpost" name="image_1_pro" id="image_1_pro" onclick="show_popup('popup_upload', 1)"><i class="fa fa-upload" aria-hidden="true"></i> Chọn Ảnh</span>                                   
                                    <input type="text" placeholder="Chưa chọn ảnh" id="nameImage_1" disabled="disabled" style="border:none;background:none;padding: 5px;" />
                                    <input class="btn btn-default" type="button" onclick="resetBrowesIimgQ('image_1_pro', 1);" value="Hủy"/>
                                    <p><span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> (<?php echo $this->lang->line('image_help'); ?>)</span></p>
                                    <div id="photo_container_1"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
				<?php echo $this->lang->line('image_2_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <div class="content">
                                    <span class="btn btn-azibai btn-file upload_btn inputimage_formpost" name="image_2_pro" id="image_2_pro" onclick="show_popup('popup_upload', 2)"><i class="fa fa-upload" aria-hidden="true"></i> Chọn Ảnh</span>                                   
                                    <input type="text" placeholder="Chưa chọn ảnh" id="nameImage_2" disabled="disabled" style="border:none;background:none;padding: 5px;" />
                                    <input class="btn btn-default" type="button" onclick="resetBrowesIimgQ('image_2_pro', 2);" value="Hủy"/>
                                    <p><span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> (<?php echo $this->lang->line('image_help'); ?>)</span></p>
                                    <div id="photo_container_2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
				<?php echo $this->lang->line('image_3_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <div class="content">
                                    <span class="btn btn-azibai btn-file upload_btn inputimage_formpost" name="image_3_pro" id="image_3_pro" onclick="show_popup('popup_upload', 3)"><i class="fa fa-upload" aria-hidden="true"></i> Chọn Ảnh</span>                                   
                                    <input type="text" placeholder="Chưa chọn ảnh" id="nameImage_3" disabled="disabled" style="border:none;background:none;padding: 5px;" />
                                    <input class="btn btn-default" type="button" onclick="resetBrowesIimgQ('image_3_pro', 3);" value="Hủy"/>
                                    <p><span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> (<?php echo $this->lang->line('image_help'); ?>)</span></p>
                                    <div id="photo_container_3"></div>
                                </div>                                
                            </div>
                        </div>

                        <div class="form-group">
				<div class="col-sm-3 col-xs-12 control-label">				    
				<?php echo $this->lang->line('image_4_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <div class="content">
                                    <span class="btn btn-azibai btn-file upload_btn inputimage_formpost" name="image_4_pro" id="image_4_pro" onclick="show_popup('popup_upload', 4)"><i class="fa fa-upload" aria-hidden="true"></i> Chọn Ảnh</span>                                   
                                    <input type="text" placeholder="Chưa chọn ảnh" id="nameImage_4" disabled="disabled" style="border:none;background:none;padding: 5px;" />
                                    <input class="btn btn-default" type="button" onclick="resetBrowesIimgQ('image_4_pro', 4);" value="Hủy"/>
                                    <p><span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> (<?php echo $this->lang->line('image_help'); ?>)</span></p>
                                    <div id="photo_container_4"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
			    <?php echo $this->lang->line('image_5_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <div class="content">
                                    <span class="btn btn-azibai btn-file upload_btn inputimage_formpost" name="image_5_pro" id="image_5_pro" onclick="show_popup('popup_upload', 5)"><i class="fa fa-upload" aria-hidden="true"></i> Chọn Ảnh</span>                                   
                                    <input type="text" placeholder="Chưa chọn ảnh" id="nameImage_5" disabled="disabled" style="border:none;background:none;padding: 5px;" />
                                    <input class="btn btn-default" type="button" onclick="resetBrowesIimgQ('image_5_pro', 5);" value="Hủy"/>
                                    <p><span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> (<?php echo $this->lang->line('image_help'); ?>)</span></p>
                                    <div id="photo_container_5"></div>
                                </div>                            
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
                                <span style="color:#FF0000"><strong>* </strong></span>
                                <?php echo $this->lang->line('detail_post'); ?>:
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <?php $this->load->view('home/common/tinymce'); ?>
                                <textarea class="editor form-control" name="txtContent" id="txtContent"><?php if (isset($pro_detail)) { echo $pro_detail; } ?></textarea>
								<?php echo form_error('txtContent'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
				<span style="color: #ff0000">* </span><?php echo $this->lang->line('cost_post'); ?> :
                            </div>
                            <div class="col-sm-3 col-xs-12">
				 <input type="text" value="<?php if (isset($cost_pro)) { echo $cost_pro;
                                } ?>" name="cost_pro" id="cost_pro" maxlength="19" onkeypress="return isNumberKey(event);" class="form-control" onkeyup="FormatCurrency('DivShowCost','currency_pro',this.value);" onclick="ChangeStyleTextBox('cost_pro','DivShowCost',document.getElementById('nonecost_pro').checked);" onfocus="ChangeStyle('cost_pro',1)" onblur="ChangeStyle('cost_pro',2)" maxlength="11" />
                                
                            </div>
                            <div class="col-sm-2 col-xs-12">
                               <select name="currency_pro" id="currency_pro" class="form-control" onchange="FormatCurrency('DivShowCost','currency_pro',document.getElementById('cost_pro').value)">
                                    <option  value="VND" <?php if (isset($currency_pro) && $currency_pro == 'VND') { echo 'selected="selected"'; } elseif (!isset($currency_pro)) { echo 'selected="selected"'; } ?>><?php echo $this->lang->line('vnd_post'); ?></option>
                                    <!-- <option value="USD" <?php if (isset($currency_pro) && $currency_pro == 'USD') {
                                        echo 'selected="selected"';
                                    } ?>><?php echo $this->lang->line('usd_post'); ?></option>-->
                                </select>
			                </div>                            
                            <div class="col-sm-3 col-xs-12">                                
                                <input type="text" name="pro_unit" id="pro_unit" class="form-control" value="<?php echo (isset($pro_unit) && $pro_unit != '') ? $pro_unit : ''; ?>" placeholder="Nhập đơn vị bán sản phẩm"/>
                            </div>
			</div>
			<div class="form-group">    
			    <div class="col-sm-3 col-xs-12"></div>
			    <div class="col-sm-9 col-xs-12">
	    				<span class="div_helppost">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
	    				<div id="DivShowCost"></div>
					    <?php echo form_error('cost_pro'); ?>
	    				<div class="none_cost" style="display:none">
	    				    <input type="checkbox" name="nonecost_pro" id="nonecost_pro" value="1" <?php
						if (isset($nonecost_pro) && $nonecost_pro == '1') {
						    echo 'checked="checked"';
						}
						?> onclick="ChangeStyleTextBox('cost_pro','DivShowCost',this.checked); ChangeCheckBox('nego_pro');"/>
					    <?php echo $this->lang->line('none_cost_post'); ?> <font
	    					color="#FF0000">(<?php echo $this->lang->line('call_post'); ?>
	    				    )</font>&nbsp;&nbsp;&nbsp;
	    				    <input type="checkbox" name="nego_pro" id="nego_pro"
	    					   value="1" <?php
						       if (isset($nego_pro) && $nego_pro == '1') {
							   echo 'checked="checked"';
						       }
						       ?> onclick="ChangeCheckBox('nonecost_pro')"/>
						       <?php echo $this->lang->line('hondle_post'); ?>
	    			    </div>
                                    <div class="pro_hot">
                                        <input type="checkbox" name="pro_hot" id="" value="1" 
                                            <?php if (isset($pro_hot) && $pro_hot == '1') {
                                                echo 'checked="checked"';
                                            }
                                            ?> />
                                        Sản phẩm nổi bật
                                    </div>
	    			    <div class="saleoff1">
	    				<input type="checkbox" onclick="checkShowSaleOffValue();" name="saleoff_pro" id="saleoff_pro" value="1" <?php
					    if (isset($saleoff_pro) && $saleoff_pro == '1') {
						echo 'checked="checked"';
					    }
					    ?> />
						   <?php echo $this->lang->line('saleoff_post'); ?>
	    				<div id="wapper-saleoff" style="display:none;">
						<div class="form-inline">	    					
	    					    <input class="form-control" id="pro_saleoff_value" onkeypress="return isNumberKey(event);" accept="" name="pro_saleoff_value" type="text" size="10"/>
	    					    <select class="form-control" id="pro_type_saleoff" name="pro_type_saleoff">
	    						    <option value="1">%</option>
	    						    <option value="2">VND</option>
	    					    </select>
						    <span  style=" color: #004B7A; font-size: 11px; font-weight:normal;">(Nhập tiền giảm giá theo % hoặc tiền VND)</span>
	    					</div>
						<br>
						<div class="form-inline">
	    					    <label for="prom_begin_txt">Ngày áp dụng:
	    						<input readonly class="form-control" name="prom_begin_txt" id="prom_begin_txt" />
	    						<input type="hidden" name="prom_begin" id="prom_begin" />
	    					    </label>
							
	    					    <label for="promotion_expiry">Thời hạn áp dụng:</label> <select class="form-control" name="promotion_expiry" id="promotion_expiry">
	    						<option value="">--Số ngày--</option>
							    <?php for ($i = 5; $i <= 45; $i++) { ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?> ngày</option>
							    <?php } ?>
	    					    </select>
	    					    <span class="text-danger"><b>*</b></span>
	    					
						    <p><i class="text-warning"><b>Nếu bạn không chọn ngày áp dụng khuyến mãi thì hệ thống sẽ lấy mặc định ngày hiện tại</b></i></p>
						</div>
	    				</div>
	    			    </div>
	    			</div>
			</div>

                        <div class="form-group">                            
			    <div class="col-sm-3 col-xs-12 control-label">
				<span style="color: #FF0000; ">* </span> <?php echo $this->lang->line('pro_instock'); ?> :
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <input onkeypress="return isNumberKey(event);" type="text" maxlength="10" value="1" name="pro_instock" id="pro_instock" title="Số lượng trong kho" class="form-control">
                            </div>
                        </div>

                        <?php if ($shoptype >= 1) : ?>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-12 control-label">
				    Số lượng bán tối thiểu :
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <input onkeypress="return isNumberKey(event);" type="number" maxlength="10" value="1" name="pro_minsale" id="pro_minsale" title="Số lượng bán sỉ tối thiểu" class="form-control" min="1" max="<?php echo settingOtherShowcart ?>">
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($this->uri->segment(3) == 'product'){ ?>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
			    <span style="color: #ff0000">* </span> Trọng lượng :
                            </div>
                           <div class="col-sm-3 col-xs-12">
                                <input onkeypress="return isNumberKey(event);" type="text" maxlength="10" value="" name="pro_weight" id="pro_weight" title="Trọng lượng sản phẩm" class="form-control">
                            </div>
			     gram
                        </div>
			
                        <div class="form-group"> 
                            <div class="col-sm-3 col-xs-12 control-label"> Kích thước sản phẩm:</div>
                            <div class="col-sm-9 col-xs-12">
				<label>
				  Dài(cm): <input onkeypress="return isNumberKey(event);" type="text" maxlength="10" value="" name="pro_length" id="pro_length" class="form-control" title="Chiều dài sản phẩm">
				</label>
				<label>
				  Rộng(cm): <input onkeypress="return isNumberKey(event);" type="text" maxlength="10" value="" name="pro_width" id="pro_width" class="form-control" title="Chiều rộng sản phẩm">
				</label>
				<label>
				  Cao(cm):<input onkeypress="return isNumberKey(event);" type="text" maxlength="10" value="" name="pro_height" id="pro_height" class="form-control" title="Chiều cao sản phẩm">
				</label>                                
                            </div>
                        </div>                        
                        <?php } ?>                       

                        <?php if (false): ?>
                            <div class="form-group">
				<div class="col-sm-3 col-xs-12 control-label">
				    <font color="#FF0000"><b></b></font> Giảm giá sỉ:
                                </div>
                                <div class="col-sm-9 col-xs-12">
                                    <?php $dcType = array('1' => '%', '2' => 'VND'); ?>
                                    <input class="inputcost_formpost" id="dc_amount" value="<?php echo $dc_amount; ?>" name="dc_amount" type="text" size="10"/>
                                    <select class="selectcurrency_formpost" id="dc_type" name="dc_type"
                                            autocomplete="off">
                                        <?php foreach ($dcType as $k => $val): ?>
                                            <option value="<?php echo $k; ?>" <?php echo ($k == $dc_type) ? 'selected="selected"' : ''; ?>><?php echo $val; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span style=" color: #004B7A; font-size: 11px; font-weight:normal;">(Nhập tiền giảm giá theo % hoặc tiền VND)</span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($url == 'product') { ?>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-12 control-label">
				    <?php echo $this->lang->line('pro_made_from'); ?> :
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <select size="1" name="pro_made_from" id="pro_made_from" title="Xuất xứ" class="form-control">
                                        <option selected="selected" value="0" title="- Chọn -">- Chọn -
                                        </option>
                                        <option value="1" title="Chính hãng">Chính hãng</option>
                                        <option value="2" title="Xách tay">Xách tay</option>
                                        <option value="3" title="Hàng công ty">Hàng công ty</option>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>                       

                         <!-- BEGIN: POST TRƯỜNG QUY CÁCH -->
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
				Phân loại sản phẩm cùng mẫu hoặc đặc tính sản phẩm:<br>
				<p><i>(Dành cho sản phẩm có nhiều màu sắc, nhiều size, hoặc nhiều chất liệu)</i></p>
			    </div>
                            <div class="col-sm-9 col-xs-12">
                                <div id="numBoxqc" class="tab-pane fade in active">				    
				    <table class="table table-hover">
                                        <thead>
                                            <tr style="font-size: 14px;">
                                                <th><span style="color: #ff0000">* </span>Hình ảnh</th>
                                                <th>Màu sắc <input type="checkbox" onclick="CheckColor();" id="input_color" value="1" checked="checked"></th>
                                                <th>Kích thước <input type="checkbox" onclick="CheckSize();" id="input_size" value="1"></th>      
                                                <th>Chất liệu <input type="checkbox" onclick="CheckMaterial();" id="input_material" value="1"></th>
                                                <th><span style="color: #ff0000">* </span>Giá</th>
						<th><span style="color: #ff0000">* </span>Số lượng</th>
                                                <th>Xóa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-default area-new" onClick="addRowQC('#numBoxqc');">
                                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
				    </button>
                                    <input id="numrow_add" type="hidden" value=""/>                                    
                                </div>
                                <script type="text/javascript">
                                    var rowqc = 1;    
                                    
                                    function addRowQC(boxqc)
                                    {
                                        var stt = $("#numBoxqc table tbody tr").length;
                                        var checked = Check_Input_QC();
                                        if(checked){
                                            var htmlqc = '';
                                            var act = "'popup_upload_qc'";
                                            htmlqc += '<tr class="rowqcach' + rowqc + '">';
                                            //htmlqc += '<td><span class="btn btn-azibai btn-file"><i class="fa fa-upload"></i> Hình<input name="rowqc_' + rowqc + '_qcimage" type="file" id="rqc_image_'+rowqc+'" class="form-control" /></span></td>';
                                            htmlqc += '<td><span class="btn btn-azibai btn-file upload_btn" id="sp_upload_'+rowqc+'" onclick="show_popup_qc('+act+','+rowqc+');"><i class="fa fa-upload"></i> Hình<input type="hidden" name="rowqc_' + rowqc + '_qcimage" id="rqc_image_'+rowqc+'" /></span><div id="container_show_'+rowqc+'"></div></td>';
                                            htmlqc += '<td><input name="rowqc[' + rowqc + '][qccolor]" type="text" id="rqc_color_'+rowqc+'" class="form-control rqc_color" /></td>';
                                            htmlqc += '<td><input name="rowqc[' + rowqc + '][qcsize]" type="text" id="rqc_size_'+rowqc+'" class="form-control rqc_size" /></td>';
                                            htmlqc += '<td><input name="rowqc[' + rowqc + '][qcmaterial]" type="text" id="rqc_material_'+rowqc+'" class="form-control rqc_material" /></td>';
                                            htmlqc += '<td><input name="rowqc[' + rowqc + '][qccost]" type="text" id="rqc_cost_'+rowqc+'" class="form-control" onkeypress="return isNumberKey(event);" maxlength="11" /></td>';
                                            htmlqc += '<td><input name="rowqc[' + rowqc + '][qcinstock]" type="text" id="rqc_instock_'+rowqc+'" class="form-control" onkeypress="return isNumberKey(event);"/></td>';
                                            //htmlqc += '<td><span class="btn btn-danger" onclick="$(this).closest(\'tr\').remove();" title="Xóa"><i class="fa fa-remove "></i></span></td>';
                                            htmlqc += '<td><span class="btn btn-danger" id="del_row" title="Xóa" onclick="removeRow('+rowqc+');"><i class="fa fa-remove "></i></span></td>';
                                            
                                            htmlqc += '</td>'; 
                                            if(rowqc >= 2){
                                                var down_row = rowqc - 1;
                                                $('#btn_cancel_' + down_row).addClass('hidden');
                                            }                                            
                                            $(boxqc).find('table tbody').append(htmlqc);
                                            if (jQuery('#input_size').is(':unchecked')) {
                                                jQuery('#rqc_size_'+rowqc).attr("disabled", 'disabled');
                                            }
                                            if (jQuery('#input_color').is(':unchecked')) {
                                                jQuery('#rqc_color_'+rowqc).attr("disabled", 'disabled');
                                            }
                                            if (jQuery('#input_material').is(':unchecked')) {
                                                jQuery('#rqc_material_'+rowqc).attr("disabled", 'disabled');
                                            }  
                                            $('#numrow_add').val(rowqc);
                                            rowqc++;
                                        }else{
                                            var val = rowqc - 1;
                                            $.jAlert({
                                                'title': 'Thông báo',
                                                'content': 'Bạn phải upload hình và nhập đầy đủ dữ liệu vào những ô trắng trống của trường quy cách!',
                                                'theme': 'default',
                                                'btns': {
                                                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                                        e.preventDefault();
//                                                        document.getElementById("#rqc_image_"+val).focus();
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        
                                    }

                                    function Check_Input_QC(){
                                        var check = true;
                                        if(rowqc >= 2) {
                                            var rqc = rowqc - 1;
                                            var rqc_image = $('#rqc_image_' + rqc).val();
                                            var rqc_size = $('#rqc_size_' + rqc).val();
                                            var rqc_color = $('#rqc_color_' + rqc).val();
                                            var rqc_material = $('#rqc_material_' + rqc).val();
                                            var rqc_cost = $('#rqc_cost_' + rqc).val();
                                            var rqc_instock = $('#rqc_instock_' + rqc).val();
                                            if ((rqc_image != '' && rqc_cost != '' && rqc_instock != '') && (rqc_size != '' || rqc_color != '' || rqc_material != '')) {
                                                if (($('#input_color').is(':checked')) && rqc_color == '') {
                                                    check = false;
                                                }
                                                if (($('#input_size').is(':checked')) && rqc_size == '') {
                                                    check = false;
                                                }
                                                if (($('#input_material').is(':checked')) && rqc_material == '') {
                                                    check = false;
                                                }
                                            }
                                            else {
                                                check = false;
                                            }
                                        }
                                            return check;
                                    }
                                    
                                    function removeRow(number_row){
                                        var idqc = number_row;
                                        var img = $('#rqc_image_'+number_row).val();
                                        jQuery.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url(); ?>home/product/ajax_delete_image_qc",
                                            data: {num:idqc, name_pic:img},
                                            success: function (res) {
                                                $('tr.rowqcach'+number_row).remove();
                                                //console.log(res);
                                            },
                                            error: function () {
                                                alert('Xóa thất bại!');
                                            }
                                        });                                        
                                    }

                                </script>
                            </div>
                        </div>
                         <!-- END: POST TRƯỜNG QUY CÁCH -->

                        <?php if (($this->session->userdata('sessionGroup') == AffiliateStoreUser) || ($this->session->userdata('sessionGroup') == BranchUser)): ?>
                            <?php if (isset($shoptype) && (int)$shoptype != 0) { ?>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-12 control-label">
					<font color="#FF0000"><b></b></font> Chiết khấu cho thành viên:
                                    </div>
                                    <div class="col-sm-9 col-xs-12">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#numBox" class="numBox">Số lượng</a></li>
                                            <li><a href="#totalBox" class="totalBox">Số tiền</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <input type="hidden" id="limit_type" name="limit_type" value="1"/>
                                            <div id="numBox" class="tab-pane fade in active">
                                                <table class="table table-hover">
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
                                                <button type="button" class="btn btn-default area-new" onClick="addRow('#numBox');">
							<i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                                                </button>
                                            </div>
                                            <div id="totalBox" class="tab-pane fade">
                                                <table class="table table-hover">
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
                                                <button type="button" class="btn btn-default area-new" onClick="addRow('#totalBox');"><i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                                                </button>
                                            </div>
                                            <br/>
                                            (Nhập số lượng từ 5 đến 10 giảm 200.000 thì nhập là Từ: 5, Tới: 10, Giảm giá:200000, tương tự cho nhập Số tiền)
                                            <br/>
                                            (Nhập số lượng từ 10 trở về sau thì nhập là Từ: 10, Tới: 0, tương tự cho nhập Số tiền)
                                        </div>
                                        <script type="text/javascript">
                                            var row = 1;
                                            function addRow(box) {
                                                var html = '';
                                                html += '<tr>';
                                                html += '<td><input name="row[' + row + '][limit_from]" type="text" class="form-control"  /></td>';
                                                html += '<td><input name="row[' + row + '][limit_to]" type="text" class="form-control"  /></td>';
                                                html += '<td><input name="row[' + row + '][amount]" type="text" class="form-control" /></td>';
                                                html += '<td > <select name="row[' + row + '][type]" class="form-control" ><option value="1">Số tiền</option><option value="2">%</option></select></td>';
                                                html += '<td><span class="btn btn-danger" onclick="$(this).closest(\'tr\').remove();" title="Xóa"><i class="fa fa-remove "></i></span></td>';
                                                html += '</tr>';
                                                $(box).find('table tbody').append(html);
                                                row++;
                                            }
                                            $(document).ready(function () {
                                                $(".nav-tabs a").click(function () {
                                                    if ($(this).hasClass('numBox')) {
                                                        $('input[name="limit_type"]').val(1);
                                                    } else {
                                                        $('input[name="limit_type"]').val(2);
                                                    }
                                                    $(this).tab('show');
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php endif; ?>

                        <div class="form-group" <?php echo ($shoptype == 0 || $shoptype == 2 || ($shoptype == 3 && $ConfigPrice == true) || $this->session->userdata('sessionGroup') == BranchUser) ? '' : 'style="display:none"'; ?>>
                            <div class="col-sm-3 col-xs-12 control-label">Sản phẩm cộng tác viên :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <div class="affiliate">
                                    <input type="checkbox" onclick="checkShowAffiliateValue();" name="affiliate_pro" id="affiliate_pro" value="1" <?php if (isset($affiliate_pro) && $affiliate_pro == '1') {
                                        echo 'checked="checked"';
                                    } ?> />
                                    Cho cộng tác viên bán sản phẩm này
                                    <div id="wapper-affiliate" style="display:none;">
                                        <input class="inputcost_formpost" id="pro_affiliate_value" value="<?php echo $pro_affiliate_value > 0 ? $pro_affiliate_value : ""; ?>" name="pro_affiliate_value" type="text" size="10"/>
                                        <select class="selectcurrency_formpost" id="pro_type_affiliate" name="pro_type_affiliate">
                                            <?php
                                            if ($pro_type_affiliate == 1) $selectprecentaf = 'selected="selected"';
                                            if ($pro_type_affiliate == 2) $selectvalueaf = 'selected="selected"';
                                            ?>
                                            <option value="2" <?php echo $selectvalueaf; ?>>
                                                VND
                                            </option>
                                            <option value="1" <?php echo $selectprecentaf; ?>>
                                                %
                                            </option>

                                        </select>
                                        <span style=" color: #004B7A; font-size: 11px; font-weight:normal;">(Nhập tiền hoa hồng theo % hoặc tiền VND, đây là tiền người giới thiệu bán sản phẩm sẽ được hưởng dựa trên giá thực thu)</span>
                                        <br/>
                                        <input class="inputcost_formpost" id="pro_dc_affiliate_value" value="<?php echo $dc_af_amount > 0 ? $dc_af_amount : ""; ?>" name="pro_dc_affiliate_value" type="text" size="10"/>
                                        <select class="selectcurrency_formpost" id="pro_type_dc_affiliate" name="pro_type_dc_affiliate">
                                            <?php
                                            $dcAmtType = '';
                                            $dcRateType = '';
                                            if ($dc_af_type == 2) {
                                                $dcAmtType = 'selected="selected"';
                                            } elseif ($dc_af_type == 1) {
                                                $dcRateType = 'selected="selected"';
                                            }
                                            ?>
                                            <option value="2" <?php echo $dcAmtType; ?>>VND</option>
                                            <option value="1" <?php echo $dcRateType; ?>>%</option>

                                        </select>
                                         <span style=" color: #004B7A; font-size: 11px; font-weight:normal;">(Nhập tiền giảm theo % hoặc tiền VND, đây là tiền người mua được giảm  dựa trên giá thực thu)</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php if($url == 'product'){ ?>
                        <div class="form-group">
			    <div class="col-sm-3 col-xs-12 control-label">										    
				<font color="#FF0000"></font> <?php echo $this->lang->line('manufacture_post'); ?> :
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <select name="mannufacurer_pro" id="mannufacurer_pro" class="form-control">
                                    <option selected="selected" value="0" title="- Chọn -">- Chọn -</option>
                                    <?php foreach ($manufacturer_category as $categoryArray) { ?>
                                        <?php if ($categoryArray->man_id_category == $category_pro) { ?>
                                            <?php if (isset($mannufacurer_pro) && $mannufacurer_pro == $categoryArray->man_id) { ?>
                                                <option value="<?php echo $categoryArray->man_id; ?>" selected="selected"><?php echo $categoryArray->man_name; ?></option>
                                            <?php } else { ?>
                                                <option  value="<?php echo $categoryArray->man_id; ?>"><?php echo $categoryArray->man_name; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <option value="khac">Khác</option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <input id="manafac_khac" name="manafac_khac" type="text" placeholder="Nếu muốn nhập nhà sản xuất hãy chọn khác" class="form-control"/>
			    </div>
				
			    </div>
                        <?php } ?>


			<div class="form-group" style="display:none;">
			    <div class="col-sm-3 col-xs-12 control-label">
				<font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('province_post'); ?> :
                            </div>
                            <div class="col-xs-12">
                                <select name="province_pro" id="province_pro" class="selectprovince_formpost">
                                    <?php foreach ($province as $provinceArray) { ?>
                                        <?php if (isset($province_pro) && $province_pro == $provinceArray->pre_id) { ?>
                                            <option value="<?php echo $provinceArray->pre_id; ?>"
                                                selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                        <?php } else { ?>
                                            <option  value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php echo form_error('province_pro'); ?>
                            </div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <div class="col-sm-3 col-xs-12 control-label">
				<font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('enddate_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" name="DivEnddate" id="DivEnddate" value="<?php echo (int)date('d'); ?>-<?php echo $nextMonth; ?>-<?php echo $nextYear; ?>" readonly="readonly" class="set_enddate"/>
                                <script type="text/javascript">
                                    jQuery(function () {
                                        jQuery("#DivEnddate").datepicker({
                                            showOn: 'button',
                                            buttonImage: '<?php echo base_url(); ?>templates/home/images/calendar.gif',
                                            buttonImageOnly: true,
                                            buttonText: '<?php echo $this->lang->line('set_enddate_tip'); ?>',
                                            dateFormat: 'dd-mm-yy',
                                            minDate: new Date(),
                                            maxDate: '+6m',
                                            onClose: function () {
                                                jQuery("#ngay_ket_thuc").val(document.getElementById('DivEnddate').value);
                                            }
                                        });
                                    });
                                </script>
                                <link type="text/css" href="<?php echo base_url(); ?>templates/home/css/datepicker.css" rel="stylesheet"/>
                                <script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/datepicker.js"></script>
                                <script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>
                                <input type="hidden" value="<?php echo (int)date('d'); ?>-<?php echo $nextMonth; ?>-<?php echo $nextYear; ?>" id="ngay_ket_thuc" name="ngay_ket_thuc"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
				<span style="color: #ff0000"><b>*</b></span> <?php echo $this->lang->line('pro_vat'); ?>:
                            </div>
                            <div class="col-xs-3">
                                <select size="1" class="form-control" name="pro_vat" id="pro_vat" title="Thuế VAT">
                                    <option selected="selected" value="" title="- Chọn -">- Chọn -</option>
                                    <option value="1" title="Đã có VAT">Đã có VAT</option>
                                    <option value="2" title="Chưa có VAT">Chưa có VAT</option>
                                </select>
                            </div>
                        </div>

                        <?php if($url == 'product'){ ?>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
				<font color="#FF0000"></font> <?php echo $this->lang->line('pro_quality'); ?> :
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <select name="pro_quality" id="pro_quality" class="form-control" title="Chất lượng">
                                    <option selected="selected" value="-1" title="- Chọn -">-
                                        Chọn -
                                    </option>
                                    <option value="0" title="Mới">Mới</option>
                                    <option value="1" title="Cũ">Cũ</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">
                                <?php echo $this->lang->line('pro_warranty_period'); ?> :
                            </div>
                            <div class="col-xs-2">
                                <input onkeypress="return isNumberKey(event);" 
				       type="number" 
				       onblur="if(this.value=='') this.value='0'" 
				       onfocus="if(this.value=='0') this.value=''" 
					maxlength="10" class="form-control" 
					value="0" name="pro_warranty_period" 
					id="pro_warranty_period"  title="Thời gian bảo hành">
                            </div>
			    <div class="col-xs-2"> tháng </div>
                        </div>
                        <?php } ?>

                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">Từ khóa tìm kiếm:</div>
                            <div class="col-sm-9 col-xs-12"><input type="text" value="<?php if (isset($keyword_pro)) { echo $keyword_pro;} ?>" name="keyword_pro" id="keyword_pro" maxlength="120" class="form-control" onkeyup="BlockChar(this,'SpecialChar')" placeholder="(Từ khóa tìm kiếm cách nhau bởi dấu ,)" onfocus="ChangeStyle('descr_pro',1)" onblur="ChangeStyle('keyword_pro',2)" onkeypress="return submitenter(this,event)"/>
                                <?php echo form_error('descr_pro'); ?>
                                <p><i class="text-warning">Từ khóa giúp người mua có thể tìm kiếm sản phẩm. Vd: điện thoại, điện thoại thông minh,.</i></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label">Link Youtube :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" name="pro_video" id="pro_video" maxlength="250" value="<?php if (isset($pro_video)) { echo $pro_video; } ?>" class="form-control" placeholder="https://www.youtube.com/watch?v=zlsQF_ufUNU"/>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label"><?php /*echo $this->lang->line('image_show_opt'); */ ?>:
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <input type="radio" name="show_img" value="0"
                                checked="checked"/>Hiệu ứng phóng to &nbsp;&nbsp;
                                <input type="radio" name="show_img" value="1"/>Hiệu ứng trình
                                diễn
                                <input type="hidden" id="pro_show_img" name="pro_show_img"
                                value="0"/>
                            </div>
                        </div>-->

                        <div class="form-group" style="display: none">
			    <div class="col-sm-3 col-xs-12 control-label">
				<font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('poster_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" value="<?php if (isset($fullname_pro)) { echo $fullname_pro; } ?>" name="fullname_pro" id="fullname_pro" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostPro','fullname_pro');" onfocus="ChangeStyle('fullname_pro',1)" onblur="ChangeStyle('fullname_pro',2)"/>
                                <?php echo form_error('fullname_pro'); ?>
                            </div>
                        </div>

                        <div class="form-group" style="display: none">
			    <div class="col-sm-3 col-xs-12 control-label">
                            <font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" value="<?php if (isset($address_pro)) { echo $address_pro; } ?>" name="address_pro" id="address_pro" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostPro','address_pro');" onfocus="ChangeStyle('address_pro',1)" onblur="ChangeStyle('address_pro',2)"/>
                                <?php echo form_error('address_pro'); ?>
                            </div>
                        </div>

                        <div class="form-group" style="display: none">
                            <div class="col-sm-3 col-xs-12 control-label">
			    <font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" value="<?php if (isset($mobile_pro)) {  echo $mobile_pro; } ?>" name="mobile_pro" id="mobile_pro" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_pro',1)" onblur="ChangeStyle('mobile_pro',2)"/>
                                <?php echo form_error('mobile_pro'); ?>
                                <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost"/><span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                            </div>
                        </div>

                        <div class="form-group" style="display: none">
                            <div class="col-sm-3 col-xs-12 control-label"><font color="#FF0000"><b>*</b></font> Điện thoại di động:
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" value="<?php if (isset($phone_pro)) { echo $phone_pro; } ?>" name="phone_pro" id="phone_pro" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_pro',1)" onblur="ChangeStyle('phone_pro',2)"/>
                                <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost"/> <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?> )</span>
                                <?php echo form_error('mobile_pro'); ?>
                            </div>
                        </div>

                        <div class="form-group" style="display: none">
                            <div class="col-sm-3 col-xs-12 control-label"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" value="<?php if (isset($email_pro)) { echo $email_pro; } ?>" name="email_pro" id="email_pro" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_pro',1)" onblur="ChangeStyle('email_pro',2)"/>
                                <?php echo form_error('email_pro'); ?>
                            </div>
                        </div>

                        <div class="form-group" style="display: none">
                            <div class="col-sm-3 col-xs-12 control-label"><?php echo $this->lang->line('yahoo_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" value="<?php if (isset($yahoo_pro)) { echo $yahoo_pro; } ?>" name="yahoo_pro" id="yahoo_pro" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_pro',1)" onblur="ChangeStyle('yahoo_pro',2)"/>
                                <?php echo form_error('yahoo_pro'); ?>
                            </div>
                        </div>

                        <div class="form-group" style="display: none">
                            <div class="col-sm-3 col-xs-12 control-label"><?php echo $this->lang->line('skype_post'); ?> :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" value="<?php if (isset($skype_pro)) { echo $skype_pro; } ?>" name="skype_pro" id="skype_pro" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_pro',1)"  onblur="ChangeStyle('skype_pro',2)"/>
                                <?php echo form_error('skype_pro'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 col-xs-12 control-label"><font color="#FF0000"><b>*</b></font> Đồng ý phí mua bán :
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <p>Khi đăng sản phẩm này tức là bạn chấp nhận với phí mua bán của danh mục sản phẩm đã chọn ở trên là <strong><span id="fee_cate">0</span>(%)</strong>.</p>
                            </div>
                        </div>                        
            
		    <div class="form-group">
			<div class="col-sm-3 col-xs-12 control-label"></div>
			<div class="col-sm-9 col-xs-12">
			    <input type="button" id="post_pro" onclick="checkbox();" name="submit_postpro"  value="<?php echo $this->lang->line('button_agree_post'); ?>" class="btn btn-azibai" />
			    <input type="reset" name="reset_postpro" value="<?php echo $this->lang->line('button_reset_post'); ?>" class="btn btn-default" /> 
			</div>
		    </div>
            <?php } else { ?>
            <div class="form-group">
                <div class="col-sm-12 col-xs-12">
                    <?php $url = $this->uri->segment(2); ?>
                    <p>
                        <?php
                        if ($url == 'product'){
                            echo 'Bạn đã thêm sản phẩm thành công!';
                        } elseif ($url == 'service'){
                            echo 'Bạn đã thêm dịch vụ thành công!';
                        } elseif ($url == 'coupon'){
                            echo 'Bạn đã thêm phiếu mua hàng thành công!';
                        }
                        ?>
                    </p>

                    <p class="text-center"><a href="<?php echo base_url() .'account/product/'. $url .'/post'; ?>">Click vào đây để tiếp tục</a></p>
                </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php } else { ?>
            <div class="form-group">
                <div class="col-sm-12 col-xs-12">
                    <p>
			<?php echo $this->lang->line('noshop'); ?> 
                        <a href="<?php echo base_url(); ?>account/shop">tại đây</a>
		    </p>
                </div>
            </div>
            <?php } ?>
			
           
            </form>
            </div>
            </div><!-- / Row-->
        </div><!-- / Container-->

    <!-- The popup for upload new photo -->
    <div id="popup_upload">
        <div class="form_upload">
            <span class="close " id="btn-close-x" onclick="close_popup('popup_upload')">x</span>
            <h2>Đăng hình sản phẩm</h2>
            <form action="<?php echo base_url(); ?>product/upload_photo" method="post" enctype="multipart/form-data" target="upload_frame" onsubmit="submit_photo()">
                <input type="file" name="photo" id="photo" class="file_input" onchange="CheckSizeImage();" />
                <div id="loading_progress"></div>
                <input type="submit" value="Tải lên" id="upload_btn" />
                <input type="hidden" name="images_pos" id="images_pos" />
                <input type="hidden" name="images_old" id="images_old"/>
            </form>
            <iframe name="upload_frame" class="upload_frame"></iframe>
        </div>
    </div>

    <!-- The popup for crop the uploaded photo -->
    <div id="popup_crop">
        <div class="form_crop">
            <!-- <span class="close" onclick="close_popup('popup_crop')">x</span> -->
            <h2>Crop ảnh</h2>
            <!-- This is the image we're attaching the crop to -->
            <img id="cropbox" />
            <!-- This is the form that our event handler fills -->
            <form>
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <input type="hidden" id="photo_url" name="photo_url" />
                <input type="hidden" id="photo_pos" name="photo_pos" />
                <input type="hidden" name="product_dir" id="product_dir" value="" />
                <input type="button" value="Crop Ảnh" id="crop_btn" onclick="crop_photo()" />
            </form>
        </div>
    </div>

    <!-- The popup for upload new photo for product many style  -->
    <div id="popup_upload_qc">
        <div class="form_upload">
            <span class="close " id="btn-close-x" onclick="close_popup('popup_upload_qc')">x</span>
            <h2>Đăng hình sản phẩm qui cách</h2>
            <form action="<?php echo base_url(); ?>product/upload_photo_qc" method="post" enctype="multipart/form-data" target="upload_frame" onsubmit="submit_photo()">
                <input type="file" name="photo_qc" id="photo_qc" class="file_input" onchange="CheckSizeImage_qc();" />
                <div id="loading_progress"></div>
                <input type="submit" value="Tải lên" id="upload_btn" />                
                <input type="hidden" name="images_pos_qc" id="images_pos_qc" />
                <input type="hidden" name="dp_id" id="dp_id" />
                <input type="hidden" name="dp_images" id="dp_images"/>
            </form>
            <iframe name="upload_frame" class="upload_frame"></iframe>
        </div>
    </div>

    <!-- The popup for crop the uploaded photo -->
    <div id="popup_crop_qc">
        <div class="form_crop">
            <!-- <span class="close" onclick="close_popup('popup_crop')">x</span> -->
            <h2>Crop ảnh</h2>            
            <img id="cropbox_qc" />            
            <form>
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <input type="hidden" id="photo_url_qc" name="photo_url_qc" />
                <input type="hidden" id="photo_pos_qc" name="photo_pos_qc" />
                <input type="button" value="Crop Ảnh" id="crop_btn" onclick="crop_photo_qc()" />
            </form>
        </div>
    </div>

<!--END LEFT-->
<?php //$this->load->view('home/common/info'); ?>
<?php $this->load->view('home/common/footer'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/daterangepicker.css" />
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/moment.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/moment-with-locales.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/daterangepicker.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/vi.js"></script>
<script type="text/javascript">
    $(function() {
        var start = moment();
        $('input[name="prom_begin_txt"]').daterangepicker({
            autoUpdateInput: false,
            startDate: start,
            minDate: start,
            locale: {
                cancelLabel: 'Hủy',
                applyLabel: 'Xác nhận'
            },
            cancelClass:'btn-danger',
            singleDatePicker: true,
            showDropdowns: true
        });

        $('input[name="prom_begin_txt"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
            $('#prom_begin').val(picker.startDate.format('YYYY/MM/DD'));
        });

        $('input[name="prom_begin_txt"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('#prom_begin').val('');
        });        
    });

    function CheckSize(){
        if (jQuery('#input_size').is(':checked')) {
            $('#input_size').val('1');
            for(var i = 1; i < rowqc; i++){               
                $('#rqc_size_'+i).val('');
                $('#rqc_size_'+i).removeAttr('disabled');
            }
        } else {
            $('#input_size').val('0');
            if(jQuery('#input_color').is(':checked') || jQuery('#input_material').is(':checked')){
                for(var j = 1; j < rowqc; j++){
                    $('#rqc_size_'+j).val('');
                    $('#rqc_size_'+j).attr('disabled', 'disabled');                
                }
            } else {
                $('#input_size').prop('checked', true);
                NotForUnCheck();
                return false;
            }
        }        
    }

    function CheckColor(){
        if (jQuery('#input_color').is(':checked')) {               
            for(var i = 1; i < rowqc; i++){               
                $('#rqc_color_'+i).val('');
                $('#rqc_color_'+i).removeAttr('disabled');
            }
            $('#input_color').val('1');
            //  var numrow = $('#numBoxqc tbody tr').length;
        } else {
            $('#input_color').val('0');
            if(jQuery('#input_size').is(':checked') || jQuery('#input_material').is(':checked')){ 
                for(var j = 1; j < rowqc; j++){
                    $('#rqc_color_'+j).val('');
                    $('#rqc_color_'+j).attr('disabled', 'disabled');                
                }
            } else {
                $('#input_color').prop('checked', true);
                NotForUnCheck();
                return false;
            }
        }        
    }

    function CheckMaterial(){

        if (jQuery('#input_material').is(':checked')) {               
            for(var i = 1; i < rowqc; i++){               
                $('#rqc_material_'+i).val('');
                $('#rqc_material_'+i).removeAttr('disabled');
            }
            $('#input_material').val('1');
        } else {
            $('#input_material').val('0');
            if(jQuery('#input_size').is(':checked') || jQuery('#input_color').is(':checked')){
                for(var j = 1; j < rowqc; j++){
                    $('#rqc_material_'+j).val('');
                    $('#rqc_material_'+j).attr('disabled', 'disabled');                
                }
            } else {
                $('#input_material').prop('checked', true);
                NotForUnCheck();
                return false;
            }
        }
    }

    function NotForUnCheck(){
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn phải có 1 qui cách cho sản phẩm của bạn!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    }

    function checkbox() {
        var checked=true;
        var num = $('#numrow_add').val();
        var rqc_image = $('#rqc_image_' + num).val();
        var checkinputC = $('#input_color').val();
        var checkinputS = $('#input_size').val();
        var checkinputM = $('#input_material').val();
        var rqc_cost = $('#rqc_cost_' + num).val();
        var rqc_instock = $('#rqc_instock_' + num).val(); 
        
        if (checkinputC == 1) {
            $('.rqc_color').each(function () {
                if($(this).val() == ''){
                    checked=false;
                }
            });
        }
        if (checkinputS == 1) {
            $('.rqc_size').each(function () {
                if($(this).val() == ''){
                    checked=false;
                }
            });
        }
        if (checkinputM == 1) {
            $('.rqc_material').each(function () {
                if($(this).val() == ''){
                    checked=false;
                }
            });
        }
        if(rqc_image == '' || rqc_cost == '' || rqc_instock == ''){
            checked = false;
        }
        if(checked == false){
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Bạn phải upload hình và nhập đầy đủ dữ liệu vào những ô trắng trống của trường quy cách!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        $('#input_color').focus();
                    }
                }
            });
            return false;
        }else{
            CheckInput_PostPro();
        }
    }

    $(document).ready(function () {
        if ($('#input_color').is(':unchecked')) {
            $('#input_color').val('0');
        }
        if ($('#input_size').is(':unchecked')) {
            $('#input_size').val('0');
        }
        if ($('#input_material').is(':unchecked')) {
            $('#input_material').val('0');
        }
    });    
</script>