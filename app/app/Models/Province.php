<?php

namespace App\Models;

use App\BaseModel;

/**
 * Province model
 *
 */
class Province extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_province';

    protected $primaryKey = 'pre_id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_province';
    }
}
