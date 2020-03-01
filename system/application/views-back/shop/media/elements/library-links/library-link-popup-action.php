<div class="modal js_library-link-popup-action">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <ul class="show-more-detail js_action-tools">
                    <?php if(empty($is_owns) && $this->session->userdata('sessionUser')&& !isset($page_custom_link_detail)) { ?>
                        <li class="js_action-link js_action-link-clone"><a href="JavaScript:Void(0);">Ghim</a></li>
                    <?php } ?>
<!--                    <li><a href="JavaScript:Void(0);">Chia sẻ và gửi qua tin nhắn</a></li>-->
                    <li class="js_action-link js_action-link-copy"><a href="JavaScript:Void(0);">Sao chép liên kết</a></li>
<!--                    <li><a href="JavaScript:Void(0);">Thêm bình luận</a></li>-->
                    <?php if(!empty($is_owns) && !isset($page_custom_link_detail)){ ?>
                        <li class="js_action-link js_action-link-edit"><a href="JavaScript:Void(0);">Sửa</a></li>
                        <li class="js_action-link js_action-link-delete"><a href="JavaScript:Void(0);">Xóa</a></li>
                    <?php } ?>
                    <li class="share-click js-customlink cursor-pointer" data-toggle="modal">Chia sẻ</li>
                    <?php if(DOMAIN_IS == AZIBAI_DOMAIN){ ?>
                        <li class="js_action-link js_action-link-common" data-toggle="modal">Thông tin</li>
                    <?php } ?>
<!--                    <li><a href="JavaScript:Void(0);">Báo cáo</a></li>-->
<!--                    <li data-toggle="modal" data-target="#popupInfo">Thông tin</li>-->
                </ul>
            </div>
        </div>
    </div>
</div>
