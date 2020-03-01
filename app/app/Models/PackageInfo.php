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
class PackageInfo extends BaseModel {
    const TYPE_PUBLISH = 1;
    protected $table = 'tbtt_package_info';
    public $wasNew = false;
    public $timestamps = false;
     public static function tableName(){
        return 'tbtt_package_info';
    }
    
    public function priceMonth(){
        return $this->hasMany('App\Models\Package','info_id','id')->where(function($q){
            $q->orWhere('id',1);
            $q->orWhere(function($q){
               $q->where('month_price','>',0);
               $q->where('period','>',6);
            });
        })->where(['published'=>1]);
    }

}
