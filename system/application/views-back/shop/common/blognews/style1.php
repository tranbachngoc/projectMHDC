<?php if (isset($lastnews) && !empty($lastnews)) {
    $linkShop = $this->uri->segment(1);
    ?>
    <h3><span class="modtitle"><i class="fa fa-newspaper-o"></i> Tin tức mới nhất</span></h3>
    <div class="row tintuc">
        <?php foreach ($lastnews as $k => $item) {
            if ($k < 8) { ?>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 <?php echo $k > 3 ? 'hidden-xs' : ''; ?>">
                    <div style="<?php if ($k % 4 == 0) echo 'clear:both'; ?>">
                        <div class="thumbnail" style="margin-bottom: 0">
                            <div class="thumbox">
                                <a href="<?php echo $URLRoot; ?>detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>">
                                    <?php $filename = 'media/images/tintuc/'.$item->not_dir_image.'/'.show_thumbnail($item->not_dir_image,$item->not_image,3,'tintuc');
                                    if(file_exists($filename) && $item->not_image !=''){
                                        ?>
                                        <img src="<?php echo $URLRoot.$filename; ?>"  class="img-responsive"/>
                                    <?php } else{?>
                                        <img width="300" height="200"  class="img-responsive" src="<?php echo $URLRoot; ?>media/images/no_photo_icon.png" />
                                    <?php }?>
                                </a>
                            </div>
                        </div>
                        <div style="margin-bottom: 20px">

                            <h4>
                                <a href="<?php echo $URLRoot; ?>detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>"><?php echo $item->not_title; ?></a>
                            </h4>

                            <!--p><?php $vovel = array("&curren;");
                            echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel, "#", $item->not_detail)), 150)); ?></p-->

                            <p><i class="fa fa-calendar fa-fw"></i><?php echo date('d/m/Y', $item->not_begindate); ?>
                                <a href="<?php echo $URLRoot; ?>detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>">
                                    <i class="fa fa-file-o fa-fw"></i> Xem thêm</a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
<?php } ?>