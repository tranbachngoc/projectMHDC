<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Order;
use DB;
use Lang;
use App\Models\UserTree;
use App\Models\Money;
use App\Models\User;
use App\Models\Commission;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shop;
use App\Models\RevenueStoreCategoryWeekly;
use App\Models\DetailProduct;
class IncomeController extends ApiController {
         /**
     * @SWG\Get(
     *     path="/api/v1/me/income/revenue",
     *     operationId="income",
     *     description="Thu nhập gian hàng",
     *     produces={"application/json"},
     *     tags={"Revenue-income"},
     *     summary="Thu nhập gian hàng",
     *     @SWG\Parameter(
     *         name="status",
     *         in="query",
     *         description="Lọc theo trạng thái",
     *         required=false,
     *         type="integer",
     *     ),
     *        @SWG\Parameter(
     *         name="type",
     *         in="query",
     *         description="Lọc theo loại",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="month",
     *         in="query",
     *         description="Lọc theo tháng",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="year",
     *         in="query",
     *         description="Lọc theo năm",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description=" total result"
     *     )
     * )
     */
    
    public function revenue(Request $req){
        //TODO
        /*$group_id = $this->session->userdata('sessionGroup');
        if ($group_id != StaffUser && $group_id != NormalUser) {

        } else {
            redirect(base_url() . "account", 'location');
            die();
        }*/
        $user = $req->user(); //use_id
        $query = Money::where([
            'user_id' => $user->use_id,
            'status' => isset($req->status) ? $req->status : 0,
        ]);
        
        if ($req->type) {
            $query->where('type', $req->type);
        }

        if ($req->month && $req->year) {
            $month = $req->month;
            if ($month < 10) {
                $month = '0' . $req->month;
            }
            $query->where('month_year', $month . '-' . $req->year);
        }

        if (!empty($req->orderBy)) {
            $req->orderBy = explode(',', $req->orderBy);
            $key = $req->orderBy[0];
            $value = $req->orderBy[1] ? $req->orderBy[1] : 'DESC';
            $query->orderBy($key, $value);
        }

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $results = $query->paginate($limit, ['*'], 'page', $page);
          return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
       
    }
    
