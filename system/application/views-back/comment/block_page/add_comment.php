<div class="create-new-comment mobile">
	<div id="list-image-comment"></div>
	<div class="button-opencomment-text">
		<button>
			<img class="icon-img" src="/templates/home/styles/images/svg/arrow_right.svg">
		</button>
	</div>
	<div class="list-add-icon">
	  	<button>
	  		<img class="icon-img" src="/templates/home/styles/images/svg/takephoto.svg" alt="">
	  			<input type="file" class="add-image-comment" name="image" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv,image/*" multiple="true">
	  	</button>
	  	<button>
	  		<img class="icon-img" src="/templates/home/styles/images/svg/link_comment.svg" alt="">
	  	</button>
	  	<button>
	  		<img class="icon-img" src="/templates/home/styles/images/svg/emotion.svg" alt="">
	  	</button>
	  	<button class="button-add-product-comments">
	  		<img class="icon-img" src="/templates/home/styles/images/svg/product.svg" alt="">
	  	</button>
	</div>
	<div class="area-comment" data-status="close">
		<textarea name="" class="input-text-comment" id="commnet_content_<?=$id?>" ></textarea>
		<img class="icon-img" src="/templates/home/styles/images/svg/sendmess.svg" id="button-send-comment" alt="" onclick="sendcoment('<?=$id?>','<?=$parent_id?>')">
	</div>
</div>
<div id="modal-product" data-type="1">
	<div class="modal-product-header">
		<div class="button-back-product">
			<img class="icon-img" src="/templates/home/styles/images/svg/back.svg" alt="">
		</div>
		<h4><span>Sản Phẩm</span><img class="icon-img select-product-type" src="/templates/home/styles/images/svg/arrow_down.svg" alt=""></h4>
		<button id="seleted-products">Xong</button>
	</div>
	<div class="modal-product-body">
		<div class="search-form">
			<input type="text" class="comment-search-product" placeholder="Tìm kiếm sản phẩm">
			<img src="/templates/home/images/svg/search.svg" alt="" class="button-comment-search-product">
		</div>
		<div class="list-product">
			<div class="select-product-category">
				<select id="select-product-category" placeholder="Danh mục sản phẩm">
					<option value="" selected disabled hidden>Danh mục sản phẩm</option>
				</select>
			</div>
			<div class="select-coupon-category">
				<select id="select-coupon-category" placeholder="Danh mục Coupon">
					<option value="" selected disabled hidden>Danh mục Coupon</option>
				</select>
			</div>
		</div>
		<div id="list-product"></div>
	</div>
	<div class="modal-product-footer">
		<button id="show-product-chose">Sản phẩm đã chọn</button>
	</div>
</div>
<!-- Popup select -->
<div id="modal-category-product-select">
	<div class="modal-product-header">
		<div class="button-back-product">
			<img class="icon-img" src="/templates/home/styles/images/svg/back.svg" alt="">
		</div>
		<h4><span>Danh Mục Sản Phẩm</span><img class="icon-img select-product-type" src="/templates/home/styles/images/svg/arrow_down.svg" alt=""></h4>
		<button id="seleted-products">Xong</button>
	</div>
	<div class="modal-category-product-select-body">
		
	</div>
</div>
<!-- Popup select -->
<div id="modal-product-select">
	<div class="modal-product-select-body">
		
	</div>
</div>