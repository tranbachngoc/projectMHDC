<script>
  // $('body').addClass('fixed-modal-ios');
</script>
<script>

  /** 
  // tạo Album ẢNH
  A - file up từ thiết bị
  B - chọn hình từ thư viện
  {{src_img}}    A - base64(dùng để xử lý uplead hình), B - full path img
  {{data_size}}  A - size MB(dùng để check MB tối da của tổng file), B - false
  {{data_check}}  A - false, B - id của hình ||
  {{data_avatar}} Dùng để xác nhận ảnh đại diện album
  {{data_from}}  A - input, B - library
  {{data_imgtitle}}  A - '', B - tiêu đề bài viết chứa ảnh đó
  {{data_disabled}}  A - false, B - disabled
  {{data_index}}  A - key item của data_input ,B - 'false'
  {{data-imgupdetect}} A - False, B - 1|đối với up len từ thiết bị trong lúc tạo album ảnh - 0|đối với ảnh trong bài viết
  */
  var max_file_upload = 30;
  var data_input = []; // data image upload
  var data_img_lib = []; // data image library
  var data_sub_input_upload = []; // data input đã đc khởi tạo trong lần album trước đó đc update thêm title
  var index = 0; // key item của data_input
  var album_ava = ''; // data của avata album
  var album_from = ''; // data album_ava từ input hay từ library
  var album_name = '';
  var album_des = '';
  var album_permission = 1;
  var album_type = '<?=ALBUM_IMAGE?>';
  var css_select = {
    'border': '1px solid red',
    'border-radius': '5px'
  };
  var css_not_select = {
    'border': 'none',
    'border-radius': 'none'
  };

  function isBlank(data) {
    return ($.trim(data).length == 0);
  }

  // mở popup tạo album ảnh trong thư viện ảnh
  $('.js-open-pop-img').click(function () {
    $('body').addClass('fixed-modal-ios');
    $('.modal').modal('hide');
    $('.js-popup-album-img').modal('show');
  });

  // mở popup chọn các ảnh trong thư viên ảnh
  $('.js-open-pop-img-from-lib').click(function () {
    $('.modal').modal('hide');
    $('.js-popup-select-library').modal('show');
  });

  // đóng tất cả modal
  $('.modal .close').click(function () {
    $('body').removeClass('fixed-modal-ios');
  });

  // đóng popup tạo album ảnh
  $('.js-popup-album-img .js-popup-album-cancel').click(function () {
    $('.modal').modal('hide');
    $('body').removeClass('fixed-modal-ios');
  });

  // xử lý ảnh úp lên từ thiết bị -> image_name
  $('input[name="img_upload"]').change(function (event) {
    function readAndPreview(file, i, max_i) {
      var reader = new FileReader();
      reader.onload = function (e) {
        var formData = new FormData();
        formData.set('image', file, file.name);
        $.ajax({
          type: "post",
          url: siteUrl + "library/album-image/upImage",
          data: formData,
          processData: false,
          contentType: false,
          success:function(data){
            if(i == max_i -1){
              $('.load-wrapp').hide();
            }
            data = JSON.parse(data);
            if(data.error == false) {
              data_input[index] = {
                dataImg: data.image_name,
                dataImg_w: data.image_w,
                dataImg_h: data.image_h,
                dataType: data.image_type,
                };
              var appendData = templateHtml
              .replace('{{src_img}}', data.image_url)
              .replace('{{data_check}}', 'false')
              .replace('{{data_avatar}}', data.image_name)
              .replace('{{data_from}}', 'input')
              .replace('{{data_imgtitle}}', '')
              .replace('{{data_disabled}}', '')
              .replace('{{data_index}}', index)
              .replace('{{data_imgUpDetect}}', 'false');

              $('.js-popup-album-img .showImagesAlbum').prepend(appendData);
              index++;
              max_file_upload--;
            } else {
              alert(data.message);
            }
          }
        });
      }
      reader.readAsDataURL(file);
    }

    var templateHtml = $('#item-img-selected').html();
    // var listHtml = '';
    var listFile = this.files;
    if (listFile && listFile[0] && listFile.length <= max_file_upload) {
      $('.load-wrapp').show();
      for (var i = 0; i < listFile.length; i++) {
        readAndPreview(listFile[i], i, listFile.length);
      }
      $(this).val('');
      reset_set_avatar();
    } else {
      alert('số lượng hình có thể tải lên ' + max_file_upload);
      event.stopPropagation();
    }
  });

  // xóa ảnh được chọn để chuẩn bị tạo bộ sưu tập
  $('.js-popup-album-img').on('click', '.act-close', function () {
    var funct_uncheck_lib = function (param) {
      var check_id = $(item).find('.data-image-upload').attr('data-check');
      var _uncheck = $('.js-popup-select-library').find('.js-item-click-check[data-check="'+check_id+'"]');
      _uncheck.attr('data-selected','false');
      _uncheck.find('.icon-checked img').attr('src', '/templates/home/styles/images/svg/check.svg');
    }

    var item = $(this).closest(".col-item");
    // item img trong library lấy từ bài viết
    if ($(item).find('.data-image-upload').attr('data-check') !== 'false'
      && $(item).find('.data-image-upload').attr('data-imgupdetect') != 'false'
      && $(item).find('.data-image-upload').attr('data-imgupdetect') == '<?=IMAGE_UP_DETECT_CONTENT?>') {
      var val = $(item).find('.data-image-upload').attr('data-check');
      data_img_lib.filter(function (v, i) {
        if (parseInt(val) == parseInt(v))
          delete data_img_lib[i];
      });
      funct_uncheck_lib(item);
    }
    // item img trong library lấy từ thiết bị
    else if ($(item).find('.data-image-upload').attr('data-check') != 'false'
      && $(item).find('.data-image-upload').attr('data-imgupdetect') != 'false'
      && $(item).find('.data-image-upload').attr('data-imgupdetect') == '<?=IMAGE_UP_DETECT_LIBRARY?>') {
      var key = $(item).find('.data-image-upload').attr('data-check');
      delete data_sub_input_upload[key];
      funct_uncheck_lib(item);
    }
    // item được up lên từ thiết bị
    else {
      var key = parseInt(item.find('.data-image-upload').attr('data-index'));
      delete data_input[key];
      max_file_upload++;
    }
    $(item).closest(".col-item").remove();
  });

  // chon ảnh đại diện album 
  $('.js-popup-album-img').on('click', '.act-setavatar', function () {
    if ($(this).attr('data-setavatar') == 'false') {
      album_ava = $(this).attr('data-avatar');
      album_from = $(this).attr('data-from');
      $('.js-popup-album-img').find('.act-setavatar').hide();
      $(this).show();
      $(this).attr('data-setavatar', 'true');
      $(this).closest('.action').find('.act-close').hide();

      // css cho hình được chọn làm ảnh album
      $(this).closest("div.img").css(css_select);
    } else {
      album_ava = album_from = '';
      $('.js-popup-album-img').find('.act-setavatar').show();
      $(this).attr('data-setavatar', 'false');
      $(this).closest('.action').find('.act-close').show();

      // remove css cho hình được chọn làm ảnh album
      $(this).closest("div.img").css(css_not_select);
    }

  })

  // chọn hình từ thư viện ảnh
  $('.js-popup-select-library').on('click', '.js-item-click-check', function () {
    var selected = $(this).attr('data-selected');
    if (selected === 'false') {
      $(this).attr('data-selected', 'true');
      $(this).find('.icon-checked img').attr('src', '/templates/home/styles/images/svg/checked.svg');
    } else if (selected === 'true') {
      $(this).attr('data-selected', 'false');
      $(this).find('.icon-checked img').attr('src', '/templates/home/styles/images/svg/check.svg');
    }
  })

  // đóng popup chọn ảnh trong thư viện
  $('.js-popup-select-library-cancel').click(function () {
    $('.modal').modal('hide');
    $('.js-popup-album-img').modal('show');
  });

  // thay đổi permission album default = public = 1
  $('.js-popup-album-img input[name="album_permission"]').change(function () {
    album_permission = $(this).val();
    var text = $(this).attr('data-text');
    $('.js-popup-album-img .permision span.show-permision').text(text);
  });

  // Xác nhận các hình đã chọn trong thư viện ảnh đẩy ra ngoài để chuẩn bị tạo album ảnh
  $('.js-popup-select-library-select').click(function () {
    // lấy template
    var templateHtml = $('#item-img-selected').html();
    // remove các img đã chon trước đó trong thư viện ảnh
    var arr_temp = $('.js-popup-album-img').find('.showImagesAlbum .col-item');
    if (arr_temp.length > 0) {
      arr_temp.each(function (index, value) {
        if ($(value).find('.data-image-upload').attr('data-check') !== 'false') {
          $(value).remove();
        }
      });
      reset_set_avatar();
    }

    // thêm/ cập nhập image mới
    var element = $('.js-popup-select-library').find('.js-item-click-check[data-selected="true"]');
    if (element.length > 0) {
      // set empty array
      data_img_lib = [];
      element.each(function (i, v) {
        data_img_lib.push($(v).attr('data-check'));
        var disable = 'disabled';
        if ($(v).attr('data-imgupdetect') == "<?=IMAGE_UP_DETECT_LIBRARY?>") {
          disable = '';
        }
        $('.js-popup-album-img .showImagesAlbum').prepend(templateHtml
          .replace('{{src_img}}', $(v).attr('data-img'))
          .replace('{{data_check}}', $(v).attr('data-check')) //id của hình có trong l library
          .replace('{{data_avatar}}', $(v).attr('data-check'))
          .replace('{{data_from}}', 'library')
          .replace('{{data_imgtitle}}', $(v).attr('data-imgtitle'))
          .replace('{{data_disabled}}', disable)
          .replace('{{data_index}}', 'false')
          .replace('{{data_imgUpDetect}}', $(v).attr('data-imgupdetect')));
      })
    }

    // reset chọn ảnh đại diện album
    // reset_set_avatar();

    $('.modal').modal('hide');
    $('.js-popup-album-img').modal('show');
  });

  function reset_set_avatar() {
    album_ava = album_from = '';
    $('body').find('.showImagesAlbum .col-item .action .act-setavatar').show();
    $('body').find('.showImagesAlbum .col-item .action .act-close').show();
    $('body').find('.showImagesAlbum .col-item div.img').css(css_not_select);
  }

  // xử lý data album
  $('.js-popup-album-img-create').click(function (event) {
    $('.load-wrapp').show();
    album_name = $('.js-popup-album-img').find('input[name="album_name"]').val();
    album_des = $('.js-popup-album-img').find('textarea[name="album_des"]').val();

    if (isBlank(album_name)) {
      alert("Tên album không được trống");
      $('.load-wrapp').hide();
      event.stopPropagation();
      return false;
    }

    if (data_input.length == 0 && data_img_lib.length == 0) {
      alert("Chưa có ảnh trong album");
      $('.load-wrapp').hide();
      event.stopPropagation();
      return false;
    }

    if (isBlank(album_ava) || isBlank(album_from)) {
      alert("Chưa chọn ảnh đại diện album");
      $('.load-wrapp').hide();
      event.stopPropagation();
      return false;
    }

    var items = $('.js-popup-album-img').find('.showImagesAlbum .col-item');
    if (items.length > 0) {
      items.each(function (index, value) {
        if ($(value).find('.data-image-upload').attr('data-check') == 'false') {
          var key = $(value).find('.data-image-upload').attr('data-index');
          var title = $(value).find('textarea').val();
          data_input[key].dataTitle = title;
        }
        if ($(value).find('.data-image-upload').attr('data-check') != 'false'
          && $(value).find('.data-image-upload').attr('data-imgupdetect') != 'false'
          && $(value).find('.data-image-upload').attr('data-imgupdetect') == '<?=IMAGE_UP_DETECT_LIBRARY?>') {
          var key = $(value).find('.data-image-upload').attr('data-check');
          var title = $(value).find('textarea').val();
          data_sub_input_upload[key] = {'title': title, 'id': key};
        }
      })
    }

    //build data ajax
    var formData = new FormData();
    //rebuild array clear elememt empty when use keyword's keyword
    __data_input = data_input.filter(function (item) {
      return item;
    })
    __data_img_lib = data_img_lib.filter(function (item) {
      return item;
    })
    __data_sub_input_upload = data_sub_input_upload.filter(function (item) {
      return item;
    })
    // build data request
    formData.append('data_input', JSON.stringify(__data_input));
    formData.append('data_img_lib', JSON.stringify(__data_img_lib));
    formData.append('data_sub_input_upload', JSON.stringify(__data_sub_input_upload));
    formData.append('album_ava', album_ava);
    formData.append('album_from', album_from);
    formData.append('album_name', album_name);
    formData.append('album_des', album_des);
    formData.append('album_permission', album_permission);
    formData.append('album_type', album_type);

    $.ajax({
      type: "post",
      url: siteUrl + "library/album-image/create",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if(response == 1) {
          window.location.reload();
        } else {
          $('.load-wrapp').hide();
          alert('Errors Connection!!!');
        }
      }
    });
  });

  // scroll append data pop library
  var __is_busy = false;
  var __stopped = false;
  $('.js-popup-select-library .block-content').scroll(function (event) {
    if ($(this).scrollTop() + $(this).find('.col-item').height() >= $(this).height()) {
      var __page = parseInt($(this).attr('data-page')) ;
      if (__is_busy == true) {
        event.stopPropagation();
        return false;
      }
      if (__stopped == true) {
        event.stopPropagation();
        return false;
      }
      //   $loadding.removeClass('hidden');
      __is_busy = true;
      __page++;

      $.ajax({
        type: 'post',
        dataType: 'html',
        url: siteUrl + 'library/album-image/load-img-lib',
        data: { page: __page , typeIMG: '<?=IMAGE_UP_DETECT_CONTENT?>'},
        success: function (result) {
          // console.log(result);

          // $loadding.addClass('hidden');
          if (result == '') {
            __stopped = true;
          }
          if (result) {
            $('.js-popup-select-library .block-content').append(result);
            $('.js-popup-select-library .block-content').attr('data-page',__page)
          }
        }
      }).always(function () {
        __is_busy = false;
      });
      return false;
    }
  });

  $('.js-popup-select-library .block-upload').scroll(function (event) {
    if ($(this).scrollTop() + $(this).find('.col-item').height() >= $(this).height()) {
      var __page = parseInt($(this).attr('data-page')) ;
      if (__is_busy == true) {
        event.stopPropagation();
        return false;
      }
      if (__stopped == true) {
        event.stopPropagation();
        return false;
      }
      //   $loadding.removeClass('hidden');
      __is_busy = true;
      __page++;

      $.ajax({
        type: 'post',
        dataType: 'html',
        url: siteUrl + 'library/album-image/load-img-lib',
        data: { page: __page , typeIMG: '<?=IMAGE_UP_DETECT_LIBRARY?>'},
        success: function (result) {
          // console.log(result);

          // $loadding.addClass('hidden');
          if (result == '') {
            __stopped = true;
          }
          if (result) {
            $('.js-popup-select-library .block-upload').append(result);
            $('.js-popup-select-library .block-upload').attr('data-page',__page);
          }
        }
      }).always(function () {
        __is_busy = false;
      });
      return false;
    }
  });

  // show/hide div
  $('.js-popup-select-library').on('click', '.js-filter-content', function () {
    if($(this).hasClass('no-bg')) {
      $(this).removeClass('no-bg');
      $(this).next().addClass('no-bg');
    }
    $('.block-content').css({'display': 'flex'});
    $('.block-upload').css({'display': 'none'});
    __is_busy = false;
    __stopped = false;
  })

  $('.js-popup-select-library').on('click', '.js-filter-upload', function () {
    if($(this).hasClass('no-bg')) {
      $(this).removeClass('no-bg');
      $(this).prev().addClass('no-bg');
    }
    $('.block-content').css({'display': 'none'});
    $('.block-upload').css({'display': 'flex'});
    __is_busy = false;
    __stopped = false;
  })
