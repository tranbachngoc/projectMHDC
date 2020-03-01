<?php
$this->load->view('home/common/header_new');
?>
<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<link href="/templates/landing_page/css/font-awesome.css" rel="stylesheet">

<script src="/templates/home/styles/js/common.js"></script>

<main class="sanphamchitiet">      
  <section class="main-content">
    <div class="breadcrumb control-board">
      <div class="container">
        <ul>
          <li><img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="mr10" alt="">Mời cộng tác viên</li>
        </ul>
        <?php $this->load->view('home/page_business/common/menu_left'); ?>
      </div>
    </div>
    <div class="container">
		<div class="affiliate-content">
			  <div class="affiliate-content-invitefriend">
			    <div class="row">
			      <div class="col-md-8 invitefriend-order01">
			        <div class="invitefriend-item">
			          <p>
			            <i class="fa fa-caret-right mb20" aria-hidden="true"></i> Bằng liên kết giới thiệu</p>
			          <div class="group-copy-link">
			            <input type="text" disabled='disabled' class="input-copy-link" value="<?=$sUrl?>">
			            <button class="btn-pink btn-copy-link js-copy-link">SAO CHÉP LIÊN KẾT</button>
			          </div>
			        </div>
			        <div class="invitefriend-item">
			          <p>
			            <i class="fa fa-caret-right mb20" aria-hidden="true"></i> Bằng mã QR</p>
			          <div class="qr-img">
			            <img src="<?=$sImage?>" alt="">
			          </div>
			          <!-- <div>
			            <button class="btn-pink btn-copy-link js-copy-image">SAO CHÉP HÌNH ẢNH</button>
			          </div> -->
			        </div>
            </div>
            <?php if(isset($aListFriend) && !empty($aListFriend)) { ?>
			      <div class="col-md-4 invitefriend-order02">
			        <div class="invitefriend-box">
			          <h4>Mời thành viên</h4>
			          <div class="search">
			            <input type="text" name="search_ctv" class="form-control" placeholder="Tìm kiếm bạn bè">
                  <img src="/templates/home/styles/images/svg/search.svg" alt="" id="loaded">
                  <i class="fa fa-spinner fa-spin" id="loadding" style="font-size:24px;position: absolute;left: 5px;top: 5px; display: none;"></i>
			          </div>
			          <h4>Gợi ý thành viên</h4>
			          <ul class="listfriends js-friends" style="max-height: 500px; overflow: auto">
                  <?php foreach ($aListFriend as $iKFriend => $oFriend) {
                    $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-invite-user', ['oFriend'=>$oFriend]);
                  } ?>
			          </ul>
			        </div>
            </div>
            <?php } ?>
			    </div>
			  </div>
		</div>
    </div>
  </section>
</main>

<footer id="footer" class="footer-border-top">
	<?php $this->load->view('e-azibai/common/common-html-footer'); ?>
  <script src="/templates/home/js/page_business.js"></script>
</footer>
<?php $this->load->view('home/personal/affiliate/popup/popup-page-affilate-list-user-menu-action'); ?>
<div class="modal" id="show_error">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">THÔNG BÁO LỖI</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="show-more-detail">
          
        </div>
      </div>
    </div>
  </div>
</div>
<script>
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
      $('#modal_mess .modal-body p').text('Sao chép link thành công');
      $('#shareClick').modal('hide');
    }
    createTextArea(text);
    selectText();
    copyToClipboard();
    url_share();
  }

  $('body').on('click', '.js-copy-link' ,function () {
    var text = $(this).prev().val();
    copy_text(text);
    alert('Sao chép thành công');
  });

  // $('body').on('click', '.js-copy-image' ,function () {
  //   alert('Sao chép thành công');
  // });

  jQuery(document).on('click','.invitefriend', function() {
      var id = $(this).attr('data-id');
      var element = this;
      $.ajax({
        url: siteUrl+"affiliate/inviteuser",
        data: {id: id, page_business : 1},
        type: 'POST',
        dataType : 'json',
        success:function(res){
            if(res.type == 'error') {
              $('#show_error .show-more-detail').html('<p>'+res.message+'</p>');
              $('#show_error').modal('show');
            }else {
              $(element).removeClass('invitefriend').text('Đã mời');
              $('#show_error .show-more-detail').html('<p>'+res.message+'</p>');
              $('#show_error').modal('show');
            }
            
        }
    });
  });


  $(document).ready(function () {
    var search = '';
    $('input[name="search_ctv"]').on("keyup", delay(function (e) {
      search = $(this).val();
      __page = 1;
      $.ajax({
        type: 'post',
        dataType: 'html',
        url: window.location.href,
        data: { page: __page , search: search},
        beforeSend: function () {
          $('#loaded').hide();
          $('#loadding').show();
        },
        success: function (result) {
          $('.js-friends').html(result);
          __stopped = false;
        }
      }).always(function () {
        $('#loaded').show();
        $('#loadding').hide();
      });
      return false;
    }, 500))

    var __page = 1;
    var __is_busy = false;
    var __stopped = false;
    $('.js-friends').scroll(function (event) {
      if ($(this).scrollTop() + $(this).find('li').height() >= $(this).height()) {
        var element = this;

        if (__is_busy == true) {
          event.stopPropagation();
          return false;
        }
        if (__stopped == true) {
          event.stopPropagation();
          return false;
        }
        __is_busy = true;
        __page++;

        $.ajax({
          type: 'post',
          dataType: 'html',
          url: window.location.href,
          data: { page: __page , search: search},
          success: function (result) {
            if (result == '') {
              __stopped = true;
            } else {
              $(element).append(result);
            }
          }
        }).always(function () {
          __is_busy = false;
        });
        return false;
      }
    });

  });

</script>