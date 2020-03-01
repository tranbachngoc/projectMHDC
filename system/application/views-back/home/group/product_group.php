<?php $this->load->view('home/common/account/header'); ?>
<div class="clearfix"></div>
<div id="product_content" class="container-fluid">
    <div class="row rowmain">
        <?php $this->load->view('home/common/left');
        ?>
        <style type="text/css">
            .fa-spinner {
                font-size: 17px;
                display: none;
            }
        </style>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-xs-12">

			<h4 class="page-header text-uppercase" style="margin-top:10px">Danh sách sản phẩm</h4>
			
            <form name="frmGroupPro" id="frmGroupPro" method="post" action="/account/grouptrade/duyetsp">
                <div style="overflow: auto">
                    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <?php //if ($shopid > 0) { ?>
                            <?php if (count($product) > 0) { ?>

                                <thead>
                                <tr>

                                    <th width="1%" class="aligncenter hidden-xs hidden-sm">STT</th>
                                    <th width="10%" class="text-center">
                                        Hình ảnh
                                    </th>
                                    <th width="20%" class="aligncenter">
                                        <?php echo "Tên sản phẩm"; //$this->lang->line('product_list'); ?>
                                        <!-- <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')"
                                             border="0" style="cursor:pointer;" alt=""/>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')"
                                             border="0" style="cursor:pointer;" alt=""/> -->
                                    </th>
                                    <th width="5%" class="aligncenter hidden-xs hidden-sm">
                                        Gian hàng
                                    </th>
                                    <th width="15%" class="hidden-xs hidden-sm">
                                        <?php echo $this->lang->line('category_list'); ?>
                                        <!-- <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>category/by/asc<?php echo $pageSort; ?>')"
                                             border="0" style="cursor:pointer;" alt=""/>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>category/by/desc<?php echo $pageSort; ?>')"
                                             border="0" style="cursor:pointer;" alt=""/> -->
                                    </th>
                                    <th width="5%"><span>Lên group</span></th>

                                </tr>
                                </thead>
                                <?php $idDiv = 1; ?>
                                <?php
                                $demGroup = 0;
                                $tongPro = count($product);
                                foreach ($product as $k => $productArray) {
                                    if ($productArray->grt_id > 0) {
                                        $demGroup++;
                                    }

                                    if ($productArray->pro_type == 2) {
                                        $pro_type = 'coupon';
                                    } else {
                                        if ($productArray->pro_type == 0) {
                                            $pro_type = 'product';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td height="45" class="aligncenter hidden-xs hidden-sm"><?php echo $sTT; ?></td>
                                        <td class="img_prev aligncenter">
                                            <?php
                                            $filename = DOMAIN_CLOUDSERVER.'media/images/product/' . $productArray->pro_dir . '/' . show_thumbnail($productArray->pro_dir, $productArray->pro_image);
                                            $imglager = DOMAIN_CLOUDSERVER.'media/images/product/' . $productArray->pro_dir . '/' . show_thumbnail($productArray->pro_dir, $productArray->pro_image, 3);
                                            if ($filename != '') {
                                                ?>
                                                <a rel="tooltip" data-toggle="tooltip" data-html="true"
                                                   data-placement="auto right"
                                                   data-original-title="<img src='<?php echo $imglager; ?>' />">
                                                    <img width="80" src="<?php echo $filename; ?>"/>
                                                </a>
                                            <?php } else {
                                                ?>
                                                <img width="80"
                                                     src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                            <?php } ?>
                                        </td>
                                        <td>                                            
                                            <a target="_blank" class="menu_1"
                                               href="<?php echo $info[$k]['link_sp'] . '/shop/' . $pro_type; ?>/detail/<?php echo $productArray->pro_id; ?>/<?php echo RemoveSign($productArray->pro_name); ?>">
                                                <?php echo sub($productArray->pro_name, 100); ?>
                                            </a>

                                        </td>
                                        <td class="aligncenter hidden-xs hidden-sm">
                                            <a target="_blank" class="menu_1"
                                               href="<?php echo $info[$k]['link_sp']?>/shop">
                                                <?php
                                            echo  $info[$k]['username'];
                                            ?></a>
                                        </td>
                                        <td class="aligncenter hidden-xs hidden-sm">
                                            <?php echo $productArray->cat_name; ?>
                                        </td>
                                        <?php if(in_array($productArray->pro_id,$proNoGroup)){$demGroup++;}?>
                                        <td class="aligncenter">
                                            <input type="checkbox" name="duyetgroup[]" <?php if(!in_array($productArray->pro_id,$proNoGroup)){echo 'checked';} ?>
                                                   id="duyetgroup"
                                                   title="Duyệt sản phẩm lên group" value="<?php echo $productArray->pro_id ?>"
                                                   onchange="duyetspGroup(<?php echo $this->uri->segment(4).','.$productArray->pro_id ?>);"
                                            />
                                        </td>                                        
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php $sTT++; ?>
                                <?php } ?>

                            <?php } elseif (count($product) == 0 && trim($keyword) != '') { ?>
                                <tr>
                                    <td width="50" class="title_account_0">STT</td>
                                    <td width="30" class="title_account_1">
                                        <input type="checkbox" name="checkall" id="checkall" value="0"
                                               onclick="DoCheck(this.checked,'frmAccountPro',0)"/>
                                    </td>
                                    <td class="title_account_2">
                                        <?php echo $this->lang->line('product_list'); ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             border="0"/>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             border="0"/>
                                    </td>
                                    <td width="150" class="title_account_1">
                                        <?php echo $this->lang->line('category_list'); ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             border="0"/>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             border="0"/>
                                    </td>
                                    <td width="110" class="title_account_2">
                                        <?php echo $this->lang->line('date_post_list'); ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             border="0"/>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             border="0"/>
                                    </td>
                                    <td width="120" class="title_account_1">
                                        <?php echo $this->lang->line('enddate_list'); ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             border="0"/>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             border="0"/>
                                    </td>
                                    <td width="60"
                                        class="title_account_2"><?php echo $this->lang->line('status_list'); ?></td>
                                    <td width="50"
                                        class="title_account_3"><?php echo $this->lang->line('edit_list'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="none_record_search"
                                        align="center"><?php echo $this->lang->line('none_record_search_product_defaults'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="10" id="delete_account">
                                        <img class="hidden-xs"
                                             src="<?php echo base_url(); ?>templates/home/images/icon_deletepro_account.gif"
                                             onclick="" style="cursor:pointer;" border="0"/>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <?php
                                        $url = $this->uri->segment(3);
                                        if ($url == 'service') {
                                            echo 'Không có dịch vụ!';
                                        } elseif ($url == 'coupon') {
                                            echo 'Không có coupon!';
                                        } else {
                                            echo 'Không có sản phẩm!';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                    </table>
                </div>
                <?php if (isset($linkPage)) { ?>
                    <?php echo $linkPage; ?>
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

    function duyetspGroup(grt_id,proID) {
        $.ajax({
            type: "get",
            //url: "home/grouptrade/duyetsp/" + proID,
            data: {pro_id: proID},
            success: function (response) {
                window.location.href = "/account/grouptrade/duyetsp?grt_id="+grt_id+"&pro_id=" + proID;
            }
        });
    }
    $("#checkall_pro").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
        document.frmGroupPro.submit();
    });
    function submit_duyetPro() {
        if($("#checkall_pro").attr('checked') == 'checked'){
        }
    }
</script>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
