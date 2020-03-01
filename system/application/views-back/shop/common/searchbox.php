<?php
/**
 * Created by PhpStorm.
 * User: son
 * Date: 4/10/2016
 * Time: 9:14 AM
 */?>
<script type="text/javascript">
    function submit_enter(e) {

        var keycode;
        if (window.event) keycode = window.event.keyCode;
        else if (e) keycode = e.which;
        else return true;

        if (keycode == 13) {

            jQuery('#searchBox').submit();
            return false;
        }
        else
            return true;

    }
</script>
<form class="row" id="searchBox" action="" method="get">
    <div class="form-group col-md-3 col-xs-12"> 
        <input type="text" value="<?php echo @$q;?>" name="q" id="KeywordSearch" class="form-control keyword"
               title="Từ khóa tìm kiếm"
               onKeyPress="return submit_enter(event)"
               placeholder="Từ khóa tìm kiếm">
    </div>
    <div class="form-group col-md-3 col-xs-12">
        <input class="form-control min_price" type="text" value="<?php echo @$price;?>" name="price" id="price" title="Giá nhỏ nhất"
               onKeyPress="return submit_enter(event)"
               placeholder="Giá nhỏ nhất">
    </div>
    <div class="form-group col-md-3 col-xs-12">
        <input class="form-control max_price" type="text" value="<?php echo @$price_to;?>" name="price_to" id="price_to"
               title="Giá lớn nhất"
               onKeyPress="return submit_enter(event)"
               placeholder="Giá lớn nhất">        
    </div>
	<div class="form-group  col-md-3 col-xs-12">
		<button type="submit"  class="btn btn-default1 btn-block"><?php echo $this->lang->line('title_search_detail_global'); ?></button>
	</div>
</form>
