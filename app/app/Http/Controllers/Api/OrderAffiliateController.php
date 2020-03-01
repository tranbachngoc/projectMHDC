<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Order;
use Lang;
use DB;
use App\Models\UserReceive;
use App\Models\User;
use App\Models\ProductPromotion;
use App\Models\OrderDetail;
use App\Components\ShipService;
class OrderAffiliateController extends ApiController {
    
        /**
     * @SWG\Get(
     *     path="/api/v1/me/affiliate-order",
     *     operationId="order",
     *     description="Đơn hàng đại lý / công tác viên online",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Affiliate Đơn hàng đại lý / công tác viên online",
     *    @SWG\Parameter(
     *         name="formPrice",
     *         in="query",
     *         description="Giá từ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="toPrice",
     *         in="query",
     *         description="Giá đến",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="status",
     *         in="query",
     *         description="Trạng thái đơn hàng",
     *         required=false,
     *         type="string",
     *     ),
      *    @SWG\Parameter(
     *         name="monthFilter",
     *         in="query",
     *         description="Tìm kiếm theo tháng",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Danh sách order"
     *     )
     * )
     */
    public function index(Request $req){
        $orderdtdb = (new OrderDetail)->getTable();
        $productdb = (new Product)->getTable();
        $user = $req->user();
        $query = OrderDetail::where([]);
        if (in_array($user->use_group, [User::TYPE_StaffUser, User::TYPE_StaffStoreUser])) {
            $get_u = $user;
            $tree = [];
            
            $tree[] = $user->use_id;
            $sub_tructiep = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser, User::TYPE_AffiliateUser, User::TYPE_StaffUser])->where('use_status', User::STATUS_ACTIVE)->where('parent_id', $user->use_id)->get();

