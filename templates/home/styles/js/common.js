var app = app || {};

var spBreak = 767;

app.init = function () {
  app.include_js(); // include library js
  app.menu();
  app.click_like();
  // app.switch_signup();
  app.top_more_detail_post();
  // app.dongmolienket();
  app.luottheodoi();
  app.loaihienthi();
  // app.bookmark_button();
  app.dropdowninfo();
  app.modal_fixed_body();
  app.accordion_search();
};

app.isMobile = function () {

  return window.matchMedia('(max-width: ' + spBreak + 'px)').matches;

};

app.isOldIE = function () {

  return $('html.ie9').length || $('html.ie10').length;

};

app.menu = function () {
  $('.drawer-hamburger').on('click', function () {
    $(this).toggleClass('active');
    if ($(this).hasClass('active')) {
      $('.sm-gnav').addClass('is-open');
    } else {
      $('.sm-gnav').removeClass('is-open');
    }
  });
};

app.click_like = function () {
  $('body').on('click', '.js-like-content', function(e){
    e.preventDefault();
    $('#modal_mess .modal-body p').html('');
    var id_content = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type:'POST',
      url:siteUrl +'like/content',
      dataType: 'json',
      data:{id_content: id_content},
      success:function(result){
        if(result.like == false && result.user == false){
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html('Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này');
        }
        else
        {
          if (result.error == false) {
            var img_like = $(_this).find('img');
            if (result.like == true) {
              $(img_like).attr('src', $(img_like).attr('data-like-icon'));
              $('.js-like-content-' + id_content+' span').text('Bỏ thích');
              $('.js-countact-content-' + id_content).attr('style','');
              $('.list-like-js-'+id_content).attr('style','');
            } else {
              $(img_like).attr('src', $(img_like).attr('data-notlike-icon'));
              $('.js-like-content-' + id_content+' span').text('Thích');
              // $('.js-countact-content-' + id_content).attr('style','display: none;');
              if(result.total == 0){
                $('.js-countact-content-' + id_content).css('display', 'none');
                $('.list-like-js-'+id_content).css('display', 'none');
              }
            }
            if (result.total == 0) {
              $('.list-like-js-'+id_content).attr('class','list-like-js-'+id_content);
            }else{
              $('.list-like-js-'+id_content).attr('class','list-like-js-'+id_content+' js-show-like');
            }
          }
          if (result.total != undefined) {
            $('body').find('.js-count-like-' + id_content). text(result.total);
          }
        }
      }
    });
  });

  $('body').on('click', '.js-like-product', function(){
    $('#modal_mess .modal-body p').html('');
    var id_pro = $(this).attr('data-id');
    var _this = $(this);
    var display_js_countact = $('.js-countact-product-' + id_pro).attr('style');
    $.ajax({
      type: 'POST',
      url: urlFile +'like/product',
      dataType: 'json',
      data: {id_pro: id_pro},
      success: function(result){
        if(result.like == false && result.user == false){
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html('Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này');
        }
        else
        {
          if (result.error == false) {
            var img_like = $(_this).find('img');
            var change_all_img = parseInt(img_like.attr('data-change-all-proid'));
            if (result.like == true) {
              if(change_all_img > 0){
                $('body').find('img[data-change-all-proid="'+id_pro+'"]').attr('src', $(img_like).attr('data-like-icon'));
              } else {
                $(img_like).attr('src', $(img_like).attr('data-like-icon'));
                $('.js-like-product-' + id_pro+' span').text('Bỏ thích');
                $('.list-like-js-'+id_pro).attr('style','');
                $('.list-like-js-'+id_pro).addClass('js-show-like-product');
              }
              $('.js-countact-product-' + id_pro).attr('style','');
            } else {
              if(change_all_img > 0){
                $('body').find('img[data-change-all-proid="'+id_pro+'"]').attr('src', $(img_like).attr('data-notlike-icon'));
              }else{

                $(img_like).attr('src', $(img_like).attr('data-notlike-icon'));
                $('.js-like-product-' + id_pro+' span').text('Thích');

                if(result.total == 0){
                  $('.js-countact-product-' + id_pro).css('display', 'none');
                  $('.list-like-js-'+id_pro).css('display', 'none');
                  $('.list-like-js-'+id_pro).removeClass('js-show-like-product');
                }
              }
            }
          }
          if (result.total != undefined) {
            $('body').find('.js-count-like-' + id_pro). text(result.total);
          }
        }
      },
      error:function(){
        alert('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.js-like-image', function(){
    $('#modal_mess .modal-body p').html('');
    var id_image = $(this).attr('data-id');
    var _this = $(this);
    var display_js_countact = $('.js-countact-image-' + id_image).attr('style');
    $.ajax({
      type: 'POST',
      url: urlFile +'like/image',
      dataType: 'json',
      data: {id_image: id_image},
      success: function(result){
        if(result.like == false && result.user == false){
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html('Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này');
        }
        else
        {
          if (result.error == false) {
            var _this = $('.js-like-image-'+id_image);
            var img_like = _this.find('img');
            if (result.like == true) {
              $(img_like).attr('src', $(img_like).attr('data-like-icon'));
              _this.find('span').text('Bỏ thích');
              $('.list-like-js-'+id_image).attr('style','');
              $('.js-countact-image-' + id_image).attr('style','');
            } else {
              $('.js-like-image-'+id_image+' img').attr('src', '/templates/home/styles/images/svg/like.svg');
              $('.js-background-black .like.js-like-image img').attr('src', '/templates/home/styles/images/svg/like_white.svg');
              $('.sm .like.js-like-image img').attr('src', '/templates/home/styles/images/svg/like_white.svg');
              _this.find('span').text('Thích');
              if(result.total == 0){
                $('.list-like-js-'+id_image).css('display', 'none');
                $('.js-countact-image-' + id_image).css('display', 'none');
              }
              //$(img_like).attr('src', $(img_like).attr('data-notlike-icon'));
            }

            if(result.total == 0){
              $('.list-like-js-'+id_image).css('display', 'none');
              $('.js-countact-image-' + id_image).css('display', 'none');
            }

            if (result.total == 0) {
              $('.list-like-js').attr('class','list-like-js');
              $('.list-like-js-'+id_image).attr('class','cursor-pointer list-like-js-'+id_image);
            }else{
              $('.list-like-js').attr('class','list-like-js js-show-like-image');
              $('.list-like-js-'+id_image).attr('class','list-like-js-'+id_image+' js-show-like-image cursor-pointer');
            }
          }
          if (result.total != undefined) {
            $('body').find('.js-count-like-' + id_image). text(result.total);
          }
        }
      },
      error:function(){
        alert('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.js-like-gallery', function(){
    $('#modal_mess .modal-body p').html('');
    var id_image = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type: 'POST',
      url: urlFile +'like/gallery',
      dataType: 'json',
      data: {id_image: id_image},
      success: function(result){
        if(result.like == false && result.user == false){
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html('Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này');
        }
        else
        {
          if (result.error == false) {
            // var img_like = $(_this).find('img');
            var img_like = $('.js-like-gallery').find('img');
            if (result.like == true) {
              $(img_like).attr('src', $(img_like).attr('data-like-icon'));
              $('.js-countact-gallery-' + id_image).attr('style', '');
            } else {
              $('.col-lg-5 .like.js-like-gallery img').attr('src', '/templates/home/styles/images/svg/like.svg');
              $('.col-lg-7 .like.js-like-gallery img').attr('src', '/templates/home/styles/images/svg/like_white.svg');
              // $(img_like).attr('src', $(img_like).attr('data-notlike-icon'));
              if (result.total == 0) {
                $('.js-countact-gallery-' + id_image).css('display', 'none');
              }
            }
            if (result.total == 0) {
              $('.list-like-js').attr('class','list-like-js');
            }else{
              $('.list-like-js').attr('class','list-like-js js-show-like-gallery');
            }
          }
          if (result.total != undefined) {
            $('body').find('.js-count-like-' + id_image). text(result.total);
          }
        }
      },
      error:function(){
        alert('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.js-like-video', function(){
    $('#modal_mess .modal-body p').html('');
    var id_image = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type: 'POST',
      url: urlFile +'like/video',
      dataType: 'json',
      data: {id_image: id_image},
      success: function(result){
        if(result.like == false && result.user == false){
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html('Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này');
        }
        else
        {
          if (result.error == false) {
            var _this = '.js-like-image-'+id_image;
            var img_like = $(_this).find('img');
            if (result.like == true) {
              $(img_like).attr('src', $(img_like).attr('data-like-icon'));
              $('.js-countact-video-' + id_image).attr('style', '');
              $('.list-like-js-'+id_image).attr('style','');
              $('.js-like-image-' + id_image+' span').text('Bỏ thích');
            } else {
              img_like.attr('src', '/templates/home/styles/images/svg/like.svg');
              $('.js-background-black '+_this+' img').attr('src', '/templates/home/styles/images/svg/like_white.svg');
              $('.sm .like'+_this+' img').attr('src', '/templates/home/styles/images/svg/like_white.svg');
              $('.js-like-image-' + id_image+' span').text('Thích');
              //img_like.attr('src', img_like.attr('data-notlike-icon'));
              if (result.total == 0) {
                $('.js-countact-video-' + id_image).css('display', 'none');
                $('.list-like-js-'+id_image).css('display', 'none');
              }
            }
            if (result.total == 0) {
              $('.list-like-js').attr('class','list-like-js');
              $('.list-like-js-'+id_image).attr('class','list-like-js-'+id_image);
            }else{
              $('.list-like-js').attr('class','list-like-js js-show-like-video');
              $('.list-like-js-'+id_image).attr('class','list-like-js-'+id_image+' js-show-like-video');
            }
          }
          if (result.total != undefined) {
            $('body').find('.js-count-like-' + id_image). text(result.total);
          }
        }
      },
      error:function(){
        alert('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.js-like-link', function(){
    $('#modal_mess .modal-body p').html('');
    var id_link = $(this).attr('data-id');
    var type_url = $(this).attr('data-type_url');
    var _this = $(this);
    $.ajax({
      type: 'POST',
      url: urlFile +'like/link',
      dataType: 'json',
      data: {id_link: id_link, tbl: type_url},
      success: function(result){
        if(result.like == false && result.user == false){
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html('Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này');
        }
        else
        {
          if (result.error == false) {
            var img_like = $(_this).find('img');

            if (result.like == true) {
              $(img_like).attr('src', $(img_like).attr('data-like-icon'));
              $('.js-like-link-' + id_link+' span').text('Bỏ thích');
              $('.list-like-js-'+id_link).attr('style','');
              $('.list-like-js-'+id_link).addClass('js-show-like-link');
              $('.js-countact-link-' + id_link).attr('style','');
            } else {
              $(img_like).attr('src', $(img_like).attr('data-notlike-icon'));
              $('.js-like-link-' + id_link+' span').text('Thích');

              if(result.total == 0){
                $('.js-countact-link-' + id_link).css('display', 'none');
                $('.list-like-js-'+id_link).css('display', 'none');
                $('.list-like-js-'+id_link).removeClass('js-show-like-link');
              }
            }
          }
          if (result.total != undefined) {
            $('body').find('.js-count-like-' + id_link). text(result.total);
          }
        }
      },
      error:function(){
        alert('Kết nối thất bại');
      }
    });
  });

  $('body').on('click', '.js-like-service', function(){
    $('#modal_mess .modal-body p').html('');
    var id_service = $(this).attr('data-id');
    var _this = $(this);
    $.ajax({
      type: 'POST',
      url: urlFile +'like/service',
      dataType: 'json',
      data: {id_service: id_service},
      success: function(result){
        if(result.like == false && result.user == false){
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html('Bạn phải <a href="/login"><b>đăng nhập</b></a> để thực hiện chức năng này');
        }
        else
        {
          if (result.error == false) {
            var img_like = $(_this).find('img');

            if (result.like == true) {
              $(img_like).attr('src', $(img_like).attr('data-like-icon'));
              $('.js-like-service-' + id_service+' span').text('Bỏ thích');
              $('.list-like-js-'+id_service).attr('style','');
              $('.list-like-js-'+id_service).addClass('js-show-like-service');
              $('.js-countact-service-' + id_service).attr('style','');
            } else {
              $(img_like).attr('src', $(img_like).attr('data-notlike-icon'));
              $('.js-like-service-' + id_service+' span').text('Thích');

              if(result.total == 0){
                $('.js-countact-service-' + id_service).css('display', 'none');
                $('.list-like-js-'+id_service).css('display', 'none');
                $('.list-like-js-'+id_service).removeClass('js-show-like-service');
              }
            }
          }
          if (result.total != undefined) {
            $('body').find('.js-count-like-' + id_service). text(result.total);
          }
        }
      },
      error:function(){
        alert('Kết nối thất bại');
      }
    });
  });

  $('#dialog_mess').on('hidden.bs.modal', function () {
    if($('#modal-show-detail-img').hasClass('show') == true){
      $('body').addClass(' modal-open');
    }
  });
};

app.luottheodoi = function () {
  $('.gianhangcuaban-luottheodoi p').click(function () {
    var num = $('.gianhangcuaban-luottheodoi p').index(this);
    $(".gianhangcuaban-luotthich").hide();
    $(".gianhangcuaban-luotthich").eq(num).show();
    $(".gianhangcuaban-luottheodoi p").removeClass('is-active');
    $(this).addClass('is-active');
  });
};


app.top_more_detail_post = function () {
  $('.post-head-more .icon-more').click(function () {
    $(this).toggleClass('opening');
    if ($(this).hasClass('opening')) {
      $(this).next().slideDown();
    } else {
      $(this).next().slideUp();
    }
  });
};

app.dropdowninfo = function () {
  $('.js-header-avata').click(function () {
    $('.dropdowninfo-arrow').toggleClass('opening');
    if ($('.dropdowninfo-arrow').hasClass('opening')) {
      $('.dropdowninfo-arrow').next().slideDown();
    } else {
      $('.dropdowninfo-arrow').next().slideUp();
    }
  });
  $('.dropdowninfo-arrow').click(function () {
    $(this).toggleClass('opening');
    if ($(this).hasClass('opening')) {
      $(this).next().slideDown();
    } else {
      $(this).next().slideUp();
    }
  });
  $('.search-click').click(function () {
    $(this).toggleClass('opening');
    var parent = $(this).closest('.f-gnav');
    if ($(this).hasClass('opening')) {
      parent.next().slideDown();
    } else {
      parent.next().slideUp();
    }
  });
  $('.kiemtradonhang').click(function () {
    $(this).toggleClass('opening');
    var parent = $(this).closest('.f-gnav');
    if ($(this).hasClass('opening')) {
      $(this).next().slideDown();
    } else {
      $(this).next().slideUp();
    }
  });
}
app.bookmark_button = function () {
  $('.bookmark-button').click(function () {
    $(this).toggleClass('opening');
    if ($(this).hasClass('opening')) {
      $(this).parents('.action').find('.bosuutap-show-action').slideDown();
    } else {
      $(this).parents('.action').find('.bosuutap-show-action').slideUp();
    }
  });
};

app.dongmolienket = function () {
  // Dong mo lien ket
  $('.open-close-link').click(function () {
    var parent = $(this).closest('.list-slider');
    $(this).toggleClass('opened');
    if ($(this).hasClass('opened')) {
      parent.find('.addlinkthem').addClass('is-active');
      $(this).text('Đóng liên kết');
    } else {
      $(this).text('Mở liên kết');
      parent.find('.addlinkthem').removeClass('is-active');
    }
  });
}

app.modal_fixed_body = function () {
  var $window = $(window),
    $body = $("body"),
    $modal = $(".modal"),
    scrollDistance = 0;

  $modal.on("show.bs.modal", function () {
    // Get the scroll distance at the time the modal was opened
    scrollDistance = $window.scrollTop();

    // Pull the top of the body up by that amount
    $body.css("top", scrollDistance * -1);
  });
  $modal.on("hidden.bs.modal", function () {
    // Remove the negative top value on the body
    $body.css("top", "");

    // Set the window's scroll position back to what it was before the modal was opened
    $window.scrollTop(scrollDistance);
  });
};

app.loaihienthi = function () {
  $('.xem-dang-danh-sach').click(function () {
    $(this).toggleClass('dangluoi');
    if ($(this).hasClass('dangluoi')) {
      $('body').find('.bosuutap-tabbosuutap-xemluoi').addClass('danhsach');
      $(this).find('img').attr("src", "/templates/home/styles/images/svg/danhsach_on.svg");
    } else {
      $('body').find('.bosuutap-tabbosuutap-xemluoi').removeClass('danhsach');
      $(this).find('img').attr("src", "/templates/home/styles/images/svg/xemluoi_on.svg");
    }
  });
};

app.accordion_search = function () {
  var $accordion = $(".js-accordion");
  var $allPanels = $(" .accordion-panel").hide();
  var $allItems = $(".accordion-item");

  // Event listeners
  $accordion.on("click", ".accordion-toggle", function() {
      // Toggle the current accordion panel and close others
      $allPanels.slideUp();
      $allItems.removeClass("is-open");
      if (
          $(this)
              .next()
              .is(":visible")
      ) {
          $(".accordion-panel").slideUp();
      } else {
          $(this)
              .next()
              .slideDown()
              .closest(".accordion-item")
              .addClass("is-open");
      }
    return false;
  });
};

$(function () {

  app.init();

});

(function ($) {
  $._loading = function (status, selector) {
    selector = typeof selector !== 'undefined' ? selector : 'body';
    if (typeof status !== 'undefined' && status !== 'show' && !$(selector).hasClass('_loading')) {
      $('#loader').parent().removeClass('_loading');
      $('#loader').remove();
    }
    if (typeof status !== 'undefined' && status === 'show' && !$('#loader').length) {
      $(selector).addClass('_loading').append('<div id="loader" class="hidden"><span></span></div>');
    }
    if (typeof status !== 'undefined' && status === 'show'){
        document.getElementById('loader').classList.remove("hidden");
    } else{
        document.getElementById('loader').classList.add("hidden");
    }
  };
})(jQuery);

function copylink(link) {
  if (typeof clipboard !== 'undefined') {
    clipboard.copy(link);
    $('#modal_mess .modal-body p').text('Sao chép liên kết thành công');
  }
}

function limit_the_string(text, limit)
{
    if(typeof limit === 'undefined')
        limit = 60;
    if(typeof text !== 'string' || !text)
        return false;
    if (text.length < limit)
        return text;
    return text.replace(RegExp('^(.{1,'+limit+'}[^\s]*).*$'), '$1...');
}
function scrollup_shownavbar (classname){
  var prevScrollpos = window.pageYOffset;
  window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
      $(classname).css({
        "bottom": "0"
      });
    } else {
      $(classname).css({
        "bottom": "-50px"
      });;
    }
    prevScrollpos = currentScrollPos;
  }
}

//popup modal dùng để show thông báo và confirm
$.modalTemplate   ='<div class="modal fade compact template-modal">';
$.modalTemplate  +='	<div class="modal-dialog modal-sm">';
$.modalTemplate  +='		<div class="modal-content"><div class="modal-body clearfix p-0"><button type="button" class="close dismiss-modal-4" data-dismiss="modal">&times;</button></div></div>';
$.modalTemplate  +='	</div>';
$.modalTemplate  +='</div>';

$.confirmModalTemplate  ='<div class="modal fade" role="dialog">';
$.confirmModalTemplate +='	  <div class="modal-dialog modal-sm">';
$.confirmModalTemplate +='        <div class="modal-content">';
$.confirmModalTemplate +='            <div class="modal-body text-center"></div>';
$.confirmModalTemplate +='            <div class="modal-footer">';
$.confirmModalTemplate +='                <div class="text-center buttons-group">';
$.confirmModalTemplate +='                    <button type="button" data-dismiss="modal" class="btn btn-border-pink btn-no">Hủy</button>';
$.confirmModalTemplate +='                    <button type="button" class="btn btn-bg-gray btn-yes">Đồng ý</button>';
$.confirmModalTemplate +='                </div>';
$.confirmModalTemplate +='            </div>';
$.confirmModalTemplate +='        </div>';
$.confirmModalTemplate +='    </div>';
$.confirmModalTemplate +='</div>';

function showAlert(title,message,cls,url, hidden){
    var jalert=$($.modalTemplate);
    jalert.find('.modal-body').append('<div class="alert alert-'+cls+' m-0"><strong>'+title+'</strong><br />'+message+'</div>');
    jalert.on('hidden.bs.modal',function(){
        jalert.remove();
        if (url !== undefined && url.length > 0) {
            window.location =  url;
        }
    });
    jalert.modal('show');
    //auto hidden after 2,5s
    if(typeof hidden !== 'undefined'){
        setTimeout(function () {
            jalert.modal('hide');
        }, 2500);
    }
}
function showConfirm(params){
    params=$.extend({},{
        text:'Bạn có chắc chắn muốn thực hiện?',
        btnYes:true,
        btnYesText:'Đồng ý',
        btnNo:true,
        btnNoText:'Hủy',
        callback:function(jelm,confirm){},
        callbackYes:function(jelm){},
        callbackNo:function(jelm){}
    },params);
    var jconfirm=$($.confirmModalTemplate);
    jconfirm.on('click','.btn-yes',function(e){
        if(typeof(params.callback)==='function'){
            ret=params.callback(jconfirm,true);
        }
        if(typeof(params.callbackYes)==='function'){
            if(typeof params.callbackYesAgument !== 'undefined'){
                params.callbackYes(params.callbackYesAgument);
            }else{
                params.callbackYes(jconfirm);
            }
        }
        if(typeof(ret)=='undefined'||ret===true){
            jconfirm.modal('hide');
        }
    }).on('click','.btn-no',function(e){
        if(typeof(params.callback)==='function'){
            params.callback(jconfirm,false);
        }
        if(typeof(params.callbackYes)==='function'){
            params.callbackNo(jconfirm);
        }
    }).on('hidden.bs.modal',function(){
        jconfirm.remove();
    });
    jconfirm.find('.modal-body').append(params.text);
    jconfirm.find('.btn-yes').text(params.btnYesText);
    jconfirm.find('.btn-no').text(params.btnNoText);
    if(!params.btnYes){
        jconfirm.find('.btn-yes').hide();
    }
    if(!params.btnNo){
        jconfirm.find('.btn-no').hide();
    }
    jconfirm.modal('show');
}

function getUrlFromInput(file)
{
  return fileUrl = window.URL.createObjectURL(file);
}

function check_type_file_image(selector)
{
    var name = $(selector).val();
    if (!name) {
        return false;
    }
    var file = $(selector)[0].files[0];
    if (!file) {
        return false;
    }
    if (!name.match(/(?:jpg|jpeg|png|gif)$/)) {
        return false;
    }
    return true;
}

app.include_js = function() {
  var ref = $('script')[ 0 ];
  var script1 = $('<script></script>').attr('src', '/templates/home/styles/plugins/exif/exif.min.js');
  $(script1).insertBefore(ref);
};

// Function to check orientation of image from EXIF metadatas and draw canvas
function orientation(img_element) {
  var canvas = document.createElement('canvas');
  // Set variables
  var ctx = canvas.getContext("2d");
  var exifOrientation = '';
  var width = img_element.width,
    height = img_element.height;

  // Check orientation in EXIF metadatas
  EXIF.getData(img_element, function () {
    var allMetaData = EXIF.getAllTags(this);
    exifOrientation = allMetaData.Orientation;
  });

  // set proper canvas dimensions before transform & export
  if (jQuery.inArray(exifOrientation, [5, 6, 7, 8]) > -1) {
    canvas.width = height;
    canvas.height = width;
  } else {
    canvas.width = width;
    canvas.height = height;
  }

  // transform context before drawing image
  switch (exifOrientation) {
    case 2:
      ctx.transform(-1, 0, 0, 1, width, 0);
      break;
    case 3:
      ctx.transform(-1, 0, 0, -1, width, height);
      break;
    case 4:
      ctx.transform(1, 0, 0, -1, 0, height);
      break;
    case 5:
      ctx.transform(0, 1, 1, 0, 0, 0);
      break;
    case 6:
      ctx.transform(0, 1, -1, 0, height, 0);
      break;
    case 7:
      ctx.transform(0, -1, -1, 0, height, width);
      break;
    case 8:
      ctx.transform(0, -1, 1, 0, 0, width);
      break;
    default:
      ctx.transform(1, 0, 0, 1, 0, 0);
  }

  // Draw img_element into canvas
  ctx.drawImage(img_element, 0, 0, width, height);
  var __return = canvas.toDataURL();
  $(canvas).remove();
  return __return;
}

$(document).on('click','.play-video-get', function(){
  var video_data = $(this).closest('.video').attr('data-video');
  if(typeof video_data != 'undefined') {
    video_data = JSON.parse(video_data);
    var preload = 'preload';
    if(video_data.is_home == 1) {
      preload = 'preload="none"';
    }
    var video_html = '';
    video_html +='<video '+video_data.attr_video+' id="'+video_data.video_attr_id+'" playsinline poster="'+video_data.poster+'" muted '+ preload;
      video_html +='class="videoautoplay popup-detail-image popup-detail-video '+video_data.video_target+'"';
      video_html +='data-id="'+video_data.data_id+'"';
      video_html +='data-cat="'+video_data.data_cat+'"';
      video_html +='data-shop-name="'+video_data.owner_name+'"';
      video_html +='data-shop-date="'+video_data.data_shop_date+'"';
      video_html +='data-shop-link="'+video_data.domain_use+'"';
      video_html +='data-shop-avatar="'+video_data.logo+'"';
      video_html +='data-video-link=="'+video_data.data_video_link+'"';
      video_html +='data-news-id='+video_data.data_news_id+'" data-key="0"';
      video_html +='data-video-id="'+video_data.data_video_id+'"';
      video_html +='data-name="'+video_data.data_name+'"';
      video_html +='data-value="'+video_data.data_value+'"';
      if(video_data.is_home == 1) {
          video_html +='<source src="'+video_data.data_video_link+'" type="video/mp4">';
      }else{
          video_html +='<source src="'+video_data.data_video_link+'#t=1" type="video/mp4">';
      }
      video_html +='Your browser does not support the video tag.';
    video_html +='</video>';
    $(this).closest('.video').find('.video-inner').html(video_html);
  }
});

function escape_quotes_html(string){
    if(string && typeof string === "string"){
        return string.replace(/"/gi, "&#34;").replace(/'/gi, "&#39;");
    }
}

function addvideo(element,data_video) {
    var video_data = data_video;
    if(typeof video_data != 'undefined') {
        video_data = JSON.parse(video_data);
        var preload = 'preload';
        if(video_data.is_home == 1) {
            preload = 'preload="none"';
        }
        var video_html = '';
        video_html +='<video '+video_data.attr_video+' id="'+video_data.video_attr_id+'" playsinline poster="'+video_data.poster+'" muted '+ preload;
        video_html +=' class="video-js videoautoplay popup-detail-video vjs-custom-skin '+video_data.video_target+'"';
        video_html +='data-id="'+video_data.data_id+'"';
        video_html +='data-cat="'+video_data.data_cat+'"';
        video_html +='data-shop-name="'+escape_quotes_html(video_data.data_shop_name)+'"';
        video_html +='data-shop-date="'+video_data.data_shop_date+'"';
        video_html +='data-shop-link="'+video_data.data_shop_link+'"';
        video_html +='data-shop-avatar="'+video_data.data_shop_avatar+'"';
        video_html +='data-video-link="'+video_data.data_video_link+'"';
        video_html +='data-news-id="'+video_data.data_news_id+'" data-key="0"';
        video_html +='data-video-id="'+video_data.data_video_id+'"';
        video_html +='data-name="'+escape_quotes_html(video_data.data_name)+'"';
        video_html +='data-value="'+video_data.data_value+'"';
        video_html +='>';
        if(video_data.is_home == 1) {
            video_html +='<source src="'+video_data.data_video_link+'" type="video/mp4">';
        }else{
            video_html +='<source src="'+video_data.data_video_link+'#t=1" type="video/mp4">';
        }
        video_html +='Your browser does not support the video tag.';
        video_html +='</video>';
        element.find('.video-inner').html(video_html);
    }
}

function copy_text(text) {
  var textArea;

  function isOS() {
    return navigator.userAgent.match(/ipad|iphone/i);
  }

  function createTextArea(text) {
    textArea = document.createElement('textArea');
    textArea.value = text;
    document.body.appendChild(textArea);
  }

  function selectText() {
    var range,
      selection;

    if (isOS()) {
      range = document.createRange();
      range.selectNodeContents(textArea);
      selection = window.getSelection();
      selection.removeAllRanges();
      selection.addRange(range);
      textArea.setSelectionRange(0, 999999);
    } else {
      textArea.select();
    }
  }

  function copyToClipboard() {
    document.execCommand('copy');
    document.body.removeChild(textArea);
  }

  function url_share(){
    $('#modal_mess .modal-body p').text('Sao chép liên kết thành công');
    $('#shareClick').modal('hide');
  }
  createTextArea(text);
  selectText();
  copyToClipboard();
  url_share();
}

window.isVisible = function (el) {
    if(!el || typeof el === 'undefined'){
        return false;
    }

    while (el) {
        if (el === document) {
            return true;
        }

        var $style = window.getComputedStyle(el, null);

        if (!el) {
            return false;
        } else if (!$style) {
            return false;
        } else if ($style.display === 'none') {
            return false;
        } else if ($style.visibility === 'hidden') {
            return false;
        } else if ($style.opacity === 0) {
            return false;
        } else if (($style.display === 'block' || $style.display === 'inline-block') &&
            $style.height === '0px' && $style.overflow === 'hidden') {
            return false;
        } else {
            return $style.position === 'fixed' || this.isVisible(el.parentNode);
        }
    }
};

function isArray(objToCheck) {
  return Boolean(objToCheck) && objToCheck.constructor === Array;
}

function error_image(image) {
  default_image_error_path = '/templates/home/styles/images/default/load_error_image_400x400.jpg';
  $(image).attr('src', default_image_error_path);
}

function error_image_avatar(image) {
  default_image_error_path = '/templates/home/styles/avatar/default-avatar.png';
  $(image).attr('src', default_image_error_path);
}

function error_image_cover(image) {
  default_image_error_path = '/templates/home/images/cover/cover_me.jpg';
  $(image).attr('src', default_image_error_path);
}

function error_video(video) {
  default_image_error_path = '/templates/home/styles/images/default/load_error_image_400x400.jpg';
  $(video).attr('poster', default_image_error_path);
}

function detectBackground(x) {
    if (x.matches) {
        if(document.body.classList.contains('display-sm') === 'undefined' || !document.body.classList.contains('display-sm')){
            document.body.classList.add("display-sm");
            document.body.classList.remove("display-md");
        }
    }else {
        if(document.body.classList.contains('display-md') === 'undefined' || !document.body.classList.contains('display-md')){
            document.body.classList.add("display-md");
            document.body.classList.remove("display-sm");
        }
    }
}

function scrollup_shownavbar (classname, prevScrollpos){
    var currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
        $(classname).css({
            "top": "0"
        });
    } else {
        $(classname).css({
            "top": "-50px"
        });
    }

    if (prevScrollpos <= 0) {
        $(classname).css({
            "top": "0"
        });
    }
    return currentScrollPos;
}

function scrollup_bottom_shownavbar (classname, prevScrollpos){
    var currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
        $(classname).css({
            "bottom": "0"
        });
    } else {
        $(classname).css({
            "bottom": "-50px"
        });
    }
    return currentScrollPos;
}

var matchBlackBackground = window.matchMedia("(max-width: 767px)");
detectBackground(matchBlackBackground);

$(document).ready(function() {

    var timeout_resize = false;
    $(window).resize(function() {
        clearTimeout(timeout_resize);
        timeout_resize = setTimeout(function () {
            detectBackground(matchBlackBackground);
        }, 300);
    });
    var prevHeaderScrollpos = window.pageYOffset;
    $(document).on('scroll' , function(){
        if($("body.display-sm .js-fixed-header-sm").length){
            prevHeaderScrollpos = scrollup_shownavbar (".js-fixed-header-sm", prevHeaderScrollpos)
        }
    });
});

function formatMoney(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
}

function isEmpty(str) {
  return (!str || 0 === str.length);
}

///function suport call api
// example code 
/**
 * https://ourcodeworld.com/articles/read/322/how-to-convert-a-base64-image-into-a-image-file-and-upload-it-with-an-asynchronous-form-using-jquery
 */
function b64toBlob(b64Data, contentType, sliceSize) {
  contentType = contentType || '';
  sliceSize = sliceSize || 512;

  var byteCharacters = atob(b64Data);
  var byteArrays = [];

  for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
      var slice = byteCharacters.slice(offset, offset + sliceSize);

      var byteNumbers = new Array(slice.length);
      for (var i = 0; i < slice.length; i++) {
          byteNumbers[i] = slice.charCodeAt(i);
      }

      var byteArray = new Uint8Array(byteNumbers);

      byteArrays.push(byteArray);
  }

  var blob = new Blob(byteArrays, {type: contentType});
  return blob;
}

function get_blob_data_b64img(b64Data) {
  var ImageURL = b64Data;
  var block = ImageURL.split(";");
  // Get the content type of the image
  var contentType = block[0].split(":")[1];// In this case "image/gif"
  // get the real base64 content of the file
  var realData = block[1].split(",")[1];// In this case "R0lGODlhPQBEAPeoAJosM...."

  // Convert it to a blob to upload
  var blob = b64toBlob(realData, contentType);

  var im = new Image;
  im.src = b64Data;

  var data = {
    blob: blob,
    contentType: contentType,
    width: im.width,
    height: im.height
  };
  return data;
}

function getMeta(url){
  var result = {width: '', height: '', contentType: ''};
  $("<img/>").attr("src", url).load(function(){
    result.height = this.height;
    result.width = this.width;
    return true;
  });
  mime = url.substring(url.lastIndexOf('.')).replace('.','image/');
  result.contentType = mime;
  return result;
}

function isFileImage(file) {
  return file && file['type'].split('/')[0] === 'image';
}

function delay(callback, ms) {
  var timer = 0;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

function allowAlpha(e) { // keypress
  var code = ('charCode' in e) ? e.charCode : e.keyCode;
  if (!(code > 64 && code < 91) && // upper alpha (A-Z)
    !(code > 96 && code < 123)) { // lower alpha (a-z)
    e.preventDefault();
  }
}
function allowNumeric(e) { // keypress
  var code = ('charCode' in e) ? e.charCode : e.keyCode;
  if (!(code > 47 && code < 58)) { // numeric (0-9)
    e.preventDefault();
  }
}
function allowSpace(e) { // keypress
  var code = ('charCode' in e) ? e.charCode : e.keyCode;
  if (!(code == 32)) { // space
    e.preventDefault();
  }
}
function blockSpecialChars(e) {
  var code = ('charCode' in e) ? e.charCode : e.keyCode;
  var regex_symbols = /[-!$%^&*()_+|~=`{}\[\]:\/;<>?,.@#]/;
  var char = String.fromCharCode(code);
  if (regex_symbols.test(char)) { // check special character
    e.preventDefault();
  }
}

/*create modal with js*/
(function($) {
    var tplModal = {};
    tplModal.defaultOptions = {
        'class'		: null,
        'title'		: false,
        'body'		: false,
        'type'		: false,/*modal-xl, modal-lg, modal-sm*/
        'buttons'	: ['btnNo', 'btnYes'],
        'bottom'	: null,
        'tplBase'	: '<div class="modal {{class}}" role="dialog" tabindex="-1">'+
                          '<div class="modal-dialog {{type}}" role="document">'+
                              '<div class="modal-content">'+
                                  '<div class="modal-header">'+
                                      '{{title}}'+
                                      '<button aria-label="Close" class="close" data-dismiss="modal" type="button">'+
                                          '<span aria-hidden="true"> × </span>'+
                                      '</button>'+
                                  '</div>'+
                                  '{{body}}'+
                                  '{{bottom}}'+
                              '</div>'+
                          '</div>'+
                      '</div>',
        'tplBottom':  '<div class="modal-footer">' +
                          '<div class="shareModal-footer">' +
                              '<div class="permision"></div>' +
                              '<div class="buttons-direct">' +
                                  '{{content}}' +
                              '</div>'+
                          '</div>'+
                      '</div>',
        'tplBtn': {
            'btnYes': {
                'label': 'Lưu',
                'class': 'btn-share',
                'tpl': '<button class="{{class}}" type="button"> {{label}} </button>'
            },
            'btnNo': {
                'label': 'Hủy',
                'class': 'btn-cancle',
                'tpl': '<button class="{{class}}" data-dismiss="modal" type="button"> {{label}} </button>'
            }
        },
    };

    tplModal.getTplHtml = function(settings){
        return settings.tplBase.replace(/{{type}}/ig, settings.type);
    };

    tplModal.getTitle = function(template, settings){
        if(typeof settings.title === 'string'){
            if(settings.title.match(/^\</im)){
                return template.replace(/{{title}}/gi, settings.title);
            }else{
                return template.replace(/{{title}}/gi, '<h5 class="modal-title">'+settings.title+'</h5>');
            }
        }
        return template;
    };

    tplModal.getBody = function(template, settings){
        if(typeof settings.body === 'string'){
            if(settings.body.match(/^\</im)){
                return template.replace(/{{body}}/gi, settings.body);
            }else{
                return template.replace(/{{body}}/gi, '<div class="modal-body">'+settings.body+'</div>');
            }
        }
        return template;
    };

    tplModal.getBottom = function(template, settings){
        if(settings.bottom && typeof settings.bottom === 'string'){
            if(settings.bottom.match(/^\</im)){
                return template.replace(/{{bottom}}/gi, settings.bottom);
            }else{
                return template.replace(/{{bottom}}/gi, '<div class="modal-footer">'+settings.bottom+'</div>');
            }
        }else if(settings.bottom && typeof settings.bottom === 'object'){
            var temp_html = '';
            $.each(settings.bottom, function(index, item) {
                temp_html += item;
            });
            temp_html = settings.tplBottom.replace(/{{content}}/ig, temp_html);
            return template.replace(/{{bottom}}/gi, temp_html);
        }
        return template;
    };

    /*return html button, nếu có thì load footer vào*/
    tplModal.getButton = function(buttons){
        if(!buttons){
            return null;
        }
        var temp = {};
        $.each(buttons, function(index, button) {
            button.tpl = button.tpl.replace(/{{class}}/ig, button.class);
            button.tpl = button.tpl.replace(/{{label}}/ig, button.label);
            temp[button.btn] = button.tpl;
        });
        return temp;
    };

    tplModal.tplHtml = function (options){
        var settings = tplModal.getConfig(options, tplModal.defaultOptions);
        var html, button;
        html   	= tplModal.getTplHtml(settings);
        html 	= tplModal.getTitle(html, settings);
        html 	= tplModal.getBody(html, settings);
        button 	= tplModal.getButton(settings.buttons);
        if(button){
            settings.bottom = button;
            html = tplModal.getBottom(html, settings);
        }else{
            html = html.replace(/{{botton}}/ig, '');
        }
        return html.replace(/{{class}}/ig, settings.class);
    };

    tplModal.getConfig = function(options, settings){
        if(typeof options !== 'undefined' && typeof options === 'object'){
            settings = $.extend({}, tplModal.defaultOptions, options);
            if(typeof settings.buttons !== 'undefined' && settings.buttons){
                var btnTemp;
                $.each(settings.buttons, function(index, button) {
                    btnTemp = '';
                    if(typeof button === 'string'){
                        btnTemp = $.extend({}, {'label': settings.buttons[index], 'btn': button}, tplModal.defaultOptions.tplBtn[button]);
                        settings.buttons[index] = btnTemp;
                    }else if (typeof button === 'object'){
                        settings.buttons[index] = $.extend({}, tplModal.defaultOptions.tplBtn[button['btn']], button);
                    }
                });
            }
        }
        return settings;
    };

    tplModal.open = function(content, options){
        if(typeof content !== 'undefined' && content){
            options.body = content;
        }
        $(tplModal.tplHtml(options)).modal('show');
    };

    tplModal.getHtml = function(content, options){
        if(typeof content !== 'undefined' && content){
            options.body = content;
        }
        return tplModal.tplHtml(options);
    };
    $.fn.tplModal = tplModal;

})(jQuery);

// $.fn.tplModal.open('test 123', {
//     'title' : 'test 11111111111',
//     'type'	: 'modal-xl',
//     'class'	: 'custom'
// });