<?php



foreach ($list_related as $key => $value) { ?>
    <?php
    $number = 10;
    $content = str_replace("\n", "", strip_tags(preg_replace("/<img[^>]+\>/i", "", $value->not_title)));
    $item_title = $content;
    $array = explode(" ", $content);
    if (count($array) <= $number) {
        $item_title = $content;
    } else {
        array_splice($array, $number);
        $item_title = implode(" ", $array) . " ...";
    }
    $itemlink = site_url('tintuc/detail/' . $value->not_id .'/'. RemoveSign($value->not_title));
    $item_image = site_url('media/images/noimage.png');
    if ( $value->not_image != '' ):
	$item_image = DOMAIN_CLOUDSERVER.'media/images/content/' . $value->not_dir_image . '/thumbnail_1_' . $value->not_image;
    endif;
    ?>
    <div class="mod-item">
	<div class="pull-left">
	    <a href="<?php echo $itemlink ?>" title="<?php echo $value->not_title ?>">
		<img class="lazy" style="width:120px; height:120px;" data-src="<?php echo $item_image ?>" alt=""/>
	    </a>
	</div>
	<div style="margin-left: 120px; padding: 0 10px;">
	    <p class="item-title"><a title="<?php echo $value->not_title ?>" href="<?php echo $itemlink ?>" ><?php echo $item_title ?></a></p> 
	    <div class="small text-muted">
                <?php echo date('d/m/Y', $value->not_begindate); ?>
	    </div>
	</div>
	<div class="clearfix"></div>
    </div>
<?php } ?>
