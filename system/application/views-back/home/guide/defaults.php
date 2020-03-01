<?php $this->load->view('home/common/header'); ?>
<!--BEGIN: LEFT-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_left.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_detail_defaults'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_left.jpg" style="padding-left:4px;" valign="top">
                <table width="585" class="post_main" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td height="20" class="post_top"></td>
                    </tr>
                    <tr>
                        <td class="title_guide">
                            <span id="DivIntroGuide"><?php echo $this->lang->line('welcome_guide_defaults'); ?></span>
							<span id="DivTitleGuide_1" class="DivGuide"><?php echo $this->lang->line('title_guide_1_defaults'); ?></span>
							<span id="DivTitleGuide_2" class="DivGuide"><?php echo $this->lang->line('title_guide_2_defaults'); ?></span>
							<span id="DivTitleGuide_3" class="DivGuide"><?php echo $this->lang->line('title_guide_3_defaults'); ?></span>
							<span id="DivTitleGuide_4" class="DivGuide"><?php echo $this->lang->line('title_guide_4_defaults'); ?></span>
							<span id="DivTitleGuide_5" class="DivGuide"><?php echo $this->lang->line('title_guide_5_defaults'); ?></span>
							<span id="DivTitleGuide_6" class="DivGuide"><?php echo $this->lang->line('title_guide_6_defaults'); ?></span>
							<span id="DivTitleGuide_7" class="DivGuide"><?php echo $this->lang->line('title_guide_7_defaults'); ?></span>
							<span id="DivTitleGuide_8" class="DivGuide"><?php echo $this->lang->line('title_guide_8_defaults'); ?></span>
							<span id="DivTitleGuide_9" class="DivGuide"><?php echo $this->lang->line('title_guide_9_defaults'); ?></span>
						</td>
                    </tr>
                    <tr>
                        <td height="10" class="post_bottom"></td>
                    </tr>
                </table>
                <table id="DivGuide" class="DivGuide" width="585" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td class="content_guide">
							<span id="DivContentGuide_1" class="DivGuide"><?php echo $this->lang->line('content_guide_1_defaults'); ?></span>
							<span id="DivContentGuide_2" class="DivGuide"><?php echo $this->lang->line('content_guide_2_defaults'); ?></span>
							<span id="DivContentGuide_3" class="DivGuide"><?php echo $this->lang->line('content_guide_3_defaults'); ?></span>
							<span id="DivContentGuide_4" class="DivGuide"><?php echo $this->lang->line('content_guide_4_defaults'); ?></span>
							<span id="DivContentGuide_5" class="DivGuide"><?php echo $this->lang->line('content_guide_5_defaults'); ?></span>
							<span id="DivContentGuide_6" class="DivGuide"><?php echo $this->lang->line('content_guide_6_defaults'); ?></span>
							<span id="DivContentGuide_7" class="DivGuide"><?php echo $this->lang->line('content_guide_7_defaults'); ?></span>
							<span id="DivContentGuide_8" class="DivGuide"><?php echo $this->lang->line('content_guide_8_defaults'); ?></span>
							<span id="DivContentGuide_9" class="DivGuide"><?php echo $this->lang->line('content_guide_9_defaults'); ?></span>
						</td>
                    </tr>
                    <tr>
                        <td width="585" height="30" style="background:url(<?php echo base_url(); ?>templates/home/images/bottom_guide_detail.png) no-repeat bottom;"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_left.png" height="16" ></td>
        </tr>
    </table>
