<?php $this->load->view('flatform/common/header_shop'); ?>
<div class="container" role="main"> 
    <br>
    <div class="row">
	<div class="col-sm-3">
	    <div class="list-group">
		<?php 
                foreach ($categories as $key => $value) { 
                    if($value->cat_id == $catcurent) { $catname = $value->cat_name; }					
                ?>
		    <a class="list-group-item <?php echo $value->cat_id == $catcurent ? 'active': ''; ?>"
                       href="/flatform/coupon/cat/<?php echo $value->cat_id.'/'. RemoveSign($value->cat_name);?>">
			   <?php echo $value->cat_name ?>
		    </a>
		<?php } ?>
	    </div>	    
	</div>
	<div class="col-sm-9">
	    <h4 class="page-header text-uppercase" style="margin-top: 10px;">
		<?php 
		if($this->uri->segment(2) == 'favorite_cou') {
		    echo 'Coupon yêu thích';
		} else {
		    echo $catname;
		}						
		?>
	    </h4>
	    <?php
            if(count($listProduct) > 0)
            {
            ?>
                <div class="row">
                    <?php
                        foreach ($listProduct as $product) {
                            $afSelect = false;
                            $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                            ?>
                        <div class="col-sm-3 col-xs-6">
                                <?php $this->load->view('flatform/coupons/product-item', array('product' => $product, 'discount' => $discount)); ?>
                        </div>                        
                        <?php 
                        }
                        ?>
                </div>
                <div class="linkPage"><?php echo $linkPage; ?></div>
            <?php
            }
            else{ ?>
                <div class="col-sm-12 col-xs-12">
                        Không có coupon nào.
                </div>                
            <?php } ?>
	</div>
    </div>

</div>
<style>
.pagination li span {
    background: #eee;
}  
</style>

<?php $this->load->view('flatform/common/footer'); ?>