<?php $this->load->view('group/product/common/header'); ?>
<div id="main" class="container">
    <?php if(isset($siteGlobal) && $keyword!=""){ ?>
    <?php
        $guser = '';
        if($_REQUEST['gr_saler'] && $_REQUEST['gr_saler'] != ''){
            $guser = $_REQUEST['gr_saler'];
        }
    ?>
    <ol class="breadcrumb">                  
        <li><a href="/grtshop">Cửa hàng</a></li>                                          
        <li class="active">Tìm kiếm: <b><?php echo $keyword ?></b> có <span style="color:#f00"><?php echo $totalRecord ?></span> kết quả</li>
    </ol>    
    <div class="row">
        <div class="col-xs-12 col-sm-12">	    
            <div class="group-products">
                <div class="row products">                    
                    <?php $this->load->view('group/product/tab_pro', array('products' => $listresult, 'guser' => $guser)); ?>
                </div>
                <div class="row text-center">
                     <div class="linkPage"><?php echo $linkPage; ?></div>              
                </div>
                
            </div>
        </div>	  
    </div>
    <?php } else { ?> 
    <div class="alert alert-success" role="alert">Bạn chưa nhập từ khóa tìm kiếm.</div>
    <?php } ?>
</div>
<?php $this->load->view('group/common/footer-group'); ?>