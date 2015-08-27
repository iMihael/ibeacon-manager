<?php

use yii\db\Migration;
use app\models\User;

class m150827_175610_user extends Migration
{
    public function up()
    {
        $this->createTable(User::tableName(), [
            'id' => 'pk',
            'email' => 'VARCHAR (128) NOT NULL',
            'firstName' => 'VARCHAR (128) NOT NULL',
            'lastName' => 'VARCHAR (128) NOT NULL',
            'passwordHash' => 'VARCHAR (128) NOT NULL',
            'authKey' => 'VARCHAR (128) NULL',
            'createdAt' => 'DATETIME NOT NULL',
            'updatedAt' => 'DATETIME NOT NULL',
            'deletedAt' => 'DATETIME NULL',
        ], Yii::$app->params['tableOptions']);

        $this->insert(User::tableName(), [
            'email' => 'admin@admin.com',
            'firstName' => 'Michael',
            'lastName' => 'Jackson',
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s'),
            'passwordHash' => Yii::$app->security->generatePasswordHash('123456'),
        ]);
    }

    public function down()
    {
        $this->dropTable(User::tableName());
    }

}
