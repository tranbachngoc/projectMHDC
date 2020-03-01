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
class Manufacturer extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_manufacturer';

    protected $primaryKey = 'man_id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_manufacturer';
    }
}
