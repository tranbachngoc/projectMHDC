<?php $this->load->view('group/common/header'); ?>
<style>
#autoSuggestionsList > li {
    background: none repeat scroll 0 0 #F3F3F3;
    border-bottom: 1px solid #E3E3E3;
    list-style: none outside none;
    padding: 3px 15px 3px 15px;
    text-align: left;
}

#autoSuggestionsList > li a { color: #800000; }

.auto_list {
    border: 1px solid #E3E3E3;
    border-radius: 5px 5px 5px 5px;
    position: absolute;
    z-index: 1;
}
.auto_list li { cursor:  pointer; }
</style>
<br>
<div id="main" class="container-fluid">
    <div class="row">          
        <div class="col-md-3 sidebar">
            <?php $this->load->view('group/common/menu'); ?>
        </div>   
        <div class="col-md-9 main">  
	    <h4 class="page-header text-uppercase" style="margin-top:10px">Mời thành viên mới</h4>
            <div class="dashboard">
                <!-- ========================== Begin Content ============================ -->
                <div class="group-news">
                   
                    <?php 
                    
                    if($notification) { ?>
                    <p class="bg-success" style="padding: 15px"><?php echo $notification ?></p>
                    <?php } ?>
                    <p class="text-center">Bạn có thể mời thành viên là gian hàng, thành viên là chi nhánh bằng cách chọn tùy chọn nhập và nhập thông tin vào ô dưới.</strong></p>
                    <form class="form-horizontal" name="frmInvitemember" id="frmInvitemember" 
                          method="post" enctype="multipart/form-data">
                        <div class="bg-warning"><?php echo $note ?></div>
                        <div class="form-group">
                            <label for="grt_invite_option" class="col-sm-3 control-label">Mời thành viên theo:</label>
                            <div class="col-sm-9">
                                <select name="grt_invite_option" class="form-control">                                    
                                    <option value="4">Link gian hàng</option>
                                    <option value="5">Tên gian hàng</option>                                    							 
                                    <option value="2">Số điện thoại</option>							 
                                    <option value="3">Email gian hàng</option>
                                    <option value="1">Tên đăng nhập</option>                                    
                                </select>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label for="grt_invite_value" class="col-sm-3 control-label">Nhập thông tin:</label>
                            <div class="col-sm-9">
                                <input type="text" name="grt_invite_value" class="form-control"  id="grt_invite_value"> 
                                <div id="suggestions">
                                    <ul id="autoSuggestionsList" class="nav"></ul>
                                </div>
                            </div>
                        </div>                                           

                        <div class="form-group">
                            <label for="grt_captcha" class="col-sm-3 control-label">Mã bảo vệ:</label>
                            <div class="col-sm-3">
                                <img src="<?php echo $imageCaptchaInvitemember ?>" height="34" style=""/>
                            </div>
                            <div class="col-sm-6">
                                <input  style="text-indent: 5px; padding: 5px 0"
                                        onkeypress="return submitenter(this, event)" type="text"
                                        name="captcha_Invitemember" id="captcha_Invitemember" value=""
                                        maxlength="10" class="form-control"/>                               
                                <p style="color: #f00; padding: 10px; margin: 0;"><?php echo $error_captcha; ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6 col-sm-3 col-sm-offset-3">
                                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="check_InvitememberGroup();">Cập nhật</button>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <button type="reset" class="btn btn-default btn-lg btn-block">Hủy bỏ</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- ========================== End Content ============================ -->
            </div>
        </div> 
    </div>
</div>
<?php $this->load->view('group/common/footer'); ?>
<script>        
    $('select').on('change', function() {
        if(this.value==5) {
           $('#grt_invite_value').attr("onkeyup","ajaxSearch();");
        } else {
           $('#grt_invite_value').removeAttr("onkeyup");
        }
    });
    function ajaxSearch(){
        var input_data = $('#grt_invite_value').val();
        if (input_data.length === 0){
            $('#suggestions').hide();
        } else {
            var post_data = { search_data: input_data };
            $.ajax({
                type: "POST",
                url: "/home/grouptrade/autocomplete",
                data: post_data,
                success: function (data) {
                    // return success
                    if (data.length > 0) {
                        $('#suggestions').show();
                        $('#autoSuggestionsList').addClass('auto_list');
                        $('#autoSuggestionsList').html(data);
                        $('.auto_list li').click(function(){                            
                            $('#grt_invite_value').val( $(this).text() );
                            $('#suggestions').hide();
                        })
                    }
                }
             });
         }
    }
</script>