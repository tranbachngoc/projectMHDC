<?php
require_once('fibosmsconfig.php'); // Khai báo dùng hàm của Fibo 
CheckRequest();  			//Hàm kiểm tra request, đảm bảo yêu cầu xử lý đến từ server của Fibo
// Lấy nội dung tin nhắn
$message =$_REQUEST['message']; // Nội dung tin
$phone= $_REQUEST['phone']; // số điện thoại của KH
$service=$_REQUEST['service']; // mã dịch vụ
$port =$_REQUEST['port'];  // đầu số
$main =$_REQUEST['main'];  //keyword
$sub =$_REQUEST['sub'];  // prefix
// Hết lấy nội dung tin nhắn

$md5id = md5(uniqid(rand(), true));// id duy nhất để gán cho tin trả về
if($port!='8077' && $port!='8177' && $port!='8277' && $port!='8377' && $port!='8477' && $port!='8577' && $port!='8677'&& $port!='8777')// kiểm tra xem có đúng đầu số không?
{
	// trường hợp nhắn sai đầu số
	echo '
			<ClientResponse>
				<Message>
					<PhoneNumber>'.$phone.'</PhoneNumber>
					<Message>Ban da nhan sai dau so, cac dau so lien quan den dich vu cua www.quahandmade.com la 8077,8177,8277,8377,8477,8577,8677,8777</Message>
					<SMSID>'.$md5id.'</SMSID>
					<ServiceNo>'.$service.'</ServiceNo>
				</Message>
			</ClientResponse>';
	
}
else // xử lý tin
{

//ket noi database
$dbname = 'sieuthiphang';
$link = mysql_connect("localhost","sieuthiphang","sieuthiphang") or die("Couldn't make connection.");
$db = mysql_select_db($dbname, $link) or die("Couldn't select database");
$tmp=explode(" ",$message);   
//define('port7',); 
	//Kiểm tra tin nhắn có đúng cú pháp không
	if(@$tmp[1]!=NULL)
	 {
		  //Ok, KH đã nhắn đúng cú pháp, tiến hành xử lý tiếp
		 //Kết nối vào CSDL
		 //Xác định xem userid có tồn tại không
		 switch($port){
			 case '8077': 
				$result = mysql_query("SELECT * FROM tbtt_ads where ads_id='$tmp[1]'");
				$duplicates = mysql_num_rows($result);
				if($duplicates == 0){
					 //Hồi báo khi userid không tồn tại 
					echo '<ClientResponse>
						<Message>
							<PhoneNumber>'.$phone.'</PhoneNumber>
							<Message>Cam on ban da ung ho www.quahandmade.com. Nhung ma tin rao vat '.$tmp[1].' khong ton tai!</Message>
							<SMSID> -1</SMSID>
							<ServiceNo>'.$service.'</ServiceNo>
						</Message>
						</ClientResponse>';  
				}
				else{				
					mysql_query("UPDATE tbtt_ads SET  up_date=now() WHERE ads_id =$tmp[1]") or die(mysql_error());
					echo '<ClientResponse>
							<Message>
							   <PhoneNumber>'.$phone.'</PhoneNumber>
							   <Message>Ban da up tin co ma so '.$tmp[1].' thanh cong</Message>
							   <SMSID> -1</SMSID>
							   <ServiceNo>'.$service.'</ServiceNo>
							</Message>
							</ClientResponse>';  
					
				}
				break;
			 
			 case '8177':			 
				 $result = mysql_query("SELECT * FROM tbtt_product where pro_id='$tmp[1]'");
				 $duplicates = mysql_num_rows($result);
				 if($duplicates == 0){
					 //Hồi báo khi userid không tồn tại 
					echo '<ClientResponse>
						<Message>
							<PhoneNumber>'.$phone.'</PhoneNumber>
							<Message>Cam on ban da ung ho www.quahandmade.com. Nhung ma tin '.$tmp[1].' khong ton tai!</Message>
							<SMSID> -1</SMSID>
							<ServiceNo>'.$service.'</ServiceNo>
						</Message>
						</ClientResponse>';  
				 }else{					
					mysql_query("UPDATE tbtt_product SET  up_date=now() WHERE pro_id =$tmp[1]") or die(mysql_error());
					echo '<ClientResponse>
							<Message>
							   <PhoneNumber>'.$phone.'</PhoneNumber>
							   <Message>Ban da up tin co ma so '.$tmp[1].' thanh cong</Message>
							   <SMSID> -1</SMSID>
							   <ServiceNo>'.$service.'</ServiceNo>
							</Message>
							</ClientResponse>';  				
				}
				break;
				
			case '8377':
				if($tmp[1]=='NAP'){
					$result = mysql_query("SELECT use_id FROM tbtt_user where use_username ='$tmp[2]'");
					$userObject=mysql_fetch_object($result);
					$duplicates = mysql_num_rows($result);
					if($duplicates == 0){
						 //Hồi báo khi userid không tồn tại 
						echo '<ClientResponse>
							<Message>
								<PhoneNumber>'.$phone.'</PhoneNumber>
								<Message>Cam on ban da ung ho www.quahandmade.com. Nhung thanh vien nay '.$tmp[1].' khong ton tai!</Message>
								<SMSID> -1</SMSID>
								<ServiceNo>'.$service.'</ServiceNo>
							</Message>
							</ClientResponse>';  
					}
					else{	
						if($userObject->use_id>0){
							mysql_query("UPDATE tbtt_account_thongkegiaodich SET sho_status = 1 WHERE sho_user=".$userObject->use_id) or die(mysql_error());
							echo '<ClientResponse>
									<Message>
									   <PhoneNumber>'.$phone.'</PhoneNumber>
									   <Message>Ban da nap '.$tmp[1].' thanh cong</Message>
									   <SMSID> -1</SMSID>
									   <ServiceNo>'.$service.'</ServiceNo>
									</Message>
									</ClientResponse>'; 
						}
						
					}
					
				}
				
				break;
			
			case '8477':
				$result = mysql_query("SELECT use_id FROM tbtt_user where use_username ='$tmp[1]'");
				$userObject=mysql_fetch_object($result);
				$duplicates = mysql_num_rows($result);
				if($duplicates == 0){
					 //Hồi báo khi userid không tồn tại 
					echo '<ClientResponse>
						<Message>
							<PhoneNumber>'.$phone.'</PhoneNumber>
							<Message>Cam on ban da ung ho www.quahandmade.com. Nhung gian hang '.$tmp[1].' khong ton tai!</Message>
							<SMSID> -1</SMSID>
							<ServiceNo>'.$service.'</ServiceNo>
						</Message>
						</ClientResponse>';  
				}
				else{	
					if($userObject->use_id>0){
						mysql_query("UPDATE tbtt_shop SET sho_status = 1 WHERE sho_user=".$userObject->use_id) or die(mysql_error());
						echo '<ClientResponse>
								<Message>
								   <PhoneNumber>'.$phone.'</PhoneNumber>
								   <Message>Ban da nang cap gian hang '.$tmp[1].' thanh cong</Message>
								   <SMSID> -1</SMSID>
								   <ServiceNo>'.$service.'</ServiceNo>
								</Message>
								</ClientResponse>'; 
					}
					
				}
				break;
			default:			
				echo '<ClientResponse>
				<Message>
				   <PhoneNumber>'.$phone.'</PhoneNumber>
				   <Message>Tin nhan sai cu phap, soan SW Username hoac SW NAP Username gui '.$port.' nhe! Xin vui long lien he voi chung toi neu gap bat ky van de gi.</Message>
				   <SMSID>-1/SMSID>
				   <ServiceNo>'.$service.'</ServiceNo>
				</Message>
				</ClientResponse>';	
				break;
		 	 
		 }				 
		 
	 }else{
		 //Khách hàng không nhắn đúng cú pháp, trả về tin nhắn báo lỗi!
			echo '<ClientResponse>
			<Message>
			   <PhoneNumber>'.$phone.'</PhoneNumber>
			   <Message>Tin nhan sai cu phap, soan SW Username hoac SW NAP Username gui '.$port.' nhe! Xin vui long lien he voi chung toi neu gap bat ky van de gi.</Message>
			   <SMSID>-1/SMSID>
			   <ServiceNo>'.$service.'</ServiceNo>
			</Message>
			</ClientResponse>';
	 }

}
?>
