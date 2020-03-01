
<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/tintuc/menubar'); ?>
<?php if ($isMobile == 0) { ?>
    <div id="header_news" class="container-fluid fixed hidden-xs" style="padding: 15px 15px 15px;">
        <div class="col-md-2 text-center">

        </div>   
        <div class="col-md-10">    
            <div class="row">
                <div class="col-sm-4">
                    <form id="tintuc_search" class="form-horizontal" action="<?php echo base_url() ?>tintuc/searc" method="post">
                        <div class="col-xs-10 col-sm-12">
                            <div class="form-group has-default has-feedback">
                                <input name="keyword" id="keyword" class="form-control" type="text"
                                       placeholder="Nhập từ khóa tìm kiếm"
                                       onKeyPress="return submitenterQ(this, event, '<?php echo base_url(); ?>')"/>
                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>            
                    </form>        
                </div>
                <div class="col-sm-8">
                    <ul class="list-inline" style="padding: 6px; margin: 0;">
                        <li><a href="<?php echo base_url(); ?>" title="Azibai shop"><img src="<?php echo base_url(); ?>templates/home/icons/black/icon-home.png" style="height:16px"> Trang chủ</a></li>
                        <li><a href="checkout" title="Giỏ hàng"><img src="<?php echo base_url(); ?>templates/home/icons/black/icon-cart.png" style="height:16px"> Giỏ hàng</a></li>

                        <li><a href="#tin-khuyen-mai"  title="Tin khuyến mãi">
                                <img src="<?php echo base_url(); ?>templates/home/icons/black/icon-gift.png" style="height:16px"> Tin khuyến mãi</a>
                        </li>
                        <li><a href="#tin-tuc-hot"  title="Tin hot">
                                <img src="<?php echo base_url(); ?>templates/home/icons/black/icon-hot.png" style="height:16px"> Tin tức HOT</a>
                        </li>
                        <li><a href="#tin-xem-nhieu"  title="Tin xem nhiều">
                                <img src="<?php echo base_url(); ?>templates/home/icons/black/icon-view.png" style="height:16px"> Tin xem nhiều</a>
                        </li>
                        <?php if ((int) $this->session->userdata('sessionUser') > 0) { ?>
                            <li><a  href="<?php echo base_url(); ?>account/news"  title="Tin đã đăng">
                                    <img src="<?php echo base_url(); ?>templates/home/icons/black/icon-post.png" style="height:16px"> Tin đã đăng
                                </a>
                            </li>
                        <?php } ?>
                    </ul> 
                </div>
            </div>
        </div>        
    </div>
    <div class="hidden-xs" style="height: 62px"></div> 
<?php } ?>
<div id="main" class="container-fluid">  
    <div class="row">
        <div class="col-sm-2 hidden-xs">
            <div class="scrollToFixed">
                <?php $this->load->view('home/common/left_tintuc'); ?>
            </div>
        </div>
        <div class="col-sm-10 col-xs-12">
            <div class="newfeeds" style="padding-top: 15px;">
                <div class="row"> 

                    <?php
                    foreach ($list_news as $k => $item) {
                        $item_title = $item->not_title;
                        $item_link = base_url() . 'tintuc/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . '.html';
                        $item_image = base_url() . 'media/images/no_photo_icon.png';
                        if (isset($item->not_image)):
                            $item_image = base_url() . 'media/images/tintuc/' . $item->not_dir_image . '/' . show_thumbnail($item->not_dir_image, $item->not_image, 3, 'tintuc');
                        endif;
                        $vovel = array("&curren;");
                        $item_desc = strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel, "#", $item->not_detail)), 150));
                        ?> 
                        <div class="item col-lg-4 col-md-4 col-sm-4">
                            <div class="rowtop">
                                <ul class="menu-dropdown">
                                    <li class="parent pull-right">
                                        <span><img src="<?php echo base_url() ?>templates/home/icons/black/icon-more.png" alt="more"></span>
                                        <?php if ($this->session->userdata('sessionUser') == $item->use_id) : ?>
                                            <ul class="child">
                                                <li>
                                                    <a href="#quang-cao"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-bullhorn.png" alt="Quảng cáo"> &nbsp; Quảng cáo</a>
                                                </li>
                                                <li>
                                                    <a href="#ghim-tin"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-tack.png" alt="Ghim tin lên đầu trang"> &nbsp; Ghim tin lên đầu trang</a>
                                                </li>
                                                <li>
                                                    <a href="#an-tin"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-hidden.png" alt="Ẩn tin"> &nbsp; Ẩn tin này</a>
                                                </li>
                                                <li>
                                                    <a href="#sua-tin"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-edit.png" alt="Sửa tin"> &nbsp; Chỉnh sửa tin</a>
                                                </li>

                                                <li>
                                                    <a href="#xoa-tin"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-remove.png" alt="Xóa tin"> &nbsp; Xóa tin</a>
                                                </li>
                                            </ul>
                                        <?php else : ?>
                                            <ul class="child">
                                                <li>
                                                    <a href="<?php echo base_url() . $item->byshop->sho_link ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-store.png" alt="Cửa hàng"> &nbsp; Đến gian hàng</a>
                                                </li>
                                                <li>
                                                    <a href="tel:<?php echo $item->byshop->sho_phone ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-call.png" alt="Gọi ngay"> &nbsp; Gọi ngay: <?php echo $item->byshop->sho_phone ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url() ?>register/affiliate"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-affiliate.png" alt="Đăng lý Affiliate"> &nbsp; Đăng lý Affiliate</a>
                                                </li>
                                                <?php $idfacebook = explode("/", $item->byshop->sho_facebook); ?>
                                                <li>
                                                    <a href="https://www.facebook.com/messages/t/<?php echo $idfacebook[3] ?>"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-comment.png" alt="Gửi tin nhắn"> &nbsp; Gửi tin nhắn</a>
                                                </li>
                                            </ul>              
                                        <?php endif; ?>
                                    </li>
                                </ul>

                                <div class="pull-left" style="margin-right: 10px;">                                         
                                    <a class="sho_logo_small img-circle" href="<?php echo base_url() . 'tintuc/' . $item->sho_link . '/'; ?>">                                                                           
                                        <?php
                                        $shop_logo = 'templates/home/images/no-logo.jpg';
                                        if ($item->sho_logo) {
                                            $shop_logo = 'media/shop/logos/' . $item->sho_dir_logo . '/' . $item->sho_logo;
                                        }
                                        ?>
                                        <img alt="<?php echo $item->sho_name; ?>" src="<?php echo base_url() . $shop_logo; ?>" />                                            
                                    </a>                                        
                                </div>
                                <a href="<?php echo base_url() . 'tintuc/' . $item->sho_link . '/'; ?>">
                                    <strong class="text-uppercase"><?php echo $item->sho_link ? $item->sho_link : 'NOSHOPNAME'; ?></strong>
                                </a>

                                <br>
                                <span class="createdate small"><?php echo date('d/m/Y', $item->not_begindate); ?></span> &nbsp;
                                <?php if ($this->session->userdata('sessionUser') == $item->not_user) : ?>
                                    <span class="dropdowncustom">
                                        <span>
                                            <i class="fa fa-globe"></i>              
                                        </span>
                                        <ul class="list-unstyled" aria-labelledby="dLabel">
                                            <li>
                                                <a href="#tat-ca-moi-nguoi"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-globe.png" alt="Quảng cáo"> Tất cả mọi người </a>
                                            </li>
                                            <li>
                                                <a href="#tat-ca-tru-khach-hang"><img src="<?php echo base_url() ?>templates/home/black/icons/black/icon-globe.png" alt="Chỉnh sửa"> Tất cả mọi người trừ khách hàng </a>
                                            </li>
                                            <li>
                                                <a href="#chi-khach-hang"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-persons.png" alt="Chỉ khách hàng"> Chỉ khách hàng </a>
                                            </li>
                                            <li>
                                                <a href="#tat-ca-tru-affiliate"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-globe.png" alt="Xóa tin"> Tất cả mọi người trừ affiliate </a>
                                            </li>
                                            <li>
                                                <a href="#chi-affiliate"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-affiliate.png" alt="Chỉ affiliate"> Chỉ affiliate </a>
                                            </li>
                                            <li>
                                                <a href="#he-thong-noi-bo"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-users.png" alt="Ghim tin lên đầu trang"> Hệ thống nội bộ, nhân viên, chi nhánh </a>
                                            </li>
                                            <li>
                                                <a href="#chi-rieng-minh-toi"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-lock.png" alt="Ghim tin lên đầu trang"> Chỉ riêng mình tôi </a>
                                            </li>
                                        </ul>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="rowmid">
                                <div class="r-text">
                                    <div class="desc" style="height: 60px; overflow: hidden">
                                        <?php echo $item_desc; ?>
                                    </div>
                                    <div><a class="viewmore" href="<?php echo $item_link; ?>"><em> → Xem tiếp</em></a></div>
                                </div>

                                <div class="fix3by2">
                                    <div class="c">
                                        <a href="<?php echo $item_link; ?>">  
                                            <img class="img-responsive" style="width:100%" src="<?php echo $item_image; ?>" />
                                        </a>
                                    </div>
                                </div>

                                <div class="r-text">
                                    <div class="title" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden; height:20px;">
                                        <strong><?php echo $item_title ?></strong>
                                    </div>
                                </div>
                            </div>
                            <div class="rowbot">
                                <ul class="menu-dropdown menu-justified">
                                    <li class="parent">
                                        <a href="<?php echo $item_link ?>#comments"><img src="<?php echo base_url() ?>templates/home/icons/orange/icon-comment.png" alt="" height="16"> &nbsp;Bình luận</a>
                                    </li>

                                    <li class="parent">
                                        <?php if ($this->session->userdata('sessionUser') == $item->use_id) : ?>            
                                            <span><img src="<?php echo base_url() ?>templates/home/icons/orange/icon-statistic.png" alt="" height="16"> &nbsp;Thống kê</span>
                                            <ul class="child">
                                                <li><span><img src="<?php echo base_url() ?>templates/home/icons/black/icon-view.png" alt="" height="16"> &nbsp;Số lượt xem tin</span> <span class="pull-right"><?php echo $item->not_view; ?></span>
                                                </li>
                                                <li><span><img src="<?php echo base_url() ?>templates/home/icons/black/icon-filter.png" alt="" height="16"> &nbsp;Số lượt chọn tin</span> <a class="pull-right" href="#danh-sach-chon-tin">...</a>
                                                </li>
                                            </ul>
                                        <?php else: ?>
                                            <a href="<?php echo $item_link ?>#related"><img src="<?php echo base_url() ?>templates/home/icons/orange/icon-newspaper.png" alt="" height="16"> &nbsp;Tin liên quan</a>
                                        <?php endif; ?>
                                    </li>

                                    <li class="parent">
                                        <span>
                                            <img src="<?php echo base_url() ?>templates/home/icons/orange/share-outline.png" alt="" height="16"> &nbsp;Chia sẻ
                                        </span>
                                        <ul class="child">
                                            <li class="social-share">
                                                <a href="#" onclick="
                                                        window.open(
                                                                'https://www.facebook.com/sharer/sharer.php?u=<?php echo $item_link ?>&amp;app_id=<?php echo app_id ?>',
                                                                'facebook-share-dialog',
                                                                'width=300,height=300');
                                                        return false;">
                                                    <img src="<?php echo base_url() ?>templates/home/icons/icon-facebook.png" alt="">
                                                </a>
                                                &nbsp;
                                                <a href="#" onclick="
                                                        window.open(
                                                                'https://twitter.com/share?text=<?php echo $item_title ?>&amp;url=<?php echo $item_link ?>',
                                                                'twitter-share-dialog',
                                                                'width=300,height=300');
                                                        return false;">
                                                    <img src="<?php echo base_url() ?>templates/home/icons/icon-twitter.png" alt="">
                                                </a>
                                                &nbsp;
                                                <a href="#" onclick="
                                                        window.open(
                                                                'https://plus.google.com/share?url=<?php echo $item_link ?>',
                                                                'google-share-dialog',
                                                                'width=300,height=300');
                                                        return false;">
                                                    <img src="<?php echo base_url() ?>templates/home/icons/icon-google-plus.png" alt="">
                                                </a>
                                                <!-- Button to trigger modal -->
                                                <a target="_blank" href="mailto:?subject=<?php echo $item_title ?>&amp;body=<?php echo $item_desc . ' - ' . $item_link ?>" class="pull-right">
                                                    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-email.png" alt="">
                                                </a>
                                            </li>

                                            <li>
                                                <a class="checknews" href="#"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-coppy.png" alt=""> &nbsp;Sao chép liên kết</a>
                                            </li>
                                            <li>
                                                <a class="checknews" href="#"><img src="<?php echo base_url() ?>templates/home/icons/black/share-outline.png" alt=""> &nbsp;Chia sẻ lên group</a>
                                            </li>

                                        </ul>
                                    </li>
                                </ul>
                            </div>        
                        </div>        
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-center"><?php echo $linkPage?></div>


<?php $this->load->view('home/common/footer'); ?>
