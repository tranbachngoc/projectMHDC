<?php
$owner_name          = '';
$afkey               = '';
$azibai_url          = azibai_url();
$domain_use          = $azibai_url;
$is_fsale            = false;
$show_vol            = true;
$flag_process_string = false;
$ua                  = strtolower($_SERVER['HTTP_USER_AGENT']);
$user_id             = (int)$this->session->userdata('sessionUser');
$group_id            = (int)$this->session->userdata('sessionGroup');
$logo                = site_url('templates/home/images/no-logo.jpg');
$avatar_bst_tin = $avatar_bst_tin_path = '';
if(!empty($item->listImg)) {
    $avatar_bst_tin = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->listImg[0]->image;
    $avatar_bst_tin_path = $item->not_dir_image . '/' . $item->listImg[0]->image;
} else if($item->not_video_url1) {
    $avatar_bst_tin = $item->poster;
    $avatar_bst_tin_path = $item->poster_path;
} else if(!empty($item->not_customlink)) {
    $aLink = $item->not_customlink[0];
    if($aLink->media_type == 'video' && $aLink->video_path != '') {
        $avatar_bst_tin = DOMAIN_CLOUDSERVER . 'media/custom_link/'. $aLink->image_path;
        $avatar_bst_tin_path = $aLink->image_path;
    } elseif ($aLink->media_type == 'image' && $aLink->image_path != '') {
        $avatar_bst_tin = DOMAIN_CLOUDSERVER . 'media/custom_link/'. $aLink->image_path;
        $avatar_bst_tin_path = $aLink->image_path;
    } else {
        $avatar_bst_tin = azibai_url() . '/templates/home/styles/images/default/error_image_400x400.jpg';
        $avatar_bst_tin_path = '';
    }
} else {
    $avatar_bst_tin = azibai_url() . '/templates/home/styles/images/default/error_image_400x400.jpg';
    $avatar_bst_tin_path = '';
}

$no_slider = false;
( ( empty($item->listImg) || !$item->not_video_url1 ) || empty($item->sho_id) ) ? $no_slider = true : $no_slider = false;


if (stripos($ua, 'ipod') !== false || stripos($ua, 'iphone') !== false || stripos($ua, 'ipad') !== false) {
    $show_vol = false;
}

if (!empty($af_id)) {
    $afkey = '?af_id=' . $af_id;
}

$item_link = $azibai_url . '/tintuc/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . $afkey;

if (!empty($item->collection) && !empty($item->collection_content)) {
    $collection         = $item->collection;
    $collection_content = $item->collection_content;
}

//shop
if(!empty($item->sho_id) && !empty($item->not_user)){
    $domain_use = shop_url($item);
    $owner_name = $item->sho_name;
    if (!empty($item->sho_logo)) {
        $logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $item->sho_dir_logo . '/' . $item->sho_logo;
    }
    if (!empty($item->show_shop)) {
        $item_link = $domain_use . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . $afkey;
    }

    $type_shrimg = TYPESHARE_DETAIL_SHOPIMG;
    $type_shrvideo = TYPESHARE_DETAIL_SHOPVIDEO;
}

//user
if(empty($item->sho_id) && !empty($item->not_user)){
    $owner_name = $item->use_fullname;
    $domain_use = !empty($item->website) ? 'http://' .$item->website : $azibai_url . '/profile/' . $item->not_user;
    if (!empty($item->avatar)) {
        $logo = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $item->use_id . '/' .  $item->avatar;
    }
    if (!empty($personal_page)) {
        $item_link = $domain_use . '/news/detail/' . $item->not_id . '/' . $afkey;
    }

    $type_shrimg = TYPESHARE_DETAIL_PRFIMG;
    $type_shrvideo = TYPESHARE_DETAIL_PRFVIDEO;
}
$allow_tag = '';
if(!empty($item->mentions)) {
    foreach ($item->mentions as $key => $mention) {
        $allow_tag .= "<{$mention->user_id}>";
    }
}

$data_title_process = $data_title_raw = trim($item->not_title);
$data_detail_raw = nl2br(strip_tags(trim($item->not_detail), $allow_tag));
$data_detail_process = strip_tags(trim($item->not_detail));
$String_data = $data_title_process . ' ' . $data_detail_process;
if($data_title_process == ''){
    $String_data = $data_detail_process;
}
$chars = preg_split('//u', $String_data, null, PREG_SPLIT_NO_EMPTY);
$chars_title = preg_split('//u', $data_title_process, null, PREG_SPLIT_NO_EMPTY);

if ($isMobile == 0) {
    if(count($chars) > $number_max = 130) {
        $offset = (count($chars_title) > 0 ? (count($chars_title) ) : 0 );
        $new_string = array_slice($chars, $offset, 130 - count($chars_title));
        $item->not_detail = implode('', $new_string);
        $flag_process_string = true;
    }
}

if ($isMobile == 1) {
    if(count($chars) > $number_max = 80) {
        $offset = (count($chars_title) > 0 ? (count($chars_title) ) : 0 );
        $new_string = array_slice($chars, $offset , 80 - count($chars_title));
        $item->not_detail = implode('', $new_string);
        $flag_process_string = true;
    }
}

