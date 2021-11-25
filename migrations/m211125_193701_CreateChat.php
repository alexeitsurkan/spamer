<?php

use yii\db\Migration;

/**
 * Class m211125_193701_CreateChat
 * @package app\migrations
 */
class m211125_193701_CreateChat extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            'chat',
            [
                'id'    => $this->primaryKey(),
                'sid'   => $this->bigInteger()->notNull()->comment('id в платформе'),
                'title' => $this->string()->comment('заголовок чата'),
                'type'  => $this->smallInteger()->notNull()->comment('тип(приватный/публичный...)'),
            ]
        );

    }

    public function safeDown()
    {
        $this->dropTable('chat');
    }
}