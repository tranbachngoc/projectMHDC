<?php

namespace App\Models;
use App\BaseModel;
use App\Models\User;
use App\Models\ChatThreadUser;
use DB;
use DateTime;

/**
 * ChatUser model
 *
 */
class ChatMessageRead extends BaseModel {

    protected $table = 'chatmessageread';
    protected static $table_name = 'chatmessageread';
    protected $fillable = [
        'userId',
        'threadId',
        'messageId',
        'statusRead'

    ];

    public static function createRowMessage($params) {
        $threadId = $params['threadId'];
        $userLogin = $params['userLogin'];
        $listUser = ChatThreadUser::where(['threadId' => $threadId, 'accept_request' => 1])->select("userId")->get();
        $insert = true;
        if($listUser) {
            foreach ( $listUser as $k => $v ) {
                if( $v['userId'] == $userLogin) {
                    $insert = DB::table(ChatMessageRead::$table_name)->insert([
                    'messageId' => $params['messageId'],
                    'threadId' => $params['threadId'],
                    'statusRead' => 1,
                    'userId' => $v['userId']
                ]);
                }
                else {
                    $insert = DB::table(ChatMessageRead::$table_name)->insert([
                    'messageId' => $params['messageId'],
                    'threadId' => $params['threadId'],
                    'statusRead' => 0,
                    'userId' => $v['userId']
                ]);
                }

            }
        }

        return $insert;
    }


    public static function createRowMessageUser($params) {
        $threadId = $params['threadId'];
        $userId = $params['userId'];
        $messageId = $params['messageId'];
        $insert = DB::table(ChatMessageRead::$table_name)->insert([
                    'messageId' => $messageId,
                    'threadId' => $threadId,
                    'statusRead' => 0,
                    'userId' => $userId
                ]);

        return $insert;
    }


    public static function updateMessage($userId, $threadId) {
        $update = ChatMessageRead::where(['threadId' => $threadId, 'userId' => $userId,'statusRead' => 0])
                    ->update(['statusRead' => 1]);
        return $update;

    }








}
