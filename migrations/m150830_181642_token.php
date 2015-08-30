<?php

use yii\db\Migration;
use app\models\Token;

class m150830_181642_token extends Migration
{
    public function up()
    {
        $this->createTable(Token::tableName(), [
            'id' => 'pk',
            'value' => 'VARCHAR (256) NOT NULL',
            'createdAt' => 'DATETIME NOT NULL',
            'updatedAt' => 'DATETIME NOT NULL',
            'userId' => 'INT (11) NOT NULL',
        ], Yii::$app->params['tableOptions']);
    }

    public function down()
    {
        $this->dropTable(Token::tableName());
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
