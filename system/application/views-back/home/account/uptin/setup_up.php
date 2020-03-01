<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<?
define("CHIPHIUPTIN",500);
?>
<script>
var is_ok_matin = 0;
Number.prototype.formatMoney = function(c, d, t){
var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

function checkAccount(){

	var num_up = jQuery("#num_up").val();
	if(isNaN(num_up)){
			jAlert('Dữ liệu không hợp lệ', "Lỗi");
			return ;
	}
	var balance = jQuery("#balance").val();
	var chiphiuptin = <? echo $chiphiuptin; ?>;
	var tongchiphi = chiphiuptin * num_up;
	jQuery('#chiphi').html(tongchiphi.formatMoney(0, '.', ',')+" VNĐ");
	if(num_up>100){
			jAlert('Vui lòng nhập số nhỏ hơn 100 ', "Lỗi");
			jQuery("#num_up").val(0);
	}
	if(chiphiuptin * num_up>balance){		
		jAlert('Tài khoản của bạn không đủ thực hiện giao dịch ',"Lỗi");
		jQuery("#num_up").val(0);
	}
}
jQuery(document).ready(function(){
	checkAccount();
});
function checkTin(){
	var matinup = jQuery("#matinup").val();
	var type = jQuery("#loaiUpTin").val();

	var url = "<? echo base_url()?>/account/checkid/"+type+"/"+matinup;

	jQuery.get(url, function(response) {
		if(response==0){
			jAlert('Tin này không tồn tại, vui lòng kiểm tra lại!',"Lỗi");
			jQuery("#matinup").val("");
			is_ok_matin = 0;
		}else{
			 is_ok_matin = 1;
		
		}    
	});		
}
function checkSubmit(){
	var matinup = jQuery("#matinup").val();
	var thungay = jQuery("#thungay").val();
	var thoigian = jQuery("#thoigian").val();	
	var type = jQuery("#loaiUpTin").val();
	var url = "<? echo base_url()?>/account/checkid/"+type+"/"+matinup;
					
	if(is_ok_matin==0){
			jAlert('Tin này không tồn tại, vui lòng kiểm tra lại!', "Lỗi");
			jQuery("#matinup").val("");
			return false;
	}
	
	if(isNaN(matinup) || matinup ==null || matinup ==""){
			jQuery('#matinup').jAlert('Dữ liệu không hợp lệ', "Lỗi");
			return false;
	}
	if(thungay =="" || thungay ==null ){
			jAlert('Vui lòng chọn thứ ngày thiết lập', "Lỗi");
			return false;
	}
	if(thoigian =="" || thoigian ==null){
			jAlert('Vui lòng chọn thời gian thiết lập', "Lỗi");
			return false;
	}
	return true;

}
</script>
<div class="col-lg-9">
<table class="table table-bordered "  width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
      <div class="tile_modules tile_modules_blue">
      <div class="fl"></div>
      <div class="fc">
      THIẾT LẬP TỰ ĐỘNG UP TIN
      </div>
      <div class="fr"></div>
      </div>
      </td>
    </tr>
    <tr>
      <td class="k_fixpaddingie"   valign="top" ><form  name="uptin" action="<?php echo base_url(); ?>/account/setup_up" method="post" onsubmit="return checkSubmit();">
          
          <div class="uptin-wrapper">
           <div class="single_line">
              <div class="label list_post"><font color="#FF0000"><b>*</b></font>Lựa Chọn Loại</div>
              <div class="field">
                <select name="loaiUpTin" class="input_formpost k_heightinput_formpost" id="loaiUpTin">
                  <option value="1">Up Tin Sản Phẩm</option>
                  <option value="2">Up Tin Rao Vặt</option>
                </select>
              </div>
            </div>
            <div class="single_line">
              <div class="label list_post"><font color="#FF0000"><b>*</b></font>Mã Tin Up</div>
              <div class="field">
                <input name="matinup" type="text" class="input_formpost" id="matinup" onblur="checkTin()">
                
                
              </div>
            </div>
           
            <div  class="single_line k_centerline">Để sử dụng tính năng tự động up, bạn sẽ trả 500đ/ mỗi lần up</div>
            <div  class="single_line">
              <div class="label list_post"><font color="#FF0000"><b>*</b></font>Bạn muốn tự động up:</div>
              <div class="field">
                <input name="num_up" type="text" class="input_formpost" onkeyup="checkAccount();"   id="num_up">
                lần (<100 lần)
                </div>
              </div>
                 <div  class="single_line k_centerline"> Chi phí:
                <span id="chiphi" style="color:red"></span>
              </div>
              <div  class="single_line k_centerline"> Số tiền trong tài khoản của bạn:
                <span id="sotientrongtaikhoan"><? echo formatMoney($balance) ?> VNĐ</span>
                <input name="balance" type="hidden" value="<? echo $balance ?>" id="balance"/>
              </div>
              <div  class="single_line">
                <div  class="label list_post"> <font color="#FF0000"><b>*</b></font>Chọn ngày trong tuần(nhấn Ctrl và lựa chọn nhiều giá trị):</div>
                <div  class="field">
                  <select name="thungay[]" id="thungay" multiple="multiple" style="width:200px; height:100px" >
                    <option value="1">Chủ Nhật</option>
                    <option value="2">Thứ 2</option>
                    <option value="3">Thứ 3</option>
                    <option value="4">Thứ 4</option>
                    <option value="5">Thứ 5</option>
                    <option value="6">Thứ 6</option>
                    <option value="7">Thứ 7</option>
                  </select>
                </div>
              </div>
              <div  class="single_line">
                <div  class="label list_post"> <font color="#FF0000"><b>*</b></font>Thời gian up tin trong ngày(nhấn Ctrl và lựa chọn nhiều giá trị) </div>
                <div  class="field">
                  <select name="thoigian[]" id="thoigian" multiple="multiple" style="width:200px; height:200px" >
                    <? for ($i=0;  $i<24; $i++){?>
                    <option value="<? echo $i;?>:00"><? echo $i;?>:00</option>
                    <option value="<? echo $i;?>:15"><? echo $i;?>:15</option>
                    <option value="<? echo $i;?>:30"><? echo $i;?>:30</option>
                    <option value="<? echo $i;?>:45"><? echo $i;?>:45</option>
                    <? }?>
                  </select>
                </div>
              </div>
           
              <div  class="single_line">
              <div  class="label list_post"> </div>   <div  class="field"><input name="submit" type="submit" value="Thực Hiện"></div>
              </div>
            </div>
          </div>
          <input name="submit_form" type="hidden" value="1" />
        </form></td>
    </tr>
    <tr>
     <td>
      			<div class="border_bottom_blue">
                	<div class="fl"></div>
                    <div class="fr"></div>
                </div>
      </td>
    </tr>
  </table></div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
