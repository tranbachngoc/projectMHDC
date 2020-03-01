<?php foreach ($list_news as $key => $item) { ?>
    <?php
    // if( (count($list_news)-1) == $key && $item->not_id != 0){
    //     $goiy = $this->load->view('home/tintuc/goiy_choban', array('id'=>$item->not_id), true);
    //     $item->goiy = $goiy;
    // }
    ?>
    <?php if($item->not_id != 0){
        $item->collection = $list_news['collection'];
        $item->collection_content = $list_news['collection_content'];
        $this->load->view('home/tintuc/item', array(
            'item' => $item, 
            'page' => $page,
            'key'  => $key
        ));

        if(!empty($item->suggest_list)) {
            foreach ($item->suggest_list as $key => $value) {
                echo $value;
            }
        }
    } ?>
<?php } ?>