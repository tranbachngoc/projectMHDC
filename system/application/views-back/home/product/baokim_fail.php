<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>

<!--BEGIN: RIGHT-->

<td width="803" valign="top">
<div class="add_money_content">
<div class="text_header">
		<span class="title">Thanh toán</span>
		<span> thông qua cổng thanh toán Bao Kim</span>
</div>

<form method="post" action="<?php echo base_url(); ?>account/process_baokim/">
<div class="form-tab">
	<ul>
		    <li class="">
	        <div class="number left">
	        01    
	        </div>
	        <div class="tab-label">
	       Chọn sản phẩm	        </div>
	    </li>
		    <li class="">
	        <div class="number left">
	        02    
	        </div>
	        <div class="tab-label">
	       Xử lý	        </div>
	    </li>
		    <li class="selected">
	        <div class="number left">
	        03    
	        </div>
	        <div class="tab-label">
	       Hoàn thành	        </div>
	    </li>
		</ul>	
	<div class="clear"></div>	
</div>
<div class="form-content">
<div>
<h2> Quá trình thanh toán bị lỗi</h2>
Quá trình thanh toán của bạn chưa hoàn tất, chọn liên kết bên dưới để về trang chủ:
<ul>
<li><a href="<?php echo base_url()?>">Quay về trang chủ</a></li>
</ul> 
</div>
</div>
<div class="form-bottom"></div>

</form>
</div></td>

<?php $this->load->view('home/common/right'); ?>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
