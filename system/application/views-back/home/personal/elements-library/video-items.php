<?php if (!empty($videos)){
    foreach ($videos as $index => $video) {
        $this->load->view('home/personal/elements-library/video-item', ['video' => $video, 'index' => $index]);
    }
} ?>