    function isWed($date) {
        $isWed = date('D', $date);
        if ($isWed == 'Wed') {
            return $date;
        } else {
            return "";
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/api/v1/me/income/provisional_store",
     *     operationId="income",
     *     description="Thu nhập tạm tính",
     *     produces={"application/json"},
     *     tags={"Revenue-income"},
     *     summary="Thu nhập tạm tính",
     *        @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Gioi han",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description=" total result"
     *     )
     * )
     */
    public function provisionalStore(Request $req) {

        $isWed = date('D', time());
        if ($isWed == 'Wed') {
            $firstday = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
            $currentday = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
        } else {
            $firstday = strtotime("previous wednesday");
            $currentday = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
        }
        
        $ids = [];
        if ($req->user()->use_group == User::TYPE_AffiliateStoreUser) {

//        $tree[] = (int)$this->session->userdata('sessionUser');
            $query = User::where(['use_status' => User::STATUS_ACTIVE]);
            $query->select('use_id');
            $query->where(function($q) use($req) {
                $q->orWhere(function($q) use($req) {
                    $q->whereIn('use_group', [User::TYPE_BranchUser]);
                    $q->where(['use_status' => User::STATUS_ACTIVE]);
                    $q->where(function($q ) use($req) {
                        $q->where(['parent_id' => $req->user()->use_id]);
                        $q->orWhereIn('parent_id', function($q3) use($req) {
                            $q3->select('use_id');
                            $q3->from((new User)->getTable());
                            $q3->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                            $q3->where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $req->user()->use_id]);
                        });
                    });
                });
                $q->orWhere(function($q) use($req) {
                    $q->whereIn('use_group', [User::TYPE_BranchUser]);
                    $q->where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $req->user()->use_id]);
                });
            });
            $ids = $query->get()->pluck('use_id')->toArray();
        }

        $orderDetaildb = ( new OrderDetail)->getTable();
        $productdb = (new Product)->getTable();
        $query = OrderDetail::where([]);
        if ($req->user()->use_group == User::TYPE_AffiliateStoreUser) {
            $query->where(function($q) use($orderDetaildb, $req) {
                $q->where([$orderDetaildb . '.shc_saler' => $req->user()->use_id, 'pro_of_shop' => 0]);
                if (!empty($ids)) {
                    $q->orWhereRaw('(tbtt_showcart.shc_saler IN(' . implode(",", $ids) . ') AND pro_of_shop>0)');
                }
            });
        } else {
            $query->where([$orderDetaildb . '.shc_saler' => $req->user()->use_id]);
        }

        $query->join($productdb, $productdb . '.pro_id', $orderDetaildb . '.shc_product')
            ->with('product')->with('category');
        $query->where($orderDetaildb . '.shc_status', '!=', Order::STATUS_CANCEL);
        $query->where($orderDetaildb . '.shc_change_status_date', '>=', $firstday);
        $query->where($orderDetaildb . '.shc_change_status_date', '<=', $currentday);

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;


        $results = $query->paginate($limit, ['*'], 'page', $page);
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }
    
             /**
     * @SWG\Get(
     *     path="/api/v1/me/income/provisional",
     *     operationId="income",
     *     description="Thu nhập của nhân viên affiliate",
     *     produces={"application/json"},
     *     tags={"Revenue-income"},
     *     summary="Thu nhập của nhân viên affiliate",
     *     @SWG\Parameter(
     *         name="month",
     *         in="query",
     *         description="Lọc theo tháng",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="year",
     *         in="query",
     *         description="Lọc theo năm",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description=" total result"
     *     )
     * )
     */
    public function provisional(Request $req) {
        
        $firstday = mktime(0, 0, 0, date("m"), 1, date("Y"));
        $currentday = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
        $orderDetaildb = OrderDetail::tableName();
        $productdb = Product::tableName();
        $productDetaildb = DetailProduct::tableName();
        $query = OrderDetail::where([]);
        $totalRevenueQ = DB::raw('IF('.$orderDetaildb.'.af_rate>0,('.$orderDetaildb.'.af_rate * ('.$orderDetaildb.'.shc_total+'.$orderDetaildb.'.em_discount))/100,'.$orderDetaildb.'.af_amt * shc_quantity)');
        $query->select($orderDetaildb.'.*',DB::raw('IF('.$orderDetaildb.'.af_rate>0,('.$orderDetaildb.'.af_rate * ('.$orderDetaildb.'.shc_total+'.$orderDetaildb.'.em_discount))/100,'.$orderDetaildb.'.af_amt * shc_quantity) as totalRevenue'));
        $query->join($productdb, $productdb . '.pro_id', $orderDetaildb . '.shc_product');
            
        $query->whereIn($orderDetaildb . '.shc_status', ['01', '02', '03', '98']);
      
        $query->leftJoin($productDetaildb, $productDetaildb . '.id', $orderDetaildb . '.shc_dp_pro_id');
        $query->where('tbtt_showcart.af_id', $req->user()->use_id);
        if ($req->month && $req->year) {
            $firstday = mktime(0, 0, 0, $req->month, 1, $req->year);
            $currentday = strtotime('first day of next month', $firstday);
        }
        $query->where($orderDetaildb . '.shc_change_status_date', '>=', $firstday);
        $query->where($orderDetaildb . '.shc_change_status_date', '<=', $currentday);
        if ($req->sum) {
            $result = $query->sum($totalRevenueQ);
            
            return response([
                'msg' => Lang::get('response.success'),
                'data' => [
                    'totalRevenue'=>$result
                ]
            ]);
        }
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $query->with('product','category');
        

        $results = $query->paginate($limit, ['*'], 'page', $page);
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/income/provisional_store_cat",
     *     operationId="income",
     *     description="Thu nhập tạm tính theo danh mục",
     *     produces={"application/json"},
     *     tags={"Revenue-income"},
     *     summary="Thu nhập tạm tính theo danh mục",
     *        @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="sum",
     *         in="query",
     *         description="sum=1",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Gioi han",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description=" total result"
     *     )
     * )
     */
    public function provisionalStroreByCat(Request $req) {
        
        $isWed = date('D', time());
         $isWed = date('D', time());
        if ($isWed == 'Wed') {
            $firstday = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
            $currentday = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
        } else {
            $startday = strtotime("-1 week");
            for ($i = $startday; $i <= time(); $i += 86400) {
                if ($this->isWed($i)) {
                    $firstday = mktime(0, 0, 0, date("m", $i), date("d", $i), date("Y", $i));
                    $currentday = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
                    break;
                }
            }
        }
        $ids = [];
        if ($req->user()->use_group == User::TYPE_AffiliateStoreUser) {

//        $tree[] = (int)$this->session->userdata('sessionUser');
            $query = User::where(['use_status' => User::STATUS_ACTIVE]);
            $query->select('use_id');
            $query->where(function($q) use($req) {
                $q->orWhere(function($q) use($req) {
                    $q->whereIn('use_group', [User::TYPE_BranchUser]);
                    $q->where(['use_status' => User::STATUS_ACTIVE]);
                    $q->where(function($q ) use($req) {
                        $q->where(['parent_id' => $req->user()->use_id]);
                        $q->orWhereIn('parent_id', function($q3) use($req) {
                            $q3->select('use_id');
                            $q3->from((new User)->getTable());
                            $q3->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                            $q3->where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $req->user()->use_id]);
                        });
                    });
                });
                $q->orWhere(function($q) use($req) {
                    $q->whereIn('use_group', [User::TYPE_BranchUser]);
                    $q->where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $req->user()->use_id]);
                });
            });


            $ids = $query->get()->pluck('use_id')->toArray();
        }


        $orderDetaildb = (new OrderDetail)->getTable();
        $categorydb = (new Category)->getTable();
        $productdb = (new Product)->getTable();
        
        $query = OrderDetail::where([]);
        if ($req->user()->use_group == User::TYPE_AffiliateStoreUser) {
            $query->where(function($q) use($orderDetaildb,$req,$ids){
                $q->where([$orderDetaildb.'.shc_saler'=>$req->user()->use_id,'pro_of_shop'=>0]);
    
                if(!empty($ids)){
                    $q->orWhereRaw('('.$orderDetaildb.'.shc_saler IN(' . implode(",",$ids). ') AND pro_of_shop>0)');
                }
            });
            
        }else{
            $query->where([$orderDetaildb.'.shc_saler'=>$req->user()->use_id]);
        }
        $query->join($productdb, $productdb . '.pro_id', $orderDetaildb . '.shc_product')
            ->leftJoin($categorydb, $categorydb . '.cat_id', $orderDetaildb . '.pro_category');
       
        $query->whereIn($orderDetaildb . '.shc_status', ['01', '02', '03', '98']);
        $select = DB::raw('tbtt_showcart.*, tbtt_product.pro_name, tbtt_product.pro_image, tbtt_product.pro_dir, tbtt_product.pro_cost, tbtt_product.pro_category, tbtt_detail_product.*', $categorydb . '.*');
        $selectAfCondtionTrue = "IF(tbtt_showcart.em_discount > 0,
            tbtt_showcart.shc_total - ((tbtt_showcart.shc_total + tbtt_product.em_discount) * (tbtt_product.af_rate / 100)),
             (tbtt_showcart.shc_total) * (1 - (tbtt_product.af_rate / 100)))";
        $selectAfCondtionFalse = 'tbtt_showcart.shc_total - (tbtt_showcart.af_amt * tbtt_showcart->shc_quantity)';
        $selectAf = 'IF(tbtt_showcart.af_rate > 0,' . $selectAfCondtionTrue . ',' . $selectAfCondtionFalse . '  )';

        $selectTotal = 'IF (
			tbtt_showcart.af_id > 0
			AND (
				tbtt_showcart.af_rate > 0
				OR tbtt_showcart.af_amt > 0
			),

		IF (
			tbtt_showcart.af_rate > 0,

		IF (
			tbtt_showcart.em_discount > 0,
			tbtt_showcart.shc_total - (
				(
					tbtt_showcart.shc_total + tbtt_showcart.em_discount
				) * (tbtt_showcart.af_rate / 100)
			),
			(tbtt_showcart.shc_total) * (1 - (tbtt_product.af_rate / 100))
		),
		tbtt_showcart.shc_total - (tbtt_showcart.af_amt * tbtt_showcart.shc_quantity)
		),
		tbtt_showcart.shc_total
		)';
        $sumTotal = DB::raw('SUM(' . $selectTotal . ') as total_price_all');
        $query->select(DB::raw('sum(pro_price*shc_quantity) as total_price, tbtt_showcart.*,tbtt_category.cat_name, tbtt_category.cat_id'),$sumTotal);
        $query->groupBy($orderDetaildb . '.pro_category');
        $query->where($orderDetaildb . '.shc_change_status_date', '>=', $firstday);
        $query->where($orderDetaildb . '.shc_change_status_date', '<=', $currentday);
        if ($req->sum) {
            $total_re = 0;
            $total_com = 0;
            $totalall = 0;
            $categories = $query->get();
            foreach ($categories as $item) {
                $item->category->findParent();
                $parentCategory = $this->findParentByID($item->category);

                $total_re += $item->total_price - (($item->total_price * $parentCategory['b2c_fee']) / 100);
                $total_com += ($item->total_price * $parentCategory['b2c_fee']) / 100; //Hoa hồng trả cho
                $totalall += $item->total_price_all; // tong tien nhan
               
            }
            
            $totalre = $totalall - $total_com;
            return response([
                'msg' => Lang::get('response.success'),
                'data' => [
                    'totalGot'=>$totalre,//Tổng tiền bán hàng
                    'totalAmount'=>$totalall,
                    'totalCommission'=>$total_com
                ]
            ]);
        }
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        $results = [];
        
        foreach ($paginate->items() as $item) {
            
            $item->category->findParent();
            $data = $item->toArray();
            $results[] = $data;
        }
        $result = $paginate->toArray();
        $result['data'] = $results;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/income/{id}/category",
     *     operationId="income",
     *     description="Doanh thu gian hàng theo danh mục",
     *     produces={"application/json"},
     *     tags={"Revenue-income"},
     *     summary="Doanh thu theo danh mục",
     *        @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="sum",
     *         in="query",
     *         description="sum=1",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Gioi han",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description=" total result"
     *     )
     * )
     */
    public function detailCategory($id, Request $req) {
        $money = Money::find($id);
        $categrydb = Category::tableName();
        $moneydb = RevenueStoreCategoryWeekly::tableName();
        $query = RevenueStoreCategoryWeekly::where([
            'rsc_created_date_str' => date("d-m-Y", strtotime($money->created_date)),
            'rsc_shop_id' => $req->user()->use_id
        ])->whereIn('rsc_type', ['02','05'])->join($categrydb,$categrydb.'.cat_id',$moneydb.'.rsc_category_id');
        $query->select($categrydb.'.cat_name',$moneydb.'.*');
        if ($req->sum) {
           $totalProfit = $query->sum('rsc_profit');
           $totalRevenue = $query->sum('rsc_revenue');
           $totalWithOutProfit = $totalRevenue  - $totalProfit;
           
           return response([
                'msg' => Lang::get('response.success'),
                'data' => [
                    'paidToAzibai' => (float)$totalProfit,
                    'totalWithOutProfit'=>(float)$totalWithOutProfit,
                    'totalRevenue'=>(float)$totalRevenue
                ]
            ]);
        }
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $paginate
        ]);
    }
    
        /**
     * @SWG\Get(
     *     path="/api/v1/me/income/{id}/revenue-order",
     *     operationId="income",
     *     description="Doanh thu gian hàng theo chi tiết order",
     *     produces={"application/json"},
     *     tags={"Revenue-income"},
     *     summary="Doanh thu theo danh mục",
     *        @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="sum",
     *         in="query",
     *         description="sum=1",
     *         required=false,
     *         type="integer",
     *     ),
    *     @SWG\Parameter(
     *         name="getConmission",
     *         in="query",
     *         description="getConmission=1 Lấy hoa hồng từ sản phẩm",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Gioi han",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description=" total result"
     *     )
     * )
     */
    public function provisionalOrder($id, Request $req) {
        $userId = $req->user()->use_id;
        $money = Money::where(['id' => $id])->first();
        
        $m_end = strtotime($money->created_date);
        $m_start = $m_end - 604800;

        $oderdtdb = (new OrderDetail)->getTable();
        $productdb = (new Product)->getTable();
        $shopdb = (new Shop)->getTable();
        $query = OrderDetail::where([])->orderBy('shc_id', 'DESC')->with(['product','category'])->select($oderdtdb.'.*');
        $query->join($productdb, $productdb . '.pro_id', $oderdtdb . '.shc_product');
        if ($req->user()->use_group == User::TYPE_AffiliateUser) {
            $query->where('af_id', $userId);
            $money_create_date = strtotime($money->created_date);
            $m_end = strtotime('first day of this month', $money_create_date);
            $m_start = strtotime('first day of last month', $money_create_date);

            $query->join($shopdb, 'sho_user', 'shc_saler')->with('shop');
        } elseif ($req->user()->use_group == User::TYPE_AffiliateStoreUser) {
            $query->where('shc_saler', $userId)->with('shop')->with('buyer');
        }
        $query->where('shc_change_status_date', '>=', $m_start);
        $query->where('shc_change_status_date', '<=', $m_end);
        $query->where('shc_status', Order::STATUS_SUCCESS);
        if (!empty($req->sum)) {
            $qItem = clone $query;
            $qItem->select($oderdtdb . '.*', DB::raw('SUM(IF(' . $oderdtdb . '.af_amt > 0,' . $oderdtdb . '.shc_quantity * ' . $oderdtdb . '.af_amt,(' . $oderdtdb . '.af_rate / 100) * ' . $oderdtdb . '.shc_total)) as total'));
            $af_money_item = $qItem->first();
            $totalPaidForAff = 0;
            if (!empty($af_money_item)) {
                $totalPaidForAff = $af_money_item->total;
            }
            $total = $query->sum('shc_total');
            return response([
                'msg' => Lang::get('response.success'),
                'data' => [
                    'totalPaidForAff' => (float) $totalPaidForAff,
                    'totalAmount' => (float) $total
                ]
            ]);
        }
        if(!empty($req->getConmission)){
            $query->where('af_id','>',0);
        }
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
       
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $paginate
        ]);
    }
          /**
     * @SWG\Get(
     *     path="/api/v1/me/income/{id}",
     *     operationId="income",
     *     description="Doanh thu chi tiết",
     *     produces={"application/json"},
     *     tags={"Revenue-income"},
     *     summary="Doanh thu chi tiết",
     *     @SWG\Response(
     *         response=200,
     *         description=" total result"
     *     )
     * )
     */
    public function provisionDetail($id, Request $req) {
        $userId = $req->user()->use_id;
        $money = Money::where(['id'=>$id, 'user_id' => $userId])->first();
        $m_end = strtotime($money->created_date);
        $m_start = $m_end - 604800;
        if ($req->user()->use_group == User::TYPE_AffiliateUser) {

            $money_create_date = strtotime($money->created_date);
            $m_end = strtotime('first day of this month', $money_create_date);
            $m_start = strtotime('first day of last month', $money_create_date);
        }
        $money = $money->toArray();
        $money['starDate'] = $m_start;
        $money['endDate'] = $m_end;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $money
        ]);
    }
    
    
    function findParentByID($cat)
    {
        
        if (!empty($cat)) {
            $calv =  $cat;
            
            if ($calv && $calv->cat_level == 4) {

                $catlv3 = Category::where(['cat_level' => 3, 'cat_id' => $calv->parent_id])->first();
                if (!empty($catlv3)) {
                    $catlv2 = Category::where(['cat_level' => 2, 'cat_id' => $catlv3->parent_id])->first();
                    if (!empty($catlv2)) {
                        $catlv1 = Category::where(['cat_level' => 1, 'cat_id' => $catlv2->parent_id])->first();
                        return $catlv1;
                    }else{
                        return $catlv3;
                    }
                } else {
                    return $calv;
                }


                return $catlv1;
            } elseif ($calv && $calv->cat_level == 3) {
                $catlv2 = Category::where(['cat_level' => 2, 'cat_id' => $calv->parent_id])->first();
                if (!empty($catlv2)) {
                    $catlv1 = Category::where(['cat_level' => 1, 'cat_id' => $catlv2->parent_id])->first();
                    return $catlv1;
                }
                return $catlv2;

                return $catlv1;
            } elseif ($calv && $calv->cat_level == 2) {
                $catlv1 = Category::where(['cat_level' => 1, 'cat_id' => $calv->parent_id])->first();
                return $catlv1;
            }
            return $calv;
        }
    }


}
