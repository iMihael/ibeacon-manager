<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Beacon extends ActiveRecord {
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
        return '{{%beacon}}';
    }

    public function rules() {
        return [
            [['identifier', 'uuid', 'major', 'minor'], 'required', 'on' => 'create'],
            [['major', 'minor'], 'integer'],
            ['userId', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
        ];
    }

    public function attributeLabels() {
        return [
            'uuid' => 'Proximity UUID'
        ];
    }
}