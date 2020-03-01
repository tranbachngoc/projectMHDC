<div class="modal" id="typeDisplayNewsdetail">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Chọn kiểu hiển thị chi tiết tin</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="typeDisplayNewsdetail">
                    <ul class="nav nav-tabs typeDisplayNewsdetail-nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($type_show) && $type_show == STYLE_SHOW_CONTENT_DEFAULT) || !isset($type_show) ? 'active show' : '' ?>" id="home-tab" data-toggle="tab" data-style-show="0" href="#home">Kiểu mặc định</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isset($type_show) && $type_show == STYLE_1_SHOW_CONTENT ? 'active show' : '' ?>" id="profile-tab" data-toggle="tab" data-style-show="1" href="#profile">Kiểu 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isset($type_show) && $type_show == STYLE_2_SHOW_CONTENT ? 'active show' : '' ?>" id="contact-tab" data-toggle="tab" data-style-show="2" href="#contact">Kiểu 2</a>
                        </li>
                    </ul>
                    <div class="typeDisplayNewsdetail-tab-content" id="myTabContent">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <img src="/templates/home/styles/images/cover/show_v1.png" alt="">
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <img src="/templates/home/styles/images/cover/show_v2.png" alt="">
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <img src="/templates/home/styles/images/cover/show_v3.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="shareModal-footer">
                    <div class="permision"></div>
                    <div class="buttons-direct">
                        <button class="btn-cancle" data-dismiss="modal">Hủy</button>
                        <button class="btn-share btn-save-style-show-content">Lưu</button>
                    </div>
                </div>
            </div>
            <!-- End modal-footer -->
        </div>
    </div>
</div>