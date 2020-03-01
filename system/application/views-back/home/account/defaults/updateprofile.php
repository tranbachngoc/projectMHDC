<?php $this->load->view('home/common/account/header'); ?>


<nav class="visible-lg" style="position: fixed; right: 0; top:50%; margin-top: -162px; z-index: 999; background: rgba(255,255,255,.75)">
    <ul class="nav inner-nav">
        <li><a href="#top" title="Thông tin cá nhân"><i class="fa fa-home fa-fw"></i></a></li>
        <li><a href="#company2" title="Công ty"><i class="fa fa-university fa-fw"></i></a></li>
        <li><a href="#services" title="Dịch vụ"><i class="fa fa-cogs fa-fw"></i></a></li>
        <li><a href="#statistic" title="Thống kê"><i class="fa fa-bar-chart fa-fw"></i></a></li>
        <li><a href="#products" title="Sản phẩm"><i class="fa fa-cubes fa-fw"></i></a></li>
        <li><a href="#customers" title="Khách hàng"><i class="fa fa-users fa-fw"></i></a></li>
        <li><a href="#certification" title="Chứng nhận"><i class="fa-fw fa fa-certificate fa-fw"></i></a></li>
        <li><a href="#actions" title="Hoạt động"><i class="fa-fw fa fa-edit fa-fw"></i></a></li>
        <li><a href="#contact" title="Liên hệ"><i class="fa-fw fa fa-save fa-fw"></i></a></li>
    </ul>
</nav>
<style>
    input[type="color"] {
        -webkit-appearance: none;
        border: 0px;
        width: 34px;
        height: 34px;
        padding: 0;    margin: 0;
    }
    input[type="color"]::-webkit-color-swatch-wrapper {
        padding: 0;
    }
    input[type="color"]::-webkit-color-swatch {
        border: none;
    }
</style>
<script>
    jQuery(function ($) {
        $('ul.inner-nav > li > a').click(function (e) {
            e.preventDefault();
            var aTag = $(this).attr('href');
            $('html,body').animate({scrollTop: $(aTag).offset().top - 55}, 'slow');
        });
        $('.buttonsubmit').scrollToFixed({bottom: 0, limit: $('#footer').offset().top});
        var s = <?php echo $resume->style ?>;
        if (s == 3) {
            $('.selectcolor').fadeIn();
        } else {
            $('.selectcolor').fadeOut();
        }
        $('#displaystyle').change(function () {
            if ($(this).val() == '3') {
                $('.selectcolor').fadeIn();
            } else {
                $('.selectcolor').fadeOut();
            }
        }); 
		
        $(document).on('click', '.deletebox', function () {
            var image = $(this).data('image');                                
            $.ajax({
                type: "post",
                url: '/home/user/delete_box',
                cache: false,
                dataType: 'text',
                data: {image: image},
                success: function (response) {
                    console.log(response);
                    if (response == '0') {
                        alert('Đã có lỗi xảy ra, không xóa được.');
                    } else {
                        
                    }
                }
            });
            $(this).parent().remove();
        });
        $(document).on('click', '.deletebox2', function () {
             $(this).parent().remove();
        });
        
    });
    function deleteproduct(key, image) {
        confirm(function (e, btn) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: '/home/user/delete_product',
                cache: false,
                dataType: 'text',
                data: {key: key, image: image},
                success: function (response) {
                    console.log(response);
                    if (response == '0') {
                        alert('Đã có lỗi xảy ra, không xóa được.');
                    } else {
                        $(response).find('a').remove();
                        $(response).find('input').attr("value", "");
                        $(response).find('img').remove();
                    }
                }
            });
        });
        return false;
    }
    function deleteimage(field, image) {
        confirm(function (e, btn) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: '/home/user/deleteimage',
                cache: false,
                dataType: 'text',
                data: {field: field, image: image},
                success: function (response) {
                    console.log(response);
                    if (response == '0') {
                        alert('Đã có lỗi xảy ra, không xóa được.')
                    } else {
                        $(response).remove();
                    }
                }
            });
        });
        return false;
    }
    function delete_certification(key, image) {
        confirm(function (e, btn) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: '/home/user/delete_certification',
                cache: false,
                dataType: 'text',
                data: {key: key, image: image},
                success: function (data) {
                    console.log(data);
                    if (data == '0') {
                        alert('Đã có lỗi xảy ra, không xóa được.')
                    } else {
                        $(data).remove();
                    }
                }
            });
        });
        return false;
    }
    

