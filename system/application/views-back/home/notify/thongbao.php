<tr>
<td>
<div class="temp_2 mod_notice">
      <div class="title">
        <div class="fl"></div>
        <div class="fc">
          <h3><a href="<?php echo base_url() ?>thongbao/tatca" style="color:#E77E03" >THÔNG BÁO</a></h3>
        </div>
        <div class="fr"></div>
      </div>
      <div class="content">
        <div class="list_link">
          <ul>
          <?php $inotify=0; foreach($listNotify as $item){
			  if($inotify==5) break;
			   ?>
            <li><a href="<?php echo base_url() ?>thongbao/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>" ><?php echo $item->not_title; ?></a>
            </li>           
            <?php $inotify++; } ?>
          </ul>
        </div>
        <div class="view_all"><a href="<?php echo base_url() ?>thongbao/tatca" class="text_link"><?php echo $this->lang->line('view_all_right'); ?></a></div>
        <div class="clear"></div>
      </div>
      <div class="bottom">
        <div class="fl"></div>
        <div class="fr"></div>
      </div>
    </div>
</td>
</tr>