<!-- Link Preview Modal -->
<div class="modal link-preview-form" id="addLinks">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><img src="/templates/home/styles/images/svg/link02.svg" class="mr10 mt02">Thêm liên kết</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="addLinks-content">
                    <div class="enter-input">
                        <input type="text" placeholder="Chèn liên kết url" class="form-control link-preview">
                        <img src="/templates/home/styles/images/svg/help_black.svg">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="shareModal-footer">
                    <div class="permision"></div>
                    <div class="buttons-direct">
                        <button class="btn-cancle" data-dismiss="modal">Đóng</button>
                        <button class="btn-share link-preview-submit"  data-toggle="modal">Xử lý</button>
                    </div>
                </div>
            </div>
            <!-- End modal-footer -->
        </div>
    </div>
</div>
<!-- End Link Preview Modal -->

<!-- Add Link Modal -->
<form action="<?php echo base_url() .'azi-admin/entertainment-link/add' ?>" method="POST" enctype="multipart/form-data">
    <div class="modal" id="addLinks02">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-sm slideInUp-animated">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><img src="/templates/home/styles/images/svg/link02.svg" class="mr10 mt02">Thêm liên kết</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="addLinks-content">
                        <div class="row">
                            <div class="col-xl-5">
                                <div class="addLinks-content-img">
                                    <img src="/templates/home/styles/images/hinhanh/03.jpg" class="object-fit-cover link-preview-image" style="width: auto;">
                                    <a class="edit" href=""><img src="/templates/home/styles/images/svg/pen.svg" class="mr05" width="20">Đổi
                                        ảnh, video</a>
                                    <input class="edit" type="file" name="link_file" accept="image/*,video/mp4,video/x-m4v,video/*">
                                </div>
                            </div>
                            <div class="col-xl-7">
                                <div class="addLinks-content-form">
                                    <input type="hidden" name="link" class="get_link" value="">
                                    <input type="hidden" name="link_image" class="get_image" value="">
                                    <div class="form-group">
                                        <label class="col-form-label ten-bst">Tên bộ sưu tập</label>
                                        <input type="text" name="title" placeholder="Text demo mô tả liên kết" class="form-control link-preview-title" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label ten-bst">Mô tả</label>
                                        <input type="text" name="description" placeholder="Text demo mô tả liên kết" class="form-control link-preview-description">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label ten-bst">Sắp xếp</label>
                                        <input type="text" name="sort_order" placeholder="" class="form-control link-preview-sort-order" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label ten-bst">Chuyên mục</label>
                                        <p class="mb10">
                                            <select name="category" id="" class="form-control link-preview-category" required>
                                                <option value="">Chọn chuyên mục</option>
                                            </select>
                                        </p>
                                        <p>
                                            <select name="category_child" id="" class="form-control link-preview-category-child">
                                                <option value="">Chọn chuyên mục</option>
                                            </select>
                                        </p>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label ten-bst">Địa Điểm</label>
                                        <p class="mb10">
                                            <select name="province_id" id="link_province" class="form-control" required>
                                                <option value="0">Chọn thành phố</option>
                                                <?php foreach ($province as $vals):?>
                                                    <option value="<?php echo $vals->pre_id; ?>">
                                                        <?php echo $vals->pre_name; ?>
                                                    </option>
                                                <?php endforeach;?>
                                            </select>
                                        </p>
                                        <p>
                                            <select name="district_id" id="link_district" class="form-control">
                                                <option value="0">Chọn quận/huyện</option>
                                            </select>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="shareModal-footer">
                        <div class="permision"></div>
                        <div class="buttons-direct">
                            <button class="btn-cancle" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn-share">Xử lý</button>
                        </div>
                    </div>
                </div>
                <!-- End modal-footer -->
            </div>
        </div>
    </div>
    <!-- End The Modal -->
</form>
<!-- End Add Link Modal -->

