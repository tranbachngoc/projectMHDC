<?php /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */ ?>
<div class="panel panel-default">                
    <div class="panel-heading"><strong>Video mới</strong></div>    
    <div class="panel-body" style="padding: 10px">
        <div id="videos_gallery">  
            <div class="owl-carousel">
                <?php foreach ($videos as $key => $value) { ?>                    
                        <a class="item" href="https://www.youtube.com/watch?v=<?php echo $value ?>" data-poster="//img.youtube.com/vi/<?php echo $value ?>/mqdefault.jpg">
                            <div class="fix16by9">
                                <div class="c">
                                    <img src="https://img.youtube.com/vi/<?php echo $value ?>/mqdefault.jpg" />
                                    <i class="icon-play"></i>										
                                </div>
                            </div>
                        </a>
                <?php } ?>
            </div>  
        </div>
    </div>
</div>

