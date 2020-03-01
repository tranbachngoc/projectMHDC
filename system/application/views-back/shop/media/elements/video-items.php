<?php if (!empty($videos)){
    foreach ($videos as $index => $video) {
        $this->load->view('shop/media/elements/video-item', ['video' => $video, 'index' => $index]);
    }
} ?>
