<?php
/** Create by Bao Tran
**  Date: 27/09/2017
**  Connect API Giao Hang Tiet Kiem
**  URL: https://services.giaohangtietkiem.vn/
**  TokenAzibai: 8cc20D58F9c595840c14Ed2C8fb0C77C1BBBF014
**  Link manager: https://khachhang.giaohangtietkiem.vn/dangnhap
**  Account: [user: tienlam@azibai.com - pass: "S9XF}ma-M"J`53)  ]
**/
class Ghtietkiem_model extends CI_Model
{
    public $URL_REQUEST = "https://services.giaohangtietkiem.vn/"; // Môi trường thật    
    //public $URL_REQUEST = "https://dev.giaohangtietkiem.vn/";   // Môi trường dev 
    public $TokenAzibai = "8cc20D58F9c595840c14Ed2C8fb0C77C1BBBF014";
    
    function __construct()
    {
        parent::__construct();
    }

    public function TestConnect()
    {
        $url = 'https://dev.giaohangtietkiem.vn/services/shipment/order';
        $dataSend = array
        (
            'products' => array
            (
                0 => array
                    (
                        'name' => 'Truyện Tranh Hary Poster',
                        'weight' => 0.5
                    ),
                1 => array
                    (
                        'name' => 'Laptop HP',
                        'weight' => 2.1
                    )
            ),
            'order' => array
            (
                'id' => '1111',
                'pick_name' => 'HCM-City',
                'pick_address' => '590 CMT8 P.11',
                'pick_province' => 'TP. Hồ Chí Minh',
                'pick_district' => 'Quận 3',
                'pick_tel' => '0911222333',
                'tel' => '0911222333',
                'name' => 'GHTK - HCM - Noi Thanh',
                'address' => '123 nguyễn chí thanh',
                'province' => 'TP. Hồ Chí Minh',
                'district' => 'Quận Tân Bình',
                'is_freeship' => 1,
                'pick_date' => '2017-09-29',
                'pick_money' => 47000,
                'note' => 'Khối lượng tính cước tối đa: 3.00 kg',
                'value' => 500000
            )
        );

        $data_string = json_encode($dataSend); //echo $data_string; die;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type:application/json',
                 'Token: 8cc20D58F9c595840c14Ed2C8fb0C77C1BBBF014',
                  'Content-Length: ' . strlen($data_string),
                 )
            );
        $response =  curl_exec($ch);
        echo $response;
        curl_close($ch);
    }

    public function ConnectGHTK($dataSend)
    {
        $url = $this->URL_REQUEST .'services/shipment/fee?'.http_build_query($dataSend);       
        $data_string = $dataSend;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type:application/json',
                 'Token: 8cc20D58F9c595840c14Ed2C8fb0C77C1BBBF014',
                  'Content-Length: ' . strlen($data_string)
                 )
            );
        $response =  curl_exec($ch);        
        curl_close($ch);
        return $response;
    }

    public function getShippingFee($data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->URL_REQUEST ."services/shipment/fee?" . http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "Token: ". $this->TokenAzibai, "Content-Type:application/json"
            )
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;       
    }

    public function GetProvinceByDistrictCode($district)
    {
        $this->db->cache_off();
        $this->db->select("DistrictName, ProvinceName");
        $this->db->where(array("DistrictCode"=>$district));
        #Query
        $query = $this->db->get("tbtt_district");
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    public function CreateOrder($dataRec)
    {
        $curl = curl_init();
        $data = json_encode($dataRec);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->URL_REQUEST ."services/shipment/order",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Token: ". $this->TokenAzibai                
            )
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function GHTKUpdate()
    {
        $return = null;
        $rest_json = file_get_contents("php://input");
        $_post = json_decode($rest_json, true);      
        $this->load->model('order_model'); 
        if($_post['partner_id']){
            $where['id'] = $_post['partner_id'];               
        } else {
            $return = json_encode("please add partner_id");           
            return $return;
        }
        $order = $this->order_model->get("*", $where);
        if($order->shipping_method == 'GHTK'){
            $ord_id = $_post['partner_id'];
            $ghtk_id = $_post['label_id'] ? $_post['label_id'] : '';
            $status = $_post['status_id'] ? $_post['status_id'] : '';
            $note = $_post['reason'] ? $_post['reason'] : '';            
            $_huy = '999';

            switch ($status) {
                case "1":                   
                case "2":
                case "3":
                case "4":
                case "8":
                case "10":
                case "12":
                case "123":
                case "127":
                case "128":
                case "410":
                    $_status = '02';
                    break;                   
                case "5":
                case "45":
                    $_status = '03';
                    break;
                case "7":
                    $_huy = $_post['reason_code'];
                case "9":
                case "20":
                case "21":
                case "49":                       
                    $_status = '04';
                    break;
                case "11":
                    $_status = '06';
                    break;                    
                case "-1":
                    $_status = '99';
                    break;                    
                case "6":
                    $_status = '98';
                    break;   
                default:
                    // $_status = '02';
                    break;                   
            }
            //$_in_ar = array('02','03','04','06','98','99');
            if($status){
                $note = $note.' - '.$_huy;
                $this->GHTK_Update_Log($ord_id, $ghtk_id, $status, $note);
            }
                        
            $mstatus = array('02','03','04','06','99');
            if (in_array($_status, $mstatus)) {
                $this->order_model->update_order($order->id, $_status);
                $return = json_encode('Success');
            }else{
                return json_encode($_status);
            }
        }else{
            $return = json_encode('Can not find order');
        }        
        return $return;
    } 

    public function GHTK_Update_Log($ord_id=0, $ghtk_id='', $status='02', $note='')
    {
        $data = array(
            'order_id'    => $ord_id,
            'ghtk_id'     => $ghtk_id,
            'status_id'   => $status,
            'update_time' => date('Y-m-d H:i:s', time()),
            'note'        => $note
        );       
        $this->db->insert('tbtt_ghtk_log', $data);
        return $this->db->insert_id();
    }

    public function CancelOrder($proID)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->URL_REQUEST ."services/shipment/cancel/partner_id:". $proID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "Token: ". $this->TokenAzibai
            )
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    ## KHONG DUNG , COPY TU GIAO HANG VTP
    public function Login()
    {
        $curl = curl_init();
        $arrayUser = array(
            'UserName' => 'AZB',
            'Password' => 'xmHNU#2_S[32v{:N',
            'AppKey' => 'LmfNRXQfd8+66POBa+z10Q=='
        );

        $data= json_encode($arrayUser);

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8446",
            CURLOPT_URL => $this->URL_REQUEST."Login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
            CURLOPT_PROXY, true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response["TokenKey"];
        }
    }

    public function callMethod($method, $data, $token,$request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8446",
            CURLOPT_URL => $this->URL_REQUEST.$method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $request,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Token: ".$token
            ),
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }       

    public function getTrackingInfo($maVanDon){
        $this->db->cache_off();
        $this->db->select("ma_trang_thai,ten_trang_thai,thoi_gian,ghi_chu");
        $this->db->where("ma_van_don" ,$maVanDon);
        #Query
        $query = $this->db->get("tbtt_vtp_tracking");
        $result = $query->result_array();
        $query->free_result();
        return $result;
    }    

    function create_order($id,$payment_method=0,$shipping_method=0,$order_saler=0,$order_user=0, $currentDate, $af_id=0,$order_total, $payment_status=0, $token = "", $other_info="", $payment_info=""){
        if($order_saler) {
            $data = array(
                'id' => $id,
                'payment_method' => $payment_method,
                'shipping_method' => $shipping_method,
                'order_user' => $order_user,
                'order_saler' => $order_saler,
                'date' =>   $date = time(),
                'af_id' =>  $af_id,
                'order_total' => $order_total,
                'payment_status' => $payment_status,
                'token' => $token,
                'other_info'=>$other_info,
                'payment_other_info' => $payment_info
            );
            $this->db->insert($this->_table, $data);
            return $this->db->insert_id();
        } else {
            return NULL;
        }
    }
}

?>