<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
use App\Models\Package;
use App\Models\PackageInfo;
use DB;
/**
 * Description of PackageUser
 *
 * @author hoanvu
 */
class PackageUser extends BaseModel {

    protected $table = 'tbtt_package_user';
    public $wasNew = false;
    public $timestamps = false;
    const STATUS_ACTIVE = 1;
    const PAYMENT_DONE = 1;
    public static function tableName(){
        return 'tbtt_package_user';
    }
    
       protected $fillable = [
        'package_id',
        'user_id',
        'created_date',
        'begined_date',
        'payment_status',
        'payment_date',
        'status',
        'amount',
        'real_amount',
        'limited',
        'sponser_id',
        'ended_date'
    ];
    protected $defaults = array(
        'limited' => 0,

    );
    protected $casts =[
        'info_id'=>'integer',
        'period'=>'integer'
    ];

    public function __construct(array $attributes = array()) {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    public function service() {
    	return self::where('tbtt_package_user.package_id', $this->package_id)
		->join('tbtt_package_service as service', 'tbtt_package_user.package_id','service.package_id')
        ->join('tbtt_service', 'service.service_id','tbtt_service.id')
    	->first();
    }
    
    static function getCurrentPackage($uid) {

        $select = 'tbtt_package_info.`name`,
                   tbtt_package_info.id,                    
                   tbtt_package.`period`,
                   tbtt_package.`id` AS ID,
                   tbtt_package_user.status,
                   tbtt_package_user.`payment_status`,
                   tbtt_package_user.`created_date`,
                   tbtt_package_user.`begined_date`,
                   tbtt_package_user.`ended_date`';
        $packageUserdb = self::tableName();
        $packagedb = Package::tableName();
        $packageInfodb = PackageInfo::tableName();

        $query = PackageUser::where([
                $packageUserdb . '.status' => PackageUser::STATUS_ACTIVE,
                $packageUserdb . '.payment_status' => PackageUser::PAYMENT_DONE])
            ->join($packagedb, $packagedb . '.id', $packageUserdb . '.package_id')
            ->join($packageInfodb, $packageInfodb . '.id', $packagedb . '.info_id')
            ->where($packageUserdb . '.user_id', $uid)
            ->where($packagedb . '.info_id', '>=', 2)
            ->where($packagedb . '.info_id', '<=', 7)
            ->whereRaw('NOW() >= ' . $packageUserdb . '.begined_date')
            ->whereRaw('(NOW() <= ' . $packageUserdb . '.ended_date OR ' . $packageUserdb . '.ended_date IS NULL)')
            ->orderBy($packageUserdb . '.id', 'desc');
        $query->select(DB::raw($select));
        return $query;
    }

    public function productSelected() {

        return $this->hasOne('App\Models\PackageDailyContent', 'order_id', 'id')->where('content_type', 'product');
    }

    public function newSelected() {
        return $this->hasOne('App\Models\PackageDailyContent', 'order_id', 'id')->where('content_type', 'news');
    }
    
    static function addFreePackage($user, $package) {
        $packageUserExtis = self::where(['user_id'=>$user->use_id,'status'=>0])->first();
        $date = date('Y-m-d H:i:s');
        $servicedb = Service::tableName();
        $packageSerivcedb = PackageService::tableName();
        if (empty($packageUserExtis)) {
          //  $packageFree = Package::where(['id' => $package])->first();
            $packageServices = PackageService::where(['package_id' => $package])
                    ->select('service_id', 'install', 'note')
                    ->leftJoin($servicedb, $packageSerivcedb . '.service_id', $servicedb . '.id')->get();
            $packageUser = new PackageUser();
            $packageUser->package_id = $package;
            $packageUser->user_id = $user->use_id;
            $packageUser->sponser_id = $user->parent_id;
            $packageUser->created_date = $date;
            $packageUser->modified_date = $date;
            $packageUser->begined_date = $date;
            $packageUser->payment_status = 1;
            $packageUser->payment_date = $date;
            $packageUser->ended_date  = date('Y-m-d H:i:s', strtotime("+3 months"));

            $packageUser->status = 1;
            $packageUser->amount = 0;
//            if ($packageFree->discount_rate > 0) {
//                $packageUser->amount = $packageFree->month_price * $packageFree->period * (100 - $packageFree->discount_rate) / 100;
//            } else {
//                $packageUser->amount = $packageFree->month_price * $packageFree->period;
//            }
            $packageUser->save();
         
            foreach ($packageServices as $packageService) {
                $packageUserService = new PackageUserService();
                $packageUserService->order_id = $packageUser->id;
                $packageUserService->service_id = $packageService->service_id;
                $packageUserService->status = $packageService->install == 1 ? 0 : 1;
                $packageUserService->note = $packageService->note;
                $packageUserService->created_date = $date;
                $packageUserService->modified_date = $date;

                $packageUserService->save();
                
            }





            //return array('error'=>false, 'message'=>'Thành công');
        }
    }

}
