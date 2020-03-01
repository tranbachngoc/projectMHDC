<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>

<tr>
    <td valign="top">
        <script type="text/javascript">
            function checkToEdit(id, baseUrl) {
                var isOk = true;
                jQuery(".text_edit_config_" + id).each(function (index) {
                    if (this.value == '' || jQuery.trim(this.value) == '') {
                        alert("Bạn phải nhập dữ liệu đầy đủ trước khi chỉnh sửa!");
                        jQuery('#' + jQuery(this).attr('id')).focus();
                        jQuery('#' + jQuery(this).attr('id')).val('');
                        isOk = false;
                    } else {
                        if (isValueCommissionSolution(this.value)) {
                        } else {
                            isOk = false;
                            alert("Bạn phải nhập dữ liệu dạng số!");
                        }
                    }
                });
                if (isOk) {
                    var commission = jQuery('#commission_' + id).val();

                    jQuery.ajax({
                        type: "POST",
                        url: baseUrl + "administ/system/config/commission_rate/ajax",
                        data: {id: id, rate: commission},
                        dataType: "json",
                        success: function (data) {
                            if (data == '1') {
                                alert("Cập nhật thành công!");
                            }
                        },
                        error: function () {
                            alert("No Data!");
                        }
                    });
                }
            }
        </script>
        <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top"><!--BEGIN: Main-->

                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td><!--BEGIN: Item Menu-->

                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="5%" height="67" class="item_menu_left"><a
                                                href="<?php echo base_url(); ?>administ/system/info"> <img
                                                    src="<?php echo base_url(); ?>templates/home/images/icon/information-icon.png"
                                                    border="0"/> </a></td>
                                        <td width="40%" height="67" class="item_menu_middle">Cấu hình hoa hồng</td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <div class="icon_item" id="icon_item_1"
                                                 onclick="ActionLink('<?php echo base_url(); ?>administ')"
                                                 onmouseover="ChangeStyleIconItem('icon_item_1',1)"
                                                 onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                                                <table width="100%" height="100%" align="center" border="0"
                                                       cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center"><img
                                                                src="<?php echo base_url(); ?>templates/admin/images/icon_back.png"
                                                                border="0"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item"
                                                            nowrap="nowrap"><?php echo $this->lang->line('back_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                <!--END Item Menu--></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
								<script>
								$(document).ready(function(){
	
									$('ul.tabs li').click(function(){
										var tab_id = $(this).attr('data-tab');

										$('ul.tabs li').removeClass('current');
										$('.tab-content').removeClass('current');

										$(this).addClass('current');
										$("#"+tab_id).addClass('current');
									})

								})
								</script>
								<style>
									ul.tabs{
										margin: 0 0 -1px;
										padding: 0px;
										list-style: none;
									}
									ul.tabs li{
										background: none;
										color: #222;
										display: inline-block;
										padding: 10px 20px;
										cursor: pointer;
										border: 1px solid #ddd;
										border-bottom: 0px;
									}

									ul.tabs li.current{
										background: #146EB4;
										color: #fff;
									}

									.tab-content{
										display: none;
									}

									.tab-content.current{
										display: inherit;
									}
								</style>
                                <div id="tabs">
                                  <ul class="tabs">
                                   	<li class="tab-link current" data-tab="tab-1">Hoa hồng mua sỉ - 01</li>
                                    <li class="tab-link " data-tab="tab-2">Hoa hồng bán sỉ - 02</li>
									<li class="tab-link " data-tab="tab-3" style="display: none;">Hoa hồng bán giải pháp - 03</li>
									<li class="tab-link " data-tab="tab-4">Hoa hồng mua lẻ - 04</li>
									<li class="tab-link " data-tab="tab-5">Hoa hồng bán lẻ - 05</li>
                                    <li class="tab-link " data-tab="tab-6">Hoa hồng mua lẻ Gian hàng - 08</li>
									<!--<li class="tab-link " data-tab="tab-6">Type-06</li>-->
                                  </ul>
                                  <div id="tab-1" class="tab-content current">
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="20" height="20" class="corner_lt_post"></td>
                                            <td height="20" class="top_post"></td>
                                            <td width="20" height="20" class="corner_rt_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" class="left_post"></td>
                                            <td align="center" valign="top">
                                                <div class="wapper_config">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td class="title_list">Tên nhóm</td>

                                                            <td class="title_list">Hoa hồng <br/>(%)</td>

                                                            <td class="title_list">Sửa</td>
                                                        </tr>
                                                        <?php foreach ($listConfig as $config): 
															if($config->type == '01') {
															?>
                                                            <tr>
                                                                <td class="detail_list">
                                                                    <b><?php echo $config->group_name; ?></b></td>

                                                                <td class="detail_list"><input disabled="disabled"
                                                                                               class="text_edit_config text_edit_config_<?php echo $config->id; ?> "
                                                                                               id="commission_<?php echo $config->id; ?>"
                                                                                               name="" type="text"
                                                                                               value="<?php echo $config->commission_rate; ?>"/>
                                                                </td>


                                                                <td class="detail_list" align="center"
                                                                    style="text-align:center">
                                                                    <button
                                                                        onclick="checkToEdit(<?php echo $config->id; ?>,'<?php echo base_url(); ?>')"
                                                                        class="save_commission_config save_commission_config_<?php echo $config->id; ?>">
                                                                        Lưu
                                                                    </button>
                                                                    <button
                                                                        onclick="editConfig(<?php echo $config->id; ?>);"
                                                                        class="edit_commission_config edit_commission_config_<?php echo $config->id; ?>">
                                                                        Sửa
                                                                    </button>
                                                                </td>
                                                            </tr>
															<?php } //endif ?>
														<?php endforeach; ?>


                                                    </table>
                                                </div>
                                            </td>
                                            <td width="20" class="right_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" height="20" class="corner_lb_post"></td>
                                            <td height="20" class="bottom_post"></td>
                                            <td width="20" height="20" class="corner_rb_post"></td>
                                        </tr>
                                    </table>
                                  </div>
                                  <div id="tab-2" class="tab-content">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="20" height="20" class="corner_lt_post"></td>
                                            <td height="20" class="top_post"></td>
                                            <td width="20" height="20" class="corner_rt_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" class="left_post"></td>
                                            <td align="center" valign="top">
                                                <div class="wapper_config">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td class="title_list">Tên nhóm</td>

                                                            <td class="title_list">Hoa hồng <br/>(%)</td>

                                                            <td class="title_list">Sửa</td>
                                                        </tr>
                                                        <?php foreach ($listConfig as $config): 
															if($config->type == '02') {
															?>
                                                            <tr>
                                                                <td class="detail_list">
                                                                    <b><?php echo $config->group_name; ?></b></td>

                                                                <td class="detail_list"><input disabled="disabled"
                                                                                               class="text_edit_config text_edit_config_<?php echo $config->id; ?> "
                                                                                               id="commission_<?php echo $config->id; ?>"
                                                                                               name="" type="text"
                                                                                               value="<?php echo $config->commission_rate; ?>"/>
                                                                </td>


                                                                <td class="detail_list" align="center"
                                                                    style="text-align:center">
                                                                    <button
                                                                        onclick="checkToEdit(<?php echo $config->id; ?>,'<?php echo base_url(); ?>')"
                                                                        class="save_commission_config save_commission_config_<?php echo $config->id; ?>">
                                                                        Lưu
                                                                    </button>
                                                                    <button
                                                                        onclick="editConfig(<?php echo $config->id; ?>);"
                                                                        class="edit_commission_config edit_commission_config_<?php echo $config->id; ?>">
                                                                        Sửa
                                                                    </button>
                                                                </td>
                                                            </tr>
															<?php } //endif ?>
														<?php endforeach; ?>

                                                    </table>
                                                </div>
                                            </td>
                                            <td width="20" class="right_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" height="20" class="corner_lb_post"></td>
                                            <td height="20" class="bottom_post"></td>
                                            <td width="20" height="20" class="corner_rb_post"></td>
                                        </tr>
                                    </table>
                                  </div>
                                  <div id="tab-3" class="tab-content" style="display: none;">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="20" height="20" class="corner_lt_post"></td>
                                            <td height="20" class="top_post"></td>
                                            <td width="20" height="20" class="corner_rt_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" class="left_post"></td>
                                            <td align="center" valign="top">
                                                <div class="wapper_config">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td class="title_list">Tên nhóm</td>

                                                            <td class="title_list">Hoa hồng <br/>(%)</td>

                                                            <td class="title_list">Sửa</td>
                                                        </tr>
                                                       <?php foreach ($listConfig as $config): 
															if($config->type == '03') {
															?>
                                                            <tr>
                                                                <td class="detail_list">
                                                                    <b><?php echo $config->group_name; ?></b></td>

                                                                <td class="detail_list"><input disabled="disabled"
                                                                                               class="text_edit_config text_edit_config_<?php echo $config->id; ?> "
                                                                                               id="commission_<?php echo $config->id; ?>"
                                                                                               name="" type="text"
                                                                                               value="<?php echo $config->commission_rate; ?>"/>
                                                                </td>


                                                                <td class="detail_list" align="center"
                                                                    style="text-align:center">
                                                                    <button
                                                                        onclick="checkToEdit(<?php echo $config->id; ?>,'<?php echo base_url(); ?>')"
                                                                        class="save_commission_config save_commission_config_<?php echo $config->id; ?>">
                                                                        Lưu
                                                                    </button>
                                                                    <button
                                                                        onclick="editConfig(<?php echo $config->id; ?>);"
                                                                        class="edit_commission_config edit_commission_config_<?php echo $config->id; ?>">
                                                                        Sửa
                                                                    </button>
                                                                </td>
                                                            </tr>
															<?php } //endif ?>
														<?php endforeach; ?>

                                                    </table>
                                                </div>
                                            </td>
                                            <td width="20" class="right_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" height="20" class="corner_lb_post"></td>
                                            <td height="20" class="bottom_post"></td>
                                            <td width="20" height="20" class="corner_rb_post"></td>
                                        </tr>
                                    </table>
                                  </div>
                                  <div id="tab-4" class="tab-content">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="20" height="20" class="corner_lt_post"></td>
                                            <td height="20" class="top_post"></td>
                                            <td width="20" height="20" class="corner_rt_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" class="left_post"></td>
                                            <td align="center" valign="top">
                                                <div class="wapper_config">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td class="title_list">Tên nhóm</td>

                                                            <td class="title_list">Hoa hồng <br/>(%)</td>

                                                            <td class="title_list">Sửa</td>
                                                        </tr>
                                                        <?php foreach ($listConfig as $config): 
															if($config->type == '04') {
															?>
                                                            <tr>
                                                                <td class="detail_list">
                                                                    <b><?php echo $config->group_name; ?></b></td>

                                                                <td class="detail_list"><input disabled="disabled"
                                                                                               class="text_edit_config text_edit_config_<?php echo $config->id; ?> "
                                                                                               id="commission_<?php echo $config->id; ?>"
                                                                                               name="" type="text"
                                                                                               value="<?php echo $config->commission_rate; ?>"/>
                                                                </td>


                                                                <td class="detail_list" align="center"
                                                                    style="text-align:center">
                                                                    <button
                                                                        onclick="checkToEdit(<?php echo $config->id; ?>,'<?php echo base_url(); ?>')"
                                                                        class="save_commission_config save_commission_config_<?php echo $config->id; ?>">
                                                                        Lưu
                                                                    </button>
                                                                    <button
                                                                        onclick="editConfig(<?php echo $config->id; ?>);"
                                                                        class="edit_commission_config edit_commission_config_<?php echo $config->id; ?>">
                                                                        Sửa
                                                                    </button>
                                                                </td>
                                                            </tr>
															<?php } //endif ?>
														<?php endforeach; ?>

                                                    </table>
                                                </div>
                                            </td>
                                            <td width="20" class="right_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" height="20" class="corner_lb_post"></td>
                                            <td height="20" class="bottom_post"></td>
                                            <td width="20" height="20" class="corner_rb_post"></td>
                                        </tr>
                                    </table>
                                  </div>
                                  <div id="tab-5" class="tab-content">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="20" height="20" class="corner_lt_post"></td>
                                            <td height="20" class="top_post"></td>
                                            <td width="20" height="20" class="corner_rt_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" class="left_post"></td>
                                            <td align="center" valign="top">
                                                <div class="wapper_config">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td class="title_list">Tên nhóm</td>

                                                            <td class="title_list">Hoa hồng <br/>(%)</td>

                                                            <td class="title_list">Sửa</td>
                                                        </tr>
                                                       <?php foreach ($listConfig as $config): 
															if($config->type == '05') {
															?>
                                                            <tr>
                                                                <td class="detail_list">
                                                                    <b><?php echo $config->group_name; ?></b></td>

                                                                <td class="detail_list"><input disabled="disabled"
                                                                                               class="text_edit_config text_edit_config_<?php echo $config->id; ?> "
                                                                                               id="commission_<?php echo $config->id; ?>"
                                                                                               name="" type="text"
                                                                                               value="<?php echo $config->commission_rate; ?>"/>
                                                                </td>


                                                                <td class="detail_list" align="center"
                                                                    style="text-align:center">
                                                                    <button
                                                                        onclick="checkToEdit(<?php echo $config->id; ?>,'<?php echo base_url(); ?>')"
                                                                        class="save_commission_config save_commission_config_<?php echo $config->id; ?>">
                                                                        Lưu
                                                                    </button>
                                                                    <button
                                                                        onclick="editConfig(<?php echo $config->id; ?>);"
                                                                        class="edit_commission_config edit_commission_config_<?php echo $config->id; ?>">
                                                                        Sửa
                                                                    </button>
                                                                </td>
                                                            </tr>
															<?php } //endif ?>
														<?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </td>
                                            <td width="20" class="right_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" height="20" class="corner_lb_post"></td>
                                            <td height="20" class="bottom_post"></td>
                                            <td width="20" height="20" class="corner_rb_post"></td>
                                        </tr>
                                    </table>
                                  </div>
                                  <div id="tab-6" class="tab-content">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="20" height="20" class="corner_lt_post"></td>
                                            <td height="20" class="top_post"></td>
                                            <td width="20" height="20" class="corner_rt_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" class="left_post"></td>
                                            <td align="center" valign="top">
                                                <div class="wapper_config">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td class="title_list">Tên nhóm</td>

                                                            <td class="title_list">Hoa hồng <br/>(%)</td>

                                                            <td class="title_list">Sửa</td>
                                                        </tr>
                                                        <?php foreach ($listConfig as $config):
															if($config->type == '08') {
															?>
                                                            <tr>
                                                                <td class="detail_list">
                                                                    <b><?php echo $config->group_name; ?></b></td>

                                                                <td class="detail_list"><input disabled="disabled"
                                                                                               class="text_edit_config text_edit_config_<?php echo $config->id; ?> "
                                                                                               id="commission_<?php echo $config->id; ?>"
                                                                                               name="" type="text"
                                                                                               value="<?php echo $config->commission_rate; ?>"/>
                                                                </td>


                                                                <td class="detail_list" align="center"
                                                                    style="text-align:center">
                                                                    <button
                                                                        onclick="checkToEdit(<?php echo $config->id; ?>,'<?php echo base_url(); ?>')"
                                                                        class="save_commission_config save_commission_config_<?php echo $config->id; ?>">
                                                                        Lưu
                                                                    </button>
                                                                    <button
                                                                        onclick="editConfig(<?php echo $config->id; ?>);"
                                                                        class="edit_commission_config edit_commission_config_<?php echo $config->id; ?>">
                                                                        Sửa
                                                                    </button>
                                                                </td>
                                                            </tr>
															<?php } //endif ?>
														<?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </td>
                                            <td width="20" class="right_post"></td>
                                        </tr>
                                        <tr>
                                            <td width="20" height="20" class="corner_lb_post"></td>
                                            <td height="20" class="bottom_post"></td>
                                            <td width="20" height="20" class="corner_rb_post"></td>
                                        </tr>
                                    </table>
                                  </div>
                                </div>


                              <div style="clear:both"></div> 
                            </td>
                        </tr>
                    </table>

                    <!--END Main--></td>
                <td width="10" class="right_main" valign="top"></td>
                <td width="2"></td>
            </tr>
            <tr>
                <td width="2" height="11"></td>
                <td width="10" height="11" class="corner_lb_main" valign="top"></td>
                <td height="11" class="middle_bottom_main"></td>
                <td width="10" height="11" class="corner_rb_main" valign="top"></td>
                <td width="2" height="11"></td>
            </tr>
        </table>
    </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>
