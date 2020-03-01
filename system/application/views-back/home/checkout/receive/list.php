<div class="delivery-address">
   <h3 class="tit">Địa chỉ giao hàng</h3>
   <?php
   if(isset($list_receive) && !empty($list_receive)){
   ?>
   <input type="hidden" class="form-control order_key" name="key" value="<?php echo $_REQUEST['key']; ?>" required>
   <input type="hidden" class="form-control id_max" name="id_max" value="<?php echo $list_receive[0]->id; ?>" required>
   <p class="text-bold mb10">Chọn địa chỉ giao hàng có sẵn bên dưới:</p>
   <div class="row row-address-list">
      <?php
         foreach ($list_receive as $key => $value) {
      ?>
      <div class="col-lg-6 col-md-6 col-sm-6 item" id="item-<?php echo $value->id;?>">
         <div class="panel panel-default address-item is-default">
            <div class="panel-body">
               <p class="name"><?php echo $value->name;?></p>
               <p class="address" title="<?php echo $value->full_address;?>">
                  <?php echo $value->full_address;?>
               </p>
               <p class="phone">Điện thoại: <?php echo $value->phone;?></p>
               <div class="action">
                  <button type="button" data-id="<?php echo $value->id;?>" class="js-choose-address btn btn-default btn-custom1 saving-address is-blue " admicro-data-event="GiaoDenDiaChiNay" admicro-data-auto="1" admicro-data-order="false">
                  Giao đến địa chỉ này
                  </button>
                  <div class="btn btn-default btn-custom1" data-id="<?php echo $value->id;?>" data-use_id="<?php echo $value->use_id;?>" data-name="<?php echo $value->name;?>" data-address="<?php echo $value->address;?>" data-full_address="<?php echo $value->full_address;?>" data-district="<?php echo $value->district;?>" data-province="<?php echo $value->province;?>" data-semail="<?php echo $value->semail;?>" data-phone="<?php echo $value->phone;?>" data-active="<?php echo $value->active;?>">
                     <button type="button" class="btn btn-default js-edit-address" data-toggle="modal" data-target="#updateAddress<?php echo $value->id;?>">Sửa</button>
                     <button type="button" class="btn btn-default btn-custom1 delete-address">Xóa</button>
                  </div>
               </div>
               <?php echo ($value->active == 1) ? '<span class="default">Mặc định</span>' : '';?>
            </div>
         </div>
      </div>
      <?php
      }
      ?>
   </div>
   <?php
   }
   ?>
   <p class="mt10">Bạn muốn giao hàng đến địa chỉ khác ? <a href="#" class="text-red add-address" data-toggle="modal" data-target="#addAddress">Thêm địa chỉ giao hàng mới</a></p>
</div>

