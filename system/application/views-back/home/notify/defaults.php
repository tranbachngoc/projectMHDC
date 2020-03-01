<?php $this->load->view('home/common/account/header'); ?>
<?php $this->load->view('home/common/menu_thong_bao_trai.php'); ?>
<td width="800px" valign="top" class="leftrighttable">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        	<td class="k_topkhung_left"></td>
            <td  height="30" class="k_topkhung_between">
                <div class="tile_modules"><?php echo $this->lang->line('title_detail_defaults'); ?></div>
            </td>
            <td class="k_topkhung_right"></td>
        </tr>
        <tr>
        	<td class="k_mainkhungleft"></td>
            <td  style="padding-left:4px;" valign="top" class="k_mainkhungbetween">
                <table style="padding:5px 0px" width="100%"  cellpadding="0" cellspacing="0" border="0">
                    <tr bgcolor="#f4f8fb">
                    	<td class="k_post_top_left"></td>
                        <td height="20" class="post_top k_post_top_between"></td>
                        <td class="k_post_top_right"></td>
                    </tr>
                    <tr  bgcolor="#f4f8fb">
                    	<td class="k_title_notify_detail_topleft"></td>
                        <td class="title_notify_detail k_title_notify_detail_toprightbetween"><?php echo $notify->not_title; ?></td>
                        <td class="k_title_notify_detail_topright"></td>
                    </tr>
                    <tr bgcolor="#f4f8fb">
                    	<td class="k_post_bottom_left"></td>
                        <td height="10" class="post_bottom k_post_bottom_between"></td>
                        <td class="k_post_bottom_right"></td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td valign="top" class="content_notify_detail k_minheight_leftrighttable" colspan="3"><?php
							$vowels = array("&curren;");						
						 	echo htmlspecialchars_decode(html_entity_decode(str_replace($vowels,"#",$notify->not_detail))); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td class="k_bottom_notify_detail_left"></td>
                        <td width="96%" height="30" class="k_bottom_notify_detail_between"></td>
                        <td class="k_bottom_notify_detail_right"></td>
                    </tr>
                </table>
            </td>
            <td class="k_mainkhungright"></td>
        </tr>
        <tr>
        	<td class="k_bottomleft"></td>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_left.png" height="16"  class="k_bottombetween"></td>
            <td class="k_bottomright"></td>
        </tr>
    </table>
</td>
<!--END LEFT-->
<!--BEGIN PADDING-->
<td width="1%"></td>
<!--END PADDING-->
<!--BEGIN: RIGHT-->
<?php /*?><td width="35%" valign="top" class="leftrighttable">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            
            <td class="k_topkhung_left"></td>
            <td  height="30" class="k_topkhung_between">
                <div class="tile_modules"><?php echo $this->lang->line('title_list_defaults'); ?></div>
            </td>
            <td class="k_topkhung_right"></td>
        </tr>
        <tr>
        	<td class="k_mainkhungleft"></td>
            <td class="k_mainkhungbetween" valign="top" style="padding:10px;">
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="25"><?php echo $this->lang->line('welcome_notify_defaults'); ?></td>
					</tr>
				</table>
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <?php foreach($listNotify as $listNotifyArray){ ?>
                    <tr>
                        <td width="5" valign="top" ><img class="list_ten" src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /></td>
                        <td class="list_2" style="font-size:12px;" valign="top">
                            <a class="<?php if($listNotifyArray->not_id == $id){echo 'menu_2';}else{echo 'menu_1';} ?>" href="<?php echo base_url(); ?>thongbao/<?php echo $listNotifyArray->not_id; ?>/<?php echo RemoveSign($listNotifyArray->not_title); ?><?php if(isset($page) && (int)$page > 0){ ?>/page/<?php echo $page; ?><?php } ?>" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $listNotifyArray->not_title; ?></a>
                            <span class="date_view">(<?php echo date('d-m-Y', $listNotifyArray->not_begindate); ?>)</span>
                        </td>
                    </tr>
                    <?php } ?>
					<tr>
					    <td colspan="2" align="right" class="show_page" style="padding-right:0px;"><?php echo $linkPage; ?></td>
					</tr>
                </table>
                <table>
                    <tr>
                        <td valign="top">
							<?php $contentThongTinRightTopGloble = Counter_model::getArticle(thongtinRightTopGlobal);?>
        					<?php $contentThongTinRightTopGloble = html_entity_decode(str_replace($vovel,"#",$contentThongTinRightTopGloble->not_detail));?>
                            <?php echo $contentThongTinRightTopGloble ?>
                        </td>
					</tr>
				</table>
            </td>
            <td class="k_mainkhungright"></td>
        </tr>
        <tr>
            
            <td class="k_bottomleft"></td>
            <td  height="16"  class="k_bottombetween"></td>
            <td class="k_bottomright"></td>
        </tr>
    </table>
</td><?php */?>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

