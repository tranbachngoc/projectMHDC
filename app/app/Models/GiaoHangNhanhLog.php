<?php

namespace App\Models;

use App\BaseModel;

/**
 * District model
 *
 */
class GiaoHangNhanhLog extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_ghn_log';

    protected $primaryKey = 'id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_ghn_log';
    }
    
    protected $fillable = [
        'OrderCode',
        'TotalFee',
        'owner',
        'logaction',
        'lastupdated'
    ];

}
