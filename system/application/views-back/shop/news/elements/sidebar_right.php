<?php if (!empty($azitab['user']) && (!isset($info_public) || isset($info_public) && $info_public['use_id'] == $azitab['user']->use_id) ){ ?>
    <?php
    $info_public_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
    if($azitab['user']->avatar){
        $info_public_avatar_path = DOMAIN_CLOUDSERVER . 'media/images/avatar/'. $azitab['user']->avatar;
    }
    ?>
    <div class="gianhangcuaban">
        <div class="gianhangcuaban-soluong">
            <p>Gian hàng của bạn</p>
        </div>
        <div class="gianhangcuaban-shopcuatoi">
            <div class="avata"><img class="js_avatar-personal" onerror="image_error(this)" src="<?php echo $info_public_avatar_path; ?>" alt=""></div>
            <div class="info">
                <h3>Shop của tôi</h3>
                <p class="tinnhan"><span>Tin nhắn</span><span class="number">12</span></p>
                <p class="thongbao"><span>Thông báo</span><span class="number"><?php echo !empty($azitab['listNotifications']) ? sizeof($azitab['listNotifications']) : 0; ?></span></p>
            </div>
        </div>
        <div class="gianhangcuaban-luottheodoi">
            <p>Lượt theo dõi</p>
            <p class="is-active">Lượt Xem</p>
            <p>Bài Viết</p>
        </div>
        <div class="gianhangcuaban-luotthich hidden">
            <p><span>21.890</span><br>158 lượt thích tuần này</p>
        </div>
        <div class="gianhangcuaban-luotthich gianhangcuaban-luotxem">
            <p class="text-left">1 tháng 1 - 7 tháng 1</p>
            <div class="xem-tuongtac">
                <div class="luotxem">
                    <span>0</span><br>Lượt xem trang
                </div>
                <div class="tuongtac">
                    <span>200</span><br>Lượt tương tác
                </div>
            </div>
        </div>
        <div class="gianhangcuaban-luotthich gianhangcuaban-luotxem hidden">
            <p class="text-left">1 tháng 1 - 7 tháng 1</p>
            <div class="xem-tuongtac">
                <div class="luotxem">
                    <span>100</span><br>Bình luận
                </div>
                <div class="tuongtac">
                    <span>200</span><br>Lượt chia sẻ
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="hidden nguoi-theo-doi">
    <div class="tit">
        Người theo dõi
        <span class="number">667</span>
    </div>
    <ul class="info">
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/mi.svg"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/nikon.jpg"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/oppo.png"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/mi.svg"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/nikon.jpg"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/oppo.png"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
    </ul>
</div>
<div class="hidden nguoi-theo-doi">
    <div class="tit">
        Đang theo dõi
        <span class="number">667</span>
    </div>
    <ul class="info">
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/mi.svg"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/nikon.jpg"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/oppo.png"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/mi.svg"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/nikon.jpg"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
        <li>
            <div class="avata-shop"><a href=""><img
                            src="templates/home/styles/images/product/avata/oppo.png"
                            alt=""></a></div>
            <div class="name-shop">tên shopabc</div>
        </li>
    </ul>
</div>
<div class="link-to-other">
    <p class="mb10">
        <a href=""><img src="/templates/home/styles/images/svg/instagram.svg" alt=""></a>
        <a href=""><img src="/templates/home/styles/images/svg/facebook.svg" alt=""></a>
        <a href=""><img src="/templates/home/styles/images/svg/google.svg" alt=""></a>
        <a href=""><img src="/templates/home/styles/images/svg/twister.svg" alt=""></a>
    </p>
    <p>
        <a href="">Trang công ty </a>
        <a href="">Hướng dẫn</a>
        <a href="">Chính sách</a>
        <a href="">Lợi ích</a>
        <a href="">Điều khoản</a>
        <a href="">Liên hệ</a>
        <a href="">Azibai © 2018</a>
    </p>
</div>