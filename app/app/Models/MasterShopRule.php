<?php


namespace App\Models;

use App\BaseModel;


/**
 * Manufacturer model
 *
 */
/**
 * @SWG\Tag(
 *   name="Manufacturer",
 *   description="Nhà sản xuất",
 * )
 */
class MasterShopRule extends BaseModel {
       
    protected $table = 'tbtt_master_shop_rule';

    protected $primaryKey = 'id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_master_shop_rule';
    }
    //put your code here
}
