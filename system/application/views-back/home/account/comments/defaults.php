<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <link type="text/css" href="<?php echo base_url(); ?>templates/home/css/datepicker.css" rel="stylesheet"/>
            <script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/datepicker.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>
            <!--BEGIN: RIGHT-->
            <SCRIPT TYPE="text/javascript">
                function SearchRaoVat(baseUrl) {
                    product_name = '';
                    if (document.getElementById('keyword_account').value != '')
                        product_name = document.getElementById('keyword_account').value;
                    window.location = baseUrl + 'account/product/search/name/keyword/' + product_name + '/';
                }
                <!--
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
                -->
            </SCRIPT>
            <div class="col-md-9 col-sm-8 col-xs-12">
                <h4 class="page-header" style="margin-top:10px">BÌNH LUẬN CỦA KHÁCH HÀNG</h4>
                <form name="frmAccountPro" method="post">
                    <div style="overflow: auto">
                        <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                            <?php if (count($comments) > 0) { ?>
                                <thead>
                                <tr>
                                    <th width="5%" class="aligncenter hidden-xs">STT</th>
                                    <th width="40%" class="aligncenter">
                                        Tin tức
                                    </th>
                                    <th width="35%" class="aligncenter">
                                        Bình luận
                                    </th>
                                    <th width="15%" class="aligncenter">
                                        Ngày đăng
                                    </th>
                                    <th width="5%" class="aligncenter">
                                       Xóa
                                    </th>
                                </tr>
                                </thead>
                                <?php $idDiv = 1;

                                $stt = $this->uri->segment(3);
                                if($this->uri->segment(3)==''){
                                    $stt = 0;
                                }

                                ?>
                                <?php foreach ($comments as $k => $productArray) { ?>
                                    <tr id="item_<?php echo $productArray['noc_id']; ?>">
                                        <td height="45" class="aligncenter hidden-xs"><?php echo  ++$stt; ?></td>
                                        <td>
                                            <a target="_blank"
                                               href="<?php echo base_url() ?>tintuc/detail/<?php echo $productArray['not_id']; ?>/<?php echo RemoveSign($productArray['not_title']); ?>">
                                                <?php echo $productArray['not_title']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $productArray['noc_comment']; ?>
                                        </td>
                                        <td class="aligncenter">
                                            <?php echo $productArray['noc_date']; ?>
                                        </td>
                                        <td class="aligncenter">
                                            <a href="#" class="btn btn-danger" onclick="DeleteComment(<?php echo $productArray['noc_id']; ?>)"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php $sTT++; ?>
                                <?php } ?>
                            <?php }; ?>
                        </table>
                    </div>
                </form>
                <?php echo $pager; ?>
            </div>
        </div>
    </div>
    <script language="javascript">

        function DeleteComment(id){
            confirm(function(e,btn){
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url:"<?php echo base_url(); ?>" + 'home/account/del_comment',
                    cache: false,
                    data:{noc_id: id},
                    dataType:'text',
                    success: function(data){
                          if(data == '1'){
                              $('#item_'+id).hide();
                          }else{
                              alert('Có lỗi xảy ra, vui lòng thử lại!');
                          }
                    }
                });
            });
            return false;
        }
    </script>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>