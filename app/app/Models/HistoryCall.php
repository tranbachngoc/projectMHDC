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
class HistoryCall extends BaseModel {

    protected $table = 'chat_history_call';
    protected $fillable = [
        'callId',
        'userDelete'
    ];

    public function showInfo() {

    }


}
