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
                     <img src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>                   
                 <?php    } ?>
                
                    <?php if($siteGlobal->cat_id!="") ?>
                    <?php { ?>
                <img src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/><span>Rao vặt </span>
               <?php  } ?>
                 </div>
                 <div class="R"></div>
             </div>            
         
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 10px;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <tr>
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h3><?php echo $this->lang->line('title_new_defaults'); ?></h3>
                            
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
                         <input type="hidden" id="name-<?php echo $newAdsArray->use_id;?>" value="<?php echo $newAdsArray->use_fullname;?>"/>
                  <input type="hidden" id="image-<?php echo $newAdsArray->use_id;?>" value="<?php if($newAdsArray->avatar !=''){echo base_url().'media/images/avatar/'.$newAdsArray->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"/>
                   <input type="hidden" id="user-<?php echo $newAdsArray->use_id;?>" value="<?php echo $newAdsArray->use_username;?>"/>
                        <input type="hidden" id="email-<?php echo $newAdsArray->use_id;?>" value="<?php echo $newAdsArray->use_email;?>"/>
                        <input type="hidden" id="phone-<?php echo $newAdsArray->use_id;?>" value="<?php echo $newAdsArray->use_phone;?>"/>
                         <input type="hidden" id="yahoo-<?php echo $newAdsArray->use_id;?>" value="<?php echo $newAdsArray->use_yahoo;?>"/>
                         <input type="hidden" id="skype-<?php echo $newAdsArray->use_id;?>" value="<?php echo $newAdsArray->use_skype;?>"/>
                         
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowNewAds_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowNewAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowNewAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxads_1" style="border-left: 1px solid #D4EDFF"><a href="<?php echo base_url(); ?>user/profile/<?php echo $newAdsArray->use_id; ?>" target="_parent"><img width="32" height="30" src="<?php if($newAdsArray->avatar!=''){ ?><?php echo base_url(); ?>media/images/avatar/<?php echo "thumbnail_".$newAdsArray->avatar; ?><?php }else{ ?><?php echo base_url(); ?>media/images/avatar/default.png<?php } ?>" alt="" onmouseover="tooltipPictureUser(this,'<?php echo $newAdsArray->use_id;?>')" /></a></td>       
                        <td height="32" class="line_boxads_1" style="text-align:left;">
                        <a class="vtip" href="<?php echo base_url(); ?>raovat/category/detail/<?php echo $newAdsArray->ads_category; ?>/<?php echo $newAdsArray->ads_id; ?>/<?php echo RemoveSign($newAdsArray->ads_title); ?>" title="<?php  echo "<b  ><font color='#E47911'>".$newAdsArray->ads_title." </font></b> &nbsp " ;  echo cut_string_unicodeutf8(strip_tags($newAdsArray->ads_detail),230) ?>"   >
						
						<?php echo sub($newAdsArray->ads_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $newAdsArray->ads_view; ?>)</span>&nbsp;</td>
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
                        	<h3><?php echo $this->lang->line('title_reliable_defaults'); ?></h3>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td height="29">
                <table class="v_center29" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
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
                    
                     <input type="hidden" id="name-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo $reliableAdsArray->use_fullname;?>"/>
                  <input type="hidden" id="image-<?php echo $reliableAdsArray->use_id;?>" value="<?php if($reliableAdsArray->avatar !=''){echo base_url().'media/images/avatar/'.$newAdsArray->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"/>
                   <input type="hidden" id="user-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo $reliableAdsArray->use_username;?>"/>
                        <input type="hidden" id="email-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo $reliableAdsArray->use_email;?>"/>
                        <input type="hidden" id="phone-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo $reliableAdsArray->use_phone;?>"/>
                         <input type="hidden" id="yahoo-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo $reliableAdsArray->use_yahoo;?>"/>
                         <input type="hidden" id="skype-<?php echo $reliableAdsArray->use_id;?>" value="<?php echo $reliableAdsArray->use_skype;?>"/>
                
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowReliableAds_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowReliableAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowReliableAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxads_1" style="border-left:1px solid #D4EDFF"><a href="<?php echo base_url(); ?>user/profile/<?php echo $reliableAdsArray->use_id; ?>" target="_parent"><img width="32" height="30" src="<?php if($reliableAdsArray->avatar!=''){ ?><?php echo base_url(); ?>media/images/avatar/<?php echo  "thumbnail_".$reliableAdsArray->avatar; ?><?php }else{ ?><?php echo base_url(); ?>media/images/avatar/default.png<?php } ?>" alt="" onmouseover="tooltipPictureUser(this,'<?php echo $reliableAdsArray->use_id;?>')" /></a></td>
                        <td height="32" class="line_boxads_1" style="text-align:left;"><a class="vtip" href="<?php echo base_url(); ?>raovat/category/detail/<?php echo $reliableAdsArray->ads_category; ?>/<?php echo $reliableAdsArray->ads_id; ?>/<?php echo RemoveSign($reliableAdsArray->ads_title); ?>"  title="<?php  echo "<b  ><font color='#E47911'>".$reliableAdsArray->ads_title." </font></b> &nbsp";  echo cut_string_unicodeutf8(strip_tags($reliableAdsArray->ads_detail),230) ?>" ><?php echo sub($reliableAdsArray->ads_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $reliableAdsArray->ads_view; ?>)</span>&nbsp;</td>
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
        <?php $this->load->view('home/advertise/center3'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>