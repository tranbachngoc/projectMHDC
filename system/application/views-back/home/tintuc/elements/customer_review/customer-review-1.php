<style type="text/css">
	.customer-type-1 .title-wrap:before {
	    border-bottom: 175px solid transparent;
	    border-left: 40px solid <?=$sStyleBackground?>;
	    right: -40px;
	    top: 0;
	}
</style>
<ul class="owl-carousel text-center customer-type-1" id="customer">
    <?php foreach ($not_customer->cus_list as $key => $customer) { ?>
        <?php $html_modal_customer .= $this->load->view('home/tintuc/elements/customer-review-more', [
            'index'         => $key,
            'customer'      => $customer,
            'not_dir_image' => $item->not_dir_image,
            'cus_title'     => $not_customer->cus_title,
            'cus_type'      => (isset($not_customer->cus_type)) ? $not_customer->cus_type : 0,
        ] , true); ?>
        <li class="item animated hiding" data-animation="fadeInDown" data-delay="500">
        	<div class="box-wrapper">
                <div class="title-wrap slopy" style="<?=$sStyle?>">
                    <h5><?php echo $this->filter->reinjection($customer->cus_text1) ?></h5>
                    <h6><?php echo $this->filter->reinjection($customer->cus_text2) ?></h6>
                    <div class="social">
                        <ul class="list-inline">
                        	<?php if ($customer->cus_facebook){ ?>
                            	<li>
                            		<a target="_blank" href="<?php echo htmlspecialchars($customer->cus_facebook) ?>">
				                        <img src="/templates/home/styles/images/svg/facebook.svg" alt="">
				                    </a>
                            	</li>
                            <?php } ?>
                            <?php if ($customer->cus_google){ ?>
                            	<li>
				                    <a target="_blank" href="<?php echo htmlspecialchars($customer->cus_google) ?>">
				                        <img src="/templates/home/styles/images/svg/google.svg" alt="">
				                    </a>
				                </li>
			                <?php } ?>
			                <?php if ($customer->cus_twitter){ ?>
			                	<li>
				                    <a target="_blank" href="<?php echo htmlspecialchars($customer->cus_twitter) ?>">
				                        <img src="/templates/home/styles/images/svg/twister.svg" alt="">
				                    </a>
				                </li>
			                <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="circle-wrap">
                	<?php if ($customer->cus_link) { ?>
	                    <a href="<?php echo $customer->cus_link ?>" target="_blank">
	                        <img class="img-circle" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $customer->cus_avatar ?>"
	                             alt="<?php echo $customer->cus_text1 ?>">
	                    </a>
	                <?php } else { ?>
	                    <img class="img-circle" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $customer->cus_avatar ?>"
	                         alt="<?php echo $customer->cus_text1 ?>">
	                <?php } ?>
                </div>
            </div>
            <p class="des"><?php echo $this->filter->reinjection($customer->cus_text3) ?></p>
            <div class="xemthem btn-show-comment-customer" data-toggle="modal" data-target="#modal_<?php echo $index_customer ?>">Xem thêm</div>
        </li>
    <?php } ?>
</ul>