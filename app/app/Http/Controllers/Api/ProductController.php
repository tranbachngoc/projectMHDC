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
use App\Models\ProductAffiiate;
use App\Models\PackageUser;
use App\Models\Package;
use App\Models\PackageInfo;

class ProductController extends ApiController {

    /**
     * @SWG\Get(
     *     path="/api/v1/products",
     *     operationId="list-products",
     *     description="Danh sach Sản Phẩm",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Danh sach sản Phẩm",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="categoryId",
     *         in="query",
     *         description="categoryId, default -1",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_type",
     *         in="query",
     *         description="kiểu sản phẩm là 1 , 2 là coupon",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="from_price",
     *         in="query",
     *         description="Giá từ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="to_price",
     *         in="query",
     *         description="Giá từ",
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
     *     @SWG\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="orderBy , hỗ trợ các trường trả về , news : mới nhất, discount: giảm giá, bestSeller: bán hàng chạy ,guarantee: gian hàng đảm bảo",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function index(Request $req) {
        $user = $req->user();
        $select = 'tbtt_product.*,pro_minsale,pro_buy,'
                . ' pro_id, pro_user, pro_buy, af_amt, af_rate,af_rate as aff_rate, af_amt as af_amt_ori,dc_amt, dc_rate,  pro_cost,'
                . ' is_product_affiliate,' . Product::queryDiscountProduct().','.Product::selelectSafePrice().' as priceAfterSale';
        $query = Product::where('pro_category', '<>', 0)
            ->where('pro_status', Product::STATUS_ACTIVE);

        if ($req->categoryId && $req->categoryId != -1) {
            $query->whereIn('pro_category', Category::getAllLevelCategorieById($req->categoryId));
        }
        if ($req->pro_type) {
            $query->where('pro_type', $req->pro_type);
        } else {
            $query->where('pro_type', 0);
        }
        
        if ($req->from_price) {
            $query->where(function($q) use($req) {
                $q->orWhereRaw(Product::selelectSafePrice(). ' >= '. $req->from_price);
            });
        }
        if($req->to_price){
             $query->where(function($q) use($req){
                $q->orWhereRaw(Product::selelectSafePrice().' <= '.$req->to_price);
            });
        }
        $bindings = $query->getBindings();
        $sql = $query->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sql = str_replace('\\', '\\\\', $sql);
      

      

        if ($req->search) {
            $query->where(function($q) use ($req) {
                $q->orWhere('pro_name', 'LIKE', '%' . $req->search . '%');
                //$q->orWhere('pro_descr', 'LIKE', '%' . $req->search . '%');
            });
        }
        $shopdb = Shop::tableName();
        $productdb = Product::tableName();
        if (!empty($req->orderBy)) {

            $req->orderBy = explode(',', $req->orderBy);
            $key = $req->orderBy[0];
            $value = isset($req->orderBy[1]) ? $req->orderBy[1] : 'DESC';
            if ($key == 'pro_cost') {
                $key = 'priceAfterSale';
            }
            switch ($key) {
                case "news":
                    $key = 'pro_id';
                    break;
                case "discount":
                    $key = 'pro_saleoff';
                    break;
                case "bestSeller":
                    $key = 'pro_buy';
                    break;
                case "guarantee":
                    break;
                default:
                    break;
            }
            if ($key == 'guarantee') {
                $select = $select .','. $shopdb . '.sho_guarantee';
                $query->leftJoin($shopdb, $shopdb . '.sho_user', $productdb . '.pro_user');
                $query->orderBy($shopdb . '.sho_guarantee', 'DESC');
            
                $query->orderBy('pro_id', 'DESC');
            } else {
                $query->orderBy($key, $value);
            }
        } else {
            $query->orderBy('pro_id', 'DESC');
        }
        $query->select(DB::raw($select));
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $results = $query->paginate($limit, ['*'], 'page', $page);
       
        //populate shop
        foreach ($results as $value) {
            $value->publicInfo($req->user());
            $value->buildPrice($req->user());
            $value->detailProducts;
            if (!empty($user) && $user->use_id == $value->pro_user) {
                $value->promotions = null;
            } else {
                $value->promotions;
            }
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/products",
     *     operationId="list-my-products",
     *     description="Danh sach Sản Phẩm / coupon của tôi",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Danh sach news",
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
     *         name="pro_type",
     *         in="query",
     *         description="Lấy sản phẩm 0 (default) , lấy coupon : 2",
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
    public function myProduct(Request $req) {
        $condition = ['pro_user' => $req->user()->use_id, 'pro_type' => 0];
        if (!empty($req->pro_type)) {
            $condition['pro_type'] = $req->pro_type;
        }
        $query = Product::where($condition);
        if (empty($req->orderBy)) {
            $query->orderBy('pro_order', 'ASC')->orderBy('pro_id', 'DESC');
        }
//        if ($req->categoryId && $req->categoryId != -1) {
//            $query->whereIn('pro_category', Category::getAllLevelCategorieById($req->categoryId));
//        }
//
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
//            $value->publicInfo($req->user());
//            $value->buildPrice($req->user());
            $value->isBracndSelected($req->user());
            
            $value->category;
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/products/{id}",
     *     operationId="productDetail",
     *     description="get list logs online offline of driver",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Lấy detail của Sản Phẩm",
     *  @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="product id",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="af_key",
     *         in="path",
     *         description="key afflilate của shop",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function detail($id, Request $req) {
        $product = Product::select(DB::raw('tbtt_product.*,(tbtt_product.af_rate) AS aff_rate,pro_minsale, pro_id, pro_user, pro_buy, af_amt, af_rate, dc_amt, dc_rate,  pro_cost, is_product_affiliate,' . Product::queryDiscountProduct()))->find($id);
        if (!$product) {
            return response([
                'msg' => Lang::get('response.product_not_found')
                ], 404);
        }
        
        //Populate category
        $product->detailProducts;
        $user = $req->user();
        $product->publicInfo($req->user());

        if (!empty($user) && $user->use_id == $product->pro_user) {
            $product->promotions = null;
        } else {
            $product->promotions;
        }
        if (!empty($product->shop)) {
            $product->shop->publicInfo();
        }
        $product->buildPrice($req->user(), $req->af_key);
        $product->category;

        $related = Product::where("pro_category",$product->pro_category)->inRandomOrder()->get()->take(10);
        $product->related_products = $related;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $product
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/products/{id}",
     *     operationId="productDetail",
     *     description="Lấy chi tiết sản phẩm của tôi",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Lấy chi tiết sản phẩm của tôi",
     *  @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="product id",
     *         required=true,
     *         type="integer",
     *  ),
     *  @SWG\Parameter(
     *         name="pro_type",
     *         in="body",
     *         description="Kiểu sản phẩm , 0:Sp, 1: service, 2: Coupon",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function myProductDetail($id, Request $req) {
        $condition = ['pro_id' => $id, 'pro_user' => $req->user()->use_id, 'pro_type' => 0];
        if (isset($req->pro_type)) {
            $condition['pro_type'] = $req->pro_type;
        }
        $product = Product::where($condition)->first();
        if (!$product) {
            return response([
                'msg' => Lang::get('response.product_not_found')
                ], 404);
        }
        $category = $product->category;
        $product->detailProducts;
        $product->promotionsProduct;
        $product->number_day_saleoff = $product->end_date_sale - $product->begin_date_sale;
        if ($product->number_day_saleoff > 0) {
            $product->number_day_saleoff = round($product->number_day_saleoff / 24 / 3600);
        }
        if ($product->is_product_affiliate == Product::IS_AFF_PRODUCT) {
            if ($product->af_amt > 0) {
                $seller_affiliate_value = $product->af_amt;
                $pro_type_affiliate = Product::TYPE_AFFILIATE_CURRENCY;
            } else {
                $seller_affiliate_value = $product->af_rate;
                $pro_type_affiliate = Product::TYPE_AFFILIATE_PERCENT;
            }

            if ($product->af_dc_amt > 0) {
                $pro_type_dc_affiliate = $product['pro_type_dc_affiliate'] = Product::TYPE_AFFILIATE_CURRENCY;
                $buyer_affiliate_value = $product['buyer_affiliate_value'] = $product->af_dc_amt;
            } else {
                $pro_type_dc_affiliate = Product::TYPE_AFFILIATE_PERCENT;
                $buyer_affiliate_value = $product->af_dc_rate; 
           }
        } else {
            $pro_type_dc_affiliate = 0;
            $buyer_affiliate_value = 0;
            $seller_affiliate_value = 0;
            $pro_type_affiliate = 0;
        }
        $product['pro_type_dc_affiliate'] = $pro_type_dc_affiliate;
        $product['buyer_affiliate_value'] = $buyer_affiliate_value;
        $product['seller_affiliate_value'] = $seller_affiliate_value;
        $product['pro_type_affiliate'] = $pro_type_affiliate;
        $product['cat_level_0'] = null;
        $product['cat_level_1'] = null;
        $product['cat_level_2'] = null;
        $product['cat_level_3'] = null;
        $product['cat_level_4'] = null;
        switch ($category->cat_level) {
            case '1':
                $product['cat_level_1'] = $category->toArray();
                $product['cat_level_0'] = $category->parentCateActive;
                break;

            case '2':
                $product['cat_level_2'] = $category->toArray();
                $level1 = $category->parentCateActive;
                if (!empty($level1)) {
                    $product['cat_level_1'] = $level1->toArray();
                    $level0 = $level1->parentCateActive;
                    $product['cat_level_0'] = $level0;
                }

                break;
            case '3':
                $product['cat_level_3'] = $category->toArray();
                $level2 = $category->parentCateActive;
                if (!empty($level2)) {
                    $product['cat_level_2'] = $level2->toArray();
                    $level1 = $level2->parentCateActive;
                    if (!empty($level1)) {
                        $product['cat_level_1'] = $level1->toArray();
                        $level0 = $level1->parentCateActive;
                        $product['cat_level_0'] = !empty($level0) ? $level0->toArray() : null;
                    }
                }


                break;
            case '4':
                $product['cat_level_4'] = $category->toArray();
                $level3 = $category->parentCateActive;
                if (!empty($level3)) {
                    $product['cat_level_3'] = $level3->toArray();
                    $level2 = $level3->parentCateActive;
                    if (!empty($level2)) {
                        $product['cat_level_2'] = $level2->toArray();
                        $level1 = $level2->parentCateActive;
                        if (!empty($level1)) {
                            $product['cat_level_1'] = $level1->toArray();
                            $level0 = $level1->parentCateActive;
                            if (!empty($level0)) {
                                $product['cat_level_0'] = $level0->toArray();
                            }
                        }
                    }
                }

                break;
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $product
        ]);
    }

    /**
     * @SWG\Post(
     *     path="/api/v1/products",
     *     operationId="productDetail",
     *     description="Tạo Sản Phẩm",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Tạo Sản Phẩm",
     *  @SWG\Parameter(
     *         name="pro_category",
     *         in="body",
     *         description="Danh mục sản phẩm truyền category cuối cùng chọn",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_keyword",
     *         in="body",
     *         description="Từ khóa tìm kiếm",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_name",
     *         in="body",
     *         description="Tên sản phẩm",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_sku",
     *         in="body",
     *         description="Mã sản phẩm",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_descr",
     *         in="body",
     *         description="Mô tả ngắn",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_cost",
     *         in="body",
     *         description="Giá bán",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_currency",
     *         in="body",
     *         description="Tiền tệ - default là VND.Yêu cầu bắt buộc khi sản phẩm này chọn sale off",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_saleoff_value",
     *         in="body",
     *         description="Giá trị khuyến mãi. Yêu cầu bắt buộc khi sản phẩm này chọn sale off",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_type_saleoff",
     *         in="body",
     *         description="Khuyến mãi theo phần trăm hay bằng tiền mặt . Phần trăm là 1 , Tiền mặt là 2 .  Yêu cầu bắt buộc khi sản phẩm này chọn sale off",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_saleoff",
     *         in="body",
     *         description="Có khuyến mãi hay không ? Có thì set  = 1",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="begin_date_sale",
     *         in="body",
     *         description="Ngày áp dụng format Y-m-d",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="number_day_saleoff",
     *         in="body",
     *         description="Số ngày áp dụng safe off // Yêu cầu bắt buộc khi sản phẩm này chọn sale off",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_image",
     *         in="body",
     *         description="Ảnh đại diện của sản phẩm , request lên server 1 chuỗi vd hinh1.jpg,hinh2.png ",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_minsale",
     *         in="body",
     *         description="Số lượng bán sĩ tối thiểu",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_instock",
     *         in="body",
     *         description="Số lượng trong kho",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_length",
     *         in="body",
     *         description="Chiều dài sản phẩm",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_width",
     *         in="body",
     *         description="Chiều rộng sản phẩm",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_height",
     *         in="body",
     *         description="Chiều cao sản phẩm",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_made_from",
     *         in="body",
     *         description="Xuất xứ sản phẩm 1: Chính hãng,2: Xách tay, 3:Hàng công ty",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="is_product_affiliate",
     *         in="body",
     *         description="Là sản phẩm đại lý online ? 1 là có ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_type_affiliate",
     *         in="body",
     *         description="Nhập tiền hoa hồng theo % hoặc tiền VND, 1 là % , 2 là tiền",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="seller_affiliate_value",
     *         in="body",
     *         description="Đây là tiền người bán sản phẩm sẽ được hưởng dựa trên giá bán gốc ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_type_dc_affiliate",
     *         in="body",
     *         description="Nhập tiền hoa hồng theo % hoặc tiền VND  1 là % , 2 là tiền",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="buyer_affiliate_value",
     *         in="body",
     *         description="Đây là tiền người mua được giảm dựa trên giá bán gốc",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_mannufacurer",
     *         in="body",
     *         description="Nhà sản xuất ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="mannufacurer_name",
     *         in="body",
     *         description="Tên nhà sản xuất khác ",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_type",
     *         in="body",
     *         description="Sản phẩm bình thường or coupon , Trường này mọi người truyền lên là 0 dùm , sau này sẽ update truyền 2 đối vs coupon",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_vat",
     *         in="body",
     *         description="Đã bao gồm vat hay chưa, 1: Đã bao gồm vat, 2 Chưa bao gồm vat",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_vat",
     *         in="body",
     *         description="Đã bao gồm vat hay chưa, 1: Đã bao gồm vat, 2 Chưa bao gồm vat",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_quality",
     *         in="body",
     *         description="Tình trạng sản phẩm 0: mới , 1: Cũ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_warranty_period",
     *         in="body",
     *         description="Số tháng báo hành",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_link_youtube",
     *         in="body",
     *         description="Liên kết youtube",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_weight",
     *         in="body",
     *         description="Cân nặng",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_detail",
     *         in="body",
     *         description="pro_detail",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products",
     *         in="body",
     *         description="Qui cách sản phẩm",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_size",
     *         in="body",
     *         description="Kích thước",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_color",
     *         in="body",
     *         description="Màu sắc",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_material",
     *         in="body",
     *         description="Chất liệu",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_cost",
     *         in="body",
     *         description="Giá //Bắt buộc khi có yêu cầu điền qui cách",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_images",
     *         in="body",
     *         description="Hình ảnh qui cách //Bắt buộc khi có yêu cầu điền qui cách",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_instock",
     *         in="body",
     *         description="Số lượng //Bắt buộc khi có yêu cầu điền qui cách",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_note",
     *         in="body",
     *         description="Số lượng //Bắt buộc khi có yêu cầu điền qui cách",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="promotions_product.*.limit_type",
     *         in="body",
     *         description="Giảm theo số lượng : 1 , Giảm theo Số tiền : 2",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="promotions_product.*.type_amount",
     *         in="body",
     *         description="Tiền :1, Phần trăm : 2",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="promotions_product.*.limit_from",
     *         in="body",
     *         description="chiếc khấu từ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="promotions_product.*.limit_to",
     *         in="body",
     *         description="chiếc khấu đến",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="promotions_product.*.amount",
     *         in="body",
     *         description="Số tiền giảm",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_dir",
     *         in="body",
     *         description="Thư mục upload hình ảnh",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function create(Request $req) {
        $user = $req->user();
        $shop = Shop::where('sho_user', $user->use_id)->first();
        if (empty($shop)) {
            return response([
                'msg' => Lang::get('shop.not_install')
                ], 401);
        }
        if ($user->use_group == User::TYPE_BranchUser) {
            $issAllow = $this->checkConfigBranch($user);
            if (!$issAllow) {
                return response([
                    'msg' => Lang::get('response.brand_cannot_create_product')
                    ], 401);
            }
        }
        $all = $req->all();
        $validatorAtt = [
            'pro_type' => 'required|in:0,1,2', //0: default, 1: service, 2: coupon
            'pro_category' => 'required',
            'pro_name' => 'required|max:100',
            'pro_sku' => 'required|max:35',
            'pro_descr' => 'required|max:100',
            'pro_keyword' => 'string|max:255',
            'pro_detail' => 'required',
            'pro_cost' => 'required|max:11',
            'pro_currency' => 'required',
            'pro_vat' => 'required',
            'pro_quality' => 'required|max:11',
            'pro_weight' => 'required|max:11',
            'pro_image' => 'required',
            'pro_made_from' => 'required',
            'pro_dir' => 'required',
            'pro_instock'=>'max:11',
            'detail_products' => 'array',
        ];
        if ($req->pro_type == Product::TYPE_COUPON) {
            unset($req->pro_made_from);
        }
        $validator = Validator::make($all, $validatorAtt);


        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        if (!empty($req->detail_products)) {
            $validator = Validator::make($all, [
                    'detail_products.*.dp_images' => 'required', //0: default, 1: service, 2: coupon
                    'detail_products.*.dp_cost' => 'required|max:11',
                    'detail_products.*.dp_instock' => 'required|max:11',
            ]);
            if ($validator->fails()) {
                return response([
                    'msg' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                    ], 422);
            }
        }
        $helper = new Commons();
        $pro_reliable = 0;
        $price = 0;
        $af_amt = 0;
        $af_dc_rate = 0;
        $af_dc_amt = 0;
        $currency = 'VND';
        $begin_date = 0;
        $promotion_expiry = 0;

        if ($user->use_group == User::TYPE_AffiliateStoreUser) {
            $pro_reliable = 1;
        }
        if (!$req->pro_no_cost) {
            $price = $req->pro_cost;
        }

        DB::beginTransaction();
        try {
            $manufacturecusom = 0;
            if ($req->pro_mannufacurer == "other" && $req->mannufacurer_name != "") {
                $manufacture = Manufacture::create([
                        'man_name' => $helper->injection_html($req->mannufacurer_name),
                        'man_status' => 0,
                        'man_id_category' => $req->man_id_category
                ]);
                if ($manufacture->save()) {
                    $manufacturecusom = $manufacture->id;
                }
            } else {
                $manufacturecusom = $req->pro_mannufacurer ? $req->pro_mannufacurer : 0;
            }

            // Là sản phẫm đại lý online
            $af_rate = 0;
            if ($req->is_product_affiliate) {
                //Kiểu hoa hồng là %
                if ($req->pro_type_affiliate == Product::TYPE_AFFILIATE_PERCENT) {
                    $af_rate = $req->seller_affiliate_value ? $req->seller_affiliate_value: 0;
                } else {
                    //Kiểu hoa hồng là tiền
                    $af_amt = $req->seller_affiliate_value ? $req->seller_affiliate_value : 0;
                }
                if ($req->pro_type_dc_affiliate == Product::TYPE_AFFILIATE_PERCENT) {
                    $af_dc_rate = $req->buyer_affiliate_value ? $req->buyer_affiliate_value : 0;
                } else {
                    $af_dc_amt = $req->buyer_affiliate_value ? $req->buyer_affiliate_value :0;
                }
            }

            // La sp khuyến mãi
            if (!empty($req->pro_saleoff)) {
                if (!empty($req->begin_date_sale)) {
                    $begin_date = date('Y-m-d', !is_numeric($req->begin_date_sale) ? strtotime($req->begin_date_sale) : $req->begin_date_sale);
                } else {
                    $begin_date = date('Y-m-d', time());
                }
                $add_days = (int) $req->number_day_saleoff;
                $promotion_expiry = strtotime($begin_date . ' +' . $add_days . ' days');
            }
            $shop = Shop::where(['sho_user' => $req->user()->use_id])->first();
            $dataPost = [
                'pro_name' => trim($helper->injection_html($req->pro_name)),
                'pro_sku' => trim($helper->injection_html($req->pro_sku)),
                'pro_descr' => trim($helper->injection_html($helper->clear($req->pro_descr))),
                'pro_keyword' => trim($helper->injection_html($helper->clear($req->pro_keyword))),
                'pro_cost' => $price,
                'pro_currency' => $currency,
                'pro_hondle' => isset($req->pro_hondle) ? $req->pro_hondle : 0, // giá tham khảo
                'pro_saleoff' => isset($req->pro_saleoff) ? $req->pro_saleoff : 0,
                'pro_province' => (int) $shop->sho_province,
                'pro_category' => (int) $req->pro_category,
                'pro_begindate' => time(),
                'pro_enddate' => time(),
                'pro_detail' => trim(str_replace("&curren;", "#", $req->pro_detail)),
                'pro_image' => $req->pro_image,
                'pro_dir' => $req->pro_dir,
                'pro_user' => $req->user()->use_id,
                'pro_poster' => trim($helper->injection_html($req->pro_poster)),
                'pro_address' => trim($helper->injection_html($req->pro_address)),
                'pro_phone' => trim($helper->injection_html($req->pro_phone)),
                'pro_mobile' => trim($helper->injection_html($req->pro_mobile)),
                'pro_email' => trim($helper->injection_html($req->pro_email)),
                'pro_yahoo' => trim($helper->injection_html($req->pro_yahoo)),
                'pro_skype' => trim($helper->injection_html($req->pro_skype)),
                'pro_status' => 1,
                'pro_view' => 0,
                'pro_buy' => 0,
                'pro_comment' => 0,
                'pro_vote_cost' => 0,
                'pro_vote_quanlity' => 0,
                'pro_vote_model' => 0,
                'pro_vote_service' => 0,
                'pro_vote_total' => 0,
                'pro_vote' => 0,
                'pro_reliable' => $pro_reliable,
                'pro_saleoff_value' => $req->pro_saleoff_value ? trim($helper->injection_html($req->pro_saleoff_value)) : 0,
                'is_product_affiliate' => $req->is_product_affiliate ? trim($req->is_product_affiliate) : 0,
                'af_amt' => $af_amt,
                'af_rate' => $af_rate,
                'af_dc_amt' => $af_dc_amt,
                'af_dc_rate' => $af_dc_rate,
                'pro_show' => (int) $req->pro_show,
                'pro_type_saleoff' => $req->pro_type_saleoff ? trim($helper->injection_html($req->pro_type_saleoff)) : 0,
                'pro_manufacturer_id' => $manufacturecusom,
                'pro_instock' => $req->pro_instock ? trim($helper->injection_html($req->pro_instock)) : 0,
                'pro_weight' => trim($helper->injection_html($req->pro_weight)),
                'pro_length' => $req->pro_length ? trim($helper->injection_html($req->pro_length)) : 0,
                'pro_width' => $req->pro_width ? trim($helper->injection_html($req->pro_width)) : 0,
                'pro_height' => $req->pro_height ? trim($helper->injection_html($req->pro_height)) : 0,
                'pro_minsale' => $req->pro_minsale,
                'pro_vat' => $req->pro_vat,
                'pro_quality' => $req->pro_quality,
                'pro_made_from' => $req->pro_made_from,
                'pro_warranty_period' => $req->pro_warranty_period ? trim($helper->injection_html($req->pro_warranty_period)) : 0,
                'pro_video' => trim($helper->injection_html($req->pro_link_youtube)),
                'created_date' => date("Y-m-d"),
                'begin_date_sale' => strtotime($begin_date) ? strtotime($begin_date) : 0,
                'end_date_sale' => $promotion_expiry,
                'up_date' => date('Y-m-d')
            ];

            $product = new Product($dataPost);
            $product->pro_type = isset($req->pro_type) ? $req->pro_type : 0;
            $product->save();

            //Lưu trữ trường quy cách
            if (is_array($req->detail_products) && sizeof($req->detail_products) > 0) {
                $detailsProducts = [];
                foreach ($req->detail_products as $detail) {
                    $detail['dp_pro_id'] = $product->pro_id;
                    $detailsProducts[] = $detail;
                }

                DetailProduct::insert($detailsProducts);
            }
            if (!empty($req->promotions_product)) {
                $promotions = [];

                foreach ($req->promotions_product as $promotion) {

                    if ($promotion['type_amount'] == ProductPromotion::TYPE_AMOUNT_MONEY) {
                        $promotion['dc_amt'] = $promotion['amount'];
                        $promotion['dc_rate'] = 0;
                    } else {
                        $promotion['dc_rate'] = $promotion['amount'];
                        $promotion['dc_amt'] = 0;
                    }
                    $promotion['pro_id'] = $product->pro_id;
                    unset($promotion['amount']);
                    unset($promotion['type_amount']);
                    $promotions[] = $promotion;
                }

                $result = ProductPromotion::insert($promotions);
            }

            DB::commit();
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $product
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::Error($e);

            return response(['msg' => Lang::get('response.server_error'), 'error' => $e->getMessage()], 500);
        } catch (Exception $ex) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::Error($ex);

            return response(['msg' => Lang::get('response.server_error'), 'error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/me/products/{id}",
     *     operationId="productDetail",
     *     description="",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Cập nhật sản phẩm",
     *  @SWG\Parameter(
     *         name="pro_category",
     *         in="body",
     *         description="Danh mục sản phẩm truyền category cuối cùng chọn",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_keyword",
     *         in="body",
     *         description="Từ khóa tìm kiếm",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_name",
     *         in="body",
     *         description="Tên sản phẩm",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_sku",
     *         in="body",
     *         description="Mã sản phẩm",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_descr",
     *         in="body",
     *         description="Mô tả ngắn",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_cost",
     *         in="body",
     *         description="Giá bán",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_currency",
     *         in="body",
     *         description="Tiền tệ - default là VND.Yêu cầu bắt buộc khi sản phẩm này chọn sale off",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_saleoff_value",
     *         in="body",
     *         description="Giá trị khuyến mãi. Yêu cầu bắt buộc khi sản phẩm này chọn sale off",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_type_saleoff",
     *         in="body",
     *         description="Khuyến mãi theo phần trăm hay bằng tiền mặt . Phần trăm là 1 , Tiền mặt là 2 .  Yêu cầu bắt buộc khi sản phẩm này chọn sale off",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_saleoff",
     *         in="body",
     *         description="Có khuyến mãi hay không ? Có thì set  = 1",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="begin_date_sale",
     *         in="body",
     *         description="Ngày áp dụng format Y-m-d",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="number_day_saleoff",
     *         in="body",
     *         description="Số ngày áp dụng safe off // Yêu cầu bắt buộc khi sản phẩm này chọn sale off",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_image",
     *         in="body",
     *         description="Ảnh đại diện của sản phẩm , request lên server 1 chuỗi vd hinh1.jpg,hinh2.png ",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_minsale",
     *         in="body",
     *         description="Số lượng bán sĩ tối thiểu",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_instock",
     *         in="body",
     *         description="Số lượng trong kho",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_length",
     *         in="body",
     *         description="Chiều dài sản phẩm",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_width",
     *         in="body",
     *         description="Chiều rộng sản phẩm",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_height",
     *         in="body",
     *         description="Chiều cao sản phẩm",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_made_from",
     *         in="body",
     *         description="Xuất xứ sản phẩm 1: Chính hãng,2: Xách tay, 3:Hàng công ty",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="is_product_affiliate",
     *         in="body",
     *         description="Là sản phẩm đại lý online ? 1 là có ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_type_affiliate",
     *         in="body",
     *         description="Nhập tiền hoa hồng theo % hoặc tiền VND, 1 là % , 2 là tiền",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="seller_affiliate_value",
     *         in="body",
     *         description="Đây là tiền người bán sản phẩm sẽ được hưởng dựa trên giá bán gốc ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_type_dc_affiliate",
     *         in="body",
     *         description="Nhập tiền hoa hồng theo % hoặc tiền VND  1 là % , 2 là tiền",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="buyer_affiliate_value",
     *         in="body",
     *         description="Đây là tiền người mua được giảm dựa trên giá bán gốc",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_mannufacurer",
     *         in="body",
     *         description="Nhà sản xuất ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="mannufacurer_name",
     *         in="body",
     *         description="Tên nhà sản xuất khác ",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_type",
     *         in="body",
     *         description="Sản phẩm bình thường or coupon , Trường này mọi người truyền lên là 0 dùm , sau này sẽ update truyền 2 đối vs coupon",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_vat",
     *         in="body",
     *         description="Đã bao gồm vat hay chưa, 1: Đã bao gồm vat, 2 Chưa bao gồm vat",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_vat",
     *         in="body",
     *         description="Đã bao gồm vat hay chưa, 1: Đã bao gồm vat, 2 Chưa bao gồm vat",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_quality",
     *         in="body",
     *         description="Tình trạng sản phẩm 0: mới , 1: Cũ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_warranty_period",
     *         in="body",
     *         description="Số tháng báo hành",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_link_youtube",
     *         in="body",
     *         description="Liên kết youtube",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_weight",
     *         in="body",
     *         description="Cân nặng ",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_detail",
     *         in="body",
     *         description="pro_detail",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products",
     *         in="body",
     *         description="Qui cách sản phẩm",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*..dp_size",
     *         in="body",
     *         description="Kích thước",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_color",
     *         in="body",
     *         description="Màu sắc",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_material",
     *         in="body",
     *         description="Chất liệu",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_cost",
     *         in="body",
     *         description="Giá //Bắt buộc khi có yêu cầu điền qui cách",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_images",
     *         in="body",
     *         description="Hình ảnh qui cách //Bắt buộc khi có yêu cầu điền qui cách",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_instock",
     *         in="body",
     *         description="Số lượng //Bắt buộc khi có yêu cầu điền qui cách",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="detail_products.*.dp_note",
     *         in="body",
     *         description="Số lượng //Bắt buộc khi có yêu cầu điền qui cách",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="promotions_product.*.limit_type",
     *         in="body",
     *         description="Giảm theo số lượng : 1 , Giảm theo Số tiền : 2",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="promotions_product.*.type_amount",
     *         in="body",
     *         description="Tiền :1, Phần trăm : 2",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="promotions_product.*.limit_from",
     *         in="body",
     *         description="chiếc khấu từ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="promotions_product.*.limit_to",
     *         in="body",
     *         description="chiếc khấu đến",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="promotions_product.*.amount",
     *         in="body",
     *         description="Số tiền giảm",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="pro_dir",
     *         in="body",
     *         description="Thư mục upload hình ảnh",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function update($id, Request $req) {
        $all = $req->all();
        $validator = Validator::make($all, [
                'pro_type' => 'required|in:0,1,2', //0: default, 1: service, 2: coupon
                'pro_category' => 'required',
                'pro_name' => 'required|max:100',
                'pro_sku' => 'required|max:35',
                'pro_descr' => 'required|max:100',
                'pro_keyword' => 'string|max:255',
                'pro_detail' => 'required',
                'pro_cost' => 'required|max:11',
                'pro_currency' => 'required',
                'pro_vat' => 'required',
                'pro_quality' => 'required|max:11',
                'pro_weight' => 'required|max:11',
                'pro_image' => 'required',
                'pro_dir' => 'required',
                'detail_products' => 'array',
                'pro_instock'=>'max:11',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
         if (!empty($req->detail_products)) {
            $validator = Validator::make($all, [
                    'detail_products.*.dp_images' => 'required', //0: default, 1: service, 2: coupon
                    'detail_products.*.dp_cost' => 'required|max:11',
                    'detail_products.*.dp_instock' => 'required|max:11',
            ]);
            if ($validator->fails()) {
                return response([
                    'msg' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                    ], 422);
            }
        }
        $user = $req->user();
        $product = Product::where(['pro_id' => $id, 'pro_user' => $req->user()->use_id])->first();
        $helper = new Commons();
        $pro_reliable = $product->pro_reliable;
        $price = $product->pro_cost;
        $af_amt = $product->af_amt;
        $af_dc_rate = $product->af_dc_rate;
        $af_dc_amt = $product->af_dc_amt;
        $currency = $product->pro_currency;
        $begin_date = 0;
        $af_rate = 0;
        $promotion_expiry = 0;

        if ($user->use_group == User::TYPE_AffiliateStoreUser) {
            $pro_reliable = 1;
        }
        if (!$req->pro_no_cost) {
            $price = $req->pro_cost;
        } else {
            $price = 0;
        }
        $manufacturecusom = $product->pro_manufacturer_id;
        if ($req->pro_mannufacurer == "other" && $req->mannufacurer_name != "") {
            $manufacture = Manufacture::create([
                    'man_name' => $helper->injection_html($req->mannufacurer_name),
                    'man_status' => 0,
                    'man_id_category' => $req->man_id_category
            ]);
            if ($manufacture->save()) {
                $manufacturecusom = $manufacture->id;
            }
        } else if ($req->pro_mannufacurer) {
            $manufacturecusom = $req->pro_mannufacurer;
        }

        if ($req->is_product_affiliate) {
            $af_amt = 0;
            $af_rate = 0;
            $af_dc_rate = 0;
            $af_dc_amt = 0;
            //Kiểu hoa hồng là %
            if ($req->pro_type_affiliate == Product::TYPE_AFFILIATE_PERCENT) {
                $af_rate = $req->seller_affiliate_value;
                
            } else {
                //Kiểu hoa hồng là tiền
                $af_amt = $req->seller_affiliate_value;
            }
            if ($req->pro_type_dc_affiliate == Product::TYPE_AFFILIATE_PERCENT) {
                $af_dc_rate = $req->buyer_affiliate_value;
            } else {
                $af_dc_amt = $req->buyer_affiliate_value;
            }
        }
        $pro_saleoff = $product->pro_saleoff;
        $begin_date = date('Y-m-d', $product->begin_date_sale);
        if (!empty($req->pro_saleoff)) {
            if (!empty($req->begin_date_sale)) {
                $begin_date = date('Y-m-d', $req->begin_date_sale);
            } else {
                $begin_date = date('Y-m-d', time());
            }

            $pro_saleoff = $req->pro_saleoff;
            $add_days = (int) $req->number_day_saleoff;

            $promotion_expiry = strtotime($begin_date . ' +' . $add_days . ' days');
        } else {
            $pro_saleoff = 0;
        }
        if ($req->pro_currency) {
            $currency = $req->pro_currency;
        }
        if ($req->pro_hondle) {
            $pro_hondle = $req->pro_hondle;
        } else {
            $pro_hondle = $product->pro_hondle;
        }
        $pro_category = $product->pro_category;
        if ($req->pro_category) {
            $pro_category = $req->pro_category;
        }

        DB::beginTransaction();
        try {
            $dataEdit = array(
                'pro_name' => trim($req->pro_name),
                'pro_sku' => trim($req->pro_sku),
                'pro_descr' => trim($helper->injection_html($req->pro_descr)),
                'pro_keyword' => trim($helper->injection_html($req->pro_keyword)),
                'pro_cost' => $price,
                'pro_currency' => $currency,
                'pro_hondle' => $pro_hondle,
                'pro_saleoff' => $pro_saleoff,
                'pro_category' => (int) $pro_category,
                'pro_enddate' => strtotime(date('Y-m-d')),
                'pro_detail' => trim($req->pro_detail),
                'pro_image' => isset($req->pro_image) ? $req->pro_image : $product->pro_image,
                'pro_dir' => isset($req->pro_dir) ? $req->pro_dir : $product->pro_dir,
                'pro_poster' => isset($req->pro_poster) ? $req->pro_poster : trim($helper->injection_html($req->pro_poster)),
                'pro_address' => isset($req->pro_address) ? $req->pro_address : trim($helper->injection_html($req->pro_address)),
                'pro_phone' => isset($req->pro_phone) ? $req->pro_phone : trim($helper->injection_html($req->pro_phone)),
                'pro_mobile' => isset($req->pro_mobile) ? $req->pro_mobile : trim($helper->injection_html($req->pro_mobile)),
                'pro_email' => isset($req->pro_email) ? $req->pro_email : trim($helper->injection_html($req->pro_email)),
                'pro_yahoo' => isset($req->pro_yahoo) ? $req->pro_yahoo : trim($helper->injection_html($req->pro_yahoo)),
                'pro_skype' => isset($req->pro_skype) ? $req->pro_skype : trim($helper->injection_html($req->pro_skype)),
                'pro_show' => isset($req->pro_show) ? $req->pro_show : $product->pro_show,
                'pro_saleoff_value' => isset($req->pro_saleoff_value) ? (int) $req->pro_saleoff_value : (int) $product->pro_saleoff_value,
                'pro_type_saleoff' => isset($req->pro_type_saleoff) ? $req->pro_type_saleoff : $product->pro_type_saleoff,
                'is_product_affiliate' => isset($req->is_product_affiliate) ? $req->is_product_affiliate : $product->is_product_affiliate,
                'af_amt' => $af_amt,
                'af_rate' => $af_rate,
                'af_dc_amt' => $af_dc_amt,
                'af_dc_rate' => $af_dc_rate,
                'pro_video' => isset($req->pro_link_youtube) ? $req->pro_link_youtube : $product->pro_link_youtube,
                // 'pro_manufacturer_id' => (int)$this->input->post('mannufacurer_pro'), manafac_khac
                'pro_province' => isset($req->pro_province) ? $req->pro_province : $product->pro_province,
                'pro_reliable' => isset($req->pro_reliable) ? $req->pro_reliable : $product->pro_reliable,
                'pro_manufacturer_id' => $manufacturecusom,
                'pro_instock' => $req->pro_instock,
                'pro_vat' => $req->pro_vat,
                'pro_quality' => $req->pro_quality,
                'pro_made_from' => $req->pro_made_from,
                'pro_warranty_period' => $req->pro_warranty_period ? trim($helper->injection_html($req->pro_warranty_period)) : 0,
                'up_date' => date('Y-m-d H:i:s', time()),
                'pro_weight' => trim($helper->injection_html($req->pro_weight)),
                'pro_length' => $req->pro_length ? trim($helper->injection_html($req->pro_length)) : 0,
                'pro_width' => $req->pro_width ? trim($helper->injection_html($req->pro_width)) : 0,
                'pro_height' => $req->pro_height ? trim($helper->injection_html($req->pro_height)) : 0,
                'pro_minsale' => (int) $req->pro_minsale,
                'begin_date_sale' => strtotime($begin_date),
                'end_date_sale' => $promotion_expiry
            );
            $product->fill($dataEdit);
            $product->save();

            //Lưu trữ trường quy cách
            if (is_array($req->detail_products) && sizeof($req->detail_products) > 0) {
                $detailsProducts = [];
                foreach ($req->detail_products as $detail) {
                    $detail['dp_pro_id'] = $product->pro_id;
                    $detailsProducts[] = $detail;
                }
                DetailProduct::where(['dp_pro_id' => $product->pro_id])->delete();
                DetailProduct::insert($detailsProducts);
            }

            if (!empty($req->promotions_product)) {
                $promotions = [];

                foreach ($req->promotions_product as $promotion) {

                    if ($promotion['type_amount'] == ProductPromotion::TYPE_AMOUNT_MONEY) {
                        $promotion['dc_amt'] = $promotion['amount'];
                        $promotion['dc_rate'] = 0;
                    } else {
                        $promotion['dc_rate'] = $promotion['amount'];
                        $promotion['dc_amt'] = 0;
                    }
                    $promotion['pro_id'] = $product->pro_id;
                    unset($promotion['amount']);
                    unset($promotion['type_amount']);
                    $promotions[] = $promotion;
                }

                ProductPromotion::where(['pro_id' => $product->pro_id])->delete();

                ProductPromotion::insert($promotions);
            }
            DB::commit();
             if ($product->is_product_affiliate == Product::IS_AFF_PRODUCT) {
                if ($product->af_amt > 0) {
                    $seller_affiliate_value = $product->af_amt;
                    $pro_type_affiliate = Product::TYPE_AFFILIATE_CURRENCY;
                } else {
                    $seller_affiliate_value = $product->af_rate;
                    $pro_type_affiliate = Product::TYPE_AFFILIATE_PERCENT;
                }

                if ($product->af_dc_amt > 0) {
                    $pro_type_dc_affiliate = $product['pro_type_dc_affiliate'] = Product::TYPE_AFFILIATE_CURRENCY;
                    $buyer_affiliate_value = $product['buyer_affiliate_value'] = $product->af_dc_amt;
                } else {
                    $pro_type_dc_affiliate = Product::TYPE_AFFILIATE_PERCENT;
                    $buyer_affiliate_value = $product->af_dc_rate;
                }
            } else {
                $pro_type_dc_affiliate = 0;
                $buyer_affiliate_value = 0;
                $seller_affiliate_value = 0;
                $pro_type_affiliate = 0;
            }
            $product['pro_type_dc_affiliate'] = $pro_type_dc_affiliate;
            $product['buyer_affiliate_value'] = $buyer_affiliate_value;
            $product['seller_affiliate_value'] = $seller_affiliate_value;
            $product['pro_type_affiliate'] = $pro_type_affiliate;
//            $product->promotionsProduct;
//            $product->
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $product
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::Error($e);

            return response(['msg' => Lang::get('response.server_error'), 'error' => $e->getMessage()], 500);
        } catch (Exception $ex) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::Error($ex);

            return response(['msg' => Lang::get('response.server_error'), 'error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/me/products/{pro_id}/update-status",
     *     operationId="products",
     *     description="Cập nhật đơn hàng sản phẩm",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Cập nhật sản phẩm",
     *  @SWG\Parameter(
     *        name="pro_order",
     *         in="body",
     *         description="Cập nhật order cho product",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="total"
     *     )
     * )
     */
    public function updateOrder($id, Request $req) {
        $all = $req->all();
        $validator = Validator::make($all, [
                'pro_order' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $user = $req->user();
        $product = Product::where(['pro_id' => $id, 'pro_user' => $user->use_id])->first();

        if (empty($product)) {
            return response(['msg' => Lang::get('response.product_not_found')], 404);
        }

        DB::beginTransaction();
        try {

            $product->pro_order = $req->pro_order;
            $product->save();


            DB::commit();
//            $product->promotionsProduct;
//            $product->
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $product
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::Error($e);

            return response(['msg' => Lang::get('response.server_error'), 'error' => $e->getMessage()], 500);
        } catch (Exception $ex) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::Error($ex);

            return response(['msg' => Lang::get('response.server_error'), 'error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @SWG\Get(
     *    path="/api/v1/me/products/{id}/user-selected",
     *     operationId="productsSelected",
     *     description="Danh sách người dùng chọ bán",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Danh sách người chọn bán",
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
     *         description="total"
     *     )
     * )
     */
    public function userSelected($id, Request $req) {

        $prodb = (new Product)->getTable();
        $proAffdb = (new ProductAffiiate)->getTable();
        $shopdb = Shop::tableName();
        $query = User::whereIn('use_id', function($q) use ($id, $proAffdb, $prodb) {
                $q->select('use_id');
                $q->from($proAffdb);

                $q->join($prodb, $prodb . '.pro_id', $proAffdb . '.pro_id');
                $q->where([$proAffdb . '.pro_id' => $id]);
                $q->where(['is_product_affiliate' => Product::IS_AFF_PRODUCT,
                    'pro_status' => Product::STATUS_ACTIVE]);
            });
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $results = $query->paginate($limit, ['*'], 'page', $page);

        //populate shop
        foreach ($results as $value) {
            $value->publicProfile();
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/me/products/{pro_id}/set-status",
     *     operationId="products",
     *     description="1: Active hay 0: Deactive 1 sản phẩm / coupon",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Active hay Deactive 1 sản phẩm / coupon",
     *    @SWG\Parameter(
     *         name="status",
     *         in="body",
     *         description=" trạng thái sản phẩm 1 : active , 0:deactive",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="total"
     *     )
     * )
     */
    public function setStatus($id, Request $req) {
        $validator = Validator::make($req->all(), [
                'status' => 'required|in:0,1', // 1: active, 0: deacive
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $user = $req->user();
        if ($user->use_group == User::TYPE_BranchUser) {
            return response([
                'msg' => 'Liên hệ với Gian hàng của bạn!.'
                ], 422);
        }
        $result = Product::where(['pro_id' => $id, 'pro_user' => $user->use_id])->first();
        $result->pro_status = $req->status;
        $result->save();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
            ], 200);
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/me/products/{pro_id}/set-affiliate",
     *     operationId="products",
     *     description="Update sp là affiliate hay không",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Update sp là affiliate hay không",
     *     @SWG\Parameter(
     *         name="status",
     *         in="body",
     *         description=" Trạng thái sản phẩm 1 : là sp aff , 0: là không aff",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="product"
     *     )
     * )
     */
    public function setAffiliate($id, Request $req) {
        $validator = Validator::make($req->all(), [
                'is_product_affiliate' => 'required|in:0,1', // 1: active, 0: deacive
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $user = $req->user();
        if ($user->use_group == User::TYPE_BranchUser) {
            return response([
                'msg' => 'Liên hệ với Gian hàng của bạn!.'
                ], 422);
        }
        $result = Product::where(['pro_id' => $id, 'pro_user' => $user->use_id])->first();
        $result->is_product_affiliate = $req->is_product_affiliate;
        $result->save();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
            ], 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/count-products",
     *     operationId="products",
     *     description="Danh sach Sản Phẩm",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Đếm số sản phẩm",
     *    @SWG\Parameter(
     *         name="outStock",
     *         in="query",
     *         description="Param để lấy sản phẩm hết hàng outStock=1",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="total"
     *     )
     * )
     */
    public function countProduct(Request $req) {

        $query = Product::where(['pro_user' => $req->user()->use_id, 'pro_status' => 1])->select('pro_id');
        if ($req->outStock) {
            $query->where(['pro_instock' => $req->outStock]);
        }
        $product = $query->count();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'total' => $product
            ]
        ]);
    }
    
    /**
     * @SWG\Get(
     *     path="/api/v1/me/allow-create-product",
     *     operationId="products",
     *     description="Check chi nhách có đường quyền tạo product",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Check chi nhách có đường quyền tạo product",
     *     @SWG\Response(
     *         response=200,
     *         description="total"
     *     )
     * )
     */
    public function checkBranchCreateProduct(Request $req) {
        $user = $req->user();
        if ($user->use_group != User::TYPE_BranchUser) {
            return response([
                'msg' => Lang::get('response.success'),
                'data' => [
                    'isAllow' => true
                ]
            ]);
        }
        $isAllow = $this->checkConfigBranch($user);
        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'isAllow' => $isAllow
            ]
        ]);
    }

    private function checkConfigBranch($user) {
        $bran_rule = $user->branchConfig;
        if (empty($bran_rule)) {
            return false;
        }

        $list_br = explode(",", $bran_rule->config_rule);
        if (empty($list_br) || !in_array('47', $list_br)) {
            return false;
        }
        return true;
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/products/{id}/style",
     *     operationId="products",
     *     description="Load thông tin sản phẩm theo style",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Load thông tin sản phẩm theo style",
     *    @SWG\Parameter(
     *         name="color",
     *         in="query",
     *         description="Màu",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="size",
     *         in="query",
     *         description="Kích thước",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="material",
     *         in="query",
     *         description="Nguyên liệu",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="total"
     *     )
     * )
     */
    function getStyle($id, Request $req) {

        $query = Product::where([]);
        $productdb = Product::tableName();
        $queryDt = DetailProduct::where([]);
        $detaildb = DetailProduct::tableName();
        if ($req->color && $req->color != "") {
            $queryDt->whereRaw('dp_color LIKE "%' . $req->color . '%"');
        }
        if ($req->size && $req->size != "") {
            $queryDt->whereRaw('dp_size LIKE "%' . $req->size . '%"');
        }
        if ($req->material && $req->material != "") {
            $queryDt->whereRaw('dp_material LIKE "%' . $req->material . '%"');
        }
        $queryDt->where('dp_pro_id', $id);
        $queryDt->orderBy('id', 'DESCT');
        $queryDt->limit(1);

        $bindings = $queryDt->getBindings();
        $sql = $queryDt->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sql = str_replace('\\', '\\\\', $sql);


        $query->leftJoin(DB::raw('(' . $sql . ') as T'), 'T.dp_pro_id', 'tbtt_product.pro_id');
        $query->where($productdb . '.pro_id', $id);
        $query->where($productdb . '.pro_status', Product::STATUS_ACTIVE);
        $query->select($productdb . '.*','T.*', DB::raw('T.id as detail_id,T.dp_images, (T.`dp_cost`) AS pro_cost,' . Product::queryDiscountProduct()));
        $product = $query->first();

        $result = null;
        if (!$product) {
            return response([
                'msg' => Lang::get('response.product_not_found')
                ], 404);
        }
        $result['dp_instock'] = $product->dp_instock;
        $result['pro_dir'] = $product->pro_dir;
        $result['pro_id_detail'] = $product->detail_id;
        $result['pro_images'] = $product->dp_images;
        $result['pro_prices'] = $product->pro_cost;
        $result['off_amount'] = $product->off_amount;
        $result['af_off'] = $product->af_off;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/products-from-shop",
     *     operationId="products",
     *     description="Chi nhánh - Sản phẩm / coupon gian hàng",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Chi nhánh - Sản phẩm / coupon gian hàng",
     *  @SWG\Parameter(
     *         name="keywords",
     *         in="query",
     *         description="Tìm kiếm theo từ khóa",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="categoryId",
     *         in="query",
     *         description="categoryId, default -1",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="price_from",
     *         in="query",
     *         description="Gia từ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="price_to",
     *         in="query",
     *         description="Giá giớ hạn",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="price_type",
     *         in="query",
     *         description="Tìm kiếm theo Giá : 1, Hoa hồng tiền : 2, Hoa hồng % : 3",
     *         required=false,
     *         type="integer",
     *     ),
     *   @SWG\Parameter(
     *         name="pro_type",
     *         in="query",
     *         description="Tìm kiếm sản phẩm : 0, Tìm kiếm coupon : 2 ",
     *         required=false,
     *         type="integer",
     *     ),
     *   @SWG\Parameter(
     *         name="shop_guarantee",
     *         in="query",
     *         description="Tìm kiếm theo gian hàng đảm bảo",
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
    function fromShop(Request $req) {
        $user = $req->user();
        $afId = $user->use_id;
        $prodb = Product::tableName();
        $get_parent = $user->parentInfo;

      
        $type = Product::TYPE_DEFAULT;
        if ($req->pro_type) {
            $type = $req->pro_type;
        }
        
        $shopdb = Shop::tableName();
        $query = Product::where('pro_status', Product::STATUS_ACTIVE);
        $query->join($shopdb, $shopdb . '.sho_user', $prodb . '.pro_user');
      
        $query->where('pro_type',$type);
        if ($req->categoryId && $req->categoryId != -1) {
            $query->whereIn($prodb . '.pro_category', Category::getAllLevelCategorieById($req->categoryId));
        }
        if (!empty($req->keywords)) {
            $query->where(function($q) use ($prodb, $shopdb, $req) {
                $keywords = $req->keywords;
                $q->orWhere($prodb . '.pro_name', 'LIKE', '%' . $keywords . '%');
                $q->orWhere($prodb . '.pro_descr', 'LIKE', '%' . $keywords . '%');
                $q->orWhere($shopdb . '.sho_link', 'LIKE', '%' . $keywords . '%');
                $q->orWhere($shopdb . '.sho_name', 'LIKE', '%' . $keywords . '%');
            });
        }
        if (!empty($req->orderBy)) {
            $req->orderBy = explode(',', $req->orderBy);
            $key = $req->orderBy[0];
            $value = $req->orderBy[1] ? $req->orderBy[1] : 'DESC';
            $query->orderBy($prodb . '.' . $key, $value);
        } else {
            $query->orderBy($prodb . '.pro_id', 'DESC');
        }

        if ($req->shop_guarantee) {
            $query->whereExists(function($query) {
                $packageUserdb = PackageUser::tableName();
                $packagedb = Package::tableName();
                $packageInfodb = PackageInfo::tableName();
                $query->select($packageUserdb . '.package_id')
                    ->from($packageUserdb)
                    ->leftJoin($packagedb, $packagedb . '.id', $packageUserdb . '.package_id')
                    ->leftJoin($packageInfodb, $packageInfodb . '.id', $packagedb . '.info_id')
                    ->where($packageUserdb . '.user_id', 'tbtt_shop.sho_user')
                    ->where($packagedb . '.info_id', '>=', 3)
                    ->whereDate($packageUserdb . '.begined_date', '<', date('Y-m-d'))
                    ->whereDate($packageUserdb . '.ended_date', '>', date('Y-m-d'))
                    ->where([
                        $packageUserdb . '.status' => PackageUser::STATUS_ACTIVE,
                        $packageUserdb . '.payment_status' => PackageUser::PAYMENT_DONE,
                        $packageInfodb . '.pType' => 'package',
                ]);
            });
        }


        if ($req->price_from) {
            switch ($req->price_type) {
                case Product::PRICE_TYPE_DEFAULT:
                    $query->where($prodb . '.pro_cost', '>=', $req->price_from);
                    break;
                case Product::PRICE_TYPE_PROMOTION_MONEY:
                    $query->where($prodb . '.af_amt', '>=', $req->price_from);
                    break;
                case Product::PRICE_TYPE_PROMOTION_PERCENT:
                    $query->where($prodb . '.af_rate', '>=', $req->price_from);
                    break;
            }
        }
        if ($req->price_to) {
            switch ($req->price_type) {
                case Product::PRICE_TYPE_DEFAULT:
                    $query->where($prodb . '.pro_cost', '<=', $req->price_to);
                    break;
                case Product::PRICE_TYPE_PROMOTION_MONEY:
                    $query->where($prodb . '.af_amt', '<=', $req->price_to);
                    break;
                case Product::PRICE_TYPE_PROMOTION_PERCENT:
                    $query->where($prodb . '.af_rate', '<=', $req->price_to);
                    break;
            }
        }
        $no_store = 0;
        if ($get_parent && $get_parent->use_group != 3) {
            $afId = (int) $get_parent->use_id;
            $parent_parent = $get_parent->parentInfo;
            
        }else{
             $parent_parent = $get_parent;
        }
        $query->where('pro_user', '<>', $afId);
        
 
        if ($parent_parent->use_group == User::TYPE_AffiliateStoreUser) {
            $query->where($prodb . '.pro_user', $parent_parent->use_id);
        } elseif ($parent_parent->use_group == User::TYPE_AffiliateStoreUser && $req->no_store == 1) {
            $query->where($prodb . '.pro_user', '<>', $parent_parent->use_id);
        } elseif ($parent_parent->use_group != User::TYPE_AffiliateStoreUser && $parent_parent->parent_shop > 0 && $no_store == 0) {
            $query->where($prodb . '.pro_user', $parent_parent->parent_shop);
        } elseif ($parent_parent->use_group != User::TYPE_AffiliateStoreUser && $parent_parent->parent_shop > 0 && $no_store == 1) {
            //$where['tbtt_product.pro_user <> '] = $user_detail->parent_shop;
        }

        $query->select($prodb . ".*", DB::raw('tbtt_product.`af_amt` + tbtt_product.`af_rate` * tbtt_product.`pro_cost` / 100
	 AS giam_gia'), DB::raw(Product::queryDiscountProduct()));
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
//         $bindings = $query->getBindings();
//        $sql = $query->toSql();
//        foreach ($bindings as $binding) {
//            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
//            $sql = preg_replace('/\?/', $value, $sql, 1);
//        }
//        $sql = str_replace('\\', '\\\\', $sql);
       
        $results = $query->paginate($limit, ['*'], 'page', $page);

        //populate shop
        foreach ($results as $value) {
            $value->publicInfo($user);
            $value->category;
            $value->isBracndSelected($user);
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/me/products-from-shop/{id}",
     *     operationId="products",
     *     description="Chi nhánh - Thêm bán Sản phẩm / coupon gian hàng",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Chi nhánh - Thêm bán Sản phẩm / coupon gian hàng",
     *     @SWG\Parameter(
     *         name="quantity",
     *         in="query",
     *         description="Số lượng",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function brandSelectBuy($id, Request $req) {
        $validator = Validator::make($req->all(), [
                'quantity' => 'required|min:1'
        ]);
        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $user = $req->user();
        
        $parent = $user->parentInfo;
        $p_id = $parent->use_id;
        if ($parent && $parent->use_group != User::TYPE_AffiliateStoreUser) {
            $p_id = $parent->parent_id;
        }
       
        $product = Product::where(['pro_id' => $id, 'pro_user' => $p_id])->first();
        if (empty($product)) {
            return response([
                'msg' => Lang::get('product.out_stock')
                ], 404);
        }
        $quantity = $req->quantity;
        if ($product->pro_instock < $quantity) {
            return response([
                'msg' => Lang::get('product.out_stock')
                ], 422);
        }
        $isProbranch = Product::where(['pro_of_shop' => $id, 'pro_user' => $user->use_id])->first();
        DB::beginTransaction();
        try {
            if (!empty($isProbranch)) {
	
                $isProbranch->pro_instock = $isProbranch->pro_instock + $quantity;
                $isProbranch->save();
                $product->pro_instock = $product->pro_instock - $quantity;
                $product->save();
                $product->pro_is_branch_selected = 1;
                DB::commit();
                return response([
                    'msg' => Lang::get('response.success'),
                    'data' => $product
                    ], 200);
            } else {


                $dataCopy = array(
                    'pro_name' => $product->pro_name,
                    'pro_sku' => $product->pro_sku,
                    'pro_descr' => $product->pro_descr,
                    'pro_keyword' => $product->pro_keyword,
                    'pro_cost' => $product->pro_cost,
                    'pro_currency' => $product->pro_currency,
                    'pro_hondle' => $product->pro_hondle,
                    'pro_saleoff' => $product->pro_saleoff,
                    'pro_province' => $product->pro_province,
                    'pro_category' => $product->pro_category,
                    'pro_begindate' => $product->pro_begindate,
                    'pro_enddate' => $product->pro_enddate,
                    'pro_detail' => $product->pro_detail,
                    'pro_image' => $product->pro_image,
                    'pro_dir' => $product->pro_dir,
                    'pro_user' => $user->use_id, //ID chi nhánh
                    'pro_poster' => $product->pro_poster,
                    'pro_address' => $product->pro_address,
                    'pro_phone' => $product->pro_phone,
                    'pro_mobile' => $product->pro_mobile,
                    'pro_email' => $product->pro_email,
                    'pro_yahoo' => $product->pro_yahoo,
                    'pro_skype' => $product->pro_skype,
                    'pro_status' => $product->pro_status,
                    'pro_view' => $product->pro_view,
                    'pro_buy' => $product->pro_buy,
                    'pro_comment' => $product->pro_comment,
                    'pro_vote_cost' => $product->pro_vote_cost,
                    'pro_vote_quanlity' => $product->pro_vote_quanlity,
                    'pro_vote_model' => $product->pro_vote_model,
                    'pro_vote_service' => $product->pro_vote_service,
                    'pro_vote_total' => $product->pro_vote_total,
                    'pro_vote' => $product->pro_vote,
                    'pro_reliable' => $product->pro_reliable,
                    'pro_saleoff_value' => $product->pro_saleoff_value,
                    'is_product_affiliate' => $product->is_product_affiliate,
                    'af_amt' => $product->af_amt,
                    'af_rate' => $product->af_rate,
                    'af_dc_amt' => $product->af_dc_amt,
                    'af_dc_rate' => $product->af_dc_rate,
                    'pro_show' => $product->pro_show,
                    'pro_type_saleoff' => $product->pro_type_saleoff,
                    'pro_manufacturer_id' => $product->pro_manufacturer_id,
                    'pro_instock' => $quantity, //get so luong
                    'pro_weight' => $product->pro_weight,
                    'pro_length' => $product->pro_length,
                    'pro_width' => $product->pro_width,
                    'pro_height' => $product->pro_height,
                    'pro_minsale' => $product->pro_minsale,
                    'pro_vat' => $product->pro_vat,
                    'pro_quality' => $product->pro_quality,
                    'pro_made_from' => $product->pro_made_from,
                    'pro_warranty_period' => $product->pro_warranty_period,
                    'pro_video' => $product->pro_video,
                    'up_date' => date('Y-m-d H:i:s', time()),
                    'created_date' => date("Y-m-d"), //ngày lấy
                  
                    'pro_type' => $product->pro_type,
                   
                );
                $productCp = new Product($dataCopy);
                $productCp->pro_of_shop = $product->pro_id;
                $productCp->begin_date_sale = $product->begin_date_sale;
                $productCp->end_date_sale = $product->end_date_sale;
                $productCp->save();
                $get_detail_pro = $product->detailProducts;
                $promotions = $product->promotions;

                if (!empty($get_detail_pro)) {
                    $arr_detail_pro = [];
                    foreach ($get_detail_pro as $k_dp => $v_dp) {
                        $arr_detail_pro[] = array(
                            'dp_pro_id' => $productCp->pro_id,
                            'dp_images' => $v_dp->dp_images,
                            'dp_size' => $v_dp->dp_size,
                            'dp_color' => $v_dp->dp_color,
                            'dp_material' => $v_dp->dp_material,
                            'dp_cost' => $v_dp->dp_cost,
                            'dp_instock' => $v_dp->dp_instock,
                            'dp_createdate' => date('Y-m-d')
                        );
                    }
                    if (!empty($arr_detail_pro)) {
                        DetailProduct::insert($arr_detail_pro);
                    }
                }

                if (!empty($promotions)) {
                    $promotionData = [];
                    foreach ($promotions as $k_promo => $v_promo) {
                        $promotions[] = array(
                            'pro_id' => $productCp->pro_id,
                            'limit_from' => $v_promo->limit_from,
                            'limit_to' => $v_promo->limit_to,
                            'limit_type' => $v_promo->limit_type,
                            'dc_rate' => $v_promo->dc_rate,
                            'dc_amt' => $v_promo->dc_amt
                        );
                    }
                    if (!empty($promotionData)) {
                        ProductPromotion::insert($promotionData);
                    }
                }
                $product->pro_instock = $product->pro_instock - $quantity;
                $product->save();
                $product->pro_is_branch_selected = 1;
                DB::commit();
                return response([
                    'msg' => Lang::get('response.success'),
                    'data' => $product
                    ], 200);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::Error($e);

            return response(['msg' => Lang::get('response.server_error'), 'error' => $e->getMessage()], 500);
        } catch (Exception $ex) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::Error($ex);

            return response(['msg' => Lang::get('response.server_error'), 'error' => $ex->getMessage()], 500);
        }
    }

}
