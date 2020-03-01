<?php $this->load->view('home/common/account/header'); ?>
<script type="text/javascript" src="/templates/home/js/jquery.autocomplete.min.js"></script>
<!--<script type="text/javascript" src="/templates/home/js/currency-autocomplete.js"></script>-->
<style>
    .unit {
        margin-top: 5px;
        margin-left: 10px;
        float: left;
    }
    .autocomplete-suggestions {
        overflow-y: scroll;
    }
    .autocomplete-suggestion {
        background: #fff;
        padding: 5px;
        border-bottom: 1px solid #ccc;
    }
    .autocomplete-selected {
        background: #f3f2f2;
    }
    .box_member {
        /*border: 1px solid #ccc;*/
    }
    .list_member {
         overflow: hidden;
         margin-bottom: 20px;
     }
    #box_tag{
        margin-right: 10px;
        float: left;
    }
    span.tag {
        background: content-box;
        padding: 3px 5px;
        border-radius: 5px;
        box-shadow: 1px 3px 4px #b5b5b5;
    }
    label.closeTag {
        color: #6d6d6d;
        /* background: #fff; */
        /* overflow: hidden; */
        padding: 2px;
        position: inherit;
        text-shadow: 1px 2px 2px #ccc;
    }
    label.closeTag:hover{
        cursor: pointer;
    }
    .note {
        color: #f00;
        text-align: center;
        text-transform: uppercase;
    }
</style>
<div class="clearfix"></div>
<div id="product_content" class="container-fluid">
    <div class="row rowmain">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-xs-12">
                <!-- ========================== Begin Content ============================ -->
                    <h2 class="page-title">Mời thành viên mới</h2>
                    <form class="form-horizontal" name="frmInvitemember" id="frmInvitemember" method="post" enctype="multipart/form-data">
                        <div class="note"><?php if($notification && $notification!=''){ echo $notification; } ?></div>
                        <div class="form-group">
                            <label for="grt_province_store" class="col-sm-3 control-label">Thành viên<font color="#FF0000"><b>*</b></font> :</label>
                            <div class="col-sm-9">
                                <div class="box_member">
                                    <div class="list_member" style="display: none"></div>
                                <textarea class="form-control" name="list_invite" id="list_invite" id="autocomplete"><?php if($list_invite){ echo $list_invite;} ?></textarea>
                            </div>
                            </div>
                        </div>
                        <div class="list_user" style="display: none"></div>
                        <div class="form-group">
                            <label for="grt_captcha" class="col-sm-3 control-label">Mã bảo vệ<font color="#FF0000"><b>*</b></font> :</label>
                            <div class="col-sm-3">
                                <img src="<?php echo $imageCaptchaInvitemember?>" height="31" style=""/>
                            </div>
                            <div class="col-sm-6">
                                <input  style="text-indent: 5px; padding: 5px 0"
                                        onkeypress="return submitenter(this, event)" type="text"
                                        name="captcha_Invitemember" id="captcha_Invitemember" value=""
                                        maxlength="10" class="form-control"/>
                                <?php //echo form_error('captcha_groupStore'); ?>
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
                <!-- ========================== End Content ============================ -->

        </div>
    </div>
</div>
<script>
    $(function(){
        $("#list_invite").keypress(function(event){
            // 1. Create the button
            var str = $('#list_invite').val();
            var pos = str.search(" ");
            if(event.keyCode == 44){

                if(pos > 0){
                    var substr = str.substring(0,pos);
                }else{
                    var substr = event.target.value;
                }
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "<?php echo base_url(); ?>home/groupTrading/get_user",
                    data: {id: event.target.value, name:substr},
                    success: function(rs){
                        showTag(rs.id,rs.name);
                    },
                    error: function () {
                        alert('Có lỗi xảy ra.');
                    }
                });
            }
        });

        function showTag(id,name) {
            $('.list_member').append('<div class="box_tag_' + id+'" id="box_tag"><span class="tag">'+name+'<label class="closeTag" id="' + id+'" onclick="xoa(this.id);">x</label></span><input type="hidden" name="use_id[]" value="' + id+'"></div>');
            $(".list_member").attr('style','');
            $("#list_invite").val('');
        }
        function showlist_User() {
                var currencies = [
                    <?php
                    //                echo $notIn;
                    $userid_invite = $this->user_model->fetch("use_username,use_id,use_group", "(parent_id IN(".$allUser.") OR use_group = 3) AND use_status = 1");
                    //                $userid_invite = $this->user_model->fetch("use_username,use_id", "parent_id IN(".$allUser.")".$notIn." AND use_status = 1");
                    foreach ($userid_invite as $k=>$item){
                        $cv = '';
                        if($item->use_group == 3){
                            $cv = ' [gian hàng]';
                        }else{
                            $cv = ' [child]';
                        }
                        echo "{ value: '".$item->use_username.$cv."', data: '".$item->use_id."' },";
                    }
                    ?>
                ];
                return currencies;

        }
        // setup autocomplete function pulling from currencies[] array
        $('#list_invite').autocomplete({
            lookup: showlist_User(),
            onSelect: function (suggestion) {
                showTag(suggestion.data,$("#list_invite").val());
                showlist_User();
            }
        });

    });

    function xoa(id) {
        $('.box_tag_'+id).remove();
    }

</script>
<script>
    function check_InvitememberGroup() {
        var dem = $('#box_tag').length;
        if(!dem){
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Bạn chưa nhập thành viên mời tham gia nhóm!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("list_invite").focus();
                        return false;
                    }
                }
            });
            return false;
        }

        if (CheckBlank(document.getElementById("captcha_Invitemember").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Bạn chưa nhập mã bảo vệ!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("captcha_Invitemember").focus();
                        return false;
                    }
                }
            });
            return false;
        }
        document.frmInvitemember.submit();
    }
</script>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
