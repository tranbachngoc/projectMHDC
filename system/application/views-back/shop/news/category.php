<?php $this->load->view('shop/common/header');?>
<!-- Start WOWSlider.com HEAD section -->
<link rel="stylesheet" type="text/css" href="/templates/engine1/style.css" />
<script type="text/javascript" src="/templates/engine1/wowslider.js"></script>
<script type="text/javascript" src="/templates/engine1/script.js"></script>

<!-- End WOWSlider.com HEAD section -->
<style>
body {
    background: #e9ebee;
    font-family: 'Segoe UI', sans-serif;
}
</style>
<link href="/templates/home/lightgallery/dist/css/lightgallery.css" rel="stylesheet" type="text/css" />
<?php
if (isset($siteGlobal)): 
    ##View logo AZIBAI when client go azibai.com
    $c = '//'.domain_site.'/';
    if(strpos($_SERVER['HTTP_REFERER'], $c)){ $_SESSION['fromazibai'] = 1; } 
    if($_SESSION['fromazibai'] == 1) { $classhidden = ""; } else { $classhidden = "hidden"; }
    ?>	
    <?php $this->load->view('shop/common/menubar'); ?>	
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-4 hidden-xs" > 
                <?php $this->load->view('shop/common/menu'); ?>
            </div> 
            <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12">
                
                <?php $this->load->view('shop/common/shopinfo'); ?>
                
                <div class="newfeeds">
                    <?php foreach ($list_news as $k => $item) {  ?>                 
                        <?php $this->load->view('shop/news/item', array('item' => $item)); ?>
                    <?php } ?> 
                </div>
		
            </div>

            <div class="col-lg-3 col-md-3 clearfixonmobile">  
		<?php if(count($ds_tin_chon)>0) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Danh sách tin chọn</div>
                    <div class="panel-body" style="padding:0">
                       <ul class="nav dstinchon">
			    <?php foreach($ds_tin_chon as $item) :
				$number = 10;
				$content = str_replace("\n", "", strip_tags(preg_replace("/<img[^>]+\>/i", "", $item->not_title)));
				$item_title = $content;
				$array = explode(" ", $content);
				if (count($array) <= $number) {
				    $item_title = $content;
				}
				array_splice($array, $number);
				$item_title = implode(" ", $array) . " ...";

				$item_image ='/media/images/noimage.png';

				if ($item->not_image !=""):
					$item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/thumbnail_2_' . $item->not_image;
				endif;

				if($item->byshop->domain){
					$item_link = '//'.$item->byshop->domain.'/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title);
				} else {
					$item_link = '//'.$item->byshop->sho_link.'.'.domain_site.'/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title);
				} ?>
				<li>
					<a href="<?php echo $item_link ?>">
							<img class="pull-left img-circle" src="<?php echo $item_image ?>">
							<?php echo $item_title ?>
						</a>
						<?php if($this->session->userdata('sessionUser') == $siteGlobal->sho_user) {?>
							<button class="btn btn-danger btn-xs pull-right" onclick="bochontin(<?php echo $item->not_id ?>);"> X </button>
						<?php } ?>

				</li>
			   <?php endforeach; ?>
		      </ul>					  
                    </div>
		</div> 
		<?php } ?> 
	    </div> 

            <div class="col-lg-2 hidden-md hidden-sm hidden-xs">  
                <?php $this->load->view('home/common/ads_right'); ?>
            </div>                       
        </div>
    </div>
<?php endif; ?>

<script  src="/templates/home/js/newsfeeds.js"></script>
<script src="/templates/home/lightgallery/dist/js/lightgallery.js" type="text/javascript"></script>
<script src="/templates/home/lightgallery/js/lg-video.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
<script language="javascript">
    jQuery(function ($) {
        $('#pictures_gallery, #videos_gallery').lightGallery({
            selector: '.item',
            download: false
        });
    });
    $(document).ready(function() { 
        var itempost = $('.wowslider-container');
        var tolerancePixel = 300;
        function checkMedia(){
                // Get current browser top and bottom
                var scrollTop = $(window).scrollTop() + tolerancePixel;
                var scrollBottom = $(window).scrollTop() + $(window).height() - tolerancePixel;                
                itempost.each(function(index, el) {
                        var yTopMedia = $(this).offset().top;
                        var yBottomMedia = $(this).height() + yTopMedia;
                        if(scrollTop < yBottomMedia && scrollBottom > yTopMedia){                        
                           itempost.swipe( {                               
                                swipeLeft:function(event, direction, distance, duration, fingerCount) {
                                    $(this).find('.ws_play').trigger('click');	
                                },
                                swipeRight:function(event, direction, distance, duration, fingerCount) {
                                    $(this).find('.ws_play').trigger('click');	
                                },                                
                                threshold:0
                            });                 
                        } else { 
                            $(this).find('.ws_pause').trigger('click');
                        }                    
                });
        }
        $(document).on('scroll', checkMedia);
    }); 
</script>
<?php $this->load->view('shop/common/footer'); ?>

<?php if($this->session->userdata('sessionGroup') == AffiliateUser ) { ?>
    <!--Display call-->
    <?php 
        if($siteGlobal->sho_phone){
            $phonenumber = $siteGlobal->sho_phone;
        } elseif($siteGlobal->sho_mobile){
            $phonenumber = $siteGlobal->sho_mobile;
        }
        if($phonenumber){
        ?>    
        <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
            <div class="phonering-alo-ph-circle"></div>
            <div class="phonering-alo-ph-circle-fill"></div>            
            <div class="phonering-alo-ph-img-circle">
                <a href="tel:<?php echo $siteGlobal->sho_mobile; ?>">
                    <img data-toggle="modal" data-target=".bs-example-modal-md" src="//i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = '//i.imgur.com/v8TniL3.png';" onmouseout="this.src = '//i.imgur.com/v8TniL3.png';">
                </a>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>    
    <?php if($packId1 == true || $packId2 == true ) { ?>
        <?php if($packId1 == true){ //is Branch ?>
            <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
                <div class="phonering-alo-ph-circle"></div>
                <div class="phonering-alo-ph-circle-fill"></div>            
                <div class="phonering-alo-ph-img-circle for-affiliate">
                    <a href="<?php echo $mainURL .'register/affiliate/pid/'.$this->session->userdata('sessionUser'); ?>">
                        <img data-toggle="modal" data-target=".bs-example-modal-md" src="//i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = '//i.imgur.com/v8TniL3.png';" onmouseout="this.src = '//i.imgur.com/v8TniL3.png';">
                    </a>
                </div>
            </div>    
        <?php } else { ?> 
            <?php if($packId2 == true) { ?>
            <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
                <div class="phonering-alo-ph-circle"></div>
                <div class="phonering-alo-ph-circle-fill"></div>            
                <div class="phonering-alo-ph-img-circle for-affiliate">
                    <a href="<?php echo $mainURL .'register/affiliate/pid/'.$siteGlobal->sho_user; ?>">
                        <img data-toggle="modal" data-target=".bs-example-modal-md" src="//i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = '//i.imgur.com/v8TniL3.png';" onmouseout="this.src = '//i.imgur.com/v8TniL3.png';">
                    </a>
                </div>
            </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    
<?php } ?>       

