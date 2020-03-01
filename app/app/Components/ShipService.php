<?php
namespace App\Components;
use App\Components\RestApiClient;
use App\Models\District;
use App\Components\ViettelAPi;
use App\Components\GiaoHangTietKiem;
class ShipService {
    const SERVICE_ID = '{"53319":"6 giờ","53320":"1 ngày","53321":"2 ngày","53322":"3 ngày","53323":"4 ngày","53324":"5 ngày"}';
    const TYPE_GIAOHANGNHANH='GHN';// Giao hàng nhanh;
    const TYPE_VT='Viettel';
    const TYPE_SHOPGIAO = 'SHO';
    const VTP_SERVICE = 'VCN';
    
    //GHN INFO
    const GHN_URL = 'https://testapipds.ghn.vn:9999/External/MarketPlace/';
    const GHN_ID = "28247";
    const GHN_PASS =  '1234567890';
    const GHN_KEY = 'wcsNLLjyLyKX6EsB';
    const GHN_SKEY = '9869C9338C530081E31BB9135355A2BF';
    
    protected $GHN_URL = 'https://testapipds.ghn.vn:9999/external/marketplace';
    public static function settingGHN() {
        return [
            'GHN_URL' =>env('GHN_URL','https://apipds.ghn.vn/external/marketplace'),
            'GHN_ID' => env('GHN_ID', '72869'),
            'GHN_PASS' => env('GHN_PASS', '6kMufjmmuNAm2fT8M'),
            'GHN_KEY' => env('GHN_KEY', 'wcsNLLjyLyKX6EsB'),
            'GHN_SKEY' => env('GHN_SKEY', '9869C9338C530081E31BB9135355A2BF')
        ];
    }

    public static function getFee($type, $shopDistrict, $desDistrict, $totalWeight) {
        $shipfee = null;
        if ($type == self::TYPE_GIAOHANGNHANH) {
            $ship = self::getGHNShippingFee($shopDistrict, $desDistrict, $totalWeight);
            return $ship ? $ship : null;
        } elseif ($type == self::TYPE_SHOPGIAO) {
            $shipfee['ServiceFee'] = 0;
            $shipfee['ServiceName'] = "";
            $shipfee['ServiceID'] = "SHO";
            return $shipfee;
        } elseif ($type == 'GHTK') {
            // by BaoTran, Case nguoi mua chon ship la GHTK
            $shipfee_ghtk = self::getGHTKShippingFee($shopDistrict, $desDistrict, $totalWeight);
            $shipfee['ServiceFee'] = $shipfee_ghtk;
            $shipfee['ServiceName'] = "";
            $shipfee['ServiceID'] = "GHTK";
        } else {

            $shipfee_vtp = self::getVTPShippingFee($shopDistrict, $desDistrict, $totalWeight);
            if ($shipfee_vtp && isset($shipfee_vtp[0]['TONG_CUOC'])) {
                $shipfee['ServiceFee'] = (float) str_replace(",", "", $shipfee_vtp[0]['TONG_CUOC']);
                $shipfee['ServiceName'] = "";
                $shipfee['ServiceID'] = self::VTP_SERVICE;
            }
        }
        return $shipfee;
    }
    public static function getGHTKShippingFee($fromDis="", $toDis="", $totalWeightPro=0){
        $GiaoHangTietKiem = new GiaoHangTietKiem();
        $from = $GiaoHangTietKiem->GetProvinceByDistrictCode($fromDis);
        $to = $GiaoHangTietKiem->GetProvinceByDistrictCode($toDis);
        $dataInfo = array(
            "pick_province" => $from->ProvinceName,
            "pick_district" => $from->DistrictName,
            "province" => $to->ProvinceName,
            "district" => $to->DistrictName,
            "address" => "",
            "weight" => $totalWeightPro,
            "value" => 0
            );        
        $result = $GiaoHangTietKiem->getShippingFee($dataInfo);  
        
        if(!empty($result)) {
            $res = json_decode($result);
            $fee = $res->fee->fee + $res->fee->insurance_fee;
            return $fee;
        } else {
            return null;
        }
    }
    public static function getGHNShippingFee($shopDistrict, $desDistrict, $totalWeight) {
        $config = self::settingGHN();
        
        $restApiClient  = new RestApiClient($config['GHN_URL'],$config['GHN_ID'],$config['GHN_PASS'],$config['GHN_KEY'],$config['GHN_SKEY']);
        $serviceClient = $restApiClient->connectGHN();
        $sessionToken = $serviceClient->SignIn();

        $result = array();
        if ($sessionToken) {
            foreach (json_decode(self::SERVICE_ID) as $k => $vls) {
                $items[] = array(
                    "FromDistrictCode" => $shopDistrict,
                    "ServiceID" => $k,
                    "ToDistrictCode" => $desDistrict,
                    "Weight" => $totalWeight,
                    "Length" => 0,
                    "Width" => 0,
                    "Height" => 0
                );
                $calculateServiceFeeRequest = array("SessionToken" => $sessionToken, "Items" => $items);
                $responseCalculateServiceFee = $serviceClient->CalculateServiceFee($calculateServiceFeeRequest);
                //dump($responseCalculateServiceFee['Items']);
                if(is_array($responseCalculateServiceFee)) {
                    $result = reset($responseCalculateServiceFee['Items']);
                    //dump($result);
                    if ($responseCalculateServiceFee['ErrorMessage'] == "") {
                        break;
                    }
                    unset($items);
                    unset($responseCalculateServiceFee);
                }
            }
            return $result;
        }
        return null;
    }


    public static function getVTPShippingFee($shopDistrict, $desDistrict, $totalWeight) {
        $viettelAPi = new ViettelAPi();
        $from = District::where(['DistrictCode' => $shopDistrict])->select(['vtp_province_code', 'vtp_code'])->first();
        $to =  District::where(['DistrictCode' => $desDistrict])->select(['vtp_province_code', 'vtp_code'])->first();
        
        if (!$from || !$to) {
            return;
        }
        $token = $viettelAPi->Login();

        $data = array("NGAYGUI_BP" => date('d/m/Y'),
            "HUYEN_GUI" => $from->vtp_code,
            "HUYEN_NHAN" => $to->vtp_code,
            "DICHVU" => self::VTP_SERVICE,
            "DV_DACBIET" => "",
            "LOAIHH" => "HH",
            "TRONG_LUONG" => $totalWeight,
            "KHAI_GIA" => "0",
            "THU_HO" => "0"
        );
        $return = $viettelAPi->callMethod('TinhCuoc', json_encode($data, true), $token, 'POST');
        if ($return) {
            return $return;
        } else {
            return null;
        }
    }

    public static function cancelOrder($order) {
        return false;
    }

}