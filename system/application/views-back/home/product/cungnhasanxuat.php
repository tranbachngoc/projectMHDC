<?php $this->load->view('home/common/header');
/*if ($_REQUEST['af_id'] != '') {
    $this->load->model('user_model');
    $userObject = $this->user_model->get("use_id", "af_key = '" . $_REQUEST['af_id'] . "'");
}*/
?>

<!--BEGIN: CENTER-->
<script language="javascript" type="text/javascript" >
document.onclick=hideallpop;
jQuery(document).ready(function(){
	
	hiddenProductViaResolutionCategory('showCateGoRyScren');	
	hiddenProductViaResolutionCategory('showCateGoRyScrenNew'); 
	jQuery('.image_boxpro').mouseover(function(){
		tooltipPicture(this,jQuery(this).attr('id'));
	});	
	var widthScreen=jQuery(window).width();
	jQuery('.header_bar_v2').css('width',widthScreen);
		jQuery('.logo-banner').css('width',widthScreen);


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
					hiddenProductViaResolutionCategory('showCateGoRyScrenNew'); 
			}
			if(key == 107 || key == 187)
			{
				// zoom in
				hiddenProductViaResolutionCategory('showCateGoRyScren');
					hiddenProductViaResolutionCategory('showCateGoRyScrenNew'); 
			}
		}
	});
});

function hoverpop(co,id,obj){
	jQuery('.sub_sub_cat').css('display','none');
	if(co >0){
		var position = jQuery(obj).position();
		jQuery('#sub_sub_cat_'+id).css('left',position.left);
		jQuery('#sub_sub_cat_'+id).css('top',position.top+20);
		jQuery('#sub_sub_cat_'+id).slideDown();
	}
}
function hidepop(id){
	jQuery('#sub_sub_cat_'+id).slideUp();
}
function hideallpop(){
	jQuery('.sub_sub_cat').css('display','none');
}

    jQuery(document).ready(function() {
		
     jQuery('.sub_sub_cat').hover(
         function () {
         	
         }, 
         function () {
           jQuery('.sub_sub_cat').css('display','none');
         }
     );
	 
    });
	

</script>

<td width="100%" valign="top">
  <div class="navigate">
            	   <?php if($CategorysiteGlobalRoot->cat_id=="") { ?>
                    
                    <?php } ?>
                   <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/move/views-home-product-category.css" />                    
                <div class="bgrumQ" >  
                <div class="bgrumQHome" id="sub_cateory_bgrum">           
                	<a href="<?php echo base_url() ?>" class="home" >Home</a> 
                       <img  alt="" src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/> 
                    </div>         	
                   <div class="sub_cateory_bgrum"> 
                    <?php echo $sanpham_sub_rum; ?>
                </div>
                      <?php if(isset($CategorysiteGlobalRoot->cat_id)) { ?>   
                      <div id="CategorysiteGlobalRoot">       
                    <a  href="<?php echo base_url()?><?php echo $CategorysiteGlobalRoot->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobalRoot->cat_name);?>"><?php echo mb_substr($CategorysiteGlobalRoot->cat_name,0,30,'UTF-8'); ?></a>
                      
                      
                        <?php if(isset($CategorysiteRootConten)) { ?>
                      <div class="CategorysiterootConten">
                    	<?php echo $CategorysiteRootConten; ?>
                    </div>
                    <?php } ?> 
                    
                       <?php if($CategorysiteRootConten!="") { ?>						       
                                <img alt=""  src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
                         <?php } else {?>
                          <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt="" />
                         <?php 
                         }
                         ?> 
                         </div>
                 <?php    } ?>                
                 
                   
                    
                 
            <span>Cùng nhà sản xuất</span>
          
             
                 </div>
                 
             </div>
             
             <div style="display:none;">
<p>
<div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumbs-title"> 
<span typeof="v:Breadcrumb">
 <a rel="v:url" property="v:title"  href="<?php echo base_url() ?>" class="home" >Home</a>
 </span>
  <span class="separator">»</span>
