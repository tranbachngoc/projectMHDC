<?php

namespace App\Models;

use App\BaseModel;

/**
 * Category model
 *
 */
class BranchConfig extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    const STATUS_ACTIVE = 1;
    protected $table = 'tbtt_config_branch';

    protected $primaryKey = 'id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_config_branch';
    }
    
      protected $fillable = [
        'shop_id',
        'bran_id',
        'parent_id',
        'config_rule',
        'createdate',
    ];

}
