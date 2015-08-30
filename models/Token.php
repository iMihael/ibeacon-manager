<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Token extends ActiveRecord {

    public static function createToken($userId) {
        $t = new self();
        $t->value = sha1(time() . mt_rand(0, 1000));
        $t->userId = $userId;
        $t->save();
        return $t;
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public static function tableName() {
        return '{{%token}}';
    }

    public function rules() {
        return [];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}