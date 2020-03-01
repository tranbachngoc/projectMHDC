<?php
$server_media = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
$domain_url   = azibai_url();

if(!empty($links)){
    foreach ($links as $item) {
        $this->load->view('home/links/item_link', [
            'item'          => $item,
            'server_media'  => $server_media,
            'url_item'      => $domain_url,
        ]);
    }
}
?>