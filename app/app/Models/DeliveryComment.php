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
class DeliveryComment extends BaseModel{
    //put your code here
    protected $table = 'tbtt_delivery_comments';
   
    public $timestamps = false;
    
     protected $fillable = [
         'id_request',
         'status_changedelivery',
         'user_id',
         'content',
         'status_comment',
         'lastupdated'
         ];
//    protected $casts = [
//        'min' => 'integer',
//        'max' => 'integer',
//        'percent' => 'integer'
//    ];
    public function user() {
        return $this->hasOne('App\Models\User', 'use_id', 'user_id');
    }

}
