<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\Shop;
use Lang;
use App\Models\PackageUser;

use App\Models\Package;
use App\Models\Service;
use App\Models\MasterShopRule;
use App\Models\BranchConfig;
use App\Models\PackageService;
use App\Models\Category;
use App\Models\Product;
use App\Models\LandingPage;
use App\Models\Content;
use App\Models\District;
class BranchController extends ApiController {

	
      /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/list-branch",
     *     operationId="staffs",
     *     description="Danh sách chi nhánh của nhân viên",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Danh sách chi nhánh của nhân viên",
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
     *     @SWG\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="orderBy",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="keywords",
     *         in="query",
     *         description="keywords",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="showAll",
     *         in="query",
     *         description="lấy luôn cả nhãn hàng ( User group = 11 )",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function listBranch(Request $req) {
        $results = $this->listbrands($req->id,$req);
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }

    protected function getPackageCreateBranch($user_id) {
  
        $packageUserdb = PackageUser::tableName();
        $servicedb = Service::tableName();
        $packagedb = Package::tableName();
        $packageServicedb= PackageService::tableName();
        $query = PackageUser::where($packageUserdb.'.user_id',$user_id);
       // $query->where($packageUserdb.'.user_id',User::TYPE_StaffStoreUser);
        $query->join($packagedb,$packageUserdb.'.package_id',$packagedb.'.id');
        $query->join($packageServicedb,$packagedb.'.id',$packageServicedb.'.package_id');
        $query->join($servicedb,$packageServicedb.'.service_id',$servicedb.'.id');
        $query->where([$servicedb . '.published' => 1, $servicedb . '.group' => 25]);
        $query->whereRaw('NOW() >= '.$packageUserdb.'.begined_date');
        $query->whereRaw('(NOW() <= '.$packageUserdb.'.ended_date OR '.$packageUserdb.'.ended_date IS NULL)');

        return $query->get();
        
    }
    
