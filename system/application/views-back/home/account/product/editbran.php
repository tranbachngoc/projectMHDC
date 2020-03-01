<?php $this->load->view('home/common/account/header'); ?>
<style>
    #frmEditPro { background: #fff;}
</style>
<script>
    function checkShowAffiliateValue() {
        if (jQuery('#affiliate_pro').is(':checked')) {
            jQuery('#wapper-affiliate').css('display', 'block');
        } else {
            jQuery('#pro_affiliate_value').val('');
            jQuery('#wapper-affiliate').css('display', 'none');
        }
    }

</script>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <link rel="stylesheet" href="/templates/home/css/jupload-crop-images/style.css" type="text/css" />
        <link rel="stylesheet" href="/templates/home/css/jupload-crop-images/jquery.Jcrop.min.css" type="text/css" />    
        <script language="javascript" src="<?php echo base_url(); ?>templates/home/js/him.js"></script>
        <script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
        <script language="javascript" src="<?php echo base_url(); ?>templates/home/js/jupload-crop-images/jquery.Jcrop.min.js"></script>
        <script language="javascript" src="<?php echo base_url(); ?>templates/home/js/jupload-crop-images/script.js"></script>

        <!--BEGIN: RIGHT-->
        <div class="col-lg-9 col-md-9 col-sm-8">
            <h4 class="page-header text-uppercase" style="margin-top:0px;">
                <?php
                $url  = $this->uri->segment(3);
                if ($url =='service'){
                    echo 'Cập nhật dịch vụ';
                }elseif($url == 'coupon'){
                    echo 'Cập nhật coupon';
                }else{
                    echo 'Cập nhật sản phẩm';
                }
                ?>
            </h4>
            <form name="frmEditPro" id="frmEditPro" method="post" enctype="multipart/form-data" class="form-horizontal">
            <?php if ($shopid > 0) { ?>
                <?php if ($successEditProductAccount == false) {?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span
                                    style="color: #FF0000"><b>*</b></span> <?php echo $this->lang->line('category_product_edit'); ?>:</label>
                            <div class="col-sm-9">
                                <div id="category_pro_0" style="margin-bottom: 15px">
                                    <select id="" name="category_pro_0" class="form-control form_control_cat_select" <?php echo $readonly ?> disabled>
                                        <?php if (isset($catlevel0) && count($catlevel0) > 0) {
                                           foreach ($catlevel0 as $item) { ?>
                                                <option value="<?php echo $item->cat_id; ?>" <?php echo ($cat_level_1[0]->parent_id == $item->cat_id) ? 'selected="selected"' : '';?>><?php echo $item->cat_name; ?></option>
                                          <?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                                <div id="category_pro_1" style="margin-bottom: 15px">
                                    <?php if (isset($cat_level_1)) {?>
                                        <select name="cat_pro_1" id="" class="form-control form_control_cat_select" <?php echo $readonly ?> disabled>
                                            <option value="0">--Chọn danh mục sản phẩm--</option>
                                            <?php foreach ($cat_level_1 as $item) {?>
                                                <?php if ($cat_level_2[0]->parent_id == $item->cat_id) { ?>
                                                    <option value="<?php echo $item->cat_id; ?>" selected="selected"><?php echo $item->cat_name.' >'; ?></option>
                                                <?php } else {
                                                    if (isset($category_pro) && $category_pro == $item->cat_id) { ?>
                                                    <option value="<?php echo $item->cat_id; ?>" selected="selected"><?php echo $item->cat_name; ?></option>
                                                    <?php } else { ?>
                                                    <?php }
                                                }
                                            } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                                <div id="category_pro_2" style="margin-bottom: 15px">
                                    <?php if (isset($cat_level_2)) { ?>
                                        <select name="cat_pro_2" id="" class="form-control form_control_cat_select" <?php echo $readonly ?> disabled>
                                            <option value="0">--Chọn danh mục sản phẩm--</option>
                                            <?php foreach ($cat_level_2 as $item) {?>
                                                <?php if ($cat_level_3[0]->parent_id == $item->cat_id) { ?>
                                                    <option value="<?php echo $item->cat_id; ?>" selected="selected"><?php echo $item->cat_name.' >'; ?></option>
                                                <?php } else {
                                                    if (isset($category_pro) && $category_pro == $item->cat_id) { ?>
                                                        <option value="<?php echo $item->cat_id; ?>" selected="selected"><?php echo $item->cat_name; ?></option>
                                                    <?php } else { ?>
                                                    <?php }
                                                }
                                            } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                                <div id="category_pro_3" style="margin-bottom: 15px">
                                    <?php if (isset($cat_level_3)) {?>
                                        <select name="cat_pro_3" id="" class="form-control form_control_cat_select" <?php echo $readonly ?> disabled>
                                            <option value="0">--Chọn danh mục sản phẩm--</option>
                                            <?php foreach ($cat_level_3 as $item) {?>
                                                <?php if ($cat_level_4[0]->parent_id == $item->cat_id) { ?>
                                                    <option value="<?php echo $item->cat_id; ?>" selected="selected"><?php echo $item->cat_name.' >'; ?></option>
                                                <?php } else {
                                                    if (isset($category_pro) && $category_pro == $item->cat_id) { ?>
                                                        <option value="<?php echo $item->cat_id; ?>" selected="selected"><?php echo $item->cat_name; ?></option>
                                                    <?php } else { ?>
                                                    <?php }
                                                }
                                            } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                                <div id="category_pro_4" style="margin-bottom: 15px">
                                    <?php if (isset($cat_level_4)) {  ?>
                                        <select name="cat_pro_4" id="cat_pro_4" class="form-control form_control_cat_select" <?php echo $readonly ?> disabled>
                                            <option value="0">--Chọn danh mục sản phẩm--</option>
                                            <?php
                                            foreach ($cat_level_4 as $item) {
                                                ?>
                                                <?php if (isset($category_pro) && $category_pro == $item->cat_id) { ?>
                                                    <option value="<?php echo $item->cat_id; ?>" selected="selected"><?php echo $item->cat_name; ?></option>
                                                <?php } else { ?>
                                                    <option
                                                        value="<?php echo $item->cat_id; ?>"><?php echo $item->cat_name; ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                                <input type="hidden" id="hd_category_id" name="hd_category_id"
                                       value="<?php echo $category_pro; ?>"/>
                                <?php echo form_error('category_pro'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <label for="name_pro" class="col-sm-3 control-label"><span
                                    style="color: #FF0000"><b>*</b></span> <?php echo $this->lang->line('name_product_edit'); ?>
                                :</label>
                            <div class="col-sm-9">
                                <input type="text" value="<?php if (isset($name_pro)) {
                                    echo $name_pro;
                                } ?>" name="name_pro" id="name_pro" maxlength="80" class="form-control" <?php echo $readonly ?>/>
                                <?php echo form_error('name_pro'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <label for="pro_sku" class="col-sm-3 control-label"><span
                                    style="color: #FF0000"><b>*</b></span> Mã sản phẩm:
                                :</label>
                            <div class="col-sm-9">
                                <input type="text" value="<?php if (isset($sku_pro)) {
                                    echo $sku_pro;
                                } ?>" name="pro_sku" id="pro_sku" maxlength="35" class="form-control" placeholder="Nhập tối đa 35 ký tự" <?php echo $readonly ?>/>
                                <?php echo form_error('pro_sku'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <label for="descr_pro"
                                   class="col-sm-3 control-label"><span
                                    style="color: #FF0000"><b>*</b></span><?php echo $this->lang->line('descr_product_edit'); ?>
                                :</label>
                            <div class="col-sm-9">
                                <input type="text" value="<?php if (isset($descr_pro)) {
                                    echo $descr_pro;
                                } ?>" name="descr_pro" id="descr_pro" maxlength="120" class="form-control" <?php echo $readonly ?>/>
                                <?php echo form_error('descr_pro'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    <!-- END: ĐĂNG HÌNH SẢN PHẨM-->    
                    <?php $imageDetail = explode(',', $pro_image); ?>
                    <div class="form-group">
                        <label for="image_1_pro" class="col-sm-3 control-label"><span style="color: #ff0000">* </span><?php echo $this->lang->line('image_1_product_edit'); ?>
                            :</label>
                        <div class="col-sm-9">
                            <div style=" display:<?php if ($imageDetail[0] != '') { echo "none"; } else { echo "block"; } ?>" id="vavatar_input1">
                                <span <?php echo $readonly ?> class="btn btn-primary btn-file upload_btn inputimage_formpost" name="image_1_pro" id="image_1_pro" disabled><i class="fa fa-upload" aria-hidden="true"></i> Chọn Ảnh</span>
                                <input type="text" placeholder="Chưa chọn ảnh" id="nameImage_1" disabled="disabled" style="border:none;background:none;padding: 5px;" />
                               <!--  <span class="btn btn-primary btn-file">
                                    <i class="fa fa-upload" aria-hidden="true"></i> Chọn File
                                    <input type="file" name="image_1_pro" id="image_1_pro" class="inputimage_formpost" />
                                </span> -->
                                <input class="btn btn-default" type="button" disabled value="Hủy"/>
                                <p><span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> (<?php echo $this->lang->line('image_help'); ?>)</span></p>
                                <div id="photo_container_1"></div>
                            </div>

                            <div style=" display:<?php if ($imageDetail[0] == '') { echo "none"; } else { echo "block"; } ?>" id="img_vavatar_input1">
                                <div style="float:left;">
                                    <?php if ($imageDetail[0] != "") { ?>
                                        <img src="<?php echo DOMAIN_CLOUDSERVER; ?>media/images/product/<?php echo $pro_dir; ?>/thumbnail_1_<?php echo $imageDetail[0] ?>" style="max-height:100px; max-width:100x; margin-top:5px; clear:both;"/>
                                    <?php } ?>
                                </div>
                            </div>
                            <input id="image1_edit" type="hidden" value="<?php echo $imageDetail[0] ?>" name="image1_edit">
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group">
                        <label for="image_2_pro" class="col-sm-3 control-label"><?php echo $this->lang->line('image_2_product_edit'); ?>:</label>
                        <div class="col-sm-9">
                            <div style=" display:<?php if ($imageDetail[1] != ''){ echo "none";
                            }else{ echo "block";} ?>" id="vavatar_input2">
                                <span <?php echo $readonly ?> class="btn btn-primary btn-file upload_btn inputimage_formpost" name="image_2_pro" id="image_2_pro" disabled><i class="fa fa-upload" aria-hidden="true"></i> Chọn Ảnh</span>
                                <input type="text" placeholder="Chưa chọn ảnh" id="nameImage_2" disabled="disabled" style="border:none;background:none;padding: 5px;" />
                                <!-- <span class="btn btn-primary btn-file">
                                    <i class="fa fa-upload" aria-hidden="true"></i> Chọn File
                                    <input type="file" name="image_2_pro" id="image_2_pro" class="inputimage_formpost" />
                                </span> -->
                                <input <?php echo $readonly ?> class="btn btn-default" type="button" disabled value="Hủy"/>
                                <p><span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> (<?php echo $this->lang->line('image_help'); ?>)</span></p>
                                <div id="photo_container_2"></div>
                            </div>
                            <div style=" display:<?php if ($imageDetail[1] == ''){ echo "none";} else { echo "block"; } ?>" id="img_vavatar_input2">
                                <div style="float:left;">
                                    <?php if ($imageDetail[1] != "") { ?>
                                        <img src="<?php echo DOMAIN_CLOUDSERVER; ?>media/images/product/<?php echo $pro_dir; ?>/thumbnail_2_<?php echo $imageDetail[1] ?>" style="max-height:100px; max-width:100px; margin-top:5px; clear:both;"/>
                                    <?php } ?>
                                </div>
                            </div>
                            <input id="image2_edit" type="hidden" value="<?php echo $imageDetail[1] ?>" name="image2_edit">
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group">
                        <label for="image_3_pro" class="col-sm-3 control-label"><?php echo $this->lang->line('image_3_product_edit'); ?> :</label>
                        <div class="col-sm-9">
                            <div style=" display:<?php if ($imageDetail[2] != '') { echo "none"; } else { echo "block"; } ?>" id="vavatar_input3">
                                <span <?php echo $readonly ?> class="btn btn-primary btn-file upload_btn inputimage_formpost" name="image_3_pro" id="image_3_pro" disabled><i class="fa fa-upload" aria-hidden="true"></i> Chọn Ảnh</span>
                                <input type="text" placeholder="Chưa chọn ảnh" id="nameImage_3" disabled="disabled" style="border:none;background:none;padding: 5px;" />
                               <!--  <span class="btn btn-primary btn-file">
                                    <i class="fa fa-upload" aria-hidden="true"></i> Chọn File
                                    <input type="file" name="image_3_pro" id="image_3_pro" class="inputimage_formpost"/>
                                </span> -->
                                <input class="btn btn-default" type="button" disabled value="Hủy"/>
                                <p><span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> (<?php echo $this->lang->line('image_help'); ?>)</span></p>
                                <div id="photo_container_3"></div>
                            </div>

                            <div style=" display:<?php if ($imageDetail[2] == '') {echo "none";} else { echo "block";} ?>" id="img_vavatar_input3">
                                <div style="float:left;">
                                    <?php if ($imageDetail[2] != "") { ?>
                                        <img src="<?php echo DOMAIN_CLOUDSERVER; ?>media/images/product/<?php echo $pro_dir; ?>/thumbnail_2_<?php echo $imageDetail[2] ?>" style="max-height:100px; max-width:100px; margin-top:5px; clear:both;"/>
                                    <?php } ?>
                                </div>
                            </div>
                            <input id="image3_edit" type="hidden" value="<?php echo $imageDetail[2] ?>"
                                   name="image3_edit">
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group">
                        <label for="image_4_pro"
                               class="col-sm-3 control-label"><?php echo $this->lang->line('image_4_product_edit'); ?>
                            :</label>
                        <div class="col-sm-9">
                            <div style=" display:<?php if ($imageDetail[3] != '') {echo "none";} else { echo "block"; } ?>; " id="vavatar_input4">
                                <span class="btn btn-primary btn-file upload_btn inputimage_formpost" name="image_4_pro" id="image_4_pro" disabled><i class="fa fa-upload" aria-hidden="true"></i> Chọn Ảnh</span>
                                <input type="text" placeholder="Chưa chọn ảnh" id="nameImage_4" disabled="disabled" style="border:none;background:none;padding: 5px;" />
                                <!-- <span class="btn btn-primary btn-file">
                                    <i class="fa fa-upload" aria-hidden="true"></i> Chọn File
                                    <input type="file" name="image_4_pro" id="image_4_pro" class="inputimage_formpost"/>
                                </span> -->
                                <input class="btn btn-default" type="button" disabled value="Hủy"/>
                                <p><span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> (<?php echo $this->lang->line('image_help'); ?>)</span></p>
                                <div id="photo_container_4"></div>
                            </div>
                            <div style=" display:<?php if ($imageDetail[3] == '') { echo "none";} else {
                                echo "block";} ?>" id="img_vavatar_input4">
                                <div style="float:left;">
                                    <?php if ($imageDetail[3] != "") { ?>
                                        <img src="<?php echo DOMAIN_CLOUDSERVER; ?>media/images/product/<?php echo $pro_dir; ?>/thumbnail_2_<?php echo $imageDetail[3] ?>" style="max-height:100px; max-width:100px; margin-top:5px; clear:both;"/>
                                    <?php } ?>
                                </div>
                            </div>
                            <input id="image4_edit" type="hidden" value="<?php echo $imageDetail[3] ?>" name="image4_edit">
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group">
                        <label for="image5_edit" class="col-sm-3 control-label"><?php echo $this->lang->line('image_5_product_edit'); ?>:</label>
                        <div class="col-sm-9">
                            <div style=" display:<?php if ($imageDetail[4] != '') { echo "none"; } else { echo "block"; } ?>; " id="vavatar_input5">
                                <span class="btn btn-primary btn-file upload_btn inputimage_formpost" name="image_5_pro" id="image_5_pro" disabled><i class="fa fa-upload" aria-hidden="true"></i> Chọn Ảnh</span>
                                <input type="text" placeholder="Chưa chọn ảnh" id="nameImage_5" disabled="disabled" style="border:none;background:none;padding: 5px;" />
                                <!-- <span class="btn btn-primary btn-file">
                                    <i class="fa fa-upload" aria-hidden="true"></i> Chọn File
                                    <input type="file" name="image_5_pro" id="image_5_pro" class="inputimage_formpost"/>
                                </span> -->
                                <input class="btn btn-default" type="button" disabled value="Hủy"/>
                                <p><span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> (<?php echo $this->lang->line('image_help'); ?>)</span></p>
                                <div id="photo_container_5"></div>
                            </div>
                            <div style=" display:<?php if ($imageDetail[4] == ''){echo "none";} else { echo "block"; } ?>" id="img_vavatar_input5">
                                <div style="float:left;">
                                    <?php if ($imageDetail[4] != "") { ?>
                                        <img src="<?php echo DOMAIN_CLOUDSERVER; ?>media/images/product/<?php echo $pro_dir; ?>/thumbnail_2_<?php echo $imageDetail[4] ?>" style="max-height:100px; max-width:100px; margin-top:5px; clear:both;"/>
                                    <?php } ?>
                                </div>
                            </div>
                            <input id="image5_edit" type="hidden" value="<?php echo $imageDetail[4] ?>" name="image5_edit">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- END: ĐĂNG HÌNH SẢN PHẨM-->                    

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label"><span style="color: #FF0000"><b>*</b></span> <?php echo $this->lang->line('detail_product_edit'); ?>:</label>
                        <div class="col-sm-9">
                            <?php $this->load->view('home/common/tinymce'); ?>
                            <textarea name="txtContent" id="txtContent" class="editor form-control">
                                <?php $vovel = array("&curren;");
                                echo html_entity_decode(str_replace($vovel, "#", $txtContent)); ?>
                            </textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <!--pro_saleoff_value-->
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span style="color: #FF0000"><b>*</b></span>  <?php echo $this->lang->line('cost_product_edit'); ?> :</label>
                        <div class="col-sm-9">
                            <input type="text" value="<?php if (isset($cost_pro)){ if ($cost_pro == 0) echo ""; else echo $cost_pro; } ?>" name="cost_pro" id="cost_pro" maxlength="11" class="inputcost_formpost" onkeypress="return isNumberKey(event);" onkeyup="FormatCurrency('DivShowCost','currency_pro',this.value);" />
                            <span class="div_helppost">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                            <select name="currency_pro" disabled id="currency_pro" class="selectcurrency_formpost">
                                <option value="VND" <?php if (isset($currency_pro) && $currency_pro == 'VND') { echo 'selected="selected"'; } elseif (!isset($currency_pro)) { echo 'selected="selected"'; } ?>><?php echo $this->lang->line('vnd_product_edit'); ?></option>
                                    <!-- <option value="USD" <?php if (isset($currency_pro) && $currency_pro == 'USD') { echo 'selected="selected"';} ?>><?php echo $this->lang->line('usd_product_edit'); ?></option>-->
                            </select>
                            <input type="text" name="pro_unit" id="pro_unit" class="inputcost_formpost" value="<?php echo (isset($pro_unit) && $pro_unit != '') ? $pro_unit : ''; ?>" placeholder="Nhập đơn vị bán sản phẩm" disabled />
                            
                            
                            <div id="DivShowCost"></div>
                            <?php echo form_error('cost_pro'); ?>
                            <div class="none_cost" style="display:none">
                                <input type="checkbox" name="nonecost_pro" id="nonecost_pro" value="1" <?php if (isset($nonecost_pro) && $nonecost_pro == '1') { echo 'checked="checked"'; } ?> onclick="ChangeStyleTextBox('cost_pro','DivShowCost',this.checked); ChangeCheckBox('nego_pro');"/>
                                    <?php echo $this->lang->line('none_cost_product_edit'); ?> <font color="#FF0000">(<?php echo $this->lang->line('call_product_edit'); ?>)</font>&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" name="nego_pro" id="nego_pro" value="1" <?php if (isset($nego_pro) && $nego_pro == '1') { echo 'checked="checked"';} ?> onclick="ChangeCheckBox('nonecost_pro')"/>
                                    <?php echo $this->lang->line('hondle_product_edit'); ?>
                            </div>
                            <br/>
                            <div class="pro_hot">
                                <input disabled type="checkbox" name="pro_hot" id="" value="1" 
                                    <?php if (isset($pro_hot) && $pro_hot == '1') {
                                        echo 'checked="checked"';
                                    }
                                    ?> />
                                Sản phẩm nổi bật
                            </div>
                            <br/>
                            <div class="saleoff_edit">
                                <input disabled type="checkbox" name="saleoff_pro" id="saleoff_pro" value="1" <?php if (isset($saleoff_pro) && $saleoff_pro == '1') { echo 'checked="checked"'; } ?> />
                                    <?php echo $this->lang->line('saleoff_product_edit'); ?>
                            </div>
                            <br/>
                            <div id="wapper-saleoff" style="<?php if($pro_saleoff_value == 0) echo 'display:none'; ?>">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <input readonly class="inputcost_formpost" id="pro_saleoff_value" value="<?php echo $pro_saleoff_value > 0 ? $pro_saleoff_value : ""; ?>" name="pro_saleoff_value" type="text" size="10"/>
                                        <select class="selectcurrency_formpost" id="pro_type_saleoff" name="pro_type_saleoff" disabled>
                                                <?php
                                                if ($pro_type_saleoff == 1)
                                                    $selectprecent = 'selected="selected"';
                                                if ($pro_type_saleoff == 2)
                                                    $selectvalue = 'selected="selected"';
                                                ?>
                                            <option value="1" <?php echo $selectprecent; ?>>%</option>
                                            <option value="2" <?php echo $selectvalue; ?>>VND</option>
                                        </select>
                                        <span style=" color: #004B7A; font-size: 11px; font-weight:normal;">(Nhập tiền giảm giá theo % hoặc tiền VND)</span>
                                    </div>
                                    <div class="form-group" style="margin-top:10px">
                                        <?php
                                        $now = strtotime(date('Y-m-d', $end_date_sale)); // or your date as well
                                        $your_date = strtotime(date('Y-m-d', $begin_date_sale));
                                        $datediff = $now - $your_date;
                                        $days =  floor($datediff/(60*60*24));
                                        ?>
                                        <div class="col-sm-4 col-xs-12">
                                        <label for="prom_begin_txt">Ngày áp dụng: </label>
                                            <input readonly class="form-control" name="prom_begin_txt" value="<?php echo $begin_date_sale ? date('d/m/Y', $begin_date_sale) :''; ?>" id="prom_begin_txt" />
                                            <input type="hidden" name="prom_begin" value="<?php echo $begin_date_sale ? date('Y/m/d', $begin_date_sale) :''; ?>" id="prom_begin" />
                                       
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <label for="promotion_expiry">Thời hạn áp dụng:</label>
                                            <span class="text-danger"><b>*</b></span>
                                            <select class="form-control" name="promotion_expiry" id="promotion_expiry" disabled>
                                            <option value="">--Số ngày--</option>
                                                <?php for ($i = 5; $i <= 45; $i++){ ?>
                                            <option <?php echo ($days == $i) ? 'selected = "selected"' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?> ngày</option>
                                                <?php } ?>
                                            </select>				
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php if ($end_date_sale > 0){ ?>
                                            <p class="text-danger">Ngày hết hạn: <?php echo date('d/m/Y', $end_date_sale); ?></p>
                                            <?php } ?>					
                                        </div>
                                    </div>
                                    <p class="small">(Nếu bạn không chọn ngày áp dụng khuyến mãi thì hệ
                                                    thống sẽ lấy mặc định ngày hiện tại)</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pro_instock" class="col-sm-3 control-label"><span style="color: #FF0000"><b>*</b></span> <?php echo $this->lang->line('pro_instock'); ?>
                            :</label>
                        <div class="col-sm-9">
                            <input type="text" maxlength="10" style="width:50px;" value="<?php echo $pro_instock; ?>" name="pro_instock" id="pro_instock" title="Số lượng trong kho" <?php echo $readonly ?>>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <?php if($shoptype >= 1): ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="pro_minsale"><span style="color: #FF0000"><b>*</b></span>Số lượng bán tối thiểu:</label>
                        <div class="col-sm-9">
                            <input type="text" onkeypress="return isNumberKey(event);" title="Số lượng bán sỉ tối thiểu" id="pro_minsale" name="pro_minsale" value="<?php if($pro_minsale >0) echo $pro_minsale; else echo '1';?>" style="width:50px;" maxlength="10" <?php echo $readonly ?>>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php endif; ?>

                    <?php if ($url == 'edit' || $url == 'editbran') { ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="pro_weight"><span style="color: #FF0000"><b>*</b></span>Trọng lượng:</label>
                        <div class="col-sm-9">
                            <input <?php echo $readonly ?> type="text" title="Trọng lượng sản phẩm" id="pro_weight" name="pro_weight" value="<?php echo $pro_weight; ?>" style="width:50px;" maxlength="10">gram
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group" id="pro_length_group">
                        <label class="col-sm-3 control-label" for="pro_length">Kích thước sản phẩm:</label>
                        <div class="col-sm-9">
                            <label class="col-sm-2 control-label" for="pro_length">Dài (cm):</label>
                            <div class="col-sm-2">
                                <input <?php echo $readonly ?> type="text" title="Chiều dài sản phẩm" id="pro_length" name="pro_length" value="<?php echo $pro_length;?>" class="form-control" maxlength="10">
                            </div>
                            <label class="col-sm-2 control-label" for="pro_length">Rộng(cm):</label>
                            <div class="col-sm-2">
                                <input <?php echo $readonly ?> type="text" title="Chiều rộng sản phẩm" id="pro_width" name="pro_width" value="<?php echo $pro_width;?>" class="form-control"  maxlength="10">
                            </div>
                            <label class="col-sm-2 control-label" for="pro_length">Cao (cm):</label>
                            <div class="col-sm-2">
                                <input <?php echo $readonly ?> type="text" title="Chiều cao sản phẩm" id="pro_height" name="pro_height" value="<?php echo $pro_height;?>" class="form-control" maxlength="10">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="pro_made_from" class="col-sm-3 control-label"><?php echo $this->lang->line('pro_made_from'); ?>
                            :</label>
                        <div class="col-sm-9">
                            <?php
                            if ($pro_made_from == 0)
                                $selecte_made_form0 = 'selected="selected"';
                            if ($pro_made_from == 1)
                                $selecte_made_form1 = 'selected="selected"';
                            if ($pro_made_from == 2)
                                $selecte_made_form2 = 'selected="selected"';
                            if ($pro_made_from == 3)
                                $selecte_made_form3 = 'selected="selected"';
                            ?>
                            <select size="1" style="width:35%"  name="pro_made_from" id="pro_made_from" class="form_control_select"
                                    title="Xuất xứ" disabled>
                                <option  <?php echo $selecte_made_form0; ?> value="0" title="- Chọn -">- Chọn -
                                </option>
                                <option <?php echo $selecte_made_form1; ?> value="1" title="Chính hãng">Chính hãng
                                </option>
                                <option  <?php echo $selecte_made_form2; ?> value="2" title="Xách tay">Xách tay
                                </option>
                                <option  <?php echo $selecte_made_form3; ?> value="3" title="Hàng công ty">Hàng công
                                    ty
                                </option>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php } ?>

                    <!-- BEGIN: TRƯỜNG QUI CÁCH -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="pro_weight"><span style="color: #FF0000"></span>Trường quy cách:<br><p><i>(Dành cho sản phẩm có nhiều màu sắc, nhiều size, hoặc nhiều chất liệu)</i></p></label>
                        <div class="col-sm-9">
                            <div id="numBoxqc" class="tab-pane fade in active">
                                <table  class="table table-responsive " >
                                    <thead>
                                        <tr>
                                            <th style="width: 130px;"><span style="color: #ff0000">* </span>Hình ảnh</th>
                                            <th>Màu sắc <input type="checkbox" onclick="CheckColor();" id="input_color" value="1" checked="checked" disabled></th>
                                            <th>Kích thước <input type="checkbox" onclick="CheckSize();" id="input_size" value="1" disabled></th>
                                            <th>Chất liệu <input type="checkbox" onclick="CheckMaterial();" id="input_material" value="1" disabled></th>
                                            <th><span style="color: #ff0000">* </span>Giá</th>
                                            <th><span style="color: #ff0000">* </span>Số lượng</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $row_qc = 0; if(!empty($de_product)) { ?> 
                                        <?php foreach ($de_product as $key => $value) { $row_qc++; ?>
                                            <tr class="inline" id="rowqc_<?php echo $value->id; ?>">
                                                <td><div style="display: <?php if($value->dp_images == ''){ echo 'none'; }else{ echo 'block'; } ?>;">
                                                    <div style="float: left;">
                                                    <img src="<?php echo DOMAIN_CLOUDSERVER; ?>media/images/product/<?php echo $pro_dir.'/thumbnail_1_'. $value->dp_images; ?>" style="min-width:60px; min-height:60px; max-height:80px; max-width:80px; clear:both;"/> 
                                                    <input type="hidden" name="<?php echo 'rowqc['.$row_qc.'][qcimage]'; ?>" id="<?php echo 'rqc_image_'.$row_qc; ?>" value="<?php echo $value->dp_images; ?>" />
                                                    <input type="hidden" name="<?php echo 'rowqc['.$row_qc.'][qcid]'; ?>" id="dp_id_<?php echo $row_qc; ?>" value="<?php echo $value->id; ?>" />
                                                    </div>
                                                    <div style="float: left;">
                                                   <!--  <span style="display:block" class="btn btn-primary btn-file upload_btn" id="sp_upload_<?php echo $rowqc;?>" onclick="show_popup_qc('upload_photo_qc',<?php echo $rowqc; ?>);"><i class="fa fa-upload"></i> Đổi ảnh<input name="<?php echo 'rowqc_'.$row_qc.'_qcimage'; ?>" type="file" id="<?php echo 'rqc_image_'.$row_qc; ?>" class="form-control" value="<?php echo $value->dp_images; ?>" /></span>  -->
                                                        <span style="display:block" class="btn btn-primary btn-file upload_btn" id="sp_upload_<?php echo $row_qc; ?>" onclick="show_popup_qc('popup_upload_qc',<?php echo $row_qc; ?>);"><i class="fa fa-upload"></i> Đổi ảnh<input type="hidden" name="<?php echo 'rowqc_'.$row_qc.'_qcimage'; ?>" id="<?php echo 'rqc_image_'.$row_qc; ?>" class="form-control" value="<?php echo $value->dp_images; ?>" /></span>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div></td>

                                                <td><input <?php echo $readonly ?> type="text" name="rowqc[<?php echo $row_qc; ?>][qccolor]" id="<?php echo 'rqc_color_'.$row_qc; ?>" class="form-control" value="<?php echo $value->dp_color; ?>" /></td>
                                                <td><input <?php echo $readonly ?> type="text" name="rowqc[<?php echo $row_qc; ?>][qcsize]" id="<?php echo 'rqc_size_'.$row_qc; ?>" class="form-control" value="<?php echo $value->dp_size; ?>" /></td>
                                                <td><input <?php echo $readonly ?> type="text" name="rowqc[<?php echo $row_qc; ?>][qcmaterial]" id="<?php echo 'rqc_material_'.$row_qc; ?>" class="form-control" value="<?php echo $value->dp_material; ?>" /></td>
                                                <td><input <?php echo $readonly ?> type="text" name="rowqc[<?php echo $row_qc; ?>][qccost]" id="<?php echo 'rqc_cost_'.$row_qc; ?>" class="form-control" value="<?php echo $value->dp_cost; ?>" /></td>
                                                <td><input <?php echo $readonly ?> type="text" name="rowqc[<?php echo $row_qc; ?>][qcinstock]" id="<?php echo 'rqc_instock_'.$row_qc; ?>" class="form-control" value="<?php echo $value->dp_instock; ?>" /></td>
                                                <td><span id="<?php echo 'del_'.$row_qc; ?>" class="btn btn-danger" style="display:<?php if($row_qc == count($de_product) && $display==''){ echo 'block'; }else{ echo 'none'; } ?>" onclick="removeRowqc(<?php echo $value->id; ?>, '#numBoxqc');" title="Xóa"><i  class="fa fa-remove "></i></span></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-default area-new" style="<?php echo $display?>"
                                        onClick="addRowQC('#numBoxqc',<?php echo $row_qc; ?>);">
                                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                                </button>
                            </div>
                            <script type="text/javascript">                                
                                var dem = <?php echo $row_qc; ?>;   
                                var rowqc = dem + 1;
                                function addRowQC(boxqc, no){
                                    var checked = Check_Input_QC();
                                    if(checked){                                        
                                        var htmlqc = '';
                                        var act = "'popup_upload_qc'";
                                        htmlqc += '<tr id="row_'+rowqc+'">';
                                        // htmlqc += '<td><span class="btn btn-primary btn-file"><i class="fa fa-upload"></i> Hình<input name="rowqc_' + rowqc + '_qcimage" type="file" id="rqc_image_'+rowqc+'" class="form-control" /></span></td>';
                                        htmlqc += '<td><span class="btn btn-primary btn-file upload_btn" id="sp_upload_'+rowqc+'" onclick="show_popup_qc('+act+','+rowqc+');"><i class="fa fa-upload"></i> Hình<input type="hidden" name="rowqc_' + rowqc + '_qcimage" id="rqc_image_'+rowqc+'" /></span><div id="container_show_'+rowqc+'"></div></td>';
                                        htmlqc += '<td><input name="rowqc[' + rowqc + '][qccolor]" type="text" id="rqc_color_'+rowqc+'" class="form-control" /></td>';
                                        htmlqc += '<td><input name="rowqc[' + rowqc + '][qcsize]" type="text" id="rqc_size_'+rowqc+'" class="form-control" /></td>';                                        
                                        htmlqc += '<td><input name="rowqc[' + rowqc + '][qcmaterial]" type="text" id="rqc_material_'+rowqc+'" class="form-control" /></td>';
                                        htmlqc += '<td><input name="rowqc[' + rowqc + '][qccost]" type="text" id="rqc_cost_'+rowqc+'" class="form-control" maxlength="11" /></td>';
                                        htmlqc += '<td><input name="rowqc[' + rowqc + '][qcinstock]" type="text" id="rqc_instock_'+rowqc+'" class="form-control" /></td>';
                                        htmlqc += '<td><span id="del_'+rowqc+'" class="btn btn-danger" onclick="Del_Row('+rowqc+')" title="Xóa"><i class="fa fa-remove "></i></span></td>';
                                        // htmlqc += '<td><span id="del_'+rowqc+'" class="btn btn-danger" onclick="$(this).closest(\'tr\').remove();" title="Xóa"><i class="fa fa-remove "></i></span></td>';
                                        // htmlqc += '<td></td>';
                                        htmlqc += '</tr>';
                                        var giam_row = rowqc - 1;
                                        $("#del_"+giam_row).css("display","none"); 
                                        $(boxqc).find('table tbody').append(htmlqc);
                                        if (jQuery('#input_color').is(':unchecked')) {
                                            jQuery('#rqc_color_'+rowqc).attr("disabled", 'disabled');
                                        }
                                        if (jQuery('#input_size').is(':unchecked')) {
                                            jQuery('#rqc_size_'+rowqc).attr("disabled", 'disabled');
                                        }                                        
                                        if (jQuery('#input_material').is(':unchecked')) {
                                            jQuery('#rqc_material_'+rowqc).attr("disabled", 'disabled');
                                        }  
                                        rowqc++;
                                    } else {
                                        var val = rowqc - 1;
                                            $.jAlert({
                                                'title': 'Thông báo',
                                                'content': 'Nhập các trường có dấu đỏ là bắt buộc & một trong 3 trường quy cách ở dòng trên!',
                                                'theme': 'default',
                                                'btns': {
                                                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                                        e.preventDefault();
                                                        document.getElementById("#rqc_image_"+val).focus();
                                                    }
                                                }
                                            });
                                        return false;
                                    }
                                }

                                function Check_Input_QC(){
                                    var check = true;                                    
                                    if(rowqc >= 2){
                                        var rqc = rowqc - 1;                
                                        var rqc_image = $('#rqc_image_'+rqc).val();
                                        var rqc_size = $('#rqc_size_'+rqc).val();
                                        var rqc_color = $('#rqc_color_'+rqc).val();
                                        var rqc_material = $('#rqc_material_'+rqc).val();
                                        var rqc_cost = $('#rqc_cost_'+rqc).val();
                                        var rqc_instock = $('#rqc_instock_'+rqc).val();
                                                                                  
                                        if((rqc_image != '' && rqc_cost != '' &&  rqc_instock != '') && (rqc_size != '' || rqc_color != '' || rqc_material != '')){
                                        }else{
                                            check = false; 
                                        }
                                    }
                                    return check;
                                }

                                function removeRowqc(idqc, boxqc ){
                                    jQuery.ajax({
                                        type: "POST",
                                        url: '<?php echo base_url()?>' + "home/account/delete_detail_product",
                                        data: {id  : idqc},
                                        success: function(res){
                                            console.log(res);
                                            if($(boxqc).length){
                                                $(boxqc).find('#rowqc_'+idqc).remove();
                                            }
                                        },
                                        error: function(){}
                                    });
                                    rowqc--;
                                }

                                function Del_Row(num_row){
                                    var giam_row = num_row - 1;
                                    var img_ = $("#rqc_image_"+num_row).val();
                                    var pro_dir = $("#pro_dir").val();
                                    jQuery.ajax({
                                        type: "POST",
                                        dataType: "text",
                                        url: '<?php echo base_url()?>' + "home/account/delete_detail_pro_row_qc",
                                        data: { img_name: img_, pro_dir: pro_dir, num: num_row},
                                        success: function(res1){
                                            console.log(res1);                             
                                        },
                                        error: function(){ alert("Có lỗi xảy ra!");}
                                    });
                                    $('#row_'+num_row).remove();          
                                    $("#del_"+giam_row).css("display","block");
                                    rowqc--;                                    
                                }
                            </script>

                        </div>
                        <div class="clearfix"></div>
                    </div> 
                    <!-- BEGIN: TRƯỜNG QUI CÁCH -->

                    <!--<div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo $this->lang->line('image_show_opt'); ?>
                                :</label>
                            <div class="col-sm-9">
                                <input type="radio" name="show_img" class="show_img"
                                       value="0" <?php if ((int)$pro_show == 0) {
                                    echo 'checked="checked"';
                                } ?>/>
                                Hiệu ứng phóng to &nbsp;&nbsp;
                                <input type="radio" name="show_img" class="show_img"
                                       value="1" <?php if ((int)$pro_show == 1) {
                                    echo 'checked="checked"';
                                } ?>/>
                                Hiệu ứng trình diễn
                                <input type="hidden" id="pro_show_img" name="pro_show_img"
                                       value="<?php /*echo $pro_show; */?>"/>
                            </div>
                            <div class="clearfix"></div>
                        </div>--> 

                    <!--end pro_saleoff_value-->
                    <!--Chiết khấu cho Thành viên-->
                    <?php if($this->session->userdata('sessionGroup') == AffiliateStoreUser || $this->session->userdata('sessionGroup') == BranchUser): ?>
                        <?php $limit_type = 1;
                        if(!empty($promotions)){
                            $limit_type = $promotions[0]['limit_type'];
                        } ?>
                            <?php if(isset($shoptype) && (int)$shoptype != 0) {?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo 'Giảm giá sỉ'; ?>
                                    :</label>
                                <div class="col-sm-9">
                                    <script type="text/javascript">
                                        var row = 1;
                                        function addRow(box){
                                            var html = '';
                                            html += '<tr>';
                                            html += '<td><input name="row['+row+'][limit_from]" type="text" class="form-control"  /></td>';
                                            html += '<td><input name="row['+row+'][limit_to]" type="text" class="form-control"  /></td>';
                                            html += '<td><input name="row['+row+'][amount]" type="text" class="form-control" /></td>';
                                            html += '<td > <select name="row['+row+'][type]" class="form-control" ><option value="1">Số tiền</option><option value="2">%</option></select></td>';
                                            html += '<td><span class="btn btn-danger" onclick="$(this).closest(\'tr\').remove();" title="Xóa"><i class="fa fa-remove "></i></span></td>';
                                            html += '</tr>';
                                            $(box).find('table tbody').append(html);
                                            row ++;
                                        }
                                        function removeRow(id, box){
                                            jQuery.ajax({
                                                type: "POST",
                                                url: '<?php echo base_url()?>' + "account/delete_promotion",
                                                data: {id  : id},
                                                success: function(data){
                                                    console.log(data);
                                                    if($(box).length){
                                                        $(box).find('#row_'+id).remove();
                                                    }
                                                },
                                                error: function(){}
                                            });
                                        }
                                        $(document).ready(function(){
                                            $(".nav-tabs a").click(function(){
                                                if($(this).hasClass('numBox')){
                                                    $('input[name="limit_type"]').val(1);
                                                }else{
                                                    $('input[name="limit_type"]').val(2);
                                                }
                                                $(this).tab('show');
                                            });
                                        });
                                    </script>
                                    <ul class="nav nav-tabs">
                                        <li <?php echo $limit_type == 1 ? 'class="active"' : '';?> ><a href="#numBox" class="numBox">Số lượng</a></li>
                                        <li <?php echo $limit_type == 2 ? 'class="active"' : '';?>><a href="#totalBox" class="totalBox">Số tiền</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <input type="hidden" id="limit_type" name="limit_type" value="<?php echo $limit_type;?>" />
                                        <div id="numBox" class="tab-pane fade <?php echo $limit_type == 1 ? 'in active' : '';?>">
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
                                                <?php if( $limit_type == 1 && !empty($promotions)):?>
                                                    <?php foreach($promotions as $pro):?>
                                                        <tr id="row_<?php echo $pro['id'];?>">
                                                            <td><?php echo $pro['limit_from'];?></td>
                                                            <td><?php echo $pro['limit_to'];?></td>
                                                            <td><?php echo $pro['dc_amount'];?></td>
                                                            <td><?php echo $pro['dc_type'];?></td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="totalBox" class="tab-pane fade <?php echo $limit_type == 2 ? 'in active' : '';?>">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Từ</th>
                                                    <th>Tới</th>
                                                    <th>Giảm giá</th>
                                                    <th>Loại</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if( $limit_type == 2 && !empty($promotions)):?>
                                                    <?php foreach($promotions as $pro):?>
                                                        <tr id="row_<?php echo $pro['id'];?>">
                                                            <td><?php echo $pro['limit_from'];?></td>
                                                            <td><?php echo $pro['limit_to'];?></td>
                                                            <td><?php echo $pro['dc_amount'];?></td>
                                                            <td><?php echo $pro['dc_type'];?></td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br/>
                                        (Nhập số lượng từ 5 đến 10 giảm 200.000 thì nhập là Từ: 5, Tới: 10, Giảm giá:200000, tương tự cho nhập Số tiền)
                                        <br/>
                                        (Nhập số lượng từ 10 trở về sau thì nhập là Từ: 10, Tới: 0, tương tự cho nhập Số tiền)
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    <?php endif;?>

                    <?php if(false): ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo 'Chiết khấu cho thành viên'; ?>
                                :</label>
                            <div class="col-sm-9">
                                <?php $dcType = array('1'=>'%', '2'=>'VND');?>
                                <input class="inputcost_formpost" id="dc_amount"
                                       value="<?php echo $dc_amount; ?>"
                                       name="dc_amount" type="text" size="10"/>
                                <select class="selectcurrency_formpost" id="dc_type"
                                        name="dc_type" autocomplete="off">
                                    <?php
                                    foreach($dcType as $k=>$val):
                                    ?>
                                    <option value="<?php echo $k;?>" <?php echo ($k == $dc_type) ? 'selected="selected"': ''; ?>><?php echo $val;?></option>
                                    <?php endforeach;?>
                                </select>
                                <span style=" color: #004B7A; font-size: 11px; font-weight:normal;">(Nhập tiền giảm giá theo % hoặc tiền VND)</span>
                                
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php endif; ?>
                        <!--Chiết khấu cho Thành viên-->
                        <div class="form-group" <?php echo ($shoptype == 0 || $shoptype == 2)? '' : 'style="display:none"'; ?> >
                            <label for="affiliate_pro" class="col-sm-3 control-label">Sản phẩm Cộng tác viên:</label>
                            <div class="col-sm-9">
<!--                                <input type="checkbox"  name="affiliate_pro" id="affiliate_pro" onclick="checkShowAffiliateValue();" value="1" />-->
                                <input type="checkbox" onclick="checkShowAffiliateValue();" name="affiliate_pro" id="affiliate_pro" value="1" <?php if (isset($affiliate_pro) && $affiliate_pro == '1') {
                                    echo 'checked="checked"';
                                } ?>> Là sản phẩm cộng tác viên
                                <div id="wapper-affiliate" <?php if (isset($affiliate_pro) && $affiliate_pro == '0') { ?> style="display:none;" <?php } else { ?>  style="display:block;" <?php } ?>>
                                    <input class="inputcost_formpost" id="pro_affiliate_value" value="<?php echo $pro_affiliate_value > 0 ? $pro_affiliate_value : ""; ?>" name="pro_affiliate_value" type="text" size="10" autocomplete="off" />
                                    <select class="selectcurrency_formpost" id="pro_type_affiliate" name="pro_type_affiliate">
                                        <?php
                                        if($pro_affiliate_value > 0){
                                            if ($pro_type_affiliate == 1){
                                                $selectprecentaf = 'selected="selected"';
                                            }
                                            if ($pro_type_affiliate == 2){
                                                $selectvalueaf = 'selected="selected"';
                                            }
                                        } else {
                                            $selectvalueaf = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="2" <?php echo $selectvalueaf; ?>>VND</option>
                                        <option value="1" <?php echo $selectprecentaf; ?>>%</option>
                                    </select>
                                    <span style=" color: #004B7A; font-size: 11px; font-weight:normal;">(Nhập tiền hoa hồng theo % hoặc tiền VND, đây là tiền người bán sản phẩm sẽ được hưởng dựa trên giá thực thu)</span>
                                    <br />
                                    <input class="inputcost_formpost" id="pro_dc_affiliate_value"
                                           value="<?php echo $dc_af_amount > 0 ? $dc_af_amount : ""; ?>"
                                           name="pro_dc_affiliate_value" type="text" size="10"/>
                                    <select class="selectcurrency_formpost" id="pro_type_dc_affiliate" autocomplete="off"
                                            name="pro_type_dc_affiliate">
                                        <?php
                                        $dcAmtType = '';
                                        $dcRateType = '';
                                        if($dc_af_amount == "" || $dc_af_amount <= 0){
                                            $dcAmtType = 'selected="selected"';
                                        } else {    
                                            if ($dc_af_type == 2){
                                                $dcAmtType = 'selected="selected"';
                                            }elseif($dc_af_type == 1){
                                                $dcRateType = 'selected="selected"';
                                            }
                                        }
                                        ?>
                                        <option value="2" <?php echo $dcAmtType; ?>>VND</option>
                                        <option value="1" <?php echo $dcRateType; ?>>%</option>
                                    </select>
                                    <span style=" color: #004B7A; font-size: 11px; font-weight:normal;">(Nhập tiền giảm theo % hoặc tiền VND, đây là tiền người mua được giảm dựa trên giá bán gốc)</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group" style="display: none">
                            <label for="province_pro" class="col-sm-3 control-label"><span
                                    style="color: #FF0000"><b>*</b></span> <?php echo $this->lang->line('province_product_edit'); ?>
                                :</label>
                            <div class="col-sm-9">
                                <select name="province_pro" id="province_pro" class="selectprovince_formpost">
                                    <?php foreach ($province as $provinceArray) { ?>
                                        <?php if (isset($province_pro) && $province_pro == $provinceArray->pre_id) { ?>
                                            <option value="<?php echo $provinceArray->pre_id; ?>"
                                                    selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                        <?php } else { ?>
                                            <option
                                                value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php echo form_error('province_pro'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group" style="display: none">
                            <label for="inputPassword3" class="col-sm-3 control-label"><span
                                    style="color: #FF0000"><b>*</b></span> <?php echo $this->lang->line('enddate_product_edit'); ?>
                                :</label>
                            <div class="col-sm-9">
                                <input type="text" name="DivEnddate" id="DivEnddate"
                                       value="<?php echo $day_pro; ?>-<?php echo $month_pro; ?>-<?php echo $year_pro; ?>"
                                       readonly="readonly" class="set_enddate"/>
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
                                <link type="text/css" href="<?php echo base_url(); ?>templates/home/css/datepicker.css"
                                      rel="stylesheet"/>
                                <script type="text/javascript"
                                        src="<?php echo base_url(); ?>templates/home/js/datepicker.js"></script>
                                <script type="text/javascript"
                                        src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>
                                <input type="hidden"
                                       value="<?php echo $day_pro; ?>-<?php echo $month_pro; ?>-<?php echo $year_pro; ?>"
                                       id="ngay_ket_thuc" name="ngay_ket_thuc"/>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    <?php if ($url == 'edit') { ?>
                        <div class="form-group">
                            <label for="mannufacurer_pro" class="col-sm-3 control-label">Nhà sản xuất:</label>
                            <div class="col-sm-3">
                                <div class="selectViewData">
                                    <select name="mannufacurer_pro" id="mannufacurer_pro"
                                          class="form_control_select">
                                        <option value="chon">--Chọn nhà sản xuất--</option>
                                        <?php foreach ($manufacturer_category as $categoryArray) { ?>
                                            <?php if ($categoryArray->man_id_category == $category_pro) { ?>
                                                <?php if (isset($mannufacurer_pro) && $mannufacurer_pro == $categoryArray->man_id) { ?>
                                                    <option value="<?php echo $categoryArray->man_id; ?>"
                                                            selected="selected"><?php echo $categoryArray->man_name; ?></option>
                                                <?php } else { ?>
                                                    <option
                                                        value="<?php echo $categoryArray->man_id; ?>"><?php echo $categoryArray->man_name; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <option value="khac">Khác</option>
                                    </select>
                                </div>
                            </div>
                            <div id="man_khac" style="display: none;">
                                <label class="control-label col-sm-1 text-right">Khác</label>
                                <div class="col-sm-5" id="manafacture_khac">
                                    <input id="manafac_khac" name="manafac_khac" class="form-control" type="text"  title=""/>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">

                            <span style='color: #ff0000'><b>*</b></span><?php echo $this->lang->line('pro_vat'); ?>:</label>
                            <div class="col-sm-3">
                                <?php
                                if ($pro_vat == 0)
                                    $pro_vat0 = 'selected="selected"';
                                if ($pro_vat == 1)
                                    $pro_vat1 = 'selected="selected"';
                                if ($pro_vat == 2)
                                    $pro_vat2 = 'selected="selected"';
                                ?>
                                <select size="1"  class="form_control_select" name="pro_vat" id="pro_vat" title="Thuế VAT" disabled>
                                    <option <?php echo $pro_vat0; ?> value="0" title="- Chọn -">- Chọn -</option>
                                    <option <?php echo $pro_vat1; ?> value="1" title="Đã có VAT">Đã có VAT</option>
                                    <option <?php echo $pro_vat2; ?> value="2" title="Chưa có VAT">Chưa có VAT
                                    </option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    <?php if ($url == 'edit' || $url == 'editbran') { ?>
                        <div class="form-group">
                            <label for="pro_quality" class="col-sm-3 control-label"><?php echo $this->lang->line('pro_quality'); ?>
                                :</label>
                            <div class="col-sm-3">
                                <?php
                                if ($pro_quality == 0)
                                    $selecte_quality0 = 'selected="selected"';
                                if ($pro_quality == 1)
                                    $selecte_quality1 = 'selected="selected"';
                                if ($pro_quality == -1)
                                    $selecte_qualitychon = 'selected="selected"';
                                ?>
                                <select size="1" name="pro_quality" id="pro_quality" class="form_control_select" title="Tình trạng" disabled>
                                    <option <?php echo $selecte_qualitychon; ?> value="-1" title="- Chọn -">- Chọn -
                                    </option>
                                    <option <?php echo $selecte_quality0; ?>  value="0" title="Mới">Mới</option>
                                    <option <?php echo $selecte_quality1; ?> value="1" title="Cũ">Cũ</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <label for="pro_warranty_period"
                                   class="col-sm-3 control-label"><?php echo $this->lang->line('pro_warranty_period'); ?>
                                :</label>
                            <div class="col-sm-9">
                                <input <?php echo $readonly ?> type="text" maxlength="10" style="width:50px;"
                                       value="<?php echo $pro_warranty_period; ?>" name="pro_warranty_period"
                                       id="pro_warranty_period" title="Thời gian bảo hành">
                                tháng
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>

                        <div class="form-group">
                            <label for="keyword_pro"
                                   class="col-sm-3 control-label">Từ khóa tìm kiếm
                                :</label>
                            <div class="col-sm-9">
                                <input <?php echo $readonly ?> type="text" value="<?php if (isset($keyword_pro)) {
                                    echo $keyword_pro;
                                } ?>" name="keyword_pro" id="keyword_pro" maxlength="120" class="form-control" placeholder="Từ khóa tìm kiếm cách nhau bởi dấu ,"
                                       />
                                <?php echo form_error('descr_pro'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>    

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Link Youtube
                                :</label>
                            <div class="col-sm-9">
                                <input <?php echo $readonly ?> type="text" name="pro_video" id="pro_video" maxlength="250" value="<?php if (isset($pro_video)) {
                                    echo $pro_video; }?>" class="form-control" placeholder="https://www.youtube.com/watch?v=zlsQF_ufUNU"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"> <font color="#FF0000"><b>*</b></font> Đồng ý phí mua bán :</label>
                            <div class="col-sm-9">
                                <p>Khi đăng sản phẩm này tức là bạn chấp nhận với phí mua bán của danh mục sản phẩm đã chọn ở trên là <strong><span id="fee_cate"><?php echo (isset($fee_cate) && $fee_cate >= 0) ? $fee_cate : 0; ?></span>(%)</strong>.</p>
                            </div>
                        </div>

                        <input type="hidden" name="pro_id" id="pro_id" value="<?php echo $pro_id; ?>" />
                        <input type="hidden" name="pro_dir" id="pro_dir" value="<?php echo $pro_dir; ?>" />
                        
                    <!--Thông tin người đăng-->
                        <div style="display: none">
                            <div class="form-group">
                                <label for="fullname_pro" class="col-sm-3 control-label"><span
                                        style="color: #FF0000"><b>*</b></span> <?php echo $this->lang->line('poster_product_edit'); ?>
                                    :</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php if (isset($fullname_pro)) {
                                        echo $fullname_pro;
                                    } ?>" name="fullname_pro" id="fullname_pro" maxlength="80" class="form-control"
                                           onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostPro','fullname_pro');"
                                           onfocus="ChangeStyle('fullname_pro',1)" onblur="ChangeStyle('fullname_pro',2)"
                                           onkeypress="return submitenter(this,event)"/>
                                    <?php echo form_error('fullname_pro'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label for="address_pro" class="col-sm-3 control-label"><span
                                        style="color: #FF0000"><b>*</b></span> <?php echo $this->lang->line('address_product_edit'); ?>
                                    :</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php if (isset($address_pro)) {
                                        echo $address_pro;
                                    } ?>" name="address_pro" id="address_pro" maxlength="80" class="form-control"
                                           onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostPro','address_pro');"
                                           onfocus="ChangeStyle('address_pro',1)" onblur="ChangeStyle('address_pro',2)"
                                           onkeypress="return submitenter(this,event)"/>
                                    <?php echo form_error('address_pro'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><span style="color: #FF0000"><b>*</b></span> <?php echo $this->lang->line('phone_product_edit'); ?>
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php if (isset($mobile_pro)) {
                                        echo $mobile_pro; } ?>" name="mobile_pro" id="mobile_pro" maxlength="20" class="form-control" onfocus="ChangeStyle('mobile_pro',1)" onblur="ChangeStyle('mobile_pro',2)" onkeypress="return submitenter(this,event)"/>
                                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif"
                                         onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');"
                                         onmouseout="hideddrivetip();" class="img_helppost"/> <span
                                        class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>
                                        )</span> <?php echo form_error('phone_pro'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><span
                                        style="color: #FF0000"><b>*</b></span> Điện thoại di động
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php if (isset($phone_pro)) {
                                        echo $phone_pro;
                                    } ?>" name="phone_pro" id="phone_pro" maxlength="20" class="form-control"
                                           onfocus="ChangeStyle('phone_pro',1)" onblur="ChangeStyle('phone_pro',2)"
                                           onkeypress="return submitenter(this,event)"/>
                                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif"
                                         onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');"
                                         onmouseout="hideddrivetip();" class="img_helppost"/> <span
                                        class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>
                                        )</span> <?php echo form_error('mobile_pro'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label for="email_pro" class="col-sm-3 control-label"><span style="color: #FF0000"><b>*</b></span> <?php echo $this->lang->line('email_product_edit'); ?>
                                    :</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php if (isset($email_pro)) {
                                        echo $email_pro;
                                    } ?>" name="email_pro" id="email_pro" maxlength="50" class="form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_pro',1)" onblur="ChangeStyle('email_pro',2)" onkeypress="return submitenter(this,event)"/>
                                    <?php echo form_error('email_pro'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label for="yahoo_pro"
                                       class="col-sm-3 control-label"><?php echo $this->lang->line('yahoo_product_edit'); ?>
                                    :</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php if (isset($yahoo_pro)) {
                                        echo $yahoo_pro;
                                    } ?>" name="yahoo_pro" id="yahoo_pro" maxlength="50" class="form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_pro',1)" onblur="ChangeStyle('yahoo_pro',2)" onkeypress="return submitenter(this,event)"/>
                                    <?php echo form_error('yahoo_pro'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label for="skype_pro"
                                       class="col-sm-3 control-label"><?php echo $this->lang->line('skype_product_edit'); ?>
                                    :</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php if (isset($skype_pro)) {
                                        echo $skype_pro;
                                    } ?>" name="skype_pro" id="skype_pro" maxlength="50" class="form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_pro',1)" onblur="ChangeStyle('skype_pro',2)" onkeypress="return submitenter(this,event)"/>
                                    <?php echo form_error('skype_pro'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    <!--End Thông tin người đăng-->

                        <?php if (isset($imageCaptchaEditProductAccount)) { ?>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label"><span style="color: #FF0000"><b>*</b></span> <?php echo $this->lang->line('captcha_main'); ?>
                                    :</label>
                                <div class="col-sm-3">
                                    <img src="<?php echo $imageCaptchaEditProductAccount; ?>" width="151" height="30"/><br/>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="captcha_pro" id="captcha_pro" value="" maxlength="10" class="form-control" onfocus="ChangeStyle('captcha_pro',1);" onblur="ChangeStyle('captcha_pro',2);" onkeypress="return submitenter(this,event)"/>
                                    <input type="hidden" id="captcha" name="captcha" value="<?php echo $captcha; ?>"/>
                                    <input type="hidden" id="isEditProduct" name="isEditProduct" value=""/>
                                    <?php echo form_error('captcha_pro'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <input type="button" onclick="CheckInput_EditProBranch();" name="submit_editpro" value="Cập nhật" class="btn btn-azibai btn-lg" onkeypress="return submitenter(this,event)"/>   
                            </div>
                            <div class="clearfix"></div>
                        </div>
                <?php }
                else { ?>
                   <div class="text-center">
                       <p>
                           <?php
                           $url = $this->uri->segment(3);
                           if ($url == 'service'){
                               $url1 = '/'.$url;
                               echo 'Bạn đã cập nhật dịch vụ thành công!';
                           }elseif ($url == 'coupon'){
                               $url1 = '/'.$url;
                               echo 'Bạn đã cập nhật coupon thành công!';
                           }else{
                               $url1 = '/product';
                               echo 'Bạn đã cập nhật sản phẩm thành công!';
                           }
                           ?>
                      </p>
                       <a href="<?php echo base_url().'account/product'.$url1; ?>">
                           Bấm vào đây để quay lại
                       </a>
                   </div>
                <?php } ?>
            <?php } else { ?>
                <div class="noshop text-center"><?php echo $this->lang->line('noshop'); ?>
                    <a href="<?php echo base_url(); ?>account/shop">tại đây</a></div>
            <?php } ?>
        </form>
        </div>
    </div>
</div>
<!--END RIGHT-->

<?php $this->load->view('home/common/footer'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/daterangepicker.css" />
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/moment.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/moment-with-locales.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/daterangepicker.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/vi.js"></script>
