<?php

namespace App\Models;

use App\BaseModel;
use App\Models\User;
use DB;

/**
 * Category model
 *
 */
class ChatUserAlias extends BaseModel {

    protected $table = 'chatuseralias';
    protected static $table_name = 'chatuseralias';
    protected $fillable = [
        'userId',
        'userId_alias',
        'name_alias'
    ];

    public static function tableName() {
        return 'chatuseralias';
    }


    public static function updateAlias($arrData) {
        $tablename = ChatUserAlias::tableName();
        $info = ChatUserAlias::where(['userId' => $arrData['userId'], 'userId_alias' => $arrData['userId_alias']])->first();
        if($info) {
            return DB::table($tablename)
                        ->where(['userId' => $arrData['userId'], 'userId_alias' => $arrData['userId_alias']])
                        ->update($arrData);
        }
        else {
            $id = DB::table($tablename)->insertGetId($arrData);
              return $id;
        }

    }

}
