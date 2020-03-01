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
class ChatFacePhone extends BaseModel {

    protected $table = 'chatfacephone';
    protected static $table_name = 'chatfacephone';
    protected $fillable = [
        'userId',
        'face_id',
        'face_name',
        'face_picture',
        'phone_name'


      ];

    public static function updateInfo($arrInfo) {
      $userId = $arrInfo['userId'];
      $check = ChatFacePhone::where("userId", $userId)->first();
      if($check) {
        //update
        return  DB::table(ChatFacePhone::$table_name)->where(['userId' => $userId])->update($arrInfo);
      }
      else {
           return DB::table(ChatFacePhone::$table_name)->insert($arrInfo);
      }

    }





}