<div class="modal orderAddress" id="addAddress" >
   <div class="modal-dialog modal-dialog-centered modal-dialog-sm">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">Thêm thông tin người nhận mới</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
          
         <form class="orderAddress" name="orderAddress" id="orderAddress" method="post">
         <!-- Modal body -->
            <div class="modal-body">
               <p class="note"></p>
               <div class="delivery-address">
                  <div class="form-group">
                     <input type="hidden" class="form-control" name="id" placeholder="" value="" required>
                     <input type="text" class="form-control name" name="name" maxlength="255" placeholder="Nhập tên người nhận" value="" required>
                   </div>
                   <div class="double-input">
                     <div class="form-group">
                       <input type="number" class="form-control" name="phone" pattern="^\d{10}$" maxlength="10" placeholder="Nhập số điện thoại" value="" required>
                     </div>
                     <div class="form-group">
                       <input type="email" class="form-control" name="semail" maxlength="255" placeholder="Email" value="" required>
                     </div>
                   </div>
                   <div class="form-group">
                     <input type="text" class="form-control" name="address" maxlength="500" placeholder="Nhập địa chỉ đường" value="" required>
                   </div>
                   <div class="double-input">
                     <div class="form-group">
                       <select class="form-control js-province" name="province" required>
                         <option value="">Chọn Tỉnh/Thành</option>
                         <?php 
                           if (!empty($province)) {
                             foreach ($province as $key => $value) {
                               echo '<option value="' .$value['pre_id']. '">' .$value['pre_name']. '</option>';
                             }
                           }
                         ?>
                       </select>
                     </div>
                     <div class="form-group">
                       <select class="form-control js-district" name="district" required>
                         <option value="">Chọn Quận/Huyện</option>
                         <?php 
                           if (!empty($district)) {
                             foreach ($district as $key => $value) {
                               echo '<option value="' .$value['id']. '">' .$value['DistrictName']. '</option>';
                             }
                           }
                         ?>
                       </select>
                     </div>
                   </div>
                   <div class="form-group mt20">
                     <label class="checkbox-style">
                       <input type="checkbox" name="active" value="1"><span>Đặt làm địa chỉ mặc định</span>
                     </label>
                   </div> 
               </div>
            </div>
             <!-- Modal footer -->
             <div class="modal-footer">
               <div class="shareModal-footer">
                 <div class="permision">
                 </div>
                 <div class="buttons-direct">
                   <button class="btn-cancle">Hủy</button>
                   <button type="button" class="btn-share btn-save-db">Lưu</button>
                 </div>
               </div>
             </div>     
         </form>         
      </div>
   </div>
</div>
<form class="form-info-delivery" action="" method="post">
  <input type="hidden" name="id_address" class="form-control id_address" required value="">
