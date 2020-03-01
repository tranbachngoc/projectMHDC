<div id="related-hosting">
  <div class="related-hosting-title">
  <div style="height:6px;"></div>
  <div class="related-hosting-title-border">Các loại phần mềm </div>
  </div>
  <ul class="related-hosting-list">

   <?php foreach($category_view_right as $item){
                
                   ?>
                   
                       <li class="related-hosting-item related_level_<?php echo $item->cat_level ?>"><a href="<?php echo base_url(); ?><?php echo $item->cat_id ?>/<?php echo RemoveSign($item->cat_name); ?>">
				
                       <?php echo cut_string_unicodeutf8($item->cat_name,30)  ?>
                      	   </a> 
                      
                       </li>
              
                <?php } ?>

  </ul>
</div>
