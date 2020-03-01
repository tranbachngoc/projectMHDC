<?php $this->load->view('group/product/common/header'); ?>

<div id="main" class="container">
    <ol class="breadcrumb">
        <li><a href="/">Trang chủ</a></li>            
        <li><a href="/grtshop">Cửa hàng</a></li>
        <li class="active">Giới thiệu</li>
    </ol>
    <div class="row">
        <div class="col-xs-12">
            <div class="group-products">
                <div class="row infogroup">
                    <div class="col-xs-12 col-sm-12 col-md-6">                    
                        <?php $this->load->view('group/product/common/block-about'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">                        
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $get_grt->grt_video ?>?rel=0&amp;controls=1&amp;showinfo=1"></iframe>
                        </div>                
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <?php if($get_grt->grt_introduction) { ?>
                            <div class="well">
                                <?php echo $get_grt->grt_introduction; ?>
                            </div>
                        <?php } else { ?>
                        <a href="../product/common/menu-left.php"></a>
                            <div class="alert alert-warning" role="alert">Chưa cập nhập thông tin giới thiệu nhóm.</div>
                        <?php } ?>
                    </div>
                </div>
                
            </div>
        </div>   
    </div>
</div>

<?php $this->load->view('group/common/footer-group'); ?>