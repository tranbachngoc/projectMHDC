<?php
$linktoproduct = '';
if(isset($product) && !empty($product)){
    $linktoproduct = azibai_url() .'/'. $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . $afkey;
}

$numshare = 0;
if (isset($oImage) && $oImage->type == 'img') {
    $id = $oImage->id;
    $type = 'image';
    $is_like = $oImage->is_like;
    $likes = $oImage->likes;
    $class_show = 'js-countact-image-'.$id;
    $list_share = 'js-list-share-img';
    $data_tag = 'image';
    $numshare = $oImage->total_share;
}else{
    $id = $item->video_id;
    $type = 'video';
    $is_like = $item->is_like;
    $likes = $item->likes;
    $class_show = 'js-countact-video-'.$id;
    $list_share = 'js-list-share-video';
    $data_tag = 'video';
    $numshare = $item->total_share;
}

if(isset($value) && $value->product->pro_name != ''){
    $share_name = $value->product->pro_name;
}
$show_video = '';
$numlike = 0;
if(!empty($likes)){
    $show_video = ' js-show-like-'.$type;
    $numlike = $likes;
}

$numcomment = 0;
// Lấy hình theo loại hiển thị
$sLikeImgage = 'like.svg';
$class_txt = 'color-gray14';
$js_class_imgw = '';
if($have_bg == 1) {
    $sLikeImgage = 'like_white.svg';
    $class_txt = 'color-white';
    $js_class_imgw = 'js-background-black';
}

$sCommentImgage = 'comment.svg';
if($have_bg == 1) {
    $sCommentImgage = 'comment_white.svg';
    $class_txt = 'color-white';
    $js_class_imgw = 'js-background-black';
}

$sShareImgage = 'share.svg';
if($have_bg == 1) {
    $sShareImgage = 'share_01_white.svg';
    $class_txt = 'color-white';
    $js_class_imgw = 'js-background-black';
}

$sLinkImgage = 'link_black.svg';
if($have_bg == 1) {
    $sLinkImgage = 'link_white.svg';
    $class_txt = 'color-white';
    $js_class_imgw = 'js-background-black';
}

$style_bar = $style_iconlike = $style_iconcomment = $style_iconshare = 'display: none;';
if((isset($numlike) && $numlike > 0) || (isset($numcomment) && $numcomment > 0) || (isset($numshare) && $numshare > 0))
{
    $style_bar = '';
    if($numlike > 0)
    {
        $style_iconlike = '';
    }
    if($numcomment > 0)
    {
        $style_iconcomment = '';
    }
    if($numshare > 0)
    {
        $style_iconshare = '';
    }
}
if(isset($title_shr) && $title_shr != '')
{
    $share_name = $title_shr;
}
?>

<div class="bg-gray-blue">
    <div class="show-number-action version02 <?php echo $class_show;?> js-item-id js-item-id-<?=$id;?>" data-id="<?=$id;?>" style="<?php echo $style_bar; ?>">
      <ul>
        <li class="list-like-js-<?=$id;?><?=$show_video;?>" data-id="<?=$id;?>" style="<?php echo $style_iconlike; ?>">
            <img class="icon-img" src="/templates/home/styles/images/svg/liked.svg" class="mr05" alt="">
            <span class="count-like js-count-like-<?=$id;?> <?php echo $class_txt; ?>"><?php echo $numlike; ?></span>
        </li>
        <li class="cursor-pointer" style="<?php echo $style_iconcomment; ?>">0 bình luận</li>
        <li class="cursor-pointer js-list-share <?php echo $list_share?>" style="<?php echo $style_iconshare; ?>">
            <span class="total-share-img"><?php echo $numshare; ?></span> chia sẻ
        </li>
      </ul>
    </div>
    <div class="action <?=$js_class_imgw;?>">
      <div class="action-left show-number-action">
        <ul class="action-left-listaction version01">
            <li class="like cursor-pointer js-like-<?=$type;?> js-like-image-<?=$id;?>" data-id="<?=$id;?>">
                <?php if (!empty($is_like)) { ?>
                    <img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg">
                    <span class="md <?php echo $class_txt; ?>">Bỏ thích</span>
                <?php } else { ?>
                    <img class="icon-img" src="/templates/home/styles/images/svg/<?=$sLikeImgage?>" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg">
                    <span class="md <?php echo $class_txt; ?>">Thích</span>
                <?php } ?>
            </li>
          <li class="comment"><img class="icon-img" src="/templates/home/styles/images/svg/<?=$sCommentImgage?>" alt="comment"><span class="md <?php echo $class_txt; ?>">Bình luận</span></li>
          <li class="share-click-image anh-chitiettin" data-name="<?=$share_name;?>" data-value="<?=$share_url;?>" data-id="<?=$id;?>" data-toggle="modal" data-type="<?php echo $type_shr_imgvideo;?>" data-tag="<?php echo $data_tag; ?>">
            <img class="icon-img" src="/templates/home/styles/images/svg/<?=$sShareImgage?>" alt="share">
            <span class="md <?php echo $class_txt; ?>">Chia sẻ</span>
          </li>
        </ul>
      </div>
      <ul class="detail-more">
            <?php if ($item->sho_id != 0 && $linktoproduct != ''){ ?>
                <li class="mr20"><a target="_blank" href="<?php echo $linktoproduct ?>">Sản phẩm</a></li>
            <?php } ?>
            <?php if (isset($external_link) && $external_link != ''): ?>
                <li><a href="<?php echo $external_link ?>"><img class="mr05" src="/templates/home/styles/images/svg/<?=$sLinkImgage?>" />Liên kết</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php if ($comment_product): ?>
        <div class="create-new-comment">
            <div class="avata-user"><img src="/templates/home/styles/images/product/avata/mi.svg" alt=""></div>
            <div class="area-comment"><textarea placeholder="Thêm nhận xét"></textarea></div>
        </div>
        <div class="show-list-comments">
            <div class="comment">
                <dl>
                    <dt><img src="/templates/home/styles/images/product/avata/nikon.jpg" alt=""></dt>
                    <dd>
                        <span class="name-user">nicknamdg</span>Tai nghe tốt, giá hợp lý. cảm ơn shop.
                    </dd>
                </dl>
                <div class="action-comment">
                    <p><a href="">Thích</a></p>
                    <p><a href="">Trả lời</a></p>
                    <p>1giờ trước</p>
                </div>
            </div>
        </div>
    <?php endif; ?>