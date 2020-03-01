<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<script>
jQuery(document).ready(function(){
	jQuery(".payment_baokim_table .col").hover(function(){
		jQuery(this).css("border-color","#279fff");
	}, function(){
		jQuery(this).css("border-color","#A3D6FF");
	});
	jQuery('a#popup_box').each(function(index) {
		jQuery(this).fancybox({
			'width'				: '50%',
			'height'			: '50%',
			'autoScale'			: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});
	});
});
</script>
<!--BEGIN: RIGHT-->
<div class="col-lg-9 col-md-9 col-sm-8">
<div class="add_money_content">
    <!-- sunguyen add-->
    <form method="post" action="<?php echo base_url(); ?>account/shop">
    <div class="classic-popup-main_eb">
      <div class="classic-popup-title_eb">
        <div class="fl_eb"><?php echo $this->lang->line('noi_quy_gian_hang'); ?></div>
       
        <div class="c_eb"></div>
      </div>
      <div class="classic-popup-content_eb">
        <div class="content_eb" style="padding: 0pt 0pt 10px;">
          
           <?php $contentFooter=Counter_model::getArticle(noi_quy_gian_hang); echo html_entity_decode($contentFooter->not_detail);?>
          
          
          <div class="c_eb"></div>
          <div align="center_eb" style="padding-bottom: 20px;" class="mRight20_eb">
            <div class="mTop10_eb"><a  style="float: right;" onclick="" class="blueButton_eb"><span><span><input type="submit" value="Đồng ý"  /> <b>»</b></span></span></a><a href="javascript:history.go(-1)" style="float: right;" class="blueButton_eb mRight20_eb"><span></span></a></div>
            <div class="c_eb"></div>
          </div>
        </div>
      </div>
    </div>
    </form>
    <!-- sunguyen add -->
<!--    <table cellspacing="10" cellpadding="0" align="center" class="payment_baokim_table k_payment_baokim_table">
      <tbody>
        <tr>
          <td id="payment_method_6" class="col"><div class="payment_baokim_content">
              <div class="name">Sử dụng số dư tài khoản Bảo Kim</div>
              <div class="picture"><a rel="nofollow" href="<?php echo base_url(); ?>account/naptien_baokim/"><img src="<?php echo base_url(); ?>templates/home/images/logo_baokim.gif"></a></div>
            </div></td>
          <td id="payment_method_9" class="col"><div class="payment_baokim_content">
              <div class="name">Nhắn tin SMS</div>
              <div style="margin-top: 30px" class="picture"><a href="<?php echo base_url(); ?>naptien/nhantinsms.php" id="popup_box"><img src="<?php echo base_url(); ?>templates/home/images/baokim_charges_sms.gif"></a></div>
            </div></td>
          <td id="payment_method_8" class="col"><div class="payment_baokim_content">
              <div class="name">Hỗ trợ nạp tiền</div>
              <div style="margin-top: 20px;" class="picture"><a href="<?php echo base_url(); ?>naptien/hotronaptien.php" id="popup_box"><img src="<?php echo base_url(); ?>templates/home/images/baokim_charges_support.gif"></a></div>
            </div></td>
        </tr>
      </tbody>
    </table>-->
    <script type="text/javascript">
jQuery(".prev_button").click(function(){
iData = jQuery(this).attr("iData");
current_page= parseInt(jQuery("#current_panel_" + iData).html());
current_page= current_page - 1;
if(current_page &lt;= 0) return;

jQuery("#current_panel_" + iData).html(current_page);
jQuery("#payment_method_" + iData + " .block").hide();
jQuery("#payment_method_" + iData + " .block:eq(" + (current_page - 1) + ")").fadeIn();
});

jQuery(".next_button").click(function(){
iData = $(this).attr("iData");
current_page= parseInt(jQuery("#current_panel_" + iData).html());
current_page= current_page + 1;
if(current_page &gt; jQuery("#payment_method_" + iData + " .block").length) return;

jQuery("#current_panel_" + iData).html(current_page);
jQuery("#payment_method_" + iData + " .block").hide();
jQuery("#payment_method_" + iData + " .block:eq(" + (current_page - 1) + ")").fadeIn();
});
</script>
  </div></td>
</tr>
</table>
    </div>
        </div>
    </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
