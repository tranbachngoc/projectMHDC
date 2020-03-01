<?php
$this->load->view('shop/common/header');
$url_segment = $this->uri->segment(2);
?>

<main>
    <div class="container">
        <div class="gioithieucuahang">
            <div class="gioithieucuahang-left">
                <div class="hinhdaidien">
                    <img src="/templates/home/styles/images/product/avata/mi.svg" alt="">
                </div>
                <div class="tenshop">
                    <p>Cửa hàng áo thun<br><span>Online 15 phút trước</span></p>
                    <p><img src="/templates/home/styles/images/svg/CTV.svg" alt=""></p>
                </div>
            </div>
            <div class="gioithieucuahang-right">
                <div class="nguoitheodoi">
                    <p>Người theo dõi <span>567</span></p>
                    <p class="btn-bosuutap"><img src="/templates/home/styles/images/svg/bookmark.svg" width="20" class="mr10" alt="">Bộ sưu tập</p>
                </div>
                <div class="nhantin-theodoi">
                    <p><img src="/templates/home/styles/images/svg/icon_mail.svg" width="24" class="mr10" alt="">Nhắn tin</p>
                    <p><img src="/templates/home/styles/images/svg/add.svg" width="24" class="mr10" alt="">Theo dõi</p>
                </div>
            </div>
        </div>
        <div class="danhsachchuyenmuc">
            <div class="danhsachchuyenmuc-slider">
                <?php if (!empty($listCategory)){ ?>
                    <?php foreach ($listCategory as $k => $category) { ?>
                        <?php $this->load->view('shop/product/elements/category_item', ['item' => $category, 'url_segment' => $url_segment]) ?>
                    <?php } ?>
                <?php } ?>
            </div>

        </div>
        <div class="hienthisanpham">
            <div class="loctheogia">
                <form class="row" id="searchBox" action="" method="get">
                    <div class="loctheogia-form">
                        <p>Lọc theo giá </p>
                        <p class="search">
                            <input type="text" value="<?php echo @$q;?>" name="q"
                                   title="Từ khóa tìm kiếm"
                                   onKeyPress="return submit_enter(event)"
                                   placeholder="Từ khóa tìm kiếm">
                            <img class="js_icon-search-submit" src="/templates/home/styles/images/svg/search.svg" width="15" alt="">
                        </p>
                        <div class="text-center"><button type="submit" class="locgia">Lọc giá</button></div>
                    </div>
                </form>
                <div class="loctheogia-tags">
                    <a href="">mỹ phẩm</a>
                    <a href="">son</a>
                    <a href="">Giày</a>
                    <a href="">mỹ phẩm</a>
                    <a href="">son</a>
                    <a href="">Giày</a>
                </div>

            </div>
            <div class="hienthisanpham-chitiet">
                <div class="tieude">
                    <div class="tatcasanpham">
                        <p class="duongdan">Trang chủ ><span>tất cả sản phẩm</span></p>
                        <p>Hiển thị tất cả <?php echo $menuSelected == 'product' ? 'Sản phẩm' : 'Coupon' ?> <?php echo @formatNumber($product_count->total) ?></p>
                    </div>

                    <select autocomplete="off" name="select_sort" onchange="ActionSort(this.value)">
                        <option <?php echo ($default_sort == 'id_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                        <option <?php echo ($default_sort == 'name_asc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>">Tên sản phẩm A&rarr;Z</option>
                        <option <?php echo ($default_sort == 'name_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>">Tên sản phẩm Z&rarr;A</option>
                        <option <?php echo ($default_sort == 'cost_asc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>">Giá sản phẩm tăng dần</option>
                        <option <?php echo ($default_sort == 'cost_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>">Giá sản phẩm giảm dần</option>
                        <option <?php echo ($default_sort == 'buy_asc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_detail_product'); ?></option>
                        <option <?php echo ($default_sort == 'buy_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_detail_product'); ?></option>
                        <option <?php echo ($default_sort == 'view_asc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_detail_product'); ?></option>
                        <option <?php echo ($default_sort == 'view_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_detail_product'); ?></option>
                        <option <?php echo ($default_sort == 'date_asc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_detail_product'); ?></option>
                        <option <?php echo ($default_sort == 'date_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_desc_detail_product'); ?></option>
                    </select>
                </div>
                <div class="noidung">
                    <?php if (!empty($product)){ ?>
                        <?php foreach ($product as $item) { ?>
                            <?php $this->load->view('shop/product/elements/product_item', ['item' => $item]) ?>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?php echo $linkPage ?>
            </div>
        </div>
    </div>
</main>

<?php $this->load->view('shop/product/elements/pop_addtocart'); ?>
<?php $this->load->view('shop/common/footer'); ?>

<script src="/templates/home/boostrap/js/popper.min.js"></script>
<script src="/templates/home/boostrap/js/bootstrap.min.js"></script>
<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>
<script src="/templates/home/styles/js/shop-page.js"></script>
<script type="text/javascript">
    $('.danhsachchuyenmuc-slider').slick({
        slidesToShow: 7,
        slidesToScroll: 5,
        arrows: false,
        infinite: false,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 1,
                    arrows: false,
                }
            }
        ]
    });
    $('.tag-list-product-slider').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 2.5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1.5,
                    slidesToScroll: 1
                }
            }
        ]
    });
</script>
