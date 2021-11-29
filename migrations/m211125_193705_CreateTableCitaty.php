<?php

use yii\db\Migration;

/**
 * Class m211125_193705_CreateTableCitaty
 */
class m211125_193705_CreateTableCitaty extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            'citaty',
            [
                'id'     => $this->primaryKey(),
                'text'   => $this->text(),
                'info'   => $this->text(),
                'theme'  => $this->string(),
                'viewed' => $this->boolean()->defaultValue(false),
            ]
        );
    }

    public function safeDown()
    {
        $this->dropTable('citaty');
    }
}