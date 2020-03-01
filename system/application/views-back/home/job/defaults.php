
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
                     <img alt=""  src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif"/>                   <span>Tuyển dụng </span>           
                 </div>
                 <div class="R"></div>
             </div>
             
             <div style="display:none;">
<p>
<div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumbs-title">
<span typeof="v:Breadcrumb">
<a rel="v:url" property="v:title"   href="<?php echo base_url() ?>" class="home">Home</a> 
</span>


</div>
</p>
</div>


             
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 10px;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <?php /*?><tr>            
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h3><?php echo $this->lang->line('title_field_defaults'); ?></h3>
                        </div>
                    </div>
                </div>
            </td>
        </tr><?php */?>
        <?php /*?><tr>
            <td height="29">
                <table class="v_center29" align="center"  border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td height="6" colspan="4"></td>
                    </tr>
                    <tr>
                    <?php $counter = 1; ?>
                    <?php foreach($field as $fieldArray){ ?>
                        <td align="left" width="25" class="icon_field"><img src="<?php echo base_url(); ?>templates/home/images/field/<?php echo $fieldArray->fie_image; ?>" border="0" alt="" /></td>
                        <td align="left" class="list_field">
                            <a class="menu_1" href="<?php echo base_url(); ?>tuyendung/<?php echo $fieldArray->fie_id; ?>/<?php echo RemoveSign($fieldArray->fie_name); ?>" title="<?php echo $fieldArray->fie_descr; ?>">
                            <h4><?php echo $fieldArray->fie_name; ?></h4>
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
        </tr><?php */?>
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
                        	<h2><?php echo $this->lang->line('title_new_job_defaults'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td height="29">
                <table class="v_center29" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                   <tr>
                        <td class="title_boxads_1 k_title_boxads_1">
                            <div class="k_floatleftmarginleft10"><?php echo $this->lang->line('title_list'); ?></div>
                            <div class="k_floatrightmarginright10">
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt=""/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt=""/>
                            </div>
                        </td>
                        <td width="110" class="title_boxads_1 k_title_boxads_1_right">
                            <div class="k_floatleftmarginleft10"><?php echo $this->lang->line('date_post_list'); ?></div>
                            <div>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt=""/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;"alt="" />
                            </div>
                        </td>
                        <td width="130" class="title_boxads_1 k_title_boxads_1_right">
                            <div class="k_floatleftmarginleft10"><?php echo $this->lang->line('place_job_list'); ?></div>
                            <div>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            </div>
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td class="k_border">
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($job as $jobArray){ ?>
                    <?php ///var_dump (date('d-m-Y',$jobArray->job_time_surrend));die(); ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowJob_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowJob_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowJob_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxjob_1" ><img src="<?php echo base_url(); ?>templates/home/images/icon_tieudejob.gif"  alt=""/></td>
                        <td style="text-align:left" height="32" class="line_boxjob_1">
                        <a class="vtip" href="<?php echo base_url(); ?>tuyendung/<?php echo $jobArray->job_field; ?>/<?php echo $jobArray->job_id; ?>/<?php echo RemoveSign($jobArray->job_title); ?>" title="<b><font color='#E47911'><?php echo $this->lang->line('position_tip'); ?></font></b>&nbsp;<?php echo $jobArray->job_position; ?><br /><b><font color='#E47911'><?php echo $this->lang->line('time_surrend_tip'); ?></font></b>&nbsp;<?php echo date('d-m-Y', $jobArray->job_enddate); ?>">
							<h4><?php echo sub($jobArray->job_title, 60); ?>&nbsp;<span class="number_view">(<?php echo $jobArray->job_view; ?>)</span>&nbsp;</h4>
                        </a>
                        </td>
                        <td width="110" height="32" class="line_boxjob_2"><?php echo date('d-m-Y', $jobArray->job_begindate); ?></td>
                        <td width="130" height="32" class="line_boxjob_3"><?php echo $jobArray->pre_name; ?></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="post_boxjob"><img src="<?php echo base_url(); ?>templates/home/images/icon_postboxjob.gif" onclick="ActionLink('<?php echo base_url(); ?>job/post')" style="cursor:pointer;" border="0"  alt=""/></td>
                        <td align="center" id="sort_boxjob">
                            <select name="select_sort" class="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_defaults'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_defaults'); ?></option>
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