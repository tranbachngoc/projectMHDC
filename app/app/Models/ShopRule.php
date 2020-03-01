<?php

namespace App\Models;

use App\BaseModel;

/**
 * Shop model
 *
 */
class ShopRule extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    const TYPE_AFFILIATE = 0;
    const TYPE_BRANCH = 3;

    protected $table = 'tbtt_shop_rule';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_shop_rule';
    }
    
       protected $fillable = [
        'sho_id',
        'shop_rule_ids',
        'up_date'
    ];
    protected $defaults = array(
        'bran_rule' => ''
        
    );

    public function __construct(array $attributes = array()) {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

}
