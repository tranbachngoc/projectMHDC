<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<div class="col-md-9 col-sm-8 col-xs-12">
    <h4 class="page-header text-uppercase" style="margin-top:10px">
	Danh sách đơn hàng
    </h4>
    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
        <?php if(count($orders) > 0){ ?>
        <form name="frmAccountShowcart" method="post">
            <tr>
                <td width="5%" class="title_account_0"  class="aligncenter">STT</td>
                <td with="23%" class="title_account_2"  class="aligncenter">
                    <?php echo $this->lang->line('order_code'); ?>
                </td>
                <td  class="aligncenter">
                    Ngày đặt hàng
                </td>
            </tr>
            <?php $idDiv = 1; ?>
            <?php foreach($orders as $order_id => $order){ ?>
                <tr class="datarow" style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                    <td width="5%" height="32" class="aligncenter"><?php echo $sTT; ?></td>
                    <td width="20%" height="32" class="line_account_2">
                        <a class="menu_1"  href="<?php echo base_url(); ?>account/user_order/<?php echo $order->shc_orderid ?>" >
                            <?php echo $order->shc_orderid  ?>
                        </a>
                    </td>
                    <td  class="aligncenter">
                        <?php echo date('d-m-Y H:i:s', $order->shc_buydate) ?>
                    </td>
                </tr>
                <?php $idDiv++; ?>
                <?php $sTT++; ?>
            <?php } ?>
            <?php if(isset($linkPage) && !empty($linkPage)) { ?>
            <tr>
                <td class="show_page"><?php echo $linkPage; ?></td>
            </tr>
            <?php }?>
        </form>
        <?php }elseif(count($showcart) == 0 && trim($keyword) != ''){ ?>
            <tr>
                <td width="50" class="title_account_0">STT</td>
                <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountShowcart',0)" /></td>
                <td class="title_account_2">
                    <?php echo $this->lang->line('product_list'); ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                </td>
                <td width="125" class="title_account_1">
                    <?php echo $this->lang->line('cost_list'); ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                </td>
                <td width="95" class="title_account_2">
                    <?php echo $this->lang->line('quantity_list'); ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                </td>
                <td width="130" class="title_account_1">
                    <?php echo $this->lang->line('saler_list'); ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                </td>
                <td width="110" class="title_account_2">
                    <?php echo $this->lang->line('date_buy_list'); ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                </td>
                <td width="50" class="title_account_3"><?php echo $this->lang->line('process_list'); ?></td>
            </tr>
            <tr>
                <td class="none_record_search" align="center"><?php echo $this->lang->line('none_record_search_showcart_defaults'); ?></td>
            </tr>
            <tr>
                <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deleteshowcart_account.gif" onclick="" style="cursor:pointer;" border="0" /></td>
                <td align="center" id="boxfilter_account">
                    <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" />
                    <input type="hidden" name="search_account" id="search_account" value="name" />
                    <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/showcart/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                </td>
                <td width="30%" class="show_page"></td>
            </tr>
        <?php }else{ ?>
        <tr>
        	<td class="none_record" align="center"  >Không có đơn hàng nào</td>
		</tr>
        <?php } ?>
    </table>
</div>
</div>
</div>
 <input id="baseUrl" type="hidden" value="<?php echo base_url()?>"  />				
<!--END RIGHT--> 
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successAddShowcart) && trim($successAddShowcart) != ''){ ?>
<script>
alert('<?php echo $successAddShowcart; ?>');</script>
<?php } ?>