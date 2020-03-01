<html>
    <head>
        <title>GIẤY XÁC NHẬN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/print_order.css">
        
        <style>
            body{
                background-color: white;
            }
            .p-left {
                text-align: justify;
                padding: 5px 22px;
                width: 160px;
            }
            .p-left img {
                float: left;
                margin: 0 8px 1px 0;
            }
            pre{
                margin: 0em 0px !important;
            }
            .table > tbody > tr > td{
                border-top:none;width:226px;
            }
            .title{
                padding:10px;font-size:14px;font-weight:bold;text-transform: uppercase;margin:0px;border: 1px solid #ddd;
            }
        </style>
    </head>
<body>
    <div class="container" id="inhd">
        <div>
            <table class="table">
                <tbody>           
                    <tr>
                        <td> 
                            <div  style="color: red;font-size: large;font-style: italic;font-weight:bold;"><?php echo 'Azibai.com';?></div>
                            <div  style="color:#000;font-size: small;font-style: italic; font-weight: bold;">
                                <?php echo settingAddress_1; ?><br/>
                                Điện thoại: <?php echo settingPhone; ?>
                            </div>
                        </td>
                        <td class="text-right"><img  src="<?php echo base_url(); ?>images/logo-azibai.png"/></td>                  
                    </tr>
                    <tr>
                        <td colspan="2"><img width="100%" height="1" src="<?php echo base_url().'templates/home/images/linebg.png'; ?>"/></td>

                    </tr>
                </tbody>
            </table>
            <div>
                <table class="table">
                    <tbody>           
                        <tr>
                            <td colspan="2" class="text-center"> 
                                <img src="<?php echo base_url().'media/shop/logos/'.$shop_info->sho_dir_logo.'/'.$shop_info->sho_logo; ?>" />
                            </td>            
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center"><p style="font-size: large;font-style: italic;"><b>XÁC NHẬN ĐƠN HÀNG</b></p> </td>
                        </tr>
                    </tbody>
                </table>       
            </div>
            <div class="row">
                <div style="background-color:#ddd;">
                    <h4 class="title">THÔNG TIN ĐƠN HÀNG</h4>
                </div>
                <table class="table table-bordered tbl_bg">
                    <tbody>           
                        <tr>
                            <td class="leftspace">Mã đơn hàng</td>
                            <td class="leftspace" style="text-transform:uppercase;font-size: 17px;"><b><?php echo $order['order_info']->id; ?></b></td>
                        </tr>
                        <?php if($order['order_info']->order_clientCode): ?>
                            <tr>
                                <td class="leftspace">Mã vận chuyển</td>
                                <td class="leftspace"><b><?php echo $order['order_info']->order_clientCode; ?></b></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="leftspace">Ngày mua</td>
                            <td class="leftspace"><b><?php echo date("d-m-Y H:i:s",$order['order_info']->date); ?></b></td>
                        </tr>
                        <tr>
                            <td class="leftspace">Giá trị đơn hàng</td>
                            <td class="leftspace" style="color:red"><b><?php echo lkvUtil::formatPrice($order['order_info']->order_total, 'đ'); ?></b></td>
                        </tr>
                    </tbody>
                </table>				
            </div>
            
            
            <div class="row">
                <div style="background-color:#ddd;">
                    <h4 class="title">THÔNG TIN GIAN HÀNG</h4>
                </div>
                <table  class="table table-bordered tbl_bg">
                    <tbody>           
                        <tr>
                            <td class="leftspace">Tên gian hàng</td>
                            <td class="leftspace" style="text-transform:uppercase;font-size: 17px; width:20px;"><b><?php echo $shop_info->sho_name; ?></b></td>
                        </tr>
                        <tr>
                            <td class="leftspace">Địa chỉ</td>
                            <td class="leftspace"><b><?php echo $shop_info->sho_address; ?></b></td>
                        </tr>
                        <?php if($shop_info->sho_phone): ?>
                            <tr>
                                <td class="leftspace">Điện thoại</td>
                                <td class="leftspace"><b><?php echo $shop_info->sho_phone; ?></b></td>
                            </tr>
                        <?php endif; ?>
                        <?php if($shop_info->sho_email): ?>
                            <tr>
                                <td class="leftspace">Email</td>
                                <td class="leftspace"><b><?php echo $shop_info->sho_email; ?></b></td>
                            </tr>
                        <?php endif; ?>
                        
                    </tbody>
                </table>				
            </div>
            
            <div class="row">
                <div style="background-color:#ddd;">
                    <div class="title">Thông tin sản phẩm trong đơn hàng</div> 
                </div>
                <table class="table table-bordered tbl_bg">
                    <tbody>                        
                        <?php foreach($order['order_detail'] as $vals):?>
                            <tr>
                            <?php 
                                if($vals->shc_dp_pro_id > 0){
                                    $link_image = base_url().'media/images/product/'.$vals->pro_dir.'/'. show_thumbnail($vals->pro_dir, $vals->dp_images, 2);
                                } else {
                                    $link_image = base_url().'media/images/product/'.$vals->pro_dir.'/'. show_thumbnail($vals->pro_dir, $vals->pro_image, 2);
                                }
                            ?>
                                <td class="leftspace" style="padding:5px;width:100px">
                                    <img width="100%" src="<?php echo $link_image; ?>" />
                                </td>
                                <td style="padding:10px 10px;width:1200px;">
                                    <b><a href="" title="<?php echo $vals->pro_name;?>" title="Đầm jeans phối hoa" style="text-decoration: none;text-transform: uppercase;"><?php echo $vals->pro_name;?></a></b>
                                    <br/>
                                    <b>Mã sản phẩm: <?php echo $vals->pro_sku; ?></b>
                                    <br/>
                                    <b>Số lượng: <?php echo $vals->shc_quantity; ?></b>
                                </td>
                            </tr>
                        <?php endforeach;; ?>
                    </tbody>
                </table>     				
            </div>
            
            <div class="row">
                    <div style="background-color:#ddd; ">
                            <h4 class="title">LƯU Ý ĐƠN HÀNG</h4>
                    </div>
                <div style="padding-top:10px;">
                    Sau khi shop xác nhận có hàng, sản phẩm sẽ được giao hàng đến địa chỉ của quý khách tại <b><?php echo $order['order_info']->ord_saddress; ?>.</b>
                    <br/>
                    Mọi thông tin về đơn hàng sẽ được gửi tới email của quý khách, vui lòng kiểm tra email để biết thêm chi tiết.
                    <br/>
                    Cảm ơn quý khách đã tin tưởng và giao dịch tại Azibai.com - Sàn mua bán trực tuyến hàng đầu Việt Nam
                    <br/>
                    Ban quản trị <b>AZIBAI</b>
                    <br/>
                    Mọi thắc mắc vui lòng liên hệ: <b><?php echo HOTLINE; ?></b>
                </div>
            </div>
            <div class="text-center" style="font-style: italic;font-weight: bold;color:red;padding-top:10px">CÁM ƠN QUÝ KHÁCH ĐÃ MUA HÀNG TẠI AZIBAI.COM</div>
    </div>
    </body>
</html>