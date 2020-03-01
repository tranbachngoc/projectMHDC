<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<?php $url =  $this->uri->segment(4); ?>
<?php $url1 =  $this->uri->segment(5); ?>
<script>
    function Sort(type) {
        var uid = '<?php echo $url ;?>';
        var type1 = type;
        window.location.href = '<?php echo base_url(); ?>administ/shop/statistics/'+uid+'/'+type1;
    }
</script>
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
                                                <a href="<?php echo base_url(); ?>administ/showcart/news_order_saler">
                                                    <img src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" border="0" />
                                                </a>
                                            </td>
                                            <td width="40%" height="67" class="item_menu_middle"><?php echo $page['title'] ?></td>
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
                                    <form action="" method="post" class="form-inline">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>

                                            <td width="160" align="left">
                                                <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url().'administ/shop/statistics/'.$url.'/search/name/keyword/'; ?>','keyword')" />
                                            </td>
                                            <td width="120" align="left">
                                                <select name="search" id="search" onchange="ActionSearch('<?php echo base_url(); ?>administ/shop/statistics/',1)" class="select_search">
                                                    <option value="0"><?php echo $this->lang->line('search_by_search'); ?></option>
                                                    <option value="orderid" <?php echo $params['search']=='orderid'?'selected="selected"':''  ?>>Mã đơn hàng</option>
                                                    <option value="buyer" <?php echo $params['search']=='buyer'?'selected="selected"':''  ?>>Người mua</option>
                                                </select>
                                            </td>
                                            <td align="left">
                                                <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url().'administ/showcart/news_order_saler/'.$url; ?>',1)" title="<?php echo $this->lang->line('search_tip'); ?>" />
                                            </td>
                                            <!---->
<!--                                            <td align="right">-->
<!--                                                <select name="pro_type" id="pro_type" class="form-control">-->
<!--                                                    <option value="">Lọc theo loại</option>-->
<!--                                                    <option --><?php //echo ($pro_type =='product') ? 'selected ="selected"' : ''; ?><!-- value="product">Sản phẩm</option>-->
<!--                                                    <option --><?php //echo ($pro_type =='service') ? 'selected ="selected"' : ''; ?><!-- value="service">Dịch vụ</option>-->
<!--                                                    <option --><?php //echo ($pro_type =='coupon') ? 'selected ="selected"' : ''; ?><!-- value="coupon">Coupon</option>-->
<!--                                                    <option value="logindate">--><?php //echo $this->lang->line('payment_title_search'); ?><!--</option>-->
<!--                                                </select>-->
<!--                                                <select name="month" id="month"  class="form-control">-->
<!--                                                    <option value="">--><?php //echo $this->lang->line('month_search'); ?><!--</option>-->
<!--                                                    --><?php
//                                                    for ($i = 1; $i <= 12; $i++) {
//                                                        $x = str_pad($i, 2, 0, STR_PAD_LEFT);
//                                                    ?>
<!--                                                        <option --><?php // if (isset($month) && $month == $i || ($month =='' && date('n') == $i)) { echo  'selected="selected"'; } ?><!-- value="--><?php //echo $i; ?><!--">--><?php //echo 'Tháng '.$x; ?><!--</option>-->
<!--                                                    --><?php //}  ?>
<!--                                                    ?>-->
<!--                                                </select> --->
<!--                                                <select name="year" id="year" class="form-control">-->
<!--                                                    <option value="0">--><?php //echo $this->lang->line('year_search'); ?><!--</option>-->
<!--                                                    --><?php //$this->load->view('admin/common/year'); ?>
<!--                                                </select>-->
                                            <td align="right">
                                                <?php $uidd = $this->uri->segment(4); ?>
                                                <select name="filter" id="filter" onchange="ActionSearch('<?php echo base_url(); ?>administ/shop/statistics/<?php echo $uidd;?>/',2)" class="select_search">
                                                    <option value="">Lọc theo loại</option>
                                                    <option <?php echo ($pro_type =='product') ? 'selected ="selected"' : ''; ?> value="product">Sản phẩm</option>
                                                    <option <?php echo ($pro_type =='service') ? 'selected ="selected"' : ''; ?> value="service">Dịch vụ</option>
                                                    <option <?php echo ($pro_type =='coupon') ? 'selected ="selected"' : ''; ?> value="coupon">Coupon</option>
                                                    <option value="statisticaldate"><?php echo $this->lang->line('payment_title_search'); ?></option>
                                                    </select>
