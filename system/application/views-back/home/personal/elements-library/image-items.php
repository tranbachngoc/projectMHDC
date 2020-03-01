<?php
if (!empty($images)){
    foreach ($images as $index => $image) {
        $this->load->view('home/personal/elements-library/image-item', [
            'image'         => $image,
            'index'         => $index,
        ]);
    }
} ?>
