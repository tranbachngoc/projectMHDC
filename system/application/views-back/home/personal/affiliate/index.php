<div class="row">
    <div class="col-md-4">
        <?php echo $this->load->view('home/personal/affiliate/layout/menu-left') ?>
    </div>
    <div class="col-md-8">
        <div class="tranggioithieu-right">
            <div class="alert"></div>
            
            <div class="item">
                <h3 class="tit">LINK GIỚI THIỆU</h3>
                <div class="text">
                    <p><?=base_url()?>register/verifycode?reg_pa=<?=$user_infomation['use_id']?></p>
                </div>
                <button class="copy-link-send" data-link="<?=base_url()?>register/verifycode?reg_pa=<?=$user_infomation['use_id']?>">Copy Link</button>
            </div>
            
        </div>

    </div>
</div>