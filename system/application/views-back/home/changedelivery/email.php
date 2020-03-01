<div id=":tm" class="ii gt m153f567cf819a5da adP adO">
    <div id=":ti" class="a3s" style="overflow: hidden;">
        <div style="overflow:hidden">
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                <tbody>
                    <tr>
                        <td align="center" style="padding:20px 0"><img alt="" src="https://ci3.googleusercontent.com/proxy/tPNwi80p9LdBwCVchMWqUyG6Sgs5c01jCVKGMBeQqriM1cCKWNTUhOPWKMUOKME4MY_TeFCORRhx2mMF4a8=s0-d-e1-ft#http://azibai.com/images/logo-azibai.png" class="CToWUd"></td>
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
                                                            <p style="color:#ba0000;font-size:18px;text-transform:uppercase;margin-bottom:20px">Chào <strong><?php echo $shop_info->sho_name; ?></strong>! Bạn có 1 khiếu nại đơn hàng trên Azibai.com</p>
                                                            <p style="font-size:14px;color:#000">Nội dung: <?php echo $content;?></p>
                                                            <?php if($attachment): ?>
                                                            <p style="text-align:center">Hóa đơn vận chuyển: <br/><img src="<?php echo $attachment;?>"/></p>
                                                            <?php endif; ?>
                                                            <p style="font-size:14px;color:#000">
                                                                Để theo dõi đơn hàng khiếu nại , bạn vui lòng đăng nhập tài khoản quản trị Shop và vào mục Yêu cầu khiếu nại, đơn hàng số #<?php echo $order_id; ?> </p>
                                                            <p>Hoặc bạn có thể click nhanh từ link sau: <a href="<?php echo base_url().'account/complaintsOrdersForm/'.$delivery_id?>"><?php echo base_url().'account/complaintsOrdersForm/'.$delivery_id?></a></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="top" width="55%">
                                                            <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block"><a href="http://AZIBAI.COM" target="_blank">AZIBAI.COM</a>
                                                                <br><?php echo settingAddress_1; ?>
                                                                <br>Liên hệ: Số điện thoại <span style="color:#ff0000"><?php echo settingPhone;?></span> - Email <a href="mailto:+<?=settingEmail_1?>" style="color:#f00;text-decoration:none" target="_blank"> <?=settingEmail_1?></a> </p>
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
            </table>
        </div>
        <div class="yj6qo"></div>
        <div class="adL"></div>
    </div>
</div>