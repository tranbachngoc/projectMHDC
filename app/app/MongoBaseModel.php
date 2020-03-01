<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * base user model
 */
class MongoBaseModel extends Model {
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public $wasNew = false;

    public function save(array $options = array()) {
        if (!$this->exists) {
            $this->wasNew = true;
        }

        parent::save($options);
    }
}
