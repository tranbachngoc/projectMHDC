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
use App\Models\Shop;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Category;

class StaticController extends ApiController {
         /**
     * @SWG\Get(
     *     path="/api/v1/me/revenue",
     *     operationId="revenue",
     *     description="Doanh thu",
     *     produces={"application/json"},
     *     tags={"Statics-Revenue"},
     *     summary="Thống kê Doanh số",
     *     @SWG\Parameter(
     *         name="thisMonth",
     *         in="query",
     *         description="Lọc theo tháng này  thisMonth should be = 1",
     *         required=false,
     *         type="integer",
     *     ),
     *        @SWG\Parameter(
     *         name="lastDay",
     *         in="query",
     *         description="Lọc theo ngày hôm qua should be = 1",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="lastMonth",
     *         in="query",
     *         description="Lọc theo tháng trước should be = 1",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="sumAll",
     *         in="query",
     *         description="sunAll = 1 tính tổng doanh số",
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
             $userdb = User::tableName();
        $currentDate_first = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $currentDate_after = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        $user = $req->user();
        $userId = $req->user()->use_id;
        $tree = [$userId];
        $queryUser = User::where(['use_status' => User::STATUS_ACTIVE]);
        $queryUser->where(function($q) use($userdb, $user) {
            $q->orWhere(function($q) use($userdb, $user) {
                $q->where('use_group', User::TYPE_StaffUser);
                $q->whereIn('parent_id', function($q) use($userdb, $user) {
                    $q->select('use_id');
                    $q->from($userdb);
                    $q->where('use_status', User::STATUS_ACTIVE);
                    $q->where(['use_group' => User::TYPE_BranchUser]);
                    $q->whereIn('parent_id', function($q) use($userdb, $user) {
                        $q->select('use_id');
                        $q->from($userdb);
                        $q->where('use_status', User::STATUS_ACTIVE);
                        $q->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                        $q->where('parent_id', $user->use_id);
                    });
                });
            });

            $q->orWhere(function($q) use ($userdb, $user) {
                $q->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffUser]);
                $q->whereIn('parent_id', function($q) use($userdb, $user) {
                    $q->select('use_id');
                    $q->from($userdb);
                    $q->where('use_status', User::STATUS_ACTIVE);
                    $q->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                    $q->where('parent_id', $user->use_id);
                });
            });
//            
            $q->orWhere(function($q) use($userdb, $user) {
                $q->select('use_id');
                $q->from($userdb);
                $q->where('use_status', User::STATUS_ACTIVE);
                $q->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser, User::TYPE_StaffUser]);
                $q->where('parent_id', $user->use_id);
            });

            $q->orWhere(function($q) use ($userdb, $user) {
                $q->whereIn('use_group', [User::TYPE_StaffUser]);
                $q->whereIn('parent_id', function($q) use($userdb, $user) {
                    $q->select('use_id');
                    $q->where('use_status', User::STATUS_ACTIVE);
                    $q->from($userdb);
                    $q->whereIn('use_group', [User::TYPE_BranchUser]);
                    $q->where('parent_id', $user->use_id);
                });
            });
        });
        $listUser = $queryUser->get()->pluck('use_id')->toArray();
      
        $whereAff = [];
        $ids = array_merge($tree, $listUser);
        if ($user->use_group == User::TYPE_StaffStoreUser) {
            $queryAff = User::where(['use_group' => User::TYPE_AffiliateUser]);
            $queryAff->whereIn('parent_id', $ids);
            $whereAff = $queryAff->get()->pluck('use_id')->toArray();
        }
        $query = Order::where([]);
        //$query = Order::whereIn('order_saler', $ids);
        if (in_array($user->use_group, [User::TYPE_StaffStoreUser, User::TYPE_StaffUser, User::TYPE_AffiliateUser])) {
            $queryAff = User::where(['use_group' => User::TYPE_AffiliateUser]);
            $queryAff->whereIn('parent_id', $ids);
            $or_saler = [];
            if (!empty($user->parent_id)) {
                $or_saler = [$user->parent_id];
            }
            $getafALL = $queryAff->get()->pluck('use_id')->toArray();
            if (!empty($getafALL)) {
                $ids = array_merge($ids, $getafALL);
            }
            $or_saler_all = array_merge($or_saler, $ids);
            if ($user->use_group == User::TYPE_AffiliateUser) {
                $query->whereIn('tbtt_showcart.af_id', $or_saler_all);
            } else {
                $p_saler = [$user->use_id];
                if (!empty($user->parent_id)) {
                    $p_saler = array_merge($p_saler, [$user->parent_id]);
                }
                if ($user->use_group != User::TYPE_StaffUser) {
                    $p_saler = array_merge($ids, $p_saler);
                    $query->where(function($q) use($or_saler_all, $p_saler) {
                        $q->orWhereIn('order_saler', $p_saler);
                        $q->orWhereIn('tbtt_showcart.af_id', $or_saler_all);
                    });
                } else {
                    $query->whereIn('tbtt_showcart.af_id', $or_saler_all);
                }
            }
        } else {
            $query = Order::whereIn('order_saler', $ids);
        }
        if (in_array($user->use_group, [User::TYPE_AffiliateStoreUser, User::TYPE_StaffStoreUser, User::TYPE_StaffUser])) {
            $tree2 = [];
            $GH = $user->use_id;
            if (in_array($user->use_group, [User::TYPE_StaffStoreUser, User::TYPE_StaffUser])) {
                $tree2[] = $GH = $user->parent_id;
                if ($user->use_group == User::TYPE_StaffUser) {
                    //TODO
                }
            }
            $sub_tructiep = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser])
                    ->select(DB::raw('use_id, use_username, use_group'))
                    ->where('use_status', User::STATUS_ACTIVE)
                    ->where('parent_id', $user->parent_id)->get();
            if (!empty($sub_tructiep)) {
                foreach ($sub_tructiep as $key => $value) {
                    //Nếu là chi nhánh, lấy danh sách nhân viên

                    if ($value->use_group == User::TYPE_StaffStoreUser) {
                        //Lấy danh sách CN dưới nó cua NVGH
                        $sub_cn = User::whereIn('use_group', [User::TYPE_BranchUser])
                                ->where('use_status', User::STATUS_ACTIVE)
                                ->where('parent_id', $value->use_id)->get();

                        if (!empty($sub_cn)) {
                            foreach ($sub_cn as $k => $vlue) {
                                $tree2[] = $vlue->use_id;
                            }
                        }
                    } else {
                        $tree2[] = $value->use_id;
                    }
                }
            }

            if (!empty($tree2)) {
                $query->where(function($q) use($GH, $tree2) {
                    $q->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
                    $q->orWhere(function($q) use ($tree2) {
                        $q->whereIn('tbtt_showcart.shc_saler', $tree2);
                        $q->where('pro_of_shop', '>', 0);
                    });
                });
            } else {
                $query->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
            }
            if ($user->use_group == User::TYPE_StaffStoreUser) {
                $query->where(function($q) use($whereAff) {
                    $q->where(function($q) {
                        $q->where('tbtt_user.use_group', '<>', User::TYPE_AffiliateStoreUser);
                        $q->where('tbtt_showcart.af_id', 0);
                    });
                    $q->orWhere(function($q) use($whereAff) {
                        $q->where('tbtt_showcart.af_id', '>', 0);
                        $q->whereIn('tbtt_showcart.af_id', $whereAff);
                    });
                });
            }
        } else {
            if ($user->use_group == User::TYPE_BranchUser) {

                //$query->where('tbtt_showcart.shc_saler', $user->use_id); // NOTED
            }
        }

        if ($req->lastMonth) {
            $last_month = date("Y-m", strtotime("-1 month"));
            $currentDate_first = strtotime($last_month . '-01 00:00:00');
            $currentDate_after = strtotime($last_month . '-' . date("t", strtotime($last_month . '-01')) . ' 23:59:59');
        }
        if ($req->lastDay) {
            $currentDate_first = strtotime(date("Y-m-d", strtotime("-1 day")));
            $currentDate_after = strtotime(date("Y-m-d", strtotime("-1 day")) . ' 23:59:00');
        }
        if ($req->thisMonth) {
            $currentDate_after = strtotime(date("Y-m-d H:i:s"));
            $currentDate_first = strtotime(date("Y-m-01") . ' 00:00:00');
        }
        $type = 0;
        if ($req->type) {
            $type = $req->type;
        }

        $query->whereIn('order_status', [Order::STATUS_PENDING, Order::STATUS_ON_TRANS, Order::STATUS_RECIVICE, Order::STATUS_SUCCESS]);
        if(!$req->sumAll){
            $query->where('change_status_date', '>=', $currentDate_first);
            $query->where('change_status_date', '<=', $currentDate_after);
        }
        $query->join('tbtt_showcart', 'tbtt_showcart.shc_orderid', 'tbtt_order.id');
        $query->leftJoin('tbtt_product', 'tbtt_product.pro_id', 'tbtt_showcart.shc_product');
        $query->leftJoin('tbtt_user', 'tbtt_product.pro_user', 'tbtt_user.use_id');
        $result = $query->sum('shc_total');
        
        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'total'=>$result
            ]
        ]);
    }
    
    public function revenueV1(Request $req)   {
        $userId = $req->user()->use_id;
        if ($req->user()->use_group > User::TYPE_AffiliateStoreUser) {
            $usersId = $this->getUsersTree($userId);
        } else {
            $usersId = [$userId];
        }
        $begin_date = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $end_date = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        if ($req->lastMonth) {
            $last_month = date("Y-m", strtotime("-1 month"));
            $begin_date = strtotime($last_month . '-01 00:00:00');
            $end_date = strtotime($last_month . '-' . date("t", strtotime($last_month . '-01')) . ' 23:59:59');
        }
        if ($req->lastDay) {
            $begin_date = strtotime(date("Y-m-d", strtotime("-1 day")));
            $end_date = $begin_date + 86400;
        }
        if ($req->thisMonth) {
            $end_date = strtotime(date("Y-m-d H:i:s"));
            $begin_date = strtotime(date("Y-m-01") . ' 00:00:00');
            
        }
        $type = 0;
        if ($req->type) {
            $type = $req->type;
        }
        
        // dump($req->user());
        $query = Order::where([]);
        if($req->user()->use_group == 2){
            $query->join('tbtt_showcart','tbtt_showcart.shc_orderid','tbtt_order.id');
            $query->whereIn('tbtt_showcart.af_id', $usersId);
        }else{
        $query = Order::whereIn('order_saler', $usersId);
        }
        $query->whereIn('order_status', [Order::STATUS_PENDING, Order::STATUS_ON_TRANS, Order::STATUS_RECIVICE, Order::STATUS_SUCCESS]);
        $query->where('change_status_date', '<=', $end_date);
        $query->where('change_status_date', '>=', $begin_date);
        $result = $query->sum('order_total_no_shipping_fee');
        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'total'=>$result
            ]
        ]);
    }
         /**
     * @SWG\Get(
     *     path="/api/v1/me/revenue-analysis",
     *     operationId="revenueAnalysis",
     *     description="Phân tích Doanh thu",
     *     produces={"application/json"},
     *     tags={"Statics-Revenue"},
     *     summary="Phân tích Doanh thu",
     *   @SWG\Parameter(
     *         name="groupBy",
     *         in="query",
     *         description="Lấy danh sách doanh thu theo tháng ngày năm (day,month,year)",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="thisMonth",
     *         in="query",
     *         description="Lọc theo tháng này  thisMonth should be = 1",
     *         required=false,
     *         type="integer",
     *     ),
     *        @SWG\Parameter(
     *         name="lastDay",
     *         in="query",
     *         description="Lọc theo ngày hôm qua should be = 1",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="lastMonth",
     *         in="query",
     *         description="Lọc theo tháng trước should be = 1",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description=" array result"
     *     )
     * )
     */
    public function revenueAnalysis(Request $req){
          $userId = $req->user()->use_id;
        if ($req->user()->use_group == User::TYPE_AffiliateStoreUser) {
            $usersId = $this->getUsersTree($userId);
        } else {
            $usersId = [$userId];
        }
        $begin_date = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $end_date = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        if ($req->lastMonth) {
            $last_month = date("Y-m", strtotime("-1 month"));
            $begin_date = strtotime($last_month . '-01 00:00:00');
            $end_date = strtotime($last_month . '-' . date("t", strtotime($last_month . '-01')) . ' 23:59:59');
        }
        if ($req->lastDay) {
            $begin_date = strtotime(date("Y-m-d", strtotime("-1 day")));
            $end_date = $begin_date + 86400;
        }
        if ($req->thisMonth) {
            $end_date = strtotime(date("Y-m-d 23:59:59"));
            $begin_date = strtotime(date("Y-m-01") . ' 00:00:00');
        }
        $type = 0;
        if ($req->type) {
            $type = $req->type;
        }
        
        $query = Order::whereIn('order_saler', $usersId);
        $query->whereIn('order_status', [Order::STATUS_PENDING, Order::STATUS_ON_TRANS, Order::STATUS_RECIVICE, Order::STATUS_SUCCESS]);
        $query->where('change_status_date', '<=', $end_date);
        $query->where('change_status_date', '>=', $begin_date);
        //$query->sum('order_total_no_shipping_fee');
        $sum = 'SUM(order_total_no_shipping_fee) as total';
        $options = 'day';
        if ($req->groupBy) {
            $options = $req->groupBy;
        }
        switch ($options) {
            case "day":
                $query->select(DB::raw("DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date," . $sum));
                $query->groupBy(DB::raw("DATE(FROM_UNIXTIME(`change_status_date`))"));
                break;
            case 'month':
                $query->select(DB::raw("MONTH(FROM_UNIXTIME(`change_status_date`)) AS updated_date," . $sum));
                $query->groupBy(DB::raw("MONTH(FROM_UNIXTIME(`change_status_date`))"));
                break;
            case 'year':
                $query->select(DB::raw("YEAR(FROM_UNIXTIME(`change_status_date`)) AS updated_date," . $sum));
                $query->groupBy(DB::raw("YEAR(FROM_UNIXTIME(`change_status_date`))"));
                break;
            default:
                $query->select(DB::raw("DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date," . $sum));
                $query->groupBy(DB::raw("DATE(FROM_UNIXTIME(`change_status_date`))"));
                break;
        }
        $result = $query->get();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }
    
    protected  function getUsersTree($userId){
//        $countAF = $this->countAF($userId);
//        $data['countAF'] = count($countAF);
        $countShop = $this->shop_tree($userId);
//        $data['countShop'] = count($countShop);
          
        return array_merge([$userId], $countShop);
    }
    
    
     /**
     * @SWG\Get(
     *     path="/api/v1/me/revenue-earnings",
     *     operationId="revenueAnalysis",
     *     description="Thu nhập hiện tại",
     *     produces={"application/json"},
     *     tags={"Statics-Revenue"},
     *     summary="Thu nhập hiện tại",
     *     @SWG\Response(
     *         response=200,
     *         description=" array result"
     *     )
     * )
     */

