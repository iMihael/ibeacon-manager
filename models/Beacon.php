<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use Yii;

class BeaconQuery extends BaseQuery {
    public function haveAccess() {
        return $this->andWhere(['userId' => Yii::$app->user->id]);
    }

    public function search($term) {
        if(!empty($term)) {
            return $this->andWhere("identifier LIKE :term OR uuid LIKE :term OR major LIKE :term OR minor LIKE :term", [
                ':term' => "%$term%"
            ]);
        }
        return $this;
    }
}

class Beacon extends ActiveRecord {

    public static function find() {
        return new BeaconQuery(get_called_class());
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

    public function beforeDelete() {
        parent::beforeDelete();

        $this->deletedAt = date('Y-m-d H:i:s');
        $this->save();

        return false;
    }

    public static function tableName() {
        return '{{%beacon}}';
    }

    public function rules() {
        return [
            [['identifier', 'uuid', 'major', 'minor'], 'required', 'on' => ['create', 'edit']],
            [['major', 'minor'], 'integer'],
            ['userId', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            ['minor', 'minorUnique', 'on' => ['create', 'edit']],
            ['identifier', 'identifierUnique', 'on' => ['create', 'edit']],
        ];
    }

    public function identifierUnique($attr) {
        if($beacon = Beacon::findOne([
            'identifier' => $this->$attr,
            'userId' => Yii::$app->user->id
        ])) {

            if($this->id && $this->id == $beacon->id) {
                return true;
            }

            $this->addError($attr, 'Identifier must be unique');
        }
    }

    public static function importEstimote($appId, $appToken) {

        $curl = curl_init('https://cloud.estimote.com/v1/beacons');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept: application/json'
        ]);
        curl_setopt($curl, CURLOPT_USERPWD, $appId . ':' . $appToken);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $counter = 0;

        if($data = curl_exec($curl)) {
            $data = json_decode($data, true);

            foreach($data as $device) {

                $id = 'est_' . $device['id'];

                if(Beacon::findOne(['identifier' => $id, 'userId' => Yii::$app->user->id])) {
                    continue;
                }

                if(Beacon::findOne([
                    'uuid' => $device['uuid'],
                    'major' => $device['major'],
                    'minor' => $device['minor'],
                    'userId' => Yii::$app->user->id,
                ])) {
                    continue;
                }

                $b = new Beacon();
                $b->setScenario('create');
                $b->setAttributes([
                    'identifier' => $id,
                    'uuid' => $device['uuid'],
                    'major' => $device['major'],
                    'minor' => $device['minor'],
                    'userId' => Yii::$app->user->id,
                ]);
                $b->save();

                $counter++;
            }
        }

        return $counter;
    }

    public static function importKontakt($apiKey) {
        $curl = curl_init('https://api.kontakt.io/device?orderBy=updated&maxResult=500&order=DESC');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Api-Key: ' . $apiKey,
            'Accept: application/vnd.com.kontakt+json; version=6',
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $counter = 0;

        if($data = curl_exec($curl)) {
            $data = json_decode($data, true);

            foreach($data['devices'] as $device) {
                if(Beacon::findOne(['identifier' => $device['uniqueId'], 'userId' => Yii::$app->user->id])) {
                    continue;
                }

                if(Beacon::findOne([
                    'uuid' => $device['proximity'],
                    'major' => $device['major'],
                    'minor' => $device['minor'],
                    'userId' => Yii::$app->user->id,
                ])) {
                    continue;
                }

                $b = new Beacon();
                $b->setScenario('create');
                $b->setAttributes([
                    'identifier' => $device['uniqueId'],
                    'uuid' => $device['proximity'],
                    'major' => $device['major'],
                    'minor' => $device['minor'],
                    'userId' => Yii::$app->user->id,
                ]);
                $b->save();

                $counter++;
            }
        }

        return $counter;
    }

    public function minorUnique($attr) {
        if($beacon = Beacon::findOne([
            'uuid' => $this->uuid,
            'major' => $this->major,
            'minor' => $this->$attr,
            'userId' => Yii::$app->user->id
        ])) {

            if($this->id && $this->id == $beacon->id) {
                return true;
            }

            $this->addError($attr, 'Minor must be unique');
        }
    }

    public function fields() {
        return [
            'id',
            'identifier',
            'userId',
            'uuid',
            'major',
            'minor',
            'createdAt',
            'updatedAt'
        ];
    }

    public function attributeLabels() {
        return [
            'uuid' => 'Proximity UUID'
        ];
    }
}