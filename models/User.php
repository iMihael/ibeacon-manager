<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;

class UserQuery extends ActiveQuery {

    public function withDeleted() {
        return $this->where = [];
    }

}

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName() {
        return '{{%user}}';
    }

    public $rememberMe;
    public $password;

    public function rules() {
        return [
            [['email', 'password'], 'required', 'on' => 'login'],
            ['password', 'passwordValidator', 'on' => 'login'],
            ['rememberMe', 'safe', 'on' => 'login'],
        ];
    }

    public function passwordValidator($attr) {
        if($user = self::findOne(['email' => $this->email])) {
            if(Yii::$app->security->validatePassword($this->$attr, $user->passwordHash)) {
                $this->setAttributes($user->getAttributes(), false);
                return true;
            }
        }

        $this->addError($attr, 'Wrong password');
    }

    public static function find() {
        $query = new UserQuery(get_called_class());
        return $query->where(['deletedAt' => null]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->passwordHash);
    }
}
