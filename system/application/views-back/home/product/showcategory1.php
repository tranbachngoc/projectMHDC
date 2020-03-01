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
        
     <td width="25%" valign="top">
          <?php $i=0;  foreach($categoryViewPage as $categoryArray){ ?>      				
                  
                  
                    <?php if($i<=10 && $categoryArray->levelQ<2 ) {?>
                   <div class="viewcategorypages<?php echo $categoryArray->levelQ; ?>">
                  	<a href="<?php echo base_url()?><?php echo $categoryArray->cat_id."/".RemoveSign($categoryArray->cat_name) ?>">
                    <h4><?php echo $categoryArray->cat_name; ?></h4>
                      <?php
					}
				  ?>
                    </a>
                    </div>
                  
                
                  
     
                    
            
        <?php if($categoryArray->levelQ==0)
  			{ $i=$i+1; 
			}
			} ?>    
       </td>
       <td width="25%" valign="top">
       		 <?php $j=0;  foreach($categoryViewPage as $categoryArray){ ?>     				
                  
                  
                    <?php if($j>10 && $categoryArray->levelQ<2 && $j<=21 ) {?>
                   <div class="viewcategorypages<?php echo $categoryArray->levelQ; ?>">
                  	<a href="<?php echo base_url()?><?php echo $categoryArray->cat_id."/".RemoveSign($categoryArray->cat_name) ?>">
                    <h4><?php echo $categoryArray->cat_name; ?></h3>
                      <?php
					}
				  ?>
                    </a>
                    </div>                  
            
        <?php if($categoryArray->levelQ==0)
  			{ $j=$j+1; 
			}
			} ?>  
       </td>  
       <td width="25%" valign="top">
       		<?php $x=0;  foreach($categoryViewPage as $categoryArray){ ?>     				
                  
                  
                    <?php if($x>=21 && $categoryArray->levelQ<2 ) {?>
                   <div class="viewcategorypages<?php echo $categoryArray->levelQ; ?>">
                  	<a href="<?php echo base_url()?><?php echo $categoryArray->cat_id."/".RemoveSign($categoryArray->cat_name) ?>">
                    <h4><?php echo $categoryArray->cat_name; ?></h3>
                      <?php
					}
				  ?>
                    </a>
                    </div>                  
            
        <?php if($categoryArray->levelQ==0)
  			{ $x=$x+1; 
			}
			} ?> 
            
       </td>  
                            
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
       
    </table>
    <table width="100%" border="0">
  <?php $this->load->view('home/advertise/footer'); ?>
</table>

</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successFavoriteProduct) && $successFavoriteProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_category'); ?>');</script>
<?php } ?>