</form>
<script type="text/javascript">

   function IsNumber(e) {
      var t = "0123456789";
      for (var n = 0; n < e.length; n++) {
        if (t.indexOf(e.charAt(n)) == -1) {
            return false
        }
      }
      return true
   }

   function checkEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
   }

   $('body').on('click','.js-edit-address', function (){

      var parent_this = $(this).parent('.btn-default');
      var id = parent_this.data('id');
      var use_id = parent_this.data('use_id');
      var name = parent_this.data('name');
      var phone = parent_this.data('phone');
      var semail = parent_this.data('semail');
      var address = parent_this.data('address');
      var full_address = parent_this.data('full_address');
      var province = parent_this.data('province');
      var district = parent_this.data('district');
      var active = parent_this.data('active');
      var _this = '#updateAddress'+id;

      $('.orderAddress .modal-title').text('Sửa thông tin người nhận');
      $('.orderAddress').attr('id','updateAddress'+id);
      $(_this+' input[name=id]').val(id);
      $(_this+' input[name=name]').val(name);
      $(_this+' input[name=phone]').val(phone);
      $(_this+' input[name=semail]').val(semail);
      $(_this+' input[name=address]').val(address);
      $(_this+' input[name=full_address]').val(full_address);
      
      if(active == 1){          
         $('.orderAddress input[name=active]').attr('checked',true);
         $('.orderAddress .checkbox-style span').css('background-image','url(/templates/home/styles/images/svg/checked.svg)');
      }else{
         $('.orderAddress input[name=active]').attr('checked',false);
         $('.orderAddress .checkbox-style span').removeAttr('style');
      }

      if(province > 0){
         $.ajax({
            type: "POST",
            url: '/home/checkout/update_address',
            dataType: 'json',
            data: {province_id: province, active: active},
            success: function(res) {
               var html_province = '';
               $(res.province).each(function(at, item){
                  var selected = '';
                  if(item.pre_id == province){
                     selected = 'selected';
                  }
                  html_province += '<option value="'+item.pre_id+'" '+selected+'>'+item.pre_name+'</option>';
               });
               $('.js-province').html(html_province);

               var html_district = '';
               $(res.district).each(function(at, item){
                  var selected = '';
                  if(item.id == district){
                     selected = 'selected';
                  }
                  html_district += '<option value="'+item.id+'" '+selected+'>'+item.DistrictName+'</option>';
               });
               $('.js-district').html(html_district);
            }
         });
      }

      $(_this+ ' .btn-save-db').click(function(){
         province = 0;

         if($(_this+' input[name=name]').val() == '' || $(_this+' input[name=name]').val() == null){
            $(_this+' p.note').html('<span class="text-red">Bạn chưa nhập nhập họ tên người nhận</span>');
            return false;
         }

         if($(_this+' input[name=phone]').val() == '' || $(_this+' input[name=phone]').val().length > 10 || !IsNumber($(_this+' input[name=phone]').val())){
            if($(_this+' input[name=phone]').val() == ''){
               var mess = '<span class="text-red">Bạn chưa nhập số điện thoại</span>';
            }else{
               var mess = '<span class="text-red">Số điện thoại chỉ chứa số 0-9, chiều dài gồm từ 10 số</span>';
            }
            $(_this+' p.note').html(mess);
            $(_this+' input[name=phone]').css('color','red');
            return false;
         }

         if($(_this+' input[name=semail]').val() == '' || !checkEmail($(_this+' input[name=semail]').val())){
            if(!checkEmail($(_this+' input[name=semail]').val())){
               mess = '<span class="text-red">Địa chỉ mail không hợp lệ</span>';
            }else{
               mess = '<span class="text-red">Bạn chưa nhập địa chỉ email</span>';
            }
            $(_this+' p.note').html(mess);
            $(_this+' input[name=semail]').css('color','red');
            return false;
         }

         if($(_this+' input[name=address]').val() == ''){
            $(_this+' p.note').html('<span class="text-red">Bạn chưa nhập địa chỉ nhận hàng</span>');
            $(_this+' input[name=address]').css('color','red');
            return false;
         }

         if($(_this+' .js-province').val() == ''){
            $(_this+' p.note').html('<span class="text-red">Bạn chưa chọn tỉnh/thành phố</span>');
            $(_this+' .js-province').css('color','red');
            return false;
         }

         if($(_this+' .js-district').val() == ''){
            $(_this+' p.note').html('<span class="text-red">Bạn chưa chọn quận/huyện</span>');
            $(_this+' .js-district').css('color','red');
            return false;
         }

         $('form').on('submit', function(e) {});
         var form = $('form');
         $('.load-wrapp').show();
         $.ajax({
            type: "POST",
            url: '/home/checkout/update_address',
            dataType: 'json',
            data: form.serialize(),
            success: function(res) {
               if(res.error == true){
                  $(_this+' p.note').html('<b><span class="text-red">Cập nhật thất bại</span></b>');
               }else{
                  $(_this+' p.note').html('<b>Cập nhật thành công</b>');
                  
                  setTimeout(function() { 
                     $(".orderAddress").modal('hide');
                     var order_key = $('.order_key').val();
                     location.href = '/v-checkout/order-address?key='+order_key;
                  }, 2000);
               }
            },
            error: function(res) {
               $('#modal_mess').show();
               $('#modal_mess .modal-body p').html('Kết nối lỗi');
            }
         }).always(function() {
             $('.load-wrapp').hide();
         });

      });
   });

   $('body').on('click','#addAddress .btn-save-db', function (){
      var _this = '#addAddress';
      $('form').on('submit',function (e) {});

      if($(_this+' input[name=name]').val() == '' || $(_this+' input[name=name]').val() == null){
         $(_this+' p.note').html('<span class="text-red">Bạn chưa nhập nhập họ tên người nhận</span>');
         return false;
      }

      if($(_this+' input[name=phone]').val() == '' || $(_this+' input[name=phone]').val().length > 10 || !IsNumber($(_this+' input[name=phone]').val())){
         if($(_this+' input[name=phone]').val() == ''){
            var mess = '<span class="text-red">Bạn chưa nhập số điện thoại</span>';
         }else{
            var mess = '<span class="text-red">Số điện thoại hợp lệ chỉ gồm 10 số từ 0 đến 9</span>';
         }
         $(_this+' p.note').html(mess);
         $(_this+' input[name=phone]').css('color','red');
         return false;
      }

      if(!checkEmail($(_this+' input[name=semail]').val())){
         mess = '<span class="text-red">Địa chỉ mail không hợp lệ</span>';
         $(_this+' p.note').html(mess);
         $(_this+' input[name=semail]').css('color','red');
         return false;
      }

      if($(_this+' input[name=address]').val() == ''){
         $(_this+' p.note').html('<span class="text-red">Bạn chưa nhập địa chỉ nhận hàng</span>');
         $(_this+' input[name=address]').css('color','red');
         return false;
      }

      if($(_this+' .js-province').val() == ''){
         $(_this+' p.note').html('<span class="text-red">Bạn chưa chọn tỉnh/thành phố</span>');
         $(_this+' .js-province').css('color','red');
         return false;
      }

      if($(_this+' .js-district').val() == ''){
         $(_this+' p.note').html('<span class="text-red">Bạn chưa chọn quận/huyện</span>');
         $(_this+' .js-district').css('color','red');
         return false;
      }

      $('.load-wrapp').show();
      var form = $('form');
      $.ajax({
         type: "POST",
         url: '/home/checkout/add_address',
         dataType: 'json',
         data: form.serialize(),
         success: function(res) {
            if(res.error == true){
               $('#addAddress p.note').html('<b><span class="text-red">Lưu thông tin thất bại</span></b>');
            }else{
               $('#addAddress p.note').html('<b>Lưu thông tin thành công</b>');
               setTimeout(function() { 
                  $(".orderAddress").modal('hide');
                  var order_key = $('.order_key').val();
                  location.href = '/v-checkout/order-address?key='+order_key;
               }, 2000);
            }
         },
         error: function(res) {
            $('#modal_mess').show();
            $('#modal_mess .modal-body p').html('Kết nối lỗi');
         }
      }).always(function() {
          $('.load-wrapp').hide();
      });
   });

   $('body').on('click','.delete-address', function (){
      var parent_this = $(this).parent('.btn-default');
      var id = parent_this.data('id');
      var active = parent_this.data('active');
      var id_max = $('.id_max').val();
      var use_name = parent_this.data('name');

      mess = 'Bạn muốn xóa thông tin người nhận hàng: <b>'+parent_this.data('name')+'</b>';
      $('#modal_mess').modal('show');
      $('#modal_mess .modal-body p').html(mess);
      $('#modal_mess .buttons-direct .btn-ok').text('Xác nhận');
      $('#modal_mess .buttons-direct .btn-ok').removeClass(' hidden');

      $('.btn-ok').on('click',function(){
         $('#modal_mess').modal('hide');
         $('#modal_mess .modal-body p').html('');
         $('.load-wrapp').show();
         $.ajax({
            type: "POST",
            url: '/home/checkout/delete_address',
            dataType: 'json',
            data: {id: id, active: active, id_max: id_max},
            success: function(res) {
               
               if(res.error == true){
                  $('#modal_mess').show();
                  $('#modal_mess .buttons-direct .btn-ok').addClass(' hidden');
                  mess = 'Xóa thông tin thất bại';
                  $('#modal_mess .modal-body p').html(mess);
               }else{
                  $('#item-'+id).remove();
               }
            },
            error: function(res) {
               $('#modal_mess').show();
               $('#modal_mess .modal-body p').html('Kết nối lỗi');
            }
         }).always(function() {
             $('.load-wrapp').hide();
         });
      });
   });

   $( document ).ready(function() {
      $('.orderAddress').on('hidden.bs.modal',function(){
         $('.orderAddress .modal-title').text('Thêm thông tin người nhận mới');
         $('.orderAddress p.note').text('');
         $('.orderAddress').attr('id','addAddress');
         $('.orderAddress input[name=name]').val('');
         $('.orderAddress input[name=phone]').val('');
         $('.orderAddress input[name=semail]').val('');
         $('.orderAddress input[name=address]').val('');
      })
   });

   $('.js-choose-address').click(function(){
      var id_address = $(this).attr('data-id');
      $('.form-info-delivery .id_address').val(id_address);
      $('.form-info-delivery').submit();
   });
   
</script>