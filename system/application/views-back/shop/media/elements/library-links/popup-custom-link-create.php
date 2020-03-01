<div class="modal fade" id="popup-crawl-custom-link">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div style="display:inline" class="add-more-txt">
                    <h4 class="modal-title"><?php echo isset($custom_title) ? $custom_title : 'Thêm link liên kết' ?></h4>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" autocomplete="off" name="url_process" class="url-processed" placeholder="nhập url">
                </div>
            </div>
            <div class="modal-footer buttons-group">
                <button type="button" class="btn btn-border-pink" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-bg-gray btn_process">Xử lý</button>
            </div>
        </div>
    </div>
</div>

<div class="modal bst-modal" id="popup-add-custom-link" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo isset($custom_title) ? $custom_title : 'Thêm link liên kết' ?></h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="edit-coll">
                <div class="modal-body">
                    <form class="js_frm-library-link js_frm-library-link-create" data-target=".js_frm-library-link-create">
                        <div class="form-group __image-library-link">
                            <img class="reviewImg center js_custom-link-image-icon" id="reviewImg" src="/templates/home/styles/images/svg/add_avata.svg">
                            <div class="wrap-block-custom-link">
                                <img class="center js_custom-link-image">
                            </div>
                            <p class="text-danger pl-4 js_image-upload-msg"></p>
                            <p class="text-danger pl-4 js_image-msg"></p>
                            <p class="text-danger pl-4 js_video-msg"></p>
                            <p class="text-danger pl-4 js_link-msg"></p>
                        </div>
                        <div class="form-group">
                            <input disabled type="text" autocomplete="off" name="custom_link_title"
                                   class="ten-bst-input js_handle_value js_custom-link-title">
                        </div>
                        <div class="form-group">
                            <textarea disabled class="form-control ten-bst-input js_handle_value js_custom-link-description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control ten-bst-input js_handle_value js_custom-link-detail" rows="3"
                                      placeholder="Nhập ghi chú" spellcheck="false"></textarea>
                            <p class="text-danger pl-4 js_detail-msg"></p>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-style-circle">
                                <input class="js_library-link-belong-to" type="radio" name="is_owner" value="personal" <?php echo !isset($default_shop) || empty($default_shop) ? 'checked' : '' ?>><span>Cá nhân</span>
                            </label>&nbsp;&nbsp;
                            <label class="checkbox-style-circle">
                                <input class="js_library-link-belong-to" type="radio" name="is_owner" value="shop" <?php echo isset($default_shop) && $default_shop == true ? 'checked' : '' ?>><span>Doanh nghiệp</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <select name="collection_custom_link[]" class="select-category js_collection-custom-link js_handle_value" multiple>
                                <option value="">Chọn bộ sưu tập liên kết</option>
                                <?php if (!empty($collections)) {
                                    echo general_group_option_collection($collections);
                                } ?>
                            </select>
                            <p class="text-danger pl-4 js_collections-msg"></p>
                        </div>
                        <div class="form-group">
                            <select name="category_link_parent_id" class="select-category js_category-parent-custom-link js_handle_value">
                                <option value="">Chọn chuyên mục liên kết</option>
                                <?php if (!empty($categories_popup_create_link)) { ?>
                                    <?php foreach ($categories_popup_create_link as $category_parent_pop) { ?>
                                        <option <?php echo isset($create_category_selected_default) && $create_category_selected_default == $category_parent_pop['id'] ? 'selected' : '' ?>
                                                value="<?php echo $category_parent_pop['id']; ?>"><?php echo $category_parent_pop['name']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <p class="text-danger pl-4 js_category_parent-msg"></p>
                        </div>
                        <div class="form-group">
                            <select name="category_link_id" class="select-category js_category-custom-link js_handle_value">
                                <option value="">Chọn chuyên mục con</option>
                            </select>
                            <p class="text-danger pl-4 js_category_child-msg"></p>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-style">
                                <input type="checkbox" name="is_private" value="check"><span>Bí mật</span>
                            </label>
                        </div>
                        <input type="hidden" class="js_save-link js_handle_value" name="save_link">
                        <input type="hidden" class="js_save-id js_handle_value" name="save_id">
                        <input type="hidden" class="js_type-link js_handle_value" name="type_link">
                        <input type="hidden" class="js_sho-id" name="sho_id" value="<?php echo @$sho_id ?>">
                        <input type="file" class="hide_0 js_handle-image-upload js_handle_value">
                        <!--  input handle ajax upload temp image -->
                        <input type="hidden" class="js_image-upload js_handle_value" name="image_path">
                        <input type="hidden" class="js_video-upload js_handle_value" name="video_path">
                        <p class="text-danger pl-4 js_save_link-msg"></p>
                        <p class="text-danger pl-4 js_sho_id-msg"></p>
                    </form>
                </div>
                <div class="modal-footer buttons-group">
                    <div class="bst-group-button">
                        <div class="left"></div>
                        <div class="right">
                            <button type="button" data-dismiss="modal" class="btn btn-border-pink">Hủy</button>
                            <button type="button" class="btn btn-bg-gray js_btn-process-link" id="">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>