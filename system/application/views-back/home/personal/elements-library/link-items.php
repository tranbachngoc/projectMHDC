<?php if (!empty($links)){
    foreach ($links as $link) {
        $this->load->view('home/personal/elements-library/link-item', ['link' => $link]);
    }
} ?>
