<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<script >
jQuery(document).ready(function(){
	hiddenProductViaResolutionCategory('showCateGoRyScren');	 
	jQuery('.image_boxpro').mouseover(function(){
		tooltipPicture(this,jQuery(this).attr('id'));
	});	
	var isCtrl = false; 
	jQuery(document).keyup(function (e) { 
		if(window.event)
        {
             key = window.event.keyCode;     //IE
             if(window.event.ctrlKey)
                 isCtrl = true;
             else
                 isCtrl = false;
        }
        else
        {
             key = e.which;     //firefox
             if(e.ctrlKey)
                 isCtrl = true;
             else
                 isCtrl = false;
        }
		if(isCtrl){
			if(key == 109 || key == 189)
			{
				// zoom out
				hiddenProductViaResolutionCategory('showCateGoRyScren');
			}
			if(key == 107 || key == 187)
			{
				// zoom in
				hiddenProductViaResolutionCategory('showCateGoRyScren');
			}
		}
	});
});
</script>
<td width="100%" valign="top">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding:0 10px;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <?php if(count($reliableProduct) > 0){ ?>
        <tr>
            <td>
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_reliable_category'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  >
                <table align="center" style="margin-top:6px;" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top">
                             
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="16" ></td>
        </tr>
        <tr>
            <td height="5"></td>
		</tr>
        <?php $this->load->view('home/advertise/center2'); ?>
        <?php } ?>
        
        <tr >
		<?php /*Dem so phan tu co levelQ=0*/?>
        <?php
			$k_kount=0;		
			foreach($categoryViewPage as $categoryArray){ 
				if($categoryArray->levelQ == 0)
				$k_kount += 1;		
			}		
			$k_columns=ceil($k_kount/3);
			//echo($k_kount	);		
        ?>
        <?php $j=0; foreach($categoryViewPage as $categoryArray){ ?> 
        <?php if(($j==0 || $j==$k_columns||$j==2*$k_columns||j==3*$k_columns) &&($categoryArray->levelQ==0)) {?>
        <td width="25%" valign="top">
            <div class="viewcategorypages<?php echo $categoryArray->levelQ; ?>">
                <a href="<?php echo base_url()?>raovat/<?php echo $categoryArray->cat_id."/".RemoveSign($categoryArray->cat_name) ?>">
                	<h5><?php echo $categoryArray->cat_name; ?></h5>               
                </a>
            </div>
        <?php $j++;?>
        <?php }else{?>
        <?php if($categoryArray->levelQ == 0){?>        	               
            <div class="viewcategorypages<?php echo $categoryArray->levelQ; ?>">
                <a href="<?php echo base_url()?>raovat/<?php echo $categoryArray->cat_id."/".RemoveSign($categoryArray->cat_name) ?>">
                	<h5><?php echo $categoryArray->cat_name; ?></h5>               
                </a>
            </div>
        <?php $j++;?> 
        <?php }/*end level == 0*/ ?>     
        <?php if($categoryArray->levelQ == 1){?>        	               
            <div class="viewcategorypages<?php echo $categoryArray->levelQ; ?>">
                <a href="<?php echo base_url()?>raovat/<?php echo $categoryArray->cat_id."/".RemoveSign($categoryArray->cat_name) ?>">
                	<h5><?php echo $categoryArray->cat_name; ?></h5>               
                </a>
            </div>
        <?php }/*end level == 1*/ ?>     
        <?php }/*end else*/?>
        <?php if(($j==$k_columns || $j==2*$k_columns || $j== 3*$k_columns || j==4*$k_columns )&&($categoryArray-levelQ==0)){?>
        </td>
        <?php ?>                    
        <?php  }/* end td */?>        
        <?php }/*end foreach*/?>                           
		</tr>
        <tr>
            <td  >
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="16" ></td>
        </tr>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successFavoriteraovat) && $successFavoriteraovat == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_category'); ?>');</script>
<?php } ?>