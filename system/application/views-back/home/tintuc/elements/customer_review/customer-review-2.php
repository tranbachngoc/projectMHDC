<ul class="owl-carousel text-center customer-type-2" id="customer">
    <?php foreach ($not_customer->cus_list as $key => $customer) { ?>
        <?php $html_modal_customer .= $this->load->view('home/tintuc/elements/customer-review-more', [
            'index'         => $key,
            'customer'      => $customer,
            'not_dir_image' => $item->not_dir_image,
            'cus_title'     => $not_customer->cus_title,
            'cus_type'      => (isset($not_customer->cus_type)) ? $not_customer->cus_type : 0,
        ] , true); ?>
        <li class="crsl-item">
            <div class="quote-box">
                <p class="quote-text"><?php echo $this->filter->reinjection($customer->cus_text3) ?></p>

                <p class="quote-name"><?php echo $this->filter->reinjection($customer->cus_text1) ?></p>
                <p class="postion-name"><?php echo $this->filter->reinjection($customer->cus_text2) ?></p>
                <div class="list-icon">
                    <?php if ($customer->cus_facebook){ ?>
                        <a target="_blank" href="<?php echo htmlspecialchars($customer->cus_facebook) ?>">
                            <img src="/templates/home/styles/images/svg/facebook.svg" alt="">
                        </a>
                    <?php } ?>
                    <?php if ($customer->cus_google){ ?>
                        <a target="_blank" href="<?php echo htmlspecialchars($customer->cus_google) ?>">
                            <img src="/templates/home/styles/images/svg/google.svg" alt="">
                        </a>
                    <?php } ?>
                    <?php if ($customer->cus_twitter){ ?>
                        <a target="_blank" href="<?php echo htmlspecialchars($customer->cus_twitter) ?>">
                            <img src="/templates/home/styles/images/svg/twister.svg" alt="">
                        </a>
                    <?php } ?>
                </div>
                <div class="xemthem btn-show-comment-customer" data-toggle="modal" data-target="#modal_<?php echo $index_customer ?>">Xem thêm</div>
                <div class="avatar-box">
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
        </li>
    <?php } ?>
</ul>