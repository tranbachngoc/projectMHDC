/*BEGIN: OpenTab*/
// ltngan
function getDistrict(siteUrl, province_id){
	if($("#user_province_get").val()){
		$.ajax({
			url     : siteUrl  +'administ/user/getDistrict',
			type    : "POST",
			data    : {user_province_put:province_id},
			cache   : true,
			beforeSend: function(){
				document.getElementById("user_province_get").disabled = true;
			},
			success:function(response)
			{
				document.getElementById("user_province_get").disabled = false;
				if(response){
					var json = JSON.parse(response);
					emptySelectBoxById('user_district_get',json);
					delete json;
				} else {
					alert("Lỗi! Vui lòng thử lại");
				}
			},
			error: function()
			{
				alert("Lỗi! Vui lòng thử lại");
			}
		});
	}
}
function getUserInfo(id,baseUrl){
	$.ajax({
			   type: "POST",
			   url: baseUrl + "administ/defaults/ajax",
			   data: "id=" + id,
			   dataType: "json",
			   success: function(data){
					$('#address_shop').val(data[0].use_address);
					$("#province_shop option[value="+data[0].use_province+"]").attr("selected","selected") ;
					$('#link_shop').val(data[0].use_username);
					$('#phone_shop').val(data[0].use_phone);
					$('#mobile_shop').val(data[0].use_mobile);
					$('#email_shop').val(data[0].use_email);
					$('#yahoo_shop').val(data[0].use_yahoo);
					$('#skype_shop').val(data[0].use_skype);
			   						  },
			   error: function(){}
		 	});

}
function isValueCommissionSolution(number)
{
    var str="0123456789.-";
    for(var i=0;i<number.length;i++)
    {
        if(str.indexOf(number.charAt(i)) == -1)
        {
            return false;
        }
    }
    return true;
}
/// content
function check_edit_content_cate(parent_id,level,baseUrl){
	jQuery('#hd_category_id').val('');
	if(parent_id=="")
	{
		jQuery('#hoidap_1').css('display','none');
		jQuery('#hoidap_2').css('display','none');
		jQuery('#hd_category_id').val("");
		return false;
	}
	if(level == 0){
		jQuery('#hoidap_1').css('display','none');
		jQuery('#hoidap_2').css('display','none');
	}
	if(level == 1){
		jQuery('#hoidap_2').css('display','none');
	}

	jQuery.ajax({
		type: "POST",
		url: baseUrl + "administ/content/ajax_category_content",
		data: "parent_id=" + parent_id,
		dataType: "json",
		success: function(data){
			jQuery('#hd_category_id').val(parent_id);
			if(data[1] > 0)
			{
				str = '<select id="hd_select_'+parseInt(level+1)+'" class="form_control_hoidap_select" onclick="check_edit_content_cate(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');  " size="14" onblur="getManAndCategory4Search(\''+baseUrl+'\');" style="width:170px">';
				for(i = 0; i < data[1]; i++)
				{
					str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name;
					if(data[0][i].child_count >0){
						str += ' >';
					}
					str += '</option>';
				}
				str += '</select>';
				jQuery('#hoidap_'+parseInt(level+1)).html(str);
				jQuery('#hoidap_'+parseInt(level+1)).css('display','inline');
			}
		},
		error: function(){alert("No Data!");}
	});



}


function check_cat_content(parent_id,level,baseUrl){
	jQuery('#parent_id').val('');
	jQuery('#cat_level').val(parseInt(level+1));
	if(level == 0){
		jQuery('#parent_1').css('display','none');
		$temp = parent_id.split('-');
		parent_id = $temp[0];
		jQuery('#cat_index').val($temp[1]);
	}
	if(parent_id != 0){
		jQuery.ajax({
			type: "POST",
			url: baseUrl + "ctcategory/ajax",
			data: "parent_id=" + parent_id,
			dataType: "json",
			success: function(data){
				if(data[1] > 0)
				{
					str = '<select id="cat_select_'+parseInt(level+1)+'" onclick="check_cat_content(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');" size="10">';
					for(i = 0; i < data[1]; i++)
					{
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name+'</option>';
					}
					str += '</select>';
					jQuery('#parent_'+parseInt(level+1)).html(str);
					jQuery('#parent_'+parseInt(level+1)).css('display','inline');
					jQuery('#parent_id').val(parent_id);
				}
				else
				{
					jQuery('#parent_id').val(parent_id);
				}
			},
			error: function(){alert("No Data!");}
		});
	}else{
		jQuery('#parent_id').val(0);
		jQuery('#cat_level').val(0);
	}
}

function OpenTabSearch(val,status)
{
	switch (status)
	{
		case 1:
			if(val == '1' || val == '2')
			{
				document.getElementById('DivDateSearch_1').style.display = "";
				document.getElementById('DivDateSearch_2').style.display = "";
				document.getElementById('DivDateSearch_3').style.display = "";
				document.getElementById('DivDateSearch_4').style.display = "";
				document.getElementById('DivDateSearch_5').style.display = "";
				document.getElementById('DivDateSearch_6').style.display = "";
			}
			else if(val == '3')
			{
				document.getElementById('DivDateSearch_7').style.display = "";
				document.getElementById('DivDateSearch_8').style.display = "";
			}
			else if(val == '4')
			{
				//from date
				document.getElementById('DivDateSearch_1').style.display = "";
				document.getElementById('DivDateSearch_2').style.display = "";
				document.getElementById('DivDateSearch_3').style.display = "";
				document.getElementById('DivDateSearch_4').style.display = "";
				document.getElementById('DivDateSearch_5').style.display = "";
				document.getElementById('DivDateSearch_6').style.display = "";
				//to date
				document.getElementById('DivDateSearch_9').style.display = "";
				document.getElementById('DivDateSearch_10').style.display = "";
				document.getElementById('DivDateSearch_11').style.display = "";
				document.getElementById('DivDateSearch_12').style.display = "";
				document.getElementById('DivDateSearch_13').style.display = "";
				document.getElementById('DivDateSearch_14').style.display = "";
			}
			else if(val == '5')
			{
				document.getElementById('DivDateSearch_15').style.display = "";
				document.getElementById('DivDateSearch_16').style.display = "";
			}
			else
			{
				document.getElementById('DivDateSearch_1').style.display = "none";
				document.getElementById('DivDateSearch_2').style.display = "none";
				document.getElementById('DivDateSearch_3').style.display = "none";
				document.getElementById('DivDateSearch_4').style.display = "none";
				document.getElementById('DivDateSearch_5').style.display = "none";
				document.getElementById('DivDateSearch_6').style.display = "none";
				document.getElementById('DivDateSearch_7').style.display = "none";
				document.getElementById('DivDateSearch_8').style.display = "none";
				document.getElementById('DivDateSearch_9').style.display = "none";
				document.getElementById('DivDateSearch_10').style.display = "none";
				document.getElementById('DivDateSearch_11').style.display = "none";
				document.getElementById('DivDateSearch_12').style.display = "none";
				document.getElementById('DivDateSearch_13').style.display = "none";
				document.getElementById('DivDateSearch_14').style.display = "none";
				document.getElementById('DivDateSearch_15').style.display = "none";
				document.getElementById('DivDateSearch_16').style.display = "none";
			}
			break;
		default:
            var currentURL = $(location).attr('href');
            var url = currentURL
            var arguments = url.split('#').pop().split('=').pop();
            if(arguments =='statisticaldate'){
                document.getElementById('DivDateSearch_1').style.display = "";
                document.getElementById('DivDateSearch_2').style.display = "";
                document.getElementById('DivDateSearch_3').style.display = "";
                document.getElementById('DivDateSearch_4').style.display = "";
                document.getElementById('DivDateSearch_5').style.display = "";
                document.getElementById('DivDateSearch_6').style.display = "";
                //to date
                document.getElementById('DivDateSearch_9').style.display = "";
                document.getElementById('DivDateSearch_10').style.display = "";
                document.getElementById('DivDateSearch_11').style.display = "";
                document.getElementById('DivDateSearch_12').style.display = "";
                document.getElementById('DivDateSearch_13').style.display = "";
                document.getElementById('DivDateSearch_14').style.display = "";
            }else {
			document.getElementById('DivDateSearch_1').style.display = "none";
			document.getElementById('DivDateSearch_2').style.display = "none";
			document.getElementById('DivDateSearch_3').style.display = "none";
			document.getElementById('DivDateSearch_4').style.display = "none";
			document.getElementById('DivDateSearch_5').style.display = "none";
			document.getElementById('DivDateSearch_6').style.display = "none";
			document.getElementById('DivDateSearch_7').style.display = "none";
			document.getElementById('DivDateSearch_8').style.display = "none";
			document.getElementById('DivDateSearch_9').style.display = "none";
			document.getElementById('DivDateSearch_10').style.display = "none";
			document.getElementById('DivDateSearch_11').style.display = "none";
			document.getElementById('DivDateSearch_12').style.display = "none";
			document.getElementById('DivDateSearch_13').style.display = "none";
			document.getElementById('DivDateSearch_14').style.display = "none";
			document.getElementById('DivDateSearch_15').style.display = "none";
			document.getElementById('DivDateSearch_16').style.display = "none";
	}
	}
}


function check_link_shopq(baseUrl,tenlink,idUser)
{

    	jQuery.ajax({
			   type: "POST",
			   url: baseUrl + "kiem_tra_link_shop",
			   data: "tenlink="+tenlink+"& idUser="+idUser,
			   success: function(data){

				   if(data!="")
				   {
					   alert("Link vào xem gian hàng của bạn đã bị trùng với gian hàng khác, vui lòng nhập link khác");
					   jQuery('#link_shop').val('');
					   	document.getElementById('link_shop').focus();
				   }

				},
			   error: function(){}
		 	});

}


function OpenTabEndday(div,val,status)
{
	switch (status)
	{
		case 1://Neu chon VIP
			if(val == "2")
			{
				document.getElementById(div).style.display = "";
			}
			else
			{
				document.getElementById(div).style.display = "none";
			}
			break;
		case 2://Hien DivEndDay
			document.getElementById(div).style.display = "";
			break;
		default://An DivEndDay
			document.getElementById(div).style.display = "none";
	}
}

function OpenTabReply(status)
{
	switch (status)
	{
		case 1://Hien
			if(document.getElementById('DivReply').style.display == "")
			{
				document.getElementById('DivReply').style.display = "none";
				document.getElementById('icon_item_2').style.display = "none";
			}
			else
			{
				document.getElementById('DivReply').style.display = "";
				document.getElementById('icon_item_2').style.display = "";
			}
			break;
		case 2://Luon hien
			document.getElementById('DivReply').style.display = "";
			document.getElementById('icon_item_2').style.display = "";
			break;
		default://An
			document.getElementById('DivReply').style.display = "none";
			document.getElementById('icon_item_2').style.display = "none";
	}
}
/*END OpenTab*/
/*BEGIN: ShowImage*/
function ShowImage(getdiv,div,path)
{
	document.getElementById(div).innerHTML = '<img src="' + path + '/' + document.getElementById(getdiv).value + '" border="0" />';
}
/*END ShowImage*/
/*BEGIN: Check Character*/
function CheckCharacter(char)
{
	var str="0123456789abcdefghikjlmnopqrstuvwxyszABCDEFGHIKJLMNOPQRSTUVWXYSZ@.-_";
	for(var i=0;i<char.length;i++)
	{
		if(str.indexOf(char.charAt(i)) == -1)
		{
			return false;
		}
	}
	return true;//Dung la ky tu cho phep
}
/*END Check Character*/
/*BEGIN: Kiem Tra TextBox Co Rong*/
function TrimInput(sString)
{
	while(sString.substring(0,1) == ' ')
	{
		sString = sString.substring(1, sString.length);
	}
	while(sString.substring(sString.length-1, sString.length) == ' ')
	{
		sString = sString.substring(0,sString.length-1);
	}
	return sString;
}

