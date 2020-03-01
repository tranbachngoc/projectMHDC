<?php $this->load->view('home/common/header'); ?>
<div id="main" class="container-fluid">
    <div class="row">
        <div class="col-md-2 hidden-xs">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-md-10">            
            <div class="panel panel-default">
                <div class="panel-heading"><span class="text-uppercase">Danh sách chọn tin </span><span class="badge pull-right"><?php echo count($listselect)?></span></div>
                <div class="panel-body">
                    <div class="row">
                    <?php foreach ($listselect as $key => $item) { if($key>0&&$key%2==0) echo '</div><div class="row">';
                        $filename = 'media/shop/logos/' . $item->sho_dir_logo . '/' . $item->sho_logo;                         
                        if( $item->sho_logo && file_exists($filename) ) {
                            $shop_logo = $filename;
                        } else {
                            $shop_logo = 'images/no-logo.png';
                        }
                        if($item->domain) {
                            $linktoshop = 'https://'.$item->domain;                             
                        } else { 
                            $linktoshop = 'https://'.$item->sho_link . '.' . domain_site;
                        }
                    ?>   
                    <div class="col-sm-6">
                        <div style="height:60px; margin-bottom: 15px;">                   
                            <a href="<?php echo $linktoshop; ?>">
                              <img class="img-circle" src="<?php echo base_url() . $shop_logo; ?>" alt="" style="width:60px; height:60px; margin-right: 15px; vertical-align: middle"/>
                              <?php echo $item->sho_name ?>
                            </a>
                        </div>  
                    </div>                        
                    <?php } ?>
                    </div>
                </div>
                <div class="panel-footer"> 
                    <a href="javascript:history.back()" class=""><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Về trang trước</a>
                </div>
            </div>
            
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>


