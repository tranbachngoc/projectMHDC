<table border="0" cellpadding="0" cellspacing="0" width="100%"  >
	<tr>
		<td>
			<p></p>
		</td>
	</tr>
	  <tr align="left">
		  <td class="left_border"><div class="total_showcart"><b><?php echo $this->lang->line('have_top_showcart_detail_global'); ?>: <?php if($this->session->userdata('sessionProductShowcart')){echo count(explode(',', trim($this->session->userdata('sessionProductShowcart'), ',')));}else{echo '0';} ?></b></div></td>
		 <!-- <td class="right_border">
		  <img src="<?php /*echo base_url();*/?>templates/shop/<?php /*echo $siteGlobal->sho_style; */?>/images/cart.png" onclick="ActionLink('<?php /*echo base_url(); */?>showcart')" style="cursor:pointer;" width="79" height="20" alt="" border="0"></td>-->
	  </tr>
  </table>
