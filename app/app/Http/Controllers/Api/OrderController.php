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
use App\Models\Status;
use App\Helpers\Commons;
use App\Helpers\Hash;
use App\Models\District;
use App\Components\ViettelAPi;
use App\Models\GiaoHangNhanhLog;
use App\Components\RestApiClient;
class OrderController extends ApiController {

	
    
    
    /**
     * @SWG\Post(
     *     path="/api/v1/orders/{id}",
     *     operationId="ordersCart",
     *     description="Mua sản phẩm",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Trả về đơn hàng",
     *  @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Đây là id của user bạn mua hàng",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="products",
     *         in="body",
     *         description="Mãng product bao gồm pro_id,qty,pro_price,af_id",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="shipping_method",
     *         in="body",
     *         description="shipping_method phải bằng SHO,GHN,VTP",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="payment_method",
     *         in="body",
     *         description="Hình thức thanh toán có 2 loại . 1. info_nganluong = Thanh toán bằng ngân lượng , 2.info_cod = thanh toán khi giao hàng",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Parameter(
     *         name="amount",
     *         in="body",
     *         description="Tổng tiền phải trả",
     *         required=true,
     *         type="string",
     *   ),
     * 
     *  @SWG\Parameter(
     *         name="use_fullname",
     *         in="body",
     *         description="Tên người nhận hàng",
     *         required=true,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="use_address",
     *         in="body",
     *         description="Địa chỉ người nhận",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="use_email",
     *         in="body",
     *         description="Email người nhận",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="use_mobile",
     *         in="body",
     *         description="Số điện thoại",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="use_province",
     *         in="body",
     *         description="Tĩnh",
     *         required=true,
     *         type="string",
     *     ), 
    *    @SWG\Parameter(
     *         name="use_district",
     *         in="body",
     *         description="Quận",
     *         required=true,
     *         type="string",
     *     ),
    *    @SWG\Parameter(
     *         name="products.*.af_id",
     *         in="body",
     *         description="affilate key ",
     *         required=true,
     *         type="integer",
     *     ), 
     *      @SWG\Parameter(
     *         name="products.*.dp_id",
     *         in="body",
     *         description="Id của qui cách",
     *         required=true,
     *         type="integer",
     *     ), 
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    
    public function create($sellerId, Request $req) {
        return $this->book_order($sellerId, $req);
    }

    /**
     * @SWG\Post(
     *     path="/api/v1/orders/{id}/check",
     *     operationId="ordersCartcheck",
     *     description="Kiểm tra Mua sản phẩm",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Trả về đơn hàng",
     *  @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Đây là id của user bạn mua hàng",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="products",
     *         in="body",
     *         description="Mãng product bao gồm pro_id,qty,pro_price,af_id",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="shipping_method",
     *         in="body",
     *         description="shipping_method phải bằng SHO,GHN,VTP",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="payment_method",
     *         in="body",
     *         description="Hình thức thanh toán có 2 loại . 1. info_nganluong = Thanh toán bằng ngân lượng , 2.info_cod = thanh toán khi giao hàng",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Parameter(
     *         name="amount",
     *         in="body",
     *         description="Tổng tiền phải trả",
     *         required=true,
     *         type="string",
     *   ),
     * 
     *  @SWG\Parameter(
     *         name="use_fullname",
     *         in="body",
     *         description="Tên người nhận hàng",
     *         required=true,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="use_address",
     *         in="body",
     *         description="Địa chỉ người nhận",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="use_email",
     *         in="body",
     *         description="Email người nhận",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="use_mobile",
     *         in="body",
     *         description="Số điện thoại",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="use_province",
     *         in="body",
     *         description="Tĩnh",
     *         required=true,
     *         type="string",
     *     ), 
    *    @SWG\Parameter(
     *         name="use_district",
     *         in="body",
     *         description="Quận",
     *         required=true,
     *         type="string",
     *     ),
    *    @SWG\Parameter(
     *         name="products.*.af_id",
     *         in="body",
     *         description="affilate key ",
     *         required=true,
     *         type="integer",
     *     ), 
     *      @SWG\Parameter(
     *         name="products.*.dp_id",
     *         in="body",
     *         description="Id của qui cách",
     *         required=true,
     *         type="integer",
     *     ), 
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function checkOrder($sellerId, Request $req) {
        return $this->book_order($sellerId, $req, true);
    }

    private function book_order($sellerId, Request $req, $check = false) {
        // Check double click
        $validator = Validator::make($req->all(), [
                'products' => 'required',
                'products.*.pro_id' => 'required',
                'products.*.qty' => 'required',
                'products.*.pro_price'=>'required',
                'shipping_method' => 'required',
                'use_fullname' => 'required|max:100',
                'use_address' => 'required|max:100',
                'use_email' => 'required|max:50',
                'use_mobile' => 'required|max:20',
                'use_province' => 'required',
                'use_district' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $shop = Shop::where(['sho_user' => $sellerId])->
                select(DB::raw('sho_name,sho_link,sho_id, sho_user, sho_shipping, IF(sho_kho_district <> \'\', sho_kho_district, sho_district) AS district'))->first();

        if (empty($shop)) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        
        $total = 0;
        $num = 0;
        $totalWeight = 0;
        $products = [];
        foreach ($req->products as $item) {
            // Build product price  
            if (isset($item['dp_id']) && $item['dp_id'] > 0) {
                $dp_id = $item['dp_id'];
                $query = Product::where([
                        'pro_status' => Product::STATUS_ACTIVE,
                        'pro_type' => Product::TYPE_DEFAULT,
                        'pro_id' => (int) $item['pro_id']]);
                $query->select(DB::raw('pro_minsale,pro_name, pro_category, pro_id, pro_user,pro_instock, pro_buy, af_amt,af_rate as af_rate_ori, af_amt as af_amt_ori af_rate, dc_amt, dc_rate, (dp_cost) AS pro_cost, is_product_affiliate, T2.*,' . Product::queryDiscountProductDp()));
                $query->leftJoin(DB::raw('(SELECT * FROM tbtt_detail_product WHERE id = ' . $dp_id . ') AS T2'), 'T2.dp_pro_id', 'tbtt_product.pro_id');
               
               
                $productInfo = $query->first();
            } else {
                $query = Product::where([
                        'pro_status' => Product::STATUS_ACTIVE,
                        'pro_id' => (int) $item['pro_id']])
                    ->select(DB::raw('pro_category,pro_minsale,pro_name, pro_id, pro_user,pro_instock, pro_buy, af_amt, af_rate,af_rate as af_rate_ori, af_amt as af_amt_ori, dc_amt, dc_rate,  pro_cost, is_product_affiliate,' . Product::queryDiscountProduct()));
                $productInfo = $query->first();
            }
            if (empty($productInfo)) {
                continue;
            }
            
            if ((int)$item['qty'] > (int)$productInfo->pro_instock || empty($productInfo->pro_instock)) {
               
                return response([
                    'msg' => 'Số lượng sản phẩm ' . $productInfo->pro_name . ' không đủ đáp ứng yêu cầu của bạn',
                    ], 402);
                break;
            }
            $num += $item['qty'];
            $item['pro_user'] = $productInfo['pro_user'];
            $totalWeight += $productInfo->pro_weight * $item['qty'];

            $wholesale = false;
            $group = 0;
            if (!empty($req->user())) {
                $shopInfo = Shop::where(['shop_user' => $req->user()->use_id])->first();
                $wholesale = $shopInfo->shop_type > Shop::TYPE_AFFILIATE ? true : false;
                $group = $req->user()->use_group;
            }
            if ($wholesale) {
                if ($productInfo->shop->shop_type == Shop::TYPE_AFFILIATE) {
                    // retailer shop
                    unset($item);
                    continue;
                } elseif ($item['qty'] < $productInfo->pro_minsale) {
                    $item['qty'] = $productInfo->pro_minsale;
                }
            }
            $item['shipping_fee'] = 0;
            $afSelect = false;
            if (isset($item['af_id']) && !empty($item['af_id']) && $productInfo->is_product_affiliate == 1) {
                $afSelect = true;
            }
            
  
            $priceInfo = Commons::buildPrice($productInfo, $group, $afSelect);
      
            $item['pro_price_original'] = $productInfo->pro_cost;
            $item['pro_price'] = $priceInfo['salePrice'];
            //print_r($priceInfo);
            $item['pro_price_rate'] = 0;
            $item['pro_price_amt'] = 0;
            $item['pro_category'] = $productInfo->pro_category;
            if ($priceInfo['saleOff'] > 0) {
                if ($productInfo->off_rate > 0) {
                    $item['pro_price_rate'] = $productInfo->off_rate;
                } else {
                    $item['pro_price_amt'] = $productInfo->off_amount;
                }
            }

            $item['af_rate'] = $productInfo->af_rate_ori;
            $item['af_amt'] = $productInfo->af_amt_ori;
            $item['dc_amt'] = 0;
            $item['dc_rate'] = 0;
            if ($priceInfo['em_off'] > 0) {
                $item['dc_amt'] = $productInfo->dc_amt;
                $item['dc_rate'] = $productInfo->dc_rate;
            }
            $item['affiliate_discount_amt'] = 0;
            $item['affiliate_discount_rate'] = 0;
            if ($priceInfo['af_off'] > 0) {
                if ($priceInfo['af_rate'] > 0) {
                    $item['affiliate_discount_rate'] = $priceInfo['af_rate'];
                } else {
                    $item['affiliate_discount_amt'] = $priceInfo['af_off'];
                }
            }
            // Make discount for member
            $item['em_promo'] = 0;
            $loginUser = $req->user()? $req->user()->use_id: null;
  
            if ($productInfo->pro_user != $loginUser) {
                
                $promotion = $this->getProductPro(['pro_id' => $productInfo->pro_id, 'qty' => $item['qty'], 'total' => ($item['pro_price'] * $item['qty'])]);
              
                if (!empty($promotion) && count($promotion) > 0) {
                    if ($promotion->dc_rate > 0) {
                        $item['em_promo'] = $item['pro_price'] * $item['qty'] * $promotion->dc_rate / 100;
                    } else {
                        $item['em_promo'] = $promotion->dc_amt;
                    }
                }
            }
            // get shop type
            $item['shc_saler_store_type'] = $productInfo->shop->shop_type;
            
            $order_type = $item['shc_saler_store_type'];
            if ($order_type == 2) {
                if ($productInfo->pro_minsale <= $item['qty']) {
                    $order_type = 1;
                } else {
                    $order_type = 0;
                }
            }
            $item['order_type'] = $order_type;
            $products[] = $item;

            $total += ($item['pro_price'] * $item['qty']) - $item['em_promo'];
        }
 
        $fee = ShipService::getFee($req->shipping_method, $shop->district, $req->use_district, $totalWeight);

        if (!isset($fee['ServiceFee'])) {
            return response([
                'msg' => Lang::get('order.place_not_support'),
                'data' => $total
            ], 400);    
        }
        
        if ($check) {
            return response([
                'msg' => Lang::get('response.success')
            ]);
        }

        if(isset($fee['ServiceFee'])){
          $total +=  $fee['ServiceFee'];  
        }
     
        if ($total > 0 && $total != $req->amount) {
            return response([
                'msg' => Lang::get('order.amount_not_valid'),
                'data' => $total
            ], 400);
        } elseif ($total == 0) {
            return response([
                'msg' => Lang::get('order.not_have_product'),
                'data' => $total
                ], 400);
        }
        

        // Tung Add user khi khach mua hang khong dang nhap
        $userData = $req->user();
        if (empty($req->user())) {
            $validator = Validator::make($req->all(), [
                'use_email' => 'required|email'
                ]);

            if ($validator->fails()) {
                return response([
                    'msg' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                    ], 422);
            }
            $userData = $this->createUser($req, $productInfo);
        }


            // end
            // Insert order
        try {
            $order = $this->createOrder($req, $userData,$total,$fee,$shop);
            $order->save();
            $this->createDetailOrder($req, $userData, $order, $products);
            $this->paymentMethod($req, $userData, $order);
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $order
            ]);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
    }

    protected function getProductPro($data) {
      
        $query = ProductPromotion::where(['pro_id' => $data['pro_id']]);

        $query->whereRaw('CASE  WHEN limit_type = 1
                            THEN (
                              (
                                limit_from <= ' . $data['qty'] . '
                                OR limit_from = 0
                              )
                              AND (limit_to >= ' . $data['qty'] . '
                                OR limit_to = 0)
                            )
                            WHEN limit_type = 2
                            THEN (
                              (
                                limit_from <= ' . $data['total'] . '
                                OR limit_from = 0
                              )
                              AND (
                                limit_to >= ' . $data['total'] . '
                                OR limit_to = 0
                              )
                            )
                          END')->orderBy('limit_from', 'desc');
        return $query->first();
    }

    protected function createOrder($req, $user, $total,$fee = [],$shop =[]) {
   
        $orderInfo = [
            'date' => time(),
         
            'shipping_method' => $req->shipping_method,
            'order_saler' => $shop->sho_user,
            'order_total_no_shipping_fee' => $total - $fee['ServiceFee'],
            'order_code' => time() . '_' . rand(100, 9999),
            'order_token' => md5(time() . rand()),
            'token' => "",
            'payment_other_info' => "",
            'other_info'=>"",

        ];
  
        $order = new Order($orderInfo);
        $order->payment_method = $req->payment_method;
        $order->order_saler = $shop->sho_user;
        $order->shipping_fee = $fee['ServiceFee'];
        $order->order_serviceID = $fee['ServiceID'];
        $order->order_user = $user->use_id;
        $order->order_total_no_shipping_fee = $total - $fee['ServiceFee'];
        $order->change_status_date = time();
        $order->af_id = 0;
        $order->order_total = $total;
        $order->payment_status = 0;
        $order->save();
        return $order;
    }

    protected function createDetailOrder($req, $user, $order, $cart) {
        $shc_buyer_group = 1;
        $shc_buyer_parent = 0;
        $shc_buyer = 0;
        if ($user->parent_id > 0) {
            $shc_buyer_parent = $user->parent_id;
            $shc_buyer_group = $user->use_group;
            $shc_buyer = $user->use_id;
        }
        foreach ($cart as $index => $pro) {
            if (!empty($pro)) {
                $shc_saler_parent = 0;
                $shc_saler_parent_group = 0;
                $shc_saler_parent = 0;
                $shc_saler_parent_group = 0;
                $shc_buyer_parent = 0;
                $shc_buyer_group = 1;
                if ($pro['pro_user'] > 0) {
                    $salerParent = User::where(['use_id' => $pro['pro_user']])->first();
                    $shc_saler_parent = $salerParent->parent_id;
                    $shc_saler_parent_group = $salerParent->use_group;
                }
                $shc_buyer = 0;
                if (!empty($user)) {
                    $shc_buyer_parent = $user->parent_id;
                    $shc_buyer_group = $user->use_group;
                    $shc_buyer = $user->use_id;
                }

                $af_id_parent = 0;
                if(empty($pro['af_id'])){
                    $pro['af_id'] = 0;
                }
                
                if ($pro['af_id'] > 0) {
                    $afParent = User::where(['use_id' => $pro['af_id']])->first();
                    if(!empty($afParent)){
                         $af_id_parent = $afParent->parent_id;
                    }
                   
                }



                if ($pro['shipping_fee'] <= 0) {
                    $pro['shipping_fee'] = 0;
                }


                $orderDetailData = array(
                    'shc_product' => (int)$pro['pro_id'],
                    'shc_quantity' => $pro['qty'],
                    'pro_category' => $pro['pro_category'],
                    'shc_saler' => $pro['pro_user'],
                    'shc_buyer' => $shc_buyer,
                    'shc_saler_parent' => $shc_saler_parent,
                    'shc_buyer_parent' => $shc_buyer_parent,
                    'shc_buyer_group' => $shc_buyer_group,
                    'shc_buydate' => time(),
                    'shc_process' => 0,
                    'shc_orderid' => $order->id,
                    'shc_status' => '01',
                    'shc_change_status_date' => time(),
                    'shc_saler_store_type' => $pro['order_type'],
                    'em_discount' => $pro['em_promo'],
                    'shc_total' => $pro['pro_price'] * $pro['qty'] - $pro['em_promo'],
                    'af_amt' => $pro['af_amt'],
                    'af_rate' => $pro['af_rate'],
                    'dc_amt' => $pro['dc_amt'],
                    'dc_rate' => $pro['dc_rate'],
                    'affiliate_discount_amt' => $pro['affiliate_discount_amt'],
                    'affiliate_discount_rate' => $pro['affiliate_discount_rate'],
                    'pro_price' => $pro['pro_price'],
                    'pro_price_original' => $pro['pro_price_original'],
                    'pro_price_rate' => $pro['pro_price_rate'],
                    'pro_price_amt' => $pro['pro_price_amt'],
                    'af_id' => $pro['af_id'] ? $pro['af_id'] : 0,
                    'af_id_parent' => $af_id_parent
                );
                $orderDetail = new OrderDetail($orderDetailData);
                if ($orderDetail->save()) {
                    Product::where(['pro_id' => $pro['pro_id']])->increment('pro_buy');
                }
                unset($orderDetail);
            }
            unset($cart[$index]);
        }
    }

    protected function paymentMethod($req,$user,$order) {
        $nganluong = array("payment_method_nganluong" => "", "bankcode" => "");
        if ($req->payment_method == Order::PAYMENT_METHOD_NGANLUONG) {
            $nganluong["payment_method_nganluong"] = $req->payment_method_online_via;
            $nganluong["bankcode"] = $req->bankcode;
        }

        $data_user_receive = array(
            'ord_sname' => $req->use_fullname,
            'ord_saddress' =>$req->use_address,
            'ord_province' =>$req->use_province,
            'ord_district' =>$req->use_district,
            'ord_semail' =>$req->use_email,
            'ord_smobile' =>$req->use_mobile,
            'ord_note' =>$req->use_note
        );
        
        $userReceive = new UserReceive($data_user_receive);
        $userReceive->order_id = $order->id;
        $userReceive->use_id = $user->use_id;
        $userReceive->save();
        return $userReceive;
       // $return = array('error' => false, 'order_id' => $order_id, 'payment_method' =>$req->payment_method'), 'order_token' => $oderInfo['order_token'], 'cart' => $cart);
    }

    protected function createUser($req,$product) {
        $salt = User::randomSalt();
        $userName = $req->use_email;

        $user  = User::where(['use_email' => $userName])->first();

        $password = Commons::generateRandomString();
        $data_user = array(
            'use_username' => $userName,
            'use_salt' => $salt,
            'use_password' => User::hashPassword($password, $salt),
            'use_fullname' => $req->use_fullname,
            'use_address' => $req->use_address,
            'use_province' => $req->use_province,
            'user_district' => $req->use_district,
            'use_email' => $req->use_email,
            'use_status' => 1,
            'use_group' => 1,
            'parent_id' => $product->pro_user,
            'use_regisdate' => time(),
            'use_mobile' => $req->use_mobile,
            'use_phone' => '',
            'use_key' => Hash::create($userName, $userName, 'sha256md5'),
            'use_lastest_login' => time()
        );
        if (empty($user) && empty($req->user())) {
            $user = new User($data_user);
            $user->save();
        }
        if(!empty($req->user())){
            return $req->user();
        }

        return $user;
    }

    protected function userEmailExitst($email){
       $has =  User::where(['use_email' => $email])->count();
       if($has > 0){
           return true;
       }
       return false;
    }
    
    protected function  fee($req,$shop,$totalWeight) {
        $shipfee = ShipService::getFee($req->company, $shop->district, $req->use_district, $totalWeight);
        return $shipfee;
//        if (!isset($shipfee) && !isset($shipfee['ServiceFee'])) {
//            return response([
//                'msg' => Lang::get('response.ship_services_not_found')
//            ], 400);
//        }
//
//        return response([
//            'msg' => Lang::get('response.success'),
//            'data' => [
//                'feeAmount' => $shipfee['ServiceFee'],
//                'feeTime' => $shipfee['ServiceName']
//            ]
//        ]);
    }


    /**
     * @SWG\Get(
     *     path="/api/v1/me/userOrders",
     *     operationId="order",
     *     description="Lấy danh sách đơn hàng mua sĩ",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Đơn hàng SP Gian hàng",
     *    @SWG\Parameter(
     *         name="order_id",
     *         in="query",
     *         description="id đơn hàng",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="use_fullname",
     *         in="query",
     *         description="Tên khách hàng",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="ord_smobile",
     *         in="query",
     *         description="số điện thoại order",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Ngày order",
     *         required=false,
     *         type="integer",
     *     ),
     *   @SWG\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Ngày order đến",
     *         required=false,
     *         type="integer",
     *     ),
     *   @SWG\Parameter(
     *         name="coupon_code",
     *         in="query",
     *         description="Mã coupon sử dụng",
     *         required=false,
     *         type="string",
     *     ),
     *   @SWG\Parameter(
     *         name="shipping_method",
     *         in="query",
     *         description="Phương thức giao hàng (SHO,GHN,VTP)",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="order_status",
     *         in="query",
     *         description="Trạng thái đơn hàng 01-Mới 02-Đang vận chuyển 03- Đã giao hàng 04-Giao thành công 05-Đang khiếu nại 06- Đã nhận lại hàng 98-Hoàn thành 99-Hủy",
     *         required=false,
     *         type="string",   
     *     ),
     *    @SWG\Parameter(
     *         name="pro_type",
     *         in="query",
     *         description="Don hang co khuyen mai hay khong , gia tri 2 la co su dung coupon",
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
    public function userOrder(Request $req) {
        $orderdb = Order::tableName();
        $userdb = User::tableName();
        $userRecivedb = UserReceive::tableName();
        $showCartdb = 'tbtt_showcart';
        $productdb = 'tbtt_product';
        //TO DO Showing order 
        $condition = ['order_user' => $req->user()->use_id];
        if($req->otherUser){
            $condition['order_user'] = $req->otherUser;
        }
        $query = Order::where($condition)->with(['userReceive','orderDetail.product']);
        if ($req->order_id) {
            $query->where($orderdb.'.id', $req->order_id);
        }
        if (!empty($req->orderBy)) {
            $req->orderBy = explode(',', $req->orderBy);
            $key = $req->orderBy[0];
            $value = $req->orderBy[1] ? $req->orderBy[1] : 'DESC';
            $query->orderBy($orderdb . '.' . $key, $value);
        } else {
            $query->orderBy('id', 'DESC');
        }

        // Conditions
        if ($req->order_id) {
            $query->where($orderdb . '.id', $req->order_id);
        }
        
        // BY use fullname
        if(!empty($req->use_fullname)){
           $query->whereRaw('LOWER('.$userdb.'.use_fullname) like ?', array('%' . mb_strtolower($req->use_fullname) . '%'));
        }

        if(!empty($req->order_mobile)){
           $query->whereRaw('LOWER('.$userRecivedb.'.ord_smobile) like ?', array('%' . mb_strtolower($req->order_mobile) . '%'));
        }
        if(!empty($req->startDate)){
            $query->where($orderdb.'.date','>=',$req->startDate);
        }
        if(!empty($req->endDate)){
             $query->where($orderdb.'.date','<=',$req->endDate);
        }
        
        if (!empty($req->pro_type) && $req->pro_type <= Order::ORDER_TYPE_PROMOTION) {
            $query->where($productdb . '.pro_type', $req->pro_type);
        }else{
            $query->where($productdb . '.pro_type', 0);
        }
        if(!empty($req->coupon_code)){
            $query->where($orderdb.'.order_coupon_code', $req->coupon_code);
        }
        if (!empty($req->shipping_method)) {
            $query->where($orderdb.'.shipping_method', $req->shipping_method);
        }

        if (!empty($req->order_status)) {
            $query->where($orderdb.'.order_status', $req->order_status);
        }

        $slc = $orderdb . '.*';
        $query->select(DB::raw($slc));
        $query->join($userRecivedb, $userRecivedb . '.order_id', $orderdb . '.id');
        $query->groupBy($orderdb.'.id');
        $query->join($showCartdb, $showCartdb . '.shc_orderid', $orderdb . '.id');
        $query->join($productdb, $productdb . '.pro_id', $showCartdb . '.shc_product');
        $query->leftJoin($userdb, $userdb . '.use_id', $orderdb . '.order_user');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0; 
        

        $results = $query->paginate($limit, ['*'], 'page', $page);
        foreach ($results as $result) {
            $result->orderDetail->product->generateLinks(null,$req->user());
         
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/orders/{id}",
     *     operationId="order",
     *     description="Chi tiết đơn hàng -người khác order shop",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Chi tiết đơn hàng",
     *    @SWG\Parameter(
     *         name="affiliateOrder",
     *         in="query",
     *         description="Nếu xem chi tiết đơn hàng afflialate thi =1",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Chi tiết đơn hàng"
     *     )
     * )
     */
    public function detail($id, Request $req) {
        $user = $req->user();
        $orderdb = (new Order)->getTable();
        $statusdb = (new Status)->getTable();
        $prodductdb = (new Product)->getTable();
        $userReceviedb = (new UserReceive)->getTable();
        $orderDetaildb = (new OrderDetail)->getTable();
        
//        $condition = [
//            $orderDetaildb . '.shc_saler' => $user->use_id, $orderdb . '.id' => $id
//        ];
        $tree[] = $user->use_id;
        $this->getTreeInList($user->use_id, $tree);
        $query = Order::where([]);
//        if($req->test){
//            unset($condition[$orderDetaildb . '.shc_saler']);
//        }
//        if ($req->affiliateOrder) {
//            unset($condition[$orderDetaildb . '.shc_saler']);
//            $condition[$orderDetaildb . '.af_id'] = $req->user()->use_id;
//        }

        $userdb = User::tableName();
        
        if (in_array($user->use_group, [User::TYPE_AffiliateStoreUser, User::TYPE_StaffStoreUser])) {
            $tree = [];
            $GH = $user->use_id;
            if ($user->use_group == User::TYPE_StaffStoreUser) {
                $tree[] = $GH = $user->parent_id;
            }
            
            $sub_tructiep = User::where(function($q)use($userdb, $user) {
                    $q->orWhere(function($q)use($userdb, $user) {
                        $q->where(['use_group' => User::TYPE_BranchUser, 'use_status' => User::STATUS_ACTIVE]);
                        $q->whereIn('parent_id', function($q) use($userdb, $user) {
                            $q->select('use_id');
                            $q->from($userdb);
                            $q->where('use_group', User::TYPE_StaffStoreUser);
                            $q->where('parent_id', $user->use_id);
                        });
                    });
                    $q->orWhere(function($q)use($userdb, $user) {
                        $q->where(['use_group' => User::TYPE_BranchUser, 'use_status' => User::STATUS_ACTIVE]);
                        $q->where('parent_id', $user->use_id);
                    });
                })->get()->pluck('use_id')->toArray();

            $ids = array_merge($tree, $sub_tructiep);
            
            if (!empty($ids)) {
                $query->where(function($q) use($GH, $ids) {
                    $q->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
                    $q->orWhere(function($q) use ($ids) {
                        $q->whereIn('tbtt_showcart.shc_saler', $ids);
                        $q->where('pro_of_shop', '>', 0);
                    });
                });
            } else {
                $query->where(['tbtt_showcart.shc_saler' => $GH, 'pro_of_shop' => 0]);
            }
        } else if ($user->use_group == User::TYPE_BranchUser) {
            $query->where(['tbtt_showcart.shc_saler' => $user->use_id]);
        }


        $query->with(['orderDetails', 'orderDetails.product', 'orderDetails.affUser', 'userReceive', 'status', 'orderDetails.buyer']);
        $query->select($orderdb . '.*');
        $query->join($orderDetaildb, $orderDetaildb . '.shc_orderid', $orderdb . '.id');
        $query->join($prodductdb, $orderDetaildb . '.shc_product', $prodductdb . '.pro_id');
        $query->join($statusdb, $statusdb . '.status_id', $orderdb . '.order_status');
        $query->join($userReceviedb, $userReceviedb . '.order_id', $orderdb . '.id');
        $query->where($orderdb .'.id', $id);
      
       
        $order = $query->first();
        
        if (!empty($order->userReceive)) {
            $order['user_receive'] = $order->userReceive->publicProfile();
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $order
        ]);
    }

    function getTreeInList($user, &$allChild) {

        $listChild = array();
        $this->getListChildTree($user, $listChild);
        foreach ($listChild as $child) {
            if ($child > 0) {
                $allChild[] = $child;
                $this->getTreeInList($child, $allChild);
            }
        }
    }
     function getListChildTree($user, &$list_child = array()) {
        if (empty($user->getChild)) {
            return 0;
        }
        $child = $user->getChild->child;
        $list_child[] = $child;
        $this->getNextList($child, $list_child);
    }
    
    function getNextList($child, &$list_next = array()) {
        $userObject = UserTree::where(['user_id' => $child])->first();
        if ($userObject->next > 0) {
            $list_next[] = $userObject->next;
        }
        if ($userObject->next > 0) {
            $this->getNextList($userObject->next, $list_next);
        } else {
            return $list_next;
        }
    }
     /**
     * @SWG\Get(
     *     path="/api/v1/me/userOrders/{id}",
     *     operationId="order",
     *     description="Chi tiết đơn hàng mua sĩ",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Chi tiết đơn hàng mua sĩ ( Người mua là mình )",
     *    @SWG\Parameter(
     *         name="otherUser",
     *         in="query",
     *         description="otherUser",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Chi tiết đơn hàng mua sĩ"
     *     )
     * )
     */
    public function userOderDetail($id, Request $req) {
        $user = $req->user();
        if($req->otherUser){
            $user = User::find($req->otherUser);
        }
        $orderdb = (new Order)->getTable();
        $statusdb = (new Status)->getTable();
        $prodductdb = (new Product)->getTable();
        $userReceviedb = (new UserReceive)->getTable();
        $orderDetaildb = (new OrderDetail)->getTable();
        $query = Order::where([$orderdb . '.order_user' => $user->use_id ,$orderdb . '.id' => $id])
            ->with(['orderDetails.product', 'shop', 'userReceive', 'status']);
        $query->select($orderdb . '.*');
        $query->join($orderDetaildb, $orderDetaildb . '.shc_orderid', $orderdb . '.id');
        $query->join($prodductdb, $orderDetaildb . '.shc_product', $prodductdb . '.pro_id');
        $query->join($statusdb, $statusdb . '.status_id', $orderdb . '.order_status');
        $query->join($userReceviedb, $userReceviedb . '.order_id', $orderdb . '.id');
        $order = $query->first();

        if (!empty($order->userReceive)) {
            $order['user_receive'] = $order->userReceive->publicProfile();
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $order
        ]);
    }
    
    
    /**
     * @SWG\Get(
     *     path="/api/v1/me/orders", 
     *     operationId="order",
     *     description="Đơn hàng SP Gian hàng - người khác order shop",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Đơn hàng SP Gian hàng - người khác order shop",
     *     @SWG\Response(
     *         response=200,
     *         description="Chi tiết đơn hàng"
     *     ),
     *     @SWG\Parameter(
     *         name="use_fullname",
     *         in="query",
     *         description="Tên khách hàng",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="ord_smobile",
     *         in="query",
     *         description="số điện thoại order",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Ngày order",
     *         required=false,
     *         type="integer",
     *     ),
     *   @SWG\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Ngày order đến",
     *         required=false,
     *         type="integer",
     *     ),
     *   @SWG\Parameter(
     *         name="coupon_code",
     *         in="query",
     *         description="Mã coupon sử dụng",
     *         required=false,
     *         type="string",
     *     ),
     *   @SWG\Parameter(
     *         name="shipping_method",
     *         in="query",
     *         description="Phương thức giao hàng (SHO,GHN,VTP)",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="order_status",
     *         in="query",
     *         description="Trạng thái đơn hàng 01-Mới 02-Đang vận chuyển 03- Đã giao hàng 04-Giao thành công 05-Đang khiếu nại 06- Đã nhận lại hàng 98-Hoàn thành 99-Hủy",
     *         required=false,
     *         type="string",   
     *     ),
     *    @SWG\Parameter(
     *         name="pro_type",
     *         in="query",
     *         description="Don hang co khuyen mai hay khong , gia tri 2 la co su dung coupon",
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
     * )
     */
    public function order(Request $req) {
        $condition = [];
        $query = Order::where($condition)->with(['user', 'status','orderDetail.product','shop']);
        $orderdb = (new Order)->getTable();
        $userRecivedb = (new UserReceive)->getTable();
        $showCartdb = 'tbtt_showcart';
        $productdb = 'tbtt_product';
        $userdb = (new User)->getTable();
        if (!empty($req->order_id)) {
            $query->where($orderdb . '.id', $req->order_id);
        }
        if(!empty($req->use_fullname)){
           $query->whereRaw('LOWER('.$userdb.'.use_fullname) like ?', array('%' . mb_strtolower($req->use_fullname) . '%'));
        }
        if(!empty($req->order_mobile)){
           $query->whereRaw('LOWER('.$userRecivedb.'.ord_smobile) like ?', array('%' . mb_strtolower($req->order_mobile) . '%'));
        }
        if(!empty($req->startDate)){
            $query->where($orderdb.'.date','>=',$req->startDate);
        }
        if(!empty($req->endDate)){
             $query->where($orderdb.'.date','<=',$req->endDate);
        }
        
        if (!empty($req->pro_type) && $req->pro_type <= Order::ORDER_TYPE_PROMOTION) {
            $query->where($productdb . '.pro_type', $req->pro_type);
        }else{
            $query->where($productdb . '.pro_type', 0);
        }
        if(!empty($req->coupon_code)){
            $query->where($orderdb.'.order_coupon_code', $req->coupon_code);
        }
        if (!empty($req->shipping_method)) {
            $query->where($orderdb.'.shipping_method', $req->shipping_method);
        }

		if (!empty($req->order_status)) {
			$query->where($orderdb.'.order_status', $req->order_status);
		}
        $query->select([$orderdb.'.*']);
        $query->join($userRecivedb, $userRecivedb . '.order_id', $orderdb . '.id');
        $query->join($showCartdb, $showCartdb . '.shc_orderid', $orderdb . '.id');
        $query->join($productdb, $productdb . '.pro_id', $showCartdb . '.shc_product');
        $query->leftJoin($userdb, $userdb . '.use_id', $orderdb . '.order_user');
      
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $query->where($showCartdb . '.shc_saler', $req->user()->use_id);
        $query->orderBy($orderdb.'.id','DESC');
        $results = $query->paginate($limit, ['*'], 'page', $page);
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
        
    }
    


  
    /**
     * @SWG\Get(
     *     path="/api/v1/me/count-orders-new",
     *     operationId="products",
     *     description="Số lượng đơn hàng mới ( Mặc định ngày hôm nay)",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Thống kê chung - Số lượng đơn hàng mới",
     *      @SWG\Parameter(
     *         name="sum",
     *         in="query",
     *         description="sum=1 Để lấy tổng số lượng đơn hàng",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="totalOrder:1"
     *     )
     * )
     */
    
    public function countOrderNew(Request $req) {

        $userdb = User::tableName();
        $currentDate_first = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $currentDate_after = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        $user = $req->user();
        $userId = $req->user()->use_id;
        $tree = [$userId];
        $queryUser = User::where(['use_status' => User::STATUS_ACTIVE]);
        $queryUser->where(function($q) use($userdb,$user){
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
                $or_saler = array_merge($ids, $getafALL);
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
                        $q->where('use_group', '<>', User::TYPE_AffiliateStoreUser);
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

                $query->where('tbtt_showcart.shc_saler', $user->use_id);
            }
        }
 

        $query->whereIn('order_status', [Order::STATUS_PENDING, Order::STATUS_ON_TRANS, Order::STATUS_RECIVICE,Order::STATUS_SUCCESS]);
        if (!$req->sum) {
            $query->where('change_status_date', '>=', $currentDate_first);
            $query->where('change_status_date', '<=', $currentDate_after);
        }

        $query->join('tbtt_showcart', 'tbtt_showcart.shc_orderid', 'tbtt_order.id');
       
        $query->leftJoin('tbtt_product', 'tbtt_product.pro_id', 'tbtt_showcart.shc_product');
        $query->leftJoin('tbtt_user', 'tbtt_user.use_id', 'tbtt_product.pro_user');
        $query->groupBy('id');
        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'totalOrder' => $query->count()
            ]
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/orders-status",
     *     operationId="products",
     *     description="Lấy các define status của đơn hàng",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Lấy các define status của đơn hàng",
     *     @SWG\Response(
     *         response=200,
     *         description="trả về ob"
     *     )
     * )
     */
   public function getStatus(Request $req) {
        $list = [
            '01' => 'Mới',
            '02' => 'Đang vận chuyển',
            '03' => 'Đã giao hàng',
            '04' => 'Giao không thành công',
            '05' => 'Đang khiếu nại',
            '06' => 'Đã nhận lại hàng - trả hàng',
            '99' => 'Đã hoàn thành',
            '98' => 'Hủy'
        ];
        $data = [];
        foreach ($list as $key => $item) {
            $data[] = [
                'key' => (string)$key,
                'value' => $item
            ];
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $data
        ]);
    }
    
     /**
     * @SWG\Get(
     *     path="/api/v1/payment-status",
     *     operationId="products",
     *     description="Lấy các define status thanh ",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Lấy các define status của đơn hàng",
     *     @SWG\Response(
     *         response=200,
     *         description="trả về ob"
     *     )
     * )
     */
    
     public function getPaymentStatus(Request $req) {
        $list = [
            '0' => 'Đang có',
            '1' => 'Yêu cầu chuyển khoản',
            '2' => 'Đã chuyển tiền',
            '3' => 'Khiếu nại',
            '6' => 'Xử lí khiếu nại',
            '4' => 'Người dùng hoàn tất',
            '5' => 'Hệ thống hoàn tất',
            '8' => 'Hoàn tất chuyển khoản',
            '9' => 'Hủy bỏ',
        ];
        $data = [];
        foreach ($list as $key => $item) {
            $data[] = [
                'key' => (string) $key,
                'value' => $item
            ];
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $data
        ]);
    }

    
     /**
     * @SWG\Put(
     *     path="/api/v1/me/orders/{id}/accept",
     *     operationId="orders",
     *     description="Shop - Accept đơn hàng",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Shop - Accept đơn hàng",
     *     @SWG\Response(
     *         response=200,
     *         description="trả về ob"
     *     )
     * )
     */
    
    public function shopAcceptOrder($id,Request $req) {
        
        $delivery = true;
        $order_saler = $req->user()->use_id;
//        if ($delivery == FALSE) {
//            $order_status = "05";
//            //05 - Đang khiếu nại
//        } else {
//            $order_status = "01";
//            // 01 - Đơn hàng mới
//        }
        $orderdb = (new Order)->getTable();
       
        $prodductdb = (new Product)->getTable();
        $userReceviedb = (new UserReceive)->getTable();
        $orderDetaildb = (new OrderDetail)->getTable();
        $query = Order::where([$orderDetaildb . '.shc_saler' => $req->user()->use_id, $orderdb . '.id' => $id])
            ->with(['orderDetails', 'orderDetails.product', 'orderDetails.affUser',
            'shopFullInfor',
            'userReceive', 'status', 'orderDetails.buyer']);
        $query->select($orderdb . '.*');
        $query->join($orderDetaildb, $orderDetaildb . '.shc_orderid', $orderdb . '.id');
        $query->join($prodductdb, $orderDetaildb . '.shc_product', $prodductdb . '.pro_id');
        // $query->join($statusdb, $statusdb . '.status_id', $orderdb . '.order_status');
//        $query->join($userReceviedb, $userReceviedb . '.order_id', $orderdb . '.id');
        $order = $query->first();


        if (empty($order)) {
            return response([
                'msg' => 'response.order_not_found'
            ], 404);
        }

        if ($order->shipping_method !== 'SHO') {
            return response([
                'msg' => 'Chưa hổ trợ dịch vụ này.'
            ], 400);
        }
      
        $weight = 0;
        $quantity = 0;
        $shop = $order->shopFullInfor;
        $userRecevie = $order->userReceive;
        foreach ($order->orderDetails as $orderDetails) {
            $product = $orderDetails->product;
            $weight += $product->pro_weight * $orderDetails->shc_quantity;
            $quantity += $orderDetails->shc_quantity;
            $products[] = array('id' => $product->pro_id, 'shc_quantity' => $orderDetails->shc_quantity, 'pro_instock' => $product->pro_instock, 'pro_buy' => $product->pro_buy);
        }

        //$data['ClientOrderCode'] = $order->order_code;
      
        if ($delivery) {
            $data['ClientOrderCode'] = $order->order_code;
        } else {
            $data['ClientOrderCode'] = time() . '_' . rand(100, 9999);
        }

        $data['SenderName'] = $shop->sho_name;
        $data['SenderPhone'] = $shop->sho_mobile;
        $data['PickAddress'] = ($shop->sho_kho_address) ? $shop->sho_kho_address : $shop->sho_address;
        $data['PickDistrictCode'] = ($shop->sho_kho_district) ? $shop->sho_kho_district :$shop->sho_district;

        $data['RecipientName'] = $userRecevie->ord_sname;
        $data['RecipientPhone'] = $userRecevie->ord_smobile;
        $data['DeliveryAddress'] = $userRecevie->ord_saddress;
        $data['DeliveryDistrictCode'] = $userRecevie->ord_district;

        if ($delivery) {
            if ($order->payment_method == "info_cod") {
                $data['CODAmount'] = (double) ($order->order_total);
                $data['cod_type'] = '3';
            } else {
                $data['CODAmount'] = '0';
                $data['cod_type'] = '1';
            }
        } else {
            $data['CODAmount'] = 0;
        }

        $data['ContentNote'] = $userRecevie->ord_note;
        $data['ServiceID'] = $order->order_serviceID;
        $data['Weight'] = $weight;
        $data['Length'] = 0;
        $data['Width'] = 0;
        $data['Height'] = 0;
//        echo "<pre>";
//print_r($order_cart);exit;die;

        try {
            if ($order->shipping_method == 'VTP') {
                $return = $this->sendToViet($order, $data, $weight,$quantity);
            } elseif ($order->shipping_method == 'GHN') {
                $return = $this->CreateShippingOrder($data);
            } elseif ($order->shipping_method == 'SHO') {
                $return['code'] = 1;
                $return['msg']['OrderCode'] = "AZB" . $id;
                $return['msg']['TotalFee'] = $order->shipping_fee;
            }

            if (isset($return['code']) && $return['code'] == 1) {
//                    if($order_cart[0]->shipping_fee != $return['msg']['TotalFee']){
//                        $logaction = "Phí vận chuyển trả về từ GIAO HÀNG NHANH ko khớp";
//                    } else {
                $logaction = "Xác nhận đơn hàng thành công";
                Order::where(['id' => $id])->update([
                    'order_clientCode' => $return['msg']['OrderCode'],
                    'order_status' => Order::STATUS_ON_TRANS,
                    'change_status_date' => time(),
                ]);
                OrderDetail::where(['shc_orderid' => $id])->update([
                    'shc_status' => Order::STATUS_ON_TRANS,
                    'shc_change_status_date' => time()
                ]);

                if ($delivery) {
                    foreach ($products as $values) {
                        if ($values['pro_buy'] > 0 || $values['pro_instock'] > 0) {
                            $this->updateStock($values);
                        }
                    }
                }

                if ($userRecevie->ord_semail) {
                    //$this->load->model("shop_mail_model");
                    // $this->shop_mail_model->sendingConfirmOrderEmailForCustomer($order_cart[0], $order_cart[0], $order_cart);
                }

//                    }
            } else {
                $logaction = "Xác nhận đơn hàng thất bại " . $return['msg'];
            }
            $logs = new GiaoHangNhanhLog([
                'OrderCode' => $return['msg']['OrderCode'],
                'TotalFee' => $return['msg']['TotalFee'],
                'owner' => $order_saler,
                'logaction' => $logaction,
                'lastupdated' => date('Y-m-d H:i:s', time())
            ]);
            $logs->save();


            if ($delivery) {
                return response([
                    'msg' => Lang::get('response.success'),
                ]);
            } else {
                return response([
                    'msg' => Lang::get('response.success'),
                    'data' => $return['msg']['OrderCode']
                ]);
            }
        } catch (Exception $e) {
            return response([
                'msg' => \Lang::get('response.server_error')
                ], 500);
        }
    }

    protected function updateStock($pro) {
        if ($pro['pro_buy'] > 0) {
            Product::where(['pro_id' => $pro['id']])->increment('pro_buy', $pro['shc_quantity']);
        }
        if ($pro['pro_instock'] > 0) {
            Product::where(['pro_id' => $pro['id']])->decrement('pro_instock', $pro['shc_quantity']);
        }
    }
    
    protected function sendToViet($order, $data, $weight, $quantity) {
        $shop = $order->shopFullInfor;
        $product = $order->orderDetails[0]->product;
        $userRecvice = $order->userReceive;
        $tinhthanh = District::where(["DistrictCode" => $shop->sho_kho_district])->first();
        $link_web = base_url() . $product->pro_category . "/" . $product->pro_id . "/" . Commons::removeSign($product->pro_name);
        $order_data = array(
            "ORDER_ID" => $order->id,
            "MA_DOITAC" => "AZB",
            "MA_SHOP" => $shop->shc_id,
            "TEN_KHGUI" => $shop->sho_name,
            "DIACHI_KHGUI" => $data['PickAddress'],
            "EMAIL_KHGUI" => $product->pro_email,
            "TEL_KHGUI" => $shop->sho_mobile,
            "TINH_KHGUI" => $tinhthanh->vtp_province_code,
            "HUYEN_KHGUI" => $tinhthanh->vtp_code,
            "PHUONGKHGUI" => 0,
            "LATITUDE" => 0,
            "LONGITUDE" => 0,
            "TEN_KHNHAN" => $userRecvice->ord_sname,
            "DIACHI_KHNHAN" => $userRecvice->ord_saddress,
            "EMAIL_KHNHAN" => $userRecvice->ord_semail,
            "TEL_KHNHAN" => $userRecvice->ord_smobile,
            "TINH_KHNHAN" => strtoupper($userRecvice->ord_province),
            "HUYEN_KHNHAN" => $userRecvice->ord_district,
            "PHUONGKHNHAN" => 0,
            "MOTA_SP" => $product->pro_descr,
            "TIEN_HANG" => $data['CODAmount'],
            "LINK_WEB" => $link_web,
            "LOAI_VANDON" => $data['cod_type'],
            "GHI_CHU" => $userRecvice->ord_note,
            "MA_DV_VIETTEL" => $order->order_serviceID,
            "TRONG_LUONG" => $weight,
            "MA_LOAI_HANGHOA" => "HH",
            "TONG_CUOC_VND" => 0,
            "PHI_COD" => 0,
            "PHI_VAS" => 0,
            "BAO_HIEM" => 0,
            "PHU_PHI" => 0,
            "PHU_PHI_KHAC" => 0,
            "TONG_VAT" => 0,
            "TONG_TIEN" => 0,
            "TIEN_THU_HO" => $data['CODAmount'],
            "SO_LUONG" => $quantity,
            "NGAY_LAY_HANG" => date('d/m/Y h:i:s')
        );
        $viettelAPi = new ViettelAPi();
        $token = $viettelAPi->Login();
        $orderShip = $viettelAPi->callMethod("InsertOrder", json_encode($order_data, true), $token, 'POST');
        $viettelAPi->callMethod('Logoff', null, $token, 'POST');
        $return = [
            'code' => -1,
            'OrderCode' => "AZB" . $order->id,
            'TotalFee' => $order->shipping_fee
        ];
        if ($orderShip == 'SUCCESS') {
            $return['code'] = 1;
        }
        return $return;
    }
    
    private function CreateShippingOrder($order) {

        $this->RestApiClient = new RestApiClient();

        $serviceClient = $this->RestApiClient->connectGHN();
        $sessionToken = $serviceClient->SignIn();
        $serviceClient->SignOut();
        $arrProduct = array();
        //https://testapipds.ghn.vn:9999/UI/API/GetAccountFortest
        if ($sessionToken) {
            $responseCreateShippingOrder = $serviceClient->CreateShippingOrder($order);
            //print_r($responseCreateShippingOrder);exit;
            if ($responseCreateShippingOrder['ErrorMessage'] == '') {
                return array(
                    'code' => '1',
                    'msg' => $responseCreateShippingOrder
                );
            } else {
                return array(
                    'code' => '-1',
                    'msg' => $responseCreateShippingOrder['ErrorMessage']
                );
            }
        } else {
            return array(
                'code' => '-1',
                'msg' => 'Client and Password are incorrect - Liên hệ Admin'
            );
        }
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/me/orders/{id}/cancel",
     *     operationId="orders",
     *     description="Shop - hủy đơn hàng",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Shop - Hủy đơn hàng",
     *  @SWG\Parameter(
     *         name="reason",
     *         in="body",
     *         description="Lý do hủy",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="order_token",
     *         in="body",
     *         description="order_token khi đặt thành công",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="trả về ob"
     *     )
     * )
     */
    public function cancel($order_id, Request $req) {
        $validator = Validator::make($req->all(), [
            'reason' => 'required|string',
            'order_token' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $order_cart = Order::where(['id'=> $order_id, 'order_token' => $req->order_token, 'order_saler' => $req->user()->use_id])->first();

        if (!$order_cart) {
            return response([
                'msg' => Lang::get('response.order_not_found')
            ], 404);
        }

        if (in_array($order_cart->order_status, [Order::STATUS_CANCEL, Order::STATUS_RECIVICE, Order::STATUS_SUCCESS])) {
            return response([
                'msg' => Lang::get('response.order_not_allow_cancel')
            ], 403);
        }

        //TODO: check status
        $order_cart->order_status = Order::STATUS_CANCEL;
        $order_cart->cancel_reason = $req->reason;
        $order_cart->cancel_date = time();
        try {

            if ($order_cart->order_clientCode) {
                $return = ShipService::cancelOrder($order_cart);
                if (!$return) {
                    return response([
                        'msg' => Lang::get('response.order_cancel_failed')
                    ], 400);
                }
            }
            
            $order_cart->save();
            return response([
                'msg' => Lang::get('response.order_cancel_success')
            ]);
        } catch (Exception $e) {
            return response([
                'msg' => \Lang::get('response.server_error')
            ], 500);
        }

    }
    /**
     * @SWG\Get(
     *     path="/api/v1/me/customer-order",
     *     operationId="orders",
     *     description="Khách hàng từ Gian hàng",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Khách hàng từ Gian hàng",
     *  @SWG\Parameter(
     *         name="limit",
     *         in="body",
     *         description="limit",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="body",
     *         description="page",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="trả về"
     *     )
     * )
     */
    public function listCustomerOrder(Request $req) {
        $saler = $req->user();
        $userdb = User::tableName();
        $from_view = '( SELECT tbtt_order.order_user, COUNT(tbtt_order.id) '
            . ' FROM tbtt_order '
            . ' INNER JOIN tbtt_showcart ON tbtt_showcart.shc_orderid = tbtt_order.id '
            . ' WHERE tbtt_showcart.shc_saler = ' . $saler->use_id
            . ' GROUP BY tbtt_order.id ) AS from_view';
        
        $query = User::select(DB::raw('count(from_view.order_user) as count_order'),'from_view.order_user', DB::raw($userdb.'.use_id, '
            . $userdb.'.use_username,'.$userdb.'.use_email,'.$userdb.'.use_address,'.$userdb.'.use_fullname,'.$userdb.'.use_mobile'));
        $query->from(DB::raw($from_view));
        $query->join($userdb, 'tbtt_user.use_id', 'from_view.order_user');
        $query->groupBy('order_user');
        $query->orderBy('order_user','DESC');
        if ($req->use_username) {
            $query->where($userdb . '.use_username', 'LIKE', '%' . $req->use_username . '%');
        }
        if ($req->use_fullname) {
            $query->where($userdb . '.use_fullname', 'LIKE', '%' . $req->use_fullname . '%');
        }

        if ($req->use_fullname) {
            $query->where($userdb . '.use_fullname', 'LIKE', '%' . $req->use_fullname . '%');
        }
        if ($req->use_mobile) {
            $query->where($userdb . '.use_mobile', 'LIKE', '%' . $req->use_mobile . '%');
        }
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $results = $query->paginate($limit, ['*'], 'page', $page);


        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
            ], 200);
    }
     /**
     * @SWG\Get(
     *     path="/api/v1/me/customer-order/{id}/list_orders",
     *     operationId="orders",
     *     description="chi tiết order khách hàng từ Gian hàng ",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="chi tiết order Khách hàng từ Gian hàng",
     *  @SWG\Parameter(
     *         name="limit",
     *         in="body",
     *         description="limit",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="body",
     *         description="page",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="trả về"
     *     )
     * )
     */
    public function customerOrderDetail($id, Request $req) {
        $producdb = Product::tableName();
        $orderdtdb = OrderDetail::tableName();
        $query = OrderDetail::join($producdb, $producdb . '.pro_id', $orderdtdb . '.shc_product');
        $query->groupBy($orderdtdb . '.shc_orderid');
        $query->where($orderdtdb . '.shc_saler', $req->user()->use_id);
        $query->where($orderdtdb . '.shc_buyer', $id);
        $query->select($orderdtdb . '.*');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $results = $query->paginate($limit, ['*'], 'page', $page);


        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
            ], 200);
    }
    
    /**
     * @SWG\Get(
     *     path="/api/v1/me/products/{id}/orders", 
     *     operationId="order",
     *     description="Đơn hàng của sản phẩm",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="Đơn hàng của sản phẩm",
     *     @SWG\Response(
     *         response=200,
     *         description="Chi tiết đơn hàng"
     *     ),
     *     @SWG\Parameter(
     *         name="use_fullname",
     *         in="query",
     *         description="Tên khách hàng",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="ord_smobile",
     *         in="query",
     *         description="số điện thoại order",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Ngày order",
     *         required=false,
     *         type="integer",
     *     ),
     *   @SWG\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Ngày order đến",
     *         required=false,
     *         type="integer",
     *     ),
     *   @SWG\Parameter(
     *         name="coupon_code",
     *         in="query",
     *         description="Mã coupon sử dụng",
     *         required=false,
     *         type="string",
     *     ),
     *   @SWG\Parameter(
     *         name="shipping_method",
     *         in="query",
     *         description="Phương thức giao hàng (SHO,GHN,VTP)",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="order_status",
     *         in="query",
     *         description="Trạng thái đơn hàng 01-Mới 02-Đang vận chuyển 03- Đã giao hàng 04-Giao thành công 05-Đang khiếu nại 06- Đã nhận lại hàng 98-Hoàn thành 99-Hủy",
     *         required=false,
     *         type="string",   
     *     ),
     *    @SWG\Parameter(
     *         name="pro_type",
     *         in="query",
     *         description="Don hang co khuyen mai hay khong , gia tri 2 la co su dung coupon",
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
     * )
     */
    public function orderProduct($id,Request $req) {
        $condition = [];
        $query = Order::where($condition)->with(['user', 'status', 'orderDetail.product', 'shop']);
        $orderdb = (new Order)->getTable();
        $userRecivedb = (new UserReceive)->getTable();
        $showCartdb = 'tbtt_showcart';
        $productdb = 'tbtt_product';
        $userdb = (new User)->getTable();
        if (!empty($req->order_id)) {
            $query->where($orderdb . '.id', $req->order_id);
        }
        if (!empty($req->use_fullname)) {
            $query->whereRaw('LOWER(' . $userdb . '.use_fullname) like ?', array('%' . mb_strtolower($req->use_fullname) . '%'));
        }
        if (!empty($req->order_mobile)) {
            $query->whereRaw('LOWER(' . $userRecivedb . '.ord_smobile) like ?', array('%' . mb_strtolower($req->order_mobile) . '%'));
        }
        if (!empty($req->startDate)) {
            $query->where($orderdb . '.date', '>=', $req->startDate);
        }
        if (!empty($req->endDate)) {
            $query->where($orderdb . '.date', '<=', $req->endDate);
        }

        if (!empty($req->pro_type) && $req->pro_type <= Order::ORDER_TYPE_PROMOTION) {
            $query->where($productdb . '.pro_type', $req->pro_type);
        }
        if (!empty($req->coupon_code)) {
            $query->where($orderdb . '.order_coupon_code', $req->coupon_code);
        }
        if (!empty($req->shipping_method)) {
            $query->where($orderdb . '.shipping_method', $req->shipping_method);
        }

        if (!empty($req->order_status)) {
            $query->where($orderdb . '.order_status', $req->order_status);
        }
        $query->select([$orderdb . '.*']);
        $query->join($userRecivedb, $userRecivedb . '.order_id', $orderdb . '.id');
        $query->join($showCartdb, $showCartdb . '.shc_orderid', $orderdb . '.id');
        $query->join($productdb, $productdb . '.pro_id', $showCartdb . '.shc_product');
        $query->leftJoin($userdb, $userdb . '.use_id', $orderdb . '.order_user');

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $query->where(function($q) use($showCartdb,$req){
            $q->orWhereIn($showCartdb.'.shc_saler',[$req->user()->use_id]);
            $q->orWhereIn($showCartdb.'.shc_saler_parent',[$req->user()->use_id]);
        });
  
        $query->where($productdb.'.pro_id',$id);
        $query->orderBy($orderdb . '.id', 'DESC');
        $results = $query->paginate($limit, ['*'], 'page', $page);
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }
    
    /**
     * @SWG\Get(
     *     path="/api/v1/user/listbran_order", 
     *     operationId="order",
     *     description="ĐƠN HÀNG CỦA CHI NHÁNH",
     *     produces={"application/json"},
     *     tags={"Order"},
     *     summary="ĐƠN HÀNG CỦA CHI NHÁNH",
     *     @SWG\Response(
     *         response=200,
     *         description="Danh sách ĐƠN HÀNG CỦA CHI NHÁNH"
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
     * )
     */
    public function listbran_order(Request $req) {
        $user = $req->user();
        $group_id = $req->user()->group_id;

        $query = User::where([
            'use_status' => 1,
            'use_group' => User::TYPE_BranchUser,
            'parent_id' => $user->use_id
        ]);

        //check number order > 0
        $query->leftJoin('tbtt_showcart', 'shc_saler', 'use_id');
        $query->select(['parent_id', 'use_id', 'use_username', 'use_fullname', 'use_email', 'use_mobile']);
        $query->selectRaw('count(tbtt_showcart.shc_id) as showcarttotal');
        $query->havingRaw('count(tbtt_showcart.shc_id) > 0');
        $query->groupBy('use_id');
        //->select('parent_id,use_id,use_username,use_fullname,use_email,use_mobile');

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        //return $paginate;
        $arraysData = [];
        foreach ($paginate->items() as $key => $value) {
            $Str = User::where('use_id', $value->parent_id)->select(['use_username', 'use_group', 'parent_id'])->first();
            $info_parent = [];
            $haveDomain = '';
            $pshop = '';

            $pgroup = $Str->use_group;

            if ($Str->use_group == 3) {
                $info_parent['GH'] = $Str->use_username;
                $checkDomain = Shop::where('sho_user', $Str->use_id)->select(['sho_id', 'sho_link', 'domain'])->first();
                if ($checkDomain) {
                    $haveDomain .= $checkDomain->domain;
                    $pshop .= $checkDomain->sho_link;
                }
            } elseif ($Str->use_group == 14) {
                $info_parent['CN'] = $Str->use_username;
                $pa_cn = User::where('use_id', $Str->parent_id)->select(['use_username', 'use_group', 'parent_id'])->first();
                if (!empty($pa_cn)) {
                    if ($pa_cn->use_group == User::TYPE_AffiliateStoreUser) {
                        $info_parent['GH'] = $pa_cn->use_username;
                    } else {
                        if ($pa_cn->use_group == User::TYPE_StaffStoreUser) {
                            $pa_nvgh = User::where('use_id', $pa_cn->parent_id)->select(['use_username', 'use_group', 'parent_id'])->first();
                            $info_parent['NVGH'] = $pa_cn->use_username;
                            $info_parent['GH'] = $pa_nvgh->use_username;
                        }
                    }
                }
            } elseif ($Str->use_group == 15) {
                $info_parent['NVGH'] = $Str->use_username;
                $pa_cn = User::where('use_id', $Str->parent_id)->select(['use_username', 'use_group', 'parent_id'])->first();
                $pa_nvgh = User::where('use_id', $pa_cn->parent_id)->select(['use_username', 'use_group', 'parent_id'])->first();
                if (!empty($pa_cn) && $pa_cn->use_group == User::TYPE_AffiliateStoreUser) {
                    $info_parent['GH'] = $pa_cn->use_username;

                }
            } elseif ($Str->use_group == 11) {
                $info_parent['NV'] = $Str->use_username;
                $pa_nv = User::where('use_id', $Str->parent_id)->select(['use_username', 'use_group', 'parent_id'])->first();
                if (!empty($pa_nv) && $pa_nv->use_group == 14) {
                    $info_parent['CN'] = $pa_nv->use_username;
                    $pa_cn = User::where('use_id', $pa_nv->parent_id)->select(['use_username', 'use_group', 'parent_id'])->first();
                    if (!empty($pa_cn) && $pa_cn->use_group == 3) {
                        $info_parent['GH'] = $pa_cn->use_username;
                    }
                } elseif (!empty($pa_nv) && $pa_nv->use_group == 3) {
                    $info_parent['GH'] = $pa_nv->use_username;
                }
            } else {
            }

            $data = $value->toArray();
            //$data['user'] = $value->user->publicProfile();
            //$data['user']['shop'] = $value->user->shop;
            $arraysData[] = array(
                'use_id' => $value->use_id,
                'use_group' => $value->use_group,
                'use_username' => $value->use_username,
                'use_fullname' => $value->use_fullname,
                'avatar' => $value->avatar,
                'use_email' => $value->use_email,
                'use_mobile' => $value->use_mobile,
                'parent_id' => $value->parent_id,
                'showcarttotal' => $value->showcarttotal,
                'info_parent' => $info_parent
            );
            //$value->user->shop;
        }
        $results = $paginate->toArray();
        $results['data'] = $arraysData;

        return $results;
    }
}