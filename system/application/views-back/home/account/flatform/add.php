<?php $this->load->view('home/common/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
	    <?php if($shopedit->fl_link == '') {?>	    
            <h4 class="page-header" style="margin-top:0px"> TẠO GIAN HÀNG D2</h4>
	    <?php } else { ?>
	    <h4 class="page-header" style="margin-top: 10px;">
		CẬP NHẬT GIAN HÀNG D2
		<a class="btn btn-default pull-right" title=" Xem gian hàng " target="_blank"
		   href="//<?php echo $shopedit->fl_link .'.'. domain_site ?>/flatform/news">
		    <i class="fa fa-eye fa-fw"></i> Xem gian hàng
		</a>
	    </h4>
	    <?php } ?>
            <br>
            <?php if ($updateshopdev == 1 ) { ?> 			
                <div class="alert alert-success alert-dismissible fade in" role="alert"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span></button> 
                    <h4>Bạn đã cập nhật gian hàng D2 thành công</h4> 
                    <p>Click <a href="/account/flatformd2/joinshop"><b>vào đây</b></a> để chọn gian hàng thêm vào D2</p>				
                </div>			
            <?php } ?>
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2" for="fl_name">Tên <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input name="fl_name" type="text" class="form-control" id="fl_name" placeholder="Tên gian hàng" value="<?php echo $shopedit->fl_name ?>">
                        <div class="small text-danger"><?php echo form_error('fl_name'); ?></div>
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_link">Link <span class="text-danger">*</span></label>                    
                    <div class="col-sm-10"> 
                        <div class="row"> 
                            <div class="col-xs-6"> 
                                <input name="fl_link" type="text" class="form-control" id="fl_link" placeholder="Link gian hàng" value="<?php echo $shopedit->fl_link ?>">
                            </div>
                            <div class="col-xs-6"> 
                                .<?php echo domain_site ?>/flatform/news
                            </div> 
                        </div>
                        <div class="small text-danger"><?php echo form_error('fl_link'); ?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_desc">Mô tả <span class="text-danger">*</span></label>
                    <div class="col-sm-10">                        
                        <input name="fl_desc" type="text" class="form-control" id="fl_desc" placeholder="Mô tả gian hàng" maxlength="200" value="<?php echo $shopedit->fl_desc ?>">
                        <div class="small text-danger"><?php echo form_error('fl_desc'); ?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_logo">Logo</label>
                    <div class="col-sm-6"> 
                        <input name="fl_logo" type="file" id="fl_logo">
                        <p><small>Dung lượng ảnh logo <= 500KB, <br>Chiều rộng 120px, chiều cao 120px</small></p>
                    </div>
                    <div class="col-sm-4">
                        <?php if($shopedit->fl_logo!="") { 
                            $logosrc = DOMAIN_CLOUDSERVER . 'media/images/flatform/'.$shopedit->fl_dir_logo.'/' . $shopedit->fl_logo;
                        } else {
                            $logosrc = '/images/noimage.jpg';
                        }
                        ?>
                        <img id="logopreview" src="<?php echo $logosrc ?>" style="height:100px; border:1px solid #ddd;"/>
                        <script>
                            function readlogoURL(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        $('#logopreview').attr('src', e.target.result);
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                            $("#fl_logo").change(function () {
                                readlogoURL(this);
                            });
                        </script>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_banner">Banner</label>
                    <div class="col-sm-6"> 
                        <input name="fl_banner" type="file" id="fl_banner">
                        <p><small>Đây là địa chỉ shop online của doanh nghiệp trên azibai.com.<br>Ví dụ: http://thoitrang.azibai.com/</small></p>
                    </div>
                    <div class="col-sm-4">
                        <?php if($shopedit->fl_banner!="") { 
                            $bannersrc = DOMAIN_CLOUDSERVER . 'media/images/flatform/'.$shopedit->fl_dir_banner.'/' . $shopedit->fl_banner;
                        } else {
                            $bannersrc = '/images/noimage.jpg';
                        }
                        ?>
                        <img id="bannerpreview" src="<?php echo $bannersrc ?>" style="height:100px; border:1px solid #ddd;"/>
                        <script>
                            function readbannerURL(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        $('#bannerpreview').attr('src', e.target.result);
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                            $("#fl_banner").change(function () {
                                readbannerURL(this);
                            });
                        </script>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_mobile">Mobile <span class="text-danger">*</span></label>
                    <div class="col-sm-4"> 
                        <input name="fl_mobile" type="text"  class="form-control" id="fl_mobile" value="<?php echo $shopedit->fl_mobile ? $shopedit->fl_mobile : $user->use_mobile ?>">
                        <div class="small text-danger"><?php echo form_error('fl_mobile'); ?></div>
                    </div>
                    <div class="visible-xs">&nbsp;</div>
                    <label class="col-sm-2" for="fl_hotline">Hotline</label>
                    <div class="col-sm-4"> 
                        <input name="fl_hotline" type="text"  class="form-control" id="fl_hotline" value="<?php echo $shopedit->fl_hotline ? $shopedit->fl_hotline : $user->use_phone ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_email">Email <span class="text-danger">*</span></label>
                    <div class="col-sm-10"> 
                        <input name="fl_email" type="email" class="form-control" id="fl_email" placeholder="email@domain.com" value="<?php echo $shopedit->fl_email ? $shopedit->fl_email : $user->use_email ?>">
                        <div class="small text-danger"><?php echo form_error('fl_email'); ?></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2" for="fl_introduction">Giới thiệu</label>
                    <div class="col-sm-10"> 
                        <textarea name="fl_introduction" type="text"  class="form-control" id="fl_introduction" rows="10"><?php echo $shopedit->fl_introduction ?></textarea>                       
                    </div>
                </div>
                <?php //print_r($province);?>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_province">Tỉnh/thành</label>
                    <div class="col-sm-4"> 
                        <select name="fl_province" id="fl_province" class="form-control">
                            <option value="">Chọn Tỉnh/Thành</option>
                            <?php foreach($province as $value) { ?>
                            <option value="<?php echo $value->pre_id ?>" 
                                <?php if($value->pre_id == $shopedit->fl_province) echo 'selected="selected"'; ?>> 
                                <?php echo $value->pre_name ?>
                            </option>
                            <?php } ?>
                        </select> 
                    </div>
                    <div class="visible-xs">&nbsp;</div>
                    <label class="col-sm-2" for="fl_district">Quận/huyện</label>
                    <div class="col-sm-4"> 
                        <select name="fl_district" id="fl_district" class="form-control">
                            <option value="">Chọn Quận/Huyện</option>
                            <?php
                                foreach ($district as $vals):
                                    if ($vals->DistrictCode == $shopedit->fl_district) {
                                        $district_selected = "selected='selected'";
                                    } else {
                                        $district_selected = '';
                                    }
                                    echo '<option value="' . $vals->DistrictCode . '" ' . $district_selected . '>' . $vals->DistrictName . '</option>';
                                endforeach;
                            ?>
                        </select>    
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_address">Địa chỉ</label>
                    <div class="col-sm-10"> 
                        <input name="fl_address" type="text"  class="form-control" id="fl_address" placeholder="Số nhà, tên đường, phường/xã" value="<?php echo $shopedit->fl_address ? $shopedit->fl_address : $user->use_address ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_facebook">Facebook</label>
                    <div class="col-sm-4"> 
                        <input name="fl_facebook" type="text"  class="form-control" id="fl_facebook" placeholder="Kết nối Facebook" value="<?php echo $shopedit->fl_facebook ?>">
                    </div> 
                    <div class="visible-xs">&nbsp;</div>
                    <label class="col-sm-2" for="fl_youtube">YouTube</label>
                    <div class="col-sm-4"> 
                        <input name="fl_youtube" type="text"  class="form-control" id="fl_youtube" placeholder="Kết nối Youtube" value="<?php echo $shopedit->fl_youtube ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_twitter">Twitter</label>
                    <div class="col-sm-4"> 
                        <input name="fl_twitter" type="text"  class="form-control" id="fl_twitter" placeholder="Kết nối Twitter" value="<?php echo $shopedit->fl_twitter ?>">
                    </div>
                    <div class="visible-xs">&nbsp;</div>
                    <label class="col-sm-2" for="fl_google_plus">Google plus</label>
                    <div class="col-sm-4"> 
                        <input name="fl_google_plus" type="text"  class="form-control" id="fl_google_plus" placeholder="Kết nối Google+" value="<?php echo $shopedit->fl_google_plus ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_video">Video giới thiệu</label>
                    <div class="col-sm-10"> 
                        <input name="fl_video" type="text"  class="form-control" id="fl_video" placeholder="https://www.youtube.com/watch?v=srhKXGGelvQ" value="<?php echo $shopedit->fl_video ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_bank">Ngân hàng</label>
                    <div class="col-sm-10"> 
                        <input name="fl_bank" type="text"  class="form-control" id="fl_bank" value="<?php echo $shopedit->fl_bank ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_bank_num">Số tài khoản</label>
                    <div class="col-sm-10"> 
                        <input name="fl_bank_num" type="text"  class="form-control" id="fl_bank_num" value="<?php echo $shopedit->fl_bank_num ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_bank_address">Chi nhánh</label>
                    <div class="col-sm-10"> 
                        <input name="fl_bank_address" type="text"  class="form-control" id="fl_bank_address" value="<?php echo $shopedit->fl_bank_address ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="fl_domain">Domain</label>
                    <div class="col-sm-10"> 
                        <input name="fl_domain" type="text"  class="form-control" id="fl_domain" value="<?php echo $shopedit->fl_domain ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button type="submit" class="btn btn-azibai">Cập nhật</button>
                        <input type="hidden" name="update" value="1">
                    </div>
                </div>
            </form>
        </div>
    </div> 
    
    <script type="text/javascript">
    $("#fl_province").change(function () {
        if ($("#fl_province").val()) {
            $.ajax({
                url: '<?php echo base_url()?>home/showcart/getDistrict',
                type: "POST",
                data: {user_province_put: $("#fl_province").val()},
                cache: true,
                beforeSend: function () {
                    document.getElementById("fl_province").disabled = true;
                },
                success: function (response) {
                    document.getElementById("fl_province").disabled = false;
                    if (response) {
                        var json = JSON.parse(response);
                        emptySelectBoxById('fl_district', json);
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
<?php $this->load->view('home/common/footer'); ?>
