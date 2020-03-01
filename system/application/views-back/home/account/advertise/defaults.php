<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header" style="margin-top:10px">QUẢNG CÁO AZIBAI</h4>
            <div id="panel_user_order" class="panel panel-default">
                
                    <div class="content">
                        <div class="vas_">
                            <div class="tableprice">
                                <div class="table-responsive  tb-grid">
                                    <table class="table dataTable">
                                        <tbody>
                                        <tr>
                                            <th width="20%">Trang</th>
                                            <th class="text-center" width="70%">Vị trí</th>
                                            <th class="text-center" width="10%">MUA</th>
                                        </tr>
                                        <tr>
                                            <td class="titlebig"><span id="1">Trang chủ danh mục </span></td>
                                            <td>
                                                <img style="border: 1px solid #ddd" class="img-responsive" src="<?php echo base_url();?>images/qc/qctop.png" alt="" />
                                            </td>
        
                                            <td class="text-center">
                                                <a href="<?php echo base_url();?>account/advs/buy/1" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Mua ngay</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="titlebig"><span id="2">Trang chủ Affiliate</span></td>
                                            <td>
                                                <img style="border: 1px solid #ddd" class="img-responsive" src="<?php echo base_url();?>images/qc/af-shop.jpg" alt="" />
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url();?>account/advs/buy/2" class="btn btn-primary" ><i class="fa fa-shopping-cart"></i> Mua ngay</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>