function CheckBlank(str)
{
	if(TrimInput(str) == '')
		return true;//Neu chua nhap
	else
		return false;//Neu da nhap
}
/*END Kiem Tra TextBox Co Rong*/
/*BEGIN: Check Phone*/
function CheckPhone(number)
{
	if(number.length < 5 || number.length > 16)
	{
		return false;
	}
	else
	{
		var str="0123456789.()";
		for(var i=0;i<number.length;i++)
		{
			if(str.indexOf(number.charAt(i)) == -1)
			{
				return false;
			}
		}
	}
	return true;//Dung so dien thoai
}
/*END Check Phone*/
/*BEGIN: Kiem Tra Ngay Co Lon Hon Ngay Hien Tai - Neu Hop Le Tra Ve true*/
function CheckDate(isday,ismonth,isyear)
{
   	var vdate = new Date();
   	var vday = vdate.getDate();
   	var vmonth = vdate.getMonth();
   	var vyear = vdate.getFullYear();
	vmonth = vmonth + 1;
	isday = isday*1;
	ismonth = ismonth*1;
	isyear = isyear*1;
	if(isyear > vyear)
	{
		return true;//Hop le
	}
	if(isyear == vyear)
	{
		if(ismonth > vmonth)
		{
			return true;//Hop le
		}
		if(ismonth == vmonth)
		{
			if(isday > vday)
			{
				return true;//Hop le
			}
			else
			{
				return false;//Khong hop le
			}
		}
		else
		{
			return false;//Khong hop le
		}
	}
	else
	{
		return false;//Khong hop le
	}
}
/*END Kiem Tra Ngay Co Lon Hon Ngay Hien Tai*/
/*BEGIN: Check Link*/
function CheckLink(char)
{
	var str="0123456789abcdefghikjlmnopqrstuvwxysz-_";
	for(var i=0;i<char.length;i++)
	{
		if(str.indexOf(char.charAt(i)) == -1)
		{
			return true;
		}
	}
	return true;//Dung la ky tu cho phep
}
/*END Check Link*/
/*BEGIN: Check Website*/
function CheckWebsite(char)
{
	var str="0123456789abcdefghikjlmnopqrstuvwxysz/.:-_";
	for(var i=0;i<char.length;i++)
	{
		if(str.indexOf(char.charAt(i)) == -1)
		{
			return true;
		}
	}
	return true;//Dung la ky tu cho phep
}
/*END Check Website*/
/*BEGIN: CheckInput*/
function CheckInput_AddUser()
{

	if(CheckBlank(document.getElementById('username_user').value))
	{
		alert("Bạn chưa nhập tài khoản!");
		document.getElementById('username_user').focus();
		return false;
	}
	if(!CheckCharacter(document.getElementById('username_user').value))
	{
		alert("Tài khoản bạn nhập không hợp lệ!\nChỉ chấp nhận các ký số 0-9\nChấp nhận các ký tự a-z hoặc A-Z\nChấp nhận các ký tự - _");
		document.getElementById('username_user').focus();
		return false;
	}
	var username = document.getElementById('username_user').value;
	if(username.length < 6)
	{
		alert("Tài khoản phải có ít nhất 6 ký tự!");
		document.getElementById('username_user').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('password_user').value))
	{
		alert("Bạn chưa nhập mật khẩu!");
		document.getElementById('password_user').focus();
		return false;
	}
	var password = document.getElementById('password_user').value;
	if(password.length < 6)
	{
		alert("Mật khẩu phải có ít nhất 6 ký tự!");
		document.getElementById('password_user').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('email_user').value))
	{
		alert("Bạn chưa nhập email!");
		document.getElementById('email_user').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('email_user').value))
	{
		alert("Email bạn nhập không hợp lê!");
		document.getElementById('email_user').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('fullname_user').value))
	{
		alert("Bạn chưa nhập họ tên!");
		document.getElementById('fullname_user').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('address_user').value))
	{
		alert("Bạn chưa nhập địa chỉ!");
		document.getElementById('address_user').focus();
		return false;
	}


	 if(!CheckBlank(document.getElementById('mobile_user').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_user').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_user').focus();
			return false;
		 }
	 }

	 var status_role = document.getElementById('role_user').value;
	 if(status_role == "VIP")
	 {
		 if(!CheckDate(document.getElementById('endday_user').value,document.getElementById('endmonth_user').value,document.getElementById('endyear_user').value))
		 {
			 alert("Ngày hết hạn không hợp lệ!\nNgày hết hạn phải lớn hơn ngày hiện tại.");
			 return false;
		 }
	 }

	if(document.getElementById('role_user').value == 6
	|| document.getElementById('role_user').value == 7
	|| document.getElementById('role_user').value == 8
	|| document.getElementById('role_user').value == 9
	){
		if(document.getElementById('sponser_user').value ==''){
			alert("Bạn phải nhập Người giới thiệu cho thành viên này!");
			return false;
		}
	}
	document.frmAddUser.submit();
}

function CheckInput_EditPayment(){
    document.getElementById("payment_info").submit();
}
function CheckInput_EditUser()
{
	if(CheckBlank(document.getElementById('username_user').value))
	{
		alert("Bạn chưa nhập tài khoản!");
		document.getElementById('username_user').focus();
		return false;
	}
	if(!CheckCharacter(document.getElementById('username_user').value))
	{
		alert("Tài khoản bạn nhập không hợp lệ!\nChỉ chấp nhận các ký số 0-9\nChấp nhận các ký tự a-z hoặc A-Z\nChấp nhận các ký tự - _");
		document.getElementById('username_user').focus();
		return false;
	}
	var username = document.getElementById('username_user').value;
	if(username.length < 6)
	{
		alert("Tài khoản phải có ít nhất 6 ký tự!");
		document.getElementById('username_user').focus();
		return false;
	}

	if(!CheckBlank(document.getElementById('password_user').value))
	{
		var password = document.getElementById('password_user').value;
		if(password.length < 6)
		{
			alert("Mật khẩu phải có ít nhất 6 ký tự!");
			document.getElementById('password_user').focus();
			return false;
		}
	}

	if(CheckBlank(document.getElementById('email_user').value))
	{
		alert("Bạn chưa nhập email!");
		document.getElementById('email_user').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('email_user').value))
	{
		alert("Email bạn nhập không hợp lê!");
		document.getElementById('email_user').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('fullname_user').value))
	{
		alert("Bạn chưa nhập họ tên!");
		document.getElementById('fullname_user').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('address_user').value))
	{
		alert("Bạn chưa nhập địa chỉ!");
		document.getElementById('address_user').focus();
		return false;
	}


	 if(!CheckBlank(document.getElementById('mobile_user').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_user').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_user').focus();
			return false;
		 }
	 }

	 var status_role = document.getElementById('role_user').value;
	 if(status_role == "VIP")
	 {
		 if(!CheckDate(document.getElementById('endday_user').value,document.getElementById('endmonth_user').value,document.getElementById('endyear_user').value))
		 {
			 alert("Ngày hết hạn không hợp lệ!\nNgày hết hạn phải lớn hơn ngày hiện tại.");
			 return false;
		 }
	 }
	document.frmEditUser.submit();
}
/********/
function CheckInput_AddShop()
{

	if(CheckBlank(document.getElementById('username_shop').value))
	{
		alert("Bạn chưa chọn  chủ gian hàng !");
		document.getElementById('username_shop').focus();
		return false;
	}
	if(CheckBlank(document.getElementById('hd_category_id').value))
	{
		alert("Bạn chưa chọn danh mục gian hàng !");
		document.getElementById('hd_category_id').focus();
		return false;
	}
	if(CheckBlank(document.getElementById('logo_shop').value))
	{
		alert("Bạn chưa chọn logo cho gian hàng!");
		document.getElementById('logo_shop').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('banner_shop').value))
	{
		alert("Bạn chưa chọn banner cho gian hàng!");
		document.getElementById('banner_shop').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('link_shop').value))
	{
		alert("Bạn chưa nhập link tới gian hàng!");
		document.getElementById('link_shop').focus();
		return false;
	}
	if(!CheckLink(document.getElementById('link_shop').value))
	{
		alert("Link tới gian hàng bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, _-");
		document.getElementById('link_shop').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('name_shop').value))
	{
		alert("Bạn chưa nhập tên công ty!");
		document.getElementById('name_shop').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('descr_shop').value))
	{
		alert("Bạn chưa nhập mô tả gian hàng!");
		document.getElementById('descr_shop').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('address_shop').value))
	{
		alert("Bạn chưa nhập địa chỉ của gian hàng!");
		document.getElementById('address_shop').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('mobile_shop').value))
	{
		alert("Bạn chưa nhập số điện thoại di động!");
		document.getElementById('mobile_shop').focus();
		return false;
	}

	 if(!CheckBlank(document.getElementById('mobile_shop').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_shop').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_shop').focus();

			return false;
		 }
	 }

	if(!CheckWebsite(document.getElementById('website_shop').value))
	{
		alert("Địa chỉ website bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, / . : _ -");
		document.getElementById('website_shop').focus();
		return false;
	}

	if(!CheckDate(document.getElementById('endday_shop').value,document.getElementById('endmonth_shop').value,document.getElementById('endyear_shop').value))
	{
		alert("Ngày hết hạn không hợp lệ!\nNgày hết hạn phải lớn hơn ngày hiện tại.");
		return false;
	}
	document.frmAddShop.submit();
}

function CheckInput_EditShop()
{

	if(document.getElementById("logo_shop").value == "" && document.getElementById("logo_shop_hiden").value == "")
	{
		alert("Chưa nhập logo");
		document.getElementById('logo_shop').focus();
		return false;
	}
	if(document.getElementById("banner_shop").value == "" && document.getElementById("banner_shop_hiden").value == "" )
	{
		alert("Chưa nhập banner");
		document.getElementById('banner_shop').focus();
		return false;
	}
	if(CheckBlank(document.getElementById('link_shop').value))
	{
		alert("Bạn chưa nhập link tới gian hàng!");
		document.getElementById('link_shop').focus();
		return false;
	}
	if(!CheckLink(document.getElementById('link_shop').value))
	{
		alert("Link tới gian hàng bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, _-");
		document.getElementById('link_shop').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('name_shop').value))
	{
		alert("Bạn chưa nhập tên công ty!");
		document.getElementById('name_shop').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('descr_shop').value))
	{
		alert("Bạn chưa nhập mô tả gian hàng!");
		document.getElementById('descr_shop').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('address_shop').value))
	{
		alert("Bạn chưa nhập địa chỉ của gian hàng!");
		document.getElementById('address_shop').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('mobile_shop').value))
	{
		alert("Bạn chưa nhập số điện thoại!");
		document.getElementById('mobile_shop').focus();
		return false;
	}
	if(!CheckPhone(document.getElementById('mobile_shop').value))
    {
	  alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
	  document.getElementById('mobile_shop').focus();
	  return false;
    }
	 if(!CheckBlank(document.getElementById('mobile_shop').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_shop').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_shop').focus();

			return false;
		 }
	 }



	if(!CheckWebsite(document.getElementById('website_shop').value))
	{
		alert("Địa chỉ website bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, / . : _ -");
		document.getElementById('website_shop').focus();
		return false;
	}

        if(CheckBlank(document.getElementById('address_kho_shop').value))
	{
		alert("Bạn chưa nhập địa chỉ KHO của gian hàng!");
		document.getElementById('address_kho_shop').focus();
		return false;
	}

        if(document.getElementById('province_kho_shop').value)
	{
		alert("Bạn chưa nhập tỉnh/thành KHO của gian hàng!");
		document.getElementById('province_kho_shop').focus();
		return false;
	}

        if(CheckBlank(document.getElementById('district_kho_shop').value))
	{
		alert("Bạn chưa nhập Quận/Huyện KHO của gian hàng!");
		document.getElementById('district_kho_shop').focus();
		return false;
	}

	document.frmEditShop.submit();
}

