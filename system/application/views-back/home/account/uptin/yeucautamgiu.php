<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<div class="col-lg-9">
    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" >
        <tr>
            <td>
                <div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc">
				DANH SÁCH YÊU CẦU THANH TOÁN TẠM GIỮ
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
         <tr>
            <td >
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="46" class="title_account_0">STT</td>
                        <td height="32" class="line_account_2">
                           Username                            
                        </td>
                        <td width="200" height="32" class="line_account_3" style="text-align:center;">
                        Họ và Tên 
                        </td>
                        <td width="200" height="32" class="line_account_4">
                           Địa chỉ
                        </td>
                        <td width="200" height="32" class="line_account_1">
                            Điện thoại
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td >
           <?php if(count($users)>0): ?>
            	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; $sTT=1; ?>
                    <?php foreach($users as $user){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="46" height="32" class="line_account_0"><?php echo $sTT; ?></td>
                       
                        <td height="32" class="line_account_2">
                            <a class="menu_1" href="<?php echo base_url(); ?>user/profile/<?php echo $user->use_id; ?>" >
                                <?php echo $user->use_username; ?>
                            </a>
                            
                        </td>
                        <td width="200" height="32" class="line_account_3" style="text-align:center;">
                            <?php echo $user->use_fullname; ?>
                        </td>
                        <td width="200" height="32" class="line_account_4">
                             <?php echo $user->use_address; ?>
                        </td>
                        <td width="200" height="32" class="line_account_1">
                            <?php echo $user->use_mobile; ?>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php $sTT++; ?>
                    <?php } ?>
                </table>
				<?php else: ?>
                
                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                   
                    <tr >
                        <td style="padding:15px; font-size:13px;">
						Không có yêu cầu nào
						</td>
                                               
                    </tr>
                 
                </table>
                
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>
            	<div class="border_bottom_blue">
                	<div class="fl"></div>
                    <div class="fr"></div>
                </div>
            </td>
        </tr>
    </table>
</div>
        </div>
    </div>
<?php $this->load->view('home/common/footer'); ?>