</td>
<!--END LEFT-->
<!--BEGIN: RIGHT-->
<td width="402" valign="top">
    <table width="402" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_right.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_list_defaults'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_right.jpg" valign="top" style="padding:10px;">
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="25"><?php echo $this->lang->line('welcome_right_guide_defaults'); ?></td>
					</tr>
				</table>
                <table border="0" width="100%" cellpadding="0" cellspacing="0" >
                    <tr>
                        <td width="5" valign="top" ><img src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /></td>
                        <td class="list_2" style="font-size:12px;" valign="top">
							<a id="DivListGuide_1" class="menu_1" onclick="Guide(1)" href="#Guide" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $this->lang->line('title_guide_1_defaults'); ?></a>
						</td>
                    </tr>
                    <tr>
                        <td width="5" valign="top" ><img src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /></td>
                        <td class="list_2" style="font-size:12px;" valign="top">
							<a id="DivListGuide_2" class="menu_1" onclick="Guide(2)" href="#Guide" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $this->lang->line('title_guide_2_defaults'); ?></a>
						</td>
                    </tr>
                    <tr>
                        <td width="5" valign="top" ><img src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /></td>
                        <td class="list_2" style="font-size:12px;" valign="top">
							<a id="DivListGuide_3" class="menu_1" onclick="Guide(3)" href="#Guide" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $this->lang->line('title_guide_3_defaults'); ?></a>
						</td>
                    </tr>
                    <tr>
                        <td width="5" valign="top" ><img src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /></td>
                        <td class="list_2" style="font-size:12px;" valign="top">
							<a id="DivListGuide_4" class="menu_1" onclick="Guide(4)" href="#Guide" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $this->lang->line('title_guide_4_defaults'); ?></a>
						</td>
                    </tr>
                    <tr>
                        <td width="5" valign="top" ><img src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /></td>
                        <td class="list_2" style="font-size:12px;" valign="top">
							<a id="DivListGuide_5" class="menu_1" onclick="Guide(5)" href="#Guide" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $this->lang->line('title_guide_5_defaults'); ?></a>
						</td>
                    </tr>
                    <tr>
                        <td width="5" valign="top" ><img src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /></td>
                        <td class="list_2" style="font-size:12px;" valign="top">
							<a id="DivListGuide_6" class="menu_1" onclick="Guide(6)" href="#Guide" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $this->lang->line('title_guide_6_defaults'); ?></a>
						</td>
                    </tr>
                    <tr>
                        <td width="5" valign="top" ><img src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /></td>
                        <td class="list_2" style="font-size:12px;" valign="top">
							<a id="DivListGuide_7" class="menu_1" onclick="Guide(7)" href="#Guide" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $this->lang->line('title_guide_7_defaults'); ?></a>
						</td>
                    </tr>
                    <tr>
                        <td width="5" valign="top"><img src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /></td>
                        <td class="list_2" style="font-size:12px;" valign="top">
							<a id="DivListGuide_8" class="menu_1" onclick="Guide(8)" href="#Guide" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $this->lang->line('title_guide_8_defaults'); ?></a>
						</td>
                    </tr>
                    <tr>
                        <td width="5" valign="top"><img src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /></td>
                        <td class="list_2" style="font-size:12px;" valign="top">
							<a id="DivListGuide_9" class="menu_1" onclick="Guide(9)" href="#Guide" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $this->lang->line('title_guide_9_defaults'); ?></a>
						</td>
                    </tr>
					<tr>
					    <td colspan="2" align="right" class="show_page" style="padding-right:0px;"></td>
					</tr>
                </table>
                <table align="left" border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="20"></td>
                        <td width="30"><!--<img src="<?php echo base_url(); ?>templates/home/images/word.jpg" style="cursor:pointer;" onclick="ActionLink('<?php echo base_url(); ?>templates/guide/data/thongtindichvu.doc')" border="0" />--></td>
                        <td width="40%" style="color:#06F; font-weight:bold;"><!--<span onclick="ActionLink('<?php echo base_url(); ?>templates/guide/data/thongtindichvu.doc')" style="cursor:pointer;"><?php echo $this->lang->line('info_service_defaults'); ?></span>--></td>
                        <td width="20"></td>
                        <td width="30"><!--<img src="<?php echo base_url(); ?>templates/home/images/word.jpg" style="cursor:pointer;" onclick="ActionLink('<?php echo base_url(); ?>templates/guide/data/banggiadichvu.doc')" border="0" />--></td>
                        <td width="40%" style="color:#06F; font-weight:bold;"><!--<span onclick="ActionLink('<?php echo base_url(); ?>templates/guide/data/banggiadichvu.doc')" style="cursor:pointer;"><?php echo $this->lang->line('download_cost_defaults'); ?></span>--></td>
					</tr>
                    <tr>
                        <td valign="top" colspan="6"><?php echo $this->lang->line('global_info'); ?></td>
					</tr>
				</table>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_right.png" height="16" ></td>
        </tr>
    </table>
</td>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>