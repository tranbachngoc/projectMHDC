<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
		<?php echo $detail_docs->not_title ?>
	    </h4>
	    <p><i class="fa fa-calendar fa-fw"></i> <?php echo date('d/m/Y', $detail_docs->not_begindate); ?></p>
	    <div class="content">
		<?php
		$content_detail = html_entity_decode($detail_docs->not_detail);
		$content_detail = str_replace('&lt;iframe', '<iframe', $content_detail);
		$vovel = array("&curren;");
		echo $content_detail;
		?>
	    </div>
	    <div class="share-links">
		<a data-original-title="Tweet It" href="http://twitter.com/home?status=http://demo.lkvsolutions.com/azibai/chi-tiet-bai-viet.html" class="fa fa-twitter"> <span class="visuallyhidden">Twitter</span></a>
		<a data-original-title="Share at Facebook" href="http://www.facebook.com/sharer.php?u=http://demo.lkvsolutions.com/azibai/chi-tiet-bai-viet.html" class="fa fa-facebook"> <span class="visuallyhidden">Facebook</span></a>
		<a data-original-title="Share at Google+" href="http://plus.google.com/share?url=http://demo.lkvsolutions.com/azibai/chi-tiet-bai-viet.html" class="fa fa-google-plus"> <span class="visuallyhidden">Google+</span></a>
		<a data-original-title="Share at LinkedIn" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://demo.lkvsolutions.com/azibai/chi-tiet-bai-viet.html" class="fa fa-linkedin"> <span class="visuallyhidden">LinkedIn</span></a>
		<a data-original-title="Share via Email" href="mailto:?subject=1% ng??i giàu n?m n?a tài s?n th? gi?i&amp;body=http://demo.lkvsolutions.com/azibai/chi-tiet-bai-viet.html" class="fa fa-envelope-o"> <span class="visuallyhidden">Email</span></a>
	    </div>
	    <div class="clearfix"></div>
	</div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
