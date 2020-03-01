<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
/**
 * Description of PackageUser
 *
 * @author hoanvu
 */
class Package extends BaseModel {

    const TYPE_PUBLISH = 1;

    protected $table = 'tbtt_package';
    public $wasNew = false;
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_package';
    }
    
    public function  packageService(){
        return $this->hasOne('App\Models\PackageService','package_id','id');
    }
    public function packageInfo(){
         return $this->hasOne('App\Models\PackageInfo','id','info_id');
    }

}
