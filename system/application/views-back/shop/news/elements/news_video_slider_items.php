<?php if (!empty($videos)){
    foreach ($videos as $k => $video) {
        $url_news = $shop_url . 'news/detail/' . $video->not_id . '/' . RemoveSign($video->not_title);
        $this->load->view('shop/news/elements/news_video_slider_item', ['video' => $video, 'k' => $k, 'url_news' => $url_news]);
    }
} ?>

