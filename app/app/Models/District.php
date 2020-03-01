<?php

namespace App\Models;

use App\BaseModel;

/**
 * District model
 *
 */
class District extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_district';

    protected $primaryKey = 'id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_district';
    }
}
