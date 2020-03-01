<?php $this->load->view('home/common/account/header'); ?>
<style>
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
	table.table-azibai td:nth-of-type(1):before { content: "STT"; }
	table.table-azibai td:nth-of-type(2):before { content: "Hình ảnh"; }
	table.table-azibai td:nth-of-type(3):before { content: "Tên sản phẩm"; }
	table.table-azibai td:nth-of-type(4):before { content: "Số lượng"; }
	table.table-azibai td:nth-of-type(5):before { content: "Đơn giá"; }
	table.table-azibai td:nth-of-type(6):before { content: "Danh mục"; }
	table.table-azibai td:nth-of-type(7):before { content: "Chi nhánh"; }
	table.table-azibai td:nth-of-type(8):before { content: "Affiliate"; }
	table.table-azibai td:nth-of-type(9):before { content: "Kích hoạt"; }
    }
</style>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>

        <!--BEGIN: RIGHT-->
        <div id="af_products" class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header" style="margin-top:10px">SẢN PHẨM CHỜ XÉT DUYỆT</h4>

            <form name="" id="" action="" method="post">
            <?php if (count($productBranch) > 0) { ?>
	    <div style="width: 100%; margin-bottom: 15px; overflow-y: hidden;">
                <table class="table table-bordered table-azibai">
                    <thead>
			<tr>
			    <th width="40">STT</th>
			    <th width="100">Hình ảnh</th>
			    <th>Tên sản phẩm</th>
			    <th width="50">SL</th>
			    <th width="150">Giá</th>
			    <th width="150">Danh mục</th>
			    <th width="150">Chi nhánh</th>
			    <th width="70">Affiliate</th>
			    <th width="70">Kích hoạt</th>
			</tr>
                    </thead>
                    <tbody>
                    <?php foreach ($productBranch as $items) :
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $sTT++; ?></td>
                            <td class="img_prev aligncenter">
                                <?php
                                $filename = 'media/images/product/' . $items->pro_dir . '/thumbnail_1_' . explode(',',$items->pro_image)[0];
                                $imglager = 'media/images/product/' . $items->pro_dir . '/thumbnail_3_' . explode(',',$items->pro_image)[0];//show_thumbnail($items->pro_dir, $items->pro_image, 3);

                                if (explode(',',$items->pro_image)[0] != '') { //file_exists($filename) && 
                                    ?>
                                    <a rel="tooltip" data-toggle="tooltip" data-html="true" data-placement="auto right"
                                       data-original-title="<img src='<?php echo DOMAIN_CLOUDSERVER . $imglager; ?>' />">
                                        <img width="80" src="<?php echo DOMAIN_CLOUDSERVER . $filename; ?>"/>
                                    </a>
                                <?php } else { ?>
                                    <img width="80" src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                <?php } ?>
                            </td>
                            <td>
                                <strong>
                                    <!--                                            <a target="_blank" class="menu_1" href="-->
                                    <?php //echo base_url();
                                    ?><!----><?php //echo $items->pro_category;
                                    ?><!--/--><?php //echo $items->pro_id;
                                    ?><!--/--><?php //echo RemoveSign($items->pro_name);
                                    ?><!--" >-->
                                    <?php echo sub($items->pro_name, 100); ?>
                                    <!--                                        </a>-->
                                </strong>
                                <p>
                                    <small><em>Ngày đăng: <?php echo $items->created_date; ?></em></small>
                                </p>
                                <p>


                            </td>
                            <td class="text-center">
                                <?php echo number_format($items->pro_instock); ?>
                            </td>
                            <td class="text-right">
                                <span class="product_price"><?php echo number_format($items->pro_cost, 0, ",", "."); ?>
                                    đ</span>
                            </td>
                            <td><?php echo $items->cat_name; ?></td>
                            <td>
                                <?php echo $items->use_username; ?>
                            </td>
                            <td style="text-align:center;">
                                <?php if ((int)$items->is_product_affiliate == 1) { ?>
                                    <img src="<?php echo base_url(); ?>templates/home/images/public.png"
                                         style="cursor:pointer;" border="0" title="Là sản phẩm Affiliate"
                                         alt="<?php echo $this->lang->line('deactive_tip'); ?>"/>
                                <?php } else { ?>
                                    <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png"
                                         style="cursor:pointer;" border="0" title="Không phải sản phẩm Affiliate"
                                         alt="<?php echo $this->lang->line('active_tip'); ?>"/>
                                <?php } ?>
                            </td>

                            <td style="text-align:center;">
                                <?php if ((int)$items->pro_status == 1) { ?>
                                    <img src="<?php echo base_url(); ?>templates/home/images/public.png"
                                         onclick="ActionLink('<?php echo base_url(); ?>branch/prowaitingapprove/status/deactive/id/<?php echo $items->pro_id; ?>')"
                                         style="cursor:pointer;" border="0"
                                         title="<?php echo $this->lang->line('deactive_tip'); ?>"
                                         alt="<?php echo $this->lang->line('deactive_tip'); ?>"/>
                                <?php } else { ?>
                                    <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png"
                                         onclick="ActionLink('<?php echo base_url(); ?>branch/prowaitingapprove/status/active/id/<?php echo $items->pro_id; ?>')"
                                         style="cursor:pointer;" border="0"
                                         title="<?php echo $this->lang->line('active_tip'); ?>"
                                         alt="<?php echo $this->lang->line('active_tip'); ?>"/>
                                <?php } ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>                    
                    </tbody>
                </table>
            </div>    
                
                <?php if (isset($linkPage)) { ?>
                    <?php echo $linkPage; ?>
                <?php } ?>
                
            <?php } else { ?>
                <div class="none_record"><p class="text-center">Không có dữ liệu</p></div>
            <?php } ?>        
            </form>
        </div>
    </div>
<!--END: RIGHT-->
</div>

<?php $this->load->view('home/common/footer'); ?>
