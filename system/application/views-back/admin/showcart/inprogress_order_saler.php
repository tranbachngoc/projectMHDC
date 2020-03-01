<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
    <tr>
        <td valign="top">
            <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="2"></td>
                    <td width="10" class="left_main" valign="top"></td>
                    <td align="center" valign="top">
                        <!--BEGIN: Main-->
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="10"></td>
                            </tr>
                            <tr>
                                <td>
                                    <!--BEGIN: Item Menu-->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="5%" height="67" class="item_menu_left">
                                                <a href="<?php echo base_url(); ?>administ/showcart/inprogress_order_saler">
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png"
                                                        border="0"/>
                                                </a>
                                            </td>
                                            <td width="40%" height="67"
                                                class="item_menu_middle"><?php echo $page['title'] ?></td>
                                            <td width="55%" height="67" class="item_menu_right">

                                            </td>
                                        </tr>
                                    </table>
                                    <!--END Item Menu-->
                                </td>
                            </tr>
                            <tr>
                                <td height="10"></td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <!--BEGIN: Search-->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="160" align="left">
                                                <input type="text" name="keyword" id="keyword"
                                                       value="<?php echo $keyword; ?>" maxlength="100"
                                                       class="input_search" onfocus="ChangeStyle('keyword',1)"
                                                       onblur="ChangeStyle('keyword',2)"
                                                       onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url(); ?>administ/showcart/inprogress_order_saler/search/name/keyword','keyword')"/>
                                            </td>
                                            <td width="120" align="left">
                                                <select name="search" id="search"
                                                        onchange="ActionSearch('<?php echo base_url(); ?>administ/showcart/inprogress_order_saler/',1)"
                                                        class="select_search">
                                                    <option
                                                        value="0"><?php echo $this->lang->line('search_by_search'); ?></option>
                                                    <option
                                                        value="orderid" <?php echo $params['search'] == 'orderid' ? 'selected="selected"' : '' ?>>
                                                        Mã đơn hàng
                                                    </option>
                                                    <option
                                                        value="buyer" <?php echo $params['search'] == 'buyer' ? 'selected="selected"' : '' ?>>
                                                        Người mua
                                                    </option>
                                                </select>
                                            </td>
                                            <td align="left">
                                                <img
                                                    src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif"
                                                    border="0" style="cursor:pointer;"
                                                    onclick="ActionSearch('<?php echo base_url(); ?>administ/showcart/inprogress_order_saler/',1)"
                                                    title="<?php echo $this->lang->line('search_tip'); ?>"/>
                                            </td>
                                            <!---->
                                            <td width="115" align="left">
                                                <select name="filter" id="filter"
                                                        onchange="ActionSearch('<?php echo base_url(); ?>administ/showcart/inprogress_order_saler/',2)"
                                                        class="select_search">
                                                    <option
                                                        value="0"><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                    <option
                                                        value="buydate"><?php echo $this->lang->line('buydate_search_defaults'); ?></option>
                                                    <!--<option value="process"><?php echo $this->lang->line('process_search_defaults'); ?></option>
                                                <option value="notprocess"><?php echo $this->lang->line('notprocess_search_defaults'); ?></option>-->
                                                </select>
                                            </td>
                                            <td id="DivDateSearch_1" width="10" align="center"><b>:</b></td>
                                            <td id="DivDateSearch_2" width="60" align="left">
                                                <select name="day" id="day" class="select_datesearch">
                                                    <option
                                                        value="0"><?php echo $this->lang->line('day_search'); ?></option>
                                                    <?php $this->load->view('admin/common/day'); ?>
                                                </select>
                                            </td>
                                            <td id="DivDateSearch_3" width="10" align="center"><b>-</b></td>
                                            <td id="DivDateSearch_4" width="60" align="left">
                                                <select name="month" id="month" class="select_datesearch">
                                                    <option
                                                        value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                    <?php $this->load->view('admin/common/month'); ?>
                                                </select>
                                            </td>
                                            <td id="DivDateSearch_5" width="10" align="center"><b>-</b></td>
                                            <td id="DivDateSearch_6" width="60" align="left">
                                                <select name="year" id="year" class="select_datesearch">
                                                    <option
                                                        value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                    <?php $this->load->view('admin/common/year'); ?>
                                                </select>
                                            </td>
                                            <script>OpenTabSearch('0', 0);</script>
                                            <td width="25" align="right">
                                                <img
                                                    src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif"
                                                    border="0" style="cursor:pointer;"
                                                    onclick="ActionSearch('<?php echo base_url(); ?>administ/showcart/inprogress_order_saler/',2)"
                                                    title="<?php echo $this->lang->line('filter_tip'); ?>"/>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--END Search-->
                                </td>
                            </tr>
                            <tr>
                                <td height="5"></td>
                            </tr>

                            <tr>

                                <td>
                                    <form name="listOrderProgress" id="listOrderProgress" method="post">
                                        <!--BEGIN: Content-->
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="25" class="title_list">STT</td>
                                                <td width="20" class="title_list">
                                                    <input type="checkbox" name="checkall" id="checkall" value="0"/>
                                                </td>
                                                <td class="title_list">
                                                    Mã đơn hàng
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>orderid/by/asc<?php echo $pageSort; ?>')"
                                                        style="cursor:pointer;" border="0"/>
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>orderid/by/desc<?php echo $pageSort; ?>')"
                                                        style="cursor:pointer;" border="0"/>
                                                </td>
                                                <td class="title_list">
                                                    Đã giao
                                                </td>
                                                <td class="title_list">
                                                    Cửa hàng
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>shopname/by/asc<?php echo $pageSort; ?>')"
                                                        style="cursor:pointer;" border="0"/>
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>shopname/by/desc<?php echo $pageSort; ?>')"
                                                        style="cursor:pointer;" border="0"/>
                                                </td>
                                                <td width="170" class="title_list">
                                                    Thời gian đặt hàng
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')"
                                                        style="cursor:pointer;" border="0"/>
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')"
                                                        style="cursor:pointer;" border="0"/>
                                                </td>
                                                <td class="title_list">
                                                    Phương thức thanh toán
                                                </td>
                                                <td class="title_list">
                                                    Nhà vận chuyển
                                                </td>
                                                <td class="title_list">
                                                    Số lượng
                                                </td>
                                                <td class="title_list">
                                                    Tổng giá
                                                </td>

                                                <td width="120" class="title_list">
                                                    Người mua
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>buyer/by/asc<?php echo $pageSort; ?>')"
                                                        style="cursor:pointer;" border="0"/>
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>buyer/by/desc<?php echo $pageSort; ?>')"
                                                        style="cursor:pointer;" border="0"/>
                                                </td>

                                            </tr>
                                            <!---->
                                            <?php $idDiv = 1; ?>
                                            <?php
                                            $protocol = "http://";
                                            $duoi = explode('//', base_url())[1];
                                            foreach ($showcart as $key => $showcartArray) {
                                                $shop = $protocol . $showcartArray->sho_link .'.'. $duoi . 'shop/';
                                                if ($showcartArray->domain != '') {
                                                    $shop = $protocol . $showcartArray->domain . '/shop/';
                                                }
                                                ?>
                                                <tr style="background:#<?php if ($idDiv % 2 == 0) {
                                                    echo 'F7F7F7';
                                                } else {
                                                    echo 'FFF';
                                                } ?>;" id="DivRow_<?php echo $idDiv; ?>">
                                                    <td class="detail_list" style="text-align:center;">
                                                        <b><?php echo $sTT++; ?></b></td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <input type="checkbox" name="orders_id[]"
                                                               id="order_id_<?php echo $key ?>"
                                                               value="<?php echo $showcartArray->shc_orderid . ',' . $showcartArray->shc_buyer . ',' . $showcartArray->shc_saler; ?>"/>
                                                    </td>
                                                    <td class="detail_list">
                                                        <a href="<?php echo base_url(); ?>administ/showcart/detail/<?php echo $showcartArray->id; ?>"><?php echo $showcartArray->id; ?></a>
                                                    </td>
                                                    <td style="text-align: center;">

                                                        <a class="chooseItem" href="javascript:void(0);"
                                                           title="<?php echo $this->lang->line('active_tip'); ?>"><img
                                                                src="<?php echo base_url(); ?>templates/home/images/unpublic.png"
                                                                style="cursor:pointer;" border="0"
                                                                alt="<?php echo $this->lang->line('active_tip'); ?>"
                                                                onclick="update_showcart_status('order_id_<?php echo $key ?>')"/>
                                                        </a>

                                                    </td>
                                                    <td class="detail_list">
                                                        <a href="<?php echo $shop ?>" target="_blank">
                                                            <?php echo $showcartArray->sho_name ?>
                                                        </a>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php echo date("d-m-Y H:i:s", $showcartArray->date); ?>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php if ($showcartArray->payment_method == "info_nganluong") {
                                                            echo 'Cổng thanh toán Ngân Lượng';
                                                        } ?>
                                                        <?php if ($showcartArray->payment_method == "info_cod") {
                                                            echo 'Thanh toán khi nhận hàng';
                                                        } ?>
                                                        <?php if ($showcartArray->payment_method == "info_bank") {
                                                            echo 'Chuyển khoản qua Ngân hàng';
                                                        } ?>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php if ($showcartArray->shipping_method == 'GHN') {
                                                            echo 'Giao hàng nhanh';
                                                        }
                                                        if ($showcartArray->shipping_method == 'VTP') {
                                                            echo 'Viettel Post';
                                                        }
                                                        if ($showcartArray->shipping_method == 'SHO') {
                                                            echo 'Shop Giao';
                                                        }
                                                        if ($showcartArray->shipping_method == 'GHTK') {
                                                            echo 'Giao hàng tiết kiệm';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <a href="<?php echo base_url(); ?>administ/showcart/detail/<?php echo $showcartArray->id; ?>"><?php echo $showcartArray->num_products; ?>
                                                            sản phẩm</a></td>

                                                    <td class="detail_list" style="text-align:right;">
                                                        <span
                                                            style="color:#F00; font-weight:bold;"><?php echo number_format($showcartArray->total_price, 0, ",", "."); ?>
                                                            đ </span></td>

                                                    <td class="detail_list" style="text-align:center;"><a
                                                            href="<?php echo base_url(); ?>administ/user/edit/<?php echo $showcartArray->order_user; ?>"><?php echo $showcartArray->use_username; ?></a>
                                                    </td>

                                                </tr>
                                                <?php $idDiv++; ?>
                                            <?php } ?>
                                            <!---->
                                            <tr>
                                                <td class="show_page" colspan="8"><?php echo $linkPage; ?></td>
                                            </tr>
                                        </table>
                                        <input type="hidden" name="current_status"
                                               value="<?php echo $page['status'] ?>">
                                        <input id='confirm_submit' type="submit" name="submit"
                                               value="<?php echo $page['next_status_title'] ?>">
                                        <!--END Content-->
                                    </form>
                                </td>
                            </tr>
                        </table>
                        <!--END Main-->
                    </td>
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