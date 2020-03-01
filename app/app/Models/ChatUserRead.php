<?php

namespace App\Models;
use App\BaseModel;
use App\Models\User;
use App\Models\ChatUserInvite;
use App\Models\ChatMessageRead;
use DB;
use DateTime;

/**
 * ChatUser model
 *
 */
class ChatUserRead extends BaseModel {

    protected $table = 'chatuserread';
    protected static $table_name = 'chatuserread';
    protected $fillable = [
        'userId',
        'threadId',
        'countUnread'

    ];


    public static function getSumCountUnread($userId, $arrThread) {
       $sum =  DB::table(ChatUserRead::$table_name)
        ->where('userId', '=', $userId)
        ->whereIn("threadId", $arrThread)
        ->sum('countUnread');
        if($sum) {
            return intval($sum);
        }
        else {
            return 0;
        }
    }


    public static function getSumCountUnreadOfUser($userId) {
       $sum =  DB::table(ChatUserRead::$table_name)
        ->where('userId', '=', $userId)
        ->sum('countUnread');
        if($sum) {
            return intval($sum);
        }
        else {
            return 0;
        }
    }




    public static function updateCountMessageUnread($threadId, $userId) {
        $listUserThread = ChatThreadUser::where("threadId", "=", $threadId)
            ->where("userId", "<>", $userId)
            ->where("accept_request", "=", 1)->select("userId")->get();
        if($listUserThread) {
            foreach( $listUserThread as $k => $v ) {
                $userIdThread = $v['userId'];
                $check =  DB::table(ChatUserRead::$table_name)
                            ->where(['userId' => $userIdThread, 'threadId' => $threadId])
                            ->first();
                if($check) {
                    $countUnread = $check->countUnread + 1;
                    DB::table(ChatUserRead::$table_name)
                            ->where(['userId' => $userIdThread, 'threadId' => $threadId])
                            ->update(['countUnread' => $countUnread]);
                }
                else {
                    DB::table(ChatUserRead::$table_name)
                            ->insert(['userId' => $userIdThread, 'threadId' => $threadId, 'countUnread' => 1]);

                }
            }
        }
    }

    public static function setRead($userId, $threadId) {
        $check =  DB::table(ChatUserRead::$table_name)
                            ->where(['userId' => $userId, 'threadId' => $threadId])
                            ->first();
        if($check) {
            DB::table(ChatUserRead::$table_name)
                            ->where(['userId' => $userId, 'threadId' => $threadId])
                            ->update(['countUnread' => 0]);
        }
        ChatMessageRead::updateMessage($userId, $threadId);
    }


    public static function updateCountMessageUnreadUser($threadId, $userId) {
        $check =  DB::table(ChatUserRead::$table_name)
                        ->where(['userId' => $userId, 'threadId' => $threadId])
                        ->first();
            if($check) {
                $countUnread = $check->countUnread + 1;
                DB::table(ChatUserRead::$table_name)
                        ->where(['userId' => $userId, 'threadId' => $threadId])
                        ->update(['countUnread' => $countUnread]);
            }
            else {
                DB::table(ChatUserRead::$table_name)
                        ->insert(['userId' => $userId, 'threadId' => $threadId, 'countUnread' => 1]);

            }
    }


    public static function getSumCountUnreadPrivate($userId) {
       $listUserThread = ChatThreadUser::join("chatthreads","chatthreads.id","=","chatthreaduser.threadId")
            ->where("chatthreaduser.userId", "=", $userId)
            ->where("chatthreads.userDeleteGroup", "<>", $userId)
            //->where("chatthreads.type", "=", 'private')
            ->whereIn("chatthreads.type", ['private','secret'])
            ->where("chatthreaduser.accept_request", "=", 1)->select("chatthreaduser.threadId")->get();
        $arrThreads  = [];
        if( count($listUserThread) > 0) {
                foreach( $listUserThread as $k => $v) {
                    $arrThreads[] = $v['threadId'];
                }
        }
       $sum =  DB::table(ChatUserRead::$table_name)
        ->where('userId', '=', $userId)
        ->whereIn("threadId", $arrThreads)
        ->sum('countUnread');
        if($sum) {
            return intval($sum);
        }
        else {
            return 0;
        }
    }

    public static function getSumCountUnreadGroup($userId) {
       $listUserThread = ChatThreadUser::join("chatthreads","chatthreads.id","=","chatthreaduser.threadId")
            ->where("chatthreaduser.userId", "=", $userId)
            ->where("chatthreads.userDeleteGroup", "<>", $userId)
            ->where("chatthreads.type", "=", 'group')
            ->where("chatthreaduser.accept_request", "=", 1)->select("chatthreaduser.threadId")->get();
        $arrThreads  = [];
        if( count($listUserThread) > 0) {
                foreach( $listUserThread as $k => $v) {
                    $arrThreads[] = $v['threadId'];
                }
        }
       $sum =  DB::table(ChatUserRead::$table_name)
        ->where('userId', '=', $userId)
        ->whereIn("threadId", $arrThreads)
        ->sum('countUnread');
        if($sum) {
            $sumInvite = ChatUserInvite::getSumCountInvite($userId);
            return intval($sum) + intval($sumInvite);
        }
        else {
            $sumInvite = ChatUserInvite::getSumCountInvite($userId);
            return $sumInvite;
        }
    }



}
