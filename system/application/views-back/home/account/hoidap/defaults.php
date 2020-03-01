<?php $this->load->view('home/common/header'); ?>
    <div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<link type="text/css" href="<?php echo base_url(); ?>templates/home/css/datepicker.css" rel="stylesheet" />	
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>
<!--BEGIN: RIGHT-->
 <SCRIPT TYPE="text/javascript">
  function Searchhoidap(type,baseUrl){
	
		  product_name='';		 
		  if(document.getElementById('keyword_account').value!='')
		  product_name=document.getElementById('keyword_account').value;	  
		 
		  window.location = baseUrl+'account/hoidap/search/title/keyword/'+product_name+'/';
		  
}
function ActionSort(isAddress)
{
	window.location.href = isAddress;
}
//function submitenter(myfield,e,type,baseUrl)
//{
//var keycode;
//if (window.event) keycode = window.event.keyCode;
//else if (e) keycode = e.which;
//else return true;
//
//if (keycode == 13)
//   {
//   Searchhoidap(type,baseUrl);
//   return false;
//   }
//else
//   return true;
//}
//-->
</SCRIPT>

<?php
$id = $this->uri->segment(6);	
$type = $this->uri->segment(1);	
$type_in_search= $this->uri->segment(2);	
if($type == "hoidap" || $type_in_search=="hoidap"){
	$type=2;
}else{
	$type = 1;
}
?>
<div class="col-lg-9 col-md-9 col-sm-8">
    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" >
        <tr>
            <td>
                <div class="tile_modules tile_modules_blue">
                    <?php echo $this->lang->line('title_hoidap_defaults'); ?>
                </div>
            </td>
         
        </tr>
        <tr>
        	<td >
            <?php if($DropDowlistCategory!="") { ?>
            Danh mục hỏi đáp :<?php echo $DropDowlistCategory; ?>
            <?php  } ?>
            </td>
        </tr>
        <?php if(count($ads) > 0){ ?>
        <form name="frmAccountAds" method="post">
        <tr>
            <td>
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="46" class="title_account_0">STT</td>
                  
                            <td width="60" class="title_account_1">Avartar</td>
                            
                        <td class="title_account_2">
                         	Tiêu đề hỏi đáp
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>/<?php echo $this->uri->segment(7); ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>/<?php echo $this->uri->segment(7); ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="150" class="title_account_1">
                            <?php echo $this->lang->line('category_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/asc<?php echo $pageSort; ?>/<?php echo $this->uri->segment(7); ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/desc<?php echo $pageSort; ?>/<?php echo $this->uri->segment(7); ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="110" class="title_account_2">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>postdate/by/asc<?php echo $pageSort; ?>/<?php echo $this->uri->segment(7); ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>postdate/by/desc<?php echo $pageSort; ?>/<?php echo $this->uri->segment(7); ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="120" class="title_account_1">
                          Trả lời gần nhất
                        </td>
                 
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="top"  >
                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($ads as $adsArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="46" height="32" class="line_account_0"><?php echo $sTT; ?></td>
                        
                       <td width="60" height="32" class="line_account_1">
                       
                          <input type="hidden" id="name-<?php echo $adsArray->use_id;?>" class="name-<?php echo $adsArray->use_id;?>" value="<?php echo $adsArray->use_fullname;?>"/>
                  <input type="hidden" id="image-<?php echo $adsArray->use_id;?>" class="image-<?php echo $adsArray->use_id;?>" value="<?php if($adsArray->avatar !=''){echo base_url().'media/images/avatar/'.$adsArray->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"/>
                  <input type="hidden" id="user-<?php echo $adsArray->use_id;?>" class="user-<?php echo $adsArray->use_id;?>" value="<?php echo $adsArray->use_username;?>"/>
                  <input type="hidden" id="ngaythamgia-<?php echo $adsArray->use_id;?>" class="email-<?php echo $adsArray->use_id;?>" value="<?php echo date('d/m/Y',Counter_model::getUSerIdNameNgayThamGia($adsArray->use_id)); ?>"/>
                  <input type="hidden" id="sanpham-<?php echo $adsArray->use_id;?>" class="email-<?php echo $adsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($adsArray->use_id,"tbtt_product","pro_user"); ?>"/>
               	  <input type="hidden" id="raovat-<?php echo $adsArray->use_id;?>" class="email-<?php echo $adsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($adsArray->use_id,"tbtt_ads","ads_user"); ?>"/>
                    <input type="hidden" id="hoidap-<?php echo $adsArray->use_id;?>" class="email-<?php echo $adsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($adsArray->use_id,"tbtt_hds","hds_user"); ?>"/>
                      <input type="hidden" id="traloi-<?php echo $adsArray->use_id;?>" class="email-<?php echo $adsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($adsArray->use_id,"tbtt_answers","answers_user"); ?>"/>
                      
               <a href="<?php echo base_url(); ?>user/profile/<?php echo $adsArray->use_id; ?>"><img alt="<?php echo ($adsArray->hds_title);?>" width="50" height="50" src="<?php if($adsArray->avatar !=''){echo base_url().'media/images/avatar/'.$adsArray->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"  onmouseover="tooltipPictureUser(this,'<?php echo $adsArray->use_id;?>')" /></a> 
							
                        </td>
                        <td height="32" class="line_account_2">
                            <a class="menu_1" href="<?php echo base_url(); ?>hoidap/<?php echo $adsArray->hds_category; ?>/<?php echo $adsArray->hds_id; ?>/<?php echo RemoveSign($adsArray->hds_title 	); ?>" onmouseover="ddrivetip('<?php echo $adsArray->hds_descr; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();">
                                <?php echo sub($adsArray->hds_title , 30); ?>
                            </a>
                            <br />
                            <span class="number_view"><span class="view" title="Lượt xem: <?php echo $item->hds_view;?>"> Lượt xem : (<?php echo $adsArray->hds_view;?>)</span>&nbsp;
                			<span class="reply" title="Trả lời: <?php echo $item->hds_answers;?>"> , Trả lời : (<?php echo $adsArray->hds_answers;?>)</span>&nbsp;
                			<span class="thumb_up" title="Câu hỏi hữu ích: <?php echo $adsArray->hds_like;?> người chọn">Thích( <?php echo $adsArray->hds_like;?> )</span>
                            <span class="thumb_down" title="Không thích câu này: <?php echo $adsArray->hds_unlike;?>">Không thích : (<?php echo $adsArray->hds_unlike;?>)</span></span>
                        </td>
                        <td width="140" height="32" class="line_account_3" style="text-align:center;">
                            <?php echo $adsArray->cat_name; ?>
                        </td>
                        <td width="110" height="32" class="line_account_4">
                         
                            <?php echo $adsArray->up_date; ?>
                        </td>
                        <td width="120" height="32" class="line_account_1">
                          <?php  $NgayUpdate=Counter_model::loadUpdateDateAnsers($adsArray->hds_id);
						  if($NgayUpdate==""){ echo "Chưa có trả lời"; } else { echo $NgayUpdate ; }?>
                        </td>                
                    </tr>
                    <?php $idDiv++; ?>
                    <?php $sTT++; ?>
                    <?php } ?>
                </table>
                
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" onKeyPress="return submitenter(this,event,<?php echo $type; ?>,'<?php echo base_url(); ?>')" />
                            <input type="hidden" name="search_account" id="search_account" value="title" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/hoidap/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" class="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        </form>
        <?php }elseif(count($ads) == 0 && trim($keyword) != ''){ ?>
        <tr>
            <td background="" height="29" style="background:#f4f4f4; border-left: 1px solid #62C7FD; border-right:1px solid #62C7FD">
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50" class="title_account_0">STT</td>
                        <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountAds',0)" /></td>
                  
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
                        
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="main_list" valign="top"   >
                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="none_record_search" align="center">Không có hỏi đáp nào được tìm thấy theo yêu cầu của bạn </td>
					</tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deleteads_account.gif" onclick="" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" onKeyPress="return submitenter(this,event,<?php echo $type; ?>,'<?php echo base_url(); ?>')" />
                            <input type="hidden" name="search_account" id="search_account" value="title" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/hoidap/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" class="show_page"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
        	<td class="none_record" align="center"  ><?php echo $this->lang->line('none_record_hoidap_defaults'); ?></td>
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