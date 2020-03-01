<?php
$root_url = azibai_url();
foreach ($list_news as $key => $item) {
    $item->collection = isset($collection) ? $collection : '';
    $item->collection_content = isset($collection_content) ? $collection_content : '';
    $item->root_url = $root_url;
    $this->load->view('home/tintuc/item', array('item' => $item, 'personal_page' => 1));

    if(!empty($item->suggest_list)) {
        foreach ($item->suggest_list as $key => $value) {
            echo $value;
        }
    }
} ?>