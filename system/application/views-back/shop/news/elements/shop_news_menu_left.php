<?php
$this->shop_current = $shop = MY_Loader::$static_data['hook_shop'];

$shop_name_xss = htmlspecialchars($item->sho_name);
$shop_link     = $this->shop_current->shop_url;
$shop_logo     = $this->shop_current->logo;
if(!$shop_logo){
    $shop_logo = site_url('templates/home/images/no-logo.jpg');
}
?>
<div class="tindoanhnghiep-sideleft">
    <h3 class="tit">Về chúng tôi</h3>
    <div class="img">
        <a href="<?php echo $shop_link ?>" title="<?php echo $shop_name_xss ?>">
            <img src="<?php echo $shop_logo ?>" alt="<?php echo $shop_name_xss ?>">
        </a>
    </div>
    <div class="sub-tit">
        <a href="<?php echo $shop_link ?>" title="<?php echo $shop_name_xss ?>">
            <?php echo $item->sho_name ?>
        </a>
    </div>
    <p><?php echo limit_the_string($item->sho_descr, 400) ?></p>
    <div class="link-to-other mt20">
        <p class="mb10">
            <a href=""><img src="/templates/home/styles/images/svg/instagram.svg" alt=""></a>
            <a href=""><img src="/templates/home/styles/images/svg/facebook.svg" alt=""></a>
            <a href=""><img src="/templates/home/styles/images/svg/google.svg" alt=""></a>
            <a href=""><img src="/templates/home/styles/images/svg/twister.svg" alt=""></a>
        </p>
    </div>
</div>