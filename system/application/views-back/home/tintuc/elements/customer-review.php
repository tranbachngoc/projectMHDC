<?php
    $sStyle = '';
    $sStyleBackground = '#ffffff';
    if(isset($not_customer->cus_background) && $not_customer->cus_background !='' ) {
        $sStyle .= 'background:#'.$not_customer->cus_background.';';
        $sStyleBackground = $not_customer->cus_background;
    }

    if(isset($not_customer->cus_color) && $not_customer->cus_color !='' ) {
        $sStyle .= 'color:#'.$not_customer->cus_color.';';
    }
?>
<div class="noivechungtoi" style="<?=$sStyle;?>">
    <div class="noivechungtoi-tit"><?php echo $not_customer->cus_title ?></div>
    <div class="noivechungtoi-content">
        <?php
            if(isset($not_customer->cus_type) && $not_customer->cus_type != '') {
                $sTemplate = 'customer-review-'.$not_customer->cus_type;
            }else {
                $sTemplate = 'customer-review-0';
            }
            echo $this->load->view(
                'home/tintuc/elements/customer_review/'.$sTemplate,
                ['not_customer' => $not_customer, 'sStyle' => $sStyle, 'sStyleBackground' => $sStyleBackground]
            );
        ?>
    </div>
    <?php echo $html_modal_customer ?>
</div>
