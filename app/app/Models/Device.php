<?php

namespace App\Models;

use App\BaseModel;

class Device extends BaseModel {
    const TYPE_ANDROID = 'android';
    const TYPE_IOS = 'ios';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_devices';

    public $timestamps = false;

    protected $fillable = ['type', 'userId', 'active', 'token', 'imei', 'token_voip'];
}
