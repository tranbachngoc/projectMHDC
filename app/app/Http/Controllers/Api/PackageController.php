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
use App\Models\Package;
use App\Models\PackageUser;
use App\Models\PackageDaily;
use App\Models\PackageInfo;
use App\Models\PackageService;
use App\Models\ServiceGroup;
use App\Models\PackageUserService;
use App\Models\Service;
use App\Models\PackageDailyPrice;
use App\Models\Wallet;
use App\Models\PackageDailyContent;

class PackageController extends ApiController {

    /**
     * @SWG\Get(
     *     path="/api/v1/package-defaults",
     *     operationId="package-defaults",
     *     description="Lấy danh sách các gói dịch vụ của shop ",
     *     produces={"application/json"},
     *     tags={"Package"},
     *     summary="Lấy danh sách các dịch vụ của shop",
     *     @SWG\Response(
     *         response=200,
     *         description="Lấy danh sách các dịch vụ của shop"
     *     )
     * )
     */
    function getPackage(Request $req) {
        $periods = array(3, 6, 12);
        $query = PackageInfo::where('id', '<=', 7);
        $result = $query->where('id', '>=', 1)->where('published', 1)->get();
        $shop = $req->user()->shop;
        $discountShop = !empty($shop) ? $shop->sho_discount_rate : 0;
        $dcs = $discountShop == 0 ? 1 : (1 - $discountShop / 100);

        foreach ($result as $item) {
            $item['serives'] = $this->serviceOfPackage($item->id);
            $item->priceMonth;
            $item->price = 0;
            if (!empty($item->priceMonth)) {
                $totalPrice12 = 0;
                foreach ($item->priceMonth as $price) {
                    $discountRate = $price->discount_rate > 0 ? (1 - $price->discount_rate / 100) : 1;

                    $price->totalPrice = $price->month_price * $price->period * $dcs * $discountRate;
                    if ($price->period == 12) {
                        $totalPrice12 = $price->totalPrice;
                    };
                }
                $item->price = $totalPrice12 / 12;
            }
        }


        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }

    function getPackageV1(Request $req) {
        $query = Package::where('id', '<=', 7);
        $result = $query->where('id', '>=', 1)->where('published', 1)->get();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }

    // Dịch vụ khác
    /**
     * @SWG\Get(
     *     path="/api/v1/package-simple",
     *     operationId="provinces",
     *     description="Dịch vụ khác",
     *     produces={"application/json"},
     *     tags={"Package"},
     *     summary="Dịch vụ khác",
     *     @SWG\Response(
     *         response=200,
     *         description="Dịch vụ khác"
     *     )
     * )
     */
    function getSimplePackage(Request $req) {

        $packageInfodb = PackageInfo::tableName();
        $packagedb = Package::tableName();
        $serviceGroupdb = ServiceGroup::tableName();
        $query = Package::where($packageInfodb . '.pType', 'simple');
        $query->where($packageInfodb . '.published', PackageInfo::TYPE_PUBLISH);
        $query->where($packagedb . '.published', Package::TYPE_PUBLISH);
        $selectContenId = ' (SELECT
          tbtt_service_group.content_id
        FROM
          tbtt_package_service
          LEFT JOIN tbtt_service
            ON tbtt_service.id = tbtt_package_service.service_id
          LEFT JOIN tbtt_service_group
            ON tbtt_service_group.group = tbtt_service.group
        WHERE tbtt_package_service.package_id = tbtt_package.id LIMIT 0, 1) as  content_id';

