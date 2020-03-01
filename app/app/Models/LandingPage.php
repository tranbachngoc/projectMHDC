<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
/**
 * Description of LandingPage
 *
 * @author hoanvu
 */
class LandingPage extends BaseModel{
     protected $table = 'tbtt_landing_page';

    //put your code here

    public function url() {
        $this->url = env('APP_FONTEND_URL') . '/' . 'landing_page/id/' . $this->id . '/' . str_slug($this->name);
    }

    public static function tableName() {
        return 'tbtt_landing_page';
    }

    public $timestamps = false;

    public function user() {
        return $this->hasOne('App\Models\User', 'use_id', 'user_id');
    }

}
