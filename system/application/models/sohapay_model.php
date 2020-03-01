<?php

/**
 *	
 *		Phiên bản: 0.1   
 *		Tên lớp: BaoKimPayment
 *		Chức năng: Tích hợp thanh toán qua baokim.vn cho các merchant site có đăng ký API
 *						- Xây dựng URL chuyển thông tin tới baokim.vn để xử lý việc thanh toán cho merchant site.
 *						- Xác thực tính chính xác của thông tin đơn hàng được gửi về từ baokim.vn.
 *		
 */
define('PG_URL_ROOT', 'https://sohapay.com/');
class Sohapay_model extends CI_Model
{

	private $pg_url = 'payment.php';

	// URL query của Soha Payment
	private $pg_url_query = 'payment_query.php';
	
	// URL embed của Soha Payment
	private $pg_url_embed = 'merchant_popup.php';
	
	// Mã merchante site 
	//private $merchant_site_code = 'test';	// Biến này được SohaPay cung cấp cho merchant site
	
	private $merchant_site_code = 'u438120';
	// Mật khẩu bảo mật
	private $secure_secret= '2505729e26b9421a9f36';//'123456789'; // Biến này được SohaPay cung cấp cho merchant site
	function __construct()
	{
        if (!empty($site_code) && !empty($site_secure)){
            $this->merchant_site_code = $site_code;
            $this->secure_secret = $site_secure;
        }
		/*$soha=$this->getSohapay();
		$this->merchant_site_code=$soha[0]->merchant_site_code;
		$this->secure_secret=$soha[0]->secure_secret;*/
        $this->pg_url = PG_URL_ROOT . $this->pg_url;
        $this->pg_url_query = PG_URL_ROOT . $this->pg_url_query;
        $this->pg_url_embed = PG_URL_ROOT . $this->pg_url_embed;	
		parent::__construct();
	}
	
	public function getSohapay(){
		$query	=	"SELECT * FROM tbtt_sohapay WHERE id=1";
		$tempresult=$this->db->query($query); 
		$result=$tempresult->result();
		return $result;
	}
	// URL checkout của baokim.vn
	//private $baokim_url = 'https://www.baokim.vn/payment/customize_payment/order';
	public function buildCheckoutUrl($return_url, $transaction_info, $order_code, $price, $order_email, $order_mobile)
	{
		
		// Mảng các tham số chuyển tới Soha Payment
		$soha=$this->getSohapay();
		$this->merchant_site_code=$soha[0]->merchant_site_code;
		$this->secure_secret=$soha[0]->secure_secret;
				
		$arr_param = array(
			'site_code'			=>	strval($this->merchant_site_code),
			'return_url'		=>	strval($return_url),
			'transaction_info'	=>	strval($transaction_info),
			'order_code'		=>	strval($order_code),
			'price'				=>	strval($price),	
			'order_email'		=>	strval($order_email),
			'order_mobile'		=>	strval($order_mobile),
			'version'			=>  '2'
		);
		
		ksort($arr_param);
		/* Bước 2. Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào*/
		$redirect_url = $this->pg_url;
		if (strpos($redirect_url, '?') === false)
		{
			$redirect_url .= '?';
		}
		else if (substr($redirect_url, strlen($redirect_url)-1, 1) != '?' && strpos($redirect_url, '&') === false)
		{
			// Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
			$redirect_url .= '&';			
		}
				
		/* Bước 3. tạo url*/
		$first = true;
		$secure_code = '';
		foreach ($arr_param as $key=>$value)
		{
			if (strlen($value) == 0) continue;
			
			if ($first == true){
				$redirect_url .= urlencode($key) . '=' . urlencode($value);
				$first = false;
			}
			else
				$redirect_url .= '&' . urlencode($key) . '=' . urlencode($value);
			
			$secure_code .= $key . "=" . $value . "&";
		}
		$secure_code = rtrim($secure_code, "&");
		$soha=$this->getSohapay();
		$this->merchant_site_code=$soha[0]->merchant_site_code;
		$this->secure_secret=$soha[0]->secure_secret;
		if (strlen($secure_code) > 0) {
		    $redirect_url .= "&secure_hash=" . strtoupper(hash_hmac('SHA256', $secure_code, pack('H*',$this->secure_secret)));
		}
		
		return $redirect_url;
	}
	
