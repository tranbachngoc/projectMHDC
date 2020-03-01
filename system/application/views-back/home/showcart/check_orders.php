<?php $this->load->view('home/common/checkout/header'); ?>
<?php
    $sub_ = false;
    if(count(explode('.', $_SERVER['HTTP_HOST'])) == 3) $sub_ = true;
?>
<style>
    .status-orders-block {
        background: #fff !important;
    }

    .note {
        margin-bottom: 10px;
        background: #fff;
        padding: 10px;
        border: 1px solid #ccc;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    .note .title {
        font-size: 18px;
        text-transform: uppercase;
        text-align: center;
        color: green;
    }

    .status-orders-block .status-orders-left {
        background: none !important;
        padding: 0 !important;
    }

    .status-orders-left.col-sm-4 .rows1 {
        padding: 10px;
        background: rgba(255, 255, 255, 0.65);
        border-bottom: 1px solid #dadada;
    }

    .col_bottom {
        background: #fff;
        padding: 10px;
    }
</style>
<script>
    document.ready(function(){
        console.log(<?php echo 'k: '. $_SERVER['SERVER_NAME'] ?>);
    });
</script>
<link type="text/css" rel="stylesheet" href="<?php echo getAliasDomain(); ?>templates/home/css/orders_success.css"/>
<div class="container-fluid">
        <div class="row">            
            <?php /* <div class="col-lg-2 hidden-md hidden-sm hidden-xs <?php if($sub_ == true){ echo 'hidden';}else{echo '';} ?>">
                <?php $this->load->view('home/common/left_tintuc'); ?>
            </div> <div class="<?php if($sub_ == true){ echo 'col-lg-12';}else{echo 'col-lg-10'; } ?>"> */ ?>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="breadcrumbs hidden-xs">
                    <a href="<?php echo !empty($url_g_d2) ? getAliasDomain($url_g_d2) : getAliasDomain(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                    <span>Thông tin đơn hàng</span>
                </div>
                <?php
                if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')) {
                    ?>
                    <div class="message success">
                        <div
                            class="alert <?php echo($this->session->flashdata('flash_message_error') ? 'alert-danger' : 'alert-success') ?>">
                            <?php echo($this->session->flashdata('flash_message_error') ? $this->session->flashdata('flash_message_error') : $this->session->flashdata('flash_message_success')); ?>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php

                $protocol = 'http://';//(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                $domainName = $duoi = $_SERVER['HTTP_HOST'];
                //$shopLink = $protocol . $order[0]->sho_link .'.'. $duoi.'/';
                $arrUrl = explode('.', $domainName);
                if (count($arrUrl) === 3 && $arrUrl[1] == 'azibai') {
                    $url = $arrUrl[1] . '.' . $arrUrl[2];
                } else {
                    $url = $domainName;
                    //$linkpro = $protocol . $order[0]->sho_link .'.'. $duoi.'/';
                }
                /* if ($order[0]->domain != '') {
                    // $shopLink = $protocol . $order[0]->domain . '/';
                }*/
                if ($order[0]->product_type == 0) {
                    $type = 'product';
                } else {
                    if ($order[0]->product_type == 2) {
                        $type = 'coupon';
                    }
                }
                
                //get link pro
                $shopLink = $protocol . $domainName.'/';
                $shopHTai = $shopLink;
                $link_shop = $protocol.$order[0]->sho_link.'.'. $url.'/';
                if($order[0]->domain != ''){
                    $link_shop = $protocol.$order[0]->domain.'/';
                }
                
                $store = $link_shop;
                if ($arrUrl[0] == 'azibai') {
                    $sh = '';
                }else{
                    if ($order[0]->order_group_id != 0) {
                        $sh = 'grtshop';
                        $get_grt = $this->grouptrade_model->get('grt_link,grt_domain', 'grt_id = "' . (int)$order[0]->order_group_id . '"');
                        if($get_grt->grt_domain != "") {
                            $link_shop = $get_grt->grt_domain;
                        }else{
                            $link_shop = $get_grt->grt_link . '.' . $duoi;
                        }
                        //$shopHTai = $protocol . $domainName.'/';
                    }else{
                        $sh = 'shop';
                        //$link_shop = $protocol . $domainName.'/';
                    }
                    $link_shop = '/';
                }
                $linkSP = '/' . $sh . '/' . $type . '/detail/'; //$shopLink
                $passSession =$this->session->userdata('password');
                ?>
                <div class="note">
                    <div class="title">Chúc mừng bạn đã đặt hàng thành công</div>
                    <div class="huongdan">
                        <p>Để tiếp tục mua hàng hãy về <a href="<?php echo '/' . $sh; //$protocol . $domainName . ?>">shop mua
                                hiện tại</a></p>
                        <p>Kiểm tra đơn hàng của bạn trong tài khoản này:
                        <!-- <br/>-->
                            <span style="font-size: 14px">
                                Username: <strong><?php echo $order[0]->ord_semail; ?></strong>.
                            <?php if($passSession!=''){ ?>
                                Password: <strong><?php echo $passSession; ?></strong>
                            <?php } ?></span>
                            <a href="<?php echo $protocol . $url . '/login' ?>">tại đây</a>