        $query->select($packageInfodb . '.name', $packagedb . '.*', DB::raw($selectContenId));
        $query->join($packageInfodb, $packagedb . '.info_id', $packageInfodb . '.id');
        $query->with('packageService.service');
        $result = $query->get();

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }

    function packagePrice(Request $req) {
        $query = Package::get();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $query
        ]);
    }

    // Dịch vụ khác
    /**
     * @SWG\Get(
     *     path="/api/v1/package-service",
     *     operationId="provinces",
     *     description="Thông tin các dịch vụ bao gồm giá cả",
     *     produces={"application/json"},
     *     tags={"Package"},
     *     summary="Thông tin các dịch vụ bao gồm giá cả",
     *     @SWG\Response(
     *         response=200,
     *         description="Thông tin các dịch vụ bao gồm giá cả"
     *     )
     * )
     */
    protected function serviceOfPackage($id) {
        $packagedb = Package::tableName();
        $servicedb = Service::tableName();
        $packeServicedb = PackageService::tableName();
        $query = Service::where([
                $servicedb . '.published' => 1,
                $packagedb . '.published' => 1,
        ]);
        $query->where($packagedb . '.info_id', '>=', 1);
        $query->where($packagedb . '.info_id', '<=', 7);

        $query->join($packeServicedb, $packeServicedb . '.service_id', $servicedb . '.id');
        $query->join($packagedb, $packeServicedb . '.package_id', $packagedb . '.id');
        $query->groupBy($packeServicedb . '.service_id');
        $query->orderBy($servicedb . '.name', 'asc');
        $query->selectRaw('tbtt_service.`name`,tbtt_service.id,
                                tbtt_service.`group`,
                                (SELECT `content_id` FROM `tbtt_service_group` WHERE `group` = tbtt_service.`group`) as content_id,
                               tbtt_service.`limit`,
                               tbtt_service.`unit`,
                                GROUP_CONCAT(tbtt_package_service.`package_id`) AS packageList');
        $query->where($packeServicedb . '.package_id', $id);

        return $query->get();
    }

    function packageService(Request $req) {
        $packagedb = Package::tableName();
        $servicedb = Service::tableName();
        $packeServicedb = PackageService::tableName();
        $query = Service::where([
                $servicedb . '.published' => 1,
                $packagedb . '.published' => 1,
        ]);
        $query->where($packagedb . '.info_id', '>=', 1);
        $query->where($packagedb . '.info_id', '<=', 7);

        $query->join($packeServicedb, $packeServicedb . '.service_id', $servicedb . '.id');
        $query->join($packagedb, $packeServicedb . '.package_id', $packagedb . '.id');
        $query->groupBy($packeServicedb . '.service_id');
        $query->orderBy($servicedb . '.group', 'asc');
        $query->selectRaw('tbtt_service.`name`,
                                tbtt_service.`group`,
                                (SELECT `content_id` FROM `tbtt_service_group` WHERE `group` = tbtt_service.`group`) as content_id,
                               tbtt_service.`limit`,
                               tbtt_service.`unit`,
                                GROUP_CONCAT(tbtt_package_service.`package_id`) AS packageList');
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $query->get()
        ]);
//        $this->db->cache_off();
//        $this->db->select('tbtt_service.`name`,
//                                tbtt_service.`group`,
//                                (SELECT `content_id` FROM `tbtt_service_group` WHERE `group` = tbtt_service.`group`) as content_id,
//                                tbtt_service.`limit`,
//                                tbtt_service.`unit`,
//                                GROUP_CONCAT(tbtt_package_service.`package_id`) AS packageList', false);
//        $this->db->from('tbtt_package_service');
//        $this->db->join('tbtt_package', 'tbtt_package_service.package_id = tbtt_package.id');
//        $this->db->join('tbtt_service', 'tbtt_package_service.service_id = tbtt_service.id');
//        $this->db->where('tbtt_package.published', 1);
//        $this->db->where('tbtt_service.published', 1);
//        $this->db->where('tbtt_package.info_id >= ', 1);
//        $this->db->where('tbtt_package.info_id <= ', 7);
//        $this->db->group_by('tbtt_package_service.service_id');
//        $this->db->order_by("tbtt_service.`group`", "asc");
//        $query = $this->db->get();
//
//        $data = array();
//        foreach($query->result_array() as $row){
//            $row['packageList'] = explode(',', $row['packageList']);
//            if(!isset($data[$row['group']])){
//                $data[$row['group']] = array('name'=>$row['name'], 'service'=>array(), 'content_id'=>$row['content_id']);
//            }
//            array_push($data[$row['group']]['service'], $row);
//        }
//        //echo $this->db->last_query();
//
//        $query->free_result();
//        return $data;
    }

    // Dịch vụ đăng sản phẩm
    /**
     * @SWG\Get(
     *     path="/api/v1/package-product",
     *     operationId="packageProduct",
     *     description="Dịch vụ đăng sản phẩm",
     *     produces={"application/json"},
     *     tags={"Package"},
     *     summary="Thông tin các dịch vụ bao gồm giá cả",
     *  @SWG\Parameter(
     *         name="unit_type",
     *         in="query",
     *         description="chọn 1 trong những string sau : ngày,tháng,năm ",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="published",
     *         in="query",
     *         description="đã published =1 , chưa publihsed = 0, default = 1",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Dịch vụ tạo sản phẩm"
     *     )
     * )
     */
    function packageProduct(Request $req) {
        $condition = [
            'unit_type' => 'ngày',
            'published' => 1
        ];
        $result = PackageDaily::where($condition)->orderBy("p_type", "asc")->get();

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/package/{id}/check-price",
     *     operationId="packageCheckPrice",
     *     description="Check giá package khi chọn khu vực và ngày",
     *     produces={"application/json"},
     *     tags={"Package"},
     *     summary="Check giá package khi chọn khu vực và ngày",
     *  @SWG\Parameter(
     *         name="position",
     *         in="query",
     *         description="khu vực",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Ngày",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Ngày",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Giá list"
     *     )
     * )
     */
    function packageCheckPrice($id, Request $req) {
        $packagePricedb = PackageDailyPrice::tableName();
        $packageDailydb = PackageDaily::tableName();
        $query = PackageDaily::where([]);
        $city = $req->position;
        $query->leftJoin($packagePricedb, $packagePricedb . '.pack_id', $packageDailydb . '.id');
        $query->where([
            $packageDailydb . '.id' => $id,
            $packagePricedb . '.city' => $city
        ]);
        $query->select($packageDailydb . '.*');
        $package_info = $query->first();
        $startDate = $req->startDate;
        $endDate = $req->endDate;

        $step = '+1 day';
        $total = 0;
        while ($startDate <= $endDate) {
            $check_date = date('Y-m-d', $startDate);
            $queryPackge = PackageDailyUser::where([]);
            $max_num = $queryPackge->select(DB::raw('IF(MAX(pos_num) IS NULL,1,MAX(pos_num) + 1) AS max_num'))->where('package_id', $id)->whereDate('begined_date', $check_date)->first();

            if ($package_info['pos_num'] < $max_num['max_num']) {
                $return['dates'][] = array('date' => date('d/m/Y', $startDate), 'd-time' => $startDate, 'd' => date('Y-m-d', $startDate), 'error' => true, 'message' => 'Đã hết chỗ');
            } else {

                $unit_price = ($package_info['price_max'] - $package_info['price_min']) / $package_info['pos_num'];
                $price = $package_info['price_min'] + (($max_num['max_num'] - 1) * $unit_price);
                $total += $price;
                $return['dates'][] = array('date' => date('d/m/Y', $startDate), 'd-time' => $startDate, 'd' => date('Y-m-d', $startDate), 'error' => false, 'price' => $price);
            }

            $startDate = strtotime($step, $startDate);
        }
        $return['pack_id'] = $id;
        $return['position'] = $city;
        $return['total'] = $total;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $return
        ]);
    }

    function AddPackageProduct($package_id, Request $req) {
        $price_total = $req->total;
        $city = $req->position;
        $dates = $req->dates;
        $packageDailyPricedb = PackageDailyPrice::tableName();
        $packageDailydb = PackageDaily::tableName();
        $user = $req->user();
        $q = PackageDaily::leftJoin($packageDailyPricedb . ' as adp', 'adp.pack_id', $packageDailydb . '.id');
        $q->where([
            $packageDailydb . '.id' => $package_id,
            'adp.city' => $city,
        ]);

        $q->select(DB::raw('tbtt_package_daily.unit_type,
                                    tbtt_package_daily.content_type,
                                    tbtt_package_daily.p_type,
                                    tbtt_package_daily.p_name,
                                    tbtt_package_daily_price.pos_num,
                                    tbtt_package_daily_price.price_min,
                                    tbtt_package_daily_price.price_max'));
        $package_info = $q->first()->toArray();
        if (empty($package_info)) {
            return response([
                'msg' => Lang::get('response.package_not_found')
                ], 404);
        }
        $pid = $req->content_id;
        if ($package_info['unit_type'] == 'ngày') {
            $total = 0;
            foreach ($dates as $date) {
                $max_num = PackageDailyUser::get_max_pos_num($date['startDate'], $package_id, $city)->toArray();

                if ($package_info['pos_num'] < $max_num['max_num']) {
                    $return['dates'][] = array('max_num' => $max_num['max_num'], 'd' => $date['startDate'], 'error' => true, 'message' => 'Đã hết chỗ');
                } else {
                    $unit_price = ($package_info['price_max'] - $package_info['price_min']) / $package_info['pos_num'];
                    $price = $package_info['price_min'] + (($max_num['max_num'] - 1) * $unit_price);
                    $total += $price;
                    $return['dates'][] = array('max_num' => $max_num['max_num'], 'date' => $date['startDate'], 'error' => false, 'price' => $price);
                }
            }
            if ($total != $price_total) {
                return response([
                    'msg' => 'Giá đã thay đổi'
                    ], 402);
            } else {
                $amount = $this->getWallet($user->use_id)->toArray();
                if ($total > $amount['amount_money'] + $amount['amount_point']) {
                    return response([
                        'msg' => 'Vui lòng nạp thêm tiền vào tài khoản để đăng ký dịch vụ'
                        ], 402);
                } else {

                    foreach ($return['dates'] as $date) {
                        $this->addPackageDaily($user->use_id, $package_id, $date['startDate'], $date['price'], $date['max_num'], $package_info['content_type'], $package_info['p_type'], $city, $package_info['p_name'], $pid);
                    }


                    $news = "";
                    if ($package_id == 8) {
                        $position = array(
                            '000' => "Toàn quốc",
                            '001' => "Khu vực 1",
                            '999' => "Khu vực 2"
                        );
                        $news = '. Khu vực: ' . $position[$city];
                    }

                    if ($package_id == 1) {
                        $position = array(
                            '000' => "Tin hot",
                            '111' => "Tin khuyến mãi"
                        );
                        $news = '. Loại: ' . $position[$city];
                    }

                    $beginTime = date("d-m-Y", $req->dates[0]['startDate']);
                    $endTime = date("d-m-Y", $req->dates[count($req->dates) - 1]['startDate']);

                    return response([
                        'msg' => Lang::get('response.success'),
                        'data' => [
                            'package_info' => $package_info,
                            'starDate' => $beginTime,
                            'endDate' => $endTime,
                            'total' => $total,
                            'position' => $city
                        ]
                    ]);
                }
            }
        } else {
            $return = $this->package_daily_user_model->addShelfPackage($userId, $pack_id, $package_info['price_min'], $package_info['pos_num'], $package_info['content_type'], $package_info['p_type'], $package_info['p_name']);
        }
    }

    //NOT USE

    function packageDailyProduct(Request $req) {
        $user = $req->user();
        if ($user->use_group == User::TYPE_AffiliateUser) {
            $result = PackageDaily::where(['unit_type' => 'tháng'])->get();
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $result
            ]);
        } else {
            $result = PackageDaily::whereIn('p_type', ['04', '05', '06', '07', '08']);
            return response([
                    'msg' => Lang::get('response.success'),
                    'data' => $result
                ])->get();
        }
    }

    function packageDaily(Request $req) {

        $user = $req->user();
        if ($user->use_group == User::TYPE_AffiliateUser) {
            $query = PackageDailyUser::where(['unit_type' => 'tháng']);
        } else {
            $query = PackageDailyUser::where(['unit_type' => 'ngày', 'published' => 1]);
            if ($req->packageType) {
                switch ($req->packageType) {
                    case 'products':
                        $query->whereIn('p_type', array('04', '05', '06', '07', '08'));
                        break;
                    case 'news':
                        $query->whereIn(array('p_type' => array('01', '02', '03')));
                        break;
                }
            }
        }
        $result = $query->get();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }

