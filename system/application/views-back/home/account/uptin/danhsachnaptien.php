<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<div class="col-lg-9">
<td valign="top"><table class="table table-bordered " width="100%" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td><div class="tile_modules tile_modules_blue">
          <div class="fl"></div>
          <div class="fc"> Danh sách đơn đặt  nạp tiền </div>
          <div class="fr"></div>
        </div></td>
    </tr>
    <tr>
      <td   valign="top"><!--BEGIN: Content-->
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="25" class="title_list title_list1">STT</td>
            <td class="title_list" width="130"  > Mã đơn hàng </td>
            <td class="title_list" > UserName </td>
            <td class="title_list" width="200"> Số Tiền </td>
            <td class="title_list" width="130"> Thời gian tạo </td>
            <td class="title_list"> Kiểu TT </td>
            <td width="130" class="title_list" > Trạng Thái </td>
          </tr>
          <?php foreach($lichsugiaodich as $key=>$row){ 
									
									?>
          <tr style="background:#<?php if($key % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $key; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $key; ?>',<?php echo $key; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $key; ?>',<?php echo $key; ?>,2)">
            <td class="detail_list" style="text-align:center;"><b><?php echo ($key+1); ?></b></td>
            <td class="detail_list" style="text-align:center;">DD<?php echo   $row->soh_id; ?></td>
            <td class="detail_list" style="text-align:center;"><?php echo   $row->soh_username; ?></td>
            <td class="detail_list" style="text-align: right;"><?php echo number_format($row->soh_money, 0, '.', '.');  ?> VNĐ </td>
            <td class="detail_list"><?php echo date('H:i,d-m-Y', $row->soh_created_date); ?></td>
            <td class="detail_list detail_list2" style="text-align:center"><?php if($row->soh_type==1){ ?>
              Nạp từ thẻ
              <?php } ?>
              <?php if($row->soh_type==2){ ?>
              Thu tiền tận nơi <br />
              Thời gian thu : <span style=" color:#F00; font-weight:bold;"><?php echo $row->soh_am_pm ?>   <?php echo $row->soh_week ?> </span>
              <?php } ?>
              <?php if($row->soh_type==3){ ?>
              Tại trụ sở               
              <?php } ?>
              <?php if($row->soh_type==4){ ?>
              Chuyển khoản <br/>
              Tại ngân hàng <span style="text-transform:uppercase; color:#F00; font-weight:bold;"><?php echo $row->soh_bank; ?></span>
              <?php } ?>              
              </td>
            <td class="detail_list"><?php if($row->soh_status==1) { ?>
              Thanh toán xong
              <?php } else { ?>
              Chờ thanh toán
              <br />
              <?php if($row->soh_type==4) {  ?>
					  <?php if($row->soh_confirmed == 1) { ?>
                      <a href="<?php echo base_url() ;?>account/danhsachnaptien/deactive/<?php echo $row->soh_id ?>">[ Hủy Xác nhận CK ]</a>
                      <?php }  else { ?>
                      
                      <a href="<?php echo base_url() ;?>account/danhsachnaptien/active/<?php echo $row->soh_id ?>">[ Xác nhận CK ]</a>
                      <?php } } ?>
              <?php } ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td  colspan="9" align="right" style="padding-top:10px; padding-right:10px;"> Tổng tiền : <font style="font-weight:bold; color:#F00"><?php echo number_format($tongtienthanhtoan->tongtien, 0, '.', '.'); ?> VNĐ </font></td>
          </tr>
          <tr>
            <td class="show_page" colspan="9"><?php echo $linkPage; ?></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td><div class="border_bottom_blue">
          <div class="fl"></div>
          <div class="fr"></div>
        </div></td>
    </tr>
  </table></td>
    </div>
        </div>
    </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