</script>
<div id="main" class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <a target="_blank" class="pull-right" href="/profile/<?php echo $resume->userid ?>/<?php echo RemoveSign($resume->fullname) ?>"><i class="fa fa-eye fa-fw"></i> Xem danh thiếp</a>

            <h4 class="page-header" style="margin-top:10px">CẬP NHẬT DANH THIẾP ĐIỆN TỬ</h4>   
            <?php if ($updateProfile == 1) { ?>
                <div class="alert alert-success">
                    Danh thiếp điện tử của bạn được cập nhật thành công. 
                </div>    
            <?php } ?>
            <form id="updateprofile" method="POST" action="/account/updateprofile" enctype="multipart/form-data" style="margin-right: 32px;">

                <div id="top">          
                    <h4 class="text-center"><span style="border-bottom:2px solid red">THÔNG TIN CÁ NHÂN</span></h4>    
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="logo" class="control-label">Logo công ty</label> 
                                <input name="logo_new" type="file" class="form-control"><br/>
                                <div class="logo" style="position: relative">
                                    <?php if ($resume->logo) { ?>                       
                                        <input name="logo" type="hidden" value="<?php echo $resume->logo ?>">
                                        <img style="max-height:100px" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->logo; ?>"/>
                                        <a class="btn btn-danger btn-delete-image" onclick="deleteimage('logo', '<?php echo $resume->logo; ?>')">X</a>
                                    <?php } else { ?>                                
                                        <img style="max-height:100px" class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/logo.jpg'; ?>"/>                       
                                    <?php } ?>                            
                                </div>
                            </div>                    
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="banner" class="control-label">Ảnh của bạn (1600x900 px)</label>
                                <input name="banner_new" type="file" class="form-control" /><br/>                                                          
                                <div class="banner" style="position: relative">
                                    <?php if ($resume->banner) { ?>                                
                                        <input name="banner" type="hidden" value="<?php echo $resume->banner ?>">
                                        <img style="max-height:100px" class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->banner; ?>" />
                                        <a class="btn btn-danger btn-delete-image" onclick="deleteimage('banner', '<?php echo $resume->banner; ?>')">X</a>
                                    <?php } else { ?>
                                        <img style="max-height:100px" class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/banner.jpg'; ?>"/>
                                    <?php } ?> 
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row">           
                        <div class="col-md-4">           
                            <div class="form-group">
                                <label for="fullname" class="control-label">Họ và Tên</label>
                                <input name="fullname" type="text" class="form-control" value="<?php echo $resume->fullname ? $resume->fullname : $user->use_fullname; ?>" placeholder="Họ và Tên">
                            </div>  
                        </div>  
                        <div class="col-md-4"> 	
                            <div class="form-group"> 
                                <label for="birthday" class="control-label">Ngày sinh</label>
                                <input name="birthday" type="date" class="form-control" value="<?php echo $resume->birthday ? $resume->birthday : date("Y-m-d", $user->use_birthday); ?>" placeholder="dd/mm/yyyy">
                            </div>
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sex" class="control-label">Giới tính</label>
                                <select name="sex" id="sex_account" class="form-control">
                                    <?php if (is_null($resume->sex)) { ?>
                                        <option value="0" <?php if ($user->use_sex == 0) echo 'selected'; ?>>Nữ</option>
                                        <option value="1" <?php if ($user->use_sex == 1) echo 'selected'; ?>>Nam</option>
                                    <?php } else { ?>
                                        <option value="0" <?php if ($resume->sex == 0) echo 'selected'; ?>>Nữ</option>
                                        <option value="1" <?php if ($resume->sex == 1) echo 'selected'; ?>>Nam</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="religion" class="control-label">Tôn giáo</label>
                                <input name="religion" type="text" class="form-control" value="<?php echo $resume->religion; ?>" placeholder="Tôn giáo">
                            </div>
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="career" class="control-label">Ngành nghề</label>
                                <input type="text" class="form-control" name="career" value="<?php echo $resume->career; ?>" placeholder="Ngành nghề">
                            </div>
                        </div>                      
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="department" class="control-label">Phòng ban</label>
                                <input name="department" type="text" class="form-control" value="<?php echo $resume->department; ?>" placeholder="Phòng ban">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group"> 
                                <label for="mobile" class="control-label">Mobile</label>
                                <input name="mobile" type="text" class="form-control" value="<?php echo $resume->mobile ? $resume->mobile : $user->use_mobile; ?>" placeholder="09012345678">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group"> 
                                <label for="email" class="control-label">Email</label>
                                <input name="email" type="email" class="form-control" value="<?php echo $resume->email ? $resume->email : $user->use_email; ?>" placeholder="youremail@domain.com">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="education" class="control-label">Trình độ</label>
                                <input name="education" list="browsers" class="form-control" value="<?php echo $resume->education; ?>" placeholder="Trình độ">
                                <datalist id="browsers">
                                    <option value="Phổ thông">
                                    <option value="Trung cấp">
                                    <option value="Cao đẳng">
                                    <option value="Đại học">
                                    <option value="Cao học">
                                </datalist>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group"> 
                                <label for="marriage" class="control-label">TT Hôn nhân</label>
                                <?php $listmarriage = array("Độc thân", "Đính hôn", "Đã kết hôn", "Ly thân", "Ly hôn", "Người góa chồng", "Người góa vợ"); ?>
                                <select name="marriage" class="form-control">
                                    <?php foreach ($listmarriage as $key => $value) { ?>
                                        <option value="<?php echo $value ?>" <?php echo $resume->marriage == $value ? 'selected' : '' ?>><?php echo $value ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="accommodation" class="control-label">Nơi sống</label>
                                <input name="accommodation" type="text" class="form-control" value="<?php echo $resume->accommodation; ?>" placeholder="Nơi mà bạn đang sống">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="favorites" class="control-label">Sở thích</label>
                                <input name="favorites" type="text" class="form-control" value="<?php echo $resume->favorites; ?>" placeholder="Liệt kê các sở thích của bạn">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="sayings" class="control-label">Câu nói yêu thích</label>
                                <input name="sayings" type="text" class="form-control" value="<?php echo $resume->sayings; ?>" placeholder="Câu nói yêu thích của bạn">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="company2">
                    <hr>
                    <h4 class="text-center"><span style="border-bottom:2px solid red">GIỚI THIỆU CÔNG TY</span></h4>
                    <div class="form-group text-center">                            
                        <input type="radio" name="show_company" value="1" <?php echo $resume->show_company == 1 ? 'checked' : '' ?>> Hiện
                        &nbsp;
                        <input type="radio" name="show_company" value="0" <?php echo $resume->show_company == 0 ? 'checked' : '' ?>> Ẩn 
                    </div>
                    <div class="row">                    
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="company_image" class="control-label">Ảnh giới thiệu (400x400 px)</label>
                                <input name="company_image_new" type="file" class="form-control"><br/>
                                <div class="company_image" style="position: relative">
                                    <?php if ($resume->company_image) { ?>
                                        <input name="company_image" type="hidden" value="<?php echo $resume->company_image ?>">                               
                                        <img class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->company_image; ?>"/>
                                        <a class="btn btn-danger btn-delete-image" onclick="deleteimage('company_image', '<?php echo $resume->company_image; ?>')">X</a>
                                    <?php } else { ?>
                                        <img class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/about.jpg'; ?>"/>
                                    <?php } ?>
                                </div>    
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="company_name" class="control-label">Tên công ty</label>
                                <input name="company_name" type="text" class="form-control" value="<?php echo $resume->company_name; ?>" placeholder="Tên công ty">
                            </div>
                            <div class="form-group">
                                <label for="company_intro" class="control-label">Giới thiệu về công ty</label>
                                <textarea class="form-control" name="company_intro" rows="10" placeholder="Giới thiệu về công ty"><?php echo $resume->company_intro; ?></textarea>
                            </div>
                        </div>
                    </div> 

                    <h4 class="text-center"><span style="border-bottom:2px solid red">SLOGAN</span></h4>
                    <div class="form-group text-center">                            
                        <input type="radio" name="show_slogan" value="1" <?php echo $resume->show_slogan == 1 ? 'checked' : '' ?>> Hiện
                        &nbsp;
                        <input type="radio" name="show_slogan" value="0" <?php echo $resume->show_slogan == 0 ? 'checked' : '' ?>> Ẩn 
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="slogan_bg" class="control-label">Ảnh nền slogan (1600x900 px)</label>
                                <input name="slogan_bg_new" type="file" class="form-control">                        
                            </div>
                            <div class="slogan_bg" style="position:relative">
                                <?php if ($resume->slogan_bg) { ?>
                                    <input name="slogan_bg" type="hidden" value="<?php echo $resume->slogan_bg ?>">                               
                                    <img class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->slogan_bg; ?>"/>
                                    <a class="btn btn-danger btn-delete-image" onclick="deleteimage('slogan_bg', '<?php echo $resume->slogan_bg; ?>')">X</a>
                                <?php } else { ?>
                                    <img class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/bg1.jpg'; ?>"/>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">                        
                            <div class="form-group">
                                <label for="slogan" class="control-label">Slogan</label>
                                <textarea name="slogan" rows="5" maxlength="255" class="form-control" ><?php echo $resume->slogan; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label for="slogan_by" class="control-label">Trích dẫn bởi</label>
                                <input name="slogan_by" type="text" class="form-control" value="<?php echo $resume->slogan_by; ?>">
                            </div>
                        </div>

                    </div>
                </div>

                <div id="services">
                    <hr>
                    <h4 class="text-center"><span style="border-bottom:2px solid red">DỊCH VỤ</span></h4>
                    <div class="form-group text-center">                            
                        <input type="radio" name="show_service" value="1" <?php echo $resume->show_service == 1 ? 'checked' : '' ?>> Hiện
                        &nbsp;
                        <input type="radio" name="show_service" value="0" <?php echo $resume->show_service == 0 ? 'checked' : '' ?>> Ẩn 
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <strong>Tiêu đề</strong>
                                <input name="title_service" type="text" class="form-control" value="<?php echo $resume->title_service ?>" placeholder="DỊCH VỤ CUNG CẤP" maxlength="100">
                            </div>
                            <div class="form-group">
                                <label for="service_desc" class="control-label">Mô tả dịch vụ</label>
                                <textarea name="service_desc" class="form-control" rows="5"><?php echo $resume->service_desc; ?></textarea>                            
                            </div>
                        </div>
                    </div>

                    <?php
                    $listservice = json_decode($resume->list_service);
                    foreach ($listservice as $key => $value) {
                        ?>                
                        <div style="position:relative" class="well">
                            <br>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12"> 
                                    <input name="imageService[]" type="file" class="form-control">
                                    <img class="img-thumbnail img-responsive" style="height:100px; margin-top: 15px" 
                                         src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>"/> 
                                    <input name="imageServiceOld[]" type="hidden" value="<?php echo $value->image ?>">                                
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <div class="form-group"> <input name="titleService[]" type="text" class="form-control" value="<?php echo $value->title ?>" placeholder="Tên dịch vụ" maxlength="100"> </div>
                                    <div class="form-group"> <textarea name="descService[]" class="form-control" rows="5" maxlength="200" placeholder="Mô tả dịch vụ"><?php echo $value->desc ?></textarea> </div>
                                    <div class="form-group">
                                        <div class="input-group"> <span class="input-group-addon" title="Liên kết"> <i class="fa fa-link fa-fw"></i> </span> <input name="urlService[]" type="url" class="form-control" value="<?php echo $value->url ?>" placeholder="Link xem chi tiết"> </div>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-danger btn-xs deletebox" data-image="<?php echo $value->image ?>" style="position: absolute; top:0; right:0">X</a>
                        </div>
                    <?php } ?>            
                    <div id="addService" class="text-right">
                        <a class="btn btn-azibai">+ THÊM</a>
                    </div>
                    <script>
                        jQuery(function ($) {
                            $(document).on('click', '#addService', function () {
                                var boxhtml = '<div style="position:relative" class="well"> <br> <div class="row"> <div class="col-md-4 col-sm-4 col-xs-12"> <input name="imageService[]" type="file" class="form-control"> <img class="img-thumbnail img-responsive" style="height:100px; margin-top: 15px" src="<?php echo DOMAIN_CLOUDSERVER ?>media/images/profiles/default/service.png"/> </div><div class="col-md-8 col-sm-8 col-xs-12"> <div class="form-group"> <input name="titleService[]" type="text" class="form-control" value="" placeholder="Tên dịch vụ" maxlength="100"> </div><div class="form-group"> <textarea name="descService[]" class="form-control" rows="5" maxlength="200" placeholder="Mô tả dịch vụ"></textarea> </div><div class="form-group"> <div class="input-group"> <span class="input-group-addon" title="Liên kết"> <i class="fa fa-link fa-fw"></i> </span> <input name="urlService[]" type="url" class="form-control" value="" placeholder="Link xem chi tiết"> </div></div></div></div><a class="btn btn-danger btn-xs deletebox2" style="position: absolute; top:0; right:0">X</a></div>';
                                $(this).before(boxhtml);
                            });                            
                        });
                    </script>                       
                </div>

                <div id="statistic">
                    <hr>
                    <h4 class="text-center"><span style="border-bottom:2px solid red">THỐNG KÊ</span></h4> 
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group text-center">                            
                                <input type="radio" name="show_statistic" value="1" <?php echo $resume->show_statistic == 1 ? 'checked' : '' ?>> Hiện
                                &nbsp;
                                <input type="radio" name="show_statistic" value="0" <?php echo $resume->show_statistic == 0 ? 'checked' : '' ?>> Ẩn 
                            </div>    
                        </div>    
                    </div>
                    <?php
                    if ($resume->statistic != "") {
                        $statistics = json_decode($resume->statistic);
                    }
                    ?>	
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label for="statistic_bg" class="control-label">Ảnh nền thống kê</label>
                                <input name="statistic_bg_new" type="file" class="form-control">                           
                            </div>
                            <div class="statistic_bg" style="position: relative">
                                <?php if ($resume->statistic_bg) { ?>
                                    <input name="statistic_bg" type="hidden" value="<?php echo $resume->statistic_bg ?>">
                                    <img class="img-responsive img-thumbnail" style="height:100px;" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->statistic_bg; ?>"/>
                                    <a class="btn btn-danger btn-delete-image" onclick="deleteimage('statistic_bg', '<?php echo $resume->statistic_bg; ?>')">X</a>
                                <?php } else { ?>                                
                                    <img class="img-responsive img-thumbnail" style="height:100px;" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/bg2.jpg'; ?>"/>                    
                                <?php } ?> 
                            </div>                     
                        </div>
                        <div class="col-md-8 col-xs-12">                    
                            <?php for ($i = 0; $i < 4; $i++) { ?>
                                <label class="control-label">Thống kê <?php echo $i + 1 ?>:</label>
                                <div class="row">
                                    <div class="form-group col-xs-8">
                                        <input name="statistic_label_<?php echo $i ?>" type="text" value="<?php echo $statistics[$i]->label ?>" class="form-control" placeholder="Nhãn <?php echo $i + 1 ?>" maxlength="50">
                                    </div>
                                    <div class="form-group col-xs-4">    
                                        <input name="statistic_number_<?php echo $i ?>" type="number" value="<?php echo $statistics[$i]->number ?>" class="form-control" min="1" max="999999">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>    
                </div>

                <div id="products">
                    <hr>
                    <h4 class="text-center"><span style="border-bottom:2px solid red">SẢN PHẨM</span></h4>             
                    <div class="form-group text-center">                            
                        <input type="radio" name="show_product" value="1" <?php echo $resume->show_product == 1 ? 'checked' : '' ?>> Hiện
                        &nbsp;
                        <input type="radio" name="show_product" value="0" <?php echo $resume->show_product == 0 ? 'checked' : '' ?>> Ẩn 
                    </div>
                    <div class="form-group">
                        <strong>Tiêu đề</strong>
                        <input name="title_product" type="text" class="form-control" value="<?php echo $resume->title_product ?>" placeholder="SẢN PHẨM NỔI BẬT" maxlength="100">
                    </div>

                    <div class="row"> 
                        <div class="col-sm-12">
                            <div class="form-group">
                                <strong>Mô tả</strong>
                                <div class="form-group">
                                    <textarea name="product_desc"  class="form-control" rows="4"><?php echo $resume->product_desc ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php
                    $product_cat = json_decode($resume->product_cat);
                    
                    if ($resume->product_list_0 != "") {
                        $product_list_0 = json_decode($resume->product_list_0);
                    }
                    if ($resume->product_list_1 != "") {
                        $product_list_1 = json_decode($resume->product_list_1);
                    } 
                    if ($resume->product_list_2 != "") {
                        $product_list_2 = json_decode($resume->product_list_2);
                    }
                    if ($resume->product_list_3 != "") {
                        $product_list_3 = json_decode($resume->product_list_3);
                    }
                    $product_list = array($product_list_0,$product_list_1,$product_list_2,$product_list_3);
                    ?>                    
<!--                    <script>
                        function imagesPreview(input, placeToInsertImagePreview) {
                            if (input.files) {
                                var filesAmount = input.files.length;
                                for (i = 0; i < filesAmount; i++) {
                                    var reader = new FileReader();
                                    reader.onload = function(event) {
                                        var html = '<div class="preview col-md-4 col-sm-6 col-xs-12"><img src="' + event.target.result + '" class="img-responsive img-thumbnail" style="margin:0 0 15px"/><div class="form-group"> <div class="input-group"> <span class="input-group-addon" title="Liên kết"><i class="fa fa-cube fa-fw"></i></span> <input name="product_title[]" type="text" class="form-control" value="" placeholder="Tên sản phẩm"> </div> </div> <div class="form-group"> <div class="input-group"> <span class="input-group-addon" title="Liên kết"><i class="fa fa-link fa-fw"></i></span> <input name="product_url[]" type="url" class="form-control" value="" placeholder="Link xem sản phẩm"> </div> </div></div>';
                                        $($.parseHTML(html)).appendTo(placeToInsertImagePreview);
                                    }
                                    reader.readAsDataURL(input.files[i]);
                                }
                            }
                        }
                    </script>-->
                    <?php foreach($product_list as $i => $products) {?>
                    <div class="groupproduct">                        
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <strong>Nhóm sản phẩm <?php echo $i + 1 ?></strong>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-folder-open fa-fw"></i></span>                            
                                        <input name="product_cat_<?php echo $i ?>" type="text" class="form-control" 
                                               value="<?php echo $product_cat[$i] ? $product_cat[$i] : 'Nhóm sản phẩm '.$i + 1 ?>"
                                               placeholder="Nhóm sản phẩm" >
                                    </div>                        
                                </div>
                            </div>                            
                       </div>                        
                       <div class="row">
                            <?php foreach ($products as $value) { ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="well">
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <?php if($value->image) { ?>
                                            <div class="form-group">                                        
                                                <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image ?>" class="img-responsive img-thumbnail"/>
                                                <input name="product_image_<?php echo $i ?>_old[]" type="hidden" value="<?php echo $value->image ?>">
                                            </div>
                                            <?php } else { ?>
                                                <img src="/images/noimage.jpg" class="img-responsive img-thumbnail"/>
                                            <?php } ?>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="form-group">
                                                <input name="product_image_<?php echo $i ?>[]" type="file" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group"> <span class="input-group-addon" title="Tên sản phẩm"><i class="fa fa-cube fa-fw"></i></span> 
                                                    <input name="product_title_<?php echo $i ?>[]" type="text" class="form-control" value="<?php echo $value->title ?>" placeholder="Tên sản phẩm"> </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group"> 
                                                    <span class="input-group-addon" title="Liên kết"><i class="fa fa-link fa-fw"></i></span> 
                                                    <input name="product_url_<?php echo $i ?>[]" type="url" class="form-control" value="<?php echo $value->url ?>" placeholder="Link xem sản phẩm"> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                        
                                <a class="btn btn-danger btn-xs deletebox" data-image="<?php echo $value->image ?>" style="position: absolute; top:0; right:10px">X</a>
                            </div>
                            <?php } ?>
                            <div id="addProduct<?php echo $i ?>" class="text-center col-sm-12 col-xs-12 ">
                                <a class="btn btn-azibai">+ THÊM</a>
                            </div>
                            <script>                                
                                jQuery(function ($) {
                                    var i = <?php echo $i ?>;
                                    $(document).on('click', '#addProduct' + i, function () {
                                        var boxhtml = '<div class="col-md-6 col-sm-6 col-xs-12"> <div class="well"> <br> <div class="row"> <div class="col-sm-3 col-xs-12"> <div class="form-group"> <img src="/images/noimage.jpg" class="img-responsive img-thumbnail"/> </div> </div> <div class="col-sm-9 col-xs-12"> <div class="form-group"> <input name="product_image_' + i + '[]" type="file" class="form-control"> </div> <div class="form-group"> <div class="input-group"> <span class="input-group-addon" title="Tên sản phẩm"><i class="fa fa-cube fa-fw"></i></span> <input name="product_title_' + i + '[]" type="text" class="form-control" value="" placeholder="Tên sản phẩm"> </div> </div> <div class="form-group"> <div class="input-group"> <span class="input-group-addon" title="Liên kết"><i class="fa fa-link fa-fw"></i></span> <input name="product_url_' + i + '[]" type="url" class="form-control" value="" placeholder="Link xem sản phẩm"> </div> </div> </div> </div> </div> <a class="btn btn-danger btn-xs deletebox2" style="position: absolute; top:0; right:10px">X</a> </div>';
                                        $(this).before(boxhtml);
                                    });                                
                                });
                            </script>
                        </div>
                    </div>
                    <?php } ?>
                    

                    <div id="customers"> 
                        <hr/>
                        <h4 class="text-center"><span style="border-bottom:2px solid red">Ý KIẾN KHÁCH HÀNG</span></h4>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group text-center">                            
                                    <input type="radio" name="show_customer" value="1" <?php echo $resume->show_customer == 1 ? 'checked' : '' ?>> Hiện
                                    &nbsp;
                                    <input type="radio" name="show_customer" value="0" <?php echo $resume->show_customer == 0 ? 'checked' : '' ?>> Ẩn 
                                </div> 
                                <div class="form-group">
                                    <strong>Tiêu đề</strong>
                                    <input name="title_customer" type="text" class="form-control" value="<?php echo $resume->title_customer ?>" placeholder="Ý KIẾN KHÁCH HÀNG">
                                </div>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                Ảnh nền khách khàng (1600 x 900 px)   
                                <div class="form-group">                            
                                    <input name="customer_bg_new" type="file" class="form-control">                            
                                </div>                        
                            </div>
                            <div class="col-sm-12">
                                <div class="customer_bg" style="position: relative">
                                    <?php if ($resume->customer_bg) { ?>
                                        <input name="customer_bg" type="hidden" value="<?php echo $resume->customer_bg ?>">
                                        <img class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->customer_bg; ?>"/>
                                        <a class="btn btn-danger btn-delete-image" onclick="deleteimage('customer_bg', '<?php echo $resume->customer_bg; ?>')">X</a>
                                    <?php } else { ?>                                
                                        <img class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/bg3.jpg'; ?>"/>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <p class="text-primary text-center">(Ảnh avartar hình vuông kích thước 200 x 200 px)</p>
                        
                        <?php
                        $customers = json_decode($resume->list_customer);                                
                        ?>
                        <?php foreach ($customers as $key => $value) { ?>
                        
                        <div style="position:relative" class="well">
                            <br>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12"> 
                                    <input name="customer_image[]" type="file" class="form-control"> 
                                    <img class="img-thumbnail img-responsive" style="height:100px; margin-top: 15px" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>" /> 
                                    <input name="customer_image_old[]" type="hidden" value="<?php echo $value->image ?>">
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <div class="form-group"> <textarea name="customer_say[]" class="form-control" rows="5" maxlength="400" placeholder="Ý kiến khách hàng"><?php echo $value->say ?></textarea> </div>
                                    <div class="form-group">
                                        <div class="input-group"> <span class="input-group-addon" title="Tên khách hàng"><i class="fa fa-user fa-fw"></i></span> <input name="customer_name[]" type="text" class="form-control" value="<?php echo $value->name ?>" placeholder="Tên khách hàng" maxlength="50"> </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group"> <span class="input-group-addon" title="Liên kết"> <i class="fa fa-link fa-fw"></i> </span> <input name="customer_url[]" type="url" class="form-control" value="<?php echo $value->url ?>" placeholder="Liên kết video youtube"> </div>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-danger btn-xs deletebox" data-image="<?php echo $value->image ?>" style="position: absolute; top:0; right:0">X</a> 
                        </div>                            
                        <?php } ?>                        
                        <div id="addCustomer" class="text-center">
                            <a class="btn btn-azibai">+ THÊM</a>
                        </div>
                        <script>
                            jQuery(function ($) {
                                $(document).on('click', '#addCustomer', function () {
                                    var boxhtml = '<div style="position:relative" class="well"> <br> <div class="row"> <div class="col-md-4 col-sm-4 col-xs-12"> <input name="customer_image[]" type="file" class="form-control"> <img class="img-thumbnail img-responsive" style="height:100px; margin-top: 15px" src="<?php echo DOMAIN_CLOUDSERVER ?>media/images/profiles/default/service.png"/> </div> <div class="col-md-8 col-sm-8 col-xs-12"> <div class="form-group"> <textarea name="customer_say[]" class="form-control" rows="5" maxlength="400" placeholder="Ý kiến khách hàng"></textarea> </div> <div class="form-group"> <div class="input-group"> <span class="input-group-addon" title="Tên khách hàng"><i class="fa fa-user fa-fw"></i></span> <input name="customer_name[]" type="text" class="form-control" value="" placeholder="Tên khách hàng" maxlength="50"> </div> </div> <div class="form-group"> <div class="input-group"> <span class="input-group-addon" title="Liên kết"> <i class="fa fa-link fa-fw"></i> </span> <input name="customer_url[]" type="url" class="form-control" value="" placeholder="Liên kết video youtube"> </div> </div> </div> </div> <a class="btn btn-danger btn-xs deletebox2" style="position: absolute; top:0; right:0">X</a> </div>';
                                    $(this).before(boxhtml);
                                });                                
                            });
                        </script> 
                       
                        
                        
                        
                    </div>
                    
                    
                    
                    <div id="certification">
                        <hr/>
                        <h4 class="text-center"><span style="border-bottom:2px solid red">CHỨNG NHẬN</span></h4>	

                        <div class="form-group text-center">                            
                            <input type="radio" name="show_certification" value="1" <?php echo $resume->show_certification == 1 ? 'checked' : '' ?>> Hiện
                            &nbsp;
                            <input type="radio" name="show_certification" value="0" <?php echo $resume->show_certification == 0 ? 'checked' : '' ?>> Ẩn 
                        </div>
                        <div class="form-group">
                            <strong>Tiêu đề</strong>
                            <input name="title_certification" type="text" class="form-control" value="<?php echo $resume->title_certification ?>" placeholder="CÁC CHỨNG NHẬN" maxlength="100">
                        </div>
                        <div class="row">                        
                            <?php
                            $certification = json_decode($resume->certification);
                            foreach ($certification as $key => $value) {
                                ?>
                                <div class="col-md-4 col-sm-4 col-xs-12" style="position:relative">
                                    <div class="well">
                                        <br>
                                        <div class="form-group">
                                            <input name="certification_image[]" type="file" class="form-control"> 
                                            <img style="height:100px; margin-top:15px;" class="img-thumbnail img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>"/>
                                            <input name="certification_image_old[]" type="hidden"  value="<?php echo $value->image ?>">
                                        </div>
                                    </div>                                       
                                    <a class="btn btn-danger btn-xs deletebox" data-image="<?php echo $value->image ?>" style="position: absolute; top:0; right:10px">X</a> 
                                </div>                     
                            <?php } ?>
                            <div id="addCertification" class="text-center col-md-12 col-sm-12 col-xs-12">
                                <a class="btn btn-azibai">+ THÊM</a>
                            </div>
                        </div>
                        <script>
                            jQuery(function ($) {
                                $(document).on('click', '#addCertification', function () {
                                    var boxhtml = '<div class="col-md-4 col-sm-4 col-xs-12" style="position:relative"> <div class="well"> <br> <div class="form-group"> <input name="certification_image[]" type="file" class="form-control"> <img style="height:100px; margin-top:15px;" class="img-thumbnail img-responsive" src="/images/noimage.jpg"/> </div> </div> <a class="btn btn-danger btn-xs deletebox2" style="position: absolute; top:0; right:10px">X</a> </div>';
                                    $(this).before(boxhtml);
                                });                                
                            });
                        </script>                        
                    </div>

                    <div id="actions">
                        <hr>
                        <h4 class="text-center"><span style="border-bottom:2px solid red">HOẠT ĐỘNG NỔI BẬT</span></h4>
                        <div class="form-group text-center">                            
                            <input type="radio" name="show_history" value="1" <?php echo $resume->show_history == 1 ? 'checked' : '' ?>> Hiện
                            &nbsp;
                            <input type="radio" name="show_history" value="0" <?php echo $resume->show_history == 0 ? 'checked' : '' ?>> Ẩn 
                        </div>
                        <div class="form-group">
                            <strong>Tiêu đề</strong>
                            <input name="title_history" type="text" class="form-control" value="<?php echo $resume->title_history ?>" placeholder="HOẠT ĐỘNG NỔI BẬT" maxlength="100">
                        </div>
                        <p class="text-primary text-center">(Ảnh hoạt động kích thước 800 x 450 px)</p>
                        <?php
                        $historys = json_decode($resume->list_history);                        
                        ?>                
                        <?php foreach ($historys as $key => $value) { ?>
                        <div class="well" style="position: relative;"> 
                            <br>
                            <div class="row">  
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <input name="history_image[]" type="file" class="form-control">
                                    <?php if($value->image) { ?>
                                    <img class="img-responsive img-thumbnail" style="height:100px; margin-top: 15px" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>"/>
                                    <input name="history_image_old[]" type="hidden" value="<?php echo $value->image ?>">
                                    <?php } else { ?>
                                    <img class="img-responsive img-thumbnail" style="height:100px; margin-top: 15px" src="/media/images/noimage.png"/>
                                    <?php } ?>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <input name="history_title[]" type="text" class="form-control" value="<?php echo $value->title ?>" placeholder="Tiêu đề hoạt động" maxlength="100">
                                    </div>                        
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>                            
                                            <input name="history_date[]" type="date" class="" value="<?php echo $value->date ?>" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon" title="Liên kết youtube"><i class="fa fa-youtube fa-fw"></i></span>                            
                                            <input name="history_youtube[]" type="url" class="form-control" value="<?php echo $value->youtube ?>" placeholder="Link xem youtube">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="history_text[]" class="form-control" rows="5" maxlength="200"><?php echo $value->text ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon" title="Liên kết"><i class="fa fa-link fa-fw"></i></span>                            
                                            <input name="history_url[]" type="url" class="form-control" value="<?php echo $value->url ?>" placeholder="Link xem chi tiết">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <a class="btn btn-danger btn-xs deletebox" data-image="<?php echo $value->image ?>" style="position: absolute; top:0; right:0">X</a>
                        </div>                            
                        <?php } ?>
                        <div id="addHistory" class="text-center">
                            <a class="btn btn-azibai">+ THÊM</a>
                        </div>
                        <script>
                            jQuery(function ($) {
                                $(document).on('click', '#addHistory', function () {
                                    var boxhtml = '<div class="well" style="position: relative;"> <br> <div class="row"> <div class="col-md-4 col-sm-4 col-xs-12"> <input name="history_image[]" type="file" class="form-control"> <img class="img-responsive img-thumbnail" style="height:100px; margin-top: 15px" src="/media/images/noimage.png"/> </div> <div class="col-md-8 col-sm-8 col-xs-12"> <div class="form-group"> <input name="history_title[]" type="text" class="form-control" value="" placeholder="Tiêu đề hoạt động" maxlength="100"> </div> <div class="form-group"> <div class="input-group"> <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span> <input name="history_date[]" type="date" class="" value="" placeholder="dd/mm/yyyy"> </div> </div> <div class="form-group"> <div class="input-group"> <span class="input-group-addon" title="Liên kết youtube"><i class="fa fa-youtube fa-fw"></i></span> <input name="history_youtube[]" type="url" class="form-control" value="" placeholder="Link xem youtube"> </div> </div> <div class="form-group"> <textarea name="history_text[]" class="form-control" rows="5" maxlength="200"></textarea> </div> <div class="form-group"> <div class="input-group"> <span class="input-group-addon" title="Liên kết"><i class="fa fa-link fa-fw"></i></span> <input name="history_url[]" type="url" class="form-control" value="" placeholder="Link xem chi tiết"> </div> </div> </div> </div> <a class="btn btn-danger btn-xs deletebox2" style="position: absolute; top:0; right:0">X</a> </div>';
                                    $(this).before(boxhtml);
                                });                                
                            });
                        </script>
                    </div>

                    <div id="contact">
                        <hr><h4 class="text-center"><span style="border-bottom:2px solid red">LIÊN HỆ</span></h4>
                        <div class="form-group text-center">                            
                            <input type="radio" name="show_contact" value="1" <?php echo $resume->show_contactUs == 1 ? 'checked' : '' ?>> Hiện
                            &nbsp;
                            <input type="radio" name="show_contact" value="0" <?php echo $resume->show_contactUs == 0 ? 'checked' : '' ?>> Ẩn 
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" ><i class="fa fa-facebook fa-fw"></i></span>                            
                                        <input name="facebook" type="url" class="form-control"  value="<?php echo $resume->facebook ?>"  placeholder="https://www.facebook.com/">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" ><i class="fa fa-twitter fa-fw"></i></span>                            
                                        <input name="twitter" type="url" class="form-control" value="<?php echo $resume->twitter ?>"  placeholder="http://twitter.com/">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" ><i class="fa fa-google-plus fa-fw"></i></span>                            
                                        <input name="google" type="url" class="form-control" value="<?php echo $resume->google ?>"  placeholder="https://plus.google.com/">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                Chọn mẫu hiển thị hồ sơ:
                                <select id="displaystyle" name="style" class="form-control">
                                    <option value="0" <?php echo $resume->style == 0 ? "selected" : "" ?>> Mẫu hồ sơ mặc định</option>			
                                    <option value="1" <?php echo $resume->style == 1 ? "selected" : "" ?>> Mẫu hồ sơ 1</option>			
                                    <option value="2" <?php echo $resume->style == 2 ? "selected" : "" ?>> Mẫu hồ sơ 2</option>			
                                    <option value="3" <?php echo $resume->style == 3 ? "selected" : "" ?>> Mẫu hồ sơ lật trang</option>			
                                </select>
                            </div>	    
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group selectcolor">
                                Chọn  màu (chỉ có ở mẫu hồ sơ lật trang)<br>
                                <input name="color" type="color" value="<?php echo $resume->color ?>">
                            </div>               
                        </div>	    
                    </div>
					
                    <div class="buttonsubmit" style="padding: 20px 0; background: #f9f9f9; border-top:1px solid #ddd;">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12 col-md-offset-3">
                                <input type="hidden" value="update" name="updateinfo" />
                                <button type="submit" class="btn btn-azibai btn-block"><i class="fa fa-floppy-o fa-fw"></i> Cập nhật</button>                   
                            </div>   
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a target="_blank" class="btn btn-default btn-block" href="/profile/<?php echo $resume->userid ?>/<?php echo RemoveSign($resume->fullname) ?>"><i class="fa fa-eye fa-fw"></i> Xem danh thiếp</a>
                            </div>   
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<!--END LEFT-->

<?php $this->load->view('home/common/footer'); ?>
