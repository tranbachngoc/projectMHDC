<?php $this->load->view('home/common/account/header'); ?>
<?php $this->load->view('home/common/tinymce'); ?>
<?php $group_id = (int) $this->session->userdata('sessionGroup'); ?>
<link rel="stylesheet" type="text/css" href="/templates/engine1/style.css" />
<?php 
$listFont = array("Anton","Arsenal","Exo","Francois One","Muli","Nunito Sans","Open Sans Condensed","Oswald","Pattaya","Roboto Condensed","Saira Condensed","Saira Extra Condensed");
//$listFont = array("Alfa Slab One","Anton","Baloo","Bevan","Chonburi","Coiny","Lalezar","Lobster","Pattaya","Paytone One","Sigmar One","Yeseva One");
?>

<script language="javascript">
    function del_picture(id, key) {
        confirm(function (e, btn) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + 'home/account/del_image',
                cache: false,
                data: {id: id, key: key},
                dataType: 'text',
                success: function (data) {
                    console.log(data);
                    switch (data) {
                        case '0':
                            $('#image').css('display', 'block');                                      
                            $('#thumb_0').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
                            $('#thumb_0').remove(); 
			    break;
                        case '1':
                            $('#image1').css('display', 'block');
                            $('#thumb_1').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
                            $('#thumb_1').remove(); 
                            break;
                        case '2':
                            $('#image2').css('display', 'block');
                            $('#thumb_2').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
                            $('#thumb_2').remove(); 
			    break;
                        case '3':
                            $('#image3').css('display', 'block');
                            $('#thumb_3').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
			    $('#thumb_3').remove(); 
                            break;
                        case '4':
                            $('#image4').css('display', 'block');
                            $('#thumb_4').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
                            $('#thumb_4').remove(); 
                            break;
                        case '5':
                            $('#image5').css('display', 'block');
                            $('#thumb_5').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
                            $('#thumb_5').remove(); 
                            break;
                        case '6':
                            $('#image6').css('display', 'block');
                            $('#thumb_6').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
                            $('#thumb_6').remove(); 
			    break;
                        case '7':
                            $('#image7').css('display', 'block');
                            $('#thumb_7').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
			    $('#thumb_7').remove(); 
                            break;
                        case '8':
                            $('#image8').css('display', 'block');
                            $('#thumb_8').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
                            $('#thumb_8').remove(); 
                            break;
                        case '9':
                            $('#image9').css('display', 'block');                            
                            $('#thumb_9').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
                            $('#thumb_9').remove(); 
                            break;
                        case '10':
                            $('#image10').css('display', 'block');
                            $('#thumb_10').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
                            $('#thumb_10').remove(); 
                            break;
                        case '11':
                            $('#image11').css('display', 'block');
                            $('#thumb_11').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
                            $('#thumb_11').remove();
			    break;
                        case '12':
                            $('#image12').css('display', 'block');
                            $('#thumb_12').after('<img style="height:100px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview" />');
                            $('#thumb_12').remove();
			    break;
                        default :
                            alert('Xóa không thành công...');
                    }
                }
            });
        });
        return false;
    }
