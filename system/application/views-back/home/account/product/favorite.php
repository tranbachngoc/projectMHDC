<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<SCRIPT TYPE="text/javascript">
    function SearchProductFavorite(baseUrl){	
        product_name='';		 
        if(document.getElementById('keyword_account').value!='')
        product_name=document.getElementById('keyword_account').value;  

        window.location = baseUrl+'account/product/<?php echo $this->uri->segment(3); ?>/favorite/search/name/keyword/'+product_name+'/';		 	
    }
    <!--
    function submitenterProductFavorite(myfield,e,baseUrl)
    {
    var keycode;
    if (window.event) keycode = window.event.keyCode;
    else if (e) keycode = e.which;
    else return true;

    if (keycode == 13)
       {
       SearchProductFavorite(baseUrl);
       return false;
       }
    else
       return true;
    };
    -->
</SCRIPT>
<div class="col-md-9 col-sm-8 col-xs-12">
    <h4 class="page-header text-uppercase" style="margin-top:0">
        <?php if($this->uri->segment(3)=='product') {echo 'Sản phẩm yêu thích'; $pro = 'Sản phẩm';$txt = $this->lang->line('none_record_favorite_product_favorite');}?>
	<?php if($this->uri->segment(3)=='coupon') {echo  'Phiếu mua hàng điện tử yêu thích';  $pro = 'phiếu mua hàng điện tử';$txt = 'Bạn chưa thích phiếu mua hàng điện tử nào';} ?>
        <?php if($this->uri->segment(3)=='service') {echo  'Dịch vụ yêu thích'; $pro = 'Dịch vụ';$txt = 'Không có dịch vụ yêu thích';} ?>	
    </h4>
    <form name="frmAccountFavoritePro" method="post">
    <div style="overflow: auto">
	<table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
        <?php if(count($favoriteProduct) > 0){ ?>
        
        <tr>
                        <td width="4%" class="title_account_0 hidden-xs">STT</td>
                        <td width="15%" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountFavoritePro',0)" /> Chọn tất cả</td>
                        <td width="40%" class="title_account_2">
                            <?php echo $this->lang->line('product_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="13%" class="title_account_3">
                            <?php echo $this->lang->line('cost_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="13%" class="title_account_1">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>postdate/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>postdate/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="11%" class="title_account_2">
                            <?php echo $this->lang->line('date_add_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                    </tr>
            <?php $idDiv = 1; ?>
            <?php foreach($favoriteProduct as $favoriteProductArray){ ?>
                <tr>
                    <td class="hidden-xs"><?php echo $sTT; ?></td>
                    <td style="text-align:center">
                        <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $favoriteProductArray->prf_id; ?>" onclick="DoCheckOne('frmAccountFavoritePro')" />
                    </td>
                    <td >
                        <a target="_blank" class="menu_1" href="<?php echo base_url(); ?><?php echo $favoriteProductArray->pro_category; ?>/<?php echo $favoriteProductArray->pro_id; ?>/<?php echo RemoveSign($favoriteProductArray->pro_name); ?>" onmouseover="ddrivetip('<table border=0 width=300 cellpadding=1 cellspacing=0><tr><td valign=\'top\' align=\'left\'><img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $favoriteProductArray->pro_dir; ?>/<?php echo show_thumbnail($favoriteProductArray->pro_dir, $favoriteProductArray->pro_image); ?>\' class=\'image_top_tip\'></td><td valign=\'top\' align=\'left\'><?php echo $favoriteProductArray->pro_descr; ?></td></tr></table>',300,'#F0F8FF');" onmouseout="hideddrivetip();">
                            <?php echo sub($favoriteProductArray->pro_name, 50); ?>
                        </a>
                        <span class="number_view">(<?php echo $favoriteProductArray->pro_view; ?>)</span>
                    </td>
                    <td>
                        <?php if((int)$favoriteProductArray->pro_cost == 0){ ?>
                            <?php echo $this->lang->line('call_main'); ?>
                        <?php }else{ ?>
                            <span id="DivCost_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $favoriteProductArray->pro_currency; ?>
                            <script type="text/javascript">FormatCost('<?php echo $favoriteProductArray->pro_cost; ?>', 'DivCost_<?php echo $idDiv; ?>');</script>
                        <?php } ?>
                    </td>
                    <td >
                        <?php echo date('d-m-Y', $favoriteProductArray->pro_begindate); ?>
                    </td>
                    <td>
                        <?php echo date('d-m-Y', $favoriteProductArray->prf_date); ?>
                    </td>
                </tr>
                <?php $idDiv++; ?>
                <?php $sTT++; ?>
            <?php } ?>
            <tr>
            <style> 
                input#keyword_account {
                    width: 200px !important;
                    display: inline-block;
                    margin-right: 20px;
                }  
            </style>
                <td colspan="6">
                    <div class="" onclick="ActionSubmit('frmAccountFavoritePro')" style="cursor:pointer;color: #f00;width: 493px; display: inline-block;"><i class="fa fa-trash"></i> Xóa <?php echo $pro?> yêu thích đã chọn</div>
                    <!--<img src="<?php echo base_url(); ?>templates/home/images/icon_deletefavoritepro_account.gif" onclick="ActionSubmit('frmAccountFavoritePro')" style="cursor:pointer;" border="0" />-->
                    <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" onKeyPress="return submitenterProductFavorite(this,event,'<?php echo base_url(); ?>')"  />
                    <input type="hidden" name="search_account" id="search_account" value="name" />
                    <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/product/<?php echo $this->uri->segment(3); ?>/favorite/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                </td>
            </tr>
            <?php if(!empty($linkPage)){?>
        <tr>
            <td colspan="6"><?php echo $linkPage; ?></td>
        </tr>
        <?php }?>
        <?php }elseif(count($favoriteProduct) == 0 && trim($keyword) != ''){ ?>
            <tr>
                <td >STT</td>
                <td ><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountFavoritePro',0)" /> Chọn tất cả</td>
                <td >
                    <?php echo $this->lang->line('product_list'); ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                </td>
                <td>
                    <?php echo $this->lang->line('cost_list'); ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                </td>
                <td >
                    <?php echo $this->lang->line('date_post_list'); ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                </td>
                <td>
                    <?php echo $this->lang->line('date_add_list'); ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                </td>
            </tr>
            <tr>
                <td class="none_record_search" align="center"><?php echo $this->lang->line('none_record_search_favorite_product_favorite'); ?></td>
            </tr>
            <tr>
                <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deletefavoritepro_account.gif" onclick="" style="cursor:pointer;" border="0" /></td>
                <td align="center" id="boxfilter_account">
                    <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)"  onKeyPress="return submitenterProductFavorite(this,event,'<?php echo base_url(); ?>')" />
                    <input type="hidden" name="search_account" id="search_account" value="name" />
                    <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/product/favorite/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                </td>
                <td width="30%" class="show_page"></td>
            </tr>
        <?php }else{ ?>
        <tr>
        	<td class="none_record" align="center" ><?php echo $txt; ?></td>
		</tr>
        <?php } ?>
    </table>
    </div>
	</form>
    </div>
</div>
    </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>