<?php $this->load->view('home/common/header'); ?>

<div id="main" class="container-fluid">
  <div class="row">
    <?php $this->load->view('home/common/left'); ?>
    <?php $this->load->view('home/common/tinymce'); ?>
    <SCRIPT TYPE="text/javascript">
<!--
function submitenter(myfield,e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   CheckInput_ContactAccount();
   return false;
   }
else
   return true;
}
jQuery(document).ready(function(){
	jQuery('#con_user_recieve').change(function(){
		if(jQuery(this).val() !=0)jQuery('#position_contact').attr('disabled','disabled');
		else jQuery('#position_contact').removeAttr('disabled');
	});
	jQuery('#choose_receiver_0').click(function(){
		jQuery('#position_contact').attr('disabled','disabled');
		jQuery('#con_user_recieve').attr('disabled','disabled');
	});
	jQuery('#choose_receiver_1').click(function(){
		jQuery('#position_contact').removeAttr('disabled');
		jQuery('#con_user_recieve').removeAttr('disabled');
	})		
});
//-->
</SCRIPT> 
    
    <!--BEGIN: RIGHT-->
    
    <div class="col-lg-9 col-md-9 col-sm-8 created-task">
      <?php
$id_task = $this->uri->segment(10);
$getday = strtolower($this->uri->segment(8));
$getVarMonth = strtolower($this->uri->segment(6));
$idstaff = strtolower($this->uri->segment(4));
if($successSendContactAccount == false){
    $getVar = strtolower($this->uri->segment(7));
    $getVarEdit = strtolower($this->uri->segment(9));
    if(isset($id_task) && !empty($id_task)){
        $title = 'Chỉnh sửa công việc cho: ';
    }
    else{
        $title = 'Tạo công việc cho: ';
    }
        $d = date('d', $taskedit->created_date);
        $m = date('m', $taskedit->created_date);
        $y = date('Y', $taskedit->created_date);
    ?>
      <form name="frmTaskAccount" method="post" enctype="multipart/form-data">
        <div class="row ">
          <h2>
            <?php
           $d = $this->uri->segment(8);
           $m = $this->uri->segment(6);
           $y = date('Y');
           $dayadd  = time();
           $currentDate = mktime(0, 0, 0,$m, $d, $y);
            ?>
            <input type="hidden" id="dayadd" name="dayadd" value="<?php echo $dayadd;?>">
            <input type="hidden" id="currentDate" name="currentDate" value="<?php if(isset($currentDate)){echo $currentDate;}?>">
            <?php echo $title.$staff.' ('.$staffuser.'), Ngày: '.$d.'/'.$m.'/'.$y;?> </div>
        </h2>
        <div class="row vientong">
          <div class="col-lg-3 tieudecv">Tiêu đề </div>
          <div class="col-lg-8">
            <input type="text" name="nametask" id="nametask" value="<?php if(isset($taskedit->name)){echo $taskedit->name;} ?>" maxlength="80" class="input_form" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('nametask',1);" onblur="ChangeStyle('nametask',2);"/>
            <?php echo form_error('nametask'); ?></div>
        </div>
        <div class="row vientong">
          <div class="col-lg-3 tieudecv">Chi tiết</div>
          <div class="col-lg-8">
            <textarea name="txtContent" id="txtContent" rows="2">
                    <?php echo $taskedit->detail;?>
                </textarea>
          </div>
        </div>
        <!-- <div class="row vientong"></div> -->
        <div class="row vientong">
          <div class="col-lg-3 tieudecv">Ghi chú</div>
          <div class="col-lg-8">
            <textarea name="txtContentnote" id="txtContentnote" >
                <?php echo $taskedit->note; ?>
            </textarea>
            <input type="hidden" value="<?php echo $taskedit->status;?>" name="status" id="status">
          </div>
        </div>
        <!-- <div class="row vientong borderbottom"></div> -->
        <div class="row vientong">

            <?php 
            $dir_img1=$taskedit->images1;
            $dir_img2=$taskedit->images2;
            $dir_img3=$taskedit->images3;

            $date_img1=$taskedit->date_img;
            $date_img2=$taskedit->date_img;
            $date_img3=$taskedit->date_img;

            if ($dir_img1=='none.gif') {
              $date_img1='default';
            }
            $img_1_1='<input type="file" name="images1" id="images1">';
            $img_1_3='<img src="'.base_url().'media/images/staff/'.$date_img1.'/'.$taskedit->images1.'" style="min-width:60px; min-height:60px; max-height:80px; max-width:80px; margin-top:5px; clear:both;" align="left">';
            #images 2
            if ($dir_img2=='none.gif') {
              $date_img2='default';
            }
            $img_2_1='<input type="file" name="images2" id="images2">';
            $img_2_3='<img src="'.base_url().'media/images/staff/'.$date_img2.'/'.$taskedit->images2.'" style="min-width:60px; min-height:60px; max-height:80px; max-width:80px; margin-top:5px; clear:both;" align="left">';
            #images 3
            if ($dir_img3=='none.gif') {
              $date_img3='default';
            }
            $img_3_1='<input type="file" name="images3" id="images3">';
            $img_3_3='<img src="'.base_url().'media/images/staff/'.$date_img3.'/'.$taskedit->images3.'" style="min-width:60px; min-height:60px; max-height:80px; max-width:80px; margin-top:5px; clear:both;" align="left">';
            #file 1
            $file_1_1='<input type="file" name="file1" id="file1">';
            $file_1_3='<a href="'.base_url().'media/images/staff/'.$taskedit->date_img.'/'.$taskedit->file1.'" >'.$taskedit->file1.'<a>';
            /*if ($taskedit->file1=="null") {
              $file_1_3=$file_1_1;
            }*/
            #file 2
            $file_2_1='<input type="file" name="file2" id="file2">';
            $file_2_3='<a href="'.base_url().'media/images/staff/'.$taskedit->date_img.'/'.$taskedit->file2.'" >'.$taskedit->file2.'<a>';
            #file 3
            $file_3_1='<input type="file" name="file3" id="file3">';
            $file_3_3='<a href="'.base_url().'media/images/staff/'.$taskedit->date_img.'/'.$taskedit->file3.'" >'.$taskedit->file3.'<a>';
            ?>
            <script>
            function myFunction() {
                document.getElementById("img_1_1").innerHTML = '<?php echo $img_1_1 ?>';
                document.getElementById("img_1_2").innerHTML = '<?php echo $img_1_2 ?>';
                document.getElementById("img_1_3").innerHTML = '';
                document.getElementById("img_1_4").innerHTML = '';
                document.getElementById("oldimages1").value = '';
            }
            function myFunction2() {
                document.getElementById("img_2_1").innerHTML = '<?php echo $img_2_1 ?>';
                document.getElementById("img_2_2").innerHTML = '<?php echo $img_2_2 ?>';
                document.getElementById("img_2_3").innerHTML = '';
                document.getElementById("img_2_4").innerHTML = '';
                document.getElementById("oldimages2").value = '';
            }
            function myFunction3() {
                document.getElementById("img_3_1").innerHTML = '<?php echo $img_3_1 ?>';
                document.getElementById("img_3_2").innerHTML = '<?php echo $img_3_2 ?>';
                document.getElementById("img_3_3").innerHTML = '';
                document.getElementById("img_3_4").innerHTML = '';
                document.getElementById("oldimages3").value = '';
            }            
            function myFile1() {
                document.getElementById("file_1_1").innerHTML = '<?php echo $file_1_1 ?>';
                document.getElementById("file_1_2").innerHTML = '<?php echo $file_1_2 ?>';
                document.getElementById("file_1_3").innerHTML = '';
                document.getElementById("file_1_4").innerHTML = '';
                document.getElementById("oldfile1").value = '';
            }         
            function myFile2() {
                document.getElementById("file_2_1").innerHTML = '<?php echo $file_2_1 ?>';
                document.getElementById("file_2_2").innerHTML = '<?php echo $file_2_2 ?>';
                document.getElementById("file_2_3").innerHTML = '';
                document.getElementById("file_2_4").innerHTML = '';
                document.getElementById("oldfile2").value = '';
            }        
            function myFile3() {
                document.getElementById("file_3_1").innerHTML = '<?php echo $file_3_1 ?>';
                document.getElementById("file_3_2").innerHTML = '<?php echo $file_3_2 ?>';
                document.getElementById("file_3_3").innerHTML = '';
                document.getElementById("file_3_4").innerHTML = '';
                document.getElementById("oldfile3").value = '';
            }
            </script>

        <div class="col-lg-3 tieudecv">Hình 1 </div>
          <div class="col-lg-8  tieudecv">
            <div id="img_1_1"></div>
            <div id="img_1_2"></div>
            <div id="img_1_3"><?php 
            if ($taskedit->images1) {
               echo $img_1_3;
            }
            ?></div>
            <div id="img_1_4">
            <?php
            $img= base_url().'templates/home/images/error_post.gif';
             ?>
            <!-- img src="<?php echo base_url()?>templates/home/images/error_post.gif" >
             -->
           <?php if ($taskedit->images1) {
            ?>
            <input type="image" src="<?php echo $img ?>" onclick="myFunction()"> 
            <?php
           } 
           else
           {
            echo $img_1_1;
          }
           ?>
            </div>
            <input type="hidden" name="oldimages1" id="oldimages1" value="<?php if(isset($taskedit->images1)){echo $taskedit->images1;} ?>">
           
          </div>
        </div>
        <div class="row vientong">
          <div class="col-lg-3 tieudecv">Hình 2</div>
          <div class="col-lg-8 tieudecv">
            <div id="img_2_1"></div>
            <div id="img_2_2"></div>
            <div id="img_2_3"><?php 
            if ($taskedit->images2) {
               echo $img_2_3;
            }
            ?></div>
            <div id="img_2_4">
            <?php if ($taskedit->images2) {
            ?>
            <input type="image" src="<?php echo $img ?>" onclick="myFunction2()"> 
            <?php
           } 
           else
           {
            echo $img_2_1;
          }
           ?>
            </div>
            <input type="hidden" name="oldimages2" id="oldimages2" value="<?php if(isset($taskedit->images2)){echo $taskedit->images2;} ?>">
            <?php /*<input type="file" name="images2" id="images2" class="inputimage_formpost">
            <input type="hidden" name="oldimages2" id="oldimages2" value="<?php if(isset($taskedit->images2)){echo $taskedit->images2;} ?>">*/?>
          </div>
        </div>
        <div class="row vientong">
          <div class="col-lg-3 tieudecv">Hình 3</div>
          <div class="col-lg-8 tieudecv">
           <div id="img_3_1"></div>
            <div id="img_3_2"></div>
            <div id="img_3_3"><?php 
            if ($taskedit->images3) {
               echo $img_3_3;
            }
            ?></div>
            <div id="img_3_4"><?php if ($taskedit->images3) {
            ?>
            <input type="image" src="<?php echo $img ?>" onclick="myFunction3()"> 
            <?php
           } 
           else
           {
            echo $img_3_1;
          }
           ?></div>
            <?php /*<input type="file" name="images3" id="images3" class="inputimage_formpost">*/?>
            <input type="hidden" name="oldimages3" id="oldimages3" value="<?php if(isset($taskedit->images3)){echo $taskedit->images3;} ?>">
          </div>
        </div>
        <div class="row vientong">
          <div class="col-lg-3 tieudecv">File 1 (Word)</div>
          <div class="col-lg-8 tieudecv">
           <div id="file_1_1"></div>
            <div id="file_1_2"></div>
            <div id="file_1_3"><?php 
            if ($taskedit->file1) {
               echo $file_1_3;
            }
            ?></div>
            <div id="file_1_4"><?php if ($taskedit->file1) {
            ?>
            <input type="image" src="<?php echo $img ?>" onclick="myFile1()"> 
            <?php
           } 
           else
           {
            echo $file_1_1;
          }
           ?></div>
            <input type="hidden" name="oldfile1" id="oldfile1" value="<?php if(isset($taskedit->file1)){echo $taskedit->file1;} ?>">
          </div>
        </div>
        <div class="row vientong">
          <div class="col-lg-3 tieudecv">File 2 (Pdf)</div>
          <div class="col-lg-8 tieudecv">
          <div id="file_2_1"></div>
            <div id="file_2_2"></div>
            <div id="file_2_3"><?php 
            if ($taskedit->file2) {
               echo $file_2_3;
            }
            ?></div>
            <div id="file_2_4"><?php if ($taskedit->file2) {
            ?>
            <input type="image" src="<?php echo $img ?>" onclick="myFile2()"> 
            <?php
           } 
           else
           {
            echo $file_2_1;
          }
           ?></div>
            <?php /*<input type="file" name="file2" id="file2" class="inputimage_formpost">*/?>
            <input type="hidden" name="oldfile2" id="oldfile2" value="<?php if(isset($taskedit->file2)){echo $taskedit->file2;} ?>">
          </div>
        </div>
        <div class="row vientong">
          <div class="col-lg-3 tieudecv">File 3 (Excel)</div>
          <div class="col-lg-8 tieudecv">
          <div id="file_3_1"></div>
            <div id="file_3_2"></div>
            <div id="file_3_3"><?php 
            if ($taskedit->file3) {
               echo $file_3_3;
            }
            ?></div>
            <div id="file_3_4"><?php if ($taskedit->file3) {
            ?>
            <input type="image" src="<?php echo $img ?>" onclick="myFile3()"> 
            <?php
           } 
           else
           {
            echo $file_3_1;
          }
           ?></div>
            <?php /*<input type="file" name="file3" id="file3" class="inputimage_formpost">*/?>
            <input type="hidden" name="oldfile3" id="oldfile3" value="<?php if(isset($taskedit->file3)){echo $taskedit->file3;} ?>">
          </div>
        </div>
        <?php if(!empty($taskedit)){ $cls = 'last-row';}?>
        <?php if(empty($taskedit)) {?>
        <div class="row vientong <?php echo $cls;?>"> 
          <!--<div class="col-lg-4"></div>-->
          <div class="col-lg-12 text-center borderbottom">
            <button id="test_button" type="button" onclick="CheckInput_TaskAccount();" name="submit_task"  class="btn btn-primary">Lưu lại</button>
          </div>
        </div>
        <?php } else{?>
        <div class="row ">
          <div class="col-lg-3 tieudecv">Trạng thái </div>
          <div class="col-lg-8 tieudecv">
            <?php if( $taskedit->status == 2) {?>
            <img src="<?php echo base_url(); ?>templates/home/images/public.png" border="0" alt="<?php echo $this->lang->line('replied_tip'); ?>" />
            <?php }elseif( $taskedit->status == 1){?>
            <i class="fa fa-refresh"></i>
            <?php }else{?>
            <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" border="0" alt="<?php echo $this->lang->line('replied_tip'); ?>" />
            <?php }?>
          </div>
        </div>
        <?php if(!empty($taskedit)){ $cls = 'last-row';}?>
        <div class="row db_hidden <?php echo $cls;?>">
          <div class="col-lg-3 tieudecv">Thao tác</div>
          <div class="col-lg-8 tieudecv">
<!--          <input type="submit" onclick="CheckInput_TaskAccount()" value="Sửa">-->
          <!-- 
            <button type="button" class="btn btn btn-primary">Sửa</button> -->
            <button type="button" onclick="ActionLink('<?php echo $statusUrl; ?>/status/active')" name="submit_task"  class="btn btn-success">Đã hoàn thành</button>
            <button type="button" onclick="ActionLink('<?php echo $statusUrl; ?>/status/deactive')" name="submit_task"  class="btn btn-warning">Chưa hoàn thành</button>
          </div>
        </div>
        <br />

            <!-- Contenedor Principal -->
            <div class="comments-container hidden">
                <?php if ($comments && count($comments) > 0){ ?>
                <h1>Nhận xét</h1>
                <ul id="comments-list" class="comments-list mCustomScrollbar" data-mcs-theme="minimal-dark">
                    <?php foreach ($comments as $comment) {
                        if ((int)$this->session->userdata('sessionUser') == $comment->use_id) {
                            $clas = 'by-author';
                            $sent = 'fa-share';
                        }else{
                            $clas = '';
                            $sent = 'fa-reply';
                        }
                        $fileav = 'media/images/avatar/'.$comment->avatar;
                        ?>
                        <li>
                            <div class="comment-main-level">
                                <!-- Avatar -->
                                <div class="comment-avatar"><img src="<?php if (file_exists($fileav) && $comment->avatar != '') {echo base_url().$fileav;}else{ echo base_url().'images/icon/avatar-default.jpg'; }?>" alt=""></div>
                                <!-- Contenedor del Comentario -->
                                <div class="comment-box">
                                    <div class="comment-head">
                                        <h6 class="comment-name <?php echo $clas;?>"><a href="#"><?php echo $comment->use_fullname ?></a></h6>
                                        <span>ngày <?php echo date('d/m/Y', $comment->created_date)?></span>
                                        <i class="fa <?php echo $sent;?>"></i>
                                    </div>
                                    <div class="comment-content">
                                        <?php echo $comment->comment; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php }?>
                </ul>
                <?php }?>
                <hr>
                <h4>Trả lời</h4>
                <textarea name="txtContentComment" id="txtContentComment"></textarea>
                <p>
                    <button type="submit"  name="submit_task"
                            id="submit_task" class="btn btn-primary">Gửi đi
                    </button>
                </p>
            </div>

        <?php }?>
      </form>
      <?php }else{  ?>
      <div class="row">
        <div class="text-center">
            <p><?php echo $this->lang->line('success_contact_send');?> </p>
            <a href="<?php echo base_url(); ?>account/staffs/task/<?php echo $idstaff; ?>/month/<?php echo $getVarMonth; ?>/day/<?php echo $getday; ?>/edit/<?php echo $id_task; ?>">Click vào đây để tiếp tục</a>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>

<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
