<?php
$user_login = MY_Loader::$static_data['hook_user'];

$data_og = [];
$url_javascript = $azibai_url = azibai_url();
$domain_use = $azibai_url;
$no_slider = false;
$style_link = false;
$show_vol = true;
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$flag_process_string = false;
$user_id  = (int)$this->session->userdata('sessionUser');
$group_id = (int)$this->session->userdata('sessionGroup');

( ( empty($content->listImg) || !$content->not_video_url1 ) || empty($content->sho_id) ) ? $no_slider = true : $no_slider = false;
( ( empty($content->listImg) && !$content->not_video_url1 ) ) ? $style_link = true : $style_link = false;

if (stripos($ua, 'ipod') !== false || stripos($ua, 'iphone') !== false || stripos($ua, 'ipad') !== false) {
  $show_vol = false;
}

$data_show = [
  'content_link' => $azibai_url . '/tintuc/detail/' . $content->not_id . '/' . RemoveSign($content->not_title),
];

//shop
if(!empty($content->sho_id) && !empty($content->not_user)){
  $domain_use = shop_url($content);
  $data_show['owner_name'] = $content->sho_name;
  $data_show['owner_link'] = shop_url($content);
  if (!empty($content->sho_logo)) {
    $data_show['owner_logo'] = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $content->sho_dir_logo . '/' . $content->sho_logo;
  }
  $data_og = [
    'ogtitle' => $content->not_title,
    'ogdescription' => $content->not_description,
    'ogtype' => 'article',
  ];
}

//user
if(empty($content->sho_id) && !empty($content->not_user)){
  $domain_use = $azibai_url . '/profile/' . $content->not_user;
  $data_show['owner_name'] = $content->use_fullname;
  $data_show['owner_link'] = $azibai_url . '/profile/' . $content->not_user;
  if (!empty($content->avatar)) {
    $data_show['owner_logo'] = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $content->use_id . '/' .  $content->avatar;
  }
  $data_og = [
    'ogtitle' => $content->use_fullname . !empty($content->not_title ? ' - ' . $content->not_title : '' ),
    'ogdescription' => $content->not_description,
    'ogtype' => 'article',
  ];
}
// ------------------------------------------------------------------------
$title_shr = $content->use_fullname;
if($content->not_detail != ''){
    $title_shr .= ' - '.cut_string_unicodeutf8(strip_tags(html_entity_decode($content->not_detail)), 225);
}
if($content->sho_id){ $title_shr = $content->not_title;}

// $title_shr = convert_percent_encoding($title_shr);
// ------------------------------------------------------------------------
$allow_tag = '';
if(!empty($content->mentions)) {
  foreach ($content->mentions as $key => $mention) {
    $allow_tag .= "<{$mention->user_id}>";
  }
}
$flag_process_string   = false;
$data_title_process = $data_title_raw = trim($content->not_title);
$data_detail_raw = nl2br(strip_tags(trim($content->not_detail),$allow_tag));
$data_detail_process = strip_tags(trim($content->not_detail));
$String_data = $data_title_process . ' ' . $data_detail_process;
if($data_title_process == ''){
    $String_data = $data_detail_process;
}
$chars = preg_split('//u', $String_data, null, PREG_SPLIT_NO_EMPTY);
$chars_title = preg_split('//u', $data_title_process, null, PREG_SPLIT_NO_EMPTY);

if ($isMobile == 0) {
  if(count($chars) > $number_max = 150) {
      $offset = (count($chars_title) > 0 ? (count($chars_title) ) : 0 );
      $new_string = array_slice($chars, $offset, 150 - count($chars_title));
      $content->not_detail = implode('', $new_string);
      $flag_process_string = true;
  }
}

if ($isMobile == 1) {
  if(count($chars) > $number_max = 80) {
      $offset = (count($chars_title) > 0 ? (count($chars_title) ) : 0 );
      if(count($chars_title) > 80) {
        $new_string = array_slice($chars_title, $offset , count($chars_title));
      } else {
        $new_string = array_slice($chars, $offset , 80 - count($chars_title));
      }
      $content->not_detail = implode('', $new_string);
      $flag_process_string = true;
  }
}

