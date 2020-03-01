<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#filter").trigger('click');
        });
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
                                                <a href="<?php echo base_url(); ?>administ/commission">
                                                    <img src="<?php echo base_url(); ?>templates/home/images/icon/email-download-icon.png" border="0" />
                                                </a>
                                            </td>
                                            <td width="40%" height="67" class="item_menu_middle">Hoa hồng
                                                <?php
                                                $user_name = strtolower($this->uri->segment(3));
                                                $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
                                                if ($user_name !=FALSE && $user_name !="" && in_array($user_name, $action) == 0) {
                                                    echo '('.$user_name.' )';
                                                }
                                                ?>

                                                <?php if($monthn > 0){ echo "( Tháng ".$monthn." )"; } ?>
                                            </td>
                                            <td width="55%" height="67" class="item_menu_right">
                                                <?php
                                                $user_name = strtolower($this->uri->segment(3));
                                                $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
                                                if ($user_name !=FALSE && $user_name !="" && in_array($user_name, $action) == 0) {
                                                    $sum = 0;
                                                    foreach($commission as $key=>$value){
                                                        if(isset($value->commission))
                                                            $sum += $value->commission;
                                                    }
                                                    echo '<span style="color: #ff0000; font-size:16px"><b>Tổng hoa hồng: '.number_format($sum).' đ</b></span>';
                                                }?>
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
                                                <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" />
                                            </td>
                                            <td align="left">
                                                <select name="search" id="search"  class="select_search">
                                                    <option value="username">Tài khoản</option>
                                                    <option value="fullname">Họ và tên</option>
                                                </select>
                                                <select name="filter" id="filter" class="select_search">
                                                    <option value="hoahongthang">Hoa hồng tháng</option>
                                                </select>
                                                <select name="month" id="month" class="select_datesearch">
                                                    <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                    <?php for($month = 1; $month <= 12; $month++){ ?>
                                                        <option value="<?php echo $month; ?>" <?php if($monthn == $month){ echo 'selected = "selected"'; } ?>><?php echo $month; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <select name="year" id="year" class="select_datesearch">
                                                    <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                    <?php for($year = 2015; $year <= (int)date('Y'); $year++){ ?>
                                                        <?php if($year == (int)date('Y')){ ?>
                                                            <option value="<?php echo $year; ?>" <?php if($year == $yearn) echo 'selected="selected"'; ?>><?php echo $year; ?></option>
                                                        <?php }else{ ?>
                                                            <option value="<?php echo $year; ?>" <?php if($year == $yearn) echo 'selected="selected"'; ?>><?php echo $year; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <input type="hidden" id="username" name="username" value="<?php echo $user_name; ?>" />
                                                <button class="btn btn-default1" onclick="ActionSearchFilter('<?php echo base_url() ?>administ/commission/',1)"><i class="fa fa-search"></i></button>
                                            </td>
                                            <td width="25" align="right">
                                            </td>
                                        </tr>
                                    </table>
                                    <!--END Search-->
                                </td>
                            </tr>
                            <tr>
                                <td height="5"></td>
                            </tr>
                            <form name="frmContact" method="post">
                                <tr>
                                    <td>
                                        <!--BEGIN: Content-->
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="25" class="title_list">STT</td>
                                                <td width="20" class="title_list">
                                                    <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmContact',0)" />
                                                </td>
                                                <td class="title_list">
                                                    Tên tài khoản<br />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>username/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>username/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td class="title_list">
                                                    Họ và tên<br />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>fullname/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>fullname/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td  class="title_list">
                                                    Người giới thiệu<br />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>parentuse/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>parentuse/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td  class="title_list">
                                                    Nhóm<br />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>ground/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>ground/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td class="title_list">
                                                    Ngày tạo
                                                </td>
                                                <td class="title_list">
                                                  Hoa hồng tháng
                                                </td>
                                                <td  class="title_list">
                                                    Loại hoa hồng <br />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>type/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>type/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td class="title_list">
                                                  Mô tả
                                                </td>
                                                <td class="title_list">
                                                   Hoa hồng<br />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>commission/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>commission/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                               <!-- <td  class="title_list">
                                                    Ngày thanh toán<br />
                                                    <img src="<?php /*echo base_url(); */?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php /*echo $sortUrl; */?>date/by/asc<?php /*echo $pageSort; */?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php /*echo base_url(); */?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php /*echo $sortUrl; */?>date/by/desc<?php /*echo $pageSort; */?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td width="125" class="title_list">
                                                    Thanh toán<br />
                                                    <img src="<?php /*echo base_url(); */?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php /*echo $sortUrl; */?>status/by/asc<?php /*echo $pageSort; */?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php /*echo base_url(); */?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php /*echo $sortUrl; */?>status/by/desc<?php /*echo $pageSort; */?>')" style="cursor:pointer;" border="0" />
                                                </td>-->
                                            </tr>
                                            <!---->
                                            <?php $idDiv = 1; ?>
                                            <?php foreach($commission as $commissionArray){
                                                ?>
                                                <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                                    <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $commissionArray->id; ?>" onclick="DoCheckOne('frmContact')" />
                                                    </td>
                                                    <td class="detail_list">
                                                        <a class="menu" href="<?php echo base_url(); ?>administ/commission/<?php echo $commissionArray->use_username; ?>/filter/hoahongthang/key/<?php echo $key; ?>" alt="<?php echo $this->lang->line('view_tip'); ?>">
                                                            <?php echo $commissionArray->use_username; ?>
                                                        </a>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php echo $commissionArray->use_fullname; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?php echo base_url().'administ/user/edit/'.$commissionArray->id_username_parent ?>">
                                                            <?php  echo $commissionArray->use_username_parent;  ?>
                                                        </a>
                                                    </td>
                                                    <td class="text-center" >
                                                        <?php echo $commissionArray->gro_name; ?>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <?php echo date('d/m/Y - H:m', $commissionArray->created_date); ?>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <?php echo $commissionArray->commission_month; ?>
                                                    </td>
                                                    <td class="detail_list" style="text-align:left;"><b><?php echo $commissionArray->text; ?></b></td>
                                                     <td class="detail_list" style="text-align:left;"><b><?php echo $commissionArray->description; ?></b></td>
                                                    <td class="detail_list" style="text-align:right; color: #ff0000"><b><?php echo number_format($commissionArray->commission, 0, ',','.').' đ'; ?></b></td>
                                                    <!--<td class="detail_list" style="text-align:center;"><?php /*echo date('d/m/Y : H:m', $commissionArray->payment_date); */?></td>
                                                    <td class="detail_list" style="text-align:center;"><b><?php /*if( $commissionArray->payment_status == 0) {echo 'Chưa thanh toán';}else {echo 'Đã thanh toán';} */?></b></td>-->
                                                </tr>
                                                <?php $idDiv++; ?>
                                            <?php } ?>
                                            <!---->
                                            <tr>
                                                <td class="show_page" colspan="8"><?php echo $linkPage; ?></td>
                                            </tr>
                                        </table>
                                        <!--END Content-->
                                    </td>
                                </tr>
                            </form>
                        </table>
                        <!--END Main-->
                    </td>
                    <td width="10" class="right_main" valign="top"></td>
                    <td width="2"></td>
                </tr>
            </table>
        </td>
    </tr>
<?php $this->load->view('admin/common/footer'); ?>