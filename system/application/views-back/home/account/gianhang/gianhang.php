 <?php $this->load->view('home/common/header'); ?>
 <div class="container">
     <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
 <div class="col-lg-9 col-md-9 col-sm-8">
    <table class="table table-bordered"  border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules">Chọn Giao Diện Cho Gian Hàng</div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" valign="top" >
        <div align="center" class="content">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/move/views-home-account-gianhang-gianhang.css" />
<div align="center" style="font-size:12px; font-weight:bold">
	<div style="color:#FF0000">Giao diện bạn đang sử dụng</div>
	<img vspace="5" src="../images/themes/standard_vang.jpg"/>
	<div>Cơ bản (Vàng)</div>
</div>
<hr size="1" style="border:1px #DDDDDD solid">
<script src="/js/tooltip.js" type="text/javascript"></script><div id="dhtmltooltip" style="left: -1000px; top: 406px; visibility: hidden;"><b>Click vào để chọn giao diện cho gian hàng của bạn.</b></div><img src="/images/tooltiparrow.gif" id="dhtmlpointer" style="left: 434px; top: 392px; visibility: hidden;"/>
<script type="text/javascript">
var	stt = 0;
function add_theme(key, value, img, icon){
	stt++;
	document.write('&lt;div&gt;&lt;a onmouseover="showtip(\'&lt;b&gt;Click vào để chọn giao diện cho gian hàng của bạn.&lt;/b&gt;\')" onmouseout="hidetip();" href="#" onclick="javascript:if(confirm(\'Bạn có muốn chọn giao diện này cho gian hàng của mình không?\')) window.location.href=\'theme_view.php?nThe=' + key + '\'; return false;"&gt;&lt;img border="0" src="' + img + '" /&gt;&lt;br /&gt;&lt;span style="color:#FF0000"&gt;' + stt + '.&lt;/span&gt; ' + value + icon + '&lt;/a&gt;&lt;/div&gt;');
}
function locked_theme(key, value, img, icon){
	stt++;
	document.write('&lt;div&gt;&lt;a onmouseover="showtip(\'&lt;b style=color:#FF0000&gt;Giao diện này chỉ dành cho gian hàng đảm bảo.&lt;/b&gt;&lt;br /&gt;Để trở thành gian hàng đảm bảo, xin bạn vui lòng liên hệ:&lt;div&gt;0973.868.996&lt;/div&gt;\')" onmouseout="hidetip();" href="#" onclick="javascript:alert(\'Giao diện này chỉ dành cho gian hàng đảm bảo!\\nĐể trở thành gian hàng đảm bảo, xin bạn vui lòng liên hệ:\\n0973.868.996\'); return false;"&gt;&lt;div class="locked"&gt;&lt;/div&gt;&lt;img class="transparent" border="0" src="' + img + '" /&gt;&lt;br /&gt;&lt;span style="color:#FF0000"&gt;' + stt + '.&lt;/span&gt; ' + value + icon + '&lt;/a&gt;&lt;/div&gt;');
}
</script>
<table cellspacing="0" cellpadding="0" align="center" class="theme_table">
	<tbody><tr>
			<td>
				
					</td>
			<td>
					
					</td>
			<td>
					
					</td>
		</tr>

</tbody></table>
</div>
        
        
        
        
  </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_ac.png" height="16" ></td>
        </tr>
    </table>
     </div>
         </div>
     </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>