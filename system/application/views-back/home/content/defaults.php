<?php $this->load->view('home/common/login/header'); ?>
<div id="main" class="container-fluid">
    <div class="row">
	
	<div class="col-lg-3">
	    <?php $this->load->view('home/common/huong_dan.php');  ?>
	</div>
	<div class="col-lg-9">
	    
	    
	  <div class="article boxwhite">
	    <h1 class="not_title"><?php echo $notify->not_title; ?></h1>	
	    <hr/>
	    <div class="not_content">
		<?php
		$vowels = array("&curren;");
		$detail = htmlspecialchars_decode(html_entity_decode(str_replace($vowels, "#", $notify->not_detail)));
		$detail = str_replace('&lt;iframe', '<iframe', $detail);
		echo $detail;
		?>
	    </div>
	    
	</div>
	</div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>