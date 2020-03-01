<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
         <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                SẢN PHẨM ĐÃ CHỌN BÁN CỦA TÔI
            </h4>
             
             
            <?php if ($this->uri->segment(3) == 'products') {
                $col = 9;
            } else {
                $col = 10;
            } ?>
            
            <form name="frmAccountPro" id="frmAccountPro" action="<?php echo $link; ?>" method="post">                    
                <div class="panel panel-default">
                    <div class="panel-body">            
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <select name="product_type" id="product_type" class="form-control"
                                            style="width: 100%">
                                        <option <?php echo ($product_type == 0) ? 'selected = "selected"' : ''; ?>
                                            value="0">Sản phẩm
                                        </option>
                                        <?php if (serviceConfig == 1) { ?>
                                            <option <?php echo ($product_type == 1) ? 'selected = "selected"' : ''; ?>
                                                value="1">Dịch vụ
                                            </option>
                                        <?php } ?>
                                        <option <?php echo ($product_type == 2) ? 'selected = "selected"' : ''; ?>
                                            value="2">Coupon
                                        </option>
                                    </select>
                                </div>
                            </div>                                
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input
                                        class="inputfilter_account form-control" type="text"
                                        name="pro_name" value="<?php echo $pro_name; ?>" placeholder="Từ khóa ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <?php $priceType = array('1' => 'Giá', '2' => 'Hoa hồng (số tiền)', '3' => 'Hoa hồng(%)'); ?>
                                    <select name="price_type" class="form-control">
                                        <?php foreach ($priceType as $k => $val): ?>
                                            <option <?php echo $price_type == $k ? 'selected="selected"' : ''; ?>
                                                value="<?php echo $k; ?>"><?php echo $val; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <input placeholder="Từ" class="form-control" type="text" name="pf"
                                           value="<?php echo $price_form; ?>"/>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <input placeholder="Đến" class="form-control" type="text" name="pt"
                                           value="<?php echo $price_to; ?>"/>
                                </div>
                            </div>
