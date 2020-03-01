<?php
global $idHome; 
$idHome=1;
?>
<?php $this->load->view('home/common/header'); ?>

<div class="container">
  <div id="main">
    <div class="col-lg-3">
      <?php $this->load->view('home/common/left_tintuc'); ?>
    </div>
    <div class="col-lg-9" >
      <div id="content">
        <h1> <?php echo $detail_content->not_title ?></h1>
       <p><i class="fa fa-calendar fa-fw"></i> <?php echo date('d/m/Y',$detail_content->not_begindate); ?></p>
        
        <div class="content">
          <?php //echo html_entity_decode($detail_content->not_detail) ?>
          <?php $vovel=array("&curren;"); echo html_entity_decode(str_replace($vovel,"#",$detail_content->not_detail)) ; ?>
        </div>

        <div class="share-links">
          <a data-original-title="Tweet It" href="http://twitter.com/home?status=http://demo.lkvsolutions.com/azibai/chi-tiet-bai-viet.html" class="fa fa-twitter"> <span class="visuallyhidden">Twitter</span></a>
          <a data-original-title="Share at Facebook" href="http://www.facebook.com/sharer.php?u=http://demo.lkvsolutions.com/azibai/chi-tiet-bai-viet.html" class="fa fa-facebook"> <span class="visuallyhidden">Facebook</span></a>
          <a data-original-title="Share at Google+" href="http://plus.google.com/share?url=http://demo.lkvsolutions.com/azibai/chi-tiet-bai-viet.html" class="fa fa-google-plus"> <span class="visuallyhidden">Google+</span></a>
          <a data-original-title="Share at LinkedIn" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://demo.lkvsolutions.com/azibai/chi-tiet-bai-viet.html" class="fa fa-linkedin"> <span class="visuallyhidden">LinkedIn</span></a>
          <a data-original-title="Share via Email" href="mailto:?subject=1% ng??i giàu n?m n?a tài s?n th? gi?i&amp;body=http://demo.lkvsolutions.com/azibai/chi-tiet-bai-viet.html" class="fa fa-envelope-o"> <span class="visuallyhidden">Email</span></a>
        </div>
        <div class="facebook-comment">
          <div class="fb-comments" data-href="http://demo.lkvsolutions.com/azibai/chi-tiet-bai-viet.html" data-width="870" data-numposts="5"></div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
