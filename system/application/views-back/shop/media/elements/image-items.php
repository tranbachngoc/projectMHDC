<?php
if (!empty($images)){
    foreach ($images as $index => $image) {
        $this->load->view('shop/media/elements/image-item', [
            'image' => $image,
            'shop_current' => $shop_current,
            'index' => $index,
        ]);
    }
} ?>
