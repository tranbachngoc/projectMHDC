<?php
$url_server_media_link = $this->config->item('library_link_config')['cloud_server_show_path'];
if($link['image']){
    $link_image = $url_server_media_link . '/' . $link['image'];
}else{
    $link_image = $link['link_image'];
}
$type_tbl = '';
if($link['type_tbl'] == LINK_TABLE_LIBRARY){
    $type_tbl   = 'library-link';
}
if($link['type_tbl'] == LINK_TABLE_CONTENT){
    $type_tbl   = 'content-link';
}
if($link['type_tbl'] == LINK_TABLE_IMAGE){
    $type_tbl   = 'image-link';
}
?>
<div class="media-wrap">
    <img src="<?php echo $link_image ?>" class="object-fit-cover">
    <div class="detail">
        <h3><?php echo $link['link_title'] ?></h3>
        <p><?php echo $link['link_description'] ?></p>
        <a href="<?= $domain_use .'/'. $type_tbl .'/'. $link['id'] ?>" rel="nofollow" target="_blank" class="btn-detail">Chi tiết</a>
    </div>
</div>