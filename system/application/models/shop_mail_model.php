<?php

class Shop_mail_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('shop_model');
    }

    function index()
    {
    }

    function smtpmailer($to, $from, $from_name, $subject, $body, $attachment = '')
    {

        $mail = new PHPMailer(true);            // tạo một đối tượng mới từ class PHPMailer
        $mail->IsSMTP();
        $mail->CharSet = "utf-8";           // bật chức năng SMTP
        $mail->SMTPDebug = 0;               // kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
        $mail->SMTPAuth = true;             // bật chức năng đăng nhập vào SMTP này
        $mail->SMTPSecure = SMTPSERCURITY;  // sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
        $mail->Host = SMTPHOST;             // smtp của gmail
        $mail->Port = SMTPPORT;             // port của smpt gmail
        $mail->Username = GUSER;
        $mail->Password = GPWD;
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);
        $mail->AddAddress($to);
        if ($attachment) {
            $mail->AddAttachment($attachment); // attachment
        }

        try {
            $mail->send();
        } catch (Exception $e) {
            $error_message = $e->getMessage();
        }

        // if (!$mail->Send()) {
        //     $message = 'Gởi mail bị lỗi: ' . $mail->ErrorInfo;
        //     return false;
        // } else {
        //     $message = 'Thư của bạn đã được gởi đi ';
        //     return true;
        // }
    }

    function sendingOrderEmailForCustomer($order, $user, $products)
    {
        $mail_order_status = '';
        // $shop_user = $this->shop_model->get("sho_name,sho_user", "sho_user = " . $order->order_saler);
        $shipping_method = "";
        if ($order->shipping_method == "GHN") {
            $shipping_method = "Giao hàng nhanh";
        }
        if ($order->shipping_method == "VTP") {
            $shipping_method = "Viettel Post";
        }
        if ($order->shipping_method == "SHO") {
            $shipping_method = "Shop giao";
        }
        $payment_method = "";
        switch ($order->payment_method) {
            case "info_nganluong":
                $payment_method = "Thanh toán qua Ngân Lượng";
                break;
            case "info_cod":
                $payment_method = "Thanh toán khi nhận hàng";
                break;
            case "info_bank":
                $payment_method = "Chuyển khoản qua ngân hàng";
                break;
            case "info_cash":
                $payment_method = "Thanh toán bằng tiền mặt tại quầy";
                break;
        }
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $duoi = $azi = $_SERVER['HTTP_HOST'];
        
        $linkKNai = base_url();
        $arr_domain = explode('.',$_SERVER['HTTP_HOST']);
        
        if(count($arr_domain) > 2) {
            if($arr_domain[1] == 'azibai'){
                $duoi = $arr_domain[1].'.'.$arr_domain[2];
            }
        }
        
        if($order->domain != "") {
            $shopLink = $protocol.$order->domain;
        } else {
            $shopLink = $protocol.$order->sho_link.'.'.domain_site;
        }
        $store = $shopLink . '/';
        if($order->order_group_id > 0){
            $segment1 = 'grtshop';
            $this->load->model('grouptrade_model');
            $get_grt = $this->grouptrade_model->get('grt_link,grt_domain', 'grt_id = "' . (int)$order->order_group_id . '"');
            if($get_grt->grt_domain != "") {
                $shopLink = $get_grt->grt_domain;
            }else{
                $shopLink = $get_grt->grt_link . '.' . $duoi;
            }
        }else{
            $segment1 = 'shop';
        }
        $shopLink .= '/';        
        
        if(count($arr_domain) > 2) {            
            $linkKNai = $protocol . substr(base_url(), strpos(base_url(), '.') + 1, strlen(base_url()));
        }
        if ($order->order_status == "01") {
            $mail_order_status = '<tr><td style="padding-left:80px;font-size:12px">Hủy đơn hàng: </td> <td><strong><a href="' . $shopLink . 'information-order/' . $order->id . '?order_token=' . $order->order_token . '&do=cancel">Nhấn vào đây hủy</a></strong></td> </tr>';
        }

        $mail_complain = '';
        if (in_array($order->order_status, ['03', '05'])) {
            $mail_complain = '<tr><td style="padding-left:80px;font-size:12px">Khiếu nại đơn hàng: </td> <td><strong><a href="' . $linkKNai . 'change-delivery/' . $order->id . '?order_token=' . $order->order_token . '">Nhấn vào đây khiếu nại</a></strong></td> </tr>';
        }

        $html1 = '<div id=":hn" class="a3s" style="overflow: hidden;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
            <tbody>
            <tr>
                <td align="center" style="padding:20px 0">
                <img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd"></td></tr>    </tbody>
                </table>  
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                <tbody>
                <tr></tr>   
                <tr>
                <td>
                <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;border-top:2px solid #ececec;background-color:#fff" width="800"> <tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
                <tbody><tr><td style="padding:20px">
                <p style="color:#000;font-size:18px;text-transform:uppercase;margin-bottom:20px">Chúc mừng <strong>' . $user->ord_sname . '</strong> đã đặt hàng thành công!</p> 
                <p style="font-size:14px;color:#000; font-weight:600">Cảm ơn bạn đã đặt hàng trên Azibai.com . <br> Để theo dõi tình trạng đơn hàng của bạn, vui lòng truy cập <a href="' . $shopLink . 'information-order/' . $order->id . '?order_token=' . $order->order_token . '" style="color:#0012ff" title="thông tin đơn hàng" target="_blank">thông tin đơn hàng</a> </p> 
                </td></tr>';
        if ((int)$this->session->userdata('sessionUser') <= 0) {
            $html1 .= '<tr><td><table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ececec;font-size:14px;margin:0 auto;border:1px solid #ececec;padding-bottom:10px" width="100%">
                        <tbody>
                        <tr><td colspan="2" style="height:36px;padding-left:10px" valign="middle">Thông tin tài khoản: </td> </tr> 
                        <tr>
                        <td style="padding-left:80px;font-size:12px" width="40%">Email đăng nhập: ' . $user->ord_semail . '</td></tr>';
            if ($this->session->userdata('password') && $this->session->userdata('password') != '') {
                $html1 .= '<tr ><td style = "padding-left:80px;font-size:12px" > Mật khẩu: ' . $this->session->userdata('password') . ' </td ></tr >';
            }
            $html1 .= '<tr><td style="padding-left:80px;font-size:12px">Đường dẫn đăng nhập: <a href="http://azibai.com/login">http://azibai.com/login</a></td></tr> 
                        </tbody>
                        </table>  </td> </tr>';
        }
        $html1 .= '<tr><td><table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ececec;font-size:14px;margin:0 auto;border:1px solid #ececec;padding-bottom:10px" width="100%">
                        <tbody>
                        <tr><td colspan="2" style="height:36px;padding-left:10px" valign="middle">Thông tin đơn hàng</td> </tr> 
                        <tr><td style="padding-left:80px;font-size:12px" width="40%">Mã số đơn hàng: </td> 
                        <td><strong><a href="' .$shopLink . 'information-order/' . $order->id . '?order_token=' . $order->order_token . '" target="_blank">' . $order->id . '</a></strong></td> </tr> 
                        <tr><td style="padding-left:80px;font-size:12px">Thời gian đặt hàng: </td> <td><strong>' . date("d-m-Y H:i:s", $order->date) . '</strong></td> </tr> 
                        <tr><td style="padding-left:80px;font-size:12px">Thông tin nhà vận chuyển: </td> <td><strong>' . $shipping_method . '</strong></td> </tr> 
                        <tr><td style="padding-left:80px;font-size:12px">Phương thức thanh toán: </td> <td><strong>' . $payment_method . '</strong></td> </tr> 
                        <tr><td style="padding-left:80px;font-size:12px">Thông tin người nhận: </td> <td><strong>' . $user->ord_sname . '</strong></td> </tr> 
                        <tr><td style="padding-left:80px;font-size:12px">Lưu ý về đơn hàng: </td> <td><strong>' . $user->ord_note . '</strong></td> </tr>  ' . $mail_order_status . $mail_complain .'
                        </tbody>
                        </table> 
                    </td> 
                    </tr>   
                    <tr><td style="padding-top:30px"><table align="left" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td colspan="3" style="height:36px">Shop: <strong><a href="' . $store . 'shop" target="_blank">' . $order->sho_name . '</a></strong> </td> </tr> <tr><td></td></tr><tr><td>';
       
        foreach ($products as $product) {
            $img1 = explode(',', $product->pro_image);
            if($product->shc_dp_pro_id > 0){
                $imgSrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $product->dp_images;
            } else {
                $imgSrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $img1[0];    
            }

            if($product->pro_type==0){
                $type='product';
            }else{
                if($product->pro_type==2){
                    $type='coupon';
                }
            }
            $html1 .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:20px 0;border-top:1px dashed #000">
            <tbody>
            <tr><td rowspan="5" width="65" valign="top" style="padding-top:10px">
            <a href="' .  $shopLink.$segment1.'/'.$type . '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '" target="_blank">
            <img src="' . $imgSrc . '" alt="" width="55" height="55" class="">
            </a>
            </td>
            <td style="font-size:14px;color:#000"><a href="' . $shopLink.$segment1.'/'.$type . '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '" target="_blank">' . sub($product->pro_name, 200) . '</a></td></tr>
            <tr><td>Mã hàng:</td>
            <td style="font-size:14px;color:#000" width="110">' . $product->pro_sku . '</td></tr>
            <tr><td>Đơn giá:</td>
            <td style="font-size:14px;color:#000">' . number_format($product->pro_price, 0, ',', '.') . ' đ</td></tr>
            <tr><td>Số lượng:</td>
            <td style="font-size:14px;color:#000">' . $product->shc_quantity . '</td></tr>
            <tr><td>Thành tiền:</td>
            <td style="font-size:14px;color:#000">' . number_format($product->shc_total, 0, ',', '.') . ' đ</td></tr>
            </tbody></table>';

        }

        $html1 .= '</td></tr>
            </tbody></table> <table align="right" border="0" cellpadding="0" cellspacing="0" style="padding:60px 0 0 60px" width="50%"><tbody><tr><td></td></tr><tr><td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc">Tổng cộng</td><td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right">' . number_format($order->order_total_no_shipping_fee, 0, ',', '.') . ' đ</td></tr><tr><td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc">Phí vận chuyển</td><td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right">' . number_format($order->shipping_fee, 0, ',', '.') . ' đ</td></tr><tr><td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc;color:#000;font-weight:bold">Tổng thanh toán</td><td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right;color:#000;font-weight:bold">' . number_format($order->order_total, 0, ',', '.') . ' đ</td></tr>  </tbody></table> </td> </tr>  <tr><td style="font-size:14px;color:#000;line-height:18px;padding-bottom:20px;line-height:20px"><p>Sau khi Shop <a href="' . $store . 'shop" target="_blank">' . $order->sho_name . '</a> xác nhận có hàng, chúng tôi sẽ tiến hành giao hàng cho bạn. Hàng sẽ được chuyển đến địa chỉ giao hàng trong khoảng 1 - 5 ngày, tính từ khi có xác nhận.</p> </td> </tr> </tbody></table> </td> </tr>  </tbody></table> </td> </tr>  </tbody></table>   <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%"><tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800"> <tbody><tr></tr>        <tr><td style="border-top:1px solid #ececec;padding:30px 0;color:#666"><table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700"><tbody><tr><td align="left" valign="top" width="55%">  <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#ff0000">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#f00;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a> </p> </td> <td align="right"><div style="padding-top:10px;margin-right:5px"><img alt="Banking" src="' . base_url() . 'templates/home/images/dichvuthanhtoan.jpg"></div></td> </tr> </tbody></table> </td> </tr>  </tbody></table> </td> </tr>  </tbody></table></div>';
        $this->load->library('email');
        $config['useragent'] = $this->lang->line('useragen_mail_detail');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        #Email
        $folder = folderWeb;
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');
        $return_email = $this->smtpmailer(trim($user->ord_semail), $this->lang->line('EMAIL_MEMBER_TT24H'), "Azibai.com", "Đặt hàng thành công", $html1);
    }

    function sendingOrderEmailForCustomerV2($order, $user, $products)
    {
        // $shop_user = $this->shop_model->get("sho_name,sho_user", "sho_user = " . $order->order_saler);
        $payment_method = "";
        switch ($order->payment_method) {
            case "info_nganluong":
                $payment_method = "Thanh toán qua Ngân Lượng";
                break;
            case "info_cod":
                $payment_method = "Thanh toán khi nhận hàng";
                break;
            case "info_bank":
                $payment_method = "Chuyển khoản qua ngân hàng";
                break;
            case "info_cash":
                $payment_method = "Thanh toán bằng tiền mặt tại quầy";
                break;
        }
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $duoi = $azi = $_SERVER['HTTP_HOST'];
        $shop_user = $this->user_model->fetch_join('use_id,parent_id,use_group,sho_name, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . (int)$order->order_saler . '"');
        $arr_domain = explode('.',$_SERVER['HTTP_HOST']);
        
        if(count($arr_domain) > 2) {
            if($arr_domain[1] == 'azibai'){
                $duoi = $arr_domain[1].'.'.$arr_domain[2];
            }
        }
        if($order->domain != "") {
            $shopLink = $protocol.$order->domain;
        } else {
            $shopLink = $protocol.$order->sho_link.'.'.domain_site;
        }
        $store = $shopLink . '/';
        if($order->order_group_id > 0){
            $segment1 = 'grtshop';
            $this->load->model('grouptrade_model');
            $get_grt = $this->grouptrade_model->get('grt_link,grt_domain', 'grt_id = "' . (int)$order->order_group_id . '"');
            if($get_grt->grt_domain != "") {
                $shopLink = $get_grt->grt_domain;
            }else{
                $shopLink = $get_grt->grt_link . '.' . $duoi;
            }
        }else{
            $segment1 = 'shop';           
        }
        $shopLink .= '/';        
        $mail_order_status = '';
       
        if ($order->order_status == "01") {
            $mail_order_status = '<tr><td style="padding-left:80px;font-size:12px">Hủy đơn hàng: </td> <td><strong><a href="' . $shopLink . 'information-order/' . $order->id . '?order_token=' . $order->order_token . '&do=cancel">Nhấn vào đây hủy</a></strong></td> </tr>';
        }


        $html1 = '<div id=":hn" class="a3s" style="overflow: hidden;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                <tbody>
                    <tr>
                        <td align="center" style="padding:20px 0"><img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd"></td>
                    </tr>    
                </tbody>
            </table>  
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                <tbody>
                <tr></tr>   
                <tr><td>
            <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;border-top:2px solid #ececec;background-color:#fff" width="800"> 
            <tbody>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
                            <tbody>
                                <tr>
                                    <td style="padding:20px"><p style="color:#000;font-size:18px;text-transform:uppercase;margin-bottom:20px">Chúc mừng <strong>' . $user->ord_sname . '</strong> đã đặt hàng thành công!</p> 
                                        <p style="font-size:14px;color:#000; font-weight: 600">Cảm ơn bạn đã đặt hàng trên Azibai.com . </p>';
        if ($order->pro_type == 2) {
            $html1 .= '<p>Sau khi nhận được thanh toán, Azibai sẽ xác nhận đơn hàng trong vòng 06 giờ làm việc. Bạn cần đăng nhập vào bằng tài khoản bên dưới để theo dõi và quản lý đơn hàng đã mua</p>';
        }
        $html1 .= '</td></tr>';
        if ((int)$this->session->userdata('sessionUser') <= 0) {
            $html1 .= '
                        <tr>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ececec;font-size:14px;margin:0 auto;border:1px solid #ececec;padding-bottom:10px" width="100%">
                                <tbody>
                                <tr><td colspan="2" style="height:36px;padding-left:10px" valign="middle">Thông tin tài khoản: </td> </tr> 
                                <tr><td style="padding-left:80px;font-size:12px" width="40%">Email đăng nhập: ' . $user->ord_semail . '</td></tr>';
                if ($this->session->userdata('password') && $this->session->userdata('password') != '') {
                    $html1 .= ' <tr><td style="padding-left:80px;font-size:12px">Mật khẩu: ' . $this->session->userdata('password') . '</td></tr>';
                }
            $html1 .= '<tr><td style="padding-left:80px;font-size:12px">Đường dẫn đăng nhập: <a href="http://azibai.com/login">http://azibai.com/login</a></td></tr> 
                                        </tbody>
                                        </table> 
                                    </td>
                                </tr>';
        }
        $html1 .= '
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ececec;font-size:14px;margin:0 auto;border:1px solid #ececec;padding-bottom:10px" width="100%">
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="height:36px;padding-left:10px" valign="middle">Thông tin đơn hàng</td> 
                                    </tr> 
                                    <tr><td style="padding-left:80px;font-size:12px" width="40%">Mã số đơn hàng: </td> <td><strong><a href="' . $shopLink . 'information-order/' . $order->id . '?order_token=' . $order->order_token . '" target="_blank">' . $order->id . '</a></strong></td> </tr> 
                                    <tr><td style="padding-left:80px;font-size:12px">Thời gian đặt hàng: </td> <td><strong>' . date("d-m-Y H:i:s", $order->date) . '</strong></td> </tr> 
                                    <tr><td style="padding-left:80px;font-size:12px">Phương thức thanh toán: </td> <td><strong>' . $payment_method . '</strong></td> </tr> 
                                    <tr><td style="padding-left:80px;font-size:12px">Thông tin người nhận: </td> <td><strong>' . $user->ord_sname . '</strong></td> </tr> 
                                    <tr><td style="padding-left:80px;font-size:12px">Lưu ý về đơn hàng: </td> <td><strong>' . $user->ord_note . '</strong></td></tr>  ' . $mail_order_status . '   
                                    </tbody>
                                </table> 
                        </td> 
                    </tr>   
                    <tr>
                        <td style="padding-top:30px">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="height:36px">Shop: <strong><a href="' . $store . 'shop" target="_blank">' . $order->sho_name . '</a></strong> </td> </tr> 
                                        <tr><td></td></tr><tr><td>';
        foreach ($products as $product) {
            $img1 = explode(',', $product->pro_image);
            if($product->dp_id > 0){
                $imgSrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $product->dp_image;
            } else {
                $imgSrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $img1[0];    
            }

            if($product->pro_type==0){
                $type='product';
            }else{
                if($product->pro_type==2){
                    $type='coupon';
                }
            }
            $html1 .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:20px 0;border-top:1px dashed #000">
            <tbody>
            <tr><td rowspan="5" width="65" valign="top" style="padding-top:10px"><a href="' . $shopLink.$segment1.'/'.$type. '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '" target="_blank">
            <img src="' . $imgSrc . '" alt="' . $imgSrc . '" width="55" height="55" class="CToWUd"></a>
            </td>
            <td style="font-size:14px;color:#000"><a href="' . $shopLink.$segment1.'/'.$type. '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '" target="_blank">' . sub($product->pro_name, 200) . '</a></td></tr>
            <tr><td>Mã hàng:</td>
            <td style="font-size:14px;color:#000" width="300">' . $product->pro_sku . '</td></tr>
            <tr><td>Đơn giá:</td>
            <td style="font-size:14px;color:#000">' . number_format($product->pro_price, 0, ',', '.') . ' đ</td></tr>
            <tr><td>Số lượng:</td>
            <td style="font-size:14px;color:#000">' . $product->shc_quantity . '</td></tr>
            <tr><td>Thành tiền:</td>
            <td style="font-size:14px;color:#000">' . number_format($product->shc_total, 0, ',', '.') . ' đ</td></tr>
            </tbody></table>';

        }
        $html1 .= '</td></tr>
            </tbody></table> 
            <table align="right" border="0" cellpadding="0" cellspacing="0" style="padding:60px 0 0 60px" width="50%">
                <tbody>
                    <tr><td></td></tr>
                    <tr>
                        <td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc">Tổng cộng</td>
                        <td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right">' . number_format($order->order_total_no_shipping_fee, 0, ',', '.') . ' đ</td></tr>
                        <tr><td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc;color:#000;font-weight:bold">Tổng thanh toán</td><td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right;color:#000;font-weight:bold">' . number_format($order->order_total, 0, ',', '.') . ' đ</td></tr>  
                        </tbody>
                        </table> </td> </tr>  
                        <tr><td style="font-size:14px;color:#000;line-height:18px;padding-bottom:20px;line-height:20px"><p>Sau khi nhận được thanh toán của bạn. Ban quản trị sẽ xác nhận đơn hàng, và sẽ có email thông báo cho bạn  kèm theo mã số. Bạn sẽ sử dụng mã số đó tại Shop <a href="' . $store . 'shop" target="_blank">' . $shop_user[0]->sho_name . '</a>.</p> </td> </tr> </tbody></table> </td> </tr>  </tbody></table> </td> </tr>  </tbody></table>   <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%"><tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800"> <tbody><tr></tr>        <tr><td style="border-top:1px solid #ececec;padding:30px 0;color:#666"><table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700"><tbody><tr><td align="left" valign="top" width="55%">  <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#ff0000">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#f00;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a> </p> </td> <td align="right"><div style="padding-top:10px;margin-right:5px"><img alt="Banking" src="http://azibai.com/templates/home/images/dichvuthanhtoan.jpg"></div></td> </tr> </tbody></table> </td> </tr>  </tbody></table> </td> </tr>  </tbody></table></div>';
        $this->load->library('email');
        $config['useragent'] = $this->lang->line('useragen_mail_detail');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        #Email
        $folder = folderWeb;
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');
        $return_email = $this->smtpmailer(trim($user->ord_semail), $this->lang->line('EMAIL_MEMBER_TT24H'), "Azibai.com", "Đặt hàng thành công", $html1);
    }

    function sendingConfirmOrderEmailForCustomer($order, $user, $products)
    {
        //$shop_user = $this->shop_model->get("sho_name,sho_user", "sho_user = " . $order->order_saler);
        $shipping_method = "";
        if ($order->shipping_method == "GHN") {
            $shipping_method = "Giao hàng nhanh";
        }
        if ($order->shipping_method == "VTP") {
            $shipping_method = "Viettel Post";
        }
        if ($order->shipping_method == "SHO") {
            $shipping_method = "Shop giao";
        }
        $payment_method = "";
        switch ($order->payment_method) {
            case "info_nganluong":
                $payment_method = "Thanh toán qua Ngân Lượng";
                break;
            case "info_cod":
                $payment_method = "Thanh toán khi nhận hàng";
                break;
            case "info_bank":
                $payment_method = "Chuyển khoản qua ngân hàng";
                break;
            case "info_cash":
                $payment_method = "Thanh toán bằng tiền mặt tại quầy";
                break;
        }
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        //$duoi = substr(base_url(), strlen($protocol), strlen(base_url()));
        //$shop_user = $this->user_model->fetch_join('use_id,parent_id,use_group,sho_name, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . (int)$order->order_saler . '"');
        $arr_domain = explode('.',$_SERVER['HTTP_HOST']);
        //bsung
        $duoi = $azi = $_SERVER['HTTP_HOST'];
        if(count($arr_domain) > 2) {
            if($arr_domain[1] == 'azibai'){
                $duoi = $arr_domain[1].'.'.$arr_domain[2];
            }
        }
        //end bsung
        $shopLink = $order->sho_link . '.' . $duoi;
        $domain = $order->domain;
        if ($domain == $duoi || $order->domain!='') {
            $shopLink = $domain;
        }
        if(count($arr_domain)>2) {
            $shopLink = $duoi;
        }
        $store = $shopLink . '/'; 
        $segment1 = 'shop';
        if($order->order_group_id > 0){
            $segment1 = 'grtshop';
            $this->load->model('grouptrade_model');
            $get_grt = $this->grouptrade_model->get('grt_link,grt_domain', 'grt_id = "' . (int)$order->order_group_id . '"');
            if($get_grt->grt_domain != "") {
                $shopLink = $get_grt->grt_domain;
            }else{
                $shopLink = $get_grt->grt_link . '.' . $duoi;
            }
        }
        $shopLink .= '/';
        $mail_complain = '';
        if($order->order_status == '02'){
            $txt = '';
            $status_order = 'ĐÃ ĐƯỢC GIAO';
            $title_mail = "Thông báo đơn hàng của bạn đã được giao thành công";

            $mail_complain = '<tr><td style="padding-left:80px;font-size:12px">Khiếu nại đơn hàng: </td> <td><strong><a href="' . $shopLink . 'change-delivery/' . $order->id . '?order_token=' . $order->order_token . '">Nhấn vào đây khiếu nại</a></strong></td> </tr>';
        
        }else{
            $status_order = 'BẮT ĐẦU ĐƯỢC VẬN CHUYỂN';
            $txt = 'đặt được chuẩn bị và chuyển đi ';
            $title_mail = "Thông báo đơn hàng của bạn đang được vận chuyển";
        }
        /*$shopLink = $shop_user[0]->sho_link . $duoi . '';
        if ($shop_user[0]->domain != '') {
            $shopLink = $shop_user[0]->domain . '/';
        }*/
        $html1 = '<div id=":hn" class="a3s" style="overflow: hidden;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
           <tbody>
              <tr>
                 <td align="center" style="padding:20px 0"><img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd"></td>
              </tr>
           </tbody>
        </table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
        <tbody>
           <tr></tr>
           <tr>
              <td>
                 <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;border-top:2px solid #ececec;background-color:#fff" width="800">
        <tbody>
           <tr>
              <td>
                 <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
        <tbody>
           <tr>
           <td style="padding:20px">
              <p style="color:#000;font-size:18px;text-transform:uppercase;margin-bottom:10px">HÀNG CỦA <strong>' . $user->ord_sname . '</strong> '.$status_order.'</p>
              <p style="font-size:16px">' . $user->ord_sname . ' thân mến, </p>
              <p style="font-size:14px;color:#000;padding-bottom:10px">Đơn hàng bạn '.$txt.' với thông tin như sau : </p>
           </td>
        </tr>

        <tr>
           <td style="padding-top:20px">
              <table border="0" cellpadding="0" cellspacing="0" style="font-size:14px;margin:0 auto;padding-bottom:10px;padding-top:10px" width="100%">
                 <tbody>
                    <tr>
                       <td style="text-transform:uppercase;font-size:16px;padding-bottom:10px;border-bottom:1px solid #1a1a1a;padding-left:10px" valign="top">Thông tin mã vận đơn: </td>
                       <td style="text-transform:uppercase;padding-bottom:10px;border-bottom:1px solid #1a1a1a;font-weight:bold" valign="top">' . $order->order_clientCode . '</td>
                    </tr>
                    <tr>
                       <td style="padding-left:80px;padding-top:10px;font-size:12px" valign="top" width="40%">Mã số đơn hàng: </td>
                       <td style="padding-top:10px" valign="top"><strong><a href="' . $shopLink . 'information-order/' . $order->id . '?order_token=' . $order->order_token . '" target="_blank">' . $order->id . '</a></strong></td>
                    </tr>
                    <tr>
                       <td style="padding-left:80px;font-size:12px" valign="top">Ngày đặt hàng:</td>
                       <td valign="top"><strong>' . date("d-m-Y H:i:s", $order->date) . '</strong></td>
                    </tr>
                    <tr>
                       <td style="padding-left:80px;font-size:12px" valign="top">Đơn vị vận chuyển: </td>
                       <td valign="top"><strong>' . $shipping_method . '</strong></td>
                    </tr>'. $mail_complain .'
                 </tbody>
              </table>
           </td>
        </tr>
           <tr>
              <td style="padding-top:30px">
                 <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
           <tr>
              <td colspan="3" style="height:36px">Shop: <strong><a href="' . $store . 'shop" target="_blank">' . $order->sho_name . '</a></strong> </td>
           </tr>
           <tr>
              <td></td>
           </tr>
           <tr>
              <td>';
        foreach ($products as $product) {
            $img1 = explode(',', $product->pro_image);
            
            if($product->shc_dp_pro_id > 0){
                $imgSrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $product->dp_images;
            } else {
                $imgSrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $img1[0];    
            }
            /*if ($img1[0] != "") {
                $imgSrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $img1[0], 1);
            } else {
                $imgSrc = $shopLink . 'media/images/noimage.png';
            }*/

            if($product->pro_type==0){
                $type='product';
            }else{
                if($product->pro_type==2){
                    $type='coupon';
                }
            }
            $html1 .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:20px 0;border-top:1px dashed #000">
            <tbody>
            <tr><td rowspan="5" width="65" valign="top" style="padding-top:10px"><a href="' . $shopLink . $segment1 . '/' . $type.  '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '" target="_blank"><img src="' . $imgSrc . '" alt="" width="55" height="55" class="CToWUd"></a></td>
            <td style="font-size:14px;color:#000"><a href="' . $shopLink . $segment1 . '/' .$type.  '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '" target="_blank">' . sub($product->pro_name, 200) . '</a></td></tr>
            <tr><td>Mã hàng:</td>
            <td style="font-size:14px;color:#000" width="110">' . $product->pro_sku . '</td></tr>
            <tr><td>Đơn giá:</td>
            <td style="font-size:14px;color:#000">' . number_format($product->pro_price, 0, ',', '.') . 'đ</td></tr>
            <tr><td>Số lượng:</td>
            <td style="font-size:14px;color:#000">' . $product->shc_quantity . '</td></tr>
            <tr><td>Thành tiền:</td>
            <td style="font-size:14px;color:#000">' . number_format($product->shc_total, 0, ',', '.') . 'đ</td></tr>
            </tbody></table>';

        }
        $html1 .= '</td></tr>
   </tbody></table> <table align="right" border="0" cellpadding="0" cellspacing="0" style="padding:60px 0 0 60px" width="50%"><tbody><tr><td></td></tr><tr><td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc">Tổng cộng</td><td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right">' . number_format($order->order_total_no_shipping_fee, 0, ',', '.') . ' đ</td></tr><tr><td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc">Phí vận chuyển</td><td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right">' . number_format($order->shipping_fee, 0, ',', '.') . 'đ</td></tr><tr><td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc;color:#000;font-weight:bold">Tổng thanh toán</td><td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right;color:#000;font-weight:bold">' . number_format($order->order_total, 0, ',', '.') . ' đ</td></tr>  </tbody></table> </td> </tr>  <tr><td style="font-size:14px;color:#000;line-height:18px;padding-bottom:20px;line-height:20px"><p>Sau khi Shop <a href="' . $store . 'shop" target="_blank">' . $order->sho_name . '</a> xác nhận có hàng, chúng tôi sẽ tiến hành giao hàng cho bạn. Hàng sẽ được chuyển đến địa chỉ giao hàng trong khoảng 1 - 5 ngày, tính từ khi có xác nhận.</p> </td> </tr> </tbody></table> </td> </tr>  </tbody></table> </td> </tr>  </tbody></table>   <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%"><tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800"> <tbody><tr></tr>        <tr><td style="border-top:1px solid #ececec;padding:30px 0;color:#666"><table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700"><tbody><tr><td align="left" valign="top" width="55%">  <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#ff0000">(08) 667. 55241</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#f00;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a> </p> </td> <td align="right"><div style="padding-top:10px;margin-right:5px"><img alt="Banking" src="' . base_url() . 'templates/home/images/dichvuthanhtoan.jpg"></div></td> </tr> </tbody></table> </td> </tr>  </tbody></table> </td> </tr>  </tbody></table></div>';
        $this->load->library('email');
        $config['useragent'] = $this->lang->line('useragen_mail_detail');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        #Email
        $folder = folderWeb;
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');
        $return_email = $this->smtpmailer(trim($user->ord_semail), $this->lang->line('EMAIL_MEMBER_TT24H'), "Azibai.com", $title_mail, $html1);
    }
    
    function sendingFinishOrderEmailForCustomer($order, $user, $products)
    {
        //$shop_user = $this->shop_model->get("sho_name,sho_user", "sho_user = " . $order->order_saler);
        $shipping_method = "";
        if ($order->shipping_method == "GHN") {
            $shipping_method = "Giao hàng nhanh";
        }
        if ($order->shipping_method == "VTP") {
            $shipping_method = "Viettel Post";
        }
        if ($order->shipping_method == "SHO") {
            $shipping_method = "Shop giao";
        }
        $payment_method = "";
        switch ($order->payment_method) {
            case "info_nganluong":
                $payment_method = "Thanh toán qua Ngân Lượng";
                break;
            case "info_cod":
                $payment_method = "Thanh toán khi nhận hàng";
                break;
            case "info_bank":
                $payment_method = "Chuyển khoản qua ngân hàng";
                break;
            case "info_cash":
                $payment_method = "Thanh toán bằng tiền mặt tại quầy";
                break;
        }

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        
        //$shop_user = $this->user_model->fetch_join('use_id, parent_id, use_group, sho_name, sho_link, domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . (int)$order->order_saler . '"');
        $arr_domain = explode('.',$_SERVER['HTTP_HOST']);
        $duoi = $azi = $_SERVER['HTTP_HOST'];
        $shopLink = $order->sho_link . '.' . $duoi;
        $domain = $order->domain;
        if ($domain == $duoi || $order->domain != '') {
            $shopLink = $domain;
        }
        if(count($arr_domain)>2) {
            $shopLink = $duoi;
        }
        $store = $shopLink . '/';	   
        $segment1 = 'shop';
        if($order->order_group_id > 0){
            $segment1 = 'grtshop';
            $this->load->model('grouptrade_model');
            $get_grt = $this->grouptrade_model->get('grt_link,grt_domain', 'grt_id = "' . (int)$order->order_group_id . '"');
            if($get_grt->grt_domain != "") {
                $shopLink = $get_grt->grt_domain;
            }else{
                $shopLink = $get_grt->grt_link . '.' . $duoi;
            }
        }
	    $shopLink .= '/';
       
        $html1 = '<div id=":hn" class="a3s" style="overflow: hidden;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
           <tbody>
              <tr>
                 <td align="center" style="padding:20px 0"><img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd"></td>
              </tr>
           </tbody>
        </table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
        <tbody>
           <tr></tr>
           <tr>
              <td>
                 <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;border-top:2px solid #ececec;background-color:#fff" width="800">
        <tbody>
           <tr>
              <td>
                 <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
        <tbody>
           <tr>
           <td style="padding:20px">
              <p style="color:#000;font-size:18px;text-transform:uppercase;margin-bottom:10px">ĐƠN HÀNG CỦA <strong>' . $user->ord_sname . '</strong> ĐÃ HOÀN THÀNH</p>
              <p style="font-size:16px">' . $user->ord_sname . ' thân mến, </p>
              <p style="font-size:14px;color:#000;padding-bottom:10px">Đơn hàng gồm những thông tin như sau : </p>
           </td>
        </tr>

        <tr>
           <td style="padding-top:20px">
              <table border="0" cellpadding="0" cellspacing="0" style="font-size:14px;margin:0 auto;padding-bottom:10px;padding-top:10px" width="100%">
                 <tbody>
                    <tr>
                       <td style="text-transform:uppercase;font-size:16px;padding-bottom:10px;border-bottom:1px solid #1a1a1a;padding-left:10px" valign="top">Thông tin mã vận đơn: </td>
                       <td style="text-transform:uppercase;padding-bottom:10px;border-bottom:1px solid #1a1a1a;font-weight:bold" valign="top">' . $order->order_clientCode . '</td>
                    </tr>
                    <tr>
                       <td style="padding-left:80px;padding-top:10px;font-size:12px" valign="top" width="40%">Mã số đơn hàng: </td>
                       <td style="padding-top:10px" valign="top"><strong><a href="' . $shopLink . 'information-order/' . $order->id . '?order_token=' . $order->order_token . '" target="_blank">' . $order->id . '</a></strong></td>
                    </tr>
                    <tr>
                       <td style="padding-left:80px;font-size:12px" valign="top">Ngày đặt hàng:</td>
                       <td valign="top"><strong>' . date("d-m-Y H:i:s", $order->date) . '</strong></td>
                    </tr>
                    <tr>
                       <td style="padding-left:80px;font-size:12px" valign="top">Đơn vị vận chuyển: </td>
                       <td valign="top"><strong>' . $shipping_method . '</strong></td>
                    </tr>
                 </tbody>
              </table>
           </td>
        </tr>
           <tr>
              <td style="padding-top:30px">
                 <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
           <tr>
              <td colspan="3" style="height:36px">Shop: <strong><a href="' . $store . 'shop" target="_blank">' . $order->sho_name . '</a></strong> </td>
           </tr>
           <tr>
              <td></td>
           </tr>
           <tr>
              <td>';
        foreach ($products as $product) {
            $img1 = explode(',', $product->pro_image);
            if ($img1[0] != "") {
                $imgSrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $img1[0];
            } else {
                $imgSrc = $shopLink . 'media/images/noimage.png';
            }

            if($product->pro_type==0){
                $type='product';
            }else{
                if($product->pro_type==2){
                    $type='coupon';
                }
            }
            $html1 .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:20px 0;border-top:1px dashed #000">
            <tbody>
            <tr><td rowspan="5" width="65" valign="top" style="padding-top:10px"><a href="' . $shopLink . $segment1 .'/'.$type.  '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '" target="_blank"><img src="' . $imgSrc . '" alt="" width="55" height="55" class="CToWUd"></a></td>
            <td style="font-size:14px;color:#000"><a href="' . $shopLink . $segment1 .'/'.$type.  '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '" target="_blank">' . sub($product->pro_name, 200) . '</a></td></tr>
            <tr><td>Mã hàng:</td>
            <td style="font-size:14px;color:#000" width="110">' . $product->pro_sku . '</td></tr>
            <tr><td>Đơn giá:</td>
            <td style="font-size:14px;color:#000">' . number_format($product->pro_price, 0, ',', '.') . 'đ</td></tr>
            <tr><td>Số lượng:</td>
            <td style="font-size:14px;color:#000">' . $product->shc_quantity . '</td></tr>
            <tr><td>Thành tiền:</td>
            <td style="font-size:14px;color:#000">' . number_format($product->shc_total, 0, ',', '.') . 'đ</td></tr>
            </tbody></table>';

        }
        $html1 .= '</td></tr>
   </tbody></table> <table align="right" border="0" cellpadding="0" cellspacing="0" style="padding:60px 0 0 60px" width="50%"><tbody><tr><td></td></tr><tr><td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc">Tổng cộng</td><td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right">' . number_format($order->order_total_no_shipping_fee, 0, ',', '.') . ' đ</td></tr><tr><td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc">Phí vận chuyển</td><td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right">' . number_format($order->shipping_fee, 0, ',', '.') . 'đ</td></tr><tr><td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc;color:#000;font-weight:bold">Tổng thanh toán</td><td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right;color:#000;font-weight:bold">' . number_format($order->order_total, 0, ',', '.') . ' đ</td></tr>  </tbody></table> </td> </tr>  <tr><td style="font-size:14px;color:#000;line-height:18px;padding-bottom:20px;line-height:20px">
   </td> </tr> </tbody></table> </td> </tr> </tbody></table> </td> </tr>  </tbody></table>   <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%"><tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800"> <tbody><tr></tr>        <tr><td style="border-top:1px solid #ececec;padding:30px 0;color:#666"><table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700"><tbody><tr><td align="left" valign="top" width="55%">  <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#ff0000">(08) 667. 55241</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#f00;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a> </p> </td> <td align="right"><div style="padding-top:10px;margin-right:5px"><img alt="Banking" src="' . base_url() . 'templates/home/images/dichvuthanhtoan.jpg"></div></td> </tr> </tbody></table> </td> </tr>  </tbody></table> </td> </tr>  </tbody></table></div>';
        $this->load->library('email');
        $config['useragent'] = $this->lang->line('useragen_mail_detail');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        #Email
        $folder = folderWeb;
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');
        $return_email = $this->smtpmailer(trim($user->ord_semail), $this->lang->line('EMAIL_MEMBER_TT24H'), "Azibai.com", "Thông báo đặt hàng thành công", $html1);
    }

    function sendingCancelOrderEmailForCustomer($order, $user, $products, $info_cancel)
    {
        // $shop_user = $this->shop_model->get("sho_name,sho_user", "sho_user = " . $order->order_saler);

        $shipping_method = "";
        if ($order->shipping_method == "GHN") {
            $shipping_method = "Giao hàng nhanh";
        }
        if ($order->shipping_method == "VTP") {
            $shipping_method = "Viettel Post";
        }
        if ($order->shipping_method == "SHO") {
            $shipping_method = "Shop giao";
        }
        $payment_method = "";
        switch ($order->payment_method) {
            case "info_nganluong":
                $payment_method = "Thanh toán qua Ngân Lượng";
                break;
            case "info_cod":
                $payment_method = "Thanh toán khi nhận hàng";
                break;
            case "info_bank":
                $payment_method = "Chuyển khoản qua ngân hàng";
                break;
            case "info_cash":
                $payment_method = "Thanh toán bằng tiền mặt tại quầy";
                break;
        }
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $shop_user = $this->user_model->fetch_join('use_id,parent_id,use_group,sho_name, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . (int)$order->order_saler . '"');
        $arr_domain = explode('.',$_SERVER['HTTP_HOST']);
        $duoi = $azi = $_SERVER['HTTP_HOST'];
        if(count($arr_domain)>2) {
            $duoi = $arr_domain[1].'.'.$arr_domain[2];
        }
        $shopLink = $order->sho_link . '.' . $duoi;
        $domain = $order->domain;
        if ($domain == $duoi || $order->domain!='') {
            $shopLink = $domain;
        }
        $store = $shopLink . '/';	   
        $segment1 = 'shop';
        if($order->order_group_id > 0){
            $segment1 = 'grtshop';
            $this->load->model('grouptrade_model');
            $get_grt = $this->grouptrade_model->get('grt_link,grt_domain', 'grt_id = "' . (int)$order->order_group_id . '"');
            if($get_grt->grt_domain != "") {
                $shopLink = $get_grt->grt_domain;
            }else{
                $shopLink = $get_grt->grt_link . '.' . $duoi;
            }
        }
	    $shopLink .= '/';
       
        $html1 = '<div id=":hn" class="a3s" style="overflow: hidden;">
<table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
   <tbody>
      <tr>
         <td align="center" style="padding:20px 0"><img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd"></td>
      </tr>
   </tbody>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
<tbody>
   <tr></tr>
   <tr>
      <td>
         <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;border-top:2px solid #ececec;background-color:#fff" width="800">
<tbody>
   <tr>
      <td>
         <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
<tbody>

<tr><td style="padding:20px 0"><p style="color:#000;font-size:18px;text-transform:uppercase;margin-bottom:20px"><strong>' . $user->ord_sname . '</strong> thân mến,</p> <p style="font-size:14px;color:#000">Do nhu cầu mua sắm phát sinh cao cho (những) sản phẩm mà bạn đã đặt mua, Shop <a href="' . $store . 'shop" target="_blank">' . $order->sho_name . '</a> xin thông báo đơn hàng <a href="' . $shopLink . 'information-order/' . $order->id . '?order_token=' . $order->order_token . '" target="_blank">' . $order->id . '</a> đặt vào ngày ' . date("d-m-Y H:i:s", $order->date) . ' đã hết hàng. </p> </td> </tr>

<tr><td style="padding-top:20px;border-top:1px solid #b2b2b2;font-size:16px">Thông tin đơn hàng bạn đã đặt mua : </td> </tr>

   <tr>
      <td style="padding-top:30px">
         <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
   <tr>
      <td colspan="3" style="height:36px">Shop: <strong><a href="' . $store . 'shop" target="_blank">' . $order->sho_name . '</a></strong> </td>
   </tr>
   <tr>
      <td></td>
   </tr>
   <tr>
      <td>';
        foreach ($products as $product) {
            $img1 = explode(',', $product->pro_image);
            if ($img1[0] != "") {
                $imgSrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $img1[0];
            } else {
                $imgSrc = $shopLink . 'media/images/noimage.png';
            }

            if($product->pro_type==0){
                $type='/product';
            }else{
                if($product->pro_type==2){
                    $type='/coupon';
                }
            }
            $html1 .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:20px 0;border-top:1px dashed #000">
<tbody>
<tr><td rowspan="5" width="65" valign="top" style="padding-top:10px"><a href="' . $shopLink . $segment1 . $type . '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '" target="_blank"><img src="' . $imgSrc . '" alt="" width="55" height="55" class="CToWUd"></a></td>
<td style="font-size:14px;color:#000"><a href="' . $shopLink  . $segment1 . $type.  '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '" target="_blank">' . sub($product->pro_name, 200) . '</a></td></tr>
<tr><td>Mã hàng:</td>
<td style="font-size:14px;color:#000" width="110">' . $product->pro_sku . '</td></tr>
<tr><td>Đơn giá:</td>
<td style="font-size:14px;color:#000">' . number_format($product->pro_price, 0, ',', '.') . ' đ</td></tr>
<tr><td>Số lượng:</td>
<td style="font-size:14px;color:#000">' . $product->shc_quantity . '</td></tr>
<tr><td>Thành tiền:</td>
<td style="font-size:14px;color:#000">' . number_format($product->shc_total, 0, ',', '.') . ' đ</td></tr>
</tbody></table>';

        }
        $html1 .= '</td></tr>
   </tbody></table>
   <table align="right" border="0" cellpadding="0" cellspacing="0" style="padding:60px 0 0 60px" width="50%">
   <tbody>
      <tr>
         <td></td>
      </tr>
      <tr>
         <td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc">Tổng cộng</td>
         <td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right">' . number_format($order->order_total_no_shipping_fee, 0, ',', '.') . ' đ</td>
      </tr>
      <tr>
         <td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc">Phí vận chuyển</td>
         <td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right">' . number_format($order->shipping_fee, 0, ',', '.') . ' đ</td>
      </tr>
      <tr>
         <td style="font-size:12px;text-transform:uppercase;height:20px;padding-left:10px;border-bottom:1px solid #dcdcdc;color:#000;font-weight:bold">Tổng thanh toán</td>
         <td style="font-size:14px;text-transform:uppercase;border-bottom:1px solid #dcdcdc;text-align:right;color:#000;font-weight:bold">' . number_format($order->order_total, 0, ',', '.') . ' đ</td>
      </tr>
   </tbody>
</table>
</td> </tr>

<tr>
   <td style="padding:20px;border-top:1px solid #ececec;font-size:14px">
      <p>Đơn hàng đã bị hủy bởi Shop <a href="' . $store . 'shop" target="_blank">' . $order->sho_name . '</a> .<br/><span style="color:red;font-weight:bold;">Lý do hủy:' . $info_cancel . '</span><br/> Nếu bạn đã thanh toán cho đơn hàng. Azibai.com sẽ tiến hành hoàn lại 100% số tiền cho bạn. Vui lòng xem thêm chi tiết <a href="' . $shopLink . 'information-order/' . $order->id . '?order_token=' . $order->order_token . '" target="_blank">tại đây</a><br> Chúng tôi rất tiếc vì sự bất tiện này. Mong bạn sẽ tiếp tục ủng hộ Azibai.com. Chân thành cảm ơn.</p>
      <p></p>
   </td>
</tr>
</tbody></table> </td> </tr>  </tbody></table> </td> </tr>  </tbody></table>
<table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
   <tbody>
      <tr>
         <td>
            <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800">
               <tbody>
                  <tr></tr>
                  <tr>
                     <td style="border-top:1px solid #ececec;padding:30px 0;color:#666">
                        <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
                           <tbody>
                              <tr>
                                 <td align="left" valign="top" width="55%">
                                    <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#ff0000">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#f00;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a> </p>
                                 </td>
                                 <td align="right">
                                    <div style="padding-top:10px;margin-right:5px"><img alt="Banking" src="' . base_url() . 'templates/home/images/dichvuthanhtoan.jpg"></div>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table></div>';
        $this->load->library('email');
        $config['useragent'] = $this->lang->line('useragen_mail_detail');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        #Email
        $folder = folderWeb;
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');
        $return_email = $this->smtpmailer(trim($user->ord_semail), $this->lang->line('EMAIL_MEMBER_TT24H'), "Azibai.com", "Thông báo hủy đơn hàng", $html1);
    }

    function sendingOrderEmailForShop($order, $user, $products)
    {
        $shipping_method = "";
        if ($order->shipping_method == "GHN") {
            $shipping_method = "Giao hàng nhanh";
        }
        if ($order->shipping_method == "VTP") {
            $shipping_method = "Viettel Post";
        }
        if ($order->shipping_method == "SHO") {
            $shipping_method = "Shop giao";
        }
        $payment_method = "";
        switch ($order->payment_method) {
            case "info_nganluong":
                $payment_method = "Thanh toán qua Ngân Lượng";
                break;
            case "info_cod":
                $payment_method = "Thanh toán khi nhận hàng";
                break;
            case "info_bank":
                $payment_method = "Chuyển khoàn qua ngân hàng";
                break;
            case "info_cash":
                $payment_method = "Thanh toán bằng tiền mặt tại quầy";
                break;
        }
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $shop_user = $this->user_model->fetch_join('use_id, use_email, parent_id, use_group, sho_name, sho_link, domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . (int)$order->order_saler . '"');
        $arr_domain = explode('.',$_SERVER['HTTP_HOST']);
        $duoi = $azi = $_SERVER['HTTP_HOST'];
        $shopLink = $shop_user[0]->sho_link . '.' . $duoi.'/';
        $domain = $shop_user[0]->domain.'/';
        if ($domain == $duoi || $shop_user[0]->domain != '') {
            $shopLink = $domain;
        }
        if(count($arr_domain) > 2) {
            $shopLink = $duoi;
        }
        // Gửi email tới gian hàng báo có đơn hàng mới
        $html = '<div id=":p8" class="ii gt m153a68f7aadeb171 adP adO"><div id=":n8" class="a3s" style="overflow: hidden;"><div class="adM">  </div><table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%"><tbody><tr><td align="center" style="padding:20px 0"><img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd"></td></tr>   <tr><td></td></tr> </tbody></table> <table border="0" cellpadding="0" cellspacing="0" style="background:#ffffff" width="100%"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" style="width:650px;border-top:1px dotted #cccccc"><tbody><tr><td align="center" style="height:9px" valign="top"></td> </tr> <tr><td align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333333;background:#fff" valign="top"><div style="line-height:18px;color:#333"><div style="background:#fff;padding:10px;width:100%;margin-top:10px"><h1 style="font-size:20px;font-weight:bold;color:#666">Thông báo đơn hàng mới</h1> <span style="display:block;padding:10px 0">Chào bạn <strong> </strong>,</span> <span style="display:block;padding:10px 0">Cảm ơn bạn đã tham gia giao dịch và sử dụng dịch vụ tại Azibai<br> Bạn vừa có đơn hàng mới với thông tin như sau:</span> </div><div style="background:#eff0f4;border:1px solid #e2e2e2;margin-top:10px;width:100%"><table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr style="padding:10px"><td colspan="2" style="border-top:1px solid #eff0f4"><table style="padding:7px 0"><tbody><tr><td style="padding:2px 8px 0px 15px">Mã số đơn hàng:</td> <td style="padding:2px 8px 0px 15px"><strong>' . $order->id . '</strong></td> </tr> <tr><td style="padding:2px 8px 0px 15px">Thời gian đặt hàng:</td> <td style="padding:2px 8px 0px 15px"><strong>' . date("d-m-Y H:i:s", $order->date) . '</strong></td> </tr> <tr><td style="padding:2px 8px 0px 15px">Phương thức vận chuyển:</td> <td style="padding:2px 8px 0px 15px"><strong>' . $shipping_method . '</strong></td> </tr> <tr><td style="padding:2px 8px 0px 15px">Phương thức thanh toán:</td> <td style="padding:2px 8px 0px 15px"><strong>' . $payment_method . '</strong></td> </tr> <tr><td style="padding:2px 8px 0px 15px">Tên người nhận:</td> <td style="padding:2px 8px 0px 15px"><strong>' . $user->ord_sname . '</strong></td> </tr> <tr><td style="padding:2px 8px 0px 15px">Lưu ý về đơn hàng:</td> <td style="padding:2px 8px 0px 15px"><strong>' . $user->ord_note . '</strong></td> </tr>  </tbody></table> </td> </tr> </tbody></table> </div><div style="background:#eff0f4;border:1px solid #e2e2e2;margin-top:10px;width:100%"><table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr bgcolor="#666" style="color:#fff;height:25px"><th scope="col" style="padding:5px">Tên hàng</th> <th scope="col" style="padding:5px">Mã hàng</th> <th scope="col" style="padding:5px">Đơn giá</th> <th scope="col" style="padding:5px">Số lượng</th> <th scope="col" style="padding:5px">Thành tiền</th> </tr>';
        foreach ($products as $product) {
            $img1 = explode(',', $product->pro_image);
            if ($img1[0] != '') {
                $imgSrc = DOMAIN_CLOUDSERVER .'media/images/product/'. $product->pro_dir .'/'. show_thumbnail($product->pro_dir, $img1[0], 1);
            } else {
                $imgSrc =DOMAIN_CLOUDSERVER .'media/images/noimage.png';
            }
            
            if($product->pro_type == 0){
                $type = 'product';
            }else{
                if($product->pro_type == 2){
                    $type = 'coupon';
                }
            }
            $html .= '<tr><td style="padding:5px 0 5px 15px;vertical-align:middle"><p style="float:left;padding-right:10px"><img src="' . $imgSrc . '" width="50" height="50" class="CToWUd"> </p><div style="padding-top:10px;line-height:18px"><a class="menu_1"
                                           href="' . $shopLink.'shop/'.$type . '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '">' . sub($product->pro_name, 200) . '</a></div><div></div></td>
<td style="padding:5px 0;text-align:center">' . $product->pro_sku . '</td>
<td style="padding:5px 0;text-align:right">' . number_format($product->pro_price, 0, ',', '.') . ' đ</td>
<td style="padding:5px 0;text-align:center">' . $product->shc_quantity . '</td>
<td style="padding:5px 15px 5px 0px;text-align:right">' . number_format($product->shc_total, 0, ',', '.') . ' đ</td>
</tr>';
        }
        $html .= '<tr align="center"><td align="right" colspan="4" style="border-bottom:1px solid #eff0f4;padding:5px">Chi phí đơn hàng</td> <td align="right" style="border-bottom:1px solid #eff0f4;padding:5px 16px 5px 5px">' . number_format($order->order_total_no_shipping_fee, 0, ',', '.') . 'đ</td> </tr><tr align="center"><td align="right" colspan="4" style="border-bottom:1px solid #eff0f4;padding:5px"><strong>Tổng thanh toán cho Shop</strong></td> <td align="right" style="border-bottom:1px solid #eff0f4;padding:5px 16px 5px 5px"><strong>' . number_format($order->order_total_no_shipping_fee, 0, ',', '.') . '</strong> đ</td> </tr> </tbody></table> </div><br> Vui lòng đăng nhập vào tài khoản của bạn trên website <a href="https://azibai.com/" target="_blank">Azibai</a> và xác nhận về khả năng đáp ứng đơn hàng của bạn.<br> </div></td> </tr> </tbody></table> </td> </tr> </tbody></table>  <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%"><tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800"> <tbody><tr></tr>        <tr><td style="border-top:1px solid #ececec;padding:30px 0;color:#666"><table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700"><tbody><tr><td align="left" valign="top" width="55%">  <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#ff0000">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#f00;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a> </p> </td> <td align="right"><div style="padding-top:10px;margin-right:5px"><img alt="Banking" src="' . $shopLink . 'templates/home/images/dichvuthanhtoan.jpg"></div></td> </tr> </tbody></table> </td> </tr>  </tbody></table> </td> </tr>  </tbody></table></div><div class="yj6qo"></div></div>';

        $this->load->library('email');
        $config['useragent'] = $this->lang->line('useragen_mail_detail');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        #Email
        $folder = folderWeb;
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');
        if (!empty($shop_user[0]->use_email)) 
        {
            $return_email = $this->smtpmailer(trim($shop_user[0]->use_email), $this->lang->line('EMAIL_MEMBER_TT24H'), "Azibai.com", "Thông báo đơn hàng mới", $html);
        } 
        else 
        {
            return false;
        }
    }

}