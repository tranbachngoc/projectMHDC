<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
                Thống kê chia sẻ Link
            </h4>
            <script type="text/javascript">
		function copylink(link) {
		    clipboard.copy(link);
		}
		function submitForm() {
		    jQuery("#share-form").submit();
		}
            </script>
            <?php if (count($list) > 0) { ?>
                
		<form action="<?php echo $link; ?>" id="share-form" method="post">
		    <div class="row">
		    <div class="form-group col-sm-4">
			<div class="input-group">
			    <input type="text" name="p" class="form-control" value="<?php echo $filter['p']; ?>"
				   placeholder="Từ khóa">
			    <div class="input-group-addon" onclick="submitForm()" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>"><i class="fa fa-search"></i></div>
			</div>
                    </div>
                    </div>
                    <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                    <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                </form>
		
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>                        
                        <tr>
                            <td width="40" class="text-center">STT</td>
                            <td>Tiêu đề
                                <a href="<?php echo $sort['proName']['asc']; ?>">
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                         style="cursor:pointer;" alt=""/>
                                </a>
                                <a href="<?php echo $sort['proName']['desc']; ?>">
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                         style="cursor:pointer;" alt=""/>
                                </a>
                            </td>
                            <td width="100">Copy Link</td>
                            <td width="150">Lượt xem
                                <a href="<?php echo $sort['click']['asc']; ?>">
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                         style="cursor:pointer;" alt=""/>
                                </a>
                                <a href="<?php echo $sort['click']['desc']; ?>">
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                         style="cursor:pointer;" alt=""/>
                                </a>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $k => $item):
                                ?>
                                <tr>
                                    <td><?php echo $num + $k + 1; ?></td>
                                    <td>
                                        <a href="<?php echo $item['link']; ?>" target="_blank">
                                            <?php
                                            echo $item['content_title'];
                                            ?>
                                        </a>
                                    </td>
                                    <td><a href="javascript:void(0);" onclick="copylink('<?php echo $item['link']; ?>');">Copy Link</a></td>
                                    <td class="text-center"><span class="badge"><?php echo $item['click']; ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center"><?php echo $pager; ?></div>
            <?php } else { ?>
		<div class="none_record">
		    <p class="text-center">Chưa có dữ liệu cho mục này</p>
		</div>
	    <?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>