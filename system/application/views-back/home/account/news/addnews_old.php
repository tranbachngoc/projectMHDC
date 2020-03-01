<?php $this->load->view('home/common/account/header'); ?>
<?php
	global $idHome;
	$idHome = 1;
	$group_id = (int) $this->session->userdata('sessionGroup');	
 ?>
<?php $this->load->view('home/common/tinymce'); ?>

<?php 
$listFont = array("Anton","Arsenal","Exo","Francois One","Muli","Nunito Sans","Open Sans Condensed","Oswald","Pattaya","Roboto Condensed","Saira Condensed","Saira Extra Condensed");
//$listFont = array("Alfa Slab One","Anton","Baloo","Bevan","Chonburi","Coiny","Lalezar","Lobster","Pattaya","Paytone One","Sigmar One","Yeseva One");
?>

<link rel="stylesheet" type="text/css" href="/templates/engine1/style.css" />
<script language="javascript">
    document.onclick = check;
    function check(e) {
	var evt = (e) ? e : event;
	var theElem = (evt.srcElement) ? evt.srcElement : evt.target;
	while (theElem != null) {
	    if (theElem.id == "office-location") {
		jQuery('#office-location').remove();
		jQuery("#img_list").css("display", "none");
		jQuery("#img_list_en").css("display", "none");
		break;
	    } else {
		break;
	    }
	}
    }
