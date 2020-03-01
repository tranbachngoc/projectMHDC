<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
	<div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<div class="<?php echo ($this->session->userdata('sessionGroup') == AffiliateStoreUser) ? 'col-md-12' : 'col-md-9' ?> col-xs-12">
<td width="803" valign="top">
<div class="add_money_content">
<div class="text_header">
		<span class="title">Nạp tiền</span>
		<span>vào tài khoản thông qua cổng thanh toán Bao Kim</span>
</div>

<form method="post" action="<?php echo base_url(); ?>account/process_baokim/">
<div class="form-tab">
	<ul>
		    <li class="">
	        <div class="number left">
	        01    
	        </div>
	        <div class="tab-label">
	       Nhập Số tiền	        </div>
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
Quá trình thanh toán của bạn chưa hoàn tất, chọn các hành động sau:
<ul>
<li><a href="<?php echo base_url()."account/naptien" ?>">Thực hiện lại quá trình nạp tiền</a></li>
<li><A href="<?php echo base_url()."account/lichsugiaodich" ?>">Xem lịch sử giao dịch</a></li>
<li><a href="<?php echo base_url()?>">Quay về trang chủ</a></li>
</ul> 
</div>
</div>
<div class="form-bottom"></div>

</form>
</div></td>
</tr>

</table>
</td>
	</div>
		</div>
	</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