</script>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12 account_edit">	    
            <h4 class="page-header text-uppercase" style="margin-top:10px">CHỈNH SỬA TIN</h4>	

            <form name="frmEditNews" method="post" class="form-horizontal" accept-charset="utf-8" enctype="multipart/form-data">
                <?php if ($successEdit == 0) { ?>
                    <input type="hidden" name="image_dir" value="<?php echo $editnew->not_dir_image; ?>"/>
                    <?php /*
                      <div class="form-group">
                      <div class="col-lg-3"><font color="#FF0000"><b>*</b></font> Danh mục sản phẩm</div>
                      <div class="col-lg-9">
                      <select name="not_pro_cat_id" id="not_pro_cat_id" class="form-control">
                      <option value="">Chọn danh mục tin tức</option>
                      <?php foreach ($productCategoryRoot as $k => $category) { ?>
                      <option <?php echo $category->cat_id == $editnew->not_pro_cat_id ? 'selected' : '' ?>
                      value="<?php echo $category->cat_id ?>"><?php echo $category->cat_name ?></option>
                      <?php } ?>
                      </select>
                      </div>
                      <div class="clearfix"></div>
                      </div> */ ?>

                    <div class="form-group khungu">
                        <div class="col-lg-3"><font color="#FF0000"><b>&nbsp;</b></font> Chuyên mục</div>
                        <div class="col-lg-9">
    <!--    			<input type="text" name="not_pro_cat_name" id="title_content" value="<?php echo $category1->cat_name ?>" class="form-control" readonly/>
                            <input type="hidden" name="not_pro_cat_id" id="title_content" value="<?php echo $category1->cat_id ?>"/>-->
                            <select id="cat_pro_0" name="category0" class="form-control form_control_cat_select">
                                <option value=""> -- Chọn chuyên mục tin tức --</option>
                                <?php
                                if (isset($catlevel0) && count($catlevel0) > 0) {
                                    foreach ($catlevel0 as $item) {
                                        ?>
                                        <option value="<?php echo $item->cat_id; ?>" <?php echo ($editnew->not_pro_cat_id == $item->cat_id) ? 'selected="selected"' : ''; ?>>
                                            <?php echo $item->cat_name; ?><?php echo ($item->child_count > 0) ? '>' : ''; ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group <?php echo form_error('title_content') != '' ? 'has-error' : ''; ?>">
                        <div class="col-lg-3"><font color="#FF0000"><b>*</b></font> Tiêu đề bài viết:</div>
                        <div class="col-lg-9">
                            <input type="text" name="title_content" id="title_content"
                                   value="<?php echo $editnew->not_title; ?>" maxlength="130" class="form-control"/>

                        </div>
                        <div class="clearfix"></div>
                    </div>                

                    <?php $filename = DOMAIN_CLOUDSERVER . 'media/images/content/' . $editnew->not_dir_image . '/thumbnail_1_' . $editnew->not_image; ?>
                    <div class="form-group">
                        <div class="col-lg-3"><font color="#FF0000"><b>&nbsp;</b></font> Hình đại diện</div>
                        <div class="col-lg-9">
                            <input type="file" style="display: <?php
                            if ($editnew->not_image) {
                                echo "none";
                            } else {
                                echo "block";
                            }
                            ?>" name="image" id="image" class="inputimage_formpost" />    			
                                   <?php if ($editnew->not_image) { ?>
                                <div id="thumb_0" class="img_slide">
                                    <input type="hidden" id="image_news" name="image_news" value="<?php echo $editnew->not_image; ?>" />
                                    <img src="<?php echo $filename; ?>"  style="height:100px;" />
                                    <i title="Xóa hình này" onclick="del_picture(<?php echo $editnew->not_id; ?>, 0);" class="fa fa-times"></i>
                                </div>
                            <?php } else { ?> 
                                <img 
                                    style="height:100px; margin-top: 15px" 
                                    class="img-responsive img-thumbnail" 
                                    src="/images/noimage.jpg"
                                    alt="image preview"
                                    />
                                <?php } ?>

                        </div>
                    </div>               
                    <div class="form-group <?php echo form_error('description') != '' ? 'has-error' : ''; ?>">
                        <div class="col-lg-3"><font color="#FF0000"><b>*</b></font> Mô tả SEO</div>
                        <div class="col-lg-9">
                            <textarea name="description" class="form-control" maxlength="180"><?php echo $editnew->not_description; ?></textarea>
                            <span class="small"><i class="fa fa-question-circle" aria-hidden="true"></i> Nhập tối đa 180 kí tự</span>
                            <?php echo form_error('description'); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group <?php echo form_error('keywords') != '' ? 'has-error' : ''; ?>">
                        <div class="col-lg-3"><font color="#FF0000"><b>*</b></font> Từ khóa bài viết</div>
                        <div class="col-lg-9">
                            <input type="text" name="keywords" id="title_content" value="<?php echo $editnew->not_keywords; ?>" maxlength="130" class="form-control" />
                            <span class="small"><i class="fa fa-question-circle" aria-hidden="true"></i> Mỗi từ khóa cách nhau bởi dấu phẩy(,)</span>
                            <?php echo form_error('keywords'); ?>                            
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group <?php echo form_error('txtContent') != '' ? 'has-error' : ''; ?>">
                        <div class="col-lg-3"><font color="#FF0000"><b>*</b></font> Nội dung bài viết:</div>
                        <div class="col-lg-9">					
                            <textarea name="txtContent" id="txtContent" class="editor form-control" rows="10"><?php echo $editnew->not_detail ? $editnew->not_detail : ''; ?></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>
		    <div class="form-group">
                        <div class="col-lg-3">Hiển thị nội dung</div>
                        <div class="col-lg-9">
			   <?php $contentdisplay = array("Mặc định", "Ảnh nền"); ?>    			    
    			    <div style="margin-bottom:15px">
    				<select id="not_display" name="not_display" class="form-control">
					<?php foreach ($contentdisplay as $k => $val) { ?>
					    <option value="<?php echo $k ?>" <?php echo $editnew->not_display == $k ? "selected" : "" ?>>
						<?php echo $val ?>
					    </option>
					<?php } ?>   
    				</select>
    			    </div>  
			</div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                    
                    <div class="form-group row">
                        <div class="col-lg-3">Nội dung bổ sung</div>
                        <div class="col-lg-9">
                            <?php if($editnew->not_additional){
                                $adddd = json_decode($editnew->not_additional);                                
                                foreach ($adddd as $key => $value) { ?>
                                    <div style="padding: 20px 20px 20px; background:#f9f9f9; border:1px solid #eee; margin-bottom: 20px; position:relative">
                                        <?php if($value->icon != '') { ?>
										<img class="inputicon<?php echo $key+1 ?>" src="/images/icons/<?php echo $value->icon ?>" />
										<?php } ?>
                                        <div class="row">
                                            <div class="col-xs-6">                                                
                                                Chọn icon:
                                                <div class="input-group"> 
                                                    <input type="text" maxlength="100" name="icon[]" class="inputicon<?php echo $key+1 ?> form-control" value="<?php echo $value->icon ?>">             
                                                    <span class="inserticon input-group-addon" data-toggle="modal" data-target="#myIconModal" data-class=".inputicon<?php echo $key+1 ?>">Chọn</span>
                                                </div>
                                                
                                            </div>
                                            <div class="col-xs-6">
                                                Chọn vị trí:
                                                <select tyle="select" name="posi[]" class="form-control">
                                                    <option value="left" <?php echo ($value->posi == 'left') ? 'selected' : '' ?> >Icon bên trái</option>
                                                    <option value="center" <?php echo ($value->posi == 'center') ? 'selected' : '' ?> >Icon chính giữa</option>
                                                    <option value="right" <?php echo ($value->posi == 'right') ? 'selected' : '' ?> >Icon bên phải</option>
                                                </select>
                                            </div>
                                        </div>
                                        Tiêu đề:
                                        <input type="text" maxlength="100" name="title[]" class="form-control" value="<?php echo $value->title ?>">
                                        Mô tả:
                                        <input type="text" maxlength="100" name="desc[]" class="form-control" value="<?php echo $value->desc ?>">
                                        <a style="position: absolute; top: 0; right: 0px;" class="delbox btn btn-sm btn-danger">X</a>
                                    </div> 
								<?php } ?>
                            <?php } ?>
        
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
                    <div class="form-group khungu">
                        <div class="col-lg-3">Tải lên video của bạn</div>
                        <div class="col-lg-6">
                                <input type="file" name="video" id="videonews" class="form-control" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv">
                                                    
                        </div>                        
                        <div class="col-lg-3">                            
                            <?php if($editnew->not_video_url1) { ?>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <video controls class="embed-responsive-item">
                                        <source src="<?php echo  DOMAIN_CLOUDSERVER . 'video/'. $editnew->not_video_url1 ?>" type="video/mp4">
                                        Trình duyệt của bạn không hỗ trợ video này.
                                    </video>
                                    <input type="hidden" id="video_old" name="video_old" value="<?php echo $editnew->not_video_url1 ?>" />
                                    <a style="position: absolute; top: 0; right: 0px;" class="btn btn-sm btn-danger btn-delete deletevideo">X</a>
                                </div> 
                                <script>
                                jQuery(function($){     
                                    $("#videonews").change(function () {
                                        var fileInput = document.getElementById('videonews');
                                        var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                                        $("video").attr("src", fileUrl); 
                                        $(".btn-delete").removeClass('deletevideo').addClass('deletevideo2');
                                    });
                                    $('body').on("click",".deletevideo2", function(e){
                                        $("video").attr("src", "<?php echo  DOMAIN_CLOUDSERVER . 'video/'. $editnew->not_video_url1 ?>"); 
                                        $(".btn-delete").removeClass('deletevideo2').addClass('deletevideo'); 
                                        $("#videonews").val("");
                                    });
                                    $('body').on('click','.deletevideo', function(e){
                                        console.log('delete video');
                                        e.preventDefault();
                                        $.ajax({
                                            type:'post',
                                            url:'/home/account/delete_video',
                                            cache:false,
                                            data:{ not_id: '<?php echo $editnew->not_id ?>',not_video_url1: '<?php echo $editnew->not_video_url1 ?>' },
                                            dataType:'text',
                                            success:function(data){
                                                if(data == '1'){			
                                                    $.jAlert({ 
                                                        'title': 'Thông báo', 
                                                        'content': 'Xoá video thành công.', 
                                                        'theme': 'blue', 
                                                        'btns': {'text': 'Ok', 'theme': 'blue'}
                                                    });
                                                    $("video").attr("src","");
                                                    $("#video_old").remove();
                                                    $(".embed-responsive").attr("style","visibility: hidden");
                                                } else {
                                                    $.jAlert({ 
                                                         'title': 'Thông báo', 
                                                         'content': 'Có lỗi xảy ra, vui lòng thử lại!', 
                                                         'theme': 'red', 
                                                         'btns': {'text': 'Ok', 'theme': 'red'}
                                                    });
                                                }
                                            }
                                        });
                                    });
                                });                                                       
                                </script>
                            <?php } else { ?>
                                <div class="embed-responsive embed-responsive-16by9" style="visibility: hidden">
                                    <video controls class="embed-responsive-item">
                                        <source src="" type="video/mp4">
                                        Trình duyệt của bạn không hỗ trợ video này.
                                    </video>                                
                                    <a style="position: absolute; top: 0; right: 0px;" class="deletevideo2 btn btn-sm btn-danger">X</a>
                                </div>                                
                                <script>
                                    jQuery(function($){                                   
                                        $("#videonews").change(function () {
                                            var fileInput = document.getElementById('videonews');
                                            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                                            $("video").attr("src", fileUrl);                                           
                                            $(".embed-responsive").removeAttr("style");                                         
                                        });                    
                                        $('body').on("click",".deletevideo2", function(e){
                                            $("video").removeAttr("src");
                                            $(".embed-responsive").attr("style","visibility: hidden");  
                                            $("#videonews").val("");
                                        });
                                    });
                                </script>
                            <?php } ?>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">Link Youtube</div>
                        <div class="col-lg-6">
                            <input type="text" name="youtube" id="youtube" value="<?php echo $editnew->not_video_url; ?>" class="form-control" />
                        </div> 
                        <?php if($editnew->not_video_url) { $youtubesrc = 'https://www.youtube.com/embed/'.get_youtube_id_from_url($editnew->not_video_url).'?rel=0'; } else { $youtubesrc = '';} ?>
                        <div class="col-lg-3">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="<?php echo $youtubesrc ?>" frameborder="0" allowfullscreen=""></iframe>
                            </div>
                            <script>
                            jQuery(function($){
                                $('#youtube').on('change', function(e){
                                    var url = $(this).val();
                                    var videoid = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
                                    if(videoid != null) {                                        
                                        $('iframe.embed-responsive-item').attr('src','https://www.youtube.com/embed/'+videoid[1]+'?rel=0')
                                    } else { 
                                        console.log("The youtube url is not valid.");
                                    }
                                });
                            });
                            </script>
                        </div>                        
                    </div>
					
                    <?php
                    $list12 = array(
                        ['image' => $editnew->not_image1, 'title' => $editnew->imgtitle1, 'link' => $editnew->imglink1, 'detail' => $editnew->linkdetail1, 'caption' => str_replace("\r\n", '', $editnew->imgcaption1), 'style' => json_decode($editnew->imgstyle1)],
                        ['image' => $editnew->not_image2, 'title' => $editnew->imgtitle2, 'link' => $editnew->imglink2, 'detail' => $editnew->linkdetail2, 'caption' => str_replace("\r\n", '', $editnew->imgcaption2), 'style' => json_decode($editnew->imgstyle2)],
                        ['image' => $editnew->not_image3, 'title' => $editnew->imgtitle3, 'link' => $editnew->imglink3, 'detail' => $editnew->linkdetail3, 'caption' => str_replace("\r\n", '', $editnew->imgcaption3), 'style' => json_decode($editnew->imgstyle3)],
                        ['image' => $editnew->not_image4, 'title' => $editnew->imgtitle4, 'link' => $editnew->imglink4, 'detail' => $editnew->linkdetail4, 'caption' => str_replace("\r\n", '', $editnew->imgcaption4), 'style' => json_decode($editnew->imgstyle4)],
                        ['image' => $editnew->not_image5, 'title' => $editnew->imgtitle5, 'link' => $editnew->imglink5, 'detail' => $editnew->linkdetail5, 'caption' => str_replace("\r\n", '', $editnew->imgcaption5), 'style' => json_decode($editnew->imgstyle5)],
                        ['image' => $editnew->not_image6, 'title' => $editnew->imgtitle6, 'link' => $editnew->imglink6, 'detail' => $editnew->linkdetail6, 'caption' => str_replace("\r\n", '', $editnew->imgcaption6), 'style' => json_decode($editnew->imgstyle6)],
                        ['image' => $editnew->not_image7, 'title' => $editnew->imgtitle7, 'link' => $editnew->imglink7, 'detail' => $editnew->linkdetail7, 'caption' => str_replace("\r\n", '', $editnew->imgcaption7), 'style' => json_decode($editnew->imgstyle7)],
                        ['image' => $editnew->not_image8, 'title' => $editnew->imgtitle8, 'link' => $editnew->imglink8, 'detail' => $editnew->linkdetail8, 'caption' => str_replace("\r\n", '', $editnew->imgcaption8), 'style' => json_decode($editnew->imgstyle8)],
                        ['image' => $editnew->not_image9, 'title' => $editnew->imgtitle9, 'link' => $editnew->imglink9, 'detail' => $editnew->linkdetail9, 'caption' => str_replace("\r\n", '', $editnew->imgcaption9), 'style' => json_decode($editnew->imgstyle9)],
                        ['image' => $editnew->not_image10, 'title' => $editnew->imgtitle10, 'link' => $editnew->imglink10, 'detail' => $editnew->linkdetail10, 'caption' => str_replace("\r\n", '', $editnew->imgcaption10), 'style' => json_decode($editnew->imgstyle10)],
                        ['image' => $editnew->not_image11, 'title' => $editnew->imgtitle11, 'link' => $editnew->imglink11, 'detail' => $editnew->linkdetail11, 'caption' => str_replace("\r\n", '', $editnew->imgcaption11), 'style' => json_decode($editnew->imgstyle11)],
                        ['image' => $editnew->not_image12, 'title' => $editnew->imgtitle12, 'link' => $editnew->imglink12, 'detail' => $editnew->linkdetail12, 'caption' => str_replace("\r\n", '', $editnew->imgcaption12), 'style' => json_decode($editnew->imgstyle12)]
                    );                    
                    ?>                   
                    <?php foreach ($list12 as $key => $value) { ?>
                    <?php if($value['image']){ $in = 'in'; $expanded == 'true'; } else{$in = ''; $expanded == 'false';} ?>
                    <button class="btn btn-default btn-block" type="button" data-toggle="collapse" data-target="#postcollapse<?php echo $key+1 ?>" aria-expanded="<?php echo  $expanded ?>" aria-controls="postcollapse<?php echo $key+1?>">
                        Sửa hình ảnh và liên kết <?php echo $key + 1 ?>
                    </button>
                    <br>
                    <div class="collapse <?php echo $in ?>" id="postcollapse<?php echo $key + 1 ?>" style="margin: 0 0 25px">
                         
                                        
                                        <div class="row">
                                            <div class="col-md-5 col-sm-12 col-xs-12">
                                                Hình ảnh <?php echo $key + 1 ?>:
                                                <div style="margin-bottom:15px">
                                                    <input type="file" 
                                                           style="display: <?php
                                                           if ($value['image']) {
                                                               echo "none";
                                                           } else {
                                                               echo "block";
                                                           }
                                                           ?>" 
                                                           name="image<?php echo $key + 1 ?>" id="image<?php echo $key + 1 ?>" class="inputimage_slide_formpost" />

                                                    <?php if (strlen($value['image']) > 10) { ?>
                                                        <div id="thumb_<?php echo $key + 1 ?>"  class="img_slide">
                                                            <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $editnew->not_dir_image . '/' . $value['image']; ?>"  style="height:110px;"  class="img-responsive img-thumbnail"/>
                                                            <input type="hidden" id="image_old<?php echo $key + 1 ?>" name="image_old<?php echo $key + 1 ?>" value="<?php echo $value['image']; ?>" />
                                                            <i title="Xóa hình này" onclick="del_picture(<?php echo $editnew->not_id; ?>, <?php echo $key + 1 ?>);" class="fa fa-times"></i>
                                                        </div>
                                                    <?php } else { ?>	    				    
                                                        <img style="height:100px; margin-top: 15px" 
                                                             class="img-responsive img-thumbnail" 
                                                             src="/images/noimage.jpg"
                                                             alt="image preview"/>
                                                         <?php } ?>
                                                </div>
                                                
                                            
                                                <div style="margin-bottom:15px">
                                                    Nhập tiêu đề cho hình ảnh:
                                                    <input type="text" id="imgtitle<?php echo $key + 1 ?>" name="imgtitle<?php echo $key + 1 ?>" class="form-control" value="<?php echo $value['title']; ?>" maxlength="100"/>
                                                </div>
                                                <div style="margin-bottom:15px">
                                                    Mô tả cho hình ảnh:
                                                    <textarea name="imgcaption<?php echo $key + 1 ?>" id="imgcaption<?php echo $key + 1 ?>" class="form-control" placeholder="Nhập mô tá hình ảnh" rows="10" maxlength="500"/><?php echo $value['caption']; ?></textarea>
                                                </div> 
                                            </div>
                                            <div class="col-md-5 col-sm-12 col-xs-12">
                                                <div style="margin-bottom:15px">
                                                    Chọn liên kết đến sản phẩm:
                                                    <select name="imglink<?php echo $key + 1 ?>" id="imglink<?php echo $key + 1 ?>" class="form-control">
                                                        <option value="">--Chọn liên kết--</option>
                                                        <?php
                                                        $insp = $incp = 0;
                                                        foreach ($products as $k => $pro) {
                                                            if ($pro->pro_type == 0) {
                                                                $insp++;
                                                                if ($insp == 1) {
                                                                    echo '<option value="" disabled> --- SẢN PHẨM --- </option>';
                                                                }
                                                            } else {
                                                                $incp++;
                                                                if ($incp == 1) {
                                                                    echo '<option value="" disabled></option><option value="" disabled> ---COUPON--- </option>';
                                                                }
                                                            }
                                                            ?>
                                                            <option value="<?php echo $pro->pro_id ?>" <?php if ($pro->pro_id == $value['link']) echo 'selected' ?>>
                                                                <?php echo $pro->pro_name ?>
                                                            </option>
                                                        <?php } ?>                        
                                                    </select>
                                                </div>

                                                <div style="margin-bottom:15px">
                                                    Nhập liên kết xem thêm:
                                                    <input type="text" id="linkdetail<?php echo $key + 1 ?>" name="linkdetail<?php echo $key + 1 ?>" class="linkdetail form-control" value="<?php echo $value['detail'] ?>" placeholder=""/>
                                                </div>

                                                <?php
                                                $listeffects = array("fadeIn","fadeInLeft","fadeInRight","fadeInUp","fadeInDown","slideInUp","slideInDown","slideInLeft","slideInRight","zoomIn");
						?>                                        
                                                <div style="margin-bottom:15px">
                                                    Hiệu ứng hình ảnh:
                                                    <select id="imgeffect<?php echo $key + 1 ?>" name="imgeffect<?php echo $key + 1 ?>" class="form-control input--dropdown js--animations">
                                                        <?php foreach ($listeffects as $e) { ?>
                                                            <option value="<?php echo $e ?>" <?php echo $value['style']->imgeffect == $e ? "selected" : "" ?>><?php echo $e ?></option>
                                                        <?php } ?> 
                                                    </select>
                                                </div>
                                                <div style="margin-bottom:15px">
                                                    Hiệu ứng văn bản:
                                                    <select id="texteffect<?php echo $key + 1 ?>" name="texteffect<?php echo $key + 1 ?>" class="form-control input--dropdown js--animations">
                                                        <?php foreach ($listeffects as $e) { ?>
                                                            <option value="<?php echo $e ?>" <?php echo $value['style']->texteffect == $e ? "selected" : "" ?>><?php echo $e ?></option>
                                                        <?php } ?>   
                                                    </select>
                                                </div>


                                                <?php $display = array("Mặc định",  "Ảnh nền", "Chọn màu nền, màu chữ"); ?>
                                                Chọn kiểu hiển thị
                                                <div style="margin-bottom:15px">
                                                    <select id="display<?php echo $key + 1 ?>" name="display<?php echo $key + 1 ?>" class="form-control">
                                                        <?php foreach ($display as $k => $val) { ?>
                                                            <option data-image="box-<?php echo $k+1 ?>.jpg" value="<?php echo $k ?>" <?php echo $value['style']->display == $k ? "selected" : "" ?>>
                                                                <?php echo $val ?>
                                                            </option>
                                                        <?php } ?>   
                                                    </select>
                                                </div>					
                                                <script>
                                                $('#display<?php echo $key + 1 ?>').on('change', function() {                                                    
                                                    $('.img-preview-<?php echo $key + 1 ?>').attr('src','/images/box-'+ this.value +'.jpg');                                                    
                                                    if(this.value == 2){
                                                        $('.bgcl_<?php echo $key + 1 ?>').slideDown();                                                        
                                                    } else {
                                                        $('.bgcl_<?php echo $key + 1 ?>').slideUp();
                                                        
                                                    }
                                                });						    
                                                </script>

                                                <div class="row bgcl_<?php echo $key + 1 ?>" style="<?php echo ($value['style']->display == 2) ? 'display: block' : 'display: none' ?>">
                                                    <div class="col-xs-6">
                                                        <div style="margin-bottom:15px">
                                                            Chọn màu nền:<br>
                                                            <input type="color" id="background<?php echo $key + 1 ?>" name="background<?php echo $key + 1 ?>"  value="<?php echo $value['style']->background; ?>" style="height:34px" />
                                                        </div>
                                                    </div>					    
                                                    <div class="col-xs-6">
                                                        <div style="margin-bottom:15px">
                                                            Chọn màu chữ:<br>
                                                            <input type="color" id="color<?php echo $key + 1 ?>" name="color<?php echo $key + 1 ?>" value="<?php echo $value['style']->color; ?>" style="height:34px"/>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-2 col-sm-12 col-xs-12">
                                                <img class="img-preview-<?php echo $key + 1 ?> img-responsive" src="/images/box-<?php echo $value['style']->display ?>.jpg"/>
                                            </div>  
                                            
                                        </div>
                                        
                                        <?php
                                        $caption2 = $value['style']->caption2;
                                        foreach ($caption2 as $i => $c) {
                                            ?>
                                        <div class="well" style="position:relative">
                                            <div class="row">
                                                <div class="col-sm-4" style="margin-bottom:15px">
                                                    Chọn icon: 
                                                    <div class="input-group">
                                                        <input type="text" class="inputicon<?php echo $key + 1 . $i ?> form-control" name="icon<?php echo $key + 1 ?>[]" value="<?php echo $c->icon ?>"> 
                                                        <span class="inserticon input-group-addon" data-toggle="modal" data-target="#myIconModal" data-class=".inputicon<?php echo $key + 1 . $i ?>">Chọn</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4" style="margin-bottom:15px">
                                                    Chọn vị trí: 
                                                    <select tyle="select" name="posi<?php echo $key + 1 ?>[]" class="form-control">
                                                        <option value="left" <?php echo ($c->posi == 'left') ? 'selected' : '' ?>>Icon bên trái</option> 
                                                        <option value="center" <?php echo ($c->posi == 'center') ? 'selected' : '' ?>>Icon chính giữa</option> 
                                                        <option value="right" <?php echo ($c->posi == 'right') ? 'selected' : '' ?>>Icon bên phải</option> 
                                                    </select>
                                                </div>
                                                <div class="col-sm-4" style="margin-bottom:15px">
                                                    Hiệu ứng:
                                                    <?php $effects = array("fadeInLeft", "fadeInRight", "fadeInUp", "fadeInDown"); ?>
                                                    <select tyle="select" name="effect<?php echo $key + 1 ?>[]" class="form-control">
                                                        <?php foreach ($effects as $e) { ?>
                                                            <option value="<?php echo $e ?>" <?php echo ($c->effect == $e) ? 'selected' : '' ?> ><?php echo $e ?></option> 
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-sm-12" style="margin-bottom:15px">
                                                    Tiêu đề: 
                                                    <input type="text" maxlength="50" name="title<?php echo $key + 1 ?>[]" class="form-control" value="<?php echo $c->title ?>">		
                                                </div>
                                                <div class="col-sm-12" style="margin-bottom:0px">   
                                                    Mô tả: 
                                                    <textarea name="desc<?php echo $key + 1 ?>[]" maxlength="100" class="form-control" rows="2"><?php echo $c->desc ?></textarea>			
                                                </div> 
                                            </div>    
                                            <a style="position: absolute; top: 0; right: 0;" class="delbox btn btn-sm btn-danger">X</a>
                                        </div>    
                                        <?php } // endforeach  ?>
                                        <div style="margin:15px 0">
                                            <a class="addbox<?php echo $key + 1 ?> btn btn-azibai">+ Mô tả nổi bật</a>
                                            <a class="btn btn-azibai" role="button" data-toggle="collapse" href="#collapse<?php echo $key + 1 ?>Example" aria-expanded="false" aria-controls="collapse<?php echo $key + 1 ?>Example">
                                                + Chữ trên ảnh
                                            </a>
                                        </div>                                        
                                        <script>                        
                                            jQuery(function($){ 
                                                var i = <?php echo count($caption2) ?>;
                                                $('body').on("click",'.delbox', function(e){ $(this).parent().remove(); });
                                                $('.addbox<?php echo $key + 1 ?>').on("click",function(e){        
                                                        $(this).before('<div class="well" style="position:relative"><div class="row"><div class="col-sm-4 col-xs-12" style="margin-bottom:15px"> Chọn icon:<div class="input-group"> <input type="text" class="inputicon<?php echo $key + 1 ?>'+i+' form-control" name="icon<?php echo $key + 1 ?>[]"> <span class="inserticon input-group-addon" data-toggle="modal" data-target="#myIconModal" data-class=".inputicon<?php echo $key + 1 ?>'+i+'">Chọn</span></div></div><div class="col-sm-4 col-xs-12" style="margin-bottom:15px"> Chọn vị trí: <select tyle="select" name="posi<?php echo $key + 1 ?>[]" class="form-control"><option value="left">Icon bên trái</option><option value="center">Icon chính giữa</option><option value="right">Icon bên phải</option> </select></div><div class="col-sm-4 col-xs-12" style="margin-bottom:15px"> Hiệu ứng: <select tyle="select" name="effect<?php echo $key + 1 ?>[]" class="form-control"><option value="fadeInLeft">fadeInLeft</option><option value="fadeInRight">fadeInRight</option><option value="fadeInUp">fadeInUp</option><option value="fadeInDown">fadeInDown</option> </select></div><div class="col-sm-12 col-xs-12" style="margin-bottom:15px"> Tiêu đề: <input type="text" maxlength="50" name="title<?php echo $key + 1 ?>[]" class="form-control"></div><div class="col-sm-12 col-xs-12" style="margin-bottom:0px"> Mô tả:<textarea name="desc<?php echo $key + 1 ?>[]" maxlength="100" class="form-control" rows="2"></textarea></div></div> <a style="position: absolute; top: 0; right: 0;" class="delbox btn btn-sm btn-danger">X</a></div>'); 
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
                                        <div class="collapse well" id="collapse<?php echo $key + 1 ?>Example">                                        
                                            <div id="textonpicture<?php echo $key + 1 ?>" style="position:relative"> 
                                                <div class="row">
                                                    <div class="col-sm-5 col-xs-12">
                                                        <div style="margin-bottom:15px">
                                                            Nhập chữ trên ảnh 1:
                                                            <input type="text" id="text_1_image_<?php echo $key + 1 ?>" name="text_1_image<?php echo $key + 1 ?>" class="form-control" value="<?php echo $value['style']->text_1_image; ?>" maxlength="60"/>
                                                        </div>
                                                        <div style="margin-bottom:15px">
                                                            Nhập chữ trên ảnh 2:
                                                            <input type="text" id="text_2_image_<?php echo $key + 1 ?>" name="text_2_image<?php echo $key + 1 ?>" class="form-control" value="<?php echo $value['style']->text_2_image; ?>" maxlength="60"/>
                                                        </div>
                                                        <div style="margin-bottom:15px">
                                                            Nhập chữ trên ảnh 3:
                                                            <input type="text" id="text_3_image_<?php echo $key + 1 ?>" name="text_3_image<?php echo $key + 1 ?>" class="form-control" value="<?php echo $value['style']->text_3_image; ?>" maxlength="60"/>
                                                        </div>
                                                        <div style="margin-bottom:15px">
                                                            Font chữ:
                                                            <select class="changecolor<?php echo $key + 1 ?> form-control" id="text_font<?php echo $key + 1 ?>" name="text_font<?php echo $key + 1 ?>">
                                                                <?php foreach ($listFont as $f => $font) { ?> 
                                                                    <option value="<?php echo $font ?>" <?php echo ($value['style']->text_font == $font) ? 'selected' : ''; ?> ><?php echo $font ?></option>   
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-xs-6" style="margin-bottom:15px">
                                                                Màu nền:<br>
                                                                <input class="changecolor<?php echo $key + 1 ?>" type="color" id="bg_color<?php echo $key + 1 ?>" name="bg_color<?php echo $key + 1 ?>" value="<?php echo $value['style']->bg_color; ?>" style="height:34px"/>
                                                            </div>
                                                            <div class="col-xs-6" style="margin-bottom:15px">
                                                                Màu chữ:<br>
                                                                <input class="changecolor<?php echo $key + 1 ?>" type="color" id="text_color<?php echo $key + 1 ?>" name="text_color<?php echo $key + 1 ?>" value="<?php echo $value['style']->text_color; ?>" style="height:34px"/>
                                                            </div>
                                                        </div>

                                                                <div style="margin-bottom:15px">  
                                                                    <br>
                                                                    <input class="changecolor<?php echo $key + 1 ?>" type="range" id="ra_color<?php echo $key + 1 ?>" name="ra_color<?php echo $key + 1 ?>" min="0" max="1" step="0.1" value="<?php echo $value['style']->ra_color; ?>" style="height:34px"/>                                            
                                                                    <input type="hidden" id="rgba_color<?php echo $key + 1 ?>" name="rgba_color<?php echo $key + 1 ?>" value="<?php echo $value['style']->rgba_color; ?>"> 
                                                                </div>                                                


                                                                <div style="margin-bottom:15px">
                                                                    Vị trí hiển thị:<br>
                                                                    <?php $position = array("top", "middle", "bottom"); ?>
                                                                    <select class="changecolor<?php echo $key + 1 ?> form-control" id="text_position<?php echo $key + 1 ?>" name="text_position<?php echo $key + 1 ?>">
                                                                        <?php foreach ($position as $pos) { ?> 
                                                                            <option value="<?php echo $pos ?>" <?php echo ($value['style']->text_position == $pos) ? 'selected' : ''; ?> ><?php echo $pos ?></option>   
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <script>
                                                                    jQuery(function($) {
                                                                        var color = $("#bg_color<?php echo $key + 1 ?>").val();
                                                                        var opacity = $("#ra_color<?php echo $key + 1 ?>").val();
                                                                        var textcolor = $('#text_color<?php echo $key + 1 ?>').val();
                                                                        var rgbaCol = $('#rgba_color<?php echo $key + 1 ?>').val();
                                                                        var vtcal = $('#text_position<?php echo $key + 1 ?>').val();
                                                                        var texteffect = $('#text_effect_in<?php echo $key + 1 ?>').val();
                                                                        $(".changecolor<?php echo $key + 1 ?>").change(function() {
                                                                            color = $("#bg_color<?php echo $key + 1 ?>").val();
                                                                            opacity = $("#ra_color<?php echo $key + 1 ?>").val();
                                                                            textcolor = $('#text_color<?php echo $key + 1 ?>').val();
                                                                            vtcal = $('#text_position<?php echo $key + 1 ?>').val();																
                                                                            rgbaCol = 'rgba(' + parseInt(color.slice(-6, -4), 16) + ',' + parseInt(color.slice(-4, -2), 16) + ',' + parseInt(color.slice(-2), 16) + ',' + opacity + ')';
                                                                            $('#rgba_color<?php echo $key + 1 ?>').val(rgbaCol);
                                                                            $('#divcolor<?php echo $key + 1 ?>').css({"background-color": rgbaCol, "color": textcolor});
                                                                            $('#position<?php echo $key + 1 ?>').css({"vertical-align": vtcal});																
                                                                        });
                                                                      });
                                                                </script>												   

                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <div style="margin-bottom:15px">
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
                                                                            <select class="changecolor<?php echo $key + 1 ?> form-control" id="text_effect_in<?php echo $key + 1 ?>" name="text_effect_in<?php echo $key + 1 ?>">
                                                                                <?php foreach ($effin as $e) { ?> 
                                                                                    <option value="<?php echo $e ?>" <?php echo ($value['style']->text_effect_in == $e) ? 'selected' : ''; ?> ><?php echo $e ?></option>   
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <div style="margin-bottom:15px">
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
                                                                            <select class="changecolor<?php echo $key + 1 ?> form-control" id="text_effect_out<?php echo $key + 1 ?>" name="text_effect_out<?php echo $key + 1 ?>">
                                                                                <?php foreach ($effout as $e) { ?> 
                                                                                    <option value="<?php echo $e ?>" <?php echo ($value['style']->text_effect_out == $e) ? 'selected' : ''; ?> ><?php echo $e ?></option>   
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        <div class="col-sm-3 col-xs-12">
                                                            <div style="position: relative; height: 190px; background:url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $editnew->not_dir_image . '/' . $value['image']; ?>) no-repeat center / cover"> 
                                                                <div style="position: absolute; top:0; right:0; bottom:0; left:0; overflow: hidden;"> 
                                                                    <div style="display:table; height:100%">
                                                                        <div id="position<?php echo $key + 1 ?>" style="display:table-cell;vertical-align:<?php echo $value['style']->text_position; ?>">
                                                                            <div>
                                                                                <div id="divcolor<?php echo $key + 1 ?>" style=" padding:10px 15px; background-color:<?php echo $value['style']->rgba_color; ?>; color: <?php echo $value['style']->text_color; ?>; ">
                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.  
                                                                                </div>
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                </div>
                                            </div> 
                                        </div>
                                   
                    </div>     
                    <?php } // endforeach ?>
                    <hr/>
                    <h3>Trình diễn <span class="small">(Bạn phải upload it nhất 3 hình ảnh để tạo slideshow)</span>
                        <span class="small pull-right">                            
                            <label class="radio-inline">
                                <input type="radio" name="slideshow" id="nocheck" value="0" <?php echo $editnew->not_slideshow == 0 ? "checked" : "" ?>> Tắt
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="slideshow" id="ischeck" value="1" <?php echo $editnew->not_slideshow == 1 ? "checked" : "" ?>> Bật 
                            </label>
                        </span>
                    </h3>
                    <script>
                    jQuery(function($){
                        $('#ischeck').click(function(){$('.slideshow_wrapper').slideDown();});
                        $('#nocheck').click(function(){$('.slideshow_wrapper').slideUp();});
                    });
                    </script>
                    <div class="row slideshow_wrapper <?php if ($editnew->not_slideshow == 0) { echo ' hidden'; } ?>">
			<?php
                                 $effect_array = array(	
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
                        <div class="col-lg-3">	Chọn hiệu ứng:                                
                                <select id="ef" name="effect" class="form-control">
                                    <option value="flip,fade,shift,page,book,stack,basic,kenburns,fly,slices|DepthPage,Fade,FlipHorizontal,FlipPage,RotateDown,RotateUp,Stack,Tablet,ZoomIn,ZoomOut,ZoomOutSlide"> -- Chọn một hiệu ứng -- </option>
                                    <?php foreach ($effect_array as $evalue) { ?>
                                    <option value="<?php echo $evalue ?>" <?php echo $editnew->not_effect == $evalue ? "selected" : "" ?>><?php echo explode("|", $evalue)[1] ?></option>
                                    <?php } ?>
                                </select>
                            <input type="hidden" name="eff_select" id="eff_select" value="<?php echo $editnew->not_effect; ?>" />
                        </div>
                        <div class="col-lg-5">Chọn nhạc nền:
                                 <?php
                                 $this->load->helper('directory');
                                 $musics = directory_map('./media/musics');
                                 ?>
                            <select id="ms" name="music" class="form-control">
                                <option value="">Chọn nhạc</option>
                                <?php foreach ($musics as $value) { ?>
                                    <option value="<?php echo $value ?>" <?php echo $editnew->not_music == $value ? "selected" : "" ?>><?php echo $value ?></option>
                                <?php } ?>
                            </select>														   
                        </div>
                        <div class="col-lg-2">
                            <!-- Button trigger modal -->
                            <br/>
                            <button type="button" class="btn btn-azibai btn-block show-modal" data-toggle="modal" data-target="#slideModal_1">
                                Xem trình diễn
                            </button>                              
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
                                        <audio src="/media/musics/<?php echo $editnew->not_music; ?>"></audio>
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
                    <?php
                    if ($editnew->not_ad) {
                        $ad = json_decode($editnew->not_ad);       
                    }
                    ?>                    
                    <h3>                                                    
                        Quảng cáo
                        <span class="small pull-right">
                            <label class="radio-inline">
                                <input id="ad_status1" type="radio" name="ad_status" value="0" <?php echo $ad->ad_status == 0 ? 'checked':'' ?>> Tắt 
                            </label>
                            <label class="radio-inline">
                                <input id="ad_status2" type="radio" name="ad_status" value="1" <?php echo $ad->ad_status == 1 ? 'checked':'' ?>> Bật
                            </label> 
                        <span>                       
                    </h3> 
                    <script>
                    jQuery(function($){
                        $('#ad_status2').click(function(){$('.show_inputad').slideDown();});
                        $('#ad_status1').click(function(){$('.show_inputad').slideUp();});
                    });
                    </script>
                    <div class="row show_inputad"  style="<?php if ($ad->ad_status == 0) { echo 'display:  none'; } ?>">
                          <div class="col-lg-3">                              
                              Chọn hình thay thế:
                              <input type="file" name="ad_image" id="ad_image" class="form-control">
                            <?php if ($ad->ad_image != "") { ?>
                                <img style="margin: 15px 0 0" class="img-responsive img-thumbnail" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $editnew->not_dir_image . '/' . $ad->ad_image; ?>" alt="image preview">
                                <input type="hidden" name="ad_image_old" id="ad_image_old" value="<?php echo $ad->ad_image ?>">
                            <?php } else { ?>
                                <img style="margin: 15px 0 0" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview">
                            <?php } ?>
                          </div>  
                        <div class="col-lg-9">
                            <div class="">                                    
                            Liên kết quảng cáo: 
                            <input type="text" name="ad_link" id="ad_link" class="form-control" placeholder="Liên kết quảng cáo" value="<?php echo $ad->ad_link ?>">		
                            </div>
                            <br>
                           
                                <?php for ($i = 0; $i < 3; $i++) { ?>
                                    Nội dung <?php echo $i + 1 ?>:
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="text" name="ad_title<?php echo $i + 1 ?>" id="ad_title<?php echo $i + 1 ?>" class="form-control" placeholder="Tiêu đề <?php echo $i + 1 ?>" value="<?php echo $ad->ad_content[$i]->title ?>" maxlength="30">		
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" name="ad_desc<?php echo $i + 1 ?>" id="ad_desc<?php echo $i + 1 ?>" class="form-control" placeholder="Mô tả <?php echo $i + 1 ?>" value="<?php echo $ad->ad_content[$i]->desc ?>" maxlength="120">
                                        </div>
                                    </div>
                                    <br> 
                                <?php } ?>
                            
                            <div class="">
                            Countdown kết thúc ngày:
                            <input type="date" name="ad_time" id="ad_time" class="form-control" value="<?php echo $ad->ad_time ?>">	
                            </div>
                            <br>
                            <div class="">
                                Hiển thị:
                                <div class="radio">
                                    <label>
                                      <input type="radio" name="ad_display" id="ad_display1" value="1" <?php echo $ad->ad_display == 1 ? 'checked' : '' ?>>
                                      Đồng hồ số
                                    </label>
                                </div>                            
                                <div class="radio">
                                    <label>
                                      <input type="radio" name="ad_display" id="ad_display2" value="2" <?php echo $ad->ad_display == 2 ? 'checked' : '' ?>>
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
                                <input id="statistic1" type="radio" name="not_statistic" value="0" <?php echo $editnew->not_statistic == '0' ? 'checked="checked"' :  ''; ?>> Tắt
                            </label>
                            <label class="radio-inline">
                                <input id="statistic2" type="radio" name="not_statistic" value="1" <?php echo $editnew->not_statistic == '1' ? 'checked="checked"' :  ''; ?>> Bật
                            </label>
                        </span>
                    </h3>                    
                    <script>
                    jQuery(function($){
                        $('#statistic2').click(function(){$('.show_inputstatistic').slideDown();});
                        $('#statistic1').click(function(){$('.show_inputstatistic').slideUp();});
                    });
                    </script>
                    <div class="show_inputstatistic" style="<?php if ($editnew->not_statistic == 0) { echo 'display:  none'; } ?>">
                        <div class="row">                
                                <div class="col-lg-3">Chọn hình ảnh</div>
                                <div class="col-lg-9">
                                    <input type="file" name="img_statistic" id="img_statistic" class="form-control">
                                    <?php if ($editnew->img_statistic != "") { ?>
                                        <img style="height:116px; margin: 15px 0 0" class="img-responsive img-thumbnail" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $editnew->not_dir_image . '/' . $editnew->img_statistic; ?>" alt="image preview">
                                    <?php } else { ?>
                                        <img style="height:116px; margin: 15px 0 0" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview">
                                    <?php } ?>
                                </div>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <?php 
                                if ($editnew->statistic != '') {
                                   $statistic = json_decode($editnew->statistic, true);
                                }
                                for ($i=1; $i < 5; $i++) {
                            ?>
                            <div class="col-md-6 col-sm-12 col-xs-12">  
                                <div style="padding: 20px 20px 20px; background:#f9f9f9; border:1px solid #eee; margin-bottom: 20px; ">
                                    <div style="margin-bottom:15px">
                                        Thống Kê <?php echo $i; ?>
                                        <input type="number" name="statistic[<?php echo $i; ?>][num]" class="form-control" value="<?php echo !empty($statistic[$i]['num']) ? $statistic[$i]['num'] : ''; ?>" placeholder="Nhập thống kê" maxlength="4">
                                    </div>

                                    <div style="margin-bottom:15px">
                                        Tiêu Đề <?php echo $i; ?>:
                                        <input type="text" name="statistic[<?php echo $i; ?>][title]" class="form-control" value="<?php echo !empty($statistic[$i]['title']) ? $statistic[$i]['title'] : ''; ?>" placeholder="Nhập tiêu đề thống kê" maxlength="30">
                                    </div>

                                    <div style="margin-bottom:15px">
                                        Mô tả <?php echo $i; ?>:
                                        <textarea name="statistic[<?php echo $i; ?>][description]" class="form-control" placeholder="Nhập mô tả thống kê" rows="3" maxlength="120"><?php echo !empty($statistic[$i]['description']) ? $statistic[$i]['description'] : ''; ?></textarea>
                                    </div>                                
                                </div>
                            </div>
                            <?php } ?>
                        </div>                        
                    </div><!--  end thống kê -->
                    <hr/>
                    <?php $not_customer = json_decode($editnew->not_customer); ?>
                    <h3>Khách hàng
			<span class="small pull-right">                            
			    <label class="radio-inline">
				<input id="cus_status_0" type="radio" name="cus_status" value="0" <?php echo ($not_customer->cus_status == 0)?'checked':''; ?>> Tắt
			    </label>
			    <label class="radio-inline">
				<input id="cus_status_1" type="radio" name="cus_status" value="1" <?php echo ($not_customer->cus_status == 1)?'checked':''; ?>> Bật
			    </label>
			</span>
		    </h3> 
		    <script>
			jQuery(function ($) { 
			    $('#cus_status_0').click(function () { $('.show_customer').slideUp(); }); 
			    $('#cus_status_1').click(function () { $('.show_customer').slideDown(); });
			});
		    </script>
                    
                    <div class="show_customer" style="display:<?php echo ($not_customer->cus_status == 0)?'none':'block'?>;">                         
                        <div class="row">
                            <div class="col-sm-8">                               
                                <label for="cus_title" class="control-label">Tiêu đề: </label><br>                               
                                <input type="text" name="cus_title" class="form-control" value="<?php echo $not_customer->cus_title ?>">
                            </div>
                            <div class="col-sm-2">
                                <label for="cus_color" class="control-label">Màu chữ: </label><br>                                    
                                <input type="color" name="cus_color"  value="<?php echo $not_customer->cus_color ?>"  style="height: 34px;">
                            </div>
                            <div class="col-sm-2"> 
                                <label for="cus_background" class="control-label">Màu nền: </label><br>                                    
                                <input type="color" name="cus_background"  value="<?php echo $not_customer->cus_background ?>"  style="height: 34px;">
                            </div>
                        </div>
                        <br>                                   
			<?php foreach ($not_customer->cus_list as $k => $customer) { ?>
			<div class="well form-horizontal" style="position:relative"> 
			    <br>
			    <div class="row">                            
				<div class="col-sm-6">
				    <div class="form-group">
					<label for="cus_avatar" class="col-sm-3 control-label">Hình ảnh: </label>
					<div class="col-sm-9">
					    <input type="file" name="cus_avatar[]" class="form-control">
					    <?php if(strlen($customer->cus_avatar)>10) { ?>
						<img style="height:116px; margin-top: 15px;" class="img-responsive img-thumbnail" src="<?php echo DOMAIN_CLOUDSERVER.'media/images/content/'.$editnew->not_dir_image.'/'.$customer->cus_avatar ?>" alt="image preview">                            
						<input type="hidden" name="cus_avatar_old[]" class="form-control" value="<?php echo $customer->cus_avatar ?>">
					    <?php } else { ?>
						<img style="height:116px; margin-top: 15px;" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview">                            
					    <?php } ?>
					</div>
				    </div>
				    <div class="form-group">
					<label for="cus_link" class="col-sm-3 control-label">Link ảnh: </label>
					<div class="col-sm-9">
					  <input type="url" name="cus_link[]" class="form-control" value="<?php echo $customer->cus_link ?>">
					</div>
				    </div>
				    <div class="form-group">
					<label for="cus_facebook" class="col-sm-3 control-label">Facebook: </label>
					<div class="col-sm-9">
					  <input type="url" name="cus_facebook[]" class="form-control" value="<?php echo $customer->cus_facebook ?>">
					</div>
				    </div>
				    <div class="form-group">
					<label for="cus_twitter" class="col-sm-3 control-label">Twitter: </label>
					<div class="col-sm-9">
					  <input type="url" name="cus_twitter[]" class="form-control" value="<?php echo $customer->cus_twitter ?>">
					</div>
				    </div>
				    <div class="form-group">
					<label for="cus_google" class="col-sm-3 control-label">Google+: </label>
					<div class="col-sm-9">
					  <input type="url" name="cus_google[]" class="form-control" value="<?php echo $customer->cus_google ?>">
					</div>
				    </div>
				</div>
				<div class="col-sm-6">
				    <div class="form-group">
					<label for="cus_text1" class="col-sm-3 control-label">Text 1: </label>
					<div class="col-sm-9">
					    <input type="text" name="cus_text1[]" class="form-control" value="<?php echo $customer->cus_text1 ?>" maxlength="30">
					</div>
				    </div>
				    <div class="form-group">
					<label for="cus_text2" class="col-sm-3 control-label">Text 2: </label>
					<div class="col-sm-9">
					  <input type="text" name="cus_text2[]" class="form-control" value="<?php echo $customer->cus_text2 ?>" maxlength="30">
					</div>
				    </div>
				    <div class="form-group">
					<label for="cus_text3" class="col-sm-3 control-label">Text 3: </label>
					<div class="col-sm-9">
					  <textarea name="cus_text3[]" class="form-control" rows="13" ><?php echo $customer->cus_text3 ?></textarea>
					</div>
				    </div>

				</div>                        
			    </div>
			    <a style="position: absolute; top: 0; right: 0;" class="delboxcustomer btn btn-sm btn-danger">X</a>
			</div>
			<?php } ?>                    
			<div class="addboxcustomer"><a class="btn btn-azibai">+ Thêm ý kiến khách hàng</a></div>
			<script>                        
			    jQuery(function($){
				$('.addboxcustomer').on("click",function(e){  
				    var html = '<div class="well" style="position:relative"><br><div class="row"><div class="col-sm-6 form-horizontal"><div class="form-group"><label for="cus_avatar" class="col-sm-3 control-label">Hình ảnh: </label><div class="col-sm-9"><input type="file" name="cus_avatar[]" class="form-control" value=""><img style="height:116px; margin-top: 15px;" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview"> </div></div><div class="form-group"> <label for="cus_link" class="col-sm-3 control-label">Link ảnh: </label> <div class="col-sm-9"> <input type="url" name="cus_link[]" class="form-control" value=""> </div> </div><div class="form-group"><label for="cus_facebook" class="col-sm-3 control-label">Facebook: </label><div class="col-sm-9"> <input type="url" name="cus_facebook[]" class="form-control" value=""></div></div><div class="form-group"><label for="cus_twitter" class="col-sm-3 control-label">Twitter: </label><div class="col-sm-9"> <input type="url" name="cus_twitter[]" class="form-control" value=""></div></div><div class="form-group"><label for="cus_google" class="col-sm-3 control-label">Google+: </label><div class="col-sm-9"> <input type="url" name="cus_google[]" class="form-control" value=""></div></div></div><div class="col-sm-6 form-horizontal"><div class="form-group"><label for="cus_text1" class="col-sm-3 control-label">Text 1: </label><div class="col-sm-9"> <input type="text" name="cus_text1[]" class="form-control" value="" maxlength="30"></div></div><div class="form-group"><label for="cus_text2" class="col-sm-3 control-label">Text 2: </label><div class="col-sm-9"> <input type="text" name="cus_text2[]" class="form-control" value="" maxlength="30"></div></div><div class="form-group"><label for="cus_text3" class="col-sm-3 control-label">Text 3: </label><div class="col-sm-9"> <textarea name="cus_text3[]" class="form-control" rows="10" ></textarea></div></div></div></div><a style="position: absolute; top: 0; right: 0;" class="delboxcustomer btn btn-sm btn-danger">X</a></div>';
				    $(this).before(html);                                 
				});
				$('body').on("click",'.delboxcustomer', function(e){ 
				    $.ajax({
					type:"post",
					url:"/home/account/delete_avatar_customer",
					cache:false,
					data:{cus_avartar:'<?php echo $customer->cus_avartar ?>', not_dir_image:'<?php echo $editnew->not_dir_image ?>'},
					dataType:'text',
					success:function(data){
					    if(data == '1'){			
						$.jAlert({ 
						    'title': 'Thông báo', 
						    'content': 'Xoá khách hàng thành công.', 
						    'theme': 'blue', 
						    'btns': {'text': 'Ok', 'theme': 'blue'}
						});
					    } else {
						$.jAlert({ 
						    'title': 'Thông báo', 
						    'content': 'Có lỗi xảy ra, vui lòng thử lại!', 
						    'theme': 'red', 
						    'btns': {'text': 'Ok', 'theme': 'red'}
						});
					    }
					}
				    });
				    $(this).parent().remove();                                
				});
			    });
			</script>
                     </div>
		    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3 col-xs-12">&nbsp;</div>
                        <div class="col-sm-3 col-xs-12">
			    <input type="checkbox" name="not_news_hot" id="not_news_hot" value="1" <?php
                            if ($editnew->not_news_hot == '1') {
                                echo 'checked="checked"';
                            }
                            ?> /> Tin tức HOT </div>
                        <div class="col-sm-3 col-xs-12"><input type="checkbox" name="not_news_sale" id="not_news_sale" value="1" <?php
                            if ($editnew->not_news_sale == '1') {
                                echo 'checked="checked"';
                            }
                            ?> /> Tin khuyến mãi </div>
                    </div>			

                    <div class="form-group">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-sm-offset-3">
                            <button class="btn btn-azibai btn-block btnupdate">Cập nhật</button>
                        </div>  
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <button onclick="ActionLink('<?php echo base_url(); ?>account/news')" class="btn btn-default  btn-block" >
                                Hủy bỏ
                            </button>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                <?php } else { ?>
                    <div class="form-group">
                        <p class="text-center"><a href="<?php echo base_url(); ?>account/news">Click vào đây để tiếp tục</a></p>
                        <p class="text-center"> Bạn đã cập nhật tin thành công !</p>
                    </div>
                <?php } ?>
            </form>
			
        </div>
    </div>
</div>
</div>
<script type="text/javascript" src="/templates/engine1/wowslider.js"></script>
<script type="text/javascript" src="/templates/engine1/script.js"></script>
<?php $eff = explode('|', $editnew->not_effect); ?>
<script>
    
    $('#nocheck').change(function () {
        $('.slideshow_wrapper').addClass('hidden');
    });
    $('#ischeck').change(function () {
        $('.slideshow_wrapper').removeClass('hidden');
    });
    
    $("#wowslider_container_1").wowSlider({effect: "<?php echo $eff[0] ?>", prev: "", next: "", duration: 20 * 100, delay: 10 * 100, width: 800, height: 450, autoPlay: false, autoPlayVideo: true, playPause: true, stopOnHover: true, loop: true, bullets: 1, caption: true, captionEffect: "fade", controls: true, controlsThumb: false, responsive: 2, fullScreen: true, gestures: 2, onBeforeStep: 0, images: 0});
    $("#ms").change(function () {
        $("audio").attr('src', '/media/musics/' + $("#ms option:selected").text());
    });
    var wow = $("#wowslider_container_2");
    var bkpCont = $(document.createElement("div")).append(wow.clone()).html();
    $('#ef').change(function () {
	$('button.show-modal').attr("data-target", "#slideModal_2");
	var eff = $("#ef option:selected").val().split('|');
	$("audio").attr('src', '/media/musics/' + $("#ms option:selected").text());
	wow = $(bkpCont).replaceAll(wow);
	wow.wowSlider({effect: eff[0], prev: "", next: "", duration: 20 * 100, delay: 10 * 100, width: 800, height: 450, autoPlay: false, autoPlayVideo: true, playPause: true, stopOnHover: true, loop: true, bullets: 1, caption: true, captionEffect: "fade", controls: true, controlsThumb: false, responsive: 2, fullScreen: true, gestures: 2, onBeforeStep: 0, images: 0});
    });
    
    $('.modal').click(function () {
        $('.ws_pause').trigger('click')
    });

    
    $('body').on("click",'.btnupdate', function(e){ 
        console.log('vao day choi');
        CheckInput_newsEdit();
    });
</script>
<script>
    /*$("#image1, #image2, #image3, #image4, #image5, #image6, #image7, #image8, #image9, #image10, #image11, #image12").change(function () {
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
            success: function() {},
            error: function() {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Định dạng ảnh phải là <b>.jpg, .png, .gif, .jpeg</b>',
                    'theme': 'default',
                    'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                            jQuery("#image1, #image2, #image3, #image4, #image5, #image6, #image7, #image8, #image9, #image10, #image11, #image12").val("");
                            //jQuery("#image, #image1, #image2, #image3, #image4, #image5, #image6, #image7, #image8").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
    });*/
</script>

<script>
    $(function(){
        $('body').on('change', '[type="file"]', showPreviewImage_click);        
    })
    function showPreviewImage_click(e) {
    var $input = $(this);
            var inputFiles = this.files;
            if (inputFiles == undefined || inputFiles.length == 0) return;
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
</script>
<?php $this->load->view('home/common/footer'); ?>
