<?php if (!empty($products)){
    foreach ($products as $product) {
        $this->load->view('shop/media/elements/product-item', ['product' => $product]);
    }
} ?>