</script>

<script>
  var album_id = '';
  var album_offset = '';
  $('.js-menu-album').on('click', function() {
    var album_id = $(this).attr('data-albumid');
    var album_offset = $(this).attr('data-offset');
    var template_menu = $('#data-process-item-menu-album').html();
    $('.js-album_offset-process-menu-album').html(template_menu.replace('{{data_albumId}}', album_id)
      .replace('{{data_albumOffSet}}', album_offset));
    $('.js-popup-menu-album').modal('show');
  })

  function setDataCurrentAlbum(){
    /*
    data-albumId
    data-albumOffSet
    */
    var item = $('.js-popup-menu-album').find('.data-current-album');
    album_id = item.attr('data-albumId');
    album_offset = item.attr('data-albumOffSet');
  }

  // set album lên vị trí đầu
  $('.js-act-set-top').on('click', function() {
    $('.load-wrapp').show();
    setDataCurrentAlbum();
    var formData = new FormData();
    formData.append('album_id', album_id);
    formData.append('album_offset', album_offset);
    formData.append('album_type', album_type);

    $.ajax({
      type: "post",
      url: siteUrl + "library/album-image/off-set",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if(response == 1) {
          window.location.reload();
        } else {
          $('.load-wrapp').hide();
          alert('Errors Connection!!!');
        }
      }
    });
  })

  // show popup alert comfirm khi chọn xóa album
  $('.js-act-del-album').on('click', function () {
    $('.modal').modal('hide');
    $('.js-comfirm-delete').show().next().hide();
    var detail_alert = "Bạn có chắc chọn xóa album này ?";
    $('.js-popup-alert').find('p.des-alert').html(detail_alert);
    $('.js-popup-alert').find('.js-comfirm-delete').attr('data-deleteFor','ALBUM');
    $('.js-popup-alert').modal('show');
  })

  // confirm cancel
  $('.js-comfirm-cancel').on('click', function () {
    $('.modal').modal('hide');
  })

  // confirm delete
  $('.js-comfirm-delete').on('click', function () {
    $('.load-wrapp').show();
    if($(this).attr('data-deleteFor') == 'ALBUM'){
      setDataCurrentAlbum();
      var formData = new FormData();
      formData.append('album_id', album_id);
      formData.append('album_type', album_type);

      $.ajax({
        type: "post",
        url: siteUrl + "library/album-image/delete-album",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          if(response == 1) {
            window.location.reload();
          } else {
            $('.load-wrapp').hide();
            alert('Errors Connection!!!');
          }
        }
      });
    }

    if($(this).attr('data-deleteFor') == 'IMAGE'){
      img_id = $(this).attr('data-imgid');
      var formData = new FormData();
      formData.append('img_id' ,img_id);

      $.ajax({
        type: "post",
        url: siteUrl + "library/album-image/remove-item-library",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if(response == 1) {
            window.location.reload();
          } else {
            $('.load-wrapp').hide();
            alert('Errors Connection!!!');
          }
        }
      });
    }
  })

  // Load popup edit album
  $('.js-act-edit-album').on('click', function () {
    $('.load-wrapp').show();
    setDataCurrentAlbum();

    var formData = new FormData();
    formData.append('album_id', album_id);
    formData.append('album_type', album_type);

    $.ajax({
      type: "post",
      url: siteUrl + "library/album-image/getInfoAlbum",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if(response != '') {
          $('body').addClass('fixed-modal-ios');
          $('body').find('.load-album-edit').html(response);
          $('.modal').modal('hide');
          $('.js-edit-album-img').modal('show');
          $('.load-wrapp').hide();
        } else {
          $('.load-wrapp').hide();
          alert('Errors Connection!!!');
        }
      }
    });
  })

