<?php foreach ($list_news as $k => $item) { ?>                 
    <?php $this->load->view('shop/news/item', array('item' => $item)); ?>
<?php } ?> 