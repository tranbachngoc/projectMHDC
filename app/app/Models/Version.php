<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
/**
 * Description of Wallet
 *
 * @author hoanvu
 */
class Version extends BaseModel {

    public $timestamps = false;
    protected $primaryKey = 'id';

    public static function tableName() {
        return 'version';
    }
        protected $fillable = [
        'version',
        'os',
        'lastversion'
    ];

}
