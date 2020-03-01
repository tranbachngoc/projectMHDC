<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">                
		<?php
		if ($title_view != false) {
		    echo $title_view;
		}
		?>
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
	    <table class="table table-bordered">
    		<thead>
    		    <tr>
    			<th width="5%" class="text-center">STT</th>
    			<th>Tên sản phẩm</th>
    			<th class="text-center">Lượt xem</th>
    			<th class="text-center">Chi tiết</th>
    		    </tr>
    		</thead>
    		<tbody>
                        <?php
                        foreach ($list as $k => $item):
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $stt + $k; ?></td>
                                <td>
                                    <a target="_blank" href="<?php echo base_url(); ?><?php echo $item->pro_category; ?>/<?php echo $item->pro_id; ?>/<?php echo RemoveSign($item->pro_name); ?>">
                                        <?php
                                        echo $item->pro_name;
                                        ?>
                                    </a>
                                </td>
                                <td class="text-center"><span class="badge"><?php echo $item->so_luong_view; ?></span></td>
                                <td class="text-center"><a class="btn btn-default btn-sm" href="<?php echo base_url() . 'account/share/view-list/detail/' . $item->pro_id; ?>" target="_blank"><i class="fa fa-eye fa-fw"></i></a></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
             </table>
            <?php echo $linkPage; ?>
	    <?php }else { ?>
	    <div class="none_record">
		<p class="text-center">Chưa có dữ liệu cho mục này</p>
	    </div>
	    <?php } ?>
	</div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>