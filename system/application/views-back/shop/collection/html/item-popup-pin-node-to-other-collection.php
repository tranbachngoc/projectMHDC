<?php 
if($type == COLLECTION_CONTENT){ // collection content item
    $srcImgCreate = $showCreate->image;
}
else if($type == COLLECTION_PRODUCT || $type == COLLECTION_COUPON){ // collection product/coupon item
    $srcImgCreate = DOMAIN_CLOUDSERVER . 'media/images/product/' . $showCreate->dir . '/' . $showCreate->image;
}
else if($type == COLLECTION_CUSTOMLINK){ // collection link item
    $srcImgCreate = $showCreate->image;
}
?>
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
        top: 0;
        width: 100%;
        height: 100%;
    }
</style>
<form action="" method="POST" id="frmCreateCollectionContent">    
<div class="bosuutap-popup-danhsach-hientai">
    <div><input type="hidden" name="collection[]" value="off" /></div>
    <?php foreach ($data as $key => $value) { ?>
    <div class="bosuutap-popup-danhsach-hientai-item">
        <div class="photo">
            <img src="<?php echo $value->avatar_path_full; ?>" alt="">
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
    <div class="title" >
        <label class="checkbox-style">
        <input type="checkbox" name="category" id="taomoi" value="aaa"><span>Tạo bộ sưu tập mới</span>      
        </label>
    </div>
    <div class="content" style="display: none;">
        <div class="nhap-ten">
            <div class="photo">
                <img src="<?php echo $srcImgCreate; ?>" onerror="image_error(this)" alt="">
            </div>
            <div class="input"><input type="text" autocomplete="off" name="name_col" placeholder="Nhập tên Bộ sưu tập"></div>
        </div>
        <div class="input"><input type="checkbox" name="name_notpublic" value="check" checked><label class="mt10">Bí mật</label></div>
        <div class="nut-xacnhan buttons-group text-right mt10" id="create">
        <!-- <button class="btn-bg-white">Hủy</button> -->
        <button type="submit" class="btn-bg-gray">Tạo Bộ Sưu Tập</button>
        </div>
    </div>
    </form>
</div>

<script>

$('#pu-pin-node-to-collection').find("#taomoi").change( function() {
  var isCheck = $(this).is(":checked");
  if (isCheck) {
    $('#pu-pin-node-to-collection .bosuutap-popup-taomoi .content').slideDown();
    $('#pu-pin-node-to-collection .bosuutap-popup-danhsach-hientai').slideUp();
    $('#pu-pin-node-to-collection #update').hide();
  } else {
    $('#pu-pin-node-to-collection .bosuutap-popup-taomoi .content').slideUp();
    $('#pu-pin-node-to-collection .bosuutap-popup-danhsach-hientai').slideDown();
    $('#pu-pin-node-to-collection #update').show();
  }
});

$("#frmCreateCollection").on('submit',(function(e) {
  e.preventDefault();
      
  var typeReturn = 1; // 0: xài ở trang chủ, 1: xài ở chi tiết bộ sưu tập
  var data = $(this).serialize() 
              + '&' + 
              $.param({ 
                  'avatar': '<?php echo $showCreate->image;?>', 
                  'dir': '<?php echo $showCreate->dir;?>',
                  'typeReturn': typeReturn,
                  'typeCollection': <?php echo $type;?>
                  });
  $.ajax({
    url: "<?php echo $shop_url; ?>collection/ajax_createCollection",
    type: "POST",
    data:  data,
    success: function(response) {
      $('#pu-pin-node-to-collection input[name=name_col]').val('');
      $('#pu-pin-node-to-collection .bosuutap-popup-danhsach-hientai').append(response);
      
      $('#pu-pin-node-to-collection .bosuutap-popup-taomoi .content').slideUp();
      $('#pu-pin-node-to-collection .bosuutap-popup-danhsach-hientai').slideDown();
      $('#pu-pin-node-to-collection #taomoi').attr('checked', false);
      $('#pu-pin-node-to-collection #update').show();
    }
  });
}));

$("#frmCreateCollectionContent").on('submit',(function(e) {
  e.preventDefault();

  var data = $(this).serialize();
  if(linkfrom != '') {
    data =  data + '&' + 
              $.param({ 
                  'linkfrom': linkfrom,
                  });
  }
  $.ajax({
    url: "<?php echo $shop_url; ?>collection/ajax_createCollectionContent/<?php echo $showCreate->id;?>/<?php echo $type;?>",
    type: "POST",
    data:  data,
    success: function(response) {
      if(response >= 0 && response != 'error') {
        $('#pu-pin-node-to-collection').modal('hide');
        var img = $('.pin-node-collection').find('img');
        // book mark trên sản phảm
        if(img.length > 0) {
            if(response == 0){
                img.attr('src','/templates/home/styles/images/svg/bookmark.svg');
            }else{
                img.attr('src','/templates/home/styles/images/svg/bookmark_gray.svg');
            }
        }
      } else {
        alert("errors.");
      }
    }
  });
}));

</script>