    public function earning(Request $req) {
        
        
        $userId = $req->user()->use_id;
        if ($req->user()->use_group == User::TYPE_AffiliateStoreUser) {
            $usersId = $this->getUsersTree($userId);
        } else {
            $usersId = [$userId];
        }

        $query = Money::whereIn('user_id', $usersId);
        $query->where('amount', '>', 0);
        $result = $query->sum('amount');
        
        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'total' => $result
            ]
        ]);
    }
        
      /**
     * @SWG\Get(
     *     path="/api/v1/me/revenue-earning-analysis",
     *     operationId="statisticIncome",
     *     description="Thống kê thu nhập",
     *     produces={"application/json"},
     *     tags={"Statics-Revenue"},
     *     summary="Thống kê thu nhập",
     *    @SWG\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Ngày bắt đầu format 2011-12-30",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Ngày bắt đầu format 2011-12-30",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="groupBy",
     *         in="query",
     *         description="Theo month/year",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description=" array result"
     *     )
     * )
     */
    public function earningAnalysis(Request $req) {
        $userId = $req->user()->use_id;
        if ($req->user()->use_group > User::TYPE_AffiliateStoreUser) {
            $usersId = $this->getUsersTree($userId);
        } else {
            $usersId = [$userId];
        }

        $query = Money::whereIn('user_id', $usersId);
        
        $groupSelect = [];
        $groupSelect[] = 'YEAR(`created_date`) as year';
        $groupSelect[] = 'WEEK(`created_date`, 5) -
        WEEK(DATE_SUB(`created_date`, INTERVAL DAYOFMONTH(`created_date`) - 1 DAY), 5) + 1 as week';
        $groupSelect[] = 'MONTH((`created_date`)) as month';
        
        $group = ['year','month','week'];
        if ($req->groupBy == 'month') {
            $groupSelect = [];
            $groupSelect[] = 'YEAR(`created_date`) as year';
            $groupSelect[] = 'MONTH(`created_date`) as month';
            $group = ['month', 'year'];
        }
        if ($req->groupBy == 'year') {
            $groupSelect = [];
            $groupSelect[] = 'YEAR(`created_date`) as year';
            $group = ['year'];
        }
        
        if (!empty($req->startDate)) {
            $query->whereDate('created_date', '>=', $req->startDate);
        }
        if (!empty($req->endDate)) {
            $query->whereDate('created_date', '<=', $req->endDate);
        }
        if (empty($req->startDate) && empty($req->endDate)) {
       //     $query->whereRaw('RIGHT(`month_year`, 4) =' . date('Y'));
        }
        $query->groupBy($group);
        
        $query->where('amount', '>', 0);
        $query->select("created_date",DB::raw('SUM(amount) as total'),DB::raw(implode(', ', $groupSelect)));
        $result = $query->get();
       
        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'total' => $result
            ]
        ]);
    }
    
    public function earningAnalysisMainV(Request $req) {
        $userId = $req->user()->use_id;
        $user = $req->user();
        if ($req->user()->use_group > User::TYPE_AffiliateStoreUser) {
            $usersId = $this->getUsersTree($userId);
        } else {
            $usersId = [$userId];
        }
        $producdb = Product::tableName();
        $userdb = User::tableName();
        $categorydb = Category::tableName();
        $orderdb = Order::tableName();
        $orderdtdb = OrderDetail::tableName();
        $query = OrderDetail::where([]);
        $query->join($producdb, $orderdtdb . '.shc_product', $producdb . '.pro_id');
        $query->join($userdb, $userdb . '.use_id', $producdb . '.pro_user');
        $query->join($orderdb, $orderdb . '.id', $orderdtdb . '.shc_orderid');
        $query->leftJoin($categorydb, $categorydb . '.cat_id', $orderdtdb . '.pro_category');


        if (in_array($user->use_group, [User::TYPE_AffiliateStoreUser, User::TYPE_StaffStoreUser])) {
            $tree = array();
            $GH = $usersId;
            if ($user->use_group == User::TYPE_StaffStoreUser) {

                $tree[] = $GH = $user->parent_id;
            }
            $sub_tructiep = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser])
                    ->where('use_status', User::STATUS_ACTIVE)
                    ->where('parent_id', $user->use_id)->get();

            if (!empty($sub_tructiep)) {
                foreach ($sub_tructiep as $key => $value) {
                    //Nếu là chi nhánh, lấy danh sách nhân viên

                    if ($value->use_group == User::TYPE_StaffStoreUser) {
                        //Lấy danh sách CN dưới nó cua NVGH
                        $sub_cn = User::whereIn('use_group', [User::TYPE_BranchUser])
                                ->where('use_status', User::STATUS_ACTIVE)
                                ->where('parent_id', $value->use_id)->get();

                        if (!empty($sub_cn)) {
                            foreach ($sub_cn as $k => $vlue) {
                                $tree[] = $vlue->use_id;
                            }
                        }
                    } else {
                        $tree[] = $value->use_id;
                    }
                }
            }

            if (!empty($tree)) {
                $query->where(function($q) use($GH, $tree) {
                    $q->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
                    $q->orWhere(function($q) use ($tree) {
                        $q->whereIn('tbtt_showcart.shc_saler', $tree);
                        $q->where('pro_of_shop', '>', 0);
                    });
                });
            } else {
                $query->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
            }
        } else {
            if ($user->use_group == User::TYPE_AffiliateUser) {
                $query->where(['tbtt_showcart.af_id' => $user->use_id]);
            } else {
                $query->where(['tbtt_showcart.shc_saler' => $user->use_id]);
            }
        }
        $groupSelect = [];
        $groupSelect[] = 'YEAR(FROM_UNIXTIME(`change_status_date`)) as year';
        $groupSelect[] = 'WEEK(FROM_UNIXTIME(`change_status_date`), 5) -
        WEEK(DATE_SUB(FROM_UNIXTIME(`change_status_date`), INTERVAL DAYOFMONTH(FROM_UNIXTIME(`change_status_date`)) - 1 DAY), 5) + 1 as week';
        $groupSelect[] = 'MONTH(FROM_UNIXTIME(`change_status_date`)) as month';

        $group = ['year', 'month', 'week'];
        if ($req->groupBy == 'month') {
            $groupSelect = [];
            $groupSelect[] = 'YEAR(FROM_UNIXTIME(`change_status_date`)) as year';
            $groupSelect[] = 'MONTH(FROM_UNIXTIME(`change_status_date`)) as month';
            $group = ['month', 'year'];
        }
        if ($req->groupBy == 'year') {
            $groupSelect = [];
            $groupSelect[] = 'YEAR(FROM_UNIXTIME(`change_status_date`)) as year';
            $group = ['year'];
        }

        if (!empty($req->startDate)) {
            $query->where('change_status_date', '>=', strtotime($req->startDate));
        }
        if (!empty($req->endDate)) {
            $query->where('change_status_date', '<=', strtotime($req->endDate . ' 23:59:59'));
        }
        if (empty($req->startDate) && empty($req->endDate)) {
            $daunam = strtotime(date("Y-01-01 00:00:00"));
            $end_date = strtotime(date("Y-m-d 23:59:00"));
            
            $query->where('change_status_date', '>=', $daunam);
            $query->where('change_status_date', '<=', $end_date);
        }
       // $query->groupBy($group);
        if ($user->use_group == User::TYPE_AffiliateUser) {
            $mainSelect = 'tbtt_category.cat_id,shc_total,tbtt_showcart.af_id,DATE(FROM_UNIXTIME(change_status_date)) as created_date, tbtt_showcart.af_amt, tbtt_showcart.af_rate,((shc_total +em_discount)*tbtt_showcart.af_rate)/100 AS HoahongPT, tbtt_showcart.af_amt*tbtt_showcart.shc_quantity as HoahongTien ,' . implode(', ', $groupSelect);
        } else {
            $mainSelect = 'tbtt_category.cat_id, shc_total,tbtt_showcart.af_id,DATE(FROM_UNIXTIME(change_status_date)) as created_date, tbtt_showcart.af_amt, tbtt_showcart.af_rate, 
            shc_total - (shc_total+em_discount) * tbtt_showcart.af_rate/100 as HoahongPT, 
            shc_total - (tbtt_showcart.af_amt*tbtt_showcart.shc_quantity) as HoahongTien, em_discount,' . implode(', ', $groupSelect);
        }
       

        $findCateParentQ = Category::select(DB::raw('IF(`b2c_fee` IS NULL,0,b2c_fee)'));
        $findCateParentQ->from(DB::raw($categorydb . ' as child_cat'));
        $findCateParentQ->whereIn('child_cat.cat_id', function($q) use($categorydb) {
            $q->select('cat_id');
            $q->from(DB::raw($categorydb . ' as child_cat_level1'));

            $q->whereRaw('child_cat.cat_level=1');
            $q->where(function($q) use($categorydb) {
                $q->whereIn('child_cat.cat_id', function($q) use($categorydb) {
                    $q->select('cat_id');
                    $q->from(DB::raw($categorydb . ' as child_cat_level1'));
                    $q->whereRaw('child_cat_level1.cat_id=' . $categorydb . '.cat_id');
                    $q->whereRaw('child_cat_level1.cat_level=1');
                });

                $q->orWhereIn('child_cat.cat_id', function($q)use($categorydb) {
                    $q->select('cat_id');
                    $q->from(DB::raw($categorydb . ' as child_cat_level2'));
                    $q->whereRaw('child_cat_level2.cat_level=1');
                    $q->whereRaw('child_cat_level2.cat_id=' . $categorydb . '.parent_id');
                    $q->whereRaw($categorydb . '.cat_level=2');
                });


                $q->orWhereIn('child_cat.cat_id', function($q) use($categorydb) {
                    $q->select('parent_id');
                    $q->from(DB::raw($categorydb . ' as child_cat_level2'));
                    $q->whereRaw('child_cat_level2.cat_level=2');
                    $q->whereRaw($categorydb . '.cat_level=3');
                    $q->whereRaw('child_cat_level2.cat_id=' . $categorydb . '.parent_id');
                    
                });

                $q->orWhereIn('cat_id', function($q) use($categorydb) {
                    $q->select('parent_id');
                    $q->from(DB::raw($categorydb . ' as child_cat_level2'));
                    $q->whereRaw('child_cat_level2.cat_level=2');
                    $q->whereIn('child_cat_level2.cat_id', function($q) use($categorydb) {
                        $q->select('child_cat_level3.parent_id');
                        $q->from(DB::raw($categorydb . ' as child_cat_level3'));
                        $q->whereRaw('child_cat_level3.cat_level=3');
                        $q->whereRaw($categorydb . '.cat_level=4');
                        $q->whereRaw('child_cat_level3.cat_id=' . $categorydb . '.parent_id');
                    });
                });
            });
        });


        if ($user->use_group != User::TYPE_AffiliateUser) {
            $mainSelect = DB::raw($mainSelect.',(' . $findCateParentQ->toSql() . ') b2c_fee');
        }else{
            $mainSelect  = DB::raw($mainSelect);
        }
        
        $query->select($mainSelect);
        $query->whereIn('order_status',array('01','02','03','98'));
        $bindings = $query->getBindings();
        $sql = $query->toSql();
        
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSql = str_replace('\\', '\\\\', $sql);
        $endQuery = OrderDetail::where([]);

        $endQuery->from(DB::raw('(' . $sumSql . ') as tablez'));
         $phiAZibai = '(shc_total * ((IF(b2c_fee IS NULL,0,b2c_fee)/100)))';
         if ($user->use_group == User::TYPE_AffiliateUser) {
             $phiAZibai = 0;
         }
         
        $endQuery->select("*",DB::raw('SUM(IF(af_id > 0,  IF(af_rate >0,HoahongPT-'.$phiAZibai.',HoahongTien-'.$phiAZibai.')  , shc_total -  '.$phiAZibai.')) as total'));
        $endQuery->groupBy($group);
         $bindings = $endQuery->getBindings();
        $sql = $endQuery->toSql();
          foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSql = str_replace('\\', '\\\\', $sql);
    
        $result = $endQuery->get()->toArray();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'total' => $result
            ]
        ]);
    }
    
  

    /**
     * @SWG\Get(
     *     path="/api/v1/me/revenue-staffs-summary",
     *     operationId="revenueAnalysis",
     *     description="Thống kê doanh thu tổng  từ các nhân viên",
     *     produces={"application/json"},
     *     tags={"Statics-Revenue"},
     *     summary="Thống kê doanh thu tổng  từ các nhân viên",
     *     @SWG\Response(
     *         response=200,
     *         description=" array result"
     *     ),
     *    @SWG\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Ngày bắt đầu",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Ngày kết thúc",
     *         required=false,
     *         type="integer",
     *     ),
     * )
     */
    public function summaryRevenueStaff(Request $req) {
        $starDate = mktime(0, 0, 0, 01, 01, 2006);
        $query = OrderDetail::where('shc_total', '>', 0);
        $query->select(DB::raw('SUM(shc_total) as totalRevenue'));
        $query->whereIn('af_id_parent', function($q) use($req) {
            $userdb = User::tableName();
            $q->select('use_id');
            $q->from($userdb);
            $q->where($userdb . '.parent_id', $req->user()->use_id);
        });
        if (!empty($req->startDate)) {
            $starDate = $req->startDate;
        }
        if (!empty($req->endDate)) {
            $query->where('shc_change_status_date', '<=', $req->endDate);
        }
        //  $query->groupBy('af_id_parent');
      
        $query->where('shc_change_status_date', '>=', $starDate);
        $results = $query->get();
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }
   
   /**
     * @SWG\Get(
     *     path="/api/v1/me/revenue-staffs",
     *     operationId="revenueAnalysis",
     *     description=" Thống kê nhân viên",
     *     produces={"application/json"},
     *     tags={"Statics-Revenue"},
     *     summary=" Thống kê nhân viên",
     *    @SWG\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Ngày bắt đầu",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Ngày kết thúc",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
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
     *         description=" array result"
     *     )
     * )
     */
    
    public function revenueStaff(Request $req) {
        $shopdb = (new Shop)->getTable();
        $userdb = (new User)->getTable();
        $orderdb = (new OrderDetail)->getTable();
        $query = User::where(['use_status' => User::STATUS_ACTIVE]);

        $tree = [];
        $user = $req->user();
        
        $tree[] = $req->user()->use_id;
        $query->where(function($q) use($userdb,$user) {
            $q->orWhere(function($q) use($userdb,$user) {
                $q->where('use_group', User::TYPE_StaffUser);
                $q->whereIn('parent_id', function($q) use($userdb,$user) {
                    $q->select('use_id');
                    $q->from($userdb);
                    $q->where(['use_group' => User::TYPE_BranchUser]);
                    $q->whereIn('parent_id', function($q) use($userdb,$user) {
                        $q->select('use_id');
                        $q->from($userdb);
                        $q->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                        $q->where('parent_id',$user->use_id);
                    });
                });
            });
            
            $q->orWhere(function($q) use ($userdb,$user) {
                $q->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffUser]);
                $q->whereIn('parent_id',function($q) use($userdb, $user) {
                    $q->select('use_id');
                    $q->from($userdb);
                    $q->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                    $q->where('parent_id', $user->use_id);
                });
            });
            $q->orWhere(function($q) use ($userdb,$user) {
                $q->whereIn('use_group', [User::TYPE_StaffUser]);
                $q->whereIn('parent_id',function($q) use($userdb, $user) {
                    $q->select('use_id');
                    $q->from($userdb);
                    $q->whereIn('use_group', [User::TYPE_BranchUser]);
                    $q->where('parent_id', $user->use_id);
                });
            });
            $q->orWhere(function($q) use($userdb,$user) {
                $q->select('use_id');
                $q->from($userdb);
                $q->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser, User::TYPE_StaffUser]);
                 $q->where('parent_id',$user->use_id);
            });
        });
     
        $listUser = $query->get()->pluck('use_id')->toArray();
      
        $ids = array_merge($tree,$listUser);
        //listAFf User
        $queryAff = User::where('udb.use_status', User::STATUS_ACTIVE);
        $queryAff->from(DB::raw($userdb.' as udb'));
        $queryAff->whereIn('udb.use_group', [User::TYPE_StaffStoreUser, User::TYPE_StaffUser]);
        $queryAff->whereIn('udb.parent_id', $ids);
        $bindings = $queryAff->getBindings();
        $sql = $queryAff->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSql = str_replace('\\', '\\\\', $sql);
        
        
        
        $query = User::where(['sumtable.use_status' => User::STATUS_ACTIVE]);
        $query->whereIn('sumtable.use_group', [User::TYPE_AffiliateUser, User::TYPE_BranchUser]);
        $query->from(DB::raw($userdb.' as sumtable'));
        $query->whereRaw('sumtable.parent_id=udb.use_id');
