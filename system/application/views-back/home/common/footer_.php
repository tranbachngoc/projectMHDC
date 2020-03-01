				</tr>
			</table>

    <script  type="text/javascript">
	 
jQuery(document).ready(function(){
	
	var widthScreen=jQuery(window).width();
	if(widthScreen <=1024){
		jQuery('.comp').css('width','950');
	}
	 	
});

</script>

<div style="height:10px;">&nbsp;</div>
<div style="height:20px;">&nbsp;</div>
<div class="fast-link" align="center">
<div class="fast-link-center">
<?php $fastLink=Counter_model::getArticle(fastLink); echo html_entity_decode($fastLink->not_detail);?>
</div>

<div class="comp"> <div class="compleft"> 
<?php $contentFooter=Counter_model::getArticle(footerLogo); echo html_entity_decode($contentFooter->not_detail);?>
</div>
<div class="compright">
<?php $contentFooter=Counter_model::getArticle(footerNetwork); echo html_entity_decode($contentFooter->not_detail);?>
</div>

</div>
</div>
<div style="clear:both;"></div>


<div id="footer" align="center">
 <div class="footer" style="background-color:#DFDFDF;" >
     <div class="iconDaDangKy">
       <?php $contentFooter=Counter_model::getArticle(footerDangKyBo); echo html_entity_decode($contentFooter->not_detail);?>
    </div>
<div class="right_footer" style="width:576px; color:#666666; font-size:11px; line-height:140%; padding-left:2px;">

<div class="moduletable_footerdetail">
<?php $contentFooter=Counter_model::getArticle(contentFooter); echo html_entity_decode($contentFooter->not_detail);?>
</div>
</div>
<div class="onlinesupport">
<div class="online-support" style=" line-height:20px;">
<?php $yahooChatFooter=Counter_model::getArticle(yahooChatFooter); echo html_entity_decode($yahooChatFooter->not_detail);?>
</div>
</div>
<?php  if($this->uri->segment(1)!="product" && $this->uri->segment(2)!="category"    ) { ?>
	<?php if($this->uri->segment(1)!="") { ?>    
    <div id="divAdLeft" style="display: block; position: fixed; top: 50px; width:130px; overflow:hidden; ">       
<?php $this->load->view('home/advertise/scrollleft'); ?>
</div>
<div id="divAdRight" style="display: block; position: fixed; top: 50px;  width:130px; overflow:hidden;">
<?php $this->load->view('home/advertise/scrollright'); ?>
</div>

<?php } } else {   ?>

<?php if($this->uri->segment(1)=="product" && $this->uri->segment(2)=="category" && $this->uri->segment(3)=="detail" ) { ?>   
<div id="divAdLeft" style="display: block; position: fixed; top: 50px; width:130px; overflow:hidden; ">       
<?php $this->load->view('home/advertise/scrollleft'); ?>
</div> 
<div id="divAdRight" style="display: block; position: fixed; top: 50px;  width:130px; overflow:hidden;">
<?php $this->load->view('home/advertise/scrollright'); ?>
</div>

<?php } ?>

<?php  } ?>

</div>
</div>
<div>
</div>
</div>
<?php if($globalProduct){?>
</div>
</div>
<?php }?>


</body>
</html>