<!--                                            <td id="DivDateSearch_1" width="100" align="center"><b>Từ ngày:</b></td>-->
<!--                                            <td id="DivDateSearch_2" width="60" align="left">-->
<!--                                                <select name="day" id="day" class="select_datesearch">-->
<!--                                                    <option value="0">--><?php //echo $this->lang->line('day_search'); ?><!--</option>-->
<!--                                                    --><?php //$this->load->view('admin/common/day'); ?>
<!--                                                </select>-->
<!--                                            </td>-->
<!--                                            <td id="DivDateSearch_3" width="10" align="center"><b>-</b></td>-->
<!--                                            <td id="DivDateSearch_4" width="60" align="left">-->
<!--                                                <select name="month" id="month" class="select_datesearch">-->
<!--                                                    <option value="0">--><?php //echo $this->lang->line('month_search'); ?><!--</option>-->
<!--                                                    --><?php //$this->load->view('admin/common/month'); ?>
<!--                                                </select>-->
<!--                                            </td>-->
<!--                                            <td id="DivDateSearch_5" width="10" align="center"><b>-</b></td>-->
<!--                                            <td id="DivDateSearch_6" width="60" align="left">-->
<!--                                                <select name="year" id="year" class="select_datesearch">-->
<!--                                                    <option value="0">--><?php //echo $this->lang->line('year_search'); ?><!--</option>-->
<!--                                                    --><?php //$this->load->view('admin/common/year'); ?>
<!--                                                </select>-->
<!--                                            </td>-->
<!--                                            <td id="DivDateSearch_7" width="10" align="center"><b>-</b></td>-->
<!--                                            <td id="DivDateSearch_8" width="60" align="left">-->
<!---->
<!--                                            </td>-->
<!---->
<!---->
<!--                                            <td id="DivDateSearch_9" width="40" align="center"><b>Đến :</b></td>-->
<!--                                            <td id="DivDateSearch_10" width="60" align="left">-->
<!--                                                <select name="dayend" id="tday" class="select_datesearch">-->
<!--                                                    <option value="0">--><?php //echo $this->lang->line('day_search'); ?><!--</option>-->
<!--                                                    --><?php //$this->load->view('admin/common/day'); ?>
<!--                                                </select>-->
<!--                                            </td>-->
<!--                                            <td id="DivDateSearch_11" width="10" align="center"><b>-</b></td>-->
<!--                                            <td id="DivDateSearch_12" width="60" align="left">-->
<!--                                                <select name="monthend" id="tmonth" class="select_datesearch">-->
<!--                                                    <option value="0">--><?php //echo $this->lang->line('month_search'); ?><!--</option>-->
<!--                                                    --><?php //$this->load->view('admin/common/month'); ?>
<!--                                                </select>-->
<!--                                            </td>-->
<!--                                            <td id="DivDateSearch_13" width="10" align="center"><b>-</b></td>-->
<!--                                            <td id="DivDateSearch_14" width="60" align="left">-->
<!--                                                <select name="yearend" id="tyear" class="select_datesearch">-->
<!--                                                    <option value="0">--><?php //echo $this->lang->line('year_search'); ?><!--</option>-->
<!--                                                    --><?php //$this->load->view('admin/common/year'); ?>
<!--                                                </select>-->
<!--                                            </td>-->
<!--                                            --><?php //	$getallaf = $this->uri->segment(3); ?>
<!--                                            <script>OpenTabSearch('0',0);</script>-->
<!--                                            </td>-->
<!--                                            <td width="25" align="right">-->
<!--                                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>-->
<!--                                            </td>-->
                                            <td id="DivDateSearch_1" width="100" align="center"><b>Từ ngày:</b></td>
                                            <td id="DivDateSearch_2" width="60" align="left">
                                                <select name="day" id="day" class="select_datesearch">
                                                    <option value="0"><?php echo $this->lang->line('day_search'); ?></option>
                                                    <?php for($day = 1; $day <= 31; $day++){ ?>
                                                        <?php if($day != $daypost) { ?>
                                                            <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                                        <?php } else {?>
                                                            <option value="<?php echo $day; ?>" selected><?php echo $day;?></option>
                                                        <?php }} ?>
                                                </select>
                                            </td>
                                            <td id="DivDateSearch_3" width="10" align="center"><b>-</b></td>
                                            <td id="DivDateSearch_4" width="60" align="left" style="display: block !important;">
                                                <select name="month" id="month" class="select_datesearch" >
                                                    <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                    <?php for($month = 1; $month <= 12; $month++){ ?>
                                                        <?php if($month != $monthpost) { ?>
                                                            <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                                        <?php } else {?>
                                                            <option value="<?php echo $month; ?>" selected><?php echo $month;?></option>
                                                        <?php }} ?>
                                                </select>

                                            </td>
                                            <td id="DivDateSearch_5" width="10" align="center" ><b>-</b></td>
                                            <td id="DivDateSearch_6" width="60" align="left">
                                                <select name="year" id="year" class="select_datesearch" >
                                                    <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                    <?php for($year = 2000; $year <= 2050; $year++){ ?>
                                                        <?php if($year != '20'.$yearpost) { ?>
                                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                        <?php } else {?>
                                                            <option value="<?php echo $year; ?>" selected><?php echo $year;?></option>
                                                        <?php }} ?>
                                                </select>
                                            </td>
                                            <td id="DivDateSearch_7" width="10" align="center"><b>-</b></td>
                                            <td id="DivDateSearch_8" width="60" align="left">
                                            </td>
                                            <td id="DivDateSearch_9" width="40" align="center"><b>Đến :</b></td>
                                            <td id="DivDateSearch_10" width="60" align="left">
                                                <select name="tday" id="tday" class="select_datesearch">
                                                    <option value="0"><?php echo $this->lang->line('day_search'); ?></option>
                                                    <?php for($day = 1; $day <= 31; $day++){ ?>
                                                        <?php if($day != $tdaypost) { ?>
                                                            <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                                        <?php } else {?>
                                                            <option value="<?php echo $day; ?>" selected><?php echo $day;?></option>
                                                        <?php }} ?>
                                                </select>
                                            </td>
                                            <td id="DivDateSearch_11" width="10" align="center"><b>-</b></td>
                                            <td id="DivDateSearch_12" width="60" align="left">
                                                <select name="tmonth" id="tmonth" class="select_datesearch">
                                                    <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                    <?php for($month = 1; $month <= 12; $month++){ ?>
                                                        <?php if($month != $tmonthpost) { ?>
                                                            <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                                        <?php } else {?>
                                                            <option value="<?php echo $month; ?>" selected><?php echo $month;?></option>
                                                        <?php }} ?>
                                                </select>
                                            </td>
                                            <td id="DivDateSearch_13" width="10" align="center"><b>-</b></td>
                                            <td id="DivDateSearch_14" width="60" align="left">
                                                <select name="tyear" id="tyear" class="select_datesearch">
                                                    <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                    <?php for($year = 2000; $year <= 2050; $year++){ ?>
                                                        <?php if($year != '20'.$tyearpost) { ?>
                                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                        <?php } else {?>
                                                            <option value="<?php echo $year; ?>" selected><?php echo $year;?></option>
                                                        <?php }} ?>
                                                </select>
                                            </td>
                                            <script>OpenTabSearch('0',0);</script>
                                            <td width="25" align="right">
                                                <!--                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>-->
                                                <?php $uid = $this->uri->segment(4); ?>
                                                <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/shop/statistics/<?php echo $uid;?>/',2)" title="<?php echo $this->lang->line('filter_tip'); ?>" />

                                            </td>
                                        </tr>
                                    </table>
                                    </form>
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
                                                <td class="title_list">
                                                    Mã đơn hàng
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>orderid/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>orderid/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td class="title_list">
                                                    Cửa hàng
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>shopname/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>shopname/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td class="title_list">
                                                    Phương thức thanh toán
                                                </td>
                                                <td class="title_list">
                                                    Nhà vận chuyển
                                                </td>
                                                <td width="170" class="title_list">
                                                    Trạng thái
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td class="title_list">
                                                    Số lượng
                                                </td>
                                                <td class="title_list">
                                                    Ngày mua hàng
                                                </td>
                                                <td class="title_list">
                                                    Tổng giá
                                                </td>
                                            </tr>
                                            <!---->
                                            <?php if (count($showcart) > 0  ) {?>
                                            <?php $idDiv = 1; $total = 0; ?>
                                            <?php foreach($showcart as $key => $showcartArray){
                                                ?>
                                                <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" >
                                                    <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                                    <td class="detail_list">
                                                        <a href="<?php echo base_url(); ?>administ/showcart/detail/<?php echo $showcartArray->id;  ?>"><?php echo $showcartArray->id; ?></a>
                                                    </td>
                                                    <td class="detail_list">
                                                        <a href="<?php echo base_url().$showcartArray->sho_link ?>">
                                                            <?php echo $showcartArray->sho_name ?>
                                                        </a>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php if($showcartArray->payment_method == "info_nganluong"){
                                                            echo 'Cổng thanh toán Ngân Lượng';
                                                        }?>
                                                        <?php if($showcartArray->payment_method == "info_cod"){
                                                            echo 'Thanh toán khi nhận hàng';
                                                        }?>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php
                                                        if($showcartArray->shipping_method == 'GHN'){
                                                            echo 'Giao hàng nhanh';
                                                        }
                                                        if($showcartArray->shipping_method == 'VTP'){
                                                            echo 'Viettel Post';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="detail_list">

                                                        <?php

                                                        switch ($showcartArray->order_status){
                                                            case '01':
                                                                echo '<span class="label label-info">'.status_1.'</span>';
                                                                break;
                                                            case '02':
                                                                echo '<span class="label label-success">'.status_2.'</span>';
                                                                break;
                                                            case '03':
                                                                echo '<span class="label label-primary">'.status_3.'</span>';
                                                                break;
                                                            case '04':
                                                                echo '<span class="label label-primary">'.status_4.'</span>';
                                                                break;
                                                            case '05':
                                                                echo '<span class="label label-primary">'.status_5.'</span>';
                                                                break;
                                                            case '06':
                                                                echo '<span class="label label-primary">'.status_6.'</span>';
                                                                break;
                                                            case '99':
                                                                echo '<span class="label label-danger">'.status_99.'</span>';
                                                                break;
                                                            case '98':

                                                                $total += $showcartArray->order_total_no_shipping_fee;
                                                                echo '<span class="label label-primary">'.status_98.'</span>';
                                                                break;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <a href="<?php echo base_url(); ?>administ/showcart/detail/<?php echo $showcartArray->id;  ?>"><?php echo $showcartArray->num_products; ?> sp</a></td>

                                                    <td class="detail_list" style="text-align:right;">
                                                        <b><?php echo date('d/m/Y', $showcartArray->shc_change_status_date); ?></b>
                                                    </td>
                                                    <td class="detail_list" style="text-align:right;">
                                                        <span style="color:#F00; font-weight:bold;"><?php echo number_format($showcartArray->order_total_no_shipping_fee, 0,",","."); ?> đ </span></td>

                                                </tr>
                                                <?php $idDiv++; ?>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="6" class="text-right detail_list" style="font-weight: 600; font-size: 15px">Tổng thu nhập từ đơn hàng:</td>
                                                <td colspan="2" class="detail_list"><span style="color:#F00; font-size: 15px"><b><?php echo number_format($total,0,",","."); ?> Đ</b></span></td>
                                            </tr>
                                            <!---->
                                            <tr>
                                                <td class="show_page" colspan="8"><?php echo $linkPage; ?></td>
                                            </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td class="detail_list text-center" colspan="8" >Không có dữ liệu</td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                        <!--END Content-->
                                    </form>
                                    <h3>Phí theo danh mục</h3>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                        <tr>
                                            <td width="25" class="title_list">STT</td>
                                            <td class="title_list">
                                                Tên danh mục
                                            </td>
                                            <td class="title_list">
                                               Tổng doanh thu
                                            </td>
                                            <td width="170" class="title_list">
                                                Phí theo danh mục
                                            </td>
                                            <td class="title_list">
                                                Tổng tiền phí
                                            </td>
                                        </tr>
                                        <?php if (count($list_cat) > 0){ ?>
                                        <!---->
                                        <?php $stt = 1; $total_cat = 0; ?>
                                        <?php foreach($list_cat as $key => $showcartArray){
                                            ?>
                                            <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $stt; ?>" >
                                                <td class="detail_list" style="text-align:center;"><b><?php echo $stt; ?></b></td>
                                                <td class="detail_list">
                                                    <a href="<?php echo base_url().$showcartArray->sho_link ?>">
                                                        <?php echo $showcartArray->cat_name ?>
                                                    </a>
                                                </td>
                                                <td class="detail_list">
                                                  <span style="color: #ff0000; font-weight: 600">  <?php echo number_format($showcartArray->total,0,",",".");?> Đ</span>
                                                </td>
                                                <td class="detail_list">
                                                    <?php echo $cat_fee[$key]->b2c_fee; ?>
                                                </td>
                                                <td class="detail_list">
                                                    <span style="color: #ff0000; font-weight: 600"> <?php echo  number_format(($showcartArray->total*$cat_fee[$key]->b2c_fee/100),0,",",".");?> Đ</span>
                                                    <?php $total_cat += ($showcartArray->total*$cat_fee[$key]->b2c_fee/100); ?>
                                                </td>
                                            </tr>
                                            <?php $stt++; ?>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="4" class="text-right detail_list" style="font-weight: 600; font-size: 15px">Tổng tiền phí:</td>
                                            <td class="detail_list"><span style="color:#F00; font-size: 15px"><b><?php echo number_format($total_cat,0,",","."); ?> Đ</b></span></td>
                                        </tr>
                                        <?php }else{ ?>
                                            <tr>
                                                <td colspan="5" class="text-center detail_list" >Không có dữ liệu</td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                    <h3>Hoa hồng cho Afiliate</h3>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="25" class="title_list">STT</td>
                                            <td class="title_list">
                                                Tên sản phẩm
                                            </td>
                                            <td class="title_list">
                                                Giá sản phẩm
                                            </td>
                                            <td class="title_list">
                                               Số lượng bán
                                            </td>
                                            <td class="title_list">
                                                AF bán
                                            </td>
                                            <td width="170" class="title_list">
                                               Hoa hồng %
                                            </td>
                                            <td width="170" class="title_list">
                                               Hoa hồng VNĐ
                                            </td>
                                            <td class="title_list">
                                                Tổng tiền phí
                                            </td>
                                        </tr>
                                        <!---->
                                        <?php if (count($list_af) > 0){ ?>
                                        <?php $stt = 1; $total_fee = 0; ?>
                                        <?php foreach($list_af as $key => $item){
                                            ?>
                                            <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $stt; ?>" >
                                                <td class="detail_list" style="text-align:center;"><b><?php echo $stt; ?></b></td>
                                                <td class="detail_list">
                                                    <?php echo $item->pro_name ?>
                                                </td>
                                                <td class="detail_list">
                                                    <span style="color: #ff0000; font-weight: 600">  <?php echo number_format($item->pro_cost,0,",",".");?> Đ</span>
                                                </td>
                                                <td class="detail_list">
                                                    <?php echo $item->shc_quantity; ?>
                                                </td>
                                                <td class="detail_list">
                                                    <a href="<?php echo base_url(); ?>administ/user/edit/<?php echo $item->use_id; ?>"><?php echo $item->use_username; ?></a>
                                                </td>
                                                <td class="detail_list">
                                                    <?php echo $item->af_rate; ?>%
                                                </td>
                                                <td class="detail_list">
                                                    <span style="color: #ff0000; font-weight: 600"> <?php echo  number_format($item->af_amt,0,",",".");?> Đ</span>
                                                </td>
                                                <td class="detail_list">
                                                    <?php
                                                    $total_com = 0;
                                                    if ($item->af_rate > 0){
                                                        $total_com = ($item->af_rate*$item->shc_total)/100;
                                                    }else{
                                                        $total_com = $item->af_amt*$item->shc_quantity;
                                                    }
                                                    $total_fee += $total_com;
                                                    ?>
                                                    <span style="color: #ff0000; font-weight: 600"> <?php echo  number_format($total_com,0,",",".");?> Đ</span>
                                                </td>
                                            </tr>
                                            <?php $stt++; ?>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="7" class="text-right detail_list" style="font-weight: 600; font-size: 15px">Tổng tiền phí:</td>
                                            <td class="detail_list"><span style="color:#F00; font-size: 15px"><b><?php echo number_format($total_fee,0,",","."); ?> Đ</b></span></td>
                                        </tr>
                                        <?php }else{ ?>
                                            <tr>
                                                <td colspan="8" class="text-center detail_list" >Không có dữ liệu</td>
                                            </tr>
                                        <?php }?>
                                    </table>
                                    <p style="padding: 15px; text-align: right; font-size: 17px" class="bg-info">Tổng thu nhập đã trừ phí : <span style="color:#ff0000; font-size: 16px"><b><?php echo number_format($total - ($total_cat + $total_fee),0,",","."); ?> Đ</b></span></p>
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