// Xử lý gắn mentions
$mentions = $item->mentions;
if(!empty($mentions)) {
    $string_old = $item->not_detail;
    foreach ($mentions as $key => $mention) {
        $str_find = "<{$mention->user_id}>";
        $str_replace = "<a href='{$mention->link_website}'>@{$mention->full_name}</a>";
        $data_detail_raw = str_replace($str_find, $str_replace, $data_detail_raw);
        if(preg_match("/{$str_find}/i", $item->not_detail)) { // kiểm tra chuỗi sau khi cắt có user nếu có
            $item->not_detail = str_replace($str_find, $str_replace, $item->not_detail);
        } else if(!preg_match("/{$str_find}/i", $item->not_detail) && $flag_process_string = true) {
            // có xử lý chuổi và ko tìm thấy text cần preplace
            // nếu ko có => mention ở chuỗi sau xữ lý đã bị mất 1 đoạn VD: <12345> => <1234
            // dựa vào start và end của mention, độ dài ký tự tối đa nằm trong khoản [start,end]
            if($mention->start <= $number_max && $number_max <= $mention->end) {
                $text_lost = substr($string_old, $mention->start, strlen($mention->user_id) + 2); // text bị cắt lỗi
                $temp = explode(' ', $item->not_detail);
                $temp[count($temp)-1] = $str_replace;
                $item->not_detail = implode(' ', $temp);
            }
        }
    }
}
// Xử lý gắn hashtag
// $string_test = "shdsh s d #123hdfhhh jsjsadsfjdsj #fsfdssad afsa asdsa s";
if(preg_match_all('/#[a-zA-Z0-9]*/i', $data_detail_raw, $m)) {
    foreach ($m[0] as $key => $value) {
        $keyword = urlencode($value);
        $url = azibai_url("/search?keyword=$keyword");
        $str_find = "{$value}";
        $str_replace = "<a href='{$url}'>{$value}</a>";
        $data_detail_raw = str_replace($str_find, $str_replace, $data_detail_raw);
        $item->not_detail = str_replace($str_find, $str_replace, $item->not_detail);
    }
}

$title = $item->not_title;
if($item->not_detail != ''){
    $title .= ' - '.cut_string_unicodeutf8(strip_tags(html_entity_decode($item->not_detail)), 225);
}
if($item->sho_id){ $title = $item->not_title;}

$title_tag = str_replace('"', "", $title);
$title_    = convert_percent_encoding($title);

// ------------------------------------------------------------------------
// $js_name_show = '';
// if( (!empty($item->not_customlink) && empty($item->listImg) && empty($item->not_video_url1))
//   || (empty($item->not_customlink) && !empty($item->listImg) && count($item->listImg) == 1 && empty($item->not_video_url1))
//   || (empty($item->not_customlink) && empty($item->listImg) && !empty($item->not_video_url1)) )
//   {
//     if($flag_process_string == true) {
//         $js_name_show = 'js-show-more';
//     } else if($flag_process_string == false){
//         $js_name_show = 'js-redirect-content';
//     }
//   }
//   else {
//     $js_name_show = 'js-redirect-content';
//   }
$js_name_show = '';
$flag_show_more = false;
if( (!empty($item->not_customlink) && empty($item->listImg) && empty($item->not_video_url1))
  || (empty($item->not_customlink) && !empty($item->listImg) && count($item->listImg) == 1 && empty($item->not_video_url1))
  || (empty($item->not_customlink) && empty($item->listImg) && !empty($item->not_video_url1)) )
  {
    if($flag_process_string == true) {
      $flag_show_more = true;
    }
    $js_name_show = 'js-show-more';
  }
  else {
    $js_name_show = 'js-redirect-content';
  }
// ------------------------------------------------------------------------

