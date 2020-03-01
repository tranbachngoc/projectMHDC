<?php
$cat_name_slug = RemoveSign($item->cat_name);
$cat_name_xss = htmlspecialchars($item->cat_name);
?>
<div class="item">
    <div class="image position-tag">
        <a title="<?php echo $cat_name_xss ?>" href="<?php echo '/shop/' . $url_segment . '/cat/' . $item->cat_id . '-' . $cat_name_slug; ?>">
            <img onerror="image_error(this)" alt="<?php echo $cat_name_xss ?>" title="<?php echo $cat_name_xss ?>" src="<?php echo DOMAIN_CLOUDSERVER . '/media/images/categories/' . $image_category ?>" />
<!--        <div class="tag-number-selected" data-toggle="modal" data-target="#myModal2">-->
<!--            <img src="/templates/home/styles/images/svg/tag.svg" alt="" >-->
<!--            <span class="number">12</span>-->
<!--        </div>-->
        </a>
    </div>
    <div class="tieude">
        <h3>
            <a title="<?php echo $cat_name_xss ?>" href="<?php echo '/shop/' . $url_segment . '/cat/' . $item->cat_id . '-' . $cat_name_slug; ?>">
                <?php echo trim($item->cat_name); ?>
            </a>
        </h3>
<!--        <p>9 sản phẩm</p>-->
    </div>
</div>
<!--<li>-->
<!--    --><?php //if ($category->child > 0) { ?>
<!--        <span>--><?php //echo $category->cat_name; ?><!--</span>-->
<!--        <ul class="list-unstyled" >-->
<!--            --><?php //foreach ($category->child as $item) { ?>
<!--                <li><a href="--><?php //echo '/shop/' . $url . '/cat/' . $item->cat_id . '-' . RemoveSign($item->cat_name); ?><!--">--><?php //echo $item->cat_name; ?><!--</a></li>-->
<!--            --><?php //} ?>
<!--        </ul>-->
<!--    --><?php //} else { ?>
<!--        <a style="font-size: 14px; font-weight: normal;" href="--><?php //echo '/shop/' . $url . '/cat/' . $category->cat_id . '-' . RemoveSign($category->cat_name); ?><!--">--><?php //echo $category->cat_name; ?><!--</a>-->
<!--    --><?php //} ?>
<!--</li>-->
