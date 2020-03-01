<?php if (!empty($links)){
    foreach ($links as $link) {
        $this->load->view('shop/media/elements/link-item', ['link' => $link]);
    }
} ?>
