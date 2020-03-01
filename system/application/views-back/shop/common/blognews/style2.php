
<?php if (isset($lastnews) && !empty($lastnews)) {
    $linkShop = $this->uri->segment(1);
    ?>    
    <div class="row tintuc">
			<div class="col-xs-12">
				<h3 class="text-center"><i class="fa fa-newspaper-o"></i> Tin tức mới nhất</h3>
			</div>
        <?php foreach ($lastnews as $k => $item) { ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 <?php echo $k >= 3 ? 'hidden-xs' : ''; ?>">
                <div style="<?php if ($k % 4 == 0) echo 'clear:both;'; ?>">

                    <h4>
                        <div class="thumbox">
                            <a href="<?php echo $URLRoot; ?>detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>">
                         
                                <?php $filename = 'media/images/tintuc/'.$item->not_dir_image.'/'.show_thumbnail($item->not_dir_image,$item->not_image,3,'tintuc');
                                if(file_exists($filename) && $item->not_image !=''){
                                    ?>
                                    <img src="<?php echo $URLRoot.$filename; ?>"  class="img-responsive"/>
                                <?php } else{?>
                                    <img width="300" height="200"  class="img-responsive" src="<?php echo $URLRoot; ?>media/images/no_photo_icon.png" />
                                <?php }?>
                         
                            <span style="display:block; margin: 10px 0"> <?php echo $item->not_title; ?></span>
                        </a>
                        </div>
                    </h4>
                    <p class="small"><i class="fa fa-calendar fa-fw"></i> <?php echo date('d/m/Y', $item->not_begindate); ?>
                        <a href="<?php echo $URLRoot; ?>detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>">
                            <i class="fa fa-file-o fa-fw"></i> Xem thêm</a>
                    </p>

                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>

