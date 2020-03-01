<div class="item moreBox">
    <div class="detail">
        <a href="<?=get_server_protocol() . domain_site . '/tintuc/detail/' . $item->not_id?>" target="_blank"> 
        <img src="<?php echo $item->image; ?>" onerror="image_error(this)" alt="">
        </a>
        <div class="text">
            <h3><a href="<?=get_server_protocol() . domain_site . '/tintuc/detail/' . $item->not_id?>" target="_blank"><?php echo $item->not_title;?></a></h3>
            <p><?php echo $item->detail;?></p>
            <div class="thaotac">
            <span class="xemthem "><img class="mt05" src="/templates/home/styles/images/svg/3dot_doc.svg" alt="more"></span>            
            <div class="show-more ">
                <ul class="show-more-detail">
                <?php if ($is_owner) { ?><li class="pin-node-collection" data-key="<?=$item->not_id?>"><a href="JavaScript:Void(0);">Ghim</a></li><?php } ?>
                    <li onclick="copyLink('<?php echo $item->not_id; ?>')"><a href="JavaScript:Void(0);">Sao chép link liên kết</a></li>
                </ul>
            </div>
            </div>
        </div>
    </div>
</div>