function CheckInput_AddAdvertise()
{
	if(jQuery('#banner_adv')[0].files[0]){

		if(jQuery('#banner_adv')[0].files[0].size > 1024*1024){
			jAlert('Dung lượng logo upload tối đa 1MB','Notice');
			return false;
		}
	}
	if(CheckBlank(document.getElementById('title_adv').value))
	{
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_adv').focus();
		return false;
	}
	if(CheckBlank(document.getElementById('ub_format_0').value))
	{
		alert("Bạn chưa chọn định dạng banner !");
		document.getElementById('ub_format_0').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('banner_adv').value) && CheckBlank(document.getElementById('link_frame').value) )
	{
		alert("Bạn chưa chọn banner!");
		document.getElementById('banner_adv').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('link_adv').value))
	{
		alert("Bạn vui lòng nhập đúng định dạng URL, ví dụ: Azibai.com!");
		document.getElementById('link_adv').focus();
		return false;
	}



	var lengurl = document.getElementById('link_adv').value;
	lengurl = lengurl.length;
	if(CheckBlank(document.getElementById('link_adv').value) || document.getElementById('link_adv').value == "http://" || lengurl <= 3)
	{
		alert("Bạn chưa nhập link liên kết!");
		document.getElementById('link_adv').focus();
		return false;
	}
	if(!CheckWebsite(document.getElementById('link_adv').value))
	{
		alert("Link liên kết bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, / . : _ -");
		document.getElementById('link_adv').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('order_adv').value))
	{
		alert("Bạn chưa nhập thứ tụ hiển thị!");
		document.getElementById('order_adv').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('name_adv').value))
	{
		alert("Bạn chưa nhập nhà quảng cáo!");
		document.getElementById('name_adv').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('address_adv').value))
	{
		alert("Bạn chưa nhập địa chỉ của nhà quảng cáo!");
		document.getElementById('address_adv').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('phone_adv').value) && CheckBlank(document.getElementById('mobile_adv').value))
	{
		alert("Bạn chưa nhập số điện thoại!\nBạn phải nhập ít nhất một số điện thoại.");
		document.getElementById('phone_adv').focus();
		return false;
	}
	if(!CheckBlank(document.getElementById('phone_adv').value))
	 {
		 if(!CheckPhone(document.getElementById('phone_adv').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('phone_adv').focus();
			return false;
		 }
	 }
	 if(!CheckBlank(document.getElementById('mobile_adv').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_adv').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_adv').focus();
			return false;
		 }
	 }

	if(CheckBlank(document.getElementById('email_adv').value))
	{
		alert("Bạn chưa nhập email!");
		document.getElementById('email_adv').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('email_adv').value))
	{
		alert("Email bạn nhập không hợp lê!");
		document.getElementById('email_adv').focus();
		return false;
	}

	if(!CheckDate(document.getElementById('endday_adv').value,document.getElementById('endmonth_adv').value,document.getElementById('endyear_adv').value))
	{
		alert("Ngày hết hạn không hợp lệ!\nNgày hết hạn phải lớn hơn ngày hiện tại.");
		return false;
	}
	document.frmAddAdvertise.submit();
}