//    function packageDaily(Request $req) {
//        $packageUserdb = PackageUser::tableName();
//        $user = $req->user();
//        $packagedb = Package::tableName();
//        $queryMax = PackageUser::where([
//                $packageUserdb . '.user_id' => $user->use_id,
//                $packageUserdb . '.status' => $user->status,
//                $packageUserdb . '.payment_status' => PackageUser::PAYMENT_DONE,
//            ])->where($packagedb . '.info_id', '>=', 2)->where($packagedb . '.info_id', '<=', 7)
//            ->leftJoin($packagedb, $packagedb . '.id', $packageUserdb . '.package_id');
//
//        $queryMax->select(DB::raw('IF(
//                      MAX(tbtt_package_user.ended_date) IS NULL,
//                      DATE_ADD(NOW(), INTERVAL 1 SECOND),
//                      DATE_ADD(
//                        MAX(tbtt_package_user.ended_date),
//                        INTERVAL 1 SECOND
//                      )
//                    ) AS begin_date,
//                    IF(
//                      MAX(tbtt_package_user.ended_date) IS NULL,
//                      1,
//                      0
//                    ) AS is_new'));
//        $bindings = $queryMax->getBindings();
//        $sql = $queryMax->toSql();
//        foreach ($bindings as $binding) {
//            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
//            $sql = preg_replace('/\?/', $value, $sql, 1);
//        }
//        $sql = str_replace('\\', '\\\\', $sql);
//        DB::select("DATE_FORMAT(pack.begin_date, '%d/%m/%Y') AS begin_date,
//                  DATE_FORMAT(
//                    DATE_ADD(pack.begin_date, INTERVAL 1 MONTH),
//                    '%d/%m/%Y'
//                  ) AS month_1,
//                  DATE_FORMAT(
//                    DATE_ADD(pack.begin_date, INTERVAL 3 MONTH),
//                    '%d/%m/%Y'
//                  ) AS month_3,
//                  DATE_FORMAT(
//                    DATE_ADD(pack.begin_date, INTERVAL 6 MONTH),
//                    '%d/%m/%Y'
//                  ) AS month_6,
//                  DATE_FORMAT(
//                    DATE_ADD(
//                      pack.begin_date,
//                      INTERVAL 12 MONTH
//                    ),
//                    '%d/%m/%Y'
//                  ) AS month_12, pack.is_new from (" . $sql . ") as pack ");
//    }

    function packageTime(Request $req) {
        if ($user->use_group == User::TYPE_AffiliateUser) {
            $result = Package::where(['p_type' => 'package_daily']);
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $result
            ]);
        }
    }

    /**
     * @SWG\Post(
     *     path="/api/v1/buy-package",
     *     operationId="buy-package",
     *     description="Đặt mua package",
     *     produces={"application/json"},
     *     tags={"Package"},
     *     summary="Đặt mua package",
     *  @SWG\Parameter(
     *         name="package",
     *         in="body",
     *         description="Id của package",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="numbran",
     *         in="body",
     *         description="So chi nhanh doi vs package 16",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="num_ctv",
     *         in="body",
     *         description="So luong goi tac vien truyen len doi vs package 17",
     *         required=false,
     *         type="integer",
     *     ),
     * 
     *     @SWG\Parameter(
     *         name="period",
     *         in="body",
     *         description="6 tháng truyền 6, 12 tháng truyền 12 tháng . Đối vs miến phí truyền -1 ( Bên họ vẫn chưa cho mua gói free)",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Giá list"
     *     )
     * )
     */
    function buyPackage(Request $req) {
        $inputValidate = [
            'package' => 'required',
            'period' => 'required'
        ];
        if ($req->package == 16) {
            $inputValidate['numbran'] = 'required';
        }
        if ($req->package == 17) {
            $inputValidate['num_ctv'] = 'required';
        }
        $validator = Validator::make($req->all(), $inputValidate);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }

        $package = Package::where(['info_id' => $req->package, 'period' => $req->period])->first();
        if (empty($package)) {
            return response([
                'msg' => Lang::get('package.package_not_found'),
                ], 404);
        }
        if ($package->id == 0) {
            return response([
                'msg' => Lang::get('package.package_not_allow'),
                ], 404);
        }

        $user = $req->user();
        $check = $this->CheckCurrentMyServices($user->use_id, $req->package);
        if (!$check) {
            return response([
                'msg' => Lang::get('package.package_allow_user_package',['name'=>'Proffessional'])
                ], 402);
        }
        $return = $this->addPackage($user, $package, $req);
        return $return;
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/get-available-date",
     *     operationId="get-avaliable-date",
     *     description="Lấy thời gian bắt đầu khi mua package",
     *     produces={"application/json"},
     *     tags={"Package"},
     *     summary="Đặt mua package",
     *     @SWG\Parameter(
     *         name="period",
     *         in="body",
     *         description="6 tháng truyền 6, 12 tháng truyền 12 tháng . Đối vs miến phí truyền -1 ( Bên họ vẫn chưa cho mua gói free)",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="thời gian"
     *     )
     * )
     */
    function apiGetAvailableDate(Request $req) {
        $available_date = $this->getAvailableDate($req->user()->use_id);
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $available_date
            ], 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/package-purchase",
     *     operationId="package-purchase",
     *     description="Danh sách package đang sử dụng",
     *     produces={"application/json"},
     *     tags={"Package"},
     *     summary="Danh sách package đang sử dụng",
     *      @SWG\Parameter(
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
     *         description="thời gian"
     *     )
     * )
     */
    public function serviceUsing(Request $req) {
        $user = $req->user();

        $pu = PackageUser::tableName();
        $pinfo = PackageInfo::tableName();
        $puduser = PackageDailyUser::tableName();
        $pudaily = PackageDaily::tableName();
        $packagedb = Package::tableName();
        $query1 = PackageUser::where(['user_id' => $user->use_id]);
        $query1->select(DB::raw("
                        tbtt_package_user.id,
                        tbtt_package_user.user_id,
                        tbtt_package_user.sponser_id,
                        tbtt_package_user.created_date,
                        tbtt_package_user.begined_date,
                        tbtt_package_user.modified_date,
                        tbtt_package_user.ended_date,
                        tbtt_package_user.payment_status,
                        tbtt_package_user.status,
                        tbtt_package_user.amount,
                        tbtt_package_user.limited as limited,
                        tbtt_package_user.real_amount,
                        tbtt_package.period,
                        tbtt_package.info_id,
                        (SELECT
                          NAME
                        FROM
                          tbtt_package_info
                        WHERE id = tbtt_package.info_id) AS package,

                        tbtt_package.unit_type,
                                                '' as 'content_type',
                        '' AS content_info,
                        'package' AS 'pack_type',
                        0 AS 'content_num'"));
        $query1->leftJoin($packagedb, $packagedb . '.id', $pu . '.package_id');

        $query2 = PackageDailyUser::where(['user_id' => $user->use_id]);
        $query2->select(DB::raw("tbtt_package_daily_user.id,
                        tbtt_package_daily_user.user_id,
                        tbtt_package_daily_user.sponser_id,
                        tbtt_package_daily_user.created_date,
                        tbtt_package_daily_user.begined_date,
                        tbtt_package_daily_user.modified_date,
                        tbtt_package_daily_user.ended_date,
                        tbtt_package_daily_user.payment_status,
                        tbtt_package_daily_user.status,
                        tbtt_package_daily_user.amount,
                        tbtt_package_daily_user.pos_num as limited,
                        tbtt_package_daily_user.real_amount,
                        IF(tbtt_package_daily.p_type = '09', tbtt_package_daily_user.pos_num, tbtt_package_daily.unit) AS period,
                        tbtt_package_daily.p_type as info_id,
                        tbtt_package_daily.p_name AS package,
                        tbtt_package_daily.unit_type,
                        tbtt_package_daily_user.content_type,
                        IF(tbtt_package_daily_user.content_type = 'product',
                          (SELECT
                              GROUP_CONCAT(
                                CONCAT_WS(
                                  ';',
                                  `pro_dir`,
                                  `pro_category`,
                                  `pro_id`,
                                  `pro_name`
                                ) SEPARATOR '#'
                              )
                            FROM
                              `tbtt_package_daily_content` AS di
                              LEFT JOIN `tbtt_product` AS pro
                                ON di.`content_id` = pro.`pro_id`
                                AND di.`content_type` = 'product'
                            WHERE di.`order_id` = tbtt_package_daily_user.id
                           ) ,
                           (
                            SELECT
                              GROUP_CONCAT(
                                CONCAT_WS(
                                  ';',
                                  `id_category`,
                                  `not_id`,
                                  `not_title`
                                ) SEPARATOR '#'
                              )
                            FROM
                              `tbtt_package_daily_content` AS di
                              LEFT JOIN  `tbtt_content` AS c
                                ON c.`not_id` = di.`content_id`
                                AND di.`content_type` = 'news'
                            WHERE di.`order_id` = tbtt_package_daily_user.id
                          )
                        ) AS content_info,
                        'package_daily' AS 'pack_type',
                        tbtt_package_daily_user.content_num"));
        $query2->leftJoin('tbtt_package_daily', 'tbtt_package_daily.id', 'tbtt_package_daily_user.package_id');

        $query1->union($query2);

        $bindings = $query1->getBindings();
        $sql = $query1->toSql();

        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        $sql = str_replace('\\', '\\\\', $sql);

        $query = PackageUser::select(DB::raw('package.*'));

        $query->from(\DB::raw('(' . $sql . ') as package'));

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $results = $query->paginate($limit, ['*'], 'page', $page);


        $datas = [];
        foreach ($results->items() as $item) {


            $item->showDetail = false;
            if ($item->status == 0 && $item->payment_status == 1) {
                $item->showDetail = true;
            }
            if ($item->status == 1 && $item->payment_status == 1) {

                if (strtotime($item->ended_date) > time() || (int) $item->ended_date == 0) {
                    $item->showDetail = true;
                }
            }
            $item->linkType = null;
            if ($item->showDetail == true) {
                if ($item->pack_type == 'package') {

                    if ($item->info_id >= 2 && $item->info_id <= 7) {
                        $item->linkType = 'package';
                    }
                } else {
                    $item->linkType = 'package_daily';
                }
            }
            $data = $item->toArray();
            $data['product_selected'] = null;
            if ($item->pack_type == 'package_daily') {
                if ($item->content_type == 'product') {
                    $item->productSelected;

                    if (!empty($item->productSelected)) {

                        $data['product_selected'] = $item->productSelected->product;
                    }
                } else {
                    $item->newsSelected;
                    if (!empty($item->newsSelected)) {
                        $item->newsSelected->product;
                        $data['product_selected'] = $item->productSelected->product;
                    }
                }
            }
            $datas[] = $data;
        }


        $result = $results->toArray();
        $result['data'] = $datas;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ],200);
    }

    ##Check using services for Shop who register pack open CTV Online
    ## by Bao Tran

    function CheckCurrentMyServices($userId, $packageId) {
    
        if ((int)$packageId !== 17) {
            return true;
        }

        $currentPackage = PackageUser::getCurrentPackage($userId)->first();

        if ($currentPackage && $currentPackage->id == 7) {
            return true;
        } else {
            return false;
        }
    }

    protected function addPackage($user, $package, $req) {
        $package_info = $package->packageInfo;
        $packageSerivedb = PackageService::tableName();
        $servicedb = Service::tableName();
        $amount = $this->getWallet($user->use_id);

        $amount_request = $this->getPackAmount($package);

        $date = date('Y-m-d H:i:s');

        $shop_info = $user->shop;
        $discountShop = 1;
        if (!empty($user->shop)) {
            $discountShop = ($shop_info->sho_discount_rate > 0) ? 1 - ($shop_info->sho_discount_rate) / 100 : 1;
        }
        //Get Số lượng chi nhánh shop mở
        $limited = 1;
        $totalRemain = 0;

        $query = PackageService::where(['package_id' => $amount_request->info_id])->leftJoin($servicedb, $packageSerivedb . '.service_id', $servicedb . '.id');
        $packageSerives = $query->select($packageSerivedb . '.service_id', $servicedb . '.*')->get();
        if ($amount_request->info_id == 16) {
            $limited = $limited * (int) $req->numbran;
        }

        if ($amount_request->info_id == 17) {
            $limited = $limited * (int) $req->num_ctv;
        }
        if ($package->id == 1) {
            $results = PackageUser::where(['user_id' => $user->user_id, 'package_id' => 1])->count();
            if ($results > 0) {
                return response([
                    'msg' => Lang::get('response.package_exitst'),
                    ], 404);
            }

            $request = new PackageUser([
                'package_id' => $package->id,
                'user_id' => $user->use_id,
                'created_date' => $date,
                'begined_date' => $date,
                'payment_status' => 1,
                'payment_date' => $date,
                'status' => 1,
                'amount' => $amount_request->request_amt,
                'real_amount' => $amount_request->request_amt * $discountShop, // Please check request_amt
            ]);
            $request->save();
            if (!empty($packageSerives)) {
                foreach ($packageSerives as $packageSerive) {
                    $packageSave = new PackageUserService([
                        'order_id' => $request->id,
                        'service_id' => $packageSerive->service_id,
                        'note' => $packageSerive->note,
                        'status' => $packageSerive->install == 1 ? 0 : 1,
                    ]);
                    $packageSave->created_date = date('Y-m-d H:i:s');
                    $packageSave->modified_date = date('Y-m-d H:i:s');
                    $packageSave->save();
                }
            }
        } else {
            $totalRemain = 0;
            if ($amount_request->info_id >= 2 && $amount_request->info_id <= 7) {
                if ($req->goline == 1) {
                    $remainData = $this->getRemainAmount($user->use_id);
                    foreach ($remainData as $item) {
                        $totalRemain += $item['amount'] * $item['remain'] / $item['num_date'];
                    }
                }

                if ($amount_request->request_amt * $discountShop > $amount->amount_money + $totalRemain) {
                    return response([
                        'msg' => Lang::get('response.wallet_not_enough'),
                        ], 402);
                }
                if ($totalRemain > 0) {
                    // Tra tien lai cho khach hang
                    $walletReturn = new Wallet([
                        'user_id' => $user->use_id,
                        'group_id' => $user->use_group,
                        'parent_id' => $user->parent_id,
                        'type' => Wallet::TYPE_MONEY,
                        'description' => 'Cộng tiền còn thừa của gói trước',
                        'created_date' => date('Y-m-d H:i:s'),
                        'month_year' => date('m-Y'),
                        'status' => 0
                    ]);
                    $walletReturn->save();
                         PackageUser::where(['user_id' => $user->use_id])->whereRaw('ended_date >= NOW()')
                        ->where(function($q) {
                            $q->whereIn('package_id', function($q) {
                                $q->from('tbtt_package');
                                $q->select('id');
                                $q->where('info_id', '>=', 2);
                            });
                        })->update(['status' => 0]);
                }


                if ($amount_request->request_amt > 0) {
                    $walletReturn = new Wallet([
                        'user_id' => $user->use_id,
                        'group_id' => $user->use_group,
                        'parent_id' => $user->parent_id,
                        'amount' => 0 - $amount_request->request_amt * $discountShop,
                        'type' => Wallet::TYPE_MONEY,
                        'description' => "Mua gói " . $package_info->name,
                        'created_date' => date('Y-m-d H:i:s'),
                        'month_year' => date('m-Y'),
                        'status' => 0
                    ]);
                    $walletReturn->save();
                }
            } else {

                if ($amount_request->request_amt * $discountShop > $amount->amount_money + $amount->amount_point) {
                    return response([
                        'msg' => 'Vui lòng nạp thêm tiền vào tài khoản để đăng ký dịch vụ.!',
                        ], 402);
                }

                if ($amount_request->request_amt > 0) {

                    $use_money = 0;
                    $use_point = 0;
                    if ($amount->amount_point > 0 && $amount->amount_point >= $amount_request->request_amt * $discountShop) {
                        $use_point = $amount_request->request_amt * $discountShop * $limited;
                    } else {
                        $use_point = $amount->amount_point;
                        $use_money = $amount_request->request_amt * $discountShop * $limited - $use_point;
                    }


                    if ($use_point > 0) {

                        $walletReturn = new Wallet([
                            'user_id' => $user->use_id,
                            'group_id' => $user->use_group,
                            'parent_id' => $user->parent_id,
                            'amount' => 0 - $use_point,
                            'type' => Wallet::TYPE_POINT,
                            'description' => 'Mua gói ' . $package_info->name,
                            'created_date' => date('Y-m-d H:i:s'),
                            'month_year' => date('m-Y'),
                            'status' => 0
                        ]);
                        $walletReturn->save();
                    }

                    if ($use_money > 0) {
                        $walletReturn = new Wallet([
                            'user_id' => $user->use_id,
                            'group_id' => $user->use_group,
                            'parent_id' => $user->parent_id,
                            'amount' => 0 - $use_money,
                            'type' => Wallet::TYPE_MONEY,
                            'description' => 'Mua gói ' . $package_info->name,
                            'created_date' => date('Y-m-d H:i:s'),
                            'month_year' => date('m-Y'),
                            'status' => 0
                        ]);
                        $walletReturn->save();
                    }
                }
            }
        }
        $this->insertToService($user, $package, $amount_request, $packageSerives, $discountShop, $totalRemain, $req);
        return response([
            'msg' => Lang::get('response.success'),
            ], 200);
    }

    protected function getPackAmount($package) {

        $query = Package::where('id', $package->id);
        $query->select(DB::raw("
                  IF (
                    discount_rate > 0,
                    ABS(
                      `month_price` * `period` * (100 - `discount_rate`) / 100
                    ),
                    ABS(`month_price` * `period`) 
                  ) AS request_amt, period, info_id"));

        return $query->first();
    }

    protected function getWallet($uid) {

        $query = Wallet::where(['user_id' => $uid]);
        $query->where('status', '<>', 9);
        $query->select(DB::raw("SUM(IF(`type` = '1', `amount`, 0)) AS amount_money,
                  SUM(IF(`type` = '2', `amount`, 0)) AS amount_point"));

        return $query->first();
    }

    function getRemainAmount($uid) {
        $packageUserdb = PackageUser::tableName();
        $packagedb = Package::tableName();
        $query = PackageUser::where([$packageUserdb . '.user_id' => $uid, 'payment_status' => 1, 'status' => 1,
        ]);
        $query->where($packagedb . '.info_id', '>=', 2);
        $query->where($packagedb . '.info_id', '<=', 7);
        $query->leftJoin($packagedb, $packagedb . '.id', $packageUserdb . '.package_id');
        $query->select(DB::raw('amount,
                  DATEDIFF(ended_date, begined_date) AS num_date,
                  IF(
                    begined_date <= NOW(),
                    DATEDIFF(ended_date, NOW()),
                    IF(
                      begined_date > NOW(),
                      DATEDIFF(ended_date, begined_date),
                      0
                    )
                  ) AS remain'));


        return $query->get();
    }

    protected function insertToService($user, $package, $amount_request, $packageSerives, $discountShop, $totalRemain, $req) {
        // Insert dich vu
        $data = [];
        $data['package_id'] = $package->id;
        $data['user_id'] = $user->use_id;
        $data['sponser_id'] = $user->parent_id;

        $data['created_date'] = date('Y-m-d H:i:s');
        if ($amount_request->info_id >= 2 && $amount_request->info_id <= 7) {
            if ($req->goline == 1) {
                $available_date = $this->getGolineAvailableDate($amount_request->period);
            } else {
                $available_date = $this->getAvailableDate($user->use_id, $amount_request->period);
            }


            $data['begined_date'] = $available_date->begin_date;
            $data['ended_date'] = $available_date->ended_date;
        } elseif ($amount_request['period'] == -1) {
            $data['begined_date'] = date('Y-m-d H:i:s');
        }

        $data['payment_status'] = 1;
        $data['payment_date'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        $data['amount'] = $amount_request->request_amt;

        if ($amount_request->info_id == 16) {
            $numbran = (int) $req->numbran;
            $data['limited'] = $numbran;
            $data['amount'] = $amount_request->request_amt * $numbran;
            $data['real_amount'] = ($amount_request->request_amt * $discountShop - $totalRemain) * $numbran;
        } elseif ($amount_request->info_id == 17) {
            $limit = $this->getLimitService($package->id);

            $numctv = (int) $req->num_ctv;
            $data['limited'] = $numctv * $limit->limit;
            $data['amount'] = $amount_request->request_amt * $numctv;
            $data['real_amount'] = ($amount_request->request_amt * $discountShop - $totalRemain) * $numctv;
            $data['ended_date'] = date('Y-m-d H:i:s', strtotime("+12 months"));
        } else {
            $data['real_amount'] = $amount_request['request_amt'] * $discountShop - $totalRemain;
        }
        $order = new PackageUser($data);

        $order->save();
        if (!empty($packageSerives)) {
            foreach ($packageSerives as $packageSerive) {
                $packageUserService = new PackageUserService([
                    'order_id' => $order->id,
                    'service_id' => $packageSerive->service_id,
                    'status' => $packageSerive->install == 1 ? 0 : 1,
                    'note' => $packageSerive->note,
                    'created_date' => date('Y-m-d H:i:s'),
                    'modified_date' => date('Y-m-d H:i:s')
                ]);
                $packageUserService->save();
            }
        }

        $wallet = new Wallet([
            'user_id' => $user->use_id,
            'parent_id' => $user->use_parent_id,
            'group' => $user->use_group,
            'amount' => $package->point > 0 ? $package->point : 0,
            'type' => Wallet::TYPE_POINT,
            'month_year' => date('m-Y'),
            'status' => 0
        ]);
        $wallet->save();
    }

    protected function getGolineAvailableDate($period) {

        $sql = "SELECT
                  NOW() as begin_date,
                  DATE_ADD(NOW(), INTERVAL {$period} MONTH) AS ended_date
                ";
        $query = DB::query($sql)->fist();
        return $query;
    }

    protected function getAvailableDate($uid, $period = 0) {
        $packageUserdb = PackageUser::tableName();
        $packagedb = Package::tableName();
        $query = PackageUser::where([$packageUserdb . '.user_id' => $uid,
                $packageUserdb . '.payment_status' => 1,]);
        $query->where($packagedb . '.info_id', '>=', 2);
        $query->where($packagedb . '.info_id', '<=', 7);
        $query->leftJoin($packagedb, $packagedb . '.id', $packageUserdb . '.package_id');
        $query->select(DB::raw('IF(
                      MAX(tbtt_package_user.ended_date) IS NULL,
                      DATE_ADD(NOW(), INTERVAL 1 SECOND),
                      DATE_ADD(
                        MAX(tbtt_package_user.ended_date),
                        INTERVAL 1 SECOND
                      )
                    ) AS begin_date,
                    IF(
                      MAX(tbtt_package_user.ended_date) IS NULL,
                      1,
                      0
                    ) AS is_new'));
        $fromQuery = Commons::toQueryString($query);

        $lastQuery = PackageUser::select(DB::raw("

                 UNIX_TIMESTAMP(pack.begin_date) as begin_date_time,
                    UNIX_TIMESTAMP(DATE_ADD(pack.begin_date, INTERVAL 1 MONTH)) as month_1_time,
                    UNIX_TIMESTAMP(DATE_ADD(pack.begin_date, INTERVAL 3 MONTH)) as month_3_time,
                    UNIX_TIMESTAMP(DATE_ADD(pack.begin_date, INTERVAL 6 MONTH)) as month_6_time,
                    UNIX_TIMESTAMP(DATE_ADD(pack.begin_date, INTERVAL 12 MONTH)) as month_12_time,
                    UNIX_TIMESTAMP(DATE_ADD(pack.begin_date, INTERVAL {$period} MONTH)) AS ended_date_time,
                     pack.begin_date,
                    DATE_ADD(pack.begin_date, INTERVAL 1 MONTH) as month_1,
                    DATE_ADD(pack.begin_date, INTERVAL 3 MONTH) AS month_3,
                    DATE_ADD(pack.begin_date, INTERVAL 6 MONTH) AS month_6,
                    DATE_ADD(pack.begin_date,INTERVAL 12 MONTH) as month_12,
                  DATE_ADD(pack.begin_date, INTERVAL {$period} MONTH) AS ended_date,
                  pack.is_new"))->from(DB::raw('(' . $fromQuery . ') as pack'));


        return $lastQuery->first();
    }

    protected function getLimitService($pack_id) {

        $packageServicedb = PackageService::tableName();
        $servicedb = Service::tableName();
        $packagedb = Package::tableName();
        $query = Service::where([$packagedb . '.id' => $pack_id]);
        $query->join($packageServicedb, $packageServicedb . '.service_id', $servicedb . '.id');
        $query->join($packagedb, $packagedb . '.id', $packageServicedb . '.package_id');
        $query->select('limit');

        return $query->first();
    }

    function addPackageDaily($userObject, $package, $regisdate, $amount_request, $pos_num, $content_type, $p_type = '', $position, $package_name, $pid = 0) {

        $amount = $this->getWallet($userObject->use_id);
        $date = date('Y-m-d H:i:s');


        /* if ($amount_request > $amount['amount_money'] + $amount['amount_point']) {
          return array('error' => true, 'message' => 'Vui lòng nạp thêm tiền vào tài khoản để đăng ký dịch vụ. Click <a class="link_popup" href="'.base_url().'account/addWallet">vào đây</a> để nạp tiền!');
          } */

        //$package_name = $this->getPackageNme($package);
        // Tru tien
        $use_money = 0;
        $use_point = 0;
        if ($amount['amount_point'] > 0 && $amount['amount_point'] >= $amount_request['request_amt']) {
            $use_point = $amount_request;
        } else {
            $use_point = $amount['amount_point'];
            $use_money = $amount_request - $use_point;
        }

        if ($use_point > 0) {
            $data = array();
            $data['group_id'] = $userObject->use_group;
            $data['parent_id'] = $userObject->parent_id;
            $data['amount'] = 0 - $use_point;
            $data['`type`'] = '2';
            $data['description'] = 'Mua gói ' . $package_name;
            $data['created_date'] = $date;
            $data['month_year'] = date('m-Y');
            $data['`status`'] = '0';
            $wallet = new Wallet($data);
            $wallet->user_id = $userObject->use_id;
            $wallet->save();
        }
        if ($use_money > 0) {
            $data = array();

            $data['group_id'] = $userObject->use_group;
            $data['parent_id'] = $userObject->parent_id;
            $data['amount'] = 0 - $use_money;
            $data['`type`'] = '1';
            $data['description'] = 'Mua gói ' . $package_name;
            $data['created_date'] = $date;
            $data['month_year'] = date('m-Y');
            $data['`status`'] = '0';
            $wallet = new Wallet($data);
            $wallet->user_id = $userObject->use_id;
            $wallet->save();
        }
        // Dang ky goi moi
        $data = array();
        $data['package_id'] = $package;
        $data['sponser_id'] = $userObject->parent_id;
        $data['created_date'] = $date;
        $data['begined_date'] = $regisdate;
        $regisdate_tt = strtotime($regisdate);
        $ended_date = date("Y-m-d", $regisdate_tt) . ' 23:59:00';
        $data['ended_date'] = $ended_date;
        $data['payment_status'] = 1;
        $data['payment_date'] = $date;
        $data['status'] = 1;
        $data['amount'] = $amount_request;
        $data['real_amount'] = $amount_request;
        $data['pos_num'] = $pos_num;
        $data['content_type'] = $content_type;
        $data['p_type'] = $p_type;
        $data['position'] = $position;
        $packageDailyUser = new PackageDailyUser($data);

        $packageDailyUser->user_id = $userObject->use_id;
        $packageDailyUser->save();
        $packageDailyContent = new PackageDailyContent([
            "order_id" => $packageDailyUser->id,
            "content_id" => $pid,
            "begin_date" => $regisdate,
            "pos_num" => $pos_num,
            "p_type" => $p_type,
            "content_type" => $content_type
        ]);
        $packageDailyContent->save();

        /* return array('error' => false, 'message' => 'Thành công'); */
    }

    function addShelfPackage($userObject, $package, $amount_request, $period, $content_num, $content_type, $p_type = '', $package_name) {
        $amount = $this->getWallet($userObject->use_id)->toArray();
        $date = date('Y-m-d H:i:s');

        if ($amount_request > $amount['amount_money'] + $amount['amount_point']) {
            return response([
                'msg' => 'Vui lòng nạp thêm tiền vào tài khoản để đăng ký dịch vụ',
                ], 422);
        }


        // Tru tien
        $use_money = 0;
        $use_point = 0;
        if ($amount['amount_point'] > 0 && $amount['amount_point'] >= $amount_request['request_amt']) {
            $use_point = $amount_request;
        } else {
            $use_point = $amount['amount_point'];
            $use_money = $amount_request - $use_point;
        }

        if ($use_point > 0) {
            $data = array();
            $data['group_id'] = $userObject->use_group;
            $data['parent_id'] = $userObject->parent_id;
            $data['amount'] = 0 - $use_point;
            $data['`type`'] = '2';
            $data['description'] = 'Mua gói ' . $package_name;
            $data['created_date'] = $date;
            $data['month_year'] = date('m-Y');
            $data['`status`'] = '0';
            $wallet = new Wallet($data);
            $wallet->user_id = $userObject->use_id;
            $wallet->save();
        }
        if ($use_money > 0) {
            $data = array();

            $data['group_id'] = $userObject->use_group;
            $data['parent_id'] = $userObject->parent_id;
            $data['amount'] = 0 - $use_money;
            $data['`type`'] = '1';
            $data['description'] = 'Mua gói ' . $package_name;
            $data['created_date'] = $date;
            $data['month_year'] = date('m-Y');
            $data['`status`'] = '0';
            $wallet = new Wallet($data);
            $wallet->user_id = $userObject->use_id;
            $wallet->save();
        }
        $pack_date = $this->getAvailableDate($uid, $period);
        // Dang ky goi moi
        $data = array();
        $data['package_id'] = $package;
        $data['user_id'] = $uid;
        $data['sponser_id'] = $userObject->parent_id;
        $data['created_date'] = $date;
        $data['ended_date'] = $pack_date['ended_date'];
        $data['begined_date'] = $pack_date['begin_date'];
        $data['payment_status'] = 1;
        $data['payment_date'] = $date;
        $data['status'] = 1;
        $data['amount'] = $amount_request;
        $data['real_amount'] = $amount_request;
        $data['pos_num'] = $period;
        $data['content_num'] = $content_num;
        $data['content_type'] = $content_type;
        $data['p_type'] = $p_type;
        $packageDailyUser = new PackageDailyUser($data);

        $packageDailyUser->user_id = $userObject->use_id;
        $packageDailyUser->save();
        return response([
            'msg' => Lang::get('response.success')
        ]);
    }

}