	/*Hàm thực hiện xác minh tính đúng đắn của các tham số trả về từ Soha Payment*/
	public function verifyReturnUrl()
	{
		$secure_hash = $_GET['secure_code'];
		unset($_GET['secure_code']);
	
		$param['transaction_info']	= $_GET['transaction_info'];
		$param['order_code'] 		= $_GET['order_code'];
		$param['order_email'] 		= $_GET['order_email'];
		$param['order_session'] 	= $_GET['order_session'];
		$param['price'] 			= $_GET['price'];
		$param['site_code'] 		= $_GET['site_code'];
		$param['response_code'] 	= $_GET['response_code'];
		$param['response_message'] 	= $_GET['response_message'];
		$param['payment_type'] 		= $_GET['payment_type'];
		$param['payment_time'] 		= $_GET['payment_time'];
		$param['error_text'] 		= $_GET['error_text'];
	
		ksort($param);
		$md5HashData = '';
	    foreach($param as $key => $value) {
	        if ($key != "secure_code" && strlen($value) > 0) {
	            $md5HashData .= $key . "=" . $value . "&";
	        }
	    }
	    $md5HashData = rtrim($md5HashData, "&");
		$soha=$this->getSohapay();
		$this->merchant_site_code=$soha[0]->merchant_site_code;
		$this->secure_secret=$soha[0]->secure_secret;
	    if (strtoupper($secure_hash) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$this->secure_secret)))) {
	        return TRUE;
	    } else {
	        return FALSE;
	    }
	}
	
	//Hàm xây dựng url, trong đó có tham số mã hóa (còn gọi là public key)
	public function buildEmbedUrl($inputParam = array())
	{
		
		// Mảng các tham số chuyển tới Soha Payment
    	$crURL = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$soha=$this->getSohapay();
		$this->merchant_site_code=$soha[0]->merchant_site_code;
		$this->secure_secret=$soha[0]->secure_secret;
		$arr_param = array(
			'site_code'			=>	strval($this->merchant_site_code),
			'return_url'		=>	isset($inputParam['return_url'])?strval($inputParam['return_url']):$crURL,
			'transaction_info'	=>	isset($inputParam['transaction_info'])?strval($inputParam['transaction_info']):'',
			'order_code'		=>	isset($inputParam['order_code'])?strval($inputParam['order_code']):time().'_'.$this->randomcode(8),
			'price'				=>	isset($inputParam['price'])?strval($inputParam['price']):0,
			'order_email'		=>	isset($inputParam['order_email'])?strval($inputParam['order_email']):'',
			'order_mobile'		=>	isset($inputParam['order_mobile'])?strval($inputParam['order_mobile']):'',
			'order_product_title'	=>  isset($inputParam['order_product_title'])?strval($inputParam['order_product_title']):'Giao dịch thanh toán tiền',
			'order_product_id'	=>  isset($inputParam['order_product_id'])?intval($inputParam['order_product_id']):0,
			'order_product_unit'=>  isset($inputParam['order_product_unit'])?strval($inputParam['order_product_unit']):'sản phẩm',
			'order_number_total'=>  isset($inputParam['order_number_total'])?intval($inputParam['order_number_total']):10,
			'order_number_max'	=>  isset($inputParam['order_number_max'])?intval($inputParam['order_number_max']):10,
			'order_number_min'	=>  isset($inputParam['order_number_min'])?intval($inputParam['order_number_min']):1,
			'order_ship'		=>  isset($inputParam['order_ship'])?intval($inputParam['order_ship']):0,
			'order_ship_fee'	=>  isset($inputParam['order_ship_fee'])?intval($inputParam['order_ship_fee']):0,
			'order_ship_type'	=>  isset($inputParam['order_ship_type'])?intval($inputParam['order_ship_type']):3,
			'order_cod_fee'		=>  isset($inputParam['order_cod_fee'])?intval($inputParam['order_cod_fee']):0,
			'order_cod_type'	=>  isset($inputParam['order_cod_type'])?intval($inputParam['order_cod_type']):1,
			'payment_type'		=> 	isset($inputParam['payment_type'])?strval($inputParam['payment_type']):'|1|',
			'embed_type'		=> 	isset($inputParam['embed_type'])?strval($inputParam['embed_type']):'popup',
			'version'			=>  '2'
		);
		
		ksort($arr_param);

		/* Bước 2. Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào*/
		$redirect_url = $this->pg_url_embed;
		if (strpos($redirect_url, '?') === false)
		{
			$redirect_url .= '?';
		}
		else if (substr($redirect_url, strlen($redirect_url)-1, 1) != '?' && strpos($redirect_url, '&') === false)
		{
			// Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
			$redirect_url .= '&';			
		}
				
		/* Bước 3. tạo url*/
		$first = true;
		$secure_code = '';
		foreach ($arr_param as $key=>$value)
		{
			if (strlen($value) == 0) continue;
			
			if ($first == true){
				$redirect_url .= urlencode($key) . '=' . urlencode($value);
				$first = false;
			}
			else
				$redirect_url .= '&' . urlencode($key) . '=' . urlencode($value);
			
			$secure_code .= $key . "=" . $value . "&";
		}
		$secure_code = rtrim($secure_code, "&");
		$soha=$this->getSohapay();
		$this->merchant_site_code=$soha[0]->merchant_site_code;
		$this->secure_secret=$soha[0]->secure_secret;
		if (strlen($secure_code) > 0) {
		    $redirect_url .= "&secure_hash=" . strtoupper(hash_hmac('SHA256', $secure_code, pack('H*',$this->secure_secret)));
		}
		
		return $redirect_url;
	}
	  
	/* Hàm xây dựng mã nhúng */
	public function buildEmbedHTML($params=array()){
	   	$url = $this->buildEmbedUrl($params);
	    return sprintf('<a class="mcpBtn" href="%s"><img src="%simages/btn/muangay_sohapay_blue.png" style="margin:3px 0; border: none;" /></a>', $url, PG_URL_ROOT);
	}
	  
	/**
	 * Cap nhat trang thai don hang pending sau khi timeout
	 * @param string $order_code
	 * @param string $command 
	 * 			query: thanh toan bang the Quoc te hoac the Noi dia
	 * 			queryMobileCard: thanh toan bang the cao dien thoai
	 * @return string
	 */
	public function queryOrderStatus($order_code, $command='query'){
		// Mảng các tham số chuyển tới Soha Payment
		$soha=$this->getSohapay();
		$this->merchant_site_code=$soha[0]->merchant_site_code;
		$this->secure_secret=$soha[0]->secure_secret;
		$arr_param = array(
			'site_code'			=>	strval($this->merchant_site_code),
			'order_code'		=>	strval($order_code),
			'command'			=>	$command,
			'version'			=>  '2'
		);
		
		ksort($arr_param);
		/* Bước 2. Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào*/
		$query_url = $this->pg_url_query;
		if (strpos($query_url, '?') === false)
		{
			$query_url .= '?';
		}
		else if (substr($query_url, strlen($query_url)-1, 1) != '?' && strpos($query_url, '&') === false)
		{
			// Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
			$query_url .= '&';			
		}

		/* Bước 3. tạo url*/
		$first = true;
		$secure_code = '';
		foreach ($arr_param as $key=>$value)
		{
			if (strlen($value) == 0) continue;
			
			if ($first == true){
				$query_url .= urlencode($key) . '=' . urlencode($value);
				$first = false;
			}
			else
				$query_url .= '&' . urlencode($key) . '=' . urlencode($value);
			
			$secure_code .= $key . "=" . $value . "&";
		}
		$secure_code = rtrim($secure_code, "&");
		$soha=$this->getSohapay();
		$this->merchant_site_code=$soha[0]->merchant_site_code;
		$this->secure_secret=$soha[0]->secure_secret;
		if (strlen($secure_code) > 0) {
		    $query_url .= "&secure_hash=" . strtoupper(hash_hmac('SHA256', $secure_code, pack('H*',$this->secure_secret)));
		}
		
		ob_start();
	
		// initialise Client URL object
		$ch = curl_init();
		
		// set the URL of the VPC
		curl_setopt ($ch, CURLOPT_URL, $query_url);
		curl_setopt ($ch, CURLOPT_POST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_exec ($ch);
	
		// get response
		$response = ob_get_contents();
		
		// turn output buffering off.
		ob_end_clean();
		
		// close client URL
		curl_close ($ch);

		$map = array();

	    $pairArray = explode("&", $response);
	    foreach ($pairArray as $pair) {
	        $param = explode("=", $pair);
	        $map[urldecode($param[0])] = urldecode($param[1]);
	    }
	    
	    $map['shp_payment_response_description'] = '';
	    if ($map['shp_payment_type']==1) $map['shp_payment_response_description'] = $this->getResponseDescriptionInternational($map['shp_payment_response_code']);
	    else if ($map['shp_payment_type']==2) $map['shp_payment_response_description'] = $this->getResponseDescriptionDomestic($map['shp_payment_response_code']);
	    else if ($map['shp_payment_type']==3) $map['shp_payment_response_description'] = $this->getResponseDescriptionMobileCard($map['shp_payment_response_code']);
	    
	    return $map;
	}
	

	public function doChargeCard($card_code, $card_type, $transaction_info, $order_code, $order_email, $order_mobile, $card_seri=''){
		// Mảng các tham số chuyển tới Soha Payment
		$soha=$this->getSohapay();
		$this->merchant_site_code=$soha[0]->merchant_site_code;
		$this->secure_secret=$soha[0]->secure_secret;
		$arr_param = array(
			'site_code'			=>	strval($this->merchant_site_code),
			'card_code'			=>	strval($card_code),
			'card_seri'			=>	strval($card_seri),
			'card_type'			=>	strval($card_type), // vinaphone or mobifone
			'transaction_info'	=>	strval($transaction_info),
			'order_code'		=>	strval($order_code),
			'order_email'		=>	strval($order_email),
			'order_mobile'		=>	strval($order_mobile),
			'command'			=>	'doChargeMobileCard',
			'version'			=>  '2'
		);
		
		ksort($arr_param);
		/* Bước 2. Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào*/
		$query_url = $this->pg_url_query;
		if (strpos($query_url, '?') === false)
		{
			$query_url .= '?';
		}
		else if (substr($query_url, strlen($query_url)-1, 1) != '?' && strpos($query_url, '&') === false)
		{
			// Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
			$query_url .= '&';			
		}
				
		/* Bước 3. tạo url*/
		$first = true;
		$secure_code = '';
		foreach ($arr_param as $key=>$value)
		{
			if (strlen($value) == 0) continue;
			
			if ($first == true){
				$query_url .= urlencode($key) . '=' . urlencode($value);
				$first = false;
			}
			else
				$query_url .= '&' . urlencode($key) . '=' . urlencode($value);
			
			$secure_code .= $key . "=" . $value . "&";
		}
		$secure_code = rtrim($secure_code, "&");
		$soha=$this->getSohapay();
		$this->merchant_site_code=$soha[0]->merchant_site_code;
		$this->secure_secret=$soha[0]->secure_secret;
		if (strlen($secure_code) > 0) {
		    $query_url .= "&secure_hash=" . strtoupper(hash_hmac('SHA256', $secure_code, pack('H*',$this->secure_secret)));
		}
		
		ob_start();
	
		// initialise Client URL object
		$ch = curl_init();
	
		// set the URL of the VPC
		curl_setopt ($ch, CURLOPT_URL, $query_url);
		curl_setopt ($ch, CURLOPT_POST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_exec ($ch);
	
		// get response
		$response = ob_get_contents();
		
		// turn output buffering off.
		ob_end_clean();
		
		// close client URL
		curl_close ($ch);

		$map = array();
		$response = substr($response, 1);

	    $pairArray = explode("&", $response);
	    foreach ($pairArray as $pair) {
	        $param = explode("=", $pair);
	        $map[urldecode($param[0])] = urldecode($param[1]);
	    }
	    
	    $map['shp_payment_response_description'] = $this->getResponseDescriptionMobileCard($map['response_code']);
	    
	    return $map;
	}
	
	public function getResponseDescriptionInternational($responseCode) {
	    switch ($responseCode) {
	        case "0" : $result = "Giao dịch thành công"; break;
	        case "?" : $result = "Tình trạng giao dịch không xác định"; break;
	        case "1" : $result = "Lỗi không xác định"; break;
	        case "2" : $result = "Ngân hàng từ tối giao dịch"; break;
	        case "3" : $result = "Không có trả lời từ Ngân hàng"; break;
	        case "4" : $result = "Thẻ hết hạn"; break;
	        case "5" : $result = "Số dư không đủ để thanh toán"; break;
	        case "6" : $result = "Lỗi giao tiếp với Ngân hàng"; break;
	        case "7" : $result = "Lỗi Hệ thống máy chủ Thanh toán"; break;
	        case "8" : $result = "Loại giao dịch không được hỗ trợ"; break;
	        case "9" : $result = "Ngân hàng từ chối giao dịch (không liên hệ với Ngân hàng)"; break;
	        case "A" : $result = "giao dịch Aborted"; break;
	        case "B" : $result = "Bị chặn do có rủi ro giả mạo"; break;
	        case "C" : $result = "giao dịch bị hủy bỏ"; break;
	        case "D" : $result = "giao dịch hoãn lại đã được nhận và đang chờ xử lý"; break;
	        case "E" : $result = "Referred"; break;
	        case "F" : $result = "3D Secure xác thực không thành công"; break;
	        case "I" : $result = "Card Security Code xác minh không thành công"; break;
	        case "L" : $result = "Mua sắm giao dịch đã bị khoá (Xin vui lòng thử lại sau giao dịch)"; break;
	        case "N" : $result = "Chủ thẻ không ghi danh vào chương trình xác thực"; break;
	        case "P" : $result = "giao dịch đã được nhận bởi các Adaptor Thanh toán và đang được xử lý"; break;
	        case "R" : $result = "giao dịch đã không được xử lý - Đã đạt đến giới hạn của những cố gắng thử lại cho phép"; break;
	        case "S" : $result = "SessionID bị trùng (OrderInfo)"; break;
	        case "T" : $result = "Địa chỉ xác minh không đúng"; break;
	        case "U" : $result = "Card Security Code không đúng"; break;
	        case "V" : $result = "Địa chỉ xác minh và Card Security Code không đúng"; break;
	        case "9999": $result = "Giao dịch có rủi ro giả mạo";break;
	        case "9998": $result = "Giao dịch có rủi ro giả mạo, cần xác thực chủ thẻ";break;
	        case "PG": $result = "Không tồn tại giao dịch trên hệ thống";break;
	        default  : $result = "Không thể xác định"; 
	    }
	    return $result;
	}
	
	public function getResponseDescriptionDomestic($responseCode){
		switch ($responseCode) {
	        case "0" : $result = "Giao dịch thành công"; break;
	        case "1" : $result = "Ngân hàng từ chối giao dịch"; break;
	        case "3" : $result = "Mã đơn vị không tồn tại"; break;
	        case "4" : $result = "Không đúng access code"; break;
	        case "5" : $result = "Số tiền không hợp lệ"; break;
	        case "6" : $result = "Mã tiền tệ không tồn tại"; break;
	        case "7" : $result = "Lỗi không xác định"; break;
	        case "8" : $result = "Số thẻ không đúng"; break;
	        case "9" : $result = "Tên chủ thẻ không đúng"; break;
	        case "10" : $result = "Thẻ hết hạn/Thẻ bị khóa"; break;
	        case "11" : $result = "Thẻ chưa đăng ký sử dụng dịch vụ thanh toán trực tuyến."; break;
	        case "12" : $result = "Ngày phát hành/Hết hạn không đúng"; break;
	        case "13" : $result = "Vượt quá hạn mức thanh toán"; break;
	        case "21" : $result = "Số dư không đủ để thanh toán"; break;
	        case "99" : $result = "Người sử dụng hủy giao dịch"; break;
	        case "100" : $result = "Không nhập thông tin thẻ/ Hủy giao dịch thanh toán"; break;
	        case "PG": $result = "Không tồn tại giao dịch trên hệ thống";break;
	        default  : $result = "Không thể xác định";
		}
		return $result;
	}
	
	public function getResponseDescriptionMobileCard($responseCode){
		switch ($responseCode) {
	        case "1" : $result = "Giao dịch thành công"; break;
	        case "-1" : $result = "Thẻ đã sử dụng"; break;
	        case "-2" : $result = "Thẻ đã khoá"; break;
	        case "-3" : $result = "Thẻ đã hết hạn sử dụng"; break;
	        case "-4" : $result = "Thẻ chưa kích hoạt"; break;
	        case "-10" : $result = "Mã thẻ không hợp lệ"; break;
	        case "-11" : $result = "Mã thẻ không hợp lệ"; break;
	        case "-12" : $result = "Thẻ không tồn tại"; break;
	        case "-99" : $result = "Lỗi hệ thống"; break;
	        case "0" : $result = "Lỗi khác"; break;
	        case "2" : $result = "Không login sử dụng các hàm charge"; break;
	        case "3" : $result = "Lỗi hệ thống của VDCO"; break;
	        case "4" : $result = "Thẻ không sử dụng được (lỗi chung cho Vinaphone)"; break;
	        case "5" : $result = "Thực hiện sai 5 lần liên tiếp"; break;
	        case "6" : $result = "Thực hiện lệnh logout không thành công"; break;
	        case "8" : $result = "Charge thẻ bị lỗi hệ thống. Lỗi này cần kiểm soát và đối soát"; break;
	        case "9" : $result = "Thông tin partner không đúng"; break;
	        case "10" : $result = "Sai format thông tin email hoặc mobile"; break;
	        default  : $result = "Không thể xác định";
		}
		return $result;
	}
	
	function randomcode($len=8)
	{
		$code = $lchar = NULL;
		for( $i=0; $i<$len; $i++ )
	  	{
		  	$char = chr(rand(48,122));
		  	while( !ereg("[0-9]", $char) )
	    	{
			    if( $char == $lchar ) continue;
			    $char = chr(rand(48,90));
		  	}
		  	$code .= $char;
		  	$lchar = $char;
		}
		return $code;
	}
}