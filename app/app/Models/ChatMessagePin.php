<?php

namespace App\Models;
use App\BaseModel;
use App\Models\User;
use DB;
use DateTime;

/**
 * ChatUser model
 *
 */
class ChatMessagePin extends BaseModel {

    protected $table = 'chatmessages_pin';
    protected static $table_name = 'chatmessages_pin';
    protected $fillable = [
        'userId',
        'threadId',
        'messageId',
        'pin'

    ];

}