//        $query->whereIn('parent_id', function($q) use($userdb, $ids) {
//            $q->select(['use_id']);
//            $q->from($userdb);
//            $q->where('use_status', User::STATUS_ACTIVE);
//            $q->whereIn('use_group', [User::TYPE_StaffStoreUser, User::TYPE_StaffUser]);
//            $q->whereIn('parent_id', $ids);
//        });
        
//        ///Trong đó neu nó la chi nhánh thì lấy danh sách nhân viên của nó
        $query->whereIn('tbtt_showcart.shc_saler', function($q) use($userdb, $ids, $user) {
            $q->select('child.use_id');
            $q->where('child.use_status', User::STATUS_ACTIVE);
            $q->from(DB::raw($userdb . ' as child'));
            $q->where(function($q) use($userdb, $user) {
                $q->orWhere(function($q) use($userdb) {
                    $q->whereIn('child.use_group', [User::TYPE_StaffUser, User::TYPE_AffiliateUser]);
                    $q->whereIn('child.parent_id', function($q) use($userdb) {
                        $q->select('child_parent.use_id');
                        $q->from(DB::raw($userdb . ' as child_parent'));
                        $q->whereIn('child_parent.use_group', [User::TYPE_BranchUser]);
                        $q->whereIn('child_parent.parent_id', function($q) use($userdb) {
                            $q->select('parent.use_id');
                            $q->from(DB::raw($userdb . ' as parent'));
                            $q->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                            $q->whereRaw('parent.parent_id=udb.use_id and udb.use_group !='.User::TYPE_StaffUser);
                        });
                    });
                });
                $q->orWhere(function($q) use($userdb) {
                    $q->whereIn('child.use_group', [User::TYPE_BranchUser, User::TYPE_StaffUser, User::TYPE_AffiliateUser]);
                    $q->whereIn('child.parent_id', function($q) use($userdb) {
                        $q->select('parent.use_id');
                        $q->from(DB::raw($userdb . ' as parent'));
                        $q->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                        $q->whereRaw('parent.parent_id=udb.use_id and udb.use_group !='.User::TYPE_StaffUser);
                    });
                });
                // Lấy những thằng nhân viên của user này
                $q->orWhere(function($q) use($userdb) {
                    $q->whereIn('child.use_group', [User::TYPE_StaffStoreUser, User::TYPE_BranchUser, User::TYPE_StaffUser, User::TYPE_AffiliateUser]);
                    $q->whereRaw('child.parent_id=udb.use_id and udb.use_group !='.User::TYPE_StaffUser);
                });
                
                $q->orWhere(function($q) use($userdb) {
                  $q->whereIn('child.use_group', [User::TYPE_StaffUser, User::TYPE_AffiliateUser]);
                  $q->whereIn('child.parent_id', function($q) use($userdb) {
                      $q->select('child_parent.use_id');
                       $q->from(DB::raw($userdb . ' as child_parent'));
                      $q->whereIn('child_parent.use_group', [User::TYPE_BranchUser]);
                      $q->whereRaw('child_parent.parent_id=udb.use_id and udb.use_group !='.User::TYPE_StaffUser);
                   });
               });

               $q->orWhere(function($q) use ($userdb) {
                   $q->whereIn('child.use_id', function($q) use($userdb) {
                       $q->select('child_parent.parent_id');
                      $q->from(DB::raw($userdb . ' as child_parent'));
                       $q->whereIn('child_parent.use_group', [User::TYPE_StaffUser]);
                       $q->whereRaw('child_parent.use_id=udb.use_id and udb.use_group ='.User::TYPE_StaffUser);
                   });
              });

              $q->orWhere(function($q) use($userdb,$user){
                  $q->where('child.use_id', $user->use_id);
                  $q->where('udb.use_group','<>',User::TYPE_StaffUser);
              });
            });
        });



  
        

        $starDate = mktime(0, 0, 0, 01, 01, 2006);
        $productdb = Product::tableName();
        $query->join($shopdb, $shopdb . '.sho_user', 'sumtable.use_id');
        $query->leftJoin($orderdb, $orderdb . '.af_id', DB::raw('sumtable.use_id or sumtable.use_id = tbtt_showcart.shc_saler'));
        $query->leftJoin($productdb,'tbtt_showcart.shc_product','tbtt_product.pro_id');
        $query->select(DB::raw('SUM(tbtt_showcart.shc_total) As showcarttotal'));
         if (!empty($req->startDate)) {
            $starDate = $req->startDate;
        }
        $query->where($orderdb . '.shc_change_status_date', '>=', $starDate);

        if (!empty($req->endDate)) {
            $query->where($orderdb . '.shc_change_status_date','<=', $req->endDate);
        }
        $query->whereIn($orderdb.'.shc_status',['01','02','03','98']);
        if ($user->use_group == User::TYPE_AffiliateStoreUser || $user->use_group == User::TYPE_StaffStoreUser) {
            $GH = $user->use_id;
            $tree1 = array();
//        $tree[] = (int)$this->session->userdata('sessionUser');
            if ($user->use_group == User::TYPE_StaffStoreUser) {
                $parent = $user->parentInfo;
                if(!empty($parent)){
                    $tree1[] = $user->parent_id;
                    $GH = $user->parent_id;
                }
            }


            $subquery = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser]);
            $subquery->where('use_status', User::STATUS_ACTIVE);
            $subquery->where('parent_id', $user->use_id);
            $sub_tructiep = $subquery->get();

            if (count($sub_tructiep) > 0) {
                foreach ($sub_tructiep as $key => $value) {
                    //Nếu là chi nhánh, lấy danh sách nhân viên
                    if ($value->use_group == User::TYPE_StaffStoreUser) {
                        
                        //Lấy danh sách CN dưới nó cua NVGH
                        $sub_cn = User::where(['use_group' => User::TYPE_BranchUser, 'use_status' => User::STATUS_ACTIVE, 'parent_id' => $value->use_id])->get();

                        if (count($sub_cn) > 0) {
                            foreach ($sub_cn as $k => $vlue) {
                                $tree1[] = $vlue->use_id;
                            }
                        }
                    } else {
                        $tree1[] = $value->use_id;
                    }
                }
            }
            if(!empty($tree1)){
                $query->where(function($q) use($GH,$tree1) {
                    $q->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
                    $q->orWhere(function($q) use ($tree1) {
                        $q->whereIn('tbtt_showcart.shc_saler', $tree1);
                        $q->where('pro_of_shop', '>', 0);
                    });
                });
               
            }else{
              $query->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
            }
  
        } else {
            if ($user->use_group == User::TYPE_BranchUser) {
                $query->where(['tbtt_showcart.shc_saler' => $user->use_id, 'pro_of_shop' => 0]);
                
            }
        }
       
        
        $bindings = $query->getBindings();
        $sql = $query->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSql = str_replace('\\', '\\\\', $sql);
       
        $queryAff->select('udb.*',DB::raw('('.$sumSql.') as showcarttotal'));
      
        $queryAff->having('showcarttotal','>',0);
        
        $bindings = $queryAff->getBindings();
        $sql = $queryAff->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSql = str_replace('\\', '\\\\', $sql);
  
        if($req->sum){
           
            $sumQuery = User::from(DB::raw('('.$sumSql.') as user'));
            $sumQuery->sum('showcarttotal');
            return response(['msg' => Lang::get('response.success'), 'data' => [
                    'revenue' => $sumQuery->sum('showcarttotal')
                ]], 200);
        }
        $sumQuery = User::from(DB::raw('('.$sumSql.') as user'));
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $sumQuery->paginate($limit, ['*'], 'page', $page);

        //populate user
        $data = [];
        foreach ($paginate->items() as $item) {
            $result = $item->publicProfile();
            $result['totalRevenue'] = $item->showcarttotal;
            $result['shop'] = $item->shop;
            $result['aff_number_count'] = $item->aff_number_count;
            $result['parent'] = $item->getParentInfoV1();
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }
    public function revenueStaffV1(Request $req) {
        $starDate = mktime(0, 0, 0, 01, 01, 2006);
        $userdb = (new User)->getTable();
        $orderDetaildb = (new OrderDetail)->getTable();
        $querySum = OrderDetail::where($orderDetaildb . '.shc_total', '>', 0);
        $querySum->select(DB::raw('SUM(' . $orderDetaildb . '.shc_total)'))
            ->join($userdb . ' as u', 'u.use_id', $orderDetaildb . '.af_id_parent');
        $querySum->whereRaw($userdb . '.use_id =' . $orderDetaildb . '.af_id_parent');
        if (!empty($req->startDate)) {
            $starDate = $req->startDate;
        }
        if (!empty($req->endDate)) {
            $querySum->where($orderDetaildb . '.shc_change_status_date', '<=', $req->endDate);
        }
        $querySum->where($orderDetaildb . '.shc_change_status_date', '>=', $starDate);
        $bindings = $querySum->getBindings();
        $sql = $querySum->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSql = str_replace('\\', '\\\\', $sql);

        $query = User::where([$userdb . '.use_status' => User::STATUS_ACTIVE, $userdb . '.parent_id' => $req->user()->use_id]);
        $query->select("*", DB::raw('(' . $sumSql . ') as showcarttotal'));
        $query->where(DB::raw('(' . $sumSql . ')'), '>', 0);
    
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        //populate user
        $data = [];
        foreach ($paginate->items() as $item) {
            $result = $item->publicProfile();
            $result['totalRevenue'] = $item->showcarttotal;
            $result['shop'] = $item->shop;
            $result['aff_number_count'] = $item->aff_number_count;
            $result['staff_of_user'] = $item->getAllStaffOfUser();
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }

    function countAF($userId) {
        $userdata = $userId;
        $tree = array();
        $userTreeModel = new UserTree();
        $userTreeModel->getTreeInList($userId, $tree);
        $shop_tree = $this->getAfByUser($userdata["sessionUser"]);
        if (count($tree) > 0) {
            foreach ($tree as $node) {
                $tmp = $this->getAfByUser($node);
                if ($tmp != -1) {
                    //$shop_tree[] = $tmp;
                    if (!in_array($tmp, $shop_tree, true)) {
                        $shop_tree = array_merge($shop_tree, $tmp);
                    }
                }
            }
        }

        return $shop_tree;
    }

    function getAfByUser($userId) {
        $shop_detail = User::where(['use_group'=>User::TYPE_AffiliateUser, 'use_status' => User::STATUS_ACTIVE, 'parent_id' => $userId])->get();
        $shopList = [];
        if (count($shop_detail) > 0) {
            foreach ($shop_detail as $shop) {
                $shopList[] = $shop->use_id;
            }
        }
        return $shopList;
    }
    
    function shop_tree($userId) {
        $tree = [];
        $userTreeModel = new UserTree();
        $userTreeModel->getTreeInList($userId, $tree);

        $shop_tree = [];
        $shop_tree = $this->getShopParent($userId);

        if (count($tree) > 0) {
            foreach ($tree as $node) {
                $tmp = $this->getShopParent($node);
                if (count($tmp) != -1) {
                    //$shop_tree[] = $tmp;
                    array_merge($shop_tree, array_diff($tmp, $shop_tree));
                }
            }
        }

        return $shop_tree;
    }

    function getShopParent($userId) {
        $shopdb = (new Shop)->getTable();
        $userdb = (new User)->getTable();
        $query = User::where(['parent_id'=> $userId]);
        $shops = $query->join($shopdb, $shopdb . '.sho_user', $userdb . '.use_id')->get();
        $shopList = array();
        if (count($shops) > 0) {
            foreach ($shops as $shop) {
                $shopList[] = $shop->use_id;
            }
        }
        return $shopList;
    }
    
     /**
     * @SWG\Get(
     *     path="/api/v1/me/statisticlistNVGH/{id}/affiliate",
     *     operationId="revenue branch",
     *     description="Thống kê doanh thu cộng tác viên của nhân viên ",
     *     produces={"application/json"},
     *     tags={"Statics-Revenue"},
     *     summary=" Thống kê doanh thu cộng tác viên của nhân viên ",
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page",
     *         required=false,
     *         type="integer",
     *     ),
     *      @SWG\Parameter(
     *         name="sum",
     *         in="query",
     *         description="truyền params này để tính tổng doanh thu",
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
     *         description=" array result"
     *     )
     * )
     */
    
    function staticsAffilateUser($id,Request $req) {
               $startDate = mktime(0, 0, 0, 01, 01, 2006);
        $shopdb = (new Shop)->getTable();
        $userdb = (new User)->getTable();
        $orderdb = (new OrderDetail)->getTable();   
        $prodb = Product::tableName();
        $query = User::where($userdb . '.use_status', 1);
        $query->whereIn('shc_status', [01, 02, 03, 98]);

        $query->where(function($q) {
            $q->where('use_group', User::TYPE_AffiliateUser);
          
        });
        $query->join($shopdb, $shopdb . '.sho_user', $userdb . '.use_id');
        $query->leftJoin($orderdb, $orderdb . '.af_id', DB::raw('tbtt_user.use_id or tbtt_user.use_id = tbtt_showcart.shc_saler'));
         $query->join($prodb, $orderdb . '.shc_product', $prodb . '.pro_id');
    
        $user = $req->user();
        $subquery1 = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser,User::TYPE_StaffUser]);
        $subquery1->where('use_status', User::STATUS_ACTIVE);
        $sub_tructiep1 = $subquery1->where('parent_id', $id)->get();
        $tree = [];
        
        if (!empty($sub_tructiep1)) {
            foreach ($sub_tructiep1 as $key => $value) {
                $tree[] = $value->use_id;
                //Nếu là chi nhánh, lấy danh sách nhân viên
                if ($value->use_group == User::TYPE_StaffStoreUser) {
                    $sub_nv = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffUser])
                            ->where('use_status', User::STATUS_ACTIVE)
                            ->where('parent_id', $value->use_id)->get();

                    if (!empty($sub_nv)) {
                        foreach ($sub_nv as $k => $v) {
                            if ($v->use_group == User::TYPE_BranchUser) {

                                $sub_nvcn = User::whereIn('use_group', [User::TYPE_StaffUser])
                                        ->where('use_status', User::STATUS_ACTIVE)
                                        ->where('parent_id', $v->use_id)->get();

                                if (!empty($sub_nvcn)) {
                                    foreach ($sub_nvcn as $k => $vlue) {
                                        $tree[] = $vlue->use_id;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($value->use_group == User::TYPE_BranchUser) {
                    $sub_nv = User::whereIn('use_group', [User::TYPE_StaffUser])
                            ->where('use_status', User::STATUS_ACTIVE)
                            ->where('parent_id', $value->use_id)->get();

                    if (!empty($sub_nv)) {
                        foreach ($sub_nv as $k => $v) {
                            $tree[] = $v->use_id;
                        }
                    }
                }
            }
        }
     
   
        if(!empty($tree)){
            $tree[]  = $id;
        }
     
        $get_aff = User::where('use_id', $id)->first();
       
        $query->where(function($q) use($get_aff,$tree) {
     
            $more = array_merge($tree, [$get_aff->parent_id]);
            $q->where(function($q) use($tree, $more) {

                $q->whereIn('shc_saler', $more);
                $q->whereIn('parent_id', $tree);
            });
            $q->orWhere(function($q) use($tree, $more) {
                $q->whereIn('shc_saler', $more);
                $q->where('af_id', 0);
                $q->whereIn('parent_id', $tree);
            });
        });




        // $query->where('use_group',User::TYPE_BranchUser);
//        ktra tai khoan dang nhap de lay tree và id GH ban sp
        if ($user->use_group == User::TYPE_StaffStoreUser || $user->use_group == User::TYPE_StaffUser) {
            $tree = $pCN = $user->parent_id;
        } else {
            $tree = $pCN = $user->use_id;
        }
        
         if ($user->use_group == User::TYPE_AffiliateStoreUser || $user->use_group == User::TYPE_StaffStoreUser) {
            $GH = $user->use_id;
            $tree1 = array();
//        $tree[] = (int)$this->session->userdata('sessionUser');
            if ( $user->use_group == User::TYPE_StaffStoreUser) {
               
                $tree1[] = $GH = (int) $user->parent_id;
                
            }
            $subquery = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser]);
            $subquery->where('use_status', User::STATUS_ACTIVE);
            $subquery->where('parent_id', $user->use_id);
            $sub_tructiep = $subquery->get();
  
           if (!empty($sub_tructiep)) {
                foreach ($sub_tructiep as $key => $value) {
                    //Nếu là chi nhánh, lấy danh sách nhân viên
                    if ($value->use_group == User::TYPE_StaffStoreUser) {
                        //Lấy danh sách CN dưới nó cua NVGH
                        $sub_cn = User::where(['use_group' => User::TYPE_BranchUser, 'use_status' => User::STATUS_ACTIVE, 'parent_id' => $value->use_id])->get();

                        if (count($sub_cn) > 0) {
                            foreach ($sub_cn as $k => $vlue) {
                                $tree1[] = $vlue->use_id;
                            }
                        }
                    } else {
                        $tree1[] = $value->use_id;
                    }
                }
            }
     
            if (!empty($tree1)) {
                $query->where(function($q) use($GH, $tree1) {
                    $q->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
                    $q->orWhere(function($q) use ($tree1) {
                        $q->whereIn('tbtt_showcart.shc_saler', $tree1);
                        $q->where('pro_of_shop', '>', 0);
                    });
                });
            } else {
                $query->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
            }
  
        } else {
            if ($user->use_group == User::TYPE_BranchUser) {
                $query->where(['tbtt_showcart.shc_saler' => $user->use_id, 'pro_of_shop' => 0]);
                
            }
        }

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $query->select(DB::raw('use_id, use_group,use_username,SUM(tbtt_showcart.shc_total) As showcarttotal, use_fullname,use_email,use_mobile,use_fullname,tbtt_shop.sho_link, tbtt_shop.sho_name,domain, parent_id,tbtt_showcart.*'));
        
        if(!empty($req->startDate)){
            $startDate = $req->startDate;
        }
        if (!empty($req->startDate)) {
            $query->where($orderdb . '.shc_change_status_date','>=', $req->startDate);
        }
        if (!empty($req->endDate)) {
            $query->where($orderdb . '.shc_change_status_date ','<=', $req->endDate);
        }
        if (!empty($req->sum)) {
            $result['totaRevenue'] = 0;
            $result = $query->select(DB::raw('SUM(tbtt_showcart.shc_total) As totaRevenue'))->first();

            return response(['msg' => Lang::get('response.success'), 'data' => $result], 200);
        }
        $query->groupBy($userdb . '.use_id');  $bindings = $query->getBindings();
        $sql = $query->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSql = str_replace('\\', '\\\\', $sql);

        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        
        //populate user
        $data = [];
        foreach ($paginate->items() as $item) {
            $result = $item->publicProfile();
            $result['totalRevenue'] = $item->showcarttotal;
            $result['shop'] = $item->shop;
            $result['parent'] = $item->getParentInfoV1();
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }
    function staticsNVGH($id,Request $req) {

        $shopdb = (new Shop)->getTable();
        $userdb = (new User)->getTable();
        $orderdb = (new OrderDetail)->getTable();   
        $query = User::where($userdb . '.use_status', 1);
        $query->where('shc_status', '<>', 99);

        $query->where(function($q) {
            $q->orWhere('use_group', User::TYPE_AffiliateUser);
            $q->orWhere('use_group', User::TYPE_BranchUser);
        });
        $query->join($shopdb, $shopdb . '.sho_user', $userdb . '.use_id');
        $query->leftJoin($orderdb, $orderdb . '.af_id', DB::raw('tbtt_showcart.af_id or tbtt_user.use_id = tbtt_showcart.shc_saler'));
        $query->where(function($q) use($id){
            $q->orWhereRaw(DB::raw('shc_saler = use_id AND parent_id='.$id));
            $q->orWhereRaw(DB::raw('shc_saler = '.$id.' AND parent_id=shc_saler'));
        });

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $query->select($userdb . '.*', DB::raw('SUM(tbtt_showcart.shc_total) As showcarttotal'));
        if (!empty($req->startDate)) {
            $query->where($orderdb . '.shc_change_status_date','>=', $req->startDate);
        }
        if (!empty($req->endDate)) {
            $query->where($orderdb . '.shc_change_status_date ','<=', $req->endDate);
        }
        if (!empty($req->sum)) {
            $result['totaRevenue'] = 0;
            $result = $query->select(DB::raw('SUM(tbtt_showcart.shc_total) As totaRevenue'))->first();

            return response(['msg' => Lang::get('response.success'), 'data' => $result], 200);
        }
        $query->groupBy($userdb . '.use_id');
        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        //populate user
        $data = [];
        foreach ($paginate->items() as $item) {
            $result = $item->publicProfile();
            $result['totalRevenue'] = $item->showcarttotal;
            $result['shop'] = $item->shop;
            $result['parent'] = $item->getParentInfoV1();
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }
    
      /**
     * @SWG\Get(
     *     path="/api/v1/me/statisticlistNVGH/{id}/detail/{userId}",
     *     operationId="revenue branch",
     *     description="Thống kê doanh thu cac san pham cua nhân viên ",
     *     produces={"application/json"},
     *     tags={"Statics-Revenue"},
     *     summary="Thống kê doanh thu cac san pham cua nhân viên",
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page",
     *         required=false,
     *         type="integer",
     *     ),
     *      @SWG\Parameter(
     *         name="sum",
     *         in="query",
     *         description="truyền params này để tính tổng doanh thu",
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
     *         description=" array result"
     *     )
     * )
     */
    function staticsNVGHDetail($parentId, $id, Request $req) {
        $userdb = User::tableName();
        $prodb = Product::tableName();
        $orderdb = (new OrderDetail)->getTable();
        $currenUser = User::where(['use_id' => $id, 'parent_id' => $parentId])->first();
        if (empty($currenUser)) {
            return response(['msg' => Lang::get('response.use_not_found')], 404);
        }

        $query = User::where([$userdb . '.use_status' => User::STATUS_ACTIVE, $userdb . '.use_id' => $id]);
        $query->join($orderdb, $orderdb . '.af_id', DB::raw($userdb . '.use_id OR ' . $userdb . '.use_id = ' . $orderdb . '.shc_saler'));
        $query->join($prodb, $orderdb . '.shc_product', $prodb . '.pro_id');
        $query->whereIn('use_group', [User::TYPE_AffiliateUser, User::TYPE_BranchUser]);
        $query->where(function($q) use($currenUser, $orderdb) {
            $q->orWhereRaw(DB::raw($orderdb . '.shc_saler = ' . $currenUser->use_id . ' AND parent_id=' . $currenUser->parent_id));
            $q->orWhereRaw(DB::raw($orderdb . '.shc_saler = ' . $currenUser->parent_id . ' AND parent_id=' . $currenUser->use_id));
        });
        $query->select(DB::raw($orderdb . '.shc_orderid as orderId'),'use_id','use_group','use_email','use_fullname','parent_id', 'use_username', 'shc_quantity', 'shc_change_status_date', 'shc_total', 'pro_name', 'pro_cost');

        $query->where($orderdb . '.shc_status', '<>', 99);
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        $data = [];
        foreach ($paginate->items() as $item) {

            $result = $item;
            $result['shop'] = $item->shop;
            $result['parent'] = $item->getParentInfoV1();
            
            $data[] = $result;
          
        }

        $results = $paginate->toArray();
        $results['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/statistic-branch/{id}",
     *     operationId="statistic-branch detail",
     *     description="Thống kê chi nhánh chi tiết",
     *     produces={"application/json"},
     *     tags={"statistic-affiliate"},
     *     summary="Thống kê chi nhánh chi tiết",
     *  @SWG\Parameter(
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
     *         description=" array result"
     *     )
     * )
     */
    function staticsBranchDetail($id, Request $req) {
        $userdb = User::tableName();
        $user = $req->user();
        $shopdb = (new Shop)->getTable();
        $prodb = Product::tableName();
        $orderdb = (new OrderDetail)->getTable();
         $subquery = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser,User::TYPE_StaffUser]);
        $subquery->where('use_status', User::STATUS_ACTIVE);
        $subquery->where('parent_id', $user->use_id);
        $sub_tructiep = $subquery->get();
        $tree = [$user->use_id];
        $tree1 = [];
        if (count($sub_tructiep) > 0) {
            foreach ($sub_tructiep as $key => $value) {
                $tree[] = $value->use_id;
                if ($value->use_group == User::TYPE_BranchUser) {
                    $sub_nv = User::where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $value->use_id])
                            ->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffUser])->get();
                    if (!empty($sub_nv)) {
                        foreach ($sub_nv as $k => $v) {
                            $tree[] = $v->use_id;
                        }
                    }
                }
                //Nếu là chi nhánh, lấy danh sách nhân viên
                if ($value->use_group == User::TYPE_StaffStoreUser) {
                    $sub_nv = User::where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $value->use_id])
                            ->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffUser])->get();
                    if (!empty($sub_nv)) {
                        foreach ($sub_nv as $k => $vlue) {
                            $tree[] = $vlue->use_id;
                            if ($vlue->use_group == User::TYPE_BranchUser) {
                                $tree1[] = $vlue->use_id;
                                $sub_nvcn = User::where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $vlue->use_id])
                                        ->whereIn('use_group', [User::TYPE_StaffUser])->get();
                                if (!empty($sub_nvcn)) {
                                    foreach ($sub_nvcn as $k => $v1) {
                                        $tree[] = $v1->use_id;
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($value->use_group != User::TYPE_StaffUser) {
                        $tree1[] = $value->use_id;
                    }
                }
            }
        }
       

      
        
        $branchUser = User::where(['use_id' => $id])->first();
          $query = User::where([$userdb . '.use_status' => User::STATUS_ACTIVE])->whereIn(
            'use_group', [User::TYPE_AffiliateUser, User::TYPE_BranchUser]);
        if ($user->use_group == User::TYPE_AffiliateStoreUser || $user->use_group == User::TYPE_StaffStoreUser) {
            $GH = $user->use_id;
//        $tree[] = (int)$this->session->userdata('sessionUser');
            if ($user->use_group == User::TYPE_StaffStoreUser || $user->use_group == User::TYPE_StaffUser) {
                $tree1[] = $GH = (int) $user->parent_id;
            }



            if (!empty($tree1)) {
                $query->where(function($q) use($GH, $tree1) {
                    $q->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
                    $q->orWhere(function($q) use ($tree1) {
                        $q->whereIn('tbtt_showcart.shc_saler', $tree1);
                        $q->where('pro_of_shop', '>', 0);
                    });
                });
            } else {
                $query->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
            }
        } else {
            if ($user->use_group == User::TYPE_BranchUser) {
                $query->where(['tbtt_showcart.shc_saler' => $user->use_id]);
            }
        }



