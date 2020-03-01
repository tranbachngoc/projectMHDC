<div class="panel panel-default">
  <div class="panel-heading">HƯỚNG DẪN</div>
  <div class="panel-body">
    <ul class="nav">
      <li style=" background:none; "> <b><a> <?php echo $category_view_left[0]->cat_name; ?> </a> </b>
	<ul  class="content_huongdan_tree">
	  <?php foreach($view_cate_1 as $item) { ?>
	  <li> <a href="<?php echo getAliasDomain() ?>content/<?php echo $item->not_id ?>" > <?php echo $item->not_title ?> </a> </li>
	  <?php } ?>
	</ul>
      </li>
      <li style=" background:none;"> <b><a > <?php echo $category_view_left[1]->cat_name; ?> </a> </b>
	<ul  class="content_huongdan_tree">
	  <?php foreach($view_cate_2 as $item) { ?>
	  <li> <a href="<?php echo getAliasDomain() ?>content/<?php echo $item->not_id ?>" > <?php echo $item->not_title ?> </a> </li>
	  <?php } ?>
	</ul>
      </li>
      <li style=" background:none;"> <b><a > <?php echo $category_view_left[2]->cat_name; ?> </a> </b>
	<ul  class="content_huongdan_tree">
	  <?php foreach($view_cate_3 as $item) { ?>
	  <li> <a href="<?php echo getAliasDomain() ?>content/<?php echo $item->not_id ?>" > <?php echo $item->not_title ?> </a> </li>
	  <?php } ?>
	</ul>
      </li>
      <li style=" background:none;"> <b><a > <?php echo $category_view_left[3]->cat_name; ?> </a> </b>
	<ul  class="content_huongdan_tree">
	  <?php foreach($view_cate_4 as $item) { ?>
	  <li> <a href="<?php echo getAliasDomain() ?>content/<?php echo $item->not_id ?>" > <?php echo $item->not_title ?> </a> </li>
	  <?php } ?>
	</ul>
      </li>
      <li style=" background:none;"> <b><a > <?php echo $category_view_left[4]->cat_name; ?> </a> </b>
	<ul  class="content_huongdan_tree">
	  <?php foreach($view_cate_5 as $item) { ?>
	  <li> <a href="<?php echo getAliasDomain() ?>content/<?php echo $item->not_id ?>" > <?php echo $item->not_title ?> </a> </li>
	  <?php } ?>
	</ul>
      </li>
      <li style=" background:none;"> <b><a > <?php echo $category_view_left[5]->cat_name; ?> </a> </b>
	<ul  class="content_huongdan_tree">
	  <?php foreach($view_cate_6 as $item) { ?>
	  <li> <a href="<?php echo getAliasDomain() ?>content/<?php echo $item->not_id ?>" > <?php echo $item->not_title ?> </a> </li>
	  <?php } ?>
	</ul>
      </li>
    </ul>
  </div>
</div>
