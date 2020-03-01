<?php

namespace App\Models;

use App\BaseModel;

/**
 * Order model
 *
 */
class UserReceive extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_user_receive';

    protected $primaryKey = 'id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_user_receive';
    }
 

    public function publicProfile() {
        $attr = $this->getAttributes();

        $attr['district'] = $this->district;
        return $attr;
    }

    public function district() {
       return $this->hasOne('App\Models\District', 'DistrictCode','ord_district')->select([
            'DistrictName', 'ProvinceName'
        ]);
    }

    protected $fillable = [
        'ord_sname',
        'ord_saddress',
        'ord_province',
        'ord_district',
        'ord_smobile',
        'ord_note',
        'ord_semail'
    ];


    

}
