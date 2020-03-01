<?php $this->load->view('group/news/common/header'); ?>

<script type="text/javascript" src="/templates/home/js/clipboard.min.js"></script>

<script> function copylink(link) { clipboard.copy(link); } </script>

<div id="main" class="container-fluid">
    <div class="row">          
        <div class="col-xs-12 col-sm-2">
            <?php $this->load->view('group/news/common/menu-left'); ?>            
        </div>   
        <div class="col-xs-12 col-sm-5 nopadding-xs">
            <?php $this->load->view('group/news/common/group-top'); ?>

            <div class="panel panel-default">                
                <div class="panel-heading"><strong>Danh sách tờ rơi điện tử</strong></div>    
                <div class="panel-body">
                    <ol>
                        <?php
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                        $url = $_SERVER['HTTP_HOST'];
                        $arr_url = explode('.',$url);
                        if(count($arr_url) > 2){
                            $url = $arr_url[1].'.'.$arr_url[2];
                        }
                        foreach($list as $list): ?>
                        <li style="margin-bottom: 10px;">
                            <a class="bluetext" href="<?php echo $protocol.$url."/landing_page/id/".$list->id."/".RemoveSign($list->name); ?>" target="_blank"><?php echo $list->name; ?></a></li>
                        <?php endforeach;?>
                    </ol>
                </div>
            </div>
            
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

<?php $this->load->view('group/common/footer-group'); ?>