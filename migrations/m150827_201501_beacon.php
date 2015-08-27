<?php

use yii\db\Schema;
use yii\db\Migration;
use app\models\User;
use app\models\Beacon;

class m150827_201501_beacon extends Migration
{
    public function up()
    {
        $this->createTable(Beacon::tableName(), [
            'id' => 'pk',
            'identifier' => 'VARCHAR (128) NOT NULL',
            'userId' => 'INT (11) NOT NULL',
            'uuid' => 'VARCHAR (512) NOT NULL',
            'major' => 'INT (11) NOT NULL',
            'minor' => 'INT (11) NOT NULL',
            'createdAt' => 'DATETIME NOT NULL',
            'updatedAt' => 'DATETIME NOT NULL',
            'deletedAt' => 'DATETIME NULL',
        ], Yii::$app->params['tableOptions']);

        $this->addForeignKey('fk_ibea_user', Beacon::tableName(), 'userId', User::tableName(), 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable(Beacon::tableName());
    }


}
