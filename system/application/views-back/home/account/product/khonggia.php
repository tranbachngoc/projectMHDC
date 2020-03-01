<?php $this->load->view('home/common/account/header'); ?>
    <div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<link type="text/css" href="<?php echo base_url(); ?>templates/home/css/datepicker.css" rel="stylesheet" />	
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>


<!--BEGIN: RIGHT-->
 <SCRIPT TYPE="text/javascript">
  function SearchRaoVat(baseUrl){	
		  product_name='';		 
		  if(document.getElementById('keyword_account').value!='')
		  product_name=document.getElementById('keyword_account').value;  
		 
		  window.location = baseUrl+'account/pnoprice/search/name/keyword/'+product_name+'/';		 	
}
<!--
function submitenterQ(myfield,e,baseUrl)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   SearchRaoVat(baseUrl);
   return false;
   }
else
   return true;
};
//-->
</SCRIPT>
<div class="col-lg-9 col-md-9 col-sm-8">
    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" >
        <tr>
            <td>
                <div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc">
				SẢN PHẨM KHÔNG CẬP NHẬT GIÁ
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        <?php if(count($product) > 0){ ?>
        <form name="frmAccountPro" method="post">
        <tr>
            <td class="k_fixpaddingie" >
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="46" class="title_account_0">STT</td>
                        <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountPro',0)" /></td>
                        <td class="title_account_2">
                            <?php echo $this->lang->line('product_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="150" class="title_account_1">
                            <?php echo $this->lang->line('category_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="110" class="title_account_2">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>postdate/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>postdate/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="120" class="title_account_1">
                            <?php echo $this->lang->line('enddate_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="60" class="title_account_2"><?php echo $this->lang->line('status_list'); ?></td>
                        <td width="45" class="title_account_3"><?php echo $this->lang->line('edit_list'); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="k_fixpaddingie" valign="top"   >
                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($product as $productArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="46" height="32" class="line_account_0"><?php echo $sTT; ?></td>
                        <td width="30" height="32" class="line_account_1">
                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $productArray->pro_id; ?>" onclick="DoCheckOne('frmAccountPro')" />
                        </td>
                        <td height="32" class="line_account_2">
                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $productArray->pro_category; ?>/<?php echo $productArray->pro_id; ?>/<?php echo RemoveSign($productArray->pro_name); ?>" onmouseover="ddrivetip('<table border=0 width=300 cellpadding=1 cellspacing=0><tr><td width=\'20\' valign=\'top\' align=\'left\'><img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $productArray->pro_dir; ?>/<?php echo show_thumbnail($productArray->pro_dir, $productArray->pro_image); ?>\' class=\'image_top_tip\'></td><td valign=\'top\' align=\'left\'><?php echo $productArray->pro_descr; ?></td></tr></table>',300,'#F0F8FF');" onmouseout="hideddrivetip();">
                                <?php echo sub($productArray->pro_name, 30); ?>
                                
                            </a>
                            <span class="number_view">(<?php echo $productArray->pro_view; ?>)</span>
                        </td>
                        <td width="140" height="32" class="line_account_3" style="text-align:center;">
                            <?php echo $productArray->cat_name; ?>
                        </td>
                        <td width="110" height="32" class="line_account_4">
                            <?php echo date('d-m-Y', $productArray->pro_begindate); ?>
                        </td>
                        <td width="120" height="32" class="line_account_1">
                            <input type="text" name="DivEnddate_<?php echo $idDiv; ?>" id="DivEnddate_<?php echo $idDiv; ?>" value="<?php echo date('d-m-Y', $productArray->pro_enddate); ?>" readonly="readonly" class="set_enddate" />                            
                        </td>
                        <td width="60" height="32" class="line_account_4">                        
                            <?php if((int)$productArray->pro_status == 1){ ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/public.png" onclick="ActionLink('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $productArray->pro_id; ?>')" style="cursor:pointer;" border="0" alt="<?php echo $this->lang->line('deactive_tip'); ?>" />
                           	<?php }else{ ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" onclick="ActionLink('<?php echo $statusUrl; ?>/status/active/id/<?php echo $productArray->pro_id; ?>')" style="cursor:pointer;" border="0" alt="<?php echo $this->lang->line('active_tip'); ?>" />
                            <?php } ?>
                        </td>
                        <td width="45" height="32" class="line_account_5">
                            <img src="<?php echo base_url(); ?>templates/home/images/edit.jpg" onclick="ActionLink('<?php echo base_url(); ?>account/product/edit/<?php echo $productArray->pro_id; ?>')" alt="<?php echo $this->lang->line('edit_tip'); ?>" style="cursor:pointer;" border="0" />
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php $sTT++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deletepro_account.gif" onclick="ActionSubmit('frmAccountPro')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" onKeyPress="return submitenterQ(this,event,'<?php echo base_url(); ?>')" />
                            <input type="hidden" name="search_account" id="search_account" value="name" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/product/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" class="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        </form>
        <?php }elseif(count($product) == 0 && trim($keyword) != ''){ ?>
        <tr>
            <td background="" height="29" class="v_background" >
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50" class="title_account_0">STT</td>
                        <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountPro',0)" /></td>
                        <td class="title_account_2">
                            <?php echo $this->lang->line('product_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="150" class="title_account_1">
                            <?php echo $this->lang->line('category_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="110" class="title_account_2">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="120" class="title_account_1">
                            <?php echo $this->lang->line('enddate_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="60" class="title_account_2"><?php echo $this->lang->line('status_list'); ?></td>
                        <td width="50" class="title_account_3"><?php echo $this->lang->line('edit_list'); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="main_list" valign="top" >
                <table border="0" width="788" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="none_record_search" align="center">Không có sản phẩm không cập nhật giá nào được tìm thấy theo yêu cầu của bạn</td>
					</tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deletepro_account.gif" onclick="" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" onKeyPress="return submitenterQ(this,event,'<?php echo base_url(); ?>')" />
                            <input type="hidden" name="search_account" id="search_account" value="name" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/product/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" class="show_page"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
        	<td class="none_record" align="center" class="v_background">
            	Không có sản phẩm không cập nhật giá 
            </td>
		</tr>
        <?php } ?>
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
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>