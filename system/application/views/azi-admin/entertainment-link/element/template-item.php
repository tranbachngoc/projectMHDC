<!-- ICON -->
<!-- icon block left -->
<script id="js-icon-image-0" type="text/template">
	<div class="icon_featured clearfix block-left" data-animation="" data-delay="500" data-key="{{TIME}}">
		<div class="wrap-caption-icon  text-center">
		  <div class="icon border-black text-center">
		    <p class="js-part-icon">
		      <img src="{{URL}}" class="icon-inserted">
		      <span class="close js-remove-icon" data-key="{{TIME}}" ><img src="/templates/home/styles/images/svg/close03.svg" alt=""></span>
		      <a class="btn-edit js-edit-icon cursor-pointer" data-key="{{TIME}}">Chỉnh sửa</a>
		    </p>
		  </div>
		</div>
		<div class="infomation text-center">
		  <input type="hidden" name="block[0][object][2][data][{{KEY}}][video]" class="hidden js-icon-video" value="{{VIDEO}}">
		  <input type="hidden" name="block[0][object][2][data][{{KEY}}][image]" class="hidden js-icon-image" value="{{IMAGE}}">
		  <input type="hidden" name="block[0][object][2][data][{{KEY}}][position]" class="hidden js-icon-position" value="{{POSITION}}">
		  <input type="hidden" name="block[0][object][2][data][{{KEY}}][effect]" class="hidden js-icon-effect" value="{{EFFECT}}">
		  <p class="title"><input name="block[0][object][2][data][{{KEY}}][title]" type="text" class="form-control js-icon-title"></p>
		  <p class="desc"><textarea rows="4" name="block[0][object][2][data][{{KEY}}][description]" id="" class="form-control js-icon-description"></textarea></p>
		</div>
	</div>
</script>

<script id="js-icon-video-0" type="text/template">
	<div class="icon_featured clearfix block-left" data-animation="" data-delay="500" data-key="{{TIME}}">
		<div class="wrap-caption-icon text-center ">
		  <div class="icon border-black text-center">
		    <p class="js-part-icon">
		      <img src="/templates/home/styles/images/svg/play_video.svg" class="icon-pause">
		      <video class="icon-inserted" id="video_{{TIME}}" playsinline="" muted="false" autoplay="true" preload="metadata" controls="controls">
		        <source src="{{URL}}" type="video/mp4">
		      </video>
		      <span class="close js-remove-icon" data-key="{{TIME}}" ><img src="/templates/home/styles/images/svg/close03.svg" alt=""></span>
		      <a class="btn-edit js-edit-icon cursor-pointer" data-key="{{TIME}}">Chỉnh sửa</a>
		    </p>
		  </div>
		</div>
		<div class="infomation text-center">
		  <input type="hidden" name="block[0][object][2][data][{{KEY}}][video]" class="hidden js-icon-video" value="{{VIDEO}}">
		  <input type="hidden" name="block[0][object][2][data][{{KEY}}][image]" class="hidden js-icon-image" value="{{IMAGE}}">
		  <input type="hidden" name="block[0][object][2][data][{{KEY}}][position]" class="hidden js-icon-position" value="{{POSITION}}">
		  <input type="hidden" name="block[0][object][2][data][{{KEY}}][effect]" class="hidden js-icon-effect" value="{{EFFECT}}">
		  <p class="title"><input name="block[0][object][2][data][{{KEY}}][title]" type="text" class="form-control js-icon-title"></p>
		  <p class="desc"><textarea rows="4" name="block[0][object][2][data][{{KEY}}][description]" id="" class="form-control js-icon-description"></textarea></p>
		</div>
	</div>
</script>

