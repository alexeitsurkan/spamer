<?php

use yii\db\Migration;

/**
 * Class m211125_193702_CreateMessage
 * @package app\migrations
 */
class m211125_193703_CreateTableAnecdote extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            'anecdote',
            [
                'id'     => $this->primaryKey(),
                'text'   => $this->text(),
                'viewed' => $this->boolean()->defaultValue(false),
            ]
        );
    }

    public function safeDown()
    {
        $this->dropTable('anecdote');
    }
}