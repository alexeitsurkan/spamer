<?php

use yii\db\Migration;

/**
 * Class m211125_193704_CreateTablePlohiePesni
 */
class m211125_193704_CreateTablePlohiePesni extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            'plohie_pesni',
            [
                'id'     => $this->primaryKey(),
                'text'   => $this->text(),
                'viewed' => $this->boolean()->defaultValue(false),
            ]
        );
    }

    public function safeDown()
    {
        $this->dropTable('plohie_pesni');
    }
}