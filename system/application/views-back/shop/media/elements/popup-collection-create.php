<div class="modal bst-modal" id="creatNewCollectionLinks"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thêm BST liên kết</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="edit-coll">
                <!-- Modal body -->
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div id="crop-zone" class="text-center">
                                <img class="reviewImg center" id="reviewImg" src="/templates/home/styles/images/svg/add_avata.svg">
                            </div>
                            <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
                      <!-- <i class="fa fa-upload" aria-hidden="true"></i> -->
                      <input type="file" class="form-control" name="" accept="image/*" id="img-collection" style="display:none">
                    </span>
                            </label>
                        </div>
                        <div class="form-group">
                            <!-- <label class="col-form-label ten-bst">Tên bộ sưu tập</label> -->
                            <input type="text" autocomplete="off" name="nameCollection" value="" placeholder="Tên bộ sưu tập" class="ten-bst-input">
                        </div>
                        <div class="form-group">
                            <!-- <label class="col-form-label ten-bst">Tên bộ sưu tập</label> -->
                            <select name="" id="" class="select-category js_collection-category">
                                <?php if (!empty($categories)) { ?>
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <option value="">Chưa có dữ liệu</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="category_link_id" class="select-category js_collection-category-child">
                                <option value="">Chọn chuyên mục con</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-style">
                                <input type="checkbox" name="isPublic" value="check"><span>Bí mật</span>
                            </label>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer buttons-group">
                    <div class="bst-group-button">
                        <div class="left"></div>
                        <div class="right">
                            <button type="button" class="btn btn-border-pink">Hủy</button>
                            <button type="button" class="btn btn-bg-gray btn_save_edit_collection">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>