//      
        $get_p = $branchUser->parentInfo;
        //begin dk statisticlistaffiliate
//            if ($user->use_group == User::TYPE_StaffStoreUser || $user->use_group == User::TYPE_StaffUser) {
//            $parent = $user->parentInfo;
//            if (!empty($parent)) {
//                $tree[] = $parent->parent_id;
//            }
//        }
//        if($user->use_group == User::TYPE_StaffUser){
//            $query->where(function($q) use($user){
//               $q->where(['shc_saler'=>$user->parent_id,'parent_id'=>$user->use_id]);
//            });
//        }else{
//            if ($user->use_group == User::TYPE_StaffStoreUser) {
//                $paGH_saler = [$user->parent_id];
//                if (!empty($tree)) {
//                    $paGH_saler[] = array_merge($tree, $paGH_saler);
//                }
//                
//                $query->where(function($q) use($user) {
//                    $q->whereIn('shc_saler',$paGH_saler);
//                    $q->whereIn('af_id',$branchUser->use_id);
//                    $q->whereIn('parent_id',[$branchUser->parent_id]);
//                
//                });
//            }else{
//                 $query->where(function($q) use($user,$tree) {
//                    $q->whereIn('shc_saler',$tree);
//                    $q->whereIn('af_id',$branchUser->use_id);
//                    $q->whereIn('parent_id',[$branchUser->parent_id]);
//                
//                });
//            }
//        }
        $paGH_saler = [$get_p->use_id];
        
        $paCN_saler = [$branchUser->use_id];

        if ($get_p->use_group == User::TYPE_StaffStoreUser || $get_p->use_group == User::TYPE_StaffUser) {
            $paGH_saler = [$get_p->parent_id];
            if ($branchUser->use_group == User::TYPE_AffiliateUser) {
                $paCN_saler = [$get_p->parent_id];
            }
            
        }
        $query->where(function($q) use($paGH_saler, $branchUser, $paCN_saler, $get_p) {
            $q->where(function($q) use ($paGH_saler, $branchUser) {
                $q->whereIn('shc_saler', $paGH_saler);
                $q->whereIn('parent_id', [$branchUser->use_id]);
            });
            $q->orWhere(function($q) use ($paCN_saler, $get_p) {
                $q->whereIn('shc_saler', $paCN_saler);
                $q->whereIn('parent_id', [$get_p->use_id]);
            });
        });

        //$query->whereIn('shc_saler', $tree);
        $query->join($shopdb, $shopdb.'.sho_user',$userdb.'.use_id');
        $query->join($orderdb, $orderdb . '.af_id', DB::raw($userdb . '.use_id OR ' . $userdb . '.use_id = ' . $orderdb . '.shc_saler'));
        
        $query->leftJoin($prodb, $orderdb . '.shc_product', $prodb . '.pro_id');
        $query->select(DB::raw($orderdb . '.shc_orderid as orderId'),'tbtt_showcart.af_id', 'use_id', 'use_group', 'use_email', 'use_fullname', 'parent_id', 'use_username', 'shc_quantity', 'shc_change_status_date', 'shc_total', 'pro_name', 'pro_cost');
        



        $query->whereIn($orderdb . '.shc_status', ['01', '02', '03', '98']);
        $bindings = $query->getBindings();
        $sql = $query->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSql = str_replace('\\', '\\\\', $sql);
       
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        $data = [];
        foreach ($paginate->items() as $item) {

            $result = $item;
            $result['shop'] = $item->shop;
            $result['parent'] = $item->getParentInfoV1();
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;

        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }

    function statisticlistNVGH()
    {

        $shopdb = (new Shop)->getTable();
        $userdb = (new User)->getTable();
        $orderdb = (new OrderDetail)->getTable();
        $query = User::where([$userdb . '.use_status' => User::STATUS_ACTIVE, $userdb . '.use_group' => User::TYPE_AffiliateUser]);
        $query->whereIn($userdb . '.parent_id', function($q) use ($req) {
            $q->select('use_id');
            $q->from((new User)->getTable());
            $q->where(function($q2) use ($req) {
                $q2->whereIn('use_group', [User::TYPE_BranchUser]);
                $q2->where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $req->user()->use_id]);
            });
            $q->orWhere('use_id', $req->user()->use_id);
        });
      
        $query->join($shopdb, $shopdb . '.sho_user', $userdb . '.use_id');
        $query->leftJoin($orderdb, $orderdb . '.af_id', $userdb . '.use_id');
        $query->select($userdb . '.*', DB::raw('SUM(tbtt_showcart.shc_total) As showcarttotal'));
        if (!empty($req->startDate)) {
            $query->where($userdb . '.shc_change_status_date','>=', $req->startDate);
        }
        if (!empty($req->endDate)) {
            $query->where($userdb . '.shc_change_status_date','<=', $req->endDate);
        }
        if (!empty($req->sum)) {
            $result['totaRevenue'] = 0;
            $result = $query->select(DB::raw('SUM(tbtt_showcart.shc_total) As totaRevenue'))->first();

            return response(['msg' => Lang::get('response.success'), 'data' => $result], 200);
        }
        $query->groupBy($userdb . '.use_id');

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        //populate user
        $data = [];
        foreach ($paginate->items() as $item) {
            $result = $item->publicProfile();
            $result['totalRevenue'] = $item->showcarttotal;
            $result['shop'] = $item->shop;
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
        
  
    }
    /**
     * @SWG\Get(
     *     path="/api/v1/me/revenue-branch",
     *     operationId="revenue branch",
     *     description=" Thống kê chi nhánh",
     *     produces={"application/json"},
     *     tags={"Statics-Revenue"},
     *     summary=" Thống kê chi nhánh",
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="startDate",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="endDate",
     *         required=false,
     *         type="integer",
     *     ),
     *      @SWG\Parameter(
     *         name="sum",
     *         in="query",
     *         description="truyền params này để tính tổng doanh thu",
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
     *         description=" array result"
     *     )
     * )
     */
    
    function revenueBranchV1(Request $req) {
        $shopdb = (new Shop)->getTable();
         $shopdb = (new Shop)->getTable();
        $userdb = (new User)->getTable();
        $orderdb = (new OrderDetail)->getTable();
        $queryAff = User::where(['use_status' => User::STATUS_ACTIVE]);

        $tree = [];
        $user = $req->user();
        
        $tree[] = $req->user()->use_id;
//        $userListQ = User::where(['use_status'=>User::STATUS_ACTIVE]);
//        
//        $userListQ->whereIn('use_group',[User::TYPE_StaffStoreUser,User::TYPE_StaffUser]);
//        $userListQ->where(['parent_id'=>$user->use_id]);
//        $sub_tructiep = $userListQ->get();
//        
//       
//         if (!empty($sub_tructiep)) {
//            foreach ($sub_tructiep as $key => $value) {
//                if ($value->use_group == User::TYPE_BranchUser) {
//                    $tree[] = $value->use_id;
//                }
//                //lay id neu NVGH
//                if ($value->use_group == USer::TYPE_StaffStoreUser) {
//                    $subQ = User::whereIn('use_group', [14, 11]);
//                    $subQ->where(['use_status' => 1, 'parent_id' => $value->use_id]);
//                    $sub_nv = $subQ->get();
//                    if (!empty($sub_nv)) {
//                        foreach ($sub_nv as $k => $v) {
//                            $tree[] = $v->use_id;
//                            if ($v->use_group == User::TYPE_BranchUser) {
//                                $tree[] = $value->use_id;
//                                $tree[] = $v->use_id;
//                            }
//                        }
//                    }
//                }
//            }
//        }
  
        $queryAff->where('use_group',14);
//        $queryAff->whereIn('use_id',[4364]);
        $queryAff->where(function($q) use($userdb,$user) {
            $q->orWhere(function($q) use($userdb,$user) {
                $q->where('use_status', User::STATUS_ACTIVE);
                $q->where('parent_id',$user->use_id);
              
            });
            $q->orWhere(function($q) use($userdb, $user) {
                $q->where('use_status', User::STATUS_ACTIVE);
                $q->where(['use_group' => User::TYPE_BranchUser]);
                $q->where('parent_id', $user->use_id);
            });

            $q->orWhere(function($q) use ($userdb, $user) {
                $q->whereIn('use_group', [User::TYPE_BranchUser,User::TYPE_StaffUser]);
                $q->whereIn('parent_id', function($q) use($userdb, $user) {
                    $q->select('use_id');
                    $q->from($userdb);
                    $q->where('use_status', User::STATUS_ACTIVE);
                    $q->where(['use_group' => User::TYPE_StaffStoreUser]);
                    $q->where('parent_id',$user->use_id);
                });
            });
            $q->orWhere(function($q) use($userdb, $user) {
                $q->whereIn('parent_id', function($q) use($userdb, $user) {
                    $q->select('parent_id');
                    $q->from($userdb);
                    $q->where('use_group', User::TYPE_BranchUser);
                    $q->where('use_status', User::STATUS_ACTIVE);
                    $q->whereIn('parent_id', function($q) use($userdb, $user) {
                        $q->select('use_id');
                        $q->from($userdb);
                        $q->where('use_status', User::STATUS_ACTIVE);
                        $q->where(['use_group' => User::TYPE_StaffStoreUser]);
                        $q->where('parent_id', $user->use_id);
                    });
                });
            });
        });
        
         
  
        $query = User::where(['sumtable.use_status' => User::STATUS_ACTIVE]);
        $query->whereIn('sumtable.use_group', [User::TYPE_AffiliateUser, User::TYPE_BranchUser]);
        $query->from(DB::raw($userdb . ' as sumtable'));
        $query->where(function($q) use($userdb) {
            $q->orWhere(function($q) use($userdb) {
                $q->whereRaw('sumtable.parent_id=udb.use_id');
                $q->whereIn('tbtt_showcart.shc_saler', function($q) use($userdb) {
                    $q->select('use_id');
                    $q->whereRaw('use_id=udb.parent_id');
                    $q->from($userdb);
                    $q->whereNotIn('use_group',[User::TYPE_StaffStoreUser, User::TYPE_StaffUser]);
                });
            });
            $q->orWhere(function($q) use($userdb) {
                $q->whereRaw('sumtable.parent_id=udb.use_id');
                $q->whereIn('tbtt_showcart.shc_saler', function($q) use($userdb) {
                    $q->select('parent_id');
                    $q->whereRaw('use_id=udb.parent_id');
                    $q->from($userdb);
                    $q->whereIn('use_group',[User::TYPE_StaffStoreUser, User::TYPE_StaffUser]);
                });
            });
            
             
            $q->orWhere(function($q) use($userdb) {
                $q->whereRaw('sumtable.parent_id=udb.parent_id');
                $q->whereIn('tbtt_showcart.shc_saler', function($q) use($userdb) {
                    $q->select('use_id');
                    $q->from($userdb);
                    $q->whereRaw('use_id=udb.use_id');
                    $q->whereIn('parent_id', function($q) use ($userdb) {
                        $q->select('use_id');
                        $q->from($userdb);
                        $q->whereRaw('use_id=udb.parent_id');
                        $q->whereNotIn('use_group', [User::TYPE_StaffStoreUser, User::TYPE_StaffUser]);
                    });
                    //$q->whereNotIn('use_group', [User::TYPE_StaffStoreUser, User::TYPE_StaffUser]);
                });
                
                //$q->whereNotIn('udb.use_group', [User::TYPE_AffiliateUser]);
            });
             $q->orWhere(function($q) use($userdb) {
                $q->whereRaw('sumtable.parent_id=udb.parent_id');
                $q->whereRaw('tbtt_showcart.shc_saler=udb.use_id');
                
                $q->whereNotIn('udb.use_group', [User::TYPE_AffiliateUser]);
            });
            
            $q->orWhere(function($q) use($userdb) {
                $q->whereRaw('sumtable.parent_id=udb.parent_id');
                $q->whereIn('tbtt_showcart.shc_saler', function($q) use($userdb) {
                    $q->select('parent_id');
                    $q->whereRaw('use_id=udb.parent_id');
                    $q->from($userdb);
                    $q->whereIn('use_group',[User::TYPE_StaffStoreUser, User::TYPE_StaffUser]);
                    $q->whereIn('udb.use_group', [User::TYPE_AffiliateUser]);
                });
            });
            

        });
        $starDate = mktime(0, 0, 0, 01, 01, 2006);
        $productdb = Product::tableName();
        $query->join($shopdb, $shopdb . '.sho_user', 'sumtable.use_id');
        $query->leftJoin($orderdb, $orderdb . '.af_id', DB::raw('sumtable.use_id or sumtable.use_id = tbtt_showcart.shc_saler'));
        $query->leftJoin($productdb,'tbtt_showcart.shc_product','tbtt_product.pro_id');
        $query->select(DB::raw('SUM(tbtt_showcart.shc_total) As showcarttotal'));
         if (!empty($req->startDate)) {
            $starDate = $req->startDate;
        }
        $query->where($orderdb . '.shc_change_status_date', '>=', $starDate);

        if (!empty($req->endDate)) {
            $query->where($orderdb . '.shc_change_status_date','<=', $req->endDate);
        }
        $query->whereIn($orderdb.'.shc_status',['01','02','03','98']);
      
        if ($user->use_group == User::TYPE_AffiliateStoreUser || $user->use_group == User::TYPE_StaffStoreUser) {
            $GH = $user->use_id;
            $tree1 = array();
//        $tree[] = (int)$this->session->userdata('sessionUser');
            if ($user->use_group == User::TYPE_StaffStoreUser) {
                $parent = $user->parentInfo;
                if(!empty($parent)){
                    $tree1[] = $user->parent_id;
                    $GH = $user->parent_id;
                }
            }


            $subquery = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser]);
            $subquery->where('use_status', User::STATUS_ACTIVE);
            $subquery->where('parent_id', $user->use_id);
            $sub_tructiep = $subquery->get();

            if (count($sub_tructiep) > 0) {
                foreach ($sub_tructiep as $key => $value) {
                    
                    //Nếu là chi nhánh, lấy danh sách nhân viên
                    if ($value->use_group == User::TYPE_StaffStoreUser) {
                        
                        //Lấy danh sách CN dưới nó cua NVGH
                        $sub_cn = User::where(['use_group' => User::TYPE_BranchUser, 'use_status' => User::STATUS_ACTIVE, 'parent_id' => $value->use_id])->get();

                        if (count($sub_cn) > 0) {
                            foreach ($sub_cn as $k => $vlue) {
                                $tree1[] = $vlue->use_id;
                            }
                        }
                    } else {
                        $tree1[] = $value->use_id;
                    }
                }
            }
            if(!empty($tree1)){
                $query->where(function($q) use($GH,$tree1) {
                    $q->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
                    $q->orWhere(function($q) use ($tree1) {
                        $q->whereIn('tbtt_showcart.shc_saler', $tree1);
                        $q->where('pro_of_shop', '>', 0);
                    });
                });
               
            }else{
              $query->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
            }
  
        } else {
            if ($user->use_group == User::TYPE_BranchUser) {
                $query->where(['tbtt_showcart.shc_saler' => $user->use_id, 'pro_of_shop' => 0]);
                
            }
        }
        
        $bindings = $query->getBindings();
        $sql = $query->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSql = str_replace('\\', '\\\\', $sql);
        
          
       
        $queryAff->select('udb.*',DB::raw('('.$sumSql.') as showcarttotal'));
        $queryAff->from(DB::raw($userdb.' as udb'));
        $queryAff->having('showcarttotal','>',0);
      
        
          $bindings = $queryAff->getBindings();
        $sql = $queryAff->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSql = str_replace('\\', '\\\\', $sql);

         $sumQuery = User::from(DB::raw('(' . $sumSql . ') as udb'));
        $bindings = $sumQuery->getBindings();
        $sql = $sumQuery->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSqlTotal = str_replace('\\', '\\\\', $sql);
        if ($req->sum) {

            $sumQuery = User::from(DB::raw('(' . $sumSqlTotal . ') as user'));
            $sumQuery->sum('showcarttotal');
            return response(['msg' => Lang::get('response.success'), 'data' => [
                    'revenue' => $sumQuery->sum('showcarttotal')
                ]], 200);
        }

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $sumQuery->paginate($limit, ['*'], 'page', $page);

        //populate user
        $data = [];
        foreach ($paginate->items() as $item) {
            $result = $item->publicProfile();
            $result['totalRevenue'] = $item->showcarttotal;
            $result['shop'] = $item->shop;
            $result['aff_number_count'] = $item->aff_number_count;
            $result['parent'] = $item->getParentInfoV1();
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
        
    }

    function revenueBranch(Request $req) {
        $shopdb = (new Shop)->getTable();
        $userdb = (new User)->getTable();
        $orderdb = (new OrderDetail)->getTable();
        $query = User::where([$userdb . '.use_status' => User::STATUS_ACTIVE, $userdb . '.use_group' => User::TYPE_BranchUser]);
        $query->whereIn($userdb . '.parent_id', function($q) use ($req) {
            $q->select('use_id');
            $q->from((new User)->getTable());
            $q->where(function($q2) use ($req) {
                $q2->whereIn('use_group', [User::TYPE_BranchUser]);
                $q2->where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $req->user()->use_id]);
            });
            $q->orWhere('use_id', $req->user()->use_id);
        });

        $query->join($shopdb, $shopdb . '.sho_user', $userdb . '.use_id');
        $query->leftJoin($orderdb, $orderdb . '.af_id', $userdb . '.use_id');
        $query->select($userdb . '.*', DB::raw('SUM(tbtt_showcart.shc_total) As showcarttotal'));
        if (!empty($req->startDate)) {
            $query->where($userdb . '.shc_change_status_date ','>=', $req->startDate);
        }
        if (!empty($req->endDate)) {
            $query->where($userdb . '.shc_change_status_date','<=', $req->endDate);
        }
        if (!empty($req->sum)) {
            $result['totaRevenue'] = 0;
            $result = $query->select(DB::raw('SUM(tbtt_showcart.shc_total) As totaRevenue'))->first();

            return response(['msg' => Lang::get('response.success'), 'data' => $result], 200);
        }
        $query->groupBy($userdb . '.use_id');

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        //populate user
        $data = [];
        foreach ($paginate->items() as $item) {
            $result = $item->publicProfile();
            $result['parent'] = $item->getParentInfoV1();
            $result['totalRevenue'] = $item->showcarttotal;
            $result['shop'] = $item->shop;
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }
     /**
     * @SWG\Get(
     *     path="/api/v1/me/statistic-affiliate",
     *     operationId="revenue affiliate",
     *     description="Thống kê Affiliate",
     *     produces={"application/json"},
     *     tags={"statistic-affiliate"},
     *     summary="Thống kê Affiliate",
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="startDate",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="endDate",
     *         required=false,
     *         type="integer",
     *     ),
     *      @SWG\Parameter(
     *         name="sum",
     *         in="query",
     *         description="truyền params này để tính tổng doanh thu",
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
     *         description=" array result"
     *     )
     * )
     */
    
    
    public function statisticAffiliate(Request $req) {
        $userdb = User::tableName();
        $shopdb = (new Shop)->getTable();
        $orderdb = (new OrderDetail)->getTable();
        $productdb = Product::tableName();
        $user = $req->user();

        //Lấy danh sách các vị trí CN và NV của GH
        $tree = [];
        $tree[] = $user->use_id;
        $queryUser = User::where(['use_status' => User::STATUS_ACTIVE]);
        $queryUser->where(function($q) use($userdb, $user) {
            $q->orWhere(function($q) use($userdb, $user) {
                $q->where('use_group', User::TYPE_StaffUser);
                $q->whereIn('parent_id', function($q) use($userdb, $user) {
                    $q->select('use_id');
                    $q->from($userdb);
                    $q->where('use_status', User::STATUS_ACTIVE);
                    $q->where(['use_group' => User::TYPE_BranchUser]);
                    $q->whereIn('parent_id', function($q) use($userdb, $user) {
                        $q->select('use_id');
                        $q->from($userdb);
                        $q->where('use_status', User::STATUS_ACTIVE);
                        $q->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                        $q->where('parent_id', $user->use_id);
                    });
                });
            });

            $q->orWhere(function($q) use ($userdb, $user) {
                $q->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffUser]);
                $q->whereIn('parent_id', function($q) use($userdb, $user) {
                    $q->select('use_id');
                    $q->from($userdb);
                    $q->where('use_status', User::STATUS_ACTIVE);
                    $q->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                    $q->where('parent_id', $user->use_id);
                });
            });
//            
            $q->orWhere(function($q) use($userdb, $user) {
                $q->select('use_id');
                $q->from($userdb);
                $q->where('use_status', User::STATUS_ACTIVE);
                $q->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser, User::TYPE_StaffUser]);
                $q->where('parent_id', $user->use_id);
            });

            $q->orWhere(function($q) use ($userdb, $user) {
                $q->whereIn('use_group', [User::TYPE_StaffUser]);
                $q->whereIn('parent_id', function($q) use($userdb, $user) {
                    $q->select('use_id');
                    $q->where('use_status', User::STATUS_ACTIVE);
                    $q->from($userdb);
                    $q->whereIn('use_group', [User::TYPE_BranchUser]);
                    $q->where('parent_id', $user->use_id);
                });
            });
        });
        $ids = $queryUser->get()->pluck('use_id')->toArray();
        $tree = array_merge($tree,$ids);
        $idP = [];
        $query = User::where([$userdb . '.use_status' => User::STATUS_ACTIVE, $userdb . '.use_group' => User::TYPE_AffiliateUser]);
        if ($user->use_group == User::TYPE_StaffStoreUser) {
            $idP = [$user->parent_id];
        }
        $idP = array_merge($tree,$idP);
        
        if ($user->use_group == User::TYPE_StaffUser) {
            $idP = [$user->parent_id];
        }
        if ($user->use_group == User::TYPE_AffiliateStoreUser || $user->use_grouo == User::TYPE_StaffStoreUser) {
            $GH = $user->use_id;
            $tree1 = [];
            if ($user->use_group == User::TYPE_StaffStoreUser) {
                
                $tree1[] = $GH = $user->parent_id;
            }
            $querySub = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser, User::TYPE_StaffUser]);
            $querySub->where(['parent_id' => $user->use_id, 'use_status' => User::STATUS_ACTIVE]);


            //Lấy danh sách các vị trí CN và NV của GH
            $sub_tructiep = $querySub->get();
           
            if (!empty($sub_tructiep)) {
                foreach ($sub_tructiep as $key => $value) {
                    //Nếu là chi nhánh, lấy danh sách nhân viên
                    if ($value->use_group == User::TYPE_StaffStoreUser) {
                        //Lấy danh sách CN dưới nó cua NVGH
                        $sub_cn = User::where(['use_group' => User::TYPE_BranchUser, 'use_status' => User::STATUS_ACTIVE, 'parent_id' => $value->use_id])->get();
                        if (count($sub_cn) > 0) {
                            foreach ($sub_cn as $k => $vlue) {
                                $tree1[] = $vlue->use_id;
                            }
                        }
                    } else {
                        $tree1[] = $value->use_id;
                    }
                }
            }
            if(!empty($tree)){
                $query->where(function($q) use($GH,$tree1) {
                    $q->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
                    $q->orWhere(function($q) use ($tree1) {
                        $q->whereIn('tbtt_showcart.shc_saler', $tree1);
                        $q->where('pro_of_shop', '>', 0);
                    });
                });
               
            }else{
              $query->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
            }
     
        } else {
            if ($user->use_id == User::TYPE_BranchUser) {
                $query->where(['tbtt_showcart.shc_saler' => $user->use_id]);
            }
        }
        
        $query->whereIn($userdb . '.parent_id', $tree);
        $query->whereIn($orderdb.'.shc_saler',$idP);
        $query->whereIn($orderdb.'.shc_status',[01,02,03,98]);
        $query->join($userdb.' as parent', $userdb . '.parent_id', 'parent.use_id');
        $query->join($shopdb, $shopdb . '.sho_user', $userdb . '.use_id');
     
        $query->join($orderdb, $orderdb . '.af_id', $userdb . '.use_id');
        $query->leftJoin($productdb, 'tbtt_showcart.shc_product', 'tbtt_product.pro_id');
        $query->select($userdb . '.*', 'parent.use_username As parent_name','shc_change_status_date', 'parent.parent_id As parent_parent_id',  'parent.use_group as parent_group', DB::raw('SUM(tbtt_showcart.shc_total) As showcarttotal'));
        if (!empty($req->startDate)) {
            $query->where($orderdb . '.shc_change_status_date', '>=', $req->startDate);
        }
        
        if (!empty($req->endDate)) {
            
            $query->where($orderdb . '.shc_change_status_date', '<=', $req->endDate);
        }
        $query->orderBy($userdb.'.use_id','DESC');  
        
        $totalQ = clone $query;
        $totalRevenue = $totalQ->select(DB::raw('SUM(tbtt_showcart.shc_total) As totaRevenue'))->first();
        
        //$query->whereNotNull('showcarttotal');
        $query->groupBy($userdb . '.use_id');

        //return $query->get();

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        //populate user
        $data = [];
        foreach ($paginate->items() as $item) {
            $result = $item->publicProfile();
            $result['shc_change_status_date'] = $item->shc_change_status_date;
            $result['totalRevenue'] = $item->showcarttotal;
            $result['shop'] = $item->shop;
            $result['parent_parent_id'] = $item->parent_parent_id;
            $result['parent_name'] = $item->parent_name;
            $result['parent_group'] = $item->parent_group; //TODO: them
            $result['parent'] = $item->getParentInfo();
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['totalRevenue'] = $totalRevenue['totaRevenue'] ? $totalRevenue['totaRevenue'] : 0;
        $results['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);

    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/statistic-affiliate/{id}",
     *     operationId="statistic-affiliate detail",
     *     description="Thống kê Affiliate Chi Tiết",
     *     produces={"application/json"},
     *     tags={"statistic-affiliate"},
     *     summary="Thống kê Affiliate",
     *  @SWG\Parameter(
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
     *         description=" array result"
     *     )
     * )
     */
    
    public function statisticAffiliateDetail($id,Request $req){
        $userdb = User::tableName();
        $user = $req->user();
        $shopdb = (new Shop)->getTable();
        $prodb = Product::tableName();
        $orderdb = (new OrderDetail)->getTable();
        $subquery = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser,User::TYPE_StaffUser]);
        $subquery->where('use_status', User::STATUS_ACTIVE);
        $subquery->where('parent_id', $user->use_id);
        $sub_tructiep = $subquery->get();
        $tree = [$user->use_id];
        $tree1 = [];
        if (count($sub_tructiep) > 0) {
            foreach ($sub_tructiep as $key => $value) {
                $tree[] = $value->use_id;
                if ($value->use_group == User::TYPE_BranchUser) {
                    $sub_nv = User::where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $value->use_id])
                            ->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffUser])->get();
                    if (!empty($sub_nv)) {
                        foreach ($sub_nv as $k => $v) {
                            $tree[] = $v->use_id;
                        }
                    }
                }
                //Nếu là chi nhánh, lấy danh sách nhân viên
                if ($value->use_group == User::TYPE_StaffStoreUser) {
                    $sub_nv = User::where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $value->use_id])
                            ->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffUser])->get();
                    if (!empty($sub_nv)) {
                        foreach ($sub_nv as $k => $v) {
                            $tree[] = $v->use_id;
                            if ($v->use_group == User::TYPE_BranchUser) {
                                $tree1[] = $v->use_id;
                                $sub_nvcn = User::where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $v->use_id])
                                        ->whereIn('use_group', [User::TYPE_StaffUser])->get();
                                if (!empty($sub_nvcn)) {
                                    foreach ($sub_nvcn as $k => $v1) {
                                        $tree[] = $v1->use_id;
                                    }
                                }
                            }
                        }
                    }
                } else {
                   if ($value->use_group != User::TYPE_StaffUser) {
                        $tree1[] = $value->use_id;
                    }

                }
            }
        }
        $branchUser = User::where(['use_id' => $id])->first();
        $query = User::where([$userdb . '.use_status' => User::STATUS_ACTIVE])->whereIn(
            'use_group', [User::TYPE_AffiliateUser, User::TYPE_BranchUser]);
        if ($user->use_group == User::TYPE_AffiliateStoreUser || $user->use_group == User::TYPE_StaffStoreUser) {
            $GH = $user->use_id;
//        $tree[] = (int)$this->session->userdata('sessionUser');
            if ($user->use_group == User::TYPE_StaffStoreUser || $user->use_group == User::TYPE_StaffUser) {
                $tree1[] = $GH = (int) $user->parent_id;
            }



            if (!empty($tree1)) {
                $query->where(function($q) use($GH, $tree1) {
                    $q->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
                    $q->orWhere(function($q) use ($tree1) {
                        $q->whereIn('tbtt_showcart.shc_saler', $tree1);
                        $q->where('pro_of_shop', '>', 0);
                    });
                });
            } else {
                $query->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
            }
        } else {
            if ($user->use_group == User::TYPE_BranchUser) {
                $query->where(['tbtt_showcart.shc_saler' => $user->use_id]);
            }
        }



