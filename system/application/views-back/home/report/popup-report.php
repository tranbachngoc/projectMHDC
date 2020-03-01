<div class="sanphamchitiet">
  <div class="modal fade" id="reportpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="title">Gửi báo cáo</div>
          <div class="close-popup">
            <img src="/templates/home/styles/images/svg/close_.svg" data-dismiss="modal">
          </div>
          <form class="report">
            <?php
            // $linkp = get_server_protocol().domain_site.'/'.$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
            foreach ($listreports as $key => $value) { ?>
              <label>
                <input type="radio" name="rp_id" id="rpid_<?php echo $value->rp_id ?>" value="<?php echo $value->rp_id ?>">
                <p><?php echo $value->rp_desc ?></p>
              </label>
            <?php } ?>
            <label>
                <input type="radio" name="rp_id" id="rpid_write" value="write">
                <p>Khác</p>
              </label>
            <div class="button-report">
              <button class="btn-report btn-close" data-dismiss="modal">Đóng</button>
              <button type="button" name="sendReport" class="btn-report btn-send">Gửi báo cáo</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/template" id="text-nhanxet">
  <div class="flex-start-center">
    <textarea type="text" class="rpd_reason" id="" placeholder="Nhập nội dung..." class="" maxlength="255" style="resize: none; width: 90%; padding: 5px; margin: 0 auto 10px;"/></textarea>
  </div>
</script>

<!-- <script src="/templates/home/styles/js/report.js"></script> -->

<script type="text/javascript">
  $(document).ready(function()
  {
    var id = rpd_type = media_id = 0;
    var rpd_link = rpd_name = rpd_image = '';
    $('body').on('click', '.report-popup', function(){
      id = $(this).parents('ul').data('id');
      rpd_type = $(this).data('rpd_type');
      rpd_link = $(this).data('link');
      rpd_name = $(this).data('rpd_name');
      rpd_image = $(this).data('rpd_image');
      media_id = $(this).data('media_id');
      // $('#reportpopup .modal-body').attr('data-id', $(this).parents('ul').data('id'));
      $('.modal').modal('hide');
      $('#reportpopup form label').eq(0).trigger('click');
    });

    $('body').on('click', '#reportpopup form label', function(){
      var text = $(this).find('p').text();
      var text = $('#text-nhanxet').html();
      $('.flex-start-center').remove();
      $(this).after(text);
      if($(this).find('input').val() == 'write'){
        $('.rpd_reason').attr('rows', "5");
      }else{
        $('.rpd_reason').attr('rows', "2");
      }
    });

    $('body').on('click', '.btn-send', function(){
      var rp_id = $('input[name="rp_id"]:checked').val();
      var rpd_reason = '';
      var error = false;

      if(rp_id == 'write')
      {
        if($('.rpd_reason').val() == ''){
          error = true;
          alert('Bạn chưa nhập nội dung báo cáo');
        }else{
          $('.load-wrapp').show();
        }
      }else{
        $('.load-wrapp').show();
      }
      rpd_reason = $('.rpd_reason').val();

      if(error == false){
        var url = '';
        var data;

        if(rpd_type == 2){
          url = siteUrl + 'report/report_pro';
          data = {
            rp_id: rp_id,
            pro_id: id,
            rpd_type: 2,
            rpd_link: window.location.href,
            rpd_name: $('.sanphamchitiet-content-detail .tit').text(),
            rpd_reason: rpd_reason
          };
        }
        else{
          url = siteUrl + 'report';
          data = {
            rp_id: rp_id,
            id: id,
            media_id: media_id,
            rpd_type: rpd_type,
            rpd_link: rpd_link,
            rpd_image: rpd_image,
            rpd_name: rpd_name,
            rpd_reason: rpd_reason
          };
        }
        $.ajax({
          url: url,
          data: data,
          type: 'POST',
          dataType: 'json',
          success: function(result){
            if(result.isLogin == 1){
              $('.load-wrapp').hide();
              $('.modal').modal('hide');
              setTimeout(function(){
                location.reload();
              }, 1000);
            }else{
              $('.load-wrapp').hide();
            }
            $('#modal_mess').modal('show');
            $('#modal_mess .modal-body p').html(result.message);
          },
          error: function(){
            alert('Kết nối thất bại');
            $('.load-wrapp').hide();
          }
        });
      }
    });
  });
</script>