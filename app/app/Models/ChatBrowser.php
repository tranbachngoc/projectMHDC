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
class ChatBrowser extends BaseModel {

    protected $table = 'chatbrowser';
    protected $fillable = [
        'title',
        'icon',
        'link',
        'type',
        'userId',
        'created_ts',
        "descr",
        "descrImg"

      ];



}
