<?php
$config_custom = $this->config->item('library_link_config');
$type_tbl = $item['type_tbl'] == 'tbtt_lib_links' ? 'library-link' 
            : ($item['type_tbl'] == 'tbtt_content_links' ? 'content-link' 
            : ($item['type_tbl'] == 'tbtt_content_image_links' ? 'image-link' : '' ));
?>

<div class="item moreBox">
    <div class="detail">
        <?php if(!$item['video']) { ?>
        <div class="img-link">
            <a href="<?php echo $shop_url . $type_tbl . '/' . $item['id'] ?>">
                <img src="<?php echo $item['image'] ? $config_custom['cloud_server_show_path'] . '/' . $item['image'] : $item['link_image'] ?>" alt="" onerror="image_error(this)">
            </a>
        </div>
        <?php } else { ?>
        <div class="img-link">
            <a target="_blank" href="<?php echo $shop_url . $type_tbl . '/' . $item['id'] ?>">
                <div class="wrap-video-item-single">
                    <video poster="<?=$config_custom['cloud_server_show_path'] . '/' .$item['image']?>" playsinline="" preload="none">
                        <source src="<?=$config_custom['cloud_server_show_path'] . '/' . $item['video']?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="btn-pause">
                        <img src="/templates/home/styles/images/svg/play_video.svg" alt="action video">
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
        <div class="text">
            <h3 class="one-line"><a href="<?=$item['link']?>" target="_blank"><?php echo "Nguồn: ".$item['host'];?></a></h3>
            <h3 class="one-line"><a href="<?=$item['link']?>" target="_blank"><?php echo $item['link_title'];?></a></h3>
            <div class="thaotac">
            <span class="xemthem "><img class="mt05" src="/templates/home/styles/images/svg/3dot_doc.svg" alt="more"></span>
            <div class="show-more ">
                <ul class="show-more-detail">
                <!-- <?php if ($is_owner) { ?><li class="pin-node-collection" data-key="<?=$item->cus_link_id ? $item->cus_link_id : ( $item->lib_link_id ? $item->lib_link_id : '' )?>" data-linkfrom="<?=$item->cus_link_id ? 'cus_link' : ( $item->lib_link_id ? 'lib_link' : '' )?>"><a href="JavaScript:Void(0);">Ghim</a></li><?php } ?> -->
                    <li onclick="copy_text('<?php echo $shop_url . $type_tbl . '/' . $item['id'] ?>')"><a href="JavaScript:Void(0);">Sao chép link liên kết</a></li>
                <?php if ($is_owner) { ?>
                    <li class="edit-lk" 
                        data-key="<?=$item['id']?>"
                        data-tbl="<?=$type_tbl?>"
                        data-title="<?=$item['link_title']?>"
                        data-description="<?=$item['link_description']?>"
                        data-detail="<?=str_replace("\"","'",$item['description'])?>"
                        data-img="<?=$config_custom['cloud_server_show_path'] . '/' .$item['image']?>"
                        data-source="<?=$item['video'] ? $config_custom['cloud_server_show_path'] . '/' . $item['video'] : ($item['image'] ? $config_custom['cloud_server_show_path'] . '/' . $item['image'] : $item['link_image']) ?>"
                        data-sourceType="<?=$item['video'] ? 'video' : ($item['image'] ? 'image' : '') ?>">
                        <a href="JavaScript:Void(0);">Chỉnh sữa nội dung</a>
                    </li>
                <?php } ?>
                </ul>
            </div>
            </div>
        </div>
    </div>
</div>