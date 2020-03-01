
          <?php $inotify=0; foreach($listNotify as $item){
			  if($inotify==5) break;
			   ?>
            <div><a href="<?php echo base_url() ?>thongbao/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>" ><?php echo $item->not_title; ?></a>
            </div>           
            <?php $inotify++; } ?>
          