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
class ChatCountCall extends BaseModel {

    protected $table = 'chat_countcall';
    protected $fillable = [
        'userId',
        'count'

    ];


}
