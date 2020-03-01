<?php

namespace App\Models;

use App\BaseModel;
use App\Observers\ForgotPasswordObserver;
/**
 * District model
 *
 */
class ForGot extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_forgot';

    protected $primaryKey = 'for_id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_forgot';
    }
    
    
    protected $fillable = [
        'for_password',
        'for_salt',
        'for_email',
        'for_key'
    ];
    
    
    public static function boot() {
        parent::boot();
        
        static::observe(new ForgotPasswordObserver());
    }

}
