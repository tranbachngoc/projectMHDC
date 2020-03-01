<?php
    $number_add = count($not_additionals);
    $flag_add_showmore = $number_add > 1 ? true : false;
    $addition = array_shift($not_additionals);
    $_addpath_image = DOMAIN_CLOUDSERVER . "media/images/content/{$dir_add}/";
    $_addpath_icon = DOMAIN_CLOUDSERVER . "media/icons/type_2/";
    $_addsrc = "";
    $_type = $addition['type'] ? $addition['type'] : $addition['icon_type'];
    switch ($_type) {
        case ICON_TYPE_IMAGE:
            $_addsrc = $this->config->item('image_path_content') . $dir_add .DIRECTORY_SEPARATOR. $addition['image_thumb'];
            break;
        case ICON_TYPE_VIDEO:
            $_addsrc = $this->config->item('video_path') . $addition['video_path'];
            $_addposter = $this->config->item('image_path_content') . $dir_add .DIRECTORY_SEPARATOR. $addition['video_thumb'];
            break;
        case ICON_TYPE_ANIMATION:
            $_addsrc = !empty($addition['icon_url']) ? $addition['icon_url'] : $_addpath_icon . $addition['icon'];
            break;
        case ICON_TYPE_ICON:
            $_addsrc = $this->config->item('icon_path') . $addition['icon'];
            break;
        default:
            break;
    }
?>

<div class="row info-product">
    <div class="col-3">
        <div class="float-right">
            <?php if($_type == ICON_TYPE_ANIMATION) { ?>

            <div id="json_image_<?=$id_add_json?>" class="icon-inserted"></div>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    bodymovin.loadAnimation({
                        container: document.getElementById('json_image_<?=$id_add_json?>'),
                        renderer: 'svg',
                        loop: true,
                        autoplay: true,
                        path: '<?=$_addsrc?>'
                    });
                });
            </script>

            <?php } else if(in_array($_type, [ICON_TYPE_IMAGE, ICON_TYPE_ICON])) { ?>

            <img class="<?=$_type == ICON_TYPE_IMAGE ? " icon-inserted " : " "?>" src="<?=$_addsrc?>">

            <?php } else if(in_array($_type, [ICON_TYPE_VIDEO])) { ?>
            <video class="icon-inserted" poster="<?=$_addposter?>" autoplay muted loop>
                <source src="<?=$_addsrc?>" type="video/mp4">
            </video>
            <?php } ?>
        </div>
    </div>
    <div class="col-9 descrip">
        <p>
            <strong>
                <?=$addition['title'] . ($addition['desc'] ? ": " : "")?></strong>
            <?=$addition['desc'] . ($flag_add_showmore === true ? "<a href='{$link_add_detail}'><span class=''>...xem thêm</span></a>" : "")?>
        </p>
    </div>
</div>