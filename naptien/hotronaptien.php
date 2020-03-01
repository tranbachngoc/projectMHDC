<style>
body {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
h2 {
	color: #279fff;
	font-size: 14px;
	font-weight: bold;
	line-height: 22px;
	margin-bottom: 5px;
}
table{
	font-size:12px;
}
.price {
    color: #960000;
}
</style>
<h2>Hỗ trợ nạp tiền</h2>
<table cellspacing="3" cellpadding="3" align="center">
  <tbody>
    <tr>
      <td>
      <?php $protocol = $_SERVER['HTTPS'] ? "https" : "http";
 			$protocol = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$protocol = substr($protocol,0,strlen($protocol)-25);
		?>
      <img border="0" src="<?php echo ($protocol);?>/templates/home/images/baokim_charges_support.gif">
      </td>
      <td > Tiền nạp vào tài khoản <b>www.quahandmade.com</b> được dùng để chi trả các dịch vụ như: <b>Đăng tin rao vặt VIP</b>, <b>Siêu VIP</b>, <b>Hỏi đáp VIP</b>..v..v nhanh chóng thuận tiện và chủ động hơn.<br>
        <br>
        Gặp khó khăn khi nạp tiền? Quý khách vui lòng liên hệ số điện thoại <b class="price">090 9068 007</b></td>
    </tr>
  </tbody>
</table>
