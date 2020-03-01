<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="/templates/home/darkroomjs/css/darkroom.css" type="text/css" rel="stylesheet"/>
<script src="/templates/home/darkroomjs/js/fabric.js"></script>
<script src="/templates/home/darkroomjs/js/darkroom.js"></script>

<style>
    .reviewImg {
        width: auto;
        max-height: 600px;
    }

    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        /* width: 50%; */
    }

    .darkroom-button-group {
        padding: 5px;
        display: inline-block;
    }
</style>

<!-- The Modal -->
<div class="modal fade" id="createCollection">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tạo bộ sưu tập</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="js_frm-collection js_frm-create-collection" data-target=".js_frm-collection">
                    <div class="form-group">
                        <label class="col-form-label" style="display:inline">Chọn hình đại diện bộ sưu tập:
                            <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                <input type="file" class="form-control" name="" accept="image/*" id="img-collection" style="display:none">
                            </span>
                        </label>
                        <div id="crop-zone">
                            <img class="reviewImg center" id="reviewImg" src="/templates/home/styles/images/default/error_image_400x400.jpg">
                        </div>
                    </div>
                    <div class="form-group after_crop" style="display:none">
                        <label class="col-form-label">Tên bộ sưu tập:</label>
                        <input type="text" name="nameCollection" class="" autocomplete="off">
                    </div>
                    <div class="form-group after_crop">
                        <label class="checkbox-style-circle">
                            <input class="js_library-link-belong-to" type="radio" name="is_owner" value="personal" <?php echo !isset($default_shop) ? 'checked' : '' ?>><span>Cá nhân</span>
                        </label>&nbsp;&nbsp;
                        <label class="checkbox-style-circle">
                            <input class="js_library-link-belong-to" type="radio" name="is_owner" value="shop" <?php echo isset($default_shop) ? 'checked' : '' ?>><span>Doanh nghiệp</span>
                        </label>
                    </div>
                    <div class="form-group after_crop">
                        <label class="checkbox-style">
                            <input type="checkbox" name="isPublic" value="check"><span>Bí mật</span>
                        </label>
                    </div>
                    <input class="js_sho-id" type="hidden" name="sho_id" value="<?php echo @$sho_id ?>">
                </form>
            </div>
            <div class="modal-footer buttons-group">
                <button type="button" class="btn btn-bg-gray after_crop" style="display:none">Xong</button>
                <button type="button" class="btn btn-bg-white" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!--<script src="/templates/home/styles/js/shop/popup-create-collection-link.js"></script>-->