//      
      
        //begin dk statisticlistaffiliate
       if ($user->use_group == User::TYPE_StaffStoreUser || $user->use_group == User::TYPE_StaffUser) {
            $parent = $branchUser->parentInfo;
            if (!empty($parent)) {
                $tree[] = $parent->parent_id;
            }
        }
        if($user->use_group == User::TYPE_StaffUser){
            $query->where(function($q) use($user){
               $q->where(['shc_saler'=>$user->parent_id,'parent_id'=>$user->use_id]);
            });
        }else{
            $paGH_saler = [];
            if ($user->use_group == User::TYPE_StaffStoreUser) {
                $paGH_saler[] = $user->parent_id;
          
                if (!empty($tree)) {
                    $paGH_saler = array_merge($tree, $paGH_saler);
                }
               
                
                $query->where(function($q) use($user,$orderdb,$branchUser,$paGH_saler)  {
                    $q->whereIn($orderdb.'.shc_saler',$paGH_saler);
                    $q->where('af_id',$branchUser->use_id);
                    $q->whereIn('parent_id',[$branchUser->parent_id]);
                
                });
            }else{
                 $query->where(function($q) use($user,$tree,$branchUser) {
                    $q->whereIn('shc_saler',$tree);
                    $q->where('af_id',$branchUser->use_id);
                    $q->whereIn('parent_id',[$branchUser->parent_id]);
                
                });
            }
        }
        //$query->whereIn('shc_saler', $tree);
       // $query->join($shopdb, $shopdb.'.sho_user',$userdb.'.use_id');
        $query->join($orderdb, $orderdb . '.af_id', $userdb . '.use_id');
        
        $query->leftJoin($prodb, $orderdb . '.shc_product', $prodb . '.pro_id');
        $query->select(DB::raw($orderdb . '.shc_orderid as orderId'),'tbtt_showcart.af_id', 'use_id', 'use_group', 'use_email', 'use_fullname', 'parent_id', 'use_username', 'shc_quantity', 'shc_change_status_date', 'shc_total', 'pro_name', 'pro_cost');
        $query->whereIn($orderdb . '.shc_status', ['01', '02', '03', '98']);
        $bindings = $query->getBindings();
        $sql = $query->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sumSql = str_replace('\\', '\\\\', $sql);
   
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        $data = [];
        foreach ($paginate->items() as $item) {

            $result = $item;
            $result['shop'] = $item->shop;
            $result['parent'] = $item->getParentInfoV1();
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;

        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }
    public function statisticAffiliateDetailV2($id, Request $req) {
        $userdb = User::tableName();
        $user = $req->user();
        $shopdb = (new Shop)->getTable();
        $prodb = Product::tableName();
        $orderdb = (new OrderDetail)->getTable();

        //Lấy danh sách các vị trí CN và NV của GH
        //$tree = $user->getListBranchAndStaffIds();

        $query = User::where([$userdb . '.use_status' => User::STATUS_ACTIVE, $userdb . '.use_id' => $id]);
        //$query->whereIn('shc_saler', $tree);
        $query->join($orderdb, $orderdb . '.af_id', $userdb . '.use_id');
        $query->join($prodb, $orderdb . '.shc_product', $prodb . '.pro_id');
        $query->select(DB::raw($orderdb.'.shc_orderid as orderId'),'use_username', 'shc_quantity', 'shc_change_status_date', 'shc_total', 'pro_name', 'pro_cost');

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $result = $query->paginate($limit, ['*'], 'page', $page);
        return response(['msg' => Lang::get('response.success'), 'data' => $result], 200);


    }
    /**
     * @SWG\Get(
     *     path="/api/v1/me/statistic-product",
     *     operationId="statistic-product",
     *     description="Thống kê theo sản phẩm",
     *     produces={"application/json"},
     *     tags={"statistic-product"},
     *     summary="Thống kê theo sản phẩm",
     *  @SWG\Parameter(
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
     *    @SWG\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="startDate",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="endDate",
     *         required=false,
     *         type="integer",
     *     ),
     *      @SWG\Parameter(
     *         name="sum",
     *         in="query",
     *         description="Params này để tính tổn doanh thu",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description=" array result"
     *     )
     * )
     */
    
     protected function static_product(Request $req) {
        $starDate = mktime(0, 0, 0, 01, 01, 2006);
        $user = $req->user();
        $group_id = $user->use_group;
        $tree = [];
        
        $tree = $this->getTreeInProduct($user,$tree);
        $oderDetaildb = OrderDetail::tableName();
        $orderdb = Order::tableName();
        $productdb = Product::tableName();
        $query = OrderDetail::where([]);
 
        $query->join($orderdb, $orderdb . '.id', $oderDetaildb . '.shc_orderid');
        $query->select($productdb.'.pro_cost',
            DB::raw('SUM(IF('.$oderDetaildb.'.em_discount > 0,(('.$oderDetaildb.'.shc_quantity*'.$oderDetaildb.'.pro_price) - '.$oderDetaildb.'.em_discount),'.$oderDetaildb.'.shc_quantity*'.$oderDetaildb.'.pro_price)) as totalRevenue'),
            $productdb . '.pro_id',
            $orderdb . '.id',
            $oderDetaildb . '.*', 
            $orderdb . '.order_saler',
            $productdb . '.pro_user',
            DB::raw('SUM(' . $oderDetaildb . '.shc_quantity) As totalQty'),
            DB::raw('(SUM(' . $oderDetaildb . '.shc_quantity) * pro_cost ) AS totalRevenue1')
        );
        $query->leftJoin($productdb, $productdb . '.pro_id', $oderDetaildb . '.shc_product');
        $wheresparentt = User::select('use_id')->where('use_group', '<>', User::TYPE_AffiliateUser)->whereIn('parent_id', $tree)->pluck('use_id')->toArray();
        $tree = array_merge($tree, $wheresparentt);
        $wherestostt = User::select('use_id')->where('use_group', '<>', User::TYPE_AffiliateUser)->whereIn('parent_id', $tree)->pluck('use_id')->toArray();
        $tree = array_merge($tree, $wherestostt);
        $wherestostt = User::select('use_id')->where('use_group', User::TYPE_AffiliateUser)->whereIn('parent_id', $tree)->pluck('use_id')->toArray();
        $tree = array_merge($tree, $wherestostt);
        
        if ($group_id <= User::TYPE_AffiliateUser || $group_id == User::TYPE_StaffUser) {
            $query->whereIn($oderDetaildb . '.af_id', $tree);
            if ($group_id != User::TYPE_AffiliateUser) {

                $id_p = $user->parent_id; //Lay sp do chinh cha tk đó tao ra

                if ($user->use_group == User::TYPE_StaffUser) {

                    $get_p1 = $user->parentInfo;
                    if (!empty($get_p1)) {
                        $id_p = [$get_p1->use_id];
                        $id_p[] = $get_p1->parent_id;
                    }
                }
                $query->where(function($q) use($id_p) {
                    $q->whereIn('tbtt_order.order_saler', $id_p);
                    $q->whereIn('tbtt_product.pro_user', $id_p);
                });
            }
        } else {
            if ($user->use_group == User::TYPE_AffiliateStoreUser || $user->use_group == User::TYPE_StaffStoreUser) {
                $tree1 = array();
                $GH = (int) $user->use_id;
                if ($user->use_group == User::TYPE_StaffStoreUser) {

                    $tree1[] = $GH = (int) $user->parent_id;
                }
                
                $sub_tructiep = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser])
                        ->select(DB::raw('use_id, use_username, use_group'))
                        ->where('use_status', User::STATUS_ACTIVE)
                        ->select('use_id', 'use_group')
                        ->where('parent_id', $user->use_id)->get();
                if (!empty($sub_tructiep)) {
                    foreach ($sub_tructiep as $key => $value) {
                        //Nếu là chi nhánh, lấy danh sách nhân viên

                        if ($value->use_group == User::TYPE_StaffStoreUser) {
                            //Lấy danh sách CN dưới nó cua NVGH
                            $sub_cn = User::where(['use_group' => User::TYPE_BranchUser, 'use_status' => User::STATUS_ACTIVE, 'parent_id' => $value->use_id])->get();
                            if (count($sub_cn) > 0) {
                                foreach ($sub_cn as $k => $vlue) {
                                    $tree1[] = $vlue->use_id;
                                }
                            }
                        } else {
                            $tree1[] = $value->use_id;
                        }
                    }
                }
         
                 $query->where(function($q) use($GH, $tree1, $tree, $user) {
                        $q->where(['tbtt_order.order_saler' => $GH, 'pro_of_shop' => 0]);
                        if ($user->use_group == User::TYPE_StaffStoreUser) {
                            $q->whereIn('tbtt_showcart.af_id', $tree);
                        }
                    if (!empty($tree1)) {
                        $q->orWhere(function($q) use ($tree1) {
                            $q->whereIn('tbtt_order.order_saler', $tree1);
                            $q->where('pro_of_shop', '>', 0);
                        });
                    }
                    });
//                if (!empty($tree1)) {
//                    $query->where(function($q) use($GH, $tree1, $tree,$user) {
//                        $q->where(['tbtt_order.order_saler' => $GH, 'pro_of_shop' => 0]);
//                        if ($user->use_group == User::TYPE_StaffStoreUser) {
//                            $q->whereIn('tbtt_showcart.af_id', $tree);
//                        }
//                        $q->orWhere(function($q) use ($tree1) {
//                            $q->whereIn('tbtt_order.order_saler', $tree1);
//                            $q->where('pro_of_shop', '>', 0);
//                        });
//                    });
//                } else {
//                    $query->where(['tbtt_order.order_saler' => $GH, 'pro_of_shop' => 0]);
//                    if ($user->use_group == User::TYPE_StaffStoreUser) {
//                        $query->whereIn('tbtt_showcart.af_id', $tree);
//                    }
//                }
//            $id = implode(" OR tbtt_order.order_saler=", $tree1);
            } else {
                if ($user->use_group == User::TYPE_BranchUser) {
                    $query->where(['tbtt_order.order_saler' => $user->use_id]);
                } else {
                    $query->whereIn($oderDetaildb . '.af_id', $tree);
                }
            }