function CheckInput_EditAdvertise()
{
	if(jQuery('#banner_adv')[0].files[0]){

		if(jQuery('#banner_adv')[0].files[0].size > 1024*1024){
			jAlert('Dung lượng logo upload tối đa 1MB ','Notice');
			return false;
		}
	}
	if(CheckBlank(document.getElementById('title_adv').value))
	{
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_adv').focus();
		return false;
	}
	if(CheckBlank(document.getElementById('ub_format_0').value))
	{
		alert("Bạn chưa chọn định dạng banner!");
		document.getElementById('ub_format_0').focus();
		return false;
	}

	var lengurl = document.getElementById('link_adv').value;
	lengurl = lengurl.length;
	if(CheckBlank(document.getElementById('link_adv').value) || document.getElementById('link_adv').value == "http://" || lengurl <= 3)
	{
		alert("Bạn chưa nhập link liên kết!");
		document.getElementById('link_adv').focus();
		return false;
	}
	if(CheckBlank(document.getElementById('link_adv').value))
	{
		alert("Bạn vui lòng nhập đúng định dạng URL, ví dụ: Azibai.com!");
		document.getElementById('link_adv').focus();
		return false;
	}


	if(CheckBlank(document.getElementById('order_adv').value))
	{
		alert("Bạn chưa nhập thứ tụ hiển thị!");
		document.getElementById('order_adv').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('name_adv').value))
	{
		alert("Bạn chưa nhập nhà quảng cáo!");
		document.getElementById('name_adv').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('address_adv').value))
	{
		alert("Bạn chưa nhập địa chỉ của nhà quảng cáo!");
		document.getElementById('address_adv').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('phone_adv').value) && CheckBlank(document.getElementById('mobile_adv').value))
	{
		alert("Bạn chưa nhập số điện thoại!\nBạn phải nhập ít nhất một số điện thoại.");
		document.getElementById('phone_adv').focus();
		return false;
	}
	if(!CheckBlank(document.getElementById('phone_adv').value))
	 {
		 if(!CheckPhone(document.getElementById('phone_adv').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('phone_adv').focus();
			return false;
		 }
	 }
	 if(!CheckBlank(document.getElementById('mobile_adv').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_adv').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_adv').focus();
			return false;
		 }
	 }

	if(CheckBlank(document.getElementById('email_adv').value))
	{
		alert("Bạn chưa nhập email!");
		document.getElementById('email_adv').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('email_adv').value))
	{
		alert("Email bạn nhập không hợp lê!");
		document.getElementById('email_adv').focus();
		return false;
	}

	if(!CheckDate(document.getElementById('endday_adv').value,document.getElementById('endmonth_adv').value,document.getElementById('endyear_adv').value))
	{
		alert("Ngày hết hạn không hợp lệ!\nNgày hết hạn phải lớn hơn ngày hiện tại.");
		return false;
	}
	document.frmEditAdvertise.submit();
}
/*******/
function CheckInput_AddNotify()
{
	if(CheckBlank(document.getElementById('title_notify').value))
	{
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_notify').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('txtContent').value))
	{
		alert("Bạn chưa nhập nội dung thông báo!");
		document.getElementById('txtContent').focus();
		return false;
	}

	if(!CheckDate(document.getElementById('endday_notify').value,document.getElementById('endmonth_notify').value,document.getElementById('endyear_notify').value))
	{
		alert("Ngày hết hạn không hợp lệ!\nNgày hết hạn phải lớn hơn ngày hiện tại.");
		return false;
	}
	document.frmAddNotify.submit();
}

function CheckInput_EditNotify()
{
	if(CheckBlank(document.getElementById('title_notify').value))
	{
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_notify').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('txtContent').value))
	{
		alert("Bạn chưa nhập nội dung thông báo!");
		document.getElementById('txtContent').focus();
		return false;
	}

	if(!CheckDate(document.getElementById('endday_notify').value,document.getElementById('endmonth_notify').value,document.getElementById('endyear_notify').value))
	{
		alert("Ngày hết hạn không hợp lệ!\nNgày hết hạn phải lớn hơn ngày hiện tại.");
		return false;
	}
	document.frmEditNotify.submit();
}
/*******/
function CheckInput_ReplyContact()
{
	if(CheckBlank(document.getElementById('txtContent').value))
	{
		alert("Bạn chưa nhập nội dung thư trả lời!");
		document.getElementById('txtContent').focus();
		return false;
	}
	document.frmReplyContact.submit();
}
/********/
function CheckInput_AddCategory()
{
	/*if(document.getElementById('image_category').value == "")
	{
		alert("Bạn chưa chọn ảnh!");
		document.getElementById('image_category').focus();
		return false;
	}*/

	if(CheckBlank(document.getElementById('name_category').value))
	{
		alert("Bạn chưa nhập danh mục!");
		document.getElementById('name_category').focus();
		return false;
	}



	if(CheckBlank(document.getElementById('order_category').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_category').focus();
		return false;
	}
	document.frmAddCategory.submit();
}
/********/
function CheckInput_AddHDCategory()
{
	if(CheckBlank(document.getElementById('name_category').value))
	{
		alert("Bạn chưa nhập danh mục!");
		document.getElementById('name_category').focus();
		return false;
	}
	if(CheckBlank(document.getElementById('order_category').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_category').focus();
		return false;
	}
	document.frmAddCategory.submit();
}

//Quang check null value manufacture
function CheckInput_Addmanufacture()
{

	if(CheckBlank(document.getElementById('name_manufacturer').value))
	{
		alert("Bạn chưa nhập tên nhà sản xuất!");
		document.getElementById('name_manufacturer').focus();
		return false;
	}
	if(CheckBlank(document.getElementById('hd_category_id').value))
	{
		alert("Bạn chưa nhập danh mục!");
		document.getElementById('hd_category_id').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('order_manufacturer').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_manufacturer').focus();
		return false;
	}
	document.frmAddCategory.submit();
}
// end Quang

function CheckInput_EditCategory()
{


	if(CheckBlank(document.getElementById('name_category').value))
	{
		alert("Bạn chưa nhập danh mục!");
		document.getElementById('name_category').focus();
		return false;
	}



	if(CheckBlank(document.getElementById('order_category').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_category').focus();
		return false;
	}
    if(isValueCommissionSolution(document.getElementById('cat_fee').value) == false){
        alert("Dữ liệu không hợp lệ!");
        document.getElementById('cat_fee').focus();
        return false;
    }
	document.frmEditCategory.submit();
}
/********/
function CheckInput_AddField()
{

	if(CheckBlank(document.getElementById('name_field').value))
	{
		alert("Bạn chưa nhập ngành nghề!");
		document.getElementById('name_field').focus();
		return false;
	}



	if(CheckBlank(document.getElementById('order_field').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_field').focus();
		return false;
	}
	document.frmAddField.submit();
}

function CheckInput_EditField()
{

	if(CheckBlank(document.getElementById('name_field').value))
	{
		alert("Bạn chưa nhập ngành nghề!");
		document.getElementById('name_field').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('order_field').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_field').focus();
		return false;
	}
	document.frmEditField.submit();
}
/********/
function CheckInput_AddMenu()
{


	if(CheckBlank(document.getElementById('name_menu').value))
	{
		alert("Bạn chưa nhập menu!");
		document.getElementById('name_menu').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('descr_menu').value))
	{
		alert("Bạn chưa nhập mô tả!");
		document.getElementById('descr_menu').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('order_menu').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_menu').focus();
		return false;
	}
	document.frmAddMenu.submit();
}

function CheckInput_EditMenu()
{


	if(CheckBlank(document.getElementById('name_menu').value))
	{
		alert("Bạn chưa nhập menu!");
		document.getElementById('name_menu').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('descr_menu').value))
	{
		alert("Bạn chưa nhập mô tả!");
		document.getElementById('descr_menu').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('order_menu').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_menu').focus();
		return false;
	}
	document.frmEditMenu.submit();
}
/********/
function CheckInput_AddProvince()
{
	if(CheckBlank(document.getElementById('name_province').value))
	{
		alert("Bạn chưa nhập Tỉnh/Thành phố!");
		document.getElementById('name_province').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('order_province').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_province').focus();
		return false;
	}
	document.frmAddProvince.submit();
}

function CheckInput_AddDistrict()
{
	if(CheckBlank(document.getElementById('name_district').value))
	{
		alert("Bạn chưa nhập Quận/Huyện!");
		document.getElementById('name_district').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('districtCode').value))
	{
		alert("Bạn chưa nhập mã số quận huyện!");
		document.getElementById('districtCode').focus();
		return false;
	}

        if(CheckBlank(document.getElementById('province').value))
	{
		alert("Bạn chưa nhập Tỉnh/Thành phố!");
		document.getElementById('province').focus();
		return false;
	}

	document.frmAddProvince.submit();
}

function CheckInput_EditDistrict()
{
	if(CheckBlank(document.getElementById('name_district').value))
	{
		alert("Bạn chưa nhập Quận/Huyện!");
		document.getElementById('name_district').focus();
		return false;
	}
	document.frmEditDistrict.submit();
}

function CheckInput_EditProvince()
{
	if(CheckBlank(document.getElementById('name_province').value))
	{
		alert("Bạn chưa nhập Tỉnh/Thành phố!");
		document.getElementById('name_province').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('order_province').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_province').focus();
		return false;
	}
	document.frmEditProvince.submit();
}
/********/
function CheckInput_Sohapay()
{
	if(CheckBlank(document.getElementById('merchant_site_code').value))
		{
			alert("Bạn chưa nhập Merchant Site Code!");
			document.getElementById('merchant_site_code').focus();
			return false;
		}

	if(CheckBlank(document.getElementById('secure_secret').value))
		{
			alert("Bạn chưa nhập Mật khẩu!");
			document.getElementById('secure_secret').focus();
			return false;
		}

	document.frmSohapay.submit();

}
function CheckInput_Config()
{
	if(CheckBlank(document.getElementById('site_config').value))
	{
		alert("Bạn chưa nhập tên website!");
		document.getElementById('site_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('descr_config').value))
	{
		alert("Bạn chưa nhập mổ tả website!");
		document.getElementById('descr_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('keyword_config').value))
	{
		alert("Bạn chưa nhập keyword website!");
		document.getElementById('keyword_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('email1_config').value))
	{
		alert("Bạn chưa nhập email 1!");
		document.getElementById('email1_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('email2_config').value))
	{
		alert("Bạn chưa nhập email 2!");
		document.getElementById('email2_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('address1_config').value))
	{
		alert("Bạn chưa nhập địa chỉ 1!");
		document.getElementById('address1_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('address2_config').value))
	{
		alert("Bạn chưa nhập địa chỉ 2!");
		document.getElementById('address2_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('phone_config').value))
	{
		alert("Bạn chưa nhập số điện thoại 1!");
		document.getElementById('phone_config').focus();
		return false;
	}
	if(!CheckPhone(document.getElementById('phone_config').value))
   	{
	  	alert("Số điện thoại 1 bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
	 	 document.getElementById('phone_config').focus();
	 	 return false;
   	}

	if(CheckBlank(document.getElementById('mobile_config').value))
	{
		alert("Bạn chưa nhập số điện thoại 2!");
		document.getElementById('mobile_config').focus();
		return false;
	}
	if(!CheckPhone(document.getElementById('mobile_config').value))
   	{
	  	alert("Số điện thoại 2 bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
	 	 document.getElementById('mobile_config').focus();
	 	 return false;
   	}

	if(CheckBlank(document.getElementById('yahoo1_config').value))
	{
		alert("Bạn chưa nhập nick yahoo 1!");
		document.getElementById('yahoo1_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('yahoo2_config').value))
	{
		alert("Bạn chưa nhập nick yahoo 2!");
		document.getElementById('yahoo2_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('skype1_config').value))
	{
		alert("Bạn chưa nhập nick skype 1!");
		document.getElementById('skype1_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('skype2_config').value))
	{
		alert("Bạn chưa nhập nick skype 2!");
		document.getElementById('skype2_config').focus();
		return false;
	}
	/******/
	if(CheckBlank(document.getElementById('timepost_config').value))
	{
		alert("Bạn chưa nhập thời gian giữa 2 lần Post!");
		document.getElementById('timepost_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('timelock_config').value))
	{
		alert("Bạn chưa nhập thời gian khóa tài khoản không hoạt động!");
		document.getElementById('timelock_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('timesession_config').value))
	{
		alert("Bạn chưa nhập thời gian của 1 phiên làm việc!");
		document.getElementById('timesession_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('timecache_config').value))
	{
		alert("Bạn chưa nhập thời gian cache!");
		document.getElementById('timecache_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('exchange_config').value))
	{
		alert("Bạn chưa nhập tỉ giá chuyển đổi từ USD sang VND!");
		document.getElementById('exchange_config').focus();
		return false;
	}
	/******/
	if(CheckBlank(document.getElementById('pro1_config').value))
	{
		alert("Bạn chưa nhập sản phẩm mới (Trang chủ)!");
		document.getElementById('pro1_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('pro2_config').value))
	{
		alert("Bạn chưa nhập sản phẩm tin cậy (Trang chủ)!");
		document.getElementById('pro2_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('pro3_config').value))
	{
		alert("Bạn chưa nhập sản phẩm mới (Theo danh mục)!");
		document.getElementById('pro3_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('pro4_config').value))
	{
		alert("Bạn chưa nhập sản phẩm tin cậy (Theo danh mục)!");
		document.getElementById('pro4_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('pro5_config').value))
	{
		alert("Bạn chưa nhập sản phẩm khuyến mãi!");
		document.getElementById('pro5_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('pro6_config').value))
	{
		alert("Bạn chưa nhập top sản phẩm mới nhất!");
		document.getElementById('pro6_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('pro7_config').value))
	{
		alert("Bạn chưa nhập top sản phẩm khuyến mãi!");
		document.getElementById('pro7_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('pro8_config').value))
	{
		alert("Bạn chưa nhập top sản phẩm mua nhiều nhất!");
		document.getElementById('pro8_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('pro9_config').value))
	{
		alert("Bạn chưa nhập sản phẩm cùng thành viên!");
		document.getElementById('pro9_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('pro10_config').value))
	{
		alert("Bạn chưa nhập sản phẩm cùng danh mục!");
		document.getElementById('pro10_config').focus();
		return false;
	}
	/********/
	if(CheckBlank(document.getElementById('ads1_config').value))
	{
		alert("Bạn chưa nhập rao vặt (Trang chủ)!");
		document.getElementById('ads1_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('ads2_config').value))
	{
		alert("Bạn chưa nhập rao vặt tin cậy (Theo danh mục)!");
		document.getElementById('ads2_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('ads3_config').value))
	{
		alert("Bạn chưa nhập rao vặt mới (Theo danh mục)!");
		document.getElementById('ads3_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('ads4_config').value))
	{
		alert("Bạn chưa nhập rao vặt từ gian hàng!");
		document.getElementById('ads4_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('ads5_config').value))
	{
		alert("Bạn chưa nhập top rao vặt tin cậy!");
		document.getElementById('ads5_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('ads6_config').value))
	{
		alert("Bạn chưa nhập top rao vặt mới nhất!");
		document.getElementById('ads6_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('ads7_config').value))
	{
		alert("Bạn chưa nhập top rao vặt xem nhiều nhất!");
		document.getElementById('ads7_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('ads8_config').value))
	{
		alert("Bạn chưa nhập top rao vặt từ gian hàng!");
		document.getElementById('ads8_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('ads9_config').value))
	{
		alert("Bạn chưa nhập rao vặt cùng thành viên!");
		document.getElementById('ads9_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('ads10_config').value))
	{
		alert("Bạn chưa nhập rao vặt cùng danh mục!");
		document.getElementById('ads10_config').focus();
		return false;
	}
	/*******/
	if(CheckBlank(document.getElementById('job1_config').value))
	{
		alert("Bạn chưa nhập tuyển dụng, tìm việc được quan tâm!");
		document.getElementById('job1_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('job2_config').value))
	{
		alert("Bạn chưa nhập tuyển dụng, tìm việc mới!");
		document.getElementById('job2_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('job3_config').value))
	{
		alert("Bạn chưa nhập top tuyển dụng 24 giờ!");
		document.getElementById('job3_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('job4_config').value))
	{
		alert("Bạn chưa nhập top tìm việc 24 giờ!");
		document.getElementById('job4_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('job5_config').value))
	{
		alert("Bạn chưa nhập tuyển dụng, tìm việc cùng thành viên!");
		document.getElementById('job5_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('job6_config').value))
	{
		alert("Bạn chưa nhập tuyển dụng, tìm việc cùng ngành nghề!");
		document.getElementById('job6_config').focus();
		return false;
	}
	/******/
	if(CheckBlank(document.getElementById('shop1_config').value))
	{
		alert("Bạn chưa nhập gian hàng nổi bật (Trang chủ)!");
		document.getElementById('shop1_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('shop2_config').value))
	{
		alert("Bạn chưa nhập gian hàng nổi bật (Theo danh mục)!");
		document.getElementById('shop2_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('shop3_config').value))
	{
		alert("Bạn chưa nhập gian hàng mới (Theo danh mục)!");
		document.getElementById('shop3_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('shop4_config').value))
	{
		alert("Bạn chưa nhập gian hàng đang có khuyến mãi!");
		document.getElementById('shop4_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('shop5_config').value))
	{
		alert("Bạn chưa nhập top gian hàng mới nhất!");
		document.getElementById('shop5_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('shop6_config').value))
	{
		alert("Bạn chưa nhập top gian hàng đang có khuyến mãi!");
		document.getElementById('shop6_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('shop7_config').value))
	{
		alert("Bạn chưa nhập top gian hàng nhiều sản phẩm nhất!");
		document.getElementById('shop7_config').focus();
		return false;
	}
	/******/
	if(CheckBlank(document.getElementById('shopping1_config').value))
	{
		alert("Bạn chưa nhập sản phẩm nổi bật (Trang chủ)!");
		document.getElementById('shopping1_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('shopping2_config').value))
	{
		alert("Bạn chưa nhập sản phẩm mới (Trang chủ)!");
		document.getElementById('shopping2_config').focus();
		return false;
	}
	if(CheckBlank(document.getElementById('shopping3_config').value))
	{
		alert("Bạn chưa nhập sản phẩm khuyến mãi (Trang chủ)!");
		document.getElementById('shopping3_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('shopping4_config').value))
	{
		alert("Bạn chưa nhập sản phẩm mới (Theo danh sách)!");
		document.getElementById('shopping4_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('shopping5_config').value))
	{
		alert("Bạn chưa nhập sản phẩm khuyến mãi (Theo danh sách)!");
		document.getElementById('shopping5_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('shopping6_config').value))
	{
		alert("Bạn chưa nhập rao vặt mới!");
		document.getElementById('shopping6_config').focus();

		return false;
	}

	if(CheckBlank(document.getElementById('shopping7_config').value))
	{
		alert("Bạn chưa nhập top sản phẩm mới!");
		document.getElementById('shopping7_config').focus();
		return false;
	}
	if(CheckBlank(document.getElementById('shopping8_config').value))
	{
		alert("Bạn chưa nhập top rao vặt mới!");
		document.getElementById('shopping8_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('shopping9_config').value))
	{
		alert("Bạn chưa nhập kết quả tìm kiếm!");
		document.getElementById('shopping9_config').focus();
		return false;
	}
	/*******/
	if(CheckBlank(document.getElementById('search1_config').value))
	{
		alert("Bạn chưa nhập kết quả tìm kiếm sản phẩm!");
		document.getElementById('search1_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('search2_config').value))
	{
		alert("Bạn chưa nhập kết quả tìm kiếm rao vặt!");
		document.getElementById('search2_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('search3_config').value))
	{
		alert("Bạn chưa nhập kết quả tìm kiếm tin tuyển dụng, tìm việc!");
		document.getElementById('search3_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('search4_config').value))
	{
		alert("Bạn chưa nhập kết quả tìm kiếm gian hàng!");
		document.getElementById('search4_config').focus();
		return false;
	}
	/*******/
	if(CheckBlank(document.getElementById('other1_config').value))
	{
		alert("Bạn chưa nhập cấu hình hiển thị ở trang tài khoản thành viên!");
		document.getElementById('other1_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('other2_config').value))
	{
		alert("Bạn chưa nhập cấu hình hiển thị ở trang quản trị!");
		document.getElementById('other2_config').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('other3_config').value))
	{
		alert("Bạn chưa nhập số lượng sản phẩm hiển thị ở giỏ hàng!");
		document.getElementById('other3_config').focus();
		return false;
	}
	document.frmConfig.submit();
}

function CheckInput_AddGroup()
{
	if(CheckBlank(document.getElementById('name_group').value))
	{
		alert("Bạn chưa nhập tên nhóm!");
		document.getElementById('name_group').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('descr_group').value))
	{
		alert("Bạn chưa nhập mô tả!");
		document.getElementById('descr_group').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('order_group').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_group').focus();
		return false;
	}
	document.frmAddGroup.submit();
}

function CheckInput_EditGroup()
{
	if(CheckBlank(document.getElementById('name_group').value))
	{
		alert("Bạn chưa nhập tên nhóm!");
		document.getElementById('name_group').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('descr_group').value))
	{
		alert("Bạn chưa nhập mô tả!");
		document.getElementById('descr_group').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('order_group').value))
	{
		alert("Bạn chưa nhập thứ tự hiển thị!");
		document.getElementById('order_group').focus();
		return false;
	}
	document.frmEditGroup.submit();
}

function CheckLogin()
{
	if(CheckBlank(document.getElementById('usernameLogin').value))
	{
		alert("Bạn chưa nhập tài khoản!");
		document.getElementById('usernameLogin').focus();
		return false;
	}
	if(!CheckCharacter(document.getElementById('usernameLogin').value))
	{
		alert("Tài khoản bạn nhập không hợp lệ!\nChỉ chấp nhận các ký số 0-9\nChấp nhận các ký tự a-z hoặc A-Z\nChấp nhận các ký tự - _");
		document.getElementById('usernameLogin').focus();
		return false;
	}


	if(CheckBlank(document.getElementById('passwordLogin').value))
	{
		alert("Bạn chưa nhập mật khẩu!");
		document.getElementById('passwordLogin').focus();
		return false;
	}
	document.frmLogin.submit();
}

function CheckInput_Mail()
{
	if(CheckBlank(document.getElementById('to_mail').value))
	{
		alert("Bạn chưa nhập email người nhận!");
		document.getElementById('to_mail').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('from_mail').value))
	{
		alert("Bạn chưa nhập email người gởi!");
		document.getElementById('from_mail').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('subject_mail').value))
	{
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('subject_mail').focus();
		return false;
	}

	if(CheckBlank(document.getElementById('txtContent').value))
	{
		alert("Bạn chưa nhập nội dung!");
		document.getElementById('txtContent').focus();
		return false;
	}
	document.frmMail.submit();
}
/*END CheckInput*/

function nrKeys(a) {
    var i = 0;
    for (key in a) {
        i++;
    }
    return i;
}


function SelectMail()
{

	var value_to_mail=jQuery('#to_mail').val();

	var foo = [];
	var chuoi="";
	var j=0;
	$('#list_mail :selected').each(function(i, selected){
	if(j==0)
	{
	  foo[i] = $(selected).text();
	  	  chuoi+=foo[i];
	}
	else
	{

		foo[i] = $(selected).text();

	  	  chuoi+=","+foo[i];

	}
	  j=j+1;

	});
	var list = document.getElementById('list_mail').value;
	var to = document.getElementById('to_mail').value;
	var temp_value;



	if(TrimInput(to) == '')
	{
		var isMail = list;
		jQuery('#to_mail').val(isMail);
	}
	else
	{
		chuoi_ban_dau=to.split(",");
		chuoi_tiep_theo=chuoi.split(",");
		n=chuoi_tiep_theo.length;
		p=chuoi_ban_dau.length;
		var chuoi_tam="";
		var flag="";

		for(var i=0;i<n;i++)
		{
			for(var j=0 ;j<p;j++)
			{
				if(chuoi_tiep_theo[i] == chuoi_ban_dau[j])
				{
					flag="";
					break;
				}
				else
				{
					flag = chuoi_tiep_theo[i];
				}
			}

			if(flag!="")
			{
				chuoi_tam=chuoi_tam+","+flag;
			}

		}
		var isMailTemp = to  + TrimInput(chuoi_tam);
		jQuery('#to_mail').val(isMailTemp);
	}

}


/*BEGIN: isActionDelete*/
function ActionDelete(formName)
{
	var r = confirm("Bạn có chắc muốn xóa!");
	if (r == true) {
		eval('document.' + formName + '.submit();');
	}
}
/*END isActionDelete*/
/*BEGIN: Change Style*/
function ChangeStyle(div,action)
{
	switch (action)
	{
		case 1:
			document.getElementById(div).style.border = "1px #2F97FF solid";
			break;
		case 2:
			document.getElementById(div).style.border = "1px #CCCCCC solid";
			break;
		default:
			document.getElementById(div).style.border = "1px #2F97FF solid";
	}
}
/*END Change Style*/
/*BEGIN: Change Style Icon*/
function ChangeStyleIcon(div,action)
{
	switch (action)
	{
		case 1:
			document.getElementById(div).style.border = "1px #2F97FF solid";
			break;
		case 2:
			document.getElementById(div).style.border = "1px #EAEAEA solid";
			break;
		default:
			document.getElementById(div).style.border = "1px #2F97FF solid";
	}
}
/*END Change Style Icon*/
/*BEGIN: Change Style Icon Item*/
function ChangeStyleIconItem(div,action)
{
	switch (action)
	{
		case 1:
			document.getElementById(div).style.border = "1px #CCCCCC outset";
			document.getElementById(div).style.color = "#F00000";
			break;
		case 2:
			document.getElementById(div).style.border = "1px #FFFFFF solid";
			document.getElementById(div).style.color = "#06F";
			break;
		default:
			document.getElementById(div).style.border = "1px #CCCCCC outset";
			document.getElementById(div).style.color = "#F00000";
	}
}
/*END Change Style Icon Item*/
/*BEGIN: ChangeStyleRow*/
function ChangeStyleRow(div,row,status)
{
	switch (status)
	{
		case 1://Change
			document.getElementById(div).style.background = "#ECF5FF";
			break;
		case 2://Default
			if(row % 2 == 0)
			{
				document.getElementById(div).style.background = "#F7F7F7";
			}
			else
			{
				document.getElementById(div).style.background = "none";
			}
			break;
		default://Change
			document.getElementById(div).style.background = "#ECF5FF";
	}
}
/*END ChangeStyleRow*/
/*BEGIN: Khoa Ky Tu Khong Cho Phep*/
var rBlock={
  'SpecialChar':/['\'\"\\#~`<>;']/g,
  'AllSpecialChar':/['@\'\"\\~<>;`&\/%$^*{}\[\]!|():?+=#']/g,
  'NotNumbers':/[^\d]/g
};


function BlockChar(div,type)
{
	if(type=='SpecialChar'){
		var iChars = "\#~`";
		for (var i = 0; i < div.value.length; i++) {
			if (iChars.indexOf(div.value.charAt(i)) != -1){
				alert ("Ký tự bạn vừa nhập \""+div.value.charAt(i)+"\" là không hợp lệ!");
				div.value = div.value.replace(div.value.charAt(i),"");
				div.focus();
				return false;
			}
		}
	}

	if(type=='AllSpecialChar'){
		var iChars = "\'\"\\~<>;`&\/%$^*{}\[\]!|:?+=#']";
		for (var i = 0; i < div.value.length; i++) {
			if (iChars.indexOf(div.value.charAt(i)) != -1){
				alert ("Ký tự bạn vừa nhập \""+div.value.charAt(i)+"\" là không hợp lệ!");
				div.value = div.value.replace(div.value.charAt(i),"");
				div.focus();
				return false;
			}
		}
	}

	if(type=='NotNumbers'){
		div.value = div.value.replace(rBlock[type],'');
		div.value = div.value.replace(/ +/g,' ');
	}

}
/*END Khoa Ky Tu Khong Cho Phep*/
/*BEGIN: Chu Hoa Dau Tu*/
function CapitalizeNames(FormName,FieldName)
{
  var ValueString = String();
  eval('ValueString=document.'+FormName+'.'+FieldName+'.value');
  ValueString = ValueString.replace(/ +/g,' ');
  var names = ValueString.split(' ');
  for(var i = 0; i < names.length; i++)
  {
	  if(names[i].length > 1)
	  {
		  names[i] = names[i].toLowerCase();
		  letters = names[i].split('');
		  letters[0] = letters[0].toUpperCase();
		  names[i] = letters.join('');
  	  }
  	  else
	  {
	  	names[i] = names[i].toUpperCase();
	  }
  }
  ValueString = names.join(' ');
  eval('document.'+FormName+'.'+FieldName+'.value=ValueString');
  return true;
}
/*END Chu Hoa Dau Tu*/
/*BEGIN: Curency*/
function AddComma(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = "";
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1))
	{
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function FormatCost(cost,div)
{
	document.getElementById(div).innerHTML = AddComma(cost);
}
/*END Curency*/
/*BEGIN: Kiem tra xem co chon vao o checkbox nao khong, Va hai tuy chon tat ca va huy bo*/
function DoCheck(status,FormName,from_)
{
	var alen=eval('document.'+FormName+'.elements.length');
	alen=(alen>1)?eval('document.'+FormName+'.checkone.length'):0;
	if (alen>0)
	{
		for(var i=0;i<alen;i++)
			eval('document.'+FormName+'.checkone[i].checked=status');
	}
	else
	{
		eval('document.'+FormName+'.checkone.checked=status');
	}
	if(from_>0)
		eval('document.'+FormName+'.checkall.checked=status');
}

function DoCheckOne(FormName)
{
	var alen=eval('document.'+FormName+'.elements.length');
	var isChecked=true;
	alen=(alen>1)?eval('document.'+FormName+'.checkone.length'):0;
	if (alen>0)
	{
		for(var i=0;i<alen;i++)
				if(eval('document.'+FormName+'.checkone[i].checked==false'))
						isChecked=false;
	}
	else
	{
		if(eval('document.'+FormName+'.checkone.checked==false'))
			isChecked=false;
	}
	eval('document.'+FormName+'.checkall.checked=isChecked');
}
/*END Kiem tra xem co chon vao o checkbox nao khong, Va hai tuy chon tat ca va huy bo*/
/*BEGIN: Mktime*/
function mktime()
{
    var no=0, i = 0, ma=0, mb=0, d = new Date(), dn = new Date(), argv = arguments, argc = argv.length;
    var dateManip = {
        0: function(tt){ return d.setHours(tt); },
        1: function(tt){ return d.setMinutes(tt); },
        2: function(tt){ var set = d.setSeconds(tt); mb = d.getDate() - dn.getDate(); return set;},
        3: function(tt){ var set = d.setMonth(parseInt(tt, 10)-1); ma = d.getFullYear() - dn.getFullYear(); return set;},
        4: function(tt){ return d.setDate(tt+mb);},
        5: function(tt){
            if (tt >= 0 && tt <= 69) {
                tt += 2000;
            }
            else if (tt >= 70 && tt <= 100) {
                tt += 1900;
            }
            return d.setFullYear(tt+ma);
        }
        // 7th argument (for DST) is deprecated
    };

    for( i = 0; i < argc; i++ ){
        no = parseInt(argv[i]*1, 10);
        if (isNaN(no)) {
            return false;
        } else {
            // arg is number, let's manipulate date object
            if(!dateManip[i](no)){
                // failed
                return false;
            }
        }
    }

    for (i = argc; i < 6; i++) {
        switch(i) {
            case 0:
                no = dn.getHours();
                break;
            case 1:
                no = dn.getMinutes();
                break;
            case 2:
                no = dn.getSeconds();
                break;
            case 3:
                no = dn.getMonth()+1;
                break;
            case 4:
                no = dn.getDate();
                break;
            case 5:
                no = dn.getFullYear();
                break;
        }
        dateManip[i](no);
    }
    return Math.floor(d.getTime()/1000);
}
function IsNumber(number)
{
	var str="0123456789";
	for(var i=0;i<number.length;i++)
	{
		if(str.indexOf(number.charAt(i)) == -1)
		{
			return false;
		}
	}
	return true;//Dung la so
}

/*END Mktime*/

/*BEGIN: Action Search*/
function ActionSearchFilter(baseurl,type)
{	
	var isAddress = "";
	switch (type)
	{
		case 1://Search
			var isKeyword = "";
			var isSearch = "";
			var isFilter = "";
			isFilter = document.getElementById('filter').value;
			isKeyword = document.getElementById('keyword').value;
			isSearch = document.getElementById('search').value;
			isMonth = document.getElementById('month').value;
			isYear = document.getElementById('year').value;
			username = document.getElementById('username').value;
			if(isMonth == "0" || isYear == "0")
			{
				break;
			}
			isKey = mktime(0, 0, 0, isMonth, 1, isYear); //alert(isKey)
			
			//isAddress = baseurl + 'filter/' + isFilter + '/key/' + isKey;
			if(!CheckBlank(isKeyword) && isSearch != "0")
			{				
				isKeyword = isKeyword+'/';
				isAddress = baseurl + 'search/' + isSearch + '/keyword/' + isKeyword +'filter/' + isFilter + '/key/' + isKey;
				window.location.href = isAddress;
			}else{
				if(username!=''){
					if(username != 'filter'){
						isAddress = baseurl + username + '/filter/' + isFilter + '/key/' + isKey;
					}else{
						isAddress = baseurl + 'filter/' + isFilter + '/key/' + isKey;
					}

				}else{
					isAddress = baseurl + 'filter/' + isFilter + '/key/' + isKey;
				}

				window.location.href = isAddress;
			}
			break;
		default://None
			alert("Error!");
	}
}
/*BEGIN: Action Search*/
function ActionSearch(baseurl,type)
{
	var isAddress = "";
	switch (type)
	{
		case 1://Search
			var isKeyword = "";
			var isSearch = "";
			isKeyword = document.getElementById('keyword').value;
			isSearch = document.getElementById('search').value;
			if(!CheckBlank(isKeyword) && isSearch != "0")
			{
				isAddress = baseurl + 'search/' + isSearch + '/keyword/' + isKeyword;
				window.location.href = isAddress;
			}
			break;
		case 2://Filter
			var isFilter = "";
			isFilter = document.getElementById('filter').value;
			if(isFilter == 'begindate' || isFilter == 'regisdate' || isFilter == 'enddate' || isFilter == 'lastestlogin' || isFilter == 'datecontact' || isFilter == 'datereply' || isFilter == 'buydate' || isFilter == 'doanhsothang' || isFilter == 'hoahongthang')//Neu Co Ngay-Thang-Nam
			{
				if(document.getElementById('DivDateSearch_2').style.display == "none" || document.getElementById('DivDateSearch_4').style.display == "none" || document.getElementById('DivDateSearch_6').style.display == "none")
				{
					OpenTabSearch('1',1);
					break;
				}
				var isDay = "";
				var isMonth = "";
				var isYear = "";
				isDay = document.getElementById('day').value;
				isMonth = document.getElementById('month').value;
				isYear = document.getElementById('year').value;
				if(isDay == "0" || isMonth == "0" || isYear == "0")
				{
					break;
				}
				isKey = mktime(0, 0, 0, isMonth, isDay, isYear);
				isAddress = baseurl + 'filter/' + isFilter + '/key/' + isKey;
			}
			else if(isFilter == 'group'){
				if(document.getElementById('DivDateSearch_8').style.display == "none")
				{
					OpenTabSearch('3',1);
					break;
				}
				isKey = document.getElementById('group').value;
				isAddress = baseurl + 'filter/' + isFilter + '/key/' + isKey;

			}
			else if( isFilter == 'logindate')
			{
				if(document.getElementById('DivDateSearch_2').style.display == "none"
					|| document.getElementById('DivDateSearch_4').style.display == "none"
					|| document.getElementById('DivDateSearch_6').style.display == "none"
					|| document.getElementById('DivDateSearch_10').style.display == "none"
					|| document.getElementById('DivDateSearch_12').style.display == "none"
					|| document.getElementById('DivDateSearch_14').style.display == "none"
					){
					OpenTabSearch('4',1);
					break;
				}
				var frDay = "";
				var frMonth = "";
				var frYear = "";
				var toDay = "";
				var toMonth = "";
				var toYear = "";
				frDay = document.getElementById('day').value;
				frMonth = document.getElementById('month').value;
				frYear = document.getElementById('year').value;
				toDay = document.getElementById('tday').value;
				toMonth = document.getElementById('tmonth').value;
				toYear = document.getElementById('tyear').value;
				if(frDay == "0" || frMonth == "0" || frYear == "0" || toDay == "0" || toMonth == "0" || toYear == "0")
				{
					break;
				}
				isKey = mktime(0, 0, 0, frMonth, frDay, frYear);
				toKey = mktime(23, 59, 59, toMonth, toDay, toYear);
				isAddress = baseurl + 'filter/' + isFilter + '/key/' + isKey + '/tokey/' + toKey;

			}
            else if( isFilter == 'product' || isFilter == 'service' || isFilter == 'coupon'){
                if(document.getElementById('DivDateSearch_2').style.display == "none"
                    || document.getElementById('DivDateSearch_4').style.display == "none"
                    || document.getElementById('DivDateSearch_6').style.display == "none"
                    || document.getElementById('DivDateSearch_10').style.display == "none"
                    || document.getElementById('DivDateSearch_12').style.display == "none"
                    || document.getElementById('DivDateSearch_14').style.display == "none"
                ){                	
                    OpenTabSearch('4',1); 
                    break;
                }
                var frDay = "";
                var frMonth = "";
                var frYear = "";
                var toDay = "";
                var toMonth = "";
                var toYear = "";
                frDay = document.getElementById('day').value;
                frMonth = document.getElementById('month').value;
                frYear = document.getElementById('year').value;
                toDay = document.getElementById('tday').value;
                toMonth = document.getElementById('tmonth').value;
                toYear = document.getElementById('tyear').value;
                if(frDay == "0" || frMonth == "0" || frYear == "0" || toDay == "0" || toMonth == "0" || toYear == "0")
                {
                    break;
                }
                isKey = mktime(0, 0, 0, frMonth, frDay, frYear);
                toKey = mktime(23, 59, 59, toMonth, toDay, toYear);
                isAddress = baseurl + 'filter/' + isFilter + '/key/' + isKey + '/tokey/' + toKey+ '/'+isFilter +'#statisticaldate';
			}
            else if( isFilter == 'statisticaldate')
            {
                if(document.getElementById('DivDateSearch_2').style.display == "none"
                    || document.getElementById('DivDateSearch_4').style.display == "none"
                    || document.getElementById('DivDateSearch_6').style.display == "none"
                    || document.getElementById('DivDateSearch_10').style.display == "none"
                    || document.getElementById('DivDateSearch_12').style.display == "none"
                    || document.getElementById('DivDateSearch_14').style.display == "none"
                ){
                    OpenTabSearch('4',1);
                    break;
                }
                var frDay = "";
                var frMonth = "";
                var frYear = "";
                var toDay = "";
                var toMonth = "";
                var toYear = "";
                frDay = document.getElementById('day').value;
                frMonth = document.getElementById('month').value;
                frYear = document.getElementById('year').value;
                toDay = document.getElementById('tday').value;
                toMonth = document.getElementById('tmonth').value;
                toYear = document.getElementById('tyear').value;
                if(frDay == "0" || frMonth == "0" || frYear == "0" || toDay == "0" || toMonth == "0" || toYear == "0")
                {
                    break;
                }
                isKey = mktime(0, 0, 0, frMonth, frDay, frYear);
                toKey = mktime(23, 59, 59, toMonth, toDay, toYear);
                isAddress = baseurl + 'filter/' + isFilter + '/key/' + isKey + '/tokey/' + toKey+ '/#statisticaldate';

            }
			else if(isFilter == 'package'){
				if(document.getElementById('DivDateSearch_16').style.display == "none")
				{
					OpenTabSearch('5',1);
					break;
				}
				isKey = document.getElementById('package').value;
				isAddress = baseurl + 'filter/' + isFilter + '/key/' + isKey;

			}
			else
			{
				isKey = isFilter;
				isAddress = baseurl + 'filter/' + isFilter + '/key/' + isKey;
			}

			if(isFilter != "0")
			{
				window.location.href = isAddress;
			}
			break;
		default://None
			alert("Error!");
	}
}
/*END Action Search*/
/*BEGIN: ActionSort*/
function ActionSort(isAddress)
{
	window.location.href = isAddress;
}
/*END ActionSort*/
/*BEGIN: ActionStatus*/
function ActionStatus(isAddress)
{
	//alert("abc");
	window.location.href = isAddress;
}
/*END ActionStatus*/
/*BEGIN: ActionLink*/
function ActionLink(isAddress)
{
	window.location.href = isAddress;
}
/*END ActionLink*/
/*BEGIN: Popup*/
function Popup(url, width, height)
{
	var winpops=window.open(url,"","width=" + width + ",height=" + height + ",toolbar=no,menubar=no,resizable=no,menubar=no,status=no,scrollbars=yes,screenX=400,screenY=400,top=100,left=250");
}
/*END Popup*/
/* Add by Le Van Son  */
function CheckInput_AddContent(){
	if(CheckBlank(document.getElementById('title_content').value))
	{
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_content').focus();
		return false;
	}
	var text = tinyMCE.get('txtContent').getContent();
	if (tinyMCE.get("txtContent").isHidden()) {
		tinyMCE.get("txtContent").show()
	}
	tinyMCE.get("txtContent").save();
	if(CheckBlank(document.getElementById('txtContent').value))
	{
		alert("Bạn chưa nhập nội dung thông báo!");
		document.getElementById('txtContent').focus();
		return false;
	}


	document.frmAddNotify.submit();
}
/* add by quang */
function SearchLinkEnter(baseUrl,idInput){
	if(document.getElementById(idInput).value=="")
	{
		alert("Bạn phải gõ từ khóa tìm kiếm");
	}
	else
	{
		  product_name='';

		  name=document.getElementById(idInput).value;


		window.location = baseUrl+name;
	}

}
function SummitEnTerAdmin(myfield,e,baseUrl,idInput)
{

	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;

	if (keycode == 13)
	   {
	   SearchLinkEnter(baseUrl,idInput);
	   return false;
	   }
	else
	   return true;

}
function check_cat(parent_id,level,baseUrl){
	jQuery('#parent_id').val('');
	jQuery('#cat_level').val(parseInt(level+1));
	if(level == 0){
		jQuery('#parent_1').css('display','none');
		$temp = parent_id.split('-');
		parent_id = $temp[0];
		jQuery('#cat_index').val($temp[1]);
	}
	if(parent_id != 0){
		jQuery.ajax({
			type: "POST",
			url: baseUrl + "hoidap/ajax",
			data: "parent_id=" + parent_id,
			dataType: "json",
			success: function(data){
				if(data[1] > 0)
				{
					str = '<select id="cat_select_'+parseInt(level+1)+'" onclick="check_cat(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');" size="10">';
					for(i = 0; i < data[1]; i++)
					{
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name+'</option>';
					}
					str += '</select>';
					jQuery('#parent_'+parseInt(level+1)).html(str);
					jQuery('#parent_'+parseInt(level+1)).css('display','inline');
					jQuery('#parent_id').val(parent_id);
				}
				else
				{
					jQuery('#parent_id').val(parent_id);
				}
			},
			error: function(){alert("No Data!");}
		});
	}
}
function check_cat_edit(parent_id,level,baseUrl){
	jQuery('#parent_id').val('');
	jQuery('#cat_level').val(parseInt(level+1));
	if(level == 0){
		jQuery('#parent_1').css('display','none');
		$temp = parent_id.split('-');
		parent_id = $temp[0];
		jQuery('#cat_index').val($temp[1]);
	}
	if(parent_id != 0){
		jQuery.ajax({
			type: "POST",
			url: baseUrl + "hoidap/ajax",
			data: "parent_id=" + parent_id,
			dataType: "json",
			success: function(data){
				if(data[1] > 0)
				{
					str = '<select id="cat_select_'+parseInt(level+1)+'" onchange="check_cat_edit(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');">';
					str += '<option value="0">Chọn danh mục</option>';
					for(i = 0; i < data[1]; i++)
					{
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name+'</option>';
					}
					str += '</select>';
					jQuery('#parent_'+parseInt(level+1)).html(str);
					jQuery('#parent_'+parseInt(level+1)).css('display','inline');
					jQuery('#parent_id').val(parent_id);
				}
				else
				{
					jQuery('#parent_id').val(parent_id);
				}
			},
			error: function(){alert("No Data!");}
		});
	}
	else{
		jQuery('#cat_level').val(0);
	}
}
function check_cat_rv(parent_id,level,baseUrl){
	jQuery('#parent_id').val('');
	jQuery('#cat_level').val(parseInt(level+1));
	if(level == 0){
		jQuery('#parent_1').css('display','none');
		$temp = parent_id.split('-');
		parent_id = $temp[0];
		jQuery('#cat_index').val($temp[1]);
	}
	if(parent_id != 0){
		jQuery.ajax({
			type: "POST",
			url: baseUrl + "adscategory/ajax",
			data: "parent_id=" + parent_id,
			dataType: "json",
			success: function(data){
				if(data[1] > 0)
				{
					str = '<select id="cat_select_'+parseInt(level+1)+'" onclick="check_cat_rv(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');" size="10">';
					for(i = 0; i < data[1]; i++)
					{
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name+'</option>';
					}
					str += '</select>';
					jQuery('#parent_'+parseInt(level+1)).html(str);
					jQuery('#parent_'+parseInt(level+1)).css('display','inline');
					jQuery('#parent_id').val(parent_id);
				}
				else
				{
					jQuery('#parent_id').val(parent_id);
				}
			},
			error: function(){alert("No Data!");}
		});
	}
}
function check_cat_edit_rv(parent_id,level,baseUrl){
	jQuery('#parent_id').val('');
	jQuery('#cat_level').val(parseInt(level+1));
	if(level == 0){
		jQuery('#parent_1').css('display','none');
		$temp = parent_id.split('-');
		parent_id = $temp[0];
		jQuery('#cat_index').val($temp[1]);
	}
	if(parent_id != 0){
		jQuery.ajax({
			type: "POST",
			url: baseUrl + "adscategory/ajax",
			data: "parent_id=" + parent_id,
			dataType: "json",
			success: function(data){
				if(data[1] > 0)
				{
					str = '<select id="cat_select_'+parseInt(level+1)+'" onchange="check_cat_edit_rv(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');">';
					str += '<option value="0">Chọn danh mục</option>';
					for(i = 0; i < data[1]; i++)
					{
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name+'</option>';
					}
					str += '</select>';
					jQuery('#parent_'+parseInt(level+1)).html(str);
					jQuery('#parent_'+parseInt(level+1)).css('display','inline');
					jQuery('#parent_id').val(parent_id);
				}
				else
				{
					jQuery('#parent_id').val(parent_id);
				}
			},
			error: function(){alert("No Data!");}
		});
	}
	else{
		jQuery('#cat_level').val(0);
	}
}
function check_cat_pr(parent_id,level,baseUrl, cate_type){
    if(level < 5){
        jQuery('#parent_id').val('');
        jQuery('#cat_level').val(parseInt(level+1));
        if(level == 0){
            jQuery('#parent_1').css('display','none');
            $temp = parent_id.split('-');
            parent_id = $temp[0];
            jQuery('#cat_index').val($temp[1]);
            jQuery('.parent_cat .parent_cat_select').each(function( index ) {
                if(index > (level)){
                    jQuery(this).remove();
                }
            });
        }
        if(parent_id != 0){
            jQuery.ajax({
                type: "POST",
                url: baseUrl + "category/ajax",
                data: {parent_id: parent_id, cate_type: cate_type},
                dataType: "json",
                success: function(data){
                    jQuery('.parent_cat .parent_cat_select').each(function( index ) {
                        if(index > (level)){
                            jQuery(this).remove();
                        }
                    });
                    if(data[1] > 0)
                    {
                        str = '<div class="parent_cat_select" id="parent_'+parseInt(level+1)+'"><select id="cat_select_'+parseInt(level+1)+'" onclick="check_cat_pr(this.value, '+parseInt(level+1)+', \''+baseUrl+'\','+data[0][0].cate_type+');" size="10">';
						for(i = 0; i < data[1]; i++)
                        {
                            str += '<option value="'+data[0][i].cat_id+'" title="'+data[0][i].cat_name+'">'+data[0][i].cat_name+'</option>';
                        }
                        str += '</select></div>';
                        jQuery('.parent_cat').append(str);
                        jQuery('#parent_id').val(parent_id);
                    }
                    else
                    {
                        jQuery('#parent_id').val(parent_id);
                    }
                },
                error: function(){alert("No Data!");}
            });
        }else{
            jQuery('#parent_id').val(0);
            jQuery('#cat_level').val(0);
        }
    }

}

function check_cat_pr_shop(parent_id,level,baseUrl){

	jQuery('#parent_id').val('');
	jQuery('#cat_level').val(parseInt(level+1));
	if(level == 0){
		jQuery('#parent_1').css('display','none');
		$temp = parent_id.split('-');
		parent_id = $temp[0];
		jQuery('#cat_index').val($temp[1]);
	}
	if(parent_id != 0){
		jQuery.ajax({
			type: "POST",
			url: baseUrl + "shop/danh_muc_ajax",
			data: "parent_id=" + parent_id,
			dataType: "json",
			success: function(data){
				if(data[1] > 0)
				{
					str = '<select id="cat_select_'+parseInt(level+1)+'" onclick="check_cat_pr_shop(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');" size="10">';
					for(i = 0; i < data[1]; i++)
					{
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name+'</option>';
					}
					str += '</select>';
					jQuery('#parent_'+parseInt(level+1)).html(str);
					jQuery('#parent_'+parseInt(level+1)).css('display','inline');
					jQuery('#parent_id').val(parent_id);
				}
				else
				{
					jQuery('#parent_id').val(parent_id);
				}
			},
			error: function(){alert("No Data!");}
		});
	}else{
		jQuery('#parent_id').val(0);
		jQuery('#cat_level').val(0);
	}
}


function isValidURL(url){
    var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

    if(RegExp.test(url)){
        return true;
    }else{
        return false;
    }
}


function check_cat_edit_pr(parent_id,level,baseUrl,cate_type){
	jQuery('#parent_id').val('');
	jQuery('#cat_level').val(parseInt(level+1));
	if(level == 0){
		jQuery('#parent_1').css('display','none');
		$temp = parent_id.split('-');
		parent_id = $temp[0];
		jQuery('#cat_index').val($temp[1]);
	}
	if(parent_id != 0){
		jQuery.ajax({
			type: "POST",
			url: baseUrl + "category/ajax",
			data: {parent_id: parent_id, cate_type: cate_type},
			dataType: "json",
			success: function(data){
				if(data[1] > 0)
				{
					str = '<select id="cat_select_'+parseInt(level+1)+'" onchange="check_cat_edit_pr(this.value, '+parseInt(level+1)+', \''+baseUrl+'\','+data[0][0].cate_type+');">';
					str += '<option value="0">Chọn danh mục</option>';
					for(i = 0; i < data[1]; i++)
					{
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name+'</option>';
					}
					str += '</select>';
					jQuery('#parent_'+parseInt(level+1)).html(str);
					jQuery('#parent_'+parseInt(level+1)).css('display','inline');
					jQuery('#parent_id').val(parent_id);
				}
				else
				{
					jQuery('#parent_id').val(parent_id);
				}
			},
			error: function(){alert("No Data!");}
		});
	}
	else{
		jQuery('#cat_level').val(0);
		jQuery('#parent_id').val(0);
	}
}

/// gian hang
function check_edit_gian_hang_cate(parent_id,level,baseUrl){
	jQuery('#hd_category_id').val('');

	if(level == 0){
		jQuery('#hoidap_1').css('display','none');
		jQuery('#hoidap_2').css('display','none');
	}
	if(level == 1){
		jQuery('#hoidap_2').css('display','none');
	}

	jQuery.ajax({
		type: "POST",
		url: baseUrl + "administ/shop/ajax_category_shop",
		data: "parent_id=" + parent_id,
		dataType: "json",
		success: function(data){

			if(data[1] > 0)
			{
				str = '<select id="hd_select_'+parseInt(level+1)+'" class="form_control_hoidap_select" onclick="   check_edit_gian_hang_cate(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');  " size="14" onblur="getManAndCategory4Search(\''+baseUrl+'\');" style="width:170px">';
				for(i = 0; i < data[1]; i++)
				{
					str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name;
					if(data[0][i].child_count >0){
						str += ' >';

					}

					str += '</option>';
				}
				str += '</select>';
				jQuery('#hoidap_'+parseInt(level+1)).html(str);
				jQuery('#hoidap_'+parseInt(level+1)).css('display','inline');
			}
			else
			{

				jQuery('#hd_category_id').val(parent_id);

			}
		},
		error: function(){alert("No Data!");}
	});



}

/// gian hang
function check_edit_nha_san_xuat_cate(parent_id,level,baseUrl){
	jQuery('#hd_category_id').val('');
	if(level == 0){
		jQuery('#hoidap_1').css('display','none');
		jQuery('#hoidap_2').css('display','none');
	}
	if(level == 1){
		jQuery('#hoidap_2').css('display','none');
	}

	jQuery.ajax({
		type: "POST",
		url: baseUrl + "administ/manufacturer/ajax_category_shop",
		data: "parent_id=" + parent_id,
		dataType: "json",
		success: function(data){
			if(data[1] > 0)
			{
				str = '<select id="hd_select_'+parseInt(level+1)+'" class="form_control_hoidap_select" onclick="check_edit_nha_san_xuat_cate(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');  " size="14" onblur="getManAndCategory4Search(\''+baseUrl+'\');" style="width:170px">';
				for(i = 0; i < data[1]; i++)
				{
					str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name;
					if(data[0][i].child_count >0){
						str += ' >';

					}

					str += '</option>';
				}
				str += '</select>';
				jQuery('#hoidap_'+parseInt(level+1)).html(str);
				jQuery('#hoidap_'+parseInt(level+1)).css('display','inline');
			}
			else
			{

				jQuery('#hd_category_id').val(parent_id);

			}
		},
		error: function(){alert("No Data!");}
	});
}

function thong_bao_kich_thuoc_banner(e)
{
	if(e == 1){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 980px và chiều cao 120px ")}
	if(e == 2){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 970px và chiều cao 250px ")}
	if(e == 3){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px ")}
	if(e == 4){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px ")}
	if(e == 5){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 580px và chiều cao 400px ")}
	if(e == 6){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 200px và chiều cao 200px ")}
	if(e == 7){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 200px và chiều cao 200px ")}
	if(e == 8){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 320px và chiều cao 480px ")}
	if(e == 9){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 240px và chiều cao 400px ")}
	if(e == 10){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 234px và chiều cao 60px ")}
	if(e == 11){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 425px và chiều cao 600px")}
	if(e == 12){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px")}
	if(e == 13){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px")}
	if(e == 14){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 728px và chiều cao 90px")}
	if(e == 15){jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 230px và chiều cao 90px")}

}

function check_cat_edit_pr_shop(parent_id,level,baseUrl){
	jQuery('#parent_id').val('');
	jQuery('#cat_level').val(parseInt(level+1));
	if(level == 0){
		jQuery('#parent_1').css('display','none');
		$temp = parent_id.split('-');
		parent_id = $temp[0];
		jQuery('#cat_index').val($temp[1]);
	}
	if(parent_id != 0){
		jQuery.ajax({
			type: "POST",
			url: baseUrl + "shop/danh_muc_ajax",
			data: "parent_id=" + parent_id,
			dataType: "json",
			success: function(data){
				if(data[1] > 0)
				{
					str = '<select id="cat_select_'+parseInt(level+1)+'" onchange="check_cat_edit_pr_shop(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');">';
					str += '<option value="0">Chọn danh mục</option>';
					for(i = 0; i < data[1]; i++)
					{
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name+'</option>';
					}
					str += '</select>';
					jQuery('#parent_'+parseInt(level+1)).html(str);
					jQuery('#parent_'+parseInt(level+1)).css('display','inline');
					jQuery('#parent_id').val(parent_id);
				}
				else
				{
					jQuery('#parent_id').val(parent_id);
				}
			},
			error: function(){alert("No Data!");}
		});
	}
	else{
		jQuery('#cat_level').val(0);
		jQuery('#parent_id').val(0);
	}
}

function uploadimage()
{
	jQuery('#isupload').val(1);
	document.frmUpload.submit();
}
function OpenPermision($group)
{
	if($group == 5)
	{
		jQuery('#permision').css('display','');
	}
	else
	{
		jQuery('#permision').css('display','none');
	}
}
function closeimagespop(){
    jQuery('#office-location').remove();
    jQuery("#img_list").css("display","none");
}
function popsimages($divid){
    jQuery("#"+$divid).css("display","block");
    var overlayLayer = jQuery("<div id='office-location'></div>").addClass('modal-overlay'); //THIS HAS THE OVERLAY CLASS OF CSS - SO IT SHOULD HAVE A OPACITY SET AND IT DOES
    jQuery('body').after(overlayLayer);
    jQuery('<div id="content-for-overlay" style="background-color: #000000;"></div>').appendTo(overlayLayer);  /// CONTENT IS ALSO HAS OPACITY BUT ITS WRONG
    jQuery('#office-location').css("opacity", 0.8).fadeIn(150);
    jQuery('#content-for-overlay').css("opacity", 1);
}
function insertimg($imglink){
	var ed = tinyMCE.get('txtContent');                // get editor instance
	var newNode = ed.getDoc().createElement ( "img" );  // create img node
	newNode.src=$imglink;                           // add src attribute
	ed.execCommand('mceInsertContent', false, newNode.outerHTML);

	jQuery('#office-location').remove();
	jQuery('#img_list').css('display','none');
}
function insertimgen($imglink){
	var ed = tinyMCE.get('txtContent_en');                // get editor instance
	var newNode = ed.getDoc().createElement ( "img" );  // create img node
	newNode.src=$imglink;                           // add src attribute
	ed.execCommand('mceInsertContent', false, newNode.outerHTML);

	jQuery('#office-location').remove();
	jQuery('#img_list_en').css('display','none');
}

function CheckInput_AddPackage()
{
    if(CheckBlank(document.getElementById('name').value))
    {
        alert("Bạn chưa nhập tên dịch vụ!");
        document.getElementById('name').focus();
        return false;
    }

    if(CheckBlank(document.getElementById('desc').value))
    {
        alert("Bạn chưa nhập mô tả ngắn cho dịch vụ!");
        document.getElementById('desc').focus();
        return false;
    }
    document.frmAddPackage.submit();
}

function CheckInput_EditPackage()
{
    if(CheckBlank(document.getElementById('package_name').value))
    {
        alert("Bạn chưa nhập tên dịch vụ!");
        document.getElementById('package_name').focus();
        return false;
    }

    if(CheckBlank(document.getElementById('package_desc').value))
    {
        alert("Bạn chưa nhập mô tả ngắn cho dịch vụ");
        document.getElementById('package_desc').focus();
        return false;
    }
    document.frmEditPackage.submit();
}


function update_showcart_status(id_input) {
//    var ans = confirm('Bạn có chắc chuyển trạng thái đơn hàng?');
//    console.log(ans);
//    if (ans) {
//        document.getElementById(id_input).checked = true;
//    }
        document.getElementById(id_input).checked = true;
        $("#confirm_submit").trigger("click");

}

function editConfig(id){
	alert("Đây là thông tin rất quan trọng, bạn hãy cận thận khi chỉnh sửa!");
	jQuery( ".text_edit_config_"+id ).each(function( index ) {
	  this.disabled = false;
	});
	jQuery(".save_commission_config_"+id).css("display","block");
	jQuery(".edit_commission_config_"+id).css("display","none");
}

function checkToEdit(id,baseUrl){
	var isOk = true;
	jQuery( ".text_edit_config_"+id ).each(function( index ) {
		if(this.value == '' || jQuery.trim(this.value) == ''){
			alert("Bạn phải nhập dữ liệu đầy đủ trước khi chỉnh sửa!");
			jQuery('#'+jQuery(this).attr('id')).focus();
			jQuery('#'+jQuery(this).attr('id')).val('');
			isOk = false;
		}else{
			if(isValueCommissionSolution(this.value)){
			}else{
				isOk = false;
				alert("Bạn phải nhập dữ liệu dạng số!");
			}
		}
	});
	if(isOk){
		var commission = jQuery('#commission_'+id).val();
		var commission_level1 = jQuery('#commission_level1_'+id).val();
		var commission_level2 = jQuery('#commission_level2_'+id).val();
		var commission_level3 = jQuery('#commission_level3_'+id).val();
		var affiliate_number_level1 = jQuery('#affiliate_number_level1_'+id).val();
		var affiliate_number_level2 = jQuery('#affiliate_number_level2_'+id).val();
		var affiliate_number_level3 = jQuery('#affiliate_number_level3_'+id).val();
		jQuery.ajax({
			type: "POST",
			url: baseUrl + "administ/system/config/solution_commission/ajax",
			data: "id="+id+"&commission=" + commission + "&commission_level1="+ commission_level1+ "&commission_level2="+ commission_level2+ "&commission_level3="+ commission_level3+ "&affiliate_number_level1="+ affiliate_number_level1+ "&affiliate_number_level2="+ affiliate_number_level2+ "&affiliate_number_level3="+ affiliate_number_level3,
			dataType: "json",
			success: function(data){
				if(data=='1'){
					alert("Cập nhật thành công!");
				}
			},
			error: function(){alert("No Data!");}
		});
	}
}

function delete_img_ajax_db(base_url,image_name) {
	var r = confirm("Bạn có chắc muốn xóa hình này?");
	if (r == true)
	{
	    jQuery.ajax({
            type: "POST",
            url: base_url + "administ/tool/delete_image_upload",
            data: "image_name=" + image_name,
            success: function (data) {
            	if(data == 1){
                	alert("Xóa hình thành công!");
                	location.reload();
                }else{
                	alert("Xóa hình thất bại, vui lòng kiểm tra lại!")
                }
            },
            error: function () {
            }
        });
	}
}

function CheckInput_EditDiscountRateShop()
{

	if(CheckBlank(document.getElementById('num_discount').value))
	{		
		alert("Bạn chưa nhập % giảm giá!");
		document.getElementById('num_discount').focus();
		return false;
	}
	document.frmEditDiscountShop.submit();
}

