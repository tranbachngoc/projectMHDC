<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<style>
.red_money {
    float: right;
}
.red_money {
    color: #CC0000;
    font-weight: bold;
}
</style>

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
                                            <a href="<?php echo base_url(); ?>administ/recharge">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $page['title'] ?></td>
                                        <td width="55%" height="67" class="item_menu_right"></td>
                                    </tr>
                                </table>
                                <!--END Item Menu-->
                            </td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <?php  if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')){ ?>
                            <tr>
                                <td height="5">
                                    <div class="message success" onclick="this.classList.add('hidden')">
                                        <div class="alert <?php echo ($this->session->flashdata('flash_message_error')?'alert-danger':'alert-success')?>">
                                            <?php echo ($this->session->flashdata('flash_message_error')?$this->session->flashdata('flash_message_error'):$this->session->flashdata('flash_message_success')); ?>
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php  } ?>
                       <tr>
                           <td colspan="10">
                               <!--BEGIN: Search-->
                               <form id="adminForm" action="<?php echo $link; ?>" method="post" class="">
                                   <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                                   <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                                   <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                       <tr>
                                           <td width="160" align="left">
                                               <input class="input_search" id="search" type="text" name="q" value="<?php echo $filter['q']; ?>"  placeholder="...">
                                           </td>
                                           <td width="120" align="left">
                                               <select name="qt" autocomplete="off" class="select_search"  onchange="Act_Search()" >
                                                   <option value="">-Tìm kiếm theo-</option>
                                                   <option value="id">Mã nạp tiền</option>
                                               </select>
                                           </td>
                                           <td width="120" align="left">
                                               <input
                                                   class="searchBt" type="submit" value="" onclick="Act_Search()" />
                                           </td>
                                           <td align="left">

                                           </td>
                                           <!---->
                                           <td width="115" align="left">
                                           </td>
                                           <td width="25" align="right">
                                           </td>
                                       </tr>
                                   </table>
                               </form>
                               <!--END Search-->
                           </td>
                       </tr>
                        <tr>
                            <td colspan="10" height="10"></td>
                        </tr>
                        <tr>
                            <td>
                                <form name="listStatus" id="listStatus" method="post">
                                <!--BEGIN: Content-->
                                <table style="font-size: 13px" width="100%" class="table table-hovered">
                                    <tr>
                                        <td width="2%" class="title_list">STT</td>
                                        <td width="10%" class="title_list">Người gủi</td>
                                        <td width="15%" class="title_list">Thông tin người gủi</td>
                                        <td width="15%" class="title_list">Ngân hàng</td>
                                        <td width="6%" class="title_list">Số tiền (Đ)</td>
                                        <td width="10%" class="title_list">Ngày gởi yêu cầu</td>
                                        <td width="10%" class="title_list">Kế toán</td>
                                        <td width="10%" colspan="2" class="title_list">Admin</td>

                                    </tr>
                                    <!---->
                                    <?php $bank = json_decode(bankpayment); ?>
                                    <?php $idDiv = 1; ?>
                                        <?php foreach($walletlog as $key => $vals){ ?>
                                            <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" >
                                                <td >
                                                    <?php echo $sTT++; ?>
                                                </td>
                                                <td align="center">
                                                    <?php echo $vals->use_username; ?>
                                                </td>
                                                <td >
                                                   <p><b>Họ tên: </b><?php echo $vals->use_fullname; ?></p>
                                                   <p><b>Điện thoại: </b><?php echo $vals->use_mobile; ?></p>
                                                   <p><b>Email: </b><?php echo $vals->use_email; ?></p>
                                                   <p><b>Địa chỉ: </b><?php echo $vals->use_address; ?></p>
                                                </td>
                                                <td align="center">
                                                    Ngân hàng <?php echo $bank[$vals->bank_id]->bank_name; ?>
                                                </td>
                                                <td>
                                                    <span id="red_money_<?php echo $vals->id; ?>" class="red_money"><?php echo number_format($vals->amount, 0, ",", "."); ?></span>
                                                        <div style="display: none" id="form_amount_<?php echo $vals->id; ?>" class="form-group">
                                                         <input type="text" style="margin-bottom: 10px"  class="form-control input-sm amount_fake"  id="Amount_<?php echo $vals->id; ?>" placeholder="Nhập số tiền">
                                                            <button type="button" id="btn_save"  autocomplete="off" data-loading-text="Đang lưu..." onclick="updateAdmount('<?php echo $vals->id; ?>')" class="btn btn-primary btn-sm">Lưu lại</button>
                                                        </div>
                                                </td>
                                                <td >
                                                    <?php echo date("d-m-Y H:i:s", strtotime($vals->lastupdated)); ?>
                                                </td>
                                                <td align="center">
                                                    <?php
                                                    if($vals->status_id == 0){
                                                        ?>
                                                        <button <?php if ($this->session->userdata('sessionGroupAdmin') != 5) {?>  <?php }?> type="button" onclick="updateStatus('<?php echo $vals->id; ?>')" class="btn btn-primary">Nạp tiền</button>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img border="0" src="<?php echo base_url();?>templates/admin/images/active.png" alt="Đã nạp tiền" title="Đã nạp tiền"/> Đã nạp tiền
                                                        <p><?php echo date('H:i d-m-Y',$vals->update_by_accountant)?></p>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>

                                                    <td>
                                                        <?php if ($this->session->userdata('sessionGroupAdmin') == 4) {?>
                                                            <?php
                                                            if($vals->status_apply == 0 && $vals->active == 0) { ?>
                                                                <button <?php if ($vals->status_id == 0) {?> disabled <?php }?> onclick="admin_Active('<?php echo $vals->id; ?>')" class="btn btn-default" type="button">Kích hoạt</button>
                                                            <?php } else{?>
                                                                <img border="0" src="<?php echo base_url();?>templates/admin/images/active.png" alt="Đã kích hoạt" title="Đã kích hoạt"/> Đã kích hoạt
                                                                <p><?php echo date('H:i d-m-Y',$vals->update_by_admin) ?> </p>
                                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal_<?php echo $vals->id; ?>">
                                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Sửa
                                                                </button>
                                                            <?php } ?>
                                                        <?php }?>
                                                        <?php if ($this->session->userdata('sessionGroupAdmin') == 5) {
                                                            if($vals->status_apply == 0 && $vals->active == 0) { ?>
                                                                <span class="text-danger"><i class="fa fa-times"></i> Chưa kích hoạt</span>
                                                        <?php } else{?>
                                                           <span class="text-success"><b><i class="fa fa-check"></i> Đã kích hoạt</b></span>
                                                            <p><i><?php echo date('H:i d-m-Y', $vals->update_by_admin) ?></i></p>
                                                        <?php } ?>
                                                        <?php }?>
                                                    </td>
                                                    <td>
                                                        <?php if ($this->session->userdata('sessionGroupAdmin') == 4) {?>
                                                            <?php
                                                            if($vals->status_apply == 0 && $vals->active == 0) { ?>
                                                                <button <?php if ($vals->status_id == 0) {?> disabled <?php }?> onclick="admin_Delete('<?php echo $vals->id; ?>')" class="btn btn-danger" type="button">Xóa</button>
                                                            <?php }?>
                                                        <?php }?>
                                                    </td>
                                            </tr>
                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal_<?php echo $vals->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Bạn vui lòng xác nhận mật khẩu!</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                                <div class="form-group">
                                                                    <input type="password" class="form-control" id="pass_put_<?php echo $vals->id; ?>" name="pass_put_<?php echo $vals->id; ?>" placeholder="Nhập mật khẩu của bạn">
                                                                    <p class="text-danger error_pass"></p>
                                                                </div>
                                                                <button type="button"  data-loading-text="Đang xử lý..." onclick="Checkpass('<?php echo $vals->id; ?>')" class="btn btn-primary btn_login"><i class="fa fa-check"></i> Xác nhận</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php $idDiv++; ?>
                                    <?php } ?>
                                    <!---->
                                    <tr>
                                        <td class="show_page" colspan="8"><?php echo $linkPage; ?></td>
                                    </tr>
                                </table>
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

    <script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/autoNumeric.js"></script>
<script type="text/javascript">
    $('.amount_fake').autoNumeric('init',{aSign:'',mDec:0, pSign:'s' });
function updateStatus(wallet_id){
    var strconfirm = confirm("Bạn chắc chắn muốn xác nhận?");
    if (strconfirm == true)
    {
        $.ajax({
            url     : "<?php echo base_url(); ?>administ/recharge/updateStatus",
            type    : "POST",
            data    : {id : wallet_id},
            success:function(response)
            {
                if(response == 0){
                    alert("Lỗi! Chưa update vào database");
                } else {
                    window.location.href='<?php echo base_url(); ?>administ/recharge';
                }
            },
            error: function()
            {
                alert("Lỗi! Vui lòng thử lại");
            }
        });
    } else {
        return false;
    }
}
function updateAdmount(wallet_id){
    var strconfirm = confirm("Bạn đã chắc chắn?");
    var amount = $('#Amount_'+wallet_id).val();
    var  amount_ok = parseInt(amount.replace(/[,]+/g,""));
    if (amount_ok){
        if (strconfirm == true)
        {
            var $btn = $('#btn_save').button('loading');
            $.ajax({
                url     : '<?php echo base_url(); ?>administ/recharge/updateAmount',
                type    : "POST",
                data    : {id : wallet_id, amount: amount_ok},
                success:function(response)
                {
                    if(response == 0){
                        alert("Có lỗi xảy ra, vui lòng thử lại!");
                    } else {
                        $btn.button('reset');
                        $('#red_money_'+wallet_id).html(amount+' <i class="fa fa-check"></i>');
                       $('#form_amount_'+wallet_id).hide();
                    }
                },
                error: function()
                {
                    alert("Lỗi! Vui lòng thử lại");
                }
            });
        } else {
            return false;
        }
    } else {
        alert('Bạn chưa nhập số tiền!');
        amount.focus();
    }

}
function Checkpass(wallet_id){
    var pass_put = $('#pass_put_'+wallet_id).val();
    if (pass_put){
        var $btn = $('.btn_login').button('loading');
        $.ajax({
            url     : '<?php echo base_url(); ?>administ/recharge/Checkpass',
            type    : "POST",
            data    : {pass_put : pass_put},
            success:function(response)
            {
                if(response == 0){
                    $('.error_pass').html("Mật khẩu bạn nhập chưa đúng!..");
                    $btn.button('reset');
                } else {
                    $btn.button('reset');
                    $('#form_amount_'+wallet_id).show();
                    $('#myModal_'+wallet_id).modal('hide');
                }
            },
            error: function()
            {
                alert("Lỗi! Vui lòng thử lại");
            }
        });
    } else {
        $('.error_pass').html("Vui lòng nhập mật khẩu...");
        return false;
    }
}

function admin_Active(wallet_id){
    var strconfirm = confirm("Bạn chắc chắn muốn xác nhận?");
    if (strconfirm == true)
    {
        $.ajax({
            url     : '<?php echo base_url(); ?>administ/recharge/AdminActive',
            type    : "POST",
            data    : {id : wallet_id},
            success:function(response)
            {
                if(response == 0){
                    alert("Lỗi! Vui lòng thử lại");
                } else {
                    window.location.href='<?php echo base_url(); ?>administ/recharge';
                }
            },
            error: function()
            {
                alert("Lỗi! Vui lòng thử lại");
            }
        });
    } else {
        return false;
    }
}
function admin_Delete(walletlog_id){
    var strconfirm = confirm("Bạn chắc chắn muốn xóa?");
    if (strconfirm == true)
    {
        $.ajax({
            url     : '<?php echo base_url(); ?>administ/recharge/AdminDelete',
            type    : "POST",
            data    : {id : walletlog_id},
            success:function(response)
            {
                if(response == 0){
                    alert("Lỗi! Vui lòng thử lại");
                } else {
                    window.location.href='<?php echo base_url(); ?>administ/recharge';
                }
            },
            error: function()
            {
                alert("Lỗi! Vui lòng thử lại");
            }
        });
    } else {
        return false;
    }
}

function Act_Search(){
    var id = "";
    var id = document.getElementById('search').value;
    window.location.href = '<?php echo base_url(); ?>administ/recharge/keyword/'+id;
}
</script>

<?php $this->load->view('admin/common/footer'); ?>