//            $wheree .= 'tbtt_order.order_saler IN (' . $tree . ') AND tbtt_product.pro_user IN (' . $tree . ')';
        }

        $query->orderBy($productdb . '.pro_user', 'ASC');
        if (!empty($req->startDate)) {
            $starDate = $req->startDate;
            $query->where($oderDetaildb . '.shc_change_status_date', '>=', $starDate);
        }

        if (!empty($req->endDate)) {
            $query->where($oderDetaildb . '.shc_change_status_date','<=', $req->endDate);
        }
        $query->whereIn('shc_status',['01','02','03','98']);
       
        

        $query->groupBy($productdb . '.pro_id');
        $bindings = $query->getBindings();
        $sql = $query->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
      
        $sumSql = str_replace('\\', '\\\\', $sql);
        $query2 = OrderDetail::from(DB::raw('(' . $sumSql . ') as dz'));

        $query2->select('dz.*');
        $query2->where('dz.totalRevenue', '>', 0);
        $query2->with(['category', 'product']);

        if ($req->sum) {
            
            /*$query->select(DB::raw('tbtt_order.order_saler,tbtt_showcart.af_id,'
                .'tbtt_showcart.shc_product,'
                .'tbtt_product.pro_user,'
                . 'tbtt_showcart.em_discount,tbtt_showcart.pro_price,tbtt_showcart.shc_quantity'));
            $bindings = $query->getBindings();
                $sql = $query->toSql();
            foreach ($bindings as $binding) {
                $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
                $sql = preg_replace('/\?/', $value, $sql, 1);
            }
            
            if ($req->dump) {
                $sumSql = str_replace('\\', '\\\\', $sql);
            }
            $sumSql = str_replace('\\', '\\\\', $sql );
            
            $querySum = OrderDetail::where([]);
            $querySum->select('af_id','order_saler',DB::raw('SUM(IF(em_discount > 0,((shc_quantity*pro_price) - em_discount),shc_quantity*pro_price)) as total'));
           
            $querySum->from(DB::raw('('.$sumSql.') as tz'));
            
            
            if ($user->use_group <= User::TYPE_AffiliateUser || $user->use_group == User::TYPE_StaffUser || $user->use_group == User::TYPE_StaffStoreUser) {
                $querySum->where(function($q) use ($tree) {
                    $q->whereIn('tz.af_id', $tree);
                    $q->orWhereIn('tz.order_saler', $tree);
                });
            } else {
                $querySum->where(function($q) use ($tree) {
                    $q->whereIn('tz.pro_user', $tree);
                    $q->whereIn('tz.order_saler', $tree);
                });
            }
      
           


            $result = $querySum->first();
            $total = 0;
            if (!empty($result)) {
                $total = !empty($result->total) ? $result->total : 0;
            }*/
            //$q = clone $query2;
            $total = $query2->sum('dz.totalRevenue');

            return response(['msg' => Lang::get('response.success'), 'data' => $total], 200);
        }


        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $results = $query2->paginate($limit, ['*'], 'page', $page);
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }
    
    protected function lasted_version(Request $req) {

        $starDate = mktime(0, 0, 0, 01, 01, 2006);
        $user = $req->user();
        $group_id = $user->use_group;
        $tree = [];

        $tree = $this->getTreeInProduct($user, $tree);
        $oderDetaildb = OrderDetail::tableName();
        $orderdb = Order::tableName();
        $productdb = Product::tableName();
        $query = OrderDetail::where([]);

        $query->join($orderdb, $orderdb . '.id', $oderDetaildb . '.shc_orderid');
        $query->select($productdb . '.pro_cost', DB::raw('SUM(IF(' . $oderDetaildb . '.em_discount > 0,((' . $oderDetaildb . '.shc_quantity*' . $oderDetaildb . '.pro_price) - ' . $oderDetaildb . '.em_discount),' . $oderDetaildb . '.shc_quantity*' . $oderDetaildb . '.pro_price)) as totalRevenue'), $productdb . '.pro_id', $orderdb . '.id', $oderDetaildb . '.*', $orderdb . '.order_saler', $productdb . '.pro_user', DB::raw('SUM(' . $oderDetaildb . '.shc_quantity) As totalQty'), DB::raw('(SUM(' . $oderDetaildb . '.shc_quantity) * pro_cost ) AS totalRevenue1')
        );
        $query->leftJoin($productdb, $productdb . '.pro_id', $oderDetaildb . '.shc_product');
        if ($group_id <= User::TYPE_AffiliateUser || $group_id == User::TYPE_StaffUser) {
            $query->whereIn($oderDetaildb . '.af_id', $tree);
            if ($group_id != User::TYPE_AffiliateUser) {

                $id_p = $user->parent_id; //Lay sp do chinh cha tk đó tao ra

                if ($user->use_group == User::TYPE_StaffUser) {

                    $get_p1 = $user->parentInfo;
                    if (!empty($get_p1)) {
                        $id_p = [$get_p1->use_id];
                        $id_p[] = $get_p1->parent_id;
                    }
                }
                $query->where(function($q) use($id_p) {
                    $q->whereIn('tbtt_order.order_saler', $id_p);
                    $q->whereIn('tbtt_product.pro_user', $id_p);
                });
            }
        } else {
            if ($user->use_group == User::TYPE_AffiliateStoreUser || $user->use_group == User::TYPE_StaffStoreUser) {
                $tree1 = array();
                $GH = (int) $user->use_id;
                if ($user->use_group == User::TYPE_StaffStoreUser) {

                    $tree1[] = $GH = (int) $user->parent_id;
                }

                $sub_tructiep = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser])
                        ->select(DB::raw('use_id, use_username, use_group'))
                        ->where('use_status', User::STATUS_ACTIVE)
                        ->select('use_id', 'use_group')
                        ->where('parent_id', $user->use_id)->get();
                if (!empty($sub_tructiep)) {
                    foreach ($sub_tructiep as $key => $value) {
                        //Nếu là chi nhánh, lấy danh sách nhân viên

                        if ($value->use_group == User::TYPE_StaffStoreUser) {
                            //Lấy danh sách CN dưới nó cua NVGH
                            $sub_cn = User::where(['use_group' => User::TYPE_BranchUser, 'use_status' => User::STATUS_ACTIVE, 'parent_id' => $value->use_id])->get();
                            if (count($sub_cn) > 0) {
                                foreach ($sub_cn as $k => $vlue) {
                                    $tree1[] = $vlue->use_id;
                                }
                            }
                        } else {
                            $tree1[] = $value->use_id;
                        }
                    }
                }


                if (!empty($tree1)) {
                    $query->where(function($q) use($GH, $tree1, $tree, $user) {
                        $q->where(['tbtt_order.order_saler' => $GH, 'pro_of_shop' => 0]);
                        if ($user->use_group == User::TYPE_StaffStoreUser) {
                            $q->whereIn('tbtt_showcart.af_id', $tree);
                        }
                        $q->orWhere(function($q) use ($tree1) {
                            $q->whereIn('tbtt_order.order_saler', $tree1);
                            $q->where('pro_of_shop', '>', 0);
                        });
                    });
                } else {
                    $query->where(['tbtt_order.order_saler' => $GH, 'pro_of_shop' => 0]);
                    if ($user->use_group == User::TYPE_StaffStoreUser) {
                        $query->whereIn('tbtt_showcart.af_id', $tree);
                    }
                }
//            $id = implode(" OR tbtt_order.order_saler=", $tree1);
            } else {
                if ($user->use_group == User::TYPE_BranchUser) {
                    $query->where(['tbtt_order.order_saler' => $user->use_id]);
                } else {
                    $query->whereIn($oderDetaildb . '.af_id', $tree);
                }
            }

