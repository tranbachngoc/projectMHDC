
<?php /* if($listeyeproduct) {
	echo('<pre>'); print_r($listeyeproduct);echo('</pre>');die();	
	}else {
		print_r('aaaaa');die();
	}?>
</pre>
<?php ?>
<?php /* KACH - Nội dung menu eye  */?>

<?php 
function cut_string($str,$len,$more){
	if ($str=="" || $str==NULL) return $str;
	if (is_array($str)) return $str;
		$str = trim($str);
	if (strlen($str) <= $len) return $str;
		$str = substr($str,0,$len);
	if ($str != "") {
	if (!substr_count($str," ")) {
	if ($more) $str .= " ...";
	return $str;
	}
	while(strlen($str) && ($str[strlen($str)-1] != " ")) {
		$str = substr($str,0,-1);
	}
	$str = substr($str,0,-1);
	if ($more) $str .= " ...";
	}
return $str;

} 
?>
<div id="k_eyecontent">

    <ul class="temp_tab_0">
        <li type="product" class="k_producttab current">
            <a onclick="changeHistoryTab('product'); this.blur()" href="javascript:;">
            	<span><b>Sản phẩm đã xem</b></span>
            </a>
        </li>
        <li type="raovat" class="k_raovattab ">
            <a onclick="changeHistoryTab('raovat'); this.blur()" href="javascript:;">
            	<span><b>Rao vặt đã xem</b></span>
            </a>
        </li>
        <li type="hoidap" class="k_hoidaptab">
            <a onclick="changeHistoryTab('hoidap'); this.blur()" href="javascript:;">
            	<span><b>Hỏi đáp đã xem</b></span>
            </a>
        </li>   
    </ul>
    <div class="k_daxemcontent">
        <div id="k_sanphamdaxem">
        <?php if(count($listeyeproduct)>0): ?>
        <?php foreach($listeyeproduct as $listeyeproductitem){?>    	
            <div class="k_item" id="k_item_<?php if($this->session->userdata('sessionUser')>0){echo $listeyeproductitem->id;}else{ echo "product_".$listeyeproductitem->pro_id; } ?>">
                <div class="k_eyethumbimg"><img alt="<?php echo (cut_string($listeyeproductitem->pro_name,10,'...'));?>" src="<?php if($listeyeproductitem->pro_image=='none.gif') echo (base_url().'media/images/product/default/none.gif');  else echo(base_url().'media/images/product/'.$listeyeproductitem->pro_dir.'/'.show_thumbnail($listeyeproductitem->pro_dir, $listeyeproductitem->pro_image, 2));?>"/></div>
                <div class="k_eyedescription">
                    <a href="<?php  echo(base_url().$listeyeproductitem->pro_category.'/'.$listeyeproductitem->pro_id).'/'.RemoveSign($listeyeproductitem->pro_name);?>" title="<?php echo ($listeyeproductitem->pro_name);?>" class="text-link"><span class="k_eyename"><?php echo (cut_string($listeyeproductitem->pro_name,40,'...'));?> </span></a>
                    (Giá:&nbsp;<span class="k_eyeprice">
                    <?php if($listeyeproductitem->pro_cost > 0){?>
                    <?php echo($listeyeproductitem->pro_cost);?>
                    </span>&nbsp;VND)
                    <?php }else{?>Thoả thuận)</span><?php }?>
                    <span class="k_eyedelete"><img alt="delete" <?php if($this->session->userdata('sessionUser')>0){  ?>onclick="deleteEye(<?php echo $listeyeproductitem->id ?>,'<?php echo base_url(); ?>')" <?php }else{ ?>onclick="deleteEyeNoLogin('product',<?php echo $listeyeproductitem->pro_id ?>,'<?php echo base_url(); ?>')"<?php } ?>  src="<?php echo (base_url().'/templates/home/images/icon_history_delete.gif');?>"/></span>
                    <br/>                
                    <span class="font11">Sản phẩm của GH:&nbsp;</span><span class="color003399"><a target="_blank" class="text-link" href="<?php echo (base_url().$listeyeproductitem->sho_link);?>" ><strong><?php echo ($listeyeproductitem->sho_name);?></strong></a></span>            
                </div>        
            </div>
            
            <div class="clr"></div>
        <div class="break_module_line"></div>
        <div class="clear-all" <?php if($this->session->userdata('sessionUser')>0){ ?>onclick="deleteAllEyeType(1,'<?php echo base_url(); ?>');" <?php }else{ ?> onclick="deleteAllEyeTypeNoLogin(1,'<?php echo base_url(); ?>');" <?php } ?>>Xóa tất cả</div>
        <?php }?>
        <?php else: ?>
            <h3 class="nodata">Không có dữ liệu</h3>
            <?php endif; ?>
            
        </div>
        <div id="k_raovatdaxem">
        <?php if(count($listeyeraovat)>0): ?>
        <?php foreach($listeyeraovat as $listeyeraovatitem){?>
            <div class="k_item" id="k_item_<?php if($this->session->userdata('sessionUser')>0){echo $listeyeraovatitem->id;}else{ echo "raovat_".$listeyeraovatitem->pro_id; } ?>">
            <div class="k_eyethumbimg"><img alt="<?php echo (cut_string($listeyeraovatitem->ads_title,10,'...'));?>" src="<?php if($listeyeraovatitem->avatar!='') echo(base_url().'media/images/avatar/'.$listeyeraovatitem->avatar); else echo(base_url().'media/images/avatar/default.png'); ?>"/></div>
            <div class="k_eyedescription">
                <span class="font12"><?php echo $listeyeraovatitem->pre_name;?></span><a href="<?php echo(base_url().'raovat/'.$listeyeraovatitem->ads_category.'/'.$listeyeraovatitem->ads_id).'/'.RemoveSign($listeyeraovatitem->ads_title);?>" title="<?php echo ($listeyeraovatitem->ads_title);?>" class="text-link"><span class="k_eyename"><?php echo (cut_string($listeyeraovatitem->ads_title,60,'...'));?></span></a>
                <span class="k_eyedelete"><img alt="delete" <?php if($this->session->userdata('sessionUser')>0){  ?>onclick="deleteEye(<?php echo $listeyeraovatitem->id ?>,'<?php echo base_url(); ?>')" <?php }else{ ?>onclick="deleteEyeNoLogin('raovat',<?php echo $listeyeraovatitem->ads_id ?>,'<?php echo base_url(); ?>')"<?php } ?>  src="<?php echo (base_url().'/templates/home/images/icon_history_delete.gif');?>"/></span>
                <br/>            
                <span class="font11">Đăng bởi:&nbsp;</span><span class="color003399"><a class="text-link" href="<?php echo(base_url().'user/profile/'.$listeyeraovatitem->use_id);?>" ><?php echo ($listeyeraovatitem->use_username);?></a></span>            
            </div>        
        </div>
        <div class="clr"></div>
        <div class="break_module_line"></div>
         <div class="clear-all" <?php if($this->session->userdata('sessionUser')>0){ ?>onclick="deleteAllEyeType(2,'<?php echo base_url(); ?>');"  <?php }else{ ?> onclick="deleteAllEyeTypeNoLogin(2,'<?php echo base_url(); ?>');" <?php } ?> >Xóa tất cả</div>
        <?php }?>
          <?php else: ?>
            <h3 class="nodata">Không có dữ liệu</h3>
            <?php endif; ?>
       
        </div>
        <div id="k_hoidapdaxem"> 
        <?php if(count($listeyehoidap)>0): ?>   
        <?php foreach($listeyehoidap as $listeyehoidapitem){?>
        
        <div class="k_item" id="k_item_<?php if($this->session->userdata('sessionUser')>0){echo $listeyehoidapitem->id;}else{ echo "hoidap_".$listeyehoidapitem->hds_id; } ?>">
            <div class="k_eyethumbimg"><img alt="<?php echo (cut_string($listeyehoidapitem->hds_title,10,'...'));?>" src="<?php if($listeyeraovatitem->avatar!='') echo(base_url().'media/images/avatar/'.$listeyeraovatitem->avatar); else echo(base_url().'media/images/avatar/default.png');?>"/></div>
            <div class="k_eyedescription">
                <a class="text-link" title="<?php echo ($listeyehoidapitem->hds_title);?>" href="<?php echo(base_url().'hoidap/'.$listeyehoidapitem->hds_category.'/'.$listeyehoidapitem->hds_id).'/'.RemoveSign($listeyehoidapitem->hds_title);?>"><span class="k_eyename"><?php echo (cut_string($listeyehoidapitem->hds_title,60,'...'));?></span></a>
                <span class="k_eyedelete"><img alt="delete" <?php if($this->session->userdata('sessionUser')>0){  ?>onclick="deleteEye(<?php echo $listeyehoidapitem->id ?>,'<?php echo base_url(); ?>')" <?php }else{ ?>onclick="deleteEyeNoLogin('hoidap',<?php echo $listeyehoidapitem->hds_id ?>,'<?php echo base_url(); ?>')"<?php } ?> src="<?php echo (base_url().'/templates/home/images/icon_history_delete.gif');?>"/></span>
                <br/>
                <span class="font11"><?php echo($listeyehoidapitem->up_date);?></span>
                &nbsp;trong:&nbsp;<a href="<?php echo(base_url().'hoidap/'.$listeyehoidapitem->hds_category.'/'.RemoveSign($listeyehoidapitem->cat_name));?>" ><span class="font11" style="color:#999999"><?php echo ($listeyehoidapitem->cat_name);?></span></a>            
            </div>        
        </div>
        <div class="clr"></div>
        <div class="break_module_line"></div>
        <div class="clear-all" <?php if($this->session->userdata('sessionUser')>0){ ?>onclick="deleteAllEyeType(3,'<?php echo base_url(); ?>');"  <?php }else{ ?> onclick="deleteAllEyeTypeNoLogin(3,'<?php echo base_url(); ?>');" <?php } ?> >Xóa tất cả</div>
        <?php }?>
         <?php else: ?>
            <h3 class="nodata">Không có dữ liệu</h3>
            <?php endif; ?>
            
        </div>
    </div>
</div>