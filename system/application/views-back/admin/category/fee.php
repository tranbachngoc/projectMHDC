<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<tr>
    <td valign="top">
        <script type="text/javascript">
            function saveFee(cat){
                var data = $('tr#cat_'+cat).find('input');
                var valid = true;
                $.each(data, function(){
                    if(! isValueCommissionSolution($(this).val())){
                        valid = false;
                        return;
                    }
                });

                if(valid){
                    var  b2c_fee = $('#b2c_fee_'+cat).val();
                    var  b2c_af_fee = $('#b2c_af_fee_'+cat).val();
                    var  b2b_fee = $('#b2b_fee_'+cat).val();
                    var  b2b_em_fee = $('#b2b_em_fee_'+cat).val();

                    jQuery.ajax({

                        type: "POST",
                        url: "<?php echo base_url();?>administ/category/updateFee",
                        dataType: 'json',
                        data: {cat_id: cat, b2c_fee: b2c_fee, b2c_af_fee: b2c_af_fee, b2b_fee: b2b_fee, b2b_em_fee: b2b_em_fee },
                        success: function (res) {
                            alert("Cập nhật thành công");
                        }
                    });
//                    jQuery.ajax({
//                        type: "POST",
//                        url: "<?php //echo base_url();?>//administ/category/updateFee",
//                        dataType: 'json',
//                        data: $('tr#cat_'+cat+' :input').serialize(),
//                        success: function (res) {
//                            alert("Cập nhật thành công");
//                        }
//                    });
                }else{
                    alert('Dữ liệu không hợp lệ');
                }

            }
        </script>
        <form name="frmCategory" method="post">
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
                                            <a href="<?php echo base_url(); ?>administ/category">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/home-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_defaults'); ?></td>
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
                            <td height="5"></td>
                        </tr>

                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td colspan="4"><a href="<?php echo base_url().'administ/category/fee/product'; ?>" class="btn btn-warning">Sản phẩm</a>&ensp;<a href="<?php echo base_url().'administ/category/fee/service'; ?>" class="btn btn-primary"> Dịch vụ</a>&ensp;<a href="<?php echo base_url().'administ/category/fee/coupon'; ?>" class="btn btn-info"> Coupon</a></td>
                                        <td colspan="4" align="right"><p><button type="submit" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> SaveAll</button></p></td>
                                    </tr>
                                    <tr>
                                        <td width="1%" class="title_list">STT</td>
                                        <td width="5%" class="title_list">
                                            <?php echo $this->lang->line('id_list'); ?>
                                        </td>
                                        <td  width="20%" class="title_list">
                                            <?php echo $this->lang->line('category_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="10%" class="title_list">
                                            Loại danh mục
                                        </td>
                                        <td width="5%" class="title_list">
                                            <?php echo 'B2C %'; ?>
                                        </td>
                                        <td width="5%" class="title_list">
                                            <?php echo 'B2C AF %'; ?>
                                        </td>
                                        <td width="5%" class="title_list">
                                            <?php echo 'B2B %'; ?>
                                        </td>
                                        <td width="5%" class="title_list">
                                            <?php echo 'B2B Employee%'; ?>
                                        </td>
                                        <td width="5%" class="title_list">
                                            <?php echo $this->lang->line('status_list'); ?>
                                        </td>
                                    </tr>                                    
                                    <?php $idDiv = 1; ?>
                                    <?php foreach($category as $categoryArray){ ?>
                                    <tr style="background:<?php if($idDiv % 2 == 0){echo '#F7F7F7';}else{echo '#FFF';} ?>;" id="cat_<?php echo $categoryArray->cat_id;?>" onmouseover="ChangeStyleRow('cat_<?php echo $categoryArray->cat_id;?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('cat_<?php echo $categoryArray->cat_id;?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php echo $categoryArray->cat_id; ?>
                                            <input type="hidden" name="cat_id[]" value="<?php echo $categoryArray->cat_id; ?>" />
                                        </td>
                                        <td class="detail_list k_displaynone" style="text-align:center;">
                                            <img  src="<?php echo base_url(); ?>templates/home/images/category/<?php echo $categoryArray->cat_image; ?>" border="0" />
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo base_url(); ?>administ/category/edit/<?php echo $categoryArray->cat_id; ?>" alt="<?php echo $this->lang->line('edit_tip'); ?>">
                                            <?php $pre = 'cat_leve0q'; if($categoryArray->cat_level == 1){$pre = 'cat_leve1q';} if($categoryArray->cat_level == 2){$pre = 'cat_leve2q';}?>
                                            <span class="<?php echo $pre; ?>">
                                                <?php echo $categoryArray->cat_name; ?>
                                                </span>
                                            </a>
                                        </td>
                                        <td class="detail_list">
                                            <?php
                                                    switch ($categoryArray->cate_type){
                                                        case 0: echo 'Sản phẩm';
                                                            break;
                                                        case 1: echo 'Dịch vụ';
                                                            break;
                                                        case 2: echo 'Coupon';
                                                            break;

                                                    }
                                            ?>
                                        </td>
                                        <td class="detail_list">
                                            <?php if($categoryArray->cat_level == 1 || true):?>
                                            <input id="b2c_fee_<?php echo $categoryArray->cat_id; ?>" type="text" name="b2c_fee[]" value="<?php echo $categoryArray->b2c_fee;?>" />
                                            <?php endif;?>
                                        </td>
                                        <td class="detail_list">
                                            <?php if($categoryArray->cat_level == 1 || true):?>
                                                <input id="b2c_af_fee_<?php echo $categoryArray->cat_id; ?>" type="text" name="b2c_af_fee[]" value="<?php echo $categoryArray->b2c_af_fee;?>" />
                                            <?php endif;?>

                                        </td>
                                        <td class="detail_list">
                                            <?php if($categoryArray->cat_level == 1 || true):?>
                                                <input id="b2b_fee_<?php echo $categoryArray->cat_id; ?>" type="text" name="b2b_fee[]" value="<?php echo $categoryArray->b2b_fee;?>" />
                                            <?php endif;?>
                                        </td>
                                        <td class="detail_list">
                                            <?php if($categoryArray->cat_level == 1 || true):?>
                                                <input  id="b2b_em_fee_<?php echo $categoryArray->cat_id; ?>" type="text" name="b2b_em_fee[]" value="<?php echo $categoryArray->b2b_em_fee;?>" />
                                            <?php endif;?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/save.png" onclick="saveFee('<?php echo $categoryArray->cat_id; ?>')" style="cursor:pointer;" border="0" alt="Lưu" />
                                        </td>
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php } ?>
                                    <!---->
                                    <tr>
                                        <td class="show_page" colspan="8"><?php //echo $linkPage; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="right"><p><button type="submit" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> SaveAll</button></p></td>
                                    </tr>
                                </table>
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
        </form>
    </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>