<!--                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="garantee" id="garantee"
                                                   value="1" <?php if ($filter['garantee'] == 1) {
                                                echo 'checked="checked"';
                                            } ?> /> Gian hàng bảo đảm
                                        </label>
                                    </div>
                                </div>
                            </div>-->
                            <div class="col-sm-2 col-xs-12">                                    
                                <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
                                <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                                <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>                                   
                            </div>

                            <?php if ($show_btn == 1) { ?>
                                <div>
                                    <button id="pro_store" class="btn <?php if ($filter['no_store'] == 1) {
                                        echo 'btn-default';
                                    } else {
                                        echo 'btn-default1';
                                    } ?>" type="submit">Sản phẩm từ Gian hàng công ty bạn
                                    </button>
                                    <button id="pro_nostore" class="btn <?php if ($filter['no_store'] == 1) {
                                        echo 'btn-default1';
                                    } else {
                                        echo 'btn-default';
                                    } ?>" type="submit">Sản phẩm từ danh mục miễn phí và có phí
                                    </button>
                                </div>
                                <style>
                                    button.btn.btn-default:hover {
                                        cursor: auto;
                                        background: #f7f8f9;
                                    }
                                </style>
                            <?php } ?>
                        </div>                                
                    </div>
                </div>
                <div style="width:100%; overflow-y: auto;">
                <table class="table table-bordered afBox">

                    <?php if (count($products) > 0){ ?>
                    <thead>
                        <tr>
                            <th width="4%" class="aligncenter hidden-xs">STT</th>
                            <th width="15%" class="aligncenter hidden-xs">Sản phẩm</th>
                            <th width="20%" class="text-center  hidden-xs">Giá bán<br/>
                                <a href="<?php echo $sort['price']['asc'].$typesr; ?>">
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                         style="cursor:pointer;" alt=""/>
                                </a>
                                <a href="<?php echo $sort['price']['desc'].$typesr; ?>">
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                         style="cursor:pointer;" alt=""/>
                                </a>
                            </th>
                            <th class="text-center  hidden-xs">Sản phẩm của Gian hàng<br/>
                                <a href="<?php echo $sort['shop']['asc'].$typesr; ?>">
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                         style="cursor:pointer;" alt=""/>
                                </a>
                                <a href="<?php echo $sort['shop']['desc'].$typesr; ?>">
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                         style="cursor:pointer;" alt=""/>
                                </a>
                            </th>
                            <th width="15%" class="aligncenter hidden-xs">Đường dẫn</th>
                            <th width="10%" class="aligncenter hidden-xs">Chọn bán</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $group_id = (int)$this->session->userdata('sessionGroup');
                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    $domainName = $_SERVER['HTTP_HOST'];
                    foreach ($products as $k => $product):
                        $stt++;
                        $link_shop = $protocol . $product->sho_link . '.' . $domainName;
                        if ($product->domain != '') {
                            $link_shop = $protocol . $product->domain;
                        }
                        if ($product->pro_type == 0) {
                            $pro_type = 'product';
                        }
                        else{
                            if ($product->pro_type == 2) {
                                $pro_type = 'coupon';
                            }
                        }
                        ?>
                        <!-- BEGIN:: Modal -->
                        <div class="modal fade prod_detail_modal" id="myModal<?php echo $k; ?>" tabindex="-1"
                             role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-times-circle text-danger"></i></button>
                                        <h4 class="modal-title" id="myModalLabel">Chi tiết sản phẩm</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-4">Tên SP:</div>
                                            <div class="col-lg-9 col-xs-8"><?php echo $product->pro_name; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-4">Giá SP:</div>
                                            <div class="col-lg-9 col-xs-8"><span
                                                    class="product_price"><?php echo number_format($product->pro_cost, 0, ",", ".") . ' VND'; ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-4">Hoa hồng</div>
                                            <div class="col-lg-9 col-xs-8">
                                            <span class="product_price_green">
                                                <?php
                                                if ($product->af_rate > 0) {
                                                    echo $product->af_rate . '%';
                                                } elseif ($product->af_amt > 0) {
                                                    echo number_format($product->af_amt, 0, ',', '.');
                                                } else {
                                                    echo "";
                                                }
                                                ?>
                                            </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-4">Gian hàng:</div>
                                            <div class="col-lg-9 col-xs-8"> <?php echo $product->nameshop; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-4">Chọn bán:</div>
                                            <div class="col-lg-9 col-xs-8">
                                                <?php if ($product->isselect == true): ?>
                                                    <a class="chooseItem selected" href="javascript:void(0);"
                                                       title="Hủy chọn bán"><img
                                                            src="<?php echo base_url(); ?>templates/home/images/public.png"
                                                            style="cursor:pointer;" border="0"
                                                            alt="Hủy chọn bán"/></a>
                                                <?php else: ?>.
                                                    <a class="chooseItem" href="javascript:void(0);"
                                                       title="Chọn bán"><img
                                                            src="<?php echo base_url(); ?>templates/home/images/unpublic.png"
                                                            style="cursor:pointer;" border="0"
                                                            alt="Chọn bán"/></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END :: Modal -->


                        <tr id="af_row_<?php echo $product->pro_id; ?>">
                            <td class="aligncenter hidden-xs">
                                <?php echo $stt + $num; ?>
                            </td>
                            <td class="img_prev text-center">
                                <?php $proimg = explode(',', $product->pro_image);
                                $filename = $imglager = 'media/images/product/' . $product->pro_dir . '/thumbnail_3_' . $proimg[0];
                                if ($proimg[0] != '') { //file_exists($filename) && 
                                    ?>
                                    <a rel="tooltip" data-placement="auto right" data-toggle="tooltip"
                                       data-html="true"
                                       data-original-title="<img src='<?php echo DOMAIN_CLOUDSERVER . $imglager; ?>' />">
                                        <img width="225" src="<?php echo DOMAIN_CLOUDSERVER . $filename ?>" alt=""
                                             class="img-responsive" style="margin:0 auto;">
                                    </a>
                                <?php } else {
                                    ?>
                                    <img width="225" src="<?php echo base_url(); ?>media/images/noimage.png" alt="">
                                <?php } ?>
                                <p><a target="_blank"
                                      href="<?php echo $link_shop.'/shop/'.$pro_type ?>/detail/<?php echo $product->pro_id; ?>/<?php echo RemoveSign($product->pro_name); ?>"><?php echo $product->pro_name; ?></a>
                                </p>
                                <span
                                    class="product_price visible-xs"><?php echo number_format($product->pro_cost, 0, ",", ".") . ' Vnđ'; ?></span>
                                <p class="visible-xs">Hoa hồng: <span class="product_price_green">
                                                            <?php if ($product->af_amt > 0) {
                                echo number_format($product->af_amt, 0, ',', '.') . ' Vnđ';
                            } elseif ($product->af_rate > 0) {
                                echo $product->af_rate . '%';
                            } ?>
                                                                    </span>
                                </p>
                                <div class="visible-xs">
                                    <?php if ($product->pro_user != $parent_shop) { ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/public.png"
                                             onclick="CancelSelectProSale(<?php echo $product->pro_id; ?>);"
                                             style="cursor:pointer;" border="0" alt="Hủy chọn bán"/>
                                    <?php } ?>
                                    <p class="hidden-md hidden-lg">
                                        <button type="button" class="btn btn-default" data-toggle="modal"
                                                data-target="#myModal<?php echo $k; ?>">
                                            <i class="fa fa-newspaper-o"></i> Chi tiết
                                        </button>
                                    </p>
                                </div>
                            </td>
                            <td align="left" class="hidden-xs">
                                <span
                                    class="product_price"><?php echo number_format($product->pro_cost, 0, ",", ".") . ' Vnđ'; ?></span>
                                <p>Hoa hồng: <span class="product_price_green">
                                                                    <?php
                                    if ($product->af_amt > 0) {
                                        echo number_format($product->af_amt, 0, ',', '.') . ' Vnđ';
                                    } elseif ($product->af_rate > 0) {
                                        echo $product->af_rate . '%';
                                    }
                                    ?> 
                                                                    </span>
                                </p>
                            </td>
                            <td class="hidden-xs">
                                <a target="_blank"
                                   href="<?php echo $link_shop; ?>/shop"><?php echo $product->sho_name; ?></a>
                            </td>
                            <?php if ($pro_type == 0) {
                                $prtype = 'product';
                            } else {
                                $prtype = 'coupon';
                            }
                            ?>
                            <td class="hidden-xs">
                                <a href="javascript:void(0);" onclick="copylink('<?php echo $link_shop . "/shop/" . $prtype . "/detail/" . $product->pro_id . "/" . RemoveSign($product->pro_name) . "?af_id=" . $setAfKey; ?>');">Copy
                                    Link</a>
                            </td>
                            <td class="hidden-xs">
                                <?php if ($product->pro_user != $parent_shop) { ?>
                                    <img src="<?php echo base_url(); ?>templates/home/images/public.png"
                                         onclick="CancelSelectProSale(<?php echo $product->pro_id; ?>)"
                                         style="cursor:pointer;" border="0" alt="Hủy chọn bán"/>
                                <?php } ?>
                                <p class="hidden-md hidden-lg">
                                    <button type="button" class="btn btn-default1" data-toggle="modal"
                                            data-target="#myModal<?php echo $k; ?>">
                                        <i class="fa fa-newspaper-o"></i>
                                    </button>
                                </p>
                                <p class="hidden-md hidden-lg">
                                    <a href="javascript:void(0);"
                                       onclick="copylink('<?php echo base_url() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '?af_id=' . $this->_afKey; ?>');">Copy
                                        Link</a>
                                </p>
                            </td>
                            <?php if ($this->uri->segment(3) == '___myproducts') : ?>
                                <td>
                                    <?php if ($product->homepage == 0) { ?>
                                        <span
                                            onclick="Showhomepage('<?php echo base_url(); ?>', 1,<?php echo $product->product_id; ?>);"
                                            class="notishome btn btn-primary"><i class="fa fa-plus"></i></span>
                                    <?php } else { ?>
                                        <span
                                            onclick="Showhomepage('<?php echo base_url(); ?>', 0,<?php echo $product->product_id; ?>);"
                                            class="ishome btn btn-primary"><i class="fa fa-check"></i></span>
                                    <?php } ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="<?php echo $col; ?>" align="center">
                                <?php if ($this->uri->segment(3) == 'products') { ?>
                                    <?php if ($filter['no_store'] == 1) { ?>
                                        <div class="nojob alert alert-info">Không có sản phẩm nào!

                                        </div>
                                    <?php } else { ?>
                                        <div class="nojob alert alert-info">Không còn sản phẩm nào từ Gian hàng công
                                            ty bạn!
                                            <br> Bạn có thể chọn thêm sản phẩm từ 1 Danh mục miễn phí Azibai tặng
                                            bằng cách click vào <b>"Sản phẩm từ danh mục miễn phí và có phí"</b> ở
                                            phí trên.
                                            <br/>Hoặc bạn có thể mua thêm dịch vụ Kệ hàng trong phần <a
                                                href="<?php echo base_url(); ?>account/service">Dịch vụ Azibai</a>
                                            để có thể gắp thêm sản phẩm từ nhiều Danh mục khác.
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($this->uri->segment(3) == 'myproducts') { ?>
                                    <div class="nojob alert alert-info">Không có sản phẩm nào!

                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                </div>
            </form>
            <?php echo $pager; ?>

            <div class="noshop" style="display:none;">
                Bạn chưa cài đặt Gian hàng, vui lòng cài đặt <a href="<?php echo base_url(); ?>account/shop">tại đây</a>
                để sử dụng tính năng này.
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
<script>
    function CancelSelectProSale(id_pro) {
        jQuery.ajax({
            type: "POST",
            url: siteUrl + "home/affiliate/ajax_cancel_select_pro_sales",
            dataType: 'text',
            data: {id_pro: id_pro},
            success: function (res1) {
                console.log(res1);
                if (res1 == '1') {
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra!');
                }
            }
        });
    }
</script>
<?php if ($this->uri->segment(3) == 'products') { ?>
    <script>
        jQuery(document).ready(function (jQuery) {
            $("#pro_nostore").click(function (ev) {
                $("#pro_store").removeClass('btn-default1');
                $(this).addClass('btn-default1');
                var ischeck = $('#no_store').attr('disabled');
                $('#no_store').prop('checked', true);
            });
            $("#pro_store").click(function () {
                $("#pro_nostore").removeClass('btn-default1');
                $(this).addClass('btn-default1');
                $('#no_store').prop('checked', false);
            });
            var dem_pro = 0;
            $('.chooseItem').click(function () {
                dem_pro++;
                if (dem_pro == 1) {
                    $('#no_store').removeAttr('disabled');
                    if ($('#no_store').attr('disable') == false) {
                        $.jAlert({
                            'title': 'Thông báo!',
                            'content': 'Azibai tặng bạn thêm 1 Danh mục, bạn có thể gắp thêm 8 sản phẩm trong đó!',
                            'theme': 'default',
                            'btns': {
                                'text': 'Đóng', 'theme': 'blue', 'onClick': function (e, btn) {
                                    e.preventDefault();
                                    $('#no_store').focus();
                                    dem_pro = 0;
                                    return false;
                                }
                            }
                        });
                    }
                }
            });
        });
    </script>
<?php } ?>
