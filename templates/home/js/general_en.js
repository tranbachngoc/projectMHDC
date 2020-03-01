var defSearchKeyword= "Search...";
/*BEGIN: Waiting Load Page*/
function WaitingLoadPage()
{
	jQuery("DivGlobalSite").css('display','');
	//document.getElementById('DivGlobalSite').style.display = '';
}
/*END Waiting Load Page*/
/*BEGIN: OpenTab*/
function OpenTab(status)
{
	switch (status)
	{
		case 1:
			document.getElementById('DivContentDetail').style.display = "";
			document.getElementById('DivVoteDetail').style.display = "none";
			document.getElementById('DivReplyDetail').style.display = "none";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
			break;
		case 2:
			document.getElementById('DivContentDetail').style.display = "none";
			document.getElementById('DivVoteDetail').style.display = "";
			document.getElementById('DivReplyDetail').style.display = "none";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
			break;
		case 3:
			document.getElementById('DivContentDetail').style.display = "none";
			document.getElementById('DivVoteDetail').style.display = "none";
			document.getElementById('DivReplyDetail').style.display = "";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
			break;
		case 4:
			if(document.getElementById('DivSendLinkDetail').style.display == "")
			{
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendLinkDetail').style.display = "";
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			break;
		case 5:
			if(document.getElementById('DivSendFailDetail').style.display == "")
			{
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendFailDetail').style.display = "";
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			break;
		default:
			document.getElementById('DivContentDetail').style.display = "";
			document.getElementById('DivVoteDetail').style.display = "none";
			document.getElementById('DivReplyDetail').style.display = "none";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
	}
}

function OpenTabAds(status)
{
	switch (status)
	{
		case 1:
			document.getElementById('DivContentDetail').style.display = "";
			document.getElementById('DivReplyDetail').style.display = "none";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
			break;
		case 2:
			document.getElementById('DivContentDetail').style.display = "none";
			document.getElementById('DivReplyDetail').style.display = "";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
			break;
		case 3:
			if(document.getElementById('DivSendLinkDetail').style.display == "")
			{
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendLinkDetail').style.display = "";
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			break;
		case 4:
			if(document.getElementById('DivSendFailDetail').style.display == "")
			{
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendFailDetail').style.display = "";
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			break;
		default:
			document.getElementById('DivContentDetail').style.display = "";
			document.getElementById('DivReplyDetail').style.display = "none";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
	}
}

function OpenTabJob(status)
{
	switch (status)
	{
		case 1:
			if(document.getElementById('DivSendLinkDetail').style.display == "")
			{
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendLinkDetail').style.display = "";
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			break;
		case 2:
			if(document.getElementById('DivSendFailDetail').style.display == "")
			{
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendFailDetail').style.display = "";
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			break;
		default:
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
	}
}
/*END OpenTab*/
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
/*BEGIN: Kiem Tra TextBox Co Rong*/
function TrimInput(sString)
{
	if(sString!=''){
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
}

function CheckBlank(str)
{
	if(TrimInput(str) == '' || str ==''){
		return true;//Neu chua nhap
	}
	else
	{
		return false;//Neu da nhap
	}
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
/*BEGIN: Check Link*/
function CheckLink(char)
{
	var str="0123456789abcdefghikjlmnopqrstuvwxysz-_";
	for(var i=0;i<char.length;i++)
	{
		if(str.indexOf(char.charAt(i)) == -1)
		{
			return false;
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
			return false;
		}
	}
	return true;//Dung la ky tu cho phep
}
/*END Check Website*/
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
function CheckInput_SendLink()
{
	if(CheckBlank(document.getElementById('sender_sendlink').value))
	{
		jAlert("You did not enter email of sender!","Input Required",function(r){
			if(r ==true){
				document.getElementById('sender_sendlink').focus();
				return false;
			}
		});
	}
	else
	{
		if(!CheckEmail(document.getElementById('sender_sendlink').value))
		{
			jAlert("Email you entered is not valid!","Wrong input",function(r){
				if(r==true){
					document.getElementById('sender_sendlink').focus();
					return false;
				}
			});
		}
		else
		{
			if(CheckBlank(document.getElementById('receiver_sendlink').value))
			{
				jAlert("You did not enter a email of receiver!","Input Required",function(r){
					if(r==true){
						document.getElementById('receiver_sendlink').focus();
						return false;
					}
				});
			}
			else
			{
				if(!CheckEmail(document.getElementById('receiver_sendlink').value))
				{
					jAlert("Email you entered is not valid!","Wrong input",function(r){
						if(r==true){
							document.getElementById('receiver_sendlink').focus();
							return false;
						}
					});
				}
				else
				{
					if(CheckBlank(document.getElementById('title_sendlink').value))
					{
						jAlert("You did not enter the title!","Input Required",function(r){
							if(r==true){
								document.getElementById('title_sendlink').focus();
								return false;
							}
						});
					}
					else
					{
						if(CheckBlank(document.getElementById('content_sendlink').value))
						{
							jAlert("You did not enter a message!","Input Required",function(r){
								if(r==true){
									document.getElementById('content_sendlink').focus();
									return false;
								}
							});
						}
						else
						{
							if(CheckBlank(document.getElementById('captcha_sendlink').value))
							{
								jAlert("You not input verification code!","Input Required",function(r){
									if(r==true){
										document.getElementById('captcha_sendlink').focus();
										return false;
									}
								});
							}
							else
							{
								if( document.getElementById('captcha_sendlink').value != document.getElementById('captcha_sendlink_hidden').value){
									jAlert("Verification code you entered not valid!","Wrong input",function(r){
										if(r==true){
											document.getElementById('captcha_sendlink').focus();
											return false;
										}
									});	 
								}
								else
								{
									jQuery('#isPostSendLink').val(1);
									document.frmSendLink.submit();
								}
							}
						}
					}
				}
			}
		}
	}
}

function CheckInput_SendFail(status)
{
	if(status == '1')
	{
		if(CheckBlank(document.getElementById('sender_sendfail').value))
		{
			jAlert("You did not enter email of sender!","Input Required",function(r){
				if(r==true){
					document.getElementById('sender_sendfail').focus();
					return false;
				}
			});	
		}
		else
		{
			if(!CheckEmail(document.getElementById('sender_sendfail').value))
			{
				jAlert("Email you entered is not valid!","Wrong input",function(r){
					if(r==true){
						document.getElementById('sender_sendfail').focus();
						return false;
					}
				});
			}
			else
			{
				if(CheckBlank(document.getElementById('title_sendfail').value))
				{
					jAlert("You did not enter the title!","Input Required",function(r){
						if(r==true){
							document.getElementById('title_sendfail').focus();
							return false;
						}
					});
				}
				else
				{
					if(CheckBlank(document.getElementById('content_sendfail').value))
					{
						jAlert("You still not enter the content!","Input Required",function(r){
							if(r==true){
								document.getElementById('content_sendfail').focus();
								return false;
							}
						});
					}
					else
					{
						if(CheckBlank(document.getElementById('captcha_sendfail').value))
						{
							jAlert("You not input verification code!","Input Required",function(r){
								if(r==true){
									document.getElementById('captcha_sendfail').focus();
									return false;
								}
							});
						}
						else
						{
							if( document.getElementById('captcha_sendfail').value != document.getElementById('captcha_sendfail_hidden').value){
								jAlert("Verification code you entered not valid!","Wrong input",function(r){
									if(r==true){
										document.getElementById('captcha_sendfail').focus();
										return false;
									}
								});
										 
							}
							else
							{
								jQuery('#isPostSendFail').val(1);
								document.frmSendFail.submit();
							}
						}
					}
				}
			}
		}
	}
	else
	{
		jAlert("Thank you, this product has been reported bad product,<br/>We are handling.","Notice");
		return false;
	}
}
function chk_sendMail(){
	if(jQuery('#msgmail').val() == ''){
		jAlert('You have not entered the sender email address.','Notice',function(r){
			if(r == true){
				jQuery('#msgmail').focus();
				return false;
			}
		});
	}else{
		if(jQuery('#msgsubject').val() == ''){
			jAlert('You have not entered the request header.','Notice',function(r){
				if(r == true){
					jQuery('#msgsubject').focus();
					return false;
				}
			});
		}else{
			var $sendContent = jQuery('#txtContent').val();
			if($sendContent =='' || $sendContent.length < 20 || $sendContent.length > 8000){
				jAlert('Enter between 20 to 8,000 characters.','Notice',function(r){
					if(r == true){
						jQuery('#txtContent').focus();
						return false;
					}
				});
			}else{
				if(jQuery('#captcha_msg').val() == ''){

					jAlert('You have not entered verification code.','Notice',function(r){
						if(r == true){
							jQuery('#captcha_msg').focus();
							return false;
						}
					});
				}else{
					if(jQuery('#captcha_msg').val() != jQuery('#captcha_send_msg').val()){
						jAlert('You have entered verification code not valid.','Notice',function(r){
							if(r == true){
								jQuery('#captcha_msg').focus();
								return false;
							}
						});
					}else{
						jQuery('#frmMsgSend').submit();
					}
				}
			}
		}
	}
}
function CheckInput_SendSupplier(){
	if(jQuery('#ffbEmail').val() == ''){
		jAlert('You have not entered the sender email address.','Notice',function(r){
			if(r == true){
				jQuery('#ffbEmail').focus();
				return false;
			}
		});
	}else{
		var $sendContent = jQuery('#fbTextArea').val();
		if($sendContent =='' || $sendContent.length < 20 || $sendContent.length > 8000){
			jAlert('Enter between 20 to 8,000 characters.','Notice',function(r){
				if(r == true){
					jQuery('#fbTextArea').focus();
					return false;
				}
			});
		}else{
			if(jQuery('#captcha_sendsupplier').val() == ''){
				jAlert('You have not entered verification code.','Notice',function(r){
					if(r == true){
						jQuery('#captcha_sendsupplier').focus();
						return false;
					}
				});
			}else{
				if(jQuery('#captcha_sendsupplier').val() != jQuery('#captcha_send_supplier').val()){
					jAlert('You have entered verification code not valid.','Notice',function(r){
						if(r == true){
							jQuery('#captcha_sendsupplier').focus();
							return false;
						}
					});
				}else{
					jQuery('#frmSendMailtoSupplier').submit();
				}
			}
		}
	}
}
function CheckInput_Tag(status)
{
	if(status == '1')
	{
		if(CheckBlank(document.getElementById('title_tag').value))
		{
			jAlert("You have not entered tag!","Input Required",function(r){
				if(r == true){
					document.getElementById('title_tag').focus();
					return false;
				}
			});
		}
		else
		{
			if(CheckBlank(document.getElementById('captcha_tag').value))
			{
				jAlert("You not input verification code!","Input Required",function(r){
					if(r == true){
						document.getElementById('captcha_tag').focus();
						return false;
					}
				});
			}
			else
			{
				if(jQuery('#captcha_tag').val() != jQuery('#captcha_tag_hidden').val()){
					jAlert('You have entered verification code not valid.','Notice',function(r){
						if(r == true){
							jQuery('#captcha_tag').focus();
							return false;
						}
					});
				}
				else
				{
					document.frmTag.submit();
				}
			}
		}
	}
	else
	{
		jAlert(status,'Notice');
		return false;
	}
}
function CheckInput_Reply(status)
{
	if(status == '1')
	{
		if(CheckBlank(document.getElementById('title_reply').value))
		{
			jAlert("You did not enter the title!","Input Required",function(r){
				if(r == true){
					document.getElementById('title_reply').focus();
					return false;
				}
			});
		}
		else
		{
			if(CheckBlank(document.getElementById('content_reply').value))
			{
				jAlert("You still not enter the content!","Input Required",function(r){
					if(r == true){
						document.getElementById('content_reply').focus();
						return false;
					}
				});
			}
			else
			{
				if(CheckBlank(document.getElementById('captcha_reply').value))
				{
					jAlert("You not input verification code!","Input Required",function(r){
						if(r == true){
							document.getElementById('captcha_reply').focus();
							return false;
						}
					});
				}
				else
				{
					if(jQuery('#captcha_reply').val() != jQuery('#captcha_reply_hidden').val()){
						jAlert('You have entered verification code not valid.','Notice',function(r){
							if(r == true){
								jQuery('#captcha_reply').focus();
								return false;
							}
						});
					}
					else
					{
						jQuery('#isPostReply').val(1);
						document.frmReply.submit();
					}
				}
			}
		}		
	}
	else
	{
		jAlert(status,'Notice');
		return false;
	}
}

function isInt(x) {
	  var y=parseInt(x);
	  if (isNaN(y)) return false;
	  return x==y && x.toString()==y.toString();
}
function CheckInput_PostPro()
{
	 if(CheckBlank(document.getElementById('name_pro').value))
	 {
		jAlert("You did not enter the product name!","Input Required",function(r){
			document.getElementById('name_pro').focus();
		});
		return false;
	 }
	 if(jQuery('#saleoff_pro').is(':checked')){
		if(CheckBlank(document.getElementById('pro_saleoff_value').value)){
			jAlert("You did not enter a discount amount!","Input Required",function(r){
				document.getElementById('pro_saleoff_value').focus();
			});
			return false;
		}else{
			if(jQuery('#pro_saleoff_value').val()>100 && jQuery('#pro_type_saleoff').val()=='1' ){
				jAlert("Discount percentage must be less than 100%!","Wrong input",function(r){
					document.getElementById('pro_saleoff_value').focus();
				});
				return false;
			}
			if(!isInt(jQuery('#pro_saleoff_value').val()) ){
				jAlert("You must enter the discount amount is numeric!","Wrong input",function(r){
					document.getElementById('pro_saleoff_value').focus();
				});
				return false;
			}
			if(jQuery('#pro_saleoff_value').val()=='0' ){
				jAlert("You must enter the discount amount greater than 0!","Wrong input",function(r){
					document.getElementById('pro_saleoff_value').value='';
					document.getElementById('pro_saleoff_value').focus();
				});
				return false;
			}
		}
	 }
	 if(document.getElementById('nonecost_pro').checked == false)
	 {
		 if(CheckBlank(document.getElementById('cost_pro').value))
		 {
			jAlert("You did not enter the price of product!","Input Required",function(r){
				document.getElementById('cost_pro').focus();
			});
			return false;
		 }
		 if(!IsNumber(document.getElementById('cost_pro').value))
		 {
			jAlert("Price you entered is not valid! \nYou just enter the number from 0-9.","Wrong input",function(r){
				document.getElementById('cost_pro').focus();
			});
			return false;
		 }
		 if(document.getElementById('cost_pro').value == "0" && document.getElementById('nego_pro').checked == false)
		 {
			jAlert("Price is not equal to 0! \n You can select No pricing.","Wrong input",function(r){
				document.getElementById('cost_pro').focus();
			});
			return false;
		 }
	 }
	 if(CheckBlank(document.getElementById('hd_category_id').value))
	 {
		jAlert("You did not selected category or this is not the category for post product!","Input Required",function(r){
		});
		return false;
	 }
	 if(!CheckDate(document.getElementById('day_pro').value,document.getElementById('month_pro').value,document.getElementById('year_pro').value))
	 {
		 jAlert("Post time end invalid! \n Time end must be greater than current date.","Wrong input",function(r){});
		 return false;
	 }
	 
	 var product_detail = tinyMCE.get('txtContent').getContent();
	 if(CheckBlank(product_detail))
	 {
		jAlert("You did not enter product details!","Input Required",function(r){
			document.getElementById('txtContent').focus();
		});
		return false;
	 }
	 var validExtensions = [".gif", ".png",".jpg"];
	 if(jQuery('#image_1_pro')[0].files[0]){
		filename = jQuery('#image_1_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_1_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_2_pro')[0].files[0]){
		filename = jQuery('#image_2_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_2_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_3_pro')[0].files[0]){
		filename = jQuery('#image_3_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_3_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_4_pro')[0].files[0]){
		filename = jQuery('#image_4_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_4_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_5_pro')[0].files[0]){
		filename = jQuery('#image_5_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_5_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(CheckBlank(document.getElementById('fullname_pro').value))
	 {
		jAlert("You did not enter the poster product!","Input Required",function(r){
			document.getElementById('fullname_pro').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_pro').value))
	 {
		jAlert("You dit not enter contact address!","Input Required",function(r){
			document.getElementById('address_pro').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_pro').value))
	 {
		jAlert("You dit not enter phone number!","Input Required",function(r){
			document.getElementById('phone_pro').focus();
		});
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_pro').value))
	 {
		jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Wrong input",function(r){
			document.getElementById('phone_pro').focus();
		});
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_pro').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_pro').value))
		 {
			jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Wrong input",function(r){
				document.getElementById('mobile_pro').focus();
			});
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_pro').value))
	 {
		jAlert("You did not enter email!","Input Required",function(r){
			document.getElementById('email_pro').focus();
		});
		return false;
	 }
	 if((document.getElementById('descr_pro').value).length > 35)
	 {
		jAlert("The short description entered more than 35 characters!","Input Required",function(r){
			document.getElementById('descr_pro').focus();
		});
		return false;
	 }
	 
	 
	 
	 if(!CheckEmail(document.getElementById('email_pro').value))
	 {
		jAlert("Email you entered is not valid!","Input Required",function(r){
			document.getElementById('email_pro').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_pro').value))
	 {
		jAlert("You not input verification code!","Input Required",function(r){
			document.getElementById('captcha_pro').focus();
		});
		return false;
	 }else{
		 if( document.getElementById('captcha_pro').value != document.getElementById('captcha').value){
			 jAlert("Verification code you entered not valid!","Wrong input",function(r){
				document.getElementById('captcha_pro').focus();
			});
			 return false;
		 }
	 }
	 jQuery('#isPostProduct').val(1);
	 document.frmPostPro.submit();
}
function CheckInput_PostRPro()
{
	 if(CheckBlank(document.getElementById('name_pro').value))
	 {
		jAlert("You did not enter the product name!","Input Required",function(r){
			document.getElementById('name_pro').focus();
		});
		return false;
	 }
	 if(document.getElementById('nonecost_pro').checked == false)
	 {
		 if(CheckBlank(document.getElementById('cost_pro').value))
		 {
			jAlert("You did not enter the price of product!","Input Required",function(r){
				document.getElementById('cost_pro').focus();
			});
			return false;
		 }
		 if(!IsNumber(document.getElementById('cost_pro').value))
		 {
			jAlert("Price you entered is not valid! \nYou just enter the number from 0-9.","Wrong input",function(r){
				document.getElementById('cost_pro').focus();
			});
			return false;
		 }
		 if(document.getElementById('cost_pro').value == "0" && document.getElementById('nego_pro').checked == false)
		 {
			jAlert("Price is not equal to 0! \n You can select No pricing.","Wrong input",function(r){
				document.getElementById('cost_pro').focus();
			});
			return false;
		 }
	 }
	 if(CheckBlank(document.getElementById('hd_category_id').value))
	 {
		jAlert("You did not selected category or this is not the category for post product!","Input Required",function(r){
		});
		return false;
	 }
	 if(!CheckDate(document.getElementById('day_pro').value,document.getElementById('month_pro').value,document.getElementById('year_pro').value))
	 {
		 jAlert("Post time end invalid! \n Time end must be greater than current date.","Wrong input",function(r){});
		 return false;
	 }
	 
	 var product_detail = tinyMCE.get('txtContent').getContent();
	 if(CheckBlank(product_detail))
	 {
		jAlert("You did not enter product details!","Input Required",function(r){
			document.getElementById('txtContent').focus();
		});
		return false;
	 }
	 var validExtensions = [".gif", ".png",".jpg"];
	 if(jQuery('#image_1_pro')[0].files[0]){
		filename = jQuery('#image_1_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_1_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_2_pro')[0].files[0]){
		filename = jQuery('#image_2_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_2_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_3_pro')[0].files[0]){
		filename = jQuery('#image_3_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_3_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_4_pro')[0].files[0]){
		filename = jQuery('#image_4_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_4_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_5_pro')[0].files[0]){
		filename = jQuery('#image_5_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_5_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(CheckBlank(document.getElementById('fullname_pro').value))
	 {
		jAlert("You did not enter the poster product!","Input Required",function(r){
			document.getElementById('fullname_pro').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_pro').value))
	 {
		jAlert("You dit not enter contact address!","Input Required",function(r){
			document.getElementById('address_pro').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_pro').value))
	 {
		jAlert("You dit not enter phone number!","Input Required",function(r){
			document.getElementById('phone_pro').focus();
		});
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_pro').value))
	 {
		jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Wrong input",function(r){
			document.getElementById('phone_pro').focus();
		});
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_pro').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_pro').value))
		 {
			jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Wrong input",function(r){
				document.getElementById('mobile_pro').focus();
			});
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_pro').value))
	 {
		jAlert("You did not enter email!","Input Required",function(r){
			document.getElementById('email_pro').focus();
		});
		return false;
	 }
	 if((document.getElementById('descr_pro').value).length > 35)
	 {
		jAlert("The short description entered more than 35 characters!","Input Required",function(r){
			document.getElementById('descr_pro').focus();
		});
		return false;
	 }
	 
	 
	 
	 if(!CheckEmail(document.getElementById('email_pro').value))
	 {
		jAlert("Email you entered is not valid!","Input Required",function(r){
			document.getElementById('email_pro').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_pro').value))
	 {
		jAlert("You not input verification code!","Input Required",function(r){
			document.getElementById('captcha_pro').focus();
		});
		return false;
	 }else{
		 if( document.getElementById('captcha_pro').value != document.getElementById('captcha').value){
			 jAlert("Verification code you entered not valid!","Wrong input",function(r){
				document.getElementById('captcha_pro').focus();
			});
			 return false;
		 }
	 }
	 jQuery('#isPostRProduct').val(1);
	 document.frmPostPro.submit();
}
function CheckInput_TranMoneyOther($baseurl){
	$username = document.getElementById('tranfer_to_other').value;
	if(CheckBlank($username))
	{
		jAlert("You did not enter account of receiver!","Input Required",function(r){
			document.getElementById('tranfer_to_other').focus();
		});
		return false;
	}
	else
	{
		jQuery.ajax({
			type: "POST",
			url: $baseurl + "account/chkusername",
			data: "username=" + $username,
			success: function(data){
				if(data == 0){
					jAlert("You have entered account not exist in the system!","Wrong input",function(r){
						document.getElementById('tranfer_to_other').focus();
					});
					return false;
				}
				else
				{
					CheckInput_TranMoneyOtherFild();
				}
			},
			error: function(){alert('aaaaa');}
		});
	}
}
function CheckInput_TranMoneyOtherFild(){
	if(CheckBlank(document.getElementById('tranfer_amount_other').value))
	{
		jAlert("You did not enter the amount of money to tranfer!","Input Required",function(r){
			document.getElementById('tranfer_amount_other').focus();
		});
		return false;
	}
	else
	{
		if(!IsNumber(document.getElementById('tranfer_amount_other').value))
		{
			jAlert("Amount of money must be numberic!","Wrong input",function(r){
				document.getElementById('tranfer_amount_other').focus();
			});
			return false;
		}
		else
		{
			if(document.getElementById('tranfer_amount_other').value == 0){
				jAlert("Amount of money must greater than 0!","Wrong input",function(r){
					document.getElementById('tranfer_amount_other').focus();
				});
				return false;
			}
			else
			{
				if(document.getElementById('tranfer_amount_other').value > document.getElementById('current_tk1').value){
					jAlert("Amount of money to tranfer must smaller than current amount of account 1!","Wrong input",function(r){
						document.getElementById('tranfer_amount_other').focus();
					});
					return false;
				}
			}
		}
	}
	if(CheckBlank(document.getElementById('captcha_other').value))
	 {
		jAlert("You not input verification code!","Input Required",function(r){
			document.getElementById('captcha_other').focus();
		});
		return false;
	 }else{
		 if( document.getElementById('captcha_other').value != document.getElementById('captcha_other_hidden').value){
			 jAlert("Verification code you entered not valid!","Wrong input",function(r){
				document.getElementById('captcha_other').focus();
			});
			 return false;
		 }
	 }
	document.frmTranMoneyToOther.submit();
}

function CheckInput_TranMoney(){
	if(CheckBlank(document.getElementById('tranfer_amount').value))
	{
		jAlert("You did not enter the amount of money to tranfer!","Input Required",function(r){
			document.getElementById('tranfer_amount').focus();
		});
		return false;
	}
	else
	{
		if(!IsNumber(document.getElementById('tranfer_amount').value))
		{
			jAlert("Amount of money must be numberic!","Wrong input",function(r){
				document.getElementById('tranfer_amount').focus();
			});
			return false;
		}
		else
		{
			if(document.getElementById('tranfer_amount').value == 0){
				jAlert("Amount of money must greater than 0!","Wrong input",function(r){
					document.getElementById('tranfer_amount').focus();
				});
				return false;
			}
			else
			{
				if(document.getElementById('tranfer_amount').value > document.getElementById('current_tk1').value){
					jAlert("Amount of money to tranfer must smaller than current amount of account 1!","Wrong input",function(r){
						document.getElementById('tranfer_amount').focus();
					});
					return false;
				}
			}
		}
	}
	if(CheckBlank(document.getElementById('captcha_account').value))
	 {
		jAlert("You not input verification code!","Input Required",function(r){
			document.getElementById('captcha_account').focus();
		});
		return false;
	 }else{
		 if( document.getElementById('captcha_account').value != document.getElementById('captcha_hidden').value){
			 jAlert("Verification code you entered not valid!","Wrong input",function(r){
				document.getElementById('captcha_account').focus();
			});
			 return false;
		 }
	 }
	document.frmTranMoney.submit();
}
function CheckInput_PostAds($baseurl)
{
	 if(CheckBlank(document.getElementById('title_ads').value))
	 {
		jAlert("You did not enter the title!","Input Required",function(r){
			document.getElementById('title_ads').focus();
		});
		return false;
	 }
	 
	 if((document.getElementById('descr_ads').value).length>35)
	 {
		jAlert("You entered short description more than 35 characters!","Input Required",function(r){
			document.getElementById('descr_ads').focus();
		});
		return false;
	 }
	 if(CheckBlank(document.getElementById('hd_category_id').value))
	 {
		jAlert("You did not select category or this is not a category for post classifieds.!","Input Required",function(r){
		});
		return false;
	 }
	 if(!CheckDate(document.getElementById('day_ads').value,document.getElementById('month_ads').value,document.getElementById('year_ads').value))
	 {
		 jAlert("Post time end invalid! \n Time end must be greater than current date.","Wrong input",function(r){});
		 return false;
	 }
	 
	var product_detail = tinyMCE.get('txtContent').getContent();
	 if(CheckBlank(product_detail))
	 {
		jAlert("You did not enter classified detail!","Input Required",function(r){
			document.getElementById('txtContent').focus();
		});
		return false;
	 }
	 var validExtensions = [".gif", ".png",".jpg"];
	 if(jQuery('#image_1_ads')[0].files[0]){
		filename = jQuery('#image_1_ads')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_1_ads')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_2_ads')[0].files[0]){
		filename = jQuery('#image_2_ads')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_2_ads')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_3_ads')[0].files[0]){
		filename = jQuery('#image_3_ads')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_3_ads')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_4_ads')[0].files[0]){
		filename = jQuery('#image_4_ads')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_4_ads')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_5_ads')[0].files[0]){
		filename = jQuery('#image_5_ads')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_5_ads')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(CheckBlank(document.getElementById('fullname_ads').value))
	 {
		jAlert("You did not enter the poster classified!","Input Required",function(r){
			document.getElementById('fullname_ads').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_ads').value))
	 {
		jAlert("You dit not enter contact address!","Input Required",function(r){
			document.getElementById('address_ads').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_ads').value))
	 {
		jAlert("You dit not enter phone number!","Input Required",function(r){
			document.getElementById('address_ads').focus();
		});
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_ads').value))
	 {
		jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Wrong input",function(r){
			document.getElementById('phone_ads').focus();
		});
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_ads').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_ads').value))
		 {
			jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Wrong input",function(r){
				document.getElementById('mobile_ads').focus();
			});
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_ads').value))
	 {
		jAlert("You did not enter email!","Input Required",function(r){
			document.getElementById('email_ads').focus();
		});
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_ads').value))
	 {
		jAlert("Email you entered is not valid!","Wrong input",function(r){
			document.getElementById('email_ads').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_ads').value))
	 {
		jAlert("You not input verification code!","Input Required",function(r){
			document.getElementById('captcha_ads').focus();
		});
		return false;
	 }else{
		if( document.getElementById('captcha_ads').value != document.getElementById('captcha').value){
			 jAlert("Verification code you entered not valid!","Wrong input",function(r){
				document.getElementById('captcha_ads').focus();
			});
			 return false;
		 }
	 }
	 chk_PostAds($baseurl);
}
function chk_PostAds($baseurl){
	$raovattype = jQuery('#rv_type_hidden').val();
	if($raovattype >0)
	{
		jQuery.ajax({
			type: "POST",
			url: $baseurl + "raovat/postraovat",
			data: "raovattype=" + $raovattype,
			success: function(data){
				if(data == 0){
					jAlert("Amount of money in your account not enought for post this type of classified!","Notice",function(r){
					});
					return false;
				}
				else
				{
					jQuery('#isPostAds').val(1);
	 				document.frmPostAds.submit();
				}
			},
			error: function(){alert('aaaaa');}
		});
	}
	else
	{
		jQuery('#isPostAds').val(1);
	 	document.frmPostAds.submit();
	}
}
function CheckInput_PostHds()
{
	 if(CheckBlank(document.getElementById('title_hds').value))
	 {
		jAlert("You did not enter the title!","Input Required",function(r){
			document.getElementById('title_hds').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('hd_category_id').value))
	 {
		jAlert("You did not select category or this is not the category for post FAQ!","Input Required",function(r){
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('username_hds').value))
	 {
		jAlert("You did not enter the name of the poster FAQ!","Input Required",function(r){
			document.getElementById('username_hds').focus();
		});
		return false;
	 }
	 if(CheckBlank(document.getElementById('captcha_hds').value))
	 {
		jAlert("You not input verification code!","Input Required",function(r){
			document.getElementById('captcha_hds').focus();
		});
		return false;
	 }else{
		if( document.getElementById('captcha_hds').value != document.getElementById('captcha').value){
			 jAlert("Verification code you entered not valid!","Wrong input",function(r){
				document.getElementById('captcha_hds').focus();
			});
			 return false;
		 }
	 }
	 jQuery('#isPostHds').val(1);
	 document.frmPostHds.submit();
}

function CheckInput_PostHdsReply()
{
	 if(CheckBlank(tinyMCE.get('txtContent').getContent())){
		jAlert("You did not enter the content of answer!","Input Required",function(r){
		});
		return false;
	 }
	 if(CheckBlank(document.getElementById('captcha_hds').value))
	 {
		jAlert("You not input verification code!","Input Required",function(r){
			document.getElementById('captcha_hds').focus();
		});
		return false;
	 }else{
		if( document.getElementById('captcha_hds').value != document.getElementById('captcha').value){
			 jAlert("Verification code you entered not valid!","Wrong input",function(r){
				document.getElementById('captcha_hds').focus();
			});
			 return false;
		 }
	 }
	 if(jQuery('#editAnswerId').val()){
		jQuery('#isEditHdsReply').val(1);
	 }else{
	 	jQuery('#isPostHdsReply').val(1);
	 }
	 document.frmHoidapReply.submit();
}

function CheckInput_PostJob()
{
	 if(CheckBlank(document.getElementById('title_job').value))
	 {
		alert("You did not enter the title!");
		document.getElementById('title_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('position_job').value))
	 {
		alert("You did not enter the job position!");
		document.getElementById('position_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('level_job').value))
	 {
		alert("You did not enter a level!");
		document.getElementById('level_job').focus();
		return false;
	 }
	 
	 if(document.getElementById('age1_job').value > document.getElementById('age2_job').value)
	 {
		 alert("You selected an invalid age! \n Example: Age 18 to 25.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('require_job').value))
	 {
		alert("You did not enter the job requirements!");
		document.getElementById('require_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('salary_job').value))
	 {
		alert("You did not enter a starting salary!");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('salary_job').value))
	 {
		alert("Starting salary you entered is not valid! \n You just enter the number from 0-9.");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 if(document.getElementById('salary_job').value == "0")
	 {
		alert("Starting salary is not equal to 0!");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('try_job').value))
	 {
		alert("You did not enter a probation period!");
		document.getElementById('try_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('try_job').value))
	 {
		alert("Probationary period you entered is not valid! \n You just enter the number from 0-9.");
		document.getElementById('try_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('interest_job').value))
	 {
		alert("You did not enter the benefits!");
		document.getElementById('interest_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('quantity_job').value))
	 {
		alert("You did not enter a number of recruitment!");
		document.getElementById('quantity_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('quantity_job').value))
	 {
		alert("The number of employers you entered is not valid! \n You just enter the number from 0-9.");


		document.getElementById('quantity_job').focus();
		return false;
	 }
	 if(document.getElementById('quantity_job').value == "0")
	 {
		alert("The number of employers are not equal to 0!");
		document.getElementById('quantity_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('record_job').value))
	 {
		alert("You did not enter the job application!");
		document.getElementById('record_job').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('day_job').value,document.getElementById('month_job').value,document.getElementById('year_job').value))
	 {
		 alert("Filing time is invalid! \n Filing period must be greater than the current date.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("You did not enter the details Jobs!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('name_job').value))
	 {
		alert("You did not enter employer's name!");
		document.getElementById('name_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_job').value))
	 {
		alert("You did not enter employer's address!");
		document.getElementById('address_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_job').value))
	 {
		alert("You dit not enter phone number of employer!");
		document.getElementById('phone_job').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_job').value))
	 {
		alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
		document.getElementById('phone_job').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_job').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_job').value))
		 {
			alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
			document.getElementById('mobile_job').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_job').value))
	 {
		alert("You did not enter email!");
		document.getElementById('email_job').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_job').value))
	 {
		alert("Email you entered is not valid!");
		document.getElementById('email_job').focus();
		return false;
	 }
	 
	 if(!CheckWebsite(document.getElementById('website_job').value))
	 {
		alert("You entered website address not valid!\n Only input characters 0-9, a-z, / . : _ -");
		document.getElementById('website_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('namecontact_job').value))
	 {
		alert("You did not enter a name of the representative!");
		document.getElementById('namecontact_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('addresscontact_job').value))
	 {
		alert("You dit not enter contact address!");
		document.getElementById('addresscontact_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phonecontact_job').value))
	 {
		alert("You dit not enter contact phone number!");
		document.getElementById('phonecontact_job').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phonecontact_job').value))
	 {
		alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
		document.getElementById('phonecontact_job').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobilecontact_job').value))
	 {
		 if(!CheckPhone(document.getElementById('mobilecontact_job').value))
		 {
			alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
			document.getElementById('mobilecontact_job').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('emailcontact_job').value))
	 {
		alert("You did not enter email!");
		document.getElementById('emailcontact_job').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('emailcontact_job').value))
	 {
		alert("Email you entered is not valid!");
		document.getElementById('emailcontact_job').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('endday_job').value,document.getElementById('endmonth_job').value,document.getElementById('endyear_job').value))
	 {
		 alert("Post time end invalid! \n Time end must be greater than current date.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_job').value))
	 {
		alert("You not input verification code!");
		document.getElementById('captcha_job').focus();
		return false;
	 }
	 document.frmPostJob.submit();
}

function CheckInput_PostEmploy()
{
	 if(CheckBlank(document.getElementById('title_employ').value))
	 {
		alert("You did not enter the title!");
		document.getElementById('title_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('position_employ').value))
	 {
		alert("You did not enter the working position!");
		document.getElementById('position_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('salary_employ').value))
	 {
		alert("You did not enter the desired salary!");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('salary_employ').value))
	 {
		alert("Expected salary you entered is not valid! \n You just enter the number from 0-9.");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 if(document.getElementById('salary_employ').value == "0")
	 {
		alert("Expected salary is not equal to 0!");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("You did not enter a detail content of find job!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('name_employ').value))
	 {
		alert("You did not enter full name!");
		document.getElementById('name_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('level_employ').value))
	 {
		alert("You did not enter a level!");
		document.getElementById('level_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_employ').value))
	 {
		alert("You did not enter address!");
		document.getElementById('address_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_employ').value))
	 {
		alert("You dit not enter phone number!");
		document.getElementById('phone_employ').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_employ').value))
	 {
		alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
		document.getElementById('phone_employ').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_employ').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_employ').value))
		 {
			alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
			document.getElementById('mobile_employ').focus();

			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_employ').value))
	 {
		alert("You did not enter email!");
		document.getElementById('email_employ').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_employ').value))
	 {
		alert("Email you entered is not valid!");
		document.getElementById('email_employ').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('endday_employ').value,document.getElementById('endmonth_employ').value,document.getElementById('endyear_employ').value))
	 {
		 alert("Post time end invalid! \n Time end must be greater than current date.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_employ').value))
	 {
		alert("You not input verification code!");
		document.getElementById('captcha_employ').focus();
		return false;
	 }
	 document.frmPostEmploy.submit();
}

function CheckInput_Register()
{
	/* ltngan */
	/*if(document.getElementById('type_value').value=='')
	{
		alert("Bạn chưa chọn Loại thành viên!");
		return false;
	}	
	
	if(document.getElementById('type_value').value!=0)
	{
		if(document.getElementById('active_code').value==''){
			alert("Bạn chưa nhập Mã kích hoạt!");
			document.getElementById('active_code').focus();
			return false;			
		}
	}	*/
	if(!jQuery('#checkDongY').is(':checked'))
	{
		alert("You did not agree with the terms!");
		document.getElementById('checkDongY').focus();
		return false;
	}	
	
	if(CheckBlank(document.getElementById('username_regis').value))
	{
		alert("You did not enter username!");
		document.getElementById('username_regis').focus();
		return false;
	}
	if(!CheckCharacter(document.getElementById('username_regis').value))
	{
		alert("The username you entered is not valid! \n Only accept 0-9 digits \n Accept the characters a-z \ n Accept the characters - _");
		document.getElementById('username_regis').focus();
		return false;
	}
	var username = document.getElementById('username_regis').value;
	if(username.length < 6)
	{
		alert("Username must be at least 6 characters!");
		document.getElementById('username_regis').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('password_regis').value))
	{
		alert("You did not enter the password!");
		document.getElementById('password_regis').focus();
		return false;
	}
	var password = document.getElementById('password_regis').value;
	if(password.length < 6)
	{
		alert("Password must be at least 6 characters!");
		document.getElementById('password_regis').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('email_regis').value))
	{
		alert("You did not enter email!");
		document.getElementById('email_regis').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('email_regis').value))
	{
		alert("You have entered not valid email!");
		document.getElementById('email_regis').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('fullname_regis').value))
	{
		alert("You did not enter full name!");
		document.getElementById('fullname_regis').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('address_regis').value))
	{
		alert("You did not enter address!");
		document.getElementById('address_regis').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('phone_regis').value))
	 {
		alert("You dit not enter phone number!");
		document.getElementById('phone_regis').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_regis').value))
	 {
		alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
		document.getElementById('phone_regis').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_regis').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_regis').value))
		 {
			alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
			document.getElementById('mobile_regis').focus();


			return false;
		 }
	 }
	
	if(CheckBlank(document.getElementById('captcha_regis').value))
	{
		alert("You not input verification code!");
		document.getElementById('captcha_regis').focus();
		return false;
	}
	document.frmRegister.submit();
}
function CheckInput_Contact()
{
	if(CheckBlank(document.getElementById('name_contact').value))
	{
		jAlert("You did not enter full name!","Input Required",function(r){
			if(r == true){
				document.getElementById('name_contact').focus();
				return false;
			}
		});
	}
	else
	{
		if(CheckBlank(document.getElementById('email_contact').value))
		{
			jAlert("You did not enter email!","Input Required",function(r){
				if(r==true){
					document.getElementById('email_contact').focus();
					return false;
				}
			});
		}
		else
		{
			if(!CheckEmail(document.getElementById('email_contact').value))
			{
				jAlert("Email you entered is not valid!","Wrong input",function(r){
					if(r==true){
						document.getElementById('email_contact').focus();
						return false;
					}
				});
			}
			else
			{
				if(CheckBlank(document.getElementById('address_contact').value))
				{
					jAlert("You did not enter address!","Input Required",function(r){
						if(r==true){
							document.getElementById('address_contact').focus();
							return false;
						}
					});
				}
				else
				{
					if(CheckBlank(document.getElementById('phone_contact').value))
					{
						jAlert("You did not enter phone number!","Input Required",function(r){
							if(r==true){
								document.getElementById('phone_contact').focus();
								return false;
							}
						});
					}
					else
					{
						if(CheckBlank(document.getElementById('title_contact').value))
						{
							jAlert("You did not enter the title!","Input Required",function(r){
								if(r==true){
									document.getElementById('title_contact').focus();
									return false;
								}
							});
						}
						else
						{
							if(CheckBlank(document.getElementById('content_contact').value))
							{
								jAlert("You still not enter the content!","Input Required",function(r){
									if(r==true){
										document.getElementById('content_contact').focus();
										return false;
									}
								});
							}
							else
							{
								if(CheckBlank(document.getElementById('captcha_contact').value))
								 {
									jAlert("You not input verification code!","Input Required",function(r){
										if(r==true){
											document.getElementById('captcha_contact').focus();
											return false;
										}
									});
								 }
								 else
								 {
									 if( document.getElementById('captcha_contact').value != document.getElementById('captcha').value){
										 jAlert("Verification code you entered not valid!","Wrong input",function(r){
											 if(r==true){
												document.getElementById('captcha_contact').focus();
												return false;
											 }
										});
										 
									 }
									 else
									 {
										 document.frmContact.submit();
									 }
								 }
							}
						}
					}
				}
			}
		}
	}
}

function CheckInput_Login()
{
	jQuery.noConflict();
	if(CheckBlank(jQuery('#UsernameLoginModule').val()))
	{
		jAlert("You did not enter username!","Notice",function(r){
			if(r==true){
				jQuery('#UsernameLoginModule').focus();
			}
		});
		return false;
	}
	if(!CheckCharacter(jQuery('#UsernameLoginModule').val()))
	{
		jAlert("The username you entered is not valid! \n Only accept 0-9 digits \n Accept the characters a-z \ n Accept the characters - _","Notice",function(r){
			if(r==true){
				jQuery('#UsernameLoginModule').focus();
			}
		});
		return false;
	}
	
	if(CheckBlank(jQuery('#PasswordLoginModule').val()))
	{
		jAlert("You did not enter the password!","Notice",function(r){
			if(r==true){
				jQuery('#PasswordLoginModule').focus();
			}
		});
		return false;
	}
	jQuery('#frmLogin').submit();
	
}

function CheckInput_Login_Page()
{
	jQuery.noConflict();
	
	if(CheckBlank(jQuery('#UsernameLogin').val()))
	{
		jAlert("You did not enter username!","Notice",function(r){
			if(r==true){	
				jQuery('#UsernameLogin').focus();
			}
		});
		return false;
	}
	
	if(!CheckCharacter(jQuery('#UsernameLogin').val()))
	{
		jAlert("The username you entered is not valid! \n Only accept 0-9 digits \n Accept the characters a-z \ n Accept the characters - _","Notice",function(r){
			if(r==true){
				jQuery('#UsernameLogin').focus();
			}
		});
		return false;
	}
	
	if(CheckBlank(jQuery('#PasswordLogin').val()))
	{
		jAlert("You did not enter the password!","Notice",function(r){
			if(r==true){
				jQuery('#PasswordLogin').focus();
			}
		});
		return false;
	}
	jQuery('#frmLoginPage').submit();
	
}

function CheckInput_Forgot()
{
	if(CheckBlank(document.getElementById('username_forgot').value))
	{
		jAlert("You did not enter username!","Notice",function(r){
			if(r==true){
				document.getElementById('username_forgot').focus();
			}
		});
		return false;
	}
	if(!CheckCharacter(document.getElementById('username_forgot').value))
	{
		jAlert("The username you entered is not valid! \n Only accept 0-9 digits \n Accept the characters a-z \ n Accept the characters - _","Notice",function(r){
			if(r==true){
				document.getElementById('username_forgot').focus();
			}
		});
		return false;
	}
	var username = document.getElementById('username_forgot').value;
	if(username.length < 6)
	{
		jAlert("Username must be at least 6 characters!","Notice",function(r){
			if(r == true){
				document.getElementById('username_forgot').focus();
			}
		});
		return false;
	}
	
	if(CheckBlank(document.getElementById('email_forgot').value))
	{
		jAlert("You did not enter email!","Notice",function(r){
			if(r == true){
				document.getElementById('email_forgot').focus();
			}
		});
		return false;
	}
	if(!CheckEmail(document.getElementById('email_forgot').value))
	{
		jAlert("Email you entered is not valid!","Notice",function(r){
			if(r== true){
				document.getElementById('email_forgot').focus();
			}
		});
		return false;
	}
	
	if(CheckBlank(document.getElementById('captcha_forgot').value))
	{
		jAlert("You not input verification code!","Notice",function(r){
			if(r==true){
				document.getElementById('captcha_forgot').focus();
			}
		});
		return false;
	}
	document.frmForgotPassword.submit();
}

function CheckInput_SearchPro(baseUrl)
{
	if(!CheckBlank(document.getElementById('cost_search1').value) || !CheckBlank(document.getElementById('cost_search2').value))
	{
		if(CheckBlank(document.getElementById('cost_search1').value))
		{
			jAlert("You did not enter a starting price of the product!","Notice",function(r){
				document.getElementById('cost_search1').focus();
			});
			return false;
		}
		if(!IsNumber(document.getElementById('cost_search1').value))
	   	{
		  jAlert("Start price you entered is not valid! \n You just enter the number from 0-9.","Notice",function(r){
		  	document.getElementById('cost_search1').focus();
		  });
		  return false;
	   	}
	   	if(document.getElementById('cost_search1').value == "0")
	   	{
		  jAlert("Price is not equal to 0!","Notice",function(r){
		  	document.getElementById('cost_search1').focus();
		  });
		  return false;
	   	}
		
		if(CheckBlank(document.getElementById('cost_search2').value))
		{
			jAlert("You did not enter a ending price of the product!","Notice",function(r){
				document.getElementById('cost_search2').focus();
			});
			return false;
		}
		if(!IsNumber(document.getElementById('cost_search2').value))
	   	{
		  jAlert("End price you entered is not valid! \n You just enter the number from 0-9.","Notice",function(r){
		  	document.getElementById('cost_search2').focus();
		  });
		  return false;
	   	}
	   	if(document.getElementById('cost_search2').value == "0")
	   	{
		  jAlert("Price is not equal to 0!","Notice",function(r){
		  	document.getElementById('cost_search2').focus();
		  });
		  return false;
	   	}
		
		var cost1 = document.getElementById('cost_search1').value*1;
		var cost2 = document.getElementById('cost_search2').value*1;
		if(cost1 > cost2)
		{
			jAlert("End price must be greater than or equal start price! \n If you want to find exact prices, please enter your starting price equal to the ending price.","Notice",function(r){
				document.getElementById('cost_search2').focus();
			});
		  	return false;
		}
	}
	
	if((document.getElementById('beginday_search1').value != 0 && document.getElementById('beginmonth_search1').value != 0 && document.getElementById('beginyear_search1').value != 0) || (document.getElementById('beginday_search2').value != 0 && document.getElementById('beginmonth_search2').value != 0 && document.getElementById('beginyear_search2').value != 0))
	{
		if(document.getElementById('beginday_search1').value == 0 || document.getElementById('beginmonth_search1').value == 0 || document.getElementById('beginyear_search1').value == 0)
		{
			jAlert("You did not select start date!","Notice",function(r){
			});
			return false;
		}
		
		if(document.getElementById('beginday_search2').value == 0 || document.getElementById('beginmonth_search2').value == 0 || document.getElementById('beginyear_search2').value == 0)
		{
			jAlert("You did not select end date!","Notice",function(r){
			});
			return false;
		}
		
	   	if(CheckDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value) || CheckDate(document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			jAlert("Post date is invalid! \ N Date Posted must less than or equal to the current date.","Notice",function(r){
			});
			return false;
	   	}
		
	   	if(!CompareDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value,document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			jAlert("End date must be greater than or equal start date! \n If you want to find exact date post, please enter your starting date equal to the ending date.","Notice",function(r){});
			return false;
	   	}
	}
	
	if((CheckBlank(document.getElementById('name_search').value) && CheckBlank(document.getElementById('cost_search1').value) && document.getElementById('saleoff_search').checked == false && document.getElementById('province_search').value == "0" && document.getElementById('category_search').value == "0") && (document.getElementById('beginday_search1').value == "0" || document.getElementById('beginmonth_search1').value == "0" || document.getElementById('beginyear_search1').value == "0"))
	{
		jAlert("Please select at least one search option!","Notice",function(r){});
		return false;
	}
	ActionSearch(baseUrl, 1);
}

function CheckInput_SearchAds(baseUrl)
{
	if(!CheckBlank(document.getElementById('view_search1').value) || !CheckBlank(document.getElementById('view_search2').value))
	{
		if(CheckBlank(document.getElementById('view_search1').value))
		{
			jAlert("You did not enter a views start!","Notice",function(r){
				document.getElementById('view_search1').focus();
			});
			return false;
		}
		if(!IsNumber(document.getElementById('view_search1').value))
	   	{
		  jAlert("Views start you entered is not valid! \n You just enter the number from 0-9.","Notice",function(r){
		      document.getElementById('view_search1').focus();
		  });
		  return false;
	   	}
		
		if(CheckBlank(document.getElementById('view_search2').value))
		{
			jAlert("You did not enter a views end!","Notice",function(r){
				document.getElementById('view_search2').focus();
			});
			return false;
		}
		if(!IsNumber(document.getElementById('view_search2').value))
	   	{
		  jAlert("Views end you entered is not valid! \n You just enter the number from 0-9.","Notice",function(r){
		  	document.getElementById('view_search2').focus();
		  });
		  return false;
	   	}
		
		var view1 = document.getElementById('view_search1').value*1;
		var view2 = document.getElementById('view_search2').value*1;
		if(view1 > view2)
		{
			jAlert("Views end must be greater than or equal views start! \n If you want to find exact views, please enter your starting views equal to the ending views.","Notice",function(r){
				document.getElementById('view_search2').focus();
			});
		  	return false;
		}
	}
	
	if((document.getElementById('beginday_search1').value != 0 && document.getElementById('beginmonth_search1').value != 0 && document.getElementById('beginyear_search1').value != 0) || (document.getElementById('beginday_search2').value != 0 && document.getElementById('beginmonth_search2').value != 0 && document.getElementById('beginyear_search2').value != 0))
	{
		if(document.getElementById('beginday_search1').value == 0 || document.getElementById('beginmonth_search1').value == 0 || document.getElementById('beginyear_search1').value == 0)
		{
			jAlert("You did not select start date!","Notice",function(r){});
			return false;
		}
		
		if(document.getElementById('beginday_search2').value == 0 || document.getElementById('beginmonth_search2').value == 0 || document.getElementById('beginyear_search2').value == 0)
		{
			jAlert("You did not select end date!","Notice",function(r){});
			return false;
		}
		
	   	if(CheckDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value) || CheckDate(document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			jAlert("Post date is invalid! \ N Date Posted must less than or equal to the current date.","Notice",function(r){});
			return false;
	   	}
		
	   	if(!CompareDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value,document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			jAlert("End date must be greater than or equal start date! \n If you want to find exact posted date, please enter your starting date equal to the ending date.","Notice",function(r){});
			return false;
	   	}
	}
	
	if((CheckBlank(document.getElementById('title_search').value) && CheckBlank(document.getElementById('view_search1').value) && document.getElementById('province_search').value == "0" && document.getElementById('category_search').value == "0") && (document.getElementById('beginday_search1').value == "0" || document.getElementById('beginmonth_search1').value == "0" || document.getElementById('beginyear_search1').value == "0"))
	{
		jAlert("Please select at least one search option!","Notice",function(r){});
		return false;
	}
	ActionSearch(baseUrl, 2);
}

function CheckInput_SearchJob(baseUrl)
{
	if(!CheckBlank(document.getElementById('salary_search').value))
	{
		if(!IsNumber(document.getElementById('salary_search').value))
		{
		  alert("Salary you entered is not valid! \n You just enter the number from 0-9.");
		  document.getElementById('salary_search').focus();
		  return false;
		}
		if(document.getElementById('salary_search').value == "0")
		{
		  alert("Salary is not equal to 0!");
		  document.getElementById('salary_search').focus();
		  return false;
		}

	}
	
	if((document.getElementById('beginday_search1').value != 0 && document.getElementById('beginmonth_search1').value != 0 && document.getElementById('beginyear_search1').value != 0) || (document.getElementById('beginday_search2').value != 0 && document.getElementById('beginmonth_search2').value != 0 && document.getElementById('beginyear_search2').value != 0))
	{
		if(document.getElementById('beginday_search1').value == 0 || document.getElementById('beginmonth_search1').value == 0 || document.getElementById('beginyear_search1').value == 0)
		{
			alert("You did not select start date!");
			return false;
		}
		
		if(document.getElementById('beginday_search2').value == 0 || document.getElementById('beginmonth_search2').value == 0 || document.getElementById('beginyear_search2').value == 0)
		{
			alert("You did not select end date!");
			return false;
		}
		
	   	if(CheckDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value) || CheckDate(document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Post date is invalid! \ N Date Posted must less than or equal to the current date.");
			return false;
	   	}
		
	   	if(!CompareDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value,document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("End date must be greater than or equal start date! \n If you want to find exact posted date, please enter your starting date equal to the ending date.");
			return false;
	   	}
	}
	
	if((CheckBlank(document.getElementById('title_search').value) && CheckBlank(document.getElementById('salary_search').value) && document.getElementById('province_search').value == "0" && document.getElementById('field_search').value == "0") && (document.getElementById('beginday_search1').value == "0" || document.getElementById('beginmonth_search1').value == "0" || document.getElementById('beginyear_search1').value == "0"))
	{
		alert("Please select at least one search option!");
		return false;
	}
	ActionSearch(baseUrl, 3);
}

function CheckInput_SearchEmploy(baseUrl)
{
	if(!CheckBlank(document.getElementById('salary_search').value))
	{
		if(!IsNumber(document.getElementById('salary_search').value))
		{
		  alert("Salary you entered is not valid! \n You just enter the number from 0-9.");
		  document.getElementById('salary_search').focus();
		  return false;
		}
		if(document.getElementById('salary_search').value == "0")
		{
		  alert("Salary is not equal to 0!");
		  document.getElementById('salary_search').focus();
		  return false;
		}
	}
	
	if((document.getElementById('beginday_search1').value != 0 && document.getElementById('beginmonth_search1').value != 0 && document.getElementById('beginyear_search1').value != 0) || (document.getElementById('beginday_search2').value != 0 && document.getElementById('beginmonth_search2').value != 0 && document.getElementById('beginyear_search2').value != 0))
	{
		if(document.getElementById('beginday_search1').value == 0 || document.getElementById('beginmonth_search1').value == 0 || document.getElementById('beginyear_search1').value == 0)
		{
			alert("You did not select start date!");
			return false;
		}
		
		if(document.getElementById('beginday_search2').value == 0 || document.getElementById('beginmonth_search2').value == 0 || document.getElementById('beginyear_search2').value == 0)
		{
			alert("You did not select end date!");
			return false;
		}
		
	   	if(CheckDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value) || CheckDate(document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Post date is invalid! \ N Date Posted must less than or equal to the current date.");
			return false;
	   	}
		
	   	if(!CompareDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value,document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("End date must be greater than or equal start date! \n If you want to find exact posted date, please enter your starting date equal to the ending date.");
			return false;
	   	}
	}
	
	if((CheckBlank(document.getElementById('title_search').value) && CheckBlank(document.getElementById('salary_search').value) && document.getElementById('province_search').value == "0" && document.getElementById('field_search').value == "0") && (document.getElementById('beginday_search1').value == "0" || document.getElementById('beginmonth_search1').value == "0" || document.getElementById('beginyear_search1').value == "0"))
	{
		alert("Please select at least one search option!");
		return false;
	}
	ActionSearch(baseUrl, 4);
}

function CheckInput_SearchShop(baseUrl)
{
	if((document.getElementById('beginday_search1').value != 0 && document.getElementById('beginmonth_search1').value != 0 && document.getElementById('beginyear_search1').value != 0) || (document.getElementById('beginday_search2').value != 0 && document.getElementById('beginmonth_search2').value != 0 && document.getElementById('beginyear_search2').value != 0))
	{
		if(document.getElementById('beginday_search1').value == 0 || document.getElementById('beginmonth_search1').value == 0 || document.getElementById('beginyear_search1').value == 0)
		{
			jAlert("You did not select start date!","Notice",function(r){});
			return false;
		}
		
		if(document.getElementById('beginday_search2').value == 0 || document.getElementById('beginmonth_search2').value == 0 || document.getElementById('beginyear_search2').value == 0)
		{
			jAlert("You did not select end date!","Notice",function(r){});
			return false;
		}
		
	   	if(CheckDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value) || CheckDate(document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			jAlert("Registration date is invalid! \n Date of registration must be less than or equal to the current date.","Notice",function(r){});
			return false;
	   	}
		
	   	if(!CompareDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value,document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			jAlert("End date must be greater than or equal start date! \n If you want to find exact register date, please enter your starting date equal to the ending date.","Notice",function(r){});
			return false;
	   	}
	}
	
	if((CheckBlank(document.getElementById('name_search').value) && CheckBlank(document.getElementById('address_search').value) && document.getElementById('saleoff_search').checked == false && document.getElementById('province_search').value == "0" && document.getElementById('category_search').value == "0") && (document.getElementById('beginday_search1').value == "0" || document.getElementById('beginmonth_search1').value == "0" || document.getElementById('beginyear_search1').value == "0"))
	{
		jAlert("Please select at least one search option!","Notice",function(r){});
		return false;
	}
	ActionSearch(baseUrl, 5);
}
function CheckInput_SearchHoidap(baseUrl){
	if((CheckBlank(document.getElementById('name_search').value) && document.getElementById('category_search').value == "0"))
	{
		jAlert("Please select at least one search option!","Notice",function(r){});
		return false;
	}
	ActionSearch(baseUrl, 6);
}

function CheckInput_EditAccount($baseurl)
{
    if (CheckBlank(document.getElementById('email_account').value))
    {
        jAlert("You did not enter email!", "Input Required", function (r) {
            if (r == true) {
                document.getElementById('email_account').focus();
                return false;
            }
        });
    } else {
        if (!CheckEmail(document.getElementById('email_account').value))
        {
            jAlert("You have entered not valid email!", "Wrong input", function (r) {
                if (r == true) {
                    document.getElementById('email_account').focus();
                    return false;
                }
            });
        } else {
            if (CheckBlank(document.getElementById('reemail_account').value))
            {
                jAlert("You did not enter confirm email!", "Input Required", function (r) {
                    if (r == true) {
                        document.getElementById('reemail_account').focus();
                        return false;
                    }
                });
            } else {
                if (document.getElementById('reemail_account').value != document.getElementById('email_account').value)
                {
                    jAlert("You have entered confirm email not valid!", "Wrong input", function (r) {
                        if (r == true) {
                            document.getElementById('reemail_account').focus();
                            return false;
                        }
                    });
                } else {
                    if (CheckBlank(document.getElementById('fullname_account').value))
                    {
                        jAlert("You did not enter full name!", "Input Required", function (r) {
                            if (r == true) {
                                document.getElementById('fullname_account').focus();
                                return false;
                            }
                        });
                    } else {
                        if (CheckBlank(document.getElementById('address_account').value))
                        {
                            jAlert("You did not enter address!", "Input Required", function (r) {
                                if (r == true) {
                                    document.getElementById('address_account').focus();
                                    return false;
                                }
                            });
                        } else {
                            if (CheckBlank(document.getElementById('phone_account').value))
                            {
                                jAlert("You dit not enter phone number!", "Input Required", function (r) {
                                    if (r == true) {
                                        document.getElementById('phone_account').focus();
                                        return false;
                                    }
                                });
                            } else {
                                if (!CheckPhone(document.getElementById('phone_account').value))
                                {
                                    jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888", "Wrong input", function (r) {
                                        if (r == true) {
                                            document.getElementById('phone_account').focus();
                                            return false;
                                        }
                                    });
                                } else {
                                    if (!CheckBlank(document.getElementById('mobile_account').value))
                                    {
                                        if (!CheckPhone(document.getElementById('mobile_account').value))
                                        {
                                            jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888", "Wrong input", function (r) {
                                                if (r == true) {
                                                    document.getElementById('mobile_account').focus();
                                                    return false;
                                                }
                                            });
                                        } else {
                                            if (CheckBlank(document.getElementById('captcha_account').value))
                                            {
                                                jAlert("You not input verification code!", "Input Required", function (r) {
                                                    if (r == true) {
                                                        document.getElementById('captcha_account').focus();
                                                        return false;
                                                    }
                                                });
                                            } else {
                                                if (document.getElementById('captcha_account').value != document.getElementById('captcha_hidden').value) {
                                                    jAlert("Verification code you entered not valid!", "Wrong input", function (r) {
                                                        document.getElementById('captcha_account').focus();
                                                    });
                                                    return false;
                                                } else
                                                {
                                                    chk_EditAccount($baseurl);
                                                }
                                            }
                                        }
                                    } else {
                                        if (CheckBlank(document.getElementById('captcha_account').value))
                                        {
                                            jAlert("You not input verification code!", "Input Required", function (r) {
                                                if (r == true) {
                                                    document.getElementById('captcha_account').focus();
                                                    return false;
                                                }
                                            });
                                        } else
                                        {
                                            if (document.getElementById('captcha_account').value != document.getElementById('captcha_hidden').value) {
                                                jAlert("Verification code you entered not valid!", "Wrong input", function (r) {
                                                    document.getElementById('captcha_account').focus();
                                                });
                                                return false;
                                            } else
                                            {
                                                chk_EditAccount($baseurl);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function chk_EditAccount($baseurl)
{
	jQuery.ajax({
			type: "POST",
		    url: $baseurl + "account/chk_account",
			data: "useremail="+document.getElementById('email_account').value,
			success: function(data){
				if(data ==0){
					jAlert("This email address is used in the system, please enter the other!","Notice",function(r){
						jQuery('#email_account').focus();
					});
					return false;
				}
				else
				{
					document.frmEditAccount.submit();
				}
			},
		error: function(){}
	 });
}
function upraovat($baseurl,$raovatid,$divid)
{
	jQuery.ajax({
		type: "POST",
		url: $baseurl + "raovat/upraovat",
		data: "raovatid=" + $raovatid,
		success: function(data){
			if(data == 0){
				jAlert("Amount money in your account not enought for up!","Notice",function(r){
				});
				return false;
			}
			else
			{
				$udates = data.split(',');
				jQuery('#DivStartdate_'+$divid).val($udates[0]);
				jQuery('#DivEnddate_'+$divid).val($udates[1]);
				jAlert('Your Classifieds have been up successfully!','Notice');
			}
		},
		error: function(){alert('aaaaa');}
	});
}
function upproduct($baseurl,$productid,$divid)
{
	jQuery.ajax({
		type: "POST",
		url: $baseurl + "product/upproduct",
		data: "productid=" + $productid,
		success: function(data){
			if(data == 0){
				jAlert("Amount money in your account not enought for up!","Notice",function(r){
				});
				return false;
			}
			else
			{
				$udates = data.split(',');
				jQuery('#DivStartdate_'+$divid).val($udates[0]);
				jQuery('#DivEnddate_'+$divid).val($udates[1]);
				jAlert('Your product have been up successfully!','Notice');
			}
		},
		error: function(){alert('aaaaa');}
	});
}
function CheckInput_ChangePassword($baseurl)
{
	if(CheckBlank(document.getElementById('oldpassword_changepass').value))
	{
		jAlert("You did  not enter old password!","Input Required",function(r){
			if(r == true){
				document.getElementById('oldpassword_changepass').focus();
				return false;
			}
		});
		
	}
	else
	{
		jQuery.ajax({
			type: "POST",
			url: $baseurl + "account/ajax_checkpass",
			data: "oldpass=" + document.getElementById('oldpassword_changepass').value,
			success: function(data){
				if(data == 0){
					jAlert("You have entered old password not right!","Wrong input",function(r){
						if(r == true){
							document.getElementById('oldpassword_changepass').focus();
							return false;
						}
					});
				}else{
					if(CheckBlank(document.getElementById('password_changepass').value))
					{
						jAlert("You did not enter new password!","Input Required",function(r){
							if(r == true){
								document.getElementById('password_changepass').focus();
								return false;
							}
						});
					}
					else
					{
						var password = document.getElementById('password_changepass').value;
						if(password.length < 6)
						{
							jAlert("New password must be at least 6 characters!","Wrong input",function(r){
								if(r == true){
									document.getElementById('password_changepass').focus();
									return false;
								}
							});
						}
						else
						{
							if(document.getElementById('password_changepass').value != document.getElementById('repassword_changepass').value)
							{
								jAlert("Confirm New password ot valid!","Wrong input",function(r){
									if(r == true){
										document.getElementById('repassword_changepass').focus();
										return false;
									}
								});
							}
							else
							{
								if(CheckBlank(document.getElementById('captcha_changepass').value))
								{
									jAlert("You not input verification code!","Input Required",function(r){
										if(r == true){
											document.getElementById('captcha_changepass').focus();
											return false;
										}
									});
								}
								else
								{
									if( document.getElementById('captcha_changepass').value != document.getElementById('captcha_hidden').value){
										 jAlert("Verification code you entered not valid!","Wrong input",function(r){
											document.getElementById('captcha_changepass').focus();
										});
										 return false;
									 }
									 else
									 {
										 document.frmChangePassword.submit();
									 }
								}
							}
						}
					}
				}
			},
			error: function(){ 
				jAlert("You have entered old password not right!","Wrong input",function(r){
					if(r == true){
						document.getElementById('oldpassword_changepass').focus();
						return false;
					}
				});
			}
		});
	}
}

function CheckInput_ContactAccount()
{
	if(CheckBlank(document.getElementById('title_contact').value))
	{
		alert("You did not enter the title!");
		document.getElementById('title_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('txtContent').value))
	{
		alert("You still not enter the content!");
		document.getElementById('txtContent').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('captcha_contact').value))
	{
		alert("You not input verification code!");
		document.getElementById('captcha_contact').focus();
		return false;
	}
	document.frmContactAccount.submit();
}

function CheckInput_EditPro()
{
	  if(jQuery('#saleoff_pro').is(':checked')){
		if(CheckBlank(document.getElementById('pro_saleoff_value').value)){
			jAlert("You did not enter a discount amount!","Input Required",function(r){
				document.getElementById('pro_saleoff_value').focus();															 
			});
			return false;
		}else{
			if(jQuery('#pro_saleoff_value').val()>100 && jQuery('#pro_type_saleoff').val()=='1' ){
				jAlert("Discount percentage must be less than 100%!","Wrong input",function(r){
					document.getElementById('pro_saleoff_value').focus();														 
				});
				return false;
			}
			
			if(!isInt(jQuery('#pro_saleoff_value').val())){
				jAlert("You must enter the discount amount is numeric!","Wrong input",function(r){
					document.getElementById('pro_saleoff_value').focus();
				});
				return false;
			}
						
			if(jQuery('#pro_saleoff_value').val()=='0' ){
				jAlert("You must enter the discount amount greater than 0!","Wrong input",function(r){
					document.getElementById('pro_saleoff_value').value='';
					document.getElementById('pro_saleoff_value').focus();
				});
				return false;
			}
		}
	}
	
	 if(CheckBlank(document.getElementById('name_pro').value))
	 {
		jAlert("You did not enter the product name!","Input Required",function(r){
			document.getElementById('name_pro').focus();
		});
		return false;
	 }
	 
	 if(document.getElementById('nonecost_pro').checked == false)
	 {
		 if(CheckBlank(document.getElementById('cost_pro').value))
		 {
			jAlert("You did not enter the price of product!","Input Required",function(r){
				document.getElementById('cost_pro').focus();
			});
			return false;
		 }
		 if(!IsNumber(document.getElementById('cost_pro').value))
		 {
			jAlert("Price you entered is not valid! \nYou just enter the number from 0-9.","Wrong input",function(r){
				document.getElementById('cost_pro').focus();
			});
			return false;
		 }
		 if(document.getElementById('cost_pro').value == "0")
		 {
			jAlert("Price is not equal to 0! \n You can select No pricing.","Wrong input",function(r){
				document.getElementById('cost_pro').focus();
			});
			return false;
		 }
	 }
	 if(CheckBlank(document.getElementById('hd_category_id').value))
	 {
		jAlert("You did not selected category or this is not the category for post product!","Input Required",function(r){
		});
		return false;
	 }
	 if(!CheckDate(document.getElementById('day_pro').value,document.getElementById('month_pro').value,document.getElementById('year_pro').value))
	 {
		 jAlert("Post time end invalid! \n Time end must be greater than current date.","Wrong input",function(r){
		 });
		 return false;
	 }
	 var product_detail = tinyMCE.get('txtContent').getContent();
	 
	 if(CheckBlank(product_detail))
	 {
		jAlert("You did not enter product details!","Input Required",function(r){
			document.getElementById('txtContent').focus();
		});
		return false;
	 }
	 var validExtensions = [".gif", ".png",".jpg"];
	 if(jQuery('#image_1_pro')[0].files[0]){
		filename = jQuery('#image_1_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_1_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_2_pro')[0].files[0]){
		filename = jQuery('#image_2_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_2_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_3_pro')[0].files[0]){
		filename = jQuery('#image_3_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_3_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_4_pro')[0].files[0]){
		filename = jQuery('#image_4_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_4_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_5_pro')[0].files[0]){
		filename = jQuery('#image_5_pro')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_5_pro')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 
	 if(CheckBlank(document.getElementById('fullname_pro').value))
	 {
		jAlert("You did not enter the poster product!","Input Required",function(r){
			document.getElementById('fullname_pro').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_pro').value))
	 {
		jAlert("You dit not enter contact address!","Input Required",function(r){
			document.getElementById('address_pro').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_pro').value))
	 {
		jAlert("You dit not enter phone number!","Input Required",function(r){
			document.getElementById('phone_pro').focus();
		});
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_pro').value))
	 {
		jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Wrong input",function(r){
			document.getElementById('phone_pro').focus();
		});
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_pro').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_pro').value))
		 {
			jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Wrong input",function(r){
				document.getElementById('mobile_pro').focus();
			});
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_pro').value))
	 {
		jAlert("You did not enter email!","Input Required",function(r){
			document.getElementById('email_pro').focus();
		});
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_pro').value))
	 {
		jAlert("Email you entered is not valid!","Wrong input",function(r){
			document.getElementById('email_pro').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_pro').value))
	 {
		jAlert("You not input verification code!","Input Required",function(r){
			document.getElementById('captcha_pro').focus();
		});
		return false;
	 }else{
		 if( document.getElementById('captcha_pro').value != document.getElementById('captcha').value){
			 jAlert("Verification code you entered not valid!","Wrong input",function(r){
				document.getElementById('captcha_pro').focus();
			});
			 return false;
		 }
	 }
	 jQuery('#isEditProduct').val(1);
	 document.frmEditPro.submit();
}

/* ltngan */ function checkActiveCode(code,baseUrl){
		jQuery.post(baseUrl+"ajax", { code: code },
                function(data) {
					if(data=='0'){
						alert('This activation code does not exist!');
						document.getElementById('active_code').value='';
						return false;
					}
					if(data=='1'){
						alert('This activation code is valid!');
						return false;
					}
					if(data=='2'){
						alert('This activation code was used. Please check again!');
						jQuery('.member_type').attr('checked',false);
						jQuery('#type_value').val('');
						document.getElementById('active_code').value='';
						return false;
					}
									
		});
		
}

function CheckInput_EditAds($baseurl,$adsvip)
{
	 if(CheckBlank(document.getElementById('title_ads').value))
	 {
		jAlert("You did not enter the title!","Input Required",function(r){
			document.getElementById('title_ads').focus();
		});
		return false;
	 }
	 
	 //if(CheckBlank(document.getElementById('descr_ads').value))
//	 {
//		jAlert("Bạn chưa nhập mô tả!","Input Required",function(r){
//			document.getElementById('descr_ads').focus();
//		});
//		return false;
//	 }
	 var validExtensions = [".gif", ".png",".jpg"];
	 if(jQuery('#image_1_ads')[0].files[0]){
		filename = jQuery('#image_1_ads')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_1_ads')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_2_ads')[0].files[0]){
		filename = jQuery('#image_2_ads')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_2_ads')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_3_ads')[0].files[0]){
		filename = jQuery('#image_3_ads')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_3_ads')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_4_ads')[0].files[0]){
		filename = jQuery('#image_4_ads')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_4_ads')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(jQuery('#image_5_ads')[0].files[0]){
		filename = jQuery('#image_5_ads')[0].files[0].name;
		var ext = filename.slice(filename.lastIndexOf(".")).toLowerCase();
		var allowSubmit = false;
		//loop through our array of extensions
        for (var i = 0; i < validExtensions.length; i++) 
        {
            //check to see if it's the proper extension
            if (validExtensions[i] == ext) 
            { 
                //it's the proper extension
                allowSubmit = true; 
            }
        }
		if (allowSubmit == false)
    	{
			jAlert('Only accepted image formats .gif, .png, .jpg','Notice');
			return false;
		}
		else
		{
			if(jQuery('#image_5_ads')[0].files[0].size >512*1024){
				jAlert('The maximum capacity for each file upload is 512 Kb','Notice');
				return false;
			}
		}
	 }
	 if(!CheckDate(document.getElementById('day_ads').value,document.getElementById('month_ads').value,document.getElementById('year_ads').value))
	 {
		 jAlert("Post time end invalid! \n Time end must be greater than current date.","Wrong input");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		jAlert("You did not enter detail of classified!","Input Required",function(r){
			document.getElementById('txtContent').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('fullname_ads').value))
	 {
		jAlert("You did not enter the poster classified!","Input Required",function(r){
			document.getElementById('fullname_ads').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_ads').value))
	 {
		jAlert("You dit not enter contact address!","Input Required",function(r){
			document.getElementById('address_ads').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_ads').value))
	 {
		jAlert("You dit not enter phone number!","Input Required",function(r){
			document.getElementById('address_ads').focus();
		});
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_ads').value))
	 {
		jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Wrong input",function(r){
		document.getElementById('phone_ads').focus();
		});
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_ads').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_ads').value))
		 {
			jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Wrong input",function(r){
			document.getElementById('mobile_ads').focus();
			});
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_ads').value))
	 {
		jAlert("You did not enter email!","Input Required",function(r){
		document.getElementById('email_ads').focus();
		});
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_ads').value))
	 {
		jAlert("Email you entered is not valid!","Wrong input",function(r){
		document.getElementById('email_ads').focus();
		});
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_ads').value))
	 {
		jAlert("You not input verification code!","Input Required",function(r){
		document.getElementById('captcha_ads').focus();
		});
		return false;
	 }else{
		 if(document.getElementById('captcha_ads').value !=document.getElementById('captcha').value){
			jAlert("Verification code you entered not valid!","Wrong input",function(r){
				document.getElementById('captcha_ads').focus();
			});
			return false;
		 }
	 }
	 chk_EditAds($baseurl,$adsvip);
}
function chk_EditAds($baseurl,$adsvip){
	$raovattype = jQuery('#rv_type_hidden').val();
	if($raovattype >0 && $raovattype != $adsvip)
	{
		jQuery.ajax({
			type: "POST",
			url: $baseurl + "raovat/postraovat",
			data: "raovattype=" + $raovattype,
			success: function(data){
				if(data == 0){
					jAlert("Amount of money in your account not enought for post this type of classified!","Notice",function(r){
					});
					return false;
				}
				else
				{
					jQuery('#isEditAds').val(1);
					document.frmEditAds.submit();
				}
			},
			error: function(){alert('aaaaa');}
		});
	}
	else
	{
		jQuery('#isEditAds').val(1);
	 	document.frmEditAds.submit();
	}
}
function CheckInput_EditJob()
{
	 if(CheckBlank(document.getElementById('title_job').value))
	 {
		alert("You did not enter the title!");
		document.getElementById('title_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('position_job').value))
	 {
		alert("You did not enter the job position!");
		document.getElementById('position_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('level_job').value))
	 {
		alert("You did not enter a level!");
		document.getElementById('level_job').focus();
		return false;
	 }
	 
	 if(document.getElementById('age1_job').value > document.getElementById('age2_job').value)
	 {
		 alert("You selected an invalid age! \n Example: Age 18 to 25.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('require_job').value))
	 {
		alert("You did not enter the job requirements!");
		document.getElementById('require_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('salary_job').value))
	 {
		alert("You did not enter a starting salary!");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('salary_job').value))
	 {
		alert("Starting salary you entered is not valid! \n You just enter the number from 0-9.");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 if(document.getElementById('salary_job').value == "0")
	 {
		alert("Starting salary is not equal to 0!");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('try_job').value))
	 {
		alert("You did not enter a probation period!");
		document.getElementById('try_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('try_job').value))
	 {
		alert("Probationary period you entered is not valid! \n You just enter the number from 0-9.");
		document.getElementById('try_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('interest_job').value))
	 {
		alert("You did not enter the benefits!");
		document.getElementById('interest_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('quantity_job').value))
	 {
		alert("You did not enter a number of recruitment!");
		document.getElementById('quantity_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('quantity_job').value))
	 {
		alert("The number of employers you entered is not valid! \n You just enter the number from 0-9.");
		document.getElementById('quantity_job').focus();
		return false;
	 }
	 if(document.getElementById('quantity_job').value == "0")
	 {
		alert("The number of employers are not equal to 0!");
		document.getElementById('quantity_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('record_job').value))
	 {
		alert("You did not enter the job application!");
		document.getElementById('record_job').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('day_job').value,document.getElementById('month_job').value,document.getElementById('year_job').value))
	 {
		 alert("Filing time is invalid! \n Filing period must be greater than the current date.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("You did not enter the details Jobs!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('name_job').value))
	 {
		alert("You did not enter employer's name!");
		document.getElementById('name_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_job').value))
	 {
		alert("You did not enter employer's address!");
		document.getElementById('address_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_job').value))
	 {
		alert("You dit not enter phone number nhà tuyển dụng!");
		document.getElementById('phone_job').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_job').value))
	 {
		alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
		document.getElementById('phone_job').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_job').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_job').value))
		 {
			alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
			document.getElementById('mobile_job').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_job').value))
	 {
		alert("You did not enter email!");
		document.getElementById('email_job').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_job').value))
	 {
		alert("Email you entered is not valid!");
		document.getElementById('email_job').focus();
		return false;
	 }
	 
	 if(!CheckWebsite(document.getElementById('website_job').value))
	 {
		alert("You entered website address not valid!\n Only input characters 0-9, a-z, / . : _ -");
		document.getElementById('website_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('namecontact_job').value))
	 {
		alert("You did not enter a name of the representative!");
		document.getElementById('namecontact_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('addresscontact_job').value))
	 {
		alert("You dit not enter contact address!");
		document.getElementById('addresscontact_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phonecontact_job').value))
	 {
		alert("You dit not enter contact phone number!");
		document.getElementById('phonecontact_job').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phonecontact_job').value))
	 {
		alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
		document.getElementById('phonecontact_job').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobilecontact_job').value))
	 {
		 if(!CheckPhone(document.getElementById('mobilecontact_job').value))
		 {
			alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
			document.getElementById('mobilecontact_job').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('emailcontact_job').value))
	 {
		alert("You did not enter email!");
		document.getElementById('emailcontact_job').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('emailcontact_job').value))
	 {
		alert("Email you entered is not valid!");
		document.getElementById('emailcontact_job').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('endday_job').value,document.getElementById('endmonth_job').value,document.getElementById('endyear_job').value))
	 {
		 alert("Post time end invalid! \n Time end must be greater than current date.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_job').value))
	 {
		alert("You not input verification code!");
		document.getElementById('captcha_job').focus();
		return false;
	 }
	 document.frmEditJob.submit();
}

function CheckInput_EditEmploy()
{
	 if(CheckBlank(document.getElementById('title_employ').value))
	 {
		alert("You did not enter the title!");
		document.getElementById('title_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('position_employ').value))
	 {
		alert("You did not enter the working position!");
		document.getElementById('position_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('salary_employ').value))
	 {
		alert("You did not enter the desired salary!");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('salary_employ').value))
	 {
		alert("Expected salary you entered is not valid! \n You just enter the number from 0-9.");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 if(document.getElementById('salary_employ').value == "0")
	 {
		alert("Expected salary is not equal to 0!");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("You did not enter a detail content of find job!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('name_employ').value))
	 {
		alert("You did not enter full name!");
		document.getElementById('name_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('level_employ').value))
	 {
		alert("You did not enter a level!");
		document.getElementById('level_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_employ').value))
	 {
		alert("You did not enter address!");
		document.getElementById('address_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_employ').value))
	 {
		alert("You dit not enter phone number!");
		document.getElementById('phone_employ').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_employ').value))
	 {
		alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
		document.getElementById('phone_employ').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_employ').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_employ').value))
		 {
			alert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888");
			document.getElementById('mobile_employ').focus();

			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_employ').value))
	 {
		alert("You did not enter email!");
		document.getElementById('email_employ').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_employ').value))
	 {
		alert("Email you entered is not valid!");
		document.getElementById('email_employ').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('endday_employ').value,document.getElementById('endmonth_employ').value,document.getElementById('endyear_employ').value))
	 {
		 alert("Post time end invalid! \n Time end must be greater than current date.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_employ').value))
	 {
		alert("You not input verification code!");
		document.getElementById('captcha_employ').focus();
		return false;
	 }
	 document.frmEditEmploy.submit();
}
function CheckInput_EditShopIntro()
{
	if(CheckBlank(document.getElementById('captcha_shop').value))
	{
		jAlert("You not input verification code!",'Input Required',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	if(document.getElementById('captcha_shop').value != document.getElementById('current_captcha').value)
	{
		jAlert("You input verification code not right!",'Wrong input',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	jQuery('#isEditShopIntro').val(1);
	document.frmEditShopIntro.submit();
}
function CheckInput_addbanner()
{
	if(CheckBlank(document.getElementById('ub_name_0').value))
	{
		jAlert("You did not input name of banner!",'Input Required',function(r){
			jQuery('#ub_name_0').focus();														 
		});
		return false;
	}
	if(jQuery('#banner_image').css('display') =='table-row')
	{
		if(jQuery('#ub_picture')[0].files[0]){
			if(jQuery('#ub_picture')[0].files[0].size >512*1024){
				jAlert('The maximum upload capacity 512 Kb','Notice');
				return false;
			}
		}
		else{
			jAlert('You did not attach file!','Input Required');
			return false;
		}
	}
	if(jQuery('#banner_size').css('display') =='table-row')
	{
		
	}
	if(CheckBlank(document.getElementById('ub_order_0').value))
	{
		jAlert("You did not enter index number!",'Input Required',function(r){
			jQuery('#ub_order_0').focus();														 
		});
		return false;
	}
	if(document.getElementById('captcha_shop').value != document.getElementById('current_captcha').value)
	{
		jAlert("You input verification code not right!",'Wrong input',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	jQuery('#isAddBanner').val(1);
	document.addbanner.submit();
}
function changeChkValue(obj){
	if(jQuery(obj).is(':checked')){
		jQuery(obj).val(1);
	}else{
		jQuery(obj).val(0);
	}
}
function CheckInput_editbanner()
{
	if(CheckBlank(document.getElementById('ub_name_0').value))
	{
		jAlert("You did not input name of banner!",'Input Required',function(r){
			jQuery('#ub_name_0').focus();														 
		});
		return false;
	}
	if(jQuery('#banner_image').css('display') =='table-row')
	{
		if(jQuery('#ub_picture')[0].files[0]){
			if(jQuery('#ub_picture')[0].files[0].size >512*1024){
				jAlert('The maximum upload capacity 512 Kb','Notice');
				return false;
			}
		}
		else{
			if(jQuery('#filename').val() ==''){
				jAlert('You did not attach file!','Input Required');
				return false;
			}
		}
	}
	if(jQuery('#banner_size').css('display') =='table-row')
	{
		
	}
	if(CheckBlank(document.getElementById('ub_order_0').value))
	{
		jAlert("You did not enter index number!",'Input Required',function(r){
			jQuery('#ub_order_0').focus();														 
		});
		return false;
	}
	if(document.getElementById('captcha_shop').value != document.getElementById('current_captcha').value)
	{
		jAlert("You input verification code not right!",'Wrong input',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	jQuery('#isEditBanner').val(1);
	document.editbanner.submit();
}
function CheckInput_EditShopWarranty()
{
	if(CheckBlank(document.getElementById('captcha_shop').value))
	{
		jAlert("You not input verification code!",'Input Required',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	if(document.getElementById('captcha_shop').value != document.getElementById('current_captcha').value)
	{
		jAlert("You input verification code not right!",'Wrong input',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	jQuery('#isEditShopWarranty').val(1);
	document.frmEditShopWarranty.submit();
}
function CheckInput_EditShopRule(){
	if(CheckBlank(document.getElementById('captcha_shop').value))
	{
		jAlert("You not input verification code!",'Input Required',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	if(document.getElementById('captcha_shop').value != document.getElementById('current_captcha').value)
	{
		jAlert("You input verification code not right!",'Wrong input',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	jQuery('#isEditShopRule').val(1);
	document.frmEditShopRule.submit();
}
function vali_type($id,$valid_extensions)
{ 
 var id_value = document.getElementById($id).value;
 
 if(id_value != '')
 { 
  if($valid_extensions.test(id_value))
  { 
    return true;
  }
  else
  {
    return false;
  }
 } 
}
function CheckInput_EditShop($baseurl)
{
	if(jQuery('#logo_shop')[0].files[0]){
		var valid_extensions = /(.jpg|.jpeg|.gif)$/i;  
		if(!vali_type('logo_shop',valid_extensions)){
			jAlert('Only image format acceptable .JPG, .PNG, .GIF','Notice');
			return false;
		}
		if(jQuery('#logo_shop')[0].files[0].size >1024*1024){
			jAlert('Logo upload a maximum capacity 1M','Notice');
			return false;
		}
	}
	
	if(jQuery('#banner_shop')[0].files[0]){
		var valid_extensions = /(.jpg|.jpeg|.gif|.swf)$/i;  
		if(!vali_type('banner_shop',valid_extensions)){
			jAlert('Only image format acceptable .JPG, .PNG, .GIF, .SWF','Notice');
			return false;
		}
		if(jQuery('#banner_shop')[0].files[0].size >2048*1024){
			jAlert('Banner upload a maximum capacity 2M','Notice');
			return false;
		}
	}
	
	if(jQuery('#bgimg_shop')[0].files[0]){
		var valid_extensions = /(.jpg|.jpeg|.gif)$/i;  
		if(!vali_type('bgimg_shop',valid_extensions)){
			jAlert('Only image format acceptable .JPG, .PNG, .GIF','Notice');
			return false;
		}
		if(jQuery('#bgimg_shop')[0].files[0].size >1024*1024){
			jAlert('Background upload a maximum capacity 1M','Notice');
			return false;
		}
	}
	
	if(CheckBlank(document.getElementById('link_shop').value))
	{
		jAlert("You did not enter a link to the store!",'Input Required',function(r){
			jQuery('#link_shop').focus();
		});
		return false;
	}
	if(!CheckLink(document.getElementById('link_shop').value))
	{
		jAlert("Link to the store you entered is not valid! \n Only accept characters 0-9, a-z, _-","Entered not valid",function(r){
			jQuery('#link_shop').focus();
		});
		return false;
	}
	
	if(CheckBlank(document.getElementById('name_shop').value))
	{
		jAlert("You did not enter name of store!",'Input Required',function(r){
			jQuery('#name_shop').focus();														 
		});
		return false;
	}
	
	if(CheckBlank(document.getElementById('descr_shop').value))
	{
		jAlert("You did not enter description of store!",'Input Required',function(r){
			jQuery('#descr_shop').focus();														 
		});
		return false;
	}
	
	if(CheckBlank(document.getElementById('address_shop').value))
	{
		jAlert("You did not enter address of store!",'Input Required',function(r){
			jQuery('#address_shop').focus();														 
		});
		return false;
	}
	
	if(CheckBlank(document.getElementById('phone_shop').value))
	 {
		jAlert("You dit not enter phone number!",'Input Required',function(r){
			jQuery('#phone_shop').focus();														 
		});
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_shop').value))
	 {
		jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Entered not valid",function(r){
			jQuery('#phone_shop').focus();
		});
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_shop').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_shop').value))
		 {
			jAlert("Phone number you entered is not valid! \n only accept number from 0-9 and the characters . () \n For example: (08) .888888 or 090.8888888","Entered not valid",function(r){
				jQuery('#mobile_shop').focus();
		    });
			return false;
		 }
	 }
	 
	if(CheckBlank(document.getElementById('email_shop').value))
	{
		jAlert("You did not enter email!",'Input Required',function(r){
			jQuery('#email_shop').focus();														 
		});
		return false;
	}
	if(!CheckEmail(document.getElementById('email_shop').value))
	{
		jAlert("You have entered not valid email!","Entered not valid",function(r){
			jQuery('#email_shop').focus();
		});
		return false;
	}
	
	if(!CheckWebsite(document.getElementById('website_shop').value))
	{
		jAlert("You entered website address not valid!\n Only input characters 0-9, a-z, / . : _ -","Entered not valid",function(r){
			jQuery('#website_shop').focus();
		});
		return false;
	}
	
	if(CheckBlank(document.getElementById('captcha_shop').value))
	{
		jAlert("You not input verification code!",'Input Required',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	if(document.getElementById('captcha_shop').value != document.getElementById('current_captcha').value)
	{
		jAlert("You input verification code not right!",'Wrong input',function(r){
			jQuery('#captcha_shop').focus();														 
		});
		return false;
	}
	chk_EditShop($baseurl);
}
function chk_EditShop($baseurl)
{
	jQuery.ajax({
			type: "POST",
		    url: $baseurl + "account/chk_shop",
			data: "shoplink="+document.getElementById('link_shop').value+"&shopname="+document.getElementById('name_shop').value,
			success: function(data){
				if(data ==0){
					jAlert("Link to your store is coincide with the another store, please enter again!","Notice",function(r){
						jQuery('#link_shop').focus();
					});
					return false;
				}
				else
				{
					if(data == 1){
						jAlert("Name of your store is coincide with the another store, please enter again!","Notice",function(r){
							jQuery('#name_shop').focus();
						});
						return false;
					}
					else{
						jQuery('#isEditShop').val(1);
						document.frmEditShop.submit();
					}
				}
			},
		error: function(){}
	 });
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
	//div.value = div.value.replace(rBlock[type],'');
	//div.value = div.value.replace(/ +/g,' ');
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
/*BEGIN: Post*/
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

function FormatCurrency(div,idGeted,number)
{
	/*Convert tu 1000->1.000*/
	/*var mynumber=1000;number = number.replace(/\./g,"");*/
	document.getElementById(div).style.display = "";
	document.getElementById(div).innerHTML = AddComma(number);
	document.getElementById(div).innerHTML = document.getElementById(div).innerHTML + '&nbsp;' + document.getElementById(idGeted).options[document.getElementById(idGeted).selectedIndex].innerHTML;
}

function FormatCost(cost,div)
{
	if(document.getElementById(div)){
		document.getElementById(div).innerHTML = AddComma(cost);
	}
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
function ChangeStyleTextBox(div,div_show,status)
{
	if (status == true)
	{
		document.getElementById(div).style.backgroundColor = "#DDDDDD";
		document.getElementById(div).value = "0";
	}
	else
	{
		document.getElementById(div).style.backgroundColor = "#FFFFFF";
		document.getElementById(div).value = "";
	}
	document.getElementById(div_show).style.display = "none";
}

function ChangeCheckBox(checkbox)
{
	document.getElementById(checkbox).checked = false;
}
/*END Post*/
/*BEGIN: Dang Ky*/
function ChangeLawRegister(status,index)
{
	if(status == true)
	{
		if(index == 1)
		{
			document.getElementById('DivNormalRegister').style.display = "none";
			document.getElementById('DivVipRegister').style.display = "";
			document.getElementById('DivShopRegister').style.display = "none";
			jQuery(function()
			{
				jQuery('#Panel_2').jScrollPane({showArrows:true, scrollbarWidth: 15, arrowSize: 16});
			});
		}
		if(index == 2)
		{
			document.getElementById('DivNormalRegister').style.display = "none";
			document.getElementById('DivVipRegister').style.display = "none";
			document.getElementById('DivShopRegister').style.display = "";
			jQuery(function()
			{
				jQuery('#Panel_3').jScrollPane({showArrows:true, scrollbarWidth: 15, arrowSize: 16});
			});
		}
	}
	else
	{
		document.getElementById('DivNormalRegister').style.display = "";
		document.getElementById('DivVipRegister').style.display = "none";
		document.getElementById('DivShopRegister').style.display = "none";
		jQuery(function()
		{
			jQuery('#Panel_1').jScrollPane({showArrows:true, scrollbarWidth: 15, arrowSize: 16});
		});
	}
}
/*END Dang Ky*/
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
/*BEGIN: ShowCart*/
function SumCost(CostVNDShowCart,Quantity,SumCostVNDShowCart,SumCostUSDShowCart,convert)
{
	var vnd = document.getElementById(CostVNDShowCart).value * document.getElementById(Quantity).value;
	var usd = vnd/convert;
	vnd = Math.round(vnd);
	usd = Math.round(usd);
	vnd = AddComma(vnd);
	usd = AddComma(usd);
	document.getElementById(SumCostVNDShowCart).innerHTML = vnd;
	document.getElementById(SumCostUSDShowCart).innerHTML = usd + "&nbsp;USD";
}

function TotalCost(CostVNDShowCart,Quantity,TotalVNDShowCart,TotalUSDShowCart,number,convert)
{
	var vnd = 0;
	var usd = 0;
	if(number > 0)
	{
		for(var i=1;i<=number;i++)
		{
			vnd = vnd + document.getElementById(CostVNDShowCart+i).value * document.getElementById(Quantity+i).value;
		}
	}
	usd = vnd/convert;
	vnd = Math.round(vnd);
	vndNoneComma=vnd;
	usd = Math.round(usd);
	vnd = AddComma(vnd);
	usd = AddComma(usd);
	document.getElementById(TotalVNDShowCart).innerHTML = vnd + "&nbsp;VND";
	/*ltngan*/
	document.getElementById('totalPrice').value = vndNoneComma;
	/*end ltngan*/
	document.getElementById(TotalUSDShowCart).innerHTML = "(" + usd + "&nbsp;USD)";
}

function ActionDeleteShowcart()
{
	var alen=document.frmShowCart.elements.length;
	var isChecked=false;
	alen=(alen>1)?document.frmShowCart.checkone.length:0;
	if(alen>0)
	{
		for(var i=0;i<alen;i++)
				if(document.frmShowCart.checkone[i].checked==true)
				{
					isChecked=true;
					break;
				}
	}
	else
	{
		if(document.frmShowCart.checkone.checked==true)
			isChecked=true;
	}	
	if(isChecked == true)
	{
		document.frmShowCart.submit();
	}
}

function ActionEqual(status)
{
	if(status == '1')
	{	
		var answer = confirm("Do you really want to buy these products? If you agree we will deduct your account corresponding to the products you have purchased!");
		if (answer){
			document.getElementById('checkall').checked = false;
			DoCheck(document.frmShowCart.checkall.checked,'frmShowCart',0);
			document.forms["frmShowCart"].submit();
			return true;
		}
		else{
			return false;
		}
		
	}
	else
	{
		alert(status);
		
	}
}
/**
author: sunguyen
**/
function submit_payment(status)
{
	if(status == '1')
	{	
		var answer = confirm("Do you really want to buy these products? If you agree we will deduct your account corresponding to the products you have purchased!");
		if (answer){
			document.getElementById('checkall').checked = false;
			DoCheck(document.frmShowCart.checkall.checked,'frmShowCart',0);
			return true;
		}
		else{
			return false;
		}
		
	}
	else
	{
		alert(status);
		
	}
}
function ResetQuantity(Quantity,number)
{
	for(var i=1;i<=number;i++)
	{
		document.getElementById(Quantity+i).value = "1"; 
	}
}
/*END ShowCart*/
/*BEGIN: Change Style*/
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
/*END Change Style*/
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
/*BEGIN: ActionSort*/
function ActionSort(isAddress)
{
	window.location.href = isAddress;
}
/*END ActionSort*/
/*BEGIN: ActionLink*/
function ActionLink(isAddress)
{
	window.location.href = isAddress;
}
/*END ActionLink*/
/*BEGIN: Favorite*/
function FavoriteProduct($baseurl, $proid,status)
{
	if(status == '1')
	{
		jQuery.ajax({
			type: "POST",
		    url: $baseurl + "product/favorite",
			data: "proid="+$proid,
			success: function(data){
				if(data ==1){
					jAlert("This product was added to the list of your favorite products!","Notice");
					jQuery('#favorite_product_'+$proid).html('<img src="'+$baseurl+'templates/home/images/btn_favorited.gif">');
				}
			},
			error: function(){}
		 });		
	}
	else
	{
		jAlert(status,"Login required!");
	}
}
function FavoriteAds($baseurl, $adsid,status)
{
	if(status == '1')
	{
		jQuery.ajax({
			type: "POST",
		    url: $baseurl + "raovat/favorite",
			data: "adsid="+$adsid,
			success: function(data){
				if(data ==1){
					jAlert("This Classified has been added to your favorite Classified!","Notice");
					jQuery('#favorite_rv_'+$adsid).html('<img src="'+$baseurl+'templates/home/images/btn_rv_favorited.gif">');
				}
			},
			error: function(){}
		 });
	}
	else
	{
		jAlert(status,"Login required!");
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
/*BEGIN: SubmitVote*/
function SubmitVote()
{
	document.frmVote.submit();
}
/*END SubmitVote*/
/*BEGIN: OpenTabTopJob*/
function OpenTabTopJob(total, page, type)
{
	if(type == 'job')
	{
		var div = 'DivTop24hJob';
	}
	else
	{
		var div = 'DivTop24hEmploy';
	}
	switch(page)
	{
		case 1:
			for(i = 1; i <= total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "";
			}
			for(i = total+1; i <= 3*total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "none";
			}
			break;
		case 2:
			for(i = 1; i <= total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "none";
			}
			for(i = total+1; i <= 2*total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "";
			}
			for(i = 2*total+1; i <= 3*total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "none";
			}
			break;
		default:
			for(i = 1; i <= 2*total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "none";
			}
			for(i = 2*total+1; i <= 3*total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "";
			}
	}
}
/*END OpenTabTopJob*/
/*BEGIN: OpenTabField*/
function OpenTabField()
{
	if(document.getElementById('DivField_1').style.display == "none")
	{
		document.getElementById('DivField_1').style.display = "";
		document.getElementById('DivField_2').style.display = "";
		document.getElementById('DivField_3').style.display = "";
		document.getElementById('DivField_4').style.display = "";
	}
	else
	{
		document.getElementById('DivField_1').style.display = "none";
		document.getElementById('DivField_2').style.display = "none";
		document.getElementById('DivField_3').style.display = "none";
		document.getElementById('DivField_4').style.display = "none";
	}
}
/*END OpenTabField*/
/*BEGIN: ActionSubmit*/
function ActionSubmit(formName)
{
	eval('document.' + formName + '.submit();');
}
/*END ActionSubmit*/
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
function goLink(golink){
	window.location.href = golink;
}
/*BEGIN: Action Search*/
function ActionSearch(baseurl,type)
{
	var isAddress = '';
	switch (type)
	{
		case 1://Search product
			isAddress = baseurl;
			isName = document.getElementById('name_search').value;
			isSCost = document.getElementById('cost_search1').value;
			isECost = document.getElementById('cost_search2').value;
			isCurrency = document.getElementById('currency_search').value;
			isSaleoff = document.getElementById('saleoff_search').value;
			isPlace = document.getElementById('province_search').value;
			isCategory = document.getElementById('category_search').value;
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
			if(isCategory != '0')
			{
				isAddress += 'category/' + isCategory + '/';
			}
			if(isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008))
			{
				isAddress += 'sPostdate/' + isSDate + '/';
				isAddress += 'ePostdate/' + isEDate + '/';
			}
			window.location.href = isAddress;
			break;
		case 2://Search ads
			isAddress = baseurl;
			isTitle = document.getElementById('title_search').value;
			isSView = document.getElementById('view_search1').value;
			isEView = document.getElementById('view_search2').value;
			isPlace = document.getElementById('province_search').value;
			isCategory = document.getElementById('category_search').value;
			isSDay = document.getElementById('beginday_search1').value;
			isSMonth = document.getElementById('beginmonth_search1').value;
			isSYear = document.getElementById('beginyear_search1').value;
			isEDay = document.getElementById('beginday_search2').value;
			isEMonth = document.getElementById('beginmonth_search2').value;
			isEYear = document.getElementById('beginyear_search2').value;
			isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
			isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
			if(!CheckBlank(isTitle))
			{
				isAddress += 'title/' + isTitle + '/';
			}
			if(!CheckBlank(isSView) && !CheckBlank(isEView))
			{
				isAddress += 'sView/' + isSView + '/';
				isAddress += 'eView/' + isEView + '/';
			}
			if(isPlace != '0')
			{
				isAddress += 'place/' + isPlace + '/';
			}
			if(isCategory != '0')
			{
				isAddress += 'category/' + isCategory + '/';
			}
			if(isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008))
			{
				isAddress += 'sPostdate/' + isSDate + '/';
				isAddress += 'ePostdate/' + isEDate + '/';
			}
			window.location.href = isAddress;
			break;
		case 3://Search job
			isAddress = baseurl;
			isTitle = document.getElementById('title_search').value;
			isSalary = document.getElementById('salary_search').value;
			isCurrency = document.getElementById('currency_search').value;
			isPlace = document.getElementById('province_search').value;
			isField = document.getElementById('field_search').value;
			isSDay = document.getElementById('beginday_search1').value;
			isSMonth = document.getElementById('beginmonth_search1').value;
			isSYear = document.getElementById('beginyear_search1').value;
			isEDay = document.getElementById('beginday_search2').value;
			isEMonth = document.getElementById('beginmonth_search2').value;
			isEYear = document.getElementById('beginyear_search2').value;
			isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
			isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
			if(!CheckBlank(isTitle))
			{
				isAddress += 'title/' + isTitle + '/';
			}
			if(!CheckBlank(isSalary))
			{
				isAddress += 'salary/' + isSalary + '/';
				isAddress += 'currency/' + isCurrency + '/';
			}
			if(isPlace != '0')
			{
				isAddress += 'place/' + isPlace + '/';
			}
			if(isField != '0')
			{
				isAddress += 'field/' + isField + '/';
			}
			if(isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008))
			{
				isAddress += 'sPostdate/' + isSDate + '/';
				isAddress += 'ePostdate/' + isEDate + '/';
			}
			window.location.href = isAddress;
			break;
		case 4://Search employ
			isAddress = baseurl;
			isTitle = document.getElementById('title_search').value;
			isSalary = document.getElementById('salary_search').value;
			isCurrency = document.getElementById('currency_search').value;
			isPlace = document.getElementById('province_search').value;
			isField = document.getElementById('field_search').value;
			isSDay = document.getElementById('beginday_search1').value;
			isSMonth = document.getElementById('beginmonth_search1').value;
			isSYear = document.getElementById('beginyear_search1').value;
			isEDay = document.getElementById('beginday_search2').value;
			isEMonth = document.getElementById('beginmonth_search2').value;
			isEYear = document.getElementById('beginyear_search2').value;
			isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
			isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
			if(!CheckBlank(isTitle))
			{
				isAddress += 'title/' + isTitle + '/';
			}
			if(!CheckBlank(isSalary))
			{
				isAddress += 'salary/' + isSalary + '/';
				isAddress += 'currency/' + isCurrency + '/';
			}
			if(isPlace != '0')
			{
				isAddress += 'place/' + isPlace + '/';
			}
			if(isField != '0')
			{
				isAddress += 'field/' + isField + '/';
			}
			if(isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008))
			{
				isAddress += 'sPostdate/' + isSDate + '/';
				isAddress += 'ePostdate/' + isEDate + '/';
			}
			window.location.href = isAddress;
			break;
		case 6: 
			isAddress = baseurl;
			isName = document.getElementById('name_search').value;
			isCategory = document.getElementById('category_search').value;
			if(!CheckBlank(isName))
			{
				isAddress += 'name/' + isName + '/';
			}
			if(isCategory != '0')
			{
				isAddress += 'category/' + isCategory + '/';
			}
			window.location.href = isAddress;
			break;
		case 5://Search shop
			isAddress = baseurl;
			isName = document.getElementById('name_search').value;
			isAddress_Shop = document.getElementById('address_search').value;
			isSaleoff = document.getElementById('saleoff_search').value;
			isProvince = document.getElementById('province_search').value;
			isCategory = document.getElementById('category_search').value;
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
			if(document.getElementById('saleoff_search').checked == true)
			{
				isAddress += 'saleoff/1/';
			}
			if(!CheckBlank(isAddress_Shop))
			{
				isAddress += 'address/' + isAddress_Shop + '/';
			}
			if(isProvince != '0')
			{
				isAddress += 'province/' + isProvince + '/';
			}
			if(isCategory != '0')
			{
				isAddress += 'category/' + isCategory + '/';
			}
			if(isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008))
			{
				isAddress += 'sPostdate/' + isSDate + '/';
				isAddress += 'ePostdate/' + isEDate + '/';
			}
			window.location.href = isAddress;
			break;
		default://Search account
			var isKeyword = "";
			var isSearch = "";
			isKeyword = document.getElementById('keyword_account').value;
			isSearch = document.getElementById('search_account').value;
			if(!CheckBlank(isKeyword))
			{
				isAddress = baseurl + 'search/' + isSearch + '/keyword/' + isKeyword;
				window.location.href = isAddress;
			}
	}
}

function SelectSearch(sel)
{
	for(i=1;i<6;i++)
	{
		document.getElementById("TabSearch_" + i).className = "menu";
	}
	document.getElementById("TabSearch_" + sel).className = "search_selected";
	return sel;
}

function Search(type, baseUrl)
{
	var isAddress = baseUrl + 'search/';
	switch(type)
	{
		case 2:
			isAddress += 'raovat/title/';
			break;
		case 3:
			isAddress += 'job/title/';
			break;
		case 4:
			isAddress += 'employ/title/';
			break;
		case 5:
			isAddress += 'shop/name/';
			break;
		default:
			isAddress += 'product/name/';
	}
	var category = jQuery('#category_quick_search').val();
	
	var isKeyword = jQuery('#name_quick_search').val();
	if(!CheckBlank(isKeyword))
	{
		isAddress = isAddress + isKeyword;
	}else{
		isAddress = isAddress + 'a';
	}
	if(!CheckBlank(category))
	{
		isAddress = isAddress + '/category/' + category;
	}
	window.location.href  = isAddress;
	return false;
}
/*END Action Search*/
/*BEGIN: Guide*/
function Guide($div)
{
	$totalGuide = 9;
	for($i = 1; $i < $div; $i++)
	{
		document.getElementById('DivTitleGuide_' + $i).style.display = 'none';
		document.getElementById('DivContentGuide_' + $i).style.display = 'none';
		document.getElementById('DivListGuide_' + $i).className = 'menu_1';
	}
	for($j = $div+1; $j <= $totalGuide; $j++)
	{
		document.getElementById('DivTitleGuide_' + $j).style.display = 'none';
		document.getElementById('DivContentGuide_' + $j).style.display = 'none';
		document.getElementById('DivListGuide_' + $j).className = 'menu_1';
	}
	document.getElementById('DivIntroGuide').style.display = 'none';
	document.getElementById('DivGuide').style.display = 'block';
	document.getElementById('DivTitleGuide_' + $div).style.display = 'block';
	document.getElementById('DivContentGuide_' + $div).style.display = 'block';
	document.getElementById('DivListGuide_' + $div).className = 'menu_2';
}
/*END Guide*/
/*BEGIN: Taskbar*/
function TabTaskbarNotify(status)
{
	switch(status)
	{
		case 1:
			if(document.getElementById('DivTaskbarNotify').style.display == 'block')
			{
				document.getElementById('DivTaskbarNotify').style.display = 'none';
			}
			else
			{
				document.getElementById('DivTaskbarNotify').style.display = 'block';
			}
			break;
		default:
			document.getElementById('DivTaskbarNotify').style.display = 'none';
	}
}
/*END Taskbar*/
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
/*END Show Thumbnail*/

function lowerCase(string,id){
	str=string.toLowerCase();
	document.getElementById(id).value=str;
}

function pagingHomepage(id,page){
	jQuery('.shop_block').css('display','none');	
	jQuery('#'+id+page).css('display','block');
	jQuery('.review_page').removeClass('current');
	jQuery('#review_page_'+page).addClass('current');
}

function pagingHomepageVote(id,page){
	jQuery('.vote_block').css('display','none');	
	jQuery('#'+id+page).css('display','block');
	jQuery('.review_page_vote').removeClass('current');
	jQuery('#review_page_vote_'+page).addClass('current');
}

function getCategory4Search(baseUrl, selCate)
{
    jQuery.ajax({
			   type: "POST",
			   url: baseUrl + "ajax_category",
			   data: "selCate="+selCate,
			   success: function(data){
				   jQuery("#category_quick_search").append(data);
				   
				},
			   error: function(){}
		 	});
}

function getManAndCategory4Search(baseUrl)
{
	
	CategoryKeyWord = document.getElementById('hd_category_id').value;
	jQuery("#mannufacurer_pro").empty();
	if(CategoryKeyWord!="")
	{
    jQuery.ajax({
			   type: "POST",
			   url: baseUrl + "ajax_mancatego",
			   data: "selCate="+CategoryKeyWord,
			   success: function(data){	
			   				if(data!=""){
				  			 jQuery("#mannufacurer_pro").empty().append(data);
							}
							else
							{
								jQuery('#manafacture_khac').css('display','block');	
							}
							jQuery("#mannufacurer_pro option[value='khac']").each(function() {
						 jQuery(this).remove();
				
				   });

							jQuery('#mannufacurer_pro').append('<option value="khac" >Khác</option>');
							
							 
					  
				},
				
			   error: function(){}
		 	});
	}
	
}
function ManafactureKhac(value){
	if(value=="khac"){
			jQuery('#manafacture_khac').css('display','block');	
	}
	else
	{
		jQuery('#manafacture_khac').css('display','none');	
	}
}

/*jQuery(document).ready(function($){
								$("#total_amount").change(function () {
															 alert($(this).val());
															 })
								})*/
function number_format (number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');    }
    return s.join(dec);
}
function select_price(){
	var value = parseFloat(jQuery('#select_cost').val());
	var total_fee = value/0.99;
	var bk_fee = parseFloat(total_fee * 0.01);
	jQuery('#bk_fee').html(number_format(bk_fee, 0, ',','.'));
	jQuery('#total_fee').html(number_format(total_fee, 0, ',','.'));
	jQuery('#total_amount').val(total_fee);	
}


var notify1 = "";
var notify2  = "";
var notify3 = "";
var notify4 = "";
var notify5 = "";

function notifyBlock1(){
	jQuery('.notice').css('display','none');
	jQuery('#notify1').css('display','block');
	jQuery("#notify1").animate({opacity:0},200,"linear",function(){
	  jQuery(this).animate({opacity:1},200);
	});
	notify2=window.setInterval(notifyBlock2, 10000);
	window.clearInterval(notify1);
}
function notifyBlock2(){
	jQuery('.notice').css('display','none');
	jQuery('#notify2').css('display','block');
	jQuery("#notify2").animate({opacity:0},200,"linear",function(){
	  jQuery(this).animate({opacity:1},200);
	});
	notify3=window.setInterval(notifyBlock3, 10000);
	window.clearInterval(notify2);
}
function notifyBlock3(){
	jQuery('.notice').css('display','none');
	jQuery('#notify3').css('display','block');
	jQuery("#notify3").animate({opacity:0},200,"linear",function(){
	  jQuery(this).animate({opacity:1},200);
	});
	notify4=window.setInterval(notifyBlock4, 10000);
	window.clearInterval(notify3);
}
function notifyBlock4(){
	jQuery('.notice').css('display','none');
	jQuery('#notify4').css('display','block');
	jQuery("#notify4").animate({opacity:0},200,"linear",function(){
	 jQuery(this).animate({opacity:1},200);
	});
	notify5=window.setInterval(notifyBlock5, 10000);
	window.clearInterval(notify4);
}
function notifyBlock5(){
	jQuery('.notice').css('display','none');
	jQuery('#notify5').css('display','block');
	jQuery("#notify5").animate({opacity:0},200,"linear",function(){
	  jQuery(this).animate({opacity:1},200);
	});

	notify1=window.setInterval(notifyBlock1, 10000);
	window.clearInterval(notify5);
}

function hiddenProductViaResolution(var_class){
	// kiem tra do phan giai mam hinh va dieu chinh so luong san pham tren 1 hang
	
	var widthScreen=jQuery(window).width();
	if(widthScreen<=1024){
		jQuery('.'+var_class+' .width_3').each(function(index) {
			jQuery(this).css('width','33%');
			if(index>=3){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}
		});  
	}
		
	if(widthScreen>=1024 && widthScreen<1280){
		jQuery('.'+var_class+' .width_3').each(function(index) {
			jQuery(this).css('width','24%');
			if(index>=4){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}
		});  
	}
	
	if(widthScreen>=1280 && widthScreen<1330){
		jQuery('.'+var_class+' .width_3').each(function(index) {
			jQuery(this).css('width','25%');
			if(index>=4){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}
		});  
	}
	
	if(widthScreen>=1330 && widthScreen<1500){
		jQuery('.'+var_class+' .width_3').each(function(index) {
			jQuery(this).css('width','19%');
			if(index>=5){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}
		});  
	}
	
	if(widthScreen>1500){
		jQuery('.'+var_class+' .width_3').each(function(index) {
			jQuery(this).css('width','16%');
			jQuery(this).css('display','block');
		});  
	}
}
// QUANG
function hiddenProductViaResolutionCategory(var_class){
	// kiem tra do phan giai mam hinh va dieu chinh so luong san pham tren 1 hang
	
	var widthScreen=jQuery(window).width();
	if(widthScreen<=1024){
		jQuery('.'+var_class+' .showbox_1').each(function(index) {
			jQuery(this).css('width','30%');
			if(index>=6){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}
		});  
	}
		
	if(widthScreen>=1024 && widthScreen<1280){
		jQuery('.'+var_class+' .showbox_1').each(function(index) {
			jQuery(this).css('width','22.3%');
			jQuery(this).css('margin-right','8px');		
			if(index>=8){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}		
		});  
	}
	
	if(widthScreen>=1280 && widthScreen<1330){
		jQuery('.'+var_class+' .showbox_1').each(function(index) {
			jQuery(this).css('width','22.5%');
			if(index>=8){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}
		});  
	}
	
	if(widthScreen>=1330 && widthScreen<1500){
		jQuery('.'+var_class+' .showbox_1').each(function(index) {
			jQuery(this).css('width','18.1%');
			if(index>=10){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}
		});  
	}
	
	if(widthScreen>1500){
		jQuery('.'+var_class+' .showbox_1').each(function(index) {
			jQuery(this).css('width','15%');
			jQuery(this).css('margin-right','15px');	
			if(index>=12){
				jQuery(this).css('display','none');
			}else{
				jQuery(this).css('display','block');
			}
			
		});  
	}
}

//END QUANG 


function hiddenProductViaResolutionId(var_id){
	// kiem tra do phan giai mam hinh va dieu chinh so luong san pham tren 1 hang
	
	var widthScreen=jQuery(window).width();
	if(widthScreen<=1024){
		jQuery('#'+var_id+' .width_3').each(function(index) {
			jQuery(this).css('width','33%');
			if(index>=3){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}
		});  
	}
		
	if(widthScreen>=1024 && widthScreen<1280){
		jQuery('#'+var_id+' .width_3').each(function(index) {
			jQuery(this).css('width','24%');
			if(index>=4){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}
		});  
	}
	
	if(widthScreen>=1280 && widthScreen<1330){
		jQuery('#'+var_id+' .width_3').each(function(index) {
			jQuery(this).css('width','25%');
			if(index>=4){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}
		});  
	}
	
	if(widthScreen>=1330 && widthScreen<1500){
		jQuery('#'+var_id+' .width_3').each(function(index) {
			jQuery(this).css('width','19%');
			if(index>=5){
				jQuery(this).css('display','none');
				
			}else{
				jQuery(this).css('display','block');
			}
		});  
	}
	
	if(widthScreen>1500){
		jQuery('#'+var_id+' .width_3').each(function(index) {
			jQuery(this).css('width','16%');
			jQuery(this).css('display','block');
		});  
	}
}



function resizeSlideshowViaResolution(){
	// kiem tra do phan giai mam hinh va dieu chinh so luong san pham tren 1 hang
	
	var widthScreen=jQuery(window).width();
	if(widthScreen<=1024){		
		jQuery('#slide-runner').css('width','420px');
		jQuery('#slide-runner').css('height','200px');
		jQuery('#slide-runner img').css('width','420px');
		jQuery('#slide-runner img').css('height','200px')				
	}
		
}
function mySearch(type,baseUrl){
	if(type==1){  // product
		  product_name='';		 
		  if(document.getElementById('singleBirdRemote').value!='')
		  product_name=document.getElementById('singleBirdRemote').value;		  
		  category='';
		  if(document.getElementById('category_quick_search').value!=''){
			  category='cat/'+document.getElementById('category_quick_search').value+'/';		   	 
		  }
		  window.location = baseUrl+'search/product/name/'+product_name+'/'+category;
		  
	}
	if(type==2){  // product
		  ads_name=document.getElementById('singleBirdRemote').value;
		  category='';
		  if(document.getElementById('category_quick_search').value!=''){
			  category='cat/'+document.getElementById('category_quick_search').value+'/';		   	 
		  }
		  window.location = baseUrl+'search/raovat/title/'+ads_name+'/'+category;
		  
	}
	
}

function keywordFocus(ob){
	if(jQuery(ob).val() == defSearchKeyword){
		jQuery(ob).val("");
	}
}
function keywordBlur(ob){
	if(jQuery(ob).val() == ""){
		jQuery(ob).val(defSearchKeyword);
	}
}
function timkiemnangcao(baseUrl){
	if(document.getElementById('category_quick_search_q').value=='product'){  // product
		window.location = baseUrl+'search/product/';			  
	}
	if(document.getElementById('category_quick_search_q').value=='raovat'){  // product			  
		window.location = baseUrl+'search/raovat/';	  
	}
	if(document.getElementById('category_quick_search_q').value=='shop'){  // product			  
		window.location = baseUrl+'search/shop/';	  
	}
	if(document.getElementById('category_quick_search_q').value=='hoidap'){  // product		  
		window.location = baseUrl+'search/hoidap/';
	}
}
function qSearch(baseUrl){
	if(document.getElementById('singleBirdRemote').value=='' ||  document.getElementById('singleBirdRemote').value==defSearchKeyword)
	{
		jAlert("You must type in the keyword search",'Notice');
	}
	else
	{	
		
		if(document.getElementById('category_quick_search_q').value=='product'){  // product
			  product_name='';		 
			  if(document.getElementById('singleBirdRemote').value!='' &&  document.getElementById('singleBirdRemote').value!=defSearchKeyword)
			  product_name=document.getElementById('singleBirdRemote').value;  
			 
			  window.location = baseUrl+'search/product/name/'+product_name;			  
		}
		if(document.getElementById('category_quick_search_q').value=='raovat'){  // product
			  ads_name = '';
			  if(document.getElementById('singleBirdRemote').value!='' &&  document.getElementById('singleBirdRemote').value!=defSearchKeyword)
			  ads_name=document.getElementById('singleBirdRemote').value;			  
			  window.location = baseUrl+'search/raovat/title/'+ads_name;
			  
		}
		if(document.getElementById('category_quick_search_q').value=='shop'){  // product
		      shop_name = '';
			  if(document.getElementById('singleBirdRemote').value!='' &&  document.getElementById('singleBirdRemote').value!=defSearchKeyword)
			  shop_name=document.getElementById('singleBirdRemote').value;			  
			  window.location = baseUrl+'search/shop/name/'+shop_name;
			  
		}
		if(document.getElementById('category_quick_search_q').value=='hoidap'){  // product
		      hoidap_name = '';
			  if(document.getElementById('singleBirdRemote').value!='' &&  document.getElementById('singleBirdRemote').value!=defSearchKeyword)
			  hoidap_name=document.getElementById('singleBirdRemote').value;			  
			  window.location = baseUrl+'search/hoidap/name/'+hoidap_name;
			  
		}
		
	}
}
function checkekdieuKienThanhCong()
{
	var checked = jQuery('#checkDongY').is(':checked');
											
	if(checked==true)
	{
		jQuery('.checkdongy').css('display','block');
	}
	else
	{
		jQuery('.checkdongy').css('display','none');
	}
}
function setValChk($id){
	if (jQuery('#'+$id).attr('checked')) {
		jQuery('#'+$id).val(1);
	}else{
		jQuery('#'+$id).val(0);
	}
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
						strReturn += '<div class="margin">Price:<b class="price">'+jQuery("#price-"+id).html()+'</b>&nbsp; &nbsp; (Views: '+ jQuery("#view-"+id).val() +')</div>';
						strReturn += '<div class="margin">At store:<b><span class="company">'+jQuery("#shop-"+id).val()+'</b></div>';
						strReturn += '<div class="margin">Address:<b>'+jQuery("#pos-"+id).val()+'</b>&nbsp; &nbsp; Date involved:<b>'+jQuery("#date-"+id).val()+'</b></div>';
						strReturn += '<div class="picture_only">'+ resizeImageSrc(picturePath, jQuery(this).width(), jQuery(this).height(), width, height) + '</div>';
						return strReturn;
					},
					track: true,
					showURL: false,
					extraClass: "tooltip_product"
				});
			}
			//tooltip user
			function tooltipPictureUser(obj,id){
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
								strReturn += '<div class="picture_only" style="float:left">'+ resizeImageSrc(picturePath, 120, 120, 120, 120) + '</div>';
						strReturn += ' <div style="float:left; padding-left:20px;"> <div class="name">'+jQuery("#name-"+id).val()+'</div>';
						strReturn += '<div class="margin">Tên đăng nhập: <b class="price">'+jQuery("#user-"+id).val()+'</b></div>';
						strReturn += '<div class="margin">Email :<b><span class="company">'+jQuery("#email-"+id).val()+'</b></div>';
						strReturn += '<div class="margin">Điện thoại :<b><span class="company">'+jQuery("#phone-"+id).val()+'</b></div> </div>';
						//strReturn += '<div class="margin">Yahoo :<b><span class="company">'+jQuery("#yahoo-"+id).val()+'</b></div>';
					//strReturn += '<div class="margin">Skype :<b><span class="company">'+jQuery("#skype-"+id).val()+'</b></div>';
				
						return strReturn;
					},
					track: true,
					showURL: false,
					extraClass: "tooltip_product"
				});
			}
			
			//end tooltip user
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
/*END Set Enddate*/
function edit_category(){
	jQuery('#reselect_category').css('display','none');
	jQuery('#undo_reselect_category').css('display','block');
	jQuery('.viewDatatNone').css('display','block');
}
function undo_edit_category($oldcatid){
	jQuery('#reselect_category').css('display','block');
	jQuery('#undo_reselect_category').css('display','none');
	jQuery('.viewDatatNone').css('display','none');
	jQuery('#hd_category_id').val($oldcatid);
	jQuery('#curr_cat_tree').html(jQuery('#old_cat_tree').val());
}
function deleteBanner($baseurl,$bannerdir,$bannerid){
	jConfirm("Do you really want to delete this banner?","Delete confirmation", function(r){
		if(r == true){
			jQuery.ajax({
				type: "POST",
				url: $baseurl + "account/delete_banner",
				data: "id=" + $bannerid + "&direct=" + $bannerdir,
				success: function(data){
					window.location.reload();
				},
				error: function(){}
			});
			return false;
		}else{
			return false;
		}
	});
}
function delete_img_ajax($baseUrl,$id,$imgname,$pos,$type){
	jConfirm("Do you really want to delete this image?","Delete confirmation", function(r){
		if(r == true){
			jQuery.ajax({
				type: "POST",
				url: $baseUrl + "delete_img",
				data: "id=" + $id + "&name=" + $imgname + "&type=" + $type + "&pos=" + $pos,
				success: function(data){
					jQuery('#img_input_'+$pos).css('display','block');	
					jQuery('#img_'+$pos).css('display','none');
				},
				error: function(){}
			});
			return false;
		}else{
			return false;
		}
	});
}
function getDistrict(provinceid, baseUrl, $language){
	jQuery('#list_district').css('display','none');
	jQuery('#sel_district').val(0);
	jQuery.ajax({
		type: "POST",
		url: baseUrl + "ajax_get_district",
		data: "province_id=" + provinceid,
		dataType: "json",
		success: function(data){
			if(data[1] > 0)
			{
				if($language == 'vietnamese'){
				    str = '<select class="selectprovince_formpost" onclick="selDistrict(this.value);"><option value="0">- Chọn Quận/Huyện -</option>';
				}else if($language == 'english'){
					str = '<select class="selectprovince_formpost" onclick="selDistrict(this.value);"><option value="0">- Select District -</option>';
				}
				for(i = 0; i < data[1]; i++)
				{
					str +='<option value="'+data[0][i].id+'">'+data[0][i].dis_name+'</option>';
				}
				jQuery('#list_district').html(str);
				jQuery('#list_district').css('display','inline');
			}
		},
		error: function(){alert("No Data!");}
	});
}
function selDistrict(districtid){
	jQuery('#sel_district').val(districtid);
}
function check_hoidap(parent_id,level,baseUrl){
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
		url: baseUrl + "hoidap/ajax",
		data: "parent_id=" + parent_id,
		dataType: "json",
		success: function(data){
			if(data[1] > 0)
			{
				str = '<select id="hd_select_'+parseInt(level+1)+'" class="form_control_hoidap_select" onclick="check_hoidap(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');" size="27">';
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

function check_postCategoryProduct(parent_id,level,baseUrl,$language){
	jQuery('#hd_category_id').val('');	
	if(level == 0){
		jQuery('#hoidap_1').css('display','none');
		jQuery('#hoidap_2').css('display','none');
	}
	if(level == 1){
		jQuery('#hoidap_2').css('display','none');
	}
	jQuery('#cat_level_'+level).val(jQuery("#hd_select_"+level+" option:selected").text());
	if(level == 0){
		jQuery('#curr_cat_tree').html(jQuery("#hd_select_"+level+" option:selected").text());
	}else{
		jQuery('#curr_cat_tree').html(jQuery('#cat_level_0').val()+jQuery('#cat_level_1').val()+jQuery('#cat_level_2').val());
	}
	jQuery.ajax({
		type: "POST",
		url: baseUrl + "product/ajax",
		data: "parent_id=" + parent_id,
		dataType: "json",
		success: function(data){
			if(data[1] > 0)
			{
				str = '<select id="hd_select_'+parseInt(level+1)+'" class="form-control form_control_hoidap_select" onclick="   check_postCategoryProduct(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');  " size="14" onblur="getManAndCategory4Search(\''+baseUrl+'\');">';
				for(i = 0; i < data[1]; i++)
				{
					if($language == 'vietnamese'){
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name;
					}else if($language == 'english'){
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name_en;
					}
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
// raovat
function check_postCategoryRaovat(parent_id,level,baseUrl,$language){
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
		url: baseUrl + "raovat/ajax",
		data: "parent_id=" + parent_id,
		dataType: "json",
		success: function(data){
			if(data[1] > 0)
			{
				str = '<select id="hd_select_'+parseInt(level+1)+'" class="form_control_hoidap_select" onclick="check_postCategoryRaovat(this.value, '+parseInt(level+1)+', \''+baseUrl+'\');  " size="15">';
				for(i = 0; i < data[1]; i++)
				{
					if($language == 'vietnamese'){
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name;
					}else if($language == 'english'){
						str += '<option value="'+data[0][i].cat_id+'">'+data[0][i].cat_name_en;
					}
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



function getManAndCategory4Search_edit(baseUrl)
{
	
	CategoryKeyWord = document.getElementById('category_pro_edit').value;
	jQuery('#hd_category_id').val(CategoryKeyWord);
	jQuery("#mannufacurer_pro").empty();
	if(CategoryKeyWord!="")
	{
    jQuery.ajax({
			   type: "POST",
			   url: baseUrl + "ajax_mancatego",
			   data: "selCate="+CategoryKeyWord,
			   success: function(data){	
			   				if(data!=""){
				  			 jQuery("#mannufacurer_pro").empty().append(data);
							}
							else
							{
								jQuery('#manafacture_khac').css('display','block');	
							}
							jQuery("#mannufacurer_pro option[value='khac']").each(function() {
						 jQuery(this).remove();
				
				   });

							jQuery('#mannufacurer_pro').append('<option value="khac" >Khác</option>');
							
							 
					  
				},
				
			   error: function(){}
		 	});
	}
	
}
function goMsgSupplier(baseUrl){
	window.open(baseUrl+'contact/msgsend','_blank');
}
function processPendCart(ob,proid,baseurl){
	$removefrompend = jQuery(ob).is(':checked');
	if($removefrompend == true){
		jQuery.ajax({
			type: "POST",
			url: baseurl + "ajax_delete_from_pend_cart",
			data: "pro_id=" + proid,
			success: function(data){
			},
			error: function(){}
		});
	}else{
		jQuery.ajax({
			type: "POST",
			url: baseurl + "ajax_add_to_pend_cart",
			data: "pro_id=" + proid,
			success: function(data){
			},
			error: function(){}
		});
	}
}
function goAdvLink($link,$advid,$baseUrl){
	jQuery.ajax({
		type: "POST",
		url: $baseUrl + "ajax_banner",
		data: "banner_id=" + $advid,
		success: function(data){
			window.open($link,'_blank');
		},
		error: function(){}
	});
}
/*********************TopMenu****************************/
var ie_overLap=(jQuery.browser.msie && jQuery.browser.version<7);
(function ($) {
	$.fn.dropDownMenu = function(options) {
        var menus = [];
        var css;
        var tag;
        var internal;
        var timeout;

        var timeoutRoot;
        var mouse_leave = true;

        var settings = $.extend({
            timer: 150,
            parentMO: null,
            childMO: null,
            levels: [],
            parentTag: 'ul',
            childTag: 'ul',
            tags: [],
            numberOfLevels: 3
        }, options || {});

        // Set number of levels
        if (settings.tags.length > 0) {
            settings.numberOfLevels = settings.tags.length;
        } else if (settings.levels.length) {
            settings.numberOfLevels = settings.levels.length;
        }

        // Set css levels with childMO
        if (settings.childMO) {
            for (var i = 0; i < settings.numberOfLevels; i++) settings.levels[i] = settings.childMO;
        }

        // Set tag levels with tag
        if (settings.tags.length < 1) {
            for (var i = 0; i < settings.numberOfLevels; i++) settings.tags[i] = settings.childTag;
        }

        // Run through each level
        menus[0] = $(this).children('li');
        for (var i = 1; i < settings.numberOfLevels + 2; i++) {
            // Tags/CSS
            css = (i == 1) ? settings.parentMO : settings.levels[i - 2];
            tag = (i == 1) ? settings.parentTag : settings.tags[i - 2];

            // level selector
            menus[i] = menus[i - 1].children(settings.tag).children('li');

            // root level
            if (i == 1) {
                menus[i - 1].attr('zindex', i);
            }
            // Action
            menus[i - 1].attr({ rel: css + ';' + tag }).mouseover(function(event) {
                if (timeout) clearTimeout(timeout);
                if (timeoutRoot) clearTimeout(timeoutRoot);

                var $$ = $(this);
                mouse_leave = false;

                var needShow = true;
                if ($$.attr('zindex')) {
                    needShow = false;
                    timeoutRoot = setTimeout(function() {
                        if (mouse_leave) return;
                        internal = $$.attr("rel").split(";");
                        $$.siblings('li').children('a').removeClass(internal[0]).siblings(internal[1]).hide();
                        $$.children('a').addClass(internal[0]).siblings(internal[1]).show();
                        // check show right
                        try{
                            var v = viewport();
                            var aOffset = $$.children('a').offset();
                            var a2 = $$.children('a').addClass(internal[0]).siblings(internal[1]);
                            if (v.x + v.cx < aOffset.left + a2[0].offsetWidth) {
                                a2.css({ left: aOffset.left + $$.children('a')[0].offsetWidth - a2[0].offsetWidth });
                                //a2.css({ left: aOffset.left - (aOffset.left + a2[0].offsetWidth - (v.x + v.cx)) - 20 });
                            } else {
                                a2.css({ left: 'auto' });
                            }
                        }catch(ee){
                        }
                        if (ie_overLap) {
                            var overLapIFrame = $$.siblings('li').children('iframe');
                            if (overLapIFrame) overLapIFrame.css('display', 'none');
                            overLap($$.children('a').next('ul'));
                        }
                    }, 130);
                }
                if (needShow) {
                    internal = $$.attr("rel").split(";");
                    $$.siblings('li').children('a').removeClass(internal[0]).siblings(internal[1]).hide();
                    $$.children('a').addClass(internal[0]).siblings(internal[1]).show();
                    if (ie_overLap) {
                        var overLapIFrame = $$.siblings('li').children('iframe');
                        if (overLapIFrame) overLapIFrame.css('display', 'none');
                        overLap($$.children('a').next('ul'));
                    }
                }
            }).mouseout(function() {
                if (timeoutRoot) clearTimeout(timeoutRoot);
                mouse_leave = true;
                internal = $(this).attr("rel").split(";");
                if (internal[0] == settings.parentMO) {
                    timeout = setTimeout(function() { closemenu(); }, settings.timer);
                }
            });
        }

        // Allows user option to close menus by clicking outside the menu on the body
        $(document).click(function() { closemenu(); });

        // Closes all open menus
        var closemenu = function() {
            if (ie_overLap) $('.iframetop').css({ display: 'none' });
            for (var i = menus.length; i > -1; i--) {
                if (menus[i] && menus[i].attr("rel")) {
                    internal = menus[i].attr("rel").split(";");
                    menus[i].children(internal[1]).hide().siblings('a').removeClass(internal[0]);
                }
            }
            $('a', menus[0]).removeClass(settings.parentMO);
            if (timeout) clearTimeout(timeout);
        }
    };
    function viewport() {
        return {
            x: $(window).scrollLeft(),
            y: $(window).scrollTop(),
            cx: $(window).width(),
            cy: $(window).height()
        };
    }
})(jQuery);

(function($) {
    $.fn.goTo = function() {
        $('html, body').animate({
            scrollTop: $(this).offset().top + 'px'
        }, 'fast');
        return this; // for chaining...
    }
})(jQuery);