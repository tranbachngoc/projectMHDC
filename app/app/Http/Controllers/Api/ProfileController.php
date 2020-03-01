<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\Device;
use Lang;
use App\Helpers\Commons;
use App\Models\Money;
use App\Models\Shop;

class ProfileController extends ApiController {

	/**
     * @SWG\Get(
     *     path="/api/v1/me/profile",
     *     operationId="profile",
     *     description="profile",
     *     produces={"application/json"},
     *     tags={"Profile"},
     *     summary="Thông tin",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function index(Request $req) {
        $managerGroup = array(User::TYPE_Developer1User, User::TYPE_Developer2User, User::TYPE_Partner1User, User::TYPE_Partner2User, User::TYPE_CoreMemberUser, User::TYPE_CoreAdminUser);
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $user = $req->user();
        $query = User::where('use_id',$user->parent_id);
        $query->where('use_status',User::STATUS_ACTIVE);
        $query->where(function($q) use($currentDate) {
            $q->whereOr('use_enddate', $currentDate);
            $q->whereOr('use_enddate', 0);
        });
        $parent = $query->first();
        
        if ($parent && ($parent->use_group == User::TYPE_StaffStoreUser || $parent->use_group == User::TYPE_StaffUser)) {
            $get_shop_parent = Shop::where(['sho_user' => $parent->parent_id])->first();
        } else {
            $get_shop_parent = Shop::where(['sho_user' => $user->parent_id])->first();
        }
        $domainName = env('APP_DOMAIN');
  
        $result = $req->user()->myPublicProfile();
        
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $shope = $user->shop;
        $domain_user = !empty($shope)?$shope->domain:'';
        $parent_domain = '';
        $shop_domain = '';
        $shop_link_parent ='';
        if (!empty($get_shop_parent)) {
            $shop_link_parent = $get_shop_parent->sho_link;
            $parent_domain = $get_shop_parent->domain;
            if (empty($parent_domain)) {
                $shop_domain = $protocol . $user->use_username;
            } else {
                $shop_domain = $protocol . $parent_domain . '/' . $user->use_username;
            }
        }

        $link_aff = $protocol . $user->use_username . '.' . $domainName;
        $result['link_shop_parent'] = $protocol . $shop_link_parent . '.' . $domainName . '/' . $user->use_username;
        if(!empty($domain_user)){
            $result['domain_user'] = $protocol . $domain_user;
        }
        $result['shop_domain'] = $shop_domain;
        $result['domain_parent'] = $parent_domain;
        $result['link_aff'] = $link_aff;
        $result['parent_group'] = null;
        if(!empty($parent)){
            $result['parent_group'] = $parent->use_group;
        }
//        $result['link_gh'] = '';
////        $p_id = array(User::TYPE_Developer1User, User::TYPE_Developer2User, User::TYPE_Partner1User, User::TYPE_Partner2User, User::TYPE_CoreMemberUser, User::TYPE_CoreAdminUser);
////        if (!in_array($parent_group,$p_id) && ($user_group == AffiliateStoreUser && $parent_group == AffiliateStoreUser)|| $user_group == AffiliateUser || $user_group == BranchUser) { 
////            
////        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }


    /**
     * @SWG\Put(
     *     path="/api/v1/devices/token",
     *     operationId="update token",
     *     description="update token",
     *     tags={"Profile"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="deviceToken",
     *         in="body",
     *         description="deviceToken",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="deviceId",
     *         in="body",
     *         description="deviceId",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="deviceType",
     *         in="body",
     *         description="Allow ios or android",
     *         required=true,
     *         type="string",
     *         enum="ios|android"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public user profile",
     *         @SWG\Schema(ref="#/definitions/Customer")
     *     )
     * )
     */
    public function updateDeviceToken(Request $request) {
        $validator = Validator::make($request->all(), [
            'deviceToken' => 'required|string',
            'deviceType' => 'required|string|in:android,ios',
            'deviceId' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        Device::where([
            'imei' => $request->deviceId
        ])->delete();

        $activeDevice = new Device([
            'type' => $request->deviceType,
            'userId' => $user->use_id,
            'token' => $request->deviceToken,
            'imei' => $request->deviceId,
            'active' => true
        ]);

        //disable other devices of this user
        //and other devices?
        try {

            $activeDevice->save();

            return response([
                'msg' => Lang::get('response.success'),
                'data' => $activeDevice
            ]);
        } catch (Exception $ex) {
            return response(['msg' => 'SERVER_ERROR'], 500);
        }
    }
    
    
    	/**
     * @SWG\Put(
     *     path="/api/v1/me/profile",
     *     operationId="profile",
     *     description="profile",
     *     produces={"application/json"},
     *     tags={"Profile"},
     *     summary="update thông tin profile",
     *  @SWG\Parameter(
     *         name="avatar",
     *         in="body",
     *         description="Avatar",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="use_fullname",
     *         in="body",
     *         description="Họ và tên",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="use_province",
     *         in="body",
     *         description="Tĩnh",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="use_district",
     *         in="body",
     *         description="Quận",
     *         required=true,
     *         type="string",
     *     ),
         *  @SWG\Parameter(
     *         name="use_phone",
     *         in="body",
     *         description="Số điện thoại",
     *         required=true,
     *         type="string",
     *     ),
      *  @SWG\Parameter(
     *         name="use_mobile",
     *         in="body",
     *         description="Số điện thoại di động",
     *         required=true,
     *         type="string",
     *     ),
      *  @SWG\Parameter(
     *         name="use_yahoo",
     *         in="body",
     *         description="Tài khoản yahoo bắt buốc đối với tài khoản shop",
     *         required=true,
     *         type="integer",
     *     ),
    *  @SWG\Parameter(
     *         name="use_skype",
     *         in="body",
     *         description="Tài khoản yahoo bắt buốc đối với tài khoản shop",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="use_sex",
     *         in="body",
     *         description="Giới tính",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="use_birthday",
     *         in="body",
     *         description="Ngày sinh",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="tax_code",
     *         in="body",
     *         description="Ma thue",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="tax_type",
     *         in="body",
     *         description="0 Ca nhan , 1 Doanh nghiep",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="cập nhật profile"
     *     )
     * )
     */
    
    public function update(Request $req) {
        $user = $req->user();
        $validatorFiled = [
            'use_fullname' => 'required|string',
            'use_address' => 'required|string',
            'use_province' => 'required',
            'use_district' => 'required',
            'use_phone' => [
                'regex:' . Commons::homePhone(),
            ],
            'use_mobile' => [
                'unique:tbtt_user,use_mobile,' . $user->use_id.',use_id',
                'regex:' . Commons::isPhone(),
            ],
        ];
        if ($req->user()->user_group > User::TYPE_AffiliateUser) {
            $validatorFiled['use_mobile'] = [
                'required',
                'unique:tbtt_user,use_mobile,' . $user->use_id,
                'regex:' . Commons::isPhone()
            ];
            $validatorFiled['yahoo_account'] = 'regex:' . Commons::validNick();
            $validatorFiled['skype_account'] = 'regex:' . Commons::validNick();
        }
        $input =  $req->all();
        $validator = Validator::make($req->all(), $validatorFiled);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        
        $helper = new Commons();
      
        foreach ($input as $key => $value) {
            if (!in_array($key,(new User)->allowUpdate($req->user()->user_group))) {
                unset($input[$key]);
            } else {
               
                if ($key == 'use_province' || $key == 'use_district') {
                    $input[$key] = (int) $input[$key];
                } else {
                    $input[$key] = trim($helper->injection_html($value));
                }
                 if($key == 'use_district'){
                    $input['user_district'] = $value;
                    unset($input['use_district']);
                }
            }
        }
        $req->user()->fill($input);
        try {
            $req->user()->save();
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $req->user()->publicProfile()
            ]);
        } catch (Exception $ex) {
            return response(['msg' => 'SERVER_ERROR'], 500);
        }
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/me/bank",
     *     operationId="bank",
     *     description="bank",
     *     produces={"application/json"},
     *     tags={"Profile"},
     *     summary="Cập nhật ngân hàng",
     *  @SWG\Parameter(
     *         name="bank_name",
     *         in="body",
     *         description="Tên ngân hàng",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="bank_add",
     *         in="body",
     *         description="Địa chỉ ngân hàng",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="account_name",
     *         in="body",
     *         description="Tên tài khoản",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="num_account",
     *         in="body",
     *         description="số tài khoản",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="cập nhật profile"
     *     )
     * )
     */
    public function updateBank(Request $req) {
        $validator = Validator::make($req->all(), [
            'bank_name' => 'required|string',
            'bank_add' => 'required|string',
            'account_name' => 'required|string',
            'num_account' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $req->user();
        if (!empty($user->bank_name) && !empty($user->account_name)  && !empty($user->num_account) && !empty($user->bank_add)) {
            return response([
                'msg' => Lang::get('response.role_update_bank'),
            ], 422);
        }

        try {
            $user->bank_name = $req->bank_name;
            $user->account_name = $req->account_name;
            $user->num_account = $req->num_account;
            $user->bank_add = $req->bank_add;
            $user->save();

            return response([
                'msg' => Lang::get('response.success'),
                'data' => $user->publicProfile()
            ]);
        } catch (Exception $ex) {
            return response(['msg' => 'SERVER_ERROR'], 500);
        }
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/me/changePassword",
     *     operationId="changePassword",
     *     description="Thay dổi password",
     *     produces={"application/json"},
     *     tags={"Profile"},
     *     summary="Thông tin",
     *  @SWG\Parameter(
     *         name="oldPassword",
     *         in="body",
     *         description="Password cũ",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="password",
     *         in="body",
     *         description="Password mới",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="passwordConfirmation",
     *         in="body",
     *         description="Nhập lại password mới",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Đổi password"
     *     )
     * )
     */
    function changepassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
                'oldPassword' => 'required',
                'password' => 'required|same:password',
                'passwordConfirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
  
        $user = User::where(['use_id'=>$req->user()->use_id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('auth.account_not_found')
                ], 404);
        }
        if (!$user->checkPassword($req->oldPassword)) {
            return response([
                'msg' => Lang::get('auth.wrong_password')
                ], 400);
        }
       
        $user->use_password = User::hashPassword($req->password, $user->use_salt);
        $user->save();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $user->publicProfile()
        ]);
    }
    
         /**
     * @SWG\Get(
     *     path="/api/v1/me/link-ref",
     *     operationId="linkRef",
     *     description="linkRef",
     *     produces={"application/json"},
     *     tags={"Profile"},
     *     summary="Các link",
     *     @SWG\Response(
     *         response=200,
     *         description="thông tin link affiliate: Link mời giới thiệu đại lý bán lẻ ,estore: link giới thiệu mở gian hàng "
     *     )
     * )
     */
    public function linkRef(Request $req) {

        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'affiliate' => env('APP_FONTEND_URL') . '/register/affiliate/pid/' . $req->user()->use_id,
                'estore' => env('APP_FONTEND_URL') . '/register/estore/pid/' . $req->user()->use_id,
            ]
        ],200);
    }
          /**
     * @SWG\Get(
     *     path="/api/v1/me/money-summary",
     *     operationId="money-summary",
     *     description="money-summary",
     *     produces={"application/json"},
     *     tags={"Profile"},
     *     summary="Thống kê tài khoản cá nhân",
     *     @SWG\Response(
     *         response=200,
     *         description="totalAmount: tiền có sẵn,waitPaid: đang đợi chi trả "
     *     )
     * )
     */
    public function getInfoAmount(Request $req) {
        $result = [
            'totalAmount' => 0,
            'waitPaid' => 0
        ];
        $query = Money::where(['user_id' => $req->user()->use_id]);

        $query->whereIn('status', [Money::STATUS_IN_BANKING]);
        $query->groupBy('status');

        $result['totalAmount'] = $query->sum('amount');
        $query1 = Money::where(['user_id' => $req->user()->use_id]);
        $query1->whereNotIn('status', [Money::STATUS_WITHDRAW]);
        $result['waitPaid'] = $query1->sum('amount');
        return response([
            'msg' => Lang::get('response.success'), 'data' => $result]);
    }

    public function listMoeny(Request $req) {
        $query = Money::where(['user_id' => $req->user()->use_id]);
        return response([
            'msg' => Lang::get('response.success'), 'data' => $query->get]);
    }
    
    	/**
     * @SWG\Put(
     *     path="/api/v1/me/update-af",
     *     operationId="update-af",
     *     description="update-af",
     *     produces={"application/json"},
     *     tags={"Profile"},
     *     summary="Nâng cấp lên update-af",
     *  @SWG\Parameter(
     *         name="avatar",
     *         in="body",
     *         description="Avatar",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="use_fullname",
     *         in="body",
     *         description="Họ và tên",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="use_province",
     *         in="body",
     *         description="Tĩnh",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="user_district",
     *         in="body",
     *         description="Quận",
     *         required=false,
     *         type="string",
     *     ),
         *  @SWG\Parameter(
     *         name="use_phone",
     *         in="body",
     *         description="Số điện thoại",
     *         required=false,
     *         type="string",
     *     ),
      *  @SWG\Parameter(
     *         name="use_mobile",
     *         in="body",
     *         description="Số điện thoại di động",
     *         required=false,
     *         type="string",
     *     ),
      *  @SWG\Parameter(
     *         name="use_yahoo",
     *         in="body",
     *         description="Tài khoản yahoo bắt buốc đối với tài khoản shop",
     *         required=false,
     *         type="integer",
     *     ),
    *  @SWG\Parameter(
     *         name="use_skype",
     *         in="body",
     *         description="Tài khoản yahoo bắt buốc đối với tài khoản shop",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="use_sex",
     *         in="body",
     *         description="Giới tính",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="use_birthday",
     *         in="body",
     *         description="Ngày sinh",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="tax_code",
     *         in="body",
     *         description="Ma thue",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="tax_type",
     *         in="body",
     *         description="0 Ca nhan , 1 Doanh nghiep",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="cập nhật profile"
     *     )
     * )
     */
    
     function upgrade_af(Request $req) {
        $user = $req->user();
        if ($user->use_group == User::TYPE_AffiliateUser) {
            return response([
                'msg' => 'Bạn đã đang là người dùng affiliate'
                ], 422);
        }
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    
        if ($user->use_group > User::TYPE_AffiliateUser) {
            $validator = Validator::make($req->all(), [
                    'use_fullname' => 'required',
                    'use_address' => 'required',
                    'use_province' => 'required',
                    'user_district' => 'required',
                    'use_mobile' => 'required',
            ]);
     
            if ($validator->fails()) {
                return response([
                    'msg' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                    ], 422);
            }
        }
        if ($user->use_group < User::TYPE_AffiliateUser && empty($user->use_email)) {
            
            $validator = Validator::make($req->all(), [
                    'use_email' => 'required'
            ]);
            if ($validator->fails()) {
                return response([
                    'msg' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                    ], 422);
            }
        }
        $allow = array(
            'use_fullname',
            'use_birthday',
            'use_sex',
            'id_card',
            'use_address',
            'use_province',
            'user_district',
            'use_mobile',
            'bank_name',
            'bank_add',
            'account_name',
            'num_account',
            'tax_type',
            'tax_code',
            'avatar',
        );
        $input = $req->all();
        foreach ($input as $key => $value) {
            if (!in_array($key, $allow)) {
                unset($input[$key]);
            }
        }
        $user->fill($input);
        $user->use_group = User::TYPE_AffiliateUser;
        try{
            $user->save();
            $shop = Shop::where('sho_user', $user->use_id)->first();
            
            if (empty($shop)) {
                $shopCat = 1;
                $shopDesc = "Gian hàng Cộng tác viên online azibai";
                $ShopLink = 'store' . $user->use_id;
                $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                $EndDate = mktime(0, 0, 0, date('m'), date('d'), date('Y') + 20);

                $dataShopRegister = array(
                    'sho_name' => 'Cộng tác viên online',
                    'sho_descr' => $shopDesc,
                    'sho_address' => '92 Trần Quốc Toản',
                    'sho_link' => $ShopLink,
                    'sho_logo' => 'default-logo.png',
                    'sho_dir_logo' => 'defaults',
                    'sho_banner' => 'default-banner.jpg',
                    'sho_dir_banner' => 'defaults',
                    'sho_province' => $user->use_province ? $user->use_province : null,
                    'sho_district' => $user->user_district ? $user->user_district: null  ,
                    'sho_category' => $shopCat,
                    'sho_phone' => $user->use_mobile ? $user->use_mobile:'',
                    'sho_mobile' => $user->use_mobile ? $user->use_mobile:'',
                    'sho_user' => $user->use_id,
                    'sho_begindate' => $currentDate,
                    'sho_enddate' => $EndDate,
                    'sho_view' => 1,
                    'sho_status' => 1,
                    'sho_style' => 'default',
                    'sho_email' => $user->use_email
                );
                $shop = new Shop($dataShopRegister);
                $shop->save();
            }
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $user->publicProfile()
                ], 200);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
   
    }

}