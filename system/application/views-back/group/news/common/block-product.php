<?php /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */ ?>
<div class="panel panel-default">                
    <div class="panel-heading"><strong>Sản phẩm</strong></div>    
    <div class="panel-body" style="padding: 10px">
        <div id="pictures_gallery">  
            <div class="owl-carousel">
                <?php
                foreach ($products as $key => $product) {
                    $listimg = explode(',', $product->pro_image);
                    $pro_image = $listimg[0];
                    $fileimg = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . $pro_image;
                    $fileimgthumb = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_2_' . $pro_image;
                    $linkbuy = $product->linkview;
                    $linkedit = $mainURL . 'account/product/edit/' . $product->pro_id . '/';
                    ?>
                    <a class="item" href="<?php echo $fileimg ?>" data-sub-html=".caption<?php echo $key ?>">
                        <div class="fix1by1" style="border:1px solid #eee;">
                            <div class="c">
                                <img src="<?php echo $fileimgthumb ?>" alt="" />
                            </div>
                        </div>
                    </a>								
                <?php } ?>
            </div>		
            <?php foreach ($products as $key => $product) { ?>
                <div class="caption<?php echo $key ?>" style="border-bottom: 10px solid #ddd; display: none;">
                    <ul class="menu-justified dropdown">
                        <?php if ($this->session->userdata('sessionUser') == $siteGlobal->sho_user) { ?>
                            <li class="">                                        
                                <a href="<?php echo $linkedit ?>">
                                    <i class="azicon icon-edit"></i> &nbsp;Chỉnh sửa
                                </a>
                            </li> 
                        <?php } else { ?>
                            <li class="">   
                                <a href="<?php echo $linkbuy ?>">
                                    <i class="azicon icon-cube"></i> &nbsp;Chi tiết
                                </a>                                        
                            </li>
                        <?php } ?>
                        <li class="">
                            <a href="<?php echo $linkbuy ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="azicon icon-share"></i> &nbsp;Chia sẻ
                            </a>
                            <ul class="dropdown-menu" style="left: -15px; right:-15px;">
                                <li>
                                    <div style="padding: 5px 15px 5px 0">
                                        <a href="javascript:void(0)" onclick="
                                                    window.open(
                                                            'https://www.facebook.com/sharer/sharer.php?u=<?php echo $linkbuy ?>&amp;app_id=<?php echo app_id ?>',
                                                            'facebook-share-dialog',
                                                            'width=800,height=450');
                                                    return false;">
                                            <i class="azicon icon-facebook"></i>
                                        </a> &nbsp;
                                        <a href="javascript:void(0)" onclick="
                                                    window.open(
                                                            'https://twitter.com/share?text=<?php echo $product->pro_name ?>&amp;url=<?php echo $linkbuy ?>',
                                                            'twitter-share-dialog',
                                                            'width=800,height=450');
                                                    return false;">
                                            <i class="azicon icon-twitter"></i>                                            
                                        </a> &nbsp;
                                        <a href="javascript:void(0)" onclick="
                                                    window.open(
                                                            'https://plus.google.com/share?url=<?php echo $linkbuy ?>',
                                                            'google-share-dialog',
                                                            'width=800,height=450');
                                                    return false;">
                                            <i class="azicon icon-google"></i>                                           
                                        </a>
                                        <!-- Button to trigger modal -->
                                        <a class="pull-right" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to&su=<?php echo $product->pro_name ?>&body=<?php echo $linkbuy ?>&ui=2&tf=1">
                                            <i class="azicon icon-email"></i>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" onclick="copylink('<?php echo $linkbuy ?>')">
                                         <i class="azicon icon-coppy"></i> &nbsp;Sao chép liên kết
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <script>
                        $('.lg-sub-html ul').removeClass('dropdown').addClass('dropup');
                    </script>
                </div>

            <?php } ?>
        </div>
    </div>
</div>            


