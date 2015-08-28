<?php

use yii\db\Migration;
use app\models\User;

class m150828_183100_estimote extends Migration
{
    public function up()
    {
        $this->addColumn(User::tableName(), 'estimoteAppId', 'VARCHAR (128) NULL');
        $this->addColumn(User::tableName(), 'estimoteAppToken', 'VARCHAR (512) NULL');
    }

    public function down()
    {
        $this->dropColumn(User::tableName(), 'estimoteAppId');
        $this->dropColumn(User::tableName(), 'estimoteAppToken');
    }

}