//            $wheree .= 'tbtt_order.order_saler IN (' . $tree . ') AND tbtt_product.pro_user IN (' . $tree . ')';
        }

        $query->orderBy($productdb . '.pro_user', 'ASC');
        if (!empty($req->startDate)) {
            $starDate = $req->startDate;
            $query->where($oderDetaildb . '.shc_change_status_date', '>=', $starDate);
        }

        if (!empty($req->endDate)) {
            $query->where($oderDetaildb . '.shc_change_status_date', '<=', $req->endDate);
        }
        $query->whereIn('shc_status', ['01', '02', '03', '98']);



        $query->groupBy($productdb . '.pro_id');
        $bindings = $query->getBindings();
        $sql = $query->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }

        $sumSql = str_replace('\\', '\\\\', $sql);
        $query2 = OrderDetail::from(DB::raw('(' . $sumSql . ') as dz'));

        $query2->select('dz.*');
        $query2->where('dz.totalRevenue', '>', 0);
        $query2->with(['category', 'product']);

        if ($req->sum) {

            /* $query->select(DB::raw('tbtt_order.order_saler,tbtt_showcart.af_id,'
              .'tbtt_showcart.shc_product,'
              .'tbtt_product.pro_user,'
              . 'tbtt_showcart.em_discount,tbtt_showcart.pro_price,tbtt_showcart.shc_quantity'));
              $bindings = $query->getBindings();
              $sql = $query->toSql();
              foreach ($bindings as $binding) {
              $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
              $sql = preg_replace('/\?/', $value, $sql, 1);
              }

              if ($req->dump) {
              $sumSql = str_replace('\\', '\\\\', $sql);
              }
              $sumSql = str_replace('\\', '\\\\', $sql );

              $querySum = OrderDetail::where([]);
              $querySum->select('af_id','order_saler',DB::raw('SUM(IF(em_discount > 0,((shc_quantity*pro_price) - em_discount),shc_quantity*pro_price)) as total'));

              $querySum->from(DB::raw('('.$sumSql.') as tz'));


              if ($user->use_group <= User::TYPE_AffiliateUser || $user->use_group == User::TYPE_StaffUser || $user->use_group == User::TYPE_StaffStoreUser) {
              $querySum->where(function($q) use ($tree) {
              $q->whereIn('tz.af_id', $tree);
              $q->orWhereIn('tz.order_saler', $tree);
              });
              } else {
              $querySum->where(function($q) use ($tree) {
              $q->whereIn('tz.pro_user', $tree);
              $q->whereIn('tz.order_saler', $tree);
              });
              }




              $result = $querySum->first();
              $total = 0;
              if (!empty($result)) {
              $total = !empty($result->total) ? $result->total : 0;
              } */
            //$q = clone $query2;
            $total = $query2->sum('dz.totalRevenue');

            return response(['msg' => Lang::get('response.success'), 'data' => $total], 200);
        }


        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $results = $query2->paginate($limit, ['*'], 'page', $page);
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }

    function product(Request $req) {

        return $this->lasted_version($req);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/statistic-product/{pro_id}",
     *     operationId="statistic-product",
     *     description="Thống kê chi tiết sản phẩm",
     *     produces={"application/json"},
     *     tags={"statistic-product"},
     *     summary="Thống kê chi tiết sản phẩm",
     *  @SWG\Parameter(
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
     *      @SWG\Parameter(
     *         name="sum",
     *         in="query",
     *         description="Params này để tính tổn doanh thu",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description=" array result"
     *     )
     * )
     */
    
     function productDetail($id,Request $req){
         $user = $req->user();
        $group_id = $user->use_group;
        $tree = [];
        $tree = $this->getTreeInProduct($user, $tree);

        $oderDetaildb = OrderDetail::tableName();
        $productdb = Product::tableName();
        $orderdb = Order::tableName();
        $userdb = User::tableName();
        $query = OrderDetail::where(['shc_product' => $id]);
        $query->join($orderdb, $orderdb . '.id', $oderDetaildb . '.shc_orderid');
        $query->leftJoin($productdb, $productdb . '.pro_id', $oderDetaildb . '.shc_product');
        $query->leftJoin($userdb, $userdb . '.use_id', $orderdb . '.order_user');
        $query->leftJoin('tbtt_group', 'tbtt_group.gro_id', $userdb . '.use_group');
        if ($group_id <= User::TYPE_AffiliateUser || $group_id == User::TYPE_StaffUser) {

            $query->whereIn($oderDetaildb . '.af_id', $tree);
        } else {
            $query->whereIn($orderdb . '.order_saler', $tree);
            $query->whereIn($productdb . '.pro_user', $tree);

//            $wheree .= 'tbtt_order.order_saler IN (' . $tree . ') AND tbtt_product.pro_user IN (' . $tree . ')';
        }

        $select = "pro_dir,order_token,order_user,order_saler, shc_orderid,id,pro_name,pro_cost,pro_image,tbtt_product.pro_category,tbtt_product.pro_id,tbtt_product.pro_id,tbtt_product.pro_cost,  SUM(shc_quantity) AS totalQty , (SUM(shc_quantity)* pro_cost) AS totalRevenue";
        $select = "shc_quantity * pro_price - em_discount as doanhthu, em_discount,tbtt_showcart.af_id,af_dc_rate,af_dc_amt,pro_price_rate,pro_price_amt,pro_dir,order_token, shc_orderid,id,pro_name,pro_cost,pro_image,tbtt_product.pro_category,tbtt_product.pro_id,tbtt_user.*,tbtt_group.*,tbtt_showcart.*,tbtt_product.pro_id,tbtt_product.pro_cost, shc_quantity, pro_price";//SUM(shc_quantity) AS shc_quantity_sum , (SUM(shc_quantity)* pro_price) AS total_sum

        $query->select(DB::raw($select), $oderDetaildb . '.*');
        if ($req->sum) {
            $total = $query->sum(DB::raw($oderDetaildb . '.shc_quantity* pro_cost'));

            return response(['msg' => Lang::get('response.success'), 'data' => $total], 200);
        }
        $query->orderBy('pro_name', 'DESC');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $query->groupBy($orderdb . '.order_user');
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        $data = [];
        foreach ($paginate->items() as $item) {
            $value = $item->toArray();
            $value['orderId'] = $item->shc_orderid;
            $value['user'] = $item->buyer->toArray();
            $value['user']['group'] = $item->buyer->group;
            $data[] = $value;
        }
        $result = $paginate->toArray();
        $result['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $result], 200);
    }

    function productDetailV2($id,Request $req){
        $user = $req->user();
        $group_id = $user->use_group;
        $tree = [];
        $tree = $this->getTreeInProduct($user, $tree);

        $oderDetaildb = OrderDetail::tableName();
        $productdb = Product::tableName();
        $orderdb = Order::tableName();
        $userdb = User::tableName();
        $query = OrderDetail::where(['shc_product' => $id]);
        
        if ($user->use_group == User::TYPE_AffiliateStoreUser || $user->use_group == User::TYPE_StaffStoreUser) {
            $tree1 = array();
            $GH = (int) $user->use_id;
            if ($user->use_group == User::TYPE_StaffStoreUser) {
                $tree1[] = $GH = (int) $user->parent_id;
            }
            $sub_tructiep = User::whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser])
                    ->select(DB::raw('use_id, use_username, use_group'))
                    ->where('use_status', User::STATUS_ACTIVE)
                    ->select('use_id', 'use_group')
                    ->where('parent_id', $user->parent_id)->get();
            if (!empty($sub_tructiep)) {
                foreach ($sub_tructiep as $key => $value) {
                    //Nếu là chi nhánh, lấy danh sách nhân viên

                    if ($value->use_group == User::TYPE_StaffStoreUser) {
                        //Lấy danh sách CN dưới nó cua NVGH
                        $sub_cn = User::where(['use_group' => User::TYPE_BranchUser, 'use_status' => User::STATUS_ACTIVE, 'parent_id' => $value->use_id])->get();
                        if (count($sub_cn) > 0) {
                            foreach ($sub_cn as $k => $vlue) {
                                $tree1[] = $vlue->use_id;
                            }
                        }
                    } else {
                        $tree1[] = $value->use_id;
                    }
                }
            }

            if (!empty($tree1)) {
                $query->where(function($q) use($GH, $tree1, $tree,$user) {
                    $q->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
                    if ($user->use_group == User::TYPE_StaffStoreUser) {
                        $q->whereIn('tbtt_showcart.af_id', $tree);
                    }
                    $q->orWhere(function($q) use ($tree1) {
                        $q->whereIn('tbtt_showcart.shc_saler', $tree1);
                        $q->where('pro_of_shop', '>', 0);
                    });
                });
            } else {
                $query->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
                if ($user->use_group == User::TYPE_StaffStoreUser) {
                    $query->whereIn('tbtt_showcart.af_id', $tree);
                }
            }
//            $id = implode(" OR tbtt_order.order_saler=", $tree1);
        } else {
            if ($user->use_group == User::TYPE_BranchUser) {
                $query->where(['tbtt_showcart.shc_saler' => $user->use_id]);
            } else {
                $query->whereIn($oderDetaildb . '.af_id', $tree);
            }
        }
        if ($group_id <= User::TYPE_AffiliateUser || $group_id == User::TYPE_StaffUser) {
            $query->whereIn($oderDetaildb . '.af_id', $tree);
            $parent = $user->parentInfo;
            $id_p = [$user->parent_id]; //Lay sp do chinh cha tk đó tao ra
            if ($user->use_group == User::TYPE_StaffUser || !empty($parent) && $parent->use_group == User::TYPE_StaffUser) {
//                 if ($user->use_group ==  User::TYPE_StaffUser) {
//                    $id_p[] = $user->use_id;
//                }
                if (!empty($parent)) {
                    $id_p[] = $parent->parent_id;
                    $parent_p = $parent->parentInfo;
                    if (!empty($parent_p)) {
                        $id_p[] = $parent_p->parent_id;
                    }
                }
            }
            if ($group_id != User::TYPE_AffiliateUser) {
                $query->where(function($q) use($id_p) {
                    $q->whereIn('tbtt_order.order_saler', $id_p);
                    $q->whereIn('tbtt_product.pro_user', $id_p);
                });
            }
        }  
        

//            $wheree .= 'tbtt_order.order_saler IN (' . $tree . ') AND tbtt_product.pro_user IN (' . $tree . ')';
        

        $query->join($orderdb, $orderdb . '.id', $oderDetaildb . '.shc_orderid');
        $query->leftJoin($productdb, $productdb . '.pro_id', $oderDetaildb . '.shc_product');
        $query->leftJoin($userdb, $userdb . '.use_id', $orderdb . '.order_user');
        $query->leftJoin('tbtt_group', 'tbtt_group.gro_id', $userdb . '.use_group');
        $query->whereIn('shc_status', [01, 02, 03, 98]);
        $query->where($oderDetaildb.'.shc_product',$id);
        $select = "pro_dir,em_discount,order_token,order_user,order_saler, shc_orderid,id,pro_name,pro_cost,pro_image,tbtt_product.pro_category,tbtt_product.pro_id,tbtt_product.pro_id,tbtt_product.pro_cost,  SUM(shc_quantity) AS totalQty , (SUM(".$oderDetaildb.".shc_quantity * ".$oderDetaildb.".pro_price - ".$oderDetaildb.".em_discount)) AS totalRevenue";

        
        if($req->sum){
            $total = $query->sum(DB::raw($oderDetaildb.'.shc_quantity* pro_price - em_discount'));
            
            return response(['msg' => Lang::get('response.success'), 'data' => $total], 200);
        }
        $query->select(DB::raw($select), $oderDetaildb . '.*');
        $query->orderBy('pro_name', 'DESC');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $query->groupBy($orderdb . '.order_user');
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        $data = [];
        foreach($paginate->items() as $item){
            $value = $item->toArray();
            $value['orderId'] = $item->shc_orderid;
            $value['user'] = $item->buyer->toArray();
            $value['user']['group'] = $item->buyer->group;
            $data[] = $value;
        }
        $result = $paginate->toArray();
        $result['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $result], 200);



//        $totalRecord = Count($this->order_model->fetch_join6($select, "INNER", "tbtt_showcart", "tbtt_order.id = tbtt_showcart.shc_orderid", "LEFT", "tbtt_user", "tbtt_order.order_saler = tbtt_user.use_id", "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", $wheree, "", "", "", ""));
//
//        $config['base_url'] = base_url() . 'account/detail_statistic_product' . $pageUrl . '/page/';
//        $config['total_rows'] = $totalRecord;
//        $config['per_page'] = 20;
//        $config['num_links'] = 1;
//        $config['uri_segment'] = 4;
//        $limit = 20;
//        $config['cur_page'] = $start;
//        $this->pagination->initialize($config);
//        $data['linkPage'] = $this->pagination->create_links();
//        $data['stt'] = $start;
//        #END Pagination
//
//        $liststoredetail = $this->order_model->fetch_join6($select, "INNER", "tbtt_showcart", "tbtt_order.id = tbtt_showcart.shc_orderid", "LEFT", "tbtt_user", "tbtt_order.order_user = tbtt_user.use_id", "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", $wheree, $sort, $by, $start, $limit);
//        #Load view
//        $use_id = (int)$this->input->post('use_id');
//        $shop_id = (int)$this->input->post('parent_shop_id');
//        if (isset($use_id) && $use_id > 0) {
//            $this->user_model->update(array('parent_shop' => $shop_id), 'use_id = ' . $use_id);
//            echo '1';
//            return false;
//            exit();
//        }
//        $total_sum_staff = 0;
//
//        $demo = '';
//        foreach ($liststoredetail as $key => $items) {
//            if ($items->order_user == 0 || $items->order_user == '') {
//                $demo = $this->user_model->fetch('*', 'use_id =' . $items->shc_saler);
//            }
//            $total_sum_staff += $items->pro_cost;
//        }
//        $data['shopname'] = $demo;
//        $data['staffs'] = $liststoredetail;
//        $data['total_sum_staff'] = $total_sum_staff;
//        $data['menuSelected'] = 'statistic';
//        $data['menuType'] = 'account';
//        $this->load->view('home/account/statistic/detail_statistic_product', $data);
    }
    function getTreeInProduct($user, $tree) {
        $userTreeModel = new UserTree();
        $userTreeModel->getTreeInList($user->use_id, $tree);
        $tree[] = $user->use_id;

        $wheresparentt = User::whereIn('parent_id', $tree)->where('use_group', '!=', User::TYPE_AffiliateUser)->get();
        $wheresparentt = $wheresparentt->pluck('use_id')->toArray();
       
        $tree = array_merge($tree, $wheresparentt);
        $wherestostt = User::whereIn('parent_id', $tree)->where('use_group', '!=', User::TYPE_AffiliateUser)->get();
        $wherestostt = $wherestostt->pluck('use_id')->toArray();
         
        $tree = array_merge($tree, $wherestostt);
        $wherestost = User::whereIn('parent_id', $tree)->where('use_group', User::TYPE_AffiliateUser)->get();
        $wherestost = $wherestost->pluck('use_id')->toArray();
        $tree = array_merge($tree, $wherestost);
        return $tree;
    }
       /**
     * @SWG\Get(
     *     path="/api/v1/me/count-aff",
     *     operationId="count-affiliate",
     *     description="Thống kê số cong tac vien",
     *     produces={"application/json"},
     *     tags={"statistic-product"},
     *     summary="Thống kê số cong tac vien",
     *     @SWG\Response(
     *         response=200,
     *         description=" array result"
     *     )
     * )
     */
    function countAffiliate(Request $req) {
        $user = $req->user();
        $tree[] = $user->use_id;
        $sub_tructiep = User::select('use_id', 'use_group')->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffStoreUser, User::TYPE_StaffUser])
                ->where('use_status', User::STATUS_ACTIVE)->where('parent_id', $user->use_id)->get();
        if (!empty($sub_tructiep)) {
            foreach ($sub_tructiep as $key => $value) {
                //Nếu là chi nhánh, lấy danh sách nhân viên
                $tree[] = $value->use_id;
                if ($value->use_group == User::TYPE_StaffStoreUser) {
                    //Lấy danh sách CN dưới nó cua NVGH

                    $sub_cn = User::select('use_id', 'use_group')->whereIn('use_group', [User::TYPE_BranchUser, User::TYPE_StaffUser])
                            ->where('use_status', User::STATUS_ACTIVE)->where('parent_id', $value->use_id)->get();

                    if (!empty($sub_cn)) {
                        foreach ($sub_cn as $k => $vlue) {
                            $tree[] = $vlue->use_id;
                            if ($vlue->use_group == User::TYPE_BranchUser) {
                                $sub_cn = User::select('use_id', 'use_group')->whereIn('use_group', [User::TYPE_StaffUser])
                                        ->where('use_status', User::STATUS_ACTIVE)->where('parent_id', $vlue->use_id)->get();
                                //Lấy danh sách CN dưới nó cua NVGH
                                if (!empty($sub_cn)) {
                                    foreach ($sub_cn as $k => $v) {
                                        $tree[] = $v->use_id;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($value->use_group == User::TYPE_BranchUser) {
                    //Lấy danh sách CN dưới nó cua NVGH
                    $sub_cn = User::select('use_id', 'use_group')->whereIn('use_group', [User::TYPE_StaffUser])
                            ->where('use_status', User::STATUS_ACTIVE)->where('parent_id', $value->use_id)->get();

                    if (!empty($sub_cn)) {
                        foreach ($sub_cn as $k => $v) {
                            $tree[] = $v->use_id;
                        }
                    }
                }
            }
        }

        $total = User::whereIn('parent_id', $tree)->where(['use_group' => User::TYPE_AffiliateUser, 'use_status' => User::STATUS_ACTIVE])->count();
        return response(['msg' => Lang::get('response.success'), 'data' => ['total' => $total]], 200);
    }

}