            //  $sub_tructiep = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN (' . BranchUser . ',' . StaffStoreUser . ',' . AffiliateUser . ',' . StaffUser . ') AND use_status = 1 AND parent_id = "' . $this->session->userdata('sessionUser') . '"');
            if (!empty($sub_tructiep)) {
                foreach ($sub_tructiep as $key => $value) {
                    $tree[] = $value->use_id;
                    //Nếu là chi nhánh, lấy danh sách nhân viên
                    if ($value->use_group == User::TYPE_BranchUser) {
                        $sub_nv = User::where(['use_group' => User::TYPE_StaffUser, 'use_status' => User::STATUS_ACTIVE])->where('parent_id', $value->use_id)->get();
                        if (!empty($sub_nv)) {
                            foreach ($sub_nv as $k => $v) {
                                $tree[] = $v->use_id;
                                $slAff = $v->sl;
                            }
                        }
                    }
                 
                    if ($value->use_group == User::TYPE_StaffStoreUser) {

                        $tree[] = $value->use_id;
                        //Lấy danh sách CN dưới nó cua NVGH
                        $sub_cn = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffUser])
                                ->where('use_status', User::STATUS_ACTIVE)->where('parent_id', $value->use_id)->get();

                        if (!empty($sub_cn)) {
                            foreach ($sub_cn as $k => $vlue) {
                                $tree[] = $vlue->use_id;

                                if ($vlue->use_group == User::TYPE_BranchUser) {
                                    $sub_nv = User::whereIn('use_group', [User::TYPE_StaffUser])
                                            ->where('use_status', User::STATUS_ACTIVE)->where('parent_id', $vlue->use_id)->get();
                                    // Lay DS NV-CN-NVGH
                                    if (!empty($sub_nv)) {
                                        foreach ($sub_nv as $k => $v) {
                                            $tree[] = $v->use_id;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
            $getAF = User::whereIn('use_group', [User::TYPE_AffiliateUser])
                    ->where(['use_status' => User::STATUS_ACTIVE])->whereIn('parent_id', $tree)->get()->pluck('use_id')->toArray();

            $query->whereIn('af_id', $getAF);
            $query->whereIn('shc_saler', [$user->parent_id]);
        } else {
            $query->where(['af_id' => $req->user()->use_id]);
        }
        //TODO add id current user in here
        
        $query->join($productdb, $productdb.'.pro_id',$orderdtdb.'.shc_product');
        $query->select($productdb.".*",$orderdtdb.'.*',
            DB::raw('tbtt_showcart.`pro_price`, tbtt_showcart.`af_amt` as af_amt_original,
                      (tbtt_showcart.`af_amt` + tbtt_showcart.`af_rate` * tbtt_showcart.`pro_price` / 100) * tbtt_showcart.`shc_quantity` as af_amt'));
        if($req->formPrice){
            $query->where($orderdtdb.'.pro_price','>=',$req->formPrice);
        }
        if($req->toPrice){
            $query->where($orderdtdb.'.pro_price','<=',$req->toPrice);
        }
        if($req->status){
            $query->where($orderdtdb.'.shc_status',$req->status);
        }
        $startMonth = mktime(0, 0, 0, date('n'), 1, date('Y'));
        $endMonth = mktime(23, 59, 59, date('n'), date('t', $startMonth), date('Y'));
        if (!empty($req->monthFilter)) {
            $startMonth = mktime(0, 0, 0, $req->monthFilter, 1, date('Y'));
            $endMonth = mktime(23, 59, 59, $req->monthFilter, date('t', $startMonth), date('Y'));
        }

        $query->where($orderdtdb . '.shc_change_status_date','>=', $startMonth);
        $query->where($orderdtdb . '.shc_change_status_date','<=', $endMonth);
        
        $query->with(['status', 'buyer', 'saler', 'product']);
     
         if (!empty($req->orderBy)) {
            $req->orderBy = explode(',', $req->orderBy);
            $key = $req->orderBy[0];
            $value = $req->orderBy[1] ? $req->orderBy[1] : 'DESC';
            $query->orderBy($orderdtdb . '.' . $key, $value);
        } else {
            //TO DO SAME AFFILATE
            if (in_array($user->use_group, [User::TYPE_StaffUser, User::TYPE_StaffStoreUser])) {
                $query->orderBy($orderdtdb . '.shc_id', 'DESC');
            }
        }
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        $results  = [];
        foreach($paginate->items() as $item){
            $data = $item->toArray(); 
            $moneyShop = 0;
            if ($item->af_rate > 0 || $item->af_amt > 0) {
                if ($item->af_rate > 0):
                    $hoahong = $item->af_rate;
                    $moneyShop = ($item->shc_total) * (1 - ($hoahong / 100));
                    if ($item->em_discount > 0):
//                                                        $hh_giasi = ($order['shc_total'])*(1-($hoahong / 100));
                        $moneyShop = ($item->shc_total) * (1 - ($hoahong / 100));
                    endif;
                else:
                    $hoahong = $item->af_amt;
                    $moneyShop = $item->shc_total - ($hoahong * $item->shc_quantity);
                endif;
            }else {
                $moneyShop = $item->shc_total;
            }
            $data['shc_total_ori'] = $item->shc_total;
            $data['shc_total'] = $moneyShop;
            $results[] = $data;
            
        }
        
        $result = $paginate->toArray();
        $result['data'] = $results;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);

//        if ($this->session->userdata('sessionUser')) {
//            $group_id = $this->session->userdata('sessionGroup');
//            if ($group_id == AffiliateUser
//            ) {
//                
//            } else {
//                redirect(base_url() . "account", 'location');
//                die();
//            }
//            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
//            $getVar = $this->uri->uri_to_assoc(4, $action);
//            if ($getVar['page'] != false && $getVar['page'] != '') {
//                $start = $getVar['page'];
//            } else {
//                $start = 0;
//            }
//            $page = $getVar['page'];
//
//            $link = 'account/affiliate/orders';
//            $this->load->model('af_order_model');
//            $this->af_order_model->pagination(TRUE);
//            $this->af_order_model->setLink($link);
//            $afId = (int) $this->session->userdata('sessionUser');
//            $body = array();
//            $this->load->model('shop_model');
//            $shop = $this->shop_model->get("*", "sho_user = " . (int) $this->session->userdata('sessionUser'));
//            $body['shop'] = $shop;
//            $body['shopid'] = $shop->sho_id;
//            $body['menuType'] = 'account';
//            $body['menuSelected'] = 'showcart';
//            $body['orders'] = $this->af_order_model->getAfList(array('tbtt_showcart.af_id' => $afId), $page);
//            $body['pager'] = $this->af_order_model->pager;
//            $body['sort'] = $this->af_order_model->getAdminSort();
//            $body['link'] = base_url() . $link;
//            $body['status'] = $this->af_order_model->getStatus();
//            $body['filter'] = $this->af_order_model->getFilter();
//            $body['num'] = $page;
//
//            $this->load->view('home/affiliate/orders', $body);
//        } else {
//            redirect(base_url() . 'login', 'location');
//            die();
//        }
    }
}