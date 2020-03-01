<div class="row item active">
    <?php
    $shop_af = $this->user_model->get('use_group', "use_id = " . (int)$siteGlobal->sho_user);
    foreach ($products as $k => $product) {
        // Added
        // by le van son
        // Calculation discount amount
        $afSelect = true;
        $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
        if ($shop_af->use_group == 2) {
            $id_gr = 8;
        } else {
            $id_gr = 4;
        }
        ?>
        <?php
        if ($isMobile == 0) {
            if ($k > 0 && $k % 4 == 0) { echo '</div><div class="row item">'; }
        }else{
            if ($k > 0 && $k % 2 == 0){ echo '</div><div class="row item">';}
        }
        ?>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <?php $this->load->view('shop/product/product_item', array('product' => $product, 'discount' => $discount, 'afLink'=>$afLink)); ?>
        </div>
    <?php } ?>
</div>
