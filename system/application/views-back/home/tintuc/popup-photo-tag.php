<link href="/templates/home/css/addnews-v2.css" type="text/css" rel="stylesheet" />
<link href="/templates/home/styles/css/fs-gal.css" type="text/css" rel="stylesheet" />


<div class="fs-gal-view">
    <!-- <img class="fs-gal-close" src="/templates/home/images/tag-photo/close.svg" alt="Close gallery" title="Close gallery" /> -->
    <img class="fs-gal-close" src="/templates/home/styles/images/svg/552.svg" alt="Close gallery" title="Quay lại" />
    <div class="fs-gal-view-img">
        <div class="image-tag-recs-close" data-compid="close_btn">
          <span class="image-tag-recs-close__text text-xxs">Đóng
            <span class="hzi-font hzi-CloseX image-tag-recs-close-x" aria-hidden="true"></span>
          </span>
        </div>
        <img class="fs-gal-prev fs-gal-nav" src="/templates/home/styles/images/svg/557.svg" alt="Previous picture" title="Previous picture" />
        <img class="fs-gal-next fs-gal-nav" src="/templates/home/styles/images/svg/556.svg" alt="Next picture" title="Next picture" />
        <div class="taggd">
          <img  class="fs-gal-main" src="" alt="">
        </div>
    </div>
    <div class="fs-gal-view-detail">
        <ul class="slider product-slider">
            
        </ul>
    </div>
    
</div>

<script id="js-link-photo-tag" type="text/template">
  <li>
      <a href="{{LINK_TAG}}" target="_blank">
        <div class="images">
          <img src="{{IMAGE_LINK_TAG}}" alt="">
        </div>
        <div class="text">  
          <p style="color: white">{{TITLE_LINK_TAG}}</p>
          <div class="sale-price">{{DOMAIN_TAG}}</div>
        </div>
      </a>
  </li>
</script>

<script src="/templates/home/js/addnews-preview-v2.js"></script>
<script src="/templates/home/styles/js/fs-gal.js"></script>

<style type="text/css">
  .image-tag-recs-close {
    position: absolute;
    left: 25px;
    bottom: 0px;
    color: #ababab;
    z-index: 1;
    cursor: pointer;
    padding-top: 5px;
  }
  .image-tag-recs-close:hover { color: #fff }

  .image-tag-recs-close:before {
    content: "";
    position: absolute;
    top: 0;
    right: -10px;
    bottom: 0;
    left: -10px;
    z-index: -1;
    background: rgba(0, 0, 0, 0.8);
    border-radius: .2em .2em 0 0;
    transform: perspective(.5em) rotateX(5deg) translateZ(-.5px);
    -webkit-box-shadow: 0 -1px 3px 0 rgba(0,0,0,.08);
    -moz-box-shadow: 0 -1px 3px 0 rgba(0,0,0,.08);
    box-shadow: 0 -1px 3px 0 rgba(0,0,0,.08);
  }
</style>