$actual_link = get_current_full_url();
$domain_share = get_current_base_url($actual_link);
if($domain_share === azibai_url() && strpos($actual_link, '/profile/') !== false) {
  $domain_share .= '/profile/' . $item->not_user;
}
$aDatasComment = array(
    'data_news_id'  => $item->not_id,
    'data_id'       => '',
    'data_key'      => '',
    'data-ori'      => '',
    'src'           => '/templates/home/styles/images/default/error_image_400x400.jpg',
    'alt'           => '',
    'title'         => '',
    'data_name'     => '',
    'data_value'    => ''
);
?>
<div class="post js-detect-item-viewport js_item-detect-video-action count-<?=$key?> page-<?=$page?> js-content-item_<?=$item->not_id?>">
    <div class="post-head">
        <div class="post-head-name">
            <div class="avata">
                <a class="shop_avatar_link" href="<?php echo $domain_use ?>">
                    <img onerror="image_error(this)" src="<?php echo $logo ?>" alt="<?=$item->sho_name?>">
                </a>
            </div>
            <div class="title two-lines">
                <a class="one-line" href="<?php echo $domain_use ?>"><?php echo $owner_name ?></a>
                <span><?php echo date('d/m/Y', $item->not_begindate); ?></span>
            </div>
        </div>
        <div class="post-head-more" style="width: 100px">
            <?php
            $text_friend = $img_friend = '';
            if($item->sho_id > 0){
                $data_id = $item->sho_id;
                $class_follow = 'cursor-pointer is-follow-shop is-follow-shop-'.$data_id;
                $img_friend = '<img src="/templates/home/styles/images/svg/theodoi.svg" title="Theo dõi gian hàng">';

                if($item->follow['follow_shop'] == 1){
                    $class_follow = 'cursor-pointer cancel-follow-shop cancel-follow-shop-'.$data_id;
                    $img_friend = '<img src="/templates/home/styles/images/svg/botheodoi.svg" title="Hủy theo dõi gian hàng">';
                }
            }else{
                $data_id = $item->use_id;
                $class_follow = 'cursor-pointer js-follow-user-profile btn-friend-'.$data_id;
                $img_friend = '<img src="/templates/home/styles/images/svg/ketban.svg" title="Kết bạn">';

                if(!empty($item->follow)){
                    if($item->follow['is_friend'] == 1){
                        $class_follow = 'cursor-pointer unfriend btn-friend-'.$data_id;
                        $img_friend = '<img src="/templates/home/styles/images/svg/banbe.svg" title="Bạn bè">';
                    }else{
                        if($item->follow['addFriend'] == 1){
                            $class_follow = '';
                            $img_friend = '<img src="/templates/home/styles/images/svg/daguiloimoi.svg" title="Đã gửi yêu cầu">';
                        }else{
                            $img_friend = '';
                            $class_follow = 'cursor-pointer js-confirmfollow-user btn-follow-'.$data_id;
                            $text_friend = 'Xác nhận';
                        }
                    }
                }
            }

            if($this->session->userdata('sessionUser') != $item->use_id && !isset($current_profile) && !isset($siteGlobal))
            {
            ?>
            <div class="hidden-text item-status">
                <div class="<?php echo $class_follow; ?>" data-id="<?php echo $data_id; ?>" data-name="<?php echo $owner_name; ?>">
                    <?php echo $img_friend;?>
                    <?php echo $text_friend;?>
                </div>
            </div>
            <?php
            }
            ?>

            <span data-toggle="modal" data-target="#myModal_<?php echo $item->not_id ?>">
                <img class="icon-img" src="/templates/home/styles/images/svg/3dot_doc.svg" height="24" alt="more">
            </span>
            <div class="modal mess-bg" id="myModal_<?php echo $item->not_id ?>">
                <div class="modal-dialog modal-lg modal-mess ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <ul class="show-more-detail" data-id="<?php echo $item->not_id ?>">
                                <?php if (empty($personal_page)) { ?>
                                    <a href="<?php echo $domain_use ?>"><li>Đến trang của gian hàng</li></a>
                                <?php } else { ?>
                                    <a href="<?php echo $domain_use ?>"><li>Đến trang của cá nhân</li></a>
                                <?php } ?>
                                <?php if ($item->check_quick_view['link'] == true || $item->check_quick_view['product'] == true || $item->check_quick_view['tag'] == true) { ?>
                                    <a href="<?php echo $item->root_url . '/quick-view/' . $item->not_id ?>" target="_blank"> <li>Xem nhanh liên kết & sản phẩm trong tin</li></a>
                                <?php } ?>
                                    <a href="tel:<?php echo $item->sho_mobile ?>"><li>Gọi ngay</li></a>
                                <?php if ($item->sho_email) { ?>
                                    <a target="_blank" href="mailto:<?php echo $item->sho_email ?>"><li>Gửi tin nhắn</li></a>
                                <?php } ?>
                                <a href="javascript:void(0)" onclick="copy_text('<?php echo $item_link ?>')"><li>Sao chép liên kết</li></a>
                                <?php if($item->not_user == $this->session->userdata('sessionUser')) { ?>
                                    <!-- <a href="javascript:void(0)" class="js-delete-content" data-id="<?=$item->not_id?>"><li>Xóa bài viết</li></a> -->
                                    <a href="javascript:void(0)" onclick="delete_content_by_id(<?=$item->not_id?>)"><li>Xóa bài viết</li></a>
                                <?php } ?>
                            <?php
                            if($item->not_user != $this->session->userdata('sessionUser')) {
                                $rpd_name = '';
                                if($item->not_title){ 
                                    $rpd_name = $item->not_title;
                                }
                                else {
                                    $rpd_name = $item->not_detail;
                                }
                                ?>
                                <a href="#" style="border:none;" class="report-popup" data-rpd_type="1" data-link="<?php echo $item_link ?>" data-rpd_name="<?php echo $rpd_name; ?>" data-toggle="modal" data-target="#reportpopup"><li>Báo cáo</li></a>
                            <?php
                            }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="post-detail item-element-parent item-home trangcuatoi">
        <?php
        // show doanh nghiep
        if ($item->not_video_url1 && !empty($item->sho_id)) {
            $this->load->view('home/tintuc/elements/item-video', ['show_vol' => $show_vol, 'data_name' => $title, 'data_value' => $item_link]);
        } else {
            // show cá nhân nếu có video và không có ảnh
            if(empty($item->sho_id) && $item->not_video_url1 && empty($item->listImg)){
                $this->load->view('home/tintuc/elements/item-video', ['show_vol' => $show_vol, 'data_name' => $title, 'data_value' => $item_link]);
            }
        }
        $random = rand(1, 1000000000);
        ?>
        <div class="list-slider " data-id="<?php echo $item->not_id . $random; ?>">
            <!-- slide image -->
            <?php if(!empty($item->listImg)){ ?>
                <?php if (!empty($item->listImg)) { ?>
                    <span class="pagingInfo button-gray" id="pagingInfo_<?php echo $item->not_id . $random; ?>"></span>
                <?php } ?>
                <?php if (!empty($item->not_customlink) && $no_slider == false) { ?>
                    <span class="open-close-link button-gray"
                          id="open-close-link_<?php echo $item->not_id . $random; ?>"
                          onclick="slider_sharelink(<?php echo $item->not_id . $random; ?>)">Mở liên kết</span>
                <?php } ?>
                <?php if (!empty($item->listImg)) { ?>
                    <ul class="slider slider-for" id="slider-for_<?php echo $item->not_id . $random; ?>" data-id="<?php echo $item->not_id . $random; ?>">
                        <?php
                        if ($item->not_video_url1 && empty($item->sho_id)) {
                            echo '<li>';
                            $this->load->view('home/tintuc/elements/item-video', ['show_vol' => $show_vol, 'data_name' => $title, 'data_value' => $item_link]);
                            echo '</li>';
                        }
                        ?>
                        <?php foreach ($item->listImg as $key => $value) { ?>
                            <?php
                            if (isset($value->img_type) && $value->img_type == 'image/gif') {
                                $image_url = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $value->image;
                            } else {
                                $image_url = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $value->link_crop;
                            }
                            $oImageOption = json_decode($value->style);
                            // Lấy chữ trên hình
                            $text_images = (array) @$oImageOption->text_list;
                                if($key == 0) {
                                    $aDatasComment = array(
                                        'data_news_id'  => $item->not_id,
                                        'data_id'       => $value->id,
                                        'data_key'      => $key,
                                        'data-ori'      => @$value->orientation,
                                        'src'           => '/templates/home/styles/images/default/error_image_400x400.jpg',
                                        'alt'           => ($value->title) ? str_replace('"', "", $value->title) : $title_tag,
                                        'title'         => ($value->title) ? str_replace('"', "", $value->title) : $title_tag,
                                        'data_name'     => $title,
                                        'data_value'    => $item_link
                                    );
                                }
                                // $vl_title = htmlspecialchars_decode(convert_percent_encoding($value->title), ENT_QUOTES, "UTF-8");
                            ?>
                            <li class="position-tag">
                                <?php if ($key > 0) { ?>
                                    <img
                                            data-lazy="<?php echo $image_url ?>" id="image_<?= $value->id; ?>"
                                            onerror="image_error(this)"
                                            class="popup-detail-image <?= (property_exists($value, 'orientation') ? (in_array($value->orientation, [-90, 270]) ? 'rotate-l-90' : ($value->orientation == 90 ? 'rotate-r-90' : ($value->orientation == 180 ? 'rotate-180' : ''))) : '' )?>"
                                            data-news-id="<?php echo $item->not_id ?>"
                                            data-id="<?= $value->id; ?>"
                                            data-key="<?php echo $key; ?>"
                                            data-ori="<?= @$value->orientation?>"
                                            src="/templates/home/styles/images/default/error_image_400x400.jpg"
                                            alt="<?php echo ($value->title) ? str_replace('"', "", $value->title) : $title_tag ?>"
                                            title="<?php echo ($value->title) ? str_replace('"', "", $value->title) : $title_tag ?>"
                                            data-name="<?php echo str_replace('"', '%22', ($value->title) ? $value->title : $title);?>" data-value="<?php echo $item_link; ?>"
                                            data-type="<?php echo $type_shrimg; ?>"
                                            data-box_slider = "<?php echo $item->not_id . $random; ?>"/>
                                <?php } else { ?>
                                    <img
                                            id="image_<?= $value->id; ?>"
                                            onerror="image_error(this)"
                                            class="popup-detail-image <?= (property_exists($value, 'orientation') ? (in_array($value->orientation, [-90, 270]) ? 'rotate-l-90' : ($value->orientation == 90 ? 'rotate-r-90' : ($value->orientation == 180 ? 'rotate-180' : ''))): '');?>"
                                            data-news-id="<?php echo $item->not_id ?>"
                                            data-id="<?= $value->id; ?>"
                                            data-key="<?php echo $key; ?>"
                                            data-ori="<?=property_exists($value, 'orientation') ? $value->orientation : 0 ?>"
                                            src="<?php echo $image_url ?>"
                                            alt="<?php echo ($value->title) ? str_replace('"', "", $value->title) : $title_tag ?>"
                                            title="<?php echo ($value->title) ? str_replace('"', "", $value->title) : $title_tag ?>"
                                            data-name="<?php echo str_replace('"', '%22', ($value->title) ? $value->title : $title); ?>" data-value="<?php echo $item_link; ?>"
                                            data-type="<?php echo $type_shrimg; ?>"
                                            data-box_slider = "<?php echo $item->not_id . $random; ?>"/>
                                <?php } ?>

                                <!-- tags photo -->
                                <?php
                                if (isset($value->tags) && $value->tags != '' && $value->tags != "'null'" && $value->tags != "[]" && $value->tags != null && $value->tags != 'null' && $value->tags != "\"null\"") {
                                    $count_tags = @count(json_decode($value->tags, true));
                                    if ($count_tags == 0) {
                                        $count_tags = count($value->tags);
                                    }
                                } else {
                                    $count_tags  = 0;
                                    $value->tags = "[]";
                                }
                                ?>
                                <div class="popup-detail-image fs-gal hide_<?php echo $count_tags ?> tag-number-selected"
                                     data-parent="<?php echo $item->not_id . $random; ?>"
                                     data-url="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $value->image ?>"
                                     data-tags="<?php echo $value->tags && gettype($value->tags) === 'string' ? htmlspecialchars($value->tags) : '{}'; ?>"
                                     data-news-id="<?php echo $item->not_id ?>" data-key="<?php echo $key; ?>"
                                     data-name="<?php echo str_replace('"', '%22', $title); ?>" data-value="<?php echo $item_link; ?>">
                                    <img src="<?php echo $item->root_url . '/templates/home/icons/boxaddnew/tag.svg'; ?>"
                                         alt="" style="max-width: 32px">
                                    <span class="number"><?php echo $count_tags; ?></span>
                                </div>
                                <!-- tags photo -->
                                <!-- Chữ trên hình -->
                                <?php
                                if (!empty($text_images)) {
                                    try{
                                        echo $this->load->view(
                                            'home/tintuc/elements/text-in-image',
                                            array(
                                                'text_images' => $text_images,
                                                'iImageId' => $value->id
                                            )
                                        );
                                    }catch (Exception $e){}
                                }
                                ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else if ($item->not_video_url1 && empty($item->sho_id)){
                    echo '<li>';
                    $this->load->view('home/tintuc/elements/item-video', ['show_vol' => $show_vol, 'data_name' => $title, 'data_value' => $item_link]);
                    echo '</li>';
                } ?>
            <?php } ?>
            <!-- END slide image -->
            <?php if (!empty($item->not_customlink)) { ?>
                <?php
                $class_no_image_video =  empty($item->listImg) && !$item->not_video_url1 ? 'version02' : null;
                $iNumberLink = count($item->not_customlink);
                $type_slider = 'three-sliders';
                if($iNumberLink == 1){
                    $type_slider = 'one-slider';
                } elseif($iNumberLink == 2){
                    $type_slider = 'two-sliders';
                    if($class_no_image_video == 'version02'){
                        $type_slider = '';
                    }
                }

                ?>
                <div class="addlinkthem <?= $no_slider == true ? 'no-slider-for' : ''?> <?php echo (!empty($item->not_customlink) && $no_slider == false) ? 'no-active' : '' ?> version01
                            <?php echo $class_no_image_video ?>" id="addlinkthem">
                    <ul class="slider addlinkthem-slider <?php echo $type_slider;?>"
                        id="addlinkthem-slider_<?php echo $item->not_id . $random; ?>">
                        <?php foreach ($item->not_customlink as $kLink => $link_v2) {
                            $this->load->view('home/tintuc/item-link-v2', [
                                'kLink'      => $kLink,
                                'link_v2'    => $link_v2,
                                'domain_use' => $domain_use,
                                'mode'       => (!$isMobile && $class_no_image_video == 'version02' ? 'pc' : 'mb'),//use for get mode image link
                            ]);
                        } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>

        <div class="bg-gray-blue">
            <?php
            $show_video = '';
            $numlike = 0;
            if(!empty($item->likes)){
                $show_video = ' js-show-like';
                $numlike = $item->likes;
            }

            $numcomment = 0;
            $numshare = 0;
            if($item->total_share > 0){
                $numshare = $item->total_share;
            }

            $style_bar = $style_iconlike = $style_iconcomment = $style_iconshare = 'display: none;';

            if($numlike > 0 || $numcomment > 0 || $numshare > 0)
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
            ?>
            <div class="show-number-action version02 js-item-id js-item-id-<?php echo $item->not_id; ?> js-countact-content-<?php echo $item->not_id ?>" style="<?php echo $style_bar; ?>" data-id="<?php echo $item->not_id; ?>">
                <ul>
                    <li class="list-like-js-<?=$item->not_id;?><?=$show_video;?>" data-id="<?php echo $item->not_id; ?>" style="<?php echo $style_iconlike; ?>">
                        <img src="/templates/home/styles/images/svg/liked.svg" class="mr05" alt="">
                        <span class="js-count-like-<?php echo $item->not_id; ?>">
                        <?php echo $numlike; ?>
                        </span>
                    </li>

                    <li class="js-list-comment js-list-comment-contents" style="<?php echo $style_iconcomment; ?>"><span class="total-comment-img"><?php echo $numcomment; ?></span> bình luận</li>

                    <li class="js-list-share js-list-share-content" style="<?php echo $style_iconshare; ?>"><span class="total-share-img"><?php echo $numshare; ?></span> chia sẻ</li>
                </ul>
            </div>
            <div class="action">
                <div class="action-left show-number-action">
                    <ul class="action-left-listaction version01">
                        <li class="like js-like-content js-like-content-<?php echo $item->not_id ?>" data-id="<?php echo $item->not_id ?>">
                            <?php if (!empty($item->is_like)) { ?>
                                <img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like"
                                    data-like-icon="/templates/home/styles/images/svg/like_pink.svg"
                                    data-notlike-icon="/templates/home/styles/images/svg/like.svg">
                                <span class="md">Bỏ thích</span>
                            <?php } else { ?>
                                <img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like"
                                    data-like-icon="/templates/home/styles/images/svg/like_pink.svg"
                                    data-notlike-icon="/templates/home/styles/images/svg/like.svg">
                                <span class="md">Thích</span>
                            <?php } ?>
                        </li>
                        <?php
                            $detect = new Mobile_Detect();
                            $infomation_user = json_encode(array(
                                'use_fullname'  => $item->use_fullname,
                                'avatar'        => DOMAIN_CLOUDSERVER . 'media/images/avatar/'.$item->use_id.'/'.$item->avatar,
                                'detail_link'   => $item_link
                            ));
                        ?>

                        <?php if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) { ?>
                            <li class="comment comment-new-popup-mobile" data-user='<?=$infomation_user;?>' data-id="<?=$item->not_id?>">
                                <a href="comment/<?=$item->not_id?>"><img class="icon-img" src="/templates/home/styles/images/svg/comment.svg" alt="comment"></a>
                                <span class="md">Bình luận</span>
                            </li>
                        <?php } else { ?>
                            <li class="comment popup-detail-image" 
                                data-news-id="<?php echo $aDatasComment['data_news_id'] ?>"
                                data-id="<?= $aDatasComment['data_id']; ?>"
                                data-key="<?php echo $aDatasComment['data_key']; ?>"
                                data-ori="<?= $aDatasComment['data_ori'] ?>"
                                src="<?=$aDatasComment['src']?>"
                                alt="<?=$aDatasComment['alt']?>"
                                title="<?=$aDatasComment['title']?>"
                                data-name="<?php echo str_replace('"', '%22', $aDatasComment['data_name'])?>"
                                data-value="<?=$aDatasComment['data_value']?>"
                            >
                                <img class="icon-img" src="/templates/home/styles/images/svg/comment.svg" alt="comment">
                                <span class="md">Bình luận</span>
                            </li>
                        <?php } ?>

                        <?php
                            $data_share = [
                                'layout_share' => 'content',
                                'data_name' => $title_,
                                'data_value' => $domain_share.'/share-content-page/'.$item->not_id,
                                'data_type' => $item->type_share,
                                'data_item_id' => $item->not_id,
                                'data_detail' => $item_link,
                                'data_permission' => ($this->session->userdata('sessionUser') == $item->not_user) ? 1 : '',
                                'src_image' => '/templates/home/styles/images/svg/share.svg',
                                'data_tag' => 'content'
                            ];
                            $this->load->view('home/share/bar-btn-share', array('data_share' => $data_share));
                        ?>

                    </ul>
                </div>
                <div class="action-right">
                    <ul class="btns">
                        <?php
                        if ($this->session->userdata('sessionUser')) {
                        $flag = false;
                        $icon = 'bookmark.svg';
                        if(!empty($collection) && gettype($collection) !== 'boolean'){
                            foreach ($collection as $key => $value) {
                                if (in_array($item->not_id, $collection_content[$value->id])) {
                                    $flag = true;
                                    $icon = 'bookmark_gray.svg';
                                }
                            }
                        }
                        ?>
                        <li class="bookmark-button" id="bookmark-button_<?php echo $item->not_id . $random; ?>"
                            onclick="bookmark_oc(<?php echo $item->not_id . $random; ?>)">
                            <img class="icon-img" src="/templates/home/styles/images/svg/<?php echo $icon ?>"
                                alt="bookmark"
                                id="icon-img_<?php echo $item->not_id . $random; ?>">
                        </li>
                    </ul>
                    <div class="show-more hidden bosuutap-show-action">
                        <div class="click-lan-1">
                            <div class="tit opened" id="tit_<?php echo $item->not_id . $random; ?>">
                                <img src="/templates/home/styles/images/svg/cong.svg" alt=""><span>Tạo bộ sưu tập mới</span>
                            </div>
                            <form action="" method="POST"
                                id="frmCreateCollectionContent_<?php echo $item->not_id . $random; ?>">
                                <div class="details" style="display:block">
                                    <div class="nut-xacnhan buttons-group save-collection"
                                        style="position: absolute; right: 10px; top: -13px; display:<?php echo(count($collection) > 0 ? 'block;' : 'none;') ?>">
                                        <button type="submit" class="btn-bg-gray">Lưu</button>
                                    </div>
                                    <div><input type="hidden" name="collection[]" value="off"/></div>
                                    <ul class="bosuutap-danhsach-hientai">
                                        <?php if(!empty($collection) && gettype($collection) !== 'boolean'){ ?>
                                            <?php foreach ($collection as $key => $value) {
                                                $flag = false;
                                                if (in_array($item->not_id, $collection_content[$value->id])) {
                                                    $flag = true;
                                                }
                                                ?>
                                                <li>
                                                    <div class="photo">
                                                        <img onerror="error_image(this)" src="<?php echo $value->avatar_path_full; ?>"
                                                            alt="">
                                                        <label class="checkbox-style">
                                                            <input type="checkbox" name="collection[]"
                                                                value="<?php echo $value->id; ?>" <?php if ($flag == true) echo "checked" ?>><span></span>
                                                        </label>
                                                    </div>
                                                    <div class="name"><?php echo $value->name; ?></div>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </form>
                            <form action="" method="POST"
                                id="frmCreateCollection_<?php echo $item->not_id . $random; ?>">
                                <div class="bosuutap-taomoi" id="bosuutap-taomoi_<?php echo $item->not_id . $random; ?>"
                                    style="display:none">
                                    <div class="nhap-ten">
                                        <div class="photo">
                                            <img onerror="error_image(this)" src="<?=$avatar_bst_tin?>"
                                                alt=""/>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="name_col" placeholder="Nhập tên Bộ sưu tập">
                                        </div>
                                    </div>
                                    <div class="input">
                                        <input type="checkbox" name="name_notpublic" value="check" checked><label>Bí mật</label>
                                    </div>
                                    <div class="nut-xacnhan buttons-group">
                                        <!-- <button class="btn-bg-white">Hủy</button> -->
                                        <button type="submit" class="btn-bg-gray">Tạo</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="info-product">
            <div class="descrip js-viewport-get" id="detail_content_<?=$item->not_id?>" data-new_id="<?php echo $item->not_id; ?>">
                <div class="txt">
                    <?php if($item->not_title){ ?>
                        <strong><?php echo $item->not_title . ($item->not_detail ? ": " : "") ?></strong><?php echo $item->not_detail; ?>
                    <?php }else{
                        echo $item->not_detail ;
                    } ?>
                    <?php if ($flag_show_more == true && $flag_process_string == true) { ?>
                        <span class="seemore <?=$js_name_show.'_'.$item->not_id?>"><span>...&nbsp;</span>Xem thêm</span>
                    <?php } else if($flag_show_more == false && $js_name_show == 'js-redirect-content'){ ?>
                        <span class="seemore <?=$js_name_show.'_'.$item->not_id?>"><span>...&nbsp;</span>Xem tiếp</span>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if(!empty($item->sho_id) && $item->sho_id > 0 && !empty($item->not_additional) && $item->not_additional != "") {
            $this->load->view('home/tintuc/elements/item-icon-homepage', [
                "not_additionals" => json_decode($item->not_additional, true),
                "dir_add" => $item->not_dir_image,
                "id_add_json" => $item->not_id,
                "link_add_detail" => $item_link
            ], FALSE);
        } ?>
    </div>

    <?php if (!empty($item->listPro)){ ?>
        <div class="flash-sale">
            <?php if (count($item->listPro) > 1) { ?>
                <span class="flash-sale-pagingInfo" id="flash-sale-pagingInfo_<?php echo $item->not_id . $random; ?>"></span>
            <?php } ?>
            <div class="slider flash-sale-slider" id="flash-sale-slider_<?php echo $item->not_id . $random; ?>">
                <?php
                foreach ($item->listPro as $k => $value) {
                    $linktoproduct = $azibai_url . '/' . $value->pro_category . '/' . $value->pro_id . '/' . RemoveSign($value->pro_name) . $afkey;
                    
                    if ($is_fsale = ($value->pro_saleoff == 1 && $value->end_date_sale != '' && $value->end_date_sale > strtotime(date("Y-m-d")))) {
                        $is_fsale = true;
                    }

                    echo $this->load->view('home/common/product/item_flash_sale', [
                        'product'     => $value,
                        'content' => $item,
                        'group_id'  => $group_id,
                        'user_id'   => $user_id,
                        'afkey'     => $afkey,
                        'k'         => $k,
                        'is_fsale'         => $is_fsale,
                        'slider_pro'         => true,
                        'idFlash' => $item->not_id . $random . $k
                    ]);
                    ?>

                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <script>
        slider(<?php echo $item->not_id . $random;?>);
        slider_fs(<?php echo $item->not_id . $random;?>);
        <?php if(count($item->not_customlink) > 2 && !$class_no_image_video) { ?>
            load_slider_sharelink(<?php echo $item->not_id . $random;?>);
        <?php } ?>
        <?php if(count($item->not_customlink) > 1 && $class_no_image_video) { ?>
            load_slider_sharelink_v2(<?php echo $item->not_id . $random;?>);
        <?php } ?>
        <?php if (count($item->listPro) > 0) {
        foreach ($item->listPro as $k => $value) {
            if($value->pro_saleoff == 1 && $value->end_date_sale != '' && $value->end_date_sale >= time() && $value->begin_date_sale <= time()) {?>
                cd_time(<?php echo $value->end_date_sale * 1000; ?>,<?php echo $item->not_id . $random . $k?>);
        <?php }}} ?>
        <?php if ($item->not_video_url1) { ?>
            metadata_detect('video_<?php echo $item->not_id;?>');
        <?php } ?>

        function show(element) {
            element.attr('controls', '');
        }

        function hide(element) {
            var isPlaying = false;
            if (!$('#video_<?php echo $item->not_id; ?>').get(0).paused) {
                isPlaying = true;
            }
            if (!isPlaying) {
                element.removeAttr('controls');
            }
        }

        
        $(document).on('mouseover','#video_<?php echo $item->not_id; ?>', function() {
            var element = $(this);
            show(element);
        });
        $(document).on('mouseleave','#video_<?php echo $item->not_id; ?>', function() {
            var element = $(this);
            show(element);
        });

        ///////////////bo suu tap
        function bookmark_oc(id) {
            $('body').on('', '#bookmark-button_' + id, function () {
                if (!$(this).hasClass('opening')) {
                    var opening = $('body').find('.opening');
                    $.each(opening, function (index, value) {
                        $(this).removeClass('opening');
                        $(this).parents('.action').find('.show-more').slideUp();
                    });
                }
                $(this).toggleClass('opening');
                if ($(this).hasClass('opening')) {
                    $(this).next().slideDown();
                } else {
                    $(this).next().slideUp();
                }
            });
            ///////////////////////////////////////
            $('#bookmark-button_' + id).toggleClass('opening');
            var parent = $('#bookmark-button_' + id).closest('.action-right');
            if ($('#bookmark-button_' + id).hasClass('opening')) {
                parent.find('.bosuutap-show-action').slideDown();
            } else {
                parent.find('.bosuutap-show-action').slideUp();
            }
        }

        $('.bosuutap-show-action #tit_<?php echo $item->not_id . $random; ?>').click(function () {
            $(this).toggleClass('opened');
            if ($(this).hasClass('opened')) {
                $(this).next().slideDown(function () {
                    $('.bosuutap-show-action #tit_<?php echo $item->not_id . $random; ?> span').text('Tạo bộ sưu tập mới');
                    $('#bosuutap-taomoi_<?php echo $item->not_id . $random; ?>').slideUp();
                });
            } else {
                $(this).next().slideUp(function () {
                    $('.bosuutap-show-action #tit_<?php echo $item->not_id . $random; ?> span').text('Bộ sưu tập hiện có');
                    $('#bosuutap-taomoi_<?php echo $item->not_id . $random; ?>').slideDown();
                });
            }
        });

        $("#frmCreateCollection_<?php echo $item->not_id . $random; ?>").on('submit', (function (e) {
            e.preventDefault();
            $('.bosuutap-show-action #tit_<?php echo $item->not_id . $random; ?>').next().slideDown(function () {
                $('.bosuutap-show-action #tit_<?php echo $item->not_id . $random; ?> span').text('Tạo bộ sưu tập mới');
                $('#bosuutap-taomoi_<?php echo $item->not_id . $random; ?>').slideUp();
            });

            var typeReturn = 0; // 0: xài ở trang chủ, 1: xài ở chi tiết bộ sưu tập
            var typeCollection = 1; // 1: content, 2: product, 3:link
            var data = $(this).serialize()
                + '&' +
                $.param({
                    'avatar': '<?php echo $avatar_bst_tin; ?>',
                    'avatar_path': '<?php echo $avatar_bst_tin_path; ?>',
                    'dir': '<?php echo $item->not_dir_image;?>',
                    'typeReturn': typeReturn,
                    'typeCollection': typeCollection
                });
            $.ajax({
                url: "collection/ajax_createCollection",
                type: "POST",
                data: data,
                success: function (response) {
                    $('input[name=name_col').val('');
                    $(".bosuutap-danhsach-hientai").append(response);
                    $('.bosuutap-show-action #tit_<?php echo $item->not_id . $random; ?>').toggleClass('opened');
                    $(".save-collection").show();
                }
            });
        }));

        $("#frmCreateCollectionContent_<?php echo $item->not_id . $random; ?>").on('submit', (function (e) {
            e.preventDefault();
            var typeCollection = 1;
            var data = $(this).serialize();
            $.ajax({
                url: "collection/ajax_createCollectionContent/<?php echo $item->not_id;?>/" + typeCollection,
                type: "POST",
                data: data,
                success: function (response) {
                    if(response >= 0 && response != 'error') {
                        if (response > 0) {
                            $('#icon-img_<?php echo $item->not_id . $random; ?>').attr('src', '/templates/home/styles/images/svg/bookmark_gray.svg');
                        } else {
                            $('#icon-img_<?php echo $item->not_id . $random; ?>').attr('src', '/templates/home/styles/images/svg/bookmark.svg');
                        }
                        $('#bookmark-button_<?php echo $item->not_id . $random; ?>').removeClass('opening');
                        var parent = $('#bookmark-button_<?php echo $item->not_id . $random; ?>').closest('.action-right');
                        parent.find('.bosuutap-show-action').slideUp();
                    } else {
                        alert("errors.");
                    }
                }
            });
        }));
    </script>
</div>
<?php if (!empty($item->goiy)) {
    echo $item->goiy; ?>
    <script>
        load_goiy(<?php echo $item->not_id; ?>)
    </script>
<?php } ?>

<script>
    // $js_name_show = 'js-show-more';
    // $js_name_show = 'js-redirect-content';
    $('body').on('click','.js-redirect-content_<?=$item->not_id?>', function () {
        window.location.href = '<?=$item_link?>';
    })
    $('body').on('click','.js-show-more_<?=$item->not_id?>', function () {
        var title = <?php echo json_encode(htmlspecialchars($data_title_raw))?>;
        var detail = <?=json_encode($data_detail_raw)?>;
        var html = '<div>';
            html += '<a href="<?=$item_link?>">'
            html += '<strong>'+title+'</strong>';
            html += ' '+detail;
            html += '</a>'
            html += '</div>';
            // html += '<span class="seemore <?='js-redirect-content_'.$item->not_id?>"><span>...&nbsp;</span>Xem tiếp</span>';
        $('#detail_content_<?=$item->not_id?>').html(html);
    });
</script>