<div class="js-scroll-x">
    <div class="tag-column-parent">
        <?php if(!empty($category_parent_selected) || (!empty($slug) && $slug == 'moi-nhat')){ ?>
            <a href="<?php echo $url_item ?>library/links"><span>Tất cả</span></a>
        <?php } else { ?>
            <span class="is-active">Tất cả</span>
        <?php }

        if(!empty($slug) && $slug == 'moi-nhat'){
            echo '<span class="is-active">Mới nhất</span>';
        }else{
            echo '<a href="'.$url_item.'library/links/moi-nhat"><span>Mới nhất</span></a>';
        }
        foreach ($categories as $category) {
            if(!empty($category_parent_selected) && $category_parent_selected == $category['id']){
                echo '<span class="is-active" data-id="' . $category['id'] . '">' . ucfirst($category['name']) . '</span>';
            }else{
                echo '<a href="'.$url_item.'library/links/'.$category['slug'].'"><span data-id="' . $category['id'] . '">' . ucfirst($category['name']) . '</span></a>';
            }
        } ?>
    </div>
</div>