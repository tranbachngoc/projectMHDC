
<?php if (count($advertise) > 0) { ?>
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="<?php echo settingTimeSlide_Advs; ?>">
		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<?php
			$counter = 0;
			$id = $this->uri->rsegment('3');
			foreach ($advertise as $key => $advertiseArray) {

				?>
				<?php if ((int)$advertiseArray->adv_position == 5 && $advertiseArray->adv_page == 'home' && $advertiseArray->cat_id == $id) {
					$counter = $counter +1;?>
					<div class="item <?php if ($key == 0) {
						echo 'active';
					} ?>">
						<a href="<?php echo base_url() . 'adv/' . $advertiseArray->adv_id; ?>" target="_blank">
							<img class="img-responsive" border="0"
								 src="<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>"/>
						</a>
					</div>
				<?php } ?>
			<?php } ?>
			<?php
			if ($counter == 0)
			{
				?><img class="img-responsive" border="0" src="<?php echo base_url(); ?>media/banners/default/default_580_400.jpg" /><?php

			}
			?>

		</div>
		<!-- Controls -->
		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
<?php }else{?>
<div style="height: 100%; background: url('<?php echo base_url(); ?>media/banners/default/default_580_400.jpg') no-repeat center / auto 100% ;"></div>
<?php } ?>
