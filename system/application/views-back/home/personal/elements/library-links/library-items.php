<?php
if(!empty($items)){
    foreach ($items as $item) {
        $this->load->view('shop/media/elements/library-links/library-item-v2', [
            'item'          => $item,
            'server_media'  => $server_media,
            'is_owns'       => $is_owns,
            'url_item'      => $url_item,
        ]);
    }
}
?>