<div class="row item active">
    <?php
    $shop_af = $this->user_model->get('use_group', "use_id = " . (int)$siteGlobal->sho_user);
    foreach ($products as $k => $product) {
        // Added
        // by le van son
        // Calculation discount amount
        $afSelect = true;
        $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
        ?>
        <?php if ($k > 0 && $k % 8 == 0) echo "</div><button class='btn btn-default' id='read_more_af_pa'>Xem thêm</button><div class='row item_2 hidden-lg'>"; ?>
        <div class="col-md-3 col-sm-6 col-xs-6">
            <?php $this->load->view('shop/product/product_item', array('product' => $product, 'discount' => $discount, 'afLink'=> $afLink)); ?>
        </div>
    <?php } ?>
</div>
<script>
    jQuery(document).ready(function(jQuery) {
        jQuery("#read_more_af_pa").click(function(){
            jQuery(this).hide();
            jQuery('.item_2').removeClass('hidden-lg');
        });
    });
</script>
