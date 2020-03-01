<?php
// dd($item);die;
?>
<div class="item moreBox">
    <div class="detail">
        <a href="<?=get_server_protocol() . domain_site . '/'.$item->pro_category.'/'.$item->pro_id.'/'. str_replace(' ','-',$item->name)?><?=$af_id ? '?af_id='.$af_id : ''?>" target="_blank"> 
        <img src="<?php echo $item->image; ?>" alt="">
        </a>
        <div class="text">
            <h3><a href="<?=get_server_protocol() . domain_site . '/'.$item->pro_category.'/'.$item->pro_id.'/'. str_replace(' ','-',$item->name)?><?=$af_id ? '?af_id='.$af_id : ''?>" target="_blank"><?php echo $item->pro_name;?></a></h3>
            <p><?php echo $item->detail;?></p>
            <div class="thaotac">
            <span class="xemthem "><img class="mt05" src="/templates/home/styles/images/svg/3dot_doc.svg" alt="more"></span>            
            <div class="show-more ">
                <ul class="show-more-detail">
                <?php if ($is_owner) { ?><li class="pin-node-collection" data-key="<?=$item->pro_id?>"><a href="JavaScript:Void(0);">Ghim</a></li><?php } ?>
                    <li onclick="copyLink('<?=$item->pro_id;?>','<?=$item->pro_category;?>','<?=str_replace(' ','-',$item->name);?>')"><a href="JavaScript:Void(0);">Sao chép link liên kết</a></li>
                </ul>
            </div>
            </div>
        </div>
    </div>
</div>