<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
 <script type="text/javascript">
	$(function() {
		$('#btndichvu').click(function(){			
			$.ajax({
			  url: "<?php echo base_url() ?>administ/test/update_status_package_user",
			}).done(function() {
				console.log('Đã cập nhật trạng thái');	
			});
		});
	});
	
	function runTest(){
		window.open("<?php echo base_url() ?>cron/commission");
	}
</script>
<tr>
    <td valign="top">
		<table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top">
                <div style="color:#06C"><?php if($type != ''){ ?>
               	 <?php echo $type; ?>
                <?php } ?>
                </div>
                    <!--BEGIN: Main-->
					<table>
					<tr>
					   <td class="dichvu">
						<a href="<?php echo base_url() ?>administ/test/reset/service"><button id="btndichvu" style="padding: 20px; margin:20px">Thiết lập dữ liệu test Giải pháp</button></a>
					   </td>
					   <td class="donhang">
						<a href="<?php echo base_url() ?>administ/test/reset/order"><button style="padding: 20px; margin:20px">Thiết lập dữ liệu test cho Đơn hàng</button></a>
					   </td>
                       <td class="donhang">
						<a href="<?php echo base_url() ?>administ/test/reset/truncate"><button style="padding: 20px; margin:20px">Xóa dữ liệu tính hoa hồng</button></a>
					   </td>
					   <td class="hoahong">
						<button onclick="runTest()" style="padding: 20px; margin:20px">Tính hoa hồng</button>
					   </td>
					</tr>  
					</table>
                    <!--END Main-->
                </td>
                <td width="10" class="right_main" valign="top"></td>
                <td width="2"></td>
            </tr>
            <tr>
                <td width="2" height="11"></td>
                <td width="10" height="11" class="corner_lb_main" valign="top"></td>
                <td height="11" class="middle_bottom_main"></td>
                <td width="10" height="11" class="corner_rb_main" valign="top"></td>
                <td width="2" height="11"></td>
            </tr>
        </table>			
	</td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>