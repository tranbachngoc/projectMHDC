<?php 
    $slug_profile     = 'profile/' . $current_profile['use_id'];
?>
<div class="row">
    <div class="col-md-4">
        <?php echo $this->load->view('home/personal/affiliate/layout/menu-left') ?>
    </div>
    <div class="col-md-8">
        <div class="tranggioithieu-right">
            <div class="alert"></div>
            <div class="item">
                <h3 class="tit">DANH SÁCH AFFILIATE USER LEVEL <?=($iAff != 0) ? $iAff : 'CHƯA PHÂN CẤP'?></h3>
                <div class="list-affiliate-service">
                    <?php if(isset($aListAffUser) && !empty($aListAffUser)) { ?>
                        <div class="affiliate-user">
                            <table>
                                <thead>
                                    <tr>
                                        <th width="40">STT</th>
                                        <th>Tên người dùng</th>
                                        <th>Điện thoại</th>
                                        <th>Email</th>
                                        <th width="150">Địa chỉ</th>
                                        <th width="50">Level</th>
                                        <th>Thuộc về</th>
                                        <th width="100">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($aListAffUser as $k => $oUser): ?>
                                    <tr>
                                        <td><?=$k+1?></td>
                                        <td><?=$oUser->use_fullname;?></td>
                                        <td><?=$oUser->use_mobile;?></td>
                                        <td><?=$oUser->use_email;?></td>
                                        <td><?=$oUser->use_address;?></td>
                                        <td>
                                            <input type="numner" min="2" max="3" name="level" value="<?=$oUser->affiliate_level;?>">
                                        </td>
                                        <td><?=$oUser->parent_name;?></td>
                                        <td> 
                                            <button class="edit_affiliate_level" data-id="<?=$oUser->use_id;?>"><i class="fa fa-pencil-square" aria-hidden="true"></i> Lưu</button>
                                            <a href="<?php echo base_url().$slug_profile . '/affiliate/user/'.$oUser->use_id; ?>"><i class="fa fa-cogs" aria-hidden="true"></i> Cấu hình</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>

    </div>
</div>