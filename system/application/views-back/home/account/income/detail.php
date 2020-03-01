
<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>

        <!--BEGIN: RIGHT-->

        <div class="<?php echo ($this->session->userdata('sessionGroup') == AffiliateStoreUser) ? 'col-md-12' : 'col-md-9' ?> col-xs-12">
           <div style="background-color: #fff">
	    <h2 class="page-title text-uppercase text-center">
                   Chi tiết thu nhập theo tuần
               </h2>
               <div class="info_income">
                   <div class="text-right">Tổng tiền sau thuế: <span class="red_money"><?php
                           echo number_format($money->amount,0,",",".");
                           ?> đ </span> </div>
                   <div>Từ thứ 4, ngày: <b><i><?php echo date('d/m/Y', $m_start); ?></i></b> đến thứ 4, ngày: <b><i><?php echo date('d/m/Y', $m_end); ?></i></b></div>
               </div>
               <?php
               switch($money->type){
                   case '06': ?>
                       <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                           <?php if(count($showcart) > 0){ ?>
                               <thead>
                               <tr class="v_height29">
                                   <th width="5%" class="hidden-xs">STT</th>
                                   <th width="20%" >
                                       Sản phẩm
                                   </th>
                                   <th width="15%">
                                       Gian hàng
                                   </th>
                                   <th width="15%">
                                       Số lượng
                                   </th>
                                   <th width="15%" >
                                       Hoa hồng
                                   </th>
                                   <th width="15%" >
                                       Tiền bán được
                                   </th>
                                   <th width="15%" >
                                       Tiền hoa hồng
                                   </th>
                               </tr>
                               </thead>
                               <tbody>
                               <?php $idDiv = 1;
                               ?>
                               <?php foreach($showcart as $item){ ?>
                                   <tr>
                                       <td height="32" class="hidden-xs" ><?php echo $sTT; ?></td>
                                       <td height="32">
                                           <a href="<?php echo base_url();?><?php echo  $item->pro_category ;?>/<?php echo  $item->pro_id ;?>/<?php  echo RemoveSign($item->pro_name); ?>" target="_blank"><?php  echo $item->pro_name; ?></a>
                                           <?php if($item->pro_sku !=''){ ?><div><i>Mã SP: <?php  echo $item->pro_sku; ?> </i></div> <?php } ?>
                                       </td>
                                       <td height="32" align="center">
                                           <a href="<?php echo base_url();?><?php echo  $item->sho_link ;?>" target="_blank"><?php  echo $item->sho_name; ?></a>
                                       </td>
                                       <td  height="32" align="center">
                                           <?php  echo $item->shc_quantity; ?>
                                       </td>
                                       <td height="32" >
                                           <?php if($item->af_amt > 0){ ?>
                                               <span class="black_money"><?php echo number_format($item->af_amt,0,",",".") ." đ"; ?></span> / 1 sp

                                           <?php } ?>
                                           <?php if($item->af_rate > 0){ ?>
                                               <span class="black_money"><?php echo $item->af_rate." %";  ?></span>
                                           <?php } ?>
                                       </td>
                                       <td height="32" >
                                           <span class="black_money"><?php  echo number_format($item->shc_total,0,",","."); ?> đ</span>
                                       </td>
                                       <td height="32" >
                                           <?php if($item->af_amt > 0){ ?>
                                               <span class="red_money"><?php echo number_format($item->af_amt * $item->shc_quantity,0,",","."); ?> đ</span>
                                           <?php }  ?>
                                           <?php if($item->af_rate > 0){ ?>
                                               <span class="red_money"><?php echo number_format($item->shc_total * ($item->af_rate / 100),0,",","."); ?> đ</span>
                                           <?php }  ?>
                                       </td>
                                   </tr>
                                   <?php $idDiv++; ?>
                                   <?php $sTT++; ?>
                               <?php } ?>
                               <?php if(!empty($linkPage)){?>
                                   <tr>
                                       <td>
                                           <?php echo $linkPage; ?>
                                       </td>
                                   </tr>
                               <?php } ?>
                               </tbody>
                           <?php }else{ ?>
                               <tr>
                                   <td colspan="7" align="center">
                                       <div class="nojob">Không có dữ liệu!</div>
                                   </td>
                               </tr>
                           <?php } ?>
                           </tbody>
                       </table>

                       <?php break;  ?>
                   <?php case '07': ?>
                   <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                       <?php
                       $af_money = array();
                       if(count($showcart) > 0) {
                           ?>
                           <thead>
                           <tr class="v_height29">
                               <th width="5%" class="hidden-xs">STT</th>
                               <th width="20%" >
                                   Sản phẩm
                               </th>
                               <th width="15%">
                                   Mã đơn hàng
                               </th>
                               <th width="15%">
                                   Số lượng
                               </th>
                               <th width="15%" >
                                   Đơn giá
                               </th>
                               <th width="15%" >
                                   Danh mục
                               </th>

                               <th width="15%" >
                                   Tổng tiền
                               </th>
                           </tr>
                           </thead>
                           <tbody>
                           <?php $idDiv = 1;
                           $sumTotal = 0;
                           $sumAF = 0;
                           $sumAzibai = 0;
                           ?>
                           <?php foreach($showcart as $item){
                               $sumTotal = $sumTotal + $item->shc_total;
                               if($item->af_id > 0){
                                   if($item->af_amt > 0){
                                       $af_money_item = array('money' => $item->shc_quantity * $item->af_amt, "money_str" => $item->shc_quantity."*".$item->af_amt,'pro_name' => $item->pro_name);
                                   }elseif($item->af_rate > 0){
                                       $af_money_item = array('money' => ($item->af_rate / 100) * $item->shc_total, "money_str" => "(".$item->af_rate ."/100".")*". $item->shc_total,'pro_name' => $item->pro_name);
                                   }
                                   $sumAF += $af_money_item['money'];
                                   array_push($af_money, $af_money_item);
                               }

                               ?>
                               <tr>
                                   <td height="32" class="hidden-xs" ><?php echo $sTT; ?></td>
                                   <td height="32">
                                       <a href="<?php echo base_url();?><?php echo  $item->pro_category ;?>/<?php echo  $item->pro_id ;?>/<?php  echo RemoveSign($item->pro_name); ?>" target="_blank"><?php  echo $item->pro_name; ?></a>
                                       <?php if($item->pro_sku !=''){ ?><div><i>Mã SP: <?php  echo $item->pro_sku; ?> </i></div> <?php } ?>
                                   </td>
                                   <td height="32" align="center">
                                       <!--                                <a href="--><?php //echo base_url();?><!--user/profile/--><?php //echo  $item->use_id ;?><!--" target="_blank">--><?php // echo $item->use_username; ?><!--</a>-->
                                       <a href="<?php echo base_url().'account/order_detail/'.$item->shc_orderid; ?>" style="font-size: 13px; font-weight: 600" class="text-info"><i># <?php echo $item->shc_orderid; ?></i></a>
                                   </td>
                                   <td  height="32" align="center">
                                       <?php  echo $item->shc_quantity; ?>
                                   </td>
                                   <td height="32" >
                                       <span class="black_money"><?php  echo number_format($item->pro_price,0,",","."); ?> đ</span>
                                   </td>
                                   <td height="32" >
                                       <?php /* if($item->af_amt > 0){ ?>
                                    <span class="black_money"><?php echo number_format($item->af_amt,0,",",".") ." đ"; ?></span> / 1 sp

                                <?php } ?>
                                <?php if($item->af_rate > 0){ ?>
                                <span class="black_money"><?php echo $item->af_rate." %";  ?></span>
                                <?php } */ ?>
                                       <?php echo $categories[$item->pro_category]; ?>

                                   </td>

                                   <td height="32" >
                                       <span class="red_money"><?php echo number_format($item->shc_total,0,",","."); ?> đ </span>
                                   </td>
                               </tr>
                               <?php $idDiv++; ?>
                               <?php $sTT++; ?>
                           <?php } ?>


                           </tbody>
                       <?php }else{ ?>
                           <tr>
                               <td colspan="7" align="center">
                                   <div class="nojob">Không có dữ liệu!</div>
                               </td>
                           </tr>
                       <?php } ?>
                       </tbody>
                   </table>
                   <?php if(!empty($linkPage)){?>
                           <?php echo $linkPage; ?>
                   <?php } ?>
                   <?php if(count($revenue) > 0){ ?>
                       <h3> Doanh thu theo danh mục </h3>
                       <!-- Thong bao duoc giam gia -->
              <?php if($discountShop > 0) {?>                
                <div class="message success">
                    <div class="alert alert-success">
                        <i class="fa fa-info-circle" aria-hidden="true"></i> Gian hàng của bạn được ưu đãi đặc biệt <b><?php echo $discountShop; ?>%</b> phí bán sỉ và bán lẻ trên Azibai. (Đã chiết khấu vào Hoa hồng cho Azibai)                   
                                <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
                    </div>
                </div>
                <?php } ?>
                       <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">

                           <thead>
                           <tr class="v_height29">
                               <th width="5%" class="hidden-xs">STT</th>
                               <th width="20%" >
                                   Danh mục
                               </th>
                               <th width="15%">
                                   Doanh thu
                               </th>
                               <th width="15%">
                                   Phần trăm hoa hồng
                               </th>
                               <th width="15%" >
                                   Hoa hồng cho Azibai
                               </th>
                               <th width="15%" >
                                   Doanh thu (trừ hoa hồng cho Azibai)
                               </th>
                           </tr>
                           </thead>
                           <tbody>

                           <?php
                           $f = 0;
                           foreach ($revenue as $key => $value) {
                               $f++;
                               $sumAzibai += $value->rsc_profit;
                               ?>
                               <tr>
                                   <td>
                                       <?php echo $f; ?>
                                   </td>
                                   <td>
                                       <?php echo $categories[$value->rsc_category_id]; ?>
                                   </td>
                                   <td>
                                       <?php echo number_format($value->rsc_revenue,0,",","."); ?> đ
                                   </td>
                                   <td>
                                       <?php echo $value->rsc_percent; ?> %
                                   </td>
                                   <td>
                                       <?php echo number_format($value->rsc_profit,0,",","."); ?> đ
                                   </td>
                                   <td>
                            <span class="red_money">
                                <?php echo  number_format(($value->rsc_revenue - $value->rsc_profit),0,",","."); ?> đ

                                </span>

                                   </td>
                               </tr>
                           <?php } ?>

                           </tbody>


                       </table>
                   <?php } ?>

                   <?php
                   if(count($af_money) > 0){

                       ?>
                       <h3> Hoa hồng cho Cộng Tác Viên </h3>
                       <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">

                           <thead>
                           <tr class="v_height29">
                               <th width="5%" class="hidden-xs">STT</th>
                               <th width="30%" >
                                   Sản phẩm
                               </th>
                               <th width="65%">
                                   Hoa hồng cho Cộng Tác Viên
                               </th>

                           </tr>
                           </thead>
                           <tbody>

                           <?php
                           $f = 0;
                           foreach ($af_money as $key => $value) {
                               $f++;
                               ?>
                               <tr>
                                   <td>
                                       <?php echo $f; ?>
                                   </td>
                                   <td>
                                       <?php echo $value['pro_name']; ?>
                                   </td>
                                   <td>
                                        <span class="red_money">
                                             <?php echo $value['money_str']." = ".number_format($value['money'],0,",","."); ?> đ
                                        </span>
                                   </td>

                               </tr>
                           <?php } ?>

                           </tbody>


                       </table>
                   <?php } ?>
                   <div style="float:right; text-align:right;">
                       <div class="income-line">Tổng tiền bán hàng : <span class="black_money"><?php echo number_format($sumTotal,0,",",".") ?> đ</span></div>
                       <div class="income-line">Hoa hồng trả cho Azibai: <span class="black_money"><?php echo number_format($sumAzibai,0,",",".") ?> đ</span></div>
                       <?php if ($sumAF > 0) { ?>  <div class="income-line">Tổng tiền trả cho Cộng Tác Viên: <span class="black_money"><?php echo number_format($sumAF,0,",",".") ?> đ</span></div>
                       <?php } ?>
                       <div class="income-line">Tổng tiền nhận được: <span class="red_money"><?php echo number_format($sumTotal - $sumAF - $sumAzibai,0,",",".") ?> đ</span></div>
                   </div>
                   <?php break; ?>




               <?php } ?>
           </div>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
