<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>

        <!--BEGIN: RIGHT-->
        <div id="af_products" class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header" style="margin-top:10px">TỜ RƠI CHỜ XÉT DUYỆT</h4>        
           
                <form name="frmAccountPro" id="frmAccountPro" action="" method="post">
                    
                    <div class="visible-xs">
                        <?php foreach ($listpage as $k => $items) { ?>
                        <div style="border:1px solid #ddd; border-bottom: 0px; display: inline-block; text-align: center; width: 50px; padding: 5px; background: #f9f9f9"><?php echo $k+1; ?></div>                 
                        <table class="table table-bordered" style="border-bottom: 2px solid #999; font-size: 12px;">                            
                                <tr><th>Tiêu đề</th><td><?php echo $items->name; ?></td></tr>
                                <tr><th>DS nhận</th><td><?php echo $items->list_name; ?></td></tr>
                                <tr><th>Ngày tạo</th><td><?php echo $items->created_date; ?></td></tr>
                                <tr><th>Chi nhánh</th><td><?php echo $items->use_username; ?></td></tr>
                                <tr><td colspan="2" class="text-center">
                                    <?php if ($items->status > 0) { ?>
                                            <a class="btn btn-default btn-xs" title="Kích hoạt" href="<?php echo base_url(); ?>branch/flyerwaitapprove?active=0&id=<?php echo $items->id; ?>"><i class="fa fa-check fa-fw"></i></a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-xs" title="Kích hoạt"  href="<?php echo base_url(); ?>branch/flyerwaitapprove?active=1&id=<?php echo $items->id; ?>"><i class="fa fa-times fa-fw"></i> Kích hoạt</a>
                                        <?php } ?>
                                    
                                       <!--  <a title="Chỉnh sửa" href="<?php echo base_url(); ?>branch/deletepage/<?php echo $items->id; ?>" style="color: black !important"><i class="fa fa-pencil-square-o  fa-fw"></i></a> &nbsp; -->

                                        <a title="Xem chi tiết" href="<?php echo base_url() . "landing_page/id/" . $items->id . "/" . RemoveSign($items->name); ?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-eye fa-fw"></i> Xem </a>

                                        <a title="Xóa" onclick="return confirmDeleteLandingPage('<?php echo base_url() . "branch/deleteflyer/" . $items->id; ?>');"  class="btn btn-default btn-xs"><i class="fa fa-trash-o fa-fw"></i> Xóa </a>
                                    
                                    </td>
                                </tr>
                            
                        </table>
                        <?php } ?>
                    </div>
                    
                    <div class="hidden-xs">
                    <table class="table table-bordered">                    
                        <thead>
                            <tr>
                                <th width="40" class="title_account_0 text-center">STT</th>
                                <th width="" class="title_account_2" align="center">Tiêu đề</th>
                                <th width="150" class="title_account_2" align="center">DS nhận</th>
                                <th width="" class="title_account_2" align="center">Ngày tạo</th>
                                <th width="150" class="title_account_2" align="center">Chi nhánh</th>
                                <th width="160" class="title_account_2" align="center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //foreach ($listpage as $key => $items) { ?>
                                <tr>
                                    <td width="" height="32" class="line_account_0  text-center"><?php echo $sTT++; ?></td>
                                    <td width="" class="title_account_2" align="left"><?php echo $items->name; ?></td>
                                    <td width="" class="title_account_2" align="center"><?php echo $items->list_name; ?></td>
                                    <td width="" class="title_account_2" align="center"><?php echo $items->created_date; ?></td>
                                    <td width="" class="title_account_2" align="center"><?php echo $items->use_username; ?></td>
                                    <td width="" class="title_account_2" align="center">
                                        <?php if ($items->status > 0) { ?>
                                            <a class="btn btn-default" title="Kích hoạt" href="<?php echo base_url(); ?>branch/flyerwaitapprove?active=0&id=<?php echo $items->id; ?>"><i class="fa fa-check fa-fw"></i></a>
                                        <?php } else { ?>
                                            <a class="btn btn-default" title="Kích hoạt"  href="<?php echo base_url(); ?>branch/flyerwaitapprove?active=1&id=<?php echo $items->id; ?>"><i class="fa fa-times fa-fw"></i></a>
                                        <?php } ?>
                                    
                                       <!--  <a title="Chỉnh sửa" href="<?php echo base_url(); ?>branch/deletepage/<?php echo $items->id; ?>" style="color: black !important"><i class="fa fa-pencil-square-o  fa-fw"></i></a> &nbsp; -->

                                        <a title="Xem chi tiết" href="<?php echo base_url() . "landing_page/id/" . $items->id . "/" . RemoveSign($items->name); ?>" target="_blank" class="btn btn-default"><i class="fa fa-eye fa-fw"></i></a>

                                        <a title="Xóa" onclick="return confirmDeleteLandingPage('<?php echo base_url() . "branch/deleteflyer/" . $items->id; ?>');"  class="btn btn-default"><i class="fa fa-trash-o fa-fw"></i></a>
                                    </td>
                                </tr>
                            <?php //} ?>
                        </tbody>
                        <?php if (count($listpage) <= 0) { ?>
                            <tr>
                                <td colspan="7" class="text-center"> <div class="nojob">
                                        Không có dữ liệu!
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>

                    </table>  
                </div>
                </form>
            
        </div>
        <?php echo $linkPage; ?>
    </div>
</div>
<!--END: RIGHT-->       
</div>
</div>
<?php $this->load->view('home/common/footer'); ?>
