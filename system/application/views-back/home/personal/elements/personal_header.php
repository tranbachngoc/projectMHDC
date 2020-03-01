<div class="container">
    <div class="cover-content">
        <?php echo $this->load->view($cover_path, ['color_icon' => @$color_icon]); ?>
    </div>
    <?php if($show_sub_aff == false) { ?>
    <div class="sidebarsm">
        <div class="gioithieu">
            <?php echo $this->load->view('home/personal/elements/personal_menu_left_items', ['profile_url' => $profile_url]) ?>
        </div>
    </div>
    <?php } ?>
    <?php
        if($show_sub_aff == true) {
            $this->load->view('home/personal/elements/personal_menu_sub_affiliate');
        }
    ?>
</div>