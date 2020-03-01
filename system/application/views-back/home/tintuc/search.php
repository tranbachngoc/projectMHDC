<?php $this->load->view('home/common/header'); ?>

<script>
    function submitSearchTintuc() {
        var keyword = document.getElementById('keyword').value;
        var url = '<?php echo base_url(); ?>tintuc/search/keyword' + keyword;
        window.location = url;
        return true;
    }
    function submitenterQ(myfield, e, baseUrl)
    {
        var keycode;
        if (window.event)
            keycode = window.event.keyCode;
        else if (e)
            keycode = e.which;
        else
            return true;

        if (keycode == 13)
        {
            submitSearchTintuc();
            return false;
        } else
            return true;
    }
</script>
<style type="text/css">
    .item-title{
        display: block;
    }
    .highlight{background-color:yellow}
</style>
<div id="main" class="container-fluid">
    <div class="row tintuc">
        <div class="col-lg-2">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10">
            <div class="breadcrumbs hidden-xs">
                <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                <a  href="<?php echo base_url(); ?>/tintuc">Tin tức azinet</a><i class="fa fa-angle-right"></i>
                <span>Tìm kiếm</span>
            </div>

            <div class="row visible-xs">  
                <div class="col-md-6">
                    <form id="tintuc_search" class="form-horizontal" action="<?php echo base_url() ?>tintuc/search" method="post">                            
                        <div class="input-group">
                            <input name="keyword" id="keyword" class="form-control" type="text" 
                                   value="<?php if ($keyword) { echo $keyword; } ?>" 
                                   placeholder="Nhập từ khóa tìm kiếm" 
                                    onkeypress="return submitenterQ(this,event,'<?php echo base_url(); ?>')">
                            <span class="input-group-btn">
                                <button class="btn btn-default1" type="submit">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="col-md-6"></div>
            </div>

			<?php if (isset($results) && count($results) > 0) { ?>
                <div class="panel panel-default" id="results">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-newspaper-o fa-fw"></i>&nbsp; Kết quả tìm kiếm <span class="small">(<?php echo $totalRecord ?>)</span></h3>
                    </div>
                    <div class="panel-body">
			<?php foreach ($results as $k => $item) { ?>                                
			<div class="row" style="margin-bottom: 15px;">
				<div class="col-xs-12">
				    <div class="pull-left" style="width:100px; height: 100px;">
					<div class="fix1by1">
					    <?php
					    if ($item->not_image != '') {
						$thumbnail = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . show_thumbnail($item->not_dir_image, $item->not_image, 1, 'tintuc');
					    } else {
						$thumbnail = base_url() . 'media/images/no_photo_icon.png';
					    }
					    ?>
					    <a class="c" 
					       href="<?php echo base_url() ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>"
					       style="background: url('<?php echo $thumbnail ?>') no-repeat center /  auto 100%;">                                                
					    </a>
					</div>
				    </div>
				    <div class="" style="margin-left:115px;">
					<div class="item-title"><a href="<?php echo base_url() ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>"><?php echo $item->not_title ?></a></div>
					<div class="small text-muted">
					    <?php echo $item->not_description ?>
					    <p>                                        
						<i class="fa fa-calendar fa-fw"></i> <?php echo date('d/m/Y', $item->not_begindate); ?>
						<i class="fa fa-eye fa-fw"></i> <?php echo $item->not_view; ?>
					    </p> 
					</div>
				    </div>
				</div>
			    </div>
			<?php } ?>                            
                    </div>                        
                </div>
                <div class="text-center"><?php echo $linkPage ?></div>    
			<?php } else { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Kết quả tìm kết</h3>
                    </div>
                    <div class="panel-body">
                        <p class="text-center">Không có kết quả nào được tìm thấy...</p>
                    </div>
                </div>
			<?php } ?>
        </div>
    </div>
</div>

<script src="https://johannburkard.de/resources/Johann/jquery.highlight-5.js"></script>
<script type="text/javascript">
    jQuery(function ($) {
        $('#results').highlight("<?php echo $keyword ?>");
    });
</script>

<?php $this->load->view('home/common/footer'); ?>
