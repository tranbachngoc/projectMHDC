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
class ChatMessageDelete extends BaseModel {

    protected $table = 'chatmessagedelete';
    protected $fillable = [
        'userId',
        'messageId'

      ];



}
