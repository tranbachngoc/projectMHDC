<?php $this->load->view('home/common/checkout/header'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/orders_success.css" />
<div class="container">
    <div class="row">        
        <div class="col-lg-12">
            <div class="breadcrumbs hidden-xs">
                <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                <span>Đặt hàng thành công</span>
            </div>
                <div class="checkout-success ">   
                    <h2 class="ttl-checkout">Đặt hàng thành công</h2>
                    <div class="checkout-success-cont">      
                        <div class="checkout-success-cont-bg">
                            <?php
                            $serviceID = json_decode(ServiceID); $order_serviceID = $order_cart[0]->order_serviceID;
                            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                                $domainName = $_SERVER['HTTP_HOST'];
                                if(count(explode('.', $domainName)) === 3){
                                    $url = '';
                                    $strUrl = explode('.', $domainName);
                                    $url = $strUrl[1].'.'.$strUrl[2];
                                }else{
                                    $url =  $domainName;
                                }

                                $link_shop = $protocol.$order_cart[0]->sho_link.'.'. $url.'/';
                                if($order_cart[0]->domain != ''){
                                    $link_shop = $protocol.$order_cart[0]->domain.'/';
                                }
                                $this->session->set_userdata('shopLink',$link_shop);
                            ?>
                            <div class="content-order">
                                <span class="ic-check"></span>
                                <p>Chào <strong><span class="yel"><?php echo $order_cart[0]->ord_sname; ?>,</span></strong></p>
                                <p>Quý khách vừa đặt thành công sản phẩm của shop <b><a href="<?php echo $link_shop; ?>shop" class="shopName" title="<?php echo $order_cart[0]->sho_name; ?>"><?php echo $order_cart[0]->sho_name; ?></a></b></p>
                                <?php if (isset($order_cart[0]->shipping_method) && $order_cart[0]->shipping_method != '') { ?>
                                    <p>Sau khi shop xác nhận có hàng, sản phẩm sẽ được giao hàng đến địa chỉ của quý khách tại <strong><?php echo $order_cart[0]->ord_saddress; ?>, <?php echo $_district; ?>, <?php echo $_province; ?></strong> <?php //echo $serviceID->$order_serviceID; ?>.</p>
                                <?php }else{ ?>
                                    <p>Sau khi nhận được thanh toán của bạn. Ban quản trị sẽ xác nhận đơn hàng và sẽ gửi mã sử dụng đơn hàng vào email của bạn.</p>
                                <?php } ?>
                                <p >
                                    <a class="btn btn-primary" title="Chi tiết đơn hàng" href="<?php echo '/information-order/'.$order_cart[0]->order_id.'?order_token='.$order_cart[0]->order_token; ?>">Chi tiết đơn hàng</a>
                                    <a class="btn btn-primary"  title="Giỏ hàng" href="/checkout">Giỏ hàng</a>
                                    <!--<a title="Tiếp tục mua sắm" href="##">Tiếp tục mua sắm</a>-->
                                </p>
                                <p>Mọi thông tin về đơn hàng sẽ được gửi tới email của quý khách, vui lòng kiểm tra email để biết thêm chi tiết.</p>
                                <br>
                                <p>Cảm ơn quý khách đã tin tưởng và giao dịch tại <a href="<?php echo $mainDomain; ?>" title="<?php echo $mainDomain; ?>"><span class="red"><?php echo $settingTitle; ?></span></a></p>
                                <p>Ban quản trị AZIBAI</p>
                                <div class="contact-info">
                                    <div>Mọi thắc mắc vui lòng liên hệ: <strong><?php echo HOTLINE;?></strong></div>        
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($order_cart[0]->payment_method == 'info_bank'){ ?>
                        <hr>
                        <div style="padding: 0" class="panel panel-info">
                            <div class="panel-heading"><h3  class="panel-title">Chuyển khoản cho Azibai theo ngân hàng</h3> </div>
                            <ul class="list-group">
                                <?php foreach ($bank_info as $item){ ?>
                                    <li class="list-group-item">
                                        <p><b>Tên ngân hàng:</b> <?php  echo $item->bank_name;?></p>
                                        <p><b>Chủ tài khoản:</b> <?php  echo $item->account_name;?></p>
                                        <p><b>Số tài khoản:</b> <?php  echo $item->account_number;?></p>
                                        <p><b>Chi nhánh:</b> <?php  echo $item->aff;?></p>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>