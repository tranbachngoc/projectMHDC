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
                                                href="<?php echo base_url(); ?>administ/showcart/allorder"> <img
                                                    src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png"
                                                    border="0"/> </a></td>
                                        <td width="40%" height="67" class="item_menu_middle">Sản phẩm AF của <?php echo $user['use_username']; ?></td>
                                        <td width="55%" height="67" class="item_menu_right"></td>
                                    </tr>
                                </table>

                                <!--END Item Menu--></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
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
                                            <td class="title_list">Tên sản phẩm
                                                <a href="<?php echo $sort['name']['asc']; ?>">
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif"
                                                        border="0"/>
                                                </a>
                                                <a href="<?php echo $sort['name']['desc']; ?>">
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif"
                                                        border="0"/>
                                                </a>
                                            </td>
                                            <td class="title_list">Giá
                                                <a href="<?php echo $sort['price']['asc']; ?>">
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif"
                                                        border="0"/>
                                                </a>
                                                <a href="<?php echo $sort['price']['desc']; ?>">
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif"
                                                        border="0"/>
                                                </a>
                                            </td>
                                            <td class="title_list">Hoa hồng
                                                <a href="<?php echo $sort['amt']['asc']; ?>">
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif"
                                                        border="0"/>
                                                </a>
                                                <a href="<?php echo $sort['amt']['desc']; ?>">
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif"
                                                        border="0"/>
                                                </a>
                                            </td>

                                            <td class="title_list">Danh mục</td>
                                            <td class="title_list">Link Sản phẩm Affiliate</td>
                                            <td class="title_list">Chọn bán</td>
                                        </tr>

                                        <?php foreach ($products as $k=>$product) { ?>
                                            <tr id="DivRow_<?php echo $k; ?>"
                                                style="background:#<?php if ($k % 2 == 0) {
                                                    echo 'F7F7F7';
                                                } else {
                                                    echo 'FFF';
                                                } ?>;" id="DivRow_<?php echo $k; ?>"
                                                onmouseover="ChangeStyleRow('DivRow_<?php echo $k; ?>',<?php echo $k; ?>,1)"
                                                onmouseout="ChangeStyleRow('DivRow_<?php echo $k; ?>',<?php echo $k; ?>,2)">
                                                <td class="detail_list"> <?php echo $num + $k + 1; ?></td>
                                                <td class="detail_list">
                                                    <a href="<?php echo base_url(); ?><?php echo $product['pro_category']; ?>/<?php echo $product['pro_id']; ?>/<?php echo RemoveSign($product['pro_name']); ?>">
                                                    <?php echo $product['pro_name']; ?>
                                                    </a>
                                                </td>
                                                <td class="detail_list">

                                                    <span style="color:#F00; font-weight:bold;"
                                                        class="product_price"><?php echo number_format($product['pro_cost'], 0, ",", ".") . ' VNĐ';?></span>
                                                    </td>
                                                <td class="detail_list"><span style="color:#F00; font-weight:bold;"
                                                                              class="product_price"><?php echo number_format($product['amt'], 0, ",", ".") . ' VNĐ';?>
                                                                    <?php if($product['af_rate'] > 0 ){echo '('.$product['af_rate'].'%)';} ?>
                                                    </span></td>

                                                <td class="detail_list">
                                                    <a target="_blank"
                                                       href="<?php echo base_url(); ?><?php echo $product['pro_category']; ?>/<?php echo RemoveSign($product['cName']); ?>"><?php echo $product['cName'];?></a>
                                                    </td>
                                                <td class="detail_list"><a style="text-decoration: underline"
                                                        href="<?php echo $product['link']; ?>">Link sản phẩm</a></td>
                                                <td class="detail_list">
                                                    <?php if($product['isselect'] == true):?>
                                                        <a class="chooseItem selected" href="javascript:void(0);"
                                                           title="<?php echo $this->lang->line('deactive_tip'); ?>"><img
                                                                src="<?php echo base_url(); ?>templates/home/images/public.png"
                                                                style="cursor:pointer;" border="0"
                                                                alt="<?php echo $this->lang->line('active_tip'); ?>"/></a>
                                                    <?php else:?>.
                                                        <a class="chooseItem" href="javascript:void(0);"
                                                           title="<?php echo $this->lang->line('active_tip'); ?>"><img
                                                                src="<?php echo base_url(); ?>templates/home/images/unpublic.png"
                                                                style="cursor:pointer;" border="0"
                                                                alt="<?php echo $this->lang->line('active_tip'); ?>"/></a>
                                                    <?php endif;?>
                                                </td>
                                            </tr>

                                        <?php } ?>
                                        <!---->
                                        <tr>
                                            <td class="show_page" colspan="8"><?php echo $pager; ?></td>
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
        <script type="text/javascript">

            jQuery( document ).ready(function() {
                var afBox = jQuery('.afBox');

                afBox.find('span.item').click(function(){
                    var item = jQuery(this);
                    if(item.hasClass('processing')){
                        return;
                    }
                    var id = item.parents('tr').attr('id');
                    id = id.replace('af_row_', '');
                    var status = item.hasClass('btn-danger') ? 0 : 1;
                    item.addClass('processing');
                    var uid = jQuery('input[name="uid"]').val();
                    jQuery.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>administ/affiliate/ajaxAddProduct",
                        dataType: 'json',
                        data: {pro_id: id, status: status, uid: uid},
                        success: function (res) {
                            item.removeClass('processing');
                            if (res.error == false) {
                                if(status == 1){
                                    item.text('Hủy bán').removeClass('btn-primary').addClass('btn-danger');
                                }else{
                                    item.text('Chọn bán').removeClass('btn-danger').addClass('btn-primary');
                                }
                            }else{
                                alert(res.message);
                            }
                        }
                    });
                })
            });
        </script>
    </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>
