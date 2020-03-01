<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
    <div class="row">          
        <div class="col-md-3 sidebar">
            <?php $this->load->view('group/common/menu'); ?>
        </div>   
        <div class="col-md-9 main"> 
	    <h4 class="page-header text-uppercase" style="margin-top:10px">Cập nhật banner tầng</h4>
            <div class="dashboard">
                <!-- ========================== Begin Content ============================ -->
                    <div class="group-news">
                                        
                        <!-- Begin Show error if have -->
                        <?php if ($this->session->flashdata('ErrorMessage')) { ?>
                            <div class="message success">
                                <div class="alert alert-danger">
                                    <?php echo $this->session->flashdata('ErrorMessage'); ?>
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                </div>
                            </div>
                        <?php } ?>
			<?php $slide = json_decode($grTrade->grt_banner_floor); ?>
                        <!-- End Show error if have -->                
                        <form name="frmInputGrtSlide" id="frmInputGrtSlide" method="POST" enctype="multipart/form-data">                            
			    <?php if($shopid > 0) { ?>				
				<?php for($i=0;$i<15;$i++){ ?>
					<p><strong>Banner tầng <?php echo $i+1 ?></strong><p>
					<div class="row">
					    <div class="col-xs-9">										    					
						<div class="form-group">  
						    <input class="form-control" type="file"  name="image_<?php echo $i ?>">
						</div>
						<div class="form-group">  
						    <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-link" aria-hidden="true"></i></span>
							<input class="form-control" type="url" name="url_<?php echo $i?>" value="<?php echo $slide[$i]->url ?>" placeholder="Liên kết"> 
						    </div>					
						</div>
						<div class="form-group">  
						    <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
							<input class="form-control" type="text" name="title_<?php echo $i?>" value="<?php echo $slide[$i]->title ?>" placeholder="Tiêu đề"> 
						    </div>					
						</div>
					    </div>
					    <div class="col-xs-3">
						<div class="form-group">
						    <?php if($slide[$i]->image != "") { ?>
						    <img class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER.'media/group/banners/'.$grTrade->grt_dir_banner.'/'.$slide[$i]->image ?>" alt=""/>
						    <?php } else { ?>
						    <img class="img-responsive" src="/media/images/noimage.png" alt=""/>
						    <?php } ?>
						    <input type="hidden" name="image_<?php echo $i ?>_old" value="<?php echo $slide[$i]->image ?>">
						</div>
					    </div>	
					</div>
					<hr>				
				<?php } ?>				
                                    <div class="form-group">					
                                        <button role="button" type="submit" name="submit" class="btn btn-primary btn-lg">Cập nhật</button>
                                        <button role="button" type="reset"  name="reset"  class="btn btn-default btn-lg">Hủy bỏ</button>
					<input type="hidden" name="updatebannerfloor" value="1">
				    </div>
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                <!-- ========================== End Content ============================ -->
            </div>
        </div> 
    </div>
</div>
<?php $this->load->view('group/common/footer'); ?>
<script>
    function CheckSyntaxDomain(){
        var dmName = $('#txtdomain').val();
        if(dmName == ''){
            return false;
        } else {
            var pattern = new RegExp("^[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$"); 
            if (!pattern.test(dmName)) {
                alert("Tên miền của bạn không đúng cấu trúc. Vui lòng nhập lại");            
                return false;
            } 
            //return true; 
            document.forms["frmInputGrtDomain"].submit();
        }   
    }
    function ActionLink(link){
        window.location.href = link;
    }
</script>