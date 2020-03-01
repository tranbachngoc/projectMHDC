<?php
$server_media = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';

if(!empty($items)){
    foreach ($items as $item) {
        $this->load->view('shop/media/elements/library-links/library-item-v2', [
            'item'           => $item,
            'is_owns'        => $is_owns,
            'server_media'   => $server_media,
        ]);
    }
}
?>