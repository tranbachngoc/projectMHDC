<?php $this->load->view('group/news/common/header'); ?>
<script> function copylink(link) { clipboard.copy(link); } </script>
<div id="main" class="container-fluid">
    <div class="row">          
        <div class="col-xs-12 col-sm-2">
            <?php $this->load->view('group/news/common/menu-left'); ?>            
        </div>   
        <div class="col-xs-12 col-sm-5">
            
            <?php $this->load->view('group/news/common/group-top'); ?>
            
            <?php if (isset($results) && count($results) > 0) { ?>
                <div class="panel panel-default" id="results">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-newspaper-o fa-fw"></i>&nbsp; Kết quả tìm kiếm <span class="small">(<?php echo $totalRecord ?>)</span></h3>
                    </div>
                    <div class="panel-body">
					
                        <?php foreach ($results as $k => $item) { ?>                                
                            <div class="row" style="margin-bottom:20px;">
                                <div class="col-xs-12">
                                    <div class="pull-left" style="width:100px; height: 100px;">
                                        <div class="fix1by1">
                                            <?php
                                            $filename = 'media/images/tintuc/' . $item->not_dir_image . '/' . show_thumbnail($item->not_dir_image, $item->not_image, 1, 'tintuc');
                                            if (file_exists($filename) && $item->not_image != '') {
                                                $thumbnail = base_url() . $filename;
                                            } else {
                                                $thumbnail = base_url() . 'media/images/no_photo_icon.png';
                                            }
                                            ?>
                                            <a class="c" 
                                               href="<?php echo getAliasDomain() ?>grtnews/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>"
                                               style="background: url('<?php echo $thumbnail ?>') no-repeat center /  auto 100%;">                                                
                                            </a>
                                        </div>
                                    </div>
                                    <div class="" style="margin-left:115px;">
                                        <div class="item-title"><a href="<?php echo getAliasDomain() ?>grtnews/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>"><?php echo $item->not_title ?></a></div>
                                        <div class="small text-muted">
                                            <?php echo $item->not_description ?>
                                            <p>                                        
                                                <i class="fa fa-calendar fa-fw"></i> <?php echo date('d/m/Y', $item->not_begindate); ?>
                                                <i class="fa fa-eye fa-fw"></i> <?php echo $item->not_view; ?>
                                            </p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?> 
						
                    </div>                        
                </div>
                <div class="text-center"><?php echo $linkPage ?></div>    
            <?php } else { ?> 
				<div class="panel panel-default" id="results">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-newspaper-o fa-fw"></i>&nbsp; Kết quả tìm kiếm <span class="small">(<?php echo $totalRecord ?>)</span></h3>
                    </div>
					<div class="panel-body">
						<div>Không tìm thấy kết quả nào. Hãy thử một từ khóa tìm kiếm khác !</div>
				    </div>                        
                </div>
			<?php } ?>           
        </div> 
        <div class="col-xs-12 col-sm-3">  
               
                    <div class="panel panel-default panel-about">                
                        <div class="panel-heading">Sản phẩm mới</div>
                        <div class="panel-body">                     
                            <?php foreach ($products as $key => $item) { ?>
                                <div class="media"> 
                                    <div class="media-left">
                                        <div class="fix1by1" style="width:70px">
                                            <div class="c">
                                                <a href="<?php echo site_url('grtshop/product/detail/'.$item->pro_id.'/'. RemoveSign($item->pro_name));?>">
                                                    <?php
                                                    $fileimg = 'media/images/product/' . $item->pro_dir . '/' . show_thumbnail($item->pro_dir, $item->pro_image, 1);
                                                    ?>
                                                    <img class="media-object" alt=""  
                                                         src="<?php
                                                         if (file_exists($fileimg)) {
                                                             echo base_url() . $fileimg;
                                                         } else {
                                                             echo base_url() . 'media/images/no_photo_icon.png';
                                                         }
                                                         ?>"/>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="<?php echo site_url('grtshop/product/detail/'.$item->pro_id.'/'. RemoveSign($item->pro_name));?>">
                                                <?php echo $item->pro_name ?>
                                            </a>
                                        </h4> 
                                        <div class="price"><strong class="text-danger"><?php echo number_format($item->pro_cost) ?></strong> đ</div>
                                    </div> 
                                </div>
                            <?php } ?>

                        </div>                
                    </div>  
                
           
        </div>      
         <div class="col-xs-12 col-sm-2">
             <?php $this->load->view('group/news/common/ads-right'); ?>               
        </div> 
    </div> 
    
</div>

<script src="http://johannburkard.de/resources/Johann/jquery.highlight-5.js"></script>
<script type="text/javascript">
    jQuery(function ($) {
        $('#results').highlight("<?php echo $keyword ?>");
    });
</script>  
<?php $this->load->view('group/common/footer-group'); ?>
