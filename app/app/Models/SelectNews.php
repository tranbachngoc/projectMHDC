<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
/**
 * Description of SelectNews
 *
 * @author hoanvu
 */
class SelectNews extends BaseModel {
    protected $table = 'tbtt_chontin';
    protected $primaryKey = 'not_id';
    public $timestamps = false;
    protected $fillable = [
        'sho_user',
        'not_id',
    ];

    public function user() {
        return $this->hasOne('App\Models\User', 'use_id', 'sho_user')->select(['use_id', 'use_username', 'avatar', 'use_fullname', 'use_phone']);
    }

    //put your code here
}
