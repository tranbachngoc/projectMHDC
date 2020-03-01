<?php
global $idHome;
$idHome=1;
?>
<?php $this->load->view('home/common/account/header'); ?>
<style>
    .addContent .fa{color: #0f1;}
    .removeContent .fa{color: #FF3939;}
</style>
<script type="text/javascript">
    function SearchRaoVat(baseUrl){
        var id = <?php echo $this->uri->segment(4);?>;
        new_name='';
        if(document.getElementById('keyword_account').value!='')
            new_name=document.getElementById('keyword_account').value;
        window.location = baseUrl+'account/service/detail_daily/'+id+'/search/name/keyword/'+new_name+'/';
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
</script>
 <div class="container">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
			<div class="col-md-9 ol-sm-8 col-xs-12 account_edit">
                <h2 class="page-header"style="margin-top:0">
                        Danh sách Tin tức đã đăng
                </h2>
               <div class="wrap_listnew">
                   <?php if(count($listnews) > 0){
                       $linkShop = $shop->sho_link;
                       ?>
                           <div style="margin: 10px 0" class="text-left form-inline">
                               <div class="col-sm-6">
                                   <div class="input-group">
                                       <input type="text" name="keyword_account"  id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="form-control" onKeyPress="return submitenterQ(this,event,'<?php echo base_url(); ?>')" />
                                       <div onclick="SearchRaoVat('<?php echo base_url(); ?>')" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" class="input-group-addon"><i class="fa fa-search"></i></div>
                                   </div>
                               </div>
                           </div>
                       <ul class="docs_cat">
                           <?php foreach($listnews as $item){
                               $filename = 'media/images/tintuc/'.$item->not_dir_image.'/'.show_thumbnail($item->not_dir_image,$item->not_image,1,'tintuc');
                               ?>
                               <li class="row item_<?php echo  $item->not_id;?>">
                                   <div class="col-lg-11 col-md-10 col-sm-8">
                                     <div class="row">
                                         <div class="col-sm-3 col-xs-12">
                                             <a class="item_new" target="_blank"  href="<?php echo base_url().$linkShop;?>/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title);?>">
                                                 <?php if(file_exists($filename) && $filename !=''){?>
                                                     <img src="<?php echo base_url().$filename; ?>" />
                                                 <?php } else{?>
                                                     <img src="<?php echo base_url(); ?>media/images/no_photo_icon.png" />
                                                 <?php }?>
                                             </a>
                                         </div>
                                         <div class="col-sm-9 col-xs-12">
                                             <h2 class="title"><a target="_blank" href="<?php echo base_url().$linkShop;?>/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title);?>">
                                                     <?php $vovel=array("&curren;"); echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel,"#",$item->not_title)),50)) ; ?>
                                                 </a></h2>
                                             <p><?php $vovel=array("&curren;"); echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel,"#",$item->not_detail)),200)) ; ?></p>
                                             <p><i class="fa fa-calendar fa-fw"></i> <?php echo date('d/m/Y',$item->not_begindate); ?> || <a target="_blank" href="<?php echo base_url().$linkShop;?>/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title);?>"><i class="fa fa-file-text-o fa-fw"></i> Xem chi tiết</a></p>
                                         </div>
                                         <div class="clearfix"></div>
                                     </div>
                                   </div>
                                   <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 ">
                                       <?php
                                       $statusClass = "addContent";
                                       $fa ="fa-plus";
                                       if(in_array($item->not_id,$dailycontent)){
                                           $statusClass = "removeContent";
                                           $fa ="fa-check";
                                       }
                                       ?>
                                       <button type="button" class="btn btn-primary click <?php echo $statusClass; ?>" rel="<?php echo $item->not_id; ?>" alt="Thêm">
                                           <i class="fa <?php echo $fa; ?>"></i>
                                       </button>
                                   </div>

                               </li>
                           <?php } ?>
                       </ul>
                       <div class="clearfix"></div>
                       <?php echo $linkPage ?>
                       <div class="clearfix"></div>
                   <?php }elseif(count($listnews) == 0 && trim($keyword) != ''){?>
                   <?php }else{ ?>
                       <p class="text-center">Bạn chưa cập nhật tin tức, vui lòng đăng tin tức <a href="<?php echo base_url(); ?>account/news/add">tại đây</a></p>
                   <?php } ?>
               </div>
        </div>
    </div>
<?php $this->load->view('home/common/footer'); ?>


     <script type="text/javascript" lang="javascript">
         $('document').ready(function(){
            $(".click").click(function(){
               var id = $(this).attr("rel");
                myfunction(id);
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
                         alert(msg.msg);

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
                         alert(msg.msg);
                     });



             }
         });

     </script>