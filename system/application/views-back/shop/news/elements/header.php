<header>
    <div class="header md">
        <div class="container">
            <div class="header-menu">
                <div class="header-menu-left">
                    <ul>
                        <li class="home"><a href="<?php echo base_url() ?>"><img class="icon-img"
                                                                                 src="/templates/home/styles/images/svg/a.svg"
                                                                                 alt="azibai"></a></li>
                        <li><a href="#">Tải ứng dụng</a></li>
                        <li class="tablet-none"><a href="#">Kết nối</a></li>
                        <li class="no-border"><a href="#"><img
                                        src="/templates/home/styles/images/svg/instagram.svg"
                                        alt="instagram"></a></li>
                        <li class="no-border"><a href=""><img
                                        src="/templates/home/styles/images/svg/facebook.svg" alt="facebook"></a>
                        </li>
                    </ul>
                </div>
                <div class="header-menu-center">
                    <div class="search">
                        <form id="formSearch" method="post">
                            <input type="text" name="keyword" id="keyword" placeholder="Tìm kiếm tin tức"><img
                                    src="asset/images/svg/search.svg" alt="">
                        </form>
                        <script>
                            var keyword = document.getElementById('keyword');
                            keyword.addEventListener('keypress', function (event) {
                                if (event.keyCode == 13) {
                                    event.preventDefault();
                                    if (keyword.value.length > 0) {
                                        document.getElementById('formSearch').action = '/tintuc/search';
                                        document.getElementById('formSearch').submit();
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
                <div class="header-menu-right">
                    <ul class="header-list-icon">
                        <li><a href="#"><img src="/templates/home/styles/images/svg/message.svg"
                                             class="icon-img" alt=""></a></li>
                        <li><a href="#"><img src="/templates/home/styles/images/svg/bell_black.svg"
                                             class="icon-img" alt=""></a></li>
                        <li><a href="#"><img src="/templates/home/styles/images/svg/help_black.svg"
                                             class="icon-img" alt=""></a></li>
                    </ul>
                    <ul class="header-avata">
                        <li class="mr00">
                            <div class="cart show-info-number"><a title="Xem giỏ hàng" href="/checkout">
                                    <img src="/templates/home/styles/images/svg/cart.svg" alt="cart">
                                    <span class="cartNum"><?php echo $azitab['cart_num']; ?></span>
                                </a></div>
                        </li>
                        <li>
                            <?php
                            if (isset($currentuser) && $currentuser) {
                                if ($currentuser->avatar) {
                                    $avatar = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $currentuser->avatar;
                                } else {
                                    $avatar = site_url('media/images/avatar/default-avatar.png');
                                }
                                ?>
                                <a href="/logout">
                                    <img class="img-circle" src="<?php echo $avatar; ?>" alt="account">
                                </a>
                                <?php
                            } else { ?>
                                <a href="#" data-toggle="modal" data-target="#pop-login">
                                    <img class="img-circle"
                                         src="/templates/home/styles/images/product/avata/default-avatar.png"
                                         alt="account">
                                </a>
                                <?php
                            } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="sm header-sp js-fixed-header-sm">
        <?php
        $link = '';
        if (isset($currentuser) && $currentuser) {
            if ($currentuser->avatar) {
                $avatar = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $currentuser->avatar;
            } else {
                $avatar = site_url('media/images/avatar/default-avatar.png');
            }
        } else {
            $avatar = site_url('media/images/avatar/default-avatar.png');
            $link   = "/login";
        }
        ?>
        <div class="header-sp-nav">
            <ul class="f-gnav">
                <li><a href="#"><img class="icon-img" src="/templates/home/styles/images/svg/a.svg"
                                     alt="azibai"></a></li>
                <li><a href="#"><img class="icon-img" src="/templates/home/styles/images/svg/shop.svg"
                                     alt="shop"></a></li>
                <li><a href="#"><img class="icon-img" src="/templates/home/styles/images/svg/bell_black.svg"
                                     alt="shop"></a></li>
                <li><a href="#"><img class="icon-img" src="/templates/home/styles/images/svg/help_black.svg"
                                     alt="shop"></a></li>
                <li>
                    <ul class="header-avata">
                        <li class="mr00">
                            <div class="cart show-info-number"><img
                                        src="/templates/home/styles/images/svg/cart.svg" alt="cart"></div>
                        </li>
                        <li><a href="<?php echo $link; ?>"><img src=<?php echo $avatar; ?> alt="cart"></a></li>
                    </ul>
                </li>
                <li class="ico-nav">
                    <div class="drawer-hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </li>
            </ul>
            <nav class="sm-gnav">
                <ul>
                    <li><a href="#">Đến trang của gian hàng</a></li>
                    <li><a href="#">Gọi ngay</a></li>
                    <li><a href="#">Gởi tin nhắn</a></li>
                    <li><a href="#">Báo cáo bài viết</a></li>
                </ul>
            </nav>
        </div>
        <div class="header-sp-search">
            <div class="search"><input type="text" placeholder="Tìm kiếm tin tức"><img
                        src="/templates/home/styles/images/svg/search.svg" class="icon-img" alt=""></div>
            <div class="sm">
                <div class="show-info-number mr00">
                    <img class="icon-img"
                                                        src="/templates/home/styles/images/svg/message.svg"
                                                        alt="message"></div>
            </div>
        </div>
    </div>
</header>