// Xử lý gắn mentions
$mentions = $content->mentions;
if(!empty($mentions)) {
  $string_old = $content->not_detail;
  foreach ($mentions as $key => $mention) {
    $str_find = "<{$mention->user_id}>";
    $str_replace = "<a href='{$mention->link_website}'>@{$mention->full_name}</a>";
    $data_detail_raw = str_replace($str_find, $str_replace, $data_detail_raw);
    if(preg_match("/{$str_find}/i", $content->not_detail)) { // kiểm tra chuỗi sau khi cắt có user nếu có
      $content->not_detail = str_replace($str_find, $str_replace, $content->not_detail);
    } else if(!preg_match("/{$str_find}/i", $content->not_detail) && $flag_process_string = true) {
      // có xử lý chuổi và ko tìm thấy text cần preplace
      // nếu ko có => mention ở chuỗi sau xữ lý đã bị mất 1 đoạn VD: <12345> => <1234
      // dựa vào start và end của mention, độ dài ký tự tối đa nằm trong khoản [start,end]
      if($mention->start <= $number_max && $number_max <= $mention->end) {
        $text_lost = substr($string_old, $mention->start, strlen($mention->user_id) + 2); // text bị cắt lỗi
        $temp = explode(' ', $content->not_detail);
        $temp[count($temp)-1] = $str_replace;
        $content->not_detail = implode(' ', $temp);
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
    $content->not_detail = str_replace($str_find, $str_replace, $content->not_detail);
  }
}


$js_name_show = '';
$flag_show_more = false;
if( (!empty($content->not_customlink) && empty($content->listImg) && empty($content->not_video_url1))
  || (empty($content->not_customlink) && !empty($content->listImg) && count($content->listImg) == 1 && empty($content->not_video_url1))
  || (empty($content->not_customlink) && empty($content->listImg) && !empty($content->not_video_url1)) )
  {
    if($flag_process_string == true) {
      $flag_show_more = true;
    }
    $js_name_show = 'js-show-more';
  }
  else {
    $js_name_show = 'js-redirect-content';
  }

$url_redirect = azibai_url();
if(isset($_REQUEST['redirect']) && filter_var($_REQUEST['redirect'], FILTER_VALIDATE_URL)) {
  $url_redirect = $_REQUEST['redirect'];
}
$url_process = $url_redirect;
$redirect = '';

$check_http = explode(':', $url_process)[0];
  if($check_http == 'http' || $check_http == 'https'){
    $redirect = $check_http.'://';
  }
$params_url = explode('/', explode(':', $url_process)[1]);
$params_url = [
  'domain' => $params_url[2],
  'profile' => $params_url[3],
  'proid' => $params_url[4],
];
if( count(explode('.',$params_url['domain'])) == 3 || (count(explode('.',$params_url['domain'])) == 2 && azibai_url() != $redirect.$params_url['domain']) ) {
  // doanh nghiệp
  $redirect .= $params_url['domain'];
} else if ($params_url['profile'] == 'profile' && is_numeric((int)$params_url['proid'])) {
  // ca nhân
  $redirect .= $params_url['domain'] . '/' . $params_url['profile'] . '/' . $params_url['proid'];
} else {
  // trang chủ
  $redirect = azibai_url();
}
// ------------------------------------------------------------------------
// background image
if(!empty($content->listImg)) {
  $data_og['ogimage'] = $image_background = DOMAIN_CLOUDSERVER . 'media/images/content/' . $content->not_dir_image . '/' . $content->listImg[0]->image;
} else if($content->not_video_url1) {
  $data_og['ogimage'] = $image_background = $content->poster;
} else if(!empty($content->not_customlink)) {
  $aLink = $content->not_customlink[0];
  $data_og['ogimage'] = $image_background = $aLink['link_image'];
  if($aLink['image']){
    $data_og['ogimage'] = $image_background = $this->config->item('library_link_config')['cloud_server_show_path'] . '/' . $aLink['image'];
  }
} else {
  $image_background = azibai_url() . '/templates/home/styles/images/default/error_image_400x400.jpg';
}

if(!empty($content->og_image)){
  $data_og['ogimage'] = $content->og_image;
}

$actual_link = get_current_full_url();
$url_javascript = $domain_share = get_current_base_url($actual_link);
if($domain_share === azibai_url() && strpos($actual_link, '/profile') !== false) {
  $domain_share .= '/profile/' . $content->not_user;
  $data_show['content_link'] = $domain_share . '/news/detail/' . $content->not_id . '/' . RemoveSign($content->not_title);
} else if($domain_share !== azibai_url()) {
  $data_show['content_link'] = $domain_share . '/news/detail/' . $content->not_id . '/' . RemoveSign($content->not_title);
}
$data_og['ogurl'] = $domain_share.'/share-content-page/'.$content->not_id;

// ------------------------------------------------------------------------
// data share
// dd($data_og);die;
// ------------------------------------------------------------------------
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php echo (isset($data_og['ogtitle'])) ? htmlspecialchars(str_replace("<br>", " ", $data_og['ogtitle'])) : settingTitle; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="google-site-verification" content="Cxcxfz0Wn9LQGLgWXQ0cRQu61dZGZ-LFyups_lTM4O8" />
	<meta name="revisit-after" content="1 days"/>
	<meta name="description" content="<?php echo $data_og['ogdescription'] ?>"/>
	<meta name="keywords" content="<?php echo isset($keywordSiteGlobal) && $keywordSiteGlobal ? str_replace(',', ' |', $keywordSiteGlobal) : settingKeyword; ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta name="og_url" property="og:url" content="<?php echo (isset($data_og['ogurl']) ? $data_og['ogurl'] : ''); ?>"/>
	<meta name="og_type" property="og:type" content="<?php echo (isset($data_og['ogtype'])) ? $data_og['ogtype'] : ''; ?>"/>
	<meta name="og_title" property="og:title" content="<?php echo htmlspecialchars(str_replace("<br>", " ", $data_og['ogtitle'])) ?>"/>
	<meta name="og_description" property="og:description" content="<?php echo $data_og['ogdescription'] ?>"/>
	
  <meta name="og_image" property="og:image" content="<?php  echo isset($data_og['ogimage']) && $data_og['ogimage'] ? $data_og['ogimage'] : ((getAliasDomain() != '') ? getAliasDomain() . 'templates/home/images/logoshare.png' : site_url('templates/home/images/logoshare.png')); ?>"/>
	<meta name="og_image_alt" property="og:image:alt" content="<?php echo htmlspecialchars(str_replace("<br>", " ", $data_og['ogtitle'])) ?>"/>
	<meta property="og:image:secure_url" content="<?php echo isset($data_og['ogimage']) && $data_og['ogimage'] ? $data_og['ogimage'] : ((getAliasDomain() != '') ? getAliasDomain().'templates/home/images/logoshare.png' : site_url('templates/home/images/logoshare.png')); ?>" /> 
  <meta property="og:image:width" content="1500" />  
  <meta property="og:image:height" content="1500" />
  <meta name="fb_app_id" property="fb:app_id" content="<?php echo app_id ?>" />

  <?php if (!empty($isMobile) && $isMobile == 1) { ?>
    <meta property="al:android:url" content="sharesample://store/apps/details?id=com.azibai.android">
    <meta property="al:android:package" content="com.azibai.android">
    <meta property="al:android:app_name" content="Azibai">	
    <meta property="al:ios:url" content="https://azibai.com" />
    <meta property="al:ios:app_name" content="azibai" />
    <meta property="al:ios:app_store_id" content="1284773842" />
    <meta property="al:web:should_f" allback content="false"/>
	<?php } ?>
  <!--[if IE]><meta http-equiv="cleartype" content="on"><![endif]-->

  <style>
    #darkroom-icons {
      top: 0;
    }
  </style>

  <!-- CSS -->
  <link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap.css">
	<link rel="stylesheet" href="/templates/home/styles/css/reset.css">
	<link rel="stylesheet" href="/templates/home/styles/css/base.css">
	<link rel="stylesheet" href="/templates/home/styles/css/top.css">
	<link rel="stylesheet" href="/templates/home/styles/css/supperDefault.css">
	<link rel="stylesheet" href="/templates/home/styles/css/slick.css">
	<link rel="stylesheet" href="/templates/home/styles/css/slick-theme.css">
  <link rel="stylesheet" href="/templates/home/css/comment.css">

  <link rel="stylesheet" href="/templates/home/styles/css/content.css">
  <link rel="stylesheet" href="/templates/home/styles/css/modal-show-details.css">
	<link rel="stylesheet" href="/templates/home/styles/css/mixin.css">
	<link rel="stylesheet" href="/templates/home/styles/css/variable.css">
	<link rel="stylesheet" href="/templates/home/styles/css/additions.css">
	<link rel="stylesheet" href="/templates/home/css/new-detail.css">

	<link rel="stylesheet" href="/templates/home/js/jAlert-master/jAlert-v3.css">

	<link rel="stylesheet" href="/templates/home/css/default.css">
  <link rel="stylesheet" href="/templates/home/styles/css/cart.css">
  <link href="https://fonts.googleapis.com/css?family=KoHo:400,500,700" rel="stylesheet">
  <link rel="stylesheet" href="/templates/home/styles/font/font-awesome-4.7.0/css/font-awesome.css">
  <!-- JS -->

  <script src="/templates/home/styles/plugins/jquery.min.js"></script>
  <script src="/templates/home/styles/plugins/boostrap/js/bootstrap.min.js"></script>
  <script src="/templates/home/styles/plugins/boostrap/js/popper.min.js"></script>
  <script src="/templates/home/styles/js/common.js"></script>
  <script src="/templates/home/js/general_ver2.js"></script>
  <script src="/templates/home/styles/js/slick.js"></script>
  <script src="/templates/home/styles/js/slick-slider.js"></script>
  <script src="/templates/home/styles/js/countdown.js"></script>
  <script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
  <script src="/templates/home/styles/js/fixed_sidebar.js"></script>
  <script src="/templates/home/js/text.min.js?ver=<?=time();?>" type="text/javascript"></script>
  <script src="/templates/home/styles/js/shop/shop-news.js"></script>
  <script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.js"></script>

</head>
<style type="text/css">
  .btn.btn-follow {
    display: flex;
    font-weight: bold;
  }

  .btn.btn-follow img {
      margin-right: 5px;
  }
</style>
<body class="bg-post-shared">
  <div class="wrapper">
    <main>
      <section class="main-content">
        <div class="container">
          <div class="row justify-content-center sm-padding-none">
            <div class="content bg-black-shadow">
              <div class="bg-image-blur-main" style="background: url('<?=$image_background?>');"></div>
              <div class="content-posts">
                <div class="post js_item-detect-video-action">
                  <div class="post-button">
                    <a href="javascript:void(0)" class="btn-chitiettin back js-close-redirect" data-dismiss="modal"><i class="fa fa-angle-left f16 mr05" aria-hidden="true"></i>&nbsp;Đóng</a>
                    <a href="<?=$data_show['content_link']?>" class="btn-chitiettin">Chi tiết tin <i class="fa fa-angle-right f16 ml05" aria-hidden="true"></i></a>
                  </div>
                  <div class="post-head">
                    <div class="post-head-name">
                      <div class="avata">
                        <a class="shop_avatar_link" href="<?=$data_show['owner_link']?>">
                          <img onerror="error_image(this)" src="<?=$data_show['owner_logo']?>" alt="<?=$data_show['owner_name']?>">
                        </a>
                      </div>
                      <div class="title two-lines">
                        <a class="one-line" href="<?=$data_show['owner_link']?>"><?=$data_show['owner_name']?></a>
                        <span><?=date('d/m/Y',$content->not_begindate)?></span>
                        <span>
                          <!-- <img class="mr10 ml20 mt05" src="/templates/home/styles/images/svg/quadiacau_white.svg" width="14" alt=""> -->
                        </span>
                        <span class="pl10">
                          <!-- <img class="mt05" src="/templates/home/styles/images/svg/eye_white.svg" width="16" alt="">&nbsp;<?=$content->not_view?></span> -->
                      </div>
                    </div>
                    <!-- <div class="post-head-more">
                      <span class="js-close-redirect">
                        <img src="/templates/home/styles/images/svg/close_white02.svg">
                      </span>
                    </div> -->
                  </div>
                  <div class="post-detail trangcuatoi item-element-parent">
                    <?php
                    // show doanh nghiep || show cá nhân nếu có video và không có ảnh
                    if ( ($content->not_video_url1 && !empty($content->sho_id)) || (empty($content->sho_id) && $content->not_video_url1 && empty($content->listImg)) ) {
                      $this->load->view('home/tintuc/elements/item-video', ['show_vol' => $show_vol, 'data_name' => $title_shr, 'data_value' => $data_show['content_link'], 'item' => $content]);
                    } ?>
                    <div class="list-slider" data-id="<?=$content->not_id?>">
                      <?php if (!empty($content->listImg)) { ?>
                        <span class="pagingInfo button-gray" id="pagingInfo_<?=$content->not_id?>"></span>
                      <?php } ?>
                      <?php if (!empty($content->not_customlink) && $no_slider == false) { ?>
                        <span class="open-close-link button-gray" 
                          id="open-close-link_<?=$content->not_id?>"
                          onclick="slider_sharelink(<?=$content->not_id?>)">
                          <img src="/templates/home/styles/images/svg/link.svg" alt="" class="mr05">
                          <span class="text">Mở liên kết</span>
                        </span>
                      <?php } ?>

                      <?php if (!empty($content->listImg)) { ?>
                      <ul class="slider slider-for" id="slider-for_<?=$content->not_id?>" data-id="<?=$content->not_id?>">
                        <?php if ($content->not_video_url1 && empty($content->sho_id)) {
                          echo '<li>';
                          $this->load->view('home/tintuc/elements/item-video', ['show_vol' => $show_vol, 'data_name' => $title_shr, 'data_value' => $data_show['content_link'], 'item' => $content]);
                          echo '</li>';
                        } ?>
                        <?php foreach ($content->listImg as $key => $value) { ?>
                          <?php
                          if (isset($value->img_type) && $value->img_type == 'image/gif') {
                            $image_url = DOMAIN_CLOUDSERVER . 'media/images/content/' . $content->not_dir_image . '/' . $value->image;
                          } else {
                            $image_url = DOMAIN_CLOUDSERVER . 'media/images/content/' . $content->not_dir_image . '/' . $value->image;
                          }
                          $oImageOption = json_decode($value->style);
                          // Lấy chữ trên hình
                          $text_images = (array) @$oImageOption->text_list;
                          $title_alt = ($value->title) ? $value->title : $content->not_title;
                          ?>
                          <li class="position-tag">
                            <img data-lazy="<?php echo $image_url ?>" id="image_<?= $value->id; ?>"
                                  donerror="error_image(this)"
                                  class="popup-detail-image"
                                  data-news-id="<?php echo $content->not_id ?>"
                                  data-id="<?= $value->id; ?>"
                                  data-key="<?php echo $key; ?>"
                                  data-ori="<?= @$value->orientation?>"
                                  src="/templates/home/styles/images/default/error_image_400x400.jpg"
                                  alt="<?php echo str_replace('"', "", $title_alt) ?>"
                                  title="<?php echo str_replace('"', "", $title_alt) ?>"
                                  data-name="<?php echo str_replace('"', '%22', $title_shr); ?>" data-value="<?php echo $data_show['content_link']; ?>">
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
                                 data-parent="<?php echo $content->not_id . $random; ?>"
                                 data-url="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $content->not_dir_image . '/' . $value->image ?>"
                                 data-tags="<?php echo $value->tags && gettype($value->tags) === 'string' ? htmlspecialchars($value->tags) : '{}'; ?>"
                                 data-news-id="<?php echo $content->not_id ?>" data-key="<?php echo $key; ?>"
                                 data-name="<?php echo str_replace('"', '%22', $title_shr); ?>" data-value="<?php echo $data_show['content_link']; ?>">
                                <img src="<?php echo $content->root_url . '/templates/home/icons/boxaddnew/tag.svg'; ?>"
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
                      <?php } ?>
                      <?php if (!empty($content->not_customlink)) { ?>
                      <div class="addlinkthem version01
                        <?=$style_link == true ? 'version02' : ''?>
                        <?=$no_slider == true ? 'no-slider-for no-slider-for-add-border' : ''?>"
                        id="addlinkthem">
                        <ul class="slider addlinkthem-slider <?=count($content->not_customlink) == 1 ? 'one-slider' : (count($content->not_customlink) == 2 ? 'two-sliders' : 'three-sliders');?>" id="addlinkthem-slider_<?=$content->not_id?>">
                          <?php foreach ($content->not_customlink as $kLink => $link_v2) {
                            $this->load->view('home/tintuc/item-link-v2', [
                              'link_v2'    => $link_v2,
                              'domain_use' => $domain_use,
                              'user_login' => $user_login
                            ]);
                           } ?>
                        </ul>
                      </div>
                      <?php } ?>
                    </div>
                    <?php
                    $style_bar = $style_iconlike = $style_iconcomment = $style_iconshare = 'display: none;';
                    if(($content->likes > 0) || (isset($numcomment) && $numcomment > 0) || (isset($numshare) && $numshare > 0))
                    {
                        $style_bar = '';
                        if($content->likes > 0)
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
                    <div class="bg-gray-blue">
                      <div class="show-number-action version01 js-countact-content-<?=$content->not_id;?>" style="<?php echo $style_bar; ?>">
                        <ul>
                          <?php
                          $show_video = '';
                          $numlike = 0;
                          if(!empty($content->likes)){
                            $show_video = ' js-show-like';
                            $numlike = $content->likes;
                          }
                          ?>
                          <li class="list-like-js-<?=$content->not_id;?><?=$show_video;?> cursor-pointer" data-id="<?=$content->not_id; ?>" style="<?php echo $style_iconlike; ?>">
                            <img src="/templates/home/styles/images/svg/liked.svg" class="mr05" alt=""><span class="js-count-like-<?php echo $content->not_id; ?>"><?=$content->likes?></span></li>
                          <li class="cursor-pointer" style="<?php echo $style_iconcomment; ?>">0 bình luận</span>
                          </li>
                          <li class="cursor-pointer" style="<?php echo $style_iconshare; ?>">0 chia sẻ</span>
                          </li>
                        </ul>
                      </div>
                      <div class="action">
                        <div class="action-left">
                          <ul class="action-left-listaction version01">
                            <li class="like js-like-content js-like-content-<?=$content->not_id; ?> cursor-pointer"
                              data-id="<?=$content->not_id; ?>">
                              <img class="icon-img" src="/templates/home/styles/images/svg/<?=$content->is_like ? 'like_pink.svg' : 'like_white.svg'?>" alt="like"
                                data-like-icon="/templates/home/styles/images/svg/like_pink.svg"
                                data-notlike-icon="/templates/home/styles/images/svg/like_white.svg">
                              <span class="md"><?=$content->is_like ? 'Bỏ thích' : 'Thích'?></span>
                            </li>
                            <li class="comment cursor-pointer">
                              <img class="icon-img" src="/templates/home/styles/images/svg/comment_white.svg" alt="comment">
                              <span class="md">Bình luận</span>
                            </li>

                            <?php
                            $data_share = [
                              'layout_share' => 'content',
                              'data_name' => convert_percent_encoding($title_shr),
                              'data_value' => $domain_share.'/share-content-page/'.$content->not_id,
                              'data_type' => @$content->type_share,
                              'data_item_id' => $content->not_id,
                              'data_permission' => ($this->session->userdata('sessionUser') == $content->not_user) ? 1 : '',
                              'data_detail' => $domain_share.'/share-content-page/'.$content->not_id,
                              'src_image' => '/templates/home/styles/images/svg/share_01_white.svg'
                            ];
                            $this->load->view('home/share/bar-btn-share', array('data_share' => $data_share));
                            ?>

                            <!-- <li>
                              <img class="icon-img" src="/templates/home/styles/images/svg/bookmark_white.svg" alt="share">
                              <span class="md">Lưu</span>
                            </li> -->
                          </ul>
                        </div>
                      </div>
                      <div class="info-product version01">
                        <div class="descrip" id="detail_content_<?php echo $content->not_id; ?>" data-new_id="<?php echo $content->not_id; ?>">
                          <?php if($content->not_title){ ?>
                            <div class="txt">
                              <strong><?php echo $content->not_title . ": " ?></strong><?php echo $content->not_detail; ?></div>
                          <?php }else{
                              echo $content->not_detail ;
                          } ?>
                          <?php if ($flag_show_more == true) { ?>
                              <span class="seemore <?=$js_name_show?>"><span>...&nbsp;</span>Xem thêm</span>
                          <?php } else if($flag_show_more == false && $flag_process_string == true){ ?>
                              <span class="seemore <?=$js_name_show?>"><span>...&nbsp;</span>Xem tiếp</span>
                          <?php } ?>
                          <!-- <div class="hagtag">
                            <a href="">@abc</a>
                            <a href="">#abc</a>
                          </div> -->
                        </div>
                      </div>
                      <?php if(!empty($content->sho_id) && $content->sho_id > 0 && !empty($content->not_additional) && $content->not_additional != "") {
                          $this->load->view('home/tintuc/elements/item-icon-homepage', [
                              "not_additionals" => json_decode($content->not_additional, true),
                              "dir_add" => $content->not_dir_image,
                              "id_add_json" => $content->not_id,
                              "link_add" => $item_link,
                          ], FALSE);
                      } ?>
                    </div>
                  </div> 

                  <?php if (!empty($content->listPro)) { ?>
                  <div class="flash-sale version01">
                    <?php if (count($content->listPro) > 1) { ?>
                      <span class="flash-sale-pagingInfo" id="flash-sale-pagingInfo_<?=$content->not_id?>"></span>
                    <?php } ?>

                    <div class="slider flash-sale-slider" id="flash-sale-slider_<?=$content->not_id?>">
                      <?php
                      $afkey = '';
                      if($af_id != '')
                      {
                        $afkey = '?af_id='.$af_id;
                      }
                      foreach ($content->listPro as $k => $value) {
                        $linktoproduct = azibai_url() . '/' . $value->pro_category . '/' . $value->pro_id . '/' . RemoveSign($value->pro_name);
                        if ($value->end_date_sale != '' && $value->end_date_sale > strtotime(date("Y-m-d"))) {
                          $is_fsale = true;
                        }
                        
                        echo $this->load->view('home/common/product/item_flash_sale', [
                            'product'     => $value,
                            'content' => $content,
                            'group_id'  => $group_id,
                            'user_id'   => $user_id,
                            'afkey'     => $afkey,
                            'k'         => $k,
                            'is_fsale'         => $is_fsale,
                            'slider_pro'         => true,
                            'idFlash' => $content->not_id . $random . $k
                        ]);
                      ?>

                      <?php } ?>
                    </div>
                  </div>
                  <?php } ?>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>

    </main>
    <!-- <footer id="footer"> </footer> -->
  </div>

  <script>
    var urlFile = siteUrl = '<?=$url_javascript?>/';
  </script>
  <?php
  $this->load->view('home/tintuc/popup-info-detail');
  // ------------------------------------------------------------------------
  // like
  $this->load->view('home/tintuc/popup/popup-list-like');
  $this->load->view('home/common/modal-mess');
  // ------------------------------------------------------------------------
  ?>
  <div class="temp-share">
    <?php
    // share
    $this->load->view('home/share/popup-btn-share');
    ?>
  </div>
  <!-- <script src="/templates/home/styles/js/share/share.js"></script> -->
  <?php
  // ------------------------------------------------------------------------
  ?>
  <?php $this->load->view('e-azibai/common/common-popup-af-commission'); ?>
 <script src="/templates/home/styles/js/commission-aft.js"></script>
  <script>
    // new logic
    jQuery(function ($) {
      // add video
      addvideo($('.video'),$('.video').attr('data-video'));

      jQuery(document).on('click', '.js_az-volume', function () {
        if (!$(this).hasClass('volume_on')) {
          $('#addlinkthem li.active').removeClass('active');
          $(this).closest('li').addClass('active');
          $(this).addClass("volume_on");
        } else {
          $(this).removeClass("volume_on");
        }
      });

      // load video
      $(document).on('click','.az-volume', function() {
        var element = $(this).closest('.video').find('video').attr('id');
        if($('#'+element).prop('muted')){
          $('.az-volume').attr("src", volume_btn_on);
          $('#'+element).prop('muted', false);
        } else {
          $('.az-volume').attr("src", volume_btn_off);
          $('#'+element).prop('muted', true);
        }
      });
      // video play tren slide anh
      if($('#slider-for_<?=$content->not_id?>').find('video').length > 0) {
        $('#slider-for_<?=$content->not_id?> video').trigger("play");
      }
      if($('div.video').find('video').length > 0) {
        $('div.video video').trigger("play");
      }

      // slide link lien ket
      for (var index = 0; index < $('#addlinkthem li.slick-active video').length; index++) {
        // $($('#addlinkthem li.slick-active video')[index]).prop('muted', false);
        $('#addlinkthem li.slick-active video').trigger("play");
        $($('#addlinkthem li.slick-active video').first()).closest('li').addClass('active');
      }

      $('#addlinkthem').on('beforeChange', function(event, slick, currentSlide, nextSlide){
        for (var index = 0; index < $('#addlinkthem li.slick-active video').length; index++) {
          if(index == 0) {
            $($('#addlinkthem li.slick-active video')[index]).prop('muted', true);
          }
          $('#addlinkthem li.slick-active video').trigger("pause");
          $('#addlinkthem li').removeClass('active');
        }
      });

      $('#addlinkthem').on('afterChange', function(event, slick, currentSlide, nextSlide){
        for (var index = 0; index < $('#addlinkthem li.slick-active video').length; index++) {
          <?php if(!$isiOS) { ?>
          if(index == 0) {
            $($('#addlinkthem li.slick-active video')[index]).prop('muted', false);
          }
          <?php } ?>
          $('#addlinkthem li.slick-active video').trigger("play");
          $($('#addlinkthem li.slick-active video').first()).closest('li').addClass('active');
        }
      });
    });

  </script>

  <script type="text/javascript">
    slider(<?=$content->not_id?>);
    slider_fs(<?=$content->not_id?>);

    <?php if(count($content->not_customlink) > 2 && $style_link == false) { ?>
      load_slider_sharelink(<?=$content->not_id . $random;?>);
    <?php } else if(count($content->not_customlink) > 1 && $style_link == true) { ?>
      load_slider_sharelink_v2(<?=$content->not_id?>);
    <?php } ?>

    <?php if (count($content->listPro) > 0) {
      foreach ($content->listPro as $k => $value) {
        if($value->pro_saleoff == 1 && $value->end_date_sale != '' && $value->end_date_sale >= time() && $value->begin_date_sale <= time()) {?>
          cd_time(<?php echo $value->end_date_sale * 1000; ?>,<?php echo $content->not_id . $random . $k?>);
      <?php }
      }
    } ?>

    <?php if ($content->not_video_url1) { ?>
      metadata_detect('video_<?=$content->not_id;?>');
    <?php } ?>

    function show(element) {
      element.attr('controls', '');
    }

    function hide(element) {
      var isPlaying = false;
      if (!$('#video_<?php echo $content->not_id; ?>').get(0).paused) {
        isPlaying = true;
      }
      if (!isPlaying) {
        element.removeAttr('controls');
      }

      $(document).on('mouseover','.video', function() {
        var element = $(this);
        show(element);
      });
      $(document).on('mouseleave','.video', function() {
        var element = $(this);
        show(element);
      });
    }

    $('.js-close-redirect').click(function() {
      window.location.href = '<?=$redirect?>';
    });
    $('.js-redirect-content').click(function(){
      window.location.href = '<?=$data_show['content_link']?>';
    });
    $('.js-show-more').click(function(){
      var new_id = $(this).parent('.descrip').data('new_id');
      var title = <?php echo json_encode(htmlspecialchars($data_title_raw))?>;
      var detail = <?=json_encode($data_detail_raw)?>;
      var html = '<div>';
          html += '<a href="<?=$data_show['content_link']?>">'
          html += '<strong>'+title+'</strong>';
          html += '<br/>'+detail;
          html += '</a>'
          html += '</div>';
          // html += '<span class="seemore js-redirect-content"><span>...&nbsp;</span>Xem tiếp</span>';
      $('#detail_content_'+new_id).html(html);
    });
  </script>

  <?php
  /*popup edit link*/
  if(!empty($user_login)){
    $this->load->view('shop/media/elements/library-links/popup-custom-link-create', [
        'sho_id'        => $user_login['my_shop']['sho_id'],
        'default_shop'  => false
    ]);
  }
  ?>

  <!--js edit link-->
  <script>
      var type_link_template = 'content_index';
  </script>
  <script src="/templates/home/styles/js/shop/shop-library-custom-link-v2.js"></script>
  <!--/end js edit link-->

</body>

</html>