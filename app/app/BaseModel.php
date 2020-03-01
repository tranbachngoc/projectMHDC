<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * base user model
 */
class BaseModel extends Model {

    public $wasNew = false;

    public function save(array $options = array()) {
        if (!$this->exists) {
            $this->wasNew = true;
        }

        parent::save($options);
    }
}