</script>

<script>
  var img_id = 0;
  $('body').on('click', '.js-ghim-album', function () {
    $('.load-wrapp').show();
    img_id = $(this).attr('data-id');
    $.ajax({
      type: 'post',
      dataType: 'html',
      url: siteUrl + 'library/album-image/openPopupGhim',
      data: { img_id: img_id, album_type: album_type},
      success: function (response) {
        if(response == '') {
          $('.load-wrapp').hide();
          alert('Chưa có Album được tạo !!!');
        } else if(response != '') {
          $('.load-popup-ghim').html(response);
          $('.js-popup-ghim').modal('show');
          $('.load-wrapp').hide();
        } else {
          $('.load-wrapp').hide();
          alert('Errors Connection!!!');
        }
      }
    })
  })

  $('body').on('click', '.js-delete-img-upload', function () {
    $('.js-comfirm-delete').show().next().hide();
    var detail_alert = "Bạn có chắc chọn xóa Ảnh này ra khỏi thư viện ảnh?";
    $('.js-popup-alert').find('p.des-alert').html(detail_alert);
    $('.js-popup-alert').find('.js-comfirm-delete').attr('data-deleteFor','IMAGE');
    $('.js-popup-alert').find('.js-comfirm-delete').attr('data-imgId', $(this).attr('data-id'));
    $('.js-popup-alert').modal('show');
  })

  $('body').on('click', '.js-create-album', function () {
    $('.js-comfirm-delete').hide().next().show();
    var detail_alert = "Ảnh này sẽ được dùng làm ảnh đại diện Album?";
    $('.js-popup-alert').find('p.des-alert').html(detail_alert);
    $('.js-popup-alert').find('.js-comfirm-continue').attr('data-next','ALBUM');
    $('.js-popup-alert').find('.js-comfirm-continue').attr('data-imgId', $(this).attr('data-id'));
    $('.modal').modal('hide');
    $('.js-popup-alert').modal('show');
  })

  $('.js-comfirm-continue').on('click', function () {
    img_id = $(this).attr('data-imgId');
    $('.modal').modal('hide');
    $('.js-popup-next').modal('show');
  });

  $('.js-next-cancel').on('click', function () {
    $('.modal').modal('hide');
  })

  $('.js-next-process').on('click', function () {
    next_album_name = $('.js-popup-next').find('input[name="next_album_title"]').val();
    next_album_des = $('.js-popup-next').find('textarea[name="next_album_des"]').val();

    if (isBlank(next_album_name)) {
      alert("Tên album không được trống");
      $('.load-wrapp').hide();
      event.stopPropagation();
      return false;
    }

    $('.load-wrapp').show();
    var formData = new FormData();
    formData.append('album_name', next_album_name);
    formData.append('album_description', next_album_des);
    formData.append('album_type', album_type);
    formData.append('album_permission', '<?=PERMISSION_SOCIAL_PUBLIC?>');
    formData.append('album_from', 'library');
    formData.append('album_ava', img_id);
    formData.append('data_img_lib', JSON.stringify([img_id]));

    $.ajax({
      type: "post",
      url: siteUrl + "library/album-image/create",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if(response == 1) {
          window.location.reload();
        } else {
          $('.load-wrapp').hide();
          alert('Errors Connection!!!');
        }
      }
    });
  })

</script>

<script>
  $('body').on('click', '.js-thao-tac', function () {
    $content = $(this).find('ul').html();
    $('.js-thao-tac-html').attr('data-id', $(this).find('ul').data('id'));
    $('.js-thao-tac-html').html($content);
    $('.js-popup-menu-item').modal('show');
  })
</script>