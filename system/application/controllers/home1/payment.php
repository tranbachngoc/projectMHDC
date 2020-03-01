<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Payment extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		#CHECK SETTING
		if((int)settingStopSite == 1)
		{
            $this->lang->load('home/common');
			show_error($this->lang->line('stop_site_main'));
			die();
		}
		#END CHECK SETTING
		#Load language
		$this->lang->load('home/common');
		$this->lang->load('home/payment');
		#Load model
		$this->load->model('showcart_model');
		$this->load->model('product_model');
		#BEGIN: Update counter
		if(!$this->session->userdata('sessionUpdateCounter'))
		{
			$this->counter_model->update();
			$this->session->set_userdata('sessionUpdateCounter', 1);
		}
		#END Update counter
		#BEGIN Eye
		if($this->session->userdata('sessionUser')>0){
			$this->load->model('eye_model');			
			$data['listeyeproduct']=$this->eye_model->geteyetype('product',$this->session->userdata('sessionUser'));		
			$data['listeyeraovat']=$this->eye_model->geteyetype('raovat',$this->session->userdata('sessionUser'));
			$data['listeyehoidap']=$this->eye_model->geteyetype('hoidap',$this->session->userdata('sessionUser'));
						
		}else{
			array_values($this->session->userdata['arrayEyeSanpham']);
			array_values($this->session->userdata['arrayEyeRaovat']);
			array_values($this->session->userdata['arrayEyeHoidap']);
			$this->load->model('eye_model');
			$data['listeyeproduct']=$this->eye_model->geteyetypenologin('product');			
			$data['listeyeraovat']=$this->eye_model->geteyetypenologin('raovat');
			$data['listeyehoidap']=$this->eye_model->geteyetypenologin('hoidap');
		}
		#END Eye
		#BEGIN: Ads & Notify Taskbar
		$this->load->model('ads_model');
		$this->load->model('notify_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)settingAdsNew_Home);
		$data['adsTaskbarGlobal'] = $adsTaskbar;
		$notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
		$data['notifyTaskbarGlobal'] = $notifyTaskbar;
		
		$this->load->vars($data);
		#END Ads & Notify Taskbar
		
	}
	
	
	function checkWallet($user_id){
		$localhost=settingLocalhost;
		$username=settingUsername;
		$password=settingPassword;
		$dbname=settingDatabase;
		$link = mysql_connect($localhost, $username, $password);
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db($dbname, $link);
		
		$query	=	"SELECT *    
		FROM jos_sbh_thongkehoahong
		WHERE user_id = ".$user_id." AND ispay=0";
		$result = mysql_query($query);
		$listCommission = array();
		while ($row = mysql_fetch_object($result)) {
			$listCommission[]=$row;
		}
		return $listCommission;		
	
	}
	
	function index()
	{	
		$id = (int)$this->uri->segment(2);
		// Save custommer info into session
		if($id == 1){
		
			$userdata = array(
			'shc_buyer_name'	=> $this->input->post('ord_name'),
			'shc_buyer_address'	=> $this->input->post('ord_address'),
			'shc_buyer_email'	=> $this->input->post('ord_email'),
			'shc_buyer_phone'	=> $this->input->post('ord_phone'),
			'shc_buyer_phone1'	=> $this->input->post('ord_mobile'),
			'shc_buyer_fax'		=> $this->input->post('ord_fax'),
			'shc_buyer_note'	=> $this->input->post('ord_otherinfo'),

			'shc_receiver_name'		=> $this->input->post('ord_sname'),
			'shc_receiver_address'	=> $this->input->post('ord_saddress'),
			'shc_receiver_email'	=> $this->input->post('ord_semail'),
			'shc_receiver_phone'	=> $this->input->post('ord_sphone'),
			'shc_receiver_phone1'	=> $this->input->post('ord_smobile'),
			'shc_receiver_fax'		=> $this->input->post('ord_sfax'),
			'shc_receiver_note'		=> $this->input->post('ord_sotherinfo')
			
			);
			$data['step'] = 2;
			$this->session->set_userdata($userdata);
		
		}
		
		
		
		
		
		
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Delete & add
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
			$listProductShowcart = explode(',', trim($this->session->userdata('sessionProductShowcart'), ','));
			$productShowcartOne = $this->input->post('checkone');
			$newProductShowcart = array();
			foreach($listProductShowcart as $listProductShowcartArray)
			{
				$isDelete = false;
				for($i = 0; $i < count($productShowcartOne); $i++)
				{
					if($listProductShowcartArray == $productShowcartOne[$i])
					{
                        $isDelete = true;
                        break;
					}
				}
				if($isDelete == false)
				{
                    $newProductShowcart[] = $listProductShowcartArray;
				}
			}
			
			$this->session->set_userdata('sessionProductShowcart', implode(',', $newProductShowcart));
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		elseif($this->input->post('QuantityShowcart') && is_array($this->input->post('QuantityShowcart')) && count($this->input->post('QuantityShowcart')) > 0 && $this->input->post('IdProductShowcart') && is_array($this->input->post('IdProductShowcart')) && count($this->input->post('IdProductShowcart')) == count($this->input->post('QuantityShowcart')) && count($this->input->post('IdProductShowcart')) <= settingOtherShowcart && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost)
		{
            #BEGIN: CHECK LOGIN
			if(!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
			{
				redirect(base_url().'login', 'location');
				die();
			}
			#END CHECK LOGIN
			
		
			
			
			$idProductShowcart = $this->input->post('IdProductShowcart');
			$quantityShowcart = $this->input->post('QuantityShowcart');
			$numberNewProductAddedShowcart = 0;
			$numberUpdateProductAddedShowcart = 0;
			for($i = 0; $i < count($idProductShowcart); $i++)
			{
				$productAddCart = $this->product_model->get("pro_user, pro_buy", "pro_id = ".(int)$idProductShowcart[$i]." AND pro_user != ".(int)$this->session->userdata('sessionUser')." AND pro_status = 1 AND pro_enddate >= $currentDate");
				if(count($productAddCart) == 1 && (int)$quantityShowcart[$i] > 0 && $this->check->is_id($idProductShowcart[$i]))
				{
					$productInCart = $this->showcart_model->get("shc_id, shc_quantity", "shc_product = ".(int)$idProductShowcart[$i]." AND shc_buyer = ".(int)$this->session->userdata('sessionUser')." AND shc_buydate = $currentDate");
					if(count($productInCart) == 1)
					{
						if($this->showcart_model->update(array('shc_quantity'=>(int)$productInCart->shc_quantity + (int)$quantityShowcart[$i]), "shc_id = ".$productInCart->shc_id))
						{
							#Update pro_buy
							$this->product_model->update(array('pro_buy'=>$productAddCart->pro_buy + 1), "pro_id = ".(int)$idProductShowcart[$i]);
                            $numberUpdateProductAddedShowcart++;
						}
					}
					else
					{
						$dataAdd = array(
						                    'shc_product'       =>      (int)$idProductShowcart[$i],
						                    'shc_quantity'      =>      (int)$quantityShowcart[$i],
						                    'shc_saler'         =>      (int)$productAddCart->pro_user,
						                    'shc_buyer'         =>      (int)$this->session->userdata('sessionUser'),
						                    'shc_buydate'       =>      $currentDate,
						                    'shc_process'       =>      0,
						                    'shc_status'        =>      1
											);
						if($this->showcart_model->add($dataAdd))
						{
                            #Update pro_buy
                            $this->product_model->update(array('pro_buy'=>$productAddCart->pro_buy + 1), "pro_id = ".(int)$idProductShowcart[$i]);
							$numberNewProductAddedShowcart++;
						}
					}
				}
			}
			if($numberNewProductAddedShowcart > 0 || $numberUpdateProductAddedShowcart > 0)
			{
                $this->session->unset_userdata('sessionProductShowcart');
				$this->session->set_flashdata('sessionSuccessAddShowcart', $numberNewProductAddedShowcart.$this->lang->line('success_add_product_showcart_defaults').'\n'.$numberUpdateProductAddedShowcart.$this->lang->line('success_update_product_showcart_defaults'));
			}
			$this->session->set_userdata('sessionTimePosted', time());
			redirect(base_url().'account/showcart', 'location');
		}
		#END Delete & add
		#BEGIN: Add in showcart
		$data['fullProductShowcart'] = false;
		if($this->session->flashdata('sessionFullProductShowcart'))
		{
            $data['fullProductShowcart'] = true;
		}
		if($this->input->post('product_showcart') && $this->check->is_id($this->input->post('product_showcart')))
		{
			if(!$this->_is_exist_product_showcart((int)$this->input->post('product_showcart')))
			{
				if(count(explode(',', trim($this->session->userdata('sessionProductShowcart'), ','))) < settingOtherShowcart)
				{
					$product = $this->product_model->get("pro_id", "pro_id = ".(int)$this->input->post('product_showcart')." AND pro_status = 1 AND pro_enddate >= $currentDate");
					if(count($product) == 1)
					{
						if(!$this->session->userdata('sessionProductShowcart') || trim(trim($this->session->userdata('sessionProductShowcart'), ',')) == '')
						{
		                    $this->session->set_userdata('sessionProductShowcart', (int)$this->input->post('product_showcart'));
						}
						else
						{
		                    $this->session->set_userdata('sessionProductShowcart', $this->session->userdata('sessionProductShowcart').','.(int)$this->input->post('product_showcart'));
						}
					}
				}
				else
				{
					$this->session->set_flashdata('sessionFullProductShowcart', 1);
				}
			}
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Add in showcart
		$data['isLogined'] = false;
        if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
			$data['isLogined'] = true;
		}
		#BEGIN: Menu
		$data['menuSelected'] = 0;
		$data['menuType'] = 'product';
		$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'showcart';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        #BEGIN: Top product saleoff right
		$select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
		$start = 0;
  		$limit = (int)settingProductSaleoff_Top;
		$data['topSaleoffProduct'] = $this->product_model->fetch($select, "pro_saleoff = 1 AND pro_status = 1 AND pro_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top product saleoff right
        #BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
        #Define url for $getVar
		$action = array('sort', 'by');
		$getVar = $this->uri->uri_to_assoc(2, $action);
		#BEGIN: Sort
		if($this->session->userdata('sessionProductShowcart') && trim(trim($this->session->userdata('sessionProductShowcart'), ',')) != '')
		{
			$idProduct = trim($this->session->userdata('sessionProductShowcart'), ',');
			$where = "pro_id IN($idProduct) AND pro_status = 1 AND pro_enddate >= $currentDate";
			$sort = '';
			$by = '';
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'name':
					    $sort .= "pro_name";
					    break;
	                case 'cost':
					    $sort .= "pro_cost";
					    break;
					default:
					    $sort .= "pro_id";
				}
				if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
				{
					$by .= "DESC";
				}
				else
				{
					$by .= "ASC";
				}
			}
			#END Sort
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'showcart/sort/';
			#END Create link sort
			#Fetch record
			$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff";
			$start = 0;
			$limit = settingOtherShowcart;
			$data['productShowcart'] = $this->product_model->fetch($select, $where, $sort, $by, $start, $limit);
			for($i=0;$i<count($data['productShowcart']);$i++){
				if($data['productShowcart'][$i]->pro_saleoff==1){
					if($data['productShowcart'][$i]->pro_saleoff_value>0){
						if($data['productShowcart'][$i]->pro_type_saleoff==1){
							$data['productShowcart'][$i]->pro_cost=$data['productShowcart'][$i]->pro_cost - round(($data['productShowcart'][$i]->pro_cost * $data['productShowcart'][$i]->pro_saleoff_value)/100);	
						}else{
							$data['productShowcart'][$i]->pro_cost=$data['productShowcart'][$i]->pro_cost - $data['productShowcart'][$i]->pro_saleoff_value;
						}
					}
					
				}
					
			}
		}
		#Load view
		$this->load->view('home/payment/defaults', $data);
	}
	
	function _is_exist_product_showcart($product)
	{
		$productShowcart = explode(',', $this->session->userdata('sessionProductShowcart'));
		foreach($productShowcart as $productShowcartArray)
		{
			if($productShowcartArray == $product)
			{
				return true;
			}
		}
		return false;
	}
	function create_showcart($order_id,$product){
		$this->load->model('showcart_model');
		$this->load->model('product_model');
		$dataAdd = array(
							'shc_product'       =>      (int)$product->pro_id,
							'shc_quantity'      =>      1,
							'shc_saler'         =>      (int)$product->pro_user,
							'shc_buyer'         =>      (int)$this->session->userdata('sessionUser'),
							'shc_buydate'       =>      $order_id,
							'shc_process'       =>      0,
							'shc_orderid'       =>      $order_id,
							'shc_status'        =>      1
							);
		if($this->showcart_model->add($dataAdd))
		{
			#Update pro_buy
			$this->product_model->update(array('pro_buy'=>$product->pro_buy + 1), "pro_id = ".(int)$product->pro_id);
		}
	}
	function order_now(){
		//header ('Content-type: text/html; charset=utf-8');
		$pro_id = $this->uri->segment(3);
		$this->load->model('product_model');
		$this->load->model('baokim_model');
		$this->load->model('order_model');
		if($this->session->userdata('sessionUser')==0){
			redirect(base_url().'login', 'location');
			die();	
		}
						
		$product = $this->product_model->get('*',' pro_id = '.$pro_id);
				
		$order_id = time();
		// tao gio hang
		$this->create_showcart($order_id,$product);
		//end tao gio hang
		$this->order_model->create_order($order_id,'info_baokim','to_receive',$product->pro_user,$this->session->userdata('sessionUser'));
		$this->session->set_flashdata('order_id',$order_id);
		if($product->pro_saleoff){
			switch($product->pro_type_saleoff){
				case 1:
					$total_amount = (float)$product->pro_cost - (float)$product->pro_cost * (float) $product->pro_saleoff_value /100;
					break;
				case 2:
					$total_amount = (float)$product->pro_cost - (float) $product->pro_saleoff_value ;
					break;					
			}			
		}
		else
			$total_amount = $product->pro_cost;		
		$order_description = $product->pro_name;
		$order_description = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $order_description);
		$pro_name = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $product->pro_name);
		//$order_description = utf8_decode( $order_description);
		$url_success = base_url()."product/baokim_success/".$order_id;
		$url_cancel = base_url()."product/fail_transaction_baokim/";
		$url_detail = base_url()."/product/category/detail/".$product->pro_category."/".$product->pro_id;
		//echo $url_detail;die();
		$info_saler = $this->order_model->getOrderSaler($order_id,'info_baokim');
		$url = $this->baokim_model->createRequestCart($info_saler,$pro_name,$total_amount,1,$total_amount,$url_detail,$url_success,$url_cancel,$order_description);
		redirect($url);		
	}
	