</script>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12 account_edit">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">THÊM TIN TỨC MỚI</h4>
	    
	<?php if ($shopid > 0) { ?>    
	    <?php if ($successAdd == false) { ?>    
	    
    	    <form name="frmAddNews" method="post" class="form-horizontal" enctype="multipart/form-data">              
    		<!--<div class="form-group khungu">
    		    <div class="col-lg-3"><font color="#FF0000"><b>*</b></font> Danh mục sản phẩm</div>
    		    <div class="col-lg-9">
    			<select name="not_pro_cat_id" id="not_pro_cat_id" class="form-control">
    			    <option value="">Chọn danh mục tin tức</option>
		    <?php /* foreach ($productCategoryRoot as $k => $category) { ?>
		      <option value="<?php echo $category->cat_id ?>"><?php echo $category->cat_name ?></option>
		      <?php } */ ?>
    			</select>
    		    </div>
    		    <div class="clearfix"></div>
    		</div>-->                    

    		<div class="form-group <?php echo form_error('not_pro_cat_id') != '' ? 'has-error': '' ?>">
    		    <div class="col-lg-3"><font color="#FF0000"><b>&nbsp;</b></font> Chuyên mục</div>
    		    <div class="col-lg-9">   
						<?php echo $not_pro_cat_id ?>
                        <select id="cat_pro_0" name="not_pro_cat_id" class="form-control form_control_cat_select">
                            <option value=""> -- Chọn chuyên mục tin tức --</option>
                            <?php 
                            if (isset($catlevel0) && count($catlevel0) > 0) {
                                foreach ($catlevel0 as $item) { ?>
									<option value="<?php echo $item->cat_id; ?>">
                                        <?php echo $item->cat_name; ?><?php echo ($item->child_count > 0) ? '>' : ''; ?>
                                    </option>                                    
                            <?php
                                }
                            } ?>
                        </select>
						<?php echo form_error('not_pro_cat_id'); ?> 
                    </div>
    		    <div class="clearfix"></div>
    		</div>

    		<div class="form-group khungu">
    		    <div class="col-lg-3">
                        <font color="#FF0000"><b>&nbsp;</b></font> Hình đại diện
                    </div>
    		    <div class="col-lg-9">
                        <input type="file" name="image" id="image" class="inputimage_formpost" />					
                        <img style="height:116px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview"/>
                    </div>
    		</div>

    		<div class="form-group <?php echo form_error('title_content') != '' ? 'has-error' : '' ; ?>">
    		    <div class="col-lg-3">
                        <font color="#FF0000"><b>*</b></font>Tiêu đề bài viết: 
                    </div>
    		    <div class="col-lg-9">
                        <input type="text" name="title_content" id="title_content" value="<?php echo $dataAdd['not_title']; ?>" maxlength="130" class="form-control" />
                        <?php echo form_error('title_content'); ?>
                    </div>
    		    <div class="clearfix"></div>
    		</div>

    		<div class="form-group <?php echo form_error('description') != '' ? 'has-error' : '' ; ?>">
    		    <div class="col-lg-3"><font color="#FF0000"><b>*</b></font> Mô tả ngắn</div>
    		    <div class="col-lg-9">
    			<textarea name="description" class="form-control" maxlength="180"><?php echo $dataAdd['not_description']; ?></textarea>
			    <?php echo form_error('description'); ?>
    			<span class="small"><i class="fa fa-info-circle" aria-hidden="true"></i> Nhập tối đa 180 kí tự</span>
    		    </div>
    		    <div class="clearfix"></div>
    		</div>

    		<div class="form-group <?php echo form_error('keywords') != '' ? 'has-error' : '' ; ?>">
    		    <div class="col-lg-3"><font color="#FF0000"><b>*</b></font> Từ khóa bài viết</div>
    		    <div class="col-lg-9">
    			<input type="text" name="keywords" id="keywords" value="<?php echo $dataAdd['not_keywords']; ?>" maxlength="130" class="form-control" />
			    <?php echo form_error('keywords'); ?>                            
    			<span class="small"><i class="fa fa-info-circle" aria-hidden="true"></i> Mỗi từ khóa cách nhau bởi dấu phẩy(,) ví dụ: azibai, kinh doanh online, azibai lien ket</span>
    		    </div>
    		    <div class="clearfix"></div>
    		</div>

    		<div class="form-group <?php echo form_error('txtContent') != '' ? 'has-error' : '' ; ?>">
    		    <div class="col-lg-3"><font color="#FF0000"><b>*</b></font> Nội dung bài viết:</div>
    		    <div class="col-lg-9">
    			<textarea name="txtContent" id="txtContent" class="editor form-control" rows="10"><?php echo $dataAdd['not_detail']; ?></textarea>
			    <?php echo form_error('txtContent'); ?>                           
    		    </div>
    		    <div class="clearfix"></div>
    		</div> 
                <div class="form-group">
                    <div class="col-lg-3">Hiển thị nội dung</div>
                    <div class="col-lg-9">
                       <?php $contentdisplay = array("Mặc định", "Ảnh nền"); ?>    			    
                        <div style="margin-bottom:20px">
                            <select id="not_display" name="not_display" class="form-control">
                                <?php foreach ($contentdisplay as $k => $val) { ?>
                                    <option value="<?php echo $k ?>">
                                        <?php echo $val ?>
                                    </option>
                                <?php } ?>   
                            </select>
                        </div>  
                    </div>
                    <div class="clearfix"></div>
                </div>

    		<div class="form-group khungu">
    		    <div class="col-lg-3">Link Youtube</div>
    		    <div class="col-lg-9">
			<input type="text" name="video" id="video" class="form-control" value="" />
    			<span class="small"><i class="fa fa-info-circle" aria-hidden="true"></i> Ví dụ: https://www.youtube.com/watch?v=q95pKXq8uVg</span>
    		    </div>
    		    <div class="clearfix"></div>
    		</div>
			
			<div class="form-group row">
				<div class="col-lg-3">Nội dung bổ sung</div>
				<div class="col-lg-9">
					<div class="addbox"><a class="btn btn-azibai">Thêm nội dung</a></div>
					<script>                        
                                jQuery(function($){ 
                                    var i = <?php echo count($adddd) ?>;
                                    $('body').on("click",'.delbox', function(e){ $(this).parent().remove(); });
                                    $('.addbox').on("click",function(e){        
                                        $(this).before('<div style="padding: 20px 20px 20px; background:#f9f9f9; border:1px solid #eee; margin-bottom: 20px; position:relative"> <div class="row"> <div class="col-xs-6"> Chọn icon: <div class="input-group"> <input type="text" class="inputicon'+i+' form-control" name="icon[]"> <span class="inserticon input-group-addon" data-toggle="modal" data-target="#myIconModal" data-class=".inputicon'+i+'">Chọn</span> </div> </div> <div class="col-xs-6"> Chọn vị trí: <select tyle="select" name="posi[]" class="form-control"> <option value="left">Icon bên trái</option> <option value="none">Icon chính giữa</option> <option value="right">Icon bên phải</option> </select> </div> </div> Tiêu đề: <input type="text" maxlength="50" name="title[]" class="form-control"> Mô tả: <input type="text" maxlength="100" name="desc[]" class="form-control"> <a style="position: absolute; top: 0; right: 0;" class="delbox btn btn-sm btn-danger">X</a> </div>'); 
                                        i++; 
                                    });
                                    $('body').on('click','.inserticon', function(e){
                                        var dataclass = $(this).data('class');
                                        $('.chooseimage').attr('data-class',dataclass);                                   
                                    });                                    
                                    $('body').on('click','.chooseimage', function(e){
                                        var aimage = $(this).data('image');
                                        var aclass = $(this).data('class');
										$('.aicon').css('outline', 'none');
										$(this).find('img').css('outline', '1px solid red');
                                        $('input'+aclass).val(aimage);
                                    });
                                    
                                    
                                });
                            </script>
                            <?php 
                                $this->load->helper('directory');
                                $icons = directory_map('./images/icons'); 
                            ?>                           
                            <!-- Modal -->
                            <div class="modal fade" id="myIconModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Chọn một icon</h4>
                                  </div>
                                    <div class="modal-body">
                                        <div class="row" style="height:450px; overflow: auto">
                                        <?php if(isset($icons)){
                                        foreach($icons as $image){
                                            $imglink = base_url().'images/icons/'.$image;
                                        ?>
                                        <div class="col-xs-1"> <?php echo '<a class="chooseimage" style="cursor:pointer;" data-image="'.$image.'" title="'.$image.'"><img class="aicon img-responsive" src="'.base_url().'images/icons/'.$image.'"></a>'; ?> </div>
                                        <?php } } ?>
                                        </div>									
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Chèn</button>
                                  </div>
                                </div>
                              </div>
                            </div>
				</div>
			</div>
			
			
		
                
		
		<?php for ($i = 1; $i < 13; $i++) { ?>
		<div style="padding: 25px 20px; background:#f9f9f9; border:1px solid #eee; margin-bottom: 20px;">
		    <div class="row">		
			<div class="col-md-6 col-sm-12" style="margin-bottom: 25px;">
			    <div class="khungu">
				<strong>Thêm hình ảnh <?php echo $i ?>:</strong>
				<br>
				<input type="file" name="image<?php echo $i ?>" id="image<?php echo $i ?>" class="form-control inputimage_slide_formpost" />
				<img 
				    style="height:116px; margin-top: 15px" 
				    class="img-responsive img-thumbnail" 
				    src="/images/noimage.jpg"
				    alt="image preview"
				    />
			    </div>
			    <br>
			    <div>
				Nhập tiêu đề cho hình ảnh
				<input type="text" id="imgtitle<?php echo $i ?>" name="imgtitle<?php echo $i ?>" class="form-control" value="" maxlength="60" placeholder=""/>
			    </div>
			    <br>
			    <div>
				Nhập mô tá cho hình ảnh:
				<textarea name="imgcaption<?php echo $i ?>" id="imgcaption<?php echo $i ?>" class="form-control" rows="7"  maxlength="500" /></textarea>
			    </div>
                            <br>
                            <div>
				Chọn liên kết đến sản phẩm:
				<select name="imglink<?php echo $i ?>" id="product<?php echo $i ?>" class="form-control">
				    <option value="">-- Chọn liên kết --</option>
				    <?php
				    $insp = $incp = 0;
				    foreach ($products as $k => $pro) {
					if ($pro->pro_type == 0) {
					    $insp++;
					    if ($insp == 1) {
						echo '<option value="" disabled> ---SẢN PHẨM--- </option>';
					    }
					} else {
					    $incp++;
					    if ($incp == 1) {
						echo '<option value="" disabled></option><option value="" disabled> ---COUPON--- </option>';
					    }
					}
					?>
					<option value="<?php echo $pro->pro_id; ?>">
					    <?php echo $pro->pro_name; ?>
					</option>
				    <?php } ?>                        
				</select>                            
			    </div>
			    <br>
			    <div>                            
				Nhập liên kết xem thêm:
				<input type="text" name="linkdetail<?php echo $i ?>" id="linkdetail<?php echo $i ?>" value="" class="linkdetail form-control" placeholder="Nhập liên kết xem thêm"/>
			    </div>
			</div>
			<div class="col-md-6 col-sm-12" style="margin-bottom: 20px;">  
			                                
                            <?php
                            //$teffects = "bounce,flash,pulse,rubberBand,shake,swing,tada,wobble,jello,bounceIn,bounceInUp,bounceInDown,bounceInLeft,bounceInRight,bounceOut,bounceOutDown,bounceOutLeft,bounceOutRight,bounceOutUp,fadeIn,fadeInDown,fadeInDownBig,fadeInLeft,fadeInLeftBig,fadeInRight,fadeInRightBig,fadeInUp,fadeInUpBig,fadeOut,fadeOutDown,fadeOutDownBig,fadeOutLeft,fadeOutLeftBig,fadeOutRight,fadeOutRightBig,fadeOutUp,fadeOutUpBig,flip,flipInX,flipInY,flipOutX,flipOutY,lightSpeedIn,lightSpeedOut,rotateIn,rotateInDownLeft,rotateInDownRight,rotateInUpLeft,rotateInUpRight,rotateOut,rotateOutDownLeft,rotateOutDownRight,rotateOutUpLeft,rotateOutUpRight slideInUp,slideInDown,slideInLeft,slideInRight,slideOutUp,slideOutDown,slideOutLeft,slideOutRight,zoomIn,zoomInDown,zoomInLeft,zoomInRight,zoomInUp,zoomOut,zoomOutDown,zoomOutLeft,zoomOutRight,zoomOutUp,hinge,jackInTheBox,rollIn,rollOut";
                            $teffects = "bounce,flash,pulse,rubberBand,shake,swing,tada,wobble,jello,bounceIn,bounceInUp,bounceInDown,bounceInLeft,bounceInRight,fadeIn,fadeInDown,fadeInDownBig,fadeInLeft,fadeInLeftBig,fadeInRight,fadeInRightBig,fadeInUp,fadeInUpBig,flip,flipInX,flipInY,lightSpeedIn,rotateIn,rotateInDownLeft,rotateInDownRight,rotateInUpLeft,rotateInUpRight,slideInUp,slideInDown,slideInLeft,slideInRight,zoomIn,zoomInDown,zoomInLeft,zoomInRight,zoomInUp,jackInTheBox,rollIn";
                            $listeffects = explode(',', $teffects);
                            ?> 
			    
			    <div> 
				Hiệu ứng hình ảnh:
				<select id="imgeffect<?php echo $i ?>" name="imgeffect<?php echo $i ?>" class="form-control input--dropdown js--animations">
				    <?php foreach ($listeffects as $e) { ?>
					<option value="<?php echo $e ?>" <?php echo $e == 'fadeIn' ? "selected" : "" ?>><?php echo $e ?></option>
				    <?php } ?> 
				</select>
			    </div>
			    <br>
			    <div>
				Hiệu ứng văn bản:
				<select id="texteffect<?php echo $i ?>" name="texteffect<?php echo $i ?>" class="form-control input--dropdown js--animations">
				    <?php foreach ($listeffects as $e) { ?>
					<option value="<?php echo $e ?>" <?php echo $e == 'fadeIn' ? "selected" : "" ?>><?php echo $e ?></option>
				    <?php } ?>   
				</select>
			    </div>
                            
                            <?php $display = array("Mặc định", "Màu nền, màu chữ", "Ảnh nền"); ?>
                            <br>
			    <div>
                                Hiển thị
                                <select id="display<?php echo $i ?>" name="display<?php echo $i ?>" class="form-control">
                                    <?php foreach ($display as $k => $val) { ?>
                                    <option value="<?php echo $k ?>">
                                            <?php echo $val ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div> 
                            <br>
                            <div class="row bgcl_<?php echo $i ?>" style="display: none; margin-bottom:20px;">
                                <div class="col-xs-6">
                                    Chọn màu nền:<br>
                                    <input type="color" id="background<?php echo $i ?>" name="background<?php echo $i ?>"  value="#ffffff" />
                                </div>                                			
                                <div class="col-xs-6">
                                    Chọn màu chữ:<br>
                                    <input type="color" id="color<?php echo $i ?>" name="color<?php echo $i ?>" value="#000000" />
                                </div>
			    </div>
                            <script>
                                jQuery(function($){
                                    $('#display<?php echo $i ?>').on('change', function() {
                                        if(this.value == 1){
                                            $('.bgcl_<?php echo $i ?>').slideDown();
                                        } else {
                                            $('.bgcl_<?php echo $i ?>').slideUp();
                                        }
                                    });						    
                                });						    
                            </script>
                            
                            <div style="margin-bottom:20px">
                                Nhập text image 1:
                                <input type="text" id="text_1_image_<?php echo $i ?>" name="text_1_image<?php echo $i ?>" class="linkdetail form-control" value="" maxlength="50"/>
                            </div>

                            <div style="margin-bottom:20px">
                                Nhập text image 2:
                                <input type="text" id="text_2_image_<?php echo $i ?>" name="text_2_image<?php echo $i ?>" class="linkdetail form-control" value="" maxlength="50"/>
                            </div>

                            <div style="margin-bottom:20px">
                                Nhập text image 3:
                                <input type="text" id="text_3_image_<?php echo $i ?>" name="text_3_image<?php echo $i ?>" class="linkdetail form-control" value="" maxlength="50"/>
                            </div>
                            <div class="row">    
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div style="margin-bottom:20px">
                                                        Chọn màu nền:
                                                        <input class="changecolor<?php echo $i ?>" type="color" id="bg_color<?php echo $i ?>" name="bg_color<?php echo $i ?>" value="#000000"/>
                                                    </div>
                                                    <div style="margin-bottom:20px">                                                        
                                                        <input class="changecolor<?php echo $i ?>" type="range" id="ra_color<?php echo $i ?>" name="ra_color<?php echo $i ?>" min="0" max="1" step="0.1" value="0.5">                                            
                                                        <input type="hidden" id="rgba_color<?php echo $i ?>" name="rgba_color<?php echo $i ?>" value="rgba(0,0,0,.5)"> 
                                                    </div>                                                
                                                    <div style="margin-bottom:20px">
                                                        Chọn màu chữ:
                                                        <input class="changecolor<?php echo $i ?>" type="color" id="text_color<?php echo $i ?>" name="text_color<?php echo $i ?>" value="#ffffff" />
                                                    </div>
                                                    <div style="margin-bottom:20px">
                                                        Vị trí hiển thị:
                                                        <?php $position = array("top","middle","bottom"); ?>
                                                        <select class="changecolor<?php echo $i ?> form-control" id="text_position<?php echo $i ?>" name="text_position<?php echo $i ?>">
                                                        <?php foreach($position as $pos){ ?> 
                                                            <option value="<?php echo $pos ?>" <?php echo ($pos == 'middle')?'selected':''; ?> ><?php echo $pos ?></option>   
                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div style="margin-bottom:20px">
                                                        Font chữ:
                                                        <select class="changecolor<?php echo $i ?> form-control" id="text_font<?php echo $i ?>" name="text_font<?php echo $i ?>">
                                                        <?php foreach($listFont as $f => $font){ ?> 
                                                            <option value="<?php echo $font ?>" <?php echo ($f == $i - 1)?'selected':''; ?> ><?php echo $font ?></option>   
                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                    <script>
                                                        jQuery(function($) {
                                                            var color = $("#bg_color<?php echo $i ?>").val();
                                                            var opacity = $("#ra_color<?php echo $i ?>").val();
                                                            var textcolor = $('#text_color<?php echo $i ?>').val();
                                                            var rgbaCol = $('#rgba_color<?php echo $i ?>').val();
                                                            var vtcal = $('#text_position<?php echo $i ?>').val();
                                                            var texteffect = $('#text_effect_in<?php echo $i ?>').val();
                                                            $(".changecolor<?php echo $i ?>").change(function() {
                                                                color = $("#bg_color<?php echo $i ?>").val();
                                                                opacity = $("#ra_color<?php echo $i ?>").val();
                                                                textcolor = $('#text_color<?php echo $i ?>').val();
                                                                vtcal = $('#text_position<?php echo $i ?>').val();																
                                                                rgbaCol = 'rgba(' + parseInt(color.slice(-6, -4), 16) + ',' + parseInt(color.slice(-4, -2), 16) + ',' + parseInt(color.slice(-2), 16) + ',' + opacity + ')';
                                                                $('#rgba_color<?php echo $i ?>').val(rgbaCol);
                                                                $('#divcolor<?php echo $i ?>').css({"background-color": rgbaCol, "color": textcolor});
                                                                $('#position<?php echo $i ?>').css({"vertical-align": vtcal});																
                                                            });
                                                          });
                                                   </script>												   
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div style="position: relative; height: 190px; background:url(/images/noimage.jpg) no-repeat center / cover"> 
                                                        <div style="position: absolute; top:0; right:0; bottom:0; left:0; overflow: hidden;"> 
                                                            <div style="display:table; height:100%">
                                                                <div id="position<?php echo $i ?>" style="display:table-cell;vertical-align:middle;">
                                                                    <div style=" background-color:rgba(0,0,0,.5); color: #ffffff">
                                                                        <div id="divcolor<?php echo $i ?>" style=" padding:10px 15px; background-color:<?php echo $value['style']->rgba_color; ?>; color: <?php echo $value['style']->text_color; ?>; ">
                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.  
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div style="margin-bottom:20px">
                                                    Hiệu ứng 1:
                                                    <?php
                                                    $effin = array(
                                                        "fadeIn", "fadeInUp", "fadeInDown", "fadeInLeft", "fadeInRight",
                                                        "bounceIn", "bounceInUp", "bounceInDonw", "bounceInLeft", "bounceInRight",
                                                        "rotateIn", "rotateInUpLeft", "rotateInUpRight", "rotateInDownLeft", "rotateInDownRight",
                                                        "slideInUp", "slideInDown", "slideInLeft", "slideInRight",
                                                        "zoomIn", "zoomInUp", "zoomInDown", "zoomInLeft", "zoomInRight"
                                                    );
                                                    ?>
                                                    <select class="changecolor<?php echo $i ?> form-control" id="text_effect_in<?php echo $i ?>" name="text_effect_in<?php echo $i ?>">
                                                        <?php foreach ($effin as $e) { ?> 
                                                            <option value="<?php echo $e ?>" <?php echo ($value['style']->text_effect_in == $e) ? 'selected' : ''; ?> ><?php echo $e ?></option>   
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div style="margin-bottom:20px">
                                                    Hiệu ứng 2:
                                                    <?php
                                                    $effout = array(
                                                        "fadeOut", "fadeOutUp", "fadeOutDown", "fadeOutLeft", "fadeOutRight",
                                                        "bounceOut", "bounceOutUp", "bounceOutDonw", "bounceOutLeft", "bounceOutRight",
                                                        "rotateOut", "rotateOutUpLeft", "rotateOutUpRight", "rotateOutDownLeft", "rotateOutDownRight",
                                                        "SlideOutUp", "SlideOutDown", "SlideOutLeft", "SlideOutRight",
                                                        "zoomOut", "zoomOutUp", "zoomOutDown", "zoomOutLeft", "zoomOutRight"
                                                    );
                                                    ?>
                                                    <select class="changecolor<?php echo $i ?> form-control" id="text_effect_out<?php echo $i ?>" name="text_effect_out<?php echo $i ?>">
                                                        <?php foreach ($effout as $e) { ?> 
                                                            <option value="<?php echo $e ?>" <?php echo ($value['style']->text_effect_out == $e) ? 'selected' : ''; ?> ><?php echo $e ?></option>   
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                            
			</div>
		    </div>
                    
                    <div class="row">                        
                        <div class="col-sm-12 addbox<?php echo $i + 1 ?>"><a class="btn btn-azibai">+ Thêm mô tả nổi bật</a></div>								
                        <script>                        
                                jQuery(function($){ 
                                        var i = 0;
                                        $('body').on("click",'.delbox', function(e){ $(this).parent().remove(); });
                                        $('.addbox<?php echo $i + 1 ?>').on("click",function(e){        
                                                $(this).before('<div class="col-sm-6"> <div style="padding: 20px 20px 20px; background:#e5e5e5; border:1px solid #eee; margin-bottom: 20px;"> <br>Chọn icon: <div class="input-group"> <input type="text" class="inputicon<?php echo $i + 1 ?>'+i+' form-control" name="icon<?php echo $i + 1 ?>[]"> <span class="inserticon input-group-addon" data-toggle="modal" data-target="#myIconModal" data-class=".inputicon<?php echo $i + 1 ?>'+i+'">Chọn</span> </div> <br>Chọn vị trí: <select tyle="select" name="posi<?php echo $i + 1 ?>[]" class="form-control"> <option value="left">Icon bên trái</option> <option value="center">Icon chính giữa</option> <option value="right">Icon bên phải</option> </select> <br>Hiệu ứng: <select tyle="select" name="effect<?php echo $i + 1 ?>[]" class="form-control"> <option value="fadeInLeft">fadeInLeft</option> <option value="fadeInRight">fadeInRight</option> <option value="fadeInUp">fadeInUp</option> <option value="fadeInDown">fadeInDown</option> </select> <br>Tiêu đề: <input type="text" maxlength="50" name="title<?php echo $i + 1 ?>[]" class="form-control"> <br>Mô tả: <textarea name="desc<?php echo $i + 1 ?>[]" maxlength="100" class="form-control" rows="2"/></textarea> </div> <a style="position: absolute; top: 0; right: 0;" class="delbox btn btn-sm btn-danger">X</a> </div>'); 
                                                i++; 
                                        });
                                        $('body').on('click','.inserticon', function(e){
                                                var dataclass = $(this).data('class');
                                                $('.chooseimage').attr('data-class',dataclass);                                   
                                        });                                    
                                        $('body').on('click','.chooseimage', function(e){
                                                var aimage = $(this).data('image');
                                                var aclass = $(this).data('class');
                                                $('.aicon').css('outline', 'none');
                                                $(this).find('img').css('outline', '1px solid blue');
                                                $('input'+aclass).val(aimage);
                                        });                                    

                                });
                        </script>
                    </div>                   
		</div>
		<?php } ?> 
	
		   		    


    		
                    <hr/>
                    <h3>Trình diễn <span class="small">(Bạn phải upload it nhất 3 hình ảnh để tạo slideshow)</span>
                        <span class="small pull-right">                            
                            <label class="radio-inline">
                                <input type="radio" name="slideshow" id="nocheck" value="0" checked> Tắt
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="slideshow" id="ischeck" value="1" > Bật 
                            </label>
                        </span>
                    </h3>
                    <script>
                    jQuery(function($){
                        $('#ischeck').click(function(){$('.slideshow_wrapper').slideDown();});
                        $('#nocheck').click(function(){$('.slideshow_wrapper').slideUp();});
                    });
                    </script>
                    <div class="row slideshow_wrapper" style="display:none;">
                        <div class="col-lg-3">                                                           
			    <?php
			    /*$all_effects = 'turn,shift,louvers,cube_over,tv,lines,bubbles,dribbles,glass_parallax,parallax,brick,collage,seven,kenburns,cube,blur,book,rotate,domino,slices,blast,blinds,basic,basic_linear,fade,fly,flip,page,stack,stack_vertical';
			    $effects = explode(',', $all_effects);*/			    
			    $effect_array = array(
				    "cube|CubeIn",
				    "flip|DepthPage",
				    "fade|Fade",
				    "flip|FlipHorizontal",
				    "shift|FlipPage",
				    "page|RotateDown",
				    "book|RotateUp",
				    "stack|Stack",
				    "basic|Tablet",
				    "kenburns|ZoomIn",
				    "fly|ZoomOut",
				    "slices|ZoomOutSlide"
				);				
			    ?>
			   
    			Chọn hiệu ứng:     			
			<select id="ef" name="effect" class="form-control">
			    <option value="fade|Fade"> -- Chọn một hiệu ứng -- </option>
			    <?php foreach ($effect_array as $evalue) { $e = explode('|', $evalue); ?>
			    <option value="<?php echo $evalue ?>"><?php echo $e[0] ?></option>
			    <?php } ?>
			</select>
    		    </div>
    		    <div class="col-lg-3">
			    <?php
			    $this->load->helper('directory');
			    $musics = directory_map('./media/musics');
			    ?>
    			Chọn nhạc nền:
    			<select id="ms" name="music" class="form-control">
    			    <option value="">Chọn nhạc</option>
				<?php foreach ($musics as $value) { ?>
				    <option value="<?php echo $value ?>"><?php echo $value ?></option>
				<?php } ?>
    			</select>
    			<audio src="/media/musics/<?php echo $musics[0] ?>"></audio>		                            
    		    </div>

    		    <div class="col-lg-2">	
    			<!-- Button trigger modal -->
    			<br/>
    			<button type="button" class="btn btn-azibai btn-block show-modal" data-toggle="modal" data-target="#slideModal_1">
    			    Xem trước
    			</button>
    			<!-- Modal -->
    			<div class="modal fade" id="slideModal_1" tabindex="-1" role="dialog" aria-labelledby="slideModalLabel">
    			    <div class="modal-dialog" role="document">
    				<div id="wowslider_container_1" class="wowslider-container">
    				    <div class="ws_images">
    					<ul>
						<?php
						$list_image = directory_map('./media/slides');
						foreach ($list_image as $key => $val) {
						    ?>
						    <li><img src="/media/slides/<?php echo $val ?>" alt="img1" title="img1" id="wows<?php echo $key ?>_0"/></li>    
						<?php } ?>
    					</ul>
    				    </div>
    				    <div class="ws_bullets">
    					<div>
						<?php foreach ($list_image as $key => $val) { ?>
						    <a href="#" title="img<?php echo $key ?>">
							<span><?php echo $key ?></span>
						    </a>
						<?php } ?>
    					</div>
    				    </div>					
    				    <audio src="/media/musics/<?php echo $musics[0] ?>"></audio>						
    				</div>
    			    </div>
    			</div>  
    			<div class="modal fade" id="slideModal_2" tabindex="-1" role="dialog" aria-labelledby="slideModalLabel">
    			    <div class="modal-dialog" role="document">
    				<div id="wowslider_container_2" class="wowslider-container">
    				    <div class="ws_images">
    					<ul>
						<?php
						$list_image = directory_map('./media/slides');
						foreach ($list_image as $key => $val) {
						    ?>
						    <li><img src="/media/slides/<?php echo $val ?>" alt="img1" title="img1" id="wows<?php echo $key ?>_0"/></li>    
						<?php } ?>
    					</ul>
    				    </div>
    				    <div class="ws_bullets">
    					<div>
					    <?php foreach ($list_image as $key => $val) { ?>
						<a href="#" title="img<?php echo $key ?>">
						    <span><?php echo $key ?></span>
						</a>
					    <?php } ?>
    					</div>
    				    </div>					
    				    <audio src="/media/musics/<?php echo $editnew->not_music; ?>"></audio>
    				</div>							
    			    </div>
    			</div>
    		    </div>
                </div>
                    <hr/>                                       
                    <h3>                                                    
                        Quảng cáo
                        <span class="small pull-right">
                            <label class="radio-inline">
                                <input id="ad_status1" type="radio" name="ad_status" value="0" checked> Tắt 
                            </label>
                            <label class="radio-inline">
                                <input id="ad_status2" type="radio" name="ad_status" value="1"> Bật
                            </label> 
                        <span>                       
                    </h3> 
                    <script>
                    jQuery(function($){
                        $('#ad_status2').click(function(){$('.show_inputad').slideDown();});
                        $('#ad_status1').click(function(){$('.show_inputad').slideUp();});
                    });
                    </script>
                    <div class="row show_inputad"  style="display:  none">
                        <div class="col-lg-3">                              
                            Chọn hình thay thế:
                            <input type="file" name="ad_image" id="ad_image" class="form-control">                            
                            <img style="margin: 15px 0 0" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview">
                        </div>  
                        <div class="col-lg-9">
                            <div class="">                                    
                            Liên kết quảng cáo: 
                            <input type="text" name="ad_link" id="ad_link" class="form-control" placeholder="Liên kết quảng cáo" value="">		
                            </div>
                            <br>
                            
                            <?php for ($i=0; $i<3; $i++) { ?>
                            Nội dung <?php echo $i + 1 ?>:
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" name="ad_title<?php echo $i + 1 ?>" id="ad_title<?php echo $i + 1 ?>" class="form-control" placeholder="Tiêu đề <?php echo $i + 1 ?>" maxlength="30">		
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="ad_desc<?php echo $i + 1 ?>" id="ad_desc<?php echo $i + 1 ?>" class="form-control" placeholder="Mô tả <?php echo $i + 1 ?>" maxlength="120">
                                </div>
                            </div>
                            <br>
                            <?php } ?>
                           
                            <div class="">
                            Countdown kết thúc ngày:
                            <input type="date" name="ad_time" id="ad_time" class="form-control" value="">	
                            </div>
                            <br>
                            <div class="">
                                Hiển thị:
                                <div class="radio">
                                    <label>
                                      <input type="radio" name="ad_display" id="ad_display1" value="1" checked>
                                      Đồng hồ số
                                    </label>
                                </div>                            
                                <div class="radio">
                                    <label>
                                      <input type="radio" name="ad_display" id="ad_display2" value="2">
                                      Countdown
                                    </label>
                                </div>	
                            </div>  
                        </div>  
                    </div>
                    <hr/>

                   
                    <!-- start thống kê -->
                    <h3>Thống kê
                        <span class="small pull-right">                            
                            <label class="radio-inline">
                                <input id="statistic1" type="radio" name="not_statistic" value="0" checked> Tắt
                            </label>
                            <label class="radio-inline">
                                <input id="statistic2" type="radio" name="not_statistic" value="1" > Bật
                            </label>
                        </span>
                    </h3>                    
                    <script>
                    jQuery(function($){
                        $('#statistic2').click(function(){$('.show_inputstatistic').slideDown();});
                        $('#statistic1').click(function(){$('.show_inputstatistic').slideUp();});
                    });
                    </script>
		<div class="show_inputstatistic" style="display:  none">	
                    <div class="form-group" style="margin-bottom: 20px;">                
                        <div class="col-lg-3">Ảnh Thống Kê</div>
                        <div class="col-lg-9">
                            <input type="file" name="img_statistic" id="img_statistic" class="form-control">
                            <img style="height:116px; margin: 15px 0 0" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <?php  for ($i=1; $i < 5; $i++) { ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">  
                            <div style="padding: 20px 20px 20px; background:#f9f9f9; border:1px solid #eee; margin-bottom: 20px; ">
                                <div style="margin-bottom:20px">
                                    Thống Kê <?php echo $i; ?>
                                    <input type="number" name="statistic[<?php echo $i; ?>][num]" class="form-control" value="" placeholder="Nhập thống kê" maxlength="4">
                                </div>

                                <div style="margin-bottom:20px">
                                    Tiêu Đề <?php echo $i; ?>:
                                    <input type="text" name="statistic[<?php echo $i; ?>][title]" class="form-control" value="" placeholder="Nhập tiêu đề thống kê" maxlength="30">
                                </div>

                                <div style="margin-bottom:20px">
                                    Mô tả <?php echo $i; ?>:
                                    <textarea name="statistic[<?php echo $i; ?>][description]" class="form-control" placeholder="Nhập mô tả thống kê" rows="3" maxlength="120"></textarea>
                                </div>                                
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div><!--  end thống kê -->
			
		<hr/>
                    <h3>KHÁCH HÀNG</h3> 
                    <div class="well">                         
                        <div class="row">
                            <div class="col-sm-6">                               
                                <label for="cus_title" class="control-label">Tiêu đề: </label><br>                               
                                <input type="text" name="cus_title" class="form-control" value="KHÁCH HÀNG VIẾT VỀ CHÚNG TÔI">
                            </div>
                            <div class="col-sm-3">
                                <label for="cus_color" class="control-label">Màu chữ: </label><br>                                    
                                <input type="color" name="cus_color"  value="#FFFFFF"  style="height: 34px; width:100%">
                            </div>
                            <div class="col-sm-3"> 
                                <label for="cus_background" class="control-label">Màu nền: </label><br>                                    
                                <input type="color" name="cus_background"  value="#333333"  style="height: 34px; width:100%">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="cus_number" id="cus_number" value="0"> 
                    <div class="addboxcustomer"><a class="btn btn-azibai">+ Thêm ý kiến khách hàng</a></div>
                    <script>                        
                        jQuery(function($){                            
                            $('.addboxcustomer').on("click",function(e){ 
                                var html = '<div class="well" style="position:relative"><br><div class="row"><div class="col-sm-6 form-horizontal"><div class="form-group"><label for="cus_avatar" class="col-sm-3 control-label">Hình ảnh: </label><div class="col-sm-9"><input type="file" name="cus_avatar[]" class="form-control" value=""><img style="height:116px; margin-top: 15px;" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview"> </div></div><div class="form-group"> <label for="cus_link" class="col-sm-3 control-label">Link ảnh: </label> <div class="col-sm-9"> <input type="url" name="cus_link[]" class="form-control" value=""> </div> </div><div class="form-group"><label for="cus_facebook" class="col-sm-3 control-label">Facebook: </label><div class="col-sm-9"> <input type="url" name="cus_facebook[]" class="form-control" value=""></div></div><div class="form-group"><label for="cus_twitter" class="col-sm-3 control-label">Twitter: </label><div class="col-sm-9"> <input type="url" name="cus_twitter[]" class="form-control" value=""></div></div><div class="form-group"><label for="cus_google" class="col-sm-3 control-label">Google+: </label><div class="col-sm-9"> <input type="url" name="cus_google[]" class="form-control" value=""></div></div></div><div class="col-sm-6 form-horizontal"><div class="form-group"><label for="cus_text1" class="col-sm-3 control-label">Text 1: </label><div class="col-sm-9"> <input type="text" name="cus_text1[]" class="form-control" value=""></div></div><div class="form-group"><label for="cus_text2" class="col-sm-3 control-label">Text 2: </label><div class="col-sm-9"> <input type="text" name="cus_text2[]" class="form-control" value=""></div></div><div class="form-group"><label for="cus_text3" class="col-sm-3 control-label">Text 3: </label><div class="col-sm-9"> <textarea name="cus_text3[]" class="form-control" rows="10" ></textarea></div></div></div></div><a style="position: absolute; top: 0; right: 0;" class="delboxcustomer btn btn-sm btn-danger">X</a></div>';
                                $(this).before(html);                                
                            });
                            $('body').on("click",'.delboxcustomer', function(e){                                 
                                $(this).parent().remove();                                                             
                            });
                        });
                    </script>
                    <hr/>	
			
    		<div class="form-group khungu">						
			<?php if ($group_id == AffiliateStoreUser) { ?>
			    <div class="col-lg-3 col-md-3 col-sm-12">
				<input type="checkbox" name="active_content" id="active_content" value="1" <?php
				if ($editnew->not_status == '1') {
				    echo 'checked="checked"';
				}
				?> /> Kích hoạt tin
			    </div>                       
			<?php } ?>
    		    <div class="col-lg-3 col-md-3 col-sm-12"><input type="checkbox" value="1" name="not_news_hot" id="not_news_hot" /> Tin tức HOT</div>
    		    <div class="col-lg-3 col-md-3 col-sm-12"><input type="checkbox" value="1" name="not_news_sale" id="not_news_sale" /> Tin khuyến mãi
    		    </div>
    		    
    		    <div class="clearfix"></div>
    		</div>

    		<div class="form-group khungu">
    		    <div class="col-sm-3 col-sm-offset-3 col-xs-6">
					<button class="btn btn-azibai btn-block btnupdate">Đăng tin</button>
    		    </div>
		    <div class="col-sm-3 col-xs-6">
    			<button class="btn btn-default btn-block" onclick="ActionLink('<?php echo base_url(); ?>account/news/add')">Hủy bỏ</button>
		    </div>
    		</div>
    		<div class="clearfix"></div>

    	    </form>
		
	    
	    <?php } else { ?>
    	    <div class="form-group khungu">
    		<p class="text-center"><a href="<?php echo base_url() . "account/news" ?>">Click vào đây để tiếp tục</a></p>Bạn đã đăng tin thành công
    	    </div>
	    <?php } ?>
	<?php } else { ?>    
	    <div class="form-group">
                <div class="col-sm-12 col-xs-12">
                    <p>
			<?php echo $this->lang->line('noshop'); ?> 
                        <a href="<?php echo base_url(); ?>account/shop">tại đây</a>
		    </p>
                </div>
            </div>
	<?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="/templates/engine1/wowslider.js"></script>
<script type="text/javascript" src="/templates/engine1/script.js"></script>
<script>
    $("#wowslider_container_1").wowSlider({effect: "fade", prev: "", next: "", duration: 20 * 100, delay: 10 * 100, width: 800, height: 450, autoPlay: false, autoPlayVideo: true, playPause: true, stopOnHover: true, loop: true, bullets: 1, caption: true, captionEffect: "fade", controls: true, controlsThumb: false, responsive: 2, fullScreen: true, gestures: 2, onBeforeStep: 0, images: 0});
    
    $("#ms").change(function () {
	    $("audio").attr('src', '/media/musics/' + $("#ms option:selected").text());
	});	
	var wow = $("#wowslider_container_2");
	var bkpCont = $(document.createElement("div")).append(wow.clone()).html();
	$('#ef').change(function () {
	    $('.show-modal').attr("data-target", "#slideModal_2");
	    var eff = $("#ef option:selected").val().split('|');
	    $("audio").attr('src', '/media/musics/' + $("#ms option:selected").text());
	    wow = $(bkpCont).replaceAll(wow);
	    wow.wowSlider({effect: eff[0], prev: "", next: "", duration: 20 * 100, delay: 10 * 100, width: 800, height: 450, autoPlay: false, autoPlayVideo: true, playPause: true, stopOnHover: true, loop: true, bullets: 1, caption: true, captionEffect: "fade", controls: true, controlsThumb: false, responsive: 2, fullScreen: true, gestures: 2, onBeforeStep: 0, images: 0});
	});

	$('.modal').click(function () {
	    $('.ws_pause').trigger('click')
	});
	
	$('.inputimage_slide_formpost').change(function () {
	    var x = 0;
	    $('.inputimage_slide_formpost').each(function(){
		if (this.value.length > 0){ x++; }
	    });
	    if (x >= 3){
		$('#ischeck').removeAttr('disabled');
	    } else {
		$('#ischeck').attr('disabled', 'true');
		$('#nocheck').attr('checked', 'true');
	    }
	});	
    

        $('body').on('change', '[type="file"]', showPreviewImage_click); 
	
	function showPreviewImage_click(e) {
	    var $input = $(this);
	    var inputFiles = this.files;
	    if(inputFiles == undefined || inputFiles.length == 0) return;
	    var inputFile = inputFiles[0];

	    var reader = new FileReader();
	    reader.onload = function(event) {
		    $input.next().attr("src", event.target.result);
	    };
	    reader.onerror = function(event) {
		    alert("I AM ERROR: " + event.target.error.code);
	    };
	    reader.readAsDataURL(inputFile);
	}
	
	function validateForm() {
	    var a = $('input["title_content"]').val();
	    if (a == "") {
		$.jAlert({
		    'title': 'Yêu cầu nhập',
		    'content': 'Bạn chưa nhập tiêu đề bài viết!',
		    'theme': 'default',
		    'btns': {
			'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
			    e.preventDefault();
			    document.getElementById("title_content").focus();
			    return false;
			}
		    }
		});
		return false;
	    }	    
	    var b = document.forms["frmAddNews"]["description"].value;
	    if (b == "") {
		$.jAlert({
		    'title': 'Yêu cầu nhập',
		    'content': 'Bạn chưa nhập tiêu đề mô tả ngắn!',
		    'theme': 'default',
		    'btns': {
			'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
			    e.preventDefault();
			    document.getElementById("title_content").focus();
			    return false;
			}
		    }
		});		
		return false;
	    }
	    var c = document.forms["frmAddNews"]["keywords"].value;
	    if (c == "") {
		$.jAlert({
		    'title': 'Yêu cầu nhập',
		    'content': 'Bạn chưa nhập tiêu đề từ khóa!',
		    'theme': 'default',
		    'btns': {
			'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
			    e.preventDefault();
			    document.getElementById("keywords").focus();
			    return false;
			}
		    }
		});
		return false;
	    }
	    var d = document.forms["frmAddNews"]["txtContent"].value;
	    if (d == "") {
		$.jAlert({
		    'title': 'Yêu cầu nhập',
		    'content': 'Bạn chưa nhập tiêu đề nội dung bài viết!',
		    'theme': 'default',
		    'btns': {
			'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
			    e.preventDefault();
			    document.getElementById("txtContent").focus();
			    return false;
			}
		    }
		});
		return false;
	    }
	    return true; 	
	}
	
	var adomain = '<?php echo domain_site ?>'; 	
	var af_id = '?af_id=<?php echo $af_id ?>';
	$('input.linkdetail').focusout(function(){
       var str = $(this).val();     
	   if( str.search(adomain) != -1 ){
			$(this).attr('value', str + af_id);			
	   } 
    });

	$('body').on("click",'.btnupdate', function(e){ 
        console.log('vao day choi');
        CheckInput_newsEdit();
    });
	
	/*
	$("#image1, #image2, #image3, #image4, #image5, #image6, #image7, #image8, #image9, #image10, #image11, #image12").change(function () {
	    var iSize = ($(this)[0].files[0].size / 1024);
	    if ((Math.round((iSize / 1024) * 100) / 100) > 3)
	    {
		$.jAlert({
		    'title': 'Thông báo',
		    'content': 'Hình ảnh không quá 3Mb, vui lòng chọn hình khác!',
		    'theme': 'default',
		    'btns': {
			'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
			    e.preventDefault();
			    $("#image1, #image2, #image3, #image4, #image5, #image6, #image7, #image8, #image9, #image10, #image11, #image12").val("");
			    //jQuery("#image, #image1, #image2, #image3, #image4, #image5, #image6, #image7, #image8").focus();
			    return false;
			}
		    }
		});
		return false;
	    }
	});

	$("#image1, #image2, #image3, #image4, #image5, #image6, #image7, #image8, #image9, #image10, #image11, #image12").change(function(){
	    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
	    success: function() {
	    },
	    error: function() {
	    $.jAlert({
	    'title': 'Thông báo',
		    'content': 'Định dạng ảnh phải là <b>.jpg, .png, .gif, .jpeg</b>',
		    'theme': 'default',
		    'btns': {
		    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
		    e.preventDefault();
			    jQuery("#image1, #image2, #image3, #image4, #image5, #image6, #image7, #image8, #image9, #image10, #image11, #image12").val("");
			    //jQuery("#image1, #image2, #image3, #image4, #image5, #image6, #image7, #image8, #image9, #image10, #image11, #image12").focus();
			    return false;
		    }
		    }
	    });
		    return false;
	    }
	});*/
</script>
<?php $this->load->view('home/common/footer'); ?>