<?php if(isset($CategorysiteGlobalRoot->cat_id)) { ?>
<span typeof="v:Breadcrumb">
<a rel="v:url" property="v:title"  href="<?php echo base_url()?><?php echo $CategorysiteGlobalRoot->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobalRoot->cat_name);?>" title="<?php echo $CategorysiteGlobalRoot->cat_name; ?>"><?php echo mb_substr($CategorysiteGlobalRoot->cat_name,0,30,'UTF-8'); ?></a> <span class="separator">»</span>
</span>

<?php    } ?>
<?php if(isset($CategorysiteGlobal->cat_id)) { ?><span typeof="v:Breadcrumb">
<a rel="v:url" property="v:title"   href="<?php echo base_url()?><?php echo $CategorysiteGlobal->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobal->cat_name);?>" title="<?php echo $CategorysiteGlobal->cat_name; ?>"><?php echo mb_substr($CategorysiteGlobal->cat_name,0,30,'UTF-8'); ?></a> <span class="separator">»</span>
</span>
<?php    } ?>
Cùng nhà sản xuất
</div>
</p>
</div>


              <?php if((isset($categorylv1) && count($categorylv1) > 0) || (isset($categorylv2) && count($categorylv2) > 0)) {?>
					<div class="title" style="margin-right:10px; margin-bottom:5px; height:auto; margin-left:10px; margin-top:10px; padding-top:10px; border-top: 1px dotted #C7C7C7; border-bottom:1px dotted #C7C7C7">
						<?php if(isset($categorylv1) && count($categorylv1) > 0){
							foreach($categorylv1 as $catitem){
							$subcat = $catitem->cat_level2;
						?>
							<div class="sub_cat"><a onmouseover="hoverpop('<?php echo count($subcat); ?>','<?php echo $catitem->cat_id;?>',this)" <?php if(count($subcat) >0){echo 'class="has_child"';}?> href="<?php echo base_url()?>product/category/<?php echo $catitem->cat_id; ?>/<?php echo RemoveSign($catitem->cat_name);?>"><?php echo $catitem->cat_name;?></a></div>
							<div class="sub_sub_cat" id="sub_sub_cat_<?php echo $catitem->cat_id;?>">
								<div style="float:right">
								
								</div>
								<?php if(count($subcat) >0){
									foreach($subcat as $key=>$suvcatitem){
								?>
								<div class="sub_sub_cat_item">
									<a href="<?php echo base_url()?>product/category/<?php echo $suvcatitem->cat_id; ?>/<?php echo RemoveSign($suvcatitem->cat_name);?>"><?php echo $suvcatitem->cat_name;?></a>
								</div>
								<?php } }?>
								<div style="clear:both"></div>
							</div>
						<?php } }?>
						<?php if(isset($categorylv2) && count($categorylv2) > 0){
							foreach($categorylv2 as $catitem){
						?>
							<div class="sub_cat"><a href="<?php echo base_url()?>product/category/<?php echo $catitem->cat_id; ?>/<?php echo RemoveSign($catitem->cat_name);?>"><?php echo $catitem->cat_name;?></a></div>
						 <?php } }?>
						<div style="clear:both"></div>
					</div>
					<?php } ?>
                    
                    
             <div class="h1-styleding">
            
             </div>          
             
             
                
             
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding:0 10px;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <?php if(count($reliableProduct) > 0){ ?>
        <tr>
            <td valign="top">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2>Cùng nhà sản xuất nổi bật</h2>
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
                            <div class="showCateGoRyScren">
                            <?php $idDiv = 1; ?>
                            <?php foreach($reliableProduct as $reliableProductArray){
                                // Added
                                // by le van son
                                // Calculation discount amount
                                $afSelect = false;
                                /*if ($_REQUEST['af_id'] != '' && $reliableProductArray->is_product_affiliate == 1) {
                                    if ($userObject->use_id > 0) {
                                        $afSelect = true;
                                    }
                                }*/

                                $discount = lkvUtil::buildPrice($reliableProductArray, $this->session->userdata('sessionGroup'), $afSelect);


                                ?>
                            <div class="showbox_1 showbox_1q" id="DivReliableProductBox_<?php echo $idDiv; ?>" onmouseover="ChangeStyleBox('DivReliableProductBox_<?php echo $idDiv; ?>',1)" onmouseout="ChangeStyleBox('DivReliableProductBox_<?php echo $idDiv; ?>',2)">
                                <a href="<?php echo base_url(); ?><?php echo $reliableProductArray->pro_category; ?>/<?php echo $reliableProductArray->pro_id; ?>/<?php echo RemoveSign($reliableProductArray->pro_name); ?>">

                                <div class="imgViewCategoryImg">
                                	<table width="100%" border="0">
                                      <tr>   
                                        <td width="100%" height="140" align="center" valign="middle">
                                        
                                    <input type="hidden" id="name-<?php echo $reliableProductArray->pro_id;?>" value="<?php echo $reliableProductArray->pro_name;?>"/>
                                    <input type="hidden" id="view-<?php echo $reliableProductArray->pro_id;?>" value="<?php echo $reliableProductArray->pro_view;?>"/>
                                    <input type="hidden" id="shop-<?php echo $reliableProductArray->pro_id;?>" value="<?php echo $reliableProductArray->sho_name;?>"/>
                                    <input type="hidden" id="pos-<?php echo $reliableProductArray->pro_id;?>" value="<?php echo $reliableProductArray->pre_name;?>"/>
                                    <input type="hidden" id="date-<?php echo $reliableProductArray->pro_id;?>" value="<?php echo date('d/m/Y',$reliableProductArray->sho_begindate);?>"/>
                                    <input type="hidden" id="image-<?php echo $reliableProductArray->pro_id;?>" value="<?php echo base_url() ?>media/images/product/<?php echo $reliableProductArray->pro_dir; ?>/<?php echo show_image($reliableProductArray->pro_image); ?>"/>
                               <div style="display:none;" id="danhgia-<?php echo $reliableProductArray->pro_id;?>" >
                        	   <?php for($vote = 0; $vote < (int)$reliableProductArray->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/home/images/star1.gif" border="0" alt="" />
		                                            <?php } ?>
		                                            <?php for($vote = 0; $vote < 10-(int)$reliableProductArray->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/home/images/star0.gif" border="0" alt="" />		                                            <?php } ?>
		                                            <b>[<?php echo $reliableProductArray->pro_vote; ?>]</b>
                                                    
                        </div>
                        		
                                    <img src="<?php echo base_url() ?>media/images/product/<?php echo $reliableProductArray->pro_dir; ?>/<?php echo show_thumbnail($reliableProductArray->pro_dir, $reliableProductArray->pro_image, 3); ?>" onmouseover="tooltipPicture(this,'<?php echo $reliableProductArray->pro_id;?>')" id="<?php echo $reliableProductArray->pro_id;?>"  class="image_boxpro" alt="<?php echo ($reliableProductArray->pro_name);?>" />                                      
                                        </td>    
                                      </tr> 
                                    </table>
                               
                                    </div>                                    
                                    <div class="name_showbox_1">
                                        <h4>
                                            <?php echo sub($reliableProductArray->pro_name, 35); ?> &nbsp;
                                        </h4>  
                                    </div>                                    
                                </a>
                                <div class="icon-saleoff" ><span class="giamgia"><?php if($reliableProductArray->pro_saleoff==1) {?>Khuyến mãi<?php } ?> </span></div>
                                    <div class="cost_showbox" id="price-<?php echo $reliableProductArray->pro_id;?>">
                                        <span id="DivCostReliable_<?php echo $idDiv; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $reliableProductArray->pro_currency; ?>
                                    </div>

                            </div>
                            <?php $idDiv++; ?>
                            <?php } ?>
                            </div>
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
        <tr>
            <td>
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2>Cùng nhà sản xuất mới</h2>
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
                            <div class="showCateGoRyScrenNew">
                            <?php $idDiv = 1; ?>
                            <?php foreach($newProduct as $newProductArray){
                                // Added
                                // by le van son
                                // Calculation discount amount
                                $afSelect = false;
                                /*if ($_REQUEST['af_id'] != '' && $newProductArray->is_product_affiliate == 1) {
                                    if ($userObject->use_id > 0) {
                                        $afSelect = true;
                                    }
                                }*/

                                $discount = lkvUtil::buildPrice($newProductArray, $this->session->userdata('sessionGroup'), $afSelect);

                                ?>
                            <div class="showbox_1 showbox_1q" id="DivReliableProductBoxNew_<?php echo $idDiv; ?>" onmouseover="ChangeStyleBox('DivReliableProductBoxNew_<?php echo $idDiv; ?>',1)" onmouseout="ChangeStyleBox('DivReliableProductBoxNew_<?php echo $idDiv; ?>',2)">
                                <a href="<?php echo base_url(); ?><?php echo $newProductArray->pro_category; ?>/<?php echo $newProductArray->pro_id; ?>/<?php echo RemoveSign($newProductArray->pro_name); ?>">
                                <div class="imgViewCategoryImg">
                                	<table width="100%" border="0">
                                      <tr>   
                                        <td width="100%" height="140" align="center" valign="middle">
                                        
                                    <input type="hidden" id="name-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->pro_name;?>"/>
                                    <input type="hidden" id="view-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->pro_view;?>"/>
                                    <input type="hidden" id="shop-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->sho_name;?>"/>
                                    <input type="hidden" id="pos-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->pre_name;?>"/>
                                    <input type="hidden" id="date-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo date('d/m/Y',$newProductArray->sho_begindate);?>"/>
                                    <input type="hidden" id="image-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo base_url() ?>media/images/product/<?php echo $newProductArray->pro_dir; ?>/<?php echo show_image($newProductArray->pro_image); ?>"/>
                               <div style="display:none;" id="danhgia-<?php echo $newProductArray->pro_id;?>" >
                        	   <?php for($vote = 0; $vote < (int)$newProductArray->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/home/images/star1.gif" border="0" alt="" />
		                                            <?php } ?>
		                                            <?php for($vote = 0; $vote < 10-(int)$newProductArray->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/home/images/star0.gif" border="0" alt="" />		                                            <?php } ?>
		                                            <b>[<?php echo $newProductArray->pro_vote; ?>]</b>
                                                    
                        </div>
                        		
                                    <img src="<?php echo base_url() ?>media/images/product/<?php echo $newProductArray->pro_dir; ?>/<?php echo show_thumbnail($newProductArray->pro_dir, $newProductArray->pro_image, 3); ?>" onmouseover="tooltipPicture(this,'<?php echo 'f'.$newProductArray->pro_id;?>')" id="<?php echo $newProductArray->pro_id;?>"  class="image_boxpro" alt="<?php echo ($newProductArray->pro_name);?>" />                                      
                                        </td>    
                                      </tr> 
                                    </table>
                               
                                    </div>                                    
                                    <div class="name_showbox_1">
                                        <h4>
                                            <?php echo sub($newProductArray->pro_name, 35); ?> &nbsp;
                                        </h4>  
                                    </div>                                    
                                </a>
                                <div class="icon-saleoff" ><span class="giamgia"><?php if($newProductArray->pro_saleoff==1) {?>Khuyến mãi<?php } ?> </span></div>
                                    <div class="cost_showbox" id="price-<?php echo 'f'.$newProductArray->pro_id;?>">
                                        <span id="DivCostReliableNew_<?php echo $idDiv; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $newProductArray->pro_currency; ?>
                                    </div>

                            </div>
                            <?php $idDiv++; ?>
                            <?php } ?>
                            </div>
                        </td>
                    </tr>
                </table>
                
                
            <?php /*?><form name="frmListPro" method="post" action="">
                <table align="center" width="100%" style="border:1px #D4EDFF solid; margin-top:5px;" cellpadding="0" cellspacing="0">
                    <tr class="v_height29">
                        <td width="28" align="center" class="title_boxpro_0"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmListPro',0)" /></td>
                        <td width="110" class="title_boxpro_1"><?php echo $this->lang->line('image_list'); ?></td>
                        <td class="title_boxpro_2">
                            <?php echo $this->lang->line('product_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="105" class="title_boxpro_1">
                            <?php echo $this->lang->line('cost_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                    </tr>
                    <?php $idDiv = 1; ?>
                    <?php foreach($newProduct as $newProductArray){ ?>
                    <tr>
                        <td width="28" align="center" class="line_boxpro_0"><input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $newProductArray->pro_id; ?>" onclick="DoCheckOne('frmListPro')" /></td>
                        <td width="110" class="line_boxpro_1">
                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $newProductArray->pro_category; ?>/<?php echo $newProductArray->pro_id; ?>/<?php echo RemoveSign($newProductArray->pro_name); ?>">            
                        		<input type="hidden" id="name-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->pro_name;?>"/>
                                <input type="hidden" id="view-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->pro_view;?>"/>
                                <input type="hidden" id="shop-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->sho_name;?>"/>
                                <input type="hidden" id="pos-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->pre_name;?>"/>
                                <input type="hidden" id="date-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo date('d/m/Y',$newProductArray->sho_begindate);?>"/>
                                <input type="hidden" id="image-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo base_url() ?>media/images/product/<?php echo $newProductArray->pro_dir; ?>/<?php echo show_image($newProductArray->pro_image); ?>"/>
                                 <div style="display:none" id="danhgia-<?php echo 'f'.$newProductArray->pro_id;?>" >
                        	   <?php for($vote = 0; $vote < (int)$newProductArray->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/home/images/star1.gif" border="0" alt="" />
		                                            <?php } ?>
		                                            <?php for($vote = 0; $vote < 10-(int)$newProductArray->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/home/images/star0.gif" border="0" alt="" />		                                            <?php } ?>
		                                            <b>[<?php echo $newProductArray->pro_vote; ?>]</b>
                                                    
                        </div>
                        
                                <div style="display:none" id="price-<?php echo 'f'.$newProductArray->pro_id;?>">
                                     <span id="DivCostReliable_<?php echo $newProductArray->pro_id; ?>"></span>&nbsp;<?php echo $newProductArray->pro_currency; ?>
                                </div>
                                <script type="text/javascript">FormatCost('<?php 
        if($newProductArray->pro_type_saleoff==1) echo $newProductArray->pro_cost-(($newProductArray->pro_cost*$newProductArray->pro_saleoff_value)/100); else echo $newProductArray->pro_cost-$newProductArray->pro_saleoff_value;?>', 'DivCostReliable_<?php echo $newProductArray->pro_id; ?>');
        						</script>
                                <img alt="<?php echo($newProductArray->pro_name);?>" src="<?php echo base_url() ?>media/images/product/<?php echo $newProductArray->pro_dir; ?>/<?php echo show_thumbnail($newProductArray->pro_dir, $newProductArray->pro_image); ?>" onmouseover="tooltipPicture(this,'<?php echo 'f'.$newProductArray->pro_id;?>')" id="<?php echo 'f'.$newProductArray->pro_id;?>"  class="image_boxpro" />
                            </a>
                        </td>
                        <td valign="top" class="line_boxpro_2">
                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $newProductArray->pro_category; ?>/<?php echo $newProductArray->pro_id; ?>/<?php echo RemoveSign($newProductArray->pro_name); ?>" >
                                <h4><?php echo $newProductArray->pro_name; ?></h4>
                            </a>
                            <div class="descr_boxpro">
                                   <?php $vovel=array("&curren;"); ?> <?php echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel,"#",$newProductArray->pro_detail))),300); ?>
                            </div>
                            <table style="margin-top:10px;" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="45%" class="saleoff_boxpro">
                                        <?php if((int)$newProductArray->pro_saleoff == 1){ ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/saleoff.gif" border="0" alt="" />
                                        <?php } ?>
                                    </td>
                                    <td class="vr_boxpro"><?php echo $this->lang->line('view_category'); ?>:&nbsp;<?php echo $newProductArray->pro_view; ?>&nbsp;<b>|</b>&nbsp;<?php echo $this->lang->line('comment_category'); ?>:&nbsp;<?php echo $newProductArray->pro_comment; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="105" class="line_boxpro_1">
                            <?php if((int)$newProductArray->pro_cost == 0){ ?>
                            <?php echo $this->lang->line('call_main'); ?>
                            <?php }else{ ?>
                            <span  <?php if($newProductArray->pro_saleoff==1 && $newProductArray->pro_saleoff_value>0){echo "class='line-saleoff'" ;} ?> id="DivCost_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $newProductArray->pro_currency; ?>
                             
							<?php if($newProductArray->pro_saleoff==1 && $newProductArray->pro_saleoff_value>0){ ?>
<br />
<span id="DivCostSale_<?php echo $idDiv; ?>">

</span>&nbsp;<?php echo $newProductArray->pro_currency; ?>
<?php 

} ?>
                            
                            
                            <div class="usd_boxpro">
                                <?php if(strtoupper($newProductArray->pro_currency) == 'VND'){ ?>
								<!--<span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>
								<script type="text/javascript">FormatCost('<?php echo round($newProductArray->pro_cost/settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>-->
								<?php }else{ ?>
								<span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>
								<script type="text/javascript">FormatCost('<?php echo round($newProductArray->pro_cost*settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>
								<?php } ?>
							</div>
                            <script type="text/javascript">FormatCost('<?php echo $newProductArray->pro_cost; ?>', 'DivCost_<?php echo $idDiv; ?>');</script>
                            <script type="text/javascript">FormatCost('<?php 
if($newProductArray->pro_type_saleoff==1) echo $newProductArray->pro_cost-(($newProductArray->pro_cost*$newProductArray->pro_saleoff_value)/100); else echo $newProductArray->pro_cost-$newProductArray->pro_saleoff_value;?>', 'DivCostSale_<?php echo $idDiv; ?>');</script>
                            <?php if($newProductArray->pro_hondle == 1){ ?>
                            <div class="nego_boxpro"><img src="<?php echo base_url(); ?>templates/home/images/hondle.gif" border="0" alt="" /></div>
                            <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                 </table>
                 <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="favorite_boxpro"><img src="<?php echo base_url(); ?>templates/home/images/icon_favorite.gif" onclick="Favorite('frmListPro', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" style="cursor:pointer;" border="0" alt="" /></td>
                        <td align="center" id="sort_boxpro">
                            <select name="select_sort" class="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_desc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>vote/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('vote_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>vote/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('vote_desc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>comment/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('comment_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>comment/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('comment_desc_category'); ?></option>
                                
                                <option value="<?php echo $sortUrl; ?>reputation/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('uytin_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>reputation/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('uytin_desc_category'); ?></option>
                                
                            </select>
                        </td>
                        <td width="37%" class="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
                </form><?php */?>
             </td>
        </tr>
        
        <tr>
            <td height="16" ></td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td>
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2>Cùng nhà sản xuất  ưa thích</h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  >
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table align="center" style="margin-top:6px;" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <?php $isCounter = 1; ?>
                                    <?php foreach($favoriteProduct as $favoriteProductArray){
                                    // Added
                                    // by le van son
                                    // Calculation discount amount
                                    $afSelect = false;
                                    /*if ($_REQUEST['af_id'] != '' && $favoriteProductArray->is_product_affiliate == 1) {
                                        if ($userObject->use_id > 0) {
                                            $afSelect = true;
                                        }
                                    }*/

                                    $discount = lkvUtil::buildPrice($favoriteProductArray, $this->session->userdata('sessionGroup'), $afSelect);


                                    ?>
                                    <td width="12%">
                                        <div class="img_bestvote">
                                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $favoriteProductArray->pro_category; ?>/<?php echo $favoriteProductArray->pro_id; ?>/<?php echo RemoveSign($favoriteProductArray->pro_name); ?>">
                                            	                                                
                                                <input type="hidden" id="name-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo $favoriteProductArray->pro_name;?>"/>
                                                <input type="hidden" id="view-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo $favoriteProductArray->pro_view;?>"/>
                                                <input type="hidden" id="shop-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo $favoriteProductArray->sho_name;?>"/>
                                                <input type="hidden" id="pos-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo $favoriteProductArray->pre_name;?>"/>
                                                <input type="hidden" id="date-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo date('d/m/Y',$favoriteProductArray->sho_begindate);?>"/>
                                                <input type="hidden" id="image-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo base_url() ?>media/images/product/<?php echo $favoriteProductArray->pro_dir; ?>/<?php echo show_image($favoriteProductArray->pro_image); ?>"/>
                                                   <div style="display:none" id="danhgia-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" >
                        	   <?php for($vote = 0; $vote < (int)$favoriteProductArray->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/home/images/star1.gif" border="0" alt="" />
		                                            <?php } ?>
		                                            <?php for($vote = 0; $vote < 10-(int)$favoriteProductArray->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/home/images/star0.gif" border="0" alt="" />		                                            <?php } ?>
		                                            <b>[<?php echo $favoriteProductArray->pro_vote; ?>]</b>
                                                    
                        </div>
                        
                                                <div style="display:none" id="price-<?php echo 'fr'.$favoriteProductArray->pro_id;?>">
                                                     <span id="DivCostReliable_<?php echo 'fr'.$favoriteProductArray->pro_id; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $favoriteProductArray->pro_currency; ?>
                                                </div>

                                                <img alt="<?php echo($favoriteProductArray->pro_name);?>" src="<?php echo base_url() ?>media/images/product/<?php echo $favoriteProductArray->pro_dir; ?>/<?php echo show_thumbnail($favoriteProductArray->pro_dir, $favoriteProductArray->pro_image); ?>" onmouseover="tooltipPicture(this,'<?php echo 'fr'.$favoriteProductArray->pro_id;?>')" id="<?php echo 'fr'.$favoriteProductArray->pro_id;?>"  class="image_boxpro" />
                                            </a>
                                        </div>
                                    </td>
                                    <td width="38%" <?php if($isCounter % 2 != 0){ ?>style="border-right:1px #D4EDFF dotted;"<?php } ?>>
                                        <div class="title_bestvote">
                                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $favoriteProductArray->pro_category; ?>/<?php echo $favoriteProductArray->pro_id; ?>/<?php echo RemoveSign($favoriteProductArray->pro_name); ?>" title="<?php echo $this->lang->line('detail_tip'); ?>">
                                            <?php echo sub($favoriteProductArray->pro_name, 80); ?>
                                            </a>
                                        </div>
                                        <div class="descr_bestvote">
                                           <?php $vovel=array("&curren;"); ?> <?php echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel,"#",$favoriteProductArray->pro_detail))),150); ?>
                                            
                                        </div>
                                        <div class="vote_bestvote">
                                            <?php for($vote = 0; $vote < (int)$favoriteProductArray->pro_vote_total; $vote++){ ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/star1.gif" border="0" alt="" />
                                            <?php } ?>
                                            <?php for($vote = 0; $vote < 10-(int)$favoriteProductArray->pro_vote_total; $vote++){ ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/star0.gif" border="0" alt="" />
                                            <?php } ?>
                                            <font color="#004B7A"><b>[<?php echo $favoriteProductArray->pro_vote; ?>]</b></font>
                                        </div>
                                    </td>
                                    <?php if($isCounter % 2 == 0 && $isCounter < count($favoriteProduct)){ ?>
                                    </tr><tr valign="top">
                                    <?php } ?>
                                    <?php $isCounter++; ?>
                                    <?php } ?>
                                </tr>
                            </table>
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
<?php if(isset($successFavoriteProduct) && $successFavoriteProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_category'); ?>');</script>
<?php } ?>