<?php

namespace App\Models;

use App\BaseModel;
use DB;
use DateTime;
use App\Models\User;



/**
 * Category model
 *
 */
class ChatEmoij extends BaseModel {

    protected $table = 'chatemoij';
    protected $fillable = [
        'emoij'

      ];

    public static function getList() {
        $list = ChatEmoij::select("*")->orderby('id', 'asc')->get()->toArray();
        return $list;

    }



}
