<?php

use yii\db\Schema;
use yii\db\Migration;
use app\models\User;

class m150828_090615_kontakt extends Migration
{
    public function up()
    {
        $this->addColumn(User::tableName(), 'kontaktKey', 'VARCHAR (512) NULL');
    }

    public function down()
    {
        $this->dropColumn(User::tableName(), 'kontaktKey');
    }
}
