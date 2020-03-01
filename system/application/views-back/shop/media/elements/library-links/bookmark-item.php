<?php $default_img_bookmark = '/templates/home/styles/images/default/error_image_400x400.jpg'; ?>
<div class="js-scroll-x">
    <ul class="logos-item">
        <?php foreach ($bookmarks as $bookmark) {?>
            <li class="js_bookmark-item js_bookmark-item-<?php echo $bookmark->id ?>">
                <div class="logo">
                    <a href="<?php echo $bookmark->link ?>" target="_blank" ref="nofollow">
                        <img src="<?php echo $bookmark->icon ? $bookmark->icon : $default_img_bookmark ?>" alt="<?php echo htmlspecialchars($bookmark->name) ?>">
                    </a>
                    <span class="close js_remove-bookmark" data-id="<?php echo $bookmark->id ?>"><i class="fa fa-times-circle"></i></span>
                </div>
                <p><?php echo $bookmark->name ?></p>
            </li>
        <?php } ?>
    </ul>
</div>