<?php
if(!empty($icons_position)){
    $icon_path = $this->config->item('icon_path');
    foreach ($icons_position as $caption) { ?>
        <?php
            $effect = property_exists($caption, 'effect') ? $caption->effect : '';
            $sClassIcon = ($effect != '') ? 'animated hiding' : '';
            $keyR = rand();
        ?>
        <div class="icon_featured <?=$sClassIcon?> clearfix mb10 <?php echo $caption->position == 'center' ? 'mb30' : '' ?>" data-animation="<?=$effect;?>" data-delay="500">
            <div class="wrap-caption-icon f-<?php echo $caption->position ?>">
                <div class="icon border-black f-<?php echo $caption->position ?>">
                    <?php if($caption->type == 'json') { ?>
                        <div class="image-json" id="json_image_<?=$keyR?>"></div>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                bodymovin.loadAnimation({
                                  container: document.getElementById('json_image_<?=$keyR?>'),
                                  renderer: 'svg',
                                  loop: true,
                                  autoplay: true,
                                  path: '<?= $icon_path . $caption->icon?>'
                                });
                            });
                        </script>
                    <?php }else { ?>
                        <img src="/images/icons/<?php echo $icon_path . $caption->icon ?>">
                    <?php } ?>
                </div>
            </div>
            <div class="infomation text-<?php echo $caption->position ?>">
                <p class="title"><?php echo $caption->title ?></p>
                <p class="desc"><?php echo $caption->desc ?></p>
            </div>
        </div>
    <?php } ?>
<?php } ?>
