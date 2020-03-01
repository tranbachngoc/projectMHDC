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
                                        <td width="5%" height="67" class="item_menu_left text-center">
                                            <a href="<?php echo $filterUrl; ?>">
                                                <img style="width: 30px" src="<?php echo base_url(); ?>templates/home/icons/black/icon-report.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">Chi tiết báo cáo</td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <div class="icon_item" id="icon_item_1" onclick="ActDel('frmreport')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_delete.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('delete_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <!--END Item Menu-->
                            </td>
                        </tr>
                        <tr>
                            <td height="50"><?php echo $title; ?></td>
                        </tr>
                        <tr>
                            <td align="center">
                                <!--BEGIN: Search-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="160" align="left">
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo $srUrl; ?>/search/title/keyword/','keyword')"  />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo $srUrl; ?>',1)" class="select_search">
                                                <!--<option value="0"><?php //echo $this->lang->line('search_by_search'); ?></option>-->
                                                <option value="title" <?php if($filtersearch == 'title'){ echo 'selected'; } ?>><?php echo $this->lang->line('title_search_defaults'); ?></option>
                                                <option value="username" <?php if($filtersearch == 'username'){ echo 'selected'; } ?>>Người báo cáo</option>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo $srUrl; ?>',1)" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        <!---->
                                        <td width="115" align="left">
                                            <select name="filter" id="filter" onchange="return window.location.href='<?php echo $filterUrl; ?>/filter/rpd_status/key/'+this.value;" class="select_search">
                                                <option value="3">---Chọn tình trạng---</option>
                                                <option value="0" <?php if($filterStatus == 0){ echo 'selected'; } ?>>Mới</option>
                                                <option value="1" <?php if($filterStatus && $filterStatus == 1){ echo 'selected'; } ?>>Đang xử lý</option>
                                                <option value="2" <?php if($filterStatus && $filterStatus == 2){ echo 'selected'; } ?>>Đã xử lý</option>
                                            </select>
                                        </td>
                                        
                                        <td id="DivDateSearch_1" width="10" align="center"><b>:</b></td>
                                        <td id="DivDateSearch_2" width="60" align="left">
                                            <select name="day" id="day" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('day_search'); ?></option>
                                                <?php $this->load->view('admin/common/day'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_3" width="10" align="center"><b>-</b></td>
                                        <td id="DivDateSearch_4" width="60" align="left">
                                            <select name="month" id="month" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                <?php $this->load->view('admin/common/month'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_5" width="10" align="center"><b>-</b></td>
                                        <td id="DivDateSearch_6" width="60" align="left">
                                            <select name="year" id="year" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                <?php $this->load->view('admin/common/year'); ?>
                                            </select>
                                        </td>
                                        <script>OpenTabSearch('0',0);</script>
                                        <td width="25" align="right">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo $srUrl; ?>,rpd_status,2)" />
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
                            <form name="frmreport" id="frmreport" action="" method="POST">
                                <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="" class="title_list">STT</td>
                                        <td width="" class="title_list">
                                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmreport',0)" /><!--DoCheck(this.checked,'frmreport',0)-->
                                        </td>
                                        <td class="title_list">
                                            Nội dung báo cáo
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="" class="title_list">
                                            Người báo cáo
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>username/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>username/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="" class="title_list">
                                            Email
                                        </td>
                                        <td class="title_list">
                                            Tình trạng
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>rpd_status/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>rpd_status/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="title_list">
                                            Xử lý
                                        </td>
                                    </tr>
                                        <input name="title" type="hidden" value="<?php echo $title; ?>">
                                    <?php $idDiv = 1; ?>
                                    <?php foreach($reports as $listreport){ ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $listreport->rpd_id; ?>" onclick="DoCheckOne('frmreport')"/><!--onclick="Checkrpd(this.value)" -->
                                        </td>
                                        <td class="detail_list">
                                            <?php 
                                            echo $listreport->rp_desc; 
                                            if($listreport->rp_id == 11 || $listreport->rp_id == 6){
                                                echo ': <b>' . $listreport->rpd_reason . '</b>'; 
                                            } ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php echo $listreport->use_username; ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php echo $listreport->use_email;?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php 
                                            switch($listreport->rpd_status){
                                                case 0: echo 'Mới'; break;
                                                case 1: echo 'Đang xử lý'; break;
                                                case 2: echo 'Đã xử lý'; break;
                                            } 
                                            ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php 
                                            if($this->uri->segment(3) == 'content'){
                                                $rpd_pronews = $listreport->not_id;
                                            }else{
                                                $rpd_pronews = $listreport->pro_id;
                                            }
                                            ?>
                                            <div id="frmreport_<?php echo $listreport->use_id;?>">
                                                <input name="rpd_id" type="hidden" value="<?php echo $listreport->rpd_id; ?>">
                                                <input name="rpd_type" type="hidden" value="<?php echo $listreport->rpd_type; ?>">
                                                <input name="rpd_pronews" type="hidden" value="<?php echo $rpd_pronews; ?>">
                                                <input name="rpd_by_user" type="hidden" value="<?php echo $listreport->use_id;?>">
                                                <input id="rpdstatus_<?php echo $listreport->use_id;?>" type="hidden" value="<?php echo $listreport->rpd_status; ?>">
                                            </div>
                                            <!--<select name="rpd_status" id="<?php echo $listreport->use_id;?>" onchange="change_rpdst(<?php echo $listreport->use_id;?>,this.value)">
                                                <option value="0" <?php if($listreport->rpd_status == 0){ echo 'selected'; } ?>>Mới</option>
                                                <option value="1" <?php if($listreport->rpd_status == 1){ echo 'selected'; } ?>>Đang xử lý</option>
                                                <option value="2" <?php if($listreport->rpd_status == 2){ echo 'selected'; } ?>>Đã xử lý</option>
                                            </select>-->
                                            <a href="#" style="border:none;" class="report" data-id="" data-toggle="modal" data-target="#sendmail" onclick="adddata(<?php echo $listreport->use_id;?>)">Xử lý</a>
                                        </td>
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php } ?>
                                    <tr>
                                        <td class="show_page" colspan="10"><?php echo $linkPage; ?></td>
                                    </tr>
                                        
                                </table>
                            </form>
                                <!--END Content-->
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

<script>
    
    function ActDel(formName){
        /*var r = confirm("Bạn chắc chắn muốn xóa!");
	if (r == true) {
            $('#'+formName).submit();
	}*/
        console.log($('#'+formName).serialize());
        alert('Bạn không thể thực hiện chức năng này');
    }
    
    function adddata(id){
        $('.rpd_status').attr('id',id);
        $('.rpd_status option').removeAttr('selected');
        $('.rpd_status option').each(function(){
            if($('#rpdstatus_'+id).val() == $(this).val()){
                $(this).attr('selected','selected');
            }
        });
        $('.form').html($('#frmreport_'+id).html());
        $('.boxmail').fadeOut();
    }
    
    function change_rpdst(id,status){
        if($('#rpdstatus_'+id).val() == 0 && status == 1){
            $('.boxmail').fadeIn();
        }else{
            $('.boxmail').fadeOut();
        }
        $('#body_email').val('');
    }
    
    function updateStatus(baseUrl){
        var frmreport = '#updateStatus';
        var contenttxtEditor = $('#body_email_ifr').contents().find("body").text();
        var contentEditor = $('#body_email_ifr').contents().find("body").html();
        $('#body_email').val(contentEditor);
        
        if($('.boxmail').css('display') != 'none' && contenttxtEditor == ''){
            alert('Bạn phải nhập nội dung mail');
        }else{
            $.ajax({
                type: 'POST',
                url: baseUrl + 'administ/reports/updatestatus',
                data: $(frmreport).serialize(),
                success: function (data) {
                    location.reload();
                },
                error: function (data) {
                    alert('Error');
                }
            });
        }
   }
</script>
<?php $this->load->view('admin/common/footer'); ?>


<script type="text/javascript" src='<?php echo base_url(); ?>templates/editor/tinymce/tinymce.min.js'></script>
<script type="text/javascript"> 
    tinymce.init({
	selector: '.editor',  
	height: 200,
	theme: 'modern',
	skins: 'lightgray',
	plugins: 'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor responsivefilemanager',
	toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link image media | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat code',
	image_advtab: true,
	menubar: 'edit insert view format table tools help'
    });
</script>
                
<div class="modal" id="sendmail" tabindex="" role="dialog" aria-labelledby="">
  <div class="modal-dialog" role="document">
    <form method="POST" id="updateStatus">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"</span></button>
                <h4 class="modal-title" id="reportModalLabel">Cập nhật tình trạng báo cáo</h4>
            </div>
            <div class="modal-body">
                <label>Tình trạng báo cáo: </label>
                <select name="rpd_status" id="" class="rpd_status" style="padding: 5px; margin-bottom: 10px;" onchange="change_rpdst(this.id, this.value)">
                    <option value="0">Mới</option>
                    <option value="1">Đang xử lý</option>
                    <option value="2">Đã xử lý</option>
                </select>
                <br/>
                <div class="boxmail" style="display: none;">
                    <label>Nội dung mail gửi tới shop: </label>
                    <textarea name="body_email" id="body_email" class="editor" style="width: 100%; height: 100px; padding: 5px; resize: none;" placeholder="Nhập nội dung email tới gian hàng"></textarea>
                </div>
                <div class="form"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btnupdate" onclick="updateStatus('<?php echo base_url(); ?>')">Lưu</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>			
            </div>		
        </div>
    </form>
  </div>
</div>