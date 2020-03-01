<?php
$icon_azibai = '';
$key_type    = null;
$icon_detail = null;
if(!empty($icons) && is_array($icons)) {
    foreach ($icons as $index => $icon) {
        if($key_type){
            break;
        }
        $type     = property_exists($icon, 'type') && $icon->type ? $icon->type : null;
        $icon_key = property_exists($icon, 'key') && $icon->key ? $icon->key : null;
        if($icon_key && $slug_icon && $icon_key == $slug_icon){
            $key_type = $type;
        }
        if(!$type || $type == ICON_TYPE_ICON || $type == ICON_TYPE_ANIMATION || $type == ICON_TYPE_AUDIO){
            $icon_azibai .= $this->load->view('home/tintuc/elements/item-detail-icon-azibai', [
                'icon'      => $icon,
                'index'     => $index,
                'type'      => $type,
                'image_dir' => $item->not_dir_image,
            ], true);
        }
        if($type == ICON_TYPE_IMAGE || $type == ICON_TYPE_VIDEO) {
            $icon_detail = $this->load->view('home/tintuc/elements/item-detail-icon', [
                'icon'      => $icon,
                'index'     => $index,
                'type'      => $type,
                'image_dir' => $item->not_dir_image,
                'domain_use' => $domain_use,
            ], true);
        }
    }
}
?>
<?php if($icon_azibai && (!$slug_icon || $key_type == ICON_TYPE_ICON || $key_type == ICON_TYPE_ANIMATION || $key_type == ICON_TYPE_AUDIO) ){ ?>
    <div class="trangtinchitiet-content post-detail">
        <div id="block_image_102634"
             class="trangtinchitiet-content-item  item04 block-image has-bg has-bg-img bg-overlay"
             data-animation=""
             data-delay="500">
            <div class="item-content">
                <div class="text">
                    <?php echo $icon_azibai; ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if($key_type && $icon_detail){
    echo $icon_detail;
} ?>
