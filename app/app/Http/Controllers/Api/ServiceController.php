<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Category;
use Lang;
use App\Helpers\Commons;
use App\Models\User;
use App\Models\Manufacture;
use App\Models\Shop;
use App\Models\DetailProduct;
use DB;
use App\Models\BranchConfig;
use App\Models\ProductPromotion;
use App\Models\PackageDailyUser;
use App\Models\PackageUser;
use App\Models\PackageUserService;
use App\Models\Service;
class ServiceController extends ApiController {
    
        /**
     * @SWG\Get(
     *     path="/api/v1/me/package-purchase/{order_id}",
     *     operationId="package-purchase-detail",
     *     description="Chi tiết gói package đã mua",
     *     produces={"application/json"},
     *     tags={"Package"},
     *     summary="Chi tiết gói package đã mua",
     *     @SWG\Response(
     *         response=200,
     *         description="kết quả"
     *     )
     * )
     */
    function detailPackage($id, Request $req) {
        $servicedb = Service::tableName();
        $packageUserServicedb = PackageUserService::tableName();
        $query = PackageUserService::where(['order_id'=> $id]);
        $query->select($servicedb.'.*');
        $query->join($servicedb, $packageUserServicedb . '.service_id', $servicedb . '.id');
        $result = $query->get();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }

//    function index(Request $req) {
//        $user = $req->user();
//        if ($user->use_group == User::TYPE_AffiliateUser) {
//            PackageDailyUser::where(['unit_type' => 'tháng']);
//        }
//    }
//
//    function product(Request $req){
////        $
////         $group_id = $this->session->userdata('sessionGroup');
////        if ($group_id == AffiliateStoreUser || $group_id == AffiliateUser
////        ) {
////
////        } else {
////            redirect(base_url() . "account", 'location');
////            die();
////        }
//        $this->load->library('utilslv');
//        $util = utilslv::getInstance();
//        $util->addScript(base_url() . 'templates/home/js/package.js');
//        $this->load->model('shop_model');
//        $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
//        $data['shopid'] = $shop->sho_id;
//        $userId = (int)$this->session->userdata('sessionUser');
//        $user_data = $this->user_model->get('use_group', "use_id = " . (int)$this->session->userdata('sessionUser'));
//        $data['user_group'] = $user_data->use_group;
//        if($user->use_group == User::TYPE_AffiliateUser){
//            PackageDailyUser::where(['unit_type'=>'tháng']);
//        }
//        if ($user_data->use_group == 2) {
//            $data['menuType'] = 'account';
//            $data['menuSelected'] = 'service';
//            $this->load->model('package_model');
//            $this->load->model('package_daily_model');
//            $data['package_daily'] = $this->package_daily_model->get_list(array('select' => '*', 'where' => array('unit_type' => 'tháng')));
//            $data['package_time'] = $this->package_model->get_list(array('select' => 'id,period,month_price,discount_rate,p_type, unit_type', 'where' => array('p_type' => 'package_daily')));
//        } else {
//            $data['menuType'] = 'account';
//            $data['menuSelected'] = 'service';
//            $this->load->model('package_model');
//
//            ///$data['maxPackage'] = $this->package_model->getMaxUsedPackage($userId);
//            $data['avai_date'] = $this->package_model->getAvailableDate($userId);
//            $data['free_exist'] = $this->package_model->checkFreePackage($userId);
//            $util->addInlineScript("var packageDate = " . json_encode($data['avai_date']) . ";\n");
//
//            switch ($shop->sho_style) {
//                case 'default':
//                    $sho_style = array('05', '04', '07');
//                    break;
//                case 'style1':
//                    $sho_style = array('05', '04', '07');
//                    break;
//                case 'style2':
//                    $sho_style = array('04', '06', '07');
//                    break;
//                case 'style3':
//                    $sho_style = array('05', '06', '07');
//                    break;
//                case 'style4':
//                    $sho_style = array('04', '05', '06');
//                    break;
//                default:
//                    $sho_style = array();
//                    break;
//            }
//            $this->load->model('package_daily_model');
//            $parrams = array('select' => '*', 'where' => array('unit_type' => 'ngày', 'published' => 1));
//            switch ($this->uri->segment('3')) {
//                case 'products':
//                    $parrams['where_in'] = array('p_type' => array('04', '05', '06', '07', '08'));
//                    break;
//                case 'news':
//                    $parrams['where_in'] = array('p_type' => array('01', '02', '03'));
//                    break;
//            }
//            $data['package_daily'] = $this->package_daily_model->get_list($parrams, $sho_style);
//
//
//            $data['position'] = array(
//                '000' => "Toàn quốc",
//                '001' => "Khu vực 1",
//                '999' => "Khu vực 2"
//            );
//            $data['news_type'] = array(
//                '000' => "Tin hot",
//                '111' => "Tin khuyến mãi"
//            );
//        }
//        $data['pid'] = $pid;
//        $this->load->view('home/account/service/new_service', $data);
//    }
}