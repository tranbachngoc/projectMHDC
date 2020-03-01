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
class ChatUserInvite extends BaseModel {

    protected $table = 'chatuserinvite';
    protected static $table_name = 'chatuserinvite';
    protected $fillable = [
        'userId',
        'countInvite',
        'createdAt',
        'updatedAt'

    ];


    public static function getSumCountInvite($userId) {
       $sum =  DB::table(ChatUserInvite::$table_name)
        ->where('userId', '=', $userId)
        ->sum('countInvite');
        return intval($sum);
    }

    public static function updateCountInvite($userId) {
        $check =  DB::table(ChatUserInvite::$table_name)
                    ->where(['userId' => $userId])
                    ->first();
        if($check) {
            $countInvite = $check->countInvite + 1;
            DB::table(ChatUserInvite::$table_name)
                    ->where(['userId' => $userId])
                    ->update(['countInvite' => $countInvite, 'updatedAt' => date('Y-m-d h:i:s')]);
        }
        else {
            DB::table(ChatUserInvite::$table_name)
                    ->insert(['userId' => $userId, 'countInvite' => 1, 'createdAt' =>date('Y-m-d h:i:s'),'updatedAt' =>date('Y-m-d h:i:s') ]);
        }
    }

    public static function minusCountInvite($userId) {
        $check =  DB::table(ChatUserInvite::$table_name)
                    ->where(['userId' => $userId])
                    ->first();
        if($check) {
            $countInvite = $check->countInvite - 1;
            if($countInvite < 0) {
                $countInvite = 0;
            }
            DB::table(ChatUserInvite::$table_name)
                    ->where(['userId' => $userId])
                    ->update(['countInvite' => $countInvite, 'updatedAt' => date('Y-m-d h:i:s')]);
        }

    }


    public static function setInviteRead($userId) {
        $check =  DB::table(ChatUserInvite::$table_name)
                            ->where(['userId' => $userId])
                            ->first();
        if($check) {
            DB::table(ChatUserInvite::$table_name)
                            ->where(['userId' => $userId])
                            ->update(['countInvite' => 0]);
        }
    }



}