<!--                            <ul style="list-style: none;">-->
<!--                                <li>Username: <strong>--><?php //echo $order[0]->ord_semail; ?><!--</strong>.</li>-->
<!--                                <li>Password: <strong>--><?php //echo $this->session->userdata('password'); ?><!--</strong></span></li>-->
<!--                            </ul><a href="--><?//= $protocol . $duoi . 'login' ?><!--">tại đây</a>-->
                        </p>
                    </div>
                </div>
                <div class="checkout-success ">
                    <div class="status-orders-block">
                        <div class="status-orders-left col-sm-4">
                            <div class="rows1">
                                <div class="tl">
                                    <a href="<?php echo '/print-order/' . $order[0]->id . '?order_token=' . $order[0]->order_token; ?>"><img
                                            src="<?php echo base_url() ?>templates/home/images/payment/print-icon.png"/></a>
                                </div>
                                <div class="tl"><span
                                        class="title">Chào bạn: </span><b><?php echo $order[0]->ord_sname; ?></b>
                                </div>
                                <div class="date-box">
                                    <span
                                        class="title"><b>Mã đơn hàng</b></span><span>: <?php echo $order[0]->order_id; ?></span><br/>
                                    <?php if ($order[0]->order_clientCode): ?>
                                        <span class="title"><b>Mã vận đơn</b></span><span>:
<!--                                            <a target="_blank" href="--><?php
//                                            if ($order[0]->shipping_method == 'GHN') {
//                                                echo clientOrderCode . $order[0]->order_clientCode;
//                                            } else {
//                                                echo clientVTPOrderCode . $order[0]->order_clientCode;
//                                            }
//                                            ?><!--">-->
                                                <?php echo $order[0]->order_clientCode; ?>
