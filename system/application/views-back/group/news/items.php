<?php foreach ($list_news as $k => $item) { ?>                 
    <?php $this->load->view('group/news/item', array('item' => $item)); ?>
<?php } ?> 