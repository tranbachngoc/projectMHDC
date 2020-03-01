<div class="modal" id="modal_<?php echo $index; ?>">
    <div class="modal-dialog modal-lg modal-mess">
        <div class="modal-content">
            <div class="contents customer-comment">
                <div class="modal-header customer-comment-title">
                    <div class="btn-back js-back"><a href="#"><img src="/templates/home/styles/images/svg/close_black.svg"></a></div>
                    <?php echo $cus_title ?>
                </div>
                <div class="modal-body">
                    <div class="customer-comment-content">
                        <div class="left">
                            <?php if ($customer->cus_link) { ?>
                                <a href="<?php echo $customer->cus_link ?>" target="_blank">
                                    <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $not_dir_image . '/' . $customer->cus_avatar ?>"
                                         alt="<?php echo $customer->cus_text1 ?>">
                                </a>
                            <?php } else { ?>
                                <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $not_dir_image . '/' . $customer->cus_avatar ?>"
                                     alt="<?php echo $customer->cus_text1 ?>">
                            <?php } ?>
                            <h3><?php echo $customer->cus_text1 ?></h3>
                            <div>
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
                        </div>
                        <div class="right"><?php echo $customer->cus_text3 ?></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>