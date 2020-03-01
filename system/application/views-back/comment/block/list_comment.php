<?php if(isset($aListComment) && !empty($aListComment)) { ?>
<div class="infomation-user-comment">
  <div class="infomation-user-comment-inner">
    <div class="avatar">
      <img src="<?=$infomation_user['avatar']?>">
    </div>
    <div class="infomation-inner">
      <h3><?=$infomation_user['use_fullname']?></h3>
    </div>
  </div>
  <a class="link-detail" href="<?=$infomation_user['detail_link']?>">Xem chi tiết tin</a>
</div>
<?php } ?>
<div class="show-list-comments">
    <div id="show-list-comment-details">
    	<?php if(isset($aCommentP) && !empty($aCommentP)) { ?>
			<div class="comment-item-detail comment-bg-first">
		        <div class="avata">
		          <img src="<?=$aCommentP['avatar']?>" alt="">
		        </div>
		        <div class="detail">
		          	<div class="show-name">
		            	<p class="name two-lines"><?=$aCommentP['use_fullname']?><img class="eyes" src="templates/home/styles/images/svg/chu_i.svg" alt=""></p>
		          	</div>
		          	<!-- <div class="replied-txt">
		          	</div> -->
		          	<div class="time"><?=$aCommentP['created_at']?><img src="templates/home/styles/images/svg/quadiacau.svg" class="icon" alt="">
		      		</div>
		          	<div class="show-comment">
		          		<?=$aCommentP['comment']?>
		          		<?php if(isset($aCommentP['images']) && !empty($aCommentP['images'])) { ?>
		          			<div class="image-gallery">
		                      	<?php $iNumnerImage = count($aCommentP['images']); ?>
		                      	<?php foreach ($aCommentP['images'] as $iKImage => $oImage) { ?>
		                          	<?php if($iKImage+1 == $iNumnerImage) { ?>
		                          		<div class="img" data-toggle="modal" data-target="#modal-show-comment-images">
		                          			<img src="<?=$aCommentP['path'].$oImage->path?>" alt="">
		                          		</div>
		                          	<?php } else { ?>
		                          		<div class="img">
			                          		<img src="<?=$aCommentP['path'].$oImage->path?>" alt="">
			                          	</div>
		                          	<?php } ?>
		                        <?php } ?>
		                      	<?php if($iNumnerImage == 4) { ?>
		                      		<span class="plus-number show-slider-image-comment" data-id="<?=$aCommentP['comment_id']?>">+<?=$aCommentP['number_image']?></span>
		                      	<?php } ?>
		                    </div>
						<?php } ?>
						<?php if(isset($aCommentP['products']) && !empty($aCommentP['products'])) {?>
							<?php $this->load->view('comment/block/items_pro_fs', ['products'=>$aCommentP['products']]); ?>
		          		<?php } ?>
		          		<?php if(isset($aCommentP['video']) && $aCommentP['video'] != '') {?>
		              		<video id="video_comment_<?=$aCommentP['comment_id']?>" playsinline muted="true" autoplay="true" class="comment-video" preload="metadata">
		                        <source src="<?php echo $aCommentP['video'] ?>"
		                                                type="video/mp4">
		                                        Your browser does not support the video tag.
		                    </video>
		                <?php } ?>
		          	</div>
		        </div>
		  	</div>
		<?php } ?>
	    <?php if(isset($aListComment) && !empty($aListComment)) { ?>
	    	<?php foreach ($aListComment as $iKComment => $oComment) { ?>
	    		<?php
	    			$sClass = '';

	    			if($oComment->count_children >= 3 && isset($oComment->last)) {
						$sClass = 'comment-bg-dot';
    				}else {
    					$sClass = 'comment-bg-line';
    				}

    				if($iKComment == 0 && $get_type == 0) {
	    				$sClass .= ' comment-bg-first';
	    				if($oComment->count_children == 0) {
	    					$sClass = 'comment-bg-first no-reply';
	    				}
	    			}
	    		?>
	    		<?php 
	    			echo $this->load->view(
	    				'comment/block/comment-item', 
	    				array(
	    					'sClass' 	=> $sClass,
	    					'oComment'	=> $oComment
	    				)
	    			); 
	    		?>
	    		<?php if(isset($oComment->parent_of_last)) { ?>
					<?php 
						$sClass = 'comment-of-last comment-bg-line';
						echo $this->load->view(
							'comment/block/comment-item', 
							array(
								'sClass' 	=> $sClass,
								'oComment'	=> $oComment->parent_of_last
							)
						); 
					?>
				<?php } ?>
				<?php if(isset($oComment->last)) { ?>
					<?php
						$sClass = 'comment-bg-last'; 
						
						echo $this->load->view(
							'comment/block/comment-item', 
							array(
								'sClass' 	=> $sClass,
								'oComment'	=> $oComment->last
							)
						); 
					?>
				<?php } ?>
	    	<?php } ?>
	    <?php }else { ?>
	    	<?php if($get_type == 0) { ?>
	    		<div class="comment-first-inner">
		    		<p class="comment-first">Hãy là người bình luận đầu tiên</p>
		    	</div>
	    	<?php } ?>
	    <?php } ?>
	</div>
</div>