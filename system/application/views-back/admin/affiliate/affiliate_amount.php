<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>

<tr>
    <td valign="top">
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
                                                href="<?php echo base_url(); ?><?php echo $link; ?>"> <img
                                                    src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png"
                                                    border="0"/> </a></td>
                                        <td width="40%" height="67" class="item_menu_middle">Doanh số AF của <?php echo $user['use_username']; ?> <?php if($frdate != 0){ echo "( Từ ".date('d/m/Y', $frdate)." Đến ".date('d/m/Y',$todate)." )"; } ?></td>
                                        <td width="55%" height="67" class="item_menu_right"></td>
                                    </tr>
                                </table>

                                <!--END Item Menu--></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td align="center">
                                <!--BEGIN: Search-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="57%"></td>
                                        <td width="115" align="left" style="float:right" >
                                            <select  name="filter" id="filter" onchange="Ac_filter()" class="select_search">
                                                <option value=""><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                <option value="logindate">Doanh số</option>
                                            </select>
                                        </td>
                                        <!-- Them filter moi -->
                                         <td id="DivDateSearch_1" width="10" align="center" style="display:none"><b> Từ&nbsp;&nbsp; </b></td>
                                        <td id="DivDateSearch_2" width="60" align="left" style="display:none" >
                                            <select name="day" id="day" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('day_search'); ?></option>
                                                <?php $this->load->view('admin/common/day'); ?>
                                                
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_3" width="10" align="center" style="display:none" ><b>-</b></td>
                                        <td id="DivDateSearch_4" width="60" align="left" style="display:none" >
                                            <select name="month" id="month" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                <?php $this->load->view('admin/common/month'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_5" width="10" align="center" style="display:none" ><b>-</b></td>
                                        <td id="DivDateSearch_6" width="60" align="left" style="display:none" >
                                            <select name="year" id="year" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                <?php $this->load->view('admin/common/year'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_9" width="10" align="center" style="display:none" ><b> Đến&nbsp;&nbsp; </b></td>
                                        <td id="DivDateSearch_10" width="60" align="left" style="display:none" >
                                            <select name="tday" id="tday" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('day_search'); ?></option>
                                                <?php $this->load->view('admin/common/day'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_11" width="10" align="center" style="display:none" ><b>-</b></td>
                                        <td id="DivDateSearch_12" width="60" align="left" style="display:none" >
                                            <select name="tmonth" id="tmonth" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                <?php $this->load->view('admin/common/month'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_13" width="10" align="center" style="display:none" ><b>-</b></td>
                                        <td id="DivDateSearch_14" width="60" align="left" style="display:none" >
                                            <select name="tyear" id="tyear" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                <?php $this->load->view('admin/common/year'); ?>
                                            </select>
                                        </td>

                                        <!--

                                        <td id="DivDateSearch_2" width="0" align="left">
                                            <select style="display: none" name="day" id="day" class="select_datesearch">
                                                <option value="5"><?php echo $this->lang->line('day_search'); ?></option>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_3"  width="10" align="center"></td>
                                        <td id="DivDateSearch_4" width="60" align="left">

                                            <select name="month" id="month" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                <?php for($month = 1; $month <= 12; $month++){ ?>
                                                    <option value="<?php echo $month; ?>" <?php if($monthn == $month){ echo 'selected = "selected"'; } ?>>Tháng <?php echo $month; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_5" width="10" align="center"><b>-</b></td>
                                        <td id="DivDateSearch_6" width="60" align="left">
                                            <select name="year" id="year" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                <?php $this->load->view('admin/common/year'); ?>
                                            </select>
                                        </td> -->

                                        <td width="25" align="right">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="Ac_tion('<?php echo base_url().$link; ?>')" />
                                        </td>
                                    </tr>
                                </table>                                
                                <!--END Search-->
                            </td>
                        </tr>
                        <tr>
                            <td align="center"><!--BEGIN: Search-->

                                <!--END Search--></td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>

                        <tr>
                            <td><!--BEGIN: Content-->
                                <form name="frmShowcart" method="post">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="25" class="title_list">STT</td>
                                            <td width="20" class="title_list"><input type="checkbox" name="checkall" id="checkall" value="0"
                                              onclick="DoCheck(this.checked,'frmShowcart',0)"/>
                                            </td>
                                            <td class="title_list">Đơn hàng</td>
                                            <td class="title_list">Tên sản phẩm</td>
                                            <td class="title_list">Số lượng</td>
                                            <td class="title_list">Giá</td>

                                            <td class="title_list">Hoa hồng trên từng sản phẩm</td>
                                            <td class="title_list">Tổng tiền Hoa hồng</td>

                                            <td class="title_list">Người mua</td>
                                            <td class="title_list">Người bán</td>
                                            <td class="title_list">Trạng thái</td>
                                           <!-- <td class="title_list">Thanh toán</td>-->
                                        </tr>
                                        <!---->

                                        <?php
                                        $sumCommission = 0;
                                        foreach ($order as $k => $item) {
                                            if($item['pStatus'] == '98'){
                                                $sumCommission = $sumCommission + $item['af_amt'] ;
                                            }
                                            ?>
                                            <tr style="background:#<?php if ($k % 2 == 0) {
                                                echo 'F7F7F7';
                                            } else {
                                                echo 'FFF';
                                            } ?>;" id="DivRow_<?php echo $k; ?>"
                                                onmouseover="ChangeStyleRow('DivRow_<?php echo $k; ?>',<?php echo $k; ?>,1)"
                                                onmouseout="ChangeStyleRow('DivRow_<?php echo $k; ?>',<?php echo $k; ?>,2)">
                                                <td class="detail_list" style="text-align:center;">
                                                    <b><?php echo $num + $k + 1; ?></b></td>
                                                <td class="detail_list" style="text-align:center;"><input
                                                        type="checkbox" name="checkone[]" id="checkone"
                                                        value="<?php echo $item->shc_id; ?>"
                                                        onclick="DoCheckOne('frmShowcart')"/></td>
                                                <td class="detail_list"><a href="<?php echo base_url(); ?>administ/showcart/detail/<?php echo $item['id']; ?>"><?php echo $item['id']; ?></a></td>
                                                <td class="detail_list">

                                                    <a class="menu" href="<?php echo base_url(); ?><?php echo $item['pLink'] . RemoveSign($item['pName']); ?>" target="_blank"><?php echo $item['pName']; ?></a>
                                                </td>
                                                <td class="detail_list"
                                                    style="text-align:center;"><?php echo $item['qty']; ?></td>
                                                <td class="detail_list" style="text-align:right;"><span
                                                        style="color:#F00; font-weight:bold;"><?php echo number_format($item['pro_price'], 0, ",", "."); ?>
                                                        đ</span></td>
                                                <td class="detail_list" style="text-align:center;">

                                                   <?php if ($item['af_rate'] > 0) { echo $item['af_rate']; ?> % <?php } ?>
                                                    <?php if ($item['af_amt_original'] > 0) { echo $item['af_amt_original']; ?> đ <?php } ?>

                                                </td>
                                                <td class="detail_list" style="text-align:right;"><span style="color:#F00; font-weight:bold;"><?php echo number_format($item['af_amt'], 0, ",", "."); ?>
                                                        đ <?php if ($item['af_rate'] > 0) {
                                                            //echo '(' . $item['af_rate'] . '%)';
                                                        } ?></span>
                                                </td>

                                                <td class="detail_list" style="text-align:center;"><a class="menu"  href="<?php echo base_url(); ?>administ/user/edit/<?php echo $item['shc_buyer']; ?>">

                                                        <?php echo $item['use_username']; ?></a>
                                                </td>
                                                <td class="detail_list" style="text-align:center;"><a
                                                        href="<?php echo base_url(); ?><?php echo $item['saler']; ?>"><?php echo $item['saler']; ?></a>
                                                </td>
                                                <td class="detail_list"
                                                    style="text-align:center;"><?php echo $item['pState']; ?></td>
                                               <!-- <td class="detail_list" style="text-align:center;">
                                                    <?php /*if ($item['payment'] == 1): */?>
                                                        <img
                                                            src="<?php /*echo base_url(); */?>templates/admin/images/active.png"
                                                            style="cursor:pointer;" border="0" title="Đã thanh toán"/>
                                                    <?php /*else: */?>
                                                        <img
                                                            src="<?php /*echo base_url(); */?>templates/admin/images/deactive.png"
                                                            style="cursor:pointer;" border="0" title="Chưa thanh toán"/>
                                                    <?php /*endif; */?>
                                                </td>-->


                                            </tr>

                                        <?php } ?>

                                        <?php if(count($order) > 0){ ?>
                                        <tr>
                                            <td class="show_page" colspan="11" align="right"><br><b>Tổng tiền cần thanh toán: <span style="color: red;"><?php echo number_format($sumCommission, 0, ",", "."); ?> đ</span> </b></td>
                                        </tr>
                                        <?php } ?>
                                        <!---->
                                        <?php if(count($order) == 0){ ?>
                                        <tr>
                                            <td class="show_page" colspan="11" align="center">Không có dữ liệu</td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td class="show_page" colspan="11"><?php echo $pager; ?></td>
                                        </tr>
                                    </table>
                                </form>
                                <!--END Content--></td>
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
<?php if($frdate != 0 && $todate != 0){ 
    $fday = (int)date('d',$frdate);
    $fmonth = (int)date('m',$frdate);
    $fyear = (int)date('Y',$frdate);
    $tday = (int)date('d',$todate);
    $tmonth = (int)date('m',$todate);
    $tyear = (int)date('Y',$todate);
    ?> 
    <script type="text/javascript">        
        document.getElementById('DivDateSearch_1').style.display = "";
        document.getElementById('DivDateSearch_2').style.display = "";
        document.getElementById('DivDateSearch_3').style.display = "";
        document.getElementById('DivDateSearch_4').style.display = "";
        document.getElementById('DivDateSearch_5').style.display = "";
        document.getElementById('DivDateSearch_6').style.display = "";
        //to date
        document.getElementById('DivDateSearch_9').style.display = "";
        document.getElementById('DivDateSearch_10').style.display = "";
        document.getElementById('DivDateSearch_11').style.display = "";
        document.getElementById('DivDateSearch_12').style.display = "";
        document.getElementById('DivDateSearch_13').style.display = "";
        document.getElementById('DivDateSearch_14').style.display = ""; 

        var fd = <?php echo "$fday"; ?>;
        var fm = <?php echo "$fmonth"; ?>;
        var fy = <?php echo "$fyear"; ?>;
        var td = <?php echo "$tday"; ?>;
        var tm = <?php echo "$tmonth"; ?>;
        var ty = <?php echo "$tyear"; ?>; 

        //From day
        var sel1 = document.getElementById('day');
        var opts1 = sel1.options;
        for(var opt1, i = 0; opt1 = opts1[i]; i++) {
            if(opt1.value == fd) {
                sel1.selectedIndex = i;
                break;
            }
        }
        var sel2 = document.getElementById('month');
        var opts2 = sel2.options;
        for(var opt2, j = 0; opt2 = opts2[j]; j++) {
            if(opt2.value == fm) {
                sel2.selectedIndex = j;
                break;
            }
        }

        var sel3 = document.getElementById('year');
        var opts3 = sel3.options;
        for(var opt3, k = 0; opt3 = opts3[k]; k++) {
            if(opt3.value == fy) {
                sel3.selectedIndex = k;
                break;
            }
        }

        //To day
        var sel4 = document.getElementById('tday');
        var opts4 = sel4.options;
        for(var opt4, m = 0; opt4 = opts4[m]; m++) {
            if(opt4.value == td) {
                sel4.selectedIndex = m;
                break;
            }
        }
        var sel5 = document.getElementById('tmonth');
        var opts5 = sel5.options;
        for(var opt5, n = 0; opt5 = opts5[n]; n++) {
            if(opt5.value == tm) {
                sel5.selectedIndex = n;
                break;
            }
        }

        var sel6 = document.getElementById('tyear');
        var opts6 = sel6.options;
        for(var opt6, p = 0; opt6 = opts6[p]; p++) {
            if(opt6.value == ty) {
                sel6.selectedIndex = p;
                break;
            }
        }
        
        
    </script>
<?php } ?>
<script type="text/javascript">    
    function Ac_filter()
    {   
        var isFilter = ''; 
        isFilter =  document.getElementById('filter').value;
        if(isFilter == 'logindate'){
            if(document.getElementById('DivDateSearch_2').style.display == "none"
                || document.getElementById('DivDateSearch_4').style.display == "none"
                || document.getElementById('DivDateSearch_6').style.display == "none"
                || document.getElementById('DivDateSearch_10').style.display == "none"
                || document.getElementById('DivDateSearch_12').style.display == "none"
                || document.getElementById('DivDateSearch_14').style.display == "none"){
                document.getElementById('DivDateSearch_1').style.display = "";
                document.getElementById('DivDateSearch_2').style.display = "";
                document.getElementById('DivDateSearch_3').style.display = "";
                document.getElementById('DivDateSearch_4').style.display = "";
                document.getElementById('DivDateSearch_5').style.display = "";
                document.getElementById('DivDateSearch_6').style.display = "";
                //to date
                document.getElementById('DivDateSearch_9').style.display = "";
                document.getElementById('DivDateSearch_10').style.display = "";
                document.getElementById('DivDateSearch_11').style.display = "";
                document.getElementById('DivDateSearch_12').style.display = "";
                document.getElementById('DivDateSearch_13').style.display = "";
                document.getElementById('DivDateSearch_14').style.display = "";                
            }
        }   
    }
    function Ac_tion(text){
        var isFilter = '';
        var fday = '', fmonth = '', fyear = '';
        var tday = '', tmonth = '', tyear = '';

        fday = document.getElementById('day').value;
        fmonth = document.getElementById('month').value;
        fyear = document.getElementById('year').value;
        tday = document.getElementById('tday').value;
        tmonth = document.getElementById('tmonth').value;
        tyear = document.getElementById('tyear').value;

        var frkey = mktime(0,0,0, fmonth, fday, fyear);
        var tokey = mktime(23, 59, 59, tmonth, tday, tyear);

        window.location.href = text+'/frkey/'+frkey+'/tokey/'+tokey;
    }
</script>

<?php $this->load->view('admin/common/footer'); ?>
