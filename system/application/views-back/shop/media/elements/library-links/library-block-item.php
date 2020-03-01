<div class="list-link-content">
    <div class="newest-post">
        <?php
        $temp_img = $data[0]['image'];
        if ($data[0]['image_path']) {
            $temp_img = $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $data[0]['image_path'];
        }
        ?>
        <div class="img">
            <img onerror="image_error(this)"  src="<?php echo $temp_img ?>" alt="<?php echo htmlspecialchars($data[0]['title'])?>">
        </div>
        <div class="head">
            <?php if(empty($category)){ ?>
                <p class="tit">Mới nhất</p>
                <a href="<?php echo $url_item ?>library/links/tat-ca">Xem tất cả</a>
            <?php } else {
                echo '<p class="tit">'.ucfirst($category['name']).'</p>';
                echo '<a href="'.$url_item.'library/links/'.$category['slug'].'">Xem tất cả</a>';
            }?>
        </div>
        <div class="text">
            <a ref="nofollow" href="<?php echo $data[0]['save_link']?>">
                <p class="text-bold">Nguồn: <?php echo $data[0]['host']?></p>
                <h3 class="one-line"><?php echo $data[0]['title']?></h3>
            </a>
        </div>
    </div>
    <div class="socials-logos">
        <?php if(!empty($categories_child)){
            $this->load->view('shop/media/elements/library-links/library-link-category-parent', [
                'categories' => $categories_child
            ]);
        } ?>
    </div>
    <div class="grid">
        <?php foreach ($data as $index => $item) {
            if ($index == 0) continue;
            $this->load->view('shop/media/elements/library-links/library-item', [
                'item'           => $item,
                'is_owns'       => $is_owns,
                'server_media'  => $server_media,
            ]);
        } ?>
    </div>
</div>