<!-- Edit Link Modal -->
<form action="" method="POST" class="edit_link" enctype="multipart/form-data">
    <div class="modal" id="editLink">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-sm slideInUp-animated">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><img src="/templates/home/styles/images/svg/link02.svg" class="mr10 mt02">Thêm liên kết</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="addLinks-content">
                        <div class="row">
                            <div class="col-xl-5">
                                <div class="addLinks-content-img">
                                    <img src="/templates/home/styles/images/hinhanh/03.jpg" class="object-fit-cover link-preview-image" style="width: auto;">
                                    <a class="edit" href=""><img src="/templates/home/styles/images/svg/pen.svg" class="mr05" width="20">Đổi
                                        ảnh, video</a>
                                    <input class="edit" type="file" name="link_file" accept="image/*,video/mp4,video/x-m4v,video/*">
                                </div>
                            </div>
                            <div class="col-xl-7">
                                <div class="addLinks-content-form">
                                    <input type="hidden" name="link" class="get_link" value="">
                                    <input type="hidden" name="link_image" class="get_image" value="">
                                    <div class="form-group">
                                        <label class="col-form-label ten-bst">Tên bộ sưu tập</label>
                                        <input type="text" name="title" placeholder="Text demo mô tả liên kết" class="form-control link-preview-title" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label ten-bst">Mô tả</label>
                                        <input type="text" name="description" placeholder="Text demo mô tả liên kết" class="form-control link-preview-description">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label ten-bst">Sắp xếp</label>
                                        <input type="text" name="sort_order" placeholder="" class="form-control link-preview-sort-order" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label ten-bst">Chuyên mục</label>
                                        <p class="mb10">
                                            <select name="category" id="" class="form-control link-preview-category" required>
                                                <option value="">Chọn chuyên mục</option>
                                            </select>
                                        </p>
                                        <p>
                                            <select name="category_child" id="" class="form-control link-preview-category-child">
                                                <option value="">Chọn chuyên mục</option>
                                            </select>
                                        </p>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label ten-bst">Địa Điểm</label>
                                        <p class="mb10">
                                            <select name="edit_province_id" id="edit_link_province" class="form-control" required>
                                                <option value="0">Chọn thành phố</option>
                                                <?php foreach ($province as $vals):?>
                                                    <option value="<?php echo $vals->pre_id; ?>">
                                                        <?php echo $vals->pre_name; ?>
                                                    </option>
                                                <?php endforeach;?>
                                            </select>
                                        </p>
                                        <p>
                                            <select name="edit_district_id" id="edit_link_district" class="form-control">
                                                <option value="0">Chọn quận/huyện</option>
                                            </select>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="shareModal-footer">
                        <div class="permision"></div>
                        <div class="buttons-direct">
                            <button class="btn-cancle" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn-share">Xử lý</button>
                        </div>
                    </div>
                </div>
                <!-- End modal-footer -->
            </div>
        </div>
    </div>
    <!-- End The Modal -->
</form>
<!-- End Add Link Modal -->

