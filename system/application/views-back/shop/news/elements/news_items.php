<?php foreach ($list_news as $item) {
    $item->show_shop = true;
    $this->load->view('home/tintuc/item', array('item' => $item, 'home_page' => true));
//    echo $this->load->view('home/tintuc/item', array('item' => $item, 'home_page' => true), true);

    if(!empty($item->suggest_list)) {
        foreach ($item->suggest_list as $key => $value) {
            echo $value;
        }
    }
} ?>