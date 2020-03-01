<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
/**
 * Description of lCommissionAff
 *
 * @author hoanvu
 */
class CommisionUserAff extends BaseModel{
    //put your code here
    protected $table = 'tbtt_detail_commission_aff';
    protected $fillable = ['commissid_percent', 'percent_aff', 'note'];
    public $timestamps = false;
//    protected $casts = [
//        'min' => 'integer',
//        'max' => 'integer',
//        'percent' => 'integer'
//    ];
    
    public function user(){
       return $this->hasOne('App/Models/User','aff_id','use_id');
    }
}