<script>
    $('body').on('click', '.link-preview-submit', function (e) {
        var link_preview = $('.link-preview-form').find('.link-preview').val();

        if (link_preview) {
            $.ajax({
                url: '/azi-admin/entertainment-link/get-link-preview',
                type: 'POST',
                dataType: 'json',
                data: {
                    link: link_preview
                }
            }).done(function(response) {
                if (response.status == 1) {
                    console.log(response);

                    $('.link-preview-image').attr('src', response.data.image);
                    $('.get_image').val(response.data.image);
                    $('.link-preview-title').val(response.data.title);
                    $('.link-preview-description').val(response.data.description);
                    $('.link-preview-sort-order').val(response.data.sort_order);

                    $.each(response.category, function(index, item) {
                        $('.link-preview-category').append('<option value="' + item.id +'">' + item.name  + '</option>');

                        $.each(item.children, function(indexChild, itemChild) {
                            $('.link-preview-category-child').append('<option style="display: none" data-parent="'+item.id+'" value="' + itemChild.id +'">' + itemChild.name  + '</option>');
                        });
                    });

                    $('#addLinks02').modal('show');
                    $('.get_link').val(link_preview);
                } else if (response.status == 0) {
                    alert('Can not get info of link.')
                }

            });
        }
    });

    $('body').on('change', '.link-preview-category', function (e) {
        if ($(this).val()) {
            var parent_id = $(this).val();
            $('.link-preview-category-child').val('');
            $('.link-preview-category-child option').each(function(){
                if ($(this).val()) {
                    if ($(this).data('parent') == parent_id) {
                        $(this).css('display', 'block');
                    } else {
                        $(this).css('display', 'none');
                    }
                } else {
                    $(this).attr('selected', 'selected');
                }
            });
        }
    });

    $("#link_province").on('change', function() {
        if ($("#link_province").val() != 0) {
          $.ajax({
              url: siteUrl + 'ajax_district',
              type: "POST",
              data: {province_id: $("#link_province").val()},
              success: function (response) {
                if (response) {
                  var json = JSON.parse(response);
                  var html_option = '<option value="0">Chọn quận/huyện</option>';
                  $(json).each(function(at, item){
                    html_option += '<option value="'+item.id+'">'+item.DistrictName+'</option>';
                  });
                  $('#link_district').html(html_option);
                  delete json;
                } else {
                  alert("Lỗi! Vui lòng thử lại");
                }
              },
              error: function () {
                alert("Lỗi! Vui lòng thử lại");
              }
          });
        }
    });

    $("#edit_link_province").on('change', function() {
        if ($("#edit_link_province").val() !=0) {
          $.ajax({
              url: siteUrl + 'ajax_district',
              type: "POST",
              data: {province_id: $("#edit_link_province").val()},
              success: function (response) {
                if (response) {
                  var json = JSON.parse(response);
                  var html_option = '<option value="0">Chọn quận/huyện</option>';

                  var district_id = 0;
                  var district_attr = $('#edit_link_district').attr('district_id');
                  
                  if (typeof district_attr !== typeof undefined && district_attr !== false)
                  {
                    district_id = district_attr;
                  }
                  
                  $(json).each(function(at, item){
                    if(district_id == item.id) 
                    {
                        html_option += '<option value="'+item.id+'" selected="selected">'+item.DistrictName+'</option>';
                    } 
                    else 
                    {
                        html_option += '<option value="'+item.id+'">'+item.DistrictName+'</option>';
                    }
                  });
                  $('#edit_link_district').removeAttr("district_id");
                  $('#edit_link_district').html(html_option);
                  delete json;
                } else {
                  alert("Lỗi! Vui lòng thử lại");
                }
              },
              error: function () {
                alert("Lỗi! Vui lòng thử lại");
              }
          });
        }
    });

    $('body').on('click', '.edit-link', function (e) {
        var id = $(this).data('id');
        var url_action = "<?php echo base_url() .'azi-admin/entertainment-link/edit/' ?>" + id;

        if (id) {
            $.ajax({
                url: '/azi-admin/entertainment-link/get-by-id/' + id,
                type: 'GET',
                dataType: 'json',
            }).done(function(response) {
                if (response.status == 1) {
                    $('.edit_link').attr('action', url_action);
                    var image = response.link.image;
                    if (!response.link.image) {
                        image = response.link.image_default;
                    }
                    $('.edit_link .link-preview-image').attr('src', image);
                    $('.edit_link .get_link').val(response.link.entertainment_link.link);
                    $('.edit_link .get_image').val(response.link.image);
                    $('.edit_link .link-preview-title').val(response.link.title);
                    $('.edit_link .link-preview-description').val(response.link.description);
                    $('.link-preview-sort-order').val(response.link.sort_order);
                    $('#edit_link_district').attr('district_id', response.link.district_id);
                    if (response.link.province_id != 0) 
                    {
                        $('#edit_link_province').val(response.link.province_id).trigger('change');
                    }
                    
                    $.each(response.category, function(index, item) {
                        var is_select_parent = false;
                        var selected_parent = '';

                        $.each(item.children, function(indexChild, itemChild) {
                            var selected_child = '';
                            var display_none = 'style="display: none"';

                            if (response.link.category_id == itemChild.id) {
                                is_select_parent = true;
                                selected_child = 'selected="selected"';
                            }

                            $('.edit_link .link-preview-category-child').append('<option ' + selected_child + ' ' + display_none + ' data-parent="'+item.id+'" value="' + itemChild.id +'">' + itemChild.name  + '</option>');
                        });

                        if (is_select_parent || response.link.category_id == item.id) {
                            selected_parent = 'selected="selected"';

                            $('.edit_link .link-preview-category-child option').each(function(){
                                if ($(this).val()) {
                                    if ($(this).data('parent') == item.id) {
                                        $(this).css('display', 'block');
                                    } else {
                                        $(this).css('display', 'none');
                                    }
                                }
                            });
                        }

                        $('.edit_link .link-preview-category').append('<option value="' + item.id +'" ' + selected_parent + '>' + item.name  + '</option>');
                    });

                    $('#editLink').modal('show');
                } else if (response.status == 0) {
                    alert('Can not get info of link.')
                }

            });
        }
    });  

</script>