<!-- icon block right -->
<script id="js-icon-image-2" type="text/template">                      
	<div class="icon_featured block-right  clearfix " data-animation="" data-delay="500" data-key="{{TIME}}">
		<div class="wrap-caption-icon text-center">
		  <div class="icon border-black text-center">
		    <p class="js-part-icon">
		      <img src="{{URL}}" class="icon-inserted">
		      <span class="close js-remove-icon" data-key="{{TIME}}" ><img src="/templates/home/styles/images/svg/close03.svg" alt=""></span>
		      <a class="btn-edit js-edit-icon cursor-pointer" data-key="{{TIME}}">Chỉnh sửa</a>
		    </p>
		  </div>
		</div>
		<div class="infomation text-center">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][data][{{KEY}}][video]" class="hidden js-icon-video" value="{{VIDEO}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][image]" class="hidden js-icon-image" value="{{IMAGE}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][position]" class="hidden js-icon-position" value="{{POSITION}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][effect]" class="hidden js-icon-effect" value="{{EFFECT}}">
		  <p class="title"><input name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][title]" type="text" class="form-control js-icon-title"></p>
		  <p class="desc"><textarea rows="4" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][description]" id="" class="form-control js-icon-description"></textarea></p>
		</div>
	</div>
</script>

<script id="js-icon-video-2" type="text/template"> 
	<div class="icon_featured block-right  clearfix " data-animation="" data-delay="500" data-key="{{TIME}}">
		<div class="wrap-caption-icon text-center">
		  <div class="icon border-black text-center">
		    <p class="js-part-icon">
		      <img src="/templates/home/styles/images/svg/play_video.svg" class="icon-pause">
		      <video class="icon-inserted" id="video_{{TIME}}" playsinline="" muted="false" autoplay="true" preload="metadata" controls="controls">
		        <source src="{{URL}}" type="video/mp4">
		      </video>
		      <span class="close js-remove-icon" data-key="{{TIME}}" ><img src="/templates/home/styles/images/svg/close03.svg" alt=""></span>
		      <a class="btn-edit js-edit-icon cursor-pointer" data-key="{{TIME}}">Chỉnh sửa</a>
		    </p>
		  </div>
		</div>
		<div class="infomation text-center">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][video]" class="hidden js-icon-video" value="{{VIDEO}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][image]" class="hidden js-icon-image" value="{{IMAGE}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][position]" class="hidden js-icon-position" value="{{POSITION}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][effect]" class="hidden js-icon-effect" value="{{EFFECT}}">
		  <p class="title"><input name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][title]" type="text" class="form-control js-icon-title"></p>
		  <p class="desc"><textarea rows="4" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][description]" id="" class="form-control js-icon-description"></textarea></p>
		</div>
	</div>
</script>

<!-- icon block center -->
<script id="js-icon-image-1" type="text/template"> 
	<div class="icon_featured block-center  clearfix mb10 mb30" data-animation="" data-delay="500" data-key="{{TIME}}">
		<div class="wrap-caption-icon text-center">
		  <div class="icon border-black text-center">
		    <p class="js-part-icon">
		      <img src="{{URL}}" class="icon-inserted">
		      <span class="close js-remove-icon" data-key="{{TIME}}" ><img src="/templates/home/styles/images/svg/close03.svg" alt=""></span>
		      <a class="btn-edit js-edit-icon cursor-pointer" data-key="{{TIME}}">Chỉnh sửa</a>
		    </p>
		  </div>
		</div>
		<div class="infomation text-center">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][video]" class="hidden js-icon-video" value="{{VIDEO}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][image]" class="hidden js-icon-image" value="{{IMAGE}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][position]" class="hidden js-icon-position" value="{{POSITION}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][effect]" class="hidden js-icon-effect" value="{{EFFECT}}">
		  <p class="title"><input name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][title]" type="text" class="form-control js-icon-title"></p>
		  <p class="desc"><textarea rows="4" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][description]" id="" class="form-control js-icon-description"></textarea></p>
		</div>
	</div>
</script>

