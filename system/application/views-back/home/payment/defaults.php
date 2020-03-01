<?php $this->load->view('home/common/account/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->

<td width="602" valign="top">
    <form name="frmShowCart" method="post" action="<?php echo base_url(); ?>showcart">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
      <?php $this->load->view('home/advertise/center1'); ?>
      <tr>
        <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30"><div class="tile_modules"><?php echo $this->lang->line('title_defaults'); ?></div></td>
      </tr>
      <?php if(isset($productShowcart) && count($productShowcart) > 0){ ?>
      <tr>
        <td background="<?php echo base_url(); ?>templates/home/images/bg_showcart.jpg" height="29"><table align="center" width="580" height="29" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="25" class="title_showcart_0">STT</td>
              <td width="30" class="title_showcart_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(document.frmShowCart.checkall.checked,'frmShowCart',0)">
              </td>
              <td class="title_showcart_2"><?php echo $this->lang->line('product_list'); ?> <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc')" border="0" style="cursor:pointer;" alt="" /> <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc')" border="0" style="cursor:pointer;" alt="" /> </td>
              <td width="130" class="title_showcart_3"><?php echo $this->lang->line('cost_list'); ?> <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc')" border="0" style="cursor:pointer;" alt="" /> <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc')" border="0" style="cursor:pointer;" alt="" /> </td>
              <td width="60" class="title_showcart_2"><?php echo $this->lang->line('quantity_list'); ?> </td>
              <td width="145" class="title_showcart_4"><?php echo $this->lang->line('equa_currency_list'); ?> </td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td  ><table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
            <?php $idDiv = 1;
					$total=0; ?>
            <?php foreach($productShowcart as $productShowcartArray){ 
					$total=$total+$productShowcartArray->pro_cost;
					?>
            <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowShowcart_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowShowcart_<?php echo $idDiv; ?>','<?php echo $idDiv; ?>',1)" onmouseout="ChangeStyleRow('DivRowShowcart_<?php echo $idDiv; ?>','<?php echo $idDiv; ?>',2)">
              <td width="25" height="32" class="line_showcart_0" ><?php echo $idDiv; ?></td>
              <td width="30" height="32" class="line_showcart_1"><input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $productShowcartArray->pro_id; ?>" onclick="DoCheckOne('frmShowCart')">
              </td>
              <td height="32" class="line_showcart_2" style="padding-left:5px; padding-right:5px; font-weight:bold;"><a class="menu_1" href="<?php echo base_url(); ?><?php echo $productShowcartArray->pro_category; ?>/<?php echo $productShowcartArray->pro_id; ?>/<?php echo RemoveSign($productShowcartArray->pro_name); ?>" onmouseover="ddrivetip('<table border=0 width=300 cellpadding=1 cellspacing=0><tr><td width=\'20\' valign=\'top\' align=\'left\'><img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $productShowcartArray->pro_dir; ?>/<?php echo show_thumbnail($productShowcartArray->pro_dir, $productShowcartArray->pro_image); ?>\' class=\'image_top_tip\'></td><td valign=\'top\' align=\'left\'><?php echo $productShowcartArray->pro_descr; ?></td></tr></table>',300,'#F0F8FF');" onmouseout="hideddrivetip();"> <?php echo sub($productShowcartArray->pro_name, 30); ?> </a> </td>
              <td width="126" height="32" class="line_showcart_3"><?php if(strtoupper($productShowcartArray->pro_currency) == 'VND'){ ?>
                <input type="hidden" name="CostVNDShowCart<?php echo $idDiv; ?>" id="CostVNDShowCart<?php echo $idDiv; ?>" value="<?php echo $productShowcartArray->pro_cost; ?>" />
                <span id="DivCost_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $productShowcartArray->pro_currency; ?>
                <script type="text/javascript">FormatCost('<?php echo $productShowcartArray->pro_cost; ?>', 'DivCost_<?php echo $idDiv; ?>');</script>
                <div style="display:none;" id="CostUSDShowCart<?php echo $idDiv; ?>" class="cost_usdshowcart"><span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?></div>
                <script type="text/javascript">FormatCost('<?php echo round((int)$productShowcartArray->pro_cost/settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>
                <?php }else{ ?>
                <input type="hidden" name="CostVNDShowCart<?php echo $idDiv; ?>" id="CostVNDShowCart<?php echo $idDiv; ?>" value="<?php echo round((int)$productShowcartArray->pro_cost*settingExchange); ?>" />
                <span id="DivCost_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>
                <script type="text/javascript">FormatCost('<?php echo round((int)$productShowcartArray->pro_cost*settingExchange); ?>', 'DivCost_<?php echo $idDiv; ?>');</script>
                <div id="CostUSDShowCart<?php echo $idDiv; ?>" class="cost_usdshowcart"><span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $productShowcartArray->pro_currency; ?></div>
                <script type="text/javascript">FormatCost('<?php echo $productShowcartArray->pro_cost; ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>
                <?php } ?>
              </td>
              <td width="60" height="32" align="center" valign="middle" class="line_showcart_2"><input type="text" name="QuantityShowcart[]" id="Quantity<?php echo $idDiv; ?>" value="1" maxlength="4" class="input_showcart" onkeyup="BlockChar(this,'NotNumbers'); SumCost('CostVNDShowCart<?php echo $idDiv; ?>','Quantity<?php echo $idDiv; ?>','SumCostVNDShowCart<?php echo $idDiv; ?>','SumCostUSDShowCart<?php echo $idDiv; ?>',<?php echo settingExchange; ?>); TotalCost('CostVNDShowCart','Quantity','TotalVNDShowCart','TotalUSDShowCart',<?php echo count($productShowcart); ?>,<?php echo settingExchange; ?>);" />
                <input type="hidden" name="IdProductShowcart[]" value="<?php echo $productShowcartArray->pro_id; ?>" />
              </td>
              <td width="141" height="32" class="line_showcart_4"><span id="SumCostVNDShowCart<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>
                <div style="display:none;" id="SumCostUSDShowCart<?php echo $idDiv; ?>" class="cost_usdshowcart"></div>
                <script>SumCost('CostVNDShowCart<?php echo $idDiv; ?>','Quantity<?php echo $idDiv; ?>','SumCostVNDShowCart<?php echo $idDiv; ?>','SumCostUSDShowCart<?php echo $idDiv; ?>',<?php echo settingExchange; ?>);</script>
              </td>
            </tr>
            <?php $idDiv++; ?>
            <?php $backCategory = $productShowcartArray->pro_category; ?>
            <?php } ?>
          </table>
          <script>ResetQuantity('Quantity',2);</script>
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td width="32%" id="delete_showcart"><img src="<?php echo base_url(); ?>templates/home/images/icon_deleteshowcart.gif" onclick="ActionDeleteShowcart()" style="cursor:pointer;" border="0" /></td>
              <td align="center" id="submit_showcart"><input type="button" onclick="return ActionEqual('<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" name="submit_showcart"  value="<?php echo $this->lang->line('button_cacul_defaults'); ?>" class="button_form" />
              </td>
              <td width="10" id="submit_showcart"></td>
              <td align="center" id="submit_showcart"><input type="button" name="conti_showcart" onclick="ActionLink('<?php echo base_url(); ?><?php if(isset($backCategory) && (int)$backCategory > 0){echo $backCategory;} ?>')" value="<?php echo $this->lang->line('button_next_buy_defaults'); ?>" class="button_form" />
              </td>
              <td width="32%" align="right" valign="bottom" id="total_showcart"><?php echo $this->lang->line('total_cost_showcart_defaults'); ?>:&nbsp;&nbsp;
                <input type="hidden"  name="totalPrice" id="totalPrice" value=""/>
                <span id="TotalVNDShowCart"></span><br />
                <span id="TotalUSDShowCart" style="display:none;"></span>
                <script>TotalCost('CostVNDShowCart','Quantity','TotalVNDShowCart','TotalUSDShowCart',<?php echo count($productShowcart); ?>,<?php echo settingExchange; ?>);</script>
              </td>
            </tr>
          </table></td>
      </tr>
      <?php }else{ ?>
      <tr>
        <td class="none_record"  ><?php echo $this->lang->line('none_record_showcart_defaults'); ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.png" height="16" ></td>
      </tr>
      <?php $this->load->view('home/advertise/footer'); ?>
    </table>
  </form>
  <div class="payment">
    <?php if(isset($isLogined) && $isLogined == true):?>
    da dang nhap
    <?php else:?>
    <div class="login_form">
      <h3><?php echo $this->lang->line('login_message');?></h3>
      <form name="frmLoginPage" method="post" id="frmLoginPage" action="<?php echo base_url(); ?>login">
        <?php echo $this->lang->line('username_defaults'); ?>:
        <input type="text" name="UsernameLogin" id="UsernameLogin" maxlength="35" class="input_form" style="width:180px;" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('UsernameLogin',1)" onblur="ChangeStyle('UsernameLogin',2); lowerCase(this.value,'UsernameLogin');" />
        <?php echo $this->lang->line('password_defaults'); ?>:
        <input type="password" name="PasswordLogin" id="PasswordLogin" maxlength="35" class="input_form" style="width:180px;" onfocus="ChangeStyle('PasswordLogin',1)" onblur="ChangeStyle('PasswordLogin',2) ;" />
        <input type="button" onclick="CheckInput_Login_Page();" name="submit_login" value="<?php echo $this->lang->line('button_login_defaults'); ?>" class="button_form" />
      </form>
    </div>
    <?php endif;?>
    <div class="customer_detail">
    <?php if(isset($step) && $step == 2):?>
    
    ????
    <?php else:?>
	
      <form name="frmBuyerPage" method="post" id="frmBuyerPage" action="<?php echo base_url(); ?>payment/1">
        <h3><?php echo $this->lang->line('custommer_detail');?></h3>
        <div class="fl left">
          <div id="ttndh" class="text_title">A - Thông tin người đặt hàng</div>
          <table cellspacing="0" cellpadding="0" align="center" class="form_table">
            <tbody>
              <tr>
                <td class="form_name"><font class="form_asterisk">* </font>Tên người đặt hàng :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_name" id="ord_name" title="Tên người đặt hàng" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name"><font class="form_asterisk">* </font>Địa chỉ :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_address" id="ord_address" title="Địa chỉ" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name"><font class="form_asterisk">* </font>Email :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_email" id="ord_email" title="Email" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name"><font class="form_asterisk">* </font>Điện thoại :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_phone" id="ord_phone" title="Điện thoại" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name">Di động :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_mobile" id="ord_mobile" title="Di động" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name">Fax :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_fax" id="ord_fax" title="Fax" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name">Ghi chú :</td>
                <td class="form_text"><textarea style="width: 250px; height: 65px;" name="ord_otherinfo" id="ord_otherinfo" title="Ghi chú" class="form_control"></textarea></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="fr right">
          <div id="ttnnh" class="text_title">B - Thông tin người nhận hàng</div>
          <table cellspacing="0" cellpadding="0" align="center" class="form_table">
            <tbody>
              <tr>
                <td></td>
                <td class="form_text"><input type="checkbox" onClick="checkSame(this.checked)" value="1" name="check_same" id="check_same">
                  <label for="check_same" class="text_link">Thông tin người nhận trùng với người đặt hàng</label></td>
              </tr>
              <tr>
                <td class="form_name"><font class="form_asterisk">* </font>Tên người nhận hàng :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_sname" id="ord_sname" title="Tên người nhận hàng" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name"><font class="form_asterisk">* </font>Địa chỉ :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_saddress" id="ord_saddress" title="Địa chỉ" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name"><font class="form_asterisk">* </font>Email :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_semail" id="ord_semail" title="Email" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name"><font class="form_asterisk">* </font>Điện thoại :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_sphone" id="ord_sphone" title="Điện thoại" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name">Di động :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_smobile" id="ord_smobile" title="Di động" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name">Fax :</td>
                <td class="form_text"><input type="text" maxlength="250" style="width: 250px;" value="" name="ord_sfax" id="ord_sfax" title="Fax" autocomplete="off" class="form_control"></td>
              </tr>
              <tr>
                <td class="form_name">Ghi chú :</td>
                <td class="form_text"><textarea style="width: 250px; height: 65px;" name="ord_sotherinfo" id="ord_sotherinfo" title="Ghi chú" class="form_control"></textarea></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="break_content" style="clear:both;"></div>
        <div class="temp_box_1">
          <div class="btn_submit">
            <div class="fl">Bạn hãy <b>kiểm tra kỹ</b> thông tin trước khi tiếp tục.</div>
            <div class="fr">
              <input type="submit" value="Tiếp theo bước 2" class="form_button">
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </form>
      <?php endif;?>
    </div>
  </div>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($fullProductShowcart) && $fullProductShowcart == true){ ?>
<script>alert('<?php echo $this->lang->line('full_product_showcart_defaults'); ?>');</script>
<?php } ?>
