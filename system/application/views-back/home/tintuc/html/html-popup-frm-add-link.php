<style>
  .bosuutap-popup-danhsach-hientai-item {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 10px;
  }
  .bosuutap-popup-danhsach-hientai-item .photo {
    min-width: 50px;
    min-height: 50px;
    width: 50px;
    height: 50px;
    margin-right: 10px;
    border-radius: 5px;
    overflow: hidden;
    position: relative;
  }
  .bosuutap-popup-danhsach-hientai-item .photo .checkbox-style {
    position: absolute;
    right: 0;
    top: -15px;
    width: 100%;
    height: 100%;
  }
</style>

<div class="btn-back js-back"><a href="#"><img src="/templates/home/styles/images/svg/close_black.svg"></a></div>
<form action="" method="POST" id="frmCreateCollectionLink">    
  <div class="bosuutap-popup-danhsach-hientai">
      <div><input type="hidden" name="collection[]" value="off" /></div>
      <?php foreach ($collection as $key => $value) { ?>
      <div class="bosuutap-popup-danhsach-hientai-item">
          <div class="photo">
              <img src="<?php echo $value->avatar; ?>" alt="">
              <label class="checkbox-style">
                  <input type="checkbox" name="collection[]" value="<?php echo $value->id ?>" <?php if($value->checked == true) echo "checked"?>><span></span>
              </label>
          </div>
          <div class="name"><?php echo $value->name ?></div>
      </div>
      <?php } ?>
  </div>
  <div class="nut-xacnhan buttons-group text-right" id="update">
      <!-- <button class="btn-bg-white">Hủy</button> -->
      <button type="submit" class="btn-bg-gray">Cập nhật</button>
  </div>
</form>

<div class="bosuutap-popup-taomoi">
  <form action="" method="POST" id="frmCreateCollection">
    <div class="title">
      <label class="checkbox-style">
        <input type="checkbox" name="category" id="taomoi" value="aaa"><span>Tạo bộ sưu tập mới</span>
      </label>
    </div>
    <div class="content" style="display: none;">
      <div class="nhap-ten">
        <div class="photo">
          <img src="<?php echo $custom_link->image; ?>" alt="">
        </div>
        <div class="input"><input type="text" name="name_col" placeholder="Nhập tên Bộ sưu tập"></div>
      </div>
      <div class="input"><input type="checkbox" name="name_notpublic" value="check" checked=""><label>Bí mật</label></div>
      <div class="nut-xacnhan buttons-group" id="create">
        <!-- <button class="btn-bg-white">Hủy</button> -->
        <button type="submit" class="btn-bg-gray">Tạo Bộ Sưu Tập</button>
      </div>
    </div>
  </form>
</div>




<script>
  $('.drawer-overlay, .js-back').on('click', function () {
    $('.btn-popup-tag').removeClass('opened');
    $('.bandangnghigi').removeClass('opened');
    $('.btn-show-comment-customer').removeClass('opened');
    $('.model-content').removeClass('is-open');
    $('.wrapper').removeClass('drawer-open');
    $('#bg05').removeClass('opacity05');
  });

  $("#taomoi").change(function () {
    var isCheck = $(this).is(":checked");
    if (isCheck) {
      $('.bosuutap-popup-taomoi .content').slideDown();
      $('.bosuutap-popup-danhsach-hientai').slideUp();''
      $('#update').hide();
    } else {
      $('.bosuutap-popup-taomoi .content').slideUp();
      $('.bosuutap-popup-danhsach-hientai').slideDown();
      $('#update').show();
    }
  });

  $("#frmCreateCollection").on('submit', (function (e) {
    e.preventDefault();
    $('.bosuutap-popup-taomoi .content').slideUp();
    $('.bosuutap-popup-danhsach-hientai').slideDown();
    $('#taomoi').attr('checked', false);
    $('#update').show();

    var typeReturn = 1; // 0: xài ở trang chủ, 1: xài ở chi tiết bộ sưu tập
    var data = $(this).serialize() +
      '&' +
      $.param({
        'avatar': '<?=$custom_link->image;?>',
        'dir': '0',
        'typeReturn': typeReturn,
        'typeCollection': 3
      });
    var url = "<?=base_url(); ?>collection/ajax_createCollection";
    $.ajax({
      url: url,
      type: "POST",
      data: data,
      success: function (response) {
        $('input[name=name_col').val('');
        $('.bosuutap-popup-danhsach-hientai').append(response);

        
      }
    });
  }));

  $("#frmCreateCollectionLink").on('submit', (function (e) {
    e.preventDefault();

    var data = $(this).serialize();
    var typeCollection = 3; // type collection
    var link_id = <?php echo $custom_link->id; ?>;
    var url = "<?=base_url(); ?>collection/ajax_createCollectionContent/"+link_id+"/"+typeCollection;
    console.log("url",url);
    $.ajax({
      url: url,
      type: "POST",
      data: data,
      success: function (response) {
        if (response >= 0) {
          alert("Cập nhật thành công !!!");
        } else {
          alert("errors.");
        }
      }
    });
  }));
</script>