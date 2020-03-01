<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-md-9 col-sm-8 col-xs-12 account_edit">                
                <h4 class="page-header text-uppercase" style="margin-top:10px">Danh sách đơn hàng tôi đã mua</h4>                
                <?php if (count($orders) > 0) { ?>
                <div class="panel panel-default">                    
                    <div class="panel-body">

                        <div class="form_seach_order">
                            <form class="form-inline searchBox" method="post" action="">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-barcode"></i>
                                    </span>
                                    <input class="form-control" type="text" name="order_id"
                                           value="<?php echo $params['order_id']; ?>"
                                           placeholder="Mã số đơn hàng ..."> 
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-azibai">Tìm kiếm</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                    <div id="order_list" class="list-group">
                                <?php
                                $tmp = 0;
                                $protocol = "http://"; //(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                                $duoi = '.' . $_SERVER['HTTP_HOST'] . '/';
                                foreach ($orders as $key => $order) {
                                    if ($tmp == $order->id) {
                                        $cls = 'item_group';
                                    }

                                    if ($order->pro_type == 2) {
                                        $pro_type = 'coupon';
                                    } else {
                                        if ($order->pro_type == 0) {
                                            $pro_type = 'product';
                                        }
                                    }
                                    $shop = $protocol . $order->sho_link . $duoi;
                                    if ($order->domain != '') {
                                        $shop = $protocol . $order->domain . '/';
                                    }
                                    ?>

                                    <div class="list-group-item <?php echo $cls ?>">
                                        <div class="row title_order_user">
                                            <div class="col-sm-3">Ngày mua: <?php echo date('d/m/Y', $order->date) ?>
                                            </div>
                                            <div class="col-sm-3">Tổng tiền: <span
                                                    style="color: #FF0000; font-weight: 600"><?php echo number_format($order->order_total, 0, '.', ','); ?>
                                                    đ</span></div>
                                            <div class="col-sm-3">Người nhận
                                                hàng: <?php echo $order->ord_sname; ?></div>
                                            <div class="col-sm-3">Mã đơn hàng:<a class="text-primary"
                                                                                 href="<?php echo base_url(); ?>account/user_order/<?php echo $order->id; ?>">
                                                    #<?php echo $order->id; ?>
                                                </a>
                                            </div>
                                        </div><!--End row1-->
                                        <div class="row">
                                            <div class="col-sm-9">                                                
                                                        <a class="menu_1" target="_blank" href="<?php echo $shop . 'shop/' . $pro_type . '/detail/' . $order->pro_id . '/' . RemoveSign($order->pro_name); ?>">
                                                            <?php
                                                            if ($order->shc_dp_pro_id > 0) {
                                                                $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $order->pro_dir . '/thumbnail_1_' . $order->dp_images;
                                                            } else {
                                                                $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $order->pro_dir . '/thumbnail_1_' . explode(',', $order->pro_image)[0];
                                                            }
                                                            if (explode(',', $order->pro_image)[0] != '' || $order->dp_images != '') { //file_exists($filename) && 
                                                                ?>
								<img width="50" class="pull-left" style="margin-right:10px" src="<?php echo $filename; ?>"/>
                                                            <?php } else { ?>
                                                                <img width="50" class="pull-left" style="margin-right:10px" src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                                            <?php } ?>
								
							    <?php echo $order->pro_name; ?>
                                                        </a> 
                                            </div>
                                            <div class="col-sm-3">
                                                <!-- <p>
                                                     <button class="btn btn-default btn-block">Hủy</button>
                                                 </p>-->
                                            </div>
                                            <div class="clearfix"></div>
                                        </div><!--End row2-->
                                        <?php if($this->uri->segment(3) != 'coupon'){?>
                                        <?php } ?>
                                        <div class="row bottom_row">
                                            <div class="col-sm-4"><p>Trạng thái đơn
                                                    hàng: <?php
                                                    switch ($order->order_status) {
                                                        case '01':
                                                            echo '<span class="label label-info">' . status_1 . '</span>';
                                                            break;
                                                        case '02':
                                                            if($this->uri->segment(3) == 'coupon') {
                                                                echo '<span class="label label-success">' . status_7 . '</span>';
                                                            }else {
                                                                echo '<span class="label label-success">' . status_2 . '</span>';
                                                            }
                                                           
                                                            break;
                                                        case '03':
                                                            echo '<span class="label label-primary">' . status_3 . '</span>';
                                                            break;
                                                        case '04':
                                                            echo '<span class="label label-primary">' . status_4 . '</span>';
                                                            break;
                                                        case '05':
                                                            echo '<span class="label label-primary">' . status_5 . '</span>';
                                                            break;
                                                        case '06':
                                                            echo '<span class="label label-primary">' . status_6 . '</span>';
                                                            break;
                                                        case '99':
                                                            echo '<span class="label label-danger">' . status_99 . '</span>';
                                                            break;
                                                        case '98':
                                                            echo '<span class="label label-primary">' . status_98 . '</span>';
                                                            break;
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php if (in_array($order->order_status, ['03', '05']) && $order->pro_type != 2) { ?>
                                                <p class="text-warning"><a target="_blank"
                                                            href="<?php echo base_url() . 'change-delivery?order_token=' . $order->order_token; ?>"><i
                                                                class="fa fa-warning"></i> Khiếu nại</a></p>
                                                    <?php } ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php if ($order->order_status == '01' && (int) $this->session->userdata('sessionGroup') == 1 && $order->pro_type == 0) { ?>
                                                    <p class="show_detail">
                                                        <a style="font-size: 13px; color: #f57420" class="text-warning"
                                                           href="<?php echo base_url(); ?>account/user_order/<?php echo $order->id; ?>">
                                                            <i class="fa fa-times"></i> Hủy đơn hàng
                                                        </a>
                                                    </p>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <p class="show_detail">
                                                    <a href="<?php echo base_url(); ?>account/user_order/<?php echo $order->id; ?>">
                                                        <i class="fa fa-angle-double-right"></i> Xem chi tiết đơn hàng
                                                    </a>
                                                </p>
                                            </div>
                                        </div><!--End row3-->
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?php if ($order->order_status == '98' && $order->order_coupon_code != '') { ?>
                                                    <?php if ($order->status_use == 0) { ?>
                                                        <a onclick="Action_apply(<?php echo $order->id; ?>)"
                                                           href="javascript:void(0)" class="btn btn-default1">
                                                            <i class="fa fa-check"></i> Xác nhận
                                                        </a>
                                                        <p><i>Xác nhận đồng ý sử dụng coupon này</i></p>
                                                    <?php } elseif ($order->status_use == 1) { ?>
                                                        <button type="button" class="btn btn-default">
                                                            <i class="fa fa-check"></i> Đã xác nhận
                                                        </button>
                                                    <?php } else { ?>
                                                        <p class="text-success"><b><i>Đã sử
                                                                    dụng: <?php echo date('d/m/Y : H:m:i', $order->change_status_date); ?></i></b>
                                                        </p>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <?php if($order->pro_type == 2) { ?>
                                                    Mã coupon:
                                                    <?php if ($order->order_status == '01' && $order->order_coupon_code == "" && $order->status_use == 0) { ?>
                                                        Chờ xác nhận
                                                        <?php
                                                    } elseif ($order->order_status == '98' && $order->order_coupon_code != "" && $order->status_use < 2) {
                                                        echo "<b>$order->order_coupon_code</b>";
                                                    } elseif ($order->order_status == '98' && $order->order_coupon_code != "" && $order->status_use == 2) {
                                                        echo '<span style="text-decoration: line-through; font-weight: 600">' . $order->order_coupon_code . '</span>';
                                                    }
                                                    ?>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-4"></div>

                                        </div>
                                        <?php if ($order->is_product_affiliate == 1 && $this->session->userdata('sessionGroup') == 1 || $this->session->userdata('sessionGroup') == 2) { ?>
                                            <div class="row ">
                                                <div class="col-sm-12">
                                                    <hr>
                                                    <div class="col-sm-1">
                                                        <span class="icon_circle"><i class="fa fa-shopping-cart"
                                                                                     aria-hidden="true"></i></span>
                                                    </div>
                                                    <div class="col-sm-11">

                                                        <b>Tham gia bán hàng cùng Azibai:</b>
                                                        <p style="margin: 0">Giới thiệu bán thành công sản phẩm này đến
                                                            người khác. Bạn sẽ nhận được hoa
                                                            hồng <?php
                                                            if ($order->af_amt > 0) {
                                                                echo number_format($order->af_amt, 0, ',', ',');
                                                            } else {
                                                                echo number_format(($order->af_rate * $order->pro_cost) / 100, 0, ',', ',');
                                                            }
                                                            ?> đ
                                                            <a id="click_show_faq"
                                                               style="padding-left: 20px; font-weight: 600"
                                                               onclick="Showdetail(<?php echo $order->id; ?>)"
                                                               class="text-primary" href="javascript:void(0)"><i
                                                                    class="fa fa-angle-double-right"
                                                                    aria-hidden="true"></i> Xem hướng dẫn</a></p>
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                    <div id="show_faq_all_<?php echo $order->id; ?>"
                                                         class="col-sm-11 show_faq_all">
                                                             <?php if ($this->session->userdata('sessionGroup') == 1) { ?>
                                                            <div id="show_faq">
                                                                <p>Bạn đang sử dụng tài khoàn người mua hàng trên
                                                                    Azibai. Tài khoản của bạn không có chức năng bán
                                                                    hàng</p>
                                                                <p>Để tham gia bán hàng online cùng Azibai. Click <a
                                                                        class="text-primary"
                                                                        href="<?php echo base_url() . 'account/affiliate/upgrade' ?>"><b>vào
                                                                            đây</b></a> để nâng cấp tài khoản Cộng Tác Viên Online MIỄN PHÍ</p>
                                                            </div>
                                                        <?php } elseif ($this->session->userdata('sessionGroup') == 2) { ?>
                                                            <p>Để tham gia bán hàng online cùng Azibai và nhận hoa hồng, bạn
                                                                chỉ cần coppy đường link bên dưới và gửi cho bạn bè.</p>
                                                            <p>Click <a target="_blank" class="text-primary"
                                                                        href="<?php echo base_url() . 'content/391' ?>"><b>vào
                                                                        đây</b></a> để tìm hiểu thêm chương trình Bán hàng
                                                                online của Azibai</p>
                                                            <?php $a = $order->pro_id; ?>
                                                            <textarea
                                                                class="form-control js-copytextarea<?php echo $a ?>"><?php echo base_url() . $order->pro_category . '/' . $order->pro_id . '/' . RemoveSign($order->pro_name) . '?af_id=' . $af_get_key->af_key; ?></textarea>
                                                            <div class="btncopy">

                                                                <input
                                                                    onclick="copyTextArea('<?php echo "js-copytextarea" . $a ?>');"
                                                                    name="copylink"
                                                                    class="js-textareacopybtn btn btn-primary" type="button"
                                                                    value="Copy Link"/>
                                                            </div>
                                                                <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div><!--End list-item-->
                                    <?php
                                    $tmp = $order->id;
                                    $cls = '';
                                }
                                ?>
                            </div>

                <div class="text-center">
                    <?php echo $linkPage; ?>
                </div>
                
                <?php } else { ?>
                    <div style="text-align:center; padding: 15px; border:1px solid #eee">Không có đơn hàng nào!</div>
                <?php } ?>
                 <br/>  
                
            </div>
        </div>
    </div>

    <script type="application/javascript">
        function copyTextArea(area) {
            var copyTextarea = document.querySelector('.' + area);
            copyTextarea.select();
            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                console.log('Copying text command was ' + msg);
            } catch (err) {
                console.log('Oops, unable to copy');
            }
        }
        jQuery(document).ready(function () {
//            $('#click_show_faq').click(function() {
//                $('#show_faq_all').slideToggle(500);
//            });
//            var copyTextareaBtn = document.querySelector('.js-textareacopybtn');
//            copyTextareaBtn.addEventListener('click', function(event) {
//                var copyTextarea = document.querySelector('.js-copytextarea');
//                copyTextarea.select();
//
//                try {
//                    var successful = document.execCommand('copy');
//                    var msg = successful ? 'successful' : 'unsuccessful';
//                    console.log('Copying text command was ' + msg);
//                } catch (err) {
//                    console.log('Oops, unable to copy');
//                }
//            });
        });
        function Showdetail(id) {
            $('#show_faq_all_' + id).slideToggle(500);
        }
    </script>
    <script>
        function Action_apply(id) {
            confirm(function (e1, btn) {
                e1.preventDefault();
                var url = '<?php echo base_url();?>account/user_order?apply=' + id;
                window.location.href = url;
            });
            return false
        }
    </script>
    <input id="baseUrl" type="hidden" value="<?php echo base_url() ?>"/>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<?php if (isset($successAddShowcart) && trim($successAddShowcart) != '') { ?>
    <script>
        alert('<?php echo $successAddShowcart; ?>');</script>
<?php } ?>