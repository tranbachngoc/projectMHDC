<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
/**
 * Description of PackageDailyUser
 *
 * @author hoanvu
 */
class PackageDaily  extends BaseModel{
     protected $table = 'tbtt_package_daily';

    const TYPE_KE_HANG = '09';

    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_package_daily';
    }
    
    public function price(){
        return $this->hasOne('App\Models\PackageDailyPrice','package_id','id');
    }
/* Lấy tổng số kệ hàng  */

  

}