<!--                                            </a>-->
                                        </span>
                                        <br/>
                                    <?php endif; ?>
                                    <span
                                        class="title"><b>Ngày mua</b></span><span>: <?php echo date("d-m-Y H:i:s", $order[0]->date); ?></span><br/>
                                    <span class="title"><b>Giá trị đơn hàng</b></span><span
                                        class="money">: <?php echo lkvUtil::formatPrice($order[0]->order_total, 'đ'); ?></span>
                                </div>
                            </div>
                            <div class="col_bottom">
                                <div class="rows">
                                    <dl>


                                        <dt>Shop:</dt>
                                        <dd><a href="<?php echo $store . 'shop'; ?>" class="shopName"
                                               title="<?php echo $order[0]->sho_name; ?>"
                                               title="<?php echo $order[0]->sho_name; ?>"><?php echo $order[0]->sho_name; ?></a>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Trạng thái đơn hàng:</dt>
                                        <dd>
                                            <?php if ($order[0]->order_status): ?>
                                                <?php echo $status[$order[0]->order_status] ?>
                                            <?php endif; ?>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Trạng thái thanh toán:</dt>
                                        <dd><?php echo ($order[0]->payment_status == 1) ? 'Đã thanh toán' : 'Chưa thanh toán' ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>Hình thức thanh toán:</dt>
                                        <dd>
                                            <?php
                                            $payment_methods = json_decode(PAYMENT_METHOD);
                                            switch ($order[0]->payment_method) {
                                                case 'info_nganluong':
                                                    $payment = $payment_methods->info_nganluong;
                                                    break;
                                                case 'info_cod':
                                                    $payment = $payment_methods->info_cod;
                                                    break;
                                                case 'info_bank':
                                                    $payment = $payment_methods->info_bank;
                                                    break;
                                                case 'info_cash':
                                                    $payment = $payment_methods->info_cash;
                                                    break;
                                                default:
                                                    $payment = $payment_methods->default;
                                                    break;
                                            }
                                            echo $payment;
                                            ?>
                                        </dd>
                                    </dl>
                                </div>
                                <?php if ($order[0]->payment_method == 'info_bank') { ?>
                                    <hr>
                                    <div style="padding: 0" class="panel panel-info">
                                        <div style="padding: 10px" class="panel-heading"><h3 style="font-size: 15px" class="panel-title">Chuyển khoản cho Azibai theo ngân hàng</h3></div>
                                        <ul class="list-group">
                                            <?php foreach ($bank_info as $item) { ?>
                                                <li class="list-group-item">
                                                    <p><b>Tên ngân hàng:</b> <?php echo $item->bank_name; ?></p>
                                                    <p><b>Chủ tài khoản:</b> <?php echo $item->account_name; ?></p>
                                                    <p><b>Số tài khoản:</b> <?php echo $item->account_number; ?></p>
                                                    <p><b>Chi nhánh:</b> <?php echo $item->aff; ?></p>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>
                                <?php if ($order[0]->order_status == "01"): ?>
                                    <?php
                                    if ($_REQUEST['order_token'] && $order[0]->order_token == $_REQUEST['order_token'] && $order[0]->pro_type == 0):
                                        echo '<dl><button id="cancel_order" class="btn btn-danger" data-toggle="modal" data-target="#cancel-modal">Hủy đơn hàng</button></dl>';
                                    endif;
                                    ?>

                                <?php endif; ?>
                                <?php if ($order[0]->order_status == "03"): ?>
                                    <dl>
                                        <button
                                            onclick="location.href='<?php echo getAliasDomain() . 'change-delivery/' . $order[0]->id . '?order_token=' . $order[0]->order_token; ?>'"
                                            class="btn btn-success">Khiếu nại đơn hàng
                                        </button>
                                    </dl>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                        $step2 = '';
                        $step3 = '';
                        switch ($order[0]->order_status) {
                            case '02':
                                $step2 = 'done';
                                break;
                            case '98':
                                $step2 = 'done';
                                $step3 = 'done';
                                break;
                        }
                        ?>
                        <div class="status-orders-right col-sm-8">
                            <div class="row">
                                <div class="box-status">
                                    <div class="tl">Tình trạng đơn hàng</div>
                                    <div class="cont">
                                        <div class="box-steps">
                                            <?php if (in_array($order[0]->order_status, array('01', '02', '98'))): ?>
                                                <div class="step done">
                                                    <span><svg class="icon icon-shopping"><use
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                xlink:href="#icon-shopping"></use></svg></span>
                                                    <p>Mới</p>
                                                </div>
                                                <div class="step <?php echo $step2; ?>">
                                                    <span><svg class="icon icon-Fcategory"><use
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                xlink:href="#icon-Fcategory"></use></svg></span>
                                                    <p>Người bán đã xác nhận và đang vận chuyển</p>
                                                </div>
                                                <div class="step <?php echo $step3; ?> final">
                                                    <span><svg class="icon icon-checkmark"><use
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                xlink:href="#icon-checkmark"></use></svg></span>
                                                    <p>Đã hoàn tất</p>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (in_array($order[0]->order_status, array("03", "04", "05", "06", "99"))): ?>
                                                <div class="order_status">
                                                    <?php echo $status[$order[0]->order_status] ?>
                                                    <?php
                                                    if ($order[0]->cancel_reason) {
                                                        echo '<br/>Lí do hủy: ' . $order[0]->cancel_reason;
                                                    }
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-status">
                                    <div class="tl">Sản phẩm</div>
                                    <div class="cont">
                                        <table class="table table-hover" width="100%" border="0" cellpadding="0"
                                               cellspacing="0">
                                            <tbody>
                                            <?php foreach ($order as $vals): ?>
                                                <?php
                                                if ($vals->id > 0) {
                                                    $link_image = DOMAIN_CLOUDSERVER . 'media/images/product/' . $vals->pro_dir . '/thumbnail_2_' . $vals->dp_images;
                                                } else {
                                                    $link_image = DOMAIN_CLOUDSERVER . 'media/images/product/' . $vals->pro_dir . '/thumbnail_2_' . explode(',',$vals->pro_image)[0];
                                                }
//                                                $link_image = base_url() . 'media/images/product/' . $vals->pro_dir . '/' . show_thumbnail($vals->pro_dir, $vals->pro_image, 2);
                                                ?>
                                                <tr>
                                                    <td width="10%">
                                                        <img width="80" src="<?php echo $link_image; ?>">
                                                    </td>
                                                    <?php

                                                    if($arrUrl[0] == 'azibai'){
                                                        $linksp = $shopLink. $vals->pro_category.'/' . $vals->pro_id. '/' . RemoveSign($vals->pro_name) ;
                                                    }else{
                                                        $linksp = $linkSP . $vals->pro_id . '/' . RemoveSign($vals->pro_name);
                                                    }
                                                    ?>
                                                    <td width="50%"><b><a
                                                                href="<?php echo $linksp ?>"
                                                                title="<?php echo $vals->pro_name; ?>"
                                                                title="Đầm jeans phối hoa"><?php echo $vals->pro_name; ?></a></b>
                                                    </td>
                                                    <td width="20%">Mã SP: <?php echo $vals->pro_sku; ?><span
                                                            class="text-primary"></span></td>
                                                    <td>Số lượng: <span
                                                            class="text-primary"><?php echo $vals->shc_quantity; ?></span>
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="box-status">
                                    <div class="tl">Thông tin người nhận hàng</div>
                                    <div class="cont">
                                        <div class="nn">
                                            <p><span>Người nhận</span>
                                                <b>: <?php echo $order[0]->ord_sname; ?></b></p>
                                            <?php
                                            if ($order[0]->ord_semail) {
                                                ?>
                                                <p><span>Email</span>
                                                    <b>: <?php echo $order[0]->ord_semail; ?></b></p>
                                                <?php
                                            }
                                            ?>
                                            <p><span>Phone</span>
                                                <b>: <?php echo $order[0]->ord_smobile; ?></b></p>
                                            <?php if ($order[0]->product_type != 2) { ?>
                                            <p><span>Địa chỉ</span>
                                                <strong>: <?php echo $order[0]->ord_saddress.', '.$_district.', '.$_province; ?></strong></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
		<br>
            </div>
        </div>
    </div>

    <svg style="position: absolute; width: 0; height: 0;" width="0" height="0" version="1.1"
         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <symbol id="icon-shopping" viewBox="0 0 1024 1024">
                <path class="path1"
                      d="M747.072 778.336c-7.136-1.312-14.4-2.24-21.92-2.24h-410.656l-10.208-43.808h548.512l171.2-472.832h-826.432l-62.624-258.336h-134.944v63.776h89.248l168.032 728.384c-1.312 0.736-2.24 1.952-3.52 2.752-16.48 10.304-30.080 24.384-40.096 40.992-0.448 0.736-1.12 1.28-1.536 2.016h0.448c-10.368 18.048-16.768 38.688-16.768 60.96 0 67.872 55.008 122.912 122.88 122.912 67.904 0 122.912-55.040 122.912-122.912 0-22.272-6.4-42.912-16.768-60.96h203.776c-10.368 18.048-16.768 38.688-16.768 60.96 0 67.872 55.008 122.912 122.88 122.912 67.904 0 122.912-55.040 122.912-122.912-0.064-63.616-48.608-115.328-110.56-121.664zM206.656 321.376h730.912l-129.152 348.96h-517.12l-84.64-348.96zM319.168 986.4c-46.528 0-84.256-37.76-84.256-84.256 0-46.56 37.728-84.256 84.256-84.256s84.256 37.696 84.256 84.256c-0.032 46.528-37.728 84.256-84.256 84.256zM735.168 986.4c-46.528 0-84.256-37.76-84.256-84.256 0-46.56 37.728-84.256 84.256-84.256s84.256 37.696 84.256 84.256c-0.032 46.528-37.728 84.256-84.256 84.256z"></path>
            </symbol>
            <symbol id="icon-Fcategory" viewBox="0 0 1024 1024">
                <path class="path1"
                      d="M736 608h-448c-17.696 0-32 14.336-32 32 0 17.696 14.304 32 32 32h448c17.696 0 32-14.304 32-32 0-17.664-14.304-32-32-32zM736 768h-448c-17.696 0-32 14.336-32 32 0 17.696 14.304 32 32 32h448c17.696 0 32-14.304 32-32 0-17.664-14.304-32-32-32zM736 448h-448c-17.696 0-32 14.336-32 32 0 17.696 14.304 32 32 32h448c17.696 0 32-14.304 32-32 0-17.664-14.304-32-32-32zM832 128h-96v-64h-86.176c-27.744-38.080-78.752-64-137.824-64s-110.080 25.92-137.824 64h-86.176v64h-96c-70.688 0-128 57.312-128 128v640c0 70.688 57.312 128 128 128h640c70.688 0 128-57.312 128-128v-640c0-70.688-57.312-128-128-128zM352 128h71.136c0-35.328 39.776-64 88.864-64s88.864 28.672 88.864 64h71.136v128h-320v-128zM896 896c0 35.328-28.672 64-64 64h-640c-35.328 0-64-28.672-64-64v-640c0-35.328 28.672-64 64-64h96v128h448v-128h96c35.328 0 64 28.672 64 64v640z"></path>
            </symbol>
            <symbol id="icon-truck" viewBox="0 0 1024 1024">
                <path class="path1"
                      d="M794.624 366.24c-5.952-8.896-15.936-14.24-26.624-14.24h-32c-17.696 0-32 14.304-32 32v192c0 17.696 14.304 32 32 32h128c17.696 0 32-14.304 32-32v-48c0-6.304-1.888-12.512-5.376-17.76l-96-144zM864 576h-128v-192h32l96 144v48zM1007.872 490.752l-128-192c-17.856-26.784-47.744-42.752-79.872-42.752h-128v-64c0-52.928-43.072-96-96-96h-480c-52.928 0-96 43.072-96 96v352c0 52.928 43.072 96 96 96v0 96c0 52.928 43.072 96 96 96h36.544c14.304 55.072 64 96 123.488 96 59.424 0 109.12-40.928 123.424-96h169.024c14.304 55.072 64 96 123.488 96 59.424 0 109.12-40.928 123.424-96h36.608c52.928 0 96-43.072 96-96v-192c0-19.008-5.568-37.44-16.128-53.248zM96 576c-17.664 0-32-14.304-32-32v-352c0-17.696 14.336-32 32-32h480c17.696 0 32 14.304 32 32v352c0 17.696-14.304 32-32 32h-480zM352.032 864c-35.36 0-64-28.672-64-64s28.64-64 64-64c35.328 0 64 28.672 64 64s-28.704 64-64 64zM768 864c-35.36 0-64-28.672-64-64s28.64-64 64-64c35.328 0 64 28.672 64 64s-28.672 64-64 64zM960 736c0 17.696-14.304 32-32 32h-36.576c-14.304-55.072-64-96-123.424-96-59.488 0-109.184 40.928-123.488 96h-169.024c-14.304-55.072-64-96-123.424-96-59.488 0-109.184 40.928-123.488 96h-36.576c-17.664 0-32-14.304-32-32v-96h416c52.928 0 96-43.072 96-96v-224h128c10.688 0 20.672 5.344 26.624 14.24l128 192c3.488 5.248 5.376 11.456 5.376 17.76v192z"></path>
            </symbol>
            <symbol id="icon-checkmark" viewBox="0 0 1024 1024">
                <path class="path1" d="M864 128l-480 480-224-224-160 160 384 384 640-640z"></path>
            </symbol>
        </defs>
    </svg>

    <div id="cancel-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:35%;">
            <form id="cancel_order_form" method="post" action="<?php echo getAliasDomain() . 'order-cancel/' . $this->uri->segment(2); ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Xác nhận hủy đơn hàng</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group no-margin">
                                    <label for="field-7" class="control-label"><strong>Nhập lí do hủy</strong></label>
                                    <textarea required="required" name="info_cancel" class="form-control autogrow" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" value="cancel">Xác nhận</button>
                        <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php if (isset($_REQUEST['do']) && $_REQUEST['do'] == "cancel"): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('button[type="submit"]').on('click', function () {
                $('button[type="submit"]').attr('disabled', 'disabled');
                $('button[type="button"]').attr('disabled', 'disabled');

                $("#cancel_order_form").submit();
            });
            $("#cancel-modal").modal('show');
        });
    </script>
<?php endif; ?>

<?php $this->load->view('home/common/footer'); ?>