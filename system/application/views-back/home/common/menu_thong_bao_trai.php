
	<td valign="top">

<div class="temp_2" style="width:180px;">
      <div class="title">
        <div class="fl"></div>
        <div class="fc">
          <h3><a href="<?php echo base_url(); ?>raovat">Bài viết liên quan</a></h3>
        </div>
        <div class="fr"></div>
      </div>
      <div class="content">
        <div class="list_link">
            <ul>
          <?php $inotify=0; foreach($listNotifyMenu as $item){
			  if($inotify==15) break;
			   ?>
            <li><a href="<?php echo base_url() ?>thongbao/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>" ><?php echo $item->not_title; ?></a>
            </li>           
            <?php $inotify++; } ?>
          </ul>
        </div>
        <div class="view_all"><a href="<?php echo base_url(); ?>thongbao/tatca">Xem tất cả</a></div>
        <div class="clear"></div>
      </div>
      <div class="bottom">
        <div class="fl"></div>
        <div class="fr"></div>
      </div>
    </div>
    </td>

