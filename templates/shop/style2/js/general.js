/*BEGIN: Waiting Load Page*/
function WaitingLoadPage()
{
	document.getElementById('DivGlobalSiteTop').style.display = '';
	document.getElementById('DivGlobalSiteMain').style.display = '';
	document.getElementById('DivGlobalSiteBottom').style.display = '';
}
/*END Waiting Load Page*/
/*BEGIN: Open Tab*/
function OpenSearch(status)
{
	switch (status)
	{
		case 1:
			if(document.getElementById('DivContent').style.display == "")
			{
				document.getElementById('DivContent').style.display = "none";
				document.getElementById('DivSearch').style.display = "";
			}
			else
			{
				document.getElementById('DivContent').style.display = "";
				document.getElementById('DivSearch').style.display = "none";
			}
			break;
		default:
			document.getElementById('DivContent').style.display = "";
			document.getElementById('DivSearch').style.display = "none";
	}
}
/*END Open Tab*/
/*BEGIN: Change Style*/
function ChangeStyle(div,action)
{
	switch (action)
	{
		case 1:
			document.getElementById(div).style.border = "1px #2F97FF solid";
			break;
		case 2:
			document.getElementById(div).style.border = "1px #CCC solid";
			break;
		default:
			document.getElementById(div).style.border = "1px #2F97FF solid";	
	}
}
/*END Change Style*/
/*BEGIN: Change Style Box*/
function ChangeStyleBox(div,action)
{
	switch (action)
	{
		case 1:
			document.getElementById(div).style.border = "1px #2F97FF solid";
			break;
		case 2:
			document.getElementById(div).style.border = "1px #D4EDFF solid";
			break;
		default:
			document.getElementById(div).style.border = "1px #2F97FF solid";	
	}
}
/*END Change Style Box*/
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
/*BEGIN: Is Number*/
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
/*END Is Number*/
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
/*BEGIN: Check Character*/
function CheckCharacter(char)
{
	var str="0123456789abcdefghikjlmnopqrstuvwxyszABCDEFGHIKJLMNOPQRSTUVWXYSZ-_";
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
/*BEGIN: Kiem Tra Ngay - Neu Hop Le Tra Ve true*/
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
/*END Kiem Tra Ngay*/
/*BEGIN: So Sanh Ngay*/
function CompareDate(isday,ismonth,isyear,vday,vmonth,vyear)
{
	isday = isday*1;
	ismonth = ismonth*1;
	isyear = isyear*1;
	vday = vday*1;
	vmonth = vmonth*1;
	vyear = vyear*1;
	if(isyear < vyear)
	{
		return true;//Neu nam sau > nam dau
	}
	if(isyear == vyear)
	{
		if(ismonth < vmonth)
		{
			return true;//Neu thang sau > thang dau
		}
		if(ismonth == vmonth)
		{
			if(isday <= vday)
			{
				return true;//Neu ngay sau lon hon ngay dau
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}
/*END So Sanh Ngay*/
/*BEGIN: Check Input*/
function Search(baseUrl)
{
	var isKeyword = document.getElementById('KeywordSearch').value;
	if(!CheckBlank(isKeyword))
	{
		var isScode = TrimInput(document.getElementById('price').value);
		var isEcode = TrimInput(document.getElementById('price_to').value);
		if(CheckBlank(isScode) && CheckBlank(isEcode)){
			document.location.href = baseUrl + '/search/name/' + isKeyword;
		}else{
			if(CheckBlank(isScode) || CheckBlank(isEcode)){
				jAlert('Bạn phải nhập cả giá từ và giá đến.','Yêu cầu nhập');
				return false;
			}
			else{
				if(IsNumber(isScode) && IsNumber(isEcode)){
					document.location.href = baseUrl + '/search/name/' + isKeyword+'/sCost/'+isScode+'/eCost/'+isEcode+'/currency/VND/';
				}else{
					jAlert('Hãy nhập giá từ và giá đến là ký tự số.','Nhập sai');
					return false;
				}
			}
		}
	}else{
		jAlert('Hãy nhập từ khóa để tìm kiếm.','Yêu cầu nhập',function(r){
			if(r==true){
				document.getElementById('KeywordSearch').focus();
			}
		});
		return false;
	}
}

function CheckInput_SearchPro(baseUrl)
{
	if(!CheckBlank(document.getElementById('cost_search1').value) || !CheckBlank(document.getElementById('cost_search2').value))
	{
		if(CheckBlank(document.getElementById('cost_search1').value))
		{
			jAlert("Bạn chưa nhập giá bắt đầu của sản phẩm!","Yêu cầu nhập",function(r){
				if(r==true){
					document.getElementById('cost_search1').focus();
				}
			});
			return false;
		}
		if(!IsNumber(document.getElementById('cost_search1').value))
	   	{
		  jAlert("Giá bắt đầu bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.","Nhập sai",function(r){
		  if(r==true){																	   
		 	 document.getElementById('cost_search1').focus();
		  }
		  });
		  return false;
	   	}
	   	if(document.getElementById('cost_search1').value == "0")
	   	{
		  jAlert("Giá bán không được bằng 0!","Nhập sai",function(r){
		  if(r==true){document.getElementById('cost_search1').focus();}});
		  return false;
	   	}
		
		if(CheckBlank(document.getElementById('cost_search2').value))
		{
			jAlert("Bạn chưa nhập giá kết thúc của sản phẩm!","Yêu cầu nhập",function(r){
			if(r==true){document.getElementById('cost_search2').focus();}});
			return false;
		}
		if(!IsNumber(document.getElementById('cost_search2').value))
	   	{
		  alert("Giá kết thúc bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		  document.getElementById('cost_search2').focus();
		  return false;
	   	}
	   	if(document.getElementById('cost_search2').value == "0")
	   	{
		  jAlert("Giá bán không được bằng 0!","Nhập sai",function(r){
		  if(r==true){document.getElementById('cost_search2').focus();
		  }});
		  return false;
	   	}
		
		var cost1 = document.getElementById('cost_search1').value*1;
		var cost2 = document.getElementById('cost_search2').value*1;
		if(cost1 > cost2)
		{
			jAlert("Giá kết thúc phải lớn hơn hoặc bằng giá bắt đầu!\nNếu bạn muốn tìm chính xác giá, bạn vui lòng nhập giá bắt đầu bằng với giá kết thúc.","Nhập sai",function(r){
			if(r==true){document.getElementById('cost_search2').focus();}});
		  	return false;
		}
	}
	
	if((document.getElementById('beginday_search1').value != 0 && document.getElementById('beginmonth_search1').value != 0 && document.getElementById('beginyear_search1').value != 0) || (document.getElementById('beginday_search2').value != 0 && document.getElementById('beginmonth_search2').value != 0 && document.getElementById('beginyear_search2').value != 0))
	{
		if(document.getElementById('beginday_search1').value == 0 || document.getElementById('beginmonth_search1').value == 0 || document.getElementById('beginyear_search1').value == 0)
		{
			jAlert("Bạn chưa chọn ngày bắt đầu!","Yêu cầu nhập");
			return false;
		}
		
		if(document.getElementById('beginday_search2').value == 0 || document.getElementById('beginmonth_search2').value == 0 || document.getElementById('beginyear_search2').value == 0)
		{
			jAlert("Bạn chưa chọn ngày kết thúc!","Yêu cầu nhập");
			return false;
		}
		
	   	if(CheckDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value) || CheckDate(document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			jAlert("Ngày đăng không hợp lệ!\nNgày đăng phải nhỏ hơn hoặc bằng ngày hiện tại.","Nhập sai");
			return false;
	   	}
		
	   	if(!CompareDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value,document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			jAlert("Ngày kết thúc phải lớn hơn hoặc bằng với ngày bắt đâu!\nNếu bạn muốn tìm chính xác ngày đăng, bạn vui lòng chọn ngày bắt đầu bằng với ngày kết thúc.","Nhập sai");
			return false;
	   	}
	}
	
	if((CheckBlank(document.getElementById('name_search').value) && CheckBlank(document.getElementById('cost_search1').value) && document.getElementById('saleoff_search').checked == false && document.getElementById('province_search').value == "0") && (document.getElementById('beginday_search1').value == "0" || document.getElementById('beginmonth_search1').value == "0" || document.getElementById('beginyear_search1').value == "0"))
	{
		jAlert("Bạn vui lòng chọn ít nhất một tùy chọn tìm kiềm!","Yêu cầu nhập");
		return false;
	}
	ActionSearch(baseUrl);
}

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
/*END Mktime*/
/*BEGIN: Action Search*/
function ActionSearch(baseurl)
{
	isAddress = baseurl;
	isName = document.getElementById('name_search').value;
	isSCost = document.getElementById('cost_search1').value;
	isECost = document.getElementById('cost_search2').value;
	isCurrency = document.getElementById('currency_search').value;
	isSaleoff = document.getElementById('saleoff_search').value;
	isPlace = document.getElementById('province_search').value;
	isSDay = document.getElementById('beginday_search1').value;
	isSMonth = document.getElementById('beginmonth_search1').value;
	isSYear = document.getElementById('beginyear_search1').value;
	isEDay = document.getElementById('beginday_search2').value;
	isEMonth = document.getElementById('beginmonth_search2').value;
	isEYear = document.getElementById('beginyear_search2').value;
	isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
	isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
	if(!CheckBlank(isName))
	{
		isAddress += 'name/' + isName + '/';
	}
	if(!CheckBlank(isSCost) && !CheckBlank(isECost))
	{
		isAddress += 'sCost/' + isSCost + '/';
		isAddress += 'eCost/' + isECost + '/';
		isAddress += 'currency/' + isCurrency + '/';
	}
	if(document.getElementById('saleoff_search').checked == true)
	{
		isAddress += 'saleoff/1/';
	}
	if(isPlace != '0')
	{
		isAddress += 'place/' + isPlace + '/';
	}
	if(isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008))
	{
		isAddress += 'sPostdate/' + isSDate + '/';
		isAddress += 'ePostdate/' + isEDate + '/';
	}
	window.location.href = isAddress;
}
/*END Action Search*/
function CheckInput_Contact()
{
	if(CheckBlank(document.getElementById('name_contact').value))
	{
		alert("Bạn chưa nhập họ tên!");
		document.getElementById('name_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('email_contact').value))
	{
		alert("Bạn chưa nhập email!");
		document.getElementById('email_contact').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('email_contact').value))
	{
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('email_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('address_contact').value))
	{
		alert("Bạn chưa nhập địa chỉ!");
		document.getElementById('address_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('phone_contact').value))
	{
		alert("Bạn chưa nhập điện thoại!");
		document.getElementById('phone_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('title_contact').value))
	{
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('content_contact').value))
	{
		alert("Bạn chưa nhập nội dung!");
		document.getElementById('content_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('captcha_contact').value))
	{
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_contact').focus();
		return false;
	}
	document.frmContact.submit();
}
/*END Check Input*/
/*BEGIN: Khoa Ky Tu Khong Cho Phep*/
var rBlock={
  'SpecialChar':/['\'\"\\#~`<>;']/g,
  'AllSpecialChar':/['@\'\"\\~<>;`&\/%$^*{}\[\]!|():,?+=#']/g,
  'NotNumbers':/[^\d]/g
};
function BlockChar(div,type)
{
	div.value = div.value.replace(rBlock[type],'');
	div.value = div.value.replace(/ +/g,' ');
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
/*BEGIN: Format Cost*/
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
	if(document.getElementById(div)){
		document.getElementById(div).innerHTML = AddComma(cost);
	}
}
/*END Format Cost*/
function FormatCurrency(div,idGeted,number)
{
	/*Convert tu 1000->1.000*/
	/*var mynumber=1000;number = number.replace(/\./g,"");*/
	document.getElementById(div).style.display = "";
	document.getElementById(div).innerHTML = AddComma(number);
	document.getElementById(div).innerHTML = document.getElementById(div).innerHTML + '&nbsp;' + document.getElementById(idGeted).options[document.getElementById(idGeted).selectedIndex].innerHTML;
}
/*BEGIN: Sub*/
function subStr(str, leng, div)
{
	var currentLeng = str.length;
	var result = '';
	var i = 0;
	while(i < leng)
	{
		result += str.charAt(i);
		if(i == currentLeng)
		{
			document.getElementById(div).innerHTML = str;
			return;
		}
		i += 1;
	}
	document.getElementById(div).innerHTML = result + ' ...';
}
/*END Sub*/
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
				document.getElementById(div).style.background = "#f1f9ff";
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
/*BEGIN: Favorite*/
function Favorite(formName, status)
{
	if(status == '1')
	{
		eval('document.' + formName + '.submit();');
	}
	else
	{
		alert(status);
	}
}
/*END Favorite*/
/*BEGIN: Showcart*/
function Showcart(formName, status)
{
	if(status == '1')
	{
		eval('document.' + formName + '.submit();');
	}
	else
	{
		alert(status);
	}
}
/*END Showcart*/
/*BEGIN: ActionLink*/
function ActionLink(isAddress)
{
	document.location.href = isAddress;
}
/*END ActionLink*/
/*BEGIN: ActionSort*/
function ActionSort(isAddress)
{
	window.location.href = isAddress;
}
/*END ActionSort*/
/*BEGIN: Show Thumbnail*/
function validImage(id)
{
    id = id*1;
    if(id > 1506)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function showThumbnail(id, image, thumb)
{
    var imageArray = image.split(',');
    if(validImage(id))
    {
        return 'thumbnail_' + thumb + '_' + imageArray[0];
    }
    else
    {
        return imageArray[0];
    }
}
function CheckInput_vote(){
	if(CheckBlank(document.getElementById('uper_title').value))
	{
		jAlert("Bạn chưa nhập tiêu đề!",'Yêu cầu nhập',function(r){
			jQuery('#uper_title').focus();														 
		});
		return false;
	}
	if(CheckBlank(document.getElementById('uper_comment').value))
	{
		jAlert("Bạn chưa nhập nội dung!",'Yêu cầu nhập',function(r){
			jQuery('#uper_comment').focus();														 
		});
		return false;
	}
	if(CheckBlank(document.getElementById('captcha_shop').value))
	{
		jAlert("Bạn chưa nhập mã xác nhận!",'Yêu cầu nhập',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	if(document.getElementById('captcha_shop').value != document.getElementById('current_captcha').value)
	{
		jAlert("Bạn chưa nhập mã xác nhận chưa đúng!",'Nhập sai',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	jQuery('#isShopVote').val(1);
	document.frmShopVote.submit();
}
/*END Show Thumbnail*/
/*BEGIN: Favorite*/
function Favorite(formName, status)
{
	if(status == '1')
	{
		eval('document.' + formName + '.submit();');
	}
	else
	{
		alert(status);
	}
}
/*END Favorite*/
/*BEGIN: Showcart*/
function Showcart(formName, status)
{
	if(status == '1')
	{
		eval('document.' + formName + '.submit();');
	}
	else
	{
		alert(status);
	}
}
function Showcart_order_now(formName, status)
{
	if(status == '1')
	{
		eval('document.' + formName + '.submit();');
	}
	else
	{
		alert(status);
	}
}
/*END Showcart*/
function tooltipPicture1(id){
	tooltipPicture(jQuery('#'+id),id);
}
function tooltipPicture(obj,id){
				jQuery(obj).tooltip({
					delay: 100,
					bodyHandler: function(){
						width	= 350;
						height	= 350;
						if(typeof(jQuery(this).attr("tooltipWidth")) != "undefined"){
							width = parseInt(jQuery(this).attr("tooltipWidth"));
						}
						if(typeof(jQuery(this).attr("tooltipHeight")) != "undefined"){
							height = parseInt(jQuery(this).attr("tooltipHeight"));
						}
						jQuery("#tooltip").css("width", width + "px");
						picturePath = jQuery('#image-'+id).val();
						strReturn = "";
						strReturn += '<div class="name">'+jQuery("#name-"+id).val()+'</div>';
						strReturn += '<div class="margin">Giá:<b class="price">'+jQuery("#price-"+id).val()+jQuery("#price-"+id).html()+'</b>&nbsp; &nbsp; (Lượt xem: '+ jQuery("#view-"+id).val() +')</div>';
						strReturn += '<div class="margin">Tại gian hàng:<b><span class="company">'+jQuery("#shop-"+id).val()+'</b></div>';
						strReturn += '<div class="margin">Vị trí:<b>'+jQuery("#pos-"+id).val()+'</b></div>';
						strReturn += '<div class="margin">Bình chọn:<b>'+jQuery("#danhgia-"+id).html()+'</b></div>';
						strReturn += '<div class="picture_only">'+ resizeImageSrc(picturePath, jQuery(this).width(), jQuery(this).height(), width, height) + '</div>';
						return strReturn;
					},
					track: true,
					showURL: false,
					extraClass: "tooltip_product"
				});
			}
			function resizeImageSrc(src, width, height, maxWidth, maxHeight){
				opts	= {
					resizeLess	: true,
					html: ""
				};
				args	= resizeImageSrc.arguments;
				if(typeof(args[5]) != "undefined") jQuery.extend(opts, args[5]);
				
				if(opts.resizeLess == true || (width > maxWidth || height > maxHeight)){
					// Check if the current width is larger than the max
					ratio		= maxWidth / width;   // Get ratio for scaling image
					width		= maxWidth;
					height	= height * ratio;    // Reset height to match scaled image
					// Check if current height is larger than max
					if(height > maxHeight){
						ratio		= maxHeight / height; // Get ratio for scaling image
						height	= maxHeight;
						width		= width * ratio;    // Reset width to match scaled image
					}
				}
				
				return '<img src="' + src + '" width="' + parseInt(width) + '" height="' + parseInt(height) + '" ' + opts.html + '/>';
			}

function addCart(pro_id){
	showLoading();
	$.ajax({
		type: "POST",
		dataType: "json",
		url: siteUrl +'showcart/add',
		data: $('#bt_'+pro_id+' :input').serialize(),
		success: function(result) {

			if(result.error == false){
				$('.cartNum').text(result.num);
			}
			if(result.message != ''){
				var type = result.error == true ? 'alert-danger' : 'alert-success';
				showMessage(result.message, type);
			}else{
				hideLoading();
			}


		},
		error: function() {}
	});
}
function addCartQty(pro_id) {
    showLoading();
    var qty = $('input#qty_' + pro_id).val();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: siteUrl + 'showcart/add',
        data: $('#bt_' + pro_id + ' :input').serialize() + '&qty=' + qty,
        success: function (result) {
            if (result.error == false) {
                $('.cartNum').text(result.num);
            }
            var type = result.error == true ? 'alert-danger' : 'alert-success';
            showMessage(result.message, type);
        },
        error: function () {
        }
    });
}

function update_qty(pro_id, num) {
    var qty = parseInt($('input#qty_' + pro_id).val(), 10);
    var meg = '';
    var qty_min = parseInt($('#bt_' + pro_id + ' input[name="qty_min"]').val(), 10);
    var qty_max = parseInt($('#bt_' + pro_id + ' input[name="qty_max"]').val(), 10);
    var qty_new = qty + num;
    if (qty_new <= qty_min) {
        qty_new = qty_min;
        meg = 'Bạn phải mua tối thiểu ' + qty_min + ' sản phẩm';
    }
    if (qty_new >= qty_max) {
        qty_new = qty_max;
        meg = 'Xin lỗi, chúng tôi chỉ có ' + qty_max + ' sẩn phẩm trong kho';
    }
    $('input#qty_' + pro_id).val(qty_new);
    if ($('#mes_' + pro_id + ' + .qty_message').length == 0) {
        $('#mes_' + pro_id).after('<span class="qty_message"></span>');
    }
    if (meg != '') {
        $('#mes_' + pro_id + ' + .qty_message').text(meg).show();
    } else {
        $('#mes_' + pro_id + ' + .qty_message').hide();
    }
}
function showLoading() {
    $('.loading').show();
    $('#aziload').show();
}
function hideLoading() {
    $('#aziload').hide();
}
function showMessage(message, type) {
    $('.loading').hide();
	$('#myModal').modal('show');
   	$('#myModal .modal-content').html('<div class="alert ' + type + ' alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>' + message + '</div>');
  
   //$('.azimes').html('<p class="' + type + '">' + message + '</p>');
   //  $('.loading_bg').click(function () {
   //      hideLoading();
   //     // $('.azimes').empty();
	// 	$('#myModal').modal('hide');
   //      $('.loading_bg').unbind('click');
   //  });
}
function showMessageBox(message) {
    $('.loading').hide();
    $('.azimes').html(message);
    $('.loading_bg').click(function () {
        hideLoading();
        $('.azimes').empty();
        $('.loading_bg').unbind('click');
    });
}

function buyNowQty(pro_id) {
    showLoading();
    var qty = $('input#qty_' + pro_id).val();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: siteUrl + 'showcart/add',
        data: $('#bt_' + pro_id + ' :input').serialize() + '&qty=' + qty,
        success: function (result) {

            if (result.error == false) {
                window.location = siteUrl + 'checkout';
                //$('.cartNum').text(result.num);
            } else {
                var type = result.error == true ? 'alert-danger' : 'alert-success';
                showMessage(result.message, type);
            }


        },
        error: function () {
        }
    });
}
function wishlist(pro_id) {
    showLoading();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: siteUrl + 'ajax/action/wishlist',
        data: $('#bt_' + pro_id + ' :input').serialize(),
        success: function (result) {
            var type = result.error == true ? 'alert-danger' : 'alert-success';
            showMessage(result.message, type);


        },
        error: function () {
        }
    });
}