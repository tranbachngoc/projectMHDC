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
class ServiceGroup extends BaseModel {

    protected $table = 'tbtt_service_group';
    public $wasNew = false;
    public $timestamps = false;

       public static function tableName() {
        return 'tbtt_service_group';
    }
}
