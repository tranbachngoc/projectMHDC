<?php
class Viettelpost_model extends CI_Model
{
    public $URL_REQUEST = "https://api.viettelpost.com.vn:8446/api/VTPTMDT/";
    function __construct()
    {
        parent::__construct();
    }

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

    public function VTPUpdate(){
        $return = null;
        $rest_json = file_get_contents("php://input");
        $_POST = json_decode($rest_json, true);
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['username'] == 'VTP' && $_POST['password'] == md5(passwordVTP) ){
            $this->load->model('order_model');
            if($_POST['ma_van_don']){
                $ma_van_don = $_POST['ma_van_don'];
                $where['id'] = str_replace("AZB","",$ma_van_don);
            }else{
                $return = json_encode("please add ma_van_don");
                return $return;
            }
            $order = $this->order_model->get("*",$where);
            if($order->shipping_method == 'VTP'){
                $status = $_POST['ma_trang_thai'] ? $_POST['ma_trang_thai'] : '';
                $ten_trang_thai = $_POST['ten_trang_thai'] ? $_POST['ten_trang_thai'] : '';
                $thoi_gian = $_POST['thoi_gian'] ? $_POST['thoi_gian'] : '';
                $ghi_chu = $_POST['ghi_chu'] ? $_POST['ghi_chu'] : '';
                if($status){
                    $this->CreateOrderVTPInfo($ma_van_don,$status,$ten_trang_thai,$thoi_gian,$ghi_chu);
                }else{
                    return false;
                }
                switch ($status) { 
                    case "100":
                        $status = '01';
                        break;
                    case "103":
                    case "104":
                    case "105":
                        $status = '02';
                        break;
                    case "501":
                        $status = '03';
                        break;
                    case "107":
                    case "503":
                        $status = '99';
                        break;
                    case "506":
                        $status = '04';
                        break;
                    default:
                        $status = '01';
                }
                $mstatus = array('02','03','04','99');
                if (in_array($status, $mstatus)) {
                    $this->order_model->update_order($order->id,$status);
                    $return = json_encode('Success');
                }else{
                    return json_encode($status);
                }
            }else{
                $return = json_encode('Can not find order');
            }
        }else{
            $return = json_encode('Username and password not match');
        }
        return $return;
    }

    public function GetProvinceByDistrictCode($district){
        $this->db->cache_off();
        $this->db->select("vtp_province_code,vtp_code");
        $this->db->where(array("DistrictCode"=>$district));
        #Query
        $query = $this->db->get("tbtt_district");
        $result = $query->row();
        $query->free_result();
        return $result;
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

    public function CreateOrderVTPInfo($ma_van_don,$ma_trang_thai,$ten_trang_thai = '',$thoi_gian='',$ghi_chu=''){
        $data = array(
            'ma_van_don' => $ma_van_don,
            'ma_trang_thai' => $ma_trang_thai,
            'ten_trang_thai' => $ten_trang_thai,
            'thoi_gian' => $thoi_gian,
            'ghi_chu' =>   $ghi_chu
        );
        $this->db->insert('tbtt_vtp_tracking', $data);
        return $this->db->insert_id();
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