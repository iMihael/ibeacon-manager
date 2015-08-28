<?php

namespace app\models;

use yii\db\ActiveQuery;

class BaseQuery extends ActiveQuery {

    public function __construct($class, $config = []) {
        parent::__construct($class, $config);
        $this->where = ['deletedAt' => null];
    }

    public function withDeleted() {
        return $this->where = [];
    }
}