<script id="js-icon-video-1" type="text/template"> 
	<div class="icon_featured block-center  clearfix mb10 mb30" data-animation="" data-delay="500" data-key="{{TIME}}">
		<div class="wrap-caption-icon text-center">
		  <div class="icon border-black text-center">
		    <p class="js-part-icon">
		      <img src="/templates/home/styles/images/svg/play_video.svg" class="icon-pause">
		      <video class="icon-inserted" id="video_{{TIME}}" playsinline="" muted="false" autoplay="true" preload="metadata" controls="controls">
		        <source src="{{URL}}" type="video/mp4">
		      </video>
		      <span class="close js-remove-icon" data-key="{{TIME}}" ><img src="/templates/home/styles/images/svg/close03.svg" alt=""></span>
		      <a class="btn-edit js-edit-icon cursor-pointer" data-key="{{TIME}}">Chỉnh sửa</a>
		    </p>
		  </div>
		</div>
		<div class="infomation text-center">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][video]" class="hidden js-icon-video" value="{{VIDEO}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][image]" class="hidden js-icon-image" value="{{IMAGE}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][position]" class="hidden js-icon-position" value="{{POSITION}}">
		  <input type="hidden" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][effect]" class="hidden js-icon-effect" value="{{EFFECT}}">
		  <p class="title"><input name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][title]" type="text" class="form-control js-icon-title"></p>
		  <p class="desc"><textarea rows="4" name="block[{{BLOCK_ID}}][object][{{OBJECT_ID}}][{{KEY}}][description]" id="" class="form-control js-icon-description"></textarea></p>
		</div>
	</div>
</script>

<script id="js-icon-image-part" type="text/template"> 
<img src="{{URL}}" class="icon-inserted">
<span class="close js-remove-icon" data-key="{{TIME}}" ><img src="/templates/home/styles/images/svg/close03.svg" alt=""></span>
<a class="btn-edit js-edit-icon edit cursor-pointer" data-key="{{TIME}}">Xong</a>
</script>

<script id="js-icon-video-part" type="text/template"> 
<img src="/templates/home/styles/images/svg/play_video.svg" class="icon-pause">
<video class="icon-inserted" id="video_{{TIME}}" playsinline="" muted="false" autoplay="true" preload="metadata" controls="controls">
<source src="{{URL}}" type="video/mp4">
</video>
<span class="close js-remove-icon" data-key="{{TIME}}" ><img src="/templates/home/styles/images/svg/close03.svg" alt=""></span>
<a class="btn-edit js-edit-icon edit cursor-pointer" data-key="{{TIME}}">Xong</a>
</script>

<!-- END ICON -->


<!-- TEMPLATE ITEM SLIDER -->
<script id="js-item-image-slider" type="text/template">
<li class="item-slider-link">
  <input type="hidden" class="js-image-lib" name="block[0][object][0][data][{{KEY}}][image]" value="{{IMAGE}}">
  <input type="hidden" class="js-video-lib" name="block[0][object][0][data][{{KEY}}][video]" value="{{VIDEO}}">
  <img class="object-fit-cover imgAdded" src="{{URL}}">
  <span class="close">
    <img src="/templates/home/styles/images/svg/close03.svg" class="js-remove-item-slider">
  </span>
</li>
</script>

<script id="js-item-video-slider" type="text/template">
<li class="item-slider-link">
  <input type="hidden" class="js-image-lib" name="block[0][object][0][data][{{KEY}}][image]" value="{{IMAGE}}">
  <input type="hidden" class="js-video-lib" name="block[0][object][0][data][{{KEY}}][video]" value="{{VIDEO}}">
  <video class="object-fit-cover imgAdded" playsinline="" muted="false" autoplay="true" preload="metadata" controls="controls">
    <source src="{{URL}}" type="video/mp4">
  </video>
  <span class="close">
    <img src="/templates/home/styles/images/svg/close03.svg" class="js-remove-item-slider">
  </span>
</li>
</script>
<!-- END ITEM SLIDER -->

