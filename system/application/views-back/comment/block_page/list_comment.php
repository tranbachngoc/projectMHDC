<div class="show-list-comments">
    <div id="show-list-comment-details">
	    <?php if(isset($aListComment) && !empty($aListComment)) { ?>
	    	<?php foreach ($aListComment as $iKComment => $oComment) { ?>
	    		<?php
	    			$sClass = $oComment->class;
	    			if($iKComment == 0) {
	    				$sClass .= ' comment-bg-first';
	    			}else if(!isset($oComment->last)) {
	    				$sClass .= ' comment-bg-parent';
	    			}
	    		?>
	    		<?php if(isset($oComment->last) && !empty($oComment->last)) { ?>
	    			<div class="have-child">
	    		<?php } ?>
	    		<div class="comment-item-detail <?=$sClass?>">
		            <div class="avata">
		              <img src="<?=$oComment->avatar?>" alt="">
		            </div>
		            <div class="detail">
		              	<div class="show-name">
		                	<p class="name two-lines"><?=$oComment->use_fullname?><img class="eyes" src="templates/home/styles/images/svg/chu_i.svg" alt=""></p>
		              	</div>
		              	<?php if(isset($oComment->reply_to) && $oComment->reply_to != '') { ?>
		              		<div class="replied-txt">Đã trả lời cho <?=$oComment->reply_to?></div>
		              	<?php } ?>
		              	<div class="time"><?=$oComment->created_at?><img src="templates/home/styles/images/svg/quadiacau.svg" class="icon" alt="">
	              		</div>
		              	<div class="show-comment">
		              		<?=$oComment->comment?>
		              		<?php if(isset($oComment->images) && !empty($oComment->images)) { ?>
		              			<div class="image-gallery">
		                          	<?php $iNumnerImage = count($oComment->images); ?>
		                          	<?php foreach ($oComment->images as $iKImage => $oImage) { ?>
			                          	<?php if($iKImage+1 == $iNumnerImage) { ?>
			                          		<div class="img" data-toggle="modal" data-target="#modal-show-comment-images">
			                          			<img src="<?=$oComment->path.$oImage->path?>" alt="">
			                          		</div>
			                          	<?php } else { ?>
			                          		<div class="img">
				                          		<img src="<?=$oComment->path.$oImage->path?>" alt="">
				                          	</div>
			                          	<?php } ?>
			                        <?php } ?>
		                          	<?php if($iNumnerImage == 4) { ?>
		                          		<span class="plus-number show-slider-image-comment" data-id="<?=$oComment->comment_id?>">+<?=$oComment->number_image?></span>
		                          	<?php } ?>
		                        </div>
							<?php } ?>
							<?php if(isset($oComment->products) && !empty($oComment->products)) {?>
								<?php $this->load->view('comment/block_page/items_pro_fs', ['products'=>$oComment->products]); ?>
		              		<?php } ?>
		              		<?php if(isset($oComment->video) && $oComment->video != '') {?>
			              		<video id="video_comment_<?=$oComment->comment_id?>" playsinline muted="true" autoplay="true" class="comment-video" preload="metadata">
	                                <source src="<?php echo $oComment->video ?>"
	                                                        type="video/mp4">
	                                                Your browser does not support the video tag.
	                            </video>
                            <?php } ?>
		              	</div>
			            <div class="show-action">
			                <ul>
			                  <li>
			                    <img src="../templates/home/styles/images/svg/like.svg" class="icon" alt=""><?=$oComment->count_likes?>
			                  </li>
			                  <li>
			                  	<a href="<?=base_url();?>comment/<?=$id?>?comment_id=<?=$oComment->comment_id?>">
			                    	<img src="../templates/home/styles/images/svg/comment.svg" class="icon" alt=""><?=$oComment->count_children?>
			                	</a>
			                  </li>
			                  <li>
			                    <img src="../templates/home/styles/images/svg/share.svg" class="icon" alt="">
			                  </li>
			                  <li>
			                    <img src="../templates/home/styles/images/svg/3dot_border.svg" class="icon-3dot" alt="">
			                  </li>
			                </ul>
			            </div>
		            </div>
	          	</div>
	          	<!-- Comment last parent -->
	          	<?php if(isset($oComment->parent_of_last) && !empty($oComment->parent_of_last)) { ?>
	          		<?php $oCommentPLast = $oComment->parent_of_last;  ?>
	          		<div class="comment-item-detail <?=$oCommentPLast->class?>">
			            <div class="avata">
			              <img src="<?=$oCommentPLast->avatar?>" alt="">
			            </div>
			            <div class="detail">
			              	<div class="show-name">
			                	<p class="name two-lines"><?=$oCommentPLast->use_fullname?><img class="eyes" src="templates/home/styles/images/svg/chu_i.svg" alt=""></p>
			              	</div>
			              	<?php if(isset($oCommentPLast->reply_to) && $oCommentPLast->reply_to != '') { ?>
			              		<div class="replied-txt">Đã trả lời cho <?=$oCommentPLast->reply_to?></div>
			              	<?php } ?>
			              	<div class="time"><?=$oCommentPLast->created_at?><img src="templates/home/styles/images/svg/quadiacau.svg" class="icon" alt="">
		              		</div>
			              	<div class="show-comment">
			              		<?=$oCommentPLast->comment?>
			              		<?php if(isset($oCommentPLast->images) && !empty($oCommentPLast->images)) { ?>
			              			<div class="image-gallery">
			                          	<?php $iNumnerImage = count($oCommentPLast->images); ?>
			                          	<?php foreach ($oCommentPLast->images as $iKImage => $oImage) { ?>
				                          	<?php if($iKImage+1 == $iNumnerImage) { ?>
				                          		<div class="img" data-toggle="modal" data-target="#modal-show-comment-images">
				                          			<img src="<?=$oCommentPLast->path.$oImage->path?>" alt="">
				                          		</div>
				                          	<?php } else { ?>
				                          		<div class="img">
					                          		<img src="<?=$oCommentPLast->path.$oImage->path?>" alt="">
					                          	</div>
				                          	<?php } ?>
				                        <?php } ?>
			                          	<?php if($iNumnerImage == 4) { ?>
			                          		<span class="plus-number show-slider-image-comment" data-id="<?=$oCommentPLast->comment_id?>">+<?=$oCommentPLast->number_image?></span>
			                          	<?php } ?>
			                        </div>
								<?php } ?>
								<?php if(isset($oCommentPLast->products) && !empty($oCommentPLast->products)) {?>
									<?php $this->load->view('comment/block_page/items_pro_fs', ['products'=>$oCommentPLast->products]); ?>
			              		<?php } ?>
			              		<?php if(isset($oCommentPLast->video) && $oCommentPLast->video != '') {?>
				              		<video id="video_comment_<?=$oCommentPLast->comment_id?>" playsinline muted="true" autoplay="true" class="comment-video" preload="metadata">
		                                <source src="<?php echo $oCommentPLast->video ?>"
		                                                        type="video/mp4">
		                                                Your browser does not support the video tag.
		                            </video>
	                            <?php } ?>
			              	</div>
				            <div class="show-action">
				                <ul>
				                  <li>
				                    <img src="../templates/home/styles/images/svg/like.svg" class="icon" alt=""><?=$oCommentPLast->count_likes?>
				                  </li>
				                  <li>
				                  	<a href="<?=base_url();?>comment/<?=$id?>?comment_id=<?=$oCommentPLast->comment_id?>">
				                    	<img src="../templates/home/styles/images/svg/comment.svg" class="icon" alt=""><?=$oCommentPLast->count_children?>
				                	</a>
				                  </li>
				                  <li>
				                    <img src="../templates/home/styles/images/svg/share.svg" class="icon" alt="">
				                  </li>
				                  <li>
				                    <img src="../templates/home/styles/images/svg/3dot_border.svg" class="icon-3dot" alt="">
				                  </li>
				                </ul>
				            </div>
			            </div>
		          	</div>
	          	<?php } ?>
	          	<!-- Comment last -->
	          	<?php if(isset($oComment->last) && !empty($oComment->last)) { ?>
	          		<?php $oCommentLast = $oComment->last; ?>
	          		<div class="comment-item-detail <?=$oCommentLast->class?>">
			            <div class="avata">
			              <img src="<?=$oCommentLast->avatar?>" alt="">
			            </div>
			            <div class="detail">
			              	<div class="show-name">
			                	<p class="name two-lines"><?=$oCommentLast->use_fullname?><img class="eyes" src="templates/home/styles/images/svg/chu_i.svg" alt=""></p>
			              	</div>
			              	<?php if(isset($oCommentLast->reply_to) && $oCommentLast->reply_to != '') { ?>
			              		<div class="replied-txt">Đã trả lời cho <?=$oCommentLast->reply_to?></div>
			              	<?php } ?>
			              	<div class="time"><?=$oCommentLast->created_at?><img src="templates/home/styles/images/svg/quadiacau.svg" class="icon" alt="">
		              		</div>
			              	<div class="show-comment">
			              		<?=$oCommentLast->comment?>
			              		<?php if(isset($oCommentLast->images) && !empty($oCommentLast->images)) { ?>
			              			<div class="image-gallery">
			                          	<?php $iNumnerImage = count($oCommentLast->images); ?>
			                          	<?php foreach ($oCommentLast->images as $iKImage => $oImage) { ?>
				                          	<?php if($iKImage+1 == $iNumnerImage) { ?>
				                          		<div class="img" data-toggle="modal" data-target="#modal-show-comment-images">
				                          			<img src="<?=$oCommentLast->path.$oImage->path?>" alt="">
				                          		</div>
				                          	<?php } else { ?>
				                          		<div class="img">
					                          		<img src="<?=$oCommentLast->path.$oImage->path?>" alt="">
					                          	</div>
				                          	<?php } ?>
				                        <?php } ?>
			                          	<?php if($iNumnerImage == 4) { ?>
			                          		<span class="plus-number show-slider-image-comment" data-id="<?=$oCommentLast->comment_id?>">+<?=$oCommentLast->number_image?></span>
			                          	<?php } ?>
			                        </div>
								<?php } ?>
								<?php if(isset($oCommentLast->products) && !empty($oCommentLast->products)) {?>
									<?php $this->load->view('comment/block_page/items_pro_fs', ['products'=>$oCommentLast->products]); ?>
			              		<?php } ?>
			              		<?php if(isset($oCommentLast->video) && $oCommentLast->video != '') {?>
				              		<video id="video_comment_<?=$oCommentLast->comment_id?>" playsinline muted="true" autoplay="true" class="comment-video" preload="metadata">
		                                <source src="<?php echo $oCommentLast->video ?>"
		                                                        type="video/mp4">
		                                                Your browser does not support the video tag.
		                            </video>
	                            <?php } ?>
			              	</div>
				            <div class="show-action">
				                <ul>
				                  <li>
				                    <img src="../templates/home/styles/images/svg/like.svg" class="icon" alt=""><?=$oCommentLast->count_likes?>
				                  </li>
				                  <li>
				                  	<a href="<?=base_url();?>comment/<?=$id?>?comment_id=<?=$oCommentLast->comment_id?>">
				                    	<img src="../templates/home/styles/images/svg/comment.svg" class="icon" alt=""><?=$oCommentLast->count_children?>
				                	</a>
				                  </li>
				                  <li>
				                    <img src="../templates/home/styles/images/svg/share.svg" class="icon" alt="">
				                  </li>
				                  <li>
				                    <img src="../templates/home/styles/images/svg/3dot_border.svg" class="icon-3dot" alt="">
				                  </li>
				                </ul>
				            </div>
			            </div>
		          	</div>
	          	<?php } ?>
	          	<?php if(isset($oComment->last) && !empty($oComment->last)) { ?>
	    			</div>
	    		<?php } ?>
	    	<?php } ?>
	    <?php }else { ?>
	    	<div class="comment-first-inner">
	    		<p class="comment-first">Hãy là người bình luận đầu tiên</p>
	    	</div>
	    <?php } ?>
	</div>
</div>