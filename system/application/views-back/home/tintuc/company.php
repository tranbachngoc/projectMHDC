<?php
$this->load->view('home/common/header');
$group_id = (int) $this->session->userdata('sessionGroup');

if ($shop->domain) {
    $shopstore = 'http://' . $shop->domain;
} else {
    $shopstore = '//' . $_SERVER['HTTP_HOST'];
}
if ($shop->sho_facebook) {
    $face = explode("//www.facebook.com/", $shop->sho_facebook);
    $facebook_id = str_replace('profile.php?id=', '', $face[1]);
}
?>



<link href="/templates/home/lightgallery/dist/css/lightgallery.css" rel="stylesheet" type="text/css" />

<script>
    function submitSearchTintuc() {
        var keyword = document.getElementById('keyword').value;
        var url = '<?php echo base_url(); ?>tintuc/search/keyword/' + keyword;
        window.location = url;
        return true;
    }

    function submitenterQ(myfield, e, baseUrl) {
        var keycode;
        if (window.event)
            keycode = window.event.keyCode;
        else if (e)
            keycode = e.which;
        else
            return true;

        if (keycode == 13) {
            submitSearchTintuc();
            return false;
        } else
            return true;
    }
</script>

<div id="main" class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4 hidden-xs" style="padding-right:0">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-8">
            <div style="background: #fff; margin-bottom: 15px;">
                <div class="shop_banner" style="background-image: url(<?php echo base_url() . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner ?>);"></div>

                <div class="shop_logo text-center">
                    <div style="vertical-align: middle; display: table-cell; height: 100px">
                        <a href="<?php echo '/tintuc/company/' . $shop->sho_user . '/' . $shop->sho_link . '.html'; ?>">
                            <img src="<?php echo '/media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo; ?>"/>
                        </a>
                    </div>
                </div>

                <div class="shop_name text-center">
                    <h1><?php echo $shop->sho_name ?></h1>
                </div>

                <div class="" style="border-top: 1px solid #ddd;">
                    <ul class="menu-justified dropdown" style="font-size:16px;">
                        <?php if ($this->session->userdata('sessionUser') == $shop->sho_user && $group_id == 3) { ?>
                            <li class="">
                                <a href="<?php echo base_url() ?>account/news/add"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-edit.png" alt=""><br>Đăng tin</a>
                            </li>
                        <?php } ?>


                        <?php if ($this->session->userdata('sessionUser') == $shop->sho_user && $group_id == 2) { ?>
                            <li class="">
                                <a href="<?php echo $shop->domain ? '//' . $shop->domain : '//' . $shop->sho_link . '.' . $_SERVER['HTTP_HOST']; ?>">
                                    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-store.png" alt="">
                                    <br>Gian hàng
                                </a>
                            </li>
                        <?php } ?>


                        <li class="">
                            <a id="dLabel" data-target="#" href="<?php echo base_url() ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo base_url() ?>templates/home/icons/black/icon-hand.png" alt=""><br>Loại tin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: 0px; right:0px;">
                                <li><a href="<?php echo '/tintuc/company/' . $shop->sho_link . '/tin-hot/' ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-coupon.png" alt=""> &nbsp; Tin tức hot </a>
                                </li>
                                <li><a href="<?php echo '/tintuc/company/' . $shop->sho_link . '/khuyen-mai/' ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-gift.png" alt=""> &nbsp; Tin khuyến mãi </a>
                                </li>
                                <li><a href="<?php echo '/tintuc/company/' . $shop->sho_link . '/xem-nhieu/' ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/cubes.png" alt=""> &nbsp; Tin xem nhiều </a>
                                </li>
                                <?php if ($this->session->userdata('sessionUser') == $shop->sho_user) { ?>
                                    <li><a href="<?php echo '/tintuc/company/' . $shop->sho_link . '/tin-chon-ve/' ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-check.png" alt=""> &nbsp; Danh sách tin chọn về</a>
                                    </li>
                                    <li><a href="<?php echo '/tintuc/company/' . $shop->sho_link . '/tin-duoc-chon/' ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-list.png" alt=""> &nbsp; Danh sách tin được chọn</a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>


                        <?php if ($this->session->userdata('sessionUser') != $shop->sho_user) { ?>
                            <li class="">
                                <a href="tel:<?php echo $shop->sho_mobile ?>" onclick="_gaq.push(['_trackEvent', 'Contact', 'Call Now Button', 'Phone']);"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-call.png" alt=""><br>Gọi ngay</a>
                            </li>

                            <li class="">
                                <a target="_blank" href="https://www.messenger.com/t/<?php echo $facebook_id ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-comment.png" alt=""><br>Nhắn tin</a>
                            </li>
                        <?php } ?>

                        <li class="">
                            <a id="dLabel" data-target="#" href="<?php echo base_url() ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo base_url() ?>templates/home/icons/black/share-outline.png" alt=""><br>Chia sẻ
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: 0px; right:0px;">
                                <li>
                                    <div>
                                        <a href="javascript:void(0)" onclick="
                                                window.open(
                                                        'https://www.facebook.com/sharer/sharer.php?u=<?php echo current_url() ?>&amp;picture=<?php echo base_url() . 'media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo ?>&amp;title=<?php echo $shop->sho_name ?>&amp;description=<?php echo $shop->sho_descr ?>',
                                                        'facebook-share-dialog',
                                                        'width=800,height=600');
                                                return false;">
                                            <img src="<?php echo base_url() ?>templates/home/icons/icon-facebook.png" alt="">
                                        </a> &nbsp;
                                        <a href="javascript:void(0)" onclick="
                                                window.open(
                                                        'https://twitter.com/share?text=<?php echo $shop->sho_name ?>&amp;url=<?php echo current_url() ?>',
                                                        'twitter-share-dialog',
                                                        'width=800,height=600');
                                                return false;">
                                            <img src="<?php echo base_url() ?>templates/home/icons/icon-twitter.png" alt="">
                                        </a> &nbsp;
                                        <a href="javascript:void(0)" onclick="
                                                window.open(
                                                        'https://plus.google.com/share?url=<?php echo current_url() ?>',
                                                        'google-share-dialog',
                                                        'width=800,height=600');
                                                return false;">
                                            <img src="<?php echo base_url() ?>templates/home/icons/icon-google-plus.png" alt="">
                                        </a>
                                        <a href="mailto:someone@example.com?Subject=<?php echo $shop->sho_name; ?>&amp;Body=<?php echo $shop->sho_descr . '-' . current_url(); ?>" class="pull-right">
                                            <img src="<?php echo site_url('templates/home/icons/black/icon-email.png'); ?>" alt=""/>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" onclick="copylink('<?php echo base_url() . '/tintuc/company/' . $shop->sho_user . '/' . $shop->sho_link; ?>')">
                                        <img src="<?php echo base_url() ?>templates/home/icons/black/icon-coppy.png" alt=""> &nbsp;Sao chép liên kết
                                    </a>
                                </li>
                                <li><a href="#"><img src="<?php echo base_url() ?>templates/home/icons/black/share-outline.png" alt=""> &nbsp; Chia sẻ lên group</a>
                                </li>
                            </ul>
                        </li>


                        <?php if ($this->session->userdata('sessionUser') == $shop->sho_user && $group_id == 3) { ?>
                            <li class="">
                                <a id="dLabel" data-target="#" href="<?php echo base_url() ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-other.png" alt=""><br>Khác
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: 0px; right:0px;">
                                    <li><a href="#"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-bullhorn.png" alt=""> &nbsp; Quảng cáo trang</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
            </div>            

            <table class="table table-bordered" style="margin-bottom: 15px; background: #fff;">
                <tbody>
                    <tr>
                        <td colspan="2" class="text-center">
                            <strong>THÔNG TIN CÔNG TY</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" width="100">Mô tả</td>
                        <td>
                            <?php echo $shop->sho_descr ?></td>
                    </tr>
                    <tr>
                        <td align="left">Địa chỉ</td>
                        <td>
                            <?php echo $shop->sho_address . ', ' . $shop->sho_district ?></td>
                    </tr>
                    <tr>
                        <td align="left">Tỉnh/thành</td>
                        <td>
                            <?php echo $shop->sho_province ?></td>
                    </tr>
                    <tr>
                        <td align="left">Điện thoại</td>
                        <td>
                            <?php echo $shop->sho_phone ?></td>
                    </tr>
                    <tr>
                        <td align="left">Mobile</td>
                        <td>
                            <?php echo $shop->sho_mobile ?></td>
                    </tr>
                    <tr>
                        <td align="left">Website</td>
                        <td>
                            <?php echo $shop->sho_website ?></td>
                    </tr>
                    <tr>
                        <td align="left">Email</td>
                        <td>
                            <?php echo $shop->sho_email ?></td>
                    </tr>
                    <tr>
                        <td align="left">Fanpage</td>
                        <td>
                            <?php echo $shop->sho_facebook ?></td>
                    </tr>

                </tbody>
            </table>  

            <?php if (count($list_products) > 0) {  ?>
                <div style="background: #fff; margin-bottom: 15px; outline: 1px solid #ddd;padding: 5px;">                    
                    <div>&nbsp;<strong>Sản phẩm</strong></div>
                    <div id="pictures_gallery">
                        <?php
                        foreach ($list_products as $key => $product) {
                            $listimg = explode(',', $product->pro_image);
                            $pro_image = $listimg[0];
                            $fileimg = '/media/images/product/' . $product->pro_dir . '/' . $pro_image;
                            $linkbuy = base_url() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . '.html';
                            $linkedit = base_url() . 'account/product/edit/' . $product->pro_id . '/';
                            ?>
                            <a class="item col-xs-4" href="<?php echo $fileimg ?>" data-sub-html=".caption<?php echo $key ?>">
                                <div class="fix4by3">
                                    <div class="c">
                                        <img class="img-responsive" src="<?php echo $fileimg ?>" alt="" />
                                    </div>
                                </div>
                            </a>
                            <div class="caption<?php echo $key ?>" style="border-bottom: 10px solid #ddd; display: none;">
                                <ul class="menu-justified dropdown">
                                    <li class="">
                                        <?php if ($this->session->userdata('sessionUser') == $shop->sho_user) : ?>
                                            <a href="<?php echo $linkedit ?>">
                                                <img src="<?php echo base_url() ?>templates/home/icons/orange/icon-edit.png" alt="update" height="16"/> &nbsp;Chỉnh sửa
                                            </a>
                                        <?php else: ?>
                                            <a href="<?php echo $linkbuy ?>">
                                                <img src="<?php echo base_url() ?>templates/home/icons/orange/icon-cart.png" alt="cart" height="16"/> &nbsp;Mua ngay
                                            </a>
                                        <?php endif; ?>
                                    </li>
                                    <li class="">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <img src="<?php echo base_url() ?>templates/home/icons/orange/share-outline.png" alt="" height="16"> &nbsp;Chia sẻ
                                        </a>
                                        <ul class="dropdown-menu" style="left: -15px; right:-15px;">
                                            <li class="social-share">
                                                <div style="padding: 5px 15px;">
                                                    <a href="javascript:void(0)" onclick="
                                                            window.open(
                                                                    '//www.facebook.com/sharer/sharer.php?u=<?php echo $linkbuy ?>&amp;picture=<?php echo $fileimg ?>&amp;title=<?php echo $product->pro_name ?>&amp;description=<?php echo $product->pro_descr ?>',
                                                                    'facebook-share-dialog',
                                                                    'width=800,height=450');
                                                            return false;">
                                                        <img src="<?php echo base_url() ?>templates/home/icons/icon-facebook.png" alt="">
                                                    </a> &nbsp;
                                                    <a href="javascript:void(0)" onclick="
                                                            window.open(
                                                                    '//twitter.com/share?text=<?php echo $product->pro_name ?>&amp;url=<?php echo $linkbuy ?>',
                                                                    'twitter-share-dialog',
                                                                    'width=800,height=450');
                                                            return false;">
                                                        <img src="<?php echo base_url() ?>templates/home/icons/icon-twitter.png" alt="">
                                                    </a> &nbsp;
                                                    <a href="javascript:void(0)" onclick="
                                                            window.open(
                                                                    '//plus.google.com/share?url=<?php echo $linkbuy ?>',
                                                                    'google-share-dialog',
                                                                    'width=800,height=450');
                                                            return false;">
                                                        <img src="<?php echo base_url() ?>templates/home/icons/icon-google-plus.png" alt="">
                                                    </a>
                                                    <!-- Button to trigger modal -->
                                                    <a class="pull-right" target="_blank" href="//mail.google.com/mail/u/0/?view=cm&fs=1&to&su=<?php echo $product->pro_name ?>&body=<?php echo $linkbuy ?>&ui=2&tf=1">
                                                        <img src="<?php echo base_url() ?>templates/home/icons/black/icon-email.png" alt="">
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="copylink('<?php echo $linkbuy ?>')">
                                                    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-coppy.png" alt=""> &nbsp;Sao chép liên kết
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <script>
                                    $('.lg-sub-html ul').removeClass('dropdown').addClass('dropup');                                    
                                </script>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>                    
                </div>
            <?php } ?>

            <?php if (count($list_videos) > 0) { ?>
                <div style="background: #fff; margin-bottom: 15px; outline: 1px solid #ddd; padding: 5px;">
                    <div>&nbsp;<strong>Videos</strong></div>
                    <div id="videos_gallery">
                        <?php
                        foreach ($list_videos as $k => $video) {
                            if ($video->not_video_url) {
                                ?>
                                <a class="item col-xs-4" href="<?php echo $video->not_video_url ?>" data-poster="//img.youtube.com/vi/<?php echo $video->not_video_id ?>/mqdefault.jpg">
                                    <div class="fix4by3">
                                        <div class="c"><img src="//img.youtube.com/vi/<?php echo $video->not_video_id ?>/mqdefault.jpg" />
                                            <i class="icon-play"></i>
                                        </div>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php } ?>

            <div class="newfeeds">
                <!--<pre><?php //print_r($list_news);?></pre>-->
                <?php echo count($list_news);
                
                
                foreach ($list_news as $k => $item) { 
                    $item_title = $item->not_title;
                    $item_link = base_url() . 'tintuc/company/' . $shop->sho_link . '/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . '.html';
                    $item_image = base_url() . 'media/images/no_photo_icon.png';
                    if (isset($item->not_image)): $item_image = base_url() . 'media/images/tintuc/' . $item->not_dir_image . '/' . show_thumbnail($item->not_dir_image, $item->not_image, 3, 'tintuc');
                    endif;
                    $item_desc = mb_substr(strip_tags(html_entity_decode($item->not_detail)), $start, 150, "UTF-8");
                    ?>

                    <div id="item<?php echo $item->not_id ?>" class="item  col-xs-12" style="display:none; background: #fff; padding-top: 15px; margin-bottom:15px;">

                        <div class="rowtop">
                            <div class="dropdown">
                                <a class="pull-right" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-more.png" alt="more">
                                </a>
                                <?php if ($this->session->userdata('sessionUser') == $item->sho_user) : ?>
                                    <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: -15px; right:-15px; margin-top: 25px;">
                                        <li>
                                            <a href="#quang-cao"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-bullhorn.png" alt="Quảng cáo"> &nbsp; Quảng cáo</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="ghimtin(<?php echo $item->not_id ?>)"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-tack.png" alt="Ghim tin lên đầu trang"> &nbsp; Ghim tin lên đầu trang</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="antinnay(<?php echo $item->not_id ?>)"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-hidden.png" alt="Ẩn tin"> &nbsp; Ẩn tin này</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() ?>account/news/edit/<?php echo $item->not_id ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-edit.png" alt="Sửa tin"> &nbsp; Chỉnh sửa tin</a>
                                        </li>

                                        <li>
                                            <a href="javascript:void(0)" onclick="xoatinnay(<?php echo $item->not_id ?>)"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-remove.png" alt="Xóa tin"> &nbsp; Xóa tin</a>
                                        </li>
                                    </ul>
                                    <?php
                                else : $messages = "#";
                                    if ($item->sho_facebook) {
                                        $face = explode("/", parse_url($item->sho_facebook, PHP_URL_PATH));
                                        $messages = "//www.messenger.com/t/" . $face[1];
                                    }
                                    ?>
                                    <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: -15px; right:-15px; margin-top: 25px;">
                                        <li>
                                            <a href="<?php echo $shopstore ?>">
                                                <img src="<?php echo site_url('templates/home/icons/black/icon-store.png'); ?>" alt=""> &nbsp; Đến gian hàng
                                            </a>
                                        </li>
                                        <li>
                                            <a href="tel:<?php echo $item->sho_mobile ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-call.png" alt="Gọi ngay"> &nbsp; Gọi ngay</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo $messages ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-comment.png" alt="Gửi tin nhắn"> &nbsp; Gửi tin nhắn</a>
                                        </li>
                                    </ul>
                                <?php endif; ?>

                            </div>
                            <div class="pull-left" style="margin-right: 10px;">
                                <a class="sho_logo_small img-circle" href="<?php echo base_url() . 'tintuc/company/' . $shop->sho_user . '/' . $shop->sho_link; ?>">
                                    <?php
                                    $shop_logo = 'templates/home/images/no-logo.jpg';
                                    if ($shop->sho_logo) {
                                        $shop_logo = 'media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo;
                                    }
                                    ?>
                                    <img alt="<?php echo $shop->sho_name; ?>" src="<?php echo base_url() . $shop_logo; ?>" />
                                </a>
                            </div>

                            <div style="padding-left:50px">
                                
                                <?php
                                if ($item->tinchon == 1) { ?>
                                    <a href="<?php echo site_url('tintuc/company/' . $shop->sho_link); ?>">
                                        <strong class="text-uppercase"><?php echo $shop->sho_link ?></strong>
                                    </a>
                                    <?php echo 'đã chọn tin của';
                                    ?>
                                    <a href="<?php echo site_url('tintuc/company/' . $item->sho_link); ?>">
                                        <strong class="text-uppercase"><?php echo $item->sho_link ?></strong>
                                    </a>
                                <?php } else {?>
                                    <a href="<?php echo site_url('tintuc/company/' . $item->sho_link); ?>">
                                        <strong class="text-uppercase"><?php echo $item->sho_link ?></strong>
                                    </a>
                                <?php } ?>

                                <div class="dropdown">
                                    <span class="small"> 
                                        <?php echo date('d/m/Y', $item->not_begindate); ?> &nbsp;
                                    </span>
                                    <?php if ($this->session->userdata('sessionUser') == $item->sho_user) : ?>
                                        <a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-globe"></i>
                                        </a>
                                        <ul class="permission dropdown-menu" aria-labelledby="dLabel" style="left: -15px; right:-15px;">
                                            <?php foreach ($permission as $key => $value) { ?>
                                                <li class="<?php echo $item->not_permission == $value->id ? 'current' : '' ?>">
                                                    <a href="javascript:void(0)" onclick="setpermission(<?php echo $item->not_id . ',' . ($key + 1) ?>)"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-permission-<?php echo $key + 1 ?>.png" alt="<?php echo $value->name ?>"> &nbsp;<?php echo $value->name ?></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="rowmid">
                            <div class="r-text">
                                <div class="desc" style="height: 60px; overflow: hidden">
                                    <?php echo $item_desc; ?>
                                </div>
                                <div>
                                    <a class="viewmore" href="<?php echo $item_link; ?>"><em> → Xem tiếp</em></a>
                                </div>
                            </div>
                            <?php if ($item->not_image) : ?>
                                <a href="<?php echo $item_link; ?>">  
                                    <img width="100%" src="<?php echo $item_image; ?>" />
                                </a>
                            <?php endif; ?>
                            <div class="r-text">
                                <div class="title" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden; height:20px;">
                                    <a href="<?php echo $item_link; ?>"><strong><?php echo $item_title ?></strong></a>
                                </div>
                            </div>
                        </div>

                        <p class="text-right text-muted small">
                            <?php echo $item->comments ?> bình luận &nbsp;
                            <?php echo $item->chontin ?> lượt chọn tin</p>

                        <div class="rowbot">
                            <div class="dropdown text-center" style="padding:5px 15px;">
                                <span class="pull-left">
                                    <a  href="<?php echo $item_link ?>#comments"><img src="<?php echo base_url() ?>templates/home/icons/orange/icon-comment.png" alt="" height="16"> &nbsp;Bình luận</a>
                                </span>
                                <span>
                                    <?php if ($this->session->userdata('sessionUser') == $item->sho_user) : ?>
                                        <a id="dLabel" data-target="#" href="//example.com" id="drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <img src="<?php echo base_url() ?>templates/home/icons/orange/icon-statistic.png" alt="" height="16"> &nbsp;Thống kê</a>
                                        <ul class="dropdown-menu" aria-labelledby="drop1" style="left: 0px; right:0px;">
                                            <li><span><img src="<?php echo base_url() ?>templates/home/icons/black/icon-view.png" alt="" height="16"> &nbsp;Số lượt xem tin</span>
                                                <span class="pull-right"><?php echo $item->not_view; ?></span>
                                            </li>
                                            <li>
                                                <a href="/tintuc/danh-sach-chon/<?php echo $item->not_id . '/' . RemoveSign($item->not_title) . '.html' ?>">
                                                    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-filter.png" alt="" height="16"> &nbsp;Số lượt chọn tin 
                                                    <span class="pull-right" ><?php echo $item->chontin ?></span>
                                                </a>
                                            </li>
                                        </ul>
                                    <?php else: ?>
                                        <a href="<?php echo base_url() . 'tintuc/category/' . $item->not_pro_cat_id . '/' . RemoveSign($item->not_pro_cat_name) . '.html' ?>"><img src="<?php echo base_url() ?>templates/home/icons/orange/icon-newspaper.png" alt="" height="16"> &nbsp;Liên quan</a>
                                    <?php endif; ?>
                                </span>
                                <span class="pull-right">
                                    <a id="dLabel" data-target="#" href="//example.com" id="drop2" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <img src="<?php echo base_url() ?>templates/home/icons/orange/share-outline.png" alt="" height="16"> &nbsp;Chia sẻ
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="drop2" style="left: 0px; right:0px;">
                                        <?php if ($shop->sho_package['id'] > 1) { ?>
                                            <li class="social-share">
                                                <div>
                                                    <a onclick="
                                                            window.open(
                                                                    '//www.facebook.com/sharer/sharer.php?u=<?php echo $item_link ?>&amp;picture=<?php echo $item_image ?>&amp;title=<?php echo $item_title ?>&amp;description=<?php echo $item_desc ?>',
                                                                    'facebook-share-dialog',
                                                                    'width=800,height=600');
                                                            return false;">
                                                        <img src="<?php echo base_url() ?>templates/home/icons/icon-facebook.png" alt="">
                                                    </a>
                                                    <a onclick="
                                                            window.open(
                                                                    '//twitter.com/share?text=<?php echo $item_title ?>&amp;url=<?php echo $item_link ?>',
                                                                    'twitter-share-dialog',
                                                                    'width=800,height=600');
                                                            return false;">
                                                        <img src="<?php echo base_url() ?>templates/home/icons/icon-twitter.png" alt="">
                                                    </a>
                                                    <a onclick="
                                                            window.open(
                                                                    '//plus.google.com/share?url=<?php echo $item_link ?>',
                                                                    'google-share-dialog',
                                                                    'width=800,height=600');
                                                            return false;">
                                                        <img src="<?php echo base_url() ?>templates/home/icons/icon-google-plus.png" alt="">
                                                    </a> 
                                                    <a style="margin-right:15px;" target="_blank" href="mailto:?subject=<?php echo $item_title ?>&amp;body=<?php echo $item_desc . ' - ' . $item_link ?>" class="pull-right">
                                                        <img src="<?php echo base_url() ?>templates/home/icons/black/icon-email.png" alt="">
                                                    </a>
                                                </div>                                        
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="copylink('<?php echo $item_link ?>')">
                                                    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-coppy.png" alt=""> &nbsp;Sao chép liên kết
                                                </a>
                                            </li>
                                            <?php if ($this->session->userdata('sessionUser') > 0 && $this->session->userdata('sessionUser') == $item->sho_user) : ?>
                                                <li>
                                                    <a class="checknews" href="#"><img src="<?php echo base_url() ?>templates/home/icons/black/share-outline.png" alt=""> &nbsp;Chia sẻ lên group</a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if ($this->session->userdata('sessionUser') > 0 && $this->session->userdata('sessionUser') != $item->sho_user) : ?>

                                                <?php if ($item->dachon == 0) { ?>
                                                    <li class="chontin">
                                                        <a class="checknews" href="javascript:void(0)"  onclick="chontin(<?php echo $item->not_id ?>);"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-check.png" alt=""> &nbsp;Chọn tin</a>
                                                    </li>
                                                <?php } else { ?>
                                                    <li class="bochontin">
                                                        <a class="checknews" href="javascript:void(0)"  onclick="bochontin(<?php echo $item->not_id ?>);"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-check.png" alt=""> &nbsp; Bỏ chọn tin</a>
                                                    </li>
                                                <?php } ?>  
                                            <?php endif; ?>

                                        <?php } else { ?>             
                                            <li><a>Bạn không được phép chia sẻ tin này!</a></li>
                                        <?php } ?> 
                                    </ul>
                                </span>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>

        <div class="col-lg-3 col-md-3 hidden-sm  hidden-xs" style="padding-left:0">
            <?php if($this->session->userdata('sessionUser') && $this->session->userdata('sessionUser') == $shop->sho_user) : ?>
            <div class="panel panel-default">
                <div class="panel-heading">Thống kê</div>
                <div class="panel-body">        
                    <table class="table-custom" style="background: #fff; width:100%">
                        <tr><td>Doanh thu</td><td class="text-right">10.000.000 vnđ</td></tr>
                        <tr><td>Thu nhập</td><td class="text-right">1.000.000 vnđ</td></tr>
                        <tr><td>Số lượng Afiliate</td><td class="text-right">10</td></tr>
                        <tr><td>Số lượng nhân viên</td><td class="text-right">10</td></tr>
                        <?php if($group_id != 14 & $group_id != 2) { ?>
                        <tr><td>Số lượng chi nhánh</td><td class="text-right">10</td></tr>
                        <?php } ?>
                        <tr><td>Số đơn hàng chờ duyệt</td><td class="text-right">10</td></tr>
                        <tr><td>Thống kê theo sản phẩm</td><td class="text-right">10</td></tr>
                    </table>
                </div>
            </div>
            <?php if($group_id != 14 & $group_id != 2) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">Danh sách chi nhánh</div>
                <div class="panel-body">
                    <ol>
                        <li><p><a hre="#">Lorem ipsum dolor sit amet</a></p></li>
                        <li><p><a hre="#">Vivamus senectus facilisis</a></p></li>
                        <li><p><a hre="#">Natoque nunc condimentum</a></p></li>
                        <li><p><a hre="#">Mus posuere luctus per</a></p></li>
                        <li><p><a hre="#">Posuere curabitur vehicula</a></p></li>
                        <li><p><a hre="#">Facilisis dignissim proin</a></p></li>
                        <li><p><a hre="#">Nunc luctus mauris vivamus</a></p></li>
                        <li><p><a hre="#">Himenaeos molestie nec</a></p></li>
                        <li><p><a hre="#">Lobortis sodales class</a></p></li>
                        <li><p><a hre="#">Orci enim neque magna</a></p></li>
                    </ol>
                </div>
            </div>
            <?php } ?>           
            
            <div class="panel panel-default">
                <div class="panel-heading">Danh sách Affiliate</div>
                <div class="panel-body">
                    <ol>
                        <li><p><a hre="#">Lorem ipsum dolor sit amet</a></p></li>
                        <li><p><a hre="#">Vivamus senectus facilisis</a></p></li>
                        <li><p><a hre="#">Natoque nunc condimentum</a></p></li>
                        <li><p><a hre="#">Mus posuere luctus per</a></p></li>
                        <li><p><a hre="#">Posuere curabitur vehicula</a></p></li>
                        <li><p><a hre="#">Facilisis dignissim proin</a></p></li>
                        <li><p><a hre="#">Nunc luctus mauris vivamus</a></p></li>
                        <li><p><a hre="#">Himenaeos molestie nec</a></p></li>
                        <li><p><a hre="#">Lobortis sodales class</a></p></li>
                        <li><p><a hre="#">Orci enim neque magna</a></p></li>
                    </ol>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">Danh sách nhân viên</div>
                <div class="panel-body">
                    <ol>
                        <li><p><a hre="#">Lorem ipsum dolor sit amet</a></p></li>
                        <li><p><a hre="#">Vivamus senectus facilisis</a></p></li>
                        <li><p><a hre="#">Natoque nunc condimentum</a></p></li>
                        <li><p><a hre="#">Mus posuere luctus per</a></p></li>
                        <li><p><a hre="#">Posuere curabitur vehicula</a></p></li>
                        <li><p><a hre="#">Facilisis dignissim proin</a></p></li>
                        <li><p><a hre="#">Nunc luctus mauris vivamus</a></p></li>
                        <li><p><a hre="#">Himenaeos molestie nec</a></p></li>
                        <li><p><a hre="#">Lobortis sodales class</a></p></li>
                        <li><p><a hre="#">Orci enim neque magna</a></p></li>
                    </ol>
                </div>
            </div>
            
            <?php else : ?>
            <div style="margin-bottom:15px">
                <img style="width: 100%;" src="//cbsv103.files.wordpress.com/2012/12/holiday-300x600-banner1.jpg">
            </div>            
            <div style="margin-bottom:15px">
                <img style="width: 100%;" src="//cbsv103.files.wordpress.com/2012/12/holiday-300x600-banner1.jpg">
            </div>
            <div style="margin-bottom:15px">
                <img style="width: 100%;" src="//cbsv103.files.wordpress.com/2012/12/holiday-300x600-banner1.jpg">
            </div>
            <div style="margin-bottom:15px">
                <img style="width: 100%;" src="//cbsv103.files.wordpress.com/2012/12/holiday-300x600-banner1.jpg">
            </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-2  hidden-md hidden-sm hidden-xs" style="padding-left:0">
            <?php $this->load->view('home/common/ads_right'); ?>
            </div>
        </div>




    </div>
</div>


<?php $this->load->view('home/common/footer_company'); ?>

<script src="/templates/home/lightgallery/dist/js/lightgallery.js" type="text/javascript"></script>
<script src="/templates/home/lightgallery/js/lg-video.js" type="text/javascript"></script>

<script language="javascript">
                                            jQuery(function ($) {
                                                $('#pictures_gallery, #videos_gallery').lightGallery({
                                                    selector: '.item',
                                                    download: false
                                                });
                                            });
</script>
