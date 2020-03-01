<div class="js-scroll-x mt15">
    <div class="tag-column-children">
        <?php if(!empty($category_child_selected) && !empty($category_parent)){ ?>
            <a href="<?php echo $url_item ?>library/links/<?php echo $category_parent['slug'] ?>"><span>Tất cả</span></a>
        <?php } else { ?>
            <span class="is-active">Tất cả</span>
        <?php } ?>
        <?php foreach ($categories_child as $child) {
            if(!empty($category_child_selected) && $category_child_selected == $child['id']){
                echo '<span class="is-active" data-id="' . $child['id'] . '">' . ucfirst($child['name']) . '</span>';
            }else{
                echo '<a href="'.$url_item.'library/links/'.$child['slug'].'"><span data-id="' . $child['id'] . '">' . ucfirst($child['name']) . '</span></a>';
            }
        } ?>
    </div>
</div>