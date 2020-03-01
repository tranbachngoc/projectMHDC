<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
		<?php echo $title_category->cat_name ?>
	    </h4>
	    <?php if(count($detail_content) > 0) {?>
		<table class="table table-bordered">
		    <tr>
			<td>
			    <ul class="docs_cat">
				<?php foreach($detail_content as $item){ ?>
				    <li>
					<div>
					    <a href="<?php echo base_url() ?>account/docs/<?php echo $item->not_id; ?>/detail/<?php echo RemoveSign($item->not_title);?>">
						<img src="<?php echo base_url(); ?>media/images/doc/<?php if(isset($item->not_dir_image) && isset($item->not_image)){ echo $item->not_dir_image; ?>/<?php echo $item->not_image;} else{ echo 'noimage.png';}?>" /></a>
					    <h2 class="title"><a href="<?php echo base_url() ?>account/docs/<?php echo $item->not_id; ?>/detail/<?php echo RemoveSign($item->not_title);?>">   <?php echo $item->not_title; ?></a></h2>
					    <p><?php $vovel=array("&curren;"); echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel,"#",$item->not_detail)),200)) ; ?></p>
					    <p>Ngày đăng: <?php echo date('d/m/Y',$item->not_begindate); ?> || <a href="<?php echo base_url() ?>account/docs/<?php echo $item->not_id; ?>/detail/<?php echo RemoveSign($item->not_title);?>">Xem chi tiết</a></p>
					    <div class="clearfix"></div>
					</div>
				    </li>
				<?php } ?>
			    </ul>
			</td>
		    </tr>
		</table>	
		<div class="text-center">
		    <?php echo $linkPage ?>
		</div>	
	    <?php } else {?>
		<div class="none_record">
		    <p class="text-center">Không có dữ liệu !</p>
		</div>
	    <?php }?>
	    <br/>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>