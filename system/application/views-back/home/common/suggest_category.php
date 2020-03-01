<div class="categories">
    <p class="suggest">Chủ đề đang theo dõi</p>
    <ul class="categories-items js-categories-items">
        <li class="add item">
            <a href="#"><div class="icon"><img src="/templates/home/images/svg/add.svg" alt="add"></div></a>
        </li>
        <?php
        $i = 0;
        $list_icons = array(
            '/templates/home/styles/images/svg/goiy_dienthoaivienthong.svg',
            '/templates/home/styles/images/svg/goiy_maytinhlinhkien.svg',
            '/templates/home/styles/images/svg/goiy_dientudienmay.svg',
            '/templates/home/styles/images/svg/goiy_mayanh.svg',
            '/templates/home/styles/images/svg/goiy_thoitrangphukien.svg',
            '/templates/home/styles/images/svg/goiy_suckhoelamdep.svg',
            '/templates/home/styles/images/svg/goiy_mebe.svg',
            '/templates/home/styles/images/svg/goiy_otoxemay.svg',
            '/templates/home/styles/images/svg/goiy_dodungsinhhoat.svg',
            '/templates/home/styles/images/svg/goiy_noithatngoaithat.svg',
            '/templates/home/styles/images/svg/goiy_thethao.svg',
            '/templates/home/styles/images/svg/goiy_thucphamdouong.svg',
            '/templates/home/styles/images/svg/goiy_sachvanphong.svg',
            '/templates/home/styles/images/svg/goiy_congnghiepxaydung.svg',
            '/templates/home/styles/images/svg/goiy_nonglamngunghiep.svg',
            '/templates/home/styles/images/svg/goiy_dichvuit.svg',
            '/templates/home/styles/images/svg/goiy_anuong.svg',
            '/templates/home/styles/images/svg/goiy_suckhoelamdep.svg',
            '/templates/home/styles/images/svg/goiy_gamedochoi.svg',
            '/templates/home/styles/images/svg/goiy_giaoducdaotao.svg',
            '/templates/home/styles/images/svg/goiy_chothue.svg',
            '/templates/home/styles/images/svg/goiy_dichvutochuctiec.svg',
            '/templates/home/styles/images/svg/goiy_dichvutuvan.svg',
            '/templates/home/styles/images/svg/goiy_dichvuphaply.svg',
            '/templates/home/styles/images/svg/goiy_dichvuvesinh.svg',
            '/templates/home/styles/images/svg/goiy_dulichkhachsan.svg',
            '/templates/home/styles/images/svg/goiy_inanthietke.svg',
            '/templates/home/styles/images/svg/goiy_dichvuthoitrang.svg',
            '/templates/home/styles/images/svg/goiy_tuyendung.svg',
            '/templates/home/styles/images/svg/goiy_xuatnhapkhau.svg',
            '/templates/home/styles/images/svg/goiy_dichvuyte.svg',
            '/templates/home/styles/images/svg/goiy_dichvusangtacnghethuat.svg',
            '/templates/home/styles/images/svg/goiy_dichvutruyenthongtruyenhinh.svg',
            '/templates/home/styles/images/svg/goiy_quangcaosukien.svg',
            '/templates/home/styles/images/svg/goiy_dichvuvantaivanchuyen.svg',
            '/templates/home/styles/images/svg/goiy_taichinhtiente.svg',
            '/templates/home/styles/images/svg/goiy_batdongsan.svg',
            '/templates/home/styles/images/svg/goiy_dichvukhac.svg',
        );
        foreach ($productCategoryRoot as $k => $category) :
            if ($category->cate_type == 2) {
                ?>
                <li class="item" id="<?=$k?>">
                    <a href="<?php echo '/tintuc/category/' . $category->cat_id . "/" . RemoveSign($category->cat_name); ?>">
                        <div class="icon"><img src="<?php echo !empty($category->cat_image) ? DOMAIN_CLOUDSERVER .'media/images/categories/' . $category->cat_image : '/templates/home/styles/images/default/error_image_400x400.jpg';?>" alt="<?php echo $category->cat_name; ?>"></div>
                        <span><?php echo $category->cat_name; ?></span>
                    </a>
                </li>
                <?php $i++;
            }
        endforeach;
        ?>
    </ul>
</div>
<script>
    $('.js-categories-items').slick({
      dots: false,
      infinite: false,
      slidesToShow: 4.5,
      slidesToScroll: 4,
      arrows: true,
      variableWidth: true,
    });
</script>