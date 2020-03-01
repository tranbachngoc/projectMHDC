<style>
  #pu-view-link {
    padding-right: 0px !important;
  }

  #pu-view-link .modal-dialog {
    width: 100%;
    height: 100%;
    max-width: 100%;
    margin: 0;
    padding: 0;
  }

  #pu-view-link .modal-header{
    border-bottom: 1px solid black;
    font-size: 20px;
  }

  #pu-view-link .modal-content {
    height: auto;
    min-height: 100%;
    border-radius: 0;
  }

  #pu-view-link .add-link {
    position: relative;
  }

  #star-six {
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 20px solid #ff2462;
    position: absolute;
    left: 103%;
    top: 12%;
  }
  #star-six:after {
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-top: 20px solid #ff2462;
    position: absolute;
    content: "";
    top: 7px;
    left: -10px;
  }

  .opacity05{
    opacity: 0.5;
    background-color: rgba(0,0,0,0.5);
  }
</style>
<!-- The Modal -->
<div class="modal modal-view fade" id="pu-view-link">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <div style="display:inline" class="add-more-txt">
          <!-- <p class="modal-title"><strong>Link: </strong><span>http://genk.vn/cuu-ky-su-apple-vua-cai-tien-man-hinh-iphone-theo-mot-cach-khong-the-tuyet-voi-hon-chinh-apple-cung-can-hoc-hoi-2019010411055309.chn</span></p> -->
          <!-- <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
            <i class="fa fa-upload" aria-hidden="true"></i>
          </span> -->
          <?php if( $this->session->userdata('sessionUser') ){ ?>
          <p class="modal-title add-link">Thêm vào bộ sưu tập link: 
            <!-- <span><img class="icon-img" src="/templates/home/styles/images/svg/lienket.svg"
                alt="bookmark"></span> -->
            <span id="star-six"></span></p>
          <?php }?>
        </div>
        <button type="button" class="close">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div id="bg05">
        <iframe src="" style="position: absolute; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden;">
          Your browser doesn't support iframes
        </iframe>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-success btn_save">Save</button>
        <button type="button" class="btn btn-success btn_process">Process</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
      </div>

    </div>
  </div>

  <div class="detail-collection-link">
    <div class="model-content">
      <div class="wrapp-model">
        <div class="content-model">
          <div class="contents bosuutap-popup">
            
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<script>
  var link = '';
  var id_link = '';

  $('body').on('click', '.view-link', function () {
    $('#pu-view-link').modal('show');
    var link = $(this).attr("data-link");
    id_link = $(this).attr("data-id");
    $('iframe').show(function () {
      $('iframe').attr('src', link);
      $('.detail-collection-link').hide();
    });
  });

  $('body').on('click', '.close', function () {
    $('#pu-view-link').modal('hide');
    $('iframe').attr('src', '');
  });

  $('body').on('click', '.add-link', function () {
    $('.detail-collection-link').modal('show');
    if($('.detail-collection-link').find('.model-content').hasClass('is-open')){
      $('.detail-collection-link').find('.model-content').removeClass('is-open');
      $('#bg05').removeClass('opacity05');
    }else{
      $('.detail-collection-link').find('.model-content').addClass('is-open');
      $('#bg05').addClass('opacity05');
      $('.detail-collection-link').show();
    }
    $('body').find('.modal-backdrop + .show').remove();

    var url = "<?= base_url() ?>collection/ajax_loadAll_Collection_CheckExist_Node/" + id_link + "/" + 3; // 3 type - link
    $.ajax({
      type: 'POST',
      url: url,
      success: function (data) {
        console.log('data',data);
        $('.detail-collection-link').find(".bosuutap-popup").html(data);
      },
      error: function(){
        console.log('Error conection !!!');
      }
    });
  });

</script>