      /**
     * @SWG\Get(
     *     path="/api/v1/me/allow-create-branch",
     *     operationId="checkallowcreatebranch",
     *     description="Kiểm tra có được tạo chi nhánh hay không",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Kiểm tra có được tạo chi nhánh hay không",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    function checkAllowCreateBrand(Request $req) {
        $user = $req->user();
        $shop_id = $user->use_id;
        if ($user->use_group == User::TYPE_StaffStoreUser) {
            $parent = $user->parentActiveInfo;
            if (!empty($parent)) {
                $shop_id = $parent->use_id;
            }
        }
        
        $result = $this->getPackageCreateBranch($shop_id);
   
        if (count($result) == 0) {
            return response(['msg' => 'Gian hàng của bạn hiện không sử dụng dịch vụ mở Chi nhánh'], 404);
        }
        //Lấy tổng số CN hiện có của GH
        $query = User::where(['use_status' => User::STATUS_ACTIVE,
                'use_group' => User::TYPE_BranchUser,
        ]);
        $query->where(function($q) use($shop_id) {
            $q->orWhere(['parent_id' => $shop_id]);
            $q->orWhereIn('parent_id', function($queryChild) {
                $queryChild->select('use_id');
                $queryChild->from(User::tableName());
                $queryChild->where(['use_status' => User::STATUS_ACTIVE, 'use_group' => User::TYPE_StaffStoreUser]);
            });
        });
        $totalBranch = $query->count();
        $total_limit = 0;
        foreach ($result as $key => $value) {
            $total_limit += $value->limited;
        }
        //Nếu GH mua gói DV mở CN
        if ($totalBranch == $total_limit) {
            return response(['msg' => 'Gói dịch vụ của bạn chỉ mở được tối đa ' . $total_limit . ' Chi nhánh.'], 402);
        }
        return response(['msg' => Lang::get('response.success'), 'data' => $totalBranch], 200);
    }
    
    public function mylist(Request $req) {
        $results = $this->listbrands($req->user()->use_id, $req);
//       
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/list-branch",
     *     operationId="staffs",
     *     description="Danh sách chi nhánh của tôi",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Danh sách chi nhánh của tôi",
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
     *     @SWG\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="orderBy",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="sum",
     *         in="query",
     *         description="Tính tổng số chi nhánh thì truyền sum=1",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="keywords",
     *         in="query",
     *         description="keywords",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="createdByMeOnly",
     *         in="query",
     *         description="Chỉ lấy danh sách tạo ra bởi tôi ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="showAll",
     *         in="query",
     *         description="lấy luôn cả nhãn hàng ( User group = 11 )",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    private function listbrands($id,Request $req) {
        $shopdb = (new Shop)->getTable();
        $userdb = (new User)->getTable();
        $query = User::where(['use_status' => User::STATUS_ACTIVE, 'use_group' => User::TYPE_BranchUser]);
        if ($req->createdByMeOnly) {
            $query->whereIn('parent_id', $id);
        }
        $query->whereIn('parent_id', function($q) use($id) {
                $q->select('use_id');
                $q->from((new User)->getTable());
                $q->where(function($q2) use ($id) {
                    $q2->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                    $q2->where(['parent_id' => $id]);
                });
                $q->orWhere('use_id', $id);
            })->join($shopdb, $shopdb . '.sho_user', $userdb . '.use_id')
            ->with('shop')->withCount('affNumber');

        if (!empty($req->orderBy)) {
            $req->orderBy = explode(',', $req->orderBy);
            $key = $req->orderBy[0];
            $value = $req->orderBy[1] ? $req->orderBy[1] : 'DESC';
            $query->orderBy($key, $value);
        } else {
            $query->orderBy('use_fullname', 'ASC');
        }

        if (!empty($req->keywords)) {
            $query->where(function($q) use ($req) {
                $q->orWhereRaw('LOWER(use_fullname) like ?', array('%' . mb_strtolower($req->keywords) . '%'));
                $q->orWhereRaw('LOWER(use_username) like ?', array('%' . mb_strtolower($req->keywords) . '%'));
                $q->orWhereRaw('LOWER(use_fullname) like ?', array('%' . mb_strtolower($req->keywords) . '%'));
                $q->orWhereRaw('LOWER(use_mobile) like ?', array('%' . mb_strtolower($req->keywords) . '%'));
                $q->orWhereRaw('LOWER(use_phone) like ?', array('%' . mb_strtolower($req->keywords) . '%'));
            });
        }
        if ($req->sum) {
            return $data['total'] = $query->count();
        }

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        $data = [];
        foreach ($paginate->items() as $item) {
            $result = $item->publicProfile();
            $result['bank_name']  = $item->bank_name;
            $result['bank_add'] = $item->bank_add;
            $result['account_name'] = $item->account_name;
            $result['num_account'] = $item->num_account;         
            $result['shop'] = $item->shop;
            $result['aff_number_count'] = $item->aff_number_count;
            $result['staff_of_user'] = $item->getAllStaffOfUser();
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;
        return $results;
    }
      /**
     * @SWG\Get(
     *     path="/api/v1/list-config-branch",
     *     operationId="Branch",
     *     description="Danh sách config",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Danh sách config",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    function listConfig(Request $req) {
        $rulers = MasterShopRule::where(['type' => 7])->orderBy('id', 'ASC')->get();
        return response(['msg' => Lang::get('response.success'), 'data' => $rulers], 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/selected-config",
     *     operationId="Branch",
     *     description="Danh sách config đã chọn",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Danh sách config",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    function selectedConfig($id) {
        $user = User::where(['use_id' => $id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.user_not_found')
                ], 404);
        }
        $shopConfig = $user->branchConfig;
        return response(['msg' => Lang::get('response.success'), 'data' => $shopConfig], 200);
    }
     /**
     * @SWG\Put(
     *     path="/api/v1/user/{id}/update-config-branch",
     *     operationId="Branch",
     *     description="Cập nhật config",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Cập nhật config",
     *  @SWG\Parameter(
     *         name="shop_rule",
     *         in="query",
     *         description="id của các rule mà mình chọn ví dụ 47,49,48" ,
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    function updateConfig($id,Request $req) {
          $validator = Validator::make($req->all(), [
                'shop_rule' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $user = User::where(['use_id' => $id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.user_not_found')
                ], 404);
        }
        $query = Shop::where(['sho_user' => $req->user()->use_id, 'sho_status' => 1]);
        $query->where('sho_enddate', '>=', time());
        $shop = $query->first();
        if (empty($shop)) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
       
        $lastSelected = !empty($user->branchConfig) ? implode(',',$user->branchConfig->toArray()):[];
       
        if (count($lastSelected) != 1) {
            $dataAdd = array(
                'shop_id' => $shop->sho_id,
                'bran_id' => (int) $id,
                'parent_id' => (int) $req->user()->use_id,
                'config_rule' => $req->shop_rule,
                'createdate' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
            );
            $config = new BranchConfig($dataAdd);
            $config->save();
            return response(['msg' => Lang::get('response.success'), 'data' => $config], 200);
        } else {
            $user->branchConfig->config_rule = $req->shop_rule;
            $user->branchConfig->save();
            return response(['msg' => Lang::get('response.success'), 'data' => $user->branchConfig], 200);
        }
    }
    
      /**
     * @SWG\Get(
     *     path="/api/v1/branch/product-waiting-approve",
     *     operationId="Branch",
     *     description="Sản phẩm chờ duyệt",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Sản phẩm chờ duyệt",
     *  @SWG\Parameter(
     *         name="testing",
     *         in="query",
     *         description="Truyền lên để test khi shop hiện tại ko có" ,
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="" ,
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="" ,
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    
   
     function productWaitingApprove(Request $req) {

        $user = $req->user();
        $userdb = User::tableName();
        $categorydb = Category::tableName();
        $productdb = Product::tableName();
        $condition = [
            $userdb . '.parent_id' => $user->use_id,
            $userdb . '.use_group' => User::TYPE_BranchUser, $productdb . '.pro_status' => 0];
        if ($req->testing) {
            unset($condition[$userdb . '.parent_id']);
        }

        $query = Product::where($condition);
        $query->join($categorydb, $categorydb . '.cat_id', $productdb . '.pro_category');
        $query->join($userdb, $userdb . '.use_id', $productdb . '.pro_user');
        $query->orderBy('pro_id', 'DESC');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);


        foreach ($paginate as $value) {
            $value->publicInfo($req->user());
            $value->buildPrice($req->user());
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $paginate
        ],200);
    }
         /**
     * @SWG\Put(
     *     path="/api/v1/branch/product-waiting-approve/{id}/status",
     *     operationId="Branch",
     *     description="Cập nhật trạng thái sản phẩm chờ duyệt",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Sản phẩm chờ duyệt",
     *  @SWG\Parameter(
     *         name="testing",
     *         in="query",
     *         description="Truyền lên để test khi shop hiện tại ko có" ,
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_status",
     *         in="body",
     *         description="1: là trạng thái active, 0 là deactive" ,
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="" ,
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function changeStatusProduct($id, Request $req) {
        $all = $req->all();
        $validatorAtt = [
            'pro_status' => 'required|in:0,1', //0: deactive, 1: active
        ];
        $validator = Validator::make($all, $validatorAtt);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $user = $req->user();
        $userdb = User::tableName();
        $productdb = Product::tableName();
        $condition = [
            $userdb . '.parent_id' => $user->use_id,
            $userdb . '.use_group' => User::TYPE_BranchUser];
        if ($req->testing) {
            unset($condition[$userdb . '.parent_id']);
        }
        $query = Product::where($condition);

        $query->join($userdb, $userdb . '.use_id', $productdb . '.pro_user');

        $query->where('pro_id', $id);
        $product = $query->first();
        if (empty($product)) {
            return response([
                'msg' => Lang::get('response.product_not_found'),
                'data' => $product
                ], 404);
        }
        $product->pro_status = $req->pro_status;
        $product->save();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $product
            ], 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/branch/flyer-wait-approve",
     *     operationId="Branch",
     *     description="Tờ rơi chờ duyệt",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Tờ rơi chờ duyệt",
     *  @SWG\Parameter(
     *         name="testing",
     *         in="query",
     *         description="Truyền lên để test khi shop hiện tại ko có" ,
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="" ,
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="" ,
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="list_name là danh sách nhận , user là thông tin chi nhánh"
     *     )
     * )
     */
    function flyerWaitApprove(Request $req) {
        $userdb = User::tableName();
        $landingdb = LandingPage::tableName();
        $condition = [
            $userdb . '.parent_id' => $req->user()->use_id,
            $landingdb . '.status' => 0,
            $userdb . '.use_group' => User::TYPE_BranchUser
        ];
        if ($req->testing) {
            unset($condition[$userdb . '.parent_id']);
        }
        $query = LandingPage::where($condition);
        $query->join($userdb, $userdb . '.use_id', $landingdb . '.user_id');
        $query->select($landingdb.'.*');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        $data = [];
        foreach($paginate->items() as $item){
            $value = $item->toArray();
            $value['user'] = $item->user->publicProfile();
            $data[] = $value;
        }
        $result = $paginate->toArray();
        $result['data'] = $data;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }
    /**
     * @SWG\Put(
     *     path="/api/v1/branch/flyer-wait-approve/{id}/status",
     *     operationId="Branch",
     *     description="Active /deavtive Tờ rơi chờ duyệt",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Tờ rơi chờ duyệt",
     *  @SWG\Parameter(
     *         name="testing",
     *         in="query",
     *         description="Truyền lên để test khi shop hiện tại ko có" ,
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="status",
     *         in="body",
     *         description="1 la active , 0 la o active" ,
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description=""
     *     )
     * )
     */
    function changeStatusFlyer($id, Request $req) {
        $userdb = User::tableName();
        $landingdb = LandingPage::tableName();
        $condition = [
            $userdb . '.parent_id' => $req->user()->use_id,
            $userdb . '.use_group' => User::TYPE_BranchUser
        ];
        if ($req->testing) {
            unset($condition[$userdb . '.parent_id']);
        }
        $condition['id'] = $id;
        $query = LandingPage::where($condition);
        $query->join($userdb, $userdb . '.use_id', $landingdb . '.user_id');
        $landing = $query->first();
        if (empty($landing)) {
            return response([
                'msg' => Lang::get('response.landing_not_found')
                ], 404);
        }

        $landing->status = $req->status;
        $landing->save();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $landing
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/branch/news-wait-approve",
     *     operationId="Branch",
     *     description="Tờ rơi chờ duyệt",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Tin tức chờ duyệt",
     *  @SWG\Parameter(
     *         name="testing",
     *         in="query",
     *         description="Truyền lên để test khi shop hiện tại ko có" ,
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="" ,
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="" ,
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="list_name là danh sách nhận , user là thông tin chi nhánh"
     *     )
     * )
     */
    function newsWaitApprove(Request $req)
    {
        $user = $req->user();
        $userdb = User::tableName();
        $newsdb = Content::tableName();
        $query = Content::where([]);
        $condition = [
            $userdb.'.parent_id'=>$user->use_id,
            $userdb.'.use_group'=>User::TYPE_BranchUser,
            $newsdb.'.not_status'=>0
        ];
        if($req->testing){
            unset($condition[$userdb.'.parent_id']);
        }
        $query->join($userdb,$userdb.'use_id',$newsdb.'.not_user');
        
        $query->where($condition);
         $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        //populate user
        $arraysData = [];
        foreach ($paginate->items() as $value) {
            $value->populate($req->user());
            $data = $value->toArray();
            $data['user'] = $value->user->publicProfile();
            $data['user']['shop'] = $value->user->shop;
            $arraysData[] = $data;
            //$value->user->shop;
        }
        $results = $paginate->toArray();
        $results['data'] = $arraysData;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
      
    }
    
    
    /**
     * @SWG\Put(
     *     path="/api/v1/branch/news-wait-approve/{id}/status",
     *     operationId="changeStatusNews",
     *     description="Cap nhat trang thai tin tuc",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Cap nhat trang thai tin tuc",
     *  @SWG\Parameter(
     *         name="con_status",
     *         in="body",
     *         description="1 la active , 0 la o active" ,
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
     function changeStatusNews($id, Request $req) {
        $user = $req->user();
        $userdb = User::tableName();
        $query = Content::where([]);
        $condition = [
            $userdb . '.parent_id' => $user->use_id,
            $userdb . '.use_group' => User::TYPE_BranchUser,
        ];
        if ($req->testing) {
            unset($condition[$userdb . '.parent_id']);
        }
        $news = $query->first();
        if (empty($news)) {
            return response([
                'msg' => Lang::get('response.news_not_found')
                ], 404);
        }

        $news->con_status = $req->con_status;
        $news->save();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $news
        ]);
    }

    /**
     * @SWG\Delete(
     *     path="/api/v1/me/list-branch/{$id}",
     *     operationId="deleteBranch",
     *     description="Xoa chi nhanh",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Xoa chi nhanh",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    function deleteBranch($id, Request $req) {
        $user = $req->user();
        $userDelete = User::where(['use_id' => $id, 'parent_id' => $user->use_id])->first();
        $parent = User::where('parent_id', $id)->first();
        if (empty($parent) && $userDelete->use_group == User::TYPE_BranchUser) {
            //DELETE SHOP
            Shop::where(['sho_user', $id])->delete();
            $userDelete->delete();
        } else {
            return response([
                'msg' => Lang::get('response.user_not_found'),
                'data' => $userDelete
                ], 404);
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $userDelete
        ]);
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/me/list-branch/{$id}/update-bank",
     *     operationId="updateBankBranch",
     *     description="Update bank",
     *     produces={"application/json"},
     *     tags={"Branch"},
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
     *         description="public info"
     *     )
     * )
     */
    function updateBank($id,Request $req){
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

        $query = User::where(['use_id' => $id, 'use_status' => User::STATUS_ACTIVE, 'use_group' => User::TYPE_BranchUser]);
        $query->whereIn('parent_id', function($q) use($req) {
            $q->select('use_id');
            $q->from((new User)->getTable());
            $q->where(function($q2) use ($req) {
                $q2->whereIn('use_group', [User::TYPE_StaffStoreUser]);
                $q2->where(['parent_id' => $req->user()->use_id]);
            });
            $q->orWhere('use_id', $req->user()->use_id);
        });
        $brand = $query->first();
        if (empty($brand)) {
            return response([
                'msg' => Lang::get('response.user_not_found'),
                'data' => $brand
            ], 404);
        }
        
        if ($req->user()->use_group == User::TYPE_BranchUser) {
            $shop_rule = BranchConfig::where(['bran_id' => $req->user()->use_id])->first();
            $bran_array = null;
            if ($shop_rule) {
                $bran_array = explode(",", $shop_rule->config_rule);
            }
            if ($shop_rule && isset($bran_array) && in_array(50, $bran_array)) {
                
            } else {
                return response([
                    'msg' => Lang::get('response.role_update_bank'),
                    ], 422);
            }
        }

        try {
            $brand->bank_name = $req->bank_name;
            $brand->account_name = $req->account_name;
            $brand->num_account = $req->num_account;
            $brand->bank_add = $req->bank_add;
            $brand->save();
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $brand
            ]);
        } catch (Exception $ex) {
            return response(['msg' => 'SERVER_ERROR'], 500);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/user/{$id}/kho",
     *     operationId="kho",
     *     description="Lấy kho",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Lấy kho",
     *     @SWG\Response(
     *         response=200,
     *         description="public info"
     *     )
     * )
     */
    public function getKho($id, Request $req) {
        $shop = Shop::where('sho_user', $id)->first();
        if (empty($shop)) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
            ], 404);
        }

        $district = District::where('DistrictCode', $shop->sho_kho_district)->first();

        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'sho_kho_address' => $shop->sho_kho_address,
                'sho_kho_province' => $shop->sho_kho_province,
                'sho_kho_province_name' => $district ? $district->ProvinceName : '',
                'sho_kho_district' => $shop->sho_kho_district,
                'sho_kho_district_name' => $district ? $district->DistrictName : ''
            ]
        ]);
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/user/{$id}/kho",
     *     operationId="updatekho",
     *     description="Update Kho",
     *     produces={"application/json"},
     *     tags={"Branch"},
     *     summary="Cập nhật kho",
     *  @SWG\Parameter(
     *         name="sho_kho_address",
     *         in="body",
     *         description="Địa chỉ kho",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_kho_province",
     *         in="body",
     *         description="Tỉnh / Thành phố Kho",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_kho_district",
     *         in="body",
     *         description="Quận/Huyện Kho",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public info"
     *     )
     * )
     */
    public function updateKho($id, Request $req) {
        $shop = Shop::where('sho_user', $id)->first();
        if (empty($shop)) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
            ], 404);
        }

        try {
            $shop->sho_kho_address = $req->sho_kho_address;
            $shop->sho_kho_province = $req->sho_kho_province;
            $shop->sho_kho_district = $req->sho_kho_district;

            $shop->save();
            return response([
                'msg' => Lang::get('response.success'),
                'data' => [
                    'sho_kho_address' => $shop->sho_kho_address,
                    'sho_kho_province' => $shop->sho_kho_province,
                    'sho_kho_district' => $shop->sho_kho_district
                ]
            ]);
        } catch (Exception $ex) {
            return response(['msg' => 'SERVER_ERROR'], 500);
        }
    }
}