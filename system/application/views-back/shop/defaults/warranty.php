<?php $this->load->view('shop/common/header'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>
<style type="text/css">
.grid-item > div{ border:1px solid #dedede; padding: 0 15px 15px; margin:15px 0; background: #fff;}
</style>
<?php //$this->load->view('shop/common/left'); ?>
<?php if(isset($siteGlobal)){ ?>
<!--script language="javascript" src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/jquery.js"></script>
<script language="javascript" src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/ajax.js"></script-->
<!--BEGIN: Center-->
<div id="main">
    <div id="warranty" class="container">
        <div class="row" style="margin-top:20px">
            <div class="col-lg-12">
                <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
                  <li><a href="/"><?php echo $this->lang->line('index_page_menu_detail_global'); ?></a></li>
                  <li class="active"><?php echo $this->lang->line('ads_menu_warranty_global'); ?></li>
                </ol>
            </div>
        </div>
        
        <div class="row">            
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 col-left pull-left">
                <?php $this->load->view('shop/common/left'); ?>
                <?php $this->load->view('shop/common/right'); ?>
            </div>

            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 pull-right">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-introduct" role="tablist">
                    <li role="presentation" class="active tab_db"><a href="#shoprule" aria-controls="shoprule" role="tab" data-toggle="tab">Chính sách gian hàng</a></li>
                    <li role="presentation" class="tab_db"><a href="#shopwarranty" aria-controls="shopwarranty" role="tab" data-toggle="tab">Chính sách bảo hành</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content tab-about">
                        <div role="tabpanel" class="tab-pane active" id="shoprule">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading_1">
                                        <?php
                                        if (isset($chinhsach_gianhang) && count($chinhsach_gianhang) > 0) {
                                            $chinhsachcoban_first = true;
                                            $chinhsachbaohanh_first = false;
                                            $chinhsachmuahang_first = true;
                                            $chinhsachthanhtoan_first = true;
                                            $chinhsachvanchuyen_first = true;
                                            $chinhsachkhac_first = true;

                                            foreach ($chinhsach_gianhang as $key => $item) {
                                                ?>
                                                <?php if ($item->type == 1 && $chinhsachcoban_first == true) { ?>
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_1" aria-expanded="true" aria-controls="collapse_1">
                                                            Thông tin cơ bản
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_1">
                                                    <div class="panel-body">
                                                        <?php $chinhsachcoban_first = false;
                                                    } else if ($item->type == 2 && $chinhsachbaohanh_first == true) { ?>
                                                        <?php echo '
                                </div>
                                </div>
                                </div>
                    <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_2">'; ?>
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_2" aria-expanded="true" aria-controls="collapse_2">
                                                                Chính sách bảo hành
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_2">
                                                        <div class="panel-body">
                                                            <?php $chinhsachbaohanh_first = false;
                                                        } else if ($item->type == 3 && $chinhsachmuahang_first == true) { ?>
                                                            <?php echo '</div>
                            </div></div>
                    <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_3">'; ?>
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_3" aria-expanded="true" aria-controls="collapse_3">
                                                                    Chính sách đặt hàng, mua hàng
                                                                </a>
                                                            </h4>
                                                        </div><!--End panel-body Chính sách đặt hàng, mua hàng-->
                                                        <div id="collapse_3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_3">
                                                            <div class="panel-body">
                                                                <?php $chinhsachmuahang_first = false;
                                                            } else if ($item->type == 4 && $chinhsachthanhtoan_first == true) { ?>
                                                                <?php echo '</div>
                            </div></div>
                    <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_4">'; ?>
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_4" aria-expanded="true" aria-controls="collapse_4">
                                                                        Phương thức thanh toán
                                                                    </a>
                                                                </h4></div>
                                                            <div id="collapse_4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_4">
                                                                <div class="panel-body">
                                                                    <?php $chinhsachthanhtoan_first = false;
                                                                } else if ($item->type == 5 && $chinhsachvanchuyen_first == true) { ?>
                                                                    <?php echo '</div>
                            </div></div>
                    <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_5">'; ?>
                                                                    <h4 class="panel-title">
                                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_5" aria-expanded="true" aria-controls="collapse_5">
                                                                            Chính sách vận chuyển
                                                                        </a>
                                                                    </h4></div>
                                                                <div id="collapse_5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_5">
                                                                    <div class="panel-body">

                                                                        <?php $chinhsachvanchuyen_first = false;
                                                                    } else if ($item->type == 6 && $chinhsachkhac_first == true) { ?>
                <?php echo '</div>
                            </div></div>
                    <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_6">'; ?>
                                                                        <h4 class="panel-title">
                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_6" aria-expanded="true" aria-controls="collapse_6">
                                                                                Chính sách về sản phẩm khác
                                                                            </a>
                                                                        </h4></div>
                                                                    <div id="collapse_6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_6">
                                                                        <div class="panel-body">
                <?php $chinhsachkhac_first = false;
            } ?>
                                                                        <?php if ($item->type != 2) { ?>
                                                                            <p class="chinhsach_list">
                                                                                <i class="fa fa-angle-right"></i> <?php echo $item->content; ?>
                                                                            </p>

            <?php
            }//end if
        } //end foreach
    } else {
        ?>
                                                                    Không có dữ liệu!
                                                <?php } ?>
                                                            </div></div>
                                                    </div>
                                                </div><!--End panel-group-->
                                            </div><!--End shoprule-->
                                            <div role="tabpanel" class="tab-pane" id="shopwarranty">
                                                <?php
                                                foreach ($chinhsach_gianhang as $wanty) {
                                                    if ($wanty->type == 2) {
                                                        ?>
                                                        <p class="chinhsach_list">
                                                            <i class="fa fa-check-circle"></i> <?php echo $wanty->content; ?>
                                                        </p>

        <?php }
    } ?>
                        <?php echo $chinhsach_baohanh; ?>
                                            </div><!--End shopwarranty-->
                                        </div>



                                    </div><!--col-lg-9 -->
                                </div><!--End row-->
                            </div><!--End container-->
                        </div><!--End Main-->
                <!--END Center-->
                <?php } ?>

<?php $this->load->view('shop/common/footer');


