<div class="comment-item-detail <?=$sClass?>">
    <div class="avata">
      <img src="<?=$oComment->avatar?>" alt="">
    </div>
    <div class="detail">
      	<div class="show-name">
        	<p class="name two-lines"><?=$oComment->use_fullname?><img class="eyes" src="templates/home/styles/images/svg/infomation-icon.png" alt=""></p>
      	</div>
      	<!-- <div class="replied-txt">
      	</div> -->
      	<div class="time"><?=$oComment->created_at?><img src="templates/home/styles/images/svg/quadiacau.svg" class="icon" alt="">
        <?php if($oComment->reply_to != '') { ?>
          <div class="reply_to"><p><?=$oComment->reply_to?></p></div>
        <?php } ?>
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
				<?php $this->load->view('comment/block/items_pro_fs', ['products'=>$oComment->products]); ?>
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
                <img src="templates/home/styles/images/svg/like.svg" class="icon" alt=""><?=$oComment->count_likes?>
              </li>
              <li>
                <img onclick='openchild(<?=json_encode($oComment)?>)' src="templates/home/styles/images/svg/comment.svg" class="icon" alt=""><?=$oComment->count_children?>
              </li>
              <li>
                <img src="templates/home/styles/images/svg/share.svg" class="icon" alt="">
              </li>
              <li>
                <img src="templates/home/styles/images/svg/3dot_border.png" class="icon-3dot" alt="">
              </li>
            </ul>
        </div>
        <?php if(!empty($oComment->aListInclude)) {?>
          <div class="comment-list-include">
            <ul>
              <?php foreach ($oComment->aListInclude as $iKUser => $oUser) { ?>
                <li><img src="<?=$oUser->avatar?>"></li>
              <?php } ?>
            </ul>
            <p>Xem tất cả bình luận</p>
          </div>
        <?php } ?>
    </div>
</div>