/** xua ly khi submit form thanh toan hoa don
*/	
	function order_bill(){
		$order_id = $this->uri->segment(3);
		if(!$order_id) redirect(base_url());
		$this->load->model('order_model');
		$payment_method = $this->order_model->getPaymentMethod($order_id);
		$info_saler = $this->order_model->getOrderSaler($order_id,$payment_method);
		switch($payment_method){
			case 'info_cod':
				$this->order_bill_cod($order_id,$info_saler);
				break;
			case 'info_baokim':
				$this->order_bill_baokim($info_saler);
				break;
			case 'info_nganluong':
				$this->order_bill_nganluong($info_saler);
				break;
			case 'info_bank':
				$this->order_bill_bank($order_id,$info_saler);
				break;	
			case 'info_cash':
				$this->order_bill_bank($order_id,$info_saler);
				break;	
			case 'info_wu':
				$this->order_bill_bank($order_id,$info_saler);
				break;	
			case 'info_po':
				$this->order_bill_bank($order_id,$info_saler);
				break;																								
		}		
	}	
	function order_bill_cod($order_id,$info_saler){
		$this->load->model('order_model');
		//$return = $this->order_model->update_order($order_id,1);
		redirect(base_url()."product/payment_success/".$order_id);
	}	
	function order_bill_baokim($info_saler){
		$order_id = $this->uri->segment(3);
		$this->load->model('product_model');
		$this->load->model('baokim_model');
		$this->load->model('order_model');	
		$total_amount = $this->order_model->getTotalOrder($order_id);
		
		$order_description = $this->lang->line("THANH TOAN HOA DON ");
		$order_description = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $order_description.$order_id);
		//$order_description = utf8_decode( $order_description);
		$url_success = base_url()."product/payment_success/".$order_id;
		$url_cancel = base_url()."product/fail_transaction_baokim/";
		$url_detail = "";
