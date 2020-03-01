<?php $this->load->view('home/common/header');  ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-lg-9 col-md-9 col-sm-8">
            <h2 class="page-title text-uppercase">
                Danh sách Developer <?php echo $text ?>
            </h2>
            <div class="db_table" style="overflow: auto; width:100%">
                <div colspan="6" class="text-right detail_list" style="font-weight: 600; font-size: 15px">Tổng số Developer trong danh sách:<span style="color:#F00; font-size: 15px"><b> <?php echo $number; ?></b></span></div>

                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%" class="title_account_0">STT</th>
                        <th width=20%" class="title_account_2" align="center" >
                            Họ tên
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th>
                        
                        <th width="20%" class="title_account_2" align="center" >
                            Tên đăng nhập
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th>
                        <th width=15%" class="title_account_2" align="center" >
                            Email
                        </th>
                        <th width=15%" class="title_account_2" align="center" >
                            Số điện thoại
                        </th>
                        <th width=15%" class="title_account_2" align="center" >
                            Số GH trực thuộc
                        </th>
                        <th width=15%" class="title_account_2" align="center" >
                            Số CTV trực thuộc
                        </th>
<!--                        <th width=15%" class="title_account_2" align="center" >-->
<!--                            Gán-->
<!--                        </th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    foreach($staffs as $key => $items)
                    {
                        $showcarttotal = 0;
                    ?>
                        <tr>
                            <td width="5%" height="32" class="line_account_0"><?php echo $stt++; ?></td>
                            <td width="20%" height="32" class="line_account_2">
                                <?php echo ($items->use_fullname == '')? 'chưa cập nhật':$items->use_fullname;?>
                            </td>
                            <td width="20%" height="32" class="line_account_2">
                                <?php echo $items->use_username;?>
                                <div class="shop_parent <?php if($items->userid_parent == $this->session->userdata('sessionUser')){ ?>active<?php } ?>">
                                    <i><?php echo 'Parent: '.$items->parent_username;?></i>
                                </div>
                            </td>
                            <td width="10%" height="32" class="line_account_2">
                                <?php echo $items->use_email;?>
                            </td>
                            <td width="10%" height="32" class="line_account_2">
                                <?php echo ($items->use_mobile == '')?'chưa cập nhật':$items->use_mobile;?>
                            </td>
                            <td width="10%" height="32" class="line_account_2">
                                <?php if(count($storedev[$items->use_id]) > 0 ){ ?>
                                <a href="/account/listshop/shc/<?php echo $items->use_id?>">
                                    <?php echo count($storedev[$items->use_id]);?>
                                </a>
                                <?php } else{ echo '0'; } ?>
                            </td>
                            <td width="10%" height="32" class="line_account_2">
                                <?php echo ($countAff[$items->use_id] != '') ? '<a href="/account/listaff/'.$items->use_id.'">'.$countAff[$items->use_id].'</a>' : 0; ?>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php if(count($staffs) <= 0){ ?>
                        <tr>
                            <td colspan="8"><div class="nojob">Không có dữ liệu!</div></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php if(count($linkPage) > 0){ ?>
                    <tr>
                        <td colspan="8"><?php echo $linkPage;?></td>
                    </tr>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
