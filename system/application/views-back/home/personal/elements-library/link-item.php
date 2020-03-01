<?php
$link_title_xss = htmlspecialchars($link->title);
$link_image = DEFAULT_IMAGE_ERROR_PATH;
if($link->image) {
    $link_image = trim(strip_tags($link->image));
}
$custom_link = '';
//http://muaban247.azibai.xxx/library/view/node/LINK_TYPE/id custom link
if($link->type == CUSTOMLINK_CONTENT){
    $custom_link = $current_profile['profile_url'] . 'library/view/node/' . CUSTOMLINK_CONTENT . '/' . $link->id;

}else if($link->type == CUSTOMLINK_COLLECTION){
//    http://faavietnam.azibai.xxx/shop/collection-link/select/86/view/1281
    $custom_link = $profile_shop_url . '/shop/collection-link/select/' . $link->type_id . '/view/' . $link->id;
}
$link_title = trim(strip_tags($link->save_link));
?>
<div class="item">
    <div class="detail">
        <a href="<?php echo $custom_link ?>" target="_blank" title="<?php echo $link_title_xss ?>">
            <img src="<?php echo $link_image ?>"
                 alt="<?php echo $link_title_xss ?>"
                 class="lazyload"
                 title="<?php echo $link_title_xss ?>"
                 onerror="image_error(this)"
            >
        </a>
        <div class="text">
            <h3>
                <a rel="nofollow" href="<?php echo $link_title ?>" title="<?php echo $link_title_xss ?>"
                   target="_blank"><?php echo limit_the_string($link_title_xss) ?></a>
            </h3>
            <div class="thaotac hidden">
                <span class="xemthem"><img class="mt05" src="/templates/home/styles/images/svg/3dot_small_gray.svg" alt="more"></span>
                <div class="show-more">
                    <ul class="show-more-detail">
                        <li><a href="JavaScript:Void(0);">Gửi dưới dạng tin nhắn</a></li>
                        <li><a href="JavaScript:Void(0);">Lưu ảnh</a></li>
                        <li><a href="JavaScript:Void(0);">Báo cáo ảnh</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>