<?php $this->load->view('home/common/account/header'); ?>

    <div class="container-fluid">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<link type="text/css" href="<?php echo base_url(); ?>templates/home/css/datepicker.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>


<!--BEGIN: RIGHT-->
 <SCRIPT TYPE="text/javascript">
  function SearchRaoVat(baseUrl){
      var id = <?php echo $this->uri->segment(4);?>;
      var slt = $('#pro_type').val();
      if (slt != ''){
          slt = '/'+slt;
      }
		  product_name='';
		  if(document.getElementById('keyword_account').value!='')
		  product_name=document.getElementById('keyword_account').value;
		  window.location = baseUrl+'account/service/detail_daily/'+id+slt+'/search/name/keyword/'+product_name+'/';
}
function submitenterQ(myfield,e,baseUrl)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   SearchRaoVat(baseUrl);
   return false;
   }
else
   return true;
};
</SCRIPT>
<style>
    .addContent .fa{color: #fff;}
    .removeContent .fa{color: #0f1;}
</style>
<div class="col-md-9 col-sm-8 col-xs-12">
    <?php
        if($flash_message){
        ?>
            <div class="message success" >
                <div class="alert alert-warning">
                    <?php echo $flash_message; ?>
                    <button type="button" class="close" data-dismiss="alert">×</button>
                </div>
            </div>
        <?php
        }
    ?>
    <h2 class="page-header"style="margin-top:0">
            Danh sách sản phẩm
    </h2>
    <form name="frmAccountPro" id="frmAccountPro" method="post" action="">
	<div style="overflow: auto">
    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" >
        <?php if($shopid > 0){ ?>
        <?php if(count($product) > 0){ ?>
                <thead>
                <tr>
                    <th colspan="10" class="text-left form-inline">
                       <div class="col-sm-9">
                           <?php $protype = $this->uri->segment(5); ?>
                           <select class="form-control" name="pro_type" id="pro_type">
                               <option value="">--Chọn loại sản phẩm--</option>
                               <option <?php echo ($protype == 'product')? 'selected = "selected"': ''; ?> value="product">Sản phẩm</option>
                               <option <?php echo ($protype == 'service')? 'selected = "selected"': ''; ?> value="service">Dịch vụ</option>
                               <option <?php echo ($protype == 'coupon')? 'selected = "selected"': ''; ?> value="coupon">Coupon</option>
                           </select>
                           <div class="input-group">
                               <input type="text" name="keyword_account"  id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="form-control" onKeyPress="return submitenterQ(this,event,'<?php echo base_url(); ?>')" />
                               <div onclick="SearchRaoVat('<?php echo base_url(); ?>')" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" class="input-group-addon"><i class="fa fa-search"></i></div>
                           </div>
                       </div>
                        <p class="hidden-lg"></p>
                    </th>
                </tr>
                <tr>
                    <th width="4%" class="aligncenter hidden-xs">STT</th>

                    <th width="10%" class="hidden-xs text-center">
                       Hình ảnh
                    </th>
                    <th class="aligncenter" >
                        <?php echo "Tên sản phẩm"; //$this->lang->line('product_list'); ?>
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                    </th>
                    <th width="5%" class="aligncenter">
                        SL
                    </th>
                    <th width="15%" class="aligncenter">
                        Giá
                    </th>
                    <th width="15%" class="hidden-xs">
                        <?php echo $this->lang->line('category_list'); ?>
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                   
                    </th>

                    <th width="5%"></th>
                </tr>
                </thead>
                <?php $idDiv = 1; ?>
                <?php foreach($product as $k=>$productArray){ ?>

                    <!-- Modal -->
                    <div class="modal fade prod_detail_modal" id="myModal<?php echo $k;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle text-danger"></i></button>
                                    <h4 class="modal-title" id="myModalLabel">Chi tiết sản phẩm</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Tên sản phẩm:</div>
                                        <div class="col-lg-9 col-xs-8"><?php echo sub($productArray->pro_name, 100); ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Số lượng:</div>
                                        <div class="col-lg-9 col-xs-8"> <?php echo $productArray->pro_instock; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Giá sản phẩm:</div>
                                        <div class="col-lg-9 col-xs-8"><span class="product_price"><?php echo number_format($productArray->pro_cost,0,",","."); ?> VNĐ</span>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-lg-3 col-xs-4">Giảm giá:</div>
                                        <div class="col-lg-9 col-xs-8">
                                            <?php if($productArray->pro_saleoff_value > 0){ ?><div class="product_discount"> - <?php if($productArray->pro_type_saleoff == 1 && $productArray->pro_saleoff_value > 0){  echo $productArray->pro_saleoff_value." %"; }elseif($productArray->pro_type_saleoff == 2 && $productArray->pro_saleoff_value > 0){ echo number_format($productArray->pro_saleoff_value,0,",",".")." đ";} ?></div><?php } ?>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-lg-3 col-xs-4">Danh mục:</div>
                                        <div class="col-lg-9 col-xs-8"><?php echo $productArray->cat_name; ?></div>
                                    </div>
                                     <div class="row">
                                        <div class="col-lg-3 col-xs-4">Ngày đăng:</div>
                                        <div class="col-lg-9 col-xs-8">  <?php echo date('d-m-Y', $productArray->pro_begindate); ?></div>
                                    </div>
                                     <div class="row">
                                        <div class="col-lg-3 col-xs-4">Cộng Tác Viên Online:</div>
                                        <div class="col-lg-9 col-xs-8">
                                            <?php if((int)$productArray->is_product_affiliate == 1){ ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/public.png"  style="cursor:pointer;" border="0" title="Là sản phẩm Cộng Tác Viên Online" alt="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" style="cursor:pointer;" border="0" title="Không phải sản phẩm Cộng Tác Viên Online" alt="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Trạng thái</div>
                                        <div class="col-lg-9 col-xs-8">
                                            <?php if((int)$productArray->is_product_affiliate == 1){ ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/public.png"  style="cursor:pointer;" border="0" title="Là sản phẩm Cộng Tác Viên Online" alt="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" style="cursor:pointer;" border="0" title="Không phải sản phẩm Cộng Tác Viên Online" alt="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <tr>
                        <td height="45" class="aligncenter hidden-xs"><?php echo $sTT; ?></td>

                        <td class=" aligncenter hidden-xs">
                            <?php
                             $filename = 'media/images/product/'.$productArray->pro_dir.'/'.show_thumbnail($productArray->pro_dir, $productArray->pro_image);
                            if(file_exists($filename) && $filename != ''){
                            ?>
                            <img width="80" src="<?php echo base_url().$filename; ?>" />
                            <?php }else{?>
                                <img width="80" src="<?php echo base_url(); ?>media/images/no_photo_icon.png" />
                            <?php }?>
                        </td>
                        <td>
<!--                            onmouseover="ddrivetip('<table border=0 width=300 cellpadding=1 cellspacing=0><tr><td width=\'20\' valign=\'top\' align=\'left\'><img src=\'--><?php //echo base_url(); ?><!--media/images/product/--><?php //echo $productArray->pro_dir; ?><!--/--><?php //echo show_thumbnail($productArray->pro_dir, $productArray->pro_image); ?><!--\' class=\'image_top_tip\'></td><td valign=\'top\' align=\'left\'>--><?php //echo $productArray->pro_descr; ?><!--</td></tr></table>',300,'#F0F8FF');" onmouseout="hideddrivetip();"-->
                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $productArray->pro_category; ?>/<?php echo $productArray->pro_id; ?>/<?php echo RemoveSign($productArray->pro_name); ?>" >
                                <?php echo sub($productArray->pro_name, 100); ?>
                            </a><span class="badge"><?php echo $productArray->pro_view; ?></span>
                            <p style="font-size:85%"><i>Ngày đăng: <?php echo date('d/m/Y', $productArray->pro_begindate); ?></i></p>

                        </td>
                        <td width="5%" class="aligncenter">
                            <?php echo number_format($productArray->pro_instock); ?>
                        </td>
                        <td width="5%" class="" style="text-align:right;">
                            <span class="product_price"><?php echo number_format($productArray->pro_cost,0,",","."); ?> đ</span>
                            <?php if($productArray->pro_saleoff_value > 0){ ?><div class="product_discount"> - <?php if($productArray->pro_type_saleoff == 1 && $productArray->pro_saleoff_value > 0){  echo $productArray->pro_saleoff_value." %"; }elseif($productArray->pro_type_saleoff == 2 && $productArray->pro_saleoff_value > 0){ echo number_format($productArray->pro_saleoff_value,0,",",".")." đ";} ?></div><?php } ?>
                        </td>
                        <td class="aligncenter hidden-xs">
                            <?php echo $productArray->cat_name; ?>
                        </td>

                        <td class="aligncenter">
                          <p>
                              <?php
                              $statusClass = "addContent";
                              $fa ="fa-plus";
                              if(in_array($productArray->pro_id,$dailycontent)){
                                  $statusClass = "removeContent";
                                  $fa ="fa-check";
                              }
                              ?>

                              <button type="button" class="btn click btn-primary <?php echo $statusClass; ?>" rel="<?php echo $productArray->pro_id; ?>" alt="Thêm">
                                  <i class="fa <?php echo $fa; ?>"></i>
                              </button>
                            </p>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php $sTT++; ?>
                <?php } ?>
        <?php }else{ ?>
        <tr>
        	<td  colspan="10" class="text-center" ><?php echo $this->lang->line('none_record_product_defaults'); ?></td>
		</tr>
        <?php } ?>
        <?php }else{ ?>
        <tr>
            <td>
            	<div class="text-center"><?php echo $this->lang->line('noshop'); ?> <a href="<?php echo base_url(); ?>account/shop">tại đây</a></div>
            </td>
        </tr>
            <?php } ?>
    </table>
		</div>
		<?php if(!empty($linkPage)) {?>
            <?php echo $linkPage; ?>
        <?php }?>
    </form>
    </div>
</div>
    </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>



<script type="text/javascript" lang="javascript">
    $('document').ready(function(){
        $(".click").click(function(){
            var id = $(this).attr("rel");
            myfunction(id);
        });
        $('.janywhere').alertOnClick({
            'title':'Thông báo!',
            'closeOnClick': true
        });
        function myfunction(id){
            if($(".btn[rel="+id+"]").hasClass("addContent")){
                addContent(id);
            }else{
                removeContent(id);
            }
        }
        function addContent(pro_id){
            var id = '<?php echo $id; ?>';
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>account/service/add_daily_content",
                data: { id: id, pro_id : pro_id }
            })
                .done(function( msg ) {
                    if(msg.isOk){
                        $(".btn[rel="+pro_id+"]").removeClass("addContent").addClass("removeContent");
                        $(".btn[rel="+pro_id+"]").find(".fa").removeClass("fa-plus").addClass("fa-check");
                    }
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': msg.msg,
                        'theme': 'default',
                        'closeOnClick':true,
                        'showAnimation': 'fadeInUp',
                        'hideAnimation': 'fadeOutDown'
                    });
                   // alert(msg.msg);
                });
        }
        function removeContent(content_id){
            var id = '<?php echo $id; ?>';
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>account/service/remove_daily_content",
                data: { order_id: id,content_id:content_id  }
            })
                .done(function( msg ) {
                    if(msg.isOk){
                        $(".btn[rel="+content_id+"]").removeClass("removeContent").addClass("addContent");
                        $(".btn[rel="+content_id+"]").find(".fa").removeClass("fa-check").addClass("fa-plus");
                    }
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': msg.msg,
                        'theme': 'default',
                        'closeOnClick':true,
                        'showAnimation': 'fadeInUp',
                        'hideAnimation': 'fadeOutDown'
                    });
                });
        }
    });

</script>