<?php
global $idHome; 
$idHome=1;
?>
<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<td valign="top">
<div class="navigate">
            	<div class="L"></div>
                <div class="C">             
                	<a href="<?php echo base_url() ?>" class="home">Home</a>                  
                      <?php if(isset($CategorysiteGlobalRoot->cat_id)) { ?>          
                     <img alt=""  src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>                   
                 <?php    } ?>
                
                    <?php if($siteGlobal->cat_id!="") ?>
                    <?php { ?>
                <img  alt="" src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/><span>Rao vặt </span>
               <?php  } ?>
                 </div>
                 <div class="R"></div>
             </div>
             
             <div style="display:none;">
<p>
<div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumbs-title">
<span typeof="v:Breadcrumb">
<a rel="v:url" property="v:title"   href="<?php echo base_url() ?>" class="home">Home</a> 
</span>
<span class="separator">»</span>
Rao vặt
</div>
</p>
</div>
             
             <div class="h1-styleding">
             <h1><?php echo $titleSiteGlobal; ?></h1>
             </div>         
         
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 10px;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <tr>
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_new_defaults'); ?></h2>
                            
                        </div>
                          <div class="tinmualink"> <a href="<?php echo base_url(); ?>raovat/tin-mua"> Tin mua </a></div>
                    </div>
                  
                </div>
                
            </td>
   
        </tr>
        <tr>
            <td height="29">
                <table class="v_center29" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                    <td width="43" class="title_boxads_1">
						
                        </td>
                        <td width="39" class="title_boxads_1">
						Mã Tin
                        </td>
                        <td class="title_boxads_1" style="border:1px dotted #C7C7C7; border-top:none;">
                            <div style="float:left; margin-left:10px;"><?php echo $this->lang->line('title_list'); ?></div>
                            <div style="float:right; margin-right:10px;">
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $nSortUrl; ?>title/nBy/asc<?php echo $nPageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $nSortUrl; ?>title/nBy/desc<?php echo $nPageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            </div>
                        </td>
                        <td width="110" class="title_boxads_1" style="border-bottom:1px dotted #C7C7C7; border-right:1px dotted #C7C7C7;">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $nSortUrl; ?>date/nBy/asc<?php echo $nPageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $nSortUrl; ?>date/nBy/desc<?php echo $nPageSort; ?>')" border="0" style="cursor:pointer;"alt=""  />
                        </td>
                        <td width="110" class="title_boxads_1" style="border-bottom:1px dotted #C7C7C7; border-right:1px dotted #C7C7C7;">
                            <?php //echo $this->lang->line('place_ads_list'); ?>
                          <!--  <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $nSortUrl; ?>place/nBy/asc<?php echo $nPageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $nSortUrl; ?>place/nBy/desc<?php echo $nPageSort; ?>')" border="0" style="cursor:pointer;" alt="" />-->
                           <select name="filter-position" id="filter-position">
                           <option value="0" <?php if($selectPlace==0){ ?>  <?php }else{ ?>selected="selected" <?php } ?> onclick="ActionSort('<?php echo base_url(); ?>raovat')" >--Tỉnh/TP--</option>
                           <?php foreach($province as $item): ?>
                           <option value="<?php echo $item->pre_id ?>" <?php if($selectPlace==$item->pre_id){ ?> selected="selected"  <?php } ?> onclick="ActionSort('<?php echo $nSortUrl; ?>splace/<?php echo $item->pre_id ?>'<?php echo $nPageSort; ?>)"><?php echo $item->pre_name ?></option>
                           <?php endforeach; ?>
                           </select>
                           
                            
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                	<?php $idDiv = 1; ?>
                    <?php foreach($newAds as $newAdsArray){ ?>
                    <tr style="display:none"><td>
                    <form action="" method="post">
                    <input type="hidden" id="name-<?php echo $newAdsArray->use_id.'_'.$idDiv;?>" class="name-<?php echo $newAdsArray->use_id;?>" value="<?php echo $newAdsArray->use_fullname;?>"/>
                  <input type="hidden" id="image-<?php echo $newAdsArray->use_id.'_'.$idDiv;?>" class="image-<?php echo $newAdsArray->use_id;?>" value="<?php if($newAdsArray->avatar !=''){echo base_url().'media/images/avatar/'.$newAdsArray->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"/>
                  <input type="hidden" id="user-<?php echo $newAdsArray->use_id.'_'.$idDiv;?>" class="user-<?php echo $newAdsArray->use_id;?>" value="<?php echo $newAdsArray->use_username;?>"/>
                  <input type="hidden" id="ngaythamgia-<?php echo $newAdsArray->use_id.'_'.$idDiv;?>" class="email-<?php echo $newAdsArray->use_id;?>" value="<?php echo date('d/m/Y',Counter_model::getUSerIdNameNgayThamGia($newAdsArray->use_id)); ?>"/>
                  <input type="hidden" id="sanpham-<?php echo $newAdsArray->use_id.'_'.$idDiv;?>" class="email-<?php echo $newAdsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($newAdsArray->use_id,"tbtt_product","pro_user"); ?>"/>
               	  <input type="hidden" id="raovat-<?php echo $newAdsArray->use_id.'_'.$idDiv;?>" class="email-<?php echo $newAdsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($newAdsArray->use_id,"tbtt_ads","ads_user"); ?>"/>
                   	  <input type="hidden" id="hoidap-<?php echo $newAdsArray->use_id.'_'.$idDiv;?>" class="email-<?php echo $newAdsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($newAdsArray->use_id,"tbtt_hds","hds_user"); ?>"/>
                      	  <input type="hidden" id="traloi-<?php echo $newAdsArray->use_id.'_'.$idDiv;?>" class="email-<?php echo $newAdsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($newAdsArray->use_id,"tbtt_answers","answers_user"); ?>"/>
                    </form>
                    </td></tr>     
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowNewAds_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowNewAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowNewAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxads_1" style="border-left: 1px solid #D4EDFF"><a href="<?php echo base_url(); ?>user/profile/<?php echo $newAdsArray->use_id; ?>" target="_parent"><img width="32" height="30" src="<?php if($newAdsArray->avatar!=''){ ?><?php echo base_url(); ?>media/images/avatar/<?php echo "thumbnail_".$newAdsArray->avatar; ?><?php }else{ ?><?php echo base_url(); ?>media/images/avatar/default.png<?php } ?>" alt="" onmouseover="tooltipPictureUser(this,'<?php echo $newAdsArray->use_id.'_'.$idDiv;?>')" /></a></td>       
                         <td width="30" class="line_boxads_1" style="text-align:center">
						<?php echo $newAdsArray->ads_id; ?>
                        </td>
                        <td height="32" class="line_boxads_1" style="text-align:left;">
                        <a class="vtip" href="<?php echo base_url(); ?>raovat/<?php echo $newAdsArray->ads_category; ?>/<?php echo $newAdsArray->ads_id; ?>/<?php echo RemoveSign($newAdsArray->ads_title); ?>" 
                        title="<b ><font color='#E47911'><?php echo $newAdsArray->ads_title; ?></font></b>&nbsp;&nbsp;<?php   $vovel=array("&curren;","<p>","</p>"); echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel," ",$newAdsArray->ads_detail))),300); if(strlen($item->ads_detail)>300) { echo "....";} ?> ">
						
						<?php echo sub($newAdsArray->ads_title, 60); ?></a>
                        
                        &nbsp;<span class="number_view">(<?php echo $newAdsArray->ads_view; ?>)</span>&nbsp;</td>
                        <td width="110" height="32" class="line_boxads_2"><?php echo date('d-m-Y', $newAdsArray->ads_begindate); ?></td>
                        <td width="110" height="32" class="line_boxads_3" style="border-right: 1px solid #D4EDFF;">
                        <a href="<?php echo base_url();?>raovat/nSort/splace/<?php echo $newAdsArray->pre_id; ?>"><?php echo $newAdsArray->pre_name; ?></a></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                       <td width="37%" class="post_boxads"><img src="<?php echo base_url(); ?>templates/home/images/icon_postboxads.gif" onclick="ActionLink('<?php echo base_url(); ?>raovat/post')" style="cursor:pointer;" border="0" alt="" /></td>
                        <td align="left" class="sort_boxads">
                            <select name="select_sort" class="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $nSortUrl; ?>id/nBy/desc<?php echo $nPageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $nSortUrl; ?>view/nBy/asc<?php echo $nPageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_defaults'); ?></option>
                                <option value="<?php echo $nSortUrl; ?>view/nBy/desc<?php echo $nPageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_defaults'); ?></option>
                            </select>
                        </td>
                        <td width="37%" class="show_page"><?php echo $nLinkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td  height="16" ></td>
        </tr>
        <?php $this->load->view('home/advertise/center2'); ?>
   
        <tr>
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_reliable_defaults'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td height="29">
                <table class="v_center29" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                     <td width="43" class="title_boxads_1">
						
                        </td>
                        <td width="39" class="title_boxads_1">
						Mã Tin
                        </td>
                        <td class="title_boxads_1" style="border:1px dotted #C7C7C7; border-top:none;">
                            <div style="float:left; margin-left:10px;"><?php echo $this->lang->line('title_list'); ?></div>
                            <div style="float:right; margin-right: 10px;">
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $rSortUrl; ?>title/rBy/asc<?php echo $rPageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $rSortUrl; ?>title/rBy/desc<?php echo $rPageSort; ?>')" border="0" style="cursor:pointer;"alt=""  />
                            </div>
                        </td>
                        
                         
                            
                        <td width="110" class="title_boxads_1" style="border-bottom:1px dotted #C7C7C7; border-right:1px dotted #C7C7C7;">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $rSortUrl; ?>date/rBy/asc<?php echo $rPageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $rSortUrl; ?>date/rBy/desc<?php echo $rPageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="110" class="title_boxads_1" style="border-bottom:1px dotted #C7C7C7; border-right:1px dotted #C7C7C7;">
                            <?php //echo $this->lang->line('place_ads_list'); ?>
                            <!--<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $rSortUrl; ?>place/rBy/asc<?php echo $rPageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $rSortUrl; ?>place/rBy/desc<?php echo $rPageSort; ?>')" border="0" style="cursor:pointer;" alt="" />-->
                            
                           <select name="filter-position-truth" id="filter-position-truth">
                           <option value="0" <?php if($selectPlace==0){ ?>  <?php }else{ ?>selected="selected" <?php } ?> onclick="ActionSort('<?php echo base_url(); ?>raovat')" >--Tỉnh/TP--</option>
                           <?php foreach($province as $item): ?>
                           <option value="<?php echo $item->pre_id ?>" <?php if($selectPlaceTruth==$item->pre_id){ ?> selected="selected"  <?php } ?> onclick="ActionSort('<?php echo $rSortUrl; ?>rsplace/<?php echo $item->pre_id ?><?php echo $rPageSort; ?>')"><?php echo $item->pre_name ?></option>
                           <?php endforeach; ?>
                           </select>
                           
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                	<?php $idDiv = 1; ?>
                    <?php foreach($reliableAds as $reliableAdsArray){ ?>
                    <tr style="display:none">
                    
                    <td>
                    <form action="" method="post">
                         
                        
                     <input type="hidden" id="name-<?php echo $reliableAdsArray->use_id.'_ads'.$idDiv;?>" class="name-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo $reliableAdsArray->use_fullname;?>"/>
                  <input type="hidden" id="image-<?php echo $reliableAdsArray->use_id.'_ads'.$idDiv;?>" class="image-<?php echo $reliableAdsArray->use_id;?>" value="<?php if($reliableAdsArray->avatar !=''){echo base_url().'media/images/avatar/'.$reliableAdsArray->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"/>
                  <input type="hidden" id="user-<?php echo $reliableAdsArray->use_id.'_ads'.$idDiv;?>" class="user-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo $reliableAdsArray->use_username;?>"/>
                  <input type="hidden" id="ngaythamgia-<?php echo $reliableAdsArray->use_id.'_ads'.$idDiv;?>" class="email-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo date('d/m/Y',Counter_model::getUSerIdNameNgayThamGia($reliableAdsArray->use_id)); ?>"/>
                  <input type="hidden" id="sanpham-<?php echo $reliableAdsArray->use_id.'_ads'.$idDiv;?>" class="email-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($reliableAdsArray->use_id,"tbtt_product","pro_user"); ?>"/>
               	  <input type="hidden" id="raovat-<?php echo $reliableAdsArray->use_id.'_ads'.$idDiv;?>" class="email-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($reliableAdsArray->use_id,"tbtt_ads","ads_user"); ?>"/>
                   	  <input type="hidden" id="hoidap-<?php echo $reliableAdsArray->use_id.'_ads'.$idDiv;?>" class="email-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($reliableAdsArray->use_id,"tbtt_hds","hds_user"); ?>"/>
                      	  <input type="hidden" id="traloi-<?php echo $reliableAdsArray->use_id.'_ads'.$idDiv;?>" class="email-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($reliableAdsArray->use_id,"tbtt_answers","answers_user"); ?>"/>
                	</form>
                    </td></tr>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowReliableAds_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowReliableAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowReliableAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                      
                      <td width="30" height="32" class="line_boxads_1" style="border-left:1px solid #D4EDFF"><a href="<?php echo base_url(); ?>user/profile/<?php echo $reliableAdsArray->use_id; ?>" target="_parent"><img width="32" height="30" src="<?php if($reliableAdsArray->avatar!=''){ ?><?php echo base_url(); ?>media/images/avatar/<?php echo  "thumbnail_".$reliableAdsArray->avatar; ?><?php }else{ ?><?php echo base_url(); ?>media/images/avatar/default.png<?php } ?>" alt="" onmouseover="tooltipPictureUser(this,'<?php echo $reliableAdsArray->use_id.'_ads'.$idDiv;?>')" /></a></td>
                          <td width="30" class="line_boxads_1" align="center" style="text-align:center">
                    <?php echo $reliableAdsArray->ads_id ?>
                    </td>
                        <td height="32" class="line_boxads_1" style="text-align:left;">
                        <a class="vtip" href="<?php echo base_url(); ?>raovat/<?php echo $reliableAdsArray->ads_category; ?>/<?php echo $reliableAdsArray->ads_id; ?>/<?php echo RemoveSign($reliableAdsArray->ads_title); ?>"  
                        title="<b ><font color='#E47911'><?php echo $reliableAdsArray->ads_title ?></font></b>&nbsp;&nbsp;<?php   $vovel=array("&curren;","<p>","</p>"); echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel," ",$reliableAdsArray->ads_detail))),300); if(strlen($item->ads_detail)>300) { echo "....";} ?> "
                        ><?php echo sub($reliableAdsArray->ads_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $reliableAdsArray->ads_view; ?>)</span>&nbsp;</td>
                        <td width="110" height="32" class="line_boxads_2"><?php echo date('d-m-Y', $reliableAdsArray->ads_begindate); ?></td>
                        <td width="110" height="32" class="line_boxads_3" style="border-right: 1px solid #D4EDFF;">
						
                         <a href="<?php echo base_url();?>raovat/rSort/rsplace/<?php echo $reliableAdsArray->pre_id; ?>">
						<?php echo $reliableAdsArray->pre_name; ?></a></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" class="post_boxads"><img src="<?php echo base_url(); ?>templates/home/images/icon_postboxads.gif" onclick="ActionLink('<?php echo base_url(); ?>raovat/post')" style="cursor:pointer;" border="0" alt="" /></td>
                        <td align="left" class="sort_boxads">
                            <select name="select_sort" class="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $rSortUrl; ?>id/rBy/desc<?php echo $rPageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $rSortUrl; ?>view/rBy/asc<?php echo $rPageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_defaults'); ?></option>
                                <option value="<?php echo $rSortUrl; ?>view/rBy/desc<?php echo $rPageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_defaults'); ?></option>
                            </select>
                        </td>
                        <td width="37%" class="show_page"><?php echo $rLinkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="16" ></td>
        </tr>
        <tr>
            <td height="5"></td>
		</tr>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
     
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>