//		echo $info_saler;die();
		$url = $this->baokim_model->createRequestCart($info_saler,$order_id,$total_amount,1,$total_amount,$url_detail,$url_success,$url_cancel,$order_description);		
//		echo $url;die();
//		$result = $this->baokim_model->verifyResponseUrl();
		redirect($url);
	}	
	function order_bill_nganluong($order_id){
		$this->load->model('nganluong_model');
		$this->load->model('order_model');
		$this->load->model('showcart_model');
		$this->load->model('user_receive_model');
        $user_receive = $this->user_receive_model->get("*","order_id = ".$order_id);
        $showcarts = $this->showcart_model->getDetail($order_id);
		$order = $this->order_model->get("*",array("id"=>$order_id));
        $total_amount = $order->order_total;
        $return_url = base_url()."payment/nganluong_success/".$order_id;
        $cancel_url = base_url()."payment/nganluong_cancle/".$order_id;
		$url_detail = "";
        $array_items = array();
        $p = 0;
        foreach($showcarts as $showcart){
            $p++;
            $array_items[]= array('item_name'.$p =>$showcart->pro_name,
                'item_quantity'.$p =>$showcart->shc_quantity,
                'item_amount'.$p => $showcart->pro_price,
                'item_url'.$p => base_url().$showcart->pro_category."/".$showcart->pro_id."/".RemoveSign($showcart->pro_name));
        }

		//$url = $this->nganluong_model->createRequestCart($info_saler,$order_id,$total_amount,$url_success,$order_description);

//		$result = $this->nganluong_model->verifyResponseUrl();
        $nganluong = $this->session->userdata('nganluong');
		$payment_method =$nganluong['payment_method_nganluong'];
		$bank_code =$nganluong['bankcode'];
		$order_code =$order_id;
		$payment_type =1;
		$discount_amount =0;
		$order_description=$user_receive->ord_note;
		$tax_amount=0;
		$fee_shipping=0;
		$buyer_fullname =$user_receive->ord_sname;
		$buyer_email =$user_receive->ord_semail;
		$buyer_mobile =$user_receive->ord_smobile;
        $buyer_address ="";
        //$total_amount = 2000;
		//$buyer_address =$_POST['ord_address'] . "|" . $_POST['user_district_put'."|" . $_POST['user_province_put']];
		if($payment_method !='' && $buyer_email !="" && $buyer_mobile !="" && $buyer_fullname !="" && filter_var( $buyer_email, FILTER_VALIDATE_EMAIL )  ){
            $this->session->set_userdata('nganluong',array());

            if($payment_method =="VISA"){
				$nl_result= $this->nganluong_model->VisaCheckout($order_code,$total_amount,$payment_type,$order_description,$tax_amount,
					$fee_shipping,$discount_amount,$return_url,$cancel_url,$buyer_fullname,$buyer_email,$buyer_mobile,
					$buyer_address,$array_items);

			}elseif($payment_method =="NL"){
				$nl_result= $this->nganluong_model->NLCheckout($order_code,$total_amount,$payment_type,$order_description,$tax_amount,
					$fee_shipping,$discount_amount,$return_url,$cancel_url,$buyer_fullname,$buyer_email,$buyer_mobile,
					$buyer_address,$array_items);

			}elseif($payment_method =="ATM_ONLINE" && $bank_code !='' ){
				$nl_result= $this->nganluong_model->BankCheckout($order_code,$total_amount,$bank_code,$payment_type,$order_description,$tax_amount,
					$fee_shipping,$discount_amount,$return_url,$cancel_url,$buyer_fullname,$buyer_email,$buyer_mobile,
					$buyer_address,$array_items) ;
			}

			if ($nl_result->error_code =='00'){
                $this->order_model->update_nl_order($order_id,0,$nl_result->token,"");

				//https://www.nganluong.vn/checkout.api.nganluong.post.php?cur_code=usd&function=SetExpressCheckout&version=3.1&merchant_id=24338&receiver_email=hoannet@gmail.com&merchant_password=f1bfd514f667cebd7595218b5a40d5b1&order_code=228&total_amount=0.1&payment_method=VISA&payment_type=&order_description=&tax_amount=0&fee_shipping=0&discount_amount=0&return_url=http://smiletouristvietnam.com/book/successpayment&cancel_url=http://smiletouristvietnam.com/book/successpayment&buyer_fullname=&buyer_email=&buyer_mobile=&buyer_address=&total_item=1&item_name1=228&item_quantity1=1&item_amount1=0.1&item_url1=http://nganluong.vn/

                redirect($nl_result->checkout_url);
			}else{
				echo $nl_result->error_message;
			}
		}



	}
	function order_bill_bank($order_id,$info_saler){
		$this->load->model('order_model');
		//$return = $this->order_model->update_order($order_id,1);
		redirect(base_url()."product/payment_success/".$order_id);
		
	}	
	function verifyresponse_nganluong(){
		parse_str($_SERVER['QUERY_STRING'],$_GET);
		$order_id = $_GET['order_code'];
		/*echo "<pre>";print_r($_GET);echo "</pre>";
		die();*/
		//if($order_id != $this->session->flashdata('order_id'))
			//redirect(base_url()."account/fail_transaction_baokim/"); 
		$this->load->model('nganluong_model');
		$this->load->model('order_model');
		$nganluong_data = $_GET;
		$transaction_info = $nganluong_data['transaction_info'];
		$order_code = $nganluong_data['order_code'];
		$price = $nganluong_data['price'];
		$payment_id = $nganluong_data['payment_id'];
		$payment_type = $nganluong_data['payment_type'];
		$error_text = $nganluong_data['error_text'];
		$secure_code = $nganluong_data['secure_code'];
		$result = $this->nganluong_model->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);

		if($result && $error_text ==''){			
			$net_amount = $_GET['net_amount'] /10000;	
			$fee_amount = $_GET['fee_amount'];			
			$transaction_id = $_GET['transaction_id'];					
			//Mot so thong tin khach hang khac
			$customer_name = $_GET['customer_name'];
			$customer_address = $_GET['customer_address'];
			$username = $this->session->userdata('sessionUsername');
			$this->order_model->update_order($order_id,1);
			redirect(base_url()."product/baokim_success/".$order_id);
		}else
			redirect(base_url()."product/fail_transaction_baokim/"); 	
	}
	
	function verifyresponse_baokim(){
		parse_str($_SERVER['QUERY_STRING'],$_GET);
		$order_id = $_GET['order_id'];
		/*echo "<pre>";print_r($this->session->flashdata('order_id'));echo "</pre>";
		echo "<pre>";print_r($_GET['order_id']);echo "</pre>";
		die();*/
		//if($order_id != $this->session->flashdata('order_id'))
		//redirect(base_url()."account/fail_transaction_baokim/"); 
		$this->load->model('baokim_model');
		$this->load->model('order_model');
		$transaction_status = $_GET['transaction_status'];	

		
		if($this->baokim_model->verifyResponseUrl($_GET) &&($transaction_status == 4 || $transaction_status == 13)){			
			$net_amount = $_GET['net_amount'] /10000;	
			$fee_amount = $_GET['fee_amount'];			
			$transaction_id = $_GET['transaction_id'];					
			//Mot so thong tin khach hang khac
			$customer_name = $_GET['customer_name'];
			$customer_address = $_GET['customer_address'];
			$username = $this->session->userdata('sessionUsername');
			$this->order_model->update_order($order_id,1);
			redirect(base_url()."product/baokim_success/".$order_id);
		}else
			redirect(base_url()."product/fail_transaction_baokim/"); 

	}

}