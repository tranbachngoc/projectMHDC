<?php
$group_id = (int)$this->session->userdata('sessionGroup');
$this->load->view('home/common/account/header');
$i = 1;
?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-lg-9 col-md-9 col-sm-8">
            <?php
            if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')){
                ?>
                <div class="message success" ">
                    <div class="alert <?php echo ($this->session->flashdata('flash_message_error')?'alert-danger':'alert-success')?>">
                        <?php echo ($this->session->flashdata('flash_message_error')?$this->session->flashdata('flash_message_error'):$this->session->flashdata('flash_message_success')); ?>
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                </div>
                <?php
            }
            ?>
            
            
            <h4 class="page-header text-uppercase" style="margin-top:10px">DANH SÁCH LANDING PAGE</h4>
            
            
            
            <div style="overflow: auto; width:100%">
                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php if (count($list) >= 0): ?>
                        <thead>
                            <tr>
                                <th width="50" class="title_account_0">STT</th>
                                <th width="" align="center">Tiêu đề</th>
                                <th width="" align="center">Danh sách người nhận tin</th>
                                <th width="180" align="center">Ngày tạo</th>
                                <th width="100" align="center">Trạng thái</th>
                                <th width="100" align="center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list as $list): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><a class="bluetext" href="<?php echo base_url()."templates/landing_page/".$list->id; ?>" target="_blank"><?php echo $list->name; ?></a></td>
                                <td><?php echo $list->list_name; ?></td>
                                <td><?php echo date("d-m-Y H:i:s", strtotime($list->created_date)); ?></td>
                                <td class="text-center">

                                    <?php 
                                        $un_href = '#';
                                        $active_href = '#';
                                        if($this->session->userdata('sessionGroup') == AffiliateStoreUser)
                                        {
                                            $un_href = base_url() . 'account/landing_page/lists?active=0&id=' . $list->id;
                                            $active_href = base_url() . 'account/landing_page/lists?active=1&id=' . $list->id;
                                        }
                                        if($list->status > 0){?>
                                            <a class="btn btn-success" href="<?php echo $un_href; ?>"><i class="fa fa-check"></i></a>
                                        <?php }else{?>
                                            <a class="btn btn-danger"  href="<?php echo $active_href; ?>"><i class="fa fa-times"></i></a>
                                        <?php } 
                                    ?>
                                </td>
                                <td>
                                    <a title="Xem chi tiết" href="<?php echo base_url()."landing_page/id/".$list->id."/".RemoveSign($list->name); ?>" target="_blank" class=""><button class="btn btn-default1"> <i class="fa fa-binoculars"></i></button></a>

                                    <a title="Xóa" onclick="return confirmDeleteLandingPage('<?php echo base_url()."account/landing_page/delete/".$list->id; ?>');"  class=""><button class="btn btn-danger"> <i class="fa fa-trash-o"></i></button></a>
                                </td>
                            </tr>
                            <?php endforeach;?>

                        <?php // BEGIN landing page temp
                        if((int)$this->session->userdata('sessionUser') == 4356){
                            $list_landing_demo = array(
                                'l0' => array(  'name' => 'Azibai Presentation', 
                                                'link_demo' => 'http://socials.azibai.com/azibai-presentation/')
                            ); 
                        }

                        if((int)$this->session->userdata('sessionUser') == 4734){
                            $list_landing_demo = array(
                                'l0' => array(  'name' => 'HOVENIA', 
                                                'link_demo' => 'http://vinacacao.azibai.com/demo-vinacacao/')
                            ); 
                        }
                                                        
                        ?>
                        <?php 
                        if($this->session->userdata('sessionUser') && isset($list_landing_demo) && !empty($list_landing_demo)) {
                        $dong = $list ? count($list) : 1;
                        foreach ($list_landing_demo as $kitem => $vitem) { ?>
                            <tr>
                                <td><?php echo $dong++; ?></td>
                                <td><a class="bluetext" href="<?php echo $vitem['link_demo']; ?>" target="_blank"><?php echo $vitem['name']; ?></a></td>
                                <td></td>
                                <td><?php echo date("d-m-Y H:i:s", time()); ?> </td>
                                <td class="text-center">                                   
                                    <a class="btn btn-success" href="#"><i class="fa fa-check"></i></a>
                                </td>
                                <td>
                                    <a title="Xem chi tiết" href="<?php echo $vitem['link_demo']; ?>" target="_blank" class=""><button class="btn btn-default1"> <i class="fa fa-binoculars"></i></button></a>
                                    <a title="Xóa" class=""><button class="btn btn-danger"> <i class="fa fa-trash-o"></i></button></a>
                                </td>   
                            </tr>
                        <?php }} // END landing page temp ?>

                        </tbody>
                    <?php else: ?>
                         <tr>
                            <td class="text-center">
                                Không có dữ liệu!
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if($this->session->userdata('sessionGroup') == AffiliateStoreUser || $this->session->userdata('sessionGroup') == BranchUser){ ?>
                    
                    <tr>
                        <td colspan="6">
                            <div style="text-align: right; padding:0 0 10px 0"><a href="#" class="btn btn-azibai" id="addNewButtton"> Thêm mới</a></div>
                        </td>
                    </tr>
                    <?php } ?>

                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
               <form id="create_landing" action="<?php echo base_url()."templates/landing_page/builder" ?>" target="_blank" method="post">
                   <div>
                       <label>Tiêu đề : <input type="text" id="name" name="name" value="" placeholder="nhập tiêu đề" />
                       </label>
                       <input type="hidden" name="list_name" id="list_name_email" />
                       <select name="list_id" id="list_for_email" style="padding:4px;">
                       <option value="">--Chọn list email---</option>
                       <?php if(isset($lList)) {
                        for($i = 0; $i < count($lListName); $i++){ ?>
                       <option value="<?php echo $lList[$i];?>"><?php echo $lListName[$i];?></option>
                       <?php }}?>
                           </select>
                       <div class="btn-box">
                           <input type="submit" value="Tạo" id="btn-create" class="btn btn-success" /><a href="#" class="btn btn-danger" data-dismiss="modal">Hủy</a>
                       </div>
                       <!--<div class="alert alert-danger " role="alert">test</div>-->
                       <div class="img-preview ac-custom ac-radio ac-circle" autocomplete="off">
                            <ul>
                                <li><label for="r1"><img src="<?php echo base_url(). "templates/landing_page/images/preview/2.png" ?>"> <span>App Landing</span></label><input id="r1" name="template_id" value="4" type="radio" checked></li>
                                <li><label for="r2"><img src="<?php echo base_url(). "templates/landing_page/images/preview/3.png" ?>"> <span> Real Estate Landing</span></label><input id="r2" name="template_id" type="radio" value="5"></li>
                                <li><label for="r3"><img src="<?php echo base_url(). "templates/landing_page/images/preview/4.png" ?>"> <span>Corporate Landing</span></label><input id="r3" name="template_id" type="radio" value="3"></li>
                                <li><label for="r4"><img src="<?php echo base_url(). "templates/landing_page/images/preview/15.png" ?>"> <span> Party Landing</span></label><input id="r4" name="template_id" type="radio" value="6"></li>
                                <li><label for="r5"><img src="<?php echo base_url(). "templates/landing_page/images/preview/18.jpg" ?>"> <span> Elegant Landing</span></label><input id="r5" name="template_id" value="2" type="radio"></li>
                            </ul>
                           <div class="clr"></div>
                       </div>
                   </div>
               </form>
            </div>
        </div>
    </div>

</div>

<script language="javascript" type="text/javascript">
    $("document").ready(function(){
        $('#list_for_email').change(function(){
            if($(this).val()){
                console.log($(this).val());
                $("#list_name_email").val($(this).find( " option:selected" ).text());
                console.log($("#list_name_email").val());
            }
        });

        //  Bind the event handler to the "submit" JavaScript event
        $('form#create_landing').submit(function () {
            // Get the Login Name value and trim it
            var name = $.trim($('#name').val());
            // Check if empty of not
            if (name  === '') {
                alert('Vui lòng nhập Tiêu đề');
                $("#name").css("border","1px solid red");
                return false;
            }
            $("#create_landing .btn-danger").trigger("click");
        });
        
        $("#addNewButtton").on('click',function(){
            $.ajax({
                url     : siteUrl  +'account/landing_page/checkLandPermissions',
                type    : "POST",
                success:function(response)
                {
                    if(response == "-1"){
                        $("#addNew").modal('show');
                    } else {
                        window.location.href = siteUrl + "account/landing_page/lists";
                        return false;
                    }
                },
                error: function()
                {
                    alert("Lỗi! Vui lòng thử lại sau");
                }
            });
        });
        
    });
</script>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>