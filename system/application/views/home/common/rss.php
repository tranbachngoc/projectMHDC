<?php 
	$url = "http://www.azibai.com/hd/?format=feed&type=rss";
	$rss = simplexml_load_file($url); ?>
<div class="temp_2 mod_notice">
      <div class="title">
        <div class="fl"></div>
        <div class="fc">
          <h3>
			<a href="http://www.azibai.com/hd" style="color:#E77E03">Hướng dẫn làm quà handmade</a>
		 </h3>
        </div>
        <div class="fr"></div>
      </div>
      <div class="content">
        <div class="list_link">
         <ul>
		 <?php
			
			if($rss)
			{
			//echo '<h1>'.$rss->channel->title.'</h1>';
			//echo '<li>'.$rss->channel->pubDate.'</li>';
			$items = $rss->channel->item;
			$i=0;
			foreach($items as $item)
			{
				if($i==8) break;
				$title = $item->title;
				$link = $item->link;
			//$published_on = $item->pubDate;
			//$description = $item->description;
				echo '<li><a href="'.$link.'">'.$title.'</a></li>';
			//echo '<span>('.$published_on.')</span>';
			//echo '<p>'.$description.'</p>';
				$i++;
			}
			}
		?>
        </ul>
        </div>
        <div class="view_all"><a href="http://www.azibai.com/hd" class="text_link">Xem tất cả...</a></div>
        <div class="clear"></div>
      </div>
      <div class="bottom">
        <div class="fl"></div>
        <div class="fr"></div>
      </div>
    </div>