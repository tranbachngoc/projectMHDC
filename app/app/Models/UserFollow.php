<?php

namespace App\Models;

use App\BaseModel;

/**
 * Order model
 *
 */
class UserFollow extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_user_follow';

    protected $primaryKey = 'id';
    
    public $timestamps = true;

    public static function tableName() {
        return 'tbtt_user_follow';
    }

    protected $fillable = [
        'user_id',
        'follower',
        'hasFollow'
    ];
}
