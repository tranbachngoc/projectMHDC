<?php $this->load->view('home/common/account/header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/jScrollPane.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/simplemodal.css" media='screen'/>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/simplemodal.js"></script>

<!--BEGIN: LEFT-->
<div id="main" class="container-fluid">
    <div class="row">
        <!--BEGIN: Left menu-->
        <?php if ($this->session->userdata('sessionUser') > 0 && $this->session->userdata('sessionGroup') == StaffStoreUser) {
            $this->load->view('home/common/left');
        } ?>
        <!--END-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">Coupon đã đăng</h4>
            <?php if($flash_msg_error){ ?>
            <div class="message success" >
                <div class="alert alert-danger">
                    <?php echo $flash_msg_error; ?>
                    <button type="button" class="close" data-dismiss="alert">×</button>
                </div>
            </div>
            <?php } ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="searchBox" id="searchBox" method="post" action="<?php echo getAliasDomain() ;?>account/emp-coupon">
                        <div class="row">
                            <div class="col-md-5 col-sm-7">
                                <div class="input-group">
                                    <input type="text" placeholder="Nhập tên Sản phẩm đã đăng cần tìm" name="keyword_account" id="keyword_account"
                                        maxlength="100" class="form-control" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)"
                                        onblur="ChangeStyle('keyword_account',2)" onkeypress="return submitenterQ(this,event,'<?php echo getAliasDomain() ;?>')">
                                    <span class="input-group-btn">
                                        <button type="submit" name="search" class="btn btn-azibai">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="visible-xs" style="height:15px"></div>
                            <div class="col-md-3 col-sm-5">
                                <a href="<?php echo getAliasDomain() ;?>account/product/coupon/post" class="btn btn-success btn-block">
                                    <i class="fa fa-plus"></i> Đăng Coupon</a>
                                <input type="hidden" name="search_account" id="search_account" value="name">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php if ($totalRecord > 0) { ?>
            <script type="text/javascript">
                function submitenterQ(myfield, e, baseUrl) {
                    var keycode;
                    if (window.event) keycode = window.event.keyCode;
                    else if (e) keycode = e.which;
                    else return true;

                    if (keycode == 13) {
                        if (document.getElementById('keyword_account').value != '') {
                            product_name = document.getElementById('keyword_account').value;
                        }
                        document.getElementByIds('searchBox').submit();
                    }
                    else
                        return true;
                };
            </script>

            <form name="frmAccountPro" id="frmAccountPro" method="post">
                <div style="overflow: auto">
                <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="40" class="text-center hidden-xs hidden-sm"><p>STT</p></th>
                            <th width="100" class="text-center">
                                <p>Hình ảnh</p>
                            </th>
                            <th width="200" class="text-center">
                                <div>
                                    <img style="cursor:pointer;" onclick="ActionSort('<?php echo getAliasDomain() . "account/$url2/search/$search_key/sort/name/asc/page/$page_num"; ?>')" alt="" src="http://azibai.xxx/templates/home/images/sort_asc.gif" border="0">
                                    <img style="cursor:pointer;" onclick="ActionSort('<?php echo getAliasDomain() . "account/$url2/search/$search_key/sort/name/desc/page/$page_num"; ?>')" alt="" src="http://azibai.xxx/templates/home/images/sort_desc.gif" border="0">
                                </div>
                                <p>Tên sản phẩm</p>
                            </th>
                            <th width="60" class="text-center hidden-xs hidden-sm">
                                <p>SL</p>
                            </th>
                            <th width="100" class="text-center">
                                <p>Giá</p>
                            </th>
                            <th width="" class="text-center hidden-xs hidden-sm">
                                <div>
                                    <img style="cursor:pointer;" onclick="ActionSort('<?php echo getAliasDomain() . "account/$url2/search/$search_key/sort/category/asc/page/$page_num"; ?>')" alt="" src="http://azibai.xxx/templates/home/images/sort_asc.gif" border="0">
                                    <img style="cursor:pointer;" onclick="ActionSort('<?php echo getAliasDomain() . "account/$url2/search/$search_key/sort/category/desc/page/$page_num"; ?>')" alt="" src="http://azibai.xxx/templates/home/images/sort_desc.gif" border="0">
                                </div>
                                <p>Danh mục</p>
                            </th>
                            <th width="" class="text-center hidden-xs hidden-sm">
                                <p>Nhân viên đăng</p>
                            </th>
                            <th width="" class="text-center hidden-xs hidden-sm">
                                <p>Cho CTV bán</p>
                            </th>
                            <th width="" class="text-center hidden-xs hidden-sm">
                                <p>Kích Hoạt</p>
                            </th>
                            <th width="" class="text-center hidden-xs hidden-sm">
                                <p>Thứ tự</p>
                            </th>
                            <th width="60">
                                <p>Chỉnh sửa</p>
                            </th>

                        </tr>
                    </thead>
                    <?php foreach ($product as $key => $item) { ?>

                    
                    <div class="modal fade prod_detail_modal" id="myModal<?php echo $key?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-times-circle text-danger"></i>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Chi tiết sản phẩm</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">sản phẩm:</div>
                                        <div class="col-lg-9 col-xs-8"><?php echo $item->pro_name; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Số lượng:</div>
                                        <div class="col-lg-9 col-xs-8"> <?php echo $item->pro_instock; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Giá sản phẩm:</div>
                                        <div class="col-lg-9 col-xs-8">
                                            <span class="product_price"><?php echo $item->pro_cost; ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Giảm giá:</div>
                                        <div class="col-lg-9 col-xs-8"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Danh mục:</div>
                                        <div class="col-lg-9 col-xs-8"><?php echo $item->cat_name; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Nhân viên đăng:</div>
                                        <div class="col-lg-9 col-xs-8"><?php echo $item->pro_user_up_by; ?></div>
                                        <?php if($item->pro_user_modified != '0') { ?>
                                        <div class="col-lg-9 col-xs-8">
                                            <p style="font-size:85%">
                                                <i>Ngày sữa: <?php echo $item->up_date; ?></i>
                                                <br>
                                                <i>Người sữa: <?php echo $item->pro_user_modified; ?></i>
                                            </p>
                                        </div>
                                        <?php } ?>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Ngày đăng:</div>
                                        <div class="col-lg-9 col-xs-8"><?php echo date('d-m-Y', $item->pro_begindate); ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Cho CTV bán:</div>
                                        <div class="col-lg-9 col-xs-8">
                                        <?php if($item->is_product_affiliate == 1) { ?>
                                            <img src="<?php echo getAliasDomain() ;?>templates/home/images/public.png" style="cursor:pointer;" border="0" title="Là sản phẩm Cộng Tác Viên Online" alt="Ngưng kích hoạt">
                                        <?php } else {?>
                                            <img src="<?php echo getAliasDomain() ;?>templates/home/images/unpublic.png" style="cursor:pointer;" border="0" title="Không phải sản phẩm Cộng Tác Viên Online" alt="Kích hoạt">
                                        <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Kích Hoạt:</div>
                                        <div class="col-lg-9 col-xs-8">
                                        <?php if($item->pro_status == 1) { ?>
                                            <img src="<?php echo getAliasDomain() ;?>templates/home/images/public.png" onclick="ActionLink('<?php echo getAliasDomain() ;?>account/product/coupon/status/deactive/id/<?php echo $item->pro_id ;?>')" style="cursor:pointer;" border="0" title="Ngưng kích hoạt" alt="Ngưng kích hoạt">
                                        <?php } else {?>
                                            <img src="<?php echo getAliasDomain() ;?>templates/home/images/unpublic.png" onclick="ActionLink('<?php echo getAliasDomain() ;?>account/product/coupon/status/active/id/<?php echo $item->pro_id ;?>')" style="cursor:pointer;" border="0" title="Kích hoạt" alt="Kích hoạt">
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                        <!-- Modal -->

                        <tbody>
                            <tr>
                                <td height="45" class="text-center hidden-xs hidden-sm"><?php echo $item->stt ;?></td>
                                <td class="img_prev text-center">
                                    <a rel="tooltip" data-toggle="tooltip" data-html="true" data-placement="auto right" data-original-title="<img src='<?php echo $item->src_img; ?>' />">
                                        <img width="80" src="<?php echo $item->src_img; ?>">
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" class="menu_1" href="<?php echo "$item->link_GH/shop/product/detail/$item->pro_id/$item->pro_name";?>">
                                        <?php echo $item->pro_name; ?> </a>
                                    <p style="font-size:85%">
                                        <i>Ngày đăng: <?php echo date('d-m-Y', $item->pro_begindate); ?></i>
                                        <br>
                                        <i>Lượt xem: <?php echo $item->pro_view; ?></i>
                                    </p>
                                </td>
                                <td class="text-center hidden-xs hidden-sm">
                                    <?php echo $item->pro_instock; ?> </td>
                                <td class="" style="text-align:right;">
                                    <span class="product_price"><?php echo $item->pro_cost; ?> đ</span>
                                </td>
                                <td class="text-center hidden-xs hidden-sm">
                                    <?php echo $item->cat_name; ?> </td>
                                <td class="text-center hidden-xs hidden-sm">
                                    <?php echo $item->pro_user_up_by; ?>
                                    <?php if($item->pro_user_modified != '0') { ?>
                                    <p style="font-size:85%">
                                        <i>Ngày sữa: <?php echo $item->up_date; ?></i>
                                        <br>
                                        <i>Người sữa: <?php echo $item->pro_user_modified; ?></i>
                                    </p>
                                    <?php } ?>
                                </td>
                                <td class="hidden-xs hidden-sm" style="text-align:center;">
                                    <?php if($item->is_product_affiliate == 1) { ?>
                                        <img src="<?php echo getAliasDomain() ;?>templates/home/images/public.png" style="cursor:pointer;" border="0" title="Là sản phẩm Cộng Tác Viên Online" alt="Ngưng kích hoạt">
                                    <?php } else {?>
                                        <img src="<?php echo getAliasDomain() ;?>templates/home/images/unpublic.png" style="cursor:pointer;" border="0" title="Không phải sản phẩm Cộng Tác Viên Online" alt="Kích hoạt">
                                    <?php } ?>                                
                                </td>
                                <td class="hidden-xs hidden-sm" style="text-align:center;">
                                    <?php if($item->pro_status == 1) { ?>
                                        <img src="<?php echo getAliasDomain() ;?>templates/home/images/public.png" onclick="ActionLink('<?php echo getAliasDomain() ;?>account/product/coupon/status/deactive/id/<?php echo $item->pro_id ;?>')" style="cursor:pointer;" border="0" title="Ngưng kích hoạt" alt="Ngưng kích hoạt">
                                    <?php } else {?>
                                        <img src="<?php echo getAliasDomain() ;?>templates/home/images/unpublic.png" onclick="ActionLink('<?php echo getAliasDomain() ;?>account/product/coupon/status/active/id/<?php echo $item->pro_id ;?>')" style="cursor:pointer;" border="0" title="Kích hoạt" alt="Kích hoạt">
                                    <?php } ?>
                                </td>
                                <td class="text-center  hidden-xs  hidden-sm">
                                    <input type="text" value="<?php echo $item->pro_order ;?>" onchange="Order_product(<?php echo $item->pro_id ;?>, this.value);" style="width: 40px">
                                </td>
                                <td class="text-center">
                                    <?php if($this->session->userdata('sessionUser') == $item->pro_user_up) { ?>
                                        <button type="button" class="btn btn-azibai" onclick="ActionLink('<?php echo getAliasDomain() ;?>account/product/coupon/edit/<?php echo $item->pro_id ;?>')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>

                                    <p class="hidden-md hidden-lg">
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal<?php echo $key?>">
                                            <i class="fa fa-newspaper-o"></i>
                                        </button>
                                    </p>
                                    <?php } ?>
                                </td>

                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>
            </form>
        </div>
        <div class="text-center">
            <?php echo $linkPage; ?>
        </div>
            <?php 
        } else { ?>
            <div style="text-align: center; padding: 10px; border:1px solid #eee;">Chưa có dữ liệu cho mục này.</div>
            <?php 
        } ?>
    </div>
</div>

<?php $this->load->view('home/common/footer'); ?>

<script language="javascript">
    function Order_product(pro_id, order){
       $("#iconload_"+pro_id).show();
        $.ajax({
            type: "post",
            url:"<?php echo base_url(); ?>" + 'home/account/order_pro',
            cache: false,
            data:{pro_id: pro_id, order: order},
            dataType:'text',
            success: function(data){
              if(data == '1'){
                  $("#iconload_"+pro_id).hide();
              }else{
                  errorAlert('Có lỗi xảy ra!');
              }
            }
        });
        return false;
    }
</script>