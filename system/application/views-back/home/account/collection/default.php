<?php $this->load->view('home/common/header'); ?>
<div class="clearfix"></div>
<div id="product_content" class="container-fluid">
    <div class="row">
    <?php $this->load->view('home/common/left');
    $url = $this->uri->segment(3);
    if (($url && $url !='' && $url =='service') || ($url && $url !='' && $url =='coupon')){
        $search  = $url.'/';
    }else{
        $url1 = '';
    }
        $url1 = '/'.$url;
    ?>

    <link type="text/css" href="<?php echo base_url(); ?>templates/home/css/datepicker.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>
    <style type="text/css">
        .fa-spinner {
            font-size: 17px;
            display: none;
        }
    </style>
    <!--BEGIN: RIGHT-->
    <div class="col-md-9 col-sm-8 col-xs-12">
        <?php
            if($flash_message){
            ?>
                <div class="message success" >
                    <div class="alert alert-warning">
                        <?php echo $flash_message; ?>
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                </div>
            <?php
            }
        ?>
        <?php
            if($flash_msg_error){
            ?>
                <div class="message success" >
                    <div class="alert alert-danger">
                        <?php echo $flash_msg_error; ?>
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                </div>
            <?php
            }
        ?>
        <h4 class="page-header text-uppercase" style="margin-top:10px">Danh sách bộ sưu tập</h4>

            <div class="panel panel-default">                    
                <div class="panel-body">
                    <form class="searchBox" method="post" action="<?php echo base_url() . 'account/collection'; ?>" class="">
                        <div class="row">
                            <div class="col-md-5 col-sm-7">
                                <div class="input-group">
                                    <input type="text" required="" placeholder="Nhập bộ sưu tập cần tìm" name="keyword"  id="keyword_account" value="<?php
                                    if (isset($keyword)) {
                                        echo $keyword;
                                    } ?>" maxlength="100" class="form-control" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" onKeyPress="return submitenterQ(this,event,'<?php echo base_url(); ?>')" />
                                    <span class="input-group-btn">
                                        <button type="submit" name="search" class="btn btn-azibai"> <i class="fa fa-search"></i> </button>
                                    </span>    
                                </div>
                            </div>                                 
                            <div class="visible-xs" style="height:15px"></div>
                            <div class="col-md-3 col-sm-5" style="float: right;">
                                <?php
                                if ($url == 'coupon') {
                                    $url_post = 'account/product/coupon/post';
                                }
                                if ($url == 'product') {
                                    $url_post = 'account/product/product/post';
                                }
                                ?>
                                <a href="#<?php //echo base_url() . 'account/collection/add' ?>" data-toggle="modal" data-target="#box_collection" class="btn btn-success btn-block" onclick="ajaxpro('<?php echo base_url(); ?>',0)"><i class="fa fa-plus"></i> 
                                    Tạo bộ sưu tập
                                </a>
                                <input type="hidden" name="collection_id" id="collection_0" value="0" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <?php
                if(count($collection) > 0){?>
                <?php
                    foreach ($collection as $k => $value){
                ?>
                    <div class="col-md-3">
                        <div class="item">
                            <div class="image">
                                <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/collection/' . $value->collection_image; ?>" alt="<?php echo $value->collection_name; ?>">
                            </div>
                            <div class="name col-md-12" style="padding: 6px 10px; border-bottom: 1px solid #ccc;">
                                <?php echo $value->collection_name; ?>
                            </div>
                            <div class="col-md-12">
                                Ngày tạo: <div class="float-right" style="float:right"><?php echo date('d/m/Y',$value->collection_date); ?></div>
                            </div>
                            <div class="col-md-12">
                                Tình trạng: 
                                <div class="float-right" style="float:right">
                                    <?php if( $value->collection_status == 1 ){ ?>
                                        <img src="<?php echo base_url(); ?>templates/admin/images/active.png" onclick="ActionLink('<?php echo base_url(); ?>account/collection/status/deactive/id/<?php echo $value->collection_id; ?>')" style="cursor:pointer;" border="0" title="Ngưng kích hoạt">
                                        <label>Hiển thị</label>
                                    <?php } else{ ?>
                                        <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" onclick="ActionLink('<?php echo base_url(); ?>account/collection/status/active/id/<?php echo $value->collection_id; ?>')" style="cursor:pointer;" border="0" title="Ngưng kích hoạt">
                                        <label>Ẩn</label>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                Tổng sản phẩm: 
                                <div class="float-right" style="float:right"><?php echo count(explode(',',$value->collection_proid)); ?></div>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="btn">
                                    <a href="#" data-toggle="modal" data-target="#box_collection" class="btn btn-success btn-block" onclick="ajaxpro('<?php echo base_url(); ?>',<?php echo $value->collection_id; ?>)">
                                        <i class="fa fa-pencil-square-o fa-fw"></i>
                                    </a>
                                    <input type="hidden" name="collection_id" id="collection_<?php echo $value->collection_id; ?>" value="<?php echo $value->collection_id; ?>" />
                                </div>
                                <div class="btn">
                                    <a href="#" onclick="delcollection(<?php echo $value->collection_id; ?>);" class="btn btn-block btn-del"><i class="fa fa fa-trash-o fa-fw"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                ?>
                <?php
                    }else{
                        echo '<div class="text-center">Bạn chưa tạo bộ sưu tập nào</div>';
                    }
                ?>
            </div>
<style>
    .item {
        border: 1px solid #ddd;
        overflow: hidden;
        padding: 5px;
        background: #fff;
    }
    .item::before {
        position: absolute;
        width: 69%;
        height: 96%;
        content: '';
        transform: rotate3d(-8,-3,1, -24deg);
        left: 33%;
        top: 0%;
        background: #e2e2df;
        z-index: -3;
        border-bottom: 2px solid #9c9c9c;
        background: linear-gradient(to bottom right, #eae8e8, #bdbcbc);
    }
    .item::before {
        position: absolute;
        width: 66%;
        height: 92%;
        content: '';
        transform: rotate3d(-8,-3,1, 0deg);
        left: 33%;
        top: 4%;
        background: #e2e2df;
        z-index: -3;
        border: 1px solid #bbb;
        border-bottom: 2px solid #9c9c9c;
        background: linear-gradient(to bottom right, #eae8e8, #b1abab);
    }
    .item::after {
        position: absolute;
        width: 90%;
        height: 85%;
        content: '';
        /* transform: rotate3d(2, -2, -1, -70deg); */
        bottom: 7%;
        right: -1%;
        z-index: -4;
        border-top: 1px solid #a8a6a6;
        background: linear-gradient(to bottom right, #d4cfcf, #9e9c9c);
    }
    .image img {
        max-width: 100%;
    }
    .btn .btn-success{
        background-color: #4e58c1;
        border-color: #4e58c1;
    }
    .btn .btn-del, .btn-del:hover {
        border: 1px solid #ea4646;
        background: #ea4646;
        color: #fff;
    }
</style>
        </div>
    </div>
</div>

<link rel="stylesheet" href="/templates/home/css/jupload-crop-images/style.css" type="text/css"/>
<link type="text/css" rel="stylesheet" href="/templates/home/css/owl.carousel.min.css"/>
<script language="javascript" src="<?php echo base_url() ?>templates/home/js/jupload-crop-images/jquery.Jcrop.min.js"></script>
<script language="javascript" src="<?php echo base_url() ?>templates/home/js/jupload-crop-images/script.js"></script>
<script src="/templates/home/js/owl.carousel.js" ></script>

<style>
    .owl-carousel .owl-item img {
        display: inline-block !important;
    }
    #box_collection{
        z-index: 1220;
    }
    #collection{
        background: #fff;
        width: 80%;
        padding: 20px;
    }
    .btnsave{
        border: 1px solid;
        color: #fff;
        background-color: #4267b2;
        border-color: #4267b2;
    }
    .btncancel{
        border: 1px solid #ddd;
    }
    .fadeInUp {
        margin-top: 15% !important;
    }
    button.owl-dot {
        padding: 10px !important;
        border-radius: 50%;
    }
    button.owl-dot.active {
        background: #8e8989;
    }
    .table>thead>tr>th, .table>tbody>tr>td {
        vertical-align: middle;
    }
</style>
<script>
function ajaxpro(baseUrl, id, sr = ''){
    var collection_id = $('#collection_'+id).val();
    $('#collid').val(collection_id);
    $.ajax({
        type: 'post',
        url: baseUrl+'home/account/procoll',
        data: {collection_id: collection_id},
        success: function (data) {
            var json = JSON.parse(data);
            $('.box_pro.add').fadeIn();
            $('.listpro #tbtitle').html(json.tbtitle);
            
            var name = json.collect.collection_name;
            var status = json.collect.collection_status;
            var desc = json.collect.collection_desc;
            $('#collection_name').val(name);
            $('#collection_desc').val(desc);
            if(status == 1){
                $('#collection_status').attr('checked','checked');
            }
            if(json.total > 20){
                $('.listpro #carouseltb').html(json.html);
                $('.product-owl-carousel-2').owlCarousel({ loop:true, responsiveClass:true, nav:true, responsive:{ 0:{ items:1, margin:0 }, 600:{ items:1, margin:0 }, 1000:{ items:1, margin:0 } } });
                $('.owl-prev').click(function(e){
                    e.preventDefault();
                });
                $('.owl-next').click(function(e){
                    e.preventDefault();
                });
            }else{
                $('.listpro #slidepro').html(json.html);
            }
        },
        error: function (data) {
            alert('Error');
        }
    });
    
}

function slsearch(baseUrl,value, sl){
    var coll_id = $('#collid').val();
    var data;
    if(sl == 'srprotype'){
        $('#srprotype').val(value);
        data = {collection_id: coll_id, protype: value, srsaleoff: $('#srsaleoff').val(), sraff: $('#sraff').val(), srcat: $('#srcat').val()};
    }else{
        if(sl == 'srsaleoff'){
            $('#srsaleoff').val(value);
            data = {collection_id: coll_id, protype: $('#srprotype').val(), srsaleoff: value, sraff: $('#sraff').val(), srcat: $('#srcat').val()};
        }else{
            if(sl == 'sraff'){
                $('#sraff').val(value);
                data = {collection_id: coll_id, protype: $('#srprotype').val(), srsaleoff: $('#srsaleoff').val(), sraff: value, srcat: $('#srcat').val()};
            }else{
                $('#srcat').val(value);
                data = {collection_id: coll_id, protype: $('#srprotype').val(), srsaleoff: $('#srsaleoff').val(), sraff: $('#sraff').val(), srcat: value};
            }
        }
    }
    
    $.ajax({
        type: 'post',
        url: baseUrl+'home/account/procoll',
        data: data,
        success: function (data) {
            var json = JSON.parse(data);
            $('#carouseltb').owlCarousel({ loop:true, responsiveClass:true, nav:true, responsive:{ 0:{ items:1, margin:0 }, 600:{ items:1, margin:0 }, 1000:{ items:1, margin:0 } } }).trigger('replace.owl.carousel',json.html).trigger('refresh.owl.carousel');
            
            $('.owl-prev').click(function(e){
                e.preventDefault();
            });
            $('.owl-next').click(function(e){
                e.preventDefault();
            });
        },
        error: function (data) {
            alert('Error');
        }
    });
}

function checkcollection(){

    if($('#collection_name').val() == ''){
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn chưa nhập tên bộ sưu tập!',
            'theme': 'blue',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                   e.preventDefault();
                   return false;
                }
            }
        });
        return false;
    }

    var check = '';
    $("input[type=checkbox]").each(function(){
        if($(this).is(":checked")){
            check = $(this).val();
        }
    });
    if(check != ''){
    }else{
        $('.btnsave').attr('type','button');
        $.jAlert({
             'title': 'Thông báo',
             'content': 'Bạn phải chọn sản phẩm để thêm vào bộ sưu tập!',
             'theme': 'blue',
             'btns': {
                 'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    return false;
                 }
             }
        });
        return false;
    }
    $('.btnsave').attr('type','submit');
    location.reload();
}

function delcollection(idcoll){
    confirm(function (e, btn) {
	e.preventDefault();
        $.ajax({
            type: 'post',
            url: '/home/account/delcoll',
            data: {collid: idcoll},
            success: function (data) {
               if(data == 1){
                   location.reload();
               }
            },
            error: function (data) {
                alert('Error');
            }
        });
    });
}
$(document).ready(function(){
    $("#box_collection").on("hidden.bs.modal", function () {
        location.reload();
    });
});

</script>

<div class="modal" id="box_collection" tabindex="" role="dialog" aria-labelledby="">
    <div class="modal-dialog" id="collection" role="document">
        <form name="frmCollection" action="" id="frmCollection" method="post">
            <div class="box_pro">
                <label class="text-uppercase" style="font-size: 18px;">Tạo bộ sưu tập</label>
                <hr/>
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" required="" style="width: 90%; padding: 5px 8px;" placeholder="Tạo tên bộ sưu tập" name="collection_name"  id="collection_name"/>
                    </div>
                    <div class="col-md-2">
                        <span class="" style="font-size: 18px;">Kích hoạt</span>
                        <input type="checkbox" name="collection_status" id="collection_status" value="1"/>
                    </div>
                    <div class="col-md-2" style="text-align: right;">
                        <button action="button" class="btnsave" type="button" name="btnsave" onclick="checkcollection()" value="1">Lưu</button>
                        <button action="button" class="btncancel" type="button" data-dismiss="modal">Hủy</button>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-md-5">
                        <input type="file" name="image" id="image" class="inputimage_formpost"/>
                        <img style="height:116px; margin-top: 15px" id="img" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview">
                    </div>
                    <div class="col-md-6">
                        <textarea name="collection_desc" id="collection_desc" style="width: 100%; padding: 5px 10px; resize: none" rows="6" placeholder="Nhập mô tả cho bộ sưu tập"></textarea>
                    </div>
                </div>
            </div>
            <script>
                $('[type="file"]').change(showPreviewImage_click);
                function showPreviewImage_click(e) {
                    var $input = $(this);
                    var inputFiles = this.files;
                    if(inputFiles == undefined || inputFiles.length == 0) return;
                    var inputFile = inputFiles[0];

                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $input.next().attr("src", event.target.result);
                    };
                    reader.onerror = function(event) {
                        alert("I AM ERROR: " + event.target.error.code);
                    };
                    reader.readAsDataURL(inputFile);
                }
            </script>
            <hr/>
            <div class="box_pro add" style="display:none;">
                <label class="text-uppercase" style="font-weight:100;">Danh sách sản phẩm đã được tạo</label>
                <div class="row">
                    <input type="hidden" name="collid" id="collid" value="" />
                    <input type="hidden" name="" id="srprotype" value="" />
                    <input type="hidden" name="" id="srsaleoff" value="" />
                    <input type="hidden" name="" id="sraff" value="" />
                    <input type="hidden" name="" id="srcat" value="" />
                    <div class="col-md-3">
                        <select id="" class="form-control form_control_cat_select" onchange="slsearch('<?php echo base_url(); ?>', this.value, 'srprotype');">
                            <option value="">--Lọc theo--</option>
                            <option value="0">Sản phẩm</option>
                            <option value="2">Coupon</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="" class="form-control form_control_cat_select" onchange="slsearch('<?php echo base_url(); ?>', this.value, 'srsaleoff');">
                            <option value="">--Lọc theo--</option>
                            <option value="1">SP có khuyến mãi</option>
                            <option value="2">SP không có khuyến mãi</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="" class="form-control form_control_cat_select" onchange="slsearch('<?php echo base_url(); ?>', this.value, 'sraff');">
                            <option value="">--Lọc theo--</option>
                            <option value="1">Sản phẩm cho cộng tác viên bán</option>
                            <option value="2">Sản phẩm không cho cộng tác viên bán</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="" class="form-control form_control_cat_select" onchange="slsearch('<?php echo base_url(); ?>', this.value, 'srcat');">
                            <option value="">--Lọc theo danh mục--</option>
                            <?php 
                            foreach ($cat as $value){
                                echo '<option value="'.$value->cat_id.'">'.$value->cat_name.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="listpro" style="overflow: auto; margin-top: 20px;">
                    <div id="tbtitle"></div>
                    <div id="slidepro">
                        <div class="product-owl-carousel-2 owl-carousel" id="carouseltb"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--END RIGHT-->

<?php $this->load->view('home/common/footer'); ?>
