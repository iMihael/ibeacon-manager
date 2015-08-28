<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;
use yii\db\Expression;

class UserQuery extends BaseQuery {

}

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
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
        return '{{%user}}';
    }

    public $rememberMe;
    public $password;

    public function rules() {
        return [
            ['email', 'email'],
            [['email', 'password'], 'required', 'on' => ['login', 'register']],
            ['password', 'passwordValidator', 'on' => 'login'],
            ['rememberMe', 'safe', 'on' => 'login'],
            [['firstName', 'lastName'], 'required', 'on' => ['register', 'profile']],
            ['email', 'required', 'on' => 'profile'],
            ['email', 'registerValidator', 'on' => ['register', 'profile']],
            [['password', 'kontaktKey'], 'safe', 'on' => 'profile'],
            ['kontaktKey', 'required', 'on' => 'kontakt-import'],
        ];
    }

    public function attributeLabels() {
        return [
            'kontaktKey' => 'Kontakt.io API key',
        ];
    }

    public function registerValidator($attr) {
        if($user = self::findOne(['email' => $this->$attr])) {

            if($user->id != $this->id) {
                $this->addError($attr, 'Email is invalid.');
                return false;
            }
        }

        if(!empty($this->password)) {
            $this->passwordHash = Yii::$app->security->generatePasswordHash($this->password);
        }

        return true;
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
        return new UserQuery(get_called_class());
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
