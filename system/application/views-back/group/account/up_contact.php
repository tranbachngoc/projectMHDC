<?php $this->load->view('group/common/header'); ?>
<br>
    <div id="main" class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <?php $this->load->view('group/common/menu'); ?>
            </div>
            <div class="col-md-9 main">
		<h4 class="page-header text-uppercase" style="margin-top:10px">Cập nhật thông tin liên hệ</h4>
                <div class="dashboard">
                    <!-- ========================== Begin Content ============================ -->
                    <div class="group-news">                        
                        <?php 
                       $filepath = 'http://azibai.org/media/group/banners/17012018/2e10521db763ff94a1d1ff9d617160e3.jpg';
                         
                       ?>
                        <form class="form-horizontal" name="frmUpdateGroupContact" id="frmUpdateGroupContact"  method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="grt_name" class="col-sm-1 control-label"> </label>
                                <div class="col-sm-10" style="font-weight: bold; text-align: center">
                                    Nhóm 
                                    <?php 
                                        if($grt_type <= 1) { 
                                            $type = 'Miễn phí';
                                        }elseif ($grt_type == 2) {
                                            $type = 'Có phí';
                                        }elseif ($grt_type == 3) {
                                            $type = 'Thuê kênh';
                                        }else{
                                            $type = 'Có phí và thuê kênh';
                                        }
                                    ?>
                                    <span style="text-transform: uppercase; padding-top: 7px; color: #0905af;"><?php echo $type ?></span>
                                </div>
                                
                            </div>

                            <div class="form-group">
                                <label for="grt_name" class="col-sm-3 control-label">Tên nhóm<font color="#FF0000"><b>*</b></font> :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="grt_name" id="grt_name" value="<?php if ($grt_name && $grt_name != '') { echo $grt_name; } ?>">
                                    <?php echo form_error('grt_name');?>
                                </div>
                            </div>
                            <?php 
                            ?>

                            <div class="form-group">
                                <label for="grt_link" class="col-sm-3 control-label">Link nhóm<font color="#FF0000"><b>*</b></font> :</label>
                                <div class="col-sm-9">
                                    <input type="text" width="100px" class="form-control" style="float: left; width: 200px" name="grt_link" id="grt_link" onblur="check_grtlink('<?php echo getAliasDomain() ?>',this.value,<?php echo $grt_id; ?>);" value="<?php if ($grt_link && $grt_link != '') { echo $grt_link; } ?>">
                                    <p style=" margin-top: 5px; overflow: hidden; float: left;"><?php echo '.'.$domainName.'/grtshop';?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Logo nhóm<font color="#FF0000"><b>*</b></font> :</label>
                                <div class="col-sm-9">                                   
                                    <div style="display:<?php if ($grt_logo != '') { echo "none"; } else { echo "block"; } ?>; padding-top:10px;" id="vavatar_input_1">
                                        <div class="col-lg-12">                                          
                                            <input type="file" name="grt_logo" id="grt_logo" class="inputimage_formpost" style="float: left"/>
                                            <input class="btn btn-danger" type="button" onclick="resetBrowesIimgQ_shop('grt_logo');" value="Hủy" />
                                        </div>
                                        <p style="padding-left:12px;">
                                            <span class="text-warning"><i class="fa fa-info-circle"></i> Dung lượng logo <= 500KB, Kích thước 120x120 px
                                            </span>
                                        </p>
                                        <input type="hidden" name="grt_logo" id="grt_logo_hiden" value="<?php echo $grt_logo; ?>"/>
                                    </div>

                                    <div style=" display:<?php if ($grt_logo == '') { echo "none"; } else { echo "block";} ?>" id="img_vavatar_input_1">
                                        <div style="float:left;">
                                            <img height="100"  src="<?php echo DOMAIN_CLOUDSERVER.'media/group/logos/'.$grt_dir_logo.'/'.$grt_logo; ?>" title="Logo group"/>
                                        </div>
                                        <div style="float:left; " class="xoa_hinh_nay">
                                            <img src="<?php echo base_url(); ?>templates/home/images/xoaimg.png" title="Xóa hình này" onclick="delete_images_ajax(1);"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Banner group<font color="#FF0000"><b>*</b></font> :</label>
                                <div class="col-sm-9">
                                    <div style="display:<?php if ($grt_banner != '') { echo "none"; } else { echo "block"; } ?>; padding-top:10px;" id="vavatar_input_2">
                                        <div class="col-lg-12">
                                        <!-- <span class="btn btn-primary btn-file"> Chọn File <i class="fa fa-upload" aria-hidden="true"></i> <input type="file" name="grt_banner" id="grt_banner" class="inputimage_formpost"/>
                                        </span> -->
                                            <input type="file" name="grt_banner" id="grt_banner" class="inputimage_formpost" style="float: left"/>
                                            <input class="btn btn-danger" type="button" onclick="resetBrowesIimgQ_shop('grt_banner');" value="Hủy"/>
                                        </div>
                                        <p style="padding-left:12px;">
                                        <span class="text-warning"><i class="fa fa-info-circle"></i>
                                            Dung lượng banner <= 1MB, kích thước 1000x600 px
                                        </span>
                                        </p>
                                        <input type="hidden" name="grt_banner" id="grt_banner_hiden" value="<?php echo $grt_banner; ?>"/>
                                    </div>

                                    <div style=" display:<?php if ($grt_banner == '') { echo "none"; } else { echo "block";} ?>; padding-top:10px;" id="img_vavatar_input_2">
                                        <div style="float:left;">
                                            <?php if (isset($grt_banner)) { ?>
                                                <img src="<?php echo DOMAIN_CLOUDSERVER.'media/group/banners/'.$grt_dir_banner.'/'.$grt_banner; ?>" border="0" height="100"/>
                                            <?php } ?>
                                        </div>
                                        <div style="float:left; " class="xoa_hinh_nay">
                                            <img src="<?php echo base_url(); ?>templates/home/images/xoaimg.png" border="0" title="Xóa hình này " onclick="delete_images_ajax(2);"/>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="grt_desc" class="col-sm-3 control-label">Mô tả nhóm :</label>
                                <div class="col-sm-9">
                                    <textarea type="textarea" class="form-control" name="grt_desc" id="grt_desc" value=""><?php if ($grt_desc != '') { echo $grt_desc;
                                        } ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="grt_email" class="col-sm-3 control-label">Email nhóm<font
                                        color="#FF0000"><b>*</b></font> :</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="grt_email" id="grt_email" value="<?php if ($grt_email && $grt_email != '') { echo $grt_email;  } ?>" placeholder="yourgroupemail@gmail.com">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="grt_mobile" class="col-sm-3 control-label">Số di động<font color="#FF0000"><b>*</b></font> :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="grt_mobile" id="grt_mobile" value="<?php if ($grt_mobile && $grt_mobile != '') { echo $grt_mobile; } ?>" placeholder="0912345678">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="grt_phone" class="col-sm-3 control-label">Số điện thoại:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="grt_phone" id="grt_phone" value="<?php if ($grt_phone && $grt_phone != '') { echo $grt_phone; } ?>" placeholder="0855555555">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="grt_facebook" class="col-sm-3 control-label">Liên kết facebook:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="grt_facebook" id="grt_facebook" value="<?php if ($grt_facebook && $grt_facebook != '') { echo $grt_facebook; } ?>" placeholder="https://www.facebook.com/groups/1233843429961548">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="grt_message" class="col-sm-3 control-label">Liên kết message:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="grt_message" id="grt_message" value="<?php if ($grt_message && $grt_message != '') { echo $grt_message; } ?>" placeholder="https://www.facebook.com/messages/t/726068167537746">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="grt_video" class="col-sm-3 control-label">Liên kết Youtube:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="grt_video" id="grt_video" value="<?php if ($grt_video && $grt_video != '') { echo $grt_video;  } ?>" placeholder="https://www.youtube.com/watch?v=q95pKXq8uVg">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="grt-province" class="col-sm-3 control-label">Tỉnh/Thành<font
                                        color="#FF0000"><b>*</b></font> :</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="grt_province" id="grt_province">
                                        <option value="">Chọn Tỉnh/Thành</option>
                                        <?php foreach ($province as $provinceArray) { ?>
                                            <?php if (isset($grt_province) && $grt_province == $provinceArray->pre_id) { ?>
                                                <option
                                                    value="<?php echo $provinceArray->pre_id; ?>"
                                                    selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                            <?php } else { ?>
                                                <option
                                                    value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                            <?php } ?>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="grt_district" class="col-sm-3 control-label">Quận/Huyện<font
                                        color="#FF0000"><b>*</b></font> :</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="grt_district" id="grt_district">
                                        <option value="">Chọn Quận/Huyện</option>
                                        <?php foreach ($district as $provinceArray) { ?>
                                            <option value="<?php echo $provinceArray->DistrictCode; ?>"
                                                <?php if (isset($grt_district) && $grt_district == $provinceArray->DistrictCode) { ?>
                                                    selected="selected" <?php } ?>><?php echo $provinceArray->DistrictName; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="grt_address" class="col-sm-3 control-label">Địa chỉ nhóm<font color="#FF0000"><b>*</b></font> :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="grt_address" id="grt_address" value="<?php if ($grt_address && $grt_address != '') { echo $grt_address;  } ?>" placeholder="Số nhà - Tên đường - Phường/Xã">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="grt_introduction" class="col-sm-3 control-label">Giới thiệu nhóm:</label>
                                <div class="col-sm-9">
                                    <?php $this->load->view('home/common/tinymce'); ?>
                                    <textarea class="editor form-control" name="grt_introduction" id="grt_introduction" value="" rows="10"><?php if ($grt_introduction && $grt_introduction != '') {
                                            echo $grt_introduction;
                                        } ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="grt_captcha" class="col-sm-3 control-label">Mã bảo vệ<font color="#FF0000"><b>*</b></font> :</label>
                                <div class="col-sm-4">
                                    <img src="<?php echo $imageCaptchaGrtContact; ?>" height="31" >
                                </div>
                                <div class="col-sm-5">
                                    <input style="text-indent: 5px; padding: 5px 0" onkeypress="return submitenter(this, event)" type="text" name="grt_captcha" id="captcha_groupContact" value="" maxlength="10" class="form-control"/>                                   
                                    <?php if($error_capchar) echo $error_capchar; ?>
                                </div>
                                
                            </div>
			    
                            <div class="form-group">
                                <div class="col-xs-6 col-sm-3 col-sm-offset-3">
                                    <button type="button" class="btn btn-primary btn-lg btn-block" onclick="check_ContactGroup();">Cập nhật
                                    </button>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <button type="reset" class="btn btn-default btn-lg btn-block">Hủy bỏ</button>
                                </div>
                                <input type="hidden" id="grt_id" value="<?php echo $grt_id; ?>" />
                            </div>
                        </form>
                    </div>
                    <!-- ========================== End Content ============================ -->
                </div>
            </div>
        </div>
    </div>
<br>
<script type="text/javascript" language="javascript" src="/templates/home/js/jAlert-master/jAlert-functions.min.js"></script>
<script type="text/javascript">
    function delete_images_ajax(no) {
        confirm(function (e, btn) {
            var gr_id = $('#grt_id').val();
            e.preventDefault();
            jQuery.ajax({
                type: 'POST',
                url: '/home/grouptrade/ajax_del_img',
                data: {grt_id:gr_id, num:no},
                success: function (res) {
                    if(res == '1'){
                        jQuery('#img_vavatar_input_'+no).css("display", "none");
                        jQuery('#vavatar_input_'+no).css("display", "block");
                    }
                },
                error: function () {
                    alert('Không xóa được! Vui lòng thử lại.');
                }
            })
        });
        return false
    }

    function check_grtlink(e,t,n){
        jQuery.ajax({
            type:"POST",
            url:e+"home/grouptrade/check_grtlink",
            data:"grt_link="+t+"&grtId="+n,
            success:function(e){
                if(e > 0){
                    $.jAlert({
                        'title':'Thông báo',
                        'content':'Link group của bạn đã bị trùng với group khác, vui lòng nhập link khác!',
                        'theme':'red',
                        'btns':{
                            'text':'Ok',
                            'theme':'red',
                            'onClick':function(e,btn){
                                e.preventDefault();
                                jQuery("#grt_link").val("");
                                jQuery("#grt_link").focus();
                                return false;}
                        }
                    });
                    return false;
                }
            },
            error:function(){}
        });
    }

    $("#grt_province").change(function () {
        if ($("#grt_province").val()) {
            $.ajax({
                url: '/home/showcart/getDistrict',
                type: "POST",
                data: {user_province_put: $("#grt_province").val()},
                cache: true,
                beforeSend: function () {
                    document.getElementById("grt_province").disabled = true;
                },
                success: function (response) {
                    document.getElementById("grt_province").disabled = false;
                    if (response) {
                        var json = JSON.parse(response);
                        emptySelectBoxById('grt_district', json);
                        delete json;
                    } else {
                        alert("Lỗi! Vui lòng thử lại");
                    }
                },
                error: function () {
                    alert("Không thành công! Vui lòng thử lại");
                }
            });
        }
    });
</script>
<?php $this->load->view('group/common/footer'); ?>