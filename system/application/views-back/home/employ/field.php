<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<td valign="top">
<div class="navigate">
    <div class="L"></div>
    <div class="C">             
        <a href="<?php echo base_url() ?>" class="home">Home</a>              
         <img alt=""  src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif"/>                   <span> <a href="<?php echo base_url(); ?>timviec">Tìm việc</a> </span>   
          <img alt=""  src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif"/>
         <span>
            <?php echo $titleSiteGlobal; ?>
         </span>        
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
<?php echo $titleSiteGlobal; ?>
</div>
</p>
</div>

<div class="h1-styleding">
             <h1><?php echo $h1tagSiteGlobal!=''? $h1tagSiteGlobal: $titleSiteGlobal; ?></h1>
             </div> 
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 10px;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <tr id="DivField_1" style="display:none;">            
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_field_field'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr id="DivField_2" style="display:none;">
            <td class="k_border" valign="top">
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="6" colspan="4"></td>
                    </tr>
                    <tr>
                    <?php $counter = 1; ?>
                    <?php foreach($field as $fieldArray){ ?>
                        <td align="left" width="25" class="icon_field"><img src="<?php echo base_url(); ?>templates/home/images/field/<?php echo $fieldArray->fie_image; ?>" border="0"  alt="" /></td>
                        <td align="left" class="list_field">
                            <a class="menu_1" href="<?php echo base_url(); ?>timviec/<?php echo $fieldArray->fie_id; ?>/<?php echo RemoveSign($fieldArray->fie_name); ?>" title="<?php echo $fieldArray->fie_descr; ?>">
                            <?php echo $fieldArray->fie_name; ?>
                            </a>
                        </td>
                    <?php if($counter % 2 == 0 && $counter < count($field)){ ?>
					</tr><tr>
    				<?php } ?>
                    <?php $counter++; ?>
                    <?php } ?>
                    <?php if(count($field) % 2 != 0){ ?>
                    <td align="left" width="25" class="icon_field"></td>
                    <td align="left" class="list_field"></td>
                    <?php } ?>
					</tr>
                </table>
            </td>
        </tr>
        <tr id="DivField_3" style="display:none;">
            <td height="16" ></td>
        </tr>
        <tr id="DivField_4" style="display:none;">
            <td height="10"></td>
		</tr>
        <tr>            
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_interest_field'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_tinraovat.jpg" height="29">
                <table align="center" width="100%" height="29" border="0" cellpadding="0" cellspacing="0">
                    <tr>                        
                        <td class="title_boxads_1 k_title_boxads_1">
                            <div class="k_floatleftmarginleft10"><?php echo $this->lang->line('title_list'); ?></div>                   
                        </td>
                        <td width="110" class="title_boxads_1 k_title_boxads_1_right">
                            <div class="k_floatleftmarginleft10"><?php echo $this->lang->line('date_post_list'); ?></div>
                            
                        </td>
                        <td width="130" class="title_boxads_1 k_title_boxads_1_right">
                            <div class="k_floatleftmarginleft10"><?php echo $this->lang->line('place_employ_list'); ?></div>
                            
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td class="k_border" valign="top">
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($interestEmploy as $interestEmployArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowInterestEmploy_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowInterestEmploy_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowInterestEmploy_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxemploy_1" ><img src="<?php echo base_url(); ?>templates/home/images/icon_tieudeemploy.gif"  alt="" /></td>
                        <td  height="32" class="line_boxemploy_1"><a class="menu" href="<?php echo base_url(); ?>timviec/<?php echo $interestEmployArray->emp_field; ?>/<?php echo $interestEmployArray->emp_id; ?>/<?php echo RemoveSign($interestEmployArray->emp_title); ?>" onmouseover="ddrivetip('<?php echo $this->lang->line('level_tip'); ?>&nbsp;<?php echo $interestEmployArray->emp_level; ?><br /><?php echo $this->lang->line('position_like_tip'); ?>&nbsp;<?php echo $interestEmployArray->emp_position; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo sub($interestEmployArray->emp_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $interestEmployArray->emp_view; ?>)</span>&nbsp;</td>
                        <td width="110" height="32" class="line_boxemploy_2"><?php echo date('d-m-Y', $interestEmployArray->emp_begindate); ?></td>
                        <td width="130" height="32" class="line_boxemploy_3"><?php echo $interestEmployArray->pre_name; ?></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
            </td>
        </tr>
        <tr>
            <td height="16" ></td>
        </tr>
        <tr>
            <td height="5"></td>
		</tr>
        <?php $this->load->view('home/advertise/bottom'); ?>
        <tr>            
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_new_employ_field'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>        
        </tr>
        <tr>
            <td height="29">
                <table class="v_center29" align="center"  border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td class="title_boxads_1 k_title_boxads_1">
                            <div class="k_floatleftmarginleft10"><?php echo $this->lang->line('title_list'); ?></div>
                            <div class="k_floatrightmarginright10">
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt=""/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt=""/>
                            </div>
                        </td>
                        <td width="110" class="title_boxads_1 k_title_boxads_1_right">
                           <div class="k_floatleftmarginleft10"> <?php echo $this->lang->line('date_post_list'); ?></div>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="130" class="title_boxads_1 k_title_boxads_1_right">
                            <div class="k_floatleftmarginleft10"><?php echo $this->lang->line('place_employ_list'); ?></div>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td class="k_border" >
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($employ as $employArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowEmploy_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowEmploy_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowEmploy_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxemploy_1" ><img src="<?php echo base_url(); ?>templates/home/images/icon_tieudeemploy.gif"  alt="" /></td>
                        <td  height="32" class="line_boxemploy_1"><a class="menu" href="<?php echo base_url(); ?>timviec/<?php echo $employArray->emp_field; ?>/<?php echo $employArray->emp_id; ?>/<?php echo RemoveSign($employArray->emp_title); ?>" onmouseover="ddrivetip('<?php echo $this->lang->line('level_tip'); ?>&nbsp;<?php echo $employArray->emp_level; ?><br /><?php echo $this->lang->line('position_like_tip'); ?>&nbsp;<?php echo $employArray->emp_position; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo sub($employArray->emp_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $employArray->emp_view; ?>)</span>&nbsp;</td>
                        <td width="110" height="32" class="line_boxemploy_2"><?php echo date('d-m-Y', $employArray->emp_begindate); ?></td>
                        <td width="130" height="32" class="line_boxemploy_3"><?php echo $employArray->pre_name; ?></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="post_boxemploy"><img src="<?php echo base_url(); ?>templates/home/images/icon_postboxemploy.gif" onclick="ActionLink('<?php echo base_url(); ?>employ/post')" style="cursor:pointer;" border="0"  alt="" /></td>
                        <td align="center" id="sort_boxemploy">
                            <select name="select_sort" class="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_field'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_field'); ?></option>
                            </select>
                        </td>
                        <td width="37%" class="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="16" ></td>
        </tr>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>