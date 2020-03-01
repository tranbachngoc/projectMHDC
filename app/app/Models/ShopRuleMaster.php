<?php

namespace App\Models;

use App\BaseModel;

/**
 * Shop model
 *
 */
class ShopRuleMaster extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    const TYPE_AFFILIATE = 0;
    const TYPE_BRANCH = 3;

    protected $table = 'tbtt_master_shop_rule';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_master_shop_rule';
    }

}
