<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->	
        <div id="af_products" class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header" style="margin-top:10px">TIN TỨC CHỜ XÉT DUYỆT</h4>        
            <?php if (count($listcontent) > 0) { ?>

                <form name="frmAccountPro" id="frmAccountPro" action="" method="post">
                        <div class="visible-xs">                       
                           <?php foreach ($listcontent as $key=>$items) : ?>
                                <hr/>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <?php
                                        $filename = DOMAIN_CLOUDSERVER . 'media/images/content/' . $items->not_dir_image . '/thumbnail_1_' . $items->not_image;
                                        if ($items->not_image != '') { // file_exists($filename) && $filename != ''?>
                                            <img class="img-responsive" src="<?php echo $filename; ?>" />                                       
                                        <?php } else { ?>
                                            <img class="img-responsive" src="<?php echo base_url(); ?>media/images/no_photo_icon.png" />
                                        <?php } ?>
                                    </div>
                                    <div class="col-xs-7" style="padding: 0">
                                        <strong><?php echo $items->not_title; ?></strong><br>    
                                        <small>Ngày tạo: <?php echo date('Y-m-d H:m:s', $items->not_begindate); ?></small><br>
                                        <small>Bởi chi nhánh: <?php echo $items->use_username; ?></small><br>
                                    </div>
                                    <div class="col-xs-2">
                                        <?php if ($items->not_status > 0) { ?>
                                            <a class="btn btn-default btn-sm btn-block" href="<?php echo base_url(); ?>branch/newswaitapprove?active=0&id=<?php echo $items->not_id; ?>"><i class="fa fa-times"></i></a>
                                        <?php } else { ?>
                                            <a class="btn btn-danger btn-sm btn-block"  href="<?php echo base_url(); ?>branch/newswaitapprove?active=1&id=<?php echo $items->not_id; ?>"><i class="fa fa-times"></i></a>
                                        <?php } ?>
                                        <br/>
                                        <a class="btn btn-danger btn-sm btn-block" title="Xóa" onclick="return confirmDeleteContentBran('<?php echo base_url() . "branch/deletenews/" . $items->not_id; ?>');" ><i class="fa fa-trash-o"></i></a>
                                    </div>
                                </div>                            
                                <?php endforeach; ?>
                        </div>

                        <table class="table table-bordered hidden-xs">                    
                            <thead>
                                <tr>
                                    <th width="40" class="title_account_0 text-center">STT</th>
                                    <th class="title_account_2" align="center">Tiêu đề</th>
                                    <!-- <th width="30%" class="title_account_2" align="center">Danh sách nhận</th> -->
                                    <th width="100" class="title_account_2" align="center">Ngày tạo</th>
                                    <th width="200" class="title_account_2" align="center">Chi nhánh</th>
                                    <th width="100" class="title_account_2" align="center">Kích hoạt</th>
                                    <th width="100" class="title_account_2 text-center" align="center">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listcontent as $key => $items) { ?>
                                    <tr>
                                        <td height="32" class="line_account_0  text-center"><?php echo $sTT++; ?></td>
                                        <td class="title_account_2" align="left">

                                            <?php
                                        $filename = DOMAIN_CLOUDSERVER . 'media/images/content/' . $items->not_dir_image . '/thumbnail_1_' . $items->not_image;
                                        if ($items->not_image != '') { // file_exists($filename) && $filename != ''?>
                                            <img width="80" src="<?php echo $filename; ?>" />                                       
                                        <?php } else { ?>
                                            <img width="80" src="<?php echo base_url(); ?>media/images/no_photo_icon.png" />
                                        <?php } ?>
                                            <?php echo $items->not_title; ?></td>
                                       <!--  <td width="30%" class="title_account_2" align="center"><?php //echo $items->list_name;  ?></td> -->
                                        <td class="title_account_2" align="center"><?php echo date('Y-m-d H:m:s', $items->not_begindate); ?></td>
                                        <td class="title_account_2" align="center"><?php echo $items->use_username; ?></td>
                                        <td class="title_account_2" align="center">
                                            <?php if ($items->not_status > 0) { ?>
                                                <a class="btn btn-default" href="<?php echo base_url(); ?>branch/newswaitapprove?active=0&id=<?php echo $items->not_id; ?>"><i class="fa fa-times"></i></a>
                                            <?php } else { ?>
                                                <a class="btn btn-danger"  href="<?php echo base_url(); ?>branch/newswaitapprove?active=1&id=<?php echo $items->not_id; ?>"><i class="fa fa-times"></i></a>
                                            <?php } ?>
                                        </td>
                                        <td class="title_account_2" align="center">
                                            <a title="Xóa" onclick="return confirmDeleteContentBran('<?php echo base_url() . "branch/deletenews/" . $items->not_id; ?>');"  class="btn btn-danger"><i class="fa fa-trash-o"></i></a>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>


                        </table>  
                    </form>            

                <?php echo $linkPage; ?>

            <?php } else { ?>
            <div class="none_record"><p class="text-center">Không có dữ liệu</p></div>
            <?php } ?>
            <br/>
        </div>
    </div>
<!--END: RIGHT-->       
</div>

<?php $this->load->view('home/common/footer'); ?>
