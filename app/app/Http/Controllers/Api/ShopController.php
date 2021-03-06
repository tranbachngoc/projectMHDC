<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Shop;
use App\Models\Content;
use App\Models\Product;
use App\Models\Category;
use Lang;
use DB;
use App\Helpers\Commons;
use App\Models\SelectNews;
use App\Models\ShopRule;
use App\Models\ProductPromotion;
use App\Models\User;
use App\Components\Folder;
use App\Models\ShopRuleMaster;
use App\Models\PackageUser;


class ShopController extends ApiController {

    /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/shop",
     *     operationId="userShop",
     *     description="userShop",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Xem Thông tin shop",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    
 

    public function view($id, Request $req) {
        $user = User::where(['use_id' => $id])->first();
        $loginUser = $req->user();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $shop = Shop::where('sho_user', $id)->first();
        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
            ], 404);
        }
        $parentInfo = $user->parentInfo;
       
        $shop->parentUser = !empty($parentInfo)? $parentInfo->publicProfile():null;
        $shop->publicInfo();
        
        $data = $shop->toArray();
        $data['sho_email'] = $user->use_email;
        $data['af_key'] = $user->af_key;
        $data['isAffiliate'] = $user->use_group == 2 ? TRUE : FALSE;
        $data['isBranch'] = $user->use_group == 14 ? TRUE : FALSE;
        $data['parentShop'] = null;
        if ($user->use_group == User::TYPE_AffiliateUser) {
            $shop_Id = $this->get_id_shop_in_tree($shop->user);
            $parentShop = Shop::where(['sho_user' => $shop_Id])->first();

            $data['parentShop'] = $parentShop;
        }
        $data['use_group'] = $user->use_group;
        $data['hasFollow'] = $user->hasFollow($loginUser ? $loginUser->use_id : null);

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $data
        ]);
    }
    
    	/**
     * @SWG\Get(
     *     path="/api/v1/me/shop",
     *     operationId="myshop",
     *     description="myshop",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Thông tin",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    
 

    public function myShop(Request $req) {
        $user = $req->user();
        $shop = Shop::where('sho_user', $req->user()->use_id)->first();
        if (!$shop) {
            return response([
                'msg' => Lang::get('shop.not_install')
            ], 404);
        }
        $data = $shop->toArray();
        $data['af_key'] = $user->af_key;
        $data['isAffiliate'] = $user->use_group == 2 ? TRUE : FALSE;
        $data['isBranch'] = $user->use_group == 14 ? TRUE : FALSE;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $shop->publicInfo()
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/shop/pictures",
     *     operationId="userShopPictures",
     *     description="userShopPictures",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Danh sách pictures",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */

    public function pictures($id, Request $req) {
        $user = User::where(['use_id' => $id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $query = Content::where([
                'not_status' => 1,
                'cat_type' => 1
            ])->where('not_image', '<>', '')
            ->whereNotNull('not_image')->orderBy('not_id','DESC');
        Content::filter($query, $req->user());
        $list = [];
        $list = $this->getParentCurrentUser($user, $list);
        $query->whereIn('not_user', $list);

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $pictures = $query->paginate($limit, ['*'], 'page', $page);
        foreach ($pictures->items() as $value) {
            $value->populate($req->user());

            $itemUser = $value->user;
            if (!empty($value->user)) {
                $shop = $value->user->shop;
                if (!empty($shop)) {
                    $value->user->shop = $shop->publicInfo();
                }
            }
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $pictures
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/shop/videos",
     *     operationId="userShopPictures",
     *     description="userShopPictures",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Danh sách videos",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */

    public function videos($id, Request $req) {
        $user = User::where(['use_id' => $id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $shop = Shop::where('sho_user', $id)->first();
        
        $query = Content::where([
                'not_status' => 1,
                'cat_type' => 1
            ])
            ->where(function($q){
                $q->orWhere(function($q) {
                    $q->where('not_video_url', '<>', '');

                    $q->whereNotNull('not_video_url');
                });
                 $q->orWhere(function($q) {
                    $q->where('not_video_url1', '<>', '');

                    $q->whereNotNull('not_video_url1');
                });
            })
            
            ->select('not_id', 'not_video_url','not_video_url1')
            ->orderBy('not_id','DESC');
            Content::filter($query, $req->user());
        $list = [];
        $list = $this->getParentCurrentUser($user,$list);
        $query->whereIn('not_user',$list);
        $videos = $query->get();
        foreach ($videos as $value) {
            $value->populate($req->user(), $shop);
            $itemUser = $value->user;
            if (!empty($itemUser)) {
                $shop = $value->user->shop;
                if (!empty($shop)) {
                    $value->user->shop = $shop->publicInfo();
                }
            }
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $videos
        ]);
    }

    
    protected function getParent($user) {
        if (empty($user)) {
            return null;
        }
        if ($user->use_group == User::TYPE_AffiliateStoreUser) {
            return null;
        }
        $parent = $user->parentInfo;
        if (empty($parent)) {
            return null;
        }
        return $parent;
    }
    /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/shop/aff-news",
     *     operationId="userShopNews",
     *     description="userShopNews",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Danh sách Tin tức",
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page trips",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="filterBy",
     *         in="query",
     *         description="filterBy: follow,promotion: theo khuyến mãi ,new, hot: Tin  hot ,category : Lọc theo danh mục, group",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="filter",
     *         in="query",
     *         description="Nếu filter By = category truyền id cateogy vào đây",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="mostView",
     *         in="query",
     *         description="sort theo xem nhiều",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit trips",
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
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    

    /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/shop/news",
     *     operationId="userShopNews",
     *     description="userShopNews",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Danh sách Tin tức",
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page trips",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit trips",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="filterBy",
     *         in="query",
     *         description="filterBy: meselect: Danh sách tin chọn về, selectme: Danh sách tin được chọn, follow,promotion: theo khuyến mãi ,new, hot: Tin  hot ,category : Lọc theo danh mục, group",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="filter",
     *         in="query",
     *         description="Nếu filter By = category truyền id cateogy vào đây",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="orderBy",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function news($id, Request $req) {
        $user = User::where(['use_id' => $id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $currentUser = $user;
        $shop = Shop::where('sho_user', $id)->first();
        $list = [];
    

        switch ($currentUser->use_group) {
            case User::TYPE_AffiliateStoreUser:
                $list[] = $currentUser->use_id;
                break;
            case User::TYPE_BranchUser:
                $list[] = $user->use_id;
                $userParent = $currentUser->parentInfo;
                if (!empty($userParent)) {
                    if ($userParent->use_group == User::TYPE_AffiliateStoreUser) {
                        $list[] = $userParent->use_id;
                    } else {
                        $list[] = $userParent->parent_id;
                    }
                }
                break;
            case User::TYPE_AffiliateUser:
                $userParent = $currentUser->parentInfo;
                if (!empty($userParent)) {
                    switch ($userParent->use_group) {
                        case User::TYPE_StaffUser:
                            $list[] = $userParent->parent_id;
                            $user_cn = $userParent->parentInfo;
                            if (!empty($user_cn)) {
                                $userParent = $user_cn->parentInfo;
                                if (!empty($userParent)) {
                                    if ($userParent->use_group == User::TYPE_AffiliateStoreUser) {
                                        $list[] = $userParent->use_id;
                                    } else {
                                        $list[] = $userParent->parent_id;
                                    }
                                }
                            }
                            break;
                        case User::TYPE_BranchUser:
                            $list[] = $userParent->use_id;
                            $userParent = $userParent->parentInfo;
                            if (!empty($userParent)) {
                                if ($userParent->use_group == User::TYPE_AffiliateStoreUser) {
                                    $list[] = $userParent->use_id;
                                } else {
                                    $list[] = $userParent->parent_id;
                                }
                            }
                            break;
                        case User::TYPE_StaffStoreUser:

                            $list[] = $userParent->parent_id;
                            break;
                        case User::TYPE_AffiliateStoreUser:
                            $list[] = $userParent->use_id;
                            break;
                    }
                }

                break;
        }
        
        $selectDb = (new SelectNews)->getTable();
        $newsDb = (new Content)->getTable();
        $shopdb = Shop::tableName();
        $query1 = Content::where([
               // 'not_status' => 1,
              //  'not_publish' => 1,
                'id_category' => 16
        ]);
        
        if ($req->user()) {
            $userLogin = $req->user();
            $shopParent = $this->get_shop_nearest($userLogin->use_id);
            $shopID = $userLogin->getShopInTree();
            $shopID = $shopID != 0 ? $shopID : $userLogin->use_id;
            $permission = [];
            $notUser = array_merge($list,[$shopParent]);
            $user_group = $req->user()->use_group;
            //dump($user_group);
            if ($user_group !== User::TYPE_AffiliateUser) {
                $permission = [1, 2, 3, 5];
                $query1->where(function($q) use($notUser, $shopParent, $shopID, $userLogin) {
                    $q->whereIn('not_permission', [1, 2, 3]);
                    $q->orWhere(function($q) use($shopID, $shopParent) {
                        $q->where('not_permission', 5);
                        $q->whereIn('not_user', [$shopID, $shopParent]);
                    });
                    $q->orWhere(function($q) use($userLogin) {
                        $q->where('not_permission', 6);
                        $q->where('not_user', $userLogin->use_id);
                    });
                    $q->orWhere(function($q) use($shopID, $userLogin) {
                        $q->where('not_permission', 4);
                        $q->whereIn('not_user', [$shopID, $userLogin->use_id]);
                    });
                });
               
              
            }
            if ($user_group == User::TYPE_AffiliateUser) {
                $query1->where(function($q) use($notUser, $shopParent,$shopID) {
                    $q->whereIn('not_permission', [1, 2, 4]);
                    $q->orWhere(function($q) use($shopID, $shopParent) {
                        $q->where('not_permission', 5);
                        $q->whereIn('not_user', [$shopID, $shopParent]);
                    });
                });
            }
          
            if(!empty($shop)){
                
                if($req->user()->use_id == $shop->sho_user){
                    
//                     $query1->whereIn('not_permission', [1, 2, 3,4,5,6]);
//                     $query1->where('not_user',$req->user()->use_id);
                }else{
                   // $query1->whereIn('not_permission', [1, 2, 3]);
                }
            }

        } else {
           $query1->whereIn('not_permission', [1]);
        }
         
        $query1->whereIn('not_user', $list);
        
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $duoi = '.' . substr(env('APP_FONTEND_URL', 'http://localhost'), strlen($protocol), strlen(env('APP_FONTEND_URL', 'http://localhost')));

        $query1->orderBy('not_begindate', 'DESC');
        
        $query2 = Content::where([])->join($selectDb, $newsDb . '.not_id', $selectDb . '.not_id');
        
        $query2->select($newsDb . '.*')->where(['id_category' => 16, 'not_status' => 1, 'not_publish' => 1]);
        $query2->where($selectDb . '.sho_user', $currentUser->use_id);
        
        if ($req->filterBy == Content::FILTER_MESELECT) {
            $query1 = clone $query2;
        } else if ($req->filterBy == Content::FILTER_SELECTME) {
            $query1->join($selectDb.' as chon ', $newsDb . '.not_id', 'chon.not_id');
            $query1->select($newsDb .'.*');
            $query1->groupBy($newsDb . '.not_id');
        } else {
            $query1->union($query2);
        }
        
        $bindings = $query1->getBindings();
        $sql = $query1->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sql = str_replace('\\', '\\\\', $sql);

        $query = Content::where([]);
        $query->select('news.*');
        $query->from(\DB::raw('(' . $sql . ') as news'));
        
        if ($req->mostView) {
            $query->orderBy('not_ghim', 'DESC')->orderBy('not_view', 'DESC');
        } else {
            $query->orderBy('not_ghim', 'DESC');
            $query->orderBy('not_id', 'DESC');
        }
        if ($req->filterBy == Content::FILTER_PROMOTION) {
            $query->where('not_news_sale', 1);
        } else if ($req->filterBy == Content::FILTER_HOT) {
            $query->where('not_news_hot', 1);
        } else if ($req->filterBy == Content::FILTER_CATEGORY) {
            $query->where('not_pro_cat_id', $req->filter);
        }
        
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        
        $items = [];
        foreach ($paginate->items() as $value) {

            $value->populate($req->user(), $shop);
            if ($shop) {
                if (!empty($shop->domain)) {
                    $value->domainLink($shop->domain,true);
                } else {
                    $value->domainLink($shop->sho_link . $duoi,true);
                }    
            }
            

            $item = $value->toArray();
            $item['user'] = null;
            if (!empty($value->user)) {
                $itemUser = $value->user->publicProfile();
                $item['user'] = $itemUser;
                $item['user']['shop'] = null;
            }
            if (!empty($itemUser)) {
                $shop = $value->user->shop;
                if (!empty($shop)) {
                    $item['user']['shop'] = $shop->publicInfo();
                }
            }
            $items[] = $item;
        }

        $result = $paginate->toArray();

        $result['data'] = $items;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }
    
    
    public function newsV1($id, Request $req) {
        $user = User::where(['use_id' => $id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $shopCurrent = Shop::where('sho_user', $id)->where('sho_status',1)->first();
        if (!$shopCurrent) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
            ], 404);
        }
        $shopCurrent->af_key = $user->af_key;
        $shopCurrent->isAffiliate = $user->use_group == 2 ? TRUE : FALSE;
        $shopCurrent->isBranch = $user->use_group == 14 ? TRUE : FALSE;


        $listParent = [$id];
        $parent = $this->getParent($user);
        if (!empty($parent)) {
            $listParent[] = $parent->use_id;
            $parent = $this->getParent($parent);
            if (!empty($parent)) {
                $parent = $this->getParent($parent);
                if (!empty($parent)) {
                    $listParent[] = $parent->use_id;
                    $parent = $this->getParent($parent);

                    if (!empty($parent)) {
                        $listParent[] = $parent->use_id;
                        $parent = $this->getParent($parent);
                        if (!empty($parent)) {
                            $listParent[] = $parent->use_id;
                        }
                    }
                }
            }
        }
       
        
        $array_use_group = array("2", "3", "14"); // have shop
        if (in_array($user->use_group, $array_use_group)) {
            $shop = $user->shop;
        } else {
            $user_parent = $user->parentInfo;
            if (!empty($user_parent)) {
                if (in_array($user_parent->use_group, $array_use_group)) {
                    $shop = $user_parent->shop;
                }
            }
        }


    
        $selectDb = (new SelectNews)->getTable();
        $newsDb = (new Content)->getTable();
        $shopdb = Shop::tableName();
        $query1 = Content::where([
//                'not_user' => $id,
//                'not_publish'=>1,
                'id_category' => 16
            ])
            ->leftJoin($shopdb,$shopdb.'.sho_user',$newsDb.'.not_user')
            ->whereIn($shopdb.'.sho_user', $listParent)
            ->select($newsDb . '.*')
            ->orderBy('not_begindate', 'DESC');
        

        if ($req->user()) { 
            $query2 = Content::where([])->join($selectDb, $newsDb . '.not_id', $selectDb . '.not_id');
            $query2->select($newsDb . '.*')->where(['id_category' => 16, 'not_status' => 1, 'not_publish' => 1]);
            $query2->whereIn($selectDb . '.sho_user', $listParent)
                ->leftJoin($shopdb, $shopdb . '.sho_user', $newsDb . '.not_user');
         //   dump($query2->get()->toArray());
            if ($req->user()->use_group != User::TYPE_AffiliateUser) {
                $query1->whereIn($newsDb . '.not_permission', [1, 2, 3, 5]);
                $query2->whereIn($newsDb . '.not_permission', [1, 2, 3, 5]);
            } else {
                $query1->whereIn($newsDb . '.not_permission', [1, 2, 4, 5]);
                $query2->whereIn($newsDb . '.not_permission', [1, 2, 4, 5]);
            }
            if (!empty($shop)) {
                if ($req->user()->use_id == $shop->sho_user) {
                    $query1->whereIn($newsDb . '.not_permission', [1, 2, 3, 4, 5, 6]);
                    $query1->whereIn($newsDb . '.not_user', $listParent);
                    $query2->whereIn($newsDb . '.not_permission', [1, 2, 3, 4, 5, 6]);
                 
                } else {
                    $query1->whereIn($newsDb . '.not_permission', [1, 2, 3]);
                    $query1->whereIn($newsDb . '.not_user', $listParent);
                    $query2->whereIn($newsDb . '.not_permission', [1, 2, 3]);
                  
                }
            }
            $query1->union($query2);
        } else {
            $query1->where('not_status', 1);
            $query1->whereIn($newsDb.'.not_permission',[1]);
            
        }

        $bindings = $query1->getBindings();
        $sql = $query1->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sql = str_replace('\\', '\\\\', $sql);

        $query = Content::where([]);
        $query->select('news.*');
        $query->from(\DB::raw('(' . $sql . ') as news'));
        $query->orderBy('not_begindate', 'DESC');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        //populate user
        $items = [];

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $duoi = '.' . substr(env('APP_FONTEND_URL', 'http://localhost'), strlen($protocol), strlen(env('APP_FONTEND_URL', 'http://localhost')));
        foreach ($paginate->items() as $value) {

            $value->populate($req->user(),$shopCurrent);
            if (!empty($shopCurrent->domain)) {
                $value->domainLink($shopCurrent->domain);
            } else {
                $value->domainLink($shopCurrent->sho_link . $duoi);
            }

            $item = $value->toArray();
            $item['user'] = $value->user->publicProfile();
           
            $items[] = $item;
        }

        $result = $paginate->toArray();
        
        $result['data'] =$items;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }
    
    protected function getParentCurrentUser($currentUser,$list){
        switch ($currentUser->use_group) {
            case User::TYPE_AffiliateStoreUser:
                $list[] = $currentUser->use_id;
                break;
            case User::TYPE_BranchUser:
                $list[] = $currentUser->use_id;
                $userParent = $currentUser->parentInfo;
                if (!empty($userParent)) {
                    if ($userParent->use_group == User::TYPE_AffiliateStoreUser) {
                        $list[] = $userParent->use_id;
                    } else {
                        $list[] = $userParent->parent_id;
                    }
                }
                break;
            case User::TYPE_AffiliateUser:
                $userParent = $currentUser->parentInfo;
                if (!empty($userParent)) {
                    switch ($userParent->use_group) {
                        case User::TYPE_StaffUser:
                            $list[] = $userParent->parent_id;
                            $user_cn = $userParent->parentInfo;
                            if (!empty($user_cn)) {
                                $userParent = $user_cn->parentInfo;
                                if (!empty($userParent)) {
                                    if ($userParent->use_group == User::TYPE_AffiliateStoreUser) {
                                        $list[] = $userParent->use_id;
                                    } else {
                                        $list[] = $userParent->parent_id;
                                    }
                                }
                            }
                            break;
                        case User::TYPE_BranchUser:
                            $list[] = $userParent->use_id;
                            $userParent = $userParent->parentInfo;
                            if (!empty($userParent)) {
                                if ($userParent->use_group == User::TYPE_AffiliateStoreUser) {
                                    $list[] = $userParent->use_id;
                                } else {
                                    $list[] = $userParent->parent_id;
                                }
                            }
                            break;
                        case User::TYPE_StaffStoreUser:

                            $list[] = $userParent->parent_id;
                            break;
                        case User::TYPE_AffiliateStoreUser:
                            $list[] = $userParent->use_id;
                            break;
                    }
                }

                break;
        }
        return $list;
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/shop/products",
     *     operationId="userShopProducts",
     *     description="userShopProducts",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Danh sách Sản Phẩm",
     *  @SWG\Parameter(
     *         name="categoryId",
     *         in="query",
     *         description="categoryId, default -1",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page trips",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="pro_type",
     *         in="query",
     *         description="Tìm kiếm sản phẩm : 0, Tìm kiếm coupon : 2 ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit trips",
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
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    
     public function products($id, Request $req) {
        $user = User::where(['use_id'=>$id])->first();
        if (!$user) {
            return response([
                'msg' => Lang::get('response.user_not_found')
                ], 404);
        }
        $queryShop = Shop::where([]);
        $queryShop->where('sho_user', $id);
        $shop = $queryShop->first();
        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
       
        $query = Product::where([]);
        $query->select('*',DB::raw('af_rate as aff_rate, af_amt as af_amt_ori'),DB::raw(Product::queryDiscountProduct()));
        
        if ($user->use_group == User::TYPE_BranchUser) {
            $query->where('pro_user', $user->use_id);
        } else {
            $listUser = [];
            $listUser = $this->getParentCurrentUser($user, $listUser);
            $query->whereIn('pro_user', $listUser);
        }
        $query->where([
            'pro_status' => Product::STATUS_ACTIVE]);
        $query->orderBy('pro_order','ASC');
        $query->orderBy('pro_id', 'DESC');


        if ($req->categoryId && $req->categoryId != -1) {
            $query->whereIn('pro_category', Category::getAllLevelCategorieById($req->categoryId));
        }
        $product_type = 0;
        if ($req->pro_type) {
            $product_type = $req->pro_type;
        }
        $query->where('pro_type', $product_type);

        if ($req->search) {
            $query->where(function($q) use ($req) {
                $q->orWhere('pro_name', 'LIKE', '%' . $req->search . '%');
                $q->orWhere('pro_descr', 'LIKE', '%' . $req->search . '%');
            });
        }

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $results = $query->paginate($limit, ['*'], 'page', $page);
        $loginUser = $req->user();
 
        //populate shop
        foreach ($results as $value) {
            $value->publicInfo($loginUser, false);
            $value->generateLinks($shop,$loginUser);
            $value->buildPrice($loginUser);

            $value->detailProducts;
            if (!empty($user) && $user->use_id == $value->pro_user) {
                $value->promotions = null;
            } else {
                $value->promotions;
            }
            $value->number_day_saleoff = $value->end_date_sale - $value->begin_date_sale;
            if ($value->number_day_saleoff > 0) {
                $value->number_day_saleoff = round($value->number_day_saleoff / 24 / 3600);
            }
            if ($value->is_product_affiliate == Product::IS_AFF_PRODUCT) {
                if ($value->af_amt > 0) {
                    $seller_affiliate_value = $value->af_amt;
                    $pro_type_affiliate = Product::TYPE_AFFILIATE_CURRENCY;
                } else {
                    $seller_affiliate_value = $value->af_rate;
                    $pro_type_affiliate = Product::TYPE_AFFILIATE_PERCENT;
                }

                if ($value->af_dc_amt > 0) {
                    $pro_type_dc_affiliate = $value['pro_type_dc_affiliate'] = Product::TYPE_AFFILIATE_CURRENCY;
                    $buyer_affiliate_value = $value['buyer_affiliate_value'] = $value->af_dc_amt;
                } else {
                    $pro_type_dc_affiliate = Product::TYPE_AFFILIATE_PERCENT;
                    $buyer_affiliate_value = $value->af_dc_rate;
                }
            } else {
                $pro_type_dc_affiliate = 0;
                $buyer_affiliate_value = 0;
                $seller_affiliate_value = 0;
                $pro_type_affiliate = 0;
            }
            $value->pro_type_dc_affiliate = $pro_type_dc_affiliate;
            $value->buyer_affiliate_value = $buyer_affiliate_value;
            $value->seller_affiliate_value = $seller_affiliate_value;
            $value->pro_type_affiliate = $pro_type_affiliate;
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' =>$results
        ]);
    }
    public function productsv1($id, Request $req) {
        $user = User::where(['use_id'=>$id])->first();
        if (!$user) {
            return response([
                'msg' => Lang::get('response.user_not_found')
                ], 404);
        }
        $queryShop = Shop::where([]);
        if($user->use_group == User::TYPE_AffiliateUser){
            $queryShop->where('sho_user',$user->parent_id);
        }else{
            $queryShop->where('sho_user', $id);
        }
        $shop = $queryShop->first();
        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
      
        $query = Product::where([]);
         $query->where([
            'pro_status' => Product::STATUS_ACTIVE]);
        if ($user->use_group == User::TYPE_AffiliateUser) {
            $listUser = [];
            $parent = $user->parentInfo;
            
            if (!empty($parent)) {
                $listUser = $this->getListParent($parent, $listUser);
            }
 
           
            $query->whereIn('pro_user', $listUser);
            $query->orderBy('pro_id', 'DESC');
        } else {
            $query->where(['pro_user' => $id]);
            $query->where('pro_category', '<>', 0);
            $query->orderBy('begin_date_sale', 'DESC');
        }


        if ($req->categoryId && $req->categoryId != -1) {
            $query->whereIn('pro_category', Category::getAllLevelCategorieById($req->categoryId));
        }
        $product_type = 0;
        if ($req->pro_type) {
            $product_type = $req->pro_type;
        }
        $query->where('pro_type', $product_type);

        if ($req->search) {
            $query->where(function($q) use ($req) {
                $q->orWhere('pro_name', 'LIKE', '%' . $req->search . '%');
                $q->orWhere('pro_descr', 'LIKE', '%' . $req->search . '%');
            });
        }

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $results = $query->paginate($limit, ['*'], 'page', $page);

        //populate shop
        foreach ($results as $value) {
            $value->shop;
            $value->generateLinks($shop);
            $value->buildPrice($req->user());
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' =>$results
        ]);
    }
    
 

    /**
     * @SWG\Get(
     *     path="/api/v1/shop-style",
     *     operationId="shopstyle",
     *     description="Danh sách giao diện",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Lấy giao diện của shop",
     *     @SWG\Response(
     *         response=200,
     *         description="Danh sách giao diện"
     *     )
     * )
     */
    public function getStyle() {
        $syltes = Folder::load(env('AZIBAI_PATH') . '\templates\shop');
        $array = [];
        foreach ($syltes as $keys => $item) {
            if ($syltes[$keys] != 'js') {
                $value = [
                    'value' => $item,
                    'image' => 'templates/home/images/templates/' . $item . '.png'
                ];
                if($item == 'style1' ){
                    $value['name'] = 'Gian hàng 1';
                }
                if($item == 'style2'){
                    $value['name'] = 'Gian hàng 2';
                }
                 if($item == 'style3'){
                    $value['name'] = 'Nhà hàng';
                }
                if($item == 'style4'){
                    $value['name'] = "Khách sạn";
                }
                $array [] = $value;
            }
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $array
        ]);
    }
         /**
     * @SWG\Get(
     *     path="/api/v1/shop-master-rule",
     *     operationId="shopstyle",
     *     description="Danh sách chính sách giang hàng",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Danh sách chính sách giang hàng",
     *     @SWG\Response(
     *         response=200,
     *         description="Danh sách giao diện"
     *     )
     * )
     */
    public function shopMasterRuler(Request $req) {
        $query = ShopRuleMaster::where('type', '<>', 7);
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $results = $query->get();
        $data = [];
        foreach ($results as $result) {
            if (!isset($data[$result->type])) {
                $name = '';
                switch ($result->type) {
                    case 1:
                        $name = 'Thông tin cơ bản';
                        break;
                    case 2:
                        $name = 'Chính sách bảo hành';
                        break;
                    case 3:
                        $name = 'Chính sách đặt hàng, mua hàng';
                        break;
                    case 4:
                        $name = 'Chính sách về sản phẩm khác';
                        break;
                    default:
                        $name = 'Chính sách về sản phẩm khác';
                        break;
                }
                $data[$result->type] = [
                    'name' => $name,
                    "data" => null
                ];
            }
            $data[$result->type]['data'][] = $result;
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' =>   array_values($data)
        ]);
    }
    /**
     * @SWG\Put(
     *     path="/api/v1/me/shop-affiliate",
     *     operationId="update info shop của affliliate",
     *     description="update info shop của affliliate",
     *     produces={"application/json"},
     *     tags={"Profile"},
     *     summary="Cập nhật thông tin shop của affliliate",
     *  @SWG\Parameter(
     *         name="sho_link",
     *         in="body",
     *         description="Đường dẫn website shop tối thiểu 5 kí tự",
     *         required=true,
     *         type="string",
     *  ),
     *  @SWG\Parameter(
     *         name="sho_category",
     *         in="body",
     *         description="Danh mục ngành nghề",
     *         required=true,
     *         type="string",
     *  ),
     *  @SWG\Parameter(
     *         name="sho_name",
     *         in="body",
     *         description="Tên shop",
     *         required=true,
     *         type="string",
     *     ),
     * @SWG\Parameter(
     *         name="sho_descr",
     *         in="body",
     *         description="Mô tả gian hàng",
     *         required=true,
     *         type="string",
     *     ),
     *@SWG\Parameter(
     *         name="sho_address",
     *         in="body",
     *         description="Địa chỉ shop",
     *         required=true,
     *         type="string",
     *     ),
    *@SWG\Parameter(
     *         name="sho_logo",
     *         in="body",
     *         description="Logo của shop",
     *         required=false,
     *         type="string",
     *     ),
    *@  SWG\Parameter(
     *         name="sho_dir_logo",
     *         in="body",
     *         description="Thư mục logo  của shop",
     *         required=false,
     *         type="string",
     *     ),
    *   @SWG\Parameter(
     *         name="sho_banner",
     *         in="body",
     *         description="baner của shop",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_dir_banner",
     *         in="body",
     *         description="Thư mục banner của shop ",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_province",
     *         in="body",
     *         description="TP/ tỉnh",
     *         required=true,
     *         type="integer",
     *     ),
     *@SWG\Parameter(
     *         name="sho_district",
     *         in="body",
     *         description="Quận huyện",
     *         required=true,
     *         type="string",
     *     ),
     * @SWG\Parameter(
     *         name="sho_phone",
     *         in="body",
     *         description="Số điện thoại",
     *         required=false,
     *         type="string",
     *     ),
     *   @SWG\Parameter(
     *         name="shop_fax",
     *         in="body",
     *         description="Fax",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_yahoo",
     *         in="body",
     *         description="Nick yahoo",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_skype",
     *         in="body",
     *         description="Nick skype :",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_style",
     *         in="body",
     *         description="Mau shop :",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_twitter",
     *         in="body",
     *         description="Tài khoản twitter : https://twitter.com/azibai",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_youtube",
     *         in="body",
     *         description="Địa chỉ youtube : https://youtube.com/azibai",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_google_plus",
     *         in="body",
     *         description="Tài khoản google plus : https://plus.google.com/+AzibaiGlobal",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_google_plus",
     *         in="body",
     *         description="Tài khoản Vimeo : https://vimeo.com/azibai",
     *         required=false,
     *         type="string",
     *     ),
     *   @SWG\Parameter(
     *         name="sho_website",
     *         in="body",
     *         description="Website",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="shop_video",
     *         in="body",
     *         description="Video trang chủ",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="thông tin shop"
     *     )
     * )
     */
    
    
    public function affiliateUpdate(Request $req) {
        $validator = Validator::make($req->all(), [
                'sho_link' => 'required|min:5',
                'sho_name' => 'required',
                'sho_descr' => 'required',
                'sho_category' => 'required|integer',
                'sho_cat_style' => 'integer',
                'sho_kho_province' => 'integer'
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $input = $req->all();
      
        unset($input['shop_type']);
        $shop = Shop::where('sho_user', $req->user()->use_id)->first();
        if(empty($shop)){
            return $this->add($input,$req);
        }
        return $this->update($input,$req,$shop);
    }
    protected function add($input, $req) {
        $validatorLink = Validator::make(['sho_link' => $req->sho_link], [
                'sho_link' => 'required'
        ]);
        if ($validatorLink->fails()) {
            return response([
                'msg' => $validatorLink->errors()->first(),
                'errors' => $validatorLink->errors()
                ], 422);
        }
        $data = $input;
        $data['sho_view'] = 1;
        $data['sho_status'] = 1;
        $data['sho_logo'] = isset($input['sho_logo']) ? $input['sho_logo']:'default-logo.png';
        $data['sho_dir_logo'] = isset($input['sho_dir_logo']) ? $input['sho_dir_logo'] : 'defaults';
        $data['sho_banner'] = isset($input['sho_banner']) ? $input['sho_banner'] : 'default-banner.jpg';
        $data['sho_dir_banner'] = isset($input['sho_dir_banner']) ? $input['sho_dir_banner'] : 'defaults';
        $data['sho_province'] = isset($input['sho_province']) ? $input['sho_province'] : 0;
        $data['sho_phone'] = isset($input['sho_phone']) ? $input['sho_phone'] : '';
        $data['sho_email'] = isset($input['sho_email']) ? $input['sho_email'] : '';
        $data['sho_begindate'] = mktime(0, 0, 0, date('m'), date('d'), (int) date('Y') + 20);
        $data['sho_enddate'] = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $data['sho_user'] = $req->user()->use_id;
        $data['sho_style'] = 'default';
        $shop = new Shop($data);
        $shop->save();
        PackageUser::addFreePackage( $req->user(),1);

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $shop
        ]);
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/me/shop-store",
     *     operationId="update info shop",
     *     description="Cap nhật thông tin giang hàng",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Cap nhật thông tin giang hàng",
     *  @SWG\Parameter(
     *         name="sho_link",
     *         in="body",
     *         description="Đường dẫn website shop tối thiểu 5 kí tự",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_category",
     *         in="body",
     *         description="Danh mục ngành nghề",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_name",
     *         in="body",
     *         description="Tên shop",
     *         required=true,
     *         type="string",
     *     ),
     * @SWG\Parameter(
     *         name="sho_descr",
     *         in="body",
     *         description="Mô tả gian hàng",
     *         required=true,
     *         type="string",
     *     ),
     *@SWG\Parameter(
     *         name="sho_address",
     *         in="body",
     *         description="Địa chỉ shop",
     *         required=true,
     *         type="string",
     *     ),
     *@SWG\Parameter(
     *         name="sho_kho_province",
     *         in="body",
     *         description="TP/ tỉnh",
     *         required=true,
     *         type="integer",
     *     ),
     *@SWG\Parameter(
     *         name="sho_kho_district",
     *         in="body",
     *         description="Quận huyện",
     *         required=true,
     *         type="string",
     *     ),
       * @SWG\Parameter(
     *         name="sho_mobile",
     *         in="body",
     *         description="Số điện thoại di động",
     *         required=true,
     *         type="string",
     *     ),
     * @SWG\Parameter(
     *         name="shop_type",
     *         in="body",
     *         description="Số điện thoại di động",
     *         required=true,
     *         type="string",
     *  ),
     * @SWG\Parameter(
     *         name="sho_phone",
     *         in="body",
     *         description="Số điện thoại bàn",
     *         required=false,
     *         type="string",
     *     ),

     *   @SWG\Parameter(
     *         name="shop_fax",
     *         in="body",
     *         description="Fax",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_yahoo",
     *         in="body",
     *         description="Nick yahoo",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_keywords",
     *         in="body",
     *         description="Từ khóa SEO",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_description",
     *         in="body",
     *         description="Mô tả SEO",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_skype",
     *         in="body",
     *         description="Nick skype :",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_twitter",
     *         in="body",
     *         description="Tài khoản twitter : https://twitter.com/azibai",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_youtube",
     *         in="body",
     *         description="Địa chỉ youtube : https://youtube.com/azibai",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_google_plus",
     *         in="body",
     *         description="Tài khoản google plus : https://plus.google.com/+AzibaiGlobal",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_google_plus",
     *         in="body",
     *         description="Tài khoản Vimeo : https://vimeo.com/azibai",
     *         required=false,
     *         type="string",
     *     ),
     *   @SWG\Parameter(
     *         name="sho_website",
     *         in="body",
     *         description="Website",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_video",
     *         in="body",
     *         description="Video trang chủ",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_dir_banner",
     *         in="body",
     *         description="Đường dẫn banner",
     *         required=false,
     *         type="string",
     *     ),
    *  @SWG\Parameter(
     *         name="sho_banner",
     *         in="body",
     *         description="Tên banner",
     *         required=false,
     *         type="string",
     *     ),
    *  @SWG\Parameter(
     *         name="sho_logo",
     *         in="body",
     *         description="Tên logo",
     *         required=false,
     *         type="string",
     *     ),
   *  @SWG\Parameter(
     *         name="sho_dir_logo",
     *         in="body",
     *         description="thư mục logo",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="thông tin shop"
     *     )
     * )
     */
    public function affiliateStoreUser(Request $req){
        $validator = Validator::make($req->all(), [
                'sho_link' => 'required|min:5',
                'sho_name' => 'required',
                'sho_descr' => 'required',
                'shop_type' => 'required',
                'sho_category' => 'required|integer',
                'sho_kho_district'=>'required',
                'sho_kho_province'=>'required|integer',
                'sho_mobile' => 'required',
                'sho_cat_style' => 'integer'
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $input = $req->all();
        $shop = Shop::where('sho_user', $req->user()->use_id)->first();
        if (empty($shop)) {
            return $this->add($input, $req);
        }
        return $this->update($input,$req,$shop);
    }
    protected function update($input,$req,$shop) {
       
        $validatorLink = Validator::make(['sho_link' => $req->sho_link], [
                'sho_link' => [
                    'unique:' . (new Shop)->getTable() . ',sho_link,' . $shop->sho_id . ',sho_id'
                ]
        ]);
        if ($validatorLink->fails()) {
            return response([
                'msg' => $validatorLink->errors()->first(),
                'errors' => $validatorLink->errors()
                ], 422);
        }

        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }

        
        $helper = new Commons();
//        foreach ($input as $key => $value) {
//            if (!in_array($key, ['sho_logo','shop_type', 'sho_dir_logo', 'sho_banner', 'sho_dir_banner','sho_facebook' ,'sho_bgimg', 'sho_user', 'sho_dir_bging'])) {
//                if (!in_array($key, ['sho_category', 'sho_cat_style', 'sho_kho_province', 'sho_district', 'sho_kho_province', 'sho_kho_district'])) {
//                    $input[$key] = trim($helper->injection_html($value));
//                }
//            } else {
//                unset($input[$key]);
//            }
//        }
        try {
            $shop->fill($input);
            $shop->save();
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $shop
            ]);
        } catch (Exception $ex) {
            return response(['msg' => 'SERVER_ERROR'], 500);
        }
    }
   
    public function linkRef(Request $req) {

        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'affiliate' => env('APP_FONTEND_URL') . '/register/affiliate/pid/' . $req->user()->use_id,
                'estore' => env('APP_FONTEND_URL') . '/register/estore/pid/' . $req->user()->use_id,
            ]
            ], 200);
    }
    
     /**
     * @SWG\Put(
     *     path="/api/v1/me/shop-banner",
     *     operationId="update info shop",
     *     description="Cap nhật thông tin giang hàng",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Cap nhật thông tin giang hàng",
     *  @SWG\Parameter(
     *         name="sho_dir_banner",
     *         in="body",
     *         description="Địa chỉ thự mục",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_banner",
     *         in="body",
     *         description="Tên banner",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="thông tin shop"
     *     )
     * )
     */
    
   
    public function updateBanner(Request $req){
       $shop = Shop::where('sho_user', $req->user()->use_id)->first();
        $validatorLink = Validator::make($req->all(), [
                'sho_dir_banner' => 'required',
                'sho_banner' => 'required'
        ]);
        if ($validatorLink->fails()) {
            return response([
                'msg' => $validatorLink->errors()->first(),
                'errors' => $validatorLink->errors()
                ], 422);
        }

        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $shop->sho_dir_banner = $req->sho_dir_banner;
        $shop->sho_banner = $req->sho_banner;
         try {
           
            $shop->save();
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $shop
            ]);
        } catch (Exception $ex) {
            return response(['msg' => 'SERVER_ERROR'], 500);
        }
    }
    
     /**
     * @SWG\Put(
     *     path="/api/v1/me/shop-logo",
     *     operationId="update info logo",
     *     description="Cập nhật logo shop",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Cap nhật thông tin giang hàng",
     *  @SWG\Parameter(
     *         name="sho_dir_logo",
     *         in="body",
     *         description="Địa chỉ thự mục",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_logo",
     *         in="body",
     *         description="Tên logo",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="thông tin shop"
     *     )
     * )
     */

    public function updateLogo(Request $req){
       $shop = Shop::where('sho_user', $req->user()->use_id)->first();
        $validatorLink = Validator::make($req->all(), [
                'sho_dir_logo' => 'required',
                'sho_logo' => 'required'
        ]);
        if ($validatorLink->fails()) {
            return response([
                'msg' => $validatorLink->errors()->first(),
                'errors' => $validatorLink->errors()
                ], 422);
        }

        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $shop->sho_dir_logo = $req->sho_dir_logo;
        $shop->sho_logo = $req->sho_logo;
         try {
           
            $shop->save();
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $shop
            ]);
        } catch (Exception $ex) {
            return response(['msg' => 'SERVER_ERROR'], 500);
        }
      
    }
    /**
     * @SWG\Put(
     *     path="/api/v1/me/shop-info",
     *     operationId="updateShopInfo",
     *     description="updateShopInfo",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Giới thiệu về gian hàng",
     *     @SWG\Parameter(
     *         name="sho_introduction",
     *         in="body",
     *         description="Cập nhật Giới thiệu về gian hàng",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="sho_company_profile",
     *         in="body",
     *         description="Hồ sơ công ty",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="sho_certificate",
     *         in="body",
     *         description="Chứng nhận công nghiệp",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="sho_trade_capacity",
     *         in="body",
     *         description="Năng lực thương mại",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Thông tin shop"
     *     )
     * )
     */
    function shopintro(Request $req) {
        //Remember allow  AffiliateStoreUser , AffiliateUser ,BranchUser
        $shop = Shop::where('sho_user', $req->user()->use_id)->first();
        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $dataEdit = array(
            'sho_introduction' => trim($req->sho_introduction),
            'sho_company_profile' => trim($req->sho_company_profile),
            'sho_certificate' => trim($req->sho_certificate),
            'sho_trade_capacity' => trim($req->sho_trade_capacity),
        );
        $shop->fill($dataEdit);
        $shop->save();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $shop
        ]);
    }
    /**
     * @SWG\Put(
     *     path="/api/v1/me/shop-domain",
     *     operationId="updateDomain",
     *     description="Cấu hình domain",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Cấu hình domain",
     *     @SWG\Parameter(
     *         name="domain",
     *         in="body",
     *         description="domain của gian hàng",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Thông tin shop"
     *     )
     * )
     */
    function domain(Request $req){
     
        #BEGIN: Get shop
        $shop = Shop::where('sho_user', $req->user()->use_id)->first();
        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        
        if ($req->domain) {
            $fileName = env("AZIBAI_PATH") . DIRECTORY_SEPARATOR . "domain.txt";
            $domain = $req->domain;
            if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$/", $domain)) {
                 return response([
                    'msg' => Lang::get('shop.domainInvalid'),
                ],422);
            } 
            $get_ip_domain = gethostbynamel($domain);
    
            foreach ($get_ip_domain as $v) {
                $ip = $v;
                break;
            }
            if ($ip != $_SERVER['SERVER_ADDR']) {
                return response([
                    'msg' => Lang::get('shop.ipnotpoint', ['ip' => $_SERVER['SERVER_ADDR']])
                    ], 422);
            }

            $start = 0;
            if (strpos($domain, ':') > 0) {
                $start = strpos($domain, '/') + 2;
            }
            $domain = substr($domain, $start, strlen($domain));
            $sho_link = $shop->sho_link;
            $strdomain = '';
            foreach (file($fileName) as $key => $values) {
                $arr = explode(' ', $values);
                foreach ($arr as $key => $value) {
//                    tim domain trong domain.txt, thay thế domain
                    if (strpos($value, $domain) !== false) {
                        $strdomain = $arr[$key] . " " . $arr[$key + 1];
                        $thaythe = $domain . " " . $shop->sho_link;
                        if ($key + 1 < count($arr)) {
                            $thaythe .= "\r\n";
                        }
                    }
                    // tim sho_link trong domain.txt, thay the sho_link
                    if (strpos($value, $sho_link) !== false) {
                        $strdomain = $arr[$key - 1] . " " . $shop->sho_link;
                        $thaythe = $domain . " " . $shop->sho_link;
                    }
                }
            }
            $dem = explode(' ', $strdomain);
            if (count($dem) > 1) {
                $contents = file_get_contents($fileName);
                $contents = str_replace($strdomain, $thaythe, $contents);
                file_put_contents($fileName, $contents);
            } else {
                $fp = fopen($fileName, 'a+') or die("can't open file");
                $str = "\r\n" . $domain . " " . $shop->sho_link;
                fwrite($fp, $str);
                fclose($fp);
            }
            $shop->domain = $domain;
            $shop->save();
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $shop
        ]);
    }
     /**
     * @SWG\Put(
     *     path="/api/v1/me/shop-warranty",
     *     operationId="updatewarranty",
     *     description="Chính sách bảo hành",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Chính sách bảo hành",
     *     @SWG\Parameter(
     *         name="sho_warranty",
     *         in="body",
     *         description="Chính sách bảo hành",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Thông tin shop"
     *     )
     * )
     */
    function warranty(Request $req) {
        //AffiliateStoreUser //AffiliateUser
        $shop = Shop::where('sho_user', $req->user()->use_id)->first();
        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        if ($req->sho_warranty) {
            $shop->sho_warranty = $req->sho_warranty;
            $shop->save();
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $shop
        ]);
    }
     /**
     * @SWG\Put(
     *     path="/api/v1/me/shop-rule",
     *     operationId="updateshoprule",
     *     description="Chính sách gian hàng",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Chính sách gian hàng",
     *     @SWG\Parameter(
     *         name="shop_rule_ids",
     *         in="body",
     *         description="ID cách chính sách gian hàng cách nhau bằng dầu ','",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Thông tin shop"
     *     )
     * )
     */
    function updateRule(Request $req) {
        //AffiliateStoreUser //AffiliateUser
        $query = Shop::where(['sho_user' => $req->user()->use_id, 'sho_status' => Shop::STATUS_ACTIVE]);
        $shop = $query->where('sho_enddate', '>=', strtotime(date('Y-m-d')))->first();
        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $shopRule = $shop->rule;
        if ($req->sho_warranty) {
            $shop->sho_warranty;
            $shop->save();
        }
        if ($req->shop_rule_ids) {
            if (count($shopRule) != 1) {
                $dataAdd = ['sho_id' => (int) $shop->sho_id, 'shop_rule_ids' => $req->shop_rule_ids,'up_date'=>date('Y-m-d H:i:s')];
                $shopRule = new ShopRule($dataAdd);
                $shopRule->save();
            } else {

                $shopRule->shop_rule_ids = $req->shop_rule_ids;
                $shopRule->up_date = date('Y-m-d H:i:s');
                $shopRule->save();
            }
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $shopRule
        ]);
    }
     /**
     * @SWG\Get(
     *     path="/api/v1/me/shop-rule",
     *     operationId="shoprule",
     *     description="danh sách chính sách của shop đã chọn",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Danh sách chính sách của shop đã chọn",
  
     *     @SWG\Response(
     *         response=200,
     *         description="Danh sách chính sách của shop đã chọn"
     *     )
     * )
     */
    public function myRule(Request $req) {
        $query = Shop::where(['sho_user' => $req->user()->use_id, 'sho_status' => Shop::STATUS_ACTIVE]);
        $shop = $query->where('sho_enddate', '>=', strtotime(date('Y-m-d')))->first();
       
        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $shopRule = ShopRule::where(['sho_id' => $shop->sho_id])->get();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $shopRule
        ]);
    }
     /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/shop/rule",
     *     operationId="userShopRule",
     *     description="Danh sách chính sách của 1 shop đã chọn",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Danh sách chính sách của 1 shop đã chọn",
  
     *     @SWG\Response(
     *         response=200,
     *         description="Danh sách chính sách của shop đã chọn"
     *     )
     * )
     */
    public function shopRule($id,Request $req){
        $query = Shop::where(['sho_user' => $id, 'sho_status' => Shop::STATUS_ACTIVE]);
        $shop = $query->where('sho_enddate', '>=', strtotime(date('Y-m-d')))->first();

        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $shopRule = ShopRule::where(['sho_id' => $shop->sho_id])->get();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $shopRule
        ]);
    }
    /**
     * @SWG\Get(
     *     path="/api/v1/me/shop-supplier",
     *     operationId="supplier",
     *     description="Sản phẩm nhà cung cấp sĩ lẽ",
     *     produces={"application/json"},
     *     tags={"Shop"},
     *     summary="Sản phẩm nhà cung cấp sĩ lẽ",
     *     @SWG\Parameter(
     *         name="from",
     *         in="query",
     *         description="Giá từ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="to",
     *         in="query",
     *         description="Giá đến",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="keywords",
     *         in="query",
     *         description="Từ khóa",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="category",
     *         in="query",
     *         description="tìm theo category",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Nhà cung cấp"
     *     )
     * )
     */
    public function supplier(Request $req) {
        $shop = Shop::where('sho_user', $req->user()->use_id)->first();
        if (!$shop) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
//        $categories = Category::where(['parent_id' => 0, 'cat_status', 1, 'cat_type' => 0]);
//        if (isset($categories) && count($categories) > 0) {
//            foreach ($categories as $category) {
//                $cat_level_1 = $category->child;
//                $category['child_count'] = count($cat_level_1);
//            }
//        }
        $productdb = Product::tableName();
        $shopdb = Shop::tableName();
        $productPromotiondb = ProductPromotion::tableName();
        $query = Product::where(['pro_status' => Product::STATUS_ACTIVE]);
        $query->where('pro_minsale', '>=', 1);
        $catName = '(SELECT `cat_name` FROM `tbtt_category` WHERE `cat_id` = tbtt_product.`pro_category` ORDER BY tbtt_product.`pro_category` DESC) as cName ';
        $select = 'tbtt_product.`pro_id`
                  ,tbtt_product.`pro_name`
                  ,tbtt_product.`pro_cost`
                  ,tbtt_product.`pro_dir`
                  ,tbtt_product.`pro_image`
                  ,tbtt_product.`pro_category`
                  ,tbtt_product.`pro_user`
                  ,tbtt_shop.`sho_link`
                  ,tbtt_shop.`sho_name`';
        $query->select(DB::raw($select));
        $query->join($shopdb, $productdb . '.pro_user', $shopdb . '.sho_user');
        $query->join($productPromotiondb, $productdb . '.pro_id', $productPromotiondb . '.pro_id');
        $query->groupBy($productdb . '.pro_id');
        
        $query->where('pro_user', '<>', $req->user()->use_id);
        $query->where($shopdb . '.shop_type', '>=', 1);
         if ($req->from > 0) {
            $query->where($productdb . '.pro_cost', '>=', $req->from);
        }
        if ($req->to > 0) {
            $query->where($productdb . '.pro_cost', '<=', $req->to);
        }
        if (trim($req->keywords) != '') {
            $searchString = trim($req->keywords);
            $query->where(function($q) use($searchString,$productdb, $shopdb) {
                $q->orWhere($productdb . '.pro_name', 'LIKE', '%' . $searchString . '%');
                $q->orWhere($shopdb . '.sho_link', 'LIKE', '%' . $searchString . '%');
                $q->orWhere($shopdb . '.sho_name', 'LIKE', '%' . $searchString . '%');
            });
        }

        if ($req->category > 0) {
             $query->where($productdb . '.pro_category', $req->category);
        }
            $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $products = $query->paginate($limit, ['*'], 'page', $page);
        foreach ($products as $row) {
            $row->category;
            $row->shop;
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $products
        ]);
    }
    
     function get_id_shop_in_tree($user) {
        #Get user
        $id_my_parent = '';
  
        if ($user->use_group != User::TYPE_AffiliateUser || $user->use_status != User::STATUS_ACTIVE) {
            return $id_my_parent;
        }
        $parent = $user->parentActiveInfo;

        if (empty($parent)) {
            return $user->parent_shop;
        }
        
        if ($parent->use_group == User::TYPE_AffiliateStoreUser || $parent->use_group == User::TYPE_BranchUser) {
            $id_my_parent = $parent->use_id;
         
        } else if ($parent->use_group == 11 || $parent->use_group == User::TYPE_StaffStoreUser) {
            $parent_parent = $parent->parentActiveInfo;
            if (!empty($parent_parent) && ($parent_parent->use_group == User::TYPE_AffiliateStoreUser || $parent_parent->use_group == User::TYPE_BranchUser)) {
                $id_my_parent = $parent->use_id;
            }
        } else {

            return $user->parent_shop;
        }

        return $id_my_parent;
    }
    function get_shop_nearest($userId) {
        #Get user
        $idShop = $userId;
        $user = User::where(['use_id' => $userId, 'use_group' => User::TYPE_AffiliateUser, 'use_status' => User::STATUS_ACTIVE])->first();
        if (empty($user)) {
            return $idShop;
        }
        $parent = $user->parentActiveInfo;
        if (empty($parent)) {
            return $user->parent_shop;
        }
        if (in_array($parent->use_group, [User::TYPE_AffiliateStoreUser, User::TYPE_BranchUser])) {
            return $parent->use_id;
        }
        if (in_array($parent->use_group, [User::TYPE_StaffUser, User::TYPE_StaffStoreUser])) {
            $parent_p = $parent->parentActiveInfo;
            if (empty($parent_p)) {
                return $idShop;
            }
            return $parent_p->use_id;
        }
        return $idShop;
    }

    function getListParent($userParent,$list) {
        switch ($userParent->use_group) {
            case User::TYPE_StaffUser :
                $ucn = $userParent->parent_id;
                $list[] = $ucn;
                $user_cn = $userParent->parentInfo;
                if(!empty($user_cn)){
                    $parent = $user_cn->parentInfo;
                    if (!empty($parent)) {
                        if ($parent->use_group == User::TYPE_AffiliateStoreUser) {
                            $ush = $parent->use_id;
                        } else {
                            $ush = $parent->parent_id;
                        }
                    }
                    $list[] = $ush;
                }
              
                break;
            case User::TYPE_BranchUser:
                $ucn = $userParent->use_id;
                $list[] = $ucn;
                $parent = $userParent->parentInfo;
                if (!empty($list)) {
                    if ($parent->use_group == 3) {
                        $ush = $parent->use_id;
                    } else {
                        $ush = $parent->parent_id;
                    }
                    $list [] = $ush;
                }
                break;
            case User::TYPE_StaffStoreUser:
                $ush = $userParent->parent_id;
                $list[] = $ush;
                break;
            case User::TYPE_AffiliateStoreUser:
                $ush = $userParent->use_id;
                $list[] = $ush;
                break;
            case 1: //NormalUser
            case 6: //Developer2User
            case 7: //Developer1User
            case 8: //Partner2User
            case 9: //Partner1User
            case 10: //CoreMemberUser
            case 12: //CoreAdminUser